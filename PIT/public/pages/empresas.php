<?php
// Buscar empresas do banco de dados
try {
    $stmt = $pdo->query("SELECT * FROM empresas ORDER BY nome");
    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $empresas = [];
}

// Se não há empresas no banco, criar algumas de exemplo
if (empty($empresas)) {
    $empresas_exemplo = [
        ['id' => 1, 'nome' => 'TechCorp Brasil', 'setor' => 'Tecnologia', 'localizacao' => 'São Paulo, SP', 'descricao' => 'Empresa líder em soluções tecnológicas inovadoras'],
        ['id' => 2, 'nome' => 'InnovaSoft', 'setor' => 'Software', 'localizacao' => 'Rio de Janeiro, RJ', 'descricao' => 'Desenvolvimento de software personalizado'],
        ['id' => 3, 'nome' => 'DataScience Pro', 'setor' => 'Análise de Dados', 'localizacao' => 'Belo Horizonte, MG', 'descricao' => 'Especialistas em ciência de dados e IA'],
        ['id' => 4, 'nome' => 'CloudTech Solutions', 'setor' => 'Cloud Computing', 'localizacao' => 'Porto Alegre, RS', 'descricao' => 'Soluções em nuvem para empresas'],
        ['id' => 5, 'nome' => 'StartupHub', 'setor' => 'Incubadora', 'localizacao' => 'Florianópolis, SC', 'descricao' => 'Aceleradora de startups inovadoras']
    ];
    
    // Inserir empresas de exemplo no banco
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS empresas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            setor VARCHAR(100),
            localizacao VARCHAR(255),
            descricao TEXT
        )");
        
        $stmt = $pdo->prepare("INSERT INTO empresas (nome, setor, localizacao, descricao) VALUES (?, ?, ?, ?)");
        foreach ($empresas_exemplo as $empresa) {
            $stmt->execute([$empresa['nome'], $empresa['setor'], $empresa['localizacao'], $empresa['descricao']]);
        }
        
        $stmt = $pdo->query("SELECT * FROM empresas ORDER BY nome");
        $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $empresas = $empresas_exemplo;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas - Professional Network</title>
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

        <h1 class="page-title">Empresas Disponíveis</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Candidatura enviada com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

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
                        <form method="POST" action="?page=candidatar" style="display: inline;">
                            <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                            <button type="submit" class="btn">Candidatar-se</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($empresas)): ?>
            <div class="empty-state">
                <h3>Nenhuma empresa encontrada</h3>
                <p>No momento não há empresas disponíveis para candidatura.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/empresas.js"></script>
</body>
</html>