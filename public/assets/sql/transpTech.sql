CREATE DATABASE IF NOT EXISTS transp_tech
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE transp_tech;


-- 1. Cadastro de produtos
CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    peso DECIMAL(10,2) DEFAULT 0,
    valor DECIMAL(10,2) DEFAULT 0,
    quantidade_estoque INT DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Endereços de origem e destino
CREATE TABLE enderecos (
    id_endereco INT AUTO_INCREMENT PRIMARY KEY,
    identificacao VARCHAR(100) NOT NULL,
    logradouro VARCHAR(150) NOT NULL,
    numero VARCHAR(20),
    complemento VARCHAR(100),
    bairro VARCHAR(100),
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep VARCHAR(9),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Transportadores
CREATE TABLE transportadores (
    id_transportador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    documento VARCHAR(20),
    telefone VARCHAR(20),
    tipo_veiculo VARCHAR(60),
    placa VARCHAR(10),
    ativo BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo_usuario VARCHAR(20) DEFAULT 'funcionario',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Fretes
CREATE TABLE fretes (
    id_frete INT AUTO_INCREMENT PRIMARY KEY,
    transportador_id INT NOT NULL,
    endereco_origem_id INT NOT NULL,
    endereco_destino_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_frete DATE NOT NULL,
    valor_frete DECIMAL(10,2) NOT NULL DEFAULT 0,
    status ENUM(
        'Pendente',
        'Em transporte',
        'Entregue',
        'Cancelado'
    ) DEFAULT 'Pendente',
    observacoes TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (transportador_id)
        REFERENCES transportadores(id_transportador),

    FOREIGN KEY (endereco_origem_id)
        REFERENCES enderecos(id_endereco),

    FOREIGN KEY (endereco_destino_id)
        REFERENCES enderecos(id_endereco),

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id_usuario)
);

-- 6. Produtos relacionados a cada frete
CREATE TABLE frete_produtos (
    id_frete_produtos INT AUTO_INCREMENT PRIMARY KEY,
    frete_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,

    FOREIGN KEY (frete_id)
        REFERENCES fretes(id_frete)
        ON DELETE CASCADE,

    FOREIGN KEY (produto_id)
        REFERENCES produtos(id_produto),

    UNIQUE (frete_id, produto_id)
);



-- Índice para facilitar o relatório por data
CREATE INDEX idx_fretes_data ON fretes(data_frete);