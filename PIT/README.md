# Sistema de Candidaturas - Professional Network

Sistema simples para candidaturas a empresas desenvolvido em PHP puro.

## 🚀 Funcionalidades

- ✅ Visualizar lista de empresas disponíveis
- ✅ Candidatar-se a empresas com um clique
- ✅ Visualizar todas as candidaturas realizadas
- ✅ Status das candidaturas (Pendente, Aceita, Rejeitada)
- ✅ Prevenção de candidaturas duplicadas
- ✅ Interface responsiva e moderna
- ✅ Animações e feedback visual

## 📋 Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx) ou XAMPP/WAMP

## 🔧 Instalação

### 1. Configurar o Banco de Dados

```sql
-- Execute o script SQL
mysql -u root -p < database/setup.sql
```

### 2. Configurar Conexão

Edite o arquivo `public/index.php` e ajuste as configurações do banco:

```php
$host = 'localhost';
$dbname = 'professional_network';
$username = 'root';
$password = 'sua_senha';
```

### 3. Executar a Aplicação

#### Usando XAMPP/WAMP:
1. Copie a pasta do projeto para `htdocs`
2. Acesse `http://localhost/PIT/public`

#### Usando servidor PHP built-in:
```bash
cd public
php -S localhost:8000
```

## 📱 Como Usar

### 1. Página Inicial
- Acesse a página inicial para ver uma visão geral do sistema

### 2. Ver Empresas
- Clique em "Empresas" para ver todas as empresas disponíveis
- Cada empresa mostra: nome, setor, localização e descrição

### 3. Candidatar-se
- Clique no botão "Candidatar-se" na empresa desejada
- Confirme a candidatura no popup
- Receba feedback visual do sucesso/erro

### 4. Minhas Candidaturas
- Clique em "Minhas Candidaturas" para ver todas suas candidaturas
- Visualize o status de cada candidatura
- Veja estatísticas resumidas

## 🎨 Recursos Visuais

- **Design Moderno**: Interface limpa com gradientes e sombras
- **Responsivo**: Funciona em desktop, tablet e mobile
- **Animações**: Transições suaves e efeitos visuais
- **Feedback**: Alertas de sucesso/erro e confirmações
- **Status Visual**: Badges coloridos para status das candidaturas

## 🔒 Segurança

- Prevenção de candidaturas duplicadas
- Validação de dados no servidor
- Proteção contra SQL Injection (PDO prepared statements)
- Sanitização de dados de saída (htmlspecialchars)

## 📊 Estrutura do Banco

### Tabela `empresas`
- `id`: Identificador único
- `nome`: Nome da empresa
- `setor`: Setor de atuação
- `localizacao`: Localização da empresa
- `descricao`: Descrição da empresa

### Tabela `candidaturas`
- `id`: Identificador único
- `usuario_id`: ID do usuário (fixo como 1 nesta versão)
- `empresa_id`: ID da empresa
- `status`: Status da candidatura (pendente/aceita/rejeitada)
- `data_candidatura`: Data/hora da candidatura

### Tabela `usuarios`
- `id`: Identificador único
- `nome`: Nome do usuário
- `email`: Email do usuário

## 🛠️ Estrutura de Arquivos

```
PIT/
├── public/
│   ├── index.php          # Arquivo principal
│   ├── css/
│   │   └── style.css      # Estilos CSS
│   ├── js/
│   │   └── empresas.js    # JavaScript
│   ├── pages/
│   │   ├── home.php       # Página inicial
│   │   ├── empresas.php   # Lista de empresas
│   │   └── candidaturas.php # Minhas candidaturas
│   └── actions/
│       └── candidatar.php # Processar candidatura
├── database/
│   └── setup.sql          # Script de configuração do BD
└── README.md              # Este arquivo
```

## 🚀 Próximas Melhorias

- [ ] Sistema de login/registro
- [ ] Upload de currículo
- [ ] Filtros de busca por setor/localização
- [ ] Notificações por email
- [ ] Painel administrativo para empresas
- [ ] API REST
- [ ] Testes automatizados

## 🐛 Solução de Problemas

### Erro de Conexão com Banco
- Verifique se o MySQL está rodando
- Confirme as credenciais no `index.php`
- Execute o script `setup.sql`

### Página em Branco
- Verifique os logs de erro do PHP
- Confirme se todas as extensões PHP estão instaladas
- Verifique permissões de arquivo

### Botões Não Funcionam
- Verifique se o JavaScript está carregando
- Confirme se não há erros no console do navegador

## 📞 Suporte

Para dúvidas ou problemas, verifique:
1. Os logs de erro do servidor
2. Console do navegador (F12)
3. Configurações do banco de dados

---

**Desenvolvido com ❤️ para facilitar conexões profissionais!**