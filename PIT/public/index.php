<?php
session_start();

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'professional_network';
$username = 'root';
$password = '';

// Conectar ao banco
try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Criar tabelas se não existirem
$pdo->exec("CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    setor VARCHAR(100),
    localizacao VARCHAR(255),
    descricao TEXT
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS candidaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    empresa_id INT NOT NULL,
    status ENUM('pendente', 'aceita', 'rejeitada') DEFAULT 'pendente',
    data_candidatura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_candidatura (usuario_id, empresa_id)
)");

// Inserir empresas de exemplo se não existirem
$stmt = $pdo->query("SELECT COUNT(*) FROM empresas");
if ($stmt->fetchColumn() == 0) {
    $empresas = [
        ['TechCorp Brasil', 'Tecnologia', 'São Paulo, SP', 'Empresa líder em soluções tecnológicas'],
        ['InnovaSoft', 'Software', 'Rio de Janeiro, RJ', 'Desenvolvimento de software personalizado'],
        ['DataScience Pro', 'Análise de Dados', 'Belo Horizonte, MG', 'Especialistas em ciência de dados'],
        ['CloudTech Solutions', 'Cloud Computing', 'Porto Alegre, RS', 'Soluções em nuvem'],
        ['StartupHub', 'Incubadora', 'Florianópolis, SC', 'Aceleradora de startups']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO empresas (nome, setor, localizacao, descricao) VALUES (?, ?, ?, ?)");
    foreach ($empresas as $empresa) {
        $stmt->execute($empresa);
    }
}

// Processar candidatura
if ($_POST['action'] ?? '' === 'candidatar') {
    $empresa_id = $_POST['empresa_id'] ?? null;
    $usuario_id = 1;
    
    if ($empresa_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO candidaturas (usuario_id, empresa_id) VALUES (?, ?)");
            $stmt->execute([$usuario_id, $empresa_id]);
            header('Location: ?page=candidaturas&success=1');
            exit;
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                header('Location: ?page=empresas&error=duplicate');
            } else {
                header('Location: ?page=empresas&error=general');
            }
            exit;
        }
    }
}

$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Network</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; color: #333; }
    .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    .header { background: rgba(255, 255, 255, 0.95); padding: 1rem 0; margin-bottom: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .nav { display: flex; justify-content: center; gap: 2rem; }
    .nav a { text-decoration: none; color: #333; font-weight: 600; padding: 0.5rem 1rem; border-radius: 5px; transition: all 0.3s ease; }
    .nav a:hover { background: #667eea; color: white; }
    .card { background: white; border-radius: 10px; padding: 1.5rem; margin-bottom: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .empresa-card { display: flex; justify-content: space-between; align-items: center; }
    .empresa-info h3 { color: #333; margin-bottom: 0.5rem; }
    .empresa-info p { color: #666; margin-bottom: 0.25rem; }
    .btn { background: #667eea; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
    .btn:hover { background: #5a6fd8; }
    .btn-success { background: #28a745; }
    .alert { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; }
    .status-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600; }
    .status-pendente { background: #fff3cd; color: #856404; }
    .status-aceita { background: #d4edda; color: #155724; }
    .status-rejeitada { background: #f8d7da; color: #721c24; }
    .page-title { text-align: center; color: white; margin-bottom: 2rem; font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); }
    .empty-state { text-align: center; padding: 3rem; color: #666; }
    .empty-state h3 { margin-bottom: 1rem; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <nav class="nav">
                <a href="?page=home">Início</a>
                <a href="?page=empresas">Empresas</a>
                <a href="?page=candidaturas">Minhas Candidaturas</a>
            </nav>
        </header>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Candidatura enviada com sucesso!</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php 
                if ($_GET['error'] === 'duplicate') {
                    echo 'Você já se candidatou a esta empresa';
                } else {
                    echo 'Erro ao processar candidatura';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php
        switch($page) {
            case 'empresas':
                $stmt = $pdo->query("SELECT * FROM empresas ORDER BY nome");
                $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <h1 class="page-title">Empresas Disponíveis</h1>
                <div class="grid">
                    <?php foreach ($empresas as $empresa): ?>
                        <div class="card empresa-card">
                            <div class="empresa-info">
                                <h3><?php echo htmlspecialchars($empresa['nome']); ?></h3>
                                <p><strong>Setor:</strong> <?php echo htmlspecialchars($empresa['setor']); ?></p>
                                <p><strong>Localização:</strong> <?php echo htmlspecialchars($empresa['localizacao']); ?></p>
                                <p><?php echo htmlspecialchars($empresa['descricao']); ?></p>
                            </div>
                            <div>
                                <form method="POST">
                                    <input type="hidden" name="action" value="candidatar">
                                    <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                                    <button type="submit" class="btn">Candidatar-se</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
                break;

            case 'candidaturas':
                $stmt = $pdo->prepare("
                    SELECT c.*, e.nome as empresa_nome, e.setor, e.localizacao, e.descricao 
                    FROM candidaturas c 
                    JOIN empresas e ON c.empresa_id = e.id 
                    WHERE c.usuario_id = 1 
                    ORDER BY c.data_candidatura DESC
                ");
                $stmt->execute();
                $candidaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <h1 class="page-title">Minhas Candidaturas</h1>
                <?php if (!empty($candidaturas)): ?>
                    <div class="grid">
                        <?php foreach ($candidaturas as $candidatura): ?>
                            <div class="card">
                                <h3><?php echo htmlspecialchars($candidatura['empresa_nome']); ?></h3>
                                <p><strong>Setor:</strong> <?php echo htmlspecialchars($candidatura['setor']); ?></p>
                                <p><strong>Localização:</strong> <?php echo htmlspecialchars($candidatura['localizacao']); ?></p>
                                <p><?php echo htmlspecialchars($candidatura['descricao']); ?></p>
                                <div style="margin-top: 1rem; display: flex; justify-content: space-between;">
                                    <span class="status-badge status-<?php echo $candidatura['status']; ?>">
                                        <?php echo ucfirst($candidatura['status']); ?>
                                    </span>
                                    <small><?php echo date('d/m/Y H:i', strtotime($candidatura['data_candidatura'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Você ainda não se candidatou a nenhuma empresa</h3>
                        <a href="?page=empresas" class="btn">Ver Empresas</a>
                    </div>
                <?php endif; ?>
                <?php
                break;

            default:
                ?>
                <h1 class="page-title">Professional Network</h1>
                <div class="card">
                    <h2>Bem-vindo à nossa plataforma!</h2>
                    <p>Conecte-se com as melhores empresas e encontre oportunidades incríveis.</p>
                    <div style="margin-top: 2rem;">
                        <a href="?page=empresas" class="btn">Ver Empresas</a>
                        <a href="?page=candidaturas" class="btn btn-success">Minhas Candidaturas</a>
                    </div>
                </div>
                <?php
                break;
        }
        ?>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                if (button) {
                    button.textContent = 'Enviando...';
                    button.disabled = true;
                }
            });
        });
    });
    </script>
</body>
</html>