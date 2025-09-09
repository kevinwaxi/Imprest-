<script setup lang="ts">
import { computed } from 'vue'

import { cn } from '@/lib/utils'

import { inputAddonVariants } from '.'

const props = defineProps<{
  variant?: 'sm' | 'md' | 'lg'
  mode?: 'default' | 'icon'
  class?: string
}>()

const classes = computed(() =>
  cn(inputAddonVariants({ variant: props.variant, mode: props.mode }), props.class),
)
</script>

<template>
  <div :class="classes" data-slot="input-addon">
    <slot />
  </div>
</template>
