import { z } from 'zod'

export const projectSchema = z.object({
  id: z.string(),
  code: z.string().nullable(),
  name: z.string(),
  description: z.string().nullable(),
  is_active: z.boolean(),
  start_date: z.string().nullable(),
  end_date: z.string().nullable(),
})

export type Project = z.infer<typeof projectSchema>
