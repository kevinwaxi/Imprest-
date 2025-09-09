import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

type AuthUser = {
  permissions: string[]
  roles: string[]
}

type PageProps = {
  auth: AuthUser
}

export function useHasPermissions() {
  const user = computed(() => (usePage().props as unknown as PageProps).auth)

  const isSuperAdmin = computed(() => {
    return user.value?.roles.includes('super-admin')
  })

  const hasPermission = (permission: string) => {
    if (isSuperAdmin.value)
      return true
    return user.value?.permissions.includes(permission)
  }

  const hasAnyPermission = (permissions: string[]) => {
    if (isSuperAdmin.value)
      return true
    return permissions.some(permission => hasPermission(permission))
  }

  const hasAllPermissions = (permissions: string[]) => {
    if (isSuperAdmin.value)
      return true
    return permissions.every(permission => hasPermission(permission))
  }

  const hasRole = (role: string) => {
    return user.value?.roles.includes(role)
  }

  const hasAnyRole = (roles: string[]) => {
    return roles.some(role => hasRole(role))
  }

  const hasAllRoles = (roles: string[]) => {
    return roles.every(role => hasRole(role))
  }

  return {
    user,
    hasPermission,
    hasAnyPermission,
    hasAllPermissions,
    hasRole,
    hasAnyRole,
    hasAllRoles,
    permissions: user.value?.permissions,
    roles: user.value?.roles,
  }
}
