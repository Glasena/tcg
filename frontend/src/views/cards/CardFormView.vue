<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Button from 'primevue/button'

const router = useRouter()
const route = useRoute()
const tcgTypesStore = useTcgTypesStore()

const cardId = route.params.id // null se for create, id se for edit
const isEditing = ref(!!cardId)

const form = ref({
  name: '',
  tcg_custom_id: '',
  tcg_type_id: 1,
})

const loading = ref(false)

const fetchCard = async () => {
  if (!cardId) return

  loading.value = true
  try {
    const response = await fetch(`http://localhost:8000/api/cards/${cardId}`)
    const data = await response.json()
    form.value = data.data
  } catch (error) {
    console.error('Error fetching card:', error)
  } finally {
    loading.value = false
  }
}

const submitForm = async () => {
  loading.value = true

  try {
    const url = isEditing.value
      ? `http://localhost:8000/api/cards/${cardId}`
      : 'http://localhost:8000/api/cards'

    const method = isEditing.value ? 'PATCH' : 'POST'

    const response = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form.value),
    })

    if (response.ok) {
      router.push('/cards')
    }
  } catch (error) {
    console.error('Error saving card:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  tcgTypesStore.fetchTypes()
  fetchCard()
})
</script>

<template>
  <div class="p-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">
      {{ isEditing ? 'Edit Card' : 'Create Card' }}
    </h1>

    <form @submit.prevent="submitForm" class="flex flex-col gap-4">
      <div class="flex flex-col gap-2">
        <label for="name">Name</label>
        <InputText id="name" v-model="form.name" placeholder="Card name" required />
      </div>

      <div class="flex flex-col gap-2">
        <label for="tcg_custom_id">Custom ID</label>
        <InputText id="tcg_custom_id" v-model="form.tcg_custom_id" placeholder="SDY-006" required />
      </div>

      <div class="flex flex-col gap-2">
        <label for="tcg_type_id">Type</label>
        <Select
          id="tcg_type_id"
          v-model="form.tcg_type_id"
          :options="tcgTypesStore.types"
          optionLabel="description"
          optionValue="id"
          placeholder="Select a type"
          :loading="tcgTypesStore.loading"
        />
      </div>

      <div class="flex gap-2 mt-4">
        <Button
          type="submit"
          :label="isEditing ? 'Update' : 'Create'"
          icon="pi pi-check"
          :loading="loading"
        />
        <Button
          type="button"
          label="Cancel"
          icon="pi pi-times"
          severity="secondary"
          @click="router.push('/cards')"
        />
      </div>
    </form>
  </div>
</template>
