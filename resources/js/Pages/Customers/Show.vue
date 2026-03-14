<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerModal from '@/Components/CustomerModal.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: { AuthenticatedLayout, Head, Link, CustomerModal, ConfirmModal, PrimaryButton },

    props: {
        customer: {
            type: Object,
            required: true,
        },
    },

    setup() {
        const deleteForm = useForm({});
        return { deleteForm };
    },

    data() {
        return {
            showEditModal: false,
            showConfirmModal: false,
        };
    },

    computed: {
        fullName() {
            return `${this.customer.first_name} ${this.customer.last_name}`;
        },

        initials() {
            return `${this.customer.first_name.charAt(0)}${this.customer.last_name.charAt(0)}`.toUpperCase();
        },

        memberSince() {
            return new Date(this.customer.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            });
        },
    },

    methods: {
        confirmDelete() {
            // After deletion the controller redirects to dashboard
            this.deleteForm.delete(route('customers.destroy', this.customer.id), {
                onSuccess: () => {
                    this.showConfirmModal = false;
                },
            });
        },
    },
};
</script>

<template>
    <Head :title="fullName" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <!-- Back link + title -->
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 transition"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Customers
                    </Link>
                    <span class="text-gray-300">/</span>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ fullName }}
                    </h2>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <!-- Delete button -->
                    <button
                        @click="showConfirmModal = true"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-600 shadow-sm transition hover:border-red-300 hover:text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>

                    <!-- Edit button -->
                    <PrimaryButton @click="showEditModal = true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Customer
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">

                <!-- Profile card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">

                    <!-- Card header with avatar -->
                    <div class="px-6 py-6 flex items-center gap-5 border-b border-gray-100">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl shrink-0">
                            {{ initials }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ fullName }}</h3>
                            <p v-if="customer.company" class="mt-0.5 text-sm text-gray-500">{{ customer.company }}</p>
                            <p class="mt-1 text-xs text-gray-400">Member since {{ memberSince }}</p>
                        </div>
                    </div>

                    <!-- Contact details grid -->
                    <div class="divide-y divide-gray-100">

                        <!-- Email -->
                        <div class="px-6 py-4 flex items-start gap-4 sm:grid sm:grid-cols-3">
                            <div class="flex items-center gap-2 text-sm font-medium text-gray-500 sm:col-span-1">
                                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email
                            </div>
                            <div class="sm:col-span-2">
                                <a :href="`mailto:${customer.email}`"
                                    class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline">
                                    {{ customer.email }}
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="px-6 py-4 flex items-start gap-4 sm:grid sm:grid-cols-3">
                            <div class="flex items-center gap-2 text-sm font-medium text-gray-500 sm:col-span-1">
                                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Phone
                            </div>
                            <div class="sm:col-span-2">
                                <span v-if="customer.phone" class="text-sm text-gray-800">{{ customer.phone }}</span>
                                <span v-else class="text-sm text-gray-400">Not provided</span>
                            </div>
                        </div>

                        <!-- Company -->
                        <div class="px-6 py-4 flex items-start gap-4 sm:grid sm:grid-cols-3">
                            <div class="flex items-center gap-2 text-sm font-medium text-gray-500 sm:col-span-1">
                                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Company
                            </div>
                            <div class="sm:col-span-2">
                                <span v-if="customer.company" class="text-sm text-gray-800">{{ customer.company }}</span>
                                <span v-else class="text-sm text-gray-400">Not provided</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Notes card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-700">Notes</h4>
                    </div>
                    <div class="px-6 py-4">
                        <p v-if="customer.notes" class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ customer.notes }}
                        </p>
                        <p v-else class="text-sm text-gray-400 italic">
                            No notes for this customer.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Edit modal -->
        <CustomerModal
            :show="showEditModal"
            :customer="customer"
            @close="showEditModal = false"
        />

        <!-- Delete confirmation modal -->
        <ConfirmModal
            :show="showConfirmModal"
            title="Delete customer"
            :message="`Are you sure you want to delete ${fullName}? This action cannot be undone.`"
            confirm-label="Delete"
            :processing="deleteForm.processing"
            @confirm="confirmDelete"
            @close="showConfirmModal = false"
        />
    </AuthenticatedLayout>
</template>
