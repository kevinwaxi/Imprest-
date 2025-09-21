<script setup lang="ts">
import type { Table } from '@tanstack/vue-table'

import type { Surrender } from './data/schema'
import { Delete } from 'lucide-vue-next'

import { computed } from 'vue'
import { Button } from '@/components/ui/button'

import { Input } from '@/components/ui/input'

import DataTableViewOptions from './DataTableViewOptions.vue'

interface DataTableToolbarProps {
    table: Table<Surrender>
}

const props = defineProps<DataTableToolbarProps>()

const isFiltered = computed(() => props.table.getState().columnFilters.length > 0)
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex flex-1 items-center space-x-2">
            <Input placeholder="Filter code..."
                :model-value="(table.getColumn('doc_code')?.getFilterValue() as string) ?? ''"
                class="h-8 w-[150px] lg:w-[250px]"
                @input="table.getColumn('doc_code')?.setFilterValue($event.target.value)" />
            <!-- <DataTableFacetedFilter v-if="table.getColumn('priority')" :column="table.getColumn('priority')"
                title="Priority" :options="priorities" /> -->

            <Button v-if="isFiltered" variant="ghost" class="h-8 px-2 lg:px-3" @click="table.resetColumnFilters()">
                Reset
                <Delete class="ml-2 h-4 w-4" />
            </Button>
        </div>
        <div class="flex items-center gap-2">
            <DataTableViewOptions :table="table" />
        </div>
    </div>
</template>
