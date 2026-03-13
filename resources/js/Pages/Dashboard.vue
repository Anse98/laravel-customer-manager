<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CreateCustomerModal from '@/Components/CreateCustomerModal.vue';
import { Head } from '@inertiajs/vue3';

export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, CreateCustomerModal },

    props: {
        customers: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            showCreateModal: false,
        };
    },

    computed: {
        hasCustomers() {
            return this.customers.length > 0;
        },
    },

    methods: {
        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Customers
                </h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">
                        {{ customers.length }} {{ customers.length === 1 ? 'customer' : 'customers' }}
                    </span>
                    <PrimaryButton @click="showCreateModal = true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Customer
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Empty state -->
                <div
                    v-if="!hasCustomers"
                    class="rounded-lg border-2 border-dashed border-gray-200 bg-white px-6 py-16 text-center"
                >
                    <div class="mx-auto h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-gray-900">No customers yet</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        You haven't registered any customers yet. Start by adding your first one.
                    </p>
                    <PrimaryButton class="mt-6" @click="showCreateModal = true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add your first customer
                    </PrimaryButton>
                </div>

                <!-- Customers table -->
                <div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hidden sm:table-cell">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hidden md:table-cell">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hidden lg:table-cell">
                                    Added
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr
                                v-for="customer in customers"
                                :key="customer.id"
                                class="transition-colors hover:bg-gray-50"
                            >
                                <!-- Name + avatar -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs shrink-0">
                                            {{ customer.first_name.charAt(0).toUpperCase() }}{{ customer.last_name.charAt(0).toUpperCase() }}
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ customer.first_name }} {{ customer.last_name }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a
                                        :href="`mailto:${customer.email}`"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline"
                                    >
                                        {{ customer.email }}
                                    </a>
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                    <span v-if="customer.phone" class="text-sm text-gray-700">{{ customer.phone }}</span>
                                    <span v-else class="text-sm text-gray-400">—</span>
                                </td>

                                <!-- Company -->
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <span v-if="customer.company" class="text-sm text-gray-700">{{ customer.company }}</span>
                                    <span v-else class="text-sm text-gray-400">—</span>
                                </td>

                                <!-- Date added -->
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <span class="text-sm text-gray-500">{{ formatDate(customer.created_at) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Create customer modal -->
        <CreateCustomerModal
            :show="showCreateModal"
            @close="showCreateModal = false"
        />
    </AuthenticatedLayout>
</template>
