<script setup lang="ts">
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog'
import { useDialogConfirm } from '@/composables/useDialogConfirm'

const { isDialogOpen, modalProps, closeModal, handleConfirm } = useDialogConfirm()
</script>

<template>
  <AlertDialog v-model:open="isDialogOpen">
    <AlertDialogContent class="bg-background/80 border-t-primary/60">
      <AlertDialogHeader>
        <AlertDialogTitle>{{ modalProps.title }}</AlertDialogTitle>
        <AlertDialogDescription>
          {{ modalProps.message }}
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click.prevent="closeModal">
          Cancel
        </AlertDialogCancel>
        <AlertDialogAction @click.prevent="handleConfirm">
          {{ modalProps.actionText }}
        </AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
