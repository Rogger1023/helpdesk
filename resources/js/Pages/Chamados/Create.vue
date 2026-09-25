<script setup>
import { Link,useForm } from '@inertiajs/vue3';
import ChamadoForm from '../../Components/Chamados/ChamadoForm.vue';
import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
    responsaveis: Array,
});

const form = useForm({
    titulo: '',
    descricao: '',
    prioridade: 'baixa',
    atribuicao: 'manual',
    responsavel_id: '',
});

const submit = () => {
    form.post('/chamados');
};
</script>
<template>
    <AppLayout>
        <h1>Abrir chamado</h1>

        <form @submit.prevent="submit">
            <ChamadoForm
                :form="form"
                :responsaveis="responsaveis"
            />

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2 text-white hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                >
                    {{ form.processing ? 'Abrindo...' : 'Abrir chamado' }}
                </button>

                <Link
                    href="/chamados"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-gray-700 hover:bg-gray-50 sm:w-auto"
                >
                    Cancelar
                </Link>
            </div>
        </form>
    </AppLayout>
</template>