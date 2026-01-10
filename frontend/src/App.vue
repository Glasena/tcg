<script setup lang="ts">
import { onMounted } from 'vue'
import AppHeader from './components/AppHeader.vue'
import ConfirmDialog from 'primevue/confirmdialog'

onMounted(() => {
  document.documentElement.classList.add('dark')
})
</script>

<template>
  <div>
    <AppHeader />
    <RouterView />
    <ConfirmDialog />
  </div>
</template>

<style>
* {
  font-family: 'Montserrat', sans-serif;
}
</style>
