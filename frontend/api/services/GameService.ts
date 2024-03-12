import type GameSession from "../models/Gamesession";
import { ApiServiceBase } from "./ApiServiceBase";

export default class GameService extends ApiServiceBase {

    async startGame(): Promise<GameSession> {
        return await this.call("/api/v1/gamesession", { method: "post" });
    }

    async makeStep(index: Number): Promise<GameSession> {
        return await this.call("/api/v1/gamesession", { method: "put", body: { index: index }, });
    }

    async getCurrentGame(): Promise<GameSession> {
        const response = await this.call("/api/v1/gamesession", { method: "get" });
        return response
    }

    async getAllGames(): Promise<GameSession[]> {
        return await this.call("/api/v1/gamesession/all", { method: "get" });
    }

    async quitCurrentGame(): Promise<GameSession> {
        return await this.call("/api/v1/gamesession", { method: "delete" });
    }
}
