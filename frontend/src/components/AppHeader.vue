<script setup lang="ts">
import { ref } from 'vue'
import Menubar from 'primevue/menubar'

const items = ref([
  {
    label: 'Home',
    icon: 'pi pi-home',
    route: '/',
  },
  {
    label: 'Cards',
    icon: 'pi pi-id-card',
    items: [
      {
        label: 'List Cards',
        icon: 'pi pi-list',
        route: '/cards',
      },
      {
        label: 'Create Card',
        icon: 'pi pi-plus',
        route: '/cards/create',
      },
    ],
  },
])
</script>

<template>
  <div class="card">
    <Menubar :model="items">
      <template #start>
        <img src="@/assets/logo.png" alt="Logo" class="h-10 w-auto" /> </template
    ></Menubar>
  </div>
</template>
