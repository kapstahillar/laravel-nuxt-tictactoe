
export default defineNuxtRouteMiddleware(() => {
    const config = useRuntimeConfig();
    return navigateTo(config.public.homeUrl, { replace: true });
});