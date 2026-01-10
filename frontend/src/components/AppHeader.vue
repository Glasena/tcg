<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Menubar from 'primevue/menubar'

const router = useRouter()

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
    </Menubar>
  </div>
</template>
