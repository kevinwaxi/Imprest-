<script setup lang="ts">
import { LucideArrowUpRight, LucideTrendingDown, LucideUserPlus } from 'lucide-vue-next'
import { computed } from 'vue'

import { Badge } from '@/components/ui/badge'
import { Card, CardContent } from '@/components/ui/card'

/**
 * Props
 * We'll pass blog data from Inertia/Laravel controller
 */
type BlogStats = {
  totalPosts: number
  publishedPosts: number
  draftPosts: number
  totalViews: number
  newPostsLast30Days: number
  changeVsPrev: number // percent growth/decline
}
const props = defineProps<{ stats: BlogStats }>()

/**
 * Transform backend stats into cards array
 */
const cards = computed(() => [
  {
    title: 'Total Blog Posts',
    subtitle: 'All time',
    value: props.stats.totalPosts.toString(),
    valueColor: 'text-blue-600',
    badge: {
      color: 'bg-blue-100 text-blue-600 dark:bg-blue-950 dark:text-blue-400',
      icon: LucideArrowUpRight,
      iconColor: 'text-blue-500',
      text: `${props.stats.changeVsPrev > 0 ? '+' : ''}${props.stats.changeVsPrev}%`,
    },
    subtext: {
      value: `${props.stats.newPostsLast30Days}`,
      label: 'in last 30 days',
      color: props.stats.newPostsLast30Days > 0 ? 'text-green-600' : 'text-gray-500',
    },
  },
  {
    title: 'Published Posts',
    subtitle: 'Currently live',
    value: props.stats.publishedPosts.toString(),
    valueColor: 'text-green-600',
    badge: {
      color: 'bg-green-100 text-green-600 dark:bg-green-950 dark:text-green-400',
      icon: LucideUserPlus,
      iconColor: 'text-green-500',
      text: 'Published',
    },
    subtext: {
      value: `${props.stats.draftPosts}`,
      label: 'still in draft',
      color: 'text-gray-500',
    },
  },
  {
    title: 'Total Views',
    subtitle: 'All time',
    value: props.stats.totalViews.toLocaleString(),
    valueColor: 'text-purple-600',
    badge: {
      color: 'bg-purple-100 text-purple-600 dark:bg-purple-950 dark:text-purple-400',
      icon: LucideTrendingDown,
      iconColor: 'text-purple-500',
      text: 'Analytics',
    },
    subtext: {
      value: props.stats.totalViews > 1000 ? '🔥' : '',
      label: 'engagement trend',
      color: 'text-purple-600',
    },
  },
])
</script>

<template>
  <div class="*:not-first:mt-2">
    <div class="@container w-full grow">
      <div
        class="bg-background border-border grid grid-cols-1 overflow-hidden rounded-xl border @3xl:grid-cols-3"
      >
        <Card
          v-for="(card, i) in cards"
          :key="i"
          class="border-border rounded-none border-0 border-y py-4 shadow-none first:border-0 last:border-0 @3xl:border-x @3xl:border-y-0"
        >
          <CardContent class="flex h-full flex-col justify-between space-y-6">
            <div class="space-y-0.25">
              <div class="text-foreground text-base font-semibold">
                {{ card.title }}
              </div>
              <div class="text-muted-foreground text-xs">
                {{ card.subtitle }}
              </div>
            </div>

            <div class="flex flex-1 grow flex-col justify-between gap-1.5">
              <div class="flex items-center gap-2">
                <span :class="`text-2xl font-bold tracking-tight ${card.valueColor}`">
                  {{ card.value }}
                </span>
                <Badge
                  :class="`${card.badge.color} flex items-center gap-1 rounded-full py-0.5 text-xs font-medium shadow-none`"
                >
                  <component :is="card.badge.icon" :class="`h-3 w-3 ${card.badge.iconColor}`" />
                  {{ card.badge.text }}
                </Badge>
              </div>
              <div class="text-xs">
                <span :class="`${card.subtext.color} font-medium`">
                  {{ card.subtext.value }}
                </span>
                <span class="text-muted-foreground font-normal">
                  {{ card.subtext.label }}
                </span>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </div>
</template>
