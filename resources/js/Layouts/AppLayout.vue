<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white border-b border-gray-200">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <Link
                    href="/chamados"
                    class="text-xl font-bold text-gray-900"
                >
                    Helpdesk TI
                </Link>

                <nav class="flex w-full gap-2 sm:w-auto">
                    <Link
                        href="/chamados"
                        class="flex-1 rounded-lg px-4 py-2 text-center text-gray-700 hover:bg-gray-100 hover:text-gray-900 sm:flex-none"
                    >
                        Chamados
                    </Link>

                    <Link
                        href="/chamados/criar"
                        class="flex-1 rounded-lg bg-gray-900 px-4 py-2 text-center text-white hover:bg-gray-700 sm:flex-none"
                    >
                        Novo chamado
                    </Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8">
            <slot />
        </main>
    </div>
</template>