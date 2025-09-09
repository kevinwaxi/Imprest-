<script setup lang="ts">
import type { Row } from '@tanstack/vue-table'

import { useForm } from '@inertiajs/vue3'
import { Loader2, MoreHorizontalIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue'

import { Button } from '@/components/ui/button'
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuPortal, DropdownMenuSeparator, DropdownMenuShortcut, DropdownMenuSub, DropdownMenuSubContent, DropdownMenuSubTrigger, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { useDialogConfirm } from '@/composables/useDialogConfirm'
import { useDialogDelete } from '@/composables/useDialogDelete'
import { useHasPermissions } from '@/composables/useHasPermissions'

import type { User } from './data/schema'

import { userSchema } from './data/schema'

const props = defineProps<DataTableRowActionsProps>()

const { openModal: openDeleteDialog } = useDialogDelete()
const { openModal: openSuspendDialog } = useDialogConfirm()
const { openModal: openVerifyUserDialog } = useDialogConfirm()

const { hasPermission } = useHasPermissions()

type DataTableRowActionsProps = {
  row: Row<User>
}

const parsedUser = computed(() => userSchema.parse(props.row.original))

const isViewUserDialogOpen = ref(false)
const isEditDialogOpen = ref(false)
const isBanDialogOpen = ref(false)

const isBanned = computed(() => parsedUser.value.banned_at !== null)
const isVerified = computed(() => parsedUser.value.email_verified_at !== null)

const form = useForm({
  id: parsedUser.value.id,
  first_name: parsedUser.value.first_name,
  last_name: parsedUser.value.last_name,
  other_names: parsedUser.value.other_names,
  username: parsedUser.value.username,
  full_name: parsedUser.value.full_name,
  email: parsedUser.value.email,
  roles: parsedUser.value.roles,
  banned_at: parsedUser.value.banned_at,
})

// const localDate = today(getLocalTimeZone())
// const df = new DateFormatter('en-UK', {
//   dateStyle: 'long',
// })

// const minDate = localDate.add({ months: 12 })

// const banDate = ref<DateValue>(minDate)

// const banForm = useForm({
//   comment: '',
//   ban_till: banDate.value.toDate(getLocalTimeZone()),
//   id: parsedUser.value.id,
// })

// watch(banDate, (newVal) => {
//   banForm.ban_till = newVal.toDate(getLocalTimeZone())
// })

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

// function closeBanUserDialog() {
//   isBanDialogOpen.value = false
// //   banForm.reset()
// }

function submitEditForm() {
  form.put(route('dashboard.user_management.users.update', form.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeEditDialog()
    },
  })
}

// function submitBanUserForm() {
//   banForm.patch(route('dashboard.user_management.users.banUser', form.id), {
//     preserveScroll: true,
//     onSuccess: () => {
//       closeBanUserDialog()
//     },
//   })
// }

function suspendUser() {
  openSuspendDialog({
    title: 'Suspend User',
    route: `/dashboard/user_management/users/suspend/${form.id}`,
    method: 'patch',
    message: `Are you sure you want to suspend user ${form.full_name} - ${form.email}?`,
  })
}

function verifyUser() {
  openVerifyUserDialog({
    title: 'Verify User',
    route: `/dashboard/user_management/users/verify/${form.id}`,
    method: 'patch',
    message: `Are you sure you want to verify user ${form.full_name} - ${form.email} account ?`,
  })
}

function deleteAccount() {
  openDeleteDialog({
    title: 'Delete Role',
    route: `/dashboard/user_management/users/delete/${form.id}`,
    method: 'delete',
    message: `Are you sure you want to delete role ${form.full_name}?`,
  })
}

function unlockAccount() {
  openSuspendDialog({
    title: 'Unlock User',
    route: `/dashboard/user_management/users/unlock/${form.id}`,
    method: 'patch',
    message: `Are you sure you want to unlock user ${form.full_name} - ${form.email}?`,
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
      <DropdownMenuItem v-if="isBanned && hasPermission('user-edit')" @click="unlockAccount">
        Unlock Account
      </DropdownMenuItem>
      <DropdownMenuItem @click="openViewUserDialog">
        View
      </DropdownMenuItem>
      <DropdownMenuItem v-if="hasPermission('user-edit')" @click="openEditDialog()">
        Edit
      </DropdownMenuItem>
      <DropdownMenuItem v-if="!isBanned && hasPermission('user-edit')">
        Access Control
      </DropdownMenuItem>
      <DropdownMenuSub v-if="!isBanned">
        <DropdownMenuSubTrigger>
          <span>Account</span>
        </DropdownMenuSubTrigger>
        <DropdownMenuPortal>
          <DropdownMenuSubContent>
            <DropdownMenuItem v-if="!isVerified" @click="verifyUser">
              <span>Verify</span>
            </DropdownMenuItem>
            <DropdownMenuItem @click="suspendUser">
              <span>Suspend</span>
            </DropdownMenuItem>
            <DropdownMenuItem @click="openBanUserDialog">
              <span>Ban</span>
            </DropdownMenuItem>
            <DropdownMenuItem>
              <span>Reset Password</span>
            </DropdownMenuItem>
          </DropdownMenuSubContent>
        </DropdownMenuPortal>
      </DropdownMenuSub>
      <DropdownMenuSub>
        <DropdownMenuSubTrigger>
          <span>Security</span>
        </DropdownMenuSubTrigger>
        <DropdownMenuPortal>
          <DropdownMenuSubContent>
            <DropdownMenuItem>
              <span>Login Attempts</span>
            </DropdownMenuItem>
            <DropdownMenuItem>
              <span>Activity Logs</span>
            </DropdownMenuItem>
          </DropdownMenuSubContent>
        </DropdownMenuPortal>
      </DropdownMenuSub>
      <DropdownMenuSeparator v-if="isBanned" />
      <DropdownMenuItem
        v-if="isBanned"
        class="bg-destructive text-destructive-foreground"
        @click="deleteAccount"
      >
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
          Editing {{ form.full_name }}
        </DialogDescription>
      </DialogHeader>
      <div class="grid grid-cols-3 gap-3">
        <TextInput
          id="first_name"
          v-model="form.first_name"
          name="first_name"
          type="text"
          label="First Name"
          required
          :errors="form.errors.first_name"
        />
        <TextInput
          id="last_name"
          v-model="form.last_name"
          name="last_name"
          type="text"
          label="Last Name"
          required
          :errors="form.errors.last_name"
        />
        <TextInput
          id="other_names"
          v-model="form.other_names"
          name="other_names"
          type="text"
          label="Other Names"
        />
      </div>
      <div class="grid grid-cols-2 gap-3">
        <TextInput
          id="username"
          v-model="form.username"
          name="username"
          type="text"
          label="Username"
          required
          :errors="form.errors.username"
        />
        <TextInput
          id="email"
          v-model="form.email"
          name="email"
          type="email"
          label="Email"
          required
          :errors="form.errors.email"
        />
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
          {{ form.processing ? 'Submitting' : 'Submit' }}
        </Button>
      </DialogFooter>
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
        View {{ parsedUser.full_name }}
      </DialogDescription>
      <div class="overflow-y-auto">
        <div class="-mt-10 px-6" />

        <div class="px-6 pt-4 pb-6">
          <form class="space-y-4">
            <div class="flex flex-col gap-4 sm:flex-row">
              <div>
                {{ parsedUser.full_name }}
              </div>
            </div>
            <div class="*:not-first:mt-2">
              {{ parsedUser.username }}
            </div>
            <div class="*:not-first:mt-2">
              {{ parsedUser.email }}
            </div>
            <div class="*:not-first:mt-2">
              <div
                v-for="role in parsedUser.roles"
                :key="role.id"
                class="flex items-center gap-2"
              >
                <div class="text-sm font-medium text-gray-900">
                  {{ role.name }}
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <DialogFooter class="border-t px-6 py-4">
        <DialogClose as-child>
          <Button type="button" variant="outline">
            Cancel
          </Button>
        </DialogClose>
        <DialogClose as-child>
          <Button type="button">
            Save changes
          </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
