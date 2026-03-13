<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },

    props: {
        href: {
            type: String,
            default: null,
        },
        type: {
            type: String,
            default: 'button',
        },
    },
};
</script>

<template>
    <!-- Renders as an Inertia Link when href is provided, otherwise as a button -->
    <Link v-if="href" :href="href"
        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed">
    <slot />
    </Link>

    <button v-else :type="type"
        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
