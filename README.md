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

Em Windows, é recomendado utilizar WSL2.

PHP e Composer instalados diretamente na máquina são opcionais, pois as dependências também podem ser instaladas utilizando Docker.

## Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/Rogger1023/helpdesk.git
```

Entre na pasta:

```bash
cd helpdesk
```

### 2. Instalar as dependências PHP

Caso PHP e Composer estejam instalados na máquina:

```bash
composer install
```

Caso não estejam instalados, é possível utilizar a imagem oficial do Composer através do Docker:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD":/app \
    -w /app \
    composer:2 \
    composer install
```

Após a instalação, o Laravel Sail estará disponível em:

```text
vendor/bin/sail
```

### 3. Criar o arquivo de ambiente

```bash
cp .env.example .env
```

A configuração padrão utiliza MySQL através do Docker:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. Iniciar os containers

```bash
./vendor/bin/sail up -d
```

Confira o estado dos containers:

```bash
./vendor/bin/sail ps
```

> Na primeira inicialização, o MySQL pode levar alguns instantes para criar o banco e ficar disponível.
>
> Caso um comando como `artisan migrate` retorne temporariamente `Connection refused`, aguarde o container MySQL ficar saudável e execute o comando novamente.

### 5. Gerar a chave da aplicação

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Executar as migrations

```bash
./vendor/bin/sail artisan migrate
```

### 7. Criar os responsáveis iniciais

```bash
./vendor/bin/sail artisan db:seed --class=ResponsavelSeeder
```

O Seeder cria três responsáveis iniciais para utilização no sistema.

### 8. Instalar as dependências do frontend

```bash
./vendor/bin/sail npm install
```

### 9. Iniciar o Vite

```bash
./vendor/bin/sail npm run dev
```

A aplicação poderá ser acessada em:

```text
http://localhost
```

A listagem de chamados está disponível em:

```text
http://localhost/chamados
```

## Possível conflito com a porta do MySQL

Por padrão, o MySQL é exposto na porta `3306`.

Caso essa porta já esteja sendo utilizada pela máquina host, altere no `.env`:

```env
FORWARD_DB_PORT=3307
```

A comunicação interna entre Laravel e MySQL continua utilizando:

```env
DB_HOST=mysql
DB_PORT=3306
```

Ou seja, `DB_PORT` não precisa ser alterado.

## Testes

Para executar todos os testes automatizados:

```bash
./vendor/bin/sail artisan test
```

Os testes cobrem cenários como:

- Criação manual de chamado
- Validação de título obrigatório
- Rejeição de responsável inexistente
- Status inicial `aberto`
- Distribuição para o responsável com menor quantidade de chamados ativos
- Chamados concluídos fora da contagem da distribuição

## Build de produção

Para gerar os arquivos finais do frontend:

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

database/
├── migrations/
└── seeders/

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
- Interface responsiva utilizando Tailwind CSS

O objetivo foi priorizar clareza, manutenção e funcionamento das regras de negócio sem adicionar complexidade desnecessária.