import { useApi } from "./useApi";
import { useUser } from "./useUser";

export const useAuth = () => {
    const router = useRouter();
    const config = useRuntimeConfig();
    const { authentication } = useApi();
    const user = useUser();

    const isAuthenticated = computed(() => user.value !== null);

    async function fetchUser(): Promise<any> {
        user.value = await authentication.user();
    }

    async function login(
        email: string,
        password: string,
        remember = true
    ): Promise<any> {
        if (isAuthenticated.value === true) {
            return;
        }

        await authentication.login(email, password, remember);
        await fetchUser();

        await router.push(config.public.homeUrl as string);
    }

    async function register(
        name: string,
        password: string,
    ): Promise<any> {
        await authentication.register(
            name,
            password
        );
        await fetchUser();

        await router.push(config.public.homeUrl as string);
    }

    async function logout(): Promise<any> {
        if (isAuthenticated.value === false) {
            return;
        }

        await authentication.logout();
        user.value = null;

        await router.push(config.public.loginUrl as string);
    }

    return {
        user,
        isAuthenticated,
        login,
        register,
        logout,
    };
};
