import type { ColumnDef } from '@tanstack/vue-table'

import type { Surrender } from './data/schema'
import { h } from 'vue'
import { Checkbox } from '@/components/ui/checkbox'

// import { labels, priorities, statuses } from '../data/data'
import DataTableColumnHeader from './DataTableColumnHeader.vue'
import DataTableRowActions from './DataTableRowActions.vue'

export const columns: ColumnDef<Surrender>[] = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
            'class': 'translate-y-0.5',
        }),
        cell: ({ row }) => h(Checkbox, { 'modelValue': row.getIsSelected(), 'onUpdate:modelValue': value => row.toggleSelected(!!value), 'ariaLabel': 'Select row', 'class': 'translate-y-0.5' }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'doc_code',
        header: ({ column, table }) => h(DataTableColumnHeader, {
            column,
            title: 'Document Code',
            table,
        }),
        cell: ({ row }) => {
            return h('div', { class: 'flex items-center gap-3' }, row.getValue('doc_code'))
        },
        enableHiding: false,
    },
    {
        accessorKey: 'warrant_name',
        header: ({ column, table }) => h(DataTableColumnHeader, {
            column,
            title: 'Warrant Code',
            table,
        }),
        cell: ({ row }) => {
            const warrantDetails = row.original.warrant
            return h('div', { class: 'flex items-center gap-3' }, warrantDetails.doc_number)
        },
        enableHiding: false,
    },
    {
        accessorKey: 'created_at',
        header: ({ column, table }) => h(DataTableColumnHeader, {
            column,
            title: 'Created At',
            table, // Pass the table instance
        }),
        cell: ({ row }) => {
            return h('div', { class: 'flex items-center gap-2' }, [
                h('span', { class: 'text-sm font-medium leading-none' }, row.getValue('created_at')),
            ])
        },
        enableHiding: true,
    },
    {
        id: 'actions',
        cell: ({ row }) => h(DataTableRowActions, { row }),
    },
]
