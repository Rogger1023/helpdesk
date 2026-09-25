<script setup>
import { reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    chamados: Array,
    responsaveis: Array,
    filtros: Object,
});

const form = reactive({
    busca: props.filtros.busca ?? '',
    status: props.filtros.status ?? '',
    prioridade: props.filtros.prioridade ?? '',
    responsavel_id: props.filtros.responsavel_id ?? '',
    ordem: props.filtros.ordem ?? 'novos',
});

const filtrar = () => {
    router.get('/chamados', form, {
        preserveState: true,
        replace: true,
    });
};

const limparFiltros = () => {
    router.get('/chamados');
};

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
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Chamados
                </h1>

                <p class="mt-1 text-gray-600">
                    Acompanhe e gerencie os chamados.
                </p>
            </div>

            <Link
                href="/chamados/criar"
                class="w-full rounded-lg bg-gray-900 px-4 py-2 text-center text-white hover:bg-gray-700 sm:w-auto"
            >
                Abrir chamado
            </Link>
        </div>

        
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <form
                class="grid gap-4 md:grid-cols-2 lg:grid-cols-5"
                @submit.prevent="filtrar"
            >
                
                <div>
                    <label for="busca" class="mb-1 block text-sm font-medium text-gray-700">
                        Buscar
                    </label>

                    <input
                        id="busca"
                        v-model="form.busca"
                        type="text"
                        placeholder="Título do chamado"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    >
                </div>

                
                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-gray-700">
                        Status
                    </label>

                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    >
                        <option value="">Todos</option>
                        <option value="aberto">Aberto</option>
                        <option value="em_andamento">Em andamento</option>
                        <option value="resolvido">Resolvido</option>
                        <option value="fechado">Fechado</option>
                    </select>
                </div>

                
                <div>
                    <label for="prioridade" class="mb-1 block text-sm font-medium text-gray-700">
                        Prioridade
                    </label>

                    <select
                        id="prioridade"
                        v-model="form.prioridade"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    >
                        <option value="">Todas</option>
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>

                
                <div>
                    <label for="responsavel" class="mb-1 block text-sm font-medium text-gray-700">
                        Responsável
                    </label>

                    <select
                        id="responsavel"
                        v-model="form.responsavel_id"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    >
                        <option value="">Todos</option>

                        <option
                            v-for="responsavel in responsaveis"
                            :key="responsavel.id"
                            :value="responsavel.id"
                        >
                            {{ responsavel.nome }}
                        </option>
                    </select>
                </div>

                
                <div>
                    <label for="ordem" class="mb-1 block text-sm font-medium text-gray-700">
                        Ordenar por
                    </label>

                    <select
                        id="ordem"
                        v-model="form.ordem"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    >
                        <option value="novos">Mais novos</option>
                        <option value="antigos">Mais antigos</option>
                    </select>
                </div>

                <div class="flex gap-2 md:col-span-2 lg:col-span-5">
                    <button
                        type="submit"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-white hover:bg-gray-700"
                    >
                        Filtrar
                    </button>

                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50"
                        @click="limparFiltros"
                    >
                        Limpar
                    </button>
                </div>
            </form>
        </div>

        
        <div
            v-if="chamados.length === 0"
            class="rounded-lg border border-gray-200 bg-white p-8 text-center"
        >
            <p class="text-gray-600">
                Nenhum chamado encontrado.
            </p>
        </div>

        
        <div v-else class="space-y-4">
            <div
                v-for="chamado in chamados"
                :key="chamado.id"
                class="rounded-lg border border-gray-200 bg-white p-5"
            >
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="mb-2 flex flex-wrap items-center gap-2">
                            <span class="text-sm text-gray-500">
                                #{{ chamado.id }}
                            </span>

                            
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

                        <Link
                            :href="`/chamados/${chamado.id}`"
                            class="text-lg font-semibold text-gray-900 hover:underline"
                        >
                            {{ chamado.titulo }}
                        </Link>

                        <div class="mt-2 flex flex-col gap-1 text-sm text-gray-600 sm:flex-row sm:gap-4">
                            <span>
                                Responsável:
                                <strong>{{ chamado.responsavel.nome }}</strong>
                            </span>

                            <span>
                                Aberto em:
                                {{ formatarData(chamado.aberto_em) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <Link
                            :href="`/chamados/${chamado.id}`"
                            class="text-sm font-medium text-gray-700 hover:text-black hover:underline"
                        >
                            Visualizar
                        </Link>

                        <Link
                            :href="`/chamados/${chamado.id}/editar`"
                            class="text-sm font-medium text-gray-700 hover:text-black hover:underline"
                        >
                            Editar
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>