<template>
    <ElText class="mx-1" size="large"> Register</ElText>
    <ElDivider />
    <ElForm ref="ruleFormRef" :model="form" label-width="auto" style="max-width: 600px" :rules="rules" status-icon>
        <ElFormItem label="Username" prop="username">
            <ElInput v-model="form.username" />
        </ElFormItem>
        <ElFormItem label="Password" prop="password">
            <ElInput type="password" v-model="form.password" show-password />
        </ElFormItem>
        <ElFormItem>
            <ElButton type="primary" @click="submitForm()">Register</ElButton>
            <ElButton type="info" @click="goToLogin()">Login</ElButton>
        </ElFormItem>
    </ElForm>
</template>

<script lang="ts" setup>
import { ElButton, ElFormItem, type FormInstance, type FormRules } from 'element-plus';
import { reactive } from 'vue'
import ApiError from '~/api/models/ApiError';

interface RegisterForm {
    username: string;
    password: string;
}

const form: RegisterForm = reactive({
    username: '',
    password: '',
})

const ruleFormRef = ref<FormInstance>()

const { register } = useAuth();
const router = useRouter();
const config = useRuntimeConfig();
const error = ref<string>("");

const rules = reactive<FormRules<typeof form>>({
    username: [
        { required: true, message: 'Please input username', trigger: 'blur' },
        { min: 4, max: 255, message: 'Length should be 4 to 255', trigger: 'blur' },
    ],
    password: [
        { required: true, message: 'Please input password', trigger: 'blur' },
        { min: 8, message: 'Length should be from 8', trigger: 'blur' },
    ],
})

function submitForm() {
    if (ruleFormRef.value == null) return
    ruleFormRef.value.validate((valid) => {
        if (valid) {
            callRegister().then(() => { return true })
        } else {
            return false
        }
    })
}

async function callRegister() {
    try {
        error.value = "";
        await register(form.username, form.password);
        router.push(config.public.homeUrl);
        ElNotification({
            title: 'Register success',
            message: 'User ' + form.username + ' has been created!',
            type: 'success',
        })
    } catch (err: unknown) {
        if (err instanceof ApiError) {
            error.value = err.message as string;
            ElNotification({
                title: 'Invalid register',
                message: error.value,
                type: 'error',
            })
        }
    }
}

function goToLogin() {
    router.push(config.public.loginUrl)
}
</script>
