<script>
import { router } from '@inertiajs/vue3';

export default {
    data() {
        return {
            visible: false,
            message: '',
            type: 'success',
            timer: null,
            removeListener: null,
        };
    },

    mounted() {
        /**
         * router.on('finish') fires after every completed Inertia navigation,
         * including POST/PATCH redirects. At this point $page.props is already
         * updated, making it more reliable than watching computed props.
         */
        this.removeListener = router.on('finish', () => {
            const flash = this.$page.props.flash;

            if (flash?.success) {
                this.show(flash.success, 'success');
            } else if (flash?.error) {
                this.show(flash.error, 'error');
            }
        });
    },

    unmounted() {
        // Clean up the event listener to avoid memory leaks
        if (this.removeListener) {
            this.removeListener();
        }

        clearTimeout(this.timer);
    },

    methods: {
        show(message, type = 'success') {
            clearTimeout(this.timer);
            this.message = message;
            this.type = type;
            this.visible = true;

            // Auto-dismiss after 4 seconds
            this.timer = setTimeout(() => {
                this.visible = false;
            }, 4000);
        },

        dismiss() {
            clearTimeout(this.timer);
            this.visible = false;
        },
    },
};
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="visible"
                class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-start gap-3 rounded-xl px-4 py-3.5 shadow-lg max-w-sm w-full bg-white"
                :class="type === 'success' ? 'border border-green-100' : 'border border-red-100'"
            >
                <!-- Icon -->
                <div
                    class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full"
                    :class="type === 'success' ? 'bg-green-100' : 'bg-red-100'"
                >
                    <svg v-if="type === 'success'" class="h-3.5 w-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg v-else class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <!-- Message -->
                <p class="text-sm font-medium text-gray-800 leading-snug flex-1">{{ message }}</p>

                <!-- Dismiss -->
                <button
                    @click="dismiss"
                    class="ml-1 shrink-0 rounded p-0.5 text-gray-400 hover:text-gray-600 transition focus:outline-none"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </Transition>
    </Teleport>
</template>
