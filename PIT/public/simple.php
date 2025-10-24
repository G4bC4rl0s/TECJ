<?php
session_start();

// Dados em arquivos (sem banco)
$empresas_file = 'data_empresas.json';
$candidaturas_file = 'data_candidaturas.json';
$atividades_file = 'data_atividades.json';

// Criar dados se não existirem
if (!file_exists($empresas_file)) {
    $empresas = [
        ['id' => 1, 'nome' => 'TechCorp Brasil', 'setor' => 'Tecnologia', 'localizacao' => 'São Paulo, SP', 'descricao' => 'Empresa líder em soluções tecnológicas'],
        ['id' => 2, 'nome' => 'InnovaSoft', 'setor' => 'Software', 'localizacao' => 'Rio de Janeiro, RJ', 'descricao' => 'Desenvolvimento de software personalizado'],
        ['id' => 3, 'nome' => 'DataScience Pro', 'setor' => 'Análise de Dados', 'localizacao' => 'Belo Horizonte, MG', 'descricao' => 'Especialistas em ciência de dados'],
        ['id' => 4, 'nome' => 'CloudTech Solutions', 'setor' => 'Cloud Computing', 'localizacao' => 'Porto Alegre, RS', 'descricao' => 'Soluções em nuvem'],
        ['id' => 5, 'nome' => 'StartupHub', 'setor' => 'Incubadora', 'localizacao' => 'Florianópolis, SC', 'descricao' => 'Aceleradora de startups']
    ];
    file_put_contents($empresas_file, json_encode($empresas));
}

if (!file_exists($candidaturas_file)) {
    file_put_contents($candidaturas_file, json_encode([]));
}

if (!file_exists($atividades_file)) {
    $atividades = [
        ['tipo' => 'candidatura', 'descricao' => 'João Silva se candidatou à TechCorp Brasil', 'data' => date('Y-m-d H:i:s')],
        ['tipo' => 'contratacao', 'descricao' => 'Maria Santos foi contratada pela InnovaSoft', 'data' => date('Y-m-d H:i:s')],
        ['tipo' => 'candidatura', 'descricao' => 'Pedro Costa se candidatou à DataScience Pro', 'data' => date('Y-m-d H:i:s')],
        ['tipo' => 'nova_empresa', 'descricao' => 'CloudTech Solutions se juntou à plataforma', 'data' => date('Y-m-d H:i:s')],
        ['tipo' => 'candidatura', 'descricao' => 'Ana Oliveira se candidatou à StartupHub', 'data' => date('Y-m-d H:i:s')]
    ];
    file_put_contents($atividades_file, json_encode($atividades));
}

// Carregar dados
$empresas = json_decode(file_get_contents($empresas_file), true);
$candidaturas = json_decode(file_get_contents($candidaturas_file), true);
$atividades = json_decode(file_get_contents($atividades_file), true);

// Processar candidatura
if (isset($_POST['candidatar'])) {
    $empresa_id = $_POST['empresa_id'];
    $nova_candidatura = [
        'id' => count($candidaturas) + 1,
        'empresa_id' => $empresa_id,
        'status' => 'pendente',
        'data' => date('Y-m-d H:i:s')
    ];
    
    // Verificar se já existe
    $existe = false;
    foreach ($candidaturas as $c) {
        if ($c['empresa_id'] == $empresa_id) {
            $existe = true;
            break;
        }
    }
    
    if (!$existe) {
        $candidaturas[] = $nova_candidatura;
        file_put_contents($candidaturas_file, json_encode($candidaturas));
        
        // Adicionar atividade
        $empresa_nome = '';
        foreach ($empresas as $e) {
            if ($e['id'] == $empresa_id) {
                $empresa_nome = $e['nome'];
                break;
            }
        }
        $atividades[] = ['tipo' => 'candidatura', 'descricao' => "Você se candidatou à $empresa_nome", 'data' => date('Y-m-d H:i:s')];
        file_put_contents($atividades_file, json_encode($atividades));
        
        header('Location: simple.php?page=candidaturas&msg=success');
        exit;
    } else {
        header('Location: simple.php?page=empresas&msg=error');
        exit;
    }
}

$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TECJ</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 1rem; margin-bottom: 2rem; border-radius: 10px; text-align: center; }
        .nav a { margin: 0 1rem; padding: 0.5rem 1rem; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #5a6fd8; }
        .card { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .empresa-card { display: flex; justify-content: space-between; align-items: center; }
        .btn { background: #667eea; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #5a6fd8; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; }
        .page-title { text-align: center; color: white; margin-bottom: 2rem; font-size: 2rem; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; background: #fff3cd; color: #856404; }
        .empty-state { text-align: center; padding: 3rem; color: #666; }
        .atividade-item { border-left: 4px solid #667eea; padding-left: 1rem; margin-bottom: 1rem; }
        .atividade-candidatura { border-left-color: #28a745; }
        .atividade-contratacao { border-left-color: #007bff; }
        .atividade-nova_empresa { border-left-color: #ffc107; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <nav class="nav">
                <a href="simple.php?page=home">Início</a>
                <a href="simple.php?page=empresas">Empresas</a>
                <a href="simple.php?page=candidaturas">Minhas Candidaturas</a>
                <a href="simple.php?page=vagas">📋 Vagas que Sigo</a>
                <a href="simple.php?page=feed">Feed de Atividades</a>
            </nav>
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
                <?php foreach ($empresas as $empresa): ?>
                    <div class="card empresa-card">
                        <div>
                            <h3><?= $empresa['nome'] ?></h3>
                            <p><strong>Setor:</strong> <?= $empresa['setor'] ?></p>
                            <p><strong>Localização:</strong> <?= $empresa['localizacao'] ?></p>
                            <p><?= $empresa['descricao'] ?></p>
                        </div>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="empresa_id" value="<?= $empresa['id'] ?>">
                                <button type="submit" name="candidatar" value="1" class="btn">Candidatar-se</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($page === 'candidaturas' || $page === 'vagas'): ?>
            <h1 class="page-title"><?= $page === 'vagas' ? 'Vagas que Sigo' : 'Minhas Candidaturas' ?></h1>
            <?php if (!empty($candidaturas)): ?>
                <div class="grid">
                    <?php foreach ($candidaturas as $candidatura): ?>
                        <?php
                        $empresa = null;
                        foreach ($empresas as $e) {
                            if ($e['id'] == $candidatura['empresa_id']) {
                                $empresa = $e;
                                break;
                            }
                        }
                        ?>
                        <div class="card">
                            <h3><?= $empresa['nome'] ?></h3>
                            <p><strong>Setor:</strong> <?= $empresa['setor'] ?></p>
                            <p><strong>Localização:</strong> <?= $empresa['localizacao'] ?></p>
                            <p><?= $empresa['descricao'] ?></p>
                            <div style="margin-top: 1rem; display: flex; justify-content: space-between;">
                                <span class="status-badge">Pendente</span>
                                <small><?= date('d/m/Y H:i', strtotime($candidatura['data'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Você ainda não se candidatou a nenhuma empresa</h3>
                    <a href="simple.php?page=empresas" class="btn">Ver Empresas</a>
                </div>
            <?php endif; ?>

        <?php elseif ($page === 'feed'): ?>
            <h1 class="page-title">Feed de Atividades</h1>
            <div class="card">
                <h3>Últimas Atividades da Plataforma</h3>
                <?php foreach (array_reverse($atividades) as $atividade): ?>
                    <div class="atividade-item atividade-<?= $atividade['tipo'] ?>">
                        <p><?= $atividade['descricao'] ?></p>
                        <div style="color: #666; font-size: 0.9rem;"><?= date('d/m/Y H:i', strtotime($atividade['data'])) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <h1 class="page-title">TECJ</h1>
            <div class="card">
                <h2>Bem-vindo ao TECJ!</h2>
                <p>Conecte-se com as melhores empresas e encontre oportunidades incríveis.</p>
                <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <a href="simple.php?page=empresas" class="btn">Ver Empresas</a>
                    <a href="simple.php?page=candidaturas" class="btn">Minhas Candidaturas</a>
                    <a href="simple.php?page=vagas" class="btn" style="background: #28a745;">📋 Vagas que Sigo</a>
                    <a href="simple.php?page=feed" class="btn">Feed de Atividades</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>