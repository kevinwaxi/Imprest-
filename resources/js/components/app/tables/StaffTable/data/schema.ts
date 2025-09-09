import { z } from 'zod'

export const staffSchema = z.object({
  id: z.number(),
  staff_number: z.string().nullable(),
  name: z.string(),
  phone: z.string().nullable(),
  is_active: z.boolean(),
})

export type Staff = z.infer<typeof staffSchema>
