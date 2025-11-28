-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2025 às 05:03
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `starmovie`
--
CREATE DATABASE starmovie;
USE starmovie;
-- --------------------------------------------------------

--
-- Estrutura para tabela `generos`
--

CREATE TABLE `generos` (
  `id_generos` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `generos`
--

INSERT INTO `generos` (`id_generos`, `nome`) VALUES
(1, 'Ação'),
(2, 'Animação'),
(3, 'Comédia'),
(4, 'Romance'),
(5, 'Suspense'),
(6, 'Terror'),
(7, 'Drama');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `fk_titulos_id_titulos` int(11) DEFAULT NULL,
  `fk_usuarios_id_usuario` int(11) DEFAULT NULL,
  `nota` decimal(10,0) DEFAULT NULL,
  `titulo_reviews` varchar(200) DEFAULT NULL,
  `conteudo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `titulos`
--

CREATE TABLE `titulos` (
  `id_titulos` int(11) NOT NULL,
  `nome_filmes` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `nome_serie` varchar(255) DEFAULT NULL,
  `sinopse` varchar(200) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `titulos`
--

INSERT INTO `titulos` (`id_titulos`, `nome_filmes`, `tipo`, `nome_serie`, `sinopse`, `imagem`, `id_usuario`) VALUES
(9, 'nhvgh', 'Filme', '', 'jhbhg', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `titulo_genero`
--

CREATE TABLE `titulo_genero` (
  `id` int(11) NOT NULL,
  `fk_titulos_id_titulos` int(11) NOT NULL,
  `fk_generos_id_generos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `titulo_genero`
--

INSERT INTO `titulo_genero` (`id`, `fk_titulos_id_titulos`, `fk_generos_id_generos`) VALUES
(3, 0, 1),
(11, 9, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`) VALUES
(1, 'helo', 'heloisa@gmail.com', '$2y$10$9752shNYZwrDctfzV39SA.KkOsi5gTjiqhfVw2b3j1Z2WgcQEqZQu'),
(2, 'helo', 'edu.rodrigues4002@gmail.com', '$2y$10$kOPU0ZAPaaQ5f4eC05OVuux4dpv./cBJk1ciYTPqFZXEzHWabpb9.'),
(3, 'gabi', 'gabizinha@gmail.com', '$2y$10$sI.TFHr2fiGnxaNkGGkruu1JqefSxdEODz/xVI5Gd7IjgdsBhC1ke');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id_generos`);

--
-- Índices de tabela `titulos`
--
ALTER TABLE `titulos`
  ADD PRIMARY KEY (`id_titulos`);

--
-- Índices de tabela `titulo_genero`
--
ALTER TABLE `titulo_genero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_titulos_id_titulos` (`fk_titulos_id_titulos`),
  ADD KEY `fk_generos_id_generos` (`fk_generos_id_generos`);

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
-- AUTO_INCREMENT de tabela `titulos`
--
ALTER TABLE `titulos`
  MODIFY `id_titulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `titulo_genero`
--
ALTER TABLE `titulo_genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `titulo_genero`
--
ALTER TABLE `titulo_genero`
  ADD CONSTRAINT `titulo_genero_ibfk_1` FOREIGN KEY (`fk_titulos_id_titulos`) REFERENCES `titulos` (`id_titulos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `titulo_genero_ibfk_2` FOREIGN KEY (`fk_generos_id_generos`) REFERENCES `generos` (`id_generos`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
