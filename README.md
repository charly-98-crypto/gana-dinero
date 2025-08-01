# NOMBRE
## CARLOS ALBERTO ALVAREZ  SALDARRIAGA
### 100 PALABRAS DE LO QUE HACE SU APP

Gana Dinero es una plataforma innovadora donde los usuarios pueden obtener ingresos extra realizando tareas sencillas como ver videos, seguir cuentas en redes sociales, responder encuestas y más. Al registrarse, reciben un bono de bienvenida. Cada tarea completada suma dinero al monedero del usuario. Para retirar las ganancias, deben activar una suscripción. Además, la app incluye sistemas de inversión, referidos y promociones exclusivas. Su diseño es moderno, intuitivo y estilo red social. Es ideal para jóvenes y adultos que buscan oportunidades digitales desde casa. Todo está respaldado con términos y condiciones legales para mayor seguridad.


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2025 a las 02:06:31
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gana_dinero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversiones`
--

CREATE TABLE `conversiones` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `estrellas_convertidas` int(11) DEFAULT NULL,
  `equivalente_usd` decimal(10,2) DEFAULT NULL,
  `comision` decimal(10,2) DEFAULT NULL,
  `total_recibido` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conversiones`
--

INSERT INTO `conversiones` (`id`, `usuario`, `estrellas_convertidas`, `equivalente_usd`, `comision`, `total_recibido`, `fecha`) VALUES
(1, 'CARLOS', 1000, '8.33', '0.83', '7.50', '2025-07-09 19:53:18'),
(2, 'CARLOS', 1000, '8.33', '1.25', '7.08', '2025-07-09 23:36:07'),
(3, 'CARLOS', 120, '1.00', '0.20', '0.80', '2025-07-10 00:26:54'),
(4, 'CARLOS', 120, '1.00', '0.20', '0.80', '2025-07-10 00:27:17'),
(5, 'CARLOS', 500, '4.17', '0.83', '3.33', '2025-07-10 00:28:53'),
(6, 'CARLOS', 500, '4.17', '0.83', '3.33', '2025-07-10 00:37:46'),
(7, 'CARLOS', 500, '4.17', '0.83', '3.33', '2025-07-10 00:38:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retiros`
--

CREATE TABLE `retiros` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `metodo` varchar(50) DEFAULT NULL,
  `destino` varchar(100) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_retiro`
--

CREATE TABLE `solicitudes_retiro` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'Pendiente',
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `recompensa` decimal(10,2) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `enlace` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `descripcion`, `recompensa`, `imagen`, `enlace`) VALUES
(1, 'Sigue la cuenta en Instagram y gana ', '0.50', 'ig.jpg', 'https://www.instagram.com/ejemplo1'),
(2, 'Dale like al video  en TikTok y gana ', '1.00', 'tiktok.png', 'https://www.tiktok.com/@ejemplo2'),
(3, 'Responde una encuesta de 2 minutos y gana ', '1.25', 'encuesta.jpg', 'https://forms.gle/encuesta123'),
(4, 'Suscríbete al canal de YouTube y gana ', '0.75', 'tareayou1.jpg', 'https://www.youtube.com/@canal1'),
(5, 'Sigue a @marca123 en TikTok y gana $0.60', '0.60', 'tiktok.png', 'https://www.tiktok.com/@marca123'),
(6, 'Comparte esta publicación en tus historias y gana $0.80', '0.80', 'ig.jpg', 'https://www.instagram.com/p/123456'),
(7, 'Mira este video completo en YouTube y gana $1.00', '1.00', 'tareayou1.jpg', 'https://www.youtube.com/watch?v=abc123'),
(8, 'Reacciona a una publicación en Facebook y gana $0.40', '0.40', 'fb.png', 'https://www.facebook.com/post123'),
(9, 'Visita nuestro sitio web por 30 segundos y gana $0.30', '0.30', 'logo.png', 'https://www.ejemplo.com'),
(10, 'Completa una encuesta rápida en Google Forms y gana $1.10', '1.10', 'encuesta.jpg', 'https://forms.gle/form456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_realizadas`
--

CREATE TABLE `tareas_realizadas` (
  `id` int(11) NOT NULL,
  `tarea_id` int(11) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `recompensa` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `ip_usuario` varchar(50) DEFAULT NULL,
  `navegador` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas_realizadas`
--

INSERT INTO `tareas_realizadas` (`id`, `tarea_id`, `usuario`, `descripcion`, `recompensa`, `fecha`, `ip_usuario`, `navegador`) VALUES
(1, 1, 'carlos', '', '0.00', '2025-07-06', NULL, NULL),
(2, 2, 'carlos', 'Dale like al video de @ejemplo2 en TikTok y gana $1.00', '1.00', '2025-07-06', NULL, NULL),
(3, 3, 'carlos', 'Responde una encuesta de 2 minutos y gana $1.25', '1.25', '2025-07-06', NULL, NULL),
(4, 4, 'carlos', 'Suscríbete al canal @canal1 de YouTube y gana $0.75', '0.75', '2025-07-06', NULL, NULL),
(5, 5, 'CARLOS', 'Sigue a @marca123 en TikTok y gana $0.60', '0.60', '2025-07-06', NULL, NULL),
(6, 10, 'CARLOS', 'Completa una encuesta rápida en Google Forms y gana $1.10', '1.10', '2025-07-06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(7, 6, 'CARLOS', 'Comparte esta publicación en tus historias y gana $0.80', '0.80', '2025-07-06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(8, 1, 'CARLOS', 'Sigue la cuenta @ejemplo1 en Instagram y gana $0.50', '0.50', '2025-07-07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(9, 2, 'CARLOS', 'Dale like al video de @ejemplo2 en TikTok y gana $1.00', '1.00', '2025-07-07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(10, 1, 'anderson', 'Sigue la cuenta @ejemplo1 en Instagram y gana $0.50', '0.50', '2025-07-07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(11, 2, 'anderson', 'Dale like al video de @ejemplo2 en TikTok y gana $1.00', '1.00', '2025-07-07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(12, 1, 'CARLOS', 'Sigue la cuenta @ejemplo1 en Instagram y gana $0.50', '0.50', '2025-07-09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(13, 2, 'CARLOS', 'Dale like al video de @ejemplo2 en TikTok y gana $1.00', '1.00', '2025-07-09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(14, 1, 'joss lyn', 'Sigue la cuenta en Instagram y gana ', '0.50', '2025-07-21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(15, 1, 'CARLOS', 'Sigue la cuenta en Instagram y gana ', '0.50', '2025-07-23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(16, 2, 'CARLOS', 'Dale like al video  en TikTok y gana ', '1.00', '2025-07-23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(17, 3, 'CARLOS', 'Responde una encuesta de 2 minutos y gana ', '1.25', '2025-07-23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(18, 1, 'joss lyn', 'Sigue la cuenta en Instagram y gana ', '0.50', '2025-07-23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `terminos_aceptados` tinyint(1) DEFAULT 0,
  `suscripcion` tinyint(1) DEFAULT 0,
  `estrellas` int(11) DEFAULT 0,
  `suscrito` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `clave`, `telefono`, `saldo`, `terminos_aceptados`, `suscripcion`, `estrellas`, `suscrito`) VALUES
(1, 'CARLOS', 'carlosalvarezsaldarriaga@gmail.com', '$2y$10$NUwheRhYxREl026QWxss3u77inprk2EANi./jAXLpcLP8pBLIrQu6', '3156184427', NULL, 1, 0, 22262, 0),
(2, 'anderson', 'ander4@gmail.com', '$2y$10$7q6y0KIAqNVkZlN2m.uT..Aism2QQH.cWlxZXGnZ3fiHNnMRLurrm', '3154785', '6.50', 0, 0, 0, 0),
(3, 'joss lyn', 'asidij@shjdj', '$2y$10$S8DgVHA2/kQ/Yh2h6t49J.kmDtfDh837/AGOsZQBywlJfDbfarbE.', '3198745634', '5.00', 0, 0, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conversiones`
--
ALTER TABLE `conversiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes_retiro`
--
ALTER TABLE `solicitudes_retiro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas_realizadas`
--
ALTER TABLE `tareas_realizadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conversiones`
--
ALTER TABLE `conversiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `retiros`
--
ALTER TABLE `retiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_retiro`
--
ALTER TABLE `solicitudes_retiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tareas_realizadas`
--
ALTER TABLE `tareas_realizadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
