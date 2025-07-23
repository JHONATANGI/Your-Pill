-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-07-2025 a las 21:38:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_yourpill`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `base_medicamentos`
--

CREATE TABLE `base_medicamentos` (
  `medicamento_id` int(11) NOT NULL,
  `nombre_comercial` varchar(255) DEFAULT NULL,
  `principio_activo` varchar(255) DEFAULT NULL,
  `dosis` varchar(100) DEFAULT NULL,
  `via_administracion` varchar(100) DEFAULT NULL,
  `requiere_receta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_citas` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `motivo` varchar(500) NOT NULL,
  `estado` enum('Pendiente','Confirmada','Cancelada','Completada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `medico_id` int(11) NOT NULL,
  `tipo_identificacion` varchar(25) NOT NULL,
  `numero_identificacion` varchar(50) NOT NULL,
  `primer_nombre` varchar(100) NOT NULL,
  `primer_apellido` varchar(100) NOT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `especialidad` varchar(50) NOT NULL,
  `matricula_profesional` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `recordatorio_id` int(11) NOT NULL,
  `medicamento_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `dosis` varchar(100) DEFAULT NULL,
  `frecuencia` varchar(100) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `notificacion_hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `nombre_rol`) VALUES
(1, 'Medico'),
(2, 'Paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `numero_identificacion` varchar(50) NOT NULL,
  `primer_nombre` varchar(100) NOT NULL,
  `primer_apellido` varchar(100) NOT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `peso` int(11) DEFAULT NULL,
  `altura` varchar(4) DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `tipo_identificacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `numero_identificacion`, `primer_nombre`, `primer_apellido`, `genero`, `telefono`, `email`, `contrasena`, `peso`, `altura`, `rol_id`, `fecha_registro`, `tipo_identificacion`) VALUES
(9, '1234566777', 'Camilo', 'Meza', 'Masculino', '123', 'camilo6@gmail.com', '$2y$10$1JS0aaw8UmLUxEwXZfZ0Gumu/hjwkcnxFw2Sw/HMctpTPVJT7jFwW', 70, '1.70', 2, '2025-06-11 22:16:58', 'Cédula de ciudadanía'),
(10, '108720229', 'Alejandro', 'Gutierrez', 'Masculino', '6789001', 'alejo80@gmail.com', '$2y$10$YtlaFCmfQMlPt9NHHk6v9uuYEF9ciLX9C73plbrzdaXT9ihlexDhq', 68, '1.70', 2, '2025-06-15 18:36:14', 'Cédula de ciudadanía');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `base_medicamentos`
--
ALTER TABLE `base_medicamentos`
  ADD PRIMARY KEY (`medicamento_id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_citas`),
  ADD UNIQUE KEY `id_citas` (`id_citas`),
  ADD KEY `citas_fk1` (`id_horario`),
  ADD KEY `citas_fk2` (`usuario_id`),
  ADD KEY `citas_fk3` (`medico_id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`),
  ADD UNIQUE KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`medico_id`),
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`),
  ADD KEY `Medicos_fk10` (`rol_id`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`recordatorio_id`),
  ADD KEY `Recordatorios_fk1` (`medicamento_id`),
  ADD KEY `Recordatorios_fk6` (`usuario_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`),
  ADD UNIQUE KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`),
  ADD KEY `Usuarios_fk10` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `base_medicamentos`
--
ALTER TABLE `base_medicamentos`
  MODIFY `medicamento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_citas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `recordatorio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_fk1` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id_horario`),
  ADD CONSTRAINT `citas_fk2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  ADD CONSTRAINT `citas_fk3` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`medico_id`);

--
-- Filtros para la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `Medicos_fk10` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`);

--
-- Filtros para la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD CONSTRAINT `Recordatorios_fk1` FOREIGN KEY (`medicamento_id`) REFERENCES `base_medicamentos` (`medicamento_id`),
  ADD CONSTRAINT `Recordatorios_fk6` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `Usuarios_fk10` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
