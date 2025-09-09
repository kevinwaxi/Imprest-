<script setup lang="ts">
import { computed } from 'vue'

import { cn } from '@/lib/utils'

import { inputGroupVariants } from '.'

const props = defineProps<{
  class?: string
}>()

const classes = computed(() =>
  cn(inputGroupVariants(), props.class),
)
</script>

<template>
  <div :class="classes" data-slot="input-group">
    <slot />
  </div>
</template>
