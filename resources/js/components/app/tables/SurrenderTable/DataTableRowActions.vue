<script setup lang="ts">
import type { Row } from '@tanstack/vue-table'
import type { Surrender } from './data/schema'

import { useForm } from '@inertiajs/vue3'
import { MoreHorizontalIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue'

import { useVueToPrint } from 'vue-to-print'
import { Button } from '@/components/ui/button'

import { Dialog, DialogDescription, DialogHeader, DialogScrollContent, DialogTitle } from '@/components/ui/dialog'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { useDialogConfirm } from '@/composables/useDialogConfirm'
import { useDialogDelete } from '@/composables/useDialogDelete'
import { useNumberToWords } from '@/composables/useNumbersToWords'
import { surrenderSchema } from './data/schema'

interface DataTableRowActionsProps {
    row: Row<Surrender>
}

const props = defineProps<DataTableRowActionsProps>()

const { openModal: openDeleteDialog } = useDialogDelete()
const { openModal: openGenerateDialog } = useDialogConfirm()

const isPreviewDialogOpen = ref(false)

const { numberToCurrencyWords } = useNumberToWords()

// ✅ Parse row data with zod schema (safely typed)
const parsedSurrender = computed(() => surrenderSchema.parse(props.row.original))

// ✅ Keep form reactive to parsedSurrender changes
const form = useForm({
    id: parsedSurrender.value.id,
})

const componentRef = ref()

// --- Actions ---
function deleteWarrant() {
    openDeleteDialog({
        title: 'Delete Warrant',
        route: `warrants/delete/${form.id}`, // ✅ use named route helper
        method: 'delete',
    })
}

function openPreviewDialog() {
    isPreviewDialogOpen.value = true
}

function closePreviewDialog() {
    isPreviewDialogOpen.value = false
}

const { handlePrint } = useVueToPrint({
    content: componentRef,
    documentTitle: `${parsedSurrender.value.doc_code}`,
    pageStyle: 'A4',
})
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="flex h-8 w-8 p-0 data-[state=open]:bg-muted">
                <MoreHorizontalIcon class="h-4 w-4" />
                <span class="sr-only">Open menu</span>
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end" class="w-[160px]">
            <DropdownMenuItem @click="openPreviewDialog">
                Preview
            </DropdownMenuItem>
            <DropdownMenuSeparator />

            <DropdownMenuItem class="bg-destructive text-destructive-foreground" @click="deleteWarrant">
                Delete
                <DropdownMenuShortcut>⌘⌫</DropdownMenuShortcut>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <!-- Dialogs -->
    <Dialog v-model:open="isPreviewDialogOpen">
        <DialogScrollContent class="sm:min-w-[800px] p-2">
            <DialogHeader>
                <DialogTitle>
                    Preview Imprest Warrant
                </DialogTitle>
                <DialogDescription>
                    View Imprest Warrant and make changes
                </DialogDescription>
            </DialogHeader>
            testiing
        </DialogScrollContent>
    </Dialog>
</template>
