import { z } from 'zod'

export const topicSchema = z.object({
  id: z.string(),
  name: z.string(),
  slug: z.string(),
  description: z.string(),
  posts: z.array(z.object({
    id: z.string(),
    title: z.string(),
    slug: z.string(),
  })),
  post_count: z.number().nullable().optional(),
  user: z.object({
    id: z.number(),
    full_name: z.string(),
    email: z.string(),
  }),
  created_at: z.string(),
  updated_at: z.string(),
})

export type Topic = z.infer<typeof topicSchema>
