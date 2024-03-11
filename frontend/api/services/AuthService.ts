import type User from "../models/User";
import { ApiServiceBase } from "./ApiServiceBase";

export default class AuthService extends ApiServiceBase {

    async login(
        username: string,
        password: string,
        remember = true
    ): Promise<any> {
        return await this.call("/login", {
            method: "post",
            body: { username, password, remember },
        });
    }

    async logout(): Promise<any> {
        return await this.call("/logout", { method: "post" });
    }

    async register(
        username: string,
        password: string,
    ): Promise<any> {
        return await this.call("/register", {
            method: "post",
            body: { username, password },
        });
    }

    async user(): Promise<User> {
        return await this.call("/api/v1/user");
    }
}