-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 03-Jun-2019 às 02:10
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `estoque_tcc`
--
CREATE DATABASE IF NOT EXISTS `estoque_tcc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `estoque_tcc`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque_material`
--

CREATE TABLE IF NOT EXISTS `estoque_material` (
  `cd_prod_estoque` int(11) NOT NULL AUTO_INCREMENT,
  `qt_volume` int(20) NOT NULL,
  `qt_produto` decimal(40,0) NOT NULL,
  `ds_local` varchar(60) NOT NULL,
  `dt_entrada` varchar(10) NOT NULL,
  `cd_produto` int(11) NOT NULL,
  PRIMARY KEY (`cd_prod_estoque`),
  KEY `fk_estoque_material_produto` (`cd_produto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `estoque_material`
--

INSERT INTO `estoque_material` (`cd_prod_estoque`, `qt_volume`, `qt_produto`, `ds_local`, `dt_entrada`, `cd_produto`) VALUES
(3, 5, '10', 'Setor 1', '11/12/2015', 2),
(4, 5, '20', 'C 1 - p 2', '24/10/2017', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `cd_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(60) NOT NULL,
  PRIMARY KEY (`cd_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`cd_categoria`, `nm_categoria`) VALUES
(1, 'Aço');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entrada`
--

CREATE TABLE IF NOT EXISTS `tb_entrada` (
  `cd_entrada` int(11) NOT NULL,
  `cd_produto` int(11) DEFAULT NULL,
  `dt_entrada` varchar(10) NOT NULL,
  `qt_volume` int(20) NOT NULL,
  `qt_recebido` decimal(40,0) NOT NULL,
  `nm_volume` varchar(20) NOT NULL,
  `ds_local` varchar(60) NOT NULL,
  `cd_nf` varchar(15) NOT NULL,
  `nm_usuario` varchar(60) NOT NULL,
  PRIMARY KEY (`cd_entrada`),
  KEY `fk_entrada_produto` (`cd_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_entrada`
--

INSERT INTO `tb_entrada` (`cd_entrada`, `cd_produto`, `dt_entrada`, `qt_volume`, `qt_recebido`, `nm_volume`, `ds_local`, `cd_nf`, `nm_usuario`) VALUES
(1, 2, '11/12/2015', 5, '50', 'Caixa', 'Setor 1', '1', 'murillo'),
(2, 2, '24/10/2017', 5, '20', 'Caixa', 'C 1 - p 2', '5698', 'murillo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_fornecedor`
--

CREATE TABLE IF NOT EXISTS `tb_fornecedor` (
  `cd_fornecedor` int(11) NOT NULL,
  `nm_fornecedor` varchar(60) NOT NULL,
  `cd_cnpj` char(18) NOT NULL,
  `cd_telefone` varchar(14) NOT NULL,
  PRIMARY KEY (`cd_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_fornecedor`
--

INSERT INTO `tb_fornecedor` (`cd_fornecedor`, `nm_fornecedor`, `cd_cnpj`, `cd_telefone`) VALUES
(1, 'Gallo', '5454545454', '1335811414');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE IF NOT EXISTS `tb_produto` (
  `cd_produto` int(11) NOT NULL,
  `cd_fornecedor` int(11) DEFAULT NULL,
  `nm_produto` varchar(60) NOT NULL,
  `cd_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_produto`),
  KEY `fk_produto_categoria` (`cd_categoria`),
  KEY `fk_produto_fornecedor` (`cd_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`cd_produto`, `cd_fornecedor`, `nm_produto`, `cd_categoria`) VALUES
(1, 1, 'Quadro', 1),
(2, 1, 'Pedal', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_saida`
--

CREATE TABLE IF NOT EXISTS `tb_saida` (
  `cd_saida` int(11) NOT NULL,
  `cd_prod_estoque` int(11) NOT NULL,
  `dt_saida` varchar(10) NOT NULL,
  `qt_saida` decimal(40,0) NOT NULL,
  `cd_pedido` int(11) NOT NULL,
  `nm_cliente` varchar(60) NOT NULL,
  `nm_usuario` varchar(60) NOT NULL,
  PRIMARY KEY (`cd_saida`),
  KEY `fk_saida_estoque_material` (`cd_prod_estoque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_saida`
--

INSERT INTO `tb_saida` (`cd_saida`, `cd_prod_estoque`, `dt_saida`, `qt_saida`, `cd_pedido`, `nm_cliente`, `nm_usuario`) VALUES
(1, 3, '11/12/2015', '30', 1, 'José', 'murillo'),
(2, 3, '11/12/2015', '10', 2, 'Natanael', 'murillo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `cd_senha` varchar(10) NOT NULL,
  `nm_usuario` varchar(50) NOT NULL,
  `ft_usuario` varchar(50) DEFAULT NULL,
  `tp_usuario` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cd_senha`, `nm_usuario`, `ft_usuario`, `tp_usuario`) VALUES
('opd', 'vitor', 'dist/img/vitor.jpg', 'Operador'),
('admin', 'murillo', 'dist/img/murillo.jpg', 'Administrador');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `estoque_material`
--
ALTER TABLE `estoque_material`
  ADD CONSTRAINT `fk_estoque_material_produto` FOREIGN KEY (`cd_produto`) REFERENCES `tb_produto` (`cd_produto`);

--
-- Limitadores para a tabela `tb_entrada`
--
ALTER TABLE `tb_entrada`
  ADD CONSTRAINT `fk_entrada_produto` FOREIGN KEY (`cd_produto`) REFERENCES `tb_produto` (`cd_produto`);

--
-- Limitadores para a tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`cd_categoria`) REFERENCES `tb_categoria` (`cd_categoria`),
  ADD CONSTRAINT `fk_produto_fornecedor` FOREIGN KEY (`cd_fornecedor`) REFERENCES `tb_fornecedor` (`cd_fornecedor`);

--
-- Limitadores para a tabela `tb_saida`
--
ALTER TABLE `tb_saida`
  ADD CONSTRAINT `fk_saida_estoque_material` FOREIGN KEY (`cd_prod_estoque`) REFERENCES `estoque_material` (`cd_prod_estoque`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
