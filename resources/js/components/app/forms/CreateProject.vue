<script lang="ts" setup>
import type { DateValue } from '@internationalized/date'
import { Form } from '@inertiajs/vue3'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'
import { CalendarIcon, LoaderCircle } from 'lucide-vue-next'
import { ref } from 'vue'
import ProjectController from '@/actions/App/Http/Controllers/ImprestWarrant/ProjectController'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Calendar } from '@/components/ui/calendar'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { Textarea } from '@/components/ui/textarea'
import { cn } from '@/lib/utils'

const isCreateStaffOpen = ref(false)

function openCreateForm() {
  isCreateStaffOpen.value = true
}

function closeCreateForm() {
  isCreateStaffOpen.value = false
}

const df = new DateFormatter('en-US', {
  dateStyle: 'long',
})

const value = ref<DateValue>()
</script>

<template>
  <Button size="sm" @click="openCreateForm">
    Create Project
  </Button>
  <Dialog v-model:open="isCreateStaffOpen">
    <DialogContent class="min-w-2xl">
      <DialogHeader>
        <DialogTitle>
          Create Project
        </DialogTitle>
        <DialogDescription>
          Create new project
        </DialogDescription>
      </DialogHeader>
      <div class="p-4">
        <Form
          id="createForm" v-slot="{ errors, processing }" class="grid gap-2"
          v-bind="ProjectController.store.form()" :transform="data => ({ ...data, is_active: true })"
          @success="closeCreateForm"
        >
          <div class="grid gap-1">
            <Label for="name">Name</Label>
            <Input type="text" name="name" class="w-full" placeholder="Enter project name" />
            <InputError :message="errors.name" />
          </div>
          <div class="grid gap-1">
            <Label for="code">Code</Label>
            <Input type="text" name="code" class="w-full" placeholder="Enter Project Code: PR-3VXX" />
            <InputError :message="errors.code" />
          </div>
          <div class="grid gap-1">
            <Label for="description">Description</Label>
            <Textarea name="description" class="w-full" placeholder="Project description" />
            <InputError :message="errors.description" />
          </div>
          <div class="grid gap-1">
            <Label for="start_date">Start Date</Label>
            <Popover name="start_date">
              <PopoverTrigger as-child>
                <Button
                  variant="outline" :class="cn(
                    'w-[280px] justify-start text-left font-normal',
                    !value && 'text-muted-foreground',
                  )"
                >
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  {{ value ? df.format(value.toDate(getLocalTimeZone())) : "Pick start date" }}
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model="value" initial-focus />
              </PopoverContent>
            </Popover>
            <InputError :message="errors.start_date" />
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
