<script setup>
import { Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

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
        <h1>Chamados</h1>

        <p>
            <Link href="/chamados/criar">
                Abrir novo chamado
            </Link>
        </p>

        <form @submit.prevent="filtrar">
            <div>
                <label for="busca">
                    Buscar
                </label>

                <input
                    id="busca"
                    v-model="form.busca"
                    type="text"
                    placeholder="Título do chamado"
                >
            </div>

            <div>
                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    v-model="form.status"
                >
                    <option value="">
                        Todos
                    </option>

                    <option value="aberto">
                        Aberto
                    </option>

                    <option value="em_andamento">
                        Em andamento
                    </option>

                    <option value="resolvido">
                        Resolvido
                    </option>

                    <option value="fechado">
                        Fechado
                    </option>
                </select>
            </div>

            <div>
                <label for="prioridade">
                    Prioridade
                </label>

                <select
                    id="prioridade"
                    v-model="form.prioridade"
                >
                    <option value="">
                        Todas
                    </option>

                    <option value="baixa">
                        Baixa
                    </option>

                    <option value="media">
                        Média
                    </option>

                    <option value="alta">
                        Alta
                    </option>
                </select>
            </div>

            <div>
                <label for="responsavel">
                    Responsável
                </label>

                <select
                    id="responsavel"
                    v-model="form.responsavel_id"
                >
                    <option value="">
                        Todos
                    </option>

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
                <label for="ordem">
                    Ordenar por:
                </label>

                <select
                    id="ordem"
                    v-model="form.ordem"
                >
                    <option value="novos">
                        Mais novos
                    </option>

                    <option value="antigos">
                        Mais antigos
                    </option>
                </select>
            </div>

            <button type="submit">
                Filtrar
            </button>

            <button
                type="button"
                @click="limparFiltros"
            >
                Limpar
            </button>
        </form>

        <p v-if="chamados.length === 0">
            Nenhum chamado encontrado.
        </p>

        <table v-else>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Responsável</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="chamado in chamados"
                    :key="chamado.id"
                >
                    <td>
                        {{ chamado.id }}
                    </td>

                    <td>
                        {{ chamado.titulo }}
                    </td>

                    <td>
                        {{ formatarPrioridade(chamado.prioridade) }}
                    </td>

                    <td>
                        {{ formatarStatus(chamado.status) }}
                    </td>

                    <td>
                        {{ chamado.responsavel.nome }}
                    </td>

                    <td>
                        <Link :href="`/chamados/${chamado.id}`">
                            Visualizar
                        </Link>

                        <Link :href="`/chamados/${chamado.id}/editar`">
                            Editar
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</template>