import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

type DeleteModalProps = {
  title?: string
  message?: string
  route?: string
  method?: 'delete' | 'put' // Defaults to 'delete'
  description?: string
  onSuccess?: () => void
}

const isDialogOpen = ref(false)

const modalProps = ref<DeleteModalProps>({
  title: 'Confirm Deletion',
  method: 'delete',
  description: 'Are you sure?',
  onSuccess: () => {},
})

export function useDialogDelete() {
  function openModal(props: DeleteModalProps) {
    modalProps.value = { ...modalProps.value, ...props }
    isDialogOpen.value = true
  }

  function closeModal() {
    isDialogOpen.value = false
  }

  function handleConfirm() {
    if (modalProps.value.route) {
      router.visit(modalProps.value.route, {
        method: modalProps.value.method,
        preserveScroll: true,
        onSuccess: () => {
          modalProps.value.onSuccess?.()
          closeModal()
        },
      })
    }
    else {
      modalProps.value.onSuccess?.()
      closeModal()
    }
  }

  return {
    isDialogOpen,
    modalProps,
    openModal,
    closeModal,
    handleConfirm,
  }
}
