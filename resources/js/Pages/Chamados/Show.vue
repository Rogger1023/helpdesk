<script setup>
import { Link } from '@inertiajs/vue3';

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

const formatarStatus = (status) => {
    const statusDisponiveis = {
        aberto: 'Aberto',
        em_andamento: 'Em andamento',
        resolvido: 'Resolvido',
        fechado: 'Fechado',
    };

    return statusDisponiveis[status] ?? status;
};
</script>

<template>
    <main>
        <h1>Chamado #{{ chamado.id }}</h1>

        <p>
            <strong>Título:</strong>
            {{ chamado.titulo }}
        </p>

        <p>
            <strong>Descrição:</strong>
            {{ chamado.descricao }}
        </p>

        <p>
            <strong>Prioridade:</strong>
            {{ formatarPrioridade(chamado.prioridade) }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ formatarStatus(chamado.status) }}
        </p>

        <p>
            <strong>Responsável:</strong>
            {{ chamado.responsavel.nome }}
        </p>

        <p>
            <strong>Email: </strong>
            {{ chamado.responsavel.email }}
        </p>

        <p>
            <strong>Aberto em:</strong>
            {{ chamado.aberto_em }}
        </p>

        <Link href="/chamados">
            Voltar para chamados
        </Link>
        <Link :href="`/chamados/${chamado.id}/editar`">
            Editar chamado
        </Link>
    </main>
</template>