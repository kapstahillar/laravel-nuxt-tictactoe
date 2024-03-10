<script lang="ts" setup>

const { register } = useAuth();
const router = useRouter();
const config = useRuntimeConfig();

const error = ref<string>("");

interface Credentials {
    username: string;
    password: string;
}

const credentials: Credentials = reactive({
    username: "",
    password: "",
});

async function submit() {
    try {
        error.value = "";

        await register(credentials.username, credentials.password);
        router.push(config.public.homeUrl);
    } catch (err) {
        error.value = err as string;
    }
}
</script>

<template>
  <div>
    Page: register
  </div>
  <form @submit.prevent="submit">
    <small>{{ error }}</small>

    <input
        id="username"
        v-model="credentials.username"
        type="text"
        name="username"
        placeholder="Your username"
        autocomplete="off"
    />
    <input
        id="password"
        v-model="credentials.password"
        type="password"
        name="password"
        placeholder="Your password"
        autocomplete="off"
    />

    <button type="submit">Login</button>
</form>

</template>

<style scoped></style>
