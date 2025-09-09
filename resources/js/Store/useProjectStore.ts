import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProjectStore = defineStore('project', () => {
  const all = ref<{ id?: number, name: string, label: string, description: string }[]>([])
  const projects = ref<{ label: string, value: string }[]>([])
  const loading = ref(false)
  const apiUrl = '/api/projects'

  const fetchAll = async () => {
    if (all.value.length)
      return

    loading.value = true
    try {
      const res = await axios.get(apiUrl)
      all.value = res.data
    }
    catch (err) {
      console.error('Failed to load projects', err)
    }
    finally {
      loading.value = false
    }
  }

  const fetchProjects = async () => {
    if (projects.value.length)
      return

    loading.value = true
    try {
      const res = await axios.get(apiUrl)
      const seen = new Set<string>()

      projects.value = res.data
        .map((item: any) => ({
          label: item.name.split('-').map((word: string) => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
          value: item.id,
          description: item.code,
        }))
        .filter((option: { value: string }) => {
          if (seen.has(option.value))
            return false
          seen.add(option.value)
          return true
        })
    }
    catch (err) {
      console.error('Failed to load projects', err)
    }
    finally {
      loading.value = false
    }
  }

  return {
    all,
    projects,
    loading,
    fetchAll,
    fetchProjects,
  }
})
