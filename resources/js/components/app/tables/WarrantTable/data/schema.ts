import { z } from 'zod'

export const warrantSchema = z.object({
  id: z.number(), // DB auto-increment
  uuid: z.string(),
  doc_number: z.string().min(1),

  // Relationships
  staff: z.object({
    name: z.string(),
  }),
  account: z.object({
    name: z.string(),
  }).nullable(),
  project: z.object({
    name: z.string(),
  }).nullable(),
  //   project_id: z.string().nullable().optional(),

  // Workflow Users
  prepared_by: z.object({
    name: z.string(),
  }).nullable(),
  checked_by: z.number().nullable().optional(),
  approved_by: z.number().nullable().optional(),
  signed_by: z.number().nullable().optional(),

  // Financials
  amount: z.number().nonnegative().nullable(),
  purpose: z.string().nullable().optional(),
  remarks: z.string().nullable().optional(),

  // Bank / Payment
  payee_bank: z.string().nullable().optional(),
  payee_account_number: z.string().nullable().optional(),
  paying_bank: z.string().nullable().optional(),
  cheque_number: z.string().nullable().optional(),
  memo_number: z.string().nullable().optional(),
  payment_date: z.string().nullable().optional(), // ISO string
  signed_date: z.string().nullable().optional(),

  // Status
  status: z.string().default('draft'),
  status_remarks: z.string().nullable().optional(),

  // Audit trail
  created_by: z.number().nullable().optional(),
  updated_by: z.number().nullable().optional(),
  created_at: z.string().optional(),
  updated_at: z.string().optional(),
  deleted_at: z.string().nullable().optional(),
})

export type Warrant = z.infer<typeof warrantSchema>
