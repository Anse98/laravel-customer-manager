<script>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    components: { Modal, SecondaryButton },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: 'Confirm action',
        },
        message: {
            type: String,
            default: 'Are you sure you want to proceed? This action cannot be undone.',
        },
        confirmLabel: {
            type: String,
            default: 'Delete',
        },
        processing: {
            type: Boolean,
            default: false,
        },
    },

    emits: ['confirm', 'close'],
};
</script>

<template>
    <Modal :show="show" max-width="md" @close="$emit('close')">
        <div class="p-6">

            <!-- Icon + title -->
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">{{ title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ message }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-end gap-3">
                <SecondaryButton type="button" @click="$emit('close')">
                    Cancel
                </SecondaryButton>
                <button
                    type="button"
                    :disabled="processing"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    @click="$emit('confirm')"
                >
                    <svg v-if="processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    {{ processing ? 'Deleting...' : confirmLabel }}
                </button>
            </div>

        </div>
    </Modal>
</template>
