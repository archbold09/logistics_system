-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2020 a las 01:17:30
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `svd`
--
CREATE DATABASE IF NOT EXISTS `svd` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `svd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosencargos`
--

CREATE TABLE `datosencargos` (
  `id` int(11) NOT NULL,
  `material` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tp` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ctdCantidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ctdUnidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `peso` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `volumen` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEncargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `datosencargos`
--

INSERT INTO `datosencargos` (`id`, `material`, `descripcion`, `tp`, `ctdCantidad`, `ctdUnidad`, `peso`, `volumen`, `idEncargo`) VALUES
(1, '1005150', 'Macarron corto COMARRICO Clasica x 500g', '200', '6', '72', '36.84', '0.095', 1),
(2, '1005990', 'Caracol COMARRICO clasica x1000g', '200', '20', '120', '126', '0.361', 1),
(3, '1005991', 'Fideo COMARRICO clasica x1000g', '200', '40', '240', '245.52', '0.53', 1),
(4, '1005992', 'Macarron Grueso COMARRICO clasica x1000g', '200', '20', '120', '126', '0.459', 1),
(5, '1005138', 'Fideo COMARRICO Clasica x 120g', '200', '450', '22500', '2767.5', '6.086', 1),
(6, '1005137', 'Spaghetti COMARRICO Clasica x 120g', '200', '36', '1800', '221.4', '0.033', 1),
(7, '1038953', 'Caracol COMARRICO Clasica x 454g', '200', '12', '144', '65.664', '0.194', 1),
(8, '1005150', 'Macarron corto COMARRICO Clasica x 500g', '200', '6', '72', '36.84', '0.095', 2),
(9, '1005990', 'Caracol COMARRICO clasica x1000g', '200', '20', '120', '126', '0.361', 2),
(10, '1005991', 'Fideo COMARRICO clasica x1000g', '200', '40', '240', '245.52', '0.53', 2),
(11, '1005992', 'Macarron Grueso COMARRICO clasica x1000g', '200', '20', '120', '126', '0.459', 2),
(12, '1005138', 'Fideo COMARRICO Clasica x 120g', '200', '450', '22500', '2767.5', '6.086', 2),
(13, '1005137', 'Spaghetti COMARRICO Clasica x 120g', '200', '36', '1800', '221.4', '0.033', 2),
(14, '1038953', 'Caracol COMARRICO Clasica x 454g', '200', '12', '144', '65.664', '0.194', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosentrega`
--

CREATE TABLE `datosentrega` (
  `id` int(11) NOT NULL,
  `idDatoEncargo` int(11) NOT NULL,
  `cantidad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idNumeroIntento` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `datosentrega`
--

INSERT INTO `datosentrega` (`id`, `idDatoEncargo`, `cantidad`, `idNumeroIntento`, `estado`) VALUES
(1, 1, '6', 1, 7),
(2, 2, '20', 1, 7),
(3, 3, '40', 1, 7),
(4, 4, '20', 1, 7),
(5, 5, '450', 1, 7),
(6, 6, '36', 1, 7),
(7, 7, '12', 1, 7),
(8, 8, '6', 2, 7),
(9, 9, '19', 2, 8),
(10, 10, '40', 2, 7),
(11, 11, '20', 2, 7),
(12, 12, '450', 2, 7),
(13, 13, '36', 2, 7),
(14, 14, '12', 2, 7),
(15, 8, '6', 3, 7),
(16, 9, '18', 3, 8),
(17, 10, '40', 3, 7),
(18, 11, '20', 3, 7),
(19, 12, '450', 3, 7),
(20, 13, '36', 3, 7),
(21, 14, '12', 3, 7),
(22, 8, '6', 4, 7),
(23, 9, '18', 4, 8),
(24, 10, '40', 4, 7),
(25, 11, '20', 4, 7),
(26, 12, '450', 4, 7),
(27, 13, '36', 4, 7),
(28, 14, '12', 4, 7),
(29, 8, '6', 5, 7),
(30, 10, '40', 5, 7),
(31, 11, '20', 5, 7),
(32, 12, '450', 5, 7),
(33, 13, '36', 5, 7),
(34, 14, '12', 5, 7),
(35, 8, '20', 6, 8),
(36, 10, '20', 6, 8),
(37, 11, '20', 6, 7),
(38, 12, '20', 6, 8),
(39, 13, '20', 6, 8),
(40, 14, '20', 6, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargos`
--

CREATE TABLE `encargos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `vehiculo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreado` date NOT NULL,
  `idAuxiliarFacturacion` int(11) NOT NULL,
  `idVerificador` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `verificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `encargos`
--

INSERT INTO `encargos` (`id`, `codigo`, `nombre`, `vehiculo`, `fechaCreado`, `idAuxiliarFacturacion`, `idVerificador`, `estado`, `verificacion`) VALUES
(1, '1.234.567-89', 'BARRANQUILLA', 'HGL-335', '2020-03-10', 2, 3, 6, 9),
(2, '12.345.678-98', 'VALLEDUPAR', 'CFG985', '2020-03-10', 2, 3, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `nombre`) VALUES
(1, 'Tipo documento'),
(2, 'Estado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numerointentos`
--

CREATE TABLE `numerointentos` (
  `id` int(11) NOT NULL,
  `fecha` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idEncargo` int(11) NOT NULL,
  `idVerificador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `numerointentos`
--

INSERT INTO `numerointentos` (`id`, `fecha`, `idEncargo`, `idVerificador`) VALUES
(1, '20-03-10', 1, 3),
(2, '20-03-10', 2, 3),
(3, '20-03-10', 2, 3),
(4, '20-03-10', 2, 3),
(5, '20-03-10', 2, 3),
(6, '20-03-10', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Auxiliar de facturación'),
(3, 'Verificador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subitem`
--

CREATE TABLE `subitem` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idItem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subitem`
--

INSERT INTO `subitem` (`id`, `nombre`, `idItem`) VALUES
(1, 'Cédula de ciudadanía ', 1),
(2, 'Tarjeta de identidad', 1),
(3, 'Activo', 2),
(4, 'Inactivo', 2),
(5, 'En proceso', 2),
(6, 'Terminada', 2),
(7, 'Correcto', 2),
(8, 'Incorrecto', 2),
(9, 'Verificado', 2),
(10, 'No verificado', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipoDocumento` int(11) NOT NULL,
  `numeroDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `rolUsuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `contrasena`, `tipoDocumento`, `numeroDocumento`, `rolUsuario`, `estado`) VALUES
(1, 'KHATERINE', 'BOLAÑO MARTINEZ', '0e6b718300692a27fe805cb01955446c25932b53782c43b44b0a3a5d1440f337', 1, '55301179', 1, 3),
(2, 'JUAN', 'CASTRO', '51fc19352f1a09f942eaa68bb30688a384736a51cea75cbe56256b1563246f78', 1, '1192796464', 2, 3),
(3, 'HEINER', 'CABARCAS', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 1, '123456789', 3, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datosencargos`
--
ALTER TABLE `datosencargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEncargo` (`idEncargo`);

--
-- Indices de la tabla `datosentrega`
--
ALTER TABLE `datosentrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado` (`estado`),
  ADD KEY `idDatoEncargo` (`idDatoEncargo`),
  ADD KEY `idNumeroIntento` (`idNumeroIntento`);

--
-- Indices de la tabla `encargos`
--
ALTER TABLE `encargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEstibador` (`idAuxiliarFacturacion`),
  ADD KEY `estado` (`estado`),
  ADD KEY `idVerificador` (`idVerificador`),
  ADD KEY `verificacion` (`verificacion`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `numerointentos`
--
ALTER TABLE `numerointentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEncargo` (`idEncargo`),
  ADD KEY `idVerificador` (`idVerificador`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subitem`
--
ALTER TABLE `subitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idItem` (`idItem`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rolUsuario` (`rolUsuario`),
  ADD KEY `estado` (`estado`),
  ADD KEY `tipoDocumento` (`tipoDocumento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datosencargos`
--
ALTER TABLE `datosencargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `datosentrega`
--
ALTER TABLE `datosentrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `encargos`
--
ALTER TABLE `encargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `numerointentos`
--
ALTER TABLE `numerointentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subitem`
--
ALTER TABLE `subitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosencargos`
--
ALTER TABLE `datosencargos`
  ADD CONSTRAINT `datosencargos_ibfk_1` FOREIGN KEY (`idEncargo`) REFERENCES `encargos` (`id`);

--
-- Filtros para la tabla `datosentrega`
--
ALTER TABLE `datosentrega`
  ADD CONSTRAINT `datosentrega_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `subitem` (`id`),
  ADD CONSTRAINT `datosentrega_ibfk_2` FOREIGN KEY (`idDatoEncargo`) REFERENCES `datosencargos` (`id`),
  ADD CONSTRAINT `datosentrega_ibfk_3` FOREIGN KEY (`idNumeroIntento`) REFERENCES `numerointentos` (`id`);

--
-- Filtros para la tabla `encargos`
--
ALTER TABLE `encargos`
  ADD CONSTRAINT `encargos_ibfk_1` FOREIGN KEY (`idAuxiliarFacturacion`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `encargos_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `subitem` (`id`),
  ADD CONSTRAINT `encargos_ibfk_3` FOREIGN KEY (`idVerificador`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `encargos_ibfk_4` FOREIGN KEY (`verificacion`) REFERENCES `subitem` (`id`);

--
-- Filtros para la tabla `numerointentos`
--
ALTER TABLE `numerointentos`
  ADD CONSTRAINT `numerointentos_ibfk_1` FOREIGN KEY (`idEncargo`) REFERENCES `encargos` (`id`),
  ADD CONSTRAINT `numerointentos_ibfk_2` FOREIGN KEY (`idVerificador`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `subitem`
--
ALTER TABLE `subitem`
  ADD CONSTRAINT `subitem_ibfk_1` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rolUsuario`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `subitem` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`tipoDocumento`) REFERENCES `subitem` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
