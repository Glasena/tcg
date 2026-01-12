<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import AppHeader from './components/AppHeader.vue'
import ConfirmDialog from 'primevue/confirmdialog'

const router = useRouter()
const isNavigating = ref(false)

router.beforeEach(() => {
  isNavigating.value = true
})

router.afterEach(() => {
  setTimeout(() => {
    isNavigating.value = false
  }, 100)
})

onMounted(() => {
  document.documentElement.classList.add('dark')
})
</script>

<template>
  <div>
    <!-- Loading overlay -->
    <div
      v-if="isNavigating"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
      <ProgressSpinner
        style="width: 50px; height: 50px"
        strokeWidth="4"
        fill="transparent"
        animationDuration="1s"
      />
    </div>

    <ConfirmDialog />
    <AppHeader />
    <RouterView />
  </div>
</template>

<style>
* {
  font-family: 'Montserrat', sans-serif;
}
</style>
