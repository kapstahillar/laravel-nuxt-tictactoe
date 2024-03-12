<template>
  <ElText class="mx-1" size="large">Login</ElText>
  <ElDivider />
  <ElForm ref="ruleFormRef" :model="form" label-width="auto" style="max-width: 600px" :rules="rules" status-icon>
    <ElFormItem label="Username" prop="username">
      <ElInput v-model="form.username" />
    </ElFormItem>
    <ElFormItem label="Password" prop="password">
      <ElInput type="password" v-model="form.password" show-password />
    </ElFormItem>
    <ElFormItem>
      <ElButton type="primary" @click="submitForm()">Login</ElButton>
      <ElButton type="info" @click="goToRegister()">Register</ElButton>
    </ElFormItem>
  </ElForm>
</template>
<script lang="ts" setup>
import { useAuthStore } from '~/store/auth.store';
import { type FormInstance, type FormRules } from 'element-plus';
import ApiError from '~/api/models/ApiError';

const { login } = useAuth();
const config = useRuntimeConfig();
const router = useRouter();

interface LoginForm {
  username: string;
  password: string;
}

const form: LoginForm = reactive({
  username: '',
  password: '',
})

const ruleFormRef = ref<FormInstance>()

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

const error = ref<string>("");
const auth = useAuthStore()
async function submitForm() {
  if (!ruleFormRef.value) return
  ruleFormRef.value.validate((valid) => {
    if (valid) {
      callLogin().then(() => { return true })
    } else {
      return false
    }
  })
}

async function callLogin() {
  try {
    error.value = "";
    await login(form.username, form.password, true);
    if (auth.isAuthenticated) {
      router.push(config.public.homeUrl);
      ElNotification({
        title: 'Login successful',
        message: error.value,
        type: 'success',
      })
    }
  } catch (err: unknown) {
    if (err instanceof ApiError) {
      error.value = err.message as string;
      ElNotification({
        title: 'Invalid login',
        message: error.value,
        type: 'error',
      })
    }
  }
}

function goToRegister() {
  router.push(config.public.registerUrl)
}
</script>
<style scoped></style>
