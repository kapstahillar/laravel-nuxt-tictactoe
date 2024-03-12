import type AuthService from "./AuthService";
import type GameService from "./GameService";


export interface ApiServiceContainer {
    gameService: GameService;
    authentication: AuthService;
}