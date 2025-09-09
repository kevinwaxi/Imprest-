<script setup lang="ts">
import type { Row } from '@tanstack/vue-table'

import type { Account } from './data/schema'
import { useForm } from '@inertiajs/vue3'
import { MoreHorizontalIcon } from 'lucide-vue-next'

import { computed, ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuShortcut, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { useDialogDelete } from '@/composables/useDialogDelete'

import { accountSchema } from './data/schema'

const props = defineProps<DataTableRowActionsProps>()

const { openModal: openDeleteDialog } = useDialogDelete()
interface DataTableRowActionsProps {
  row: Row<Account>
}

const parsedUser = computed(() => accountSchema.parse(props.row.original))

const isViewUserDialogOpen = ref(false)
const isEditDialogOpen = ref(false)
const isBanDialogOpen = ref(false)

// const isBanned = computed(() => parsedUser.value.banned_at !== null)
// const isVerified = computed(() => parsedUser.value.email_verified_at !== null)

const form = useForm({
  id: parsedUser.value.id,
})

function openViewUserDialog() {
  isViewUserDialogOpen.value = true
}

function openEditDialog() {
  isEditDialogOpen.value = true
}

function closeEditDialog() {
  isEditDialogOpen.value = false
  form.reset()
}

function openBanUserDialog() {
  isBanDialogOpen.value = true
}

function deleteAccount() {
  openDeleteDialog({
    title: 'Delete Role',
    route: `/dashboard/user_management/users/delete/${form.id}`,
    method: 'delete',
    message: `Are you sure you want to delete staff ${form.name}?`,
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
      <DropdownMenuItem @click="openViewUserDialog">
        View
      </DropdownMenuItem>
      <DropdownMenuItem @click="openEditDialog()">
        Edit
      </DropdownMenuItem>
      <DropdownMenuItem>
        Imprest Warrants
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="bg-destructive text-destructive-foreground" @click="deleteAccount">
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
      </DialogHeader>
      Edit Staff Dialog
    </DialogContent>
  </Dialog>

  <!-- ban dialog -->
  <!-- <Dialog v-model:open="isBanDialogOpen">
    <DialogContent class="md:min-w-2xl border border-warning">
      <DialogHeader>
        <DialogTitle>
          Ban User Account
        </DialogTitle>
        <DialogDescription>
          Banning <kbd> {{ form.full_name }}</kbd>
        </DialogDescription>
      </DialogHeader>
      <div class="mt-2 border p-2 rounded-md border-dashed hover:border-accent hover:bg-accent/20">
        Banning user can be done for a specific period of time. Enter a <kbd>comment</kbd> and <kbd> select a
          date </kbd> to ban user
        If no date is selected, user will be banned for <kbd>360 days.</kbd>
      </div>
      <div class="mt-2 grid gap-3">
        <Label>
          Comment
        </Label>
        <Textarea v-model="banForm.comment" />
        <InputError v-motion-slide-bottom :message="banForm.errors.comment" />
      </div>
      <div class="mt-2 grid gap-3">
        <Label>
          Ban till
        </Label>
        <Popover>
          <PopoverTrigger as-child>
            <Button
              variant="outline"
              :class="cn(
                'w-[280px] justify-start text-left font-normal',
                !banDate && 'text-muted-foreground',
              )"
            >
              <CalendarIcon class="mr-2 h-4 w-4" />
              {{ banDate ? df.format(banDate.toDate(getLocalTimeZone())) : "Pick a date" }}
            </Button>
          </PopoverTrigger>
          <PopoverContent class="w-auto p-0">
            <Calendar
              v-model="banDate"
              :min-value="minDate"
              calendar-label="Ban till"
            />
          </PopoverContent>
        </Popover>
      </div>
      <DialogFooter class="mt-4 w-full">
        <Button
          variant="outline"
          :disabled="banForm.processing"
          @click="closeBanUserDialog"
        >
          Cancel
        </Button>
        <Button
          :disabled="banForm.processing"
          class="bg-warning/40 hover:bg-warning/50 border border-warning/55 text-white"
          type="submit"
          @click.prevent="submitBanUserForm"
        >
          <Loader2 v-if="banForm.processing" class="h-4 w-4 animate-spin" />
          {{ banForm.processing ? 'Banning' : 'Ban' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog> -->

  <!-- View Dialog -->
  <Dialog v-model:open="isViewUserDialogOpen">
    <DialogContent class="flex flex-col gap-0 overflow-y-visible p-0 sm:max-w-lg [&>button:last-child]:top-3.5">
      <DialogHeader class="contents space-y-0 text-left">
        <DialogTitle class="border-b px-6 py-4 text-base">
          View Profile
        </DialogTitle>
      </DialogHeader>
      <DialogDescription class="sr-only">
        View {{ parsedUser.name }}
      </DialogDescription>
      view staff
    </DialogContent>
  </Dialog>
</template>
