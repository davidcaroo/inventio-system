-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2024 a las 15:06:33
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
-- Base de datos: `inventiolite`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `box`
--

INSERT INTO `box` (`id`, `created_at`) VALUES
(15, '2024-11-10 19:09:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `image`, `name`, `description`, `created_at`) VALUES
(4, NULL, 'Basic', NULL, '2024-11-10 23:30:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `val` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`id`, `short`, `name`, `kind`, `val`) VALUES
(1, 'title', 'Titulo del Sistema', 2, 'Districolombia System'),
(2, 'use_image_product', 'Utilizar Imagenes en los productos', 1, '1'),
(3, 'active_clients', 'Activar clientes', 1, '1'),
(4, 'active_providers', 'Activar proveedores', 1, '1'),
(5, 'active_categories', 'Activar categorias', 1, '1'),
(6, 'active_reports_word', 'Activar reportes en Word', 1, '1'),
(7, 'active_reports_excel', 'Activar reportes en Excel', 1, '1'),
(8, 'active_reports_pdf', 'Activar reportes en PDF', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `q` float DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT NULL,
  `sell_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operation`
--

INSERT INTO `operation` (`id`, `product_id`, `q`, `operation_type_id`, `sell_id`, `created_at`) VALUES
(43, 64, 30, 1, NULL, '2024-11-10 13:06:24'),
(44, 64, 1, 2, 36, '2024-11-10 13:08:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_type`
--

CREATE TABLE `operation_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operation_type`
--

INSERT INTO `operation_type` (`id`, `name`) VALUES
(1, 'entrada'),
(2, 'salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `email1` varchar(50) DEFAULT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `inventary_min` int(11) DEFAULT 10,
  `price_in` float DEFAULT NULL,
  `price_out` float DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `presentation` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `image`, `barcode`, `name`, `description`, `inventary_min`, `price_in`, `price_out`, `unit`, `presentation`, `user_id`, `category_id`, `created_at`, `is_active`) VALUES
(64, NULL, '1', 'CAMISA XD', 'CAMISA', 5, 14000, 22000, 'TALLA', 'TODAS', 1, 4, '2024-11-10 13:06:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sell`
--

CREATE TABLE `sell` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT 2,
  `box_id` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `cash` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sell`
--

INSERT INTO `sell` (`id`, `person_id`, `user_id`, `operation_type_id`, `box_id`, `total`, `cash`, `discount`, `created_at`, `note`) VALUES
(36, NULL, 1, 2, 15, 22000, NULL, 2000, '2024-11-10 13:08:59', 'credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `username`, `email`, `password`, `image`, `is_active`, `is_admin`, `created_at`) VALUES
(1, 'Administrador', 'Inventio', 'admin', 'admin@admin.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', NULL, 1, 1, '2024-10-07 18:16:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short` (`short`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `operation_type_id` (`operation_type_id`),
  ADD KEY `sell_id` (`sell_id`);

--
-- Indices de la tabla `operation_type`
--
ALTER TABLE `operation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `box_id` (`box_id`),
  ADD KEY `operation_type_id` (`operation_type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `box`
--
ALTER TABLE `box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `operation_type`
--
ALTER TABLE `operation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT de la tabla `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `operation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `operation_ibfk_2` FOREIGN KEY (`operation_type_id`) REFERENCES `operation_type` (`id`),
  ADD CONSTRAINT `operation_ibfk_3` FOREIGN KEY (`sell_id`) REFERENCES `sell` (`id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `sell_ibfk_1` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`),
  ADD CONSTRAINT `sell_ibfk_2` FOREIGN KEY (`operation_type_id`) REFERENCES `operation_type` (`id`),
  ADD CONSTRAINT `sell_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `sell_ibfk_4` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
