<script>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: { Modal, PrimaryButton, SecondaryButton },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        /**
         * When provided the modal operates in edit mode;
         * when null it operates in create mode.
         */
        customer: {
            type: Object,
            default: null,
        },
    },

    emits: ['close'],

    setup() {
        const form = useForm({
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            company: '',
            notes: '',
        });

        return { form };
    },

    data() {
        return {
            /**
             * Local snapshot of the customer, set only when the modal opens.
             * We intentionally do NOT clear it on close so the template stays
             * in the same mode (edit/create) during the closing animation,
             * avoiding the visual flicker where the title switches prematurely.
             */
            localCustomer: null,
        };
    },

    computed: {
        isEditing() {
            return this.localCustomer !== null;
        },

        title() {
            return this.isEditing ? 'Edit Customer' : 'Add New Customer';
        },

        subtitle() {
            return this.isEditing
                ? 'Update the details for this customer.'
                : 'Fill in the details to register a new customer.';
        },

        submitLabel() {
            return this.isEditing ? 'Save Changes' : 'Save Customer';
        },
    },

    watch: {
        /**
         * Initialize the form only when the modal opens (show becomes true).
         * Ignoring the closing transition prevents the title from switching
         * from "Edit" to "Add New" while the modal is still animating out.
         */
        show(value) {
            if (!value) return;

            this.localCustomer = this.customer;

            if (this.customer) {
                this.form.first_name = this.customer.first_name;
                this.form.last_name  = this.customer.last_name;
                this.form.email      = this.customer.email;
                this.form.phone      = this.customer.phone ?? '';
                this.form.company    = this.customer.company ?? '';
                this.form.notes      = this.customer.notes ?? '';
            } else {
                this.form.reset();
                this.form.clearErrors();
            }
        },
    },

    methods: {
        submit() {
            if (this.isEditing) {
                this.form.patch(route('customers.update', this.localCustomer.id), {
                    onSuccess: () => this.closeModal(),
                });
            } else {
                this.form.post(route('customers.store'), {
                    onSuccess: () => this.closeModal(),
                });
            }
        },

        closeModal() {
            this.$emit('close');
            // Reset only after emitting so the parent starts the close animation
            // while the form still shows the correct data.
            // localCustomer is left as-is and will be overwritten on next open.
            this.form.reset();
            this.form.clearErrors();
        },
    },
};
</script>

<template>
    <Modal :show="show" max-width="2xl" @close="closeModal">
        <div class="p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ title }}</h2>
                    <p class="mt-0.5 text-sm text-gray-500">{{ subtitle }}</p>
                </div>
                <button @click="closeModal"
                    class="rounded-md p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-5">

                <!-- First name + Last name -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                            First name <span class="text-red-500">*</span>
                        </label>
                        <input id="first_name" v-model="form.first_name" type="text" autocomplete="given-name"
                            placeholder="John"
                            class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            :class="form.errors.first_name ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                        <p v-if="form.errors.first_name" class="mt-1 text-xs text-red-600">
                            {{ form.errors.first_name }}
                        </p>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Last name <span class="text-red-500">*</span>
                        </label>
                        <input id="last_name" v-model="form.last_name" type="text" autocomplete="family-name"
                            placeholder="Doe"
                            class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            :class="form.errors.last_name ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                        <p v-if="form.errors.last_name" class="mt-1 text-xs text-red-600">
                            {{ form.errors.last_name }}
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" v-model="form.email" type="email" autocomplete="email"
                        placeholder="john.doe@company.com"
                        class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        :class="form.errors.email ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Phone + Company -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone
                        </label>
                        <input id="phone" v-model="form.phone" type="text" autocomplete="tel"
                            placeholder="+1 234 567 890"
                            class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            :class="form.errors.phone ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                        <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">
                            {{ form.errors.phone }}
                        </p>
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-1">
                            Company
                        </label>
                        <input id="company" v-model="form.company" type="text" autocomplete="organization"
                            placeholder="Acme Inc."
                            class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            :class="form.errors.company ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                        <p v-if="form.errors.company" class="mt-1 text-xs text-red-600">
                            {{ form.errors.company }}
                        </p>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes
                    </label>
                    <textarea id="notes" v-model="form.notes" rows="3"
                        placeholder="Any relevant notes about this customer..."
                        class="block w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                        :class="form.errors.notes ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                    <p v-if="form.errors.notes" class="mt-1 text-xs text-red-600">
                        {{ form.errors.notes }}
                    </p>
                </div>

                <!-- Footer actions -->
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                    <SecondaryButton type="button" @click="closeModal">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton type="submit" :disabled="form.processing">
                        <svg v-if="form.processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        {{ form.processing ? 'Saving...' : submitLabel }}
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </Modal>
</template>
