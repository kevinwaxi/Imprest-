<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { useDialogDelete } from '@/composables/useDialogDelete'

const { isDialogOpen, modalProps, closeModal, handleConfirm } = useDialogDelete()
</script>

<template>
  <Dialog v-model:open="isDialogOpen">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>
          <h3 class="text-lg font-semibold">
            {{ modalProps.title }}
          </h3>
        </DialogTitle>
        <DialogDescription> {{ modalProps.description }} </DialogDescription>
      </DialogHeader>
      <p v-if="modalProps.message" class="text-sm text-muted-foreground">
        {{ modalProps.message }}
      </p>
      <DialogFooter>
        <Button variant="outline" @click="closeModal">
          Cancel
        </Button>
        <Button variant="destructive" @click="handleConfirm">
          Delete
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
