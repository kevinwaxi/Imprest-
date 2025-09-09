<script lang="ts" setup>
import type { Project } from '@/components/app/tables/ProjectTable/data/schema'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { columns } from '@/components/app/tables/ProjectTable/columns'
import DataTable from '@/components/app/tables/ProjectTable/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { index as project } from '@/routes/projects'

interface Prop {
  projects: Project[]
}

const props = defineProps<Prop>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Project',
    href: project().url,
  },
]
</script>

<template>
  <Head title="Imprest Warrant - Projects" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable :data="props.projects" :columns="columns" />
    </div>
  </AppLayout>
</template>
