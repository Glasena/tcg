<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import { useConfirm } from 'primevue/useconfirm'
import { API_URL } from '@/config/api'
import { useAuthStore } from '@/stores/auth'

import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'

const router = useRouter()
const tcgTypesStore = useTcgTypesStore()
const confirm = useConfirm()

const cards = ref([])
const loading = ref(true)

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
        })
        fetchCards()
      } catch (error) {
        console.error('Error deleting card:', error)
      }
    },
  })
}

const authStore = useAuthStore()

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

    <DataTable :value="cards" :loading="loading" paginator :rows="10" stripedRows>
      <Column field="name" header="Name" sortable></Column>
      <Column field="tcg_custom_id" header="ID" sortable></Column>
      <Column field="tcg_type_id" header="Type" sortable>
        <template #body="slotProps">
          {{ getTypeName(slotProps.data.tcg_type_id) }}
        </template>
      </Column>

      <Column header="Actions" v-if="authStore.isAuthenticated">
        <template #body="slotProps">
          <div class="flex gap-2">
            <Button
              icon="pi pi-pencil"
              severity="info"
              size="small"
              @click="router.push(`/cards/${slotProps.data.id}/edit`)"
            />
            <Button
              icon="pi pi-trash"
              severity="danger"
              size="small"
              @click="deleteCard(slotProps.data.id)"
            /></div></template></Column
    ></DataTable>
  </div>
</template>
