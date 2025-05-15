-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:33065
-- Tiempo de generación: 15-05-2025 a las 17:45:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `benalmadena65`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `usuario`, `contrasena`) VALUES
(1, 'adminjesus', 'jesus123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_culturales`
--

CREATE TABLE `eventos_culturales` (
  `id` int(11) NOT NULL,
  `Evento` varchar(255) NOT NULL,
  `Dirección` varchar(255) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos_culturales`
--

INSERT INTO `eventos_culturales` (`id`, `Evento`, `Dirección`, `Fecha`, `Hora`) VALUES
(1, 'Concierto de JazzBanda News Poland', 'Auditorio MunicipalAv. de Rocío Jurado, 029631 Arroyo de La Miel-Málaga', '2025-06-12', '20:00:00'),
(2, 'Teatro para mayores\r\n\"El último tranvía de Hans Breffel\".', 'Teatro Casa de la Cultura\r\nPlaza Austria, s/n, 29631 \r\nArroyo De La Miel-Benalmádena Costa-Málaga', '2025-06-20', '19:00:00'),
(3, 'Exposición de Arte Contemporáneo\r\n\"El estilo de las civilizaciones sefardies\".\r\nAutor: John Müller\r\n', 'Centro NOMAD\r\nAvda. Antonio Machado, 64 29631\r\nBenalmádena-Málaga', '2025-05-16', '10:00:00'),
(4, 'Música y vida para rejuvenecer\r\nOrquesta \"Carpe diem\"', 'Sala Multiusos Ayuntamiento  \r\nAvda. Juan Luis Peralta 52 29631\r\nBenalmádena Pueblo - Málaga', '2025-04-30', '11:00:00'),
(5, 'Malaga Street Festival', 'Palacio de los Deportes Sánchez Gómez', '2025-12-23', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias`
--

CREATE TABLE `farmacias` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Dirección` varchar(255) NOT NULL,
  `Teléfono` varchar(15) NOT NULL,
  `Horario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `farmacias`
--

INSERT INTO `farmacias` (`id`, `Nombre`, `Dirección`, `Teléfono`, `Horario`) VALUES
(1, 'Farmacia Orzuelo', 'Calle Ciudad de Melilla, número 2329631 Benalmádena -Málaga', '654 85 96 56', '09:00 a 19:00'),
(2, 'Farmacia Gálvez', 'Avenida Inmaculada Concepción, número 13\r\n29631 Benalmádena-Málaga', '952 44 25 32', '08:00 a 20:00'),
(3, 'Farmacia San Juan', 'Calle San Juan, número 26\r\n29631 Benalmádena-Málaga', '952 56 19 54', '09:00 a 18:00'),
(4, 'Farmacia Los Pinos', 'Calle Los Cármenes, número 12\r\n29631 Benálmadena-Málaga', '952 57 67 04', '08:00 a 20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Dirección` varchar(255) NOT NULL,
  `Teléfono` varchar(15) NOT NULL,
  `Horario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `Nombre`, `Dirección`, `Teléfono`, `Horario`) VALUES
(1, 'Hayar Nouayti', 'Calle San Juan, número 10', '952 26 45 85', '10:00 a 16:00'),
(2, 'Dra. Rossel', 'Avenida de la Libertad, número 54', '665 56 85 74', '09:00 a 15:00'),
(3, 'Dr. Olvaide Guzman', 'Calle Mayor, número 60', '649 87 32 12', '11:00 a 17:00'),
(4, 'Clinica Cumes', 'Avenida Antonio Machado, número 8', '952 63 25 78', '08:00 a 14:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportes`
--

CREATE TABLE `transportes` (
  `id` int(11) NOT NULL,
  `Ruta` varchar(255) NOT NULL,
  `Horario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transportes`
--

INSERT INTO `transportes` (`id`, `Ruta`, `Horario`) VALUES
(1, 'Línea 103 - Estupa-Torremuelle', '05:00 a 23:00'),
(2, 'Línea 103 - Torremuelle-Estupa', '06:00 a 22:00'),
(3, 'Línea 107 - Santangelo-Myramar-Arroyo de la Miel', '07:00 a 21:00'),
(4, 'Línea 107 - Arroyo de la Miel-Myramar-Santangelo', '08:00 a 20:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `eventos_culturales`
--
ALTER TABLE `eventos_culturales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transportes`
--
ALTER TABLE `transportes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `eventos_culturales`
--
ALTER TABLE `eventos_culturales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `farmacias`
--
ALTER TABLE `farmacias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transportes`
--
ALTER TABLE `transportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
