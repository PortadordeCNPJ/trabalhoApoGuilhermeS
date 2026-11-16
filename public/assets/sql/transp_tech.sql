-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/11/2026 às 23:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `transp_tech`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id_endereco` int(11) NOT NULL,
  `identificacao` varchar(100) NOT NULL,
  `logradouro` varchar(150) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `identificacao`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `criado_em`) VALUES
(1, 'Empresa ao lado da coca-cola (Alpha Com)', 'Rua dos machados', 'S/N', 'KM54 BR 288', 'Santa Cruz', 'Cascavel', 'PR', '85820570', '2026-11-12 21:48:43'),
(2, 'Kabum', 'Avenida Marechal Arthur da Costa e Silva', '835', 'Galpao', 'Jardim Gloria', 'Limeira', 'SP', '13487220', '2026-11-15 14:13:29'),
(3, 'Magalu do centro Cascavel', 'Av Brasil', '567', 'Centro', 'Centro', 'Cascavel', 'PR', '85820570', '2026-11-16 22:07:43'),
(4, 'Rua cabral casa', 'Rua cabral', '835', 'Casa de esquina', 'Santa Cruz', 'Cascavel', 'PR', '85820556', '2026-11-16 22:08:21'),
(5, 'Casas BAHIA', 'Av Brasil', '12312', 'Centro', 'Centro', 'Cascavel', 'PR', '85820324', '2026-11-16 22:21:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fretes`
--

CREATE TABLE `fretes` (
  `id_frete` int(11) NOT NULL,
  `transportador_id` int(11) NOT NULL,
  `endereco_origem_id` int(11) NOT NULL,
  `endereco_destino_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_frete` date NOT NULL,
  `valor_frete` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pendente','Em transporte','Entregue','Cancelado') DEFAULT 'Pendente',
  `observacoes` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `fretes`
--

INSERT INTO `fretes` (`id_frete`, `transportador_id`, `endereco_origem_id`, `endereco_destino_id`, `usuario_id`, `data_frete`, `valor_frete`, `status`, `observacoes`, `criado_em`) VALUES
(1, 1, 2, 1, 1, '2026-12-02', 89.00, 'Pendente', 'Produto Frágil. Tomar cuidado.', '2026-11-15 14:15:24'),
(3, 1, 2, 1, 1, '2026-11-18', 234.03, 'Pendente', 'Tomar cuidado', '2026-11-15 22:55:42'),
(4, 2, 3, 4, 1, '2026-11-16', 30.22, 'Pendente', 'Tomar cuidado, frágil.', '2026-11-16 22:09:52'),
(5, 3, 5, 4, 1, '2026-11-16', 12.00, 'Pendente', 'Tomar cuidado', '2026-11-16 22:22:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `frete_produtos`
--

CREATE TABLE `frete_produtos` (
  `id_frete_produtos` int(11) NOT NULL,
  `frete_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `frete_produtos`
--

INSERT INTO `frete_produtos` (`id_frete_produtos`, `frete_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 1, 4),
(2, 3, 4, 45),
(3, 4, 5, 43),
(4, 4, 2, 2),
(5, 5, 4, 123),
(6, 5, 6, 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT 0.00,
  `valor` decimal(10,2) DEFAULT 0.00,
  `quantidade_estoque` int(11) DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `descricao`, `peso`, `valor`, `quantidade_estoque`, `criado_em`) VALUES
(1, 'Notebook', 'Notebook para uso profissional', 2.50, 3500.00, 11, '2026-10-29 18:51:17'),
(2, 'Monitor', 'Monitor LED de 24 polegadas', 4.20, 950.00, 18, '2026-10-29 18:51:17'),
(3, 'Teclado Mecânico', 'Teclado USB para computadores', 0.90, 280.00, 35, '2026-10-29 18:51:17'),
(4, 'SSD NVME', 'SSD NVMe 2TB Kingston', 100.00, 8000.00, 332, '2026-10-30 00:06:25'),
(5, 'Teste 2', 'Caixa pesada de tablets', 600.00, 6900.00, 2, '2026-11-16 22:05:30'),
(6, 'Tv 44pol 4k', 'Tvs', 12.00, 4000.00, 19, '2026-11-16 22:18:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transportadores`
--

CREATE TABLE `transportadores` (
  `id_transportador` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `tipo_veiculo` varchar(60) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `transportadores`
--

INSERT INTO `transportadores` (`id_transportador`, `nome`, `documento`, `telefone`, `tipo_veiculo`, `placa`, `ativo`, `criado_em`) VALUES
(1, 'Guilherme e CIA LTDA', '99999999000199', '45991349999', 'Van', 'BNH1322', 1, '2026-11-12 21:03:49'),
(2, 'Marlon', '99999999000190', '45991349994', 'Carro', 'ABC1H34', 1, '2026-11-16 22:04:14'),
(3, 'Lauro', '99999999000192', '45991349912', 'Caminhão', 'ABC1H67', 1, '2026-11-16 22:17:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` varchar(20) DEFAULT 'funcionario',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `tipo_usuario`, `criado_em`) VALUES
(1, 'Guilherme', 'guilherme@transptech.com', '202cb962ac59075b964b07152d234b70', 'admin', '2026-10-22 17:53:56'),
(2, 'teste', 'testeuser@gmail.com', '550e1bafe077ff0b0b67f4e32f29d751', 'motorista', '2026-11-12 13:57:49'),
(3, 'Teste1', 'teste1@gmail.com', '550e1bafe077ff0b0b67f4e32f29d751', 'usuario', '2026-11-15 15:24:25'),
(4, 'Teste2', 'teste2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'usuario', '2026-11-15 19:15:20'),
(5, 'teste 3', 'teste3@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'usuario', '2026-11-16 22:06:21'),
(6, 'Teste 4', 'teste4@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'usuario', '2026-11-16 22:19:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Índices de tabela `fretes`
--
ALTER TABLE `fretes`
  ADD PRIMARY KEY (`id_frete`),
  ADD KEY `transportador_id` (`transportador_id`),
  ADD KEY `endereco_origem_id` (`endereco_origem_id`),
  ADD KEY `endereco_destino_id` (`endereco_destino_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_fretes_data` (`data_frete`);

--
-- Índices de tabela `frete_produtos`
--
ALTER TABLE `frete_produtos`
  ADD PRIMARY KEY (`id_frete_produtos`),
  ADD UNIQUE KEY `frete_id` (`frete_id`,`produto_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `transportadores`
--
ALTER TABLE `transportadores`
  ADD PRIMARY KEY (`id_transportador`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fretes`
--
ALTER TABLE `fretes`
  MODIFY `id_frete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `frete_produtos`
--
ALTER TABLE `frete_produtos`
  MODIFY `id_frete_produtos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `transportadores`
--
ALTER TABLE `transportadores`
  MODIFY `id_transportador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `fretes`
--
ALTER TABLE `fretes`
  ADD CONSTRAINT `fretes_ibfk_1` FOREIGN KEY (`transportador_id`) REFERENCES `transportadores` (`id_transportador`),
  ADD CONSTRAINT `fretes_ibfk_2` FOREIGN KEY (`endereco_origem_id`) REFERENCES `enderecos` (`id_endereco`),
  ADD CONSTRAINT `fretes_ibfk_3` FOREIGN KEY (`endereco_destino_id`) REFERENCES `enderecos` (`id_endereco`),
  ADD CONSTRAINT `fretes_ibfk_4` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `frete_produtos`
--
ALTER TABLE `frete_produtos`
  ADD CONSTRAINT `frete_produtos_ibfk_1` FOREIGN KEY (`frete_id`) REFERENCES `fretes` (`id_frete`) ON DELETE CASCADE,
  ADD CONSTRAINT `frete_produtos_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
