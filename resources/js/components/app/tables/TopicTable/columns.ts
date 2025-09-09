import type { ColumnDef } from '@tanstack/vue-table'

import { h } from 'vue'

import { Checkbox } from '@/components/ui/checkbox'

import type { Topic } from './data/schema'

import UserCard from './components/UserCard.vue'
// import { labels, priorities, statuses } from '../data/data'
import DataTableColumnHeader from './DataTableColumnHeader.vue'
import DataTableRowActions from './DataTableRowActions.vue'

export const columns: ColumnDef<Topic>[] = [
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
      return h('span', { class: 'text-sm font-medium leading-none' }, row.getValue('name'))
    },
    enableHiding: false,
  },
  {
    accessorKey: 'user',
    header: ({ column, table }) =>
      h(DataTableColumnHeader, {
        column,
        title: 'Created By',
        table,
      }),
    cell: ({ row }) => {
      const user = row.original.user
      if (!user)
        return h('span', {}, '-')

      return h(UserCard, { user })
    },
    enableHiding: false,
  },
  {
    accessorKey: 'post_count',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Posts Count',
      table,
    }),
    cell: ({ row }) => {
      return h('span', { class: 'text-sm font-medium leading-none' }, row.original.post_count ?? 'N/A')
    },
    enableHiding: true,
  },
  {
    accessorKey: 'created_at',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Joined',
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
