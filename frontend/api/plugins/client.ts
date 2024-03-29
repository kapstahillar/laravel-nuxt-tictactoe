import { type FetchOptions, FetchError } from 'ofetch';
import { appendHeader } from "h3";
import { splitCookiesString } from "set-cookie-parser";
import ApiError from '../models/ApiError';
import { useUser } from '../composables/useUser';
import type { ApiServiceContainer } from '../services/ApiServiceContainer';
import AuthService from '../services/AuthService';
import type User from '../models/User';
import GameService from '../services/GameService';

const SECURE_METHODS = new Set(['post', 'delete', 'put', 'patch']);
const UNAUTHENTICATED_STATUSES = new Set([401, 419]);
const VALIDATION_ERROR_STATUS = 422;
const FORBIDDEN_ERROR_STATUS = 403;

export default defineNuxtPlugin((nuxtApp) => {
    const event = useRequestEvent();
    const config = useRuntimeConfig();
    const user = useUser();
    const apiConfig = config.public.api;

    async function initUser(getter: () => Promise<User | null>) {
        try {
            user.value = await getter();
        } catch (err) {
            if (
                err instanceof FetchError &&
                err.response &&
                UNAUTHENTICATED_STATUSES.has(err.response.status)
            ) {
                console.warn("[API initUser] User is not authenticated");
            }
        }
    }

    const httpOptions: FetchOptions = {
        baseURL: apiConfig.baseUrl,
        credentials: 'include',
        headers: {
            Accept: 'application/json',
            'content-type': 'application/json'
        },
        retry: false,

        async onRequest({ options }) {

            if (process.server) {
                options.headers = buildServerHeaders(options.headers);
            }

            if (process.client) {
                const method = options.method?.toLocaleLowerCase() ?? '';

                if (!SECURE_METHODS.has(method)) {
                    return;
                }

                options.headers = await buildClientHeaders(options.headers);
            }

        },


        onResponse({ response }) {
            if (process.server && event != undefined) {
                const rawCookiesHeader = response.headers.get(
                    apiConfig.serverCookieName
                );

                if (rawCookiesHeader === null) {
                    return;
                }

                const cookies = splitCookiesString(rawCookiesHeader);

                for (const cookie of cookies) {
                    appendHeader(event, apiConfig.serverCookieName, cookie);
                }
            }
        },

        async onResponseError({ response }) {
            if (
                apiConfig.redirectUnauthenticated &&
                UNAUTHENTICATED_STATUSES.has(response.status)
            ) {
                await navigateTo(config.public.loginUrl as string);
                return;
            }

            if (response.status === VALIDATION_ERROR_STATUS || response.status === FORBIDDEN_ERROR_STATUS) {
                throw new ApiError(response._data);
            }
        },

    };

    function buildServerHeaders(headers: HeadersInit | undefined): HeadersInit {
        const csrfToken = useCookie(apiConfig.csrfCookieName).value;
        const clientCookies = useRequestHeaders(['cookie']);

        return {
            ...headers,
            ...(clientCookies.cookie && clientCookies),
            ...(csrfToken && { [apiConfig.csrfHeaderName]: csrfToken }),
            Referer: config.public.baseUrl as string,
        };
    }


    async function buildClientHeaders(
        headers: HeadersInit | undefined
    ): Promise<HeadersInit> {
        await $fetch(apiConfig.cookieRequestUrl, {
            baseURL: apiConfig.baseUrl,
            credentials: 'include',
        });

        const csrfToken = useCookie(apiConfig.csrfCookieName).value;

        return {
            ...headers,
            ...(csrfToken && { [apiConfig.csrfHeaderName]: csrfToken }),
        };
    }

    const client: any = $fetch.create(httpOptions);

    const api: ApiServiceContainer = {
        gameService: new GameService(client),
        authentication: new AuthService(client),
    };


    if (process.server && user.value === null) {
        initUser(() => api.authentication.user());
    }

    return { provide: { api } };
});
