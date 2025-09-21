<script setup lang="ts">
import type { Surrender } from '@/components/app/tables/SurrenderTable/data/schema'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { columns } from '@/components/app/tables/SurrenderTable/columns'
import DataTable from '@/components/app/tables/SurrenderTable/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { index } from '@/routes/surrenders'

interface Prop {
    surrenders: Surrender[]
}

const props = defineProps<Prop>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Surrender',
        href: index().url,
    },
]
</script>

<template>

    <Head title="Imprest Warrant - Surrenders" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <DataTable :data="props.surrenders" :columns="columns" />
        </div>
    </AppLayout>
</template>
