<?php
session_start();

// Configuração do banco
$host = 'localhost';
$dbname = 'professional_network';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
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
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS atividades (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo VARCHAR(50) NOT NULL,
        descricao TEXT NOT NULL,
        usuario VARCHAR(100),
        empresa VARCHAR(100),
        data_atividade TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Inserir dados se não existirem
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
        
        // Inserir atividades de exemplo
        $atividades = [
            ['candidatura', 'João Silva se candidatou à TechCorp Brasil', 'João Silva', 'TechCorp Brasil'],
            ['contratacao', 'Maria Santos foi contratada pela InnovaSoft', 'Maria Santos', 'InnovaSoft'],
            ['candidatura', 'Pedro Costa se candidatou à DataScience Pro', 'Pedro Costa', 'DataScience Pro'],
            ['atualizacao', 'CloudTech Solutions atualizou sua descrição', null, 'CloudTech Solutions'],
            ['candidatura', 'Ana Oliveira se candidatou à StartupHub', 'Ana Oliveira', 'StartupHub'],
            ['contratacao', 'Carlos Lima foi contratado pela TechCorp Brasil', 'Carlos Lima', 'TechCorp Brasil'],
            ['nova_empresa', 'FinTech Brasil se juntou à plataforma', null, 'FinTech Brasil'],
            ['candidatura', 'Lucia Ferreira se candidatou à CloudTech Solutions', 'Lucia Ferreira', 'CloudTech Solutions'],
            ['atualizacao', 'DataScience Pro publicou nova vaga', null, 'DataScience Pro'],
            ['candidatura', 'Roberto Alves se candidatou à InnovaSoft', 'Roberto Alves', 'InnovaSoft']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO atividades (tipo, descricao, usuario, empresa) VALUES (?, ?, ?, ?)");
        foreach ($atividades as $atividade) {
            $stmt->execute($atividade);
        }
    }
    
    // Verificar se atividades existem, se não, inserir
    $stmt = $pdo->query("SELECT COUNT(*) FROM atividades");
    if ($stmt->fetchColumn() == 0) {
        $atividades = [
            ['candidatura', 'João Silva se candidatou à TechCorp Brasil', 'João Silva', 'TechCorp Brasil'],
            ['contratacao', 'Maria Santos foi contratada pela InnovaSoft', 'Maria Santos', 'InnovaSoft'],
            ['candidatura', 'Pedro Costa se candidatou à DataScience Pro', 'Pedro Costa', 'DataScience Pro'],
            ['atualizacao', 'CloudTech Solutions atualizou sua descrição', null, 'CloudTech Solutions'],
            ['candidatura', 'Ana Oliveira se candidatou à StartupHub', 'Ana Oliveira', 'StartupHub'],
            ['contratacao', 'Carlos Lima foi contratado pela TechCorp Brasil', 'Carlos Lima', 'TechCorp Brasil'],
            ['nova_empresa', 'FinTech Brasil se juntou à plataforma', null, 'FinTech Brasil'],
            ['candidatura', 'Lucia Ferreira se candidatou à CloudTech Solutions', 'Lucia Ferreira', 'CloudTech Solutions'],
            ['atualizacao', 'DataScience Pro publicou nova vaga', null, 'DataScience Pro'],
            ['candidatura', 'Roberto Alves se candidatou à InnovaSoft', 'Roberto Alves', 'InnovaSoft']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO atividades (tipo, descricao, usuario, empresa) VALUES (?, ?, ?, ?)");
        foreach ($atividades as $atividade) {
            $stmt->execute($atividade);
        }
    }
} catch(PDOException $e) {
    die("Erro: " . $e->getMessage());
}

// Debug - mostrar dados POST
if (!empty($_POST)) {
    echo "<pre>POST data: ";
    print_r($_POST);
    echo "</pre>";
}

// Processar candidatura
if (isset($_POST['candidatar']) && $_POST['candidatar'] == '1') {
    $empresa_id = $_POST['empresa_id'] ?? null;
    
    if ($empresa_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO candidaturas (usuario_id, empresa_id) VALUES (1, ?)");
            $stmt->execute([$empresa_id]);
            
            // Adicionar atividade ao feed
            $stmt = $pdo->prepare("SELECT nome FROM empresas WHERE id = ?");
            $stmt->execute([$empresa_id]);
            $empresa_nome = $stmt->fetchColumn();
            
            $stmt = $pdo->prepare("INSERT INTO atividades (tipo, descricao, usuario, empresa) VALUES ('candidatura', ?, 'Você', ?)");
            $stmt->execute(["Você se candidatou à $empresa_nome", $empresa_nome]);
            
            header('Location: app.php?page=candidaturas&msg=success');
            exit;
        } catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
            header('Location: app.php?page=empresas&msg=error');
            exit;
        }
    } else {
        echo "Empresa ID não encontrado";
    }
}

$page = $_GET['page'] ?? 'home';

// Debug - mostrar URL completa
echo "<div style='background: yellow; padding: 10px; margin: 10px;'>URL: " . $_SERVER['REQUEST_URI'] . " | Página: $page</div>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Professional Network</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 1rem; margin-bottom: 2rem; border-radius: 10px; text-align: center; }
        .nav a { margin: 0 1rem; padding: 0.5rem 1rem; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #5a6fd8; }
        .card { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .empresa-card { display: flex; justify-content: space-between; align-items: center; }
        .btn { background: #667eea; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #5a6fd8; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; }
        .page-title { text-align: center; color: white; margin-bottom: 2rem; font-size: 2rem; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; }
        .status-pendente { background: #fff3cd; color: #856404; }
        .empty-state { text-align: center; padding: 3rem; color: #666; }
        .atividade-item { border-left: 4px solid #667eea; padding-left: 1rem; margin-bottom: 1rem; }
        .atividade-candidatura { border-left-color: #28a745; }
        .atividade-contratacao { border-left-color: #007bff; }
        .atividade-nova_empresa { border-left-color: #ffc107; }
        .atividade-atualizacao { border-left-color: #6c757d; }
        .atividade-time { color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <nav class="nav">
                <a href="app.php?page=home">Início</a>
                <a href="app.php?page=empresas">Empresas</a>
                <a href="app.php?page=candidaturas">Minhas Candidaturas</a>
                <a href="app.php?page=feed">Feed de Atividades</a>
            </nav>
            <div style="text-align: center; margin-bottom: 1rem;">
                <a href="app.php?page=vagas" class="btn" style="background: #28a745;">📋 Vagas que Sigo</a>
            </div>
        </header>

        <?php if ($_GET['msg'] ?? '' === 'success'): ?>
            <div class="alert alert-success">Candidatura enviada com sucesso!</div>
        <?php endif; ?>

        <?php if ($_GET['msg'] ?? '' === 'error'): ?>
            <div class="alert alert-error">Você já se candidatou a esta empresa!</div>
        <?php endif; ?>

        <?php if ($page === 'empresas'): ?>
            <h1 class="page-title">Empresas Disponíveis</h1>
            <div class="grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM empresas ORDER BY nome");
                while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <div class="card empresa-card">
                        <div>
                            <h3><?= htmlspecialchars($empresa['nome']) ?></h3>
                            <p><strong>Setor:</strong> <?= htmlspecialchars($empresa['setor']) ?></p>
                            <p><strong>Localização:</strong> <?= htmlspecialchars($empresa['localizacao']) ?></p>
                            <p><?= htmlspecialchars($empresa['descricao']) ?></p>
                        </div>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="empresa_id" value="<?= $empresa['id'] ?>">
                                <button type="submit" name="candidatar" value="1" class="btn">Candidatar-se</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        <?php elseif ($page === 'candidaturas'): ?>
            <h1 class="page-title">Minhas Candidaturas</h1>
            <?php
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
            
            <?php if (!empty($candidaturas)): ?>
                <div class="grid">
                    <?php foreach ($candidaturas as $candidatura): ?>
                        <div class="card">
                            <h3><?= htmlspecialchars($candidatura['empresa_nome']) ?></h3>
                            <p><strong>Setor:</strong> <?= htmlspecialchars($candidatura['setor']) ?></p>
                            <p><strong>Localização:</strong> <?= htmlspecialchars($candidatura['localizacao']) ?></p>
                            <p><?= htmlspecialchars($candidatura['descricao']) ?></p>
                            <div style="margin-top: 1rem; display: flex; justify-content: space-between;">
                                <span class="status-badge status-<?= $candidatura['status'] ?>">
                                    <?= ucfirst($candidatura['status']) ?>
                                </span>
                                <small><?= date('d/m/Y H:i', strtotime($candidatura['data_candidatura'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Você ainda não se candidatou a nenhuma empresa</h3>
                    <a href="app.php?page=empresas" class="btn">Ver Empresas</a>
                </div>
            <?php endif; ?>

        <?php elseif ($page === 'vagas' || strpos($_SERVER['REQUEST_URI'], 'jobs/followed') !== false): ?>
            <h1 class="page-title">Vagas que Sigo</h1>
            <?php
            $stmt = $pdo->prepare("
                SELECT c.*, e.nome as empresa_nome, e.setor, e.localizacao, e.descricao 
                FROM candidaturas c 
                JOIN empresas e ON c.empresa_id = e.id 
                WHERE c.usuario_id = 1 AND c.status = 'pendente'
                ORDER BY c.data_candidatura DESC
            ");
            $stmt->execute();
            $vagas_seguindo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            
            <?php if (!empty($vagas_seguindo)): ?>
                <div class="grid">
                    <?php foreach ($vagas_seguindo as $vaga): ?>
                        <div class="card">
                            <h3><?= htmlspecialchars($vaga['empresa_nome']) ?></h3>
                            <p><strong>Setor:</strong> <?= htmlspecialchars($vaga['setor']) ?></p>
                            <p><strong>Localização:</strong> <?= htmlspecialchars($vaga['localizacao']) ?></p>
                            <p><?= htmlspecialchars($vaga['descricao']) ?></p>
                            <div style="margin-top: 1rem; display: flex; justify-content: space-between;">
                                <span class="status-badge status-<?= $vaga['status'] ?>">
                                    Aguardando Resposta
                                </span>
                                <small>Candidatura: <?= date('d/m/Y', strtotime($vaga['data_candidatura'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Você não está seguindo nenhuma vaga</h3>
                    <p>Candidate-se a empresas para acompanhar suas vagas aqui!</p>
                    <a href="app.php?page=empresas" class="btn">Ver Empresas</a>
                </div>
            <?php endif; ?>

        <?php elseif ($page === 'feed'): ?>
            <h1 class="page-title">Feed de Atividades</h1>
            <?php
            $stmt = $pdo->query("SELECT * FROM atividades ORDER BY data_atividade DESC LIMIT 20");
            $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            
            <div class="card">
                <h3>Últimas Atividades da Plataforma</h3>
                <?php if (!empty($atividades)): ?>
                    <?php foreach ($atividades as $atividade): ?>
                        <div class="atividade-item atividade-<?= $atividade['tipo'] ?>">
                            <p><?= htmlspecialchars($atividade['descricao']) ?></p>
                            <div class="atividade-time"><?= date('d/m/Y H:i', strtotime($atividade['data_atividade'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>Nenhuma atividade encontrada. Candidate-se a uma empresa para gerar atividades!</p>
                    </div>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <?php if ($page !== 'home'): ?>
                <div class="alert alert-error">Página '<?= $page ?>' não encontrada!</div>
            <?php endif; ?>
            <h1 class="page-title">Professional Network</h1>
            <div class="card">
                <h2>Bem-vindo à nossa plataforma!</h2>
                <p>Conecte-se com as melhores empresas e encontre oportunidades incríveis.</p>
                <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <a href="app.php?page=empresas" class="btn">Ver Empresas</a>
                    <a href="app.php?page=candidaturas" class="btn">Minhas Candidaturas</a>
                    <a href="app.php?page=vagas" class="btn" style="background: #28a745;">📋 Vagas que Sigo</a>
                    <a href="app.php?page=feed" class="btn">Feed de Atividades</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('button[name="candidatar"]');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const empresaId = form.querySelector('input[name="empresa_id"]').value;
                
                // Criar formulário dinâmico
                const newForm = document.createElement('form');
                newForm.method = 'POST';
                newForm.action = 'app.php';
                
                const inputCandidatar = document.createElement('input');
                inputCandidatar.type = 'hidden';
                inputCandidatar.name = 'candidatar';
                inputCandidatar.value = '1';
                
                const inputEmpresa = document.createElement('input');
                inputEmpresa.type = 'hidden';
                inputEmpresa.name = 'empresa_id';
                inputEmpresa.value = empresaId;
                
                newForm.appendChild(inputCandidatar);
                newForm.appendChild(inputEmpresa);
                document.body.appendChild(newForm);
                
                this.textContent = 'Enviando...';
                this.disabled = true;
                
                newForm.submit();
            });
        });
    });
    </script>
</body>
</html>