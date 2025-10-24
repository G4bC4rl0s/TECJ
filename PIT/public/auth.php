<?php
session_start();

// Arquivo para armazenar usuários
$usuarios_file = 'data_usuarios.json';

// Criar arquivo se não existir
if (!file_exists($usuarios_file)) {
    $usuarios_default = [
        ['id' => 1, 'nome' => 'Administrador', 'email' => 'admin@tecj.com', 'senha' => password_hash('123456', PASSWORD_DEFAULT)]
    ];
    file_put_contents($usuarios_file, json_encode($usuarios_default));
}

$usuarios = json_decode(file_get_contents($usuarios_file), true);

// Processar login
if ($_POST['login'] ?? false) {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email && password_verify($senha, $usuario['senha'])) {
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['usuario_id'] = $usuario['id'];
            header('Location: tecj.php');
            exit;
        }
    }
    $erro = 'Email ou senha incorretos!';
}

// Processar cadastro
if ($_POST['cadastro'] ?? false) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validações
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro_cadastro = 'Todos os campos são obrigatórios!';
    } elseif ($senha !== $confirmar_senha) {
        $erro_cadastro = 'As senhas não coincidem!';
    } elseif (strlen($senha) < 6) {
        $erro_cadastro = 'A senha deve ter pelo menos 6 caracteres!';
    } else {
        // Verificar se email já existe
        $email_existe = false;
        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                $email_existe = true;
                break;
            }
        }
        
        if ($email_existe) {
            $erro_cadastro = 'Este email já está cadastrado!';
        } else {
            // Cadastrar novo usuário
            $novo_usuario = [
                'id' => count($usuarios) + 1,
                'nome' => $nome,
                'email' => $email,
                'senha' => password_hash($senha, PASSWORD_DEFAULT)
            ];
            
            $usuarios[] = $novo_usuario;
            file_put_contents($usuarios_file, json_encode($usuarios));
            
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $nome;
            $_SESSION['usuario_id'] = $novo_usuario['id'];
            header('Location: tecj.php');
            exit;
        }
    }
}

$modo = $_GET['modo'] ?? 'login';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $modo === 'login' ? 'Login' : 'Cadastro' ?> - TECJ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 1;
        }
        
        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            border-radius: 25px 25px 0 0;
            background-size: 200% 100%;
            animation: gradient 3s ease infinite;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .logo {
            text-align: center;
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            position: relative;
        }
        
        .logo::after {
            content: '🚀';
            position: absolute;
            top: -10px;
            right: -20px;
            font-size: 1.5rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 2rem;
            font-weight: 400;
        }
        
        .tab-container {
            display: flex;
            background: #f1f5f9;
            border-radius: 15px;
            padding: 5px;
            margin-bottom: 2rem;
        }
        
        .tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            text-decoration: none;
            color: #64748b;
        }
        
        .tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .input-container {
            position: relative;
        }
        
        .input-container input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .input-container input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }
        
        .input-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .input-container:focus-within::after {
            width: 100%;
        }
        
        .btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
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
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
            border-left-color: #ef4444;
        }
        
        .login-info {
            background: linear-gradient(135deg, #f0f9ff, #dbeafe);
            color: #1e40af;
            border-left-color: #3b82f6;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-info strong {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatShapes 15s infinite linear;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 10s;
        }
        
        @keyframes floatShapes {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.3; }
            100% { transform: translateY(0px) rotate(360deg); opacity: 0.7; }
        }
        
        @media (max-width: 480px) {
            .auth-container {
                margin: 20px;
                padding: 2rem;
            }
            .logo {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="auth-container">
        <div class="logo">TECJ</div>
        <div class="subtitle">Plataforma de Conexões Profissionais</div>
        
        <div class="tab-container">
            <a href="auth.php?modo=login" class="tab <?= $modo === 'login' ? 'active' : '' ?>">Login</a>
            <a href="auth.php?modo=cadastro" class="tab <?= $modo === 'cadastro' ? 'active' : '' ?>">Cadastro</a>
        </div>
        
        <?php if ($modo === 'login'): ?>
            <div class="login-info">
                <strong>🔑 Dados para teste:</strong>
                Email: admin@tecj.com<br>
                Senha: 123456
            </div>
            
            <?php if (isset($erro)): ?>
                <div class="alert alert-error">❌ <?= $erro ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <div class="input-container">
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="senha">🔒 Senha:</label>
                    <div class="input-container">
                        <input type="password" id="senha" name="senha" required>
                    </div>
                </div>
                
                <button type="submit" name="login" value="1" class="btn">🚀 Entrar</button>
            </form>
            
        <?php else: ?>
            <?php if (isset($erro_cadastro)): ?>
                <div class="alert alert-error">❌ <?= $erro_cadastro ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="nome">👤 Nome Completo:</label>
                    <div class="input-container">
                        <input type="text" id="nome" name="nome" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <div class="input-container">
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="senha">🔒 Senha:</label>
                    <div class="input-container">
                        <input type="password" id="senha" name="senha" required minlength="6">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirmar_senha">🔒 Confirmar Senha:</label>
                    <div class="input-container">
                        <input type="password" id="confirmar_senha" name="confirmar_senha" required minlength="6">
                    </div>
                </div>
                
                <button type="submit" name="cadastro" value="1" class="btn">✨ Criar Conta</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>