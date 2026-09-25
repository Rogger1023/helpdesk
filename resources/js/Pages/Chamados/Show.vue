<script setup>
import { Link } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
    chamado: Object,
});

const formatarPrioridade = (prioridade) => {
    const prioridades = {
        baixa: 'Baixa',
        media: 'Média',
        alta: 'Alta',
    };

    return prioridades[prioridade] ?? prioridade;
};

const classePrioridade = (prioridade) => {
    const classes = {
        baixa: 'bg-green-100 text-green-700',
        media: 'bg-yellow-100 text-yellow-700',
        alta: 'bg-red-100 text-red-700',
    };

    return classes[prioridade] ?? 'bg-gray-100 text-gray-700';
};

const formatarStatus = (status) => {
    const statusDisponiveis = {
        aberto: 'Aberto',
        em_andamento: 'Em andamento',
        resolvido: 'Resolvido',
        fechado: 'Fechado',
    };

    return statusDisponiveis[status] ?? status;
};

const classeStatus = (status) => {
    const classes = {
        aberto: 'bg-blue-100 text-blue-700',
        em_andamento: 'bg-yellow-100 text-yellow-700',
        resolvido: 'bg-green-100 text-green-700',
        fechado: 'bg-gray-100 text-gray-700',
    };

    return classes[status] ?? 'bg-gray-100 text-gray-700';
};

const formatarData = (data) => {
    if (!data) {
        return '-';
    }

    return new Date(data).toLocaleString('pt-BR');
};
</script>

<template>
    <AppLayout>
        <div class="mb-6">
            <Link
                href="/chamados"
                class="text-sm text-gray-600 hover:text-gray-900 hover:underline"
            >
                ← Voltar para chamados
            </Link>

            <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-2 flex flex-wrap items-center gap-2">
                        <span
                            :class="classePrioridade(chamado.prioridade)"
                            class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                        >
                            {{ formatarPrioridade(chamado.prioridade) }}
                        </span>

                        <span
                            :class="classeStatus(chamado.status)"
                            class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                        >
                            {{ formatarStatus(chamado.status) }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900">
                        Chamado #{{ chamado.id }}
                    </h1>

                    <p class="mt-1 text-gray-600">
                        Visualize os detalhes do chamado.
                    </p>
                </div>

                <Link
                    :href="`/chamados/${chamado.id}/editar`"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-center text-white hover:bg-gray-700"
                >
                    Editar chamado
                </Link>
            </div>
        </div>

        <div class="max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white">
            <div class="border-b border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">
                    Título
                </p>

                <h2 class="mt-1 text-xl font-semibold text-gray-900">
                    {{ chamado.titulo }}
                </h2>
            </div>

            <div class="border-b border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">
                    Descrição
                </p>

                <p class="mt-2 whitespace-pre-line text-gray-800">
                    {{ chamado.descricao }}
                </p>
            </div>

            <div class="grid gap-6 p-6 md:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Prioridade
                    </p>

                    <span
                        :class="classePrioridade(chamado.prioridade)"
                        class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                    >
                        {{ formatarPrioridade(chamado.prioridade) }}
                    </span>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Status
                    </p>

                    <span
                        :class="classeStatus(chamado.status)"
                        class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                    >
                        {{ formatarStatus(chamado.status) }}
                    </span>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Responsável
                    </p>

                    <p class="mt-1 text-gray-900">
                        {{ chamado.responsavel.nome }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        E-mail do responsável
                    </p>

                    <p class="mt-1 text-gray-900">
                        {{ chamado.responsavel.email }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Aberto em
                    </p>

                    <p class="mt-1 text-gray-900">
                        {{ formatarData(chamado.aberto_em) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
            <Link
                :href="`/chamados/${chamado.id}/editar`"
                class="w-full rounded-lg bg-gray-900 px-4 py-2 text-white hover:bg-gray-700  text-center sm:w-auto"
            >
                Editar
            </Link>

            <Link
                href="/chamados"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50  text-center sm:w-auto"
            >
                Voltar
            </Link>
        </div>
    </AppLayout>
</template>