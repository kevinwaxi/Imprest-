<script setup lang="ts">
import type { Row } from '@tanstack/vue-table'
import type { Warrant } from './data/schema'

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
import { warrantSchema } from './data/schema'

const props = defineProps<DataTableRowActionsProps>()

interface DataTableRowActionsProps {
  row: Row<Warrant>
}

const { openModal: openDeleteDialog } = useDialogDelete()
const { openModal: openGenerateDialog } = useDialogConfirm()

const isPreviewDialogOpen = ref(false)

const { numberToCurrencyWords } = useNumberToWords()

// ✅ Parse row data with zod schema (safely typed)
const parsedWarrant = computed(() => warrantSchema.parse(props.row.original))

// ✅ Keep form reactive to parsedWarrant changes
const form = useForm({
  id: parsedWarrant.value.id,
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

function generateWarrant() {
  openGenerateDialog({
    title: 'Download Warrant',
    route: `/warrants/${form.id}/download`, // ✅ use named route helper
    method: 'post',
    message: 'Your warrant will be downloaded to your device',
  })
  window.open((`/warrants/${form.id}/download`), '_blank')
}

function openPreviewDialog() {
  isPreviewDialogOpen.value = true
}

function closePreviewDialog() {
  isPreviewDialogOpen.value = false
}

const imprestAmount = parsedWarrant.value.amount

const { handlePrint } = useVueToPrint({
  content: componentRef,
  documentTitle: `${parsedWarrant.value.doc_number}`,
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
      <div>
        <div class="w-full p-6 rounded-lg shadow print:shadow-none print:p-0">
          <div ref="componentRef">
            <!-- Header -->
            <div class="flex justify-between items-start border-b pb-4">
              <div>
                <h1 class="text-xl font-bold uppercase leading-tight">
                  Imprest Warrant <br> Form
                </h1>
              </div>
              <div
                class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-4 text-gray-400 text-sm"
              >
                Upload your company logo
              </div>
            </div>

            <!-- Info Row -->
            <div class="flex justify-between mt-4 text-sm">
              <div class="space-y-1">
                <p><span class="font-semibold">Document No:</span> W: {{ parsedWarrant.doc_number }}</p>
                <p><span class="font-semibold">Document Date:</span> {{ parsedWarrant.created_at }}</p>
                <p><span class="font-semibold">Staff Name:</span> {{ parsedWarrant.staff.name }}</p>

                <div class="mt-4 space-y-1">
                  <p class="font-semibold">
                    Payee Bank Details
                  </p>
                  <p><span class="font-semibold">Bank:</span> M-Pesa</p>
                  <p><span class="font-semibold">Branch:</span> N/A</p>
                  <p><span class="font-semibold">Account Number:</span> —</p>
                </div>
              </div>

              <div class="text-right text-xs space-y-0.5">
                <p class="font-bold">
                  KENYA BIOVAX INSTITUTE LIMITED
                </p>
                <p>P.O.BOX 40779-00100</p>
                <p>NAIROBI, KENYA</p>
                <p class="mt-2">
                  Embakasi, Rd to KQ Pride Centre
                </p>
                <p class="mt-2">
                  Inquiries: +254 775 751 639
                </p>
                <p>Email: info@biovax.go.ke</p>
              </div>
            </div>

            <!-- Payment Narration -->
            <div class="mt-6">
              <p class="text-orange-600 font-semibold mb-2">
                Payment Narration
              </p>
              <table class="w-full border border-gray-300 text-sm  rounded-2xl">
                <thead class="bg-orange-600 text-white">
                  <tr>
                    <th class="border p-2 text-left">
                      Vote No
                    </th>
                    <th class="border p-2 text-left">
                      Account Name
                    </th>
                    <th class="border p-2 text-left">
                      Purpose
                    </th>
                    <th class="border p-2 text-right">
                      Amount
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="border p-2" />
                    <td class="border p-2">
                      {{ parsedWarrant.account?.name }}
                    </td>
                    <td class="border p-2">
                      {{ parsedWarrant.purpose }}
                    </td>
                    <td class="border p-2 text-right">
                      {{ $n(parsedWarrant.amount ?? 0, 'currency') }}
                    </td>
                  </tr>
                  <tr class="font-semibold bg-background/20">
                    <td colspan="3" class="border p-2 text-right">
                      Total Amount (Kshs.)
                    </td>
                    <td class="border p-2 text-right">
                      {{ $n(parsedWarrant.amount ?? 0, 'currency') }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Payment Details -->
            <div class="mt-6 rounded-t-xl">
              <table class="w-full border border-gray-200 text-xs">
                <thead class="bg-orange-600 text-white">
                  <tr>
                    <th class="border p-2">
                      Paying Bank
                    </th>
                    <th class="border p-2">
                      Cheque/IBANK No
                    </th>
                    <th class="border p-2">
                      Payment Date
                    </th>
                    <th class="border p-2">
                      Department
                    </th>
                    <th class="border p-2">
                      Program
                    </th>
                    <th class="border p-2">
                      Project No
                    </th>
                    <th class="border p-2">
                      Memo No
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="border p-2">
                      KCB
                    </td>
                    <td class="border p-2" />
                    <td class="border p-2" />
                    <td class="border p-2" />
                    <td class="border p-2" />
                    <td class="border p-2" />
                    <td class="border p-2" />
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Amount in Words -->
            <div class="mt-6 text-xs">
              <p class="bg-orange-600 text-white font-medium px-2 py-1 rounded-t-sm">
                Amount Payable (In Words) Kshs.
              </p>
              <p class="border border-t-0 rounded-b-sm px-2 py-3">
                {{ numberToCurrencyWords(parsedWarrant.amount) }} ...
              </p>
            </div>

            <!-- Document Approval -->
            <div class="mt-6">
              <p class="text-orange-600 font-semibold mb-2">
                Document Approval
              </p>
              <table class="w-full border border-gray-300 text-xs">
                <thead>
                  <tr>
                    <th class="border p-2 w-1/2" />
                    <th class="border p-2 w-1/4 text-center">
                      Date &amp; Time Prepared
                    </th>
                    <th class="border p-2 w-1/4 text-center">
                      Signature
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="border p-2 align-top">
                      <p><strong>Prepared by:</strong>{{ parsedWarrant.prepared_by?.name }}</p>
                      <p class="mt-4">
                        <strong>Checked by:</strong> KELVIN GATEMBO
                      </p>
                    </td>
                    <td class="border p-2 text-center align-top">
                      <p>{{ parsedWarrant.created_at }}</p>
                      <p class="mt-4">
                        {{ parsedWarrant.created_at }}
                      </p>
                    </td>
                    <td class="border p-2 text-center align-top">
                      <p>__________</p>
                      <p class="mt-4">
                        __________
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-xs space-y-4">
              <p>
                I certify that the amount has been captured in the system under the document number
                above...
              </p>

              <table class="w-full border border-gray-300">
                <tbody>
                  <tr class="bg-background font-semibold">
                    <td class="border p-2">
                      Imprest Recipient
                    </td>
                    <td class="border p-2 text-center">
                      Date
                    </td>
                    <td class="border p-2 text-center">
                      Signature
                    </td>
                  </tr>
                  <tr>
                    <td class="border p-2">
                      Name: {{ parsedWarrant.staff.name }}
                    </td>
                    <td class="border p-2 text-center">
                      ____________
                    </td>
                    <td class="border p-2 text-center">
                      ____________
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Print Button -->
          <div class="mt-6 flex justify-end">
            <Button @click="handlePrint">
              Print
            </Button>
          </div>
        </div>
      </div>
    </DialogScrollContent>
  </Dialog>
</template>
