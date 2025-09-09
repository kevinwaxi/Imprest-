<script lang="ts" setup>
import { Form } from '@inertiajs/vue3'
import { LoaderCircle } from 'lucide-vue-next'
import { ref } from 'vue'
import StaffController from '@/actions/App/Http/Controllers/ImprestWarrant/StaffController'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

const isCreateStaffOpen = ref(false)

function openCreateStaffForm() {
  isCreateStaffOpen.value = true
}

function closeCreateStaffForm() {
  isCreateStaffOpen.value = false
}
</script>

<template>
  <Button size="sm" @click="openCreateStaffForm">
    Create Staff
  </Button>
  <Dialog v-model:open="isCreateStaffOpen">
    <DialogContent class="min-w-2xl">
      <DialogHeader>
        <DialogTitle>
          Create Staff
        </DialogTitle>
        <DialogDescription>
          Create new staff info
        </DialogDescription>
      </DialogHeader>
      <div class="p-4">
        <Form
          id="createForm" v-slot="{ errors, processing }" class="grid gap-2"
          v-bind="StaffController.store.form()" :transform="data => ({ ...data, is_active: true })" @success="closeCreateStaffForm"
        >
          <div class="grid gap-1">
            <Label for="name">Full name</Label>
            <Input type="text" name="name" class="w-full" placeholder="Enter full name: John Doe" />
            <InputError :message="errors.name" />
          </div>
          <div class="grid gap-1">
            <Label for="staff_number">Staff Number</Label>
            <Input
              type="text" name="staff_number" class="w-full"
              placeholder="Enter Staff Number: SM-3VXX"
            />
            <InputError :message="errors.staff_number" />
          </div>
          <div class="grid gap-1">
            <Label for="phone">Staff Phone</Label>
            <Input
              type="tel" name="phone" class="w-full"
              placeholder="Enter Staff Phone: +254700-000-___"
            />
            <InputError :message="errors.phone" />
          </div>
          <Button name="createForm" :disabled="processing">
            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
            Create
          </Button>
        </Form>
      </div>
    </DialogContent>
  </Dialog>
</template>
