<?php
namespace App\Http\Services;

use App\Models\GameSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    function makeStep(int $user_id, int $index)
    {
        $gameSession = $this->getGame($user_id);
        $fields = $gameSession->fields;
        // Check if users turn
        // If users turn check if free
        // If free then make step
        // AI makes predicts a step
        // Ai choosese a step
        // Return result
    }

    function getGame(int $user_id): GameSession|null
    {
        return GameSession::where('user_id', $user_id)->where('completed_at', null)->first();
    }

    function getAll(int $user_id): Collection
    {
        return GameSession::where('user_id', $user_id)->orderBy('completed_at', 'desc')->get();
    }
}