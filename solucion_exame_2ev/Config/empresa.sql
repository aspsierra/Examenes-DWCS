-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Xerado en: 12 de Mar de 2021 ás 08:55
-- Versión do servidor: 10.4.14-MariaDB
-- Versión do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS EXAMEN;

USE EXAMEN;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examen`
--

-- --------------------------------------------------------

--
-- Estrutura da táboa `departamentos`
--

CREATE TABLE `departamentos` (
  `NUMERO` int(2) UNSIGNED ZEROFILL NOT NULL,
  `NOMBRE` varchar(25) NOT NULL,
  `DIRECTOR` int(3) UNSIGNED ZEROFILL NOT NULL,
  `PRIMA_SUELDO` float NOT NULL DEFAULT 1000,
  `FECHA_INICIO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A extraer os datos da táboa `departamentos`
--

INSERT INTO `departamentos` (`NUMERO`, `NOMBRE`, `DIRECTOR`, `PRIMA_SUELDO`, `FECHA_INICIO`) VALUES
(01, 'ADMINISTRACION', 001, 1000, '2017-12-11'),
(02, 'VENTAS', 002, 1000, '2017-12-05'),
(03, 'MARKETING', 003, 1000, '2017-12-05'),
(04, 'PERSONAL', 004, 1000, '2017-12-25');

-- --------------------------------------------------------

--
-- Estrutura da táboa `empleados`
--

CREATE TABLE `empleados` (
  `ID_EMPLEADO` int(3) UNSIGNED ZEROFILL NOT NULL,
  `NIF` char(9) NOT NULL,
  `NSS` char(20) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `DIRECCION` varchar(50) NOT NULL,
  `SALARIO` float NOT NULL,
  `SEXO` enum('V','H') NOT NULL DEFAULT 'V',
  `FECHA_NAC` date NOT NULL,
  `DEPARTAMENTO` int(2) UNSIGNED ZEROFILL NOT NULL,
  `SUPERVISOR` int(3) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A extraer os datos da táboa `empleados`
--

INSERT INTO `empleados` (`ID_EMPLEADO`, `NIF`, `NSS`, `NOMBRE`, `DIRECCION`, `SALARIO`, `SEXO`, `FECHA_NAC`, `DEPARTAMENTO`, `SUPERVISOR`) VALUES
(001, '111111111', '123456567891111', 'PEPE FERNANDEZ', 'AVDA DE ARTEIXO 123', 1200, 'V', '2017-12-04', 01, NULL),
(002, '22222222', '22222222256789012', 'FERNANDO GOMEZ', 'CAMELIAS 34', 13450, 'V', '2017-12-04', 02, NULL),
(003, '33333333', '134563333333', 'ELENA PEREZ', 'AVDA DE ARTEIXO 123', 1345, 'H', '2017-12-04', 03, NULL),
(004, '44444444', '34567899999', 'JUANA GOMEZ', 'AVDA DE ARTEIXO 123', 1234, 'H', '2017-12-04', 04, NULL),
(005, '5454515', '545154', 'marquitos', 'caminito', 1900, 'V', '2017-12-04', 02, NULL),
(007, '1515415', '1541515151', 'marcus', 'noexiste', 1, 'V', '2017-12-05', 01, 005),
(008, '52525252', '57878', 'JUAN PEREZ PERES', 'CAMELIAS 25 ', 1000, 'V', '2017-12-05', 01, 005),
(009, '991234567', '0991234567', 'FERNADO ARBONES GONZALEZ', 'CASTRELOS NUEVO 56', 2000, 'V', '1993-01-09', 01, 005),
(010, '981234567', '0981234567', 'MARIA DOLORES FERNANDEZ PEREZ', 'PRINCIPE 19', 2000, 'H', '1999-03-09', 03, 005),
(011, '971234567', '0971234567', 'JUAN DOMINGO GARCIA LOPEZ', 'CASTRELOS 15', 1500, 'V', '1998-05-04', 04, NULL),
(012, '96456789', '0961234567', 'PABLO DOPICO DOPICO', 'AVDA CASTELAO', 1800, 'V', '1995-03-08', 04, 007),
(013, '951234567', '09512345678', 'ELENA NUÑEZ FERNANDEZ', 'CAMINO DEL COUTO', 2300, 'H', '1999-08-03', 04, 007),
(014, '891234567', '08956789', 'JUANA INES DOVAL', 'CASTELAO 34', 1600, 'H', '1993-02-10', 04, 007),
(015, '871234567', '087324567', 'DAVID LEMA GOMEZ', 'SAMIL 78', 1780, 'V', '1994-07-02', 02, 005),
(016, '861234567', '0865432189', 'ENRIQUE CASTRO GOMEZ', 'PEINCIPE 56', 1800, 'V', '1994-01-05', 03, 007),
(017, '851234567', '0856789522', 'MERCEDES POSE RECAREY', 'INES DE CASTRO 23', 1290, 'H', '1993-01-05', 02, NULL),
(018, '823456789', '0824444444', 'TERESA LOPEZ GAGO', 'CASTRELOS NUEVO 56', 1345, 'H', '1993-01-09', 02, NULL),
(019, '811234567', '081555555', 'DIEGO JUSTO FERNANDEZ', 'PLAZA DE LUGO 19', 2000, 'V', '1994-05-09', 04, NULL),
(020, '781234567', '0786666666', 'FRANCISCO ARUFE REY', 'AVDA DE ARTEIXO 19', 1345, 'V', '1995-03-08', 02, 009),
(021, '771234567', '0771111114', 'JOAQUIN DAVILA PEREZ', 'CAMELIAS 12', 1560, 'V', '1996-10-06', 02, 009);

-- --------------------------------------------------------

--
-- Estrutura da táboa `empleados_proyectos`
--

CREATE TABLE `empleados_proyectos` (
  `EMPLEADO` int(3) UNSIGNED ZEROFILL NOT NULL,
  `PROYECTO` int(3) UNSIGNED ZEROFILL NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `NUM_HORAS` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A extraer os datos da táboa `empleados_proyectos`
--

INSERT INTO `empleados_proyectos` (`EMPLEADO`, `PROYECTO`, `FECHA_INICIO`, `NUM_HORAS`) VALUES
(003, 001, '2017-01-01', 100),
(003, 002, '2017-12-05', 77),
(003, 005, '2017-01-01', 26),
(003, 008, '2017-05-01', 200),
(004, 002, '2017-12-12', 20),
(004, 003, '2017-07-12', 23),
(004, 006, '2017-11-12', 100),
(004, 007, '2017-12-02', 25),
(005, 001, '2017-12-04', 20),
(005, 002, '2017-12-06', 1),
(008, 001, '2017-12-05', 45),
(009, 008, '2017-12-02', 46),
(011, 003, '2017-07-12', 100),
(011, 005, '2017-05-01', 45),
(012, 008, '2017-01-01', 23),
(013, 003, '2017-07-12', 19),
(014, 005, '2017-01-01', 23),
(015, 007, '2017-12-08', 120),
(016, 004, '2017-07-12', 123),
(016, 007, '2017-12-02', 150),
(017, 006, '2017-07-12', 300),
(017, 008, '2017-12-08', 100),
(018, 001, '2017-01-01', 26),
(018, 003, '2017-01-01', 15),
(018, 005, '2017-07-12', 36),
(020, 001, '2017-01-01', 30),
(020, 003, '2017-01-01', 25),
(020, 007, '2017-12-08', 50),
(021, 004, '2017-07-12', 34);

-- --------------------------------------------------------

--
-- Estrutura da táboa `familiares`
--

CREATE TABLE `familiares` (
  `ID_FAMILIA` int(2) NOT NULL,
  `NIF` char(9) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `SEXO` enum('V','H') NOT NULL,
  `FECHA_NAC` date NOT NULL,
  `PARENTESCO` enum('HIJA','HIJO','PADRE','MADRE') NOT NULL,
  `EMPLEADO` int(3) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A extraer os datos da táboa `familiares`
--

INSERT INTO `familiares` (`ID_FAMILIA`, `NIF`, `NOMBRE`, `SEXO`, `FECHA_NAC`, `PARENTESCO`, `EMPLEADO`) VALUES
(0, '621234567', 'DAVID LEMAPEREZ', 'V', '2000-02-02', 'HIJO', 021),
(1, '66123456', 'ELENA FRANCO PEREZ', 'H', '2000-02-02', 'HIJA', 018),
(2, '65123456', 'JUAN FRANCO PEREZ', 'V', '2003-06-06', 'HIJO', 018),
(3, '591234567', 'GLORIA DOVAL GOMEZ', 'H', '1999-03-19', 'MADRE', 004),
(4, '581234567', 'DAVID LEMA GONZALEZ', 'V', '2004-08-09', 'HIJO', 003);

-- --------------------------------------------------------

--
-- Estrutura da táboa `proyectos`
--

CREATE TABLE `proyectos` (
  `NUMERO` int(3) UNSIGNED ZEROFILL NOT NULL,
  `NOMBRE` varchar(25) NOT NULL,
  `DEPARTAMENTO` int(2) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A extraer os datos da táboa `proyectos`
--

INSERT INTO `proyectos` (`NUMERO`, `NOMBRE`, `DEPARTAMENTO`) VALUES
(001, 'proyecto a', 01),
(002, 'proyecto b', 02),
(003, 'PROYECTO C', 02),
(004, 'PROYECTO D', 03),
(005, 'PROYECTO E', 04),
(006, 'PROYECTO AAA', 04),
(007, 'PROYECTO X', 03),
(008, 'PROYECTO JJ', 02);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`NUMERO`),
  ADD UNIQUE KEY `AK2_NOMBRE` (`NOMBRE`),
  ADD UNIQUE KEY `FK7_DIRECTOR` (`DIRECTOR`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID_EMPLEADO`),
  ADD UNIQUE KEY `AK1_NSS` (`NSS`),
  ADD UNIQUE KEY `AK4_NIF` (`NIF`),
  ADD KEY `FK6_DEPARTAMENTO` (`DEPARTAMENTO`),
  ADD KEY `FK8_EMPLEADOS` (`SUPERVISOR`);

--
-- Indexes for table `empleados_proyectos`
--
ALTER TABLE `empleados_proyectos`
  ADD PRIMARY KEY (`EMPLEADO`,`PROYECTO`),
  ADD KEY `FK3_EMPLEADO` (`EMPLEADO`),
  ADD KEY `FK4_PROYECTO` (`PROYECTO`);

--
-- Indexes for table `familiares`
--
ALTER TABLE `familiares`
  ADD PRIMARY KEY (`ID_FAMILIA`),
  ADD KEY `FK9_EMPLEADO` (`EMPLEADO`);

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`NUMERO`),
  ADD UNIQUE KEY `AK3_NOMBRE` (`NOMBRE`),
  ADD KEY `FK5_DEPARTAMENTO` (`DEPARTAMENTO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `NUMERO` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID_EMPLEADO` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `NUMERO` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricións para os envorcados das táboas
--

--
-- Restricións para a táboa `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`DIRECTOR`) REFERENCES `empleados` (`ID_EMPLEADO`) ON UPDATE CASCADE;

--
-- Restricións para a táboa `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`DEPARTAMENTO`) REFERENCES `departamentos` (`NUMERO`) ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`SUPERVISOR`) REFERENCES `empleados` (`ID_EMPLEADO`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restricións para a táboa `empleados_proyectos`
--
ALTER TABLE `empleados_proyectos`
  ADD CONSTRAINT `empleados_proyectos_ibfk_1` FOREIGN KEY (`EMPLEADO`) REFERENCES `empleados` (`ID_EMPLEADO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_proyectos_ibfk_2` FOREIGN KEY (`PROYECTO`) REFERENCES `proyectos` (`NUMERO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restricións para a táboa `familiares`
--
ALTER TABLE `familiares`
  ADD CONSTRAINT `familiares_ibfk_1` FOREIGN KEY (`EMPLEADO`) REFERENCES `empleados` (`ID_EMPLEADO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restricións para a táboa `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`DEPARTAMENTO`) REFERENCES `departamentos` (`NUMERO`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
