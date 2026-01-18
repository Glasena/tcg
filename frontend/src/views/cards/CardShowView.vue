<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { API_URL } from '@/config/api'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import Button from 'primevue/button'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'

interface CardSet {
  id: number
  tcg_set_type_id: number
  set_name: string
  code: string
  rarity_code: string | null
}

interface CardDetail {
  id: number
  name: string
  tcg_custom_id: string
  tcg_type_id: number
  image_url: string | null
  card_sets: CardSet[]
}

const route = useRoute()
const router = useRouter()
const tcgTypesStore = useTcgTypesStore()

const card = ref<CardDetail | null>(null)
const loading = ref(true)

const fetchCard = async () => {
  try {
    const response = await fetch(`${API_URL}/cards/${route.params.id}`)
    const data = await response.json()
    card.value = data.data || data
  } catch (error) {
    console.error('Error fetching card:', error)
  } finally {
    loading.value = false
  }
}

const getCardImage = () => {
  if (card.value?.image_url) {
    return `http://localhost:8000${card.value.image_url}`
  }
  return '/yugioh_back.jpeg'
}

const getTypeName = (typeId: number) => {
  const type = tcgTypesStore.types.find((t) => t.id === typeId)
  return type?.description || typeId
}

onMounted(() => {
  tcgTypesStore.fetchTypes()
  fetchCard()
})
</script>

<template>
  <div class="p-8">
    <Button
      label="Back"
      icon="pi pi-arrow-left"
      @click="router.back()"
      severity="secondary"
      class="mb-6"
    />

    <div v-if="loading" class="text-center py-8">
      <i class="pi pi-spin pi-spinner text-4xl"></i>
      <p class="mt-4">Loading card...</p>
    </div>

    <div
      v-else-if="card"
      class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-8 max-w-full items-start"
    >
      <!-- Imagem à esquerda - 1/3 da largura -->
      <div class="bg-gray-900 p-8 rounded-lg flex items-center justify-center sticky top-8 w-full">
        <img :src="getCardImage()" :alt="card.name" class="max-h-96 max-w-full object-contain" />
      </div>

      <!-- Informações à direita - 2/3 da largura -->
      <div class="flex flex-col gap-6">
        <!-- Info básica -->
        <div>
          <p class="text-lg font-semibold text-yellow-600 mb-2">
            {{ getTypeName(card.tcg_type_id) }}
          </p>
          <h1 class="text-3xl font-bold">{{ card.name }}</h1>
        </div>

        <!-- Tabela de Sets -->
        <div class="flex flex-col flex-1">
          <h2 class="text-xl font-bold mb-3">Sets</h2>

          <DataTable
            v-if="card.card_sets && card.card_sets.length > 0"
            :value="card.card_sets"
            :paginator="card.card_sets.length > 15"
            :rows="15"
            scrollable
            scrollHeight="600px"
          >
            <Column field="set_name" header="Set Name" style="min-width: 250px" />
            <Column field="code" header="Code" style="min-width: 120px" />
            <Column field="rarity_code" header="Rarity" style="min-width: 100px" />
          </DataTable>

          <p v-else class="text-gray-400">No sets available for this card</p>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-8">
      <p class="text-red-500">Card not found</p>
    </div>
  </div>
</template>
