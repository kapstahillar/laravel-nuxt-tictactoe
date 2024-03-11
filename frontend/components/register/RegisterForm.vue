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
            <ElButton type="primary" @click="submitForm(ruleFormRef)">Register</ElButton>
        </ElFormItem>
    </ElForm>
</template>

<script lang="ts" setup>
import { ElButton, ElFormItem, type FormInstance, type FormRules } from 'element-plus';
import { reactive } from 'vue'

const form = reactive({
    username: '',
    password: '',
})

const ruleFormRef = ref<FormInstance>()

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

function submitForm(formEl: FormInstance | undefined) {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            callRegister().then(function () {
                return true
            })
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
    } catch (err) {
        error.value = err as string;
    }
}
</script>
