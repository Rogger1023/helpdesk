<script setup>
import { Link, useForm } from '@inertiajs/vue3';

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
    <main>
        <h1>Editar chamado #{{ chamado.id }}</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="titulo">Título</label>
                <input id="titulo" v-model="form.titulo" type="text">
                <p v-if="form.errors.titulo">
                    {{ form.errors.titulo }}
                </p>
            </div>
            <div>
                <label for="descricao">Descrição</label>
                <textarea id="descricao" v-model="form.descricao"></textarea>
                <p v-if="form.errors.descricao">
                    {{ form.errors.descricao }}
                </p>
            </div>
            <div>
                <label for="prioridade">Prioridade</label>
                <select v-model="form.prioridade" id="prioridade">
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
                <p v-if="form.errors.prioridade">
                    {{ form.errors.prioridade }}
                </p>
            </div>
            <div>
                <label for="status">Status</label>
                <select v-model="form.status" id="status">
                    <option value="aberto">Aberto</option>
                    <option value="em_andamento">Em andamento</option>
                    <option value="resolvido">Resolvido</option>
                    <option value="fechado">Fechado</option>
                </select>
            </div>
            <div>
                <label for="responsavel">Responsável</label>
                <select v-model="form.responsavel_id" id="responsavel">
                    <option 
                    v-for="responsavel in responsaveis"
                    :key="responsavel.id"
                    :value="responsavel.id"
                    >
                        {{ responsavel.nome }}
                    </option>
                </select>
                 <p v-if="form.errors.responsavel_id">
                    {{ form.errors.responsavel_id }}
                </p>
            </div>
            <button type="submit" 
            :disabled="form.processing">
                Salvar alterações
            </button>
        </form>
        <Link :href="`/chamados/${chamado.id}`">
            Cancelar
        </Link>
    </main>
</template>