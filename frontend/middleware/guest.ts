import { useAuthStore } from "~/store/auth.store";

export default defineNuxtRouteMiddleware(() => {
    const { isAuthenticated } = useAuthStore();
    const config = useRuntimeConfig();
    if (isAuthenticated) {
        return navigateTo(config.public.homeUrl, { replace: true });
    }
});