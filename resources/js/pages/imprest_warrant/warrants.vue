<script lang="ts" setup>
import type { Warrant } from '@/components/app/tables/WarrantTable/data/schema'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { columns } from '@/components/app/tables/WarrantTable/columns'
import DataTable from '@/components/app/tables/WarrantTable/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { index } from '@/routes/warrants'

interface Prop {
  warrants: Warrant[]
}

const props = defineProps<Prop>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Warrants',
    href: index().url,
  },
]
</script>

<template>
  <Head title="Imprest Warrant - Warrants" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable :data="props.warrants" :columns="columns" />
    </div>
  </AppLayout>
</template>
