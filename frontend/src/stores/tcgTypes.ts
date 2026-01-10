import { ref } from 'vue'
import { defineStore } from 'pinia'

interface TcgType {
  id: number
  description: string
  created_at: string
  updated_at: string
}

export const useTcgTypesStore = defineStore('tcgTypes', () => {
  const types = ref<TcgType[]>([])
  const loading = ref(false)

  const fetchTypes = async () => {
    if (types.value.length > 0) return

    loading.value = true
    try {
      const response = await fetch('http://localhost:8000/api/tcg-types')
      const data = await response.json()
      types.value = data.data
    } catch (error) {
      console.error('Error fetching TCG types:', error)
    } finally {
      loading.value = false
    }
  }

  return { types, loading, fetchTypes }
})
