<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import { useConfirm } from 'primevue/useconfirm'
import { API_URL } from '@/config/api'
import { useAuthStore } from '@/stores/auth'

import Button from 'primevue/button'
import Card from 'primevue/card'

const router = useRouter()
const tcgTypesStore = useTcgTypesStore()
const confirm = useConfirm()
const authStore = useAuthStore()

interface Card {
  id: number
  name: string
  tcg_custom_id: string
  tcg_type_id: number
  image_url: string | null
}

const cards = ref<Card[]>([])
const loading = ref(true)

const getAuthHeaders = () => ({
  'Content-Type': 'application/json',
  Authorization: `Bearer ${authStore.token}`,
})

const fetchCards = async () => {
  loading.value = true
  try {
    const response = await fetch(`${API_URL}/cards`)
    const data = await response.json()
    cards.value = data.data
  } catch (error) {
    console.error('Error fetching cards:', error)
  } finally {
    loading.value = false
  }
}

const getTypeName = (typeId: number) => {
  const type = tcgTypesStore.types.find((t) => t.id === typeId)
  return type?.description || typeId
}

const deleteCard = async (id: number) => {
  confirm.require({
    message: 'Are you sure you want to delete this card?',
    header: 'Delete Confirmation',
    icon: 'pi pi-exclamation-triangle',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger',
    accept: async () => {
      try {
        await fetch(`${API_URL}/cards/${id}`, {
          method: 'DELETE',
          headers: getAuthHeaders(),
        })
        fetchCards()
      } catch (error) {
        console.error('Error deleting card:', error)
      }
    },
  })
}

const getCardImage = (card: Card) => {
  if (card.image_url) {
    return `http://localhost:8000${card.image_url}`
  }
  return '/yugioh_back.jpeg'
}

onMounted(() => {
  tcgTypesStore.fetchTypes()
  fetchCards()
})
</script>

<template>
  <div class="p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Cards</h1>
      <Button
        label="New Card"
        icon="pi pi-plus"
        @click="router.push('/cards/create')"
        v-if="authStore.isAuthenticated"
      />
    </div>

    <div v-if="loading" class="text-center py-8">Loading cards...</div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
      <Card v-for="card in cards" :key="card.id" class="overflow-hidden">
        <template #header>
          <div class="bg-gray-900 p-4 flex items-center justify-center h-80">
            <img
              :src="getCardImage(card)"
              :alt="card.name"
              class="max-h-full max-w-full object-contain"
            />
          </div>
        </template>
        <template #content>
          <div class="text-center space-y-1">
            <h3 class="font-semibold text-sm truncate">{{ card.name }}</h3>
            <p class="text-xs text-gray-400">ID: {{ card.tcg_custom_id }}</p>
            <p class="text-xs text-yellow-600">{{ getTypeName(card.tcg_type_id) }}</p>
          </div>
        </template>
        <template #footer v-if="authStore.isAuthenticated">
          <div class="flex gap-2 justify-center">
            <Button
              icon="pi pi-pencil"
              severity="info"
              size="small"
              text
              @click="router.push(`/cards/${card.id}/edit`)"
            />
            <Button
              icon="pi pi-trash"
              severity="danger"
              size="small"
              text
              @click="deleteCard(card.id)"
            />
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>
