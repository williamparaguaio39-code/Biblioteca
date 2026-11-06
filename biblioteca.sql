-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/11/2026 às 01:28
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
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `id` int(11) NOT NULL,
  `livroId` int(11) NOT NULL,
  `leitorId` int(11) NOT NULL,
  `dataEmprestimo` date NOT NULL,
  `dataPrevista` date NOT NULL,
  `dataDevolucao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `emprestimo`
--

INSERT INTO `emprestimo` (`id`, `livroId`, `leitorId`, `dataEmprestimo`, `dataPrevista`, `dataDevolucao`) VALUES
(4, 1, 1, '2025-08-10', '2025-08-20', '2025-08-19'),
(5, 2, 2, '2025-09-05', '2025-09-10', '2026-10-22'),
(6, 3, 3, '2026-10-22', '2026-11-05', NULL),
(7, 4, 1, '2025-09-01', '2025-09-08', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `leitor`
--

CREATE TABLE `leitor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `leitor`
--

INSERT INTO `leitor` (`id`, `nome`, `telefone`) VALUES
(1, 'Maria Silva', '61999999999'),
(2, 'João Pereira', '61888888888'),
(3, 'Ana Costa', '61777777777');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

CREATE TABLE `livro` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `livro`
--

INSERT INTO `livro` (`id`, `codigo`, `titulo`, `autor`) VALUES
(1, 'LIV-001', 'Dom Casmurro', 'Machado de Assis'),
(2, 'LIV-002', '1984', 'George Orwell'),
(3, 'LIV-003', 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry'),
(4, 'LIV-004', 'Clean Code', 'Robert C. Martin'),
(7, 'LIV-1000', 'meu teste', 'seu nome');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livroId` (`livroId`),
  ADD KEY `leitorId` (`leitorId`);

--
-- Índices de tabela `leitor`
--
ALTER TABLE `leitor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `leitor`
--
ALTER TABLE `leitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`livroId`) REFERENCES `livro` (`id`),
  ADD CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`leitorId`) REFERENCES `leitor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
