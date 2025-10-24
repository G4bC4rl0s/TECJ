# TECJ - Plataforma de Conexões Profissionais

Sistema web para candidaturas a empresas e networking profissional desenvolvido em PHP puro com MySQL.

## Descrição

O TECJ é uma plataforma de conexões profissionais que permite aos usuários visualizar empresas disponíveis, candidatar-se a vagas, acompanhar o status de suas candidaturas e visualizar um feed de atividades da plataforma. O sistema oferece uma interface moderna e responsiva com funcionalidades completas de autenticação e gerenciamento de candidaturas.

## Integrantes

- Pedro Alves - 22300341
- Gabriel Carlos - 12300551
- Raphael Giannese - 22301143
- Valleska Sousa - 12301469
- Marcelo Bernardez - 22300805
- Renganeschi Rodrigues - 22301780

## Estrutura de Diretórios

```
PIT/
├── public/                    # Arquivos públicos da aplicação
│   ├── actions/              # Ações do sistema
│   │   └── candidatar.php    # Processamento de candidaturas
│   ├── css/                  # Estilos CSS
│   │   └── style.css         # Folha de estilos principal
│   ├── js/                   # Scripts JavaScript
│   │   └── empresas.js       # Funcionalidades das empresas
│   ├── pages/                # Páginas do sistema
│   │   ├── candidaturas.php  # Página de candidaturas
│   │   ├── empresas.php      # Página de empresas
│   │   └── home.php          # Página inicial
│   ├── index.php             # Arquivo principal (versão simples)
│   ├── tecj.php              # Aplicação principal completa
│   ├── auth.php              # Sistema de autenticação
│   ├── app.php               # Versão alternativa da aplicação
│   ├── logout.php            # Logout do sistema
│   ├── data_*.json           # Arquivos de dados JSON
│   └── .htaccess             # Configurações do Apache
├── database/                 # Scripts do banco de dados
│   └── setup.sql             # Script de criação do banco
├── resources/                # Recursos da aplicação
│   └── views/                # Templates de visualização
├── storage/                  # Armazenamento de arquivos
└── README.md                 # Este arquivo
```

## Como Executar o Projeto

### 1. Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx) ou XAMPP/WAMP/LARAGON
- Extensões PHP: PDO, PDO_MySQL

### 2. Instalação

```bash
# Clone o repositório
git clone https://github.com/usuario/tecj.git

# Acesse a pasta do projeto
cd tecj/PIT

# Configure o banco de dados executando o script SQL
mysql -u root -p < database/setup.sql
```

### 3. Configuração

Edite os arquivos `public/index.php`, `public/tecj.php` ou `public/app.php` e ajuste as configurações do banco:

```php
$host = 'localhost';
$dbname = 'professional_network';
$username = 'root';
$password = 'sua_senha';
```

### 4. Execução

#### Usando XAMPP/WAMP/LARAGON:
1. Copie a pasta do projeto para `htdocs`
2. Acesse `http://localhost/tecj/PIT/public/tecj.php`

#### Usando servidor PHP built-in:
```bash
cd public
php -S localhost:8000
```

### 5. Acesso

- **URL principal**: http://localhost/tecj/PIT/public/tecj.php
- **Usuário padrão**: admin@tecj.com
- **Senha padrão**: 123456

---

## Checklist das 20 Funcionalidades

1. ✅ **Sistema de Autenticação** - Login e cadastro de usuários
2. ✅ **Visualização de Empresas** - Lista todas as empresas disponíveis
3. ✅ **Candidatura a Empresas** - Permite candidatar-se com um clique
4. ✅ **Prevenção de Candidaturas Duplicadas** - Evita múltiplas candidaturas
5. ✅ **Visualização de Candidaturas** - Mostra todas as candidaturas do usuário
6. ✅ **Status das Candidaturas** - Pendente, Aceita, Rejeitada
7. ✅ **Feed de Atividades** - Timeline de atividades da plataforma
8. ✅ **Vagas que Sigo** - Acompanhamento de candidaturas pendentes
9. ✅ **Interface Responsiva** - Funciona em desktop, tablet e mobile
10. ✅ **Animações e Efeitos Visuais** - Transições suaves e feedback visual
11. ✅ **Armazenamento em Banco de Dados** - MySQL com PDO
12. ✅ **Armazenamento em Arquivos JSON** - Sistema alternativo de dados
13. ✅ **Validação de Dados** - Sanitização e validação no servidor
14. ✅ **Segurança contra SQL Injection** - Prepared statements
15. ✅ **Sistema de Sessões** - Controle de acesso e estado do usuário
16. ✅ **Feedback Visual** - Alertas de sucesso/erro
17. ✅ **Navegação Intuitiva** - Menu de navegação claro
18. ✅ **Dados de Exemplo** - Empresas e atividades pré-cadastradas
19. ✅ **Múltiplas Versões** - Diferentes implementações (index.php, tecj.php, app.php)
20. ✅ **Design Moderno** - Interface com gradientes, sombras e efeitos

---

## Design Patterns Aplicados na Camada de Domínio

### 🔹 Singleton
- **Uso**: Conexão única ao banco de dados através da classe PDO
- **Justificativa**: Evita múltiplas instâncias de conexão e otimiza o uso de recursos do banco de dados

### 🔹 MVC (Model-View-Controller)
- **Uso**: Separação entre lógica de negócio, apresentação e controle
- **Justificativa**: Organiza o código de forma modular, facilitando manutenção e escalabilidade

### 🔹 Factory Method
- **Uso**: Criação de diferentes tipos de atividades no feed (candidatura, contratação, nova empresa)
- **Justificativa**: Permite criar objetos sem especificar suas classes concretas, facilitando extensibilidade

### 🔹 Strategy
- **Uso**: Diferentes estratégias de armazenamento (MySQL vs JSON)
- **Justificativa**: Permite alternar entre diferentes algoritmos de persistência sem modificar o código cliente

### 🔹 Observer
- **Uso**: Sistema de notificações e atualizações do feed de atividades
- **Justificativa**: Permite que múltiplos componentes sejam notificados quando eventos importantes ocorrem

---

## Funcionalidades Detalhadas

### 🔐 Sistema de Autenticação
- Login com email e senha
- Cadastro de novos usuários
- Validação de dados
- Hash seguro de senhas
- Controle de sessões

### 🏢 Gestão de Empresas
- Visualização de empresas cadastradas
- Informações detalhadas (setor, localização, descrição)
- Interface moderna com cards responsivos
- Avatares gerados automaticamente

### 💼 Sistema de Candidaturas
- Candidatura com um clique
- Prevenção de duplicatas
- Acompanhamento de status
- Timeline de candidaturas
- Estatísticas resumidas

### 📈 Feed de Atividades
- Atividades em tempo real
- Diferentes tipos de eventos
- Interface de timeline
- Badges coloridos por categoria
- Ordenação cronológica

### 🎨 Interface e UX
- Design responsivo
- Animações CSS
- Gradientes e efeitos visuais
- Feedback imediato
- Navegação intuitiva

---

## Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Estilo**: CSS Grid, Flexbox, Animações CSS
- **Segurança**: PDO Prepared Statements, Password Hashing
- **Armazenamento**: MySQL + JSON (sistema híbrido)

---

## Observações

### Características Técnicas
- **Arquitetura**: Monolítica com separação de responsabilidades
- **Persistência**: Suporte a MySQL e arquivos JSON
- **Segurança**: Proteção contra SQL Injection e XSS
- **Performance**: Consultas otimizadas e cache de sessão
- **Responsividade**: Mobile-first design

### Melhorias Futuras
- Sistema de notificações por email
- Upload de currículo
- Chat entre candidatos e empresas
- API REST para integração
- Painel administrativo
- Sistema de avaliações
- Filtros avançados de busca

### Problemas Conhecidos
- Sistema de usuários simplificado (ID fixo em algumas versões)
- Falta de paginação para grandes volumes de dados
- Ausência de testes automatizados

---

**Desenvolvido com ❤️ pela equipe TECJ para facilitar conexões profissionais!**