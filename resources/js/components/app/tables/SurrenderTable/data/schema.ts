import { z } from 'zod'

export const warrantSchema = z.object({
  id: z.number(), // DB auto-increment
  uuid: z.string(),
  doc_number: z.string().min(1),
  staff: z.object({
    name: z.string(),
  }),
  prepared_by: z.object({
    name: z.string(),
  }).nullable(),
  project: z.object({
    name: z.string(),
  }).nullable(),
  amount: z.number().nonnegative().nullable(),
  purpose: z.string().nullable().optional(),
  remarks: z.string().nullable().optional(),
  created_at: z.string(),
})

export const surrenderSchema = z.object({
  id: z.number().int().optional(),
  // Instead of warrant_id, include full warrant object
  warrant: warrantSchema,

  doc_code: z.string(),
  sequence_number: z.number().int(),
  imprest_amount: z.number().nonnegative().nullable(),
  actual_spent: z.number().nonnegative().nullable(),

  created_at: z.coerce.date().optional(),
  updated_at: z.coerce.date().optional(),

  //
  examiner: z.string(),
  approver: z.string(),
  authorizer: z.string(),
})

export type Surrender = z.infer<typeof surrenderSchema>
