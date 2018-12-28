-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Maio-2018 às 21:15
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asw024`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nome` text CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `nome`, `password`, `email`) VALUES
(1, 'superadmin', 'qwerty123', 'admin@administracao@.pt');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartas`
--

CREATE TABLE `cartas` (
  `id` int(11) NOT NULL,
  `cidade` char(50) NOT NULL DEFAULT '',
  `cor` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cartas`
--

INSERT INTO `cartas` (`id`, `cidade`, `cor`) VALUES
(1, 'Atlanta', 'Azul'),
(2, 'Bagdad', 'Preto'),
(3, 'Bangkok', 'Vermelho'),
(4, 'Beijing', 'Vermelho'),
(5, 'Bogota', 'Amarelo'),
(6, 'Buenos Aires', 'Amarelo'),
(7, 'Cairo', 'Preto'),
(8, 'Chennai', 'Preto'),
(9, 'Chicago', 'Azul'),
(10, 'Hong Kong', 'Vermelho'),
(11, 'Istanbul', 'Preto'),
(12, 'Jakarta', 'Vermelho'),
(13, 'Johannesburg', 'Amarelo'),
(14, 'Karachi', 'Preto'),
(15, 'Khartoum', 'Amarelo'),
(16, 'Kinshasa', 'Amarelo'),
(17, 'Kolkata', 'Preto'),
(18, 'Lagos', 'Amarelo'),
(19, 'Lima', 'Amarelo'),
(20, 'Lisboa', 'Azul'),
(21, 'London', 'Azul'),
(22, 'Los Angeles', 'Amarelo'),
(23, 'Madrid', 'Azul'),
(24, 'Manila', 'Vermelho'),
(25, 'Mexico City', 'Amarelo'),
(26, 'Milan', 'Azul'),
(27, 'Montreal', 'Azul'),
(28, 'Moscow', 'Preto'),
(29, 'New-York', 'Azul'),
(30, 'Osaka', 'Vermelho'),
(31, 'Paris', 'Azul'),
(32, 'Riyadh', 'Preto'),
(33, 'Santiago', 'Amarelo'),
(34, 'Sao Francisco', 'Azul'),
(35, 'Sedul', 'Vermelho'),
(36, 'Shanghai', 'Vermelho'),
(37, 'St. Petersburg', 'Azul'),
(38, 'Sydney', 'Vermelho'),
(39, 'Tehran', 'Preto'),
(40, 'Tokyo', 'Vermelho'),
(41, 'Tripei', 'Vermelho'),
(42, 'Washington', 'Azul'),
(43, 'Berlin', 'Azul'),
(44, 'Bruxelas', 'Azul'),
(45, 'Rio de Janeiro', 'Amarelo'),
(46, 'Saná', 'Preto'),
(47, 'Atenas', 'Azul'),
(48, 'Cidade do México', 'Amarelo'),
(49, 'Catmandu', 'Vermelho'),
(50, 'Cidade do Panamá', 'Amarelo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartas_jogador`
--

CREATE TABLE `cartas_jogador` (
  `id` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `id_carta` int(11) NOT NULL,
  `id_jogador` text NOT NULL,
  `carta` text NOT NULL,
  `cor` text NOT NULL,
  `ja_jogada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cartas_jogador`
--

INSERT INTO `cartas_jogador` (`id`, `id_jogo`, `id_carta`, `id_jogador`, `carta`, `cor`, `ja_jogada`) VALUES
(599, 7, 35, 'poni', 'Sedul', 'Vermelho', 0),
(600, 7, 23, 'poni', 'Madrid', 'Azul', 0),
(601, 7, 7, 'poni', 'Cairo', 'Preto', 0),
(602, 7, 26, 'poni', 'Milan', 'Azul', 0),
(603, 7, 41, 'poni', 'Tripei', 'Vermelho', 0),
(604, 7, 48, 'poni', 'Cidade do México', 'Amarelo', 0),
(605, 7, 3, 'poni', 'Bangkok', 'Vermelho', 0),
(606, 7, 2, 'poni', 'Bagdad', 'Preto', 0),
(607, 8, 19, 'poni', 'Lima', 'Amarelo', 0),
(608, 8, 8, 'pinipon', 'Chennai', 'Preto', 0),
(609, 8, 4, 'poni', 'Beijing', 'Vermelho', 0),
(610, 8, 50, 'pinipon', 'Cidade do Panamá', 'Amarelo', 0),
(611, 8, 29, 'poni', 'New-York', 'Azul', 0),
(612, 8, 40, 'pinipon', 'Tokyo', 'Vermelho', 0),
(613, 8, 23, 'poni', 'Madrid', 'Azul', 0),
(614, 8, 46, 'pinipon', 'Saná', 'Preto', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cor` char(8) NOT NULL,
  `conexoes` char(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `cor`, `conexoes`) VALUES
(1, 'San Francisco', 'Azul', 'Los Angeles, Chicago, Tokyo, Manila'),
(2, 'Washington', 'Azul', 'Atlanta, Montreal, New-york'),
(3, 'Montreal', 'Azul', 'Chicago, New-York, Washington'),
(4, 'New-York', 'Azul', 'Montreal, Washington, London, Madrid'),
(5, 'Chicago', 'Azul', 'San Francisco, Los Angeles, Mexico City, Atlanta'),
(6, 'Atlanta', 'Azul', 'Chicago, Miami, Washington'),
(7, 'London', 'Azul', 'New-York, Madrid, Paris, Essen'),
(8, 'Essen', 'Azul', 'London, Paris, Milan, St. Petersburg'),
(9, 'Paris', 'Azul', 'Madrid, London, Essen, Milan, Algiers'),
(10, 'Madrid', 'Azul', 'New-York, Sao Paulo, London, Paris, Algiers'),
(11, 'St. Petersburg', 'Azul', 'Essen, Istanbul, Moscow'),
(12, 'Milan', 'Azul', 'Essen, Istanbul, Paris'),
(13, 'Los Angeles', 'Amarelo', 'Sydney, San Francisco, Mexico City, Chicago'),
(14, 'Mexico City', 'Amarelo', 'Los Angeles, Chicago, Miami, Lima, Bogota'),
(15, 'Miami', 'Amarelo', 'Washington, Atlanta, Mexico City, Bogota'),
(16, 'Bogota', 'Amarelo', 'Atlanta, Mexico City, Lima, Sao Paulo, Buenos Aires'),
(17, 'Lima', 'Amarelo', 'Santiago, Bogota, Mexico City'),
(18, 'Santiago', 'Amarelo', 'Lima'),
(19, 'Kinshasa', 'Amarelo', 'Lagos, Khartoum, Johannesburg'),
(20, 'Buenos Aires', 'Amarelo', 'Sao Paulo, Bogota'),
(21, 'Sao Paulo', 'Amarelo', 'Buenos Aires, Bogota, Lagos, Madrid'),
(22, 'Lagos', 'Amarelo', 'Sao Paulo, Kinshasa, Khartoum'),
(23, 'Khartoum', 'Amarelo', 'Lagos, Kinshasa, Johannesburg, Cairo'),
(24, 'Johannesburg', 'Amarelo', 'Kinshasa, Khartoum'),
(25, 'Moscow', 'Preto', 'Madrid, Paris, Istanbul, Cairo'),
(26, 'Tehran', 'Preto', 'Moscow, Bagdad, Karachi'),
(27, 'Bagdad', 'Preto', 'Karachi, Moscow, Istanbul, Beijing'),
(29, 'Karachi', 'Preto', 'Cairo, Tehran, Beijing, Bangkok'),
(30, 'Istanbul', 'Preto', 'Moscow, Bagdad, Riyadh'),
(31, 'Cairo', 'Preto', 'Milan, Madrid, Bagdad, Riyadh'),
(32, 'Riyadh', 'Preto', 'Tehran, Beijing'),
(33, 'Manila', 'Vermelho', 'Tokyo, Beijing, Sydney, Seoul'),
(34, 'Hong Kong', 'Vermelho', 'Beijing, Shanghai, Osaka, Tripei'),
(35, 'Sydney', 'Vermelho', 'Manila, Jakarta, Los Angeles, Buenos Aires'),
(36, 'Tokyo', 'Vermelho', 'Beijing, Manila, Shanghai, Sydney'),
(37, 'Osaka', 'Vermelho', 'Tokyo, Shanghai, Seoul'),
(38, 'Seoul', 'Vermelho', 'Moscow, Tokyo, Osaka'),
(39, 'Shanghai', 'Vermelho', 'Beijing, Karachi, Moscow'),
(40, 'Beijing', 'Vermelho', 'Moscow, Sydney, Bagdad, Tokyo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades_infectadas`
--

CREATE TABLE `cidades_infectadas` (
  `id` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  `nome_cidade` varchar(60) NOT NULL,
  `n_doencas` tinyint(1) NOT NULL,
  `cor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cidades_infectadas`
--

INSERT INTO `cidades_infectadas` (`id`, `id_jogo`, `id_cidade`, `nome_cidade`, `n_doencas`, `cor`) VALUES
(288, 7, 14, 'Mexico City', 1, 'Amarelo'),
(289, 7, 10, 'Madrid', 1, 'Azul'),
(290, 7, 39, 'Shanghai', 1, 'Vermelho'),
(291, 7, 11, 'St. Petersburg', 1, 'Azul'),
(292, 7, 3, 'Montreal', 1, 'Azul'),
(293, 7, 9, 'Paris', 1, 'Azul'),
(294, 7, 8, 'Essen', 1, 'Azul'),
(295, 7, 29, 'Karachi', 1, 'Preto'),
(296, 7, 2, 'Washington', 1, 'Azul'),
(297, 7, 28, '', 1, ''),
(298, 7, 32, 'Riyadh', 1, 'Preto'),
(299, 8, 36, 'Tokyo', 3, 'Vermelho'),
(300, 8, 32, 'Riyadh', 3, 'Preto'),
(301, 8, 11, 'St. Petersburg', 3, 'Azul'),
(302, 8, 23, 'Khartoum', 2, 'Amarelo'),
(303, 8, 4, 'New-York', 2, 'Azul'),
(304, 8, 26, 'Tehran', 2, 'Preto'),
(305, 8, 38, 'Seoul', 1, 'Vermelho'),
(306, 8, 1, 'San Francisco', 1, 'Azul'),
(307, 8, 18, 'Santiago', 1, 'Amarelo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `doencas_erradicadas`
--

CREATE TABLE `doencas_erradicadas` (
  `id` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `Amarelo` tinyint(1) NOT NULL,
  `Azul` tinyint(4) NOT NULL,
  `Preto` tinyint(4) NOT NULL,
  `Vermelho` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `doencas_erradicadas`
--

INSERT INTO `doencas_erradicadas` (`id`, `id_jogo`, `Amarelo`, `Azul`, `Preto`, `Vermelho`) VALUES
(1, 7, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_jogo`
--

CREATE TABLE `estado_jogo` (
  `id` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `estado` text NOT NULL,
  `n_jogadores` int(11) NOT NULL,
  `jogador1` text NOT NULL,
  `jogador2` text NOT NULL,
  `jogador3` text NOT NULL,
  `jogador4` text NOT NULL,
  `cidade_jogador1` int(11) NOT NULL,
  `cidade_jogador2` int(11) NOT NULL,
  `cidade_jogador3` int(11) NOT NULL,
  `cidade_jogador4` int(11) NOT NULL,
  `n_turnos` int(11) NOT NULL,
  `centros_pesquisa` varchar(100) NOT NULL,
  `jogadas` tinyint(1) NOT NULL,
  `turno_jogador` int(11) NOT NULL,
  `cartas_biscadas` int(11) NOT NULL,
  `pilha_descarte` varchar(200) NOT NULL,
  `velocidade_infecao` int(11) NOT NULL,
  `surtos` int(11) NOT NULL,
  `mudar_velocidade` tinyint(1) NOT NULL DEFAULT '0',
  `data_inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estado_jogo`
--

INSERT INTO `estado_jogo` (`id`, `id_jogo`, `estado`, `n_jogadores`, `jogador1`, `jogador2`, `jogador3`, `jogador4`, `cidade_jogador1`, `cidade_jogador2`, `cidade_jogador3`, `cidade_jogador4`, `n_turnos`, `centros_pesquisa`, `jogadas`, `turno_jogador`, `cartas_biscadas`, `pilha_descarte`, `velocidade_infecao`, `surtos`, `mudar_velocidade`, `data_inicio`) VALUES
(22, 7, 'Iniciado', 2, 'poni', 'pinipon', '', '', 24, 6, 6, 6, 5, '4,24,', 0, 2, 20, '', 2, 0, 0, '2018-05-25'),
(23, 8, 'Desistiram', 2, 'poni', 'pinipon', '', '', 6, 6, 6, 6, 1, '', 0, 1, 8, '', 2, 0, 0, '2018-05-27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo`
--

CREATE TABLE `jogo` (
  `id` int(11) NOT NULL,
  `n_jogadores` int(11) NOT NULL,
  `jogadores_actuais` tinyint(1) NOT NULL,
  `descricao` text NOT NULL,
  `nome` text NOT NULL,
  `criador` varchar(60) NOT NULL,
  `jogador2` varchar(60) DEFAULT NULL,
  `jogador3` varchar(60) DEFAULT NULL,
  `jogador4` varchar(60) DEFAULT NULL,
  `data_comeco` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jogo`
--

INSERT INTO `jogo` (`id`, `n_jogadores`, `jogadores_actuais`, `descricao`, `nome`, `criador`, `jogador2`, `jogador3`, `jogador4`, `data_comeco`) VALUES
(7, 2, 2, 'Teste para geração de cartas', 'Teste Cartas', 'poni', 'pinipon', NULL, NULL, '2018-05-18'),
(8, 2, 2, 'um dois tres', 'Teste mais recente', 'poni', 'pinipon', NULL, NULL, '2018-05-18'),
(9, 4, 1, 'adasdasasdasda', 'Teste 3', 'poni', NULL, NULL, NULL, '2018-05-23'),
(10, 2, 1, 'asdasdasdasdsadasdadasdas', 'Teste 4', 'poni', NULL, NULL, NULL, '2018-05-05'),
(11, 2, 1, 'adasdadasd', 'adasdasdas', 'poni', NULL, NULL, NULL, '0000-00-00'),
(12, 2, 1, 'asdasdas', 'teste sincronizacao', 'pinipon', NULL, NULL, NULL, '2018-05-04'),
(13, 2, 1, '', '', 'pini', NULL, NULL, NULL, '0000-00-00'),
(14, 3, 1, 'rrfererert', 'fertg', 'pini', NULL, NULL, NULL, '2018-05-22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` text CHARACTER SET utf8 NOT NULL,
  `apelido` text CHARACTER SET utf8 NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `sexo` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `pais` text CHARACTER SET utf8 NOT NULL,
  `distrito` text CHARACTER SET utf8,
  `concelho` text CHARACTER SET utf8,
  `password` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartas_jogador`
--
ALTER TABLE `cartas_jogador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cidades_infectadas`
--
ALTER TABLE `cidades_infectadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jogo` (`id_jogo`);

--
-- Indexes for table `doencas_erradicadas`
--
ALTER TABLE `doencas_erradicadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado_jogo`
--
ALTER TABLE `estado_jogo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jogo` (`id_jogo`),
  ADD KEY `cidade_jogador1` (`cidade_jogador1`),
  ADD KEY `cidade_jogador2` (`cidade_jogador2`),
  ADD KEY `cidade_jogador4` (`cidade_jogador4`),
  ADD KEY `cidade_jogador3` (`cidade_jogador3`);

--
-- Indexes for table `jogo`
--
ALTER TABLE `jogo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cartas_jogador`
--
ALTER TABLE `cartas_jogador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- AUTO_INCREMENT for table `cidades_infectadas`
--
ALTER TABLE `cidades_infectadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `doencas_erradicadas`
--
ALTER TABLE `doencas_erradicadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `estado_jogo`
--
ALTER TABLE `estado_jogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jogo`
--
ALTER TABLE `jogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `estado_jogo`
--
ALTER TABLE `estado_jogo`
  ADD CONSTRAINT `estado_jogo_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
