<script setup lang="ts">
import { ArrowUpRightSquareIcon } from 'lucide-vue-next'
import { ref } from 'vue'

import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import { generateAvatarSvg } from '@/composables/useAvatar'

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false) // Initial value
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="ghost" class="group/item flex items-center gap-2">
        <div class="flex gap-2">
          <span class="text-sm font-medium leading-none">{{ props.user.full_name }}</span>
          <ArrowUpRightSquareIcon class="opacity-0 group-hover/item:opacity-100 transition-opacity size-4" />
        </div>
      </Button>
    </DialogTrigger>
    <DialogContent class="gap-0 p-0 [&>button:last-child]:text-primary sm:max-w-100">
      <div class="relative p-2">
        <img
          class="w-full rounded-md "
          src="/dialog-content.png"
          width="382"
          height="216"
          alt="dialog"
        >

        <!-- Avatar positioned on top -->
        <div class="absolute inset-0 flex items-center justify-center ">
          <img
            :src="generateAvatarSvg(user.full_name)"
            alt="avatar"
            class="w-20 h-20 rounded-full object-cover shadow-lg"
          >
        </div>
      </div>
      <div class="space-y-6 px-6 pt-3 pb-6">
        <DialogHeader>
          <DialogTitle>
            {{ user.full_name }}
          </DialogTitle>
          <DialogDescription>
            {{ user.email }}
          </DialogDescription>
        </DialogHeader>
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
          <div class="flex justify-center space-x-1.5 max-sm:order-1">
            {{ user.email }}
          </div>
        </div>
        <DailogFooter>
          <Button variant="secondary" @click="isOpen = false">
            Close
          </Button>
        </DailogFooter>
      </div>
    </DialogContent>
  </Dialog>
</template>
