<?php
// Simular ID do usuário (em um sistema real, viria da sessão)
$usuario_id = $_SESSION['usuario_id'] ?? 1;

// Buscar candidaturas do usuário
try {
    $stmt = $pdo->prepare("
        SELECT c.*, e.nome as empresa_nome, e.setor, e.localizacao, e.descricao 
        FROM candidaturas c 
        JOIN empresas e ON c.empresa_id = e.id 
        WHERE c.usuario_id = ? 
        ORDER BY c.data_candidatura DESC
    ");
    $stmt->execute([$usuario_id]);
    $candidaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $candidaturas = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas - Professional Network</title>
    <link rel="stylesheet" href="css/style.css">
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

        <h1 class="page-title">Minhas Candidaturas</h1>

        <?php if (!empty($candidaturas)): ?>
            <div class="grid">
                <?php foreach ($candidaturas as $candidatura): ?>
                    <div class="card">
                        <div class="empresa-info">
                            <h3><?php echo htmlspecialchars($candidatura['empresa_nome']); ?></h3>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($candidatura['setor']); ?></p>
                            <p><strong>Localização:</strong> <?php echo htmlspecialchars($candidatura['localizacao']); ?></p>
                            <p><?php echo htmlspecialchars($candidatura['descricao']); ?></p>
                            
                            <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                <span class="status-badge status-<?php echo $candidatura['status']; ?>">
                                    <?php 
                                    $status_labels = [
                                        'pendente' => 'Pendente',
                                        'aceita' => 'Aceita',
                                        'rejeitada' => 'Rejeitada'
                                    ];
                                    echo $status_labels[$candidatura['status']];
                                    ?>
                                </span>
                                <small style="color: #666;">
                                    Candidatura enviada em: <?php echo date('d/m/Y H:i', strtotime($candidatura['data_candidatura'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card" style="margin-top: 2rem;">
                <h3>Resumo das Candidaturas</h3>
                <?php
                $total = count($candidaturas);
                $pendentes = count(array_filter($candidaturas, fn($c) => $c['status'] === 'pendente'));
                $aceitas = count(array_filter($candidaturas, fn($c) => $c['status'] === 'aceita'));
                $rejeitadas = count(array_filter($candidaturas, fn($c) => $c['status'] === 'rejeitada'));
                ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <h4 style="color: #333; margin-bottom: 0.5rem;">Total</h4>
                        <span style="font-size: 2rem; font-weight: bold; color: #667eea;"><?php echo $total; ?></span>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #fff3cd; border-radius: 5px;">
                        <h4 style="color: #856404; margin-bottom: 0.5rem;">Pendentes</h4>
                        <span style="font-size: 2rem; font-weight: bold; color: #856404;"><?php echo $pendentes; ?></span>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #d4edda; border-radius: 5px;">
                        <h4 style="color: #155724; margin-bottom: 0.5rem;">Aceitas</h4>
                        <span style="font-size: 2rem; font-weight: bold; color: #155724;"><?php echo $aceitas; ?></span>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #f8d7da; border-radius: 5px;">
                        <h4 style="color: #721c24; margin-bottom: 0.5rem;">Rejeitadas</h4>
                        <span style="font-size: 2rem; font-weight: bold; color: #721c24;"><?php echo $rejeitadas; ?></span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Você ainda não se candidatou a nenhuma empresa</h3>
                <p>Explore as empresas disponíveis e candidate-se às que mais interessam você!</p>
                <a href="?page=empresas" class="btn" style="margin-top: 1rem;">Ver Empresas</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>