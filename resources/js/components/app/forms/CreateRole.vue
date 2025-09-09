<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'
import { AwardIcon, CpuIcon, Loader2Icon, PlusIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue'

import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input, InputGroup } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { MultiSelect } from '@/components/ui/multi-select'
import { Switch } from '@/components/ui/switch'
import { Textarea } from '@/components/ui/textarea'
import { usePermissionStore } from '@/stores/usePermissionStore'

const isFormOpen = ref(false)
const permissionQuery = ref('')
const permissionStore = usePermissionStore()

const form = useForm({
  name: '',
  details: '',
  permissions: [],
  is_system: false,
  is_default: false,
})

function openForm() {
  isFormOpen.value = true
  permissionStore.fetchPermissions()
}

function closeForm() {
  isFormOpen.value = false
  form.resetAndClearErrors()
}

function submitForm() {
  form.submit('post', '/dashboard/user_management/roles', {
    onSuccess: () => {
      closeForm()
    },
  })
}

const allPermissions = computed(() => permissionStore.permissions)
</script>

<template>
  <Button size="sm" @click="openForm">
    <PlusIcon />
    Create Role
  </Button>
  <Dialog v-model:open="isFormOpen">
    <DialogContent class="sm:min-w-2xl">
      <DialogHeader>
        <DialogTitle>
          Create Role
        </DialogTitle>
      </DialogHeader>
      <div class="p-2 grid gap-3">
        <!-- name -->
        <div class="grid gap-2">
          <Label for="name">
            Role Name
          </Label>
          <InputGroup>
            <Input
              id="name"
              v-model="form.name"
              name="name"
              placeholder="Enter role name"
            />
          </InputGroup>
          <InputError :message="form.errors.name" />
        </div>
        <!-- details -->
        <div class="grid gap-2">
          <Label for="description">
            Description
          </Label>
          <Textarea
            v-model="form.details"
            row="2"
            placeholder="Enter role details"
          />
          <InputError :message="form.errors.details" />
        </div>
        <!-- permissions -->
        <div class="grid gap-2">
          <Label for="permissions">
            Select Permissions
          </Label>
          <MultiSelect
            v-model="form.permissions"
            :options="allPermissions"
            :query="permissionQuery"
            placeholder="Select permissions"
          />
          <InputError :message="form.errors.permissions" />
        </div>

        <!-- system -->
        <div
          class="border-input has-data-[state=checked]:border-primary/50 relative flex w-full items-start gap-2 rounded-md border p-4 shadow-xs outline-none"
        >
          <Switch
            id="system"
            v-model="form.is_system"
            class="order-1 h-4 w-6 after:absolute after:inset-0 [&_span]:size-3 data-[state=checked]:[&_span]:translate-x-2 data-[state=checked]:[&_span]:rtl:-translate-x-2"
            aria-describedby="description"
          />
          <div class="flex grow items-center gap-3">
            <CpuIcon />
            <div class="grid grow gap-2">
              <Label for="system">
                System Role
                <span
                  class="text-muted-foreground text-xs leading-[inherit] font-normal"
                >
                  (will {{ form.is_system ? '' : 'not' }} be system role)
                </span>
              </Label>
              <p id="description" class="text-muted-foreground text-xs">
                Means will {{ form.is_system ? '' : 'not' }} be deleted
              </p>
            </div>
          </div>
        </div>
        <!-- default -->
        <div
          class="border-input has-data-[state=checked]:border-primary/50 relative flex w-full items-start gap-2 rounded-md border p-4 shadow-xs outline-none"
        >
          <Switch
            id="default"
            v-model="form.is_default"
            class="order-1 h-4 w-6 after:absolute after:inset-0 [&_span]:size-3 data-[state=checked]:[&_span]:translate-x-2 data-[state=checked]:[&_span]:rtl:-translate-x-2"
            aria-describedby="description"
          />
          <div class="flex grow items-center gap-3">
            <AwardIcon />
            <div class="grid grow gap-2">
              <Label for="default">
                Default Role
                <span
                  class="text-muted-foreground text-xs leading-[inherit] font-normal"
                >
                  (will {{ form.is_default ? '' : 'not' }} be default role)
                </span>
              </Label>
              <p id="description" class="text-muted-foreground text-xs">
                People who self register will have this role
              </p>
            </div>
          </div>
        </div>
      </div>
      <DialogFooter>
        <Button
          :disabled="form.processing"
          variant="outline"
          @click="closeForm"
        >
          Cancel
        </Button>
        <Button :disabled="form.processing" @click="submitForm">
          <Loader2Icon v-if="form.processing" class="size-4 animate-spin" />
          {{ form.processing ? 'creating ...' : 'Create' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
