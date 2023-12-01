-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24/11/2023 às 01:15
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
(15, '2023-11-23 21:08:08'),
(16, NULL),
(17, NULL),
(18, NULL),
(19, NULL);

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
('ivia@bd.com', '1234', 'Ivia Adm', 1, 3000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Cliente`
--

CREATE TABLE `Cliente` (
  `nome` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `id_Cliente` int(6) NOT NULL,
  `data_ingresso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Cliente`
--

INSERT INTO `Cliente` (`nome`, `email`, `senha`, `id_Cliente`, `data_ingresso`) VALUES
('Ivia Cliente', 'iviacliente@bd.com', '1234', 1, '2023-11-23'),
('Elisa Cliente', 'elisa@bd.com', '1234', 2, '2023-11-23'),
('João Cliente', 'joaocliente@bd.com', '1234', 4, '2023-11-23');

--
-- Acionadores `Cliente`
--
DELIMITER $$
CREATE TRIGGER `Trigger_dataIngressoCliente` BEFORE INSERT ON `Cliente` FOR EACH ROW BEGIN
    SET NEW.data_ingresso = CURDATE();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `COMPRA`
--

CREATE TABLE `COMPRA` (
  `data` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `id_compra` int(6) NOT NULL,
  `aprovacao` int(1) NOT NULL DEFAULT 0,
  `id_curso` int(6) NOT NULL,
  `id_cliente` int(6) NOT NULL,
  `id_adm` int(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `COMPRA`
--

INSERT INTO `COMPRA` (`data`, `valor`, `id_compra`, `aprovacao`, `id_curso`, `id_cliente`, `id_adm`) VALUES
('2023-11-23', 279.99, 15, 1, 2, 1, 1),
(NULL, 179.99, 16, 1, 7, 1, 1),
(NULL, 169.99, 17, 1, 11, 1, 1),
('2023-11-23', 189.99, 18, 1, 10, 1, 1),
('2023-11-23', 249.99, 19, 2, 1, 1, 1);

--
-- Acionadores `COMPRA`
--
DELIMITER $$
CREATE TRIGGER `Trigger_atualizaSalario` AFTER UPDATE ON `COMPRA` FOR EACH ROW BEGIN
    DECLARE oldSalario DECIMAL;
    DECLARE valorCurso DECIMAL;
    DECLARE salarioTotal DECIMAL;
    DECLARE id_prof INT;
    SET id_prof = (SELECT P.id_professor from Compra CO join Curso CU on CO.id_curso=CU.id_curso join Professor P on CU.id_professor=P.id_professor where CO.id_compra=NEW.id_compra);
    SET oldSalario = (SELECT P.salario from Professor P where P.id_professor = id_prof);
    SET valorCurso = (SELECT CU.valor from COMPRA CO JOIN CURSO CU ON CO.id_curso=CU.id_curso where CO.id_compra=NEW.id_compra); 
    SET salarioTotal = oldSalario + (0.9 * valorCurso);
    
UPDATE Professor P SET P.salario = salarioTotal where id_professor = id_prof;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_criarAcesso` AFTER INSERT ON `COMPRA` FOR EACH ROW BEGIN
INSERT INTO Acesso_Realizado VALUES (NEW.id_compra, NULL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_dataAprovacao` BEFORE UPDATE ON `COMPRA` FOR EACH ROW BEGIN
    SET NEW.data = CURDATE();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_numVendas` AFTER UPDATE ON `COMPRA` FOR EACH ROW BEGIN
    DECLARE id_prof INT;
SET id_prof = (SELECT P.id_professor from Compra CO join Curso CU on CO.id_curso=CU.id_curso join Professor P on CU.id_professor=P.id_professor where CO.id_compra=NEW.id_compra);
UPDATE Professor SET CURSOS_VENDIDOS = (SELECT count(*) FROM COMPRA CO JOIN CURSO CU ON CO.id_curso=CU.id_curso join Professor P on CU.id_professor=P.id_professor WHERE P.id_professor = id_prof and CO.aprovacao=1)where id_professor = id_prof;
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
  `salario` decimal(10,2) NOT NULL DEFAULT 0.00,
  `data_ingresso` datetime NOT NULL DEFAULT current_timestamp(),
  `cursos_vendidos` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Professor`
--

INSERT INTO `Professor` (`nome`, `email`, `senha`, `especialidade`, `id_professor`, `salario`, `data_ingresso`, `cursos_vendidos`) VALUES
('evandrino', 'evandrino@bd.com', '1234', 'Banco de Dados', 0, 9428.00, '2023-11-16 00:00:00', 5);

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
  ADD KEY `FK_id_adm` (`id_adm`),
  ADD KEY `FK_id_curso` (`id_curso`),
  ADD KEY `FK_id_cliente` (`id_cliente`);

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
  ADD PRIMARY KEY (`id_professor`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id_Cliente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `COMPRA`
--
ALTER TABLE `COMPRA`
  MODIFY `id_compra` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `Curso`
--
ALTER TABLE `Curso`
  MODIFY `id_curso` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Professor`
--
ALTER TABLE `Professor`
  MODIFY `id_professor` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Acesso_Realizado`
--
ALTER TABLE `Acesso_Realizado`
  ADD CONSTRAINT `FK_id_compra` FOREIGN KEY (`id_compra`) REFERENCES `COMPRA` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `COMPRA`
--
ALTER TABLE `COMPRA`
  ADD CONSTRAINT `FK_id_adm` FOREIGN KEY (`id_adm`) REFERENCES `Administrador` (`id_Adm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_curso` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `Curso`
--
ALTER TABLE `Curso`
  ADD CONSTRAINT `FK_id_professor` FOREIGN KEY (`id_professor`) REFERENCES `Professor` (`id_professor`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- BEGIN
--     DECLARE oldSalario DECIMAL;
--     DECLARE valorCurso DECIMAL;
--     DECLARE salarioTotal DECIMAL;
--     DECLARE id_prof INT;
--     SET id_prof = (SELECT P.id_professor from Compra CO join Curso CU on CO.id_curso=CU.id_curso join Professor P on CU.id_professor=P.id_professor where CO.id_compra=NEW.id_compra);
--     SET oldSalario = (SELECT P.salario from Professor P where P.id_professor = id_prof);
--     SET valorCurso = (SELECT CU.valor from COMPRA CO JOIN CURSO CU ON CO.id_curso=CU.id_curso where CO.id_compra=NEW.id_compra); 
--     SET salarioTotal = oldSalario + (0.9 * valorCurso);
    
-- UPDATE Professor P SET P.salario = salarioTotal where id_professor = id_prof;
-- END