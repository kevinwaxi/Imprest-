import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useStaffStore = defineStore('staff', () => {
  const all = ref<{ id?: number, name: string, label: string, description: string }[]>([])
  const staff = ref<{ label: string, value: string }[]>([])
  const loading = ref(false)
  const apiUrl = '/api/staff'

  const fetchAll = async () => {
    if (all.value.length)
      return

    loading.value = true
    try {
      const res = await axios.get(apiUrl)
      all.value = res.data
    }
    catch (err) {
      console.error('Failed to load staff', err)
    }
    finally {
      loading.value = false
    }
  }

  const fetchStaff = async () => {
    if (staff.value.length)
      return

    loading.value = true
    try {
      const res = await axios.get(apiUrl)
      const seen = new Set<string>()

      staff.value = res.data
        .map((item: any) => ({
          label: item.name.split('-').map((word: string) => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
          value: item.id,
        }))
        .filter((option: { value: string }) => {
          if (seen.has(option.value))
            return false
          seen.add(option.value)
          return true
        })
    }
    catch (err) {
      console.error('Failed to load staff', err)
    }
    finally {
      loading.value = false
    }
  }

  return {
    all,
    staff,
    loading,
    fetchAll,
    fetchStaff,
  }
})
