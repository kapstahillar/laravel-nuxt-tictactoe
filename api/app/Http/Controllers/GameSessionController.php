<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameSessionStepRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\GameSessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GameSessionController extends Controller
{
    public function __construct(private GameSessionService $gameSessionService)
    {
    }

    public function getCurrentGame(): JsonResponse
    {
        $user = Auth::user();
        $gameSession = $this->gameSessionService->getGame($user->id);
        return response()->json($gameSession, 200);
    }

    public function startNewGame(): JsonResponse
    {
        $user = Auth::user();
        $gameSession = $this->gameSessionService->createGame($user->id);
        return response()->json($gameSession, 200);
    }

    public function quitGame()
    {
        $user = Auth::user();
        $this->gameSessionService->quitGame($user->id);
        return response()->json("{ success: true", 200);
    }

    public function makeStep(GameSessionStepRequest $request): JsonResponse
    {
        $user = Auth::user();
        return response()->json($this->gameSessionService->makeStep($user->id, $request->index), 200);
    }

    public function getAll(): JsonResponse
    {
        $user = Auth::user();
        return response()->json($this->gameSessionService->getAll($user->id), 200);
    }
}
