CREATE TABLE perfis 
( 
 id_perfil INT PRIMARY KEY AUTO_INCREMENT,  
 nome VARCHAR(50) NOT NULL,  
 descricao VARCHAR(255)  
); 

CREATE TABLE usuarios 
( 
 id_usuario INT PRIMARY KEY AUTO_INCREMENT,  
 id_perfil INT NOT NULL,  
 nome VARCHAR(100) NOT NULL,  
 email VARCHAR(150) NOT NULL,  
 senha VARCHAR(255) NOT NULL,  
 ativo INT(1) NOT NULL DEFAULT '1',  
 data_cadastro DATETIME NOT NULL,  
 UNIQUE (email)
); 

CREATE TABLE clientes 
( 
 id_cliente INT PRIMARY KEY AUTO_INCREMENT,  
 tipo_cliente ENUM('PF','PJ') NOT NULL,  
 nome VARCHAR(150) NOT NULL,  
 cpf_cnpj VARCHAR(20) NOT NULL,  
 email VARCHAR(150),  
 telefone VARCHAR(20) NOT NULL,  
 ativo INT NOT NULL DEFAULT '1',  
 data_cadastro DATETIME NOT NULL,  
 UNIQUE (cpf_cnpj)
); 

CREATE TABLE enderecos 
( 
 id_endereco INT PRIMARY KEY AUTO_INCREMENT,  
 id_cliente INT NOT NULL,  
 cep VARCHAR(9) NOT NULL,  
 logradouro VARCHAR(150) NOT NULL,  
 numero VARCHAR(20) NOT NULL,  
 complemento VARCHAR(100),  
 bairro VARCHAR(100) NOT NULL,  
 cidade VARCHAR(100) NOT NULL,  
 estado CHAR(2) NOT NULL,  
 referencia VARCHAR(255)  
); 

CREATE TABLE veiculos 
( 
 id_veiculo INT PRIMARY KEY AUTO_INCREMENT,  
 placa VARCHAR(10) NOT NULL,  
 modelo VARCHAR(100) NOT NULL,  
 marca VARCHAR(100),  
 ano DATE,  
 capacidade_kg FLOAT NOT NULL,  
 ativo INT NOT NULL DEFAULT '1',  
 UNIQUE (placa)
); 

CREATE TABLE tarifas_frete 
( 
 id_tarifa INT PRIMARY KEY AUTO_INCREMENT,  
 nome VARCHAR NOT NULL,  
 tipo_servico VARCHAR NOT NULL,  
 tarifa_por_kg FLOAT NOT NULL,  
 tarifa_por_km FLOAT NOT NULL,  
 taxa_fixa FLOAT NOT NULL,  
 fator_cubagem FLOAT NOT NULL,  
 peso_minimo_cobravel FLOAT NOT NULL,  
 vigencia_inicio DATE NOT NULL,  
 vigencia_fim DATE,  
 ativo INT NOT NULL DEFAULT '1',  
); 

CREATE TABLE cotacoes_frete 
( 
 id_cotacao INT PRIMARY KEY AUTO_INCREMENT,  
 id_cliente INT,  
 id_origem_end INT NOT NULL,  
 id_destino INT NOT NULL,  
 id_tarifa INT NOT NULL,  
 tipo_servico VARCHAR NOT NULL,  
 peso_real FLOAT NOT NULL,  
 peso_cubado FLOAT NOT NULL,  
 peso_tarifavel FLOAT NOT NULL,  
 distancia_km INT NOT NULL,  
 valor_base FLOAT NOT NULL,  
 valor_adicional FLOAT NOT NULL DEFAULT '0',  
 valor_total FLOAT NOT NULL,  
 data_cotacao DATETIME NOT NULL,  
 validade DATE,  
 status VARCHAR NOT NULL,  
); 

CREATE TABLE motoristas 
( 
 id_motorista INT PRIMARY KEY AUTO_INCREMENT,  
 id_motorista VARCHAR NOT NULL,  
 cpf VARCHAR NOT NULL,  
 cnh VARCHAR NOT NULL,  
 categoria_cnh VARCHAR NOT NULL,  
 telefone VARCHAR NOT NULL,  
 ativo INT NOT NULL DEFAULT '1',  
 UNIQUE (cpf,cnh)
); 

CREATE TABLE remessas 
( 
 id_remessa INT PRIMARY KEY AUTO_INCREMENT,  
 codigo_rastreamento VARCHAR NOT NULL,  
 id_cliente INT,  
 id_cotacao INT,  
 id_origem INT,  
 id_destino INT,  
 data_postagem DATETIME NOT NULL,  
 previsao_entrega DATE,  
 peso_total FLOAT NOT NULL,  
 valor_frete FLOAT NOT NULL,  
 valor_declarado FLOAT NOT NULL DEFAULT '0',  
 status VARCHAR NOT NULL,  
 observacoes VARCHAR,  
 UNIQUE (codigo_rastreamento)
); 

CREATE TABLE volumes 
( 
 id_volume INT PRIMARY KEY AUTO_INCREMENT,  
 id_remessa INT NOT NULL,  
 descricao VARCHAR NOT NULL,  
 peso_kg FLOAT NOT NULL,  
 comprimento_cm VARCHAR NOT NULL,  
 largura_cm VARCHAR NOT NULL,  
 altura_cm FLOAT NOT NULL,  
 quantidade INT NOT NULL DEFAULT '1',  
); 

CREATE TABLE itens_remessa 
( 
 id_item INT PRIMARY KEY AUTO_INCREMENT,  
 id_remessa INT,  
 descricao VARCHAR NOT NULL,  
 quantidade INT NOT NULL,  
 valor_unitario FLOAT NOT NULL,  
 peso_unitario FLOAT,  
); 

CREATE TABLE coletas 
( 
 id_coleta INT PRIMARY KEY AUTO_INCREMENT,  
 id_remessa INT NOT NULL,  
 id_motorista INT,  
 id_endereco INT NOT NULL,  
 data_agendada DATETIME NOT NULL,  
 data_realizada DATETIME,  
 status VARCHAR NOT NULL,  
 observacoes VARCHAR,  
); 

CREATE TABLE viagens 
( 
 id_viagem INT PRIMARY KEY AUTO_INCREMENT,  
 id_motorista INT NOT NULL,  
 id_veiculo INT NOT NULL,  
 data_saida DATETIME NOT NULL,  
 data_prevista_retornov DATETIME,  
 data_retorno DATETIME,  
 status VARCHAR NOT NULL,  
 observacoes VARCHAR,  
); 

CREATE TABLE viagem_remessas 
( 
 id_viagem_remessa INT PRIMARY KEY AUTO_INCREMENT,  
 id_viagem INT NOT NULL,  
 id_remessa INT,  
 data_vinculo DATETIME NOT NULL,  
 status VARCHAR NOT NULL,  
); 

CREATE TABLE paradas_viagem 
( 
 id_parada INT PRIMARY KEY AUTO_INCREMENT,  
 id_viagem INT NOT NULL,  
 id_endereco INT NOT NULL,  
 ordem INT NOT NULL,  
 tipo_parada VARCHAR NOT NULL,  
 tipo_parada DATETIME,  
 chegada_real DATETIME,  
 status VARCHAR NOT NULL,  
 UNIQUE (tipo_parada)
); 

CREATE TABLE eventos_rastreamento 
( 
 id_evento INT PRIMARY KEY AUTO_INCREMENT,  
 id_remessa INT NOT NULL,  
 id_viagem INT,  
 id_usuario INT,  
 status VARCHAR NOT NULL,  
 descricao VARCHAR NOT NULL,  
 localizacao VARCHAR,  
 data_evento DATETIME NOT NULL,  
); 

CREATE TABLE entregas 
( 
 id_entrega INT PRIMARY KEY AUTO_INCREMENT,  
 id_remessa INT NOT NULL,  
 id_motorista INT,  
 data_saida_entrega DATETIME,  
 data_entrega DATETIME,  
 nome_recebedor VARCHAR,  
 documento_recebedor VARCHAR,  
 status INT NOT NULL,  
 observacoes VARCHAR,  
 UNIQUE (id_remessa)
); 

ALTER TABLE usuarios ADD FOREIGN KEY(id_perfil) REFERENCES perfis (id_perfil)
ALTER TABLE enderecos ADD FOREIGN KEY(id_cliente) REFERENCES clientes (id_cliente)
ALTER TABLE cotacoes_frete ADD FOREIGN KEY(id_cliente) REFERENCES clientes (id_cliente)
ALTER TABLE cotacoes_frete ADD FOREIGN KEY(id_origem_end) REFERENCES enderecos (id_origem_end)
ALTER TABLE cotacoes_frete ADD FOREIGN KEY(id_destino) REFERENCES enderecos (id_destino)
ALTER TABLE cotacoes_frete ADD FOREIGN KEY(id_tarifa) REFERENCES tarifas_frete (id_tarifa)
ALTER TABLE remessas ADD FOREIGN KEY(id_cliente) REFERENCES clientes (id_cliente)
ALTER TABLE remessas ADD FOREIGN KEY(id_cotacao) REFERENCES cotacoes_frete (id_cotacao)
ALTER TABLE remessas ADD FOREIGN KEY(id_origem) REFERENCES enderecos (id_origem)
ALTER TABLE remessas ADD FOREIGN KEY(id_destino) REFERENCES enderecos (id_destino)
ALTER TABLE volumes ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE itens_remessa ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE coletas ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE coletas ADD FOREIGN KEY(id_motorista) REFERENCES motoristas (id_motorista)
ALTER TABLE coletas ADD FOREIGN KEY(id_endereco) REFERENCES enderecos (id_endereco)
ALTER TABLE viagens ADD FOREIGN KEY(id_motorista) REFERENCES motoristas (id_motorista)
ALTER TABLE viagens ADD FOREIGN KEY(id_veiculo) REFERENCES veiculos (id_veiculo)
ALTER TABLE viagem_remessas ADD FOREIGN KEY(id_viagem) REFERENCES viagens (id_viagem)
ALTER TABLE viagem_remessas ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE paradas_viagem ADD FOREIGN KEY(id_viagem) REFERENCES viagens (id_viagem)
ALTER TABLE paradas_viagem ADD FOREIGN KEY(id_endereco) REFERENCES enderecos (id_endereco)
ALTER TABLE eventos_rastreamento ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE eventos_rastreamento ADD FOREIGN KEY(id_viagem) REFERENCES viagens (id_viagem)
ALTER TABLE eventos_rastreamento ADD FOREIGN KEY(id_usuario) REFERENCES usuarios (id_usuario)
ALTER TABLE entregas ADD FOREIGN KEY(id_remessa) REFERENCES remessas (id_remessa)
ALTER TABLE entregas ADD FOREIGN KEY(id_motorista) REFERENCES motoristas (id_motorista)
