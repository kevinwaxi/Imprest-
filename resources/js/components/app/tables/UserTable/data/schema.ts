import { z } from 'zod'

export const userSchema = z.object({
  id: z.number(),
  first_name: z.string(),
  last_name: z.string(),
  other_names: z.string().nullable(), // Assuming other_names can be null
  full_name: z.string(),
  email: z.string(),
  // profile: profileSchema, // Optional when using whenLoaded
  roles: z.array(z.object({
    id: z.number(),
    name: z.string(),
  })).optional(), // Optional when using whenLoaded
  created_at: z.string(), // diffForHumans returns string
  updated_at: z.string(), // diffForHumans returns string
  banned_at: z.string().nullable(),
  email_verified_at: z.string().nullable(),
})

export type User = z.infer<typeof userSchema>
