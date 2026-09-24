<script setup>
import { useForm } from '@inertiajs/vue3';

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
    <main>
        <h1>Abrir chamado</h1>
        

        <form @submit.prevent="submit">

            <div>
                <label for="titulo">Título</label>

                <input
                    id="titulo"
                    v-model="form.titulo"
                    type="text"
                >
                <p v-if="form.errors.titulo">
                    {{ form.errors.titulo }}
                </p>
            </div>

            <div>
                <label for="descricao">Descrição</label>

                <textarea
                    id="descricao"
                    v-model="form.descricao"
                ></textarea>
                <p v-if="form.errors.descricao">
                    {{ form.errors.descricao }}
                </p>
            </div>

            <div>
                <label for="prioridade">Prioridade</label>

                <select
                    id="prioridade"
                    v-model="form.prioridade"
                >
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
                <p v-if="form.errors.prioridade">
                    {{ form.errors.prioridade }}
                </p>
            </div>


            <div>
                <p>Forma de atribuição</p>
                <label>
                    <input v-model="form.atribuicao" type="radio" value="manual">
                    Manual
                </label>
                <label>
                    <input v-model="form.atribuicao" type="radio" value="automatica">
                    Automática
                </label>
            </div>

            <div v-if="form.atribuicao === 'manual'">
                <label for="responsavel">
                    Responsável
                </label>

                <select
                    id="responsavel"
                    v-model="form.responsavel_id"
                >
                    <option value="">
                        Selecione
                    </option>

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
            <p v-else>
                O sistema escolherá automaticamente o responsável
                com menos chamados em aberto.
            </p>

            <button type="submit">
                Abrir chamado
            </button>
            <pre>{{ form.errors }}</pre>

        </form>
    </main>
</template>