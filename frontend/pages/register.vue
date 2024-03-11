<script lang="ts" setup>
import RegisterForm from '~/components/register/RegisterForm.vue';

definePageMeta({
    middleware: ["guest"],
});


</script>

<template>
    <ElMain>
        <ElCard style="max-width: 480px;">
            <RegisterForm />
        </ElCard>
    </ElMain>

</template>

<style scoped></style>
