import type User from "../models/User";
import { ApiServiceBase } from "./ApiServiceBase";

export default class AuthService extends ApiServiceBase {

    async login(
        username: string,
        password: string,
        remember = true
    ): Promise<any> {
        return await this.call("/auth/login", {
            method: "post",
            body: { username, password, remember },
        });
    }

    async logout(): Promise<any> {
        return await this.call("/auth/logout", { method: "post" });
    }

    async register(
        name: string,
        password: string,
    ): Promise<any> {
        return await this.call("/auth/register", {
            method: "post",
            body: { name, password },
        });
    }

    async user(): Promise<User> {
        return await this.call("/api/user");
    }
}