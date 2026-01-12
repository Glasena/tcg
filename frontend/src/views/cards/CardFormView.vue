<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTcgTypesStore } from '@/stores/tcgTypes'
import { useAuthStore } from '@/stores/auth'
import { API_URL } from '@/config/api'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Button from 'primevue/button'
import FileUpload from 'primevue/fileupload'

const router = useRouter()
const route = useRoute()
const tcgTypesStore = useTcgTypesStore()
const authStore = useAuthStore()

const cardId = route.params.id
const isEditing = ref(!!cardId)

const form = ref({
  name: '',
  tcg_custom_id: '',
  tcg_type_id: 1,
  image_url: null as string | null,
})

const selectedFile = ref<File | null>(null)
const previewUrl = ref<string | null>(null)

const loading = ref(false)

const cardImage = computed(() => {
  if (previewUrl.value) {
    return previewUrl.value
  }
  if (form.value.image_url) {
    return `http://localhost:8000${form.value.image_url}`
  }
  return '/yugioh_back.jpeg'
})

const getAuthHeaders = () => ({
  Authorization: `Bearer ${authStore.token}`,
})

const onFileSelect = (event: { files: File[] }) => {
  const file = event.files[0]
  if (file) {
    selectedFile.value = file
    previewUrl.value = URL.createObjectURL(file)
  }
}

const fetchCard = async () => {
  if (!cardId) return

  loading.value = true
  try {
    const response = await fetch(`${API_URL}/cards/${cardId}`, {
      headers: { ...getAuthHeaders(), 'Content-Type': 'application/json' },
    })
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
    const url = isEditing.value ? `${API_URL}/cards/${cardId}` : `${API_URL}/cards`
    const method = isEditing.value ? 'POST' : 'POST' // Laravel precisa de POST com _method

    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('tcg_custom_id', form.value.tcg_custom_id)
    formData.append('tcg_type_id', String(form.value.tcg_type_id))

    if (isEditing.value) {
      formData.append('_method', 'PATCH')
    }

    if (selectedFile.value) {
      formData.append('image', selectedFile.value)
    }

    const response = await fetch(url, {
      method,
      headers: getAuthHeaders(),
      body: formData,
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
  <div class="p-8">
    <h1 class="text-3xl font-bold mb-6">
      {{ isEditing ? 'Edit Card' : 'Create Card' }}
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl">
      <!-- Imagem à esquerda -->
      <div class="bg-gray-900 p-8 rounded-lg flex items-center justify-center">
        <img
          :src="cardImage"
          :alt="form.name || 'Card preview'"
          class="max-h-96 max-w-full object-contain"
        />
      </div>

      <!-- Form à direita -->
      <form @submit.prevent="submitForm" class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
          <label for="name">Name</label>
          <InputText id="name" v-model="form.name" placeholder="Card name" required />
        </div>

        <div class="flex flex-col gap-2">
          <label for="tcg_custom_id">Custom ID</label>
          <InputText
            id="tcg_custom_id"
            v-model="form.tcg_custom_id"
            placeholder="SDY-006"
            required
          />
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

        <div class="flex flex-col gap-2">
          <label>Card Image</label>
          <FileUpload
            mode="basic"
            accept="image/*"
            :maxFileSize="2000000"
            :auto="true"
            chooseLabel="Choose Image"
            @select="onFileSelect"
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
  </div>
</template>
