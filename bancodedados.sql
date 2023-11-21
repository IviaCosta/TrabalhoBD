-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21/11/2023 às 22:32
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `TrabalhoBD`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Acesso_Realizado`
--

CREATE TABLE `Acesso_Realizado` (
  `id_compra` int(6) NOT NULL,
  `data_acesso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Acesso_Realizado`
--

INSERT INTO `Acesso_Realizado` (`id_compra`, `data_acesso`) VALUES
(1, '2023-11-21 18:27:43'),
(3, '2023-11-21 18:28:08'),
(4, '2023-11-21 18:26:44'),
(5, '2023-11-21 18:26:57');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Administrador`
--

CREATE TABLE `Administrador` (
  `email` varchar(20) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `id_Adm` int(6) NOT NULL,
  `salario` decimal(10,2) NOT NULL DEFAULT 3000.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Administrador`
--

INSERT INTO `Administrador` (`email`, `senha`, `nome`, `id_Adm`, `salario`) VALUES
('ivia@bd.com', '1234', 'Ivia Administradora', 1, 3000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Cliente`
--

CREATE TABLE `Cliente` (
  `nome` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `id_Cliente` int(6) NOT NULL,
  `data_ingresso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Cliente`
--

INSERT INTO `Cliente` (`nome`, `email`, `senha`, `id_Cliente`, `data_ingresso`) VALUES
('Ivia Cliente', 'iviacliente@bd.com', '1234', 1, '2023-11-19'),
('Elisa', 'elisa@bd.com', '1234', 3, '2023-11-19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `COMPRA`
--

CREATE TABLE `COMPRA` (
  `data` date DEFAULT current_timestamp(),
  `valor` decimal(10,2) NOT NULL,
  `id_compra` int(6) NOT NULL,
  `aprovacao` tinyint(1) NOT NULL DEFAULT 0,
  `id_curso` int(6) NOT NULL,
  `id_cliente` int(6) NOT NULL,
  `id_adm` int(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `COMPRA`
--

INSERT INTO `COMPRA` (`data`, `valor`, `id_compra`, `aprovacao`, `id_curso`, `id_cliente`, `id_adm`) VALUES
('2023-11-19', 249.00, 1, 1, 1, 1, 1),
('2023-11-20', 200.00, 3, 1, 14, 3, 1),
('2023-11-20', 229.99, 4, 1, 9, 1, 1),
('2023-11-21', 179.99, 5, 1, 7, 1, 1);

--
-- Acionadores `COMPRA`
--
DELIMITER $$
CREATE TRIGGER `Trigger_criarAcesso` AFTER INSERT ON `COMPRA` FOR EACH ROW BEGIN
INSERT INTO Acesso_Realizado VALUES (NEW.id_compra, NULL);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Curso`
--

CREATE TABLE `Curso` (
  `nome` varchar(30) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `duracao` decimal(10,2) NOT NULL,
  `id_curso` int(6) NOT NULL,
  `id_professor` int(6) NOT NULL
) ;

--
-- Despejando dados para a tabela `Curso`
--

INSERT INTO `Curso` (`nome`, `descricao`, `valor`, `duracao`, `id_curso`, `id_professor`) VALUES
('Java', 'Explore os fundamentos da programação Java neste curso abrangente. Desde conceitos básicos até tópicos avançados, você dominará a linguagem de programação mais utilizada no mundo.', 249.99, 150.00, 1, 0),
('Flutter', 'Aprenda a criar aplicativos móveis incríveis usando Flutter. Este curso abrange o desenvolvimento multiplataforma para iOS e Android.', 279.99, 160.00, 2, 0),
('Python', 'Aprofunde-se no universo da programação com Python, uma linguagem versátil e poderosa. Este curso oferece uma introdu', 199.99, 120.00, 3, 0),
('C++', 'Descubra as complexidades da programação em C++. Este curso aborda desde a sintaxe básica até tópicos avançados, proporcionando uma compreensão sólida dessa linguagem de programação poderosa.', 99.99, 220.00, 4, 0),
('JavaScript', 'Entre no mundo dinâmico do desenvolvimento web com JavaScript. Este curso explora os fundamentos da linguagem e como ela é usada para criar interatividade e dinamismo nas páginas web.', 149.99, 90.00, 5, 0),
('HTML', 'Aprenda a estrutura e o estilo da web com este curso introdutório de HTML/CSS. Desde a criação de páginas simples até o design responsivo, você adquirirá habilidades essenciais para desenvolvimento web.', 51.00, 60.00, 6, 0),
('SQL', 'Mergulhe no universo dos bancos de dados com SQL. Este curso ensina os princípios do SQL, desde consultas básicas até operações avançadas, permitindo que você gerencie dados de maneira eficiente.', 179.99, 120.00, 7, 0),
('React', 'Construa interfaces de usuário modernas e reativas com React. Este curso abrange os conceitos essenciais e as práticas recomendadas para o desenvolvimento eficaz de aplicações web usando esta biblioteca JavaScript.', 219.99, 150.00, 8, 0),
('Angular', 'Aprenda a desenvolver aplicações web escaláveis e robustas com Angular. Este curso explora os recursos poderosos do framework, proporcionando uma compreensão aprofundada de como construir aplicações web dinâmicas.', 229.99, 160.00, 9, 0),
('Node.js', 'Entre no mundo do desenvolvimento de servidor com Node.js. Este curso abrange a construção de aplicativos escaláveis, desde o básico até a criação de APIs RESTful eficientes.', 189.99, 120.00, 10, 0),
('PHP', 'Explore as possibilidades de desenvolvimento web do lado do servidor com PHP. Este curso fornece uma introdução prática à linguagem, permitindo que você crie aplicações web dinâmicas.', 169.99, 100.00, 11, 0),
('Swift', 'Desenvolva aplicativos incríveis para dispositivos iOS com Swift. Este curso explora os conceitos fundamentais da linguagem e fornece as habilidades necessárias para criar aplicações iOS modernas.', 259.99, 140.00, 12, 0),
('Ruby', 'Entre no mundo elegante e expressivo da programação Ruby. Este curso abrange desde os conceitos básicos até o desenvolvimento avançado, capacitando você a criar aplicações Ruby eficientes.', 209.99, 130.00, 13, 0),
('C Sharp', 'Mergulhe no desenvolvimento de aplicações Windows e web com C#. Este curso explora os recursos poderosos da linguagem, proporcionando uma base sólida para a criação de aplicativos robustos.', 239.99, 170.00, 14, 0),
('Segurança', 'Explore os fundamentos da segurança cibernética, incluindo criptografia, detecção de ameaças e práticas recomendadas para proteger sistemas e dados.', 199.99, 120.00, 15, 0),
('Data Science', 'Aprofunde-se na análise de dados e descubra insights valiosos com este curso de Data Science. Desde a coleta e limpeza de dados até a visualização e interpretação, você dominará as habilidades essenciais para o campo.', 279.99, 180.00, 16, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Professor`
--

CREATE TABLE `Professor` (
  `nome` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `especialidade` varchar(200) DEFAULT NULL,
  `id_professor` int(6) NOT NULL,
  `salario` decimal(10,2) NOT NULL DEFAULT 5000.00,
  `data_ingresso` date NOT NULL DEFAULT current_timestamp(),
  `cursos_vendidos` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Professor`
--

INSERT INTO `Professor` (`nome`, `email`, `senha`, `especialidade`, `id_professor`, `salario`, `data_ingresso`, `cursos_vendidos`) VALUES
('evandrino', 'evandrino@bd.com', '1234', 'Banco de Dados', 0, 5000.00, '2023-11-16', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Acesso_Realizado`
--
ALTER TABLE `Acesso_Realizado`
  ADD PRIMARY KEY (`id_compra`);

--
-- Índices de tabela `Administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`id_Adm`);

--
-- Índices de tabela `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`id_Cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `COMPRA`
--
ALTER TABLE `COMPRA`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `FK_id_curso` (`id_curso`),
  ADD KEY `FK_id_cliente` (`id_cliente`),
  ADD KEY `FK_id_adm` (`id_adm`);

--
-- Índices de tabela `Curso`
--
ALTER TABLE `Curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `FK_id_professor` (`id_professor`);

--
-- Índices de tabela `Professor`
--
ALTER TABLE `Professor`
  ADD PRIMARY KEY (`id_professor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Administrador`
--
ALTER TABLE `Administrador`
  MODIFY `id_Adm` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `Cliente`
--
ALTER TABLE `Cliente`
  MODIFY `id_Cliente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `COMPRA`
--
ALTER TABLE `COMPRA`
  MODIFY `id_compra` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `Curso`
--
ALTER TABLE `Curso`
  MODIFY `id_curso` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Professor`
--
ALTER TABLE `Professor`
  MODIFY `id_professor` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Acesso_Realizado`
--
ALTER TABLE `Acesso_Realizado`
  ADD CONSTRAINT `FK_id_compra` FOREIGN KEY (`id_compra`) REFERENCES `COMPRA` (`id_compra`);

--
-- Restrições para tabelas `COMPRA`
--
ALTER TABLE `COMPRA`
  ADD CONSTRAINT `FK_id_adm` FOREIGN KEY (`id_adm`) REFERENCES `Administrador` (`id_Adm`),
  ADD CONSTRAINT `FK_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_Cliente`),
  ADD CONSTRAINT `FK_id_curso` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`);

--
-- Restrições para tabelas `Curso`
--
ALTER TABLE `Curso`
  ADD CONSTRAINT `FK_id_professor` FOREIGN KEY (`id_professor`) REFERENCES `Professor` (`id_professor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
