<script setup>
    import { Link } from '@inertiajs/vue3';
    
    defineProps({
        chamados: Array,
    });
    const formatarPrioridade = (prioridade)=>{
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
    }

</script>

<template>
    <main>
        <h1>Chamados</h1>

        <p>
            <Link href="/chamados/criar">
                Abrir novo chamado
            </Link>
        </p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Aberto em </th>
                    <th>Responsável</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="chamado in chamados"
                    :key="chamado.id"
                >
                    <td>{{ chamado.id }}</td>
                    <td>
                        <Link :href="`/chamados/${chamado.id}`">
                            {{ chamado.titulo }}
                        </Link>
                    </td>
                    <td>{{formatarPrioridade( chamado.prioridade )}}</td>
                    <td>{{formatarStatus( chamado.status )}}</td>
                    <td>{{ chamado.aberto_em }}</td>
                    <td>{{ chamado.responsavel.nome }}</td>
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