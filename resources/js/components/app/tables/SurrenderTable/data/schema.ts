import { z } from 'zod'

export const warrantSchema = z.object({
    id: z.number(), // DB auto-increment
    uuid: z.string(),
    doc_number: z.string().min(1),

})

export const surrenderSchema = z.object({
    id: z.number().int().optional(),
    // Instead of warrant_id, include full warrant object
    warrant: warrantSchema,

    doc_code: z.string(),
    sequence_number: z.number().int(),
    imprest_amount: z.string().regex(/^\d+(\.\d{1,2})?$/),
    actual_spent: z.string().regex(/^\d+(\.\d{1,2})?$/),

    created_at: z.coerce.date().optional(),
    updated_at: z.coerce.date().optional(),
})

export type Surrender = z.infer<typeof surrenderSchema>
