<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'
import Card from 'primevue/card'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const loading = ref(false)
const error = ref('')

const register = async () => {
  error.value = ''
  loading.value = true

  try {
    await authStore.register(form.value)
    router.push('/cards')
  } catch (err) {
    if (err instanceof Response) {
      const data = await err.json()
      error.value = data.message || 'Registration failed'
    } else {
      error.value = 'Registration failed'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="flex items-center justify-center min-h-screen">
    <Card class="w-full max-w-md">
      <template #content>
        <form @submit.prevent="register" class="flex flex-col gap-4">
          <div v-if="error" class="p-3 bg-red-500 text-white rounded">
            {{ error }}
          </div>

          <div class="flex flex-col gap-2">
            <label for="name">Name</label>
            <InputText id="name" v-model="form.name" required />
          </div>

          <div class="flex flex-col gap-2">
            <label for="email">Email</label>
            <InputText id="email" v-model="form.email" type="email" required />
          </div>

          <div class="flex flex-col gap-2">
            <label for="password">Password</label>
            <Password id="password" v-model="form.password" :feedback="false" toggleMask required />
          </div>

          <div class="flex flex-col gap-2">
            <label for="password_confirmation">Confirm Password</label>
            <Password
              id="password_confirmation"
              v-model="form.password_confirmation"
              :feedback="false"
              toggleMask
              required
            />
          </div>

          <Button type="submit" label="Register" :loading="loading" />

          <Button
            type="button"
            label="Already have an account? Login"
            severity="secondary"
            text
            @click="router.push('/login')"
          />
        </form>
      </template>
    </Card>
  </div>
</template>
