<script lang="ts" setup>
import type { Staff } from '@/components/app/tables/StaffTable/data/schema'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { columns } from '@/components/app/tables/StaffTable/columns'
import DataTable from '@/components/app/tables/StaffTable/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { index as staff } from '@/routes/staff'

interface Prop {
  staff: Staff[]
}

const props = defineProps<Prop>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Staff',
    href: staff().url,
  },
]
</script>

<template>
  <Head title="Imprest Warrant - Staff" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div>
        <DataTable :columns="columns" :data="props.staff" />
      </div>
    </div>
  </AppLayout>
</template>
