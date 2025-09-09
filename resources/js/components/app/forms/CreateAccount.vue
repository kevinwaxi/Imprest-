<script lang="ts" setup>
import { Form } from '@inertiajs/vue3'
import { LoaderCircle } from 'lucide-vue-next'
import { ref } from 'vue'
import AccountController from '@/actions/App/Http/Controllers/ImprestWarrant/AccountController'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'

const isCreateStaffOpen = ref(false)

function openCreateForm() {
  isCreateStaffOpen.value = true
}

function closeCreateForm() {
  isCreateStaffOpen.value = false
}
</script>

<template>
  <Button size="sm" @click="openCreateForm">
    Create Account
  </Button>
  <Dialog v-model:open="isCreateStaffOpen">
    <DialogContent class="min-w-2xl">
      <DialogHeader>
        <DialogTitle>
          Create Account
        </DialogTitle>
        <DialogDescription>
          Create new account
        </DialogDescription>
      </DialogHeader>
      <div class="p-4">
        <Form
          id="createForm" v-slot="{ errors, processing }" class="grid gap-2"
          v-bind="AccountController.store.form()" :transform="data => ({ ...data, is_active: true })"
          @success="closeCreateForm"
        >
          <div class="grid gap-1">
            <Label for="name">Name</Label>
            <Input type="text" name="name" class="w-full" placeholder="Enter account name: Petty Cash" />
            <InputError :message="errors.name" />
          </div>
          <div class="grid gap-1">
            <Label for="code">Code</Label>
            <Input type="text" name="code" class="w-full" placeholder="Enter Staff Number: BA-3VXX" />
            <InputError :message="errors.code" />
          </div>
          <div class="grid gap-1">
            <Label for="description">Description</Label>
            <Textarea name="description" class="w-full" placeholder="Account descriptions" />
            <InputError :message="errors.description" />
          </div>
          <Button name="createForm" :disabled="processing">
            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
            {{ processing ? 'Creating' : 'Create' }}
          </Button>
        </Form>
      </div>
    </DialogContent>
  </Dialog>
</template>
