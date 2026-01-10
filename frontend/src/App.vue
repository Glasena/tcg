<script setup lang="ts">
import { onMounted } from 'vue'
import AppHeader from './components/AppHeader.vue'

onMounted(() => {
  document.documentElement.classList.add('dark')
})
</script>

<template>
  <div>
    <AppHeader />
    <RouterView />
  </div>
</template>

<style>
* {
  font-family: 'Montserrat', sans-serif;
}
</style>
