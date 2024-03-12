<template>
    <ElMain>
        <ElCard class="registerpage__container-card">
            <RegisterForm />
        </ElCard>
    </ElMain>
</template>
<script lang="ts" setup>
import RegisterForm from '~/components/register/RegisterForm.vue';
definePageMeta({
    middleware: ["guest"],
});
</script>
<style scoped>
.registerpage__container-card {
    max-width: 480px;
    margin: auto;
}
</style>
