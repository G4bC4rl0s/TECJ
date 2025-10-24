<?php
session_start();

// Verificar se está logado
if (!isset($_SESSION['logado'])) {
    header('Location: auth.php');
    exit;
}

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
        
        header('Location: tecj.php?page=candidaturas&msg=success');
        exit;
    } else {
        header('Location: tecj.php?page=empresas&msg=error');
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
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Partículas flutuantes */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, rgba(255,255,255,0.3), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 90px 40px, rgba(255,255,255,0.4), transparent),
                radial-gradient(1px 1px at 130px 80px, rgba(255,255,255,0.3), transparent),
                radial-gradient(2px 2px at 160px 30px, rgba(255,255,255,0.2), transparent);
            background-repeat: repeat;
            background-size: 200px 100px;
            animation: sparkle 20s linear infinite;
            pointer-events: none;
            z-index: 1;
        }
        
        @keyframes sparkle {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-100px); }
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 2;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: headerShine 3s ease-in-out infinite;
        }
        
        @keyframes headerShine {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }
        
        .nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .nav a {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .nav a:hover::before {
            left: 100%;
        }
        
        .nav a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }
        
        .empresa-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }
        
        .empresa-info h3 {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .empresa-info p {
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-weight: 400;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }
        
        .btn-success:hover {
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .page-title {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        
        .alert {
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            border-radius: 15px;
            font-weight: 500;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #f0fff4, #c6f6d5);
            color: #22543d;
            border-left-color: #48bb78;
            box-shadow: 0 10px 25px rgba(72, 187, 120, 0.1);
        }
        
        .alert-error {
            background: linear-gradient(135deg, #fff5f5, #fed7d7);
            color: #742a2a;
            border-left-color: #f56565;
            box-shadow: 0 10px 25px rgba(245, 101, 101, 0.1);
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 500;
            background: linear-gradient(135deg, #fef5e7, #fbd38d);
            color: #744210;
            box-shadow: 0 2px 10px rgba(251, 211, 141, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #4a5568;
        }
        
        .empty-state h3 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .atividade-item {
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0 15px 15px 0;
            transition: all 0.3s ease;
        }
        
        .atividade-item:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateX(5px);
        }
        
        .atividade-candidatura { border-left-color: #48bb78; }
        .atividade-contratacao { border-left-color: #4299e1; }
        .atividade-nova_empresa { border-left-color: #ed8936; }
        
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .page-title { font-size: 2rem; }
            .empresa-card { flex-direction: column; gap: 1rem; }
            .grid { grid-template-columns: 1fr; gap: 1rem; }
            .nav { gap: 0.25rem; }
            .nav a { padding: 10px 16px; font-size: 0.9rem; }
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2, #667eea);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            animation: gradientShift 3s ease-in-out infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .logo::after {
            content: '🚀';
            position: absolute;
            top: -5px;
            right: -25px;
            font-size: 1.2rem;
            animation: rocketFloat 3s ease-in-out infinite;
        }
        
        @keyframes rocketFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-3px) rotate(5deg); }
            75% { transform: translateY(-1px) rotate(-3deg); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            60% { transform: translateY(-2px); }
        }
        
        /* Hero Section */
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 4rem 2rem;
            margin-bottom: 3rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #fff, #f0f0f0, #fff);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: textShine 2s ease-in-out infinite;
        }
        
        @keyframes textShine {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
        }
        
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
        }
        
        .hero-stat {
            text-align: center;
        }
        
        .hero-stat .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .hero-stat .stat-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            font-weight: 500;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }
        
        .dashboard-card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
            transition: all 0.3s ease;
        }
        
        .dashboard-card .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .dashboard-card h3 {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .dashboard-card p {
            color: #4a5568;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .card-btn {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .card-btn:hover {
            color: #5a6fd8;
            transform: translateX(5px);
        }
        
        /* Page Headers */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }
        
        /* Stats Container */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            display: block;
        }
        
        .stat-label {
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Empresas Grid */
        .empresas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .empresa-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .empresa-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .empresa-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }
        
        .empresa-card-modern:hover .empresa-avatar {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .empresa-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .empresa-avatar {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            margin-right: 1rem;
        }
        
        .empresa-info h3 {
            color: #2d3748;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .empresa-setor {
            color: #667eea;
            font-size: 0.9rem;
            font-weight: 500;
            background: rgba(102, 126, 234, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }
        
        .empresa-details {
            margin-bottom: 2rem;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: #4a5568;
        }
        
        .detail-icon {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .empresa-desc {
            color: #4a5568;
            line-height: 1.6;
        }
        
        .btn-candidatar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            justify-content: center;
        }
        
        .btn-candidatar:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }
        
        .btn-candidatar:active {
            transform: translateY(0) scale(0.98);
        }
        
        /* Timeline Styles */
        .candidaturas-timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .candidaturas-timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #667eea, #764ba2);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-marker {
            position: absolute;
            left: -1.75rem;
            top: 1rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #667eea;
            border: 3px solid white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }
        
        .candidatura-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .candidatura-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .empresa-mini-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 1rem;
        }
        
        .status-badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-badge-modern.pending {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
        }
        
        /* Feed Styles */
        .feed-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .feed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }
        
        .feed-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
        }
        
        .feed-live {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #48bb78;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #48bb78;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .feed-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .feed-item:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: translateX(5px);
        }
        
        .feed-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .feed-content {
            flex: 1;
        }
        
        .feed-text {
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .feed-time {
            color: #718096;
            font-size: 0.8rem;
        }
        
        .feed-type-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .feed-type-badge.candidatura {
            background: rgba(72, 187, 120, 0.2);
            color: #22543d;
        }
        
        .feed-type-badge.contratacao {
            background: rgba(66, 153, 225, 0.2);
            color: #2a4365;
        }
        
        .feed-type-badge.nova_empresa {
            background: rgba(237, 137, 54, 0.2);
            color: #744210;
        }
        
        .feed-type-badge.atualizacao {
            background: rgba(113, 128, 150, 0.2);
            color: #2d3748;
        }
        
        /* Recent Activity */
        .recent-activity {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .section-title {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .activity-item-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .activity-item-preview:hover {
            background: rgba(102, 126, 234, 0.05);
        }
        
        .activity-icon {
            font-size: 1.5rem;
        }
        
        .activity-text {
            flex: 1;
            color: #4a5568;
        }
        
        .activity-time {
            color: #718096;
            font-size: 0.8rem;
        }
        
        .view-all-btn {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        
        .view-all-btn:hover {
            color: #5a6fd8;
            transform: translateX(5px);
        }
        
        /* Summary Cards */
        .candidaturas-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .summary-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
        }
        
        .summary-icon {
            font-size: 2rem;
        }
        
        .summary-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
        }
        
        .summary-label {
            color: #4a5568;
            font-size: 0.9rem;
        }
        
        /* Empty State */
        .empty-state-modern {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .empty-state-modern h3 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .empty-state-modern p {
            color: #4a5568;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-stats { gap: 2rem; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .empresas-grid { grid-template-columns: 1fr; }
            .candidaturas-timeline { padding-left: 1rem; }
            .timeline-marker { left: -1.25rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="logo">TECJ</div>
                <div style="color: #4a5568; font-weight: 500;">👋 Olá, <?= $_SESSION['usuario'] ?? 'Usuário' ?>! | <a href="logout.php" style="color: #e53e3e; text-decoration: none; font-weight: 600;">🚪 Sair</a></div>
            </div>
            <nav class="nav">
                <a href="tecj.php?page=home">Início</a>
                <a href="tecj.php?page=empresas">Empresas</a>
                <a href="tecj.php?page=candidaturas">Minhas Candidaturas</a>
                <a href="tecj.php?page=vagas">📋 Vagas que Sigo</a>
                <a href="tecj.php?page=feed">Feed de Atividades</a>
            </nav>
        </header>

        <?php if ($_GET['msg'] ?? '' === 'success'): ?>
            <div class="alert alert-success">Candidatura enviada com sucesso!</div>
        <?php endif; ?>

        <?php if ($_GET['msg'] ?? '' === 'error'): ?>
            <div class="alert alert-error">Você já se candidatou a esta empresa!</div>
        <?php endif; ?>

        <?php if ($page === 'empresas'): ?>
            <div class="page-header">
                <h1 class="page-title">🏢 Empresas Disponíveis</h1>
                <p class="page-subtitle">Descubra oportunidades incríveis nas melhores empresas</p>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <div class="stat-number"><?= count($empresas) ?></div>
                    <div class="stat-label">Empresas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💼</div>
                    <div class="stat-number"><?= count($candidaturas) ?></div>
                    <div class="stat-label">Candidaturas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-number">5</div>
                    <div class="stat-label">Setores</div>
                </div>
            </div>
            
            <div class="empresas-grid">
                <?php foreach ($empresas as $empresa): ?>
                    <div class="empresa-card-modern">
                        <div class="empresa-header">
                            <div class="empresa-avatar"><?= substr($empresa['nome'], 0, 2) ?></div>
                            <div class="empresa-info">
                                <h3><?= htmlspecialchars($empresa['nome']) ?></h3>
                                <span class="empresa-setor"><?= htmlspecialchars($empresa['setor']) ?></span>
                            </div>
                        </div>
                        
                        <div class="empresa-details">
                            <div class="detail-item">
                                <span class="detail-icon">📍</span>
                                <span><?= htmlspecialchars($empresa['localizacao']) ?></span>
                            </div>
                            <p class="empresa-desc"><?= htmlspecialchars($empresa['descricao']) ?></p>
                        </div>
                        
                        <div class="empresa-actions">
                            <form method="POST" class="candidatura-form">
                                <input type="hidden" name="empresa_id" value="<?= $empresa['id'] ?>">
                                <button type="submit" name="candidatar" value="1" class="btn-candidatar">
                                    <span class="btn-icon">🚀</span>
                                    <span>Candidatar-se</span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($page === 'candidaturas' || $page === 'vagas'): ?>
            <div class="page-header">
                <h1 class="page-title"><?= $page === 'vagas' ? '📋 Vagas que Sigo' : '💼 Minhas Candidaturas' ?></h1>
                <p class="page-subtitle">Acompanhe o progresso das suas candidaturas</p>
            </div>
            
            <?php if (!empty($candidaturas)): ?>
                <div class="candidaturas-summary">
                    <div class="summary-card total">
                        <div class="summary-icon">📊</div>
                        <div class="summary-content">
                            <div class="summary-number"><?= count($candidaturas) ?></div>
                            <div class="summary-label">Total de Candidaturas</div>
                        </div>
                    </div>
                    <div class="summary-card pending">
                        <div class="summary-icon">⏳</div>
                        <div class="summary-content">
                            <div class="summary-number"><?= count($candidaturas) ?></div>
                            <div class="summary-label">Pendentes</div>
                        </div>
                    </div>
                    <div class="summary-card success">
                        <div class="summary-icon">✅</div>
                        <div class="summary-content">
                            <div class="summary-number">0</div>
                            <div class="summary-label">Aceitas</div>
                        </div>
                    </div>
                </div>
                
                <div class="candidaturas-timeline">
                    <?php foreach ($candidaturas as $index => $candidatura): ?>
                        <?php
                        $empresa = null;
                        foreach ($empresas as $e) {
                            if ($e['id'] == $candidatura['empresa_id']) {
                                $empresa = $e;
                                break;
                            }
                        }
                        ?>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="candidatura-card">
                                    <div class="candidatura-header">
                                        <div class="empresa-mini-avatar"><?= substr($empresa['nome'], 0, 2) ?></div>
                                        <div class="candidatura-info">
                                            <h4><?= htmlspecialchars($empresa['nome']) ?></h4>
                                            <span class="candidatura-setor"><?= htmlspecialchars($empresa['setor']) ?></span>
                                        </div>
                                        <div class="status-badge-modern pending">⏳ Pendente</div>
                                    </div>
                                    <div class="candidatura-details">
                                        <p class="candidatura-desc"><?= htmlspecialchars($empresa['descricao']) ?></p>
                                        <div class="candidatura-meta">
                                            <span class="meta-item">📍 <?= htmlspecialchars($empresa['localizacao']) ?></span>
                                            <span class="meta-item">📅 <?= date('d/m/Y H:i', strtotime($candidatura['data'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state-modern">
                    <div class="empty-icon">🎯</div>
                    <h3>Nenhuma candidatura ainda</h3>
                    <p>Que tal começar explorando as empresas disponíveis?</p>
                    <a href="tecj.php?page=empresas" class="btn-primary">🏢 Explorar Empresas</a>
                </div>
            <?php endif; ?>

        <?php elseif ($page === 'feed'): ?>
            <div class="page-header">
                <h1 class="page-title">📈 Feed de Atividades</h1>
                <p class="page-subtitle">Acompanhe as últimas movimentações da plataforma</p>
            </div>
            
            <div class="feed-container">
                <div class="feed-header">
                    <div class="feed-title">
                        <span class="feed-icon">🔥</span>
                        <span>Atividades Recentes</span>
                    </div>
                    <div class="feed-live">
                        <span class="live-dot"></span>
                        <span>Ao vivo</span>
                    </div>
                </div>
                
                <div class="feed-timeline">
                    <?php foreach (array_reverse($atividades) as $index => $atividade): ?>
                        <div class="feed-item feed-<?= $atividade['tipo'] ?>">
                            <div class="feed-avatar">
                                <?php
                                $icons = [
                                    'candidatura' => '🚀',
                                    'contratacao' => '🎉',
                                    'nova_empresa' => '🏢',
                                    'atualizacao' => '📝'
                                ];
                                echo $icons[$atividade['tipo']] ?? '📌';
                                ?>
                            </div>
                            <div class="feed-content">
                                <div class="feed-text"><?= htmlspecialchars($atividade['descricao']) ?></div>
                                <div class="feed-time"><?= date('d/m/Y H:i', strtotime($atividade['data'])) ?></div>
                            </div>
                            <div class="feed-type-badge <?= $atividade['tipo'] ?>">
                                <?php
                                $types = [
                                    'candidatura' => 'Candidatura',
                                    'contratacao' => 'Contratação',
                                    'nova_empresa' => 'Nova Empresa',
                                    'atualizacao' => 'Atualização'
                                ];
                                echo $types[$atividade['tipo']] ?? 'Atividade';
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title">🚀 Bem-vindo ao TECJ</h1>
                    <p class="hero-subtitle">Sua plataforma de conexões profissionais em tecnologia</p>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="stat-number"><?= count($empresas) ?></span>
                            <span class="stat-text">Empresas</span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number"><?= count($candidaturas) ?></span>
                            <span class="stat-text">Candidaturas</span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number"><?= count($atividades) ?></span>
                            <span class="stat-text">Atividades</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card empresas">
                    <div class="card-icon">🏢</div>
                    <div class="card-content">
                        <h3>Explorar Empresas</h3>
                        <p>Descubra oportunidades nas melhores empresas de tecnologia</p>
                        <a href="tecj.php?page=empresas" class="card-btn">Explorar →</a>
                    </div>
                </div>
                
                <div class="dashboard-card candidaturas">
                    <div class="card-icon">💼</div>
                    <div class="card-content">
                        <h3>Minhas Candidaturas</h3>
                        <p>Acompanhe o status das suas candidaturas</p>
                        <a href="tecj.php?page=candidaturas" class="card-btn">Ver Candidaturas →</a>
                    </div>
                </div>
                
                <div class="dashboard-card vagas">
                    <div class="card-icon">📋</div>
                    <div class="card-content">
                        <h3>Vagas que Sigo</h3>
                        <p>Monitore as vagas do seu interesse</p>
                        <a href="tecj.php?page=vagas" class="card-btn">Acompanhar →</a>
                    </div>
                </div>
                
                <div class="dashboard-card feed">
                    <div class="card-icon">📈</div>
                    <div class="card-content">
                        <h3>Feed de Atividades</h3>
                        <p>Veja as últimas movimentações da plataforma</p>
                        <a href="tecj.php?page=feed" class="card-btn">Ver Feed →</a>
                    </div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h3 class="section-title">🔥 Atividades Recentes</h3>
                <div class="activity-preview">
                    <?php foreach (array_slice(array_reverse($atividades), 0, 3) as $atividade): ?>
                        <div class="activity-item-preview">
                            <div class="activity-icon">
                                <?php
                                $icons = ['candidatura' => '🚀', 'contratacao' => '🎉', 'nova_empresa' => '🏢', 'atualizacao' => '📝'];
                                echo $icons[$atividade['tipo']] ?? '📌';
                                ?>
                            </div>
                            <div class="activity-text"><?= htmlspecialchars($atividade['descricao']) ?></div>
                            <div class="activity-time"><?= date('H:i', strtotime($atividade['data'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="tecj.php?page=feed" class="view-all-btn">Ver todas as atividades →</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>