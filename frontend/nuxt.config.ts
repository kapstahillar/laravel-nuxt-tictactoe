// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  extends: ["./api"],
  $development: {
    ssr: true,
    devtools: {
      enabled: true,
    },
  },
  app: {
    head: {
      title: 'Tic-tac-toe',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      ],
    },
  },
  modules: [
    '@element-plus/nuxt',
    '@pinia/nuxt',
    '@pinia-plugin-persistedstate/nuxt',
    'dayjs-nuxt',
  ],
  runtimeConfig: {
    public: {
      baseUrl: "http://localhost:3000",
      homeUrl: "/game",
      loginUrl: "/login",
      registerUrl: "/register",
    },
  },
})
