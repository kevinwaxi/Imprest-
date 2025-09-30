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
import { useDialogDelete } from '@/composables/useDialogDelete'
import { useNumberToWords } from '@/composables/useNumbersToWords'
import { surrenderSchema } from './data/schema'

interface DataTableRowActionsProps {
  row: Row<Surrender>
}

const props = defineProps<DataTableRowActionsProps>()

const { openModal: openDeleteDialog } = useDialogDelete()

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

const documentNo = parsedSurrender.value.doc_code
const wNumber = `W: ${parsedSurrender.value.doc_code}`
const documentDate = parsedSurrender.value.created_at
const payeeName = parsedSurrender.value.warrant.staff.name

const imprestAmount = parsedSurrender.value.imprest_amount
const actualSpent = (parsedSurrender.value.actual_spent ?? 0) + 300
const remainingAmount = ((actualSpent ?? 0) - (imprestAmount ?? 0))

const preparedByName = parsedSurrender.value.warrant.prepared_by?.name
const preparedByDate = parsedSurrender.value.warrant.created_at
const examinationByName = parsedSurrender.value.examiner
const expenditureApprovedByName = parsedSurrender.value.approver
const authorizedByName = parsedSurrender.value.authorizer

const projectName = parsedSurrender.value.warrant.project?.name
const projectPurpose = parsedSurrender.value.warrant.purpose
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
    <DialogScrollContent class="sm:min-w-6xl p-2">
      <DialogHeader>
        <DialogTitle>
          Preview Imprest Surrender
        </DialogTitle>
        <DialogDescription>
          View Imprest Surrender
        </DialogDescription>
      </DialogHeader>
      <div class="w-full p-6 rounded-lg shadow print:shadow-none print:p-0">
        <div ref="componentRef">
          <!-- Header -->
          <div class="flex justify-between items-start border-b pb-4">
            <div>
              <h1 class="text-xl font-bold uppercase leading-tight">
                Imprest Surrender <br> Form
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
              <p><span class="font-semibold">Document No:</span> {{ wNumber }}</p>
              <p><span class="font-semibold">Document Date:</span> {{ documentDate }}</p>
              <p><span class="font-semibold">Staff Name:</span> {{ payeeName }}</p>

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
                    Vote Name
                  </th>
                  <th class="border p-2 text-left">
                    Purpose
                  </th>
                  <th class="border p-2 text-right">
                    Imprest Amount
                  </th>
                  <th class="border p-2 text-right">
                    Actual Spent
                  </th>
                  <th class="border p-2 text-right">
                    Remaining Amount
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="border p-2" />
                  <td class="border p-2">
                    {{ projectName }}
                  </td>
                  <td class="border p-2">
                    {{ projectPurpose }}
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(imprestAmount ?? 0, 'currency') }}
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(actualSpent ?? 0, 'currency') }}
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(remainingAmount ?? 0, 'currency') }}
                  </td>
                </tr>
                <tr class="font-semibold bg-background/20">
                  <td colspan="3" class="border p-2 text-right">
                    Total Amount (Kshs.)
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(imprestAmount ?? 0, 'currency') }}
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(actualSpent ?? 0, 'currency') }}
                  </td>
                  <td class="border p-2 text-right">
                    {{ $n(remainingAmount ?? 0, 'currency') }}
                  </td>
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
              {{ numberToCurrencyWords(actualSpent) }} ...
            </p>
          </div>
          <!-- Footer -->
          <div class="mt-8 text-xs space-y-4">
            <p>
              I certify that the amount has been captured in the system under the document number
              above...
            </p>

            <!-- Account Information -->
            <div class="mt-6">
              <p class="text-orange-600 font-semibold mb-2">
                Account Info
              </p>
              <div class="grid grid-cols-3 gap-4">
                <table class="w-full border border-gray-300 text-xs col-span-1">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2">
                        Paying Bank
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Cheque EFT/No.
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Payment Date
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          -
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>-</p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>-</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="w-full border border-gray-300 text-xs col-span-1 col-start-3">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2">
                        Department
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Project
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          -
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>-</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
              <div class="mt-6">
                <p class="text-orange-600 font-semibold mb-2">
                  Prepared By
                </p>
                <table class="w-full border border-gray-300 text-xs">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2" />
                      <th class="border p-2 w-1/4 text-center">
                        Date &amp; time
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Signature
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          {{ preparedByName }}
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>{{ preparedByDate }}</p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>__________</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-6">
                <p class="text-orange-600 font-semibold mb-2">
                  Expenditure Approved By
                </p>
                <table class="w-full border border-gray-300 text-xs">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2" />
                      <th class="border p-2 w-1/4 text-center">
                        Date &amp; time
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Signature
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          {{ expenditureApprovedByName }}
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>{{ preparedByDate }}</p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>__________</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-6">
                <p class="text-orange-600 font-semibold mb-2">
                  Examination By
                </p>
                <table class="w-full border border-gray-300 text-xs">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2" />
                      <th class="border p-2 w-1/4 text-center">
                        Date &amp; time
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Signature
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          {{ examinationByName }}
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>{{ preparedByDate }}</p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>__________</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-6">
                <p class="text-orange-600 font-semibold mb-2">
                  Authorized By
                </p>
                <table class="w-full border border-gray-300 text-xs">
                  <thead>
                    <tr>
                      <th class="border p-2 w-1/2" />
                      <th class="border p-2 w-1/4 text-center">
                        Date &amp; time
                      </th>
                      <th class="border p-2 w-1/4 text-center">
                        Signature
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border p-2 align-top">
                        <p class=" font-bold">
                          {{ authorizedByName }}
                        </p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>{{ preparedByDate }}</p>
                      </td>
                      <td class="border p-2 text-center align-top">
                        <p>__________</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Document -->

      <div class="mt-6 flex justify-end">
        <Button @click="handlePrint">
          Print
        </Button>
      </div>
    </DialogScrollContent>
  </Dialog>
</template>
