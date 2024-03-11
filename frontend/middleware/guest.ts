import { useAuth } from "../composables/useAuth";

export default defineNuxtRouteMiddleware(() => {
    const { isAuthenticated } = useAuth();
    const config = useRuntimeConfig();

    if (isAuthenticated.value === true) {
        return navigateTo(config.public.homeUrl as string, { replace: true });
    }
});