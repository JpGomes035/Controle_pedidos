-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/12/2024 às 23:20
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
-- Banco de dados: `pedidos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `idAgenda` int(5) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(1500) NOT NULL,
  `nivelAprov` varchar(15) NOT NULL,
  `telAgenda` varchar(25) NOT NULL,
  `resp` varchar(150) DEFAULT NULL,
  `concluido` varchar(1) DEFAULT NULL,
  `datareg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`idAgenda`, `titulo`, `data`, `descricao`, `nivelAprov`, `telAgenda`, `resp`, `concluido`, `datareg`) VALUES
(149, 'teste', '2024-11-06', 'alo', 'Ativo', '+55 (35) 8468-7649', 'João', 'S', '2024-11-07 05:48:20'),
(150, 'teste', '2024-11-06', 'alo', 'Ativo', '+55 (35) 8468-7649', 'João', 's', '2024-11-07 05:48:20'),
(151, 'João Pedro', '2025-02-01', 'teste', 'Ativo', '+55 (35) 8468-7649', 'João', 'n', '2024-11-07 05:48:20'),
(152, 'teste', '2024-11-07', 'teste', 'Ativo', '11', 'Admin', 'S', '2024-11-07 05:57:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `banco`
--

CREATE TABLE `banco` (
  `idBanco` int(5) NOT NULL,
  `nomeBanco` varchar(150) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `cc` varchar(50) NOT NULL,
  `valor_banco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `banco`
--

INSERT INTO `banco` (`idBanco`, `nomeBanco`, `agencia`, `cc`, `valor_banco`) VALUES
(1, 'Cofre', '2322', '12121-5', 100.59),
(2, 'Caixa', '1212', '12121-2', 512.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `catalogo` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`IdCategoria`, `Nome`, `catalogo`) VALUES
(23, 'Roupas de Frio porra', ''),
(24, 'Roupas', 'n'),
(25, 'Ferramenta', 's');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nomeCliente` varchar(150) NOT NULL,
  `numeroCliente` varchar(150) NOT NULL,
  `emailCliente` varchar(150) NOT NULL,
  `cepCliente` varchar(15) NOT NULL,
  `cpfCliente` varchar(20) NOT NULL,
  `respCliente` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nomeCliente`, `numeroCliente`, `emailCliente`, `cepCliente`, `cpfCliente`, `respCliente`) VALUES
(21, 'João ', '+55 (35) 9967-7580', 'contat.joao10@gmail.com', '37504-500', '139.527.326-06', 'Jorge'),
(23, 'Consumidor Final', '', 'contato@gmail.com', '', '', '.'),
(24, 'João Pedro', '+55 (35) 8468-7649', 'contat.joao10@gmail.com', '37504-500', '139.527.326-05', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `emails_enviados`
--

CREATE TABLE `emails_enviados` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `anexo_nome` varchar(255) DEFAULT NULL,
  `anexo_tipo` varchar(255) DEFAULT NULL,
  `anexo_conteudo` longblob DEFAULT NULL,
  `data_envio` datetime NOT NULL,
  `anexo_caminho` varchar(255) DEFAULT NULL,
  `visualizar` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `emails_enviados`
--

INSERT INTO `emails_enviados` (`id`, `nome`, `email`, `destinatario`, `mensagem`, `anexo_nome`, `anexo_tipo`, `anexo_conteudo`, `data_envio`, `anexo_caminho`, `visualizar`) VALUES
(17, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'test', 'e8cf79ea617df106_pedido_compra.pdf', 'application/pdf', NULL, '2024-12-11 14:07:27', 'anexo_email/e8cf79ea617df106_pedido_compra.pdf', 'n'),
(18, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'opa', '0de1d2244b0727f2_IMG_7980.jpeg', 'image/jpeg', NULL, '2024-07-22 14:14:05', 'anexo_email/0de1d2244b0727f2_IMG_7980.jpeg', 'n'),
(19, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste', '1e64d3e878e73cc5_jess i eu.mp4', 'video/mp4', NULL, '2024-07-24 11:58:05', 'anexo_email/1e64d3e878e73cc5_jess i eu.mp4', 'n'),
(20, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste', '31722f97609f8766_default.jpg', 'image/jpeg', NULL, '2024-07-29 15:34:54', 'anexo_email/31722f97609f8766_default.jpg', 'n'),
(21, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste2', 'fc61a3e2b8e4ff8b_669fad8d56dec.jpg', 'image/jpeg', NULL, '2024-07-29 15:35:57', 'anexo_email/fc61a3e2b8e4ff8b_669fad8d56dec.jpg', 'n'),
(22, 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'nao sei o que é', 'c110a43be5ee7165_14-13_BR1-2960795262_02.mp4', 'video/mp4', NULL, '2024-08-09 17:12:11', 'anexo_email/c110a43be5ee7165_14-13_BR1-2960795262_02.mp4', 'n');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `IdProduto` int(11) NOT NULL,
  `Numero` varchar(50) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `precovenda` varchar(150) NOT NULL,
  `Quantidade` int(11) DEFAULT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `Fornecedor` varchar(100) DEFAULT NULL,
  `descProd` varchar(500) DEFAULT NULL,
  `vencProd` varchar(150) DEFAULT NULL,
  `unidade_estoque` varchar(40) DEFAULT NULL,
  `peso` varchar(20) DEFAULT NULL,
  `precoPromocional` varchar(150) DEFAULT NULL,
  `status_prod` varchar(150) DEFAULT NULL,
  `preco_custo` varchar(150) DEFAULT NULL,
  `preco_bruto` varchar(150) DEFAULT NULL,
  `qntVendas` varchar(15) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `localEstoq` varchar(150) DEFAULT NULL,
  `img_prod` varchar(150) DEFAULT NULL,
  `catalogo` enum('s','n') NOT NULL DEFAULT 'n',
  `promocao` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`IdProduto`, `Numero`, `Nome`, `precovenda`, `Quantidade`, `Categoria`, `Fornecedor`, `descProd`, `vencProd`, `unidade_estoque`, `peso`, `precoPromocional`, `status_prod`, `preco_custo`, `preco_bruto`, `qntVendas`, `deletado`, `id_reg_delet`, `localEstoq`, `img_prod`, `catalogo`, `promocao`) VALUES
(57, '1642', 'Alicate', '200.99', 0, 'Ferramenta', 'ProControl', 'Alicate de bico', '2024-02-10', 'Unidade', '2', '150', 'Disponível', '10', '180,55', '10', 'n', 2, 'Local 3', 'upload-prod/669fad8d56dec.jpg', '', ''),
(63, '133', 'Iphone XR 64GB', '1200', 1, 'Ferramenta', 'ProControl', 'Vermelho, 88% de Vida na bateria', '', 'UN', '0,194', '1000.65', 'Disponível', '1,500', '1850', '2', 'N', NULL, 'Local 2', 'upload-prod/669fad9b3aa39.jpg', '', ''),
(62, '153', 'Capacitor', '10.99', 10, 'Ferramenta', 'ProControl', 'Capacitor de chuveiro', '2024-02-29', 'UN', '20', '15,99', 'Disponível', '10.5', '129,52', '8', 'N', NULL, '351', 'upload-prod/669fada1ebe58.jpg', 's', 'n'),
(64, '150', 'Monitor PCFORT', '880.99', 200, 'Informática', 'ProControl', 'Preto, HDMI e VGA, 1920x1080.', '', 'UN', '1', '', 'Disponivel', '', '', '8', 'N', 2, 'Local 1', 'upload-prod/669fadc0bb223.jpg', 's', 'n'),
(65, '157', 'Feijão Preto', '1.00', 13, 'Alimento', 'ProControl', 'Feijão Preto', '2004-04-02', 'Pacote', '2', '15,99', 'Disponivel', '15,00', '19,00', '0', 'n', 2, 'Área G', NULL, 'n', 's'),
(66, '150', 'Arroz', '1.00', 10, 'Direto', 'ProControl', 'Preto', '2024-04-08', 'UN', '', '', 'Disponivel', '', '', '2', 'S', 2, '', 'upload-prod/baixados (2).jpg', 's', 'N'),
(68, '600', 'Camiseta preta ', '29.00', 9, 'Roupas', 'ProControl', 'Camisa preta básica ', '', 'CX', '', '20.55', 'OK', '10', '', '6', 'N', NULL, '', 'upload-prod/66a2a68ca2ee4.jpg', 's', 's'),
(69, 'teste', 'Casa', '1.00', 10, 'Alimento', 'ProControl', 'frio', NULL, 'UN', NULL, NULL, 'OK', NULL, NULL, NULL, 'S', 2, NULL, 'upload-prod/669fac2b9be87.jpg', 's', 'N'),
(70, '1', 'João Pedro Gomes', '150.99', 21, 'Ferramenta', 'ProControl', 'CACETE', NULL, 'UN', NULL, '100', 'usando ele porra', NULL, NULL, NULL, 'N', NULL, NULL, 'upload-prod/6764f421c7b04_Shidou icon.jpg', '', ''),
(71, '2', 'blusa', '0.10', 1, 'Ferramenta', 'Fornecedor', 'OK', '', 'UN', '', '', 'ok', '', '', NULL, 'S', 2, '', 'upload-prod/6764f7bfe8ab6_baixados (3).jpg', 'n', 'N');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fm_pag`
--

CREATE TABLE `fm_pag` (
  `id_fmpag` int(5) NOT NULL,
  `nome_fmpag` varchar(100) DEFAULT NULL,
  `banco_vinculado` varchar(45) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `id_reg_edit` int(5) DEFAULT NULL,
  `percentual_taxa` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fm_pag`
--

INSERT INTO `fm_pag` (`id_fmpag`, `nome_fmpag`, `banco_vinculado`, `deletado`, `id_reg_delet`, `id_reg_edit`, `percentual_taxa`) VALUES
(3, 'Pix ', 'Caixa', 'N', 2, 2, 0.00),
(8, 'A prazo', 'Cofre', 'N', NULL, 2, 0.00),
(10, 'Cartão Crédito', 'Caixa', 'N', NULL, 2, 10.00),
(11, 'rsrs', 'Caixa', 'S', 2, 2, 15.99);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `IdFornecedor` int(11) NOT NULL,
  `nomeForn` varchar(150) NOT NULL,
  `cnpjForn` varchar(20) NOT NULL,
  `telefoneForn` varchar(25) NOT NULL,
  `cepForn` varchar(15) NOT NULL,
  `emailForn` varchar(150) NOT NULL,
  `cod_Forn` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`IdFornecedor`, `nomeForn`, `cnpjForn`, `telefoneForn`, `cepForn`, `emailForn`, `cod_Forn`) VALUES
(14, 'ProControl', '21.221.312/0001-24', '+55 (35) 8468-7649', '37504-500', 'ProControl@gmail.com', '9073123'),
(17, 'Fornecedor', '00.000.000/0000-00', '', '', 'fornecedor@email.com', '000000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens`
--

CREATE TABLE `imagens` (
  `id_imagem` int(5) NOT NULL,
  `nome` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imagens`
--

INSERT INTO `imagens` (`id_imagem`, `nome`) VALUES
(26, 'IMG_3487.jpg'),
(27, 'fof.jpeg'),
(28, '8f2d4c23-75f7-4bbc-802c-65f2f08c2b7.jpeg'),
(29, 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'),
(30, 'procontrol.png'),
(31, 'ping.jpeg'),
(32, 'procontrol.png'),
(33, '8f2d4c23-75f7-4bbc-802c-65f2f08c2b78.jpeg'),
(34, 'ping.jpeg'),
(35, 'procontrol.png'),
(36, 'limpeza.png'),
(37, 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'),
(38, 'fof.jpeg'),
(39, 'gojo.jpg'),
(40, 'Chainsaw man (Denji) Ft_ The Weeknd [Starboy].jpg'),
(41, 'anime-girl-chilling-at-balcony-4k-de-1910x1075.jpg'),
(42, 'baixados.jpg'),
(43, 'gojo.jpg'),
(44, 'frieren-beyond-journey-s-end-oc-1910x1075.jpg'),
(45, 'anime-girl-chilling-at-balcony-4k-de-1910x1075.jpg'),
(46, 'anime-girl-chilling-at-balcony-4k-de-1910x1075.jpg'),
(47, 'baixados (2).jpg'),
(48, 'monitor.png'),
(49, 'frieren-beyond-journey-s-end-oc-1910x1075.jpg'),
(50, 'Preview.png'),
(51, 'Procontrol.png'),
(52, 'baixados (1).jpg'),
(53, 'Preview.png'),
(54, 'Procontrol.png'),
(55, 'hayseyn.jpeg'),
(56, 'Procontrol.png'),
(57, 'Uluzang gril, (1).jpeg'),
(58, 'IMG_5288.jpeg'),
(59, '91EFADD8-F9D7-4788-982C-03356DE35A04.jpeg'),
(60, 'Uluzang gril, (1).jpeg'),
(61, '91EFADD8-F9D7-4788-982C-03356DE35A04.jpeg'),
(62, 'baixados (2).jpg'),
(63, 'hehe.png'),
(64, 'baixados (3).jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `informacoes`
--

CREATE TABLE `informacoes` (
  `id_info` int(5) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `rua` varchar(150) NOT NULL,
  `cep` varchar(150) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `informacoes`
--

INSERT INTO `informacoes` (`id_info`, `nome`, `cnpj`, `email`, `telefone`, `rua`, `cep`, `cidade`, `bairro`) VALUES
(13, 'ProControl', '28.230.375/0001-67	', 'procontrol.contat@gmail.com', '35 84687649', 'Rua Augusto de souza cardoso, 330', '37504-500', 'Itajubá - MG', 'Jardim das Palmeiras');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(200) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `codigo_pedido`, `produto_id`, `nome_produto`, `quantidade`, `valor_unitario`) VALUES
(106, 95, 57, 'Alicate', 1, 1.00),
(107, 96, 68, 'Camiseta preta ', 10, 10.00),
(108, 97, 68, 'Camiseta preta ', 1, 122.00),
(109, 97, 68, 'Camiseta preta ', 1, 10.00),
(110, 98, 57, 'Alicate', 22, 1.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido_compra`
--

CREATE TABLE `itens_pedido_compra` (
  `id` int(11) NOT NULL,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido_compra`
--

INSERT INTO `itens_pedido_compra` (`id`, `codigo_pedido`, `produto_id`, `nome_produto`, `quantidade`, `valor_unitario`) VALUES
(97, 74, 57, 'Alicate', 1, 10.00),
(98, 75, 57, 'Alicate', 1, 10.00),
(99, 76, 57, 'Alicate', 1, 10.00),
(100, 76, 68, 'Camiseta preta ', 1, 10.00),
(101, 77, 57, 'Alicate', 11, 1.00),
(102, 78, 57, 'Alicate', 10, 10.00),
(103, 78, 63, 'Iphone XR 64GB', 10, 10.00),
(104, 79, 57, 'Alicate', 140, 1.00),
(105, 79, 63, 'Iphone XR 64GB', 100, 150.00),
(106, 80, 57, 'Alicate', 11, 200.00),
(107, 80, 63, 'Iphone XR 64GB', 22, 100.00),
(108, 81, 57, 'Alicate', 1, 10.00),
(109, 82, 57, 'Alicate', 1, 10.00),
(110, 83, 57, 'Alicate', 1, 10.00),
(111, 84, 63, 'Iphone XR 64GB', 1, 10.00),
(112, 85, 63, 'Iphone XR 64GB', 1, 10.00),
(113, 86, 63, 'Iphone XR 64GB', 1, 10.00),
(114, 87, 57, 'Alicate', 10, 15.55),
(115, 88, 63, 'Iphone XR 64GB', 1, 10.00),
(116, 89, 57, 'Alicate', 1, 10.54),
(117, 89, 63, 'Iphone XR 64GB', 1, 10.54);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `idMensagem` int(5) NOT NULL,
  `mensagem` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagem`
--

INSERT INTO `mensagem` (`idMensagem`, `mensagem`) VALUES
(1, 'kjkkkkkkkkkkk'),
(2, 'mkkkkkkkkkkkkkkkkkkk'),
(3, 'teste'),
(4, 'oi'),
(5, 'Teste'),
(6, 'Teste'),
(7, 'João'),
(8, 'teste'),
(9, 'teste'),
(10, 'kkkkk'),
(11, 'teste do caralho nessa porra'),
(12, 'mensagem'),
(13, 'teste'),
(14, 'teste safada'),
(15, 'tes'),
(16, 'tesa'),
(17, 'tesstee'),
(18, 'Olá.'),
(19, 'caraio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `codigo_pedido` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `responsavel_pedido` varchar(150) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`codigo_pedido`, `nome_cliente`, `responsavel_pedido`, `observacoes`, `valor_total`, `data`, `deletado`, `id_reg_delet`, `pago`, `banco_receb`, `fm_pag`) VALUES
(95, 'Consumidor Final', 'Admin', 'teste nao pago', 1.00, '2024-09-05', 'S', 2, 'N', 'Caixa', 'A prazo'),
(96, 'Consumidor Final', 'Admin', 'caralho', 100.00, '2024-09-26', 'S', 2, 'S', 'Cofre', 'A prazo'),
(97, 'Consumidor Final', 'Admin', '.', 132.00, '2024-12-16', 'N', 0, 'S', 'Caixa', 'Pix'),
(98, 'Consumidor Final', 'Admin', 'zerar alicate', 22.00, '2024-12-16', 'S', 2, 'S', 'Caixa', 'A prazo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_compra`
--

CREATE TABLE `pedido_compra` (
  `codigo_pedido` int(11) NOT NULL,
  `nome_fornecedor` varchar(100) DEFAULT NULL,
  `responsavel_pedido` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(11) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido_compra`
--

INSERT INTO `pedido_compra` (`codigo_pedido`, `nome_fornecedor`, `responsavel_pedido`, `observacoes`, `valor_total`, `data`, `deletado`, `id_reg_delet`, `pago`, `banco_receb`, `fm_pag`) VALUES
(74, 'ProControl', 'João', 'subtrair 10 reais do caixa e ja cair como pago 201', 10.00, '2024-09-03', 'N', 2, 'N', 'Caixa', 'A prazo'),
(75, 'Fornecedor', 'Admin', 'subtrair e ficar 200 e marcar como S no pago', 10.00, '2024-09-04', 'N', 0, 'S', 'Cofre', 'A prazo'),
(76, 'ProControl', 'João', 'caraio', 20.00, '2024-12-16', 'N', 0, 'S', 'Caixa', 'A prazo'),
(77, 'Fornecedor', 'Admin', 'alicate zerado', 11.00, '2024-12-23', 'N', 0, 'N', 'Caixa', 'A prazo'),
(78, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'S', NULL, NULL),
(79, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(80, 'Fornecedor', 'João', 'Observações do pedido', 0.00, '2024-12-20', 'S', 2, 'N', 'Caixa', 'Pix'),
(81, 'Fornecedor', 'João', 'Observações do pedido', 15.54, '2024-12-20', 'S', 2, 'N', 'Caixa', 'Pix'),
(82, 'Fornecedor', 'João', 'Observações do pedido', NULL, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(83, 'Fornecedor', 'João', 'Observações do pedido', NULL, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(84, 'Fornecedor', 'João', 'Observações do pedido', NULL, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(85, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(86, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(87, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(88, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'S', 2, 'N', NULL, NULL),
(89, 'Fornecedor', 'João', 'Observações do pedido', 1.00, '2024-12-20', 'N', 0, 'N', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `idSetor` int(5) NOT NULL,
  `NomeSetor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`idSetor`, `NomeSetor`) VALUES
(2, 'Desenvolvimento'),
(3, 'Financeiro'),
(4, 'Administração');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nome` varchar(80) NOT NULL,
  `Sobrenome` varchar(90) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(256) NOT NULL,
  `NivelUsuario` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(20) NOT NULL,
  `cpfUsuario` varchar(15) NOT NULL,
  `Setor` varchar(70) DEFAULT NULL,
  `Online` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nome`, `Sobrenome`, `Email`, `Senha`, `NivelUsuario`, `Status`, `telefoneUsuario`, `cpfUsuario`, `Setor`, `Online`) VALUES
(2, 'João', 'Pedro', 'joao@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 'Ativo', '+55 (35) 8468-7649', '139.527.326-06', 'Administração', 1),
(49, 'Admin', 'Pedro', 'admin@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 'Ativo', '+55 (55) 3584-0000', '139.527.326-03', 'Administração', 0),
(66, 'João', 'Pedro', 'contat.joao10@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '+55 (35) 8468-7649', '139.527.326-02', 'Desenvolvimento', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Índices de tabela `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`idBanco`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices de tabela `emails_enviados`
--
ALTER TABLE `emails_enviados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`IdProduto`);

--
-- Índices de tabela `fm_pag`
--
ALTER TABLE `fm_pag`
  ADD PRIMARY KEY (`id_fmpag`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`IdFornecedor`);

--
-- Índices de tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id_imagem`);

--
-- Índices de tabela `informacoes`
--
ALTER TABLE `informacoes`
  ADD PRIMARY KEY (`id_info`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_pedido_compra`
--
ALTER TABLE `itens_pedido_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_pedido` (`codigo_pedido`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`idMensagem`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codigo_pedido`);

--
-- Índices de tabela `pedido_compra`
--
ALTER TABLE `pedido_compra`
  ADD PRIMARY KEY (`codigo_pedido`);

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`idSetor`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `idAgenda` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de tabela `banco`
--
ALTER TABLE `banco`
  MODIFY `idBanco` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `emails_enviados`
--
ALTER TABLE `emails_enviados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `IdProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `fm_pag`
--
ALTER TABLE `fm_pag`
  MODIFY `id_fmpag` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `IdFornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id_imagem` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `informacoes`
--
ALTER TABLE `informacoes`
  MODIFY `id_info` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `itens_pedido_compra`
--
ALTER TABLE `itens_pedido_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `idMensagem` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de tabela `pedido_compra`
--
ALTER TABLE `pedido_compra`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `idSetor` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
