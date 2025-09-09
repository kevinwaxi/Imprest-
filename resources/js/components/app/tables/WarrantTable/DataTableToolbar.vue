<script setup lang="ts">
import type { Table } from '@tanstack/vue-table'

import type { Warrant } from './data/schema'
import { Delete } from 'lucide-vue-next'

import { computed } from 'vue'
import { Button } from '@/components/ui/button'

import { Input } from '@/components/ui/input'

import CreateWarrant from '../../forms/CreateWarrant.vue'
import { statuses, verifications } from './data/data'
import DataTableFacetedFilter from './DataTableFacetedFilter.vue'
import DataTableViewOptions from './DataTableViewOptions.vue'

interface DataTableToolbarProps {
  table: Table<Warrant>
}

const props = defineProps<DataTableToolbarProps>()

const isFiltered = computed(() => props.table.getState().columnFilters.length > 0)
</script>

<template>
  <div class="flex items-center justify-between">
    <div class="flex flex-1 items-center space-x-2">
      <Input
        placeholder="Filter users..."
        :model-value="(table.getColumn('name')?.getFilterValue() as string) ?? ''"
        class="h-8 w-[150px] lg:w-[250px]"
        @input="table.getColumn('name')?.setFilterValue($event.target.value)"
      />
      <DataTableFacetedFilter
        v-if="table.getColumn('banned_at')"
        :column="table.getColumn('banned_at')"
        title="Status"
        :options="statuses"
      />

      <DataTableFacetedFilter
        v-if="table.getColumn('verified_at')"
        :column="table.getColumn('verified_at')"
        title="Verified"
        :options="verifications"
      />
      <!-- <DataTableFacetedFilter v-if="table.getColumn('priority')" :column="table.getColumn('priority')"
                title="Priority" :options="priorities" /> -->

      <Button
        v-if="isFiltered"
        variant="ghost"
        class="h-8 px-2 lg:px-3"
        @click="table.resetColumnFilters()"
      >
        Reset
        <Delete class="ml-2 h-4 w-4" />
      </Button>
    </div>
    <div class="flex items-center gap-2">
      <DataTableViewOptions :table="table" />
      <CreateWarrant />
    </div>
  </div>
</template>
