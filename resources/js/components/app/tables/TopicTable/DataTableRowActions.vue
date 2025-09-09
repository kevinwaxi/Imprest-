<script setup lang="ts">
import type { Row } from '@tanstack/vue-table'

import { useForm } from '@inertiajs/vue3'
import { Loader2, MoreHorizontalIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue'

import { TipTapEditor } from '@/components/core/TextEditor/TipTap'
import { TextInput } from '@/components/core/TextInput'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuShortcut, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Label } from '@/components/ui/label'
import { useDeleteDialog } from '@/composables/useDeleteDialog'
import { useHasPermissions } from '@/composables/useHasPermissions'

import type { Topic } from './data/schema'

import { topicSchema } from './data/schema'

const props = defineProps<DataTableRowActionsProps>()

const { openModal: openDeleteDialog } = useDeleteDialog()

const { hasPermission } = useHasPermissions()

type DataTableRowActionsProps = {
  row: Row<Topic>
}

const parseTopic = computed(() => topicSchema.parse(props.row.original))

const isEditDialogOpen = ref(false)
const isViewDialogOpen = ref(false)

const form = useForm({
  id: parseTopic.value.id,
  name: parseTopic.value.name,
  description: parseTopic.value.description,
})

function openEditDialog() {
  isEditDialogOpen.value = true
}

function openViewDialog() {
  isViewDialogOpen.value = true
}

function closeEditDialog() {
  isEditDialogOpen.value = false
  form.reset()
}

function closeViewDialog() {
  isViewDialogOpen.value = false
}

function submitEditForm() {
  form.put(route('dashboard.blog.topics.update', form.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeEditDialog()
    },
  })
}

function deleteTopic() {
  openDeleteDialog({
    title: 'Delete Role',
    route: `/dashboard/blog/topics/delete/${form.id}`,
    method: 'delete',
    message: `Are you sure you want to delete role ${form.name}?`,
  })
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="flex h-8 w-8 p-0 data-[state=open]:bg-muted">
        <MoreHorizontalIcon class="h-4 w-4" />
        <span class="sr-only">Open menu</span>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end" class="w-[160px]">
      <DropdownMenuItem @click="openViewDialog">
        View
      </DropdownMenuItem>
      <DropdownMenuItem @click="openEditDialog">
        Edit
      </DropdownMenuItem>
      <DropdownMenuItem v-if="hasPermission('topic-edit')" @click="openEditDialog()">
        Edit
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="bg-danger text-destructive" @click="deleteTopic">
        Delete
        <DropdownMenuShortcut>⌘⌫</DropdownMenuShortcut>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <!-- edit form sheet -->
  <Dialog v-model:open="isEditDialogOpen">
    <DialogContent class="md:min-w-3xl">
      <DialogHeader>
        <DialogTitle>
          Edit User Account
        </DialogTitle>
        <DialogDescription>
          Editing {{ form.name }}
        </DialogDescription>
      </DialogHeader>
      <div class="mt-3">
        <TextInput
          id="name"
          v-model="form.name"
          name="name"
          type="text"
          label="Name"
          required
          :errors="form.errors.name"
        />
      </div>
      <div class="grid gap-3">
        <Label>
          Topic Description
        </Label>
        <TipTapEditor v-model="form.description" />
        <InputError v-motion-slide-bottom :message="form.errors.description" />
      </div>
      <DialogFooter class="mt-4 w-full">
        <Button
          variant="outline"
          :disabled="form.processing"
          @click="closeEditDialog"
        >
          Cancel
        </Button>
        <Button
          :disabled="form.processing"
          type="submit"
          @click.prevent="submitEditForm"
        >
          <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
          {{ form.processing ? 'updating...' : 'Update' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>

  <!-- view Dialog  -->
  <Dialog v-model:open="isViewDialogOpen">
    <DialogContent class="sm:max-w-3xl">
      <DialogHeader class="mb-1">
        <DialogTitle>
          {{ parseTopic.name }}
        </DialogTitle>
        <DialogDescription>
          View topic details
        </DialogDescription>
        <div class="mt-2">
          <div class="grid gap-2 mt-3">
            <div class="border p-2 rounded-md border-dashed hover:border-accent hover:bg-accent/20" v-html="parseTopic.description" />
            <div class="text-sm font-thin text-muted-foreground">
              {{ parseTopic.created_at }}
            </div>
          </div>
        </div>
      </DialogHeader>
    </DialogContent>
  </Dialog>
</template>
