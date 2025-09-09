<script setup lang="ts">
import { computed } from 'vue'

import { cn } from '@/lib/utils'

import { inputVariants, inputWrapperVariants } from '.'

const props = defineProps<{
  variant?: 'sm' | 'md' | 'lg'
  class?: string
}>()

const classes = computed(() =>
  cn(inputVariants({ variant: props.variant }), inputWrapperVariants({ variant: props.variant }), props.class),
)
</script>

<template>
  <div :class="classes" data-slot="input-wrapper">
    <slot />
  </div>
</template>
