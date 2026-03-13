<script>
export default {};
</script>

<template>
    <div class="flex min-h-screen">
        <!-- Left panel: branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-900 flex-col justify-between p-12">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-indigo-500 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg tracking-tight">Customer Manager</span>
            </div>

            <div>
                <blockquote class="text-gray-300 text-xl font-light leading-relaxed">
                    "Manage your customers simply, quickly and professionally."
                </blockquote>
                <div class="mt-8 flex items-center gap-4">
                    <div class="flex -space-x-2">
                        <div class="h-8 w-8 rounded-full bg-indigo-400 border-2 border-gray-900"></div>
                        <div class="h-8 w-8 rounded-full bg-purple-400 border-2 border-gray-900"></div>
                        <div class="h-8 w-8 rounded-full bg-pink-400 border-2 border-gray-900"></div>
                    </div>
                    <p class="text-gray-400 text-sm">Used by teams of every size</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-white text-2xl font-bold">99%</p>
                    <p class="text-gray-400 text-xs mt-1">Guaranteed uptime</p>
                </div>
                <div>
                    <p class="text-white text-2xl font-bold">10k+</p>
                    <p class="text-gray-400 text-xs mt-1">Customers managed</p>
                </div>
                <div>
                    <p class="text-white text-2xl font-bold">24/7</p>
                    <p class="text-gray-400 text-xs mt-1">Active support</p>
                </div>
            </div>
        </div>

        <!-- Right panel: form -->
        <div class="flex w-full lg:w-1/2 flex-col px-8 sm:px-16 lg:px-24 bg-white">
            <!-- Top-right slot (e.g. Register link) -->
            <div class="flex justify-end pt-6">
                <slot name="topRight" />
            </div>

            <div class="mx-auto w-full max-w-md my-auto">
                <!-- Mobile logo -->
                <div class="flex items-center gap-2 mb-10 lg:hidden">
                    <div class="h-8 w-8 rounded-lg bg-indigo-500 flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800 text-base">Customer Manager</span>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
