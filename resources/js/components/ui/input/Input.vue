<!-- Input.vue -->
<script setup lang="ts">
import { useVModel } from '@vueuse/core'
import { computed } from 'vue'

import { cn } from '@/lib/utils'

import { inputVariants } from '.' // for styling variants like sm/md/lg/ghost/etc

const props = defineProps<{
  modelValue?: string
  placeholder?: string
  type?: string
  class?: string
}>()
const emit = defineEmits(['update:modelValue'])
const model = useVModel(props, 'modelValue', emit)

const inputClasses = computed(() =>
  cn(inputVariants(), props.class),
)
</script>

<template>
  <input
    v-model="model"
    :type="type || 'text'"
    data-slot="input"
    :placeholder="placeholder"
    :class="inputClasses"
  >
</template>
