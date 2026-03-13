<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: { GuestLayout, Head, Link },

    props: {
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    },

    setup() {
        const form = useForm({
            email: '',
            password: '',
            remember: false,
        });

        return { form };
    },

    methods: {
        submit() {
            this.form.post(route('login'), {
                onFinish: () => this.form.reset('password'),
            });
        },
    },
};
</script>

<template>
    <GuestLayout>
        <template #topRight>
            <span class="text-sm text-gray-500">First time here?</span>
            <Link :href="route('register')"
                class="ml-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition">
                Register
            </Link>
        </template>

        <Head title="Log in" />

        <div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
            <p class="mt-1 text-sm text-gray-500">Enter your credentials to access your account</p>
        </div>

        <!-- Status message (e.g. after password reset) -->
        <div v-if="status" class="mt-4 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="mt-8 space-y-5">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input id="email" v-model="form.email" type="email" required autofocus autocomplete="username"
                    placeholder="name@company.com"
                    class="block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :class="form.errors.email ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-600">{{ form.errors.email }}</p>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                </div>
                <input id="password" v-model="form.password" type="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :class="form.errors.password ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'" />
                <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-600">{{ form.errors.password }}</p>
            </div>

            <!-- Submit -->
            <button type="submit" :disabled="form.processing"
                class="w-full flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed">
                <svg v-if="form.processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                </svg>
                {{ form.processing ? 'Signing in...' : 'Sign in' }}
            </button>
        </form>
    </GuestLayout>
</template>
