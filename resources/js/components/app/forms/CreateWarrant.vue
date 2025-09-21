<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { PlusCircle, Trash2 } from 'lucide-vue-next'
import { computed, onMounted, ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader } from '@/components/ui/card'
import {
    Dialog,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogScrollContent,
    DialogTitle,
} from '@/components/ui/dialog'

import Input from '@/components/ui/input/Input.vue'

import {
    Select,
    SelectContent,
    SelectItem,
    SelectItemText,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import { useAccountStore } from '@/Store/useAccountStore'
import { useProjectStore } from '@/Store/useProjectStore'
import { useStaffStore } from '@/Store/useStaffStore'
import { useUserStore } from '@/Store/useUserStore'

const isCreateFormOpen = ref(false)
const lastDocNumber = ref('IW000')

const maxWarrants = 10
const accountStore = useAccountStore()
const projectStore = useProjectStore()
const staffStore = useStaffStore()
const userStore = useUserStore()

const allAccounts = computed(() => accountStore.accounts)
const allProjects = computed(() => projectStore.projects)
const allStaff = computed(() => staffStore.staff)
const allUsers = computed(() => userStore.user)

const page = usePage()
const authUser = page.props.auth.user

// Common defaults (applied to every warrant)
const commonFields = ref({
    account_id: '',
    prepared_by: authUser.id,
    project_id: '',
    amount: '',
    purpose: '',
    remarks: '',
    payment_date: '',
    signed_date: '',
})

const form = useForm({
    warrants: [
        {
            doc_number: '',
            staff_id: '',
        },
    ],
})

async function openCreateForm() {
    const { data } = await axios.get('/api/warrants/last-doc-number')
    lastDocNumber.value = data.lastDocNumber
    isCreateFormOpen.value = true

    // initialize the form
    form.warrants = [
        {
            doc_number: getNextDocNumber(0),
            staff_id: '',
        },
    ]
}

function closeCreateForm() {
    isCreateFormOpen.value = false
    form.reset()
    commonFields.value = {
        account_id: '',
        prepared_by: authUser,
        project_id: '',
        amount: '',
        purpose: '',
        remarks: '',
        payment_date: '',
        signed_date: '',
    }
}

function getNextDocNumber(index: number) {
    const base = Number.parseInt(lastDocNumber.value.replace('IW', ''), 10)
    const next = base + index + 1
    return `IW${next.toString().padStart(3, '0')}`
}

function addWarrant() {
    const newIndex = form.warrants.length
    if (form.warrants.length < maxWarrants) {
        form.warrants.push({
            doc_number: getNextDocNumber(newIndex),
            staff_id: '',
        })
    }
}

function removeWarrant(index: number) {
    form.warrants.splice(index, 1)
    form.warrants = form.warrants.map((warrant, i) => ({
        ...warrant,
        doc_number: getNextDocNumber(i),
    }))
}

function submit() {
    // Merge common fields into each warrant before sending
    const payload = {
        warrants: form.warrants.map(w => ({
            ...w,
            ...commonFields.value,
        })),
    }

    form.transform(() => payload).post('/warrants', {
        preserveScroll: true,
        onSuccess: () => {
            closeCreateForm()
        },
    })
}

onMounted(async () => {
    await accountStore.fetchAccounts?.()
    await projectStore.fetchProjects?.()
    await staffStore.fetchStaff?.()
    await userStore.fetchUsers?.()
})
</script>

<template>
    <Button size="sm" @click="openCreateForm">
        Create Warrants
    </Button>

    <Dialog v-model:open="isCreateFormOpen">
        <DialogScrollContent class="sm:min-w-4xl">
            <DialogHeader>
                <DialogTitle>Create Warrants</DialogTitle>
                <DialogDescription>
                    Enter common details once. You can add up to {{ maxWarrants }} warrants at a time, changing only
                    staff (and document number).
                </DialogDescription>
            </DialogHeader>

            <form class="space-y-6" @submit.prevent="submit">
                <!-- Common fields -->
                <Card>
                    <CardHeader>
                        <h2 class="font-semibold">
                            Common Details
                        </h2>
                    </CardHeader>
                    <CardContent>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid grid-cols-2 gap-2 col-span-2">
                                <!-- Account -->
                                <Select v-if="allAccounts.length" v-model="commonFields.account_id" class="w-full"
                                    default-value="1">
                                    <SelectTrigger class="**:data-desc:hidden w-auto max-w-full min-w-48">
                                        <SelectValue placeholder="Choose account" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="option in allAccounts" :key="option.value"
                                            :value="option.value">
                                            <SelectItemText>{{ option.label }}</SelectItemText>
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <!-- Project (nullable, so optional) -->
                                <Select v-if="allProjects.length" v-model="commonFields.project_id" class="w-full">
                                    <SelectTrigger class="**:data-desc:hidden w-auto max-w-full min-w-48">
                                        <SelectValue placeholder="Choose project" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="option in allProjects" :key="option.value"
                                            :value="option.value">
                                            <SelectItemText>{{ option.label }}</SelectItemText>
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <!-- Prepared by -->
                                <Select v-model="commonFields.prepared_by" class="w-full">
                                    <SelectTrigger class="**:data-desc:hidden w-auto max-w-full min-w-48">
                                        <SelectValue placeholder="Prepared By" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="option in allUsers" :key="option.value"
                                            :value="option.value">
                                            <SelectItemText>{{ option.label }}</SelectItemText>
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <!-- Amount -->
                            <Input v-model="commonFields.amount" placeholder="Amount" type="number"
                                class="w-full col-span-2" />

                            <!-- Purpose -->
                            <Textarea v-model="commonFields.purpose" class="col-span-3" placeholder="Purpose" />
                        </div>
                    </CardContent>
                </Card>

                <!-- Individual staff warrants -->
                <div class="grid gap-6">
                    <Card v-for="(warrant, index) in form.warrants" :key="index" class="relative">
                        <CardHeader>
                            <div class="flex justify-between items-center">
                                <h2 class="font-semibold">
                                    Warrant {{ index + 1 }}
                                </h2>
                                <Button v-if="form.warrants.length > 1" type="button" variant="destructive" size="icon"
                                    @click="removeWarrant(index)">
                                    <Trash2 class="w-4 h-4" />
                                </Button>
                            </div>
                        </CardHeader>

                        <CardContent>
                            <div class="grid grid-cols-3 gap-4">
                                <!-- Document Number -->
                                <Input v-model="warrant.doc_number" placeholder="Document Number" />

                                <!-- Staff -->
                                <Select v-model="warrant.staff_id" class="w-full">
                                    <SelectTrigger class="**:data-desc:hidden">
                                        <SelectValue placeholder="Choose staff" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="option in allStaff" :key="option.value"
                                            :value="option.value">
                                            <SelectItemText>{{ option.label }}</SelectItemText>
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Controls -->
                <div class="flex gap-3">
                    <Button type="button" variant="outline" :disabled="form.warrants.length >= maxWarrants"
                        @click="addWarrant">
                        <PlusCircle class="w-4 h-4 mr-2" />
                        Add Warrant
                    </Button>

                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Submitting' : 'Submit Warrant' }}
                    </Button>
                </div>
            </form>

            <DialogFooter>
                <Button variant="outline" @click="closeCreateForm">
                    Cancel
                </Button>
            </DialogFooter>
        </DialogScrollContent>
    </Dialog>
</template>
