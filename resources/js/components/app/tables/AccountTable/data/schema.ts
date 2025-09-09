import { z } from 'zod'

export const accountSchema = z.object({
  id: z.number(),
  code: z.string().nullable(),
  name: z.string(),
  description: z.string().nullable(),
  is_active: z.boolean(),
  balance: z.string(),
})

export type Account = z.infer<typeof accountSchema>
