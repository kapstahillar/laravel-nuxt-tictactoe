<?php
namespace App\Http\Services;

use App\Exceptions\InvalidStepException;
use App\Models\Enums\GameField;
use App\Models\GameSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameSessionService
{

    function createGame(int $user_id): GameSession|null
    {
        $gameSession = new GameSession(["user_id" => $user_id]);
        $gameSession->save();
        return GameSession::find($gameSession->id);
    }

    function quitGame(int $user_id)
    {
        DB::table('game_sessions')
            ->where('user_id', $user_id)
            ->where('completed_at', null)
            ->update([
                'winner' => 1,
                'completed_at' => Carbon::now(),
            ]);
    }

    function getGame(int $user_id): GameSession|null
    {
        return GameSession::where('user_id', $user_id)->where('completed_at', null)->first();
    }

    function getAll(int $user_id): Collection
    {
        return GameSession::where('user_id', $user_id)->orderBy('completed_at', 'desc')->get();
    }

    function makeStep(int $user_id, int $index): GameSession
    {
        $gameSession = $this->getGame($user_id);
        $state = $gameSession->getStateArray();

        if ($state[$index] != GameField::EMPTY_CELL->value) {
            throw new InvalidStepException;
        }
        $state[$index] = GameField::PLAYER->value;

        if ($this->checkEndCondition($state)) {
            $gameSession->completed_at = Carbon::now();
            $gameSession->winner = 0;
        } else {
            $stepIndex = $this->makeAIStep($state);
            $state[$stepIndex] = GameField::AI->value;
            if ($this->checkEndCondition($state)) {
                $gameSession->completed_at = Carbon::now();
                $gameSession->winner = 1;
            }
        }

        $gameSession->serializeState($state);
        $gameSession->save();
        return $gameSession;
    }


    private function makeAIStep(array $state): int
    {
        // $state = ["x", "o", "x", " ", "x", " ", "0", " ", " "];
        return $this->findBestMove($state);
    }

    private function findBestMove(array $state): int
    {
        $bestScore = PHP_INT_MIN;
        $bestIndex = PHP_INT_MIN;

        for ($i = 0; $i < count($state); $i++) {
            if ($state[$i] != GameField::EMPTY_CELL->value)
                continue;
            $state[$i] = GameField::AI->value;
            $moveScore = $this->minimax($state, 0, false);
            $state[$i] = GameField::EMPTY_CELL->value;

            if ($moveScore > $bestScore) {
                $bestScore = $moveScore;
                $bestIndex = $i;
            }
        }
        return $bestIndex;
    }

    private function minimax(array $state, int $depth, bool $isMaximizing): int
    {
        $score = $this->evaluate($state);
        if ($score == 10) {
            return $score - $depth;
        }
        if ($score == -10) {
            return $score + $depth;
        }
        if (!$this->checkAnyAvailableStepsLeft($state)) {
            return 0;
        }

        if ($isMaximizing) {
            $best = PHP_INT_MIN;
            for ($i = 0; $i < count($state); $i++) {
                if ($state[$i] != GameField::EMPTY_CELL->value)
                    continue;
                $state[$i] = GameField::AI->value;
                $best = max($best, $this->minimax($state, $depth + 1, !$isMaximizing));
                $state[$i] = GameField::EMPTY_CELL->value;
            }
            return $best - $depth;
        } else {
            $best = PHP_INT_MAX;
            for ($i = 0; $i < count($state); $i++) {
                if ($state[$i] != GameField::EMPTY_CELL->value)
                    continue;
                $state[$i] = GameField::PLAYER->value;
                $best = min($best, $this->minimax($state, $depth + 1, !$isMaximizing));
                $state[$i] = GameField::EMPTY_CELL->value;
            }
            return $best + $depth;
        }
    }

    private function checkEndCondition(array $state): bool
    {
        if (!$this->checkAnyAvailableStepsLeft($state)) {
            return true;
        }

        if ($this->checkWinningCondition($state)) {
            return true;
        }

        return false;
    }

    private function checkWinningCondition(array $state)
    {
        $board = array_chunk($state, 3);

        for ($i = 0; $i < 3; $i++) {
            if (($board[$i][0] != GameField::EMPTY_CELL->value) && ($board[$i][0] == $board[$i][1]) && ($board[$i][1] == $board[$i][2])) {
                return true; // Horizontal win
            }

            if (($board[0][$i] != GameField::EMPTY_CELL->value) && ($board[0][$i] == $board[1][$i]) && ($board[1][$i] == $board[2][$i])) {

                return true; // Vertical win
            }
        }

        if (($board[0][0] != GameField::EMPTY_CELL->value) && ($board[0][0] == $board[1][1]) && ($board[1][1] == $board[2][2])) {
            return true; // Diagonal from top-left to bottom-right
        }

        if (($board[0][2] != GameField::EMPTY_CELL->value) && ($board[0][2] == $board[1][1]) && ($board[1][1] == $board[2][0])) {
            return true; // Diagonal from top-right to bottom-left
        }

        return false;
    }


    private function evaluate(array $state)
    {
        $board = array_chunk($state, 3);
        for ($i = 0; $i < 3; $i++) {
            if (($board[$i][0] != GameField::EMPTY_CELL->value) && ($board[$i][0] == $board[$i][1]) && ($board[$i][1] == $board[$i][2])) {
                return($board[$i][0] == GameField::AI->value) ? 10 : -10;
            }

            if (($board[0][$i] != GameField::EMPTY_CELL->value) && ($board[0][$i] == $board[1][$i]) && ($board[1][$i] == $board[2][$i])) {
                return($board[0][$i] == GameField::AI->value) ? 10 : -10;
            }
        }

        if (($board[0][0] != GameField::EMPTY_CELL->value) && ($board[0][0] == $board[1][1]) && ($board[1][1] == $board[2][2])) {
            return($board[0][0] == GameField::AI->value) ? 10 : -10;
        }

        if (($board[0][2] != GameField::EMPTY_CELL->value) && ($board[0][2] == $board[1][1]) && ($board[1][1] == $board[2][0])) {
            return($board[0][2] == GameField::AI->value) ? 10 : -10;
        }

        return 0;
    }

    private function checkAnyAvailableStepsLeft(array $states)
    {
        foreach ($states as $state) {
            if ($state == GameField::EMPTY_CELL->value)
                return true;
        }
        return false;
    }



}