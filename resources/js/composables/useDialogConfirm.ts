import type { VNode } from 'vue'

import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

interface ConfirmModalProps {
  title?: string
  message?: string | VNode
  route?: string
  method?: 'post' | 'put' | 'patch' // Defaults to 'delete'
  actionText?: string
  cancelText?: string
  onSuccess?: () => void
}

const isDialogOpen = ref(false)

const modalProps = ref<ConfirmModalProps>({
  title: 'Confirm Change',
  actionText: 'Confirm',
  cancelText: 'Cancel',
  message: 'This action cannot be undone.',
  method: 'put',
  onSuccess: () => { },
})

export function useDialogConfirm() {
  function openModal(props: ConfirmModalProps) {
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
