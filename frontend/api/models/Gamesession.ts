export enum GameFieldValue {
    PLAYER = "x",
    AI = "o",
    NONE = "-",
}

export default interface GameSession {
    id: number
    user_id: number // Current user playing
    state: string // State in string values
    created_at: Date
    winner: number | null
    completed_at: Date
}