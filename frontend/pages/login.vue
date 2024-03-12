<template>
    <ElMain>
        <ElCard class="loginpage__container-card">
            <LoginForm />
        </ElCard>
    </ElMain>
</template>
<script lang="ts" setup>
definePageMeta({
    middleware: ["guest"],
});
</script>
<style scoped>
.loginpage__container-card {
    max-width: 480px;
    margin: auto;
}
</style>