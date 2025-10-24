-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS professional_network CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE professional_network;

-- Tabela de empresas
CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    setor VARCHAR(100),
    localizacao VARCHAR(255),
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de usuários (simplificada)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de candidaturas
CREATE TABLE IF NOT EXISTS candidaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    empresa_id INT NOT NULL,
    status ENUM('pendente', 'aceita', 'rejeitada') DEFAULT 'pendente',
    data_candidatura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    observacoes TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_candidatura (usuario_id, empresa_id)
);

-- Inserir empresas de exemplo
INSERT INTO empresas (nome, setor, localizacao, descricao) VALUES
('TechCorp Brasil', 'Tecnologia', 'São Paulo, SP', 'Empresa líder em soluções tecnológicas inovadoras'),
('InnovaSoft', 'Software', 'Rio de Janeiro, RJ', 'Desenvolvimento de software personalizado'),
('DataScience Pro', 'Análise de Dados', 'Belo Horizonte, MG', 'Especialistas em ciência de dados e IA'),
('CloudTech Solutions', 'Cloud Computing', 'Porto Alegre, RS', 'Soluções em nuvem para empresas'),
('StartupHub', 'Incubadora', 'Florianópolis, SC', 'Aceleradora de startups inovadoras'),
('FinTech Brasil', 'Fintech', 'São Paulo, SP', 'Soluções financeiras digitais'),
('EcoTech', 'Sustentabilidade', 'Curitiba, PR', 'Tecnologia para sustentabilidade ambiental'),
('HealthTech', 'Saúde Digital', 'Brasília, DF', 'Inovação em tecnologia médica'),
('EduTech', 'Educação', 'Recife, PE', 'Plataformas educacionais digitais'),
('GameDev Studio', 'Jogos', 'Salvador, BA', 'Desenvolvimento de jogos mobile e web');

-- Inserir usuário de exemplo
INSERT INTO usuarios (nome, email) VALUES
('Usuário Teste', 'usuario@teste.com');

-- Inserir algumas candidaturas de exemplo
INSERT INTO candidaturas (usuario_id, empresa_id, status) VALUES
(1, 1, 'pendente'),
(1, 3, 'aceita'),
(1, 5, 'rejeitada');