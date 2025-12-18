# E-Commerce com AI Chat

## 📋 Índice

- [Visão Geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
- [Como Usar](#como-usar)
- [Arquitetura](#arquitetura)
- [Contribuindo](#contribuindo)
- [Licença](#licença)


## 🎯 Visão Geral

E-Commerce com assistente virtual inteligente integrado. O projeto demonstra o uso de **Function Calling da OpenAI** para criar um chat que busca produtos em tempo real através de conversas naturais.

**Construído com Laravel 11, Vue.js 3 e OpenAI GPT-4o-mini.**


## ✨ Funcionalidades

- 🤖 **Chat AI Interativo** - Converse naturalmente com o assistente
- 🔍 **Busca Inteligente** - AI entende suas perguntas e busca produtos
- 🛍️ **Catálogo de Produtos** - Grid responsivo com produtos
- 🏗️ **Clean Architecture** - Código organizado e mantível
- 🐳 **Docker Ready** - Ambiente completo containerizado


## 🚀 Tecnologias

**Backend:**
- Laravel 11 + PHP 8.4
- PostgreSQL 16
- Redis

**Frontend:**
- Vue.js 3 + Composition API
- Vite
- Tailwind CSS

**AI:**
- OpenAI GPT-4o-mini
- Function Calling

**Infraestrutura:**
- Docker + Docker Compose
- Nginx


## 📦 Instalação

### Pré-requisitos

- Docker e Docker Compose
- Chave API da OpenAI ([obtenha aqui](https://platform.openai.com/api-keys))

### Passos

1. **Clone o repositório**

```bash
git clone https://github.com/weriston-developer/e-commer-mcp.git
cd e-commer-mcp
```

2. **Configure as variáveis de ambiente**

```bash
cp .env.example .env
```

Edite o `.env` e adicione sua chave OpenAI:

```env
OPENAI_API_KEY=sk-sua-chave-aqui
OPENAI_MODEL=gpt-4o-mini
```

**Importante:** Ajuste `UID` e `GID` no `.env` (use `id -u` e `id -g` para descobrir)

3. **Inicie os containers**

```bash
docker compose up -d
```

4. **Instale as dependências**

```bash
docker exec -it laravel-docker-examples-workspace-1 bash
composer install
npm install
npm run build
exit
```

5. **Execute as migrations**

```bash
docker exec laravel-docker-examples-workspace-1 php artisan migrate --seed
```

6. **Acesse a aplicação**

Abra: [http://localhost](http://localhost)


## 💬 Como Usar

### Exemplos de Conversas

```
Usuário: "Mostre notebooks disponíveis"
AI: Encontrei 2 notebooks... [exibe produtos]

Usuário: "Quero algo mais barato"
AI: Aqui estão opções mais econômicas... [filtra]

Usuário: "Me mostre celulares da Samsung"
AI: Encontrei estes celulares Samsung... [busca por marca]
```

### Comandos Úteis

```bash
# Parar containers
docker compose down

# Ver logs
docker compose logs -f

# Adicionar produtos via Tinker
docker exec -it laravel-docker-examples-workspace-1 php artisan tinker
```


## 🏗️ Arquitetura

O projeto segue **Clean Architecture**:

```
app/
├── Domain/              # Entidades e Interfaces
│   └── Produto/
├── Application/         # Casos de Uso
│   └── Produto/
│       └── BuscarProdutosUseCase.php
├── Infrastructure/      # Implementações
│   ├── AI/
│   │   ├── OpenAIClient.php
│   │   └── Tools/
│   │       └── BuscarProdutosTool.php
│   └── Persistence/
│       └── EloquentProdutoRepository.php
└── Http/
    └── Controllers/
        └── ChatController.php
```

### Como funciona?

1. Usuário envia mensagem → `ChatController`
2. Controller envia para `OpenAIClient`
3. OpenAI decide se precisa chamar function
4. `ToolRouter` executa tool apropriada (`BuscarProdutosTool`)
5. Tool usa `BuscarProdutosUseCase` → `ProdutoRepository`
6. Resultado volta para OpenAI que gera resposta
7. Frontend exibe resposta e produtos


## 🤝 Contribuindo

Contribuições são bem-vindas! 

1. Fork o projeto
2. Crie uma branch: `git checkout -b feature/nova-funcionalidade`
3. Commit: `git commit -m "feat: adiciona nova funcionalidade"`
4. Push: `git push origin feature/nova-funcionalidade`
5. Abra um Pull Request


## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

---

## 👨‍💻 Autor

**Planejado e desenvolvido por Weriston**

---

*Dúvidas ou problemas? Abra uma issue no GitHub!*
