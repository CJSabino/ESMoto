-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/11/2025 às 22:14
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
-- Banco de dados: `motos_es`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `motos`
--

CREATE TABLE `motos` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `cilindrada` int(11) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `km` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `motos`
--

INSERT INTO `motos` (`id`, `marca`, `modelo`, `cilindrada`, `ano`, `km`, `preco`, `imagem`) VALUES
(10, 'Yamaha', 'Teste1', 160, 2025, 1000, 20000.00, 'uploads/imagem_2025-11-18_022129999.png'),
(11, 'Kawasaki', 'Teste2', 160, 2026, 2000, 30000.00, 'uploads/WhatsApp Image 2025-11-17 at 14.09.10.jpeg'),
(12, 'Honda', 'Teste3', 760, 2024, 3000, 60000.00, 'uploads/imagem_2025-11-18_022534722.png'),
(13, 'Harley-Davidson', 'Teste4', 720, 2026, 1000, 60000.00, 'uploads/WhatsApp Image 2025-11-17 at 14.09.11 (1).jpeg'),
(14, 'Suzuki', 'ModeloT', 560, 2025, 100, 40000.00, 'uploads/imagem_2025-11-18_022748728.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_admin`
--

CREATE TABLE `usuarios_admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id`, `usuario`, `senha`) VALUES
(1, 'admin', '$2y$10$pCjnlt.EZJaAuNUVQz7tIO9jls745phYkqeBXI0jEvnQnqKSGS20i');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `motos`
--
ALTER TABLE `motos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `motos`
--
ALTER TABLE `motos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
