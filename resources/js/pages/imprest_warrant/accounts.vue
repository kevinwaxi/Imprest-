<script lang="ts" setup>
import type { Account } from '@/components/app/tables/AccountTable/data/schema'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { columns } from '@/components/app/tables/AccountTable/columns'
import DataTable from '@/components/app/tables/AccountTable/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { index as accounts } from '@/routes/accounts'

interface Prop {
  accounts: Account[]
}

const props = defineProps<Prop>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Account',
    href: accounts().url,
  },
]
</script>

<template>
  <Head title="Imprest Warrant - Accounts" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable :columns="columns" :data="props.accounts" />
    </div>
  </AppLayout>
</template>
