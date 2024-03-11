import { useAuthStore } from "~/store/auth.store";
import { useApi } from "./useApi";

export const useAuth = () => {
    const { authentication } = useApi();
    const auth = useAuthStore()

    async function login(
        username: string,
        password: string,
        remember = true
    ): Promise<any> {
        await authentication.login(username, password, remember);
        let user = await authentication.user();
        await auth.setUser(user)
    }

    async function register(
        username: string,
        password: string,
    ): Promise<any> {
        await authentication.register(
            username,
            password
        );
        let user = await authentication.user();
        await auth.setUser(user);
    }

    async function logout(): Promise<any> {
        await authentication.logout();
        await auth.unsetUser();
    }

    return {
        login,
        register,
        logout,
    };
};
