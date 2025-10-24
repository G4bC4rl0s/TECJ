<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?page=empresas&error=Método inválido');
    exit;
}

$empresa_id = $_POST['empresa_id'] ?? null;

if (!$empresa_id) {
    header('Location: ?page=empresas&error=Empresa não encontrada');
    exit;
}

// Simular ID do usuário (em um sistema real, viria da sessão)
$usuario_id = $_SESSION['usuario_id'] ?? 1;

try {
    // Criar tabela de candidaturas se não existir
    $pdo->exec("CREATE TABLE IF NOT EXISTS candidaturas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        empresa_id INT NOT NULL,
        status ENUM('pendente', 'aceita', 'rejeitada') DEFAULT 'pendente',
        data_candidatura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_candidatura (usuario_id, empresa_id)
    )");

    // Verificar se já existe candidatura
    $stmt = $pdo->prepare("SELECT id FROM candidaturas WHERE usuario_id = ? AND empresa_id = ?");
    $stmt->execute([$usuario_id, $empresa_id]);
    
    if ($stmt->fetch()) {
        header('Location: ?page=empresas&error=Você já se candidatou a esta empresa');
        exit;
    }

    // Inserir nova candidatura
    $stmt = $pdo->prepare("INSERT INTO candidaturas (usuario_id, empresa_id) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $empresa_id]);

    header('Location: ?page=empresas&success=1');
    exit;

} catch(PDOException $e) {
    if ($e->getCode() == 23000) {
        header('Location: ?page=empresas&error=Você já se candidatou a esta empresa');
    } else {
        header('Location: ?page=empresas&error=Erro ao processar candidatura');
    }
    exit;
}
?>