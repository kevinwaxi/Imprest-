<script setup lang="ts">
import type { NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { BookOpen, Building, Cog, LayoutGrid, LibraryBig, Notebook, SquareStack, Users } from 'lucide-vue-next'
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar'
import { dashboard } from '@/routes'
import { index as accounts } from '@/routes/accounts'
import { edit as appSettings } from '@/routes/app_settings'
import { index as projects } from '@/routes/projects'
import { index as staff } from '@/routes/staff'
import { index as surrenders } from '@/routes/surrenders'
import { index as warrants } from '@/routes/warrants'
import AppLogo from './AppLogo.vue'

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
  },
  {
    title: 'Staff',
    href: staff(),
    icon: Users,
  },
  {
    title: 'Accounts',
    href: accounts(),
    icon: Building,
  },
  {
    title: 'Projects',
    href: projects(),
    icon: Notebook,
  },
  {
    title: 'Warrants',
    href: warrants(),
    icon: LibraryBig,
  },
  {
    title: 'Surrender',
    href: surrenders(),
    icon: SquareStack,
  },

]

const footerNavItems: NavItem[] = [
  {
    title: 'App Settings',
    href: appSettings(),
    icon: Cog,
  },
  {
    title: 'Documentation',
    href: 'https://laravel.com/docs/starter-kits#vue',
    icon: BookOpen,
  },
]
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="dashboard()">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
