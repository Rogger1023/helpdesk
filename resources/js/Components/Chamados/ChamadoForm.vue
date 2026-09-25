<script setup>
defineProps({
    form: Object,

    responsaveis: Array,

    edicao: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="space-y-5">
        <div>
            <label for="titulo" class="mb-1 block text-sm font-medium text-gray-700">
                Título
            </label>

            <input
                id="titulo"
                v-model="form.titulo"
                type="text"
                placeholder="Ex: Computador sem acesso à internet"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-gray-500 focus:outline-none"
            >

            <p v-if="form.errors.titulo" class="mt-1 text-sm text-red-600">
                {{ form.errors.titulo }}
            </p>
        </div>
        <div>
            <label for="descricao" class="mb-1 block text-sm font-medium text-gray-700">
                Descrição
            </label>

            <textarea
                id="descricao"
                v-model="form.descricao"
                rows="5"
                placeholder="Descreva o problema..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-gray-500 focus:outline-none"
            ></textarea>

            <p v-if="form.errors.descricao" class="mt-1 text-sm text-red-600">
                {{ form.errors.descricao }}
            </p>
        </div>
        <div>
            <label for="prioridade" class="mb-1 block text-sm font-medium text-gray-700">
                Prioridade
            </label>

            <select
                id="prioridade"
                v-model="form.prioridade"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-gray-500 focus:outline-none"
            >
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

            <p v-if="form.errors.prioridade" class="mt-1 text-sm text-red-600">
                {{ form.errors.prioridade }}
            </p>
        </div>
        <div v-if="edicao">
            <label for="status" class="mb-1 block text-sm font-medium text-gray-700">
                Status
            </label>

            <select
                id="status"
                v-model="form.status"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-gray-500 focus:outline-none"
            >
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

            <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">
                {{ form.errors.status }}
            </p>
        </div>
        <div v-if="!edicao">
            <p class="mb-2 block text-sm font-medium text-gray-700">
                Forma de atribuição
            </p>

            <div class="flex gap-6">
                <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                    <input
                        v-model="form.atribuicao"
                        type="radio"
                        value="manual"
                    >

                    Manual
                </label>

                <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                    <input
                        v-model="form.atribuicao"
                        type="radio"
                        value="automatica"
                    >

                    Automática
                </label>
            </div>

            <p v-if="form.errors.atribuicao" class="mt-1 text-sm text-red-600">
                {{ form.errors.atribuicao }}
            </p>
        </div>

        <div v-if="edicao || form.atribuicao === 'manual'">
            <label for="responsavel" class="mb-1 block text-sm font-medium text-gray-700">
                Responsável
            </label>

            <select
                id="responsavel"
                v-model="form.responsavel_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-gray-500 focus:outline-none"
            >
                <option v-if="!edicao" value="">
                    Selecione um responsável
                </option>

                <option
                    v-for="responsavel in responsaveis"
                    :key="responsavel.id"
                    :value="responsavel.id"
                >
                    {{ responsavel.nome }}
                </option>
            </select>

            <p v-if="form.errors.responsavel_id" class="mt-1 text-sm text-red-600">
                {{ form.errors.responsavel_id }}
            </p>
        </div>
        <div
            v-if="!edicao && form.atribuicao === 'automatica'"
            class="rounded-lg border border-gray-200 bg-gray-50 p-4"
        >
            <p class="text-sm text-gray-600">
                O sistema escolherá automaticamente o responsável com menos chamados ainda não concluídos.
            </p>
        </div>
    </div>
</template>