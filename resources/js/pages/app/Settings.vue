<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
  settings: Object,
})

const form = useForm({
  site: props.settings?.site || { name: '', description: '' },
  communication: props.settings?.communication || { email: '', phone: '', company: '' },
  address: props.settings?.address || { country: '', city: '', timezone: '' },
  authority: props.settings?.authority || { approver: '', examiner: '', authorizer: '' },
})

function submit() {
  form.post('/app_settings', {
    onSuccess: () => { console.log('success') },
  })
}
</script>

<template>
  <AppLayout>
    <h2>
      App Settings
    </h2>

    <div class="p-2 grid gap-3">
      <div class="grid grid-cols-4 gap-4 w-full">
        <!-- Site Info -->
        <Card class="col-span-2">
          <CardHeader>
            Site Information
          </CardHeader>
          <CardContent>
            <Input v-model="form.site.name" class="input" placeholder="Site Name" />
            <Textarea v-model="form.site.description" class="input mt-2" placeholder="Description" />
          </CardContent>
        </Card>
        <!-- Communication -->
        <Card class="col-span-2">
          <CardHeader class="font-semibold mb-2">
            Communication
          </CardHeader>
          <CardContent>
            <Input v-model="form.communication.email" class="input" placeholder="Email" />
            <Input v-model="form.communication.phone" class="input mt-2" placeholder="Phone" />
            <Input v-model="form.communication.company" class="input mt-2" placeholder="Company" />
          </CardContent>
        </Card>
      </div>

      <!-- Address -->
      <Card>
        <CardHeader class="font-semibold mb-2">
          Default Address
        </CardHeader>
        <CardContent>
          <Input v-model="form.address.country" class="input" placeholder="Country" />
          <Input v-model="form.address.city" class="input mt-2" placeholder="City" />
          <Input v-model="form.address.timezone" class="input mt-2" placeholder="Timezone" />
        </CardContent>
      </Card>

      <!-- Defaults Accounts -->

      <Card>
        <CardHeader>
          Default Authorizations
        </CardHeader>
        <CardContent>
          <div class="grid gap-2">
            <Input v-model="form.authority.approver" class="input" placeholder="Approver" />
            <Input v-model="form.authority.examiner" class="input" placeholder="Examiner" />
            <Input v-model="form.authority.authorizer" class="input" placeholder="Authorizer" />
          </div>
        </CardContent>
      </Card>

      <div>
        <Button :disabled="form.processing" @click="submit">
          {{ form.processing ? 'saving' : 'Save' }}
        </Button>
      </div>
    </div>
  </AppLayout>
</template>
