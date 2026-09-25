<script setup>
import { Link, useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import ChamadoForm from '../../Components/Chamados/ChamadoForm.vue';

const props = defineProps({
    chamado: Object,
    responsaveis: Array,
});

const form = useForm({
    titulo: props.chamado.titulo,
    descricao: props.chamado.descricao,
    prioridade: props.chamado.prioridade,
    status: props.chamado.status,
    responsavel_id: props.chamado.responsavel_id,
});

const submit = () => {
    form.put(`/chamados/${props.chamado.id}`);
};
</script>

<template>
    <AppLayout>
        <div class="mb-6">
            <Link
                :href="`/chamados/${chamado.id}`"
                class="text-sm text-gray-600 hover:text-gray-900 hover:underline"
            >
                ← Voltar para o chamado
            </Link>

            <h1 class="mt-3 text-3xl font-bold text-gray-900">
                Editar chamado #{{ chamado.id }}
            </h1>

            <p class="mt-1 text-gray-600">
                Altere as informações do chamado.
            </p>
        </div>

        <div class="max-w-3xl rounded-lg border border-gray-200 bg-white p-6">
            <form @submit.prevent="submit">
                <ChamadoForm
                    :form="form"
                    :responsaveis="responsaveis"
                    :edicao="true"
                />

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-lg bg-gray-900 px-4 py-2 text-white hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                    >
                        {{ form.processing ? 'Salvando...' : 'Salvar alterações' }}
                    </button>

                    <Link
                        href="/chamados"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-gray-700 hover:bg-gray-50 sm:w-auto"
                    >
                        Cancelar
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>