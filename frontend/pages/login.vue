<script lang="ts" setup>
import { useAuthStore } from '~/store/auth.store';
definePageMeta({
    middleware: ["guest"],
});

interface Credentials {
    username: string;
    password: string;
}

const { login } = useAuth();
const config = useRuntimeConfig();
const router = useRouter();

const credentials: Credentials = reactive({
    username: "",
    password: "",
});

const error = ref<string>("");
const auth = useAuthStore()
async function submit() {
    try {
        error.value = "";
        await login(credentials.username, credentials.password, true);
        if (auth.isAuthenticated)
            router.push(config.public.homeUrl);
    } catch (err) {
        error.value = err as string;
    }
}
</script>

<template>
    <div>
        <p>Page: login</p>

        <form @submit.prevent="submit">
            <small>{{ error }}</small>

            <input id="username" v-model="credentials.username" type="text" name="username" placeholder="Your username"
                autocomplete="off" />
            <input id="password" v-model="credentials.password" type="password" name="password"
                placeholder="Your password" autocomplete="off" />

            <button type="submit">Login</button>
        </form>

        <NuxtLink to="/register" class="text-blue-500">
            Register
        </NuxtLink>
    </div>
</template>