<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'
import Card from 'primevue/card'
import Message from 'primevue/message'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: '',
})

const loading = ref(false)
const error = ref('')

const login = async () => {
  error.value = ''
  loading.value = true

  try {
    await authStore.login(form.value)
    router.push('/cards')
  } catch (err) {
    if (err instanceof Response) {
      const data = await err.json()
      error.value = data.message || 'Login failed'
    } else {
      error.value = 'Login failed'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="flex items-center justify-center min-h-screen">
    <Card class="w-full max-w-md">
      <template #title>Login</template>
      <template #content>
        <form @submit.prevent="login" class="flex flex-col gap-4">
          <Message v-if="error" severity="error" :closable="false">
            {{ error }}
          </Message>

          <div class="flex flex-col gap-2">
            <label for="email">Email</label>
            <InputText id="email" v-model="form.email" type="email" required />
          </div>

          <div class="flex flex-col gap-2">
            <label for="password">Password</label>
            <Password id="password" v-model="form.password" :feedback="false" toggleMask required />
          </div>

          <Button type="submit" label="Login" :loading="loading" />

          <Button
            type="button"
            label="Don't have an account? Register"
            severity="secondary"
            text
            @click="router.push('/register')"
          />
        </form>
      </template>
    </Card>
  </div>
</template>
