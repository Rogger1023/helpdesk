# Helpdesk de TI

Sistema de controle e acompanhamento de chamados técnicos desenvolvido com Laravel, Vue.js, Inertia.js e MySQL.

O projeto permite cadastrar, visualizar, editar, pesquisar e filtrar chamados, além de realizar a distribuição manual ou automática entre os responsáveis disponíveis.

## Tecnologias

- PHP
- Laravel
- Vue.js 3
- Inertia.js
- MySQL
- Docker
- Laravel Sail
- Tailwind CSS
- Vite

## Funcionalidades

- Cadastro de chamados
- Edição de chamados
- Visualização de detalhes
- Listagem de chamados
- Busca por título
- Filtro por status
- Filtro por prioridade
- Filtro por responsável
- Ordenação por chamados mais novos ou mais antigos
- Atribuição manual de responsável
- Atribuição automática de responsável
- Validação dos dados
- Interface responsiva
- Testes automatizados

## Chamados

Cada chamado possui:

- Título
- Descrição
- Prioridade
- Status
- Responsável
- Data e hora de abertura

### Prioridades

Os chamados podem possuir as seguintes prioridades:

- Baixa
- Média
- Alta

### Status

Os chamados podem possuir os seguintes status:

- Aberto
- Em andamento
- Resolvido
- Fechado

Para a regra de distribuição automática, são considerados chamados ativos:

- `aberto`
- `em_andamento`

Chamados com status `resolvido` ou `fechado` não entram na contagem.

## Distribuição automática

Ao criar um chamado, o usuário pode escolher entre:

- Atribuição manual
- Atribuição automática

Na atribuição automática, o sistema seleciona o responsável que possui a menor quantidade de chamados ativos.

Em caso de empate, o responsável com o menor ID é selecionado.

A regra foi isolada no serviço:

```text
app/Services/DistribuidorChamados.php
```

Isso mantém a regra de negócio separada do Controller e facilita manutenção e testes.

## Organização do projeto

Algumas responsabilidades foram separadas para manter o código organizado.

### Models

Responsáveis pela representação e relacionamento das entidades do banco de dados.

```text
app/Models/Chamado.php
app/Models/Responsavel.php
```

### Enums

Utilizados para centralizar os valores permitidos de prioridade e status.

```text
app/Enums/PrioridadeChamado.php
app/Enums/StatusChamado.php
```

### Form Requests

As validações foram separadas dos Controllers utilizando Form Requests.

```text
app/Http/Requests/StoreChamadoRequest.php
app/Http/Requests/UpdateChamadoRequest.php
```

### Services

A regra de distribuição automática foi isolada em um Service.

```text
app/Services/DistribuidorChamados.php
```

### Componentes Vue

Os campos compartilhados entre criação e edição de chamados foram centralizados em:

```text
resources/js/Components/Chamados/ChamadoForm.vue
```

O layout principal da aplicação está em:

```text
resources/js/Layouts/AppLayout.vue
```

Essa organização reduz duplicação de código e facilita manutenção.

## Requisitos

Para executar o projeto localmente:

- Docker Desktop
- Docker Compose
- Git
- Composer

Em Windows, é recomendado utilizar WSL2.

## Instalação

Clone o repositório:

```bash
git clone https://github.com/Rogger1023/helpdesk.git
```

Entre na pasta do projeto:

```bash
cd helpdesk
```

Instale as dependências PHP:

```bash
composer install
```

Crie o arquivo de ambiente:

```bash
cp .env.example .env
```

Inicie os containers:

```bash
./vendor/bin/sail up -d
```

Gere a chave da aplicação:

```bash
./vendor/bin/sail artisan key:generate
```

Execute as migrations:

```bash
./vendor/bin/sail artisan migrate
```

Popule os responsáveis iniciais:

```bash
./vendor/bin/sail artisan db:seed --class=ResponsavelSeeder
```

Instale as dependências do frontend:

```bash
./vendor/bin/sail npm install
```

Inicie o Vite:

```bash
./vendor/bin/sail npm run dev
```

A aplicação poderá ser acessada em:

```text
http://localhost
```

## Possível conflito com a porta do MySQL

Caso a porta `3306` já esteja sendo utilizada pela máquina host, é possível alterar apenas a porta exposta pelo Docker no arquivo `.env`:

```env
FORWARD_DB_PORT=3307
```

A comunicação interna do Laravel com o container MySQL continua utilizando:

```env
DB_HOST=mysql
DB_PORT=3306
```

## Testes

Para executar todos os testes automatizados:

```bash
./vendor/bin/sail artisan test
```

Atualmente os testes verificam cenários como:

- Criação manual de chamado
- Validação de título obrigatório
- Rejeição de responsável inexistente
- Status inicial `aberto`
- Distribuição para o responsável com menor quantidade de chamados ativos
- Chamados concluídos fora da contagem da distribuição

## Build de produção

Para gerar os arquivos do frontend para produção:

```bash
./vendor/bin/sail npm run build
```

## Estrutura principal

```text
app/
├── Enums/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
└── Services/

resources/js/
├── Components/
│   └── Chamados/
├── Layouts/
└── Pages/
    └── Chamados/

tests/
└── Feature/
```

## Decisões de desenvolvimento

Durante o desenvolvimento foram utilizados alguns princípios para manter o projeto simples e organizado:

- Separação de responsabilidades
- DRY (Don't Repeat Yourself)
- Componentização no Vue
- Form Requests para validação
- Enums para valores de domínio
- Service para regras de negócio
- Eager Loading para relacionamentos
- Testes automatizados para regras importantes
- Interface responsiva com Tailwind CSS

O objetivo foi priorizar clareza, manutenção e funcionamento das regras de negócio sem adicionar complexidade desnecessária.