import type { ColumnDef } from '@tanstack/vue-table'

import type { Account } from './data/schema'
import { h } from 'vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'

import { Checkbox } from '@/components/ui/checkbox'

// import { labels, priorities, statuses } from '../data/data'
import DataTableColumnHeader from './DataTableColumnHeader.vue'
import DataTableRowActions from './DataTableRowActions.vue'

export const columns: ColumnDef<Account>[] = [
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
    accessorKey: 'name',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Name',
      table,
    }),
    cell: ({ row }) => {
      const accountName = String(row.original.name)
      const accountCode = row.original.code

      return h('div', { class: 'flex items-center gap-3' }, [
        h('div', { class: 'grid flex-1 gap-1.5' }, [
          h('span', { class: 'text-sm font-medium leading-none' }, accountName),
          h('span', { class: 'text-xs leading-none text-muted-foreground' }, accountCode ?? ''),
        ]),
      ])
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
