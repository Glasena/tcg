<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import { useConfirm } from 'primevue/useconfirm'
import { API_URL } from '@/config/api'
import { useAuthStore } from '@/stores/auth'

import Button from 'primevue/button'
import Card from 'primevue/card'
import Paginator from 'primevue/paginator'
import Select from 'primevue/select'
import AutoComplete from 'primevue/autocomplete'
import InputText from 'primevue/inputtext'

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

interface PaginationMeta {
  current_page: number
  last_page: number
  per_page: number
  total: number
}

interface TcgSetType {
  id: number
  name: string
  code: string
}

interface AutoCompleteCompleteEvent {
  query: string
}

interface Filters {
  tcg_type_id: number | null
  tcg_set_type_id: TcgSetType | null
  name: string | Card
  code: string
}

// Filtros
const filters = ref<Filters>({
  tcg_type_id: null,
  tcg_set_type_id: null,
  name: '',
  code: '',
})

const sets = ref<TcgSetType[]>([])
const filteredSets = ref<TcgSetType[]>([])
const cardSuggestions = ref<Card[]>([])

const cards = ref<Card[]>([])
const loading = ref(true)
const pagination = ref<PaginationMeta>({
  current_page: 1,
  last_page: 1,
  per_page: 12,
  total: 0,
})

const getAuthHeaders = () => ({
  'Content-Type': 'application/json',
  Authorization: `Bearer ${authStore.token}`,
})

// Buscar Sets
const fetchSets = async () => {
  try {
    const response = await fetch(`${API_URL}/tcg-set-types`)
    const data = await response.json()
    sets.value = data.data || data
  } catch (error) {
    console.error('Error fetching sets:', error)
  }
}

// Autocomplete de Sets
const searchSets = async (event: AutoCompleteCompleteEvent) => {
  if (!event.query.trim().length) {
    filteredSets.value = [...sets.value]
    return
  }

  try {
    const response = await fetch(`${API_URL}/tcg-set-types?name=${event.query}`)
    const data = await response.json()
    filteredSets.value = data.data
  } catch (error) {
    console.error('Error searching sets:', error)
  }
}

// Autocomplete de Cards (busca na API)
const searchCards = async (event: AutoCompleteCompleteEvent) => {
  if (!event.query.trim().length) {
    cardSuggestions.value = []
    return
  }

  try {
    const response = await fetch(`${API_URL}/cards?name=${event.query}&per_page=10`)
    const data = await response.json()
    cardSuggestions.value = data.data
  } catch (error) {
    console.error('Error searching cards:', error)
  }
}

const fetchCards = async (page = 1) => {
  loading.value = true
  try {
    const params = new URLSearchParams({ page: page.toString() })

    if (filters.value.tcg_type_id) {
      params.append('tcg_type_id', filters.value.tcg_type_id.toString())
    }
    if (filters.value.tcg_set_type_id) {
      params.append('tcg_set_type_id', filters.value.tcg_set_type_id.id.toString())
    }
    if (filters.value.name) {
      const nameValue =
        typeof filters.value.name === 'string' ? filters.value.name : filters.value.name.name
      params.append('name', nameValue)
    }
    if (filters.value.code) {
      params.append('code', filters.value.code)
    }

    const response = await fetch(`${API_URL}/cards?${params}`)
    const data = await response.json()
    cards.value = data.data
    pagination.value = {
      current_page: data.meta.current_page,
      last_page: data.meta.last_page,
      per_page: data.meta.per_page,
      total: data.meta.total,
    }
  } catch (error) {
    console.error('Error fetching cards:', error)
  } finally {
    loading.value = false
  }
}

const onPageChange = (event: { page: number }) => {
  fetchCards(event.page + 1)
  window.scrollTo({ top: 0, behavior: 'smooth' })
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
        fetchCards(pagination.value.current_page)
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

const clearFilters = () => {
  filters.value = {
    tcg_type_id: null,
    tcg_set_type_id: null,
    name: '',
    code: '',
  }
  fetchCards()
}

onMounted(() => {
  tcgTypesStore.fetchTypes()
  fetchSets()
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
    <!-- FILTROS -->
    <div class="bg-gray-800 p-4 rounded-lg mb-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <!-- Card Name - 4 colunas -->
        <div class="md:col-span-4">
          <label class="block text-sm mb-2">Card Name</label>
          <AutoComplete
            v-model="filters.name"
            :suggestions="cardSuggestions"
            @complete="searchCards"
            optionLabel="name"
            placeholder="Search card..."
            class="w-full"
            :pt="{ input: { class: 'w-full' } }"
          />
        </div>

        <!-- Set - 4 colunas -->
        <div class="md:col-span-4">
          <label class="block text-sm mb-2">Set</label>
          <AutoComplete
            v-model="filters.tcg_set_type_id"
            :suggestions="filteredSets"
            @complete="searchSets"
            optionLabel="name"
            placeholder="Search set..."
            class="w-full"
            :pt="{ input: { class: 'w-full' } }"
          />
        </div>

        <!-- Code - 2 colunas -->
        <div class="md:col-span-2">
          <label class="block text-sm mb-2">Code</label>
          <InputText v-model="filters.code" placeholder="LOB-005" class="w-full" />
        </div>

        <!-- TCG Type - 2 colunas -->
        <div class="md:col-span-2">
          <label class="block text-sm mb-2">TCG Type</label>
          <Select
            v-model="filters.tcg_type_id"
            :options="tcgTypesStore.types"
            optionLabel="description"
            optionValue="id"
            placeholder="Select TCG"
            class="w-full"
          />
        </div>
      </div>
      <div class="flex gap-2 justify-end">
        <Button label="Search" icon="pi pi-search" @click="fetchCards(1)" />
        <Button label="Clear" icon="pi pi-times" severity="secondary" @click="clearFilters" />
      </div>
    </div>

    <div v-if="loading" class="text-center py-8">Loading cards...</div>

    <div v-else>
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
          <template #footer>
            <div class="flex gap-2 justify-center">
              <Button
                v-if="authStore.isAuthenticated"
                icon="pi pi-pencil"
                severity="info"
                size="small"
                text
                @click="router.push(`/cards/${card.id}/edit`)"
              />
              <Button
                v-if="authStore.isAuthenticated"
                icon="pi pi-trash"
                severity="danger"
                size="small"
                text
                @click="deleteCard(card.id)"
              />
              <Button
                icon="pi pi-eye"
                severity="info"
                size="small"
                text
                @click="() => router.push(`/cards/${card.id}`)"
              />
            </div>
          </template>
        </Card>
      </div>

      <Paginator
        v-if="pagination.total > pagination.per_page"
        :rows="pagination.per_page"
        :totalRecords="pagination.total"
        :first="(pagination.current_page - 1) * pagination.per_page"
        @page="onPageChange"
        class="mt-6"
      />
    </div>
  </div>
</template>
<style scoped>
:deep(.p-autocomplete),
:deep(.p-select),
:deep(.p-inputtext) {
  width: 100% !important;
}
</style>
