import type { ColumnDef } from '@tanstack/vue-table'

import type { User } from './data/schema'
import { BadgeCheck, CheckCircle2Icon, ShieldAlertIcon } from 'lucide-vue-next'

import { h } from 'vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Badge } from '@/components/ui/badge'

import { Checkbox } from '@/components/ui/checkbox'

// import { labels, priorities, statuses } from '../data/data'
import DataTableColumnHeader from './DataTableColumnHeader.vue'
import DataTableRowActions from './DataTableRowActions.vue'

export const columns: ColumnDef<User>[] = [
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
      const userFullName = String(row.original.full_name)
      const userEmail = row.original.email

      return h('div', { class: 'flex items-center gap-3' }, [
        h(Avatar, { class: 'h-8 w-8 border-2 border-background hover:z-10' }, [
          h(AvatarImage, { src: String(row.getValue('avatar') || '') }),
          h(AvatarFallback, {}, () => (userFullName || '?')
            .split(' ')
            .map(n => n[0])
            .join('')),
        ]),
        h('div', { class: 'grid flex-1 gap-1.5' }, [
          h('span', { class: 'text-sm font-medium leading-none' }, userFullName),
          h('span', { class: 'text-xs leading-none text-muted-foreground' }, userEmail),
        ]),
      ])
    },
    enableHiding: false,
  },
  {
    accessorKey: 'roles',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Roles',
      table, // Pass the table instance
    }),
    cell: ({ row }) => {
      const roles: any[] = row.getValue('roles') || []
      const visibleRoles = roles.slice(0, 2)
      const hiddenRoles = roles.slice(2)
      const hiddenCount = hiddenRoles.length

      return h('div', { class: 'flex flex-wrap gap-1' }, [
        ...visibleRoles.map((role: any) => h(Badge, { variant: 'outline', class: 'rounded-sm' }, () => role.name)),
        hiddenCount > 0
        && h(Badge, { variant: 'outline', class: 'rounded-sm' }, () => `+${hiddenCount} more`),
      ])
    },
    enableHiding: true,
  },
  {
    accessorKey: 'verified_at',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Verified',
      table, // Pass the table instance
    }),
    cell: ({ row }) => {
      const verified_at = row.original.email_verified_at || null

      return h('div', { class: 'flex items-center gap-2' }, [
        verified_at === null
          ? h(BadgeCheck, { class: 'size-4 text-muted-foreground' })
          : h(BadgeCheck, { class: 'size-4 text-success' }),
      ])
    },
    filterFn: (row, columnId, filterValues) => {
      const verified_at = row.getValue(columnId)
      const verification = verified_at ? 'verified' : 'not_verified'

      return filterValues.includes(verification)
    },
    enableHiding: true,
  },
  {
    accessorKey: 'banned_at',
    header: ({ column, table }) => h(DataTableColumnHeader, {
      column,
      title: 'Status',
      table, // Pass the table instance
    }),
    cell: ({ row }) => {
      const banned_at = row.original.banned_at

      return h('div', { class: 'flex items-center gap-2' }, [
        banned_at
          ? h(Badge, { variant: 'warning', class: 'rounded-sm' }, [
              h(ShieldAlertIcon, { class: 'size-3 mr-1' }),
              h('span', {}, 'Banned'),
            ])
          : h(Badge, { variant: 'success', class: 'rounded-sm' }, [
              h(CheckCircle2Icon, { class: 'size-3 mr-1' }),
              h('span', {}, 'Active'),
            ]),
      ])
    },
    filterFn: (row, columnId, filterValues) => {
      const banned_at = row.getValue(columnId)
      const status = banned_at ? 'banned' : 'active'

      return filterValues.includes(status)
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
