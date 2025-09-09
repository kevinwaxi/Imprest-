import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

type PageProps = {
  csrf_token: string
  [key: string]: unknown
}

export function useCSRFToken() {
  const page = usePage<PageProps>()

  const csrfToken = computed(() => page.props.csrf_token)

  return { csrfToken }
}
