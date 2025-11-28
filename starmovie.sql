-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/11/2025 às 02:37
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
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `titulos`
--

INSERT INTO `titulos` (`id_titulos`, `nome_filmes`, `tipo`, `nome_serie`, `sinopse`, `imagem`, `id_usuario`) VALUES
(58, '', 'Série', 'outer banks', 'amigos', 'img/690e9c98ba4a5-WhatsApp Image 2025-11-05 at 20.17.10.jpeg','$id_usuario');

-- --------------------------------------------------------

--
-- Estrutura para tabela `titulo_genero`
--

CREATE TABLE `titulo_genero` (
  `fk_generos_id_generos` int(11) DEFAULT NULL,
  `fk_titulos_id_titulos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `titulo_genero`
--

INSERT INTO `titulo_genero` (`fk_generos_id_generos`, `fk_titulos_id_titulos`) VALUES
(1, 58);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`) VALUES
(1, 'GRUPO Etecflix', 'etecflix@etec.com', '$2y$10$9mMZJhMx3qUs7pTu3mtK1OgDSCXBoM/eEefyg9n1pdPDCKxzKMz7m'),
(2, 'helo', 'heloisa@email.com', '$2y$10$uTqzktvD4ukPAKH92oKe0O4Wg3OhGfe8gM6pB/PLcaXbZkUAh7hQ.'),
(3, 'maria', 'maria@gmail.com', '$2y$10$KdXu7Rg3UAGQkmZfGjVQWOW2mIpAb25pnAWQ/oQCRKywlfwy/Gls.'),
(4, 'helo', 'desd@gmail.com', '$2y$10$5uXt/DYALKLfEnIqZ0ElSedjm9rDfBy.24ACKlyCbPrWzJbLaypTW'),
(5, 'maria', 'edu.rodrigues4002@gmail.com', '$2y$10$nf0mV./x1PHVuQ1XApShYuLqYrcII8fK0Fw9DW9re.vfZflM5w.Ta'),
(6, 'joao', 'heloisalimarodrigues83@gmail.com', '$2y$10$w4cDjmyzL0HUyyUOahMKMOqMXXlQ6L.zdEc4Ki/I2ywIvW/h0njHC');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id_generos`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reviews_1` (`fk_titulos_id_titulos`),
  ADD KEY `FK_reviews_2` (`fk_usuarios_id_usuario`);

--
-- Índices de tabela `titulos`
--
ALTER TABLE `titulos`
  ADD PRIMARY KEY (`id_titulos`);

--
-- Índices de tabela `titulo_genero`
--
ALTER TABLE `titulo_genero`
  ADD KEY `FK_titulo_genero_1` (`fk_generos_id_generos`),
  ADD KEY `FK_titulo_genero_2` (`fk_titulos_id_titulos`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id_generos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `titulos`
--
ALTER TABLE `titulos`
  MODIFY `id_titulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_1` FOREIGN KEY (`fk_titulos_id_titulos`) REFERENCES `titulos` (`id_titulos`),
  ADD CONSTRAINT `FK_reviews_2` FOREIGN KEY (`fk_usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `titulo_genero`
--
ALTER TABLE `titulo_genero`
  ADD CONSTRAINT `FK_titulo_genero_1` FOREIGN KEY (`fk_generos_id_generos`) REFERENCES `generos` (`id_generos`),
  ADD CONSTRAINT `FK_titulo_genero_2` FOREIGN KEY (`fk_titulos_id_titulos`) REFERENCES `titulos` (`id_titulos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
