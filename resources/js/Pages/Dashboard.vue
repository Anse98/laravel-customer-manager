<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CustomerModal from '@/Components/CustomerModal.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, CustomerModal, ConfirmModal, Link },

    props: {
        customers: {
            type: Array,
            required: true,
        },
    },

    setup() {
        const deleteForm = useForm({});
        return { deleteForm };
    },

    data() {
        return {
            showModal: false,
            selectedCustomer: null,
            showConfirmModal: false,
            customerToDelete: null,
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

        openModal(customer = null) {
            this.selectedCustomer = customer;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.selectedCustomer = null;
        },

        openDeleteConfirm(customer) {
            this.customerToDelete = customer;
            this.showConfirmModal = true;
        },

        closeDeleteConfirm() {
            this.showConfirmModal = false;
            this.customerToDelete = null;
        },

        confirmDelete() {
            this.deleteForm.delete(route('customers.destroy', this.customerToDelete.id), {
                onSuccess: () => this.closeDeleteConfirm(),
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
                    <PrimaryButton @click="openModal()">
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
                    <PrimaryButton class="mt-6" @click="openModal()">
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
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
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
                                    <Link :href="route('customers.show', customer.id)" class="flex items-center gap-3 group">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs shrink-0">
                                            {{ customer.first_name.charAt(0).toUpperCase() }}{{ customer.last_name.charAt(0).toUpperCase() }}
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition">
                                            {{ customer.first_name }} {{ customer.last_name }}
                                        </p>
                                    </Link>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a :href="`mailto:${customer.email}`"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline">
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

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Edit -->
                                        <button
                                            @click="openModal(customer)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm transition hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- Delete -->
                                        <button
                                            @click="openDeleteConfirm(customer)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm transition hover:border-red-300 hover:text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Create / edit modal -->
        <CustomerModal
            :show="showModal"
            :customer="selectedCustomer"
            @close="closeModal"
        />

        <!-- Delete confirmation modal -->
        <ConfirmModal
            :show="showConfirmModal"
            title="Delete customer"
            :message="customerToDelete ? `Are you sure you want to delete ${customerToDelete.first_name} ${customerToDelete.last_name}? This action cannot be undone.` : ''"
            confirm-label="Delete"
            :processing="deleteForm.processing"
            @confirm="confirmDelete"
            @close="closeDeleteConfirm"
        />
    </AuthenticatedLayout>
</template>
