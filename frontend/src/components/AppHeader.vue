<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Menubar from 'primevue/menubar'
import Button from 'primevue/button'

const router = useRouter()
const authStore = useAuthStore()

const items = ref([
  {
    label: 'Home',
    icon: 'pi pi-home',
    command: () => router.push('/'),
  },
  {
    label: 'Cards',
    icon: 'pi pi-id-card',
    items: [
      {
        label: 'List Cards',
        icon: 'pi pi-list',
        command: () => router.push('/cards'),
      },
      {
        label: 'Create Card',
        icon: 'pi pi-plus',
        command: () => router.push('/cards/create'),
      },
    ],
  },
])

const handleLogout = () => {
  authStore.logout()
  router.push('/login')
}
</script>

<template>
  <div class="card">
    <Menubar :model="items">
      <template #start>
        <img
          src="@/assets/logo.png"
          alt="Logo"
          class="h-10 w-auto cursor-pointer"
          @click="router.push('/')"
        />
      </template>

      <template #end>
        <div class="flex items-center gap-2">
          <template v-if="authStore.isAuthenticated">
            <span class="text-sm">{{ authStore.user?.name }}</span>
            <Button
              label="Logout"
              icon="pi pi-sign-out"
              severity="secondary"
              size="small"
              @click="handleLogout"
            />
          </template>
          <template v-else>
            <Button
              label="Login"
              icon="pi pi-sign-in"
              severity="secondary"
              size="small"
              @click="router.push('/login')"
            />
            <Button
              label="Register"
              icon="pi pi-user-plus"
              size="small"
              @click="router.push('/register')"
            />
          </template>
        </div>
      </template>
    </Menubar>
  </div>
</template>
