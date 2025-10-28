-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-05-2025 a las 09:09:51
-- Versión del servidor: 10.6.21-MariaDB-cll-lve-log
-- Versión de PHP: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alevermx_wpbot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `subdomain` varchar(191) DEFAULT NULL,
  `logo` varchar(191) NOT NULL DEFAULT '',
  `cover` varchar(191) NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `lat` varchar(191) DEFAULT NULL,
  `lng` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `minimum` varchar(191) NOT NULL DEFAULT '0',
  `description` varchar(500) NOT NULL DEFAULT '',
  `fee` double(8,2) NOT NULL DEFAULT 0.00,
  `static_fee` double(8,2) NOT NULL DEFAULT 0.00,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `whatsapp_phone` varchar(191) NOT NULL DEFAULT '',
  `do_covertion` int(11) NOT NULL DEFAULT 1,
  `currency` varchar(191) DEFAULT NULL,
  `payment_info` varchar(191) DEFAULT NULL,
  `mollie_payment_key` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `subdomain`, `logo`, `cover`, `active`, `lat`, `lng`, `address`, `phone`, `minimum`, `description`, `fee`, `static_fee`, `is_featured`, `views`, `whatsapp_phone`, `do_covertion`, `currency`, `payment_info`, `mollie_payment_key`, `user_id`) VALUES
(1, '2024-05-25 18:20:50', '2024-05-25 18:38:24', NULL, 'Antonio Leal', 'antonioleal', '', '', 1, NULL, NULL, 'UVM Veracruz', '5212291686944', '0', 'UVM Veracruz', 0.00, 0.00, 0, 0, '', 1, 'MXN', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `key` varchar(191) NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configs`
--

INSERT INTO `configs` (`id`, `value`, `key`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES
(1, '1', 'task_done_1', 'App\\Models\\User', 1, '2024-05-25 18:02:54', '2024-05-25 18:02:54'),
(2, '1', 'task_done_2', 'App\\Models\\User', 1, '2024-05-25 18:18:59', '2024-05-25 18:18:59'),
(3, NULL, 'plugins', 'App\\Models\\Plan', 1, '2024-05-25 18:36:59', '2024-05-25 18:36:59'),
(4, 'l3UxwKHZ2htHYwizOFGTDeR0I8B6ee7c5FYhDa4he308bee6', 'plain_token', 'App\\Models\\Company', 1, '2024-05-25 18:40:20', '2024-05-25 18:40:20'),
(5, 'yes', 'whatsapp_webhook_verified', 'App\\Models\\Company', 1, '2024-05-25 18:44:15', '2024-05-25 18:44:15'),
(6, 'EAAYSbIm5CfIBO1F0n7iwUeXV21rffBgXNrclEeWS1wr3dGHUkB2aKB5fWkq48Sq6LjQM5oaidNyUgKKBibfHQ58AtpIdJGMJ4FKw2UDIOY7SEVpjj1q0GpGDOH0woyvP3GNNJrawazqTI2e5MVSP58cVDjuexsF1AonfNNwN6rbbcGobj073U8ytO1DH6wZDZD', 'whatsapp_permanent_access_token', 'App\\Models\\Company', 1, '2024-05-25 18:45:13', '2025-05-22 00:31:46'),
(7, '721506761038297', 'whatsapp_phone_number_id', 'App\\Models\\Company', 1, '2024-05-25 18:45:14', '2025-05-22 00:32:37'),
(8, '1065268944933904', 'whatsapp_business_account_id', 'App\\Models\\Company', 1, '2024-05-25 18:45:14', '2025-05-22 00:32:37'),
(9, 'yes', 'whatsapp_settings_done', 'App\\Models\\Company', 1, '2024-05-25 18:45:14', '2024-05-25 18:46:21'),
(10, 'true', 'agent_enable', 'App\\Models\\Company', 1, '2024-05-25 18:53:11', '2025-05-27 19:50:50'),
(11, 'true', 'agent_assigned_only', 'App\\Models\\Company', 1, '2024-05-25 18:53:11', '2025-05-27 19:50:50'),
(12, NULL, 'whatsapp_data_send_webhook', 'App\\Models\\Company', 1, '2024-05-25 18:53:11', '2024-05-25 18:53:11'),
(13, NULL, 'black_listed_phone_numbers', 'App\\Models\\Company', 1, '2024-05-25 18:53:12', '2024-05-25 18:53:12'),
(14, 'Generando mensaje, espere un momento...', 'delay_response', 'App\\Models\\Company', 1, '2024-05-25 18:53:12', '2025-05-23 16:28:12'),
(15, '1', 'task_done_3', 'App\\Models\\User', 1, '2024-05-26 15:30:41', '2024-05-26 15:30:41'),
(28, 'true', 'aviso_mensaje', 'App\\Models\\Company', 1, '2024-07-04 15:02:42', '2024-07-04 15:02:42'),
(29, '5212291686944', 'aviso_mensaje_celular', 'App\\Models\\Company', 1, '2024-07-04 15:02:42', '2025-05-21 15:32:16'),
(30, 'false', 'aviso_mensaje_sino', 'App\\Models\\Company', 1, '2024-07-06 14:30:01', '2025-05-27 19:53:27'),
(31, 'aviso_mensaje', 'aviso_mensaje_texto', 'App\\Models\\Company', 1, '2024-07-06 14:30:01', '2024-07-07 14:09:43'),
(35, 'aviso_mensaje1', 'aviso_mensaje_template', 'App\\Models\\Company', 1, '2024-07-07 14:15:17', '2025-05-21 15:53:17'),
(36, 'es_MX', 'aviso_mensaje_lenguaje', 'App\\Models\\Company', 1, '2024-07-07 14:15:17', '2024-07-07 14:15:17'),
(49, 'sjEglRV2FT55kouEF3c4wuzkH8fxQ3a0MPbRoJy3d1644fb8', 'plain_token', 'App\\Models\\User', 1, '2025-05-21 00:14:53', '2025-05-21 00:14:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_reply_at` timestamp NULL DEFAULT NULL,
  `last_client_reply_at` timestamp NULL DEFAULT NULL,
  `last_support_reply_at` timestamp NULL DEFAULT NULL,
  `last_message` varchar(191) NOT NULL DEFAULT '',
  `is_last_message_by_contact` tinyint(1) NOT NULL DEFAULT 0,
  `has_chat` tinyint(1) NOT NULL DEFAULT 0,
  `resolved_chat` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `enabled_ai_bot` tinyint(1) NOT NULL DEFAULT 1,
  `enabled_bot` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'para que responda bot normal '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `phone`, `avatar`, `country_id`, `company_id`, `deleted_at`, `created_at`, `updated_at`, `last_reply_at`, `last_client_reply_at`, `last_support_reply_at`, `last_message`, `is_last_message_by_contact`, `has_chat`, `resolved_chat`, `user_id`, `enabled_ai_bot`, `enabled_bot`) VALUES
(8130, 'CERVANTES NUBERG ELSA FERNANDA', '5217821091255', NULL, 135, 1, NULL, '2025-05-23 23:34:53', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8131, 'HERNANDEZ ISLEÑO ARACELY DEL CARMEN', '5212294171781', NULL, 135, 1, NULL, '2025-05-23 23:34:53', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8132, 'LOPEZ HERNANDEZ DANA VALERIA', '5212281342377', NULL, 135, 1, NULL, '2025-05-23 23:34:53', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8133, 'LORETO ARIZMENDI EVELYN NIMUE', '5217444487052', NULL, 135, 1, NULL, '2025-05-23 23:34:53', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8384, 'TROCHE MARQUEZ SANTIAGO', '5212299323311', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8385, 'COBOS ARANA ANETTE', '5212881009651', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8386, 'CISNEROS MARTINEZ DAIRA KARELY', '5212871080462', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8387, 'SOSA HERNANDEZ RUBEN SAHID', '5217821038969', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8388, 'GONZALEZ RAMIREZ SALVADOR', '5212283538890', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8389, 'SERRANO SANTOS DANNIA LIZETH', '5212291775387', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8390, 'ANDRADE KATTURA EVELYN', '5212295203079', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8391, 'RAMIREZ FISHER SCARLETT CLARISSE', '5212351045627', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8392, 'VAZQUEZ HERRERA LEONARDO', '5212722971224', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8394, 'CESSA BARRAGAN ISABELLA', '5219242485206', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8395, 'HERRERA HERNANDEZ LOLITA', '5212971023726', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-30 06:35:26', '2025-05-30 06:35:24', '2025-05-30 06:35:24', '2025-05-30 06:35:24', 'Datos de contacto', 0, 1, 0, NULL, 1, 1),
(8396, 'NAVARRETE RIVERA FATIMA DALAI', '5212295521238', NULL, 135, 1, NULL, '2025-05-26 22:06:26', '2025-05-29 18:25:22', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8429, 'RUIZ ATILANO VANESSA', '5212291094231', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8430, 'SERRANO SANTOS DANNIA LIZETH', '5212291775387', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8431, 'ESQUITIN PAVON REGINA', '5212287772464', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8432, 'VILLANUEVA REYES DANIELA', '5212881079112', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8433, 'PEDRAZA AMARO YULIANA MONSERRAT', '5212851154369', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8434, 'BELTRAN RIOS IVAN ALEXANDER', '5212851147358', NULL, 135, 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8435, 'RODRIGUEZ CRODA LUZ MARIA', '5212731093118', NULL, 135, 1, NULL, '2025-05-26 22:06:29', '2025-05-26 22:06:29', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8436, 'VIRGEN SANCHEZ KATHERINE', '5212299849700', NULL, 135, 1, NULL, '2025-05-26 22:06:29', '2025-05-26 22:06:29', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8437, 'MARTINEZ SANDOVAL KIMBERLY ESMERALDA', '5216192002011', NULL, 135, 1, NULL, '2025-05-26 22:06:29', '2025-05-26 22:06:29', NULL, NULL, NULL, '', 0, 0, 0, NULL, 1, 1),
(8487, 'NUÑEZ PINEDA SONIA ITZEL', '5212292431738', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 23:16:12', '2025-05-26 23:16:11', '2025-05-26 23:16:11', '2025-05-26 23:16:11', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8488, 'REYES BOLAÑOS GUSTAVO ALEXIS', '5212731436049', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8489, 'MONTIEL CARREON LUIS LEONARDO', '5212294861859', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8490, 'MASSON MALDONADO KEVIN', '5212295143002', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-28 12:54:15', '2025-05-28 12:54:13', '2025-05-28 12:54:13', '2025-05-28 12:54:13', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8491, 'CRUZ FUENTES IVANNA MICHELLE', '5215625274963', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 23:16:52', '2025-05-26 23:16:51', '2025-05-26 23:16:51', '2025-05-26 23:16:51', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8492, 'CONTRERAS PEGUEROS ANGELIQUE', '5212299682395', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8493, 'RODRIGUEZ GOMEZ TERESITA NICOLE', '5212831082744', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8494, 'MORA ANGELLO PAOLO', '5212295113403', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-27 00:52:43', '2025-05-27 00:52:42', '2025-05-27 00:52:42', '2025-05-27 00:52:42', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8495, 'HERNANDEZ SILVA FRANCISCO GAEL', '5212293123711', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8496, 'CERON GARCIA MARIO LUIS', '5212293394252', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:34:07', '2025-05-26 22:34:06', '2025-05-26 22:34:06', '2025-05-26 22:34:06', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8497, 'MUÑIZ CONTRERAS AURELIO', '5212851063434', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8498, 'TUN ACOSTA JOSE ALEJANDRO', '5212294910764', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 23:41:07', '2025-05-26 23:41:06', '2025-05-26 23:41:06', '2025-05-26 23:41:06', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8499, 'GARCIA GARCIA ALFREDO', '5212292276540', NULL, 135, 1, NULL, '2025-05-26 22:22:31', '2025-05-26 22:22:31', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8500, 'DAVID MARIN NATALIA', '5212296097950', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8501, 'DOMINGUEZ FOLLEZA LUIS ENRIQUE', '5212291047581', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8502, 'FILIBERTO GUZMAN ALEXIA SHIRLEY', '5212292535484', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:27:47', '2025-05-26 22:27:46', '2025-05-26 22:24:58', '2025-05-26 22:27:46', 'Muchas gracias por confirmar', 0, 1, 0, 7, 1, 1),
(8503, 'LOPEZ MARTINEZ JORGE CARLOS TADEO', '5212291079965', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-29 04:23:54', '2025-05-29 04:23:53', '2025-05-29 04:23:53', '2025-05-29 04:23:53', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8504, 'ANGELES CHELIUS JOHANNA', '5212299538885', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8505, 'CRUZ OLIVERA MILDRE ODETTE', '5212292503706', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8506, 'ALCANTARA MARTINEZ GUSTAVO DE JESUS', '5212295483962', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-27 02:21:16', '2025-05-27 02:21:15', '2025-05-27 02:21:15', '2025-05-27 02:21:15', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8507, 'BARRIENTOS TRUJILLO MICHELLE ESTRELLA', '5212299339394', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8508, 'MUÑOZ TORRES SOFIA XIMENA', '5215638629700', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8509, 'BAUTISTA FIGUEROA VANESSA', '5212292656724', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8510, 'VAZQUEZ HUESCA YARETZI', '5212295303407', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-27 02:37:37', '2025-05-27 02:37:36', '2025-05-27 02:37:36', '2025-05-27 02:37:36', 'Ok muchas gracias', 0, 1, 0, 7, 1, 1),
(8511, 'DOMINGUEZ MONTALVO RAFAEL', '5219203424748', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8512, 'GOBIN CROCHE PAOLO PIERRE', '5212295497047', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8513, 'REYES ESPERON JESSICA PAULINA', '5212219374837', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:28:01', '2025-05-26 22:28:00', '2025-05-26 22:28:00', '2025-05-26 22:28:00', 'Okey muchas gracias', 0, 1, 0, 7, 1, 1),
(8514, 'CAMAL DE LA ROSA KARIM DAVID', '5212293668181', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8515, 'ESCANDON GONZALEZ MANUEL ALFREDO', '5216678289890', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8516, 'SOLIS MOJICA KARLA MONSERRATH', '5212296156147', NULL, 135, 1, NULL, '2025-05-26 22:22:32', '2025-05-26 22:22:32', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8517, 'PRIETO RAMIREZ ANGEL GABRIEL', '5212292115538', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8518, 'LIMA AMADOR SARAHY', '5212741146133', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8519, 'AMADOR LOPEZ RAFAEL FERNANDO', '5213234235760', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8520, 'HERRERA FOMPEROSA MARTIN', '5212881020294', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8521, 'SENA CASTRO ZAID', '5212291407421', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8522, 'REYES ENRIQUEZ XIMENA', '5212292074353', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 23:25:22', '2025-05-26 23:25:21', '2025-05-26 23:25:21', '2025-05-26 23:25:22', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8523, 'ARCHUNDIA ORDOÑEZ EMILIANO', '5212295199573', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8524, 'HERMIDA RIVERA ROCIO YARELI', '5212295279008', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-27 01:02:41', '2025-05-27 01:02:41', '2025-05-27 01:02:41', '2025-05-27 01:02:41', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8525, 'SANCHEZ MIJANGOS MARISOL', '5212293642624', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8526, 'GARCIA OLIVARES FABIOLA', '5212293060755', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-27 01:14:56', '2025-05-27 01:14:55', '2025-05-27 01:14:55', '2025-05-27 01:14:55', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8527, 'VASQUEZ CRUZ ANGEL', '5219211135933', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-29 19:44:37', '2025-05-29 19:44:37', '2025-05-29 02:21:23', '2025-05-29 19:44:37', 'Arysa Esthibaly Del Angel Zumaya...', 0, 1, 0, 7, 1, 1),
(8528, 'HERRERA LARA JESUS AARON', '5212741347469', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8529, 'FLORES HERMIDA ADALBERTO', '5219934070946', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8530, 'PRADO OLIVARES GERARDO', '5212294525040', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8531, 'AGUILAR SALMONES ANA VALERIA', '5219331115388', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8532, 'VILLEGAS GONZALEZ SERGIO AMAURY', '5217821268648', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 23:06:47', '2025-05-26 23:06:46', '2025-05-26 22:58:35', '2025-05-26 23:06:46', 'Ellos le informan todo lo que necesita....', 0, 1, 0, 7, 1, 1),
(8533, 'PIÑEIRO AMADOR ANA VALENTINA', '5212299770170', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8534, 'NUÑEZ GARCIA JOSE LUIS', '5212881102985', NULL, 135, 1, NULL, '2025-05-26 22:22:33', '2025-05-26 22:22:33', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8535, 'MORALES ROSAS REGINA', '5212295309448', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:27:17', '2025-05-26 22:27:16', '2025-05-26 22:27:16', '2025-05-26 22:27:16', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8536, 'DE SANTOS PIÑA EDGAR ALEJANDRO', '5212293737049', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-27 19:49:28', '2025-05-27 16:41:04', '2025-05-27 16:41:04', '2025-05-27 16:41:04', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8537, 'GARCIA VIVEROS DIEGO DANIEL', '5212293042949', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8538, 'MORALES OREA VICTOR MANUEL', '5212296960616', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:27:41', '2025-05-26 22:27:40', '2025-05-26 22:27:40', '2025-05-26 22:27:40', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8539, 'REYES ALVAREZ ALEXANDER', '5212294399867', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-29 01:29:48', '2025-05-29 01:29:48', '2025-05-29 01:29:48', '2025-05-28 14:34:56', 'Muchas t igualmente', 1, 1, 0, 7, 1, 1),
(8540, 'ZAMBRANO TORRES KEVIN JOSEPH', '5218994509545', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8541, 'MANTILLA NIKOLAS', '5212297795498', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8542, 'SANTANA JIMENEZ JOSE LUIS', '5217842118057', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8543, 'VADO SANCHEZ YAEL', '5212291375012', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-29 14:47:16', '2025-05-29 14:47:14', '2025-05-29 14:47:14', '2025-05-29 14:47:14', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8544, 'DOMINGUEZ VITE GAEL EMILIANO', '5212292088865', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-27 01:40:43', '2025-05-27 01:40:42', '2025-05-27 01:40:42', '2025-05-27 01:40:42', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8545, 'DIAZ RIVERA ISABELA', '5212941402842', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8546, 'MENDOZA FERNANDEZ JUAN', '5212292913377', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8547, 'MEZA TORRES SOFIA GUADALUPE', '5212871626961', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8548, 'SOLIS DIAZ DASHA BERIT', '5212941691653', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8549, 'VICTORIA NUÑEZ SANTIAGO', '5212294970187', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8550, 'GORRIZ CALDERON MITZZY DAYHANA', '5212741365833', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 22:22:34', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8551, 'ORTIZ LOPEZ VALERIA', '5212292437469', NULL, 135, 1, NULL, '2025-05-26 22:22:34', '2025-05-26 23:06:17', '2025-05-26 23:06:17', '2025-05-26 23:06:17', '2025-05-26 23:06:17', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8552, 'GUTIERREZ CHAVEZ DIANA CRISTAL', '5212291468739', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8553, 'HERNANDEZ HERNANDEZ DANIEL', '5212293992784', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-27 04:56:54', '2025-05-27 04:56:53', '2025-05-27 04:56:53', '2025-05-27 04:56:53', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8554, 'ROSARIO MARTINEZ JUANA', '5212941298208', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8555, 'JUAREZ ANDRADE ASHLEY CLARISSA', '5212291164488', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8556, 'BARRADAS CARRERA BRANDON OWEN', '5212962060056', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8557, 'AMADOR ROMERO KRYSTELL', '5212831092172', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8558, 'RUIZ MIGUEL YIREH', '5212214265595', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-27 01:02:21', '2025-05-27 01:02:20', '2025-05-26 23:15:59', '2025-05-27 01:02:20', 'Si, es obligatorio para poder asignarte...', 0, 1, 0, 7, 1, 1),
(8559, 'AGUIRRE FERNANDEZ CINTHIA ESTRELLA', '5212871108856', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8560, 'VERA LOPEZ GISSELLE', '5212225191230', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-27 01:00:25', '2025-05-27 01:00:24', '2025-05-27 00:12:05', '2025-05-27 01:00:24', 'Por favor puedes hablar o mandar...', 0, 1, 0, 7, 1, 1),
(8561, 'RODRIGUEZ VELASCO HAZIEL AARON', '5212294503666', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8562, 'ORTIZ SALLAGO ROBERTO ENRICO', '5212292425221', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8563, 'LARA DOMINGUEZ EMILIANO', '5212961117570', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8564, 'LEDESMA JACOBO ANA SOFIA', '5212294208159', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-27 03:47:20', '2025-05-27 03:15:48', '2025-05-27 03:15:48', '2025-05-27 03:15:48', 'Datos de la Coordinación', 0, 1, 0, 7, 1, 1),
(8565, 'ORTIZ GUADARRAMA DANIEL', '5212722261767', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-27 19:53:00', '2025-05-27 19:53:00', '2025-05-27 19:53:00', NULL, 'para el miércoles 4 de junio 5pm', 1, 1, 0, 7, 1, 1),
(8566, 'ZAVALA SALDAÑA ETHAN SEBASTIAN', '5215624738872', NULL, 135, 1, NULL, '2025-05-26 22:22:35', '2025-05-26 22:22:35', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8567, 'GRIS FERNANDEZ EDWIN JESSE', '5212291632570', NULL, NULL, 1, NULL, '2025-05-26 22:22:35', '2025-05-28 01:28:08', NULL, NULL, NULL, '', 0, 0, 0, 7, 1, 1),
(8568, 'NO ESPECIFICADO', '522961117570', '', 135, 1, NULL, '2025-05-26 23:06:49', '2025-05-29 23:31:49', '2025-05-26 23:06:49', '2025-05-26 23:06:49', NULL, 'Datos de la Coordinación', 1, 1, 0, 7, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `lat` varchar(191) NOT NULL DEFAULT '',
  `lng` varchar(191) NOT NULL DEFAULT '',
  `iso2` varchar(191) NOT NULL,
  `iso3` varchar(191) NOT NULL,
  `phone_code` varchar(191) NOT NULL,
  `timezone` varchar(191) NOT NULL,
  `languages` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `lat`, `lng`, `iso2`, `iso3`, `phone_code`, `timezone`, `languages`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', '33.93911', '67.709953', 'AF', 'AFG', '93', 'Asia/Kabul', 'fa-AF,ps,uz-AF,tk', NULL, NULL),
(2, 'Albania', '41.153332', '20.168331', 'AL', 'ALB', '355', 'Europe/Tirane', 'sq,el', NULL, NULL),
(3, 'Algeria', '28.033886', '1.659626', 'DZ', 'DZA', '213', 'Africa/Algiers', 'ar-DZ', NULL, NULL),
(4, 'American Samoa', '-14.270972', '-170.132217', 'AS', 'ASM', '1-684', 'Pacific/Pago_Pago', 'en-AS,sm,to', NULL, NULL),
(5, 'Andorra', '42.546245', '1.601554', 'AD', 'AND', '376', 'Europe/Andorra', 'ca', NULL, NULL),
(6, 'Angola', '-11.202692', '17.873887', 'AO', 'AGO', '244', 'Africa/Lagos', 'pt-AO', NULL, NULL),
(7, 'Anguilla', '18.220554', '-63.068615', 'AI', 'AIA', '1-264', 'America/Port_of_Spain', 'en-AI', NULL, NULL),
(8, 'Antarctica', '-75.250973', '-0.071389', 'AQ', 'ATA', '672', 'Antarctica/Troll', '', NULL, NULL),
(9, 'Antigua and Barbuda', '17.060816', '-61.796428', 'AG', 'ATG', '1-268', 'America/Antigua', 'en-AG', NULL, NULL),
(10, 'Argentina', '-38.416097', '-63.616672', 'AR', 'ARG', '54', 'America/Argentina/Buenos_Aires', 'es-AR,en,it,de,fr,gn', NULL, NULL),
(11, 'Armenia', '40.069099', '45.038189', 'AM', 'ARM', '374', 'Asia/Yerevan', 'hy', NULL, NULL),
(12, 'Aruba', '12.52111', '-69.968338', 'AW', 'ABW', '297', 'America/Curacao', 'nl-AW,es,en', NULL, NULL),
(13, 'Australia', '-25.274398', '133.775136', 'AU', 'AUS', '61', 'Australia/Sydney', 'en-AU', NULL, NULL),
(14, 'Austria', '47.516231', '14.550072', 'AT', 'AUT', '43', 'Europe/Vienna', 'de-AT,hr,hu,sl', NULL, NULL),
(15, 'Azerbaijan', '40.143105', '47.576927', 'AZ', 'AZE', '994', 'Asia/Baku', 'az,ru,hy', NULL, NULL),
(16, 'Bahamas', '25.03428', '-77.39628', 'BS', 'BHS', '1-242', 'America/Nassau', 'en-BS', NULL, NULL),
(17, 'Bahrain', '25.930414', '50.637772', 'BH', 'BHR', '973', 'Asia/Bahrain', 'ar-BH,en,fa,ur', NULL, NULL),
(18, 'Bangladesh', '23.684994', '90.356331', 'BD', 'BGD', '880', 'Asia/Dhaka', 'bn-BD,en', NULL, NULL),
(19, 'Barbados', '13.193887', '-59.543198', 'BB', 'BRB', '1-246', 'America/Barbados', 'en-BB', NULL, NULL),
(20, 'Belarus', '53.709807', '27.953389', 'BY', 'BLR', '375', 'Europe/Minsk', 'be,ru', NULL, NULL),
(21, 'Belgium', '50.503887', '4.469936', 'BE', 'BEL', '32', 'Europe/Brussels', 'nl-BE,fr-BE,de-BE', NULL, NULL),
(22, 'Belize', '17.189877', '-88.49765', 'BZ', 'BLZ', '501', 'America/Belize', 'en-BZ,es', NULL, NULL),
(23, 'Benin', '9.30769', '2.315834', 'BJ', 'BEN', '229', 'Africa/Lagos', 'fr-BJ', NULL, NULL),
(24, 'Bermuda', '32.321384', '-64.75737', 'BM', 'BMU', '1-441', 'Atlantic/Bermuda', 'en-BM,pt', NULL, NULL),
(25, 'Bhutan', '27.514162', '90.433601', 'BT', 'BTN', '975', 'Asia/Thimphu', 'dz', NULL, NULL),
(26, 'Bolivia', '-16.290154', '-63.588653', 'BO', 'BOL', '591', 'America/La_Paz', 'es-BO,qu,ay', NULL, NULL),
(27, 'Bosnia and Herzegovina', '43.915886', '17.679076', 'BA', 'BIH', '387', 'Europe/Belgrade', 'bs,hr-BA,sr-BA', NULL, NULL),
(28, 'Botswana', '-22.328474', '24.684866', 'BW', 'BWA', '267', 'Africa/Maputo', 'en-BW,tn-BW', NULL, NULL),
(29, 'Brazil', '-14.235004', '-51.92528', 'BR', 'BRA', '55', 'America/Sao_Paulo', 'pt-BR,es,en,fr', NULL, NULL),
(30, 'British Indian Ocean Territory', '-6.343194', '71.876519', 'IO', 'IOT', '246', 'Indian/Chagos', 'en-IO', NULL, NULL),
(31, 'British Virgin Islands', '18.420695', '-64.639968', 'VG', 'VGB', '1-284', 'America/Port_of_Spain', 'en-VG', NULL, NULL),
(32, 'Brunei', '4.535277', '114.727669', 'BN', 'BRN', '673', 'Asia/Brunei', 'ms-BN,en-BN', NULL, NULL),
(33, 'Bulgaria', '42.733883', '25.48583', 'BG', 'BGR', '359', 'Europe/Sofia', 'bg,tr-BG', NULL, NULL),
(34, 'Burkina Faso', '12.238333', '-1.561593', 'BF', 'BFA', '226', 'Africa/Abidjan', 'fr-BF', NULL, NULL),
(35, 'Burundi', '-3.373056', '29.918886', 'BI', 'BDI', '257', 'Africa/Maputo', 'fr-BI,rn', NULL, NULL),
(36, 'Cambodia', '12.565679', '104.990963', 'KH', 'KHM', '855', 'Asia/Phnom_Penh', 'km,fr,en', NULL, NULL),
(37, 'Cameroon', '7.369722', '12.354722', 'CM', 'CMR', '237', 'Africa/Lagos', 'en-CM,fr-CM', NULL, NULL),
(38, 'Canada', '56.130366', '-106.346771', 'CA', 'CAN', '1', 'America/Toronto', 'en-CA,fr-CA,iu', NULL, NULL),
(39, 'Cape Verde', '16.002082', '-24.013197', 'CV', 'CPV', '238', 'Atlantic/Cape_Verde', 'pt-CV', NULL, NULL),
(40, 'Cayman Islands', '19.513469', '-80.566956', 'KY', 'CYM', '1-345', 'America/Cayman', 'en-KY', NULL, NULL),
(41, 'Central African Republic', '6.611111', '20.939444', 'CF', 'CAF', '236', 'Africa/Lagos', 'fr-CF,sg,ln,kg', NULL, NULL),
(42, 'Chad', '15.454166', '18.732207', 'TD', 'TCD', '235', 'Africa/Ndjamena', 'fr-TD,ar-TD,sre', NULL, NULL),
(43, 'Chile', '-35.675147', '-71.542969', 'CL', 'CHL', '56', 'America/Santiago', 'es-CL', NULL, NULL),
(44, 'China', '35.86166', '104.195397', 'CN', 'CHN', '86', 'Asia/Shanghai', 'zh-CN,yue,wuu,dta,ug,za', NULL, NULL),
(45, 'Christmas Island', '-10.447525', '105.690449', 'CX', 'CXR', '61', 'Indian/Christmas', 'en,zh,ms-CC', NULL, NULL),
(46, 'Cocos Islands', '-12.164165', '96.870956', 'CC', 'CCK', '61', 'Indian/Cocos', 'ms-CC,en', NULL, NULL),
(47, 'Colombia', '4.570868', '-74.297333', 'CO', 'COL', '57', 'America/Bogota', 'es-CO', NULL, NULL),
(48, 'Comoros', '-11.875001', '43.872219', 'KM', 'COM', '269', 'Indian/Comoro', 'ar,fr-KM', NULL, NULL),
(49, 'Cook Islands', '-21.236736', '-159.777671', 'CK', 'COK', '682', 'Pacific/Rarotonga', 'en-CK,mi', NULL, NULL),
(50, 'Costa Rica', '9.748917', '-83.753428', 'CR', 'CRI', '506', 'America/Costa_Rica', 'es-CR,en', NULL, NULL),
(51, 'Croatia', '45.1', '15.2', 'HR', 'HRV', '385', 'Europe/Belgrade', 'hr-HR,sr', NULL, NULL),
(52, 'Cuba', '21.521757', '-77.781167', 'CU', 'CUB', '53', 'America/Havana', 'es-CU', NULL, NULL),
(53, 'Curacao', '12.16957', '-68.990021', 'CW', 'CUW', '599', 'America/Curacao', 'nl,pap', NULL, NULL),
(54, 'Cyprus', '35.126413', '33.429859', 'CY', 'CYP', '357', 'Asia/Nicosia', 'el-CY,tr-CY,en', NULL, NULL),
(55, 'Czech Republic', '49.817492', '15.472962', 'CZ', 'CZE', '420', 'Europe/Prague', 'cs,sk', NULL, NULL),
(56, 'Democratic Republic of the Congo', '-4.038333', '21.758664', 'CD', 'COD', '243', 'Africa/Lagos', 'fr-CD,ln,kg', NULL, NULL),
(57, 'Denmark', '56.26392', '9.501785', 'DK', 'DNK', '45', 'Europe/Copenhagen', 'da-DK,en,fo,de-DK', NULL, NULL),
(58, 'Djibouti', '11.825138', '42.590275', 'DJ', 'DJI', '253', 'Africa/Djibouti', 'fr-DJ,ar,so-DJ,aa', NULL, NULL),
(59, 'Dominica', '15.414999', '-61.370976', 'DM', 'DMA', '1-767', 'America/Port_of_Spain', 'en-DM', NULL, NULL),
(60, 'Dominican Republic', '18.735693', '-70.162651', 'DO', 'DOM', '1-809, 1-829, 1-849', 'America/Santo_Domingo', 'es-DO', NULL, NULL),
(61, 'East Timor', '-8.874217', '125.727539', 'TL', 'TLS', '670', 'Asia/Dili', 'tet,pt-TL,id,en', NULL, NULL),
(62, 'Ecuador', '-1.831239', '-78.183406', 'EC', 'ECU', '593', 'America/Guayaquil', 'es-EC', NULL, NULL),
(63, 'Egypt', '26.820553', '30.802498', 'EG', 'EGY', '20', 'Africa/Cairo', 'ar-EG,en,fr', NULL, NULL),
(64, 'El Salvador', '13.794185', '-88.89653', 'SV', 'SLV', '503', 'America/El_Salvador', 'es-SV', NULL, NULL),
(65, 'Equatorial Guinea', '1.650801', '10.267895', 'GQ', 'GNQ', '240', 'Africa/Lagos', 'es-GQ,fr', NULL, NULL),
(66, 'Eritrea', '15.179384', '39.782334', 'ER', 'ERI', '291', 'Africa/Asmara', 'aa-ER,ar,tig,kun,ti-ER', NULL, NULL),
(67, 'Estonia', '58.595272', '25.013607', 'EE', 'EST', '372', 'Europe/Tallinn', 'et,ru', NULL, NULL),
(68, 'Ethiopia', '9.145', '40.489673', 'ET', 'ETH', '251', 'Africa/Addis_Ababa', 'am,en-ET,om-ET,ti-ET,so-ET,sid', NULL, NULL),
(69, 'Falkland Islands', '-51.796253', '-59.523613', 'FK', 'FLK', '500', 'Atlantic/Stanley', 'en-FK', NULL, NULL),
(70, 'Faroe Islands', '61.892635', '-6.911806', 'FO', 'FRO', '298', 'Atlantic/Faroe', 'fo,da-FO', NULL, NULL),
(71, 'Fiji', '-16.578193', '179.414413', 'FJ', 'FJI', '679', 'Pacific/Fiji', 'en-FJ,fj', NULL, NULL),
(72, 'Finland', '61.92411', '25.748151', 'FI', 'FIN', '358', 'Europe/Helsinki', 'fi-FI,sv-FI,smn', NULL, NULL),
(73, 'France', '46.227638', '2.213749', 'FR', 'FRA', '33', 'Europe/Paris', 'fr-FR,frp,br,co,ca,eu,oc', NULL, NULL),
(74, 'French Polynesia', '-17.679742', '-149.406843', 'PF', 'PYF', '689', 'Pacific/Tahiti', 'fr-PF,ty', NULL, NULL),
(75, 'Gabon', '-0.803689', '11.609444', 'GA', 'GAB', '241', 'Africa/Lagos', 'fr-GA', NULL, NULL),
(76, 'Gambia', '13.443182', '-15.310139', 'GM', 'GMB', '220', 'Africa/Abidjan', 'en-GM,mnk,wof,wo,ff', NULL, NULL),
(77, 'Georgia', '42.315407', '43.356892', 'GE', 'GEO', '995', 'Asia/Tbilisi', 'ka,ru,hy,az', NULL, NULL),
(78, 'Germany', '51.165691', '10.451526', 'DE', 'DEU', '49', 'Europe/Berlin', 'de', NULL, NULL),
(79, 'Ghana', '7.946527', '-1.023194', 'GH', 'GHA', '233', 'Africa/Accra', 'en-GH,ak,ee,tw', NULL, NULL),
(80, 'Gibraltar', '36.137741', '-5.345374', 'GI', 'GIB', '350', 'Europe/Gibraltar', 'en-GI,es,it,pt', NULL, NULL),
(81, 'Greece', '39.074208', '21.824312', 'GR', 'GRC', '30', 'Europe/Athens', 'el-GR,en,fr', NULL, NULL),
(82, 'Greenland', '71.706936', '-42.604303', 'GL', 'GRL', '299', 'America/Godthab', 'kl,da-GL,en', NULL, NULL),
(83, 'Grenada', '12.262776', '-61.604171', 'GD', 'GRD', '1-473', 'America/Port_of_Spain', 'en-GD', NULL, NULL),
(84, 'Guam', '13.444304', '144.793731', 'GU', 'GUM', '1-671', 'Pacific/Guam', 'en-GU,ch-GU', NULL, NULL),
(85, 'Guatemala', '15.783471', '-90.230759', 'GT', 'GTM', '502', 'America/Guatemala', 'es-GT', NULL, NULL),
(86, 'Guernsey', '49.465691', '-2.585278', 'GG', 'GGY', '44-1481', 'Europe/London', 'en,fr', NULL, NULL),
(87, 'Guinea', '9.945587', '-9.696645', 'GN', 'GIN', '224', 'Africa/Abidjan', 'fr-GN', NULL, NULL),
(88, 'Guinea-Bissau', '11.803749', '-15.180413', 'GW', 'GNB', '245', 'Africa/Bissau', 'pt-GW,pov', NULL, NULL),
(89, 'Guyana', '4.860416', '-58.93018', 'GY', 'GUY', '592', 'America/Guyana', 'en-GY', NULL, NULL),
(90, 'Haiti', '18.971187', '-72.285215', 'HT', 'HTI', '509', 'America/Port-au-Prince', 'ht,fr-HT', NULL, NULL),
(91, 'Honduras', '15.199999', '-86.241905', 'HN', 'HND', '504', 'America/Tegucigalpa', 'es-HN', NULL, NULL),
(92, 'Hong Kong', '22.396428', '114.109497', 'HK', 'HKG', '852', 'Asia/Hong_Kong', 'zh-HK,yue,zh,en', NULL, NULL),
(93, 'Hungary', '47.162494', '19.503304', 'HU', 'HUN', '36', 'Europe/Budapest', 'hu-HU', NULL, NULL),
(94, 'Iceland', '64.963051', '-19.020835', 'IS', 'ISL', '354', 'Atlantic/Reykjavik', 'is,en,de,da,sv,no', NULL, NULL),
(95, 'India', '20.593684', '78.96288', 'IN', 'IND', '91', 'Asia/Kolkata', 'en-IN,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,bh,sat,ks,ne,sd,kok,doi,mni,sit,sa,fr,lus,inc', NULL, NULL),
(96, 'Indonesia', '-0.789275', '113.921327', 'ID', 'IDN', '62', 'Asia/Jakarta', 'id,en,nl,jv', NULL, NULL),
(97, 'Iran', '32.427908', '53.688046', 'IR', 'IRN', '98', 'Asia/Tehran', 'fa-IR,ku', NULL, NULL),
(98, 'Iraq', '33.223191', '43.679291', 'IQ', 'IRQ', '964', 'Asia/Baghdad', 'ar-IQ,ku,hy', NULL, NULL),
(99, 'Ireland', '53.41291', '-8.24389', 'IE', 'IRL', '353', 'Europe/Dublin', 'en-IE,ga-IE', NULL, NULL),
(100, 'Isle of Man', '54.236107', '-4.548056', 'IM', 'IMN', '44-1624', 'Europe/London', 'en,gv', NULL, NULL),
(101, 'Israel', '31.046051', '34.851612', 'IL', 'ISR', '972', 'Asia/Jerusalem', 'he,ar-IL,en-IL,', NULL, NULL),
(102, 'Italy', '41.87194', '12.56738', 'IT', 'ITA', '39', 'Europe/Rome', 'it-IT,de-IT,fr-IT,sc,ca,co,sl', NULL, NULL),
(103, 'Ivory Coast', '7.539989', '-5.54708', 'CI', 'CIV', '225', 'Africa/Abidjan', 'fr-CI', NULL, NULL),
(104, 'Jamaica', '18.109581', '-77.297508', 'JM', 'JAM', '1-876', 'America/Jamaica', 'en-JM', NULL, NULL),
(105, 'Japan', '36.204824', '138.252924', 'JP', 'JPN', '81', 'Asia/Tokyo', 'ja', NULL, NULL),
(106, 'Jersey', '49.214439', '-2.13125', 'JE', 'JEY', '44-1534', 'Europe/London', 'en,pt', NULL, NULL),
(107, 'Jordan', '30.585164', '36.238414', 'JO', 'JOR', '962', 'Asia/Amman', 'ar-JO,en', NULL, NULL),
(108, 'Kazakhstan', '48.019573', '66.923684', 'KZ', 'KAZ', '7', 'Asia/Almaty', 'kk,ru', NULL, NULL),
(109, 'Kenya', '-0.023559', '37.906193', 'KE', 'KEN', '254', 'Africa/Nairobi', 'en-KE,sw-KE', NULL, NULL),
(110, 'Kiribati', '-3.370417', '-168.734039', 'KI', 'KIR', '686', 'Pacific/Tarawa', 'en-KI,gil', NULL, NULL),
(111, 'Kosovo', '42.602636', '20.902977', 'XK', 'XKX', '383', 'Europe/Belgrade', 'sq,sr', NULL, NULL),
(112, 'Kuwait', '29.31166', '47.481766', 'KW', 'KWT', '965', 'Asia/Kuwait', 'ar-KW,en', NULL, NULL),
(113, 'Kyrgyzstan', '41.20438', '74.766098', 'KG', 'KGZ', '996', 'Asia/Bishkek', 'ky,uz,ru', NULL, NULL),
(114, 'Laos', '19.85627', '102.495496', 'LA', 'LAO', '856', 'Asia/Vientiane', 'lo,fr,en', NULL, NULL),
(115, 'Latvia', '56.879635', '24.603189', 'LV', 'LVA', '371', 'Europe/Riga', 'lv,ru,lt', NULL, NULL),
(116, 'Lebanon', '33.854721', '35.862285', 'LB', 'LBN', '961', 'Asia/Beirut', 'ar-LB,fr-LB,en,hy', NULL, NULL),
(117, 'Lesotho', '-29.609988', '28.233608', 'LS', 'LSO', '266', 'Africa/Johannesburg', 'en-LS,st,zu,xh', NULL, NULL),
(118, 'Liberia', '6.428055', '-9.429499', 'LR', 'LBR', '231', 'Africa/Monrovia', 'en-LR', NULL, NULL),
(119, 'Libya', '26.3351', '17.228331', 'LY', 'LBY', '218', 'Africa/Tripoli', 'ar-LY,it,en', NULL, NULL),
(120, 'Liechtenstein', '47.166', '9.555373', 'LI', 'LIE', '423', 'Europe/Zurich', 'de-LI', NULL, NULL),
(121, 'Lithuania', '55.169438', '23.881275', 'LT', 'LTU', '370', 'Europe/Vilnius', 'lt,ru,pl', NULL, NULL),
(122, 'Luxembourg', '49.815273', '6.129583', 'LU', 'LUX', '352', 'Europe/Luxembourg', 'lb,de-LU,fr-LU', NULL, NULL),
(123, 'Macau', '22.198745', '113.543873', 'MO', 'MAC', '853', 'Asia/Macau', 'zh,zh-MO,pt', NULL, NULL),
(124, 'Macedonia', '41.608635', '21.745275', 'MK', 'MKD', '389', 'Europe/Belgrade', 'mk,sq,tr,rmm,sr', NULL, NULL),
(125, 'Madagascar', '-18.766947', '46.869107', 'MG', 'MDG', '261', 'Indian/Antananarivo', 'fr-MG,mg', NULL, NULL),
(126, 'Malawi', '-13.254308', '34.301525', 'MW', 'MWI', '265', 'Africa/Maputo', 'ny,yao,tum,swk', NULL, NULL),
(127, 'Malaysia', '4.210484', '101.975766', 'MY', 'MYS', '60', 'Asia/Kuala_Lumpur', 'ms-MY,en,zh,ta,te,ml,pa,th', NULL, NULL),
(128, 'Maldives', '3.202778', '73.22068', 'MV', 'MDV', '960', 'Indian/Maldives', 'dv,en', NULL, NULL),
(129, 'Mali', '17.570692', '-3.996166', 'ML', 'MLI', '223', 'Africa/Abidjan', 'fr-ML,bm', NULL, NULL),
(130, 'Malta', '35.937496', '14.375416', 'MT', 'MLT', '356', 'Europe/Malta', 'mt,en-MT', NULL, NULL),
(131, 'Marshall Islands', '7.131474', '171.184478', 'MH', 'MHL', '692', 'Pacific/Majuro', 'mh,en-MH', NULL, NULL),
(132, 'Mauritania', '21.00789', '-10.940835', 'MR', 'MRT', '222', 'Africa/Abidjan', 'ar-MR,fuc,snk,fr,mey,wo', NULL, NULL),
(133, 'Mauritius', '-20.348404', '57.552152', 'MU', 'MUS', '230', 'Indian/Mauritius', 'en-MU,bho,fr', NULL, NULL),
(134, 'Mayotte', '-12.8275', '45.166244', 'YT', 'MYT', '262', 'Indian/Mayotte', 'fr-YT', NULL, NULL),
(135, 'Mexico', '23.634501', '-102.552784', 'MX', 'MEX', '52', 'America/Mexico_City', 'es-MX', NULL, NULL),
(136, 'Micronesia', '7.425554', '150.550812', 'FM', 'FSM', '691', 'Pacific/Pohnpei', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', NULL, NULL),
(137, 'Moldova', '47.411631', '28.369885', 'MD', 'MDA', '373', 'Europe/Chisinau', 'ro,ru,gag,tr', NULL, NULL),
(138, 'Monaco', '43.750298', '7.412841', 'MC', 'MCO', '377', 'Europe/Monaco', 'fr-MC,en,it', NULL, NULL),
(139, 'Mongolia', '46.862496', '103.846656', 'MN', 'MNG', '976', 'Asia/Ulaanbaatar', 'mn,ru', NULL, NULL),
(140, 'Montenegro', '42.708678', '19.37439', 'ME', 'MNE', '382', 'Europe/Belgrade', 'sr,hu,bs,sq,hr,rom', NULL, NULL),
(141, 'Montserrat', '16.742498', '-62.187366', 'MS', 'MSR', '1-664', 'America/Port_of_Spain', 'en-MS', NULL, NULL),
(142, 'Morocco', '31.791702', '-7.09262', 'MA', 'MAR', '212', 'Africa/Casablanca', 'ar-MA,fr', NULL, NULL),
(143, 'Mozambique', '-18.665695', '35.529562', 'MZ', 'MOZ', '258', 'Africa/Maputo', 'pt-MZ,vmw', NULL, NULL),
(144, 'Myanmar', '21.913965', '95.956223', 'MM', 'MMR', '95', 'Asia/Rangoon', 'my', NULL, NULL),
(145, 'Namibia', '-22.95764', '18.49041', 'NA', 'NAM', '264', 'Africa/Windhoek', 'en-NA,af,de,hz,naq', NULL, NULL),
(146, 'Nauru', '-0.522778', '166.931503', 'NR', 'NRU', '674', 'Pacific/Nauru', 'na,en-NR', NULL, NULL),
(147, 'Nepal', '28.394857', '84.124008', 'NP', 'NPL', '977', 'Asia/Kathmandu', 'ne,en', NULL, NULL),
(148, 'Netherlands', '52.132633', '5.291266', 'NL', 'NLD', '31', 'Europe/Amsterdam', 'nl-NL,fy-NL', NULL, NULL),
(149, 'Netherlands Antilles', '12.226079', '-69.060087', 'AN', 'ANT', '599', 'America/Curacao', 'nl-AN,en,es', NULL, NULL),
(150, 'New Caledonia', '-20.904305', '165.618042', 'NC', 'NCL', '687', 'Pacific/Noumea', 'fr-NC', NULL, NULL),
(151, 'New Zealand', '-40.900557', '174.885971', 'NZ', 'NZL', '64', 'Pacific/Auckland', 'en-NZ,mi', NULL, NULL),
(152, 'Nicaragua', '12.865416', '-85.207229', 'NI', 'NIC', '505', 'America/Managua', 'es-NI,en', NULL, NULL),
(153, 'Niger', '17.607789', '8.081666', 'NE', 'NER', '227', 'Africa/Lagos', 'fr-NE,ha,kr,dje', NULL, NULL),
(154, 'Nigeria', '9.081999', '8.675277', 'NG', 'NGA', '234', 'Africa/Lagos', 'en-NG,ha,yo,ig,ff', NULL, NULL),
(155, 'Niue', '-19.054445', '-169.867233', 'NU', 'NIU', '683', 'Pacific/Niue', 'niu,en-NU', NULL, NULL),
(156, 'North Korea', '40.339852', '127.510093', 'KP', 'PRK', '850', 'Asia/Pyongyang', 'ko-KP', NULL, NULL),
(157, 'Northern Mariana Islands', '17.33083', '145.38469', 'MP', 'MNP', '1-670', 'Pacific/Saipan', 'fil,tl,zh,ch-MP,en-MP', NULL, NULL),
(158, 'Norway', '60.472024', '8.468946', 'NO', 'NOR', '47', 'Europe/Oslo', 'no,nb,nn,se,fi', NULL, NULL),
(159, 'Oman', '21.512583', '55.923255', 'OM', 'OMN', '968', 'Asia/Muscat', 'ar-OM,en,bal,ur', NULL, NULL),
(160, 'Pakistan', '30.375321', '69.345116', 'PK', 'PAK', '92', 'Asia/Karachi', 'ur-PK,en-PK,pa,sd,ps,brh', NULL, NULL),
(161, 'Palau', '7.51498', '134.58252', 'PW', 'PLW', '680', 'Pacific/Palau', 'pau,sov,en-PW,tox,ja,fil,zh', NULL, NULL),
(162, 'Palestine', '31.952162', '35.233154', 'PS', 'PSE', '970', 'Asia/Hebron', 'ar-PS', NULL, NULL),
(163, 'Panama', '8.537981', '-80.782127', 'PA', 'PAN', '507', 'America/Panama', 'es-PA,en', NULL, NULL),
(164, 'Papua New Guinea', '-6.314993', '143.95555', 'PG', 'PNG', '675', 'Pacific/Port_Moresby', 'en-PG,ho,meu,tpi', NULL, NULL),
(165, 'Paraguay', '-23.442503', '-58.443832', 'PY', 'PRY', '595', 'America/Asuncion', 'es-PY,gn', NULL, NULL),
(166, 'Peru', '-9.189967', '-75.015152', 'PE', 'PER', '51', 'America/Lima', 'es-PE,qu,ay', NULL, NULL),
(167, 'Philippines', '12.879721', '121.774017', 'PH', 'PHL', '63', 'Asia/Manila', 'tl,en-PH,fil', NULL, NULL),
(168, 'Pitcairn', '-24.703615', '-127.439308', 'PN', 'PCN', '64', 'Pacific/Pitcairn', 'en-PN', NULL, NULL),
(169, 'Poland', '51.919438', '19.145136', 'PL', 'POL', '48', 'Europe/Warsaw', 'pl', NULL, NULL),
(170, 'Portugal', '39.399872', '-8.224454', 'PT', 'PRT', '351', 'Europe/Lisbon', 'pt-PT,mwl', NULL, NULL),
(171, 'Puerto Rico', '18.220833', '-66.590149', 'PR', 'PRI', '1-787, 1-939', 'America/Puerto_Rico', 'en-PR,es-PR', NULL, NULL),
(172, 'Qatar', '25.354826', '51.183884', 'QA', 'QAT', '974', 'Asia/Qatar', 'ar-QA,es', NULL, NULL),
(173, 'Republic of the Congo', '-0.228021', '15.827659', 'CG', 'COG', '242', 'Africa/Lagos', 'fr-CG,kg,ln-CG', NULL, NULL),
(174, 'Reunion', '-21.115141', '55.536384', 'RE', 'REU', '262', 'Indian/Reunion', 'fr-RE', NULL, NULL),
(175, 'Romania', '45.943161', '24.96676', 'RO', 'ROU', '40', 'Europe/Bucharest', 'ro,hu,rom', NULL, NULL),
(176, 'Russia', '61.52401', '105.318756', 'RU', 'RUS', '7', 'Europe/Moscow', 'ru,tt,xal,cau,ady,kv,ce,tyv,cv,udm,tut,mns,bua,myv,mdf,chm,ba,inh,tut,kbd,krc,ava,sah,nog', NULL, NULL),
(177, 'Rwanda', '-1.940278', '29.873888', 'RW', 'RWA', '250', 'Africa/Maputo', 'rw,en-RW,fr-RW,sw', NULL, NULL),
(178, 'Saint Barthelemy', '', '', 'BL', 'BLM', '590', 'America/Port_of_Spain', 'fr', NULL, NULL),
(179, 'Saint Helena', '-24.143474', '-10.030696', 'SH', 'SHN', '290', 'Africa/Abidjan', 'en-SH', NULL, NULL),
(180, 'Saint Kitts and Nevis', '17.357822', '-62.782998', 'KN', 'KNA', '1-869', 'America/Port_of_Spain', 'en-KN', NULL, NULL),
(181, 'Saint Lucia', '13.909444', '-60.978893', 'LC', 'LCA', '1-758', 'America/Port_of_Spain', 'en-LC', NULL, NULL),
(182, 'Saint Martin', '', '', 'MF', 'MAF', '590', 'America/Port_of_Spain', 'fr', NULL, NULL),
(183, 'Saint Pierre and Miquelon', '46.941936', '-56.27111', 'PM', 'SPM', '508', 'America/Miquelon', 'fr-PM', NULL, NULL),
(184, 'Saint Vincent and the Grenadines', '12.984305', '-61.287228', 'VC', 'VCT', '1-784', 'America/Port_of_Spain', 'en-VC,fr', NULL, NULL),
(185, 'Samoa', '-13.759029', '-172.104629', 'WS', 'WSM', '685', 'Pacific/Apia', 'sm,en-WS', NULL, NULL),
(186, 'San Marino', '43.94236', '12.457777', 'SM', 'SMR', '378', 'Europe/Rome', 'it-SM', NULL, NULL),
(187, 'Sao Tome and Principe', '0.18636', '6.613081', 'ST', 'STP', '239', 'Africa/Abidjan', 'pt-ST', NULL, NULL),
(188, 'Saudi Arabia', '23.885942', '45.079162', 'SA', 'SAU', '966', 'Asia/Riyadh', 'ar-SA', NULL, NULL),
(189, 'Senegal', '14.497401', '-14.452362', 'SN', 'SEN', '221', 'Africa/Abidjan', 'fr-SN,wo,fuc,mnk', NULL, NULL),
(190, 'Serbia', '44.016521', '21.005859', 'RS', 'SRB', '381', 'Europe/Belgrade', 'sr,hu,bs,rom', NULL, NULL),
(191, 'Seychelles', '-4.679574', '55.491977', 'SC', 'SYC', '248', 'Indian/Mahe', 'en-SC,fr-SC', NULL, NULL),
(192, 'Sierra Leone', '8.460555', '-11.779889', 'SL', 'SLE', '232', 'Africa/Abidjan', 'en-SL,men,tem', NULL, NULL),
(193, 'Singapore', '1.352083', '103.819836', 'SG', 'SGP', '65', 'Asia/Singapore', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', NULL, NULL),
(194, 'Sint Maarten', '18.075277', '-63.060001', 'SX', 'SXM', '1-721', 'America/Curacao', 'nl,en', NULL, NULL),
(195, 'Slovakia', '48.669026', '19.699024', 'SK', 'SVK', '421', 'Europe/Prague', 'sk,hu', NULL, NULL),
(196, 'Slovenia', '46.151241', '14.995463', 'SI', 'SVN', '386', 'Europe/Belgrade', 'sl,sh', NULL, NULL),
(197, 'Solomon Islands', '-9.64571', '160.156194', 'SB', 'SLB', '677', 'Pacific/Guadalcanal', 'en-SB,tpi', NULL, NULL),
(198, 'Somalia', '5.152149', '46.199616', 'SO', 'SOM', '252', 'Africa/Mogadishu', 'so-SO,ar-SO,it,en-SO', NULL, NULL),
(199, 'South Africa', '-30.559482', '22.937506', 'ZA', 'ZAF', '27', 'Africa/Johannesburg', 'zu,xh,af,nso,en-ZA,tn,st,ts,ss,ve,nr', NULL, NULL),
(200, 'South Korea', '35.907757', '127.766922', 'KR', 'KOR', '82', 'Asia/Seoul', 'ko-KR,en', NULL, NULL),
(201, 'South Sudan', '', '', 'SS', 'SSD', '211', 'Africa/Khartoum', 'en', NULL, NULL),
(202, 'Spain', '40.463667', '-3.74922', 'ES', 'ESP', '34', 'Europe/Madrid', 'es-ES,ca,gl,eu,oc', NULL, NULL),
(203, 'Sri Lanka', '7.873054', '80.771797', 'LK', 'LKA', '94', 'Asia/Colombo', 'si,ta,en', NULL, NULL),
(204, 'Sudan', '12.862807', '30.217636', 'SD', 'SDN', '249', 'Africa/Khartoum', 'ar-SD,en,fia', NULL, NULL),
(205, 'Suriname', '3.919305', '-56.027783', 'SR', 'SUR', '597', 'America/Paramaribo', 'nl-SR,en,srn,hns,jv', NULL, NULL),
(206, 'Svalbard and Jan Mayen', '77.553604', '23.670272', 'SJ', 'SJM', '47', 'Europe/Oslo', 'no,ru', NULL, NULL),
(207, 'Swaziland', '-26.522503', '31.465866', 'SZ', 'SWZ', '268', 'Africa/Johannesburg', 'en-SZ,ss-SZ', NULL, NULL),
(208, 'Sweden', '60.128161', '18.643501', 'SE', 'SWE', '46', 'Europe/Stockholm', 'sv-SE,se,sma,fi-SE', NULL, NULL),
(209, 'Switzerland', '46.818188', '8.227512', 'CH', 'CHE', '41', 'Europe/Zurich', 'de-CH,fr-CH,it-CH,rm', NULL, NULL),
(210, 'Syria', '34.802075', '38.996815', 'SY', 'SYR', '963', 'Asia/Damascus', 'ar-SY,ku,hy,arc,fr,en', NULL, NULL),
(211, 'Taiwan', '23.69781', '120.960515', 'TW', 'TWN', '886', 'Asia/Taipei', 'zh-TW,zh,nan,hak', NULL, NULL),
(212, 'Tajikistan', '38.861034', '71.276093', 'TJ', 'TJK', '992', 'Asia/Dushanbe', 'tg,ru', NULL, NULL),
(213, 'Tanzania', '-6.369028', '34.888822', 'TZ', 'TZA', '255', 'Africa/Dar_es_Salaam', 'sw-TZ,en,ar', NULL, NULL),
(214, 'Thailand', '15.870032', '100.992541', 'TH', 'THA', '66', 'Asia/Bangkok', 'th,en', NULL, NULL),
(215, 'Togo', '8.619543', '0.824782', 'TG', 'TGO', '228', 'Africa/Abidjan', 'fr-TG,ee,hna,kbp,dag,ha', NULL, NULL),
(216, 'Tokelau', '-8.967363', '-171.855881', 'TK', 'TKL', '690', 'Pacific/Fakaofo', 'tkl,en-TK', NULL, NULL),
(217, 'Tonga', '-21.178986', '-175.198242', 'TO', 'TON', '676', 'Pacific/Tongatapu', 'to,en-TO', NULL, NULL),
(218, 'Trinidad and Tobago', '10.691803', '-61.222503', 'TT', 'TTO', '1-868', 'America/Port_of_Spain', 'en-TT,hns,fr,es,zh', NULL, NULL),
(219, 'Tunisia', '33.886917', '9.537499', 'TN', 'TUN', '216', 'Africa/Tunis', 'ar-TN,fr', NULL, NULL),
(220, 'Turkey', '38.963745', '35.243322', 'TR', 'TUR', '90', 'Europe/Istanbul', 'tr-TR,ku,diq,az,av', NULL, NULL),
(221, 'Turkmenistan', '38.969719', '59.556278', 'TM', 'TKM', '993', 'Asia/Ashgabat', 'tk,ru,uz', NULL, NULL),
(222, 'Turks and Caicos Islands', '21.694025', '-71.797928', 'TC', 'TCA', '1-649', 'America/Grand_Turk', 'en-TC', NULL, NULL),
(223, 'Tuvalu', '-7.109535', '177.64933', 'TV', 'TUV', '688', 'Pacific/Funafuti', 'tvl,en,sm,gil', NULL, NULL),
(224, 'U.S. Virgin Islands', '18.335765', '-64.896335', 'VI', 'VIR', '1-340', 'America/Port_of_Spain', 'en-VI', NULL, NULL),
(225, 'Uganda', '1.373333', '32.290275', 'UG', 'UGA', '256', 'Africa/Kampala', 'en-UG,lg,sw,ar', NULL, NULL),
(226, 'Ukraine', '48.379433', '31.16558', 'UA', 'UKR', '380', 'Europe/Kiev', 'uk,ru-UA,rom,pl,hu', NULL, NULL),
(227, 'United Arab Emirates', '23.424076', '53.847818', 'AE', 'ARE', '971', 'Asia/Dubai', 'ar-AE,fa,en,hi,ur', NULL, NULL),
(228, 'United Kingdom', '55.378051', '-3.435973', 'GB', 'GBR', '44', 'Europe/London', 'en-GB,cy-GB,gd', NULL, NULL),
(229, 'United States', '37.09024', '-95.712891', 'US', 'USA', '1', 'America/New_York', 'en-US,es-US,haw,fr', NULL, NULL),
(230, 'Uruguay', '-32.522779', '-55.765835', 'UY', 'URY', '598', 'America/Montevideo', 'es-UY', NULL, NULL),
(231, 'Uzbekistan', '41.377491', '64.585262', 'UZ', 'UZB', '998', 'Asia/Tashkent', 'uz,ru,tg', NULL, NULL),
(232, 'Vanuatu', '-15.376706', '166.959158', 'VU', 'VUT', '678', 'Pacific/Efate', 'bi,en-VU,fr-VU', NULL, NULL),
(233, 'Vatican', '41.902916', '12.453389', 'VA', 'VAT', '379', 'Europe/Rome', 'la,it,fr', NULL, NULL),
(234, 'Venezuela', '6.42375', '-66.58973', 'VE', 'VEN', '58', 'America/Caracas', 'es-VE', NULL, NULL),
(235, 'Vietnam', '14.058324', '108.277199', 'VN', 'VNM', '84', 'Asia/Ho_Chi_Minh', 'vi,en,fr,zh,km', NULL, NULL),
(236, 'Wallis and Futuna', '-13.768752', '-177.156097', 'WF', 'WLF', '681', 'Pacific/Wallis', 'wls,fud,fr-WF', NULL, NULL),
(237, 'Western Sahara', '24.215527', '-12.885834', 'EH', 'ESH', '212', 'Africa/El_Aaiun', 'ar,mey', NULL, NULL),
(238, 'Yemen', '15.552727', '48.516388', 'YE', 'YEM', '967', 'Asia/Aden', 'ar-YE', NULL, NULL),
(239, 'Zambia', '-13.133897', '27.849332', 'ZM', 'ZMB', '260', 'Africa/Maputo', 'en-ZM,bem,loz,lun,lue,ny,toi', NULL, NULL),
(240, 'Zimbabwe', '-19.015438', '29.154857', 'ZW', 'ZWE', '263', 'Africa/Maputo', 'en-ZW,sn,nr,nd', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_contacts_fields`
--

CREATE TABLE `custom_contacts_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'text',
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `custom_contacts_fields`
--

INSERT INTO `custom_contacts_fields` (`id`, `name`, `type`, `company_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Debe', 'text', 1, NULL, '2024-05-25 18:59:01', '2024-05-25 19:01:22'),
(2, 'Matricula', 'text', 1, NULL, '2024-05-25 18:59:17', '2024-05-25 19:01:15'),
(3, 'Programa', 'text', 1, NULL, '2024-05-25 18:59:32', '2024-05-25 18:59:32'),
(4, 'Nivel', 'text', 1, NULL, '2024-05-25 19:02:11', '2024-05-25 19:02:11'),
(5, 'Clave', 'text', 1, NULL, '2024-06-10 15:37:19', '2024-06-10 15:37:19'),
(6, 'Fecha', 'text', 1, NULL, '2024-07-08 19:50:30', '2024-07-09 17:03:46'),
(7, 'coordinador', 'text', 1, NULL, '2024-07-31 17:07:25', '2024-07-31 17:07:25'),
(15, 'correo', 'text', 1, NULL, '2025-05-20 19:25:19', '2025-05-20 19:25:19'),
(16, 'fecha_del', 'text', 1, '2025-05-26 22:11:31', '2025-05-26 19:54:30', '2025-05-26 22:11:31'),
(17, 'fecha_al', 'text', 1, '2025-05-26 22:11:27', '2025-05-26 19:54:30', '2025-05-26 22:11:27'),
(18, 'fechaal', 'text', 1, NULL, '2025-05-26 22:06:25', '2025-05-26 22:06:25'),
(19, 'fechadel', 'text', 1, NULL, '2025-05-26 22:06:25', '2025-05-26 22:06:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_contacts_fields_contacts`
--

CREATE TABLE `custom_contacts_fields_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `custom_contacts_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `custom_contacts_fields_contacts`
--

INSERT INTO `custom_contacts_fields_contacts` (`id`, `contact_id`, `custom_contacts_field_id`, `value`) VALUES
(12444, 8130, 2, '480142237'),
(12445, 8130, 3, 'Medicina'),
(12446, 8130, 4, 'MED'),
(12447, 8130, 5, 'MED'),
(12448, 8130, 7, 'Arturo Cadenas Andrade '),
(12449, 8130, 6, '07/06/2025'),
(12450, 8131, 2, '480143363'),
(12451, 8131, 3, 'Medicina'),
(12452, 8131, 4, 'MED'),
(12453, 8131, 5, 'MED'),
(12454, 8131, 7, 'Arturo Cadenas Andrade '),
(12455, 8131, 6, '07/06/2025'),
(12456, 8132, 2, '52214640'),
(12457, 8132, 3, 'Medicina'),
(12458, 8132, 4, 'MED'),
(12459, 8132, 5, 'MED'),
(12460, 8132, 7, 'Arturo Cadenas Andrade '),
(12461, 8132, 6, '07/06/2025'),
(12462, 8133, 2, '480143307'),
(12463, 8133, 3, 'Medicina'),
(12464, 8133, 4, 'MED'),
(12465, 8133, 5, 'MED'),
(12466, 8133, 7, 'Arturo Cadenas Andrade '),
(12467, 8133, 6, '07/06/2025'),
(14028, 8384, 2, '480143441'),
(14029, 8384, 3, 'Medicina'),
(14030, 8384, 4, 'MED'),
(14031, 8384, 5, 'MED'),
(14032, 8384, 7, 'Arturo Cadenas Andrade '),
(14033, 8384, 6, '07/06/2025'),
(14034, 8385, 2, '480143733'),
(14035, 8385, 3, 'Medicina'),
(14036, 8385, 4, 'MED'),
(14037, 8385, 5, 'MED'),
(14038, 8385, 7, 'Arturo Cadenas Andrade '),
(14039, 8385, 6, '07/06/2025'),
(14040, 8386, 2, '480144015'),
(14041, 8386, 3, 'Medicina'),
(14042, 8386, 4, 'MED'),
(14043, 8386, 5, 'MED'),
(14044, 8386, 7, 'Arturo Cadenas Andrade '),
(14045, 8386, 6, '07/06/2025'),
(14046, 8387, 2, '480144528'),
(14047, 8387, 3, 'Medicina'),
(14048, 8387, 4, 'MED'),
(14049, 8387, 5, 'MED'),
(14050, 8387, 7, 'Arturo Cadenas Andrade '),
(14051, 8387, 6, '07/06/2025'),
(14052, 8388, 2, '480144577'),
(14053, 8388, 3, 'Medicina'),
(14054, 8388, 4, 'MED'),
(14055, 8388, 5, 'MED'),
(14056, 8388, 7, 'Arturo Cadenas Andrade '),
(14057, 8388, 6, '07/06/2025'),
(14058, 8389, 2, '480142696'),
(14059, 8389, 3, 'Medicina'),
(14060, 8389, 4, 'MED'),
(14061, 8389, 5, 'MED'),
(14062, 8389, 7, 'Arturo Cadenas Andrade '),
(14063, 8389, 6, '07/06/2025'),
(14064, 8390, 2, '480144741'),
(14065, 8390, 3, 'Medicina'),
(14066, 8390, 4, 'MED'),
(14067, 8390, 5, 'MED'),
(14068, 8390, 7, 'Arturo Cadenas Andrade '),
(14069, 8390, 6, '07/06/2025'),
(14070, 8391, 2, '480145579'),
(14071, 8391, 3, 'Medicina'),
(14072, 8391, 4, 'MED'),
(14073, 8391, 5, 'MED'),
(14074, 8391, 7, 'Arturo Cadenas Andrade '),
(14075, 8391, 6, '07/06/2025'),
(14076, 8392, 2, '480145565'),
(14077, 8392, 3, 'Medicina'),
(14078, 8392, 4, 'MED'),
(14079, 8392, 5, 'MED'),
(14080, 8392, 7, 'Arturo Cadenas Andrade '),
(14081, 8392, 6, '07/06/2025'),
(14088, 8394, 2, '480145653'),
(14089, 8394, 3, 'Medicina'),
(14090, 8394, 4, 'MED'),
(14091, 8394, 5, 'MED'),
(14092, 8394, 7, 'Arturo Cadenas Andrade '),
(14093, 8394, 6, '07/06/2025'),
(14094, 8395, 2, '480145671'),
(14095, 8395, 3, 'Medicina'),
(14096, 8395, 4, 'MED'),
(14097, 8395, 5, 'MED'),
(14098, 8395, 7, 'Arturo Cadenas Andrade '),
(14099, 8395, 6, '07/06/2025'),
(14100, 8396, 2, '480145676'),
(14101, 8396, 3, 'Medicina'),
(14102, 8396, 4, 'MED'),
(14103, 8396, 5, 'MED'),
(14104, 8396, 7, 'Arturo Cadenas Andrade '),
(14105, 8396, 6, '07/06/2025'),
(14330, 8429, 2, '480142768'),
(14331, 8429, 3, 'Cirujano Dentista'),
(14332, 8429, 4, 'NC'),
(14333, 8429, 5, 'ODONTO'),
(14334, 8429, 7, 'Laura Chavacano Santos'),
(14335, 8430, 2, '480142696'),
(14336, 8430, 3, 'Cirujano Dentista'),
(14337, 8430, 4, 'NC'),
(14338, 8430, 5, 'ODONTO'),
(14339, 8430, 7, 'Laura Chavacano Santos'),
(14340, 8431, 2, '480143619'),
(14341, 8431, 3, 'Cirujano Dentista'),
(14342, 8431, 4, 'NC'),
(14343, 8431, 5, 'ODONTO'),
(14344, 8431, 7, 'Laura Chavacano Santos'),
(14345, 8432, 2, '480144572'),
(14346, 8432, 3, 'Cirujano Dentista'),
(14347, 8432, 4, 'NC'),
(14348, 8432, 5, 'ODONTO'),
(14349, 8432, 7, 'Laura Chavacano Santos'),
(14350, 8433, 2, '480144715'),
(14351, 8433, 3, 'Cirujano Dentista'),
(14352, 8433, 4, 'NC'),
(14353, 8433, 5, 'ODONTO'),
(14354, 8433, 7, 'Laura Chavacano Santos'),
(14355, 8434, 2, '480144717'),
(14356, 8434, 3, 'Cirujano Dentista'),
(14357, 8434, 4, 'NC'),
(14358, 8434, 5, 'ODONTO'),
(14359, 8434, 7, 'Laura Chavacano Santos'),
(14360, 8435, 2, '480144745'),
(14361, 8435, 3, 'Cirujano Dentista'),
(14362, 8435, 4, 'NC'),
(14363, 8435, 5, 'ODONTO'),
(14364, 8435, 7, 'Laura Chavacano Santos'),
(14365, 8436, 2, '480144516'),
(14366, 8436, 3, 'Cirujano Dentista'),
(14367, 8436, 4, 'NC'),
(14368, 8436, 5, 'ODONTO'),
(14369, 8436, 7, 'Laura Chavacano Santos'),
(14370, 8437, 2, '51037679'),
(14371, 8437, 3, 'Cirujano Dentista'),
(14372, 8437, 4, 'NC'),
(14373, 8437, 5, 'ODONTO'),
(14374, 8437, 7, 'Laura Chavacano Santos'),
(14718, 8487, 2, '480143217'),
(14719, 8487, 3, 'Químico Farmacéutico Biotecnólogo'),
(14720, 8487, 4, 'NC'),
(14721, 8487, 5, 'QUIM'),
(14722, 8487, 7, 'Carolina Trujillo Carretero'),
(14723, 8487, 19, '02/06/2025'),
(14724, 8487, 18, '06/06/2025'),
(14725, 8488, 2, '480144076'),
(14726, 8488, 3, 'Químico Farmacéutico Biotecnólogo'),
(14727, 8488, 4, 'NC'),
(14728, 8488, 5, 'QUIM'),
(14729, 8488, 7, 'Carolina Trujillo Carretero'),
(14730, 8488, 19, '02/06/2025'),
(14731, 8488, 18, '06/06/2025'),
(14732, 8489, 2, '480144507'),
(14733, 8489, 3, 'Químico Farmacéutico Biotecnólogo'),
(14734, 8489, 4, 'NC'),
(14735, 8489, 5, 'QUIM'),
(14736, 8489, 7, 'Carolina Trujillo Carretero'),
(14737, 8489, 19, '02/06/2025'),
(14738, 8489, 18, '06/06/2025'),
(14739, 8490, 2, '480144598'),
(14740, 8490, 3, 'Químico Farmacéutico Biotecnólogo'),
(14741, 8490, 4, 'NC'),
(14742, 8490, 5, 'QUIM'),
(14743, 8490, 7, 'Carolina Trujillo Carretero'),
(14744, 8490, 19, '02/06/2025'),
(14745, 8490, 18, '06/06/2025'),
(14746, 8491, 2, '480144832'),
(14747, 8491, 3, 'Químico Farmacéutico Biotecnólogo'),
(14748, 8491, 4, 'NC'),
(14749, 8491, 5, 'QUIM'),
(14750, 8491, 7, 'Carolina Trujillo Carretero'),
(14751, 8491, 19, '02/06/2025'),
(14752, 8491, 18, '06/06/2025'),
(14753, 8492, 2, '480145536'),
(14754, 8492, 3, 'Químico Farmacéutico Biotecnólogo'),
(14755, 8492, 4, 'NC'),
(14756, 8492, 5, 'QUIM'),
(14757, 8492, 7, 'Carolina Trujillo Carretero'),
(14758, 8492, 19, '02/06/2025'),
(14759, 8492, 18, '06/06/2025'),
(14760, 8493, 2, '51030476'),
(14761, 8493, 3, 'Psicología'),
(14762, 8493, 4, 'NC'),
(14763, 8493, 5, 'PSICO'),
(14764, 8493, 7, 'Bertha Velazquez Garcia'),
(14765, 8493, 19, '02/06/2025'),
(14766, 8493, 18, '06/06/2025'),
(14767, 8494, 2, '480143898'),
(14768, 8494, 3, 'Psicología'),
(14769, 8494, 4, 'NC'),
(14770, 8494, 5, 'PSICO'),
(14771, 8494, 7, 'Bertha Velazquez Garcia'),
(14772, 8494, 19, '02/06/2025'),
(14773, 8494, 18, '06/06/2025'),
(14774, 8495, 2, '51037224'),
(14775, 8495, 3, 'Psicología'),
(14776, 8495, 4, 'NC'),
(14777, 8495, 5, 'PSICO'),
(14778, 8495, 7, 'Bertha Velazquez Garcia'),
(14779, 8495, 19, '02/06/2025'),
(14780, 8495, 18, '06/06/2025'),
(14781, 8496, 2, '480145000'),
(14782, 8496, 3, 'Psicología'),
(14783, 8496, 4, 'NC'),
(14784, 8496, 5, 'PSICO'),
(14785, 8496, 7, 'Bertha Velazquez Garcia'),
(14786, 8496, 19, '02/06/2025'),
(14787, 8496, 18, '06/06/2025'),
(14788, 8497, 2, '480142417'),
(14789, 8497, 3, 'Psicología'),
(14790, 8497, 4, 'NC'),
(14791, 8497, 5, 'PSICO'),
(14792, 8497, 7, 'Bertha Velazquez Garcia'),
(14793, 8497, 19, '02/06/2025'),
(14794, 8497, 18, '06/06/2025'),
(14795, 8498, 2, '480145869'),
(14796, 8498, 3, 'Psicología'),
(14797, 8498, 4, 'NC'),
(14798, 8498, 5, 'PSICO'),
(14799, 8498, 7, 'Bertha Velazquez Garcia'),
(14800, 8498, 19, '02/06/2025'),
(14801, 8498, 18, '06/06/2025'),
(14802, 8499, 2, '480146002'),
(14803, 8499, 3, 'Psicología'),
(14804, 8499, 4, 'NC'),
(14805, 8499, 5, 'PSICO'),
(14806, 8499, 7, 'Bertha Velazquez Garcia'),
(14807, 8499, 19, '02/06/2025'),
(14808, 8499, 18, '06/06/2025'),
(14809, 8500, 2, '480146003'),
(14810, 8500, 3, 'Psicología'),
(14811, 8500, 4, 'NC'),
(14812, 8500, 5, 'PSICO'),
(14813, 8500, 7, 'Bertha Velazquez Garcia'),
(14814, 8500, 19, '02/06/2025'),
(14815, 8500, 18, '06/06/2025'),
(14816, 8501, 2, '51029239'),
(14817, 8501, 3, 'Nutrición'),
(14818, 8501, 4, 'NC'),
(14819, 8501, 5, 'NUTRI'),
(14820, 8501, 7, 'Bertha Velazquez Garcia'),
(14821, 8501, 19, '02/06/2025'),
(14822, 8501, 18, '06/06/2025'),
(14823, 8502, 2, '480144474'),
(14824, 8502, 3, 'Nutrición'),
(14825, 8502, 4, 'NC'),
(14826, 8502, 5, 'NUTRI'),
(14827, 8502, 7, 'Bertha Velazquez Garcia'),
(14828, 8502, 19, '02/06/2025'),
(14829, 8502, 18, '06/06/2025'),
(14830, 8503, 2, '480145058'),
(14831, 8503, 3, 'Nutrición'),
(14832, 8503, 4, 'NC'),
(14833, 8503, 5, 'NUTRI'),
(14834, 8503, 7, 'Bertha Velazquez Garcia'),
(14835, 8503, 19, '02/06/2025'),
(14836, 8503, 18, '06/06/2025'),
(14837, 8504, 2, '480145583'),
(14838, 8504, 3, 'Nutrición'),
(14839, 8504, 4, 'NC'),
(14840, 8504, 5, 'NUTRI'),
(14841, 8504, 7, 'Bertha Velazquez Garcia'),
(14842, 8504, 19, '02/06/2025'),
(14843, 8504, 18, '06/06/2025'),
(14844, 8505, 2, '480145764'),
(14845, 8505, 3, 'Nutrición'),
(14846, 8505, 4, 'NC'),
(14847, 8505, 5, 'NUTRI'),
(14848, 8505, 7, 'Bertha Velazquez Garcia'),
(14849, 8505, 19, '02/06/2025'),
(14850, 8505, 18, '06/06/2025'),
(14851, 8506, 2, '480142697'),
(14852, 8506, 3, 'Ing en Biotecnología'),
(14853, 8506, 4, 'NC'),
(14854, 8506, 5, 'BIO'),
(14855, 8506, 7, 'Carolina Trujillo Carretero'),
(14856, 8506, 19, '02/06/2025'),
(14857, 8506, 18, '06/06/2025'),
(14858, 8507, 2, '480142727'),
(14859, 8507, 3, 'Ing en Biotecnología'),
(14860, 8507, 4, 'NC'),
(14861, 8507, 5, 'BIO'),
(14862, 8507, 7, 'Carolina Trujillo Carretero'),
(14863, 8507, 19, '02/06/2025'),
(14864, 8507, 18, '06/06/2025'),
(14865, 8508, 2, '480143665'),
(14866, 8508, 3, 'Ing en Biotecnología'),
(14867, 8508, 4, 'NC'),
(14868, 8508, 5, 'BIO'),
(14869, 8508, 7, 'Carolina Trujillo Carretero'),
(14870, 8508, 19, '02/06/2025'),
(14871, 8508, 18, '06/06/2025'),
(14872, 8509, 2, '51029304'),
(14873, 8509, 3, 'Ing en Biotecnología'),
(14874, 8509, 4, 'NC'),
(14875, 8509, 5, 'BIO'),
(14876, 8509, 7, 'Carolina Trujillo Carretero'),
(14877, 8509, 19, '02/06/2025'),
(14878, 8509, 18, '06/06/2025'),
(14879, 8510, 2, '480143235'),
(14880, 8510, 3, 'Fisioterapia'),
(14881, 8510, 4, 'NC'),
(14882, 8510, 5, 'FISIO'),
(14883, 8510, 7, 'Diana Estrada Lopez'),
(14884, 8510, 19, '02/06/2025'),
(14885, 8510, 18, '06/06/2025'),
(14886, 8511, 2, '480143918'),
(14887, 8511, 3, 'Fisioterapia'),
(14888, 8511, 4, 'NC'),
(14889, 8511, 5, 'FISIO'),
(14890, 8511, 7, 'Diana Estrada Lopez'),
(14891, 8511, 19, '02/06/2025'),
(14892, 8511, 18, '06/06/2025'),
(14893, 8512, 2, '480143067'),
(14894, 8512, 3, 'Fisioterapia'),
(14895, 8512, 4, 'NC'),
(14896, 8512, 5, 'FISIO'),
(14897, 8512, 7, 'Diana Estrada Lopez'),
(14898, 8512, 19, '02/06/2025'),
(14899, 8512, 18, '06/06/2025'),
(14900, 8513, 2, '51029254'),
(14901, 8513, 3, 'Fisioterapia'),
(14902, 8513, 4, 'NC'),
(14903, 8513, 5, 'FISIO'),
(14904, 8513, 7, 'Diana Estrada Lopez'),
(14905, 8513, 19, '02/06/2025'),
(14906, 8513, 18, '06/06/2025'),
(14907, 8514, 2, '480145741'),
(14908, 8514, 3, 'Fisioterapia'),
(14909, 8514, 4, 'NC'),
(14910, 8514, 5, 'FISIO'),
(14911, 8514, 7, 'Diana Estrada Lopez'),
(14912, 8514, 19, '02/06/2025'),
(14913, 8514, 18, '06/06/2025'),
(14914, 8515, 2, '480145757'),
(14915, 8515, 3, 'Fisioterapia'),
(14916, 8515, 4, 'NC'),
(14917, 8515, 5, 'FISIO'),
(14918, 8515, 7, 'Diana Estrada Lopez'),
(14919, 8515, 19, '02/06/2025'),
(14920, 8515, 18, '06/06/2025'),
(14921, 8516, 2, '480144419'),
(14922, 8516, 3, 'Enfermería'),
(14923, 8516, 4, 'NC'),
(14924, 8516, 5, 'ENF'),
(14925, 8516, 7, 'Robby Carvallo Uscanga'),
(14926, 8516, 19, '02/06/2025'),
(14927, 8516, 18, '06/06/2025'),
(14928, 8517, 2, '480144758'),
(14929, 8517, 3, 'Enfermería'),
(14930, 8517, 4, 'NC'),
(14931, 8517, 5, 'ENF'),
(14932, 8517, 7, 'Robby Carvallo Uscanga'),
(14933, 8517, 19, '02/06/2025'),
(14934, 8517, 18, '06/06/2025'),
(14935, 8518, 2, '480145548'),
(14936, 8518, 3, 'Enfermería'),
(14937, 8518, 4, 'NC'),
(14938, 8518, 5, 'ENF'),
(14939, 8518, 7, 'Robby Carvallo Uscanga'),
(14940, 8518, 19, '02/06/2025'),
(14941, 8518, 18, '06/06/2025'),
(14942, 8519, 2, '480144699'),
(14943, 8519, 3, 'Relaciones Internacionales'),
(14944, 8519, 4, 'L6'),
(14945, 8519, 5, 'RELA '),
(14946, 8519, 7, 'Ana Lilia Gonzalez Lopez'),
(14947, 8519, 19, '02/06/2025'),
(14948, 8519, 18, '06/06/2025'),
(14949, 8520, 2, '51038347'),
(14950, 8520, 3, 'Ing Industrial y de Sistemas'),
(14951, 8520, 4, 'L6'),
(14952, 8520, 5, 'INDUS SIS'),
(14953, 8520, 7, 'Milka Mendoza Rojas'),
(14954, 8520, 19, '02/06/2025'),
(14955, 8520, 18, '06/06/2025'),
(14956, 8521, 2, '51028801'),
(14957, 8521, 3, 'Ing en Sistemas Computacionales'),
(14958, 8521, 4, 'L6'),
(14959, 8521, 5, 'SIS COMPU'),
(14960, 8521, 7, 'Milka Mendoza Rojas'),
(14961, 8521, 19, '02/06/2025'),
(14962, 8521, 18, '06/06/2025'),
(14963, 8522, 2, '51029551'),
(14964, 8522, 3, 'Ing Industrial y de Sistemas'),
(14965, 8522, 4, 'L6'),
(14966, 8522, 5, 'INDUS SIS'),
(14967, 8522, 7, 'Milka Mendoza Rojas'),
(14968, 8522, 19, '02/06/2025'),
(14969, 8522, 18, '06/06/2025'),
(14970, 8523, 2, '51030781'),
(14971, 8523, 3, 'Ing en Sistemas Computacionales'),
(14972, 8523, 4, 'L6'),
(14973, 8523, 5, 'SIS COMPU'),
(14974, 8523, 7, 'Milka Mendoza Rojas'),
(14975, 8523, 19, '02/06/2025'),
(14976, 8523, 18, '06/06/2025'),
(14977, 8524, 2, '480145715'),
(14978, 8524, 3, 'Lenguas Extranjeras'),
(14979, 8524, 4, 'L6'),
(14980, 8524, 5, 'LENG'),
(14981, 8524, 7, 'Ana Lilia Gonzalez Lopez'),
(14982, 8524, 19, '02/06/2025'),
(14983, 8524, 18, '06/06/2025'),
(14984, 8525, 2, '480144133'),
(14985, 8525, 3, 'Lenguas Extranjeras'),
(14986, 8525, 4, 'L6'),
(14987, 8525, 5, 'LENG'),
(14988, 8525, 7, 'Ana Lilia Gonzalez Lopez'),
(14989, 8525, 19, '02/06/2025'),
(14990, 8525, 18, '06/06/2025'),
(14991, 8526, 2, '480145554'),
(14992, 8526, 3, 'Ing Mecatrónica con enf Automotriz'),
(14993, 8526, 4, 'L6'),
(14994, 8526, 5, 'MECA AUTO'),
(14995, 8526, 7, 'Milka Mendoza Rojas'),
(14996, 8526, 19, '02/06/2025'),
(14997, 8526, 18, '06/06/2025'),
(14998, 8527, 2, '480145597'),
(14999, 8527, 3, 'Ing Mecatrónica con enf Automotriz'),
(15000, 8527, 4, 'L6'),
(15001, 8527, 5, 'MECA AUTO'),
(15002, 8527, 7, 'Milka Mendoza Rojas'),
(15003, 8527, 19, '02/06/2025'),
(15004, 8527, 18, '06/06/2025'),
(15005, 8528, 2, '480145616'),
(15006, 8528, 3, 'Ing Mecatrónica con enf Automotriz'),
(15007, 8528, 4, 'L6'),
(15008, 8528, 5, 'MECA AUTO'),
(15009, 8528, 7, 'Milka Mendoza Rojas'),
(15010, 8528, 19, '02/06/2025'),
(15011, 8528, 18, '06/06/2025'),
(15012, 8529, 2, '480145695'),
(15013, 8529, 3, 'Ing Mecatrónica con enf Automotriz'),
(15014, 8529, 4, 'L6'),
(15015, 8529, 5, 'MECA AUTO'),
(15016, 8529, 7, 'Milka Mendoza Rojas'),
(15017, 8529, 19, '02/06/2025'),
(15018, 8529, 18, '06/06/2025'),
(15019, 8530, 2, '51028827'),
(15020, 8530, 3, 'Ing Mecatrónica'),
(15021, 8530, 4, 'L6'),
(15022, 8530, 5, 'MECA'),
(15023, 8530, 7, 'Milka Mendoza Rojas'),
(15024, 8530, 19, '02/06/2025'),
(15025, 8530, 18, '06/06/2025'),
(15026, 8531, 2, '480143475'),
(15027, 8531, 3, 'Ing Mecatrónica'),
(15028, 8531, 4, 'L6'),
(15029, 8531, 5, 'MECA'),
(15030, 8531, 7, 'Milka Mendoza Rojas'),
(15031, 8531, 19, '02/06/2025'),
(15032, 8531, 18, '06/06/2025'),
(15033, 8532, 2, '480142293'),
(15034, 8532, 3, 'Ing Industrial y de Sistemas'),
(15035, 8532, 4, 'L6'),
(15036, 8532, 5, 'INDUS SIS'),
(15037, 8532, 7, 'Milka Mendoza Rojas'),
(15038, 8532, 19, '02/06/2025'),
(15039, 8532, 18, '06/06/2025'),
(15040, 8533, 2, '480142258'),
(15041, 8533, 3, 'Ing Industrial y de Sistemas'),
(15042, 8533, 4, 'L6'),
(15043, 8533, 5, 'INDUS SIS'),
(15044, 8533, 7, 'Milka Mendoza Rojas'),
(15045, 8533, 19, '02/06/2025'),
(15046, 8533, 18, '06/06/2025'),
(15047, 8534, 2, '480143617'),
(15048, 8534, 3, 'Ing Industrial y de Sistemas'),
(15049, 8534, 4, 'L6'),
(15050, 8534, 5, 'INDUS SIS'),
(15051, 8534, 7, 'Milka Mendoza Rojas'),
(15052, 8534, 19, '02/06/2025'),
(15053, 8534, 18, '06/06/2025'),
(15054, 8535, 2, '480143640'),
(15055, 8535, 3, 'Ing Industrial y de Sistemas'),
(15056, 8535, 4, 'L6'),
(15057, 8535, 5, 'INDUS SIS'),
(15058, 8535, 7, 'Milka Mendoza Rojas'),
(15059, 8535, 19, '02/06/2025'),
(15060, 8535, 18, '06/06/2025'),
(15061, 8536, 2, '51029437'),
(15062, 8536, 3, 'Ing Industrial y de Sistemas'),
(15063, 8536, 4, 'L6'),
(15064, 8536, 5, 'INDUS SIS'),
(15065, 8536, 7, 'Milka Mendoza Rojas'),
(15066, 8536, 19, '02/06/2025'),
(15067, 8536, 18, '06/06/2025'),
(15068, 8537, 2, '480143244'),
(15069, 8537, 3, 'Ing en Sistemas Computacionales'),
(15070, 8537, 4, 'L6'),
(15071, 8537, 5, 'SIS COMPU'),
(15072, 8537, 7, 'Milka Mendoza Rojas'),
(15073, 8537, 19, '02/06/2025'),
(15074, 8537, 18, '06/06/2025'),
(15075, 8538, 2, '480144564'),
(15076, 8538, 3, 'Ing en Sistemas Computacionales'),
(15077, 8538, 4, 'L6'),
(15078, 8538, 5, 'SIS COMPU'),
(15079, 8538, 7, 'Milka Mendoza Rojas'),
(15080, 8538, 19, '02/06/2025'),
(15081, 8538, 18, '06/06/2025'),
(15082, 8539, 2, '480143270'),
(15083, 8539, 3, 'Ing en Petróleo y Gas'),
(15084, 8539, 4, 'L6'),
(15085, 8539, 5, 'PETRO GAS'),
(15086, 8539, 7, 'Carlos Quezada Herrera'),
(15087, 8539, 19, '02/06/2025'),
(15088, 8539, 18, '06/06/2025'),
(15089, 8540, 2, '480145631'),
(15090, 8540, 3, 'Ing en Petróleo y Gas'),
(15091, 8540, 4, 'L6'),
(15092, 8540, 5, 'PETRO GAS'),
(15093, 8540, 7, 'Carlos Quezada Herrera'),
(15094, 8540, 19, '02/06/2025'),
(15095, 8540, 18, '06/06/2025'),
(15096, 8541, 2, '480142769'),
(15097, 8541, 3, 'Ing en Energía y Desarrollo Sustentable'),
(15098, 8541, 4, 'L6'),
(15099, 8541, 5, 'ENERGIA'),
(15100, 8541, 7, 'Melissa Avendaño Oropeza'),
(15101, 8541, 19, '02/06/2025'),
(15102, 8541, 18, '06/06/2025'),
(15103, 8542, 2, '480143725'),
(15104, 8542, 3, 'Ing en Desarrollo de Videojuegos'),
(15105, 8542, 4, 'L6'),
(15106, 8542, 5, 'VIDEO'),
(15107, 8542, 7, 'Juan Arboleyda Valdovinos'),
(15108, 8542, 19, '02/06/2025'),
(15109, 8542, 18, '06/06/2025'),
(15110, 8543, 2, '480145573'),
(15111, 8543, 3, 'Ing en Desarrollo de Videojuegos'),
(15112, 8543, 4, 'L6'),
(15113, 8543, 5, 'VIDEO'),
(15114, 8543, 7, 'Juan Arboleyda Valdovinos'),
(15115, 8543, 19, '02/06/2025'),
(15116, 8543, 18, '06/06/2025'),
(15117, 8544, 2, '480144557'),
(15118, 8544, 3, 'Ing Civil'),
(15119, 8544, 4, 'L6'),
(15120, 8544, 5, 'CIVIL'),
(15121, 8544, 7, 'Juan Arboleyda Valdovinos'),
(15122, 8544, 19, '02/06/2025'),
(15123, 8544, 18, '06/06/2025'),
(15124, 8545, 2, '480144662'),
(15125, 8545, 3, 'Ing Civil'),
(15126, 8545, 4, 'L6'),
(15127, 8545, 5, 'CIVIL'),
(15128, 8545, 7, 'Juan Arboleyda Valdovinos'),
(15129, 8545, 19, '02/06/2025'),
(15130, 8545, 18, '06/06/2025'),
(15131, 8546, 2, '480145709'),
(15132, 8546, 3, 'Ing Civil'),
(15133, 8546, 4, 'L6'),
(15134, 8546, 5, 'CIVIL'),
(15135, 8546, 7, 'Juan Arboleyda Valdovinos'),
(15136, 8546, 19, '02/06/2025'),
(15137, 8546, 18, '06/06/2025'),
(15138, 8547, 2, '480143062'),
(15139, 8547, 3, 'Gastronomía Internacional'),
(15140, 8547, 4, 'L6'),
(15141, 8547, 5, 'GASTRO'),
(15142, 8547, 7, 'Carlos Quezada Herrera'),
(15143, 8547, 19, '02/06/2025'),
(15144, 8547, 18, '06/06/2025'),
(15145, 8548, 2, '480142653'),
(15146, 8548, 3, 'Gastronomía Internacional'),
(15147, 8548, 4, 'L6'),
(15148, 8548, 5, 'GASTRO'),
(15149, 8548, 7, 'Carlos Quezada Herrera'),
(15150, 8548, 19, '02/06/2025'),
(15151, 8548, 18, '06/06/2025'),
(15152, 8549, 2, '480144461'),
(15153, 8549, 3, 'Gastronomía Internacional'),
(15154, 8549, 4, 'L6'),
(15155, 8549, 5, 'GASTRO'),
(15156, 8549, 7, 'Carlos Quezada Herrera'),
(15157, 8549, 19, '02/06/2025'),
(15158, 8549, 18, '06/06/2025'),
(15159, 8550, 2, '480145575'),
(15160, 8550, 3, 'Gastronomía Internacional'),
(15161, 8550, 4, 'L6'),
(15162, 8550, 5, 'GASTRO'),
(15163, 8550, 7, 'Carlos Quezada Herrera'),
(15164, 8550, 19, '02/06/2025'),
(15165, 8550, 18, '06/06/2025'),
(15166, 8551, 2, '480143053'),
(15167, 8551, 3, 'Gastronomía Internacional'),
(15168, 8551, 4, 'L6'),
(15169, 8551, 5, 'GASTRO'),
(15170, 8551, 7, 'Carlos Quezada Herrera'),
(15171, 8551, 19, '02/06/2025'),
(15172, 8551, 18, '06/06/2025'),
(15173, 8552, 2, '480143255'),
(15174, 8552, 3, 'Diseño y Comunicación Gráfica'),
(15175, 8552, 4, 'L6'),
(15176, 8552, 5, 'DISEÑO'),
(15177, 8552, 7, 'Juan Arboleyda Valdovinos'),
(15178, 8552, 19, '02/06/2025'),
(15179, 8552, 18, '06/06/2025'),
(15180, 8553, 2, '480144590'),
(15181, 8553, 3, 'Diseño y Comunicación Gráfica'),
(15182, 8553, 4, 'L6'),
(15183, 8553, 5, 'DISEÑO'),
(15184, 8553, 7, 'Juan Arboleyda Valdovinos'),
(15185, 8553, 19, '02/06/2025'),
(15186, 8553, 18, '06/06/2025'),
(15187, 8554, 2, '480143737'),
(15188, 8554, 3, 'Derecho'),
(15189, 8554, 4, 'L6'),
(15190, 8554, 5, 'DERECHO'),
(15191, 8554, 7, 'Ana Lilia Gonzalez Lopez'),
(15192, 8554, 19, '02/06/2025'),
(15193, 8554, 18, '06/06/2025'),
(15194, 8555, 2, '480145066'),
(15195, 8555, 3, 'Derecho'),
(15196, 8555, 4, 'L6'),
(15197, 8555, 5, 'DERECHO'),
(15198, 8555, 7, 'Ana Lilia Gonzalez Lopez'),
(15199, 8555, 19, '02/06/2025'),
(15200, 8555, 18, '06/06/2025'),
(15201, 8556, 2, '480144515'),
(15202, 8556, 3, 'Criminología'),
(15203, 8556, 4, 'L6'),
(15204, 8556, 5, 'CRIMI'),
(15205, 8556, 7, 'Ana Lilia Gonzalez Lopez'),
(15206, 8556, 19, '02/06/2025'),
(15207, 8556, 18, '06/06/2025'),
(15208, 8557, 2, '480146078'),
(15209, 8557, 3, 'Contaduría Pública y Finanzas'),
(15210, 8557, 4, 'L6'),
(15211, 8557, 5, 'CONTA'),
(15212, 8557, 7, 'Rogelio Rosado Dominguez'),
(15213, 8557, 19, '02/06/2025'),
(15214, 8557, 18, '06/06/2025'),
(15215, 8558, 2, '480145740'),
(15216, 8558, 3, 'Comunicación y Medios Digitales'),
(15217, 8558, 4, 'L6'),
(15218, 8558, 5, 'COMU'),
(15219, 8558, 7, 'Ana Lilia Gonzalez Lopez'),
(15220, 8558, 19, '02/06/2025'),
(15221, 8558, 18, '06/06/2025'),
(15222, 8559, 2, '480143997'),
(15223, 8559, 3, 'Arquitectura'),
(15224, 8559, 4, 'L6'),
(15225, 8559, 5, 'ARQ'),
(15226, 8559, 7, 'Juan Arboleyda Valdovinos'),
(15227, 8559, 19, '02/06/2025'),
(15228, 8559, 18, '06/06/2025'),
(15229, 8560, 2, '480143809'),
(15230, 8560, 3, 'Arquitectura'),
(15231, 8560, 4, 'L6'),
(15232, 8560, 5, 'ARQ'),
(15233, 8560, 7, 'Juan Arboleyda Valdovinos'),
(15234, 8560, 19, '02/06/2025'),
(15235, 8560, 18, '06/06/2025'),
(15236, 8561, 2, '480143676'),
(15237, 8561, 3, 'Arquitectura'),
(15238, 8561, 4, 'L6'),
(15239, 8561, 5, 'ARQ'),
(15240, 8561, 7, 'Juan Arboleyda Valdovinos'),
(15241, 8561, 19, '02/06/2025'),
(15242, 8561, 18, '06/06/2025'),
(15243, 8562, 2, '480144067'),
(15244, 8562, 3, 'Arquitectura'),
(15245, 8562, 4, 'L6'),
(15246, 8562, 5, 'ARQ'),
(15247, 8562, 7, 'Juan Arboleyda Valdovinos'),
(15248, 8562, 19, '02/06/2025'),
(15249, 8562, 18, '06/06/2025'),
(15250, 8563, 2, '480143704'),
(15251, 8563, 3, 'Administración Turística y Hotelera'),
(15252, 8563, 4, 'L6'),
(15253, 8563, 5, 'HOTEL'),
(15254, 8563, 7, 'Carlos Quezada Herrera'),
(15255, 8563, 19, '02/06/2025'),
(15256, 8563, 18, '06/06/2025'),
(15257, 8564, 2, '51030518'),
(15258, 8564, 3, 'Administración Turística y Hotelera'),
(15259, 8564, 4, 'L6'),
(15260, 8564, 5, 'HOTEL'),
(15261, 8564, 7, 'Carlos Quezada Herrera'),
(15262, 8564, 19, '02/06/2025'),
(15263, 8564, 18, '06/06/2025'),
(15264, 8565, 2, '480143582'),
(15265, 8565, 3, 'Actuaría'),
(15266, 8565, 4, 'L6'),
(15267, 8565, 5, 'ACTUA'),
(15268, 8565, 7, 'Rogelio Rosado Dominguez'),
(15269, 8565, 19, '02/06/2025'),
(15270, 8565, 18, '06/06/2025'),
(15271, 8566, 2, '51030278'),
(15272, 8566, 3, 'Actuaría'),
(15273, 8566, 4, 'L6'),
(15274, 8566, 5, 'ACTUA'),
(15275, 8566, 7, 'Rogelio Rosado Dominguez'),
(15276, 8566, 19, '02/06/2025'),
(15277, 8566, 18, '06/06/2025'),
(15306, 8567, 2, '51037547'),
(15307, 8567, 3, 'Actuaría'),
(15308, 8567, 4, 'L6'),
(15309, 8567, 5, 'ACTUA'),
(15310, 8567, 7, 'Rogelio Rosado Dominguez'),
(15311, 8567, 18, '06/06/2025'),
(15312, 8567, 19, '02/06/2025');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flows`
--

CREATE TABLE `flows` (
  `id` int(11) NOT NULL,
  `nodes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`nodes`)),
  `connections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`connections`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `flows`
--

INSERT INTO `flows` (`id`, `nodes`, `connections`, `created_at`, `updated_at`, `company_id`, `name`) VALUES
(2, '[{\"id\": 0, \"data\": {\"message\": \"Registrarme\"}, \"name\": \"Start\"}]', '[]', '2024-07-18 18:07:14', '2024-07-18 18:08:29', 3, 'Test1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `company_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(54, 'PRUEBAS', 1, '2025-05-29 23:30:31', '2025-05-21 17:31:38', '2025-05-29 23:30:31'),
(55, 'MED230525', 1, NULL, '2025-05-23 22:34:18', '2025-05-23 22:34:18'),
(58, 'EXUBI260525', 1, NULL, '2025-05-26 19:54:30', '2025-05-26 19:54:30'),
(59, 'ODO230525', 1, NULL, '2025-05-26 22:06:28', '2025-05-26 22:06:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_contacts`
--

CREATE TABLE `groups_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `groups_contacts`
--

INSERT INTO `groups_contacts` (`id`, `contact_id`, `group_id`) VALUES
(8372, 8130, 55),
(8373, 8131, 55),
(8374, 8132, 55),
(8375, 8133, 55),
(8626, 8384, 55),
(8627, 8385, 55),
(8628, 8386, 55),
(8629, 8387, 55),
(8630, 8388, 55),
(8631, 8389, 55),
(8632, 8390, 55),
(8633, 8391, 55),
(8634, 8392, 55),
(8636, 8394, 55),
(8637, 8395, 55),
(8638, 8396, 55),
(8671, 8429, 59),
(8672, 8430, 59),
(8673, 8431, 59),
(8674, 8432, 59),
(8675, 8433, 59),
(8676, 8434, 59),
(8677, 8435, 59),
(8678, 8436, 59),
(8679, 8437, 59),
(8729, 8487, 58),
(8730, 8488, 58),
(8731, 8489, 58),
(8732, 8490, 58),
(8733, 8491, 58),
(8734, 8492, 58),
(8735, 8493, 58),
(8736, 8494, 58),
(8737, 8495, 58),
(8738, 8496, 58),
(8739, 8497, 58),
(8740, 8498, 58),
(8741, 8499, 58),
(8742, 8500, 58),
(8743, 8501, 58),
(8744, 8502, 58),
(8745, 8503, 58),
(8746, 8504, 58),
(8747, 8505, 58),
(8748, 8506, 58),
(8749, 8507, 58),
(8750, 8508, 58),
(8751, 8509, 58),
(8752, 8510, 58),
(8753, 8511, 58),
(8754, 8512, 58),
(8755, 8513, 58),
(8756, 8514, 58),
(8757, 8515, 58),
(8758, 8516, 58),
(8759, 8517, 58),
(8760, 8518, 58),
(8761, 8519, 58),
(8762, 8520, 58),
(8763, 8521, 58),
(8764, 8522, 58),
(8765, 8523, 58),
(8766, 8524, 58),
(8767, 8525, 58),
(8768, 8526, 58),
(8769, 8527, 58),
(8770, 8528, 58),
(8771, 8529, 58),
(8772, 8530, 58),
(8773, 8531, 58),
(8774, 8532, 58),
(8775, 8533, 58),
(8776, 8534, 58),
(8777, 8535, 58),
(8778, 8536, 58),
(8779, 8537, 58),
(8780, 8538, 58),
(8781, 8539, 58),
(8782, 8540, 58),
(8783, 8541, 58),
(8784, 8542, 58),
(8785, 8543, 58),
(8786, 8544, 58),
(8787, 8545, 58),
(8788, 8546, 58),
(8789, 8547, 58),
(8790, 8548, 58),
(8791, 8549, 58),
(8792, 8550, 58),
(8793, 8551, 58),
(8794, 8552, 58),
(8795, 8553, 58),
(8796, 8554, 58),
(8797, 8555, 58),
(8798, 8556, 58),
(8799, 8557, 58),
(8800, 8558, 58),
(8801, 8559, 58),
(8802, 8560, 58),
(8803, 8561, 58),
(8804, 8562, 58),
(8805, 8563, 58),
(8806, 8564, 58),
(8807, 8565, 58),
(8808, 8566, 58),
(8809, 8567, 58),
(8813, 8568, 58);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fb_message_id` varchar(191) DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `header_text` varchar(191) NOT NULL DEFAULT '',
  `footer_text` varchar(191) NOT NULL DEFAULT '',
  `header_image` varchar(191) NOT NULL DEFAULT '',
  `header_video` varchar(191) NOT NULL DEFAULT '',
  `header_location` varchar(191) NOT NULL DEFAULT '',
  `header_document` varchar(191) NOT NULL DEFAULT '',
  `buttons` text NOT NULL,
  `value` text NOT NULL,
  `error` varchar(191) NOT NULL DEFAULT '',
  `is_campign_messages` tinyint(1) NOT NULL DEFAULT 0,
  `is_message_by_contact` tinyint(1) NOT NULL DEFAULT 0,
  `message_type` int(11) NOT NULL DEFAULT 1 COMMENT '1 - text, 2-media, 3-location',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0-Schuduled, 1-Sending, 2-Sent, 3-Delivered, 4-Read, 5-Failed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `scchuduled_at` timestamp NULL DEFAULT NULL,
  `components` text NOT NULL,
  `campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `header_audio` varchar(191) DEFAULT NULL,
  `bot_has_replied` tinyint(1) NOT NULL DEFAULT 0,
  `ai_bot_has_replied` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `fb_message_id`, `contact_id`, `company_id`, `header_text`, `footer_text`, `header_image`, `header_video`, `header_location`, `header_document`, `buttons`, `value`, `error`, `is_campign_messages`, `is_message_by_contact`, `message_type`, `status`, `created_at`, `updated_at`, `scchuduled_at`, `components`, `campaign_id`, `header_audio`, `bot_has_replied`, `ai_bot_has_replied`) VALUES
(5566, 'wamid.HBgNNTIxMjI5MjQzMTczOBUCABEYEjJGRjE3MENEQjgyMjE3MkZENgA=', 8487, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *NUÑEZ PINEDA SONIA ITZEL* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:50', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"NU\\u00d1EZ PINEDA SONIA ITZEL\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5567, 'wamid.HBgNNTIxMjczMTQzNjA0ORUCABEYEkZBRjUwMTU3NEM3RjQyQjA4NQA=', 8488, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *REYES BOLAÑOS GUSTAVO ALEXIS* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:50', '2025-05-26 22:24:03', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"REYES BOLA\\u00d1OS GUSTAVO ALEXIS\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5568, 'wamid.HBgNNTIxMjI5NDg2MTg1ORUCABEYEkYxODVDQ0YyMDA4MzMxN0U5NAA=', 8489, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MONTIEL CARREON LUIS LEONARDO* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:51', '2025-05-26 22:24:06', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MONTIEL CARREON LUIS LEONARDO\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5569, 'wamid.HBgNNTIxMjI5NTE0MzAwMhUCABEYEkU1NjhFMTYwRUQ3RTM2MTI3RAA=', 8490, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MASSON MALDONADO KEVIN* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:51', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MASSON MALDONADO KEVIN\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5570, 'wamid.HBgNNTIxNTYyNTI3NDk2MxUCABEYEjIxQTJDRDkxQjExRkU5MDcxNAA=', 8491, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *CRUZ FUENTES IVANNA MICHELLE* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:52', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"CRUZ FUENTES IVANNA MICHELLE\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5571, 'wamid.HBgNNTIxMjI5OTY4MjM5NRUCABEYEjY4NEJCQjZEOTM5RkZGOEM5OAA=', 8492, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *CONTRERAS PEGUEROS ANGELIQUE* 👋 futur@ Lince de Programa *Químico Farmacéutico Biotecnólogo* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:23:52', '2025-05-26 23:03:38', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"CONTRERAS PEGUEROS ANGELIQUE\"},{\"type\":\"text\",\"text\":\"Qu\\u00edmico Farmac\\u00e9utico Biotecn\\u00f3logo\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5572, 'wamid.HBgNNTIxMjgzMTA4Mjc0NBUCABEYEjM3MDVFMkY3QzU3MzMxMzAzOQA=', 8493, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *RODRIGUEZ GOMEZ TERESITA NICOLE* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:52', '2025-05-26 22:24:17', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"RODRIGUEZ GOMEZ TERESITA NICOLE\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5573, 'wamid.HBgNNTIxMjI5NTExMzQwMxUCABEYEjVEQTQxMTQxNDQ5Q0FGRUE0QQA=', 8494, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MORA ANGELLO PAOLO* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:53', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MORA ANGELLO PAOLO\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5574, 'wamid.HBgNNTIxMjI5MzEyMzcxMRUCABEYEkRCNDk1NTRFNTczRDkyMUNERgA=', 8495, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *HERNANDEZ SILVA FRANCISCO GAEL* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:53', '2025-05-27 01:13:18', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"HERNANDEZ SILVA FRANCISCO GAEL\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5575, 'wamid.HBgNNTIxMjI5MzM5NDI1MhUCABEYEkVBOTdDRjI5NzUwODg0M0NCRgA=', 8496, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *CERON GARCIA MARIO LUIS* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:54', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"CERON GARCIA MARIO LUIS\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5576, 'wamid.HBgNNTIxMjg1MTA2MzQzNBUCABEYEjVDNDhDNTM5QTFDRkQ3MTBGQwA=', 8497, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MUÑIZ CONTRERAS AURELIO* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 2, '2025-05-26 22:23:54', '2025-05-26 22:24:12', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MU\\u00d1IZ CONTRERAS AURELIO\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5577, 'wamid.HBgNNTIxMjI5NDkxMDc2NBUCABEYEjYzOERFMTIzMjVENERENTRGQgA=', 8498, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *TUN ACOSTA JOSE ALEJANDRO* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:54', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"TUN ACOSTA JOSE ALEJANDRO\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5578, 'wamid.HBgNNTIxMjI5MjI3NjU0MBUCABEYEjMwRUFCNjFDNTE1MkYwNURFMgA=', 8499, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GARCIA GARCIA ALFREDO* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:55', '2025-05-26 22:31:27', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GARCIA GARCIA ALFREDO\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5579, 'wamid.HBgNNTIxMjI5NjA5Nzk1MBUCABEYEjcxOThDMzU5RUQ1MUQ3RDU3NAA=', 8500, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DAVID MARIN NATALIA* 👋 futur@ Lince de Programa *Psicología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:55', '2025-05-26 22:31:17', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DAVID MARIN NATALIA\"},{\"type\":\"text\",\"text\":\"Psicolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5580, 'wamid.HBgNNTIxMjI5MTA0NzU4MRUCABEYEjQ2MEQ2OEI0RkUyN0E0QThEMwA=', 8501, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DOMINGUEZ FOLLEZA LUIS ENRIQUE* 👋 futur@ Lince de Programa *Nutrición* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:56', '2025-05-26 22:24:41', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DOMINGUEZ FOLLEZA LUIS ENRIQUE\"},{\"type\":\"text\",\"text\":\"Nutrici\\u00f3n\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5581, 'wamid.HBgNNTIxMjI5MjUzNTQ4NBUCABEYEjc4NThFNEMzODhCRTQwOEYxMQA=', 8502, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *FILIBERTO GUZMAN ALEXIA SHIRLEY* 👋 futur@ Lince de Programa *Nutrición* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:56', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"FILIBERTO GUZMAN ALEXIA SHIRLEY\"},{\"type\":\"text\",\"text\":\"Nutrici\\u00f3n\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5582, 'wamid.HBgNNTIxMjI5MTA3OTk2NRUCABEYEjlBOTBDNTU4OTBENjZERDgyNwA=', 8503, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *LOPEZ MARTINEZ JORGE CARLOS TADEO* 👋 futur@ Lince de Programa *Nutrición* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:23:56', '2025-05-27 01:12:38', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"LOPEZ MARTINEZ JORGE CARLOS TADEO\"},{\"type\":\"text\",\"text\":\"Nutrici\\u00f3n\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5583, 'wamid.HBgNNTIxMjI5OTUzODg4NRUCABEYEjFBQTdGNjE5OTIyQzc5NTExNwA=', 8504, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ANGELES CHELIUS JOHANNA* 👋 futur@ Lince de Programa *Nutrición* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:57', '2025-05-26 22:24:20', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ANGELES CHELIUS JOHANNA\"},{\"type\":\"text\",\"text\":\"Nutrici\\u00f3n\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5584, 'wamid.HBgNNTIxMjI5MjUwMzcwNhUCABEYEkE1NEE0RkIxMjE5NkRBNDg2QQA=', 8505, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *CRUZ OLIVERA MILDRE ODETTE* 👋 futur@ Lince de Programa *Nutrición* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:23:57', '2025-05-26 22:25:45', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"CRUZ OLIVERA MILDRE ODETTE\"},{\"type\":\"text\",\"text\":\"Nutrici\\u00f3n\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5585, 'wamid.HBgNNTIxMjI5NTQ4Mzk2MhUCABEYEkMyRjg2MDc4RjdFQ0E2MzQwMwA=', 8506, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ALCANTARA MARTINEZ GUSTAVO DE JESUS* 👋 futur@ Lince de Programa *Ing en Biotecnología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:23:58', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ALCANTARA MARTINEZ GUSTAVO DE JESUS\"},{\"type\":\"text\",\"text\":\"Ing en Biotecnolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5586, 'wamid.HBgNNTIxMjI5OTMzOTM5NBUCABEYEkU0QzNDNzYyRjFBRkZEM0ZERAA=', 8507, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *BARRIENTOS TRUJILLO MICHELLE ESTRELLA* 👋 futur@ Lince de Programa *Ing en Biotecnología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:23:58', '2025-05-26 22:30:51', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"BARRIENTOS TRUJILLO MICHELLE ESTRELLA\"},{\"type\":\"text\",\"text\":\"Ing en Biotecnolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5587, 'wamid.HBgNNTIxNTYzODYyOTcwMBUCABEYEjFGQUU4MzFGNjk3NUI2MUY5NgA=', 8508, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MUÑOZ TORRES SOFIA XIMENA* 👋 futur@ Lince de Programa *Ing en Biotecnología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 2, '2025-05-26 22:23:59', '2025-05-26 22:31:05', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MU\\u00d1OZ TORRES SOFIA XIMENA\"},{\"type\":\"text\",\"text\":\"Ing en Biotecnolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5588, 'wamid.HBgNNTIxMjI5MjY1NjcyNBUCABEYEkZBRjIzQjdGQzg5QTVEMTcyQwA=', 8509, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *BAUTISTA FIGUEROA VANESSA* 👋 futur@ Lince de Programa *Ing en Biotecnología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:23:59', '2025-05-26 22:39:23', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"BAUTISTA FIGUEROA VANESSA\"},{\"type\":\"text\",\"text\":\"Ing en Biotecnolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5589, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABEYEkIzRkY3NDU1Rjc3MkU2RkNENAA=', 8510, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VAZQUEZ HUESCA YARETZI* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:00', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VAZQUEZ HUESCA YARETZI\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5590, 'wamid.HBgNNTIxOTIwMzQyNDc0OBUCABEYEjhERDhFNDY2NDgwMDA3QUQ5OQA=', 8511, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DOMINGUEZ MONTALVO RAFAEL* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:00', '2025-05-26 22:24:19', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DOMINGUEZ MONTALVO RAFAEL\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5591, 'wamid.HBgNNTIxMjI5NTQ5NzA0NxUCABEYEjU2MDM4RTRENTEzMDhEMzZFMwA=', 8512, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GOBIN CROCHE PAOLO PIERRE* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:01', '2025-05-28 00:24:40', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GOBIN CROCHE PAOLO PIERRE\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5592, 'wamid.HBgNNTIxMjIxOTM3NDgzNxUCABEYEjFCNzVFODgzOTI1MDU3QzQyNwA=', 8513, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *REYES ESPERON JESSICA PAULINA* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:02', '2025-05-28 17:09:55', '2025-05-26 22:23:45', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"REYES ESPERON JESSICA PAULINA\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5593, 'wamid.HBgNNTIxMjI5MzY2ODE4MRUCABEYEkI5QkEyREFCQjRFOTcxOUMyOQA=', 8514, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *CAMAL DE LA ROSA KARIM DAVID* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:03', '2025-05-30 02:40:50', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"CAMAL DE LA ROSA KARIM DAVID\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5594, 'wamid.HBgNNTIxNjY3ODI4OTg5MBUCABEYEjUzQzc3NEUzQkRGM0EwN0IyMwA=', 8515, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ESCANDON GONZALEZ MANUEL ALFREDO* 👋 futur@ Lince de Programa *Fisioterapia* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:04', '2025-05-26 22:24:20', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ESCANDON GONZALEZ MANUEL ALFREDO\"},{\"type\":\"text\",\"text\":\"Fisioterapia\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5595, 'wamid.HBgNNTIxMjI5NjE1NjE0NxUCABEYEjJGOUM3QjBCMTMxNDkyMTExRQA=', 8516, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *SOLIS MOJICA KARLA MONSERRATH* 👋 futur@ Lince de Programa *Enfermería* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:05', '2025-05-26 22:24:21', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"SOLIS MOJICA KARLA MONSERRATH\"},{\"type\":\"text\",\"text\":\"Enfermer\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5596, 'wamid.HBgNNTIxMjI5MjExNTUzOBUCABEYEjZCODJBREI2Nzk1NTBDNzdEMAA=', 8517, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *PRIETO RAMIREZ ANGEL GABRIEL* 👋 futur@ Lince de Programa *Enfermería* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:06', '2025-05-26 23:00:36', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"PRIETO RAMIREZ ANGEL GABRIEL\"},{\"type\":\"text\",\"text\":\"Enfermer\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5597, 'wamid.HBgNNTIxMjc0MTE0NjEzMxUCABEYEjczNDA2RjYzNENFMERBNUM3MwA=', 8518, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *LIMA AMADOR SARAHY* 👋 futur@ Lince de Programa *Enfermería* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:07', '2025-05-26 23:54:51', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"LIMA AMADOR SARAHY\"},{\"type\":\"text\",\"text\":\"Enfermer\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5598, 'wamid.HBgNNTIxMzIzNDIzNTc2MBUCABEYEkNEQzk5NDIyRDlFRTg3ODZCNQA=', 8519, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *AMADOR LOPEZ RAFAEL FERNANDO* 👋 futur@ Lince de Programa *Relaciones Internacionales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:08', '2025-05-26 22:24:23', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"AMADOR LOPEZ RAFAEL FERNANDO\"},{\"type\":\"text\",\"text\":\"Relaciones Internacionales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5599, 'wamid.HBgNNTIxMjg4MTAyMDI5NBUCABEYEjlFMUYxQ0QzODExNDIyRTVEQwA=', 8520, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *HERRERA FOMPEROSA MARTIN* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:09', '2025-05-26 22:55:06', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"HERRERA FOMPEROSA MARTIN\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5600, 'wamid.HBgNNTIxMjI5MTQwNzQyMRUCABEYEjY3RjQwMjQzOUI4QUVFNUU3NgA=', 8521, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *SENA CASTRO ZAID* 👋 futur@ Lince de Programa *Ing en Sistemas Computacionales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:11', '2025-05-27 06:45:59', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"SENA CASTRO ZAID\"},{\"type\":\"text\",\"text\":\"Ing en Sistemas Computacionales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5601, 'wamid.HBgNNTIxMjI5MjA3NDM1MxUCABEYEjAzRTQzRkNFRTVFNzg5NjZBMQA=', 8522, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *REYES ENRIQUEZ XIMENA* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:12', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"REYES ENRIQUEZ XIMENA\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5602, 'wamid.HBgNNTIxMjI5NTE5OTU3MxUCABEYEkI1RTEyOUI4NkNCNTU5QzYzQQA=', 8523, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ARCHUNDIA ORDOÑEZ EMILIANO* 👋 futur@ Lince de Programa *Ing en Sistemas Computacionales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:13', '2025-05-26 22:24:46', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ARCHUNDIA ORDO\\u00d1EZ EMILIANO\"},{\"type\":\"text\",\"text\":\"Ing en Sistemas Computacionales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5603, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABEYEkU0RTlDQ0E2QkZEMjcwQTA5QQA=', 8524, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *HERMIDA RIVERA ROCIO YARELI* 👋 futur@ Lince de Programa *Lenguas Extranjeras* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:14', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"HERMIDA RIVERA ROCIO YARELI\"},{\"type\":\"text\",\"text\":\"Lenguas Extranjeras\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5604, 'wamid.HBgNNTIxMjI5MzY0MjYyNBUCABEYEjlBMjYzNDYxMDYyMEQxMUU2NgA=', 8525, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *SANCHEZ MIJANGOS MARISOL* 👋 futur@ Lince de Programa *Lenguas Extranjeras* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:15', '2025-05-26 22:30:43', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"SANCHEZ MIJANGOS MARISOL\"},{\"type\":\"text\",\"text\":\"Lenguas Extranjeras\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5605, 'wamid.HBgNNTIxMjI5MzA2MDc1NRUCABEYEjg3MjZFNkQ1NDdDMDA5NzYxMwA=', 8526, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GARCIA OLIVARES FABIOLA* 👋 futur@ Lince de Programa *Ing Mecatrónica con enf Automotriz* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:16', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GARCIA OLIVARES FABIOLA\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica con enf Automotriz\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0);
INSERT INTO `messages` (`id`, `fb_message_id`, `contact_id`, `company_id`, `header_text`, `footer_text`, `header_image`, `header_video`, `header_location`, `header_document`, `buttons`, `value`, `error`, `is_campign_messages`, `is_message_by_contact`, `message_type`, `status`, `created_at`, `updated_at`, `scchuduled_at`, `components`, `campaign_id`, `header_audio`, `bot_has_replied`, `ai_bot_has_replied`) VALUES
(5606, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABEYEkIzQTk0RjQxNjY4Qjg0RDg1NAA=', 8527, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VASQUEZ CRUZ ANGEL* 👋 futur@ Lince de Programa *Ing Mecatrónica con enf Automotriz* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:17', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VASQUEZ CRUZ ANGEL\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica con enf Automotriz\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5607, 'wamid.HBgNNTIxMjc0MTM0NzQ2ORUCABEYEjc5MDBENzZDM0NFRDIzMkJEMgA=', 8528, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *HERRERA LARA JESUS AARON* 👋 futur@ Lince de Programa *Ing Mecatrónica con enf Automotriz* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:18', '2025-05-27 21:14:20', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"HERRERA LARA JESUS AARON\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica con enf Automotriz\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5608, 'wamid.HBgNNTIxOTkzNDA3MDk0NhUCABEYEjhEQzM2MDFCRDU1M0Y5N0U5RgA=', 8529, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *FLORES HERMIDA ADALBERTO* 👋 futur@ Lince de Programa *Ing Mecatrónica con enf Automotriz* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:19', '2025-05-26 22:29:12', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"FLORES HERMIDA ADALBERTO\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica con enf Automotriz\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5609, 'wamid.HBgNNTIxMjI5NDUyNTA0MBUCABEYEkI4OUQ2NkIwMTA2QkUzMzZGRAA=', 8530, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *PRADO OLIVARES GERARDO* 👋 futur@ Lince de Programa *Ing Mecatrónica* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:20', '2025-05-26 22:32:54', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"PRADO OLIVARES GERARDO\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5610, 'wamid.HBgNNTIxOTMzMTExNTM4OBUCABEYEkU4QTcwRjc5QjQ1Njk2MzdCRQA=', 8531, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *AGUILAR SALMONES ANA VALERIA* 👋 futur@ Lince de Programa *Ing Mecatrónica* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:21', '2025-05-26 22:45:11', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"AGUILAR SALMONES ANA VALERIA\"},{\"type\":\"text\",\"text\":\"Ing Mecatr\\u00f3nica\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5611, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABEYEjE1RDg4MTY3QzIwNDJFOEE5MgA=', 8532, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VILLEGAS GONZALEZ SERGIO AMAURY* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:22', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VILLEGAS GONZALEZ SERGIO AMAURY\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5612, 'wamid.HBgNNTIxMjI5OTc3MDE3MBUCABEYEjVBNzIwN0Y3OEZBRDY2MTE2OQA=', 8533, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *PIÑEIRO AMADOR ANA VALENTINA* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:24', '2025-05-26 22:24:50', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"PI\\u00d1EIRO AMADOR ANA VALENTINA\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5613, 'wamid.HBgNNTIxMjg4MTEwMjk4NRUCABEYEjJCMEFDNjNGREJDMERCMEI1NAA=', 8534, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *NUÑEZ GARCIA JOSE LUIS* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:25', '2025-05-26 22:24:53', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"NU\\u00d1EZ GARCIA JOSE LUIS\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5614, 'wamid.HBgNNTIxMjI5NTMwOTQ0OBUCABEYEjNDNkUyQjg4RDJERUM4M0Y3OQA=', 8535, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MORALES ROSAS REGINA* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:26', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MORALES ROSAS REGINA\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5615, 'wamid.HBgNNTIxMjI5MzczNzA0ORUCABEYEjNCRjZENjJDRTE0REVBQjgwQgA=', 8536, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DE SANTOS PIÑA EDGAR ALEJANDRO* 👋 futur@ Lince de Programa *Ing Industrial y de Sistemas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:27', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DE SANTOS PI\\u00d1A EDGAR ALEJANDRO\"},{\"type\":\"text\",\"text\":\"Ing Industrial y de Sistemas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5616, 'wamid.HBgNNTIxMjI5MzA0Mjk0ORUCABEYEkZEM0E2OThCMzRFNTc5NUM0RAA=', 8537, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GARCIA VIVEROS DIEGO DANIEL* 👋 futur@ Lince de Programa *Ing en Sistemas Computacionales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:28', '2025-05-26 22:27:43', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GARCIA VIVEROS DIEGO DANIEL\"},{\"type\":\"text\",\"text\":\"Ing en Sistemas Computacionales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5617, 'wamid.HBgNNTIxMjI5Njk2MDYxNhUCABEYEkVFOTYxRDBDNTA1MkZEOTdGMAA=', 8538, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MORALES OREA VICTOR MANUEL* 👋 futur@ Lince de Programa *Ing en Sistemas Computacionales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:29', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MORALES OREA VICTOR MANUEL\"},{\"type\":\"text\",\"text\":\"Ing en Sistemas Computacionales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5618, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABEYEjlFMEExOERFMjhGNzVCMkJERQA=', 8539, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *REYES ALVAREZ ALEXANDER* 👋 futur@ Lince de Programa *Ing en Petróleo y Gas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:30', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"REYES ALVAREZ ALEXANDER\"},{\"type\":\"text\",\"text\":\"Ing en Petr\\u00f3leo y Gas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5619, 'wamid.HBgNNTIxODk5NDUwOTU0NRUCABEYEjFFQ0IyNTUzQTlEN0I4NUQ1RAA=', 8540, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ZAMBRANO TORRES KEVIN JOSEPH* 👋 futur@ Lince de Programa *Ing en Petróleo y Gas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 2, '2025-05-26 22:24:31', '2025-05-26 22:24:50', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ZAMBRANO TORRES KEVIN JOSEPH\"},{\"type\":\"text\",\"text\":\"Ing en Petr\\u00f3leo y Gas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5620, 'wamid.HBgNNTIxMjI5Nzc5NTQ5OBUCABEYEkQ3NjlEMUE5NTA2MUI1NTQzRgA=', 8541, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MANTILLA NIKOLAS* 👋 futur@ Lince de Programa *Ing en Energía y Desarrollo Sustentable* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:32', '2025-05-26 22:24:49', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MANTILLA NIKOLAS\"},{\"type\":\"text\",\"text\":\"Ing en Energ\\u00eda y Desarrollo Sustentable\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5621, 'wamid.HBgNNTIxNzg0MjExODA1NxUCABEYEjA0RkQ3MkRBNUE4NzYwNDNEMQA=', 8542, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *SANTANA JIMENEZ JOSE LUIS* 👋 futur@ Lince de Programa *Ing en Desarrollo de Videojuegos* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:34', '2025-05-26 22:25:11', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"SANTANA JIMENEZ JOSE LUIS\"},{\"type\":\"text\",\"text\":\"Ing en Desarrollo de Videojuegos\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5622, 'wamid.HBgNNTIxMjI5MTM3NTAxMhUCABEYEjA1Q0JCNzJCQjMxNUEwMDBERQA=', 8543, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VADO SANCHEZ YAEL* 👋 futur@ Lince de Programa *Ing en Desarrollo de Videojuegos* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:35', '2025-05-26 22:27:08', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VADO SANCHEZ YAEL\"},{\"type\":\"text\",\"text\":\"Ing en Desarrollo de Videojuegos\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5623, 'wamid.HBgNNTIxMjI5MjA4ODg2NRUCABEYEjY5RUQ2Qjk2RTJBNzI3MjQ0NgA=', 8544, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DOMINGUEZ VITE GAEL EMILIANO* 👋 futur@ Lince de Programa *Ing Civil* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:36', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DOMINGUEZ VITE GAEL EMILIANO\"},{\"type\":\"text\",\"text\":\"Ing Civil\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5624, 'wamid.HBgNNTIxMjk0MTQwMjg0MhUCABEYEjNFNTM5MDEyRDAzQkMwNEE0QgA=', 8545, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *DIAZ RIVERA ISABELA* 👋 futur@ Lince de Programa *Ing Civil* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:37', '2025-05-26 22:25:00', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"DIAZ RIVERA ISABELA\"},{\"type\":\"text\",\"text\":\"Ing Civil\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5625, 'wamid.HBgNNTIxMjI5MjkxMzM3NxUCABEYEjQ4MThDOTg3QkFGNjJCRDc0QgA=', 8546, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MENDOZA FERNANDEZ JUAN* 👋 futur@ Lince de Programa *Ing Civil* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:38', '2025-05-26 22:25:19', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MENDOZA FERNANDEZ JUAN\"},{\"type\":\"text\",\"text\":\"Ing Civil\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5626, 'wamid.HBgNNTIxMjg3MTYyNjk2MRUCABEYEjBBRDdGQzVBNzE2NTkzQkVGNAA=', 8547, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *MEZA TORRES SOFIA GUADALUPE* 👋 futur@ Lince de Programa *Gastronomía Internacional* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:39', '2025-05-26 22:28:08', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"MEZA TORRES SOFIA GUADALUPE\"},{\"type\":\"text\",\"text\":\"Gastronom\\u00eda Internacional\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5627, 'wamid.HBgNNTIxMjk0MTY5MTY1MxUCABEYEjU1MkVBMTVENUNBRkQyN0FGQgA=', 8548, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *SOLIS DIAZ DASHA BERIT* 👋 futur@ Lince de Programa *Gastronomía Internacional* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 2, '2025-05-26 22:24:40', '2025-05-26 22:24:52', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"SOLIS DIAZ DASHA BERIT\"},{\"type\":\"text\",\"text\":\"Gastronom\\u00eda Internacional\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5628, 'wamid.HBgNNTIxMjI5NDk3MDE4NxUCABEYEkNGREUzODY5RDM2MDYyREU1QQA=', 8549, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VICTORIA NUÑEZ SANTIAGO* 👋 futur@ Lince de Programa *Gastronomía Internacional* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:41', '2025-05-26 22:25:03', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VICTORIA NU\\u00d1EZ SANTIAGO\"},{\"type\":\"text\",\"text\":\"Gastronom\\u00eda Internacional\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5629, 'wamid.HBgNNTIxMjc0MTM2NTgzMxUCABEYEkVFODNEQUY4QkZFRjZGMzUyOAA=', 8550, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GORRIZ CALDERON MITZZY DAYHANA* 👋 futur@ Lince de Programa *Gastronomía Internacional* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:42', '2025-05-26 22:31:10', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GORRIZ CALDERON MITZZY DAYHANA\"},{\"type\":\"text\",\"text\":\"Gastronom\\u00eda Internacional\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5630, 'wamid.HBgNNTIxMjI5MjQzNzQ2ORUCABEYEjRBODUyNEZBOTMyQzc4NDZBMQA=', 8551, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ORTIZ LOPEZ VALERIA* 👋 futur@ Lince de Programa *Gastronomía Internacional* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:43', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ORTIZ LOPEZ VALERIA\"},{\"type\":\"text\",\"text\":\"Gastronom\\u00eda Internacional\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5631, 'wamid.HBgNNTIxMjI5MTQ2ODczORUCABEYEkE5QjVGNTM5RkNBQkQyMzVFQgA=', 8552, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GUTIERREZ CHAVEZ DIANA CRISTAL* 👋 futur@ Lince de Programa *Diseño y Comunicación Gráfica* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', 'Message undeliverable', 1, 0, 1, 5, '2025-05-26 22:24:43', '2025-05-26 22:25:09', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GUTIERREZ CHAVEZ DIANA CRISTAL\"},{\"type\":\"text\",\"text\":\"Dise\\u00f1o y Comunicaci\\u00f3n Gr\\u00e1fica\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5632, 'wamid.HBgNNTIxMjI5Mzk5Mjc4NBUCABEYEkU3RDU4NTdFQzk5MEEzRDRENAA=', 8553, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *HERNANDEZ HERNANDEZ DANIEL* 👋 futur@ Lince de Programa *Diseño y Comunicación Gráfica* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:44', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"HERNANDEZ HERNANDEZ DANIEL\"},{\"type\":\"text\",\"text\":\"Dise\\u00f1o y Comunicaci\\u00f3n Gr\\u00e1fica\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5633, 'wamid.HBgNNTIxMjk0MTI5ODIwOBUCABEYEjE2QUM2NDgwRDc5Q0Q1MjE5MQA=', 8554, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ROSARIO MARTINEZ JUANA* 👋 futur@ Lince de Programa *Derecho* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:45', '2025-05-26 22:29:26', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ROSARIO MARTINEZ JUANA\"},{\"type\":\"text\",\"text\":\"Derecho\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5634, 'wamid.HBgNNTIxMjI5MTE2NDQ4OBUCABEYEkU5MEY0OEI0MEVCODZCNTA3RgA=', 8555, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *JUAREZ ANDRADE ASHLEY CLARISSA* 👋 futur@ Lince de Programa *Derecho* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:46', '2025-05-28 15:56:33', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"JUAREZ ANDRADE ASHLEY CLARISSA\"},{\"type\":\"text\",\"text\":\"Derecho\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5635, 'wamid.HBgNNTIxMjk2MjA2MDA1NhUCABEYEjM3NjNBNjIyNzE5NzcyRDEwOAA=', 8556, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *BARRADAS CARRERA BRANDON OWEN* 👋 futur@ Lince de Programa *Criminología* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 2, '2025-05-26 22:24:47', '2025-05-26 22:25:00', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"BARRADAS CARRERA BRANDON OWEN\"},{\"type\":\"text\",\"text\":\"Criminolog\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5636, 'wamid.HBgNNTIxMjgzMTA5MjE3MhUCABEYEjMxNUE3MUNFODA1NUQyMzM3NwA=', 8557, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *AMADOR ROMERO KRYSTELL* 👋 futur@ Lince de Programa *Contaduría Pública y Finanzas* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:48', '2025-05-26 22:25:02', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"AMADOR ROMERO KRYSTELL\"},{\"type\":\"text\",\"text\":\"Contadur\\u00eda P\\u00fablica y Finanzas\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5637, 'wamid.HBgNNTIxMjIxNDI2NTU5NRUCABEYEjdENDEzMTk2NkFENEJCQzZCMQA=', 8558, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *RUIZ MIGUEL YIREH* 👋 futur@ Lince de Programa *Comunicación y Medios Digitales* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:49', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"RUIZ MIGUEL YIREH\"},{\"type\":\"text\",\"text\":\"Comunicaci\\u00f3n y Medios Digitales\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5638, 'wamid.HBgNNTIxMjg3MTEwODg1NhUCABEYEkRGNzEyQkExRDBBMDFFNEEyRQA=', 8559, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *AGUIRRE FERNANDEZ CINTHIA ESTRELLA* 👋 futur@ Lince de Programa *Arquitectura* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:50', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"AGUIRRE FERNANDEZ CINTHIA ESTRELLA\"},{\"type\":\"text\",\"text\":\"Arquitectura\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5639, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABEYEjVBOTc0MjAyQ0VDRUFDMEZDMQA=', 8560, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *VERA LOPEZ GISSELLE* 👋 futur@ Lince de Programa *Arquitectura* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:51', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"VERA LOPEZ GISSELLE\"},{\"type\":\"text\",\"text\":\"Arquitectura\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5640, 'wamid.HBgNNTIxMjI5NDUwMzY2NhUCABEYEjhDNkVBMENBQjAzRkEzQjJDNgA=', 8561, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *RODRIGUEZ VELASCO HAZIEL AARON* 👋 futur@ Lince de Programa *Arquitectura* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:53', '2025-05-26 22:31:39', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"RODRIGUEZ VELASCO HAZIEL AARON\"},{\"type\":\"text\",\"text\":\"Arquitectura\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5641, 'wamid.HBgNNTIxMjI5MjQyNTIyMRUCABEYEjFGNUREOUY3Q0Y0NERCOTBGRQA=', 8562, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ORTIZ SALLAGO ROBERTO ENRICO* 👋 futur@ Lince de Programa *Arquitectura* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:54', '2025-05-26 22:25:14', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ORTIZ SALLAGO ROBERTO ENRICO\"},{\"type\":\"text\",\"text\":\"Arquitectura\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5642, 'wamid.HBgMNTIyOTYxMTE3NTcwFQIAERgSNTg5NkU0RDREMzRBQjM0NTg0AA==', 8563, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *LARA DOMINGUEZ EMILIANO* 👋 futur@ Lince de Programa *Administración Turística y Hotelera* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:55', '2025-05-26 22:25:17', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"LARA DOMINGUEZ EMILIANO\"},{\"type\":\"text\",\"text\":\"Administraci\\u00f3n Tur\\u00edstica y Hotelera\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5643, 'wamid.HBgNNTIxMjI5NDIwODE1ORUCABEYEjk1NUI2OTRDQUY0ODMyRDkwQwA=', 8564, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *LEDESMA JACOBO ANA SOFIA* 👋 futur@ Lince de Programa *Administración Turística y Hotelera* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:56', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"LEDESMA JACOBO ANA SOFIA\"},{\"type\":\"text\",\"text\":\"Administraci\\u00f3n Tur\\u00edstica y Hotelera\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5644, 'wamid.HBgNNTIxMjcyMjI2MTc2NxUCABEYEkUyREYzNDE5QjEwMUI2QzY4OAA=', 8565, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ORTIZ GUADARRAMA DANIEL* 👋 futur@ Lince de Programa *Actuaría* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 6, '2025-05-26 22:24:57', '2025-05-28 17:09:55', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ORTIZ GUADARRAMA DANIEL\"},{\"type\":\"text\",\"text\":\"Actuar\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5645, 'wamid.HBgNNTIxNTYyNDczODg3MhUCABEYEkY3QzFFMDY3NjU2MTI4RjU5QgA=', 8566, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *ZAVALA SALDAÑA ETHAN SEBASTIAN* 👋 futur@ Lince de Programa *Actuaría* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 4, '2025-05-26 22:24:58', '2025-05-26 23:46:35', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"ZAVALA SALDA\\u00d1A ETHAN SEBASTIAN\"},{\"type\":\"text\",\"text\":\"Actuar\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0);
INSERT INTO `messages` (`id`, `fb_message_id`, `contact_id`, `company_id`, `header_text`, `footer_text`, `header_image`, `header_video`, `header_location`, `header_document`, `buttons`, `value`, `error`, `is_campign_messages`, `is_message_by_contact`, `message_type`, `status`, `created_at`, `updated_at`, `scchuduled_at`, `components`, `campaign_id`, `header_audio`, `bot_has_replied`, `ai_bot_has_replied`) VALUES
(5646, 'wamid.HBgNNTIxMjI5MTYzMjU3MBUCABEYEkM3MDEwNDQyNUNGNjZCNDI2NQA=', 8567, 1, '', 'Da clic en los botones para enviarte los datos deseados', '', '', '', '', '[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]', 'Hola *GRIS FERNANDEZ EDWIN JESSE* 👋 futur@ Lince de Programa *Actuaría* 😺, ¡Bienvenid@! a la *Universidad del Valle de México Campus Veracruz*\n\n Para completar el proceso de inscripción, no olvides presentar tu *examen de ubicación a idiomas*📝\n\n Próxima 📅 fecha de examen de ubicación (EXUBI): *02/06/2025* al *06/06/2025*\n\n  Contacta a la Coordinadora *Lic. Arysa del Ángel* para confirmar tu fecha y conocer el horario de aplicación 🕒', '', 1, 0, 1, 3, '2025-05-26 22:24:59', '2025-05-26 22:25:18', '2025-05-26 22:23:46', '[{\"type\":\"BODY\",\"parameters\":[{\"type\":\"text\",\"text\":\"GRIS FERNANDEZ EDWIN JESSE\"},{\"type\":\"text\",\"text\":\"Actuar\\u00eda\"},{\"type\":\"text\",\"text\":\"02\\/06\\/2025\"},{\"type\":\"text\",\"text\":\"06\\/06\\/2025\"}]}]', 85, '', 0, 0),
(5647, 'wamid.HBgNNTIxMjI5MjUzNTQ4NBUCABIYFDNBODBEMTBGMjlGNUU5Q0I4OTNDAA==', 8502, 1, '', '', '', '', '', '', '[]', 'ya lo hice', '', 0, 1, 1, 1, '2025-05-26 22:24:58', '2025-05-26 22:24:58', NULL, '', NULL, '', 0, 0),
(5648, 'wamid.HBgNNTIxMjI5Njk2MDYxNhUCABIYFDNBMkI1QUFCODFBNDlBQkFCQkQzAA==', 8538, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:26:00', '2025-05-26 22:26:00', NULL, '', NULL, '', 0, 0),
(5649, NULL, 8538, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-26 22:26:00', '2025-05-26 22:26:00', NULL, '', NULL, NULL, 0, 0),
(5650, 'wamid.HBgNNTIxMjI5NTMwOTQ0OBUCABIYIDdGRDgzMTk1NjBGQzlBQjVGOTQ5NzZFRjU1MUQzQjE1AA==', 8535, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:27:16', '2025-05-26 22:27:17', NULL, '', NULL, '', 1, 0),
(5651, 'wamid.HBgNNTIxMjI5NTMwOTQ0OBUCABEYEjI2MjhCQTRGRDQ3MTIwNUMxMQA=', 8535, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-26 22:27:16', '2025-05-26 22:27:19', NULL, '', NULL, NULL, 0, 0),
(5652, 'wamid.HBgNNTIxMjI5Njk2MDYxNhUCABIYFDNBMUIyMDc0RTgwMEZBOTE1MjVGAA==', 8538, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:27:40', '2025-05-26 22:27:40', NULL, '', NULL, '', 1, 0),
(5653, 'wamid.HBgNNTIxMjI5Njk2MDYxNhUCABEYEkQyMDMxNzQ5MTM0RTVCMTRBOAA=', 8538, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-26 22:27:40', '2025-05-26 22:27:43', NULL, '', NULL, NULL, 0, 0),
(5654, 'wamid.HBgNNTIxMjI5MjUzNTQ4NBUCABEYEjM0QjkzN0U4ODI4OEY2NEQyNwA=', 8502, 1, '', '', '', '', '', '', '[]', 'Muchas gracias por confirmar', '', 0, 0, 1, 3, '2025-05-26 22:27:46', '2025-05-26 22:27:49', NULL, '', NULL, '', 0, 0),
(5655, 'wamid.HBgNNTIxMjIxOTM3NDgzNxUCABIYFDNBNEI2NDA3MENCRkU5MzU4MjgzAA==', 8513, 1, '', '', '', '', '', '', '[]', 'Okey muchas gracias', '', 0, 1, 1, 1, '2025-05-26 22:28:00', '2025-05-26 22:28:01', NULL, '', NULL, '', 1, 0),
(5656, 'wamid.HBgNNTIxMjIxOTM3NDgzNxUCABEYEkY2NjI3QjkzN0IwQkNCN0ZDRAA=', 8513, 1, '', '', '', '', '', '', '[]', 'Estamos para servirle 👍🏻👍🏻', '', 0, 0, 1, 4, '2025-05-26 22:28:00', '2025-05-26 22:28:03', NULL, '', NULL, NULL, 0, 0),
(5657, 'wamid.HBgNNTIxMjI5MzM5NDI1MhUCABIYFDNBOEVENkRERTM2QzAyMDQ0MDM3AA==', 8496, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:34:06', '2025-05-26 22:34:07', NULL, '', NULL, '', 1, 0),
(5658, 'wamid.HBgNNTIxMjI5MzM5NDI1MhUCABEYEjBDODA5RkM1OUJBQ0I1QjlBQgA=', 8496, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 22:34:06', '2025-05-26 22:34:09', NULL, '', NULL, NULL, 0, 0),
(5659, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABIYIDQ3NTEyOUM4N0UzNjA5QURDNURGOUE3ODcwN0FBNUE5AA==', 8510, 1, '', '', '', '', '', '', '[]', 'Disculpa, pero ya presente el examen de ubicación', '', 0, 1, 1, 1, '2025-05-26 22:49:52', '2025-05-26 22:49:53', NULL, '', NULL, '', 1, 0),
(5660, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABEYEkEyM0U3MkEwNjdEMDU3QjVBQwA=', 8510, 1, '', '', '', '', '', '', '[]', 'Estamos ubicados en el edificio J,🏢 alado del CAE, arriba de la puerta dice DAE, te esperamos .', '', 0, 0, 1, 3, '2025-05-26 22:49:52', '2025-05-26 22:49:55', NULL, '', NULL, NULL, 0, 0),
(5661, 'wamid.HBgNNTIxMjI5MjQzNzQ2ORUCABIYIDY2QkIyMzlDNDA4Nzk3MDcxQTMwNjZDOEFDMjU1QjNBAA==', 8551, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:52:32', '2025-05-26 22:52:32', NULL, '', NULL, '', 0, 0),
(5662, NULL, 8551, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-26 22:52:32', '2025-05-26 22:52:32', NULL, '', NULL, NULL, 0, 0),
(5663, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABIYFDNBNEUyRjRBMzg2QjEyN0YwMjEyAA==', 8532, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 22:57:21', '2025-05-26 22:57:21', NULL, '', NULL, '', 0, 0),
(5664, NULL, 8532, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-26 22:57:21', '2025-05-26 22:57:21', NULL, '', NULL, NULL, 0, 0),
(5665, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABIYFDNBOTFDNDNBRDNFOEIxNEQ1ODk5AA==', 8532, 1, '', '', '', '', '', '', '[]', 'Horarios ?', '', 0, 1, 1, 1, '2025-05-26 22:58:11', '2025-05-26 22:58:12', NULL, '', NULL, '', 1, 0),
(5666, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABEYEjdGRjVCQTNBRDkyMjcyNkM2NAA=', 8532, 1, '', '', '', '', '', '', '[]', 'Estamos en el edificio J, oficinas de la DAE en horario de :\r\n*Lunes a Viernes* de🕙 09:00 a 14:00 y de 16:00 a 19:00 horas\r\n*Sábados* en horario de 09:00 a  14:00 horas.', '', 0, 0, 1, 4, '2025-05-26 22:58:11', '2025-05-26 22:58:16', NULL, '', NULL, NULL, 0, 0),
(5667, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABIYFDNBMkE5MEQwRTlCNjAxMDFGMkZEAA==', 8532, 1, '', '', '', '', '', '', '[]', 'Horario sobre la fecha del examen', '', 0, 1, 1, 1, '2025-05-26 22:58:33', '2025-05-26 22:58:34', NULL, '', NULL, '', 1, 0),
(5668, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABEYEkFGNTVEMDdDODdGREUyNkRDRgA=', 8532, 1, '', '', '', '', '', '', '[]', 'Estamos en el edificio J, oficinas de la DAE en horario de :\r\n*Lunes a Viernes* de🕙 09:00 a 14:00 y de 16:00 a 19:00 horas\r\n*Sábados* en horario de 09:00 a  14:00 horas.', '', 0, 0, 1, 4, '2025-05-26 22:58:33', '2025-05-26 22:58:36', NULL, '', NULL, NULL, 0, 0),
(5669, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABIYFDNBNkM0OTNDQzA5QjEwMkI3MTU0AA==', 8532, 1, '', '', '', '', '', '', '[]', 'Cuando sería', '', 0, 1, 1, 1, '2025-05-26 22:58:35', '2025-05-26 22:58:35', NULL, '', NULL, '', 0, 0),
(5670, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABEYEjcxOTU2NkJEQTREMDlBNTcxMAA=', 8510, 1, '', '', '', '', '', '', '[]', 'Gracias, Si ya lo presentó no se preocupe, procedo a actualizar la información =)', '', 0, 0, 1, 3, '2025-05-26 23:04:19', '2025-05-26 23:04:21', NULL, '', NULL, '', 0, 0),
(5671, 'wamid.HBgNNTIxMjI5MjQzNzQ2ORUCABIYIDgxNDE5NjE1NzQxQ0Y3RTA4NEM4Q0U1RjI2N0M4MjAxAA==', 8551, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:06:17', '2025-05-26 23:06:17', NULL, '', NULL, '', 1, 0),
(5672, 'wamid.HBgNNTIxMjI5MjQzNzQ2ORUCABEYEkExQ0IwNDc0QjczNDNENzU2QQA=', 8551, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 23:06:17', '2025-05-26 23:06:19', NULL, '', NULL, NULL, 0, 0),
(5673, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABEYEjNCQjY5QjNEQkJBQjgwNTFGQgA=', 8532, 1, '', '', '', '', '', '', '[]', 'Favor de contactar a la Coordinación de idiomas', '', 0, 0, 1, 4, '2025-05-26 23:06:32', '2025-05-27 21:47:14', NULL, '', NULL, '', 0, 0),
(5674, 'wamid.HBgNNTIxNzgyMTI2ODY0OBUCABEYEjA1RjlDRERCNTU2OTUzOUJEOAA=', 8532, 1, '', '', '', '', '', '', '[]', 'Ellos le informan todo lo que necesita. =)', '', 0, 0, 1, 4, '2025-05-26 23:06:46', '2025-05-27 21:47:13', NULL, '', NULL, '', 0, 0),
(5675, 'wamid.HBgMNTIyOTYxMTE3NTcwFQIAEhgUM0EyRUQ2NjdGM0IzMjg5N0UwMEMA', 8568, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:06:49', '2025-05-26 23:06:49', NULL, '', NULL, '', 0, 0),
(5676, 'wamid.HBgNNTIxMjIxNDI2NTU5NRUCABIYIDMzNzc0QzhDNzZDMkFGQUM1RTFGMzA2QTQwMjdEOTBFAA==', 8558, 1, '', '', '', '', '', '', '[]', 'Hola buenas tardes', '', 0, 1, 1, 1, '2025-05-26 23:15:54', '2025-05-26 23:15:55', NULL, '', NULL, '', 1, 0),
(5677, 'wamid.HBgNNTIxMjIxNDI2NTU5NRUCABEYEjc3M0E5MUEwMjNFREFEN0RCQgA=', 8558, 1, '', '', '', '', '', '', '[]', 'Hola, como estas, en qué te puedo apoyar hoy ?😼👍', '', 0, 0, 1, 4, '2025-05-26 23:15:54', '2025-05-26 23:15:56', NULL, '', NULL, NULL, 0, 0),
(5678, 'wamid.HBgNNTIxMjIxNDI2NTU5NRUCABIYIDgxMDYyNzc2MDY0M0Q0NkExOTBGMjVGOEUxNDVFMjJDAA==', 8558, 1, '', '', '', '', '', '', '[]', 'Es obligatorio', '', 0, 1, 1, 1, '2025-05-26 23:15:59', '2025-05-26 23:15:59', NULL, '', NULL, '', 0, 0),
(5679, 'wamid.HBgNNTIxMjI5MjQzMTczOBUCABIYIDlBNTExRUU0OTM3MTEyQTE2OTY5ODFDMjRBREFEMzI3AA==', 8487, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:16:11', '2025-05-26 23:16:12', NULL, '', NULL, '', 1, 0),
(5680, 'wamid.HBgNNTIxMjI5MjQzMTczOBUCABEYEjExRjJBNjEyNTEwQjlEMzk1NwA=', 8487, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 23:16:11', '2025-05-26 23:16:13', NULL, '', NULL, NULL, 0, 0),
(5681, 'wamid.HBgNNTIxNTYyNTI3NDk2MxUCABIYFDNBRjM3ODhCNDU1RDFBNkFFNzM5AA==', 8491, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:16:51', '2025-05-26 23:16:52', NULL, '', NULL, '', 1, 0),
(5682, 'wamid.HBgNNTIxNTYyNTI3NDk2MxUCABEYEjdFODdGODJEMkY4QTFDMjRBNAA=', 8491, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 23:16:51', '2025-05-26 23:16:54', NULL, '', NULL, NULL, 0, 0),
(5683, 'wamid.HBgNNTIxMjI5MjA3NDM1MxUCABIYIEFGRjQyNDkzRDEzMjcwNjJBN0IxNkQ2REU2ODg0QTdCAA==', 8522, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:17:22', '2025-05-26 23:17:22', NULL, '', NULL, '', 0, 0),
(5684, NULL, 8522, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-26 23:17:22', '2025-05-26 23:17:22', NULL, '', NULL, NULL, 0, 0),
(5685, 'wamid.HBgNNTIxMjI5MjA3NDM1MxUCABIYIEE4MzEzMEU5NDcyMzREQzZGNDQ5RDI3RjQ2NkM1RjBCAA==', 8522, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:25:21', '2025-05-26 23:25:22', NULL, '', NULL, '', 1, 0),
(5686, 'wamid.HBgNNTIxMjI5MjA3NDM1MxUCABEYEkY0MURCNzQ4NEM2OUJFQTU2MgA=', 8522, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 23:25:22', '2025-05-26 23:25:24', NULL, '', NULL, NULL, 0, 0),
(5687, 'wamid.HBgNNTIxMjI5NDkxMDc2NBUCABIYFDNBN0Y3Mjg5NEFFMUZDNzQ4QUQyAA==', 8498, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-26 23:41:06', '2025-05-26 23:41:07', NULL, '', NULL, '', 1, 0),
(5688, 'wamid.HBgNNTIxMjI5NDkxMDc2NBUCABEYEkNEOTY2QjFDRTJDRkY3OUM0OQA=', 8498, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-26 23:41:06', '2025-05-26 23:41:10', NULL, '', NULL, NULL, 0, 0),
(5689, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABIYFDNBRjUyODU2MkI0OTk1QzM3OEEwAA==', 8524, 1, '', '', '', '', '', '', '[]', 'Buenas tardes', '', 0, 1, 1, 1, '2025-05-26 23:58:47', '2025-05-26 23:58:48', NULL, '', NULL, '', 1, 0),
(5690, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABEYEjBCOTFGN0VEMTA4RTMwQzIxRQA=', 8524, 1, '', '', '', '', '', '', '[]', 'Hola, como estas, en qué te puedo apoyar hoy ?😼👍', '', 0, 0, 1, 2, '2025-05-26 23:58:47', '2025-05-26 23:58:51', NULL, '', NULL, NULL, 0, 0),
(5691, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABIYFDNBMUNFM0Q0RTREQThGQURGNDkxAA==', 8524, 1, '', '', '', '', '', '', '[]', 'disculpe yo había agendado el examen el 13 de junio', '', 0, 1, 1, 1, '2025-05-26 23:59:06', '2025-05-26 23:59:06', NULL, '', NULL, '', 0, 0),
(5692, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABIYFDNBRjdBOTYzQjU0NDEzREY0NDkzAA==', 8524, 1, '', '', '', '', '', '', '[]', 'Ya que en las fechas que me proporcionan yo no puedo', '', 0, 1, 1, 1, '2025-05-26 23:59:13', '2025-05-26 23:59:13', NULL, '', NULL, '', 0, 0),
(5693, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABIYFDNBQzhBMTNBRTcwNjAwRkQ5RjhFAA==', 8560, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 00:11:10', '2025-05-27 00:11:11', NULL, '', NULL, '', 1, 0),
(5694, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABEYEjYxM0VDM0Y2MEQ0ODEwNUY0MAA=', 8560, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 00:11:10', '2025-05-27 00:11:13', NULL, '', NULL, NULL, 0, 0),
(5695, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABIYFDNBMUU4QjhFQ0UyM0I4QzI5MzlCAA==', 8560, 1, '', '', '', '', '', '', '[]', 'Cual es el horario del examen?', '', 0, 1, 1, 1, '2025-05-27 00:11:23', '2025-05-27 00:11:24', NULL, '', NULL, '', 1, 0),
(5696, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABEYEkU2RUU3QzA4NTgyODRDMDNGNwA=', 8560, 1, '', '', '', '', '', '', '[]', 'Nuestros horarios son \r\n*Lunes a Viernes* de🕙 09:00 a 14:00 y de 16:00 a 19:00 horas\r\n*Sábados* en horario de 09:00 a  14:00 horas.', '', 0, 0, 1, 4, '2025-05-27 00:11:23', '2025-05-27 00:11:26', NULL, '', NULL, NULL, 0, 0),
(5697, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABIYFDNBOEQ5MkIyQjdDODM3OTVCRTdFAA==', 8560, 1, '', '', '', '', '', '', '[]', 'A que hora puedo ajendar el examen?', '', 0, 1, 1, 1, '2025-05-27 00:12:05', '2025-05-27 00:12:05', NULL, '', NULL, '', 0, 0),
(5698, 'wamid.HBgNNTIxMjg3MTEwODg1NhUCABIYIDg0QjE4Njg3RUZGMTlBMTU3NzhCMzlFRDkzMEUwRjBEAA==', 8559, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 00:35:30', '2025-05-27 00:35:30', NULL, '', NULL, '', 0, 0),
(5699, NULL, 8559, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 00:35:30', '2025-05-27 00:35:30', NULL, '', NULL, NULL, 0, 0),
(5700, 'wamid.HBgNNTIxMjI5NTExMzQwMxUCABIYFDNBNUY1MzVDOTc5OTNBRkI4RkUxAA==', 8494, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 00:52:42', '2025-05-27 00:52:43', NULL, '', NULL, '', 1, 0),
(5701, 'wamid.HBgNNTIxMjI5NTExMzQwMxUCABEYEkEwMTQ2Q0Y1QUQxNUZERkJGMQA=', 8494, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 00:52:42', '2025-05-27 00:52:45', NULL, '', NULL, NULL, 0, 0),
(5702, 'wamid.HBgNNTIxMjI5NTExMzQwMxUCABIYFDNBNTJDNjc5MkJBMkMyOUNBRDY5AA==', 8494, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 00:52:54', '2025-05-27 00:52:54', NULL, '', NULL, '', 0, 0),
(5703, NULL, 8494, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 00:52:54', '2025-05-27 00:52:54', NULL, '', NULL, NULL, 0, 0),
(5704, 'wamid.HBgNNTIxMjIyNTE5MTIzMBUCABEYEjMyRTY5MEFDNTEwREYyNjkzMwA=', 8560, 1, '', '', '', '', '', '', '[]', 'Por favor puedes hablar o mandar mensaje al área de Idiomas para que te puedan asesorar', '', 0, 0, 1, 3, '2025-05-27 01:00:24', '2025-05-27 01:00:27', NULL, '', NULL, '', 0, 0),
(5705, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABEYEjhDOTJEREU5NjI2QkVFQkI4QgA=', 8524, 1, '', '', '', '', '', '', '[]', 'Claro, por favor contacte al área de Idiomas para informar y validar su fecha 😉', '', 0, 0, 1, 4, '2025-05-27 01:01:25', '2025-05-27 01:01:45', NULL, '', NULL, '', 0, 0),
(5706, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABIYFDNBMTM4RENGOTI1MTEzMjUzQTdCAA==', 8524, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 01:01:57', '2025-05-27 01:01:57', NULL, '', NULL, '', 0, 0),
(5707, NULL, 8524, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 01:01:57', '2025-05-27 01:01:57', NULL, '', NULL, NULL, 0, 0),
(5708, 'wamid.HBgNNTIxMjIxNDI2NTU5NRUCABEYEkUzOUQ1OEFERkZEMTEzOEUyNwA=', 8558, 1, '', '', '', '', '', '', '[]', 'Si, es obligatorio para poder asignarte el nivel de idioma. Por favor contacta al área de idiomas para más información', '', 0, 0, 1, 4, '2025-05-27 01:02:20', '2025-05-27 01:03:28', NULL, '', NULL, '', 0, 0),
(5709, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABIYFDNBMkJBOUU0NDI2RkY2ODAxMUMxAA==', 8524, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 01:02:41', '2025-05-27 01:02:41', NULL, '', NULL, '', 1, 0),
(5710, 'wamid.HBgNNTIxMjI5NTI3OTAwOBUCABEYEjlFODI4QTM0MjU0MTIwNDYwNAA=', 8524, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 01:02:41', '2025-05-27 01:02:44', NULL, '', NULL, NULL, 0, 0),
(5711, 'wamid.HBgNNTIxMjI5MzA2MDc1NRUCABIYIDlCQUU2QzY1OUMxOUI3OTE5RTI3M0U2QUI2MTM1NEVDAA==', 8526, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 01:14:55', '2025-05-27 01:14:56', NULL, '', NULL, '', 1, 0),
(5712, 'wamid.HBgNNTIxMjI5MzA2MDc1NRUCABEYEjUwMUFDMTM0MTUyQjA5OTIzQgA=', 8526, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-27 01:14:55', '2025-05-27 01:14:57', NULL, '', NULL, NULL, 0, 0),
(5713, 'wamid.HBgNNTIxMjI5MjA4ODg2NRUCABIYFDNBOTAwMDI2NUMyM0ZDOTg1QTk0AA==', 8544, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 01:40:42', '2025-05-27 01:40:43', NULL, '', NULL, '', 1, 0),
(5714, 'wamid.HBgNNTIxMjI5MjA4ODg2NRUCABEYEjVGNUU3QkIyNTAyODQzNkI4RgA=', 8544, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 01:40:42', '2025-05-27 01:40:45', NULL, '', NULL, NULL, 0, 0),
(5715, 'wamid.HBgNNTIxMjI5MjA4ODg2NRUCABIYFDNBM0Q4MEQ2NjkwNTc4MDQ4NDIxAA==', 8544, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 01:41:04', '2025-05-27 01:41:04', NULL, '', NULL, '', 0, 0),
(5716, NULL, 8544, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 01:41:04', '2025-05-27 01:41:04', NULL, '', NULL, NULL, 0, 0),
(5717, 'wamid.HBgNNTIxMjI5NTQ4Mzk2MhUCABIYIERCRjU1NTk2OTY0QzQ1MUEyRDAwODZBNDdBOTEzREFEAA==', 8506, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 02:21:15', '2025-05-27 02:21:16', NULL, '', NULL, '', 1, 0),
(5718, 'wamid.HBgNNTIxMjI5NTQ4Mzk2MhUCABEYEkFFMDgzRkMxMjVERUZFMzYxRgA=', 8506, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 02:21:15', '2025-05-27 02:21:18', NULL, '', NULL, NULL, 0, 0),
(5719, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABIYIDYyOEQyQUM5NjM5OEEyQkM4OTE0ODg2MTgyMUFCQUY5AA==', 8510, 1, '', '', '', '', '', '', '[]', 'Ok muchas gracias', '', 0, 1, 1, 1, '2025-05-27 02:37:36', '2025-05-27 02:37:37', NULL, '', NULL, '', 1, 0),
(5720, 'wamid.HBgNNTIxMjI5NTMwMzQwNxUCABEYEjFCNTQwQkQ5OTkwQ0ZBQUM1MwA=', 8510, 1, '', '', '', '', '', '', '[]', 'Estamos para servirle 👍🏻👍🏻', '', 0, 0, 1, 3, '2025-05-27 02:37:36', '2025-05-27 02:37:38', NULL, '', NULL, NULL, 0, 0),
(5721, 'wamid.HBgNNTIxMjI5NDIwODE1ORUCABIYFDNBM0ZDQjU1MkVDMzRBOUY5MUZFAA==', 8564, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 03:15:48', '2025-05-27 03:15:50', NULL, '', NULL, '', 1, 0),
(5722, 'wamid.HBgNNTIxMjI5NDIwODE1ORUCABEYEjIxNkU2OURFMjFENkQ2NjZBMwA=', 8564, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-27 03:15:48', '2025-05-27 03:15:52', NULL, '', NULL, NULL, 0, 0),
(5723, 'wamid.HBgNNTIxMjI5NDIwODE1ORUCABIYFDNBOTMyODVEOTkyOEI2OTU0Mzc5AA==', 8564, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 03:17:23', '2025-05-27 03:17:23', NULL, '', NULL, '', 0, 0),
(5724, NULL, 8564, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 03:17:23', '2025-05-27 03:17:23', NULL, '', NULL, NULL, 0, 0),
(5725, 'wamid.HBgNNTIxMjI5Mzk5Mjc4NBUCABIYIEFDNTExNTVBMTA0RDAxRkM0RkExRkFDQjlDMTBCMzY0AA==', 8553, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 04:56:36', '2025-05-27 04:56:36', NULL, '', NULL, '', 0, 0),
(5726, NULL, 8553, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 04:56:36', '2025-05-27 04:56:36', NULL, '', NULL, NULL, 0, 0),
(5727, 'wamid.HBgNNTIxMjI5Mzk5Mjc4NBUCABIYIEI5M0IwRUE4QTU4MEUwRkRGQkQxMkEzQzQ1M0JDRDkxAA==', 8553, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 04:56:53', '2025-05-27 04:56:54', NULL, '', NULL, '', 1, 0),
(5728, 'wamid.HBgNNTIxMjI5Mzk5Mjc4NBUCABEYEjQxOERGRDk5QkY1Nzg0OEZDRQA=', 8553, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 2, '2025-05-27 04:56:53', '2025-05-27 04:56:56', NULL, '', NULL, NULL, 0, 0),
(5731, 'wamid.HBgNNTIxMjI5MzczNzA0ORUCABIYFDNBMjdBODVBQUQ4OTc3NjFDMDhEAA==', 8536, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 16:41:04', '2025-05-27 16:41:05', NULL, '', NULL, '', 1, 0),
(5732, 'wamid.HBgNNTIxMjI5MzczNzA0ORUCABEYEjQwRDIyNUE2MTE3MjA4NTU1RgA=', 8536, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-27 16:41:04', '2025-05-27 16:41:07', NULL, '', NULL, NULL, 0, 0),
(5733, 'wamid.HBgMNTIyOTYxMTE3NTcwFQIAEhgUM0E0NjYyNkUyNTNDNDk1NEIzODUA', 8568, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-27 19:35:23', '2025-05-27 19:35:23', NULL, '', NULL, '', 0, 0),
(5734, NULL, 8568, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-27 19:35:23', '2025-05-27 19:35:23', NULL, '', NULL, NULL, 0, 0),
(5735, 'wamid.HBgNNTIxMjcyMjI2MTc2NxUCABIYIDUzQ0UzMENEMzlFNzZBM0M3MTZBRkZBOTZDNUJFRUQ5AA==', 8565, 1, '', '', '', '', '', '', '[]', 'ya la agendé', '', 0, 1, 1, 1, '2025-05-27 19:52:41', '2025-05-27 19:52:41', NULL, '', NULL, '', 0, 0),
(5736, 'wamid.HBgNNTIxMjcyMjI2MTc2NxUCABIYIDVDRDA4N0E5QzY4N0Y5MTMyQjQ1QkMyRjAyODY2QTNFAA==', 8565, 1, '', '', '', '', '', '', '[]', 'para el miércoles 4 de junio 5pm', '', 0, 1, 1, 1, '2025-05-27 19:53:00', '2025-05-27 19:53:00', NULL, '', NULL, '', 0, 0),
(5737, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABIYIEFGNzkzRENGNzMzQ0I4M0E1MjQwNjlDMjhFNkU2RTQ5AA==', 8539, 1, '', '', '', '', '', '', '[]', 'Hola buenas tardes disculpe por apenas contestar de verdad eeh sobre el EXUBI EL OTRO DIA SE CONTACTARON CONMIGO Y ME DIJIERON Q TENIA 2 OPCIONES Q ERA la carta de renuncia y el hacer el EXUBI PERO PUES LA VERDAD EN LAS ESCUELAS EEH IDO LOS MAESTROS NO ENSEÑAN NADA DE INGLÉS ES MAS NI ELLOS SABEN Y PUES TENGO UN BAJO NIVEL EN INGLÉS  y me comentaron q con la carta de renuncia iniciaba desde 0 el curso de inglés y pues si la acepte la carta de renuncia', '', 0, 1, 1, 1, '2025-05-28 01:59:32', '2025-05-28 01:59:33', NULL, '', NULL, '', 1, 0),
(5738, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABEYEjRCQTY2NDUyRUQzRTZBQjJDNQA=', 8539, 1, '', '', '', '', '', '', '[]', 'Hola, como estas, en qué te puedo apoyar hoy ?😼👍', '', 0, 0, 1, 4, '2025-05-28 01:59:32', '2025-05-28 01:59:46', NULL, '', NULL, NULL, 0, 0),
(5739, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABIYIEQ2NURBOTg3MERCMTQ4NzY4M0MwMTFCM0RDNUU1QjVCAA==', 8539, 1, '', '', '', '', '', '', '[]', 'O es para otra cosa expliquenme', '', 0, 1, 1, 1, '2025-05-28 01:59:46', '2025-05-28 01:59:46', NULL, '', NULL, '', 0, 0),
(5740, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABIYIDgwNzYzQUJDQUQ5NDdGMURGMjE2NUY1Q0NFQjVBNjRCAA==', 8539, 1, '', '', '', '', '', '', '[]', 'Es q ya anteriormente hace algunos días me contaron el área de idiomas ( inglés) y ya firme la carta de renuncia para iniciar ingles desde 0 .... Y ese examen q usted dice es de otro cosa o otro idioma', '', 0, 1, 1, 1, '2025-05-28 02:14:52', '2025-05-28 02:14:52', NULL, '', NULL, '', 0, 0),
(5741, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABIYFDNBRkZDNjlCNDY0NTMwMzBBOUNFAA==', 8527, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-28 04:36:34', '2025-05-28 04:36:35', NULL, '', NULL, '', 1, 0),
(5742, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABEYEkFDQUZENzA3QkI4NjMzNjdFNgA=', 8527, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-28 04:36:34', '2025-05-28 04:36:37', NULL, '', NULL, NULL, 0, 0),
(5743, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABIYFDNBOERGNzZFMTI2NjMzQkEwMDc4AA==', 8527, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-28 04:36:37', '2025-05-28 04:36:37', NULL, '', NULL, '', 0, 0),
(5744, NULL, 8527, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-28 04:36:37', '2025-05-28 04:36:37', NULL, '', NULL, NULL, 0, 0),
(5745, 'wamid.HBgNNTIxMjI5NTE0MzAwMhUCABIYIDQ2RUE1MUM0MkExQTM3Qjc2NzVBODg5OTQwM0VFMzhBAA==', 8490, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-28 12:54:13', '2025-05-28 12:54:15', NULL, '', NULL, '', 1, 0),
(5746, 'wamid.HBgNNTIxMjI5NTE0MzAwMhUCABEYEjNEREI3MDhGRkEzNzQxQTg0OAA=', 8490, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-28 12:54:13', '2025-05-28 12:54:16', NULL, '', NULL, NULL, 0, 0),
(5747, 'wamid.HBgNNTIxMjI5NTE0MzAwMhUCABIYIDJCRDFFMjMxMkZCQTA1OTU1NEVCRjUwNjA2OTM5NDE4AA==', 8490, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-28 12:54:26', '2025-05-28 12:54:26', NULL, '', NULL, '', 0, 0),
(5748, NULL, 8490, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-28 12:54:26', '2025-05-28 12:54:26', NULL, '', NULL, NULL, 0, 0),
(5749, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABEYEkFENzg2RkZBQzMxMzcwNkQ1QgA=', 8539, 1, '', '', '', '', '', '', '[]', 'Buen día. Muchas gracias por infórmanos que inicia del nivel 1 de idioma , es muy buena decisión para poder aprender desde 0, tomamos nota para informar al área de idiomas , que tenga buen día', '', 0, 0, 1, 4, '2025-05-28 14:34:56', '2025-05-29 01:29:15', NULL, '', NULL, '', 0, 0),
(5750, 'wamid.HBgNNTIxMjI5NDM5OTg2NxUCABIYIDQzMzFFQkYxODAwMDc3NTA0NEM2RjcxNTMwMjY1REIzAA==', 8539, 1, '', '', '', '', '', '', '[]', 'Muchas t igualmente', '', 0, 1, 1, 1, '2025-05-29 01:29:48', '2025-05-29 01:29:48', NULL, '', NULL, '', 0, 0),
(5751, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABIYFDNBRjRFNkNERUQ4MTM3QzMzNkE1AA==', 8527, 1, '', '', '', '', '', '', '[]', 'hola buenas noches', '', 0, 1, 1, 1, '2025-05-29 02:18:02', '2025-05-29 02:18:04', NULL, '', NULL, '', 1, 0),
(5752, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABEYEjlCN0NDNzVFQjc0NUE2MEE1MgA=', 8527, 1, '', '', '', '', '', '', '[]', 'Hola, como estas, en qué te puedo apoyar hoy ?😼👍', '', 0, 0, 1, 3, '2025-05-29 02:18:02', '2025-05-29 02:18:05', NULL, '', NULL, NULL, 0, 0),
(5753, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABIYFDNBRkNBMEM3MDNBNDA4NTg4MkNFAA==', 8527, 1, '', '', '', '', '', '', '[]', 'quisiera más información sobre el examen exubi, ya que no sé si tenga la opción de tomar la carta renuncia y empezar con el inglés de cero', '', 0, 1, 1, 1, '2025-05-29 02:21:23', '2025-05-29 02:21:23', NULL, '', NULL, '', 0, 0),
(5754, 'wamid.HBgNNTIxMjI5MTA3OTk2NRUCABIYFDNBN0VEOTMxMkM0Qzk5NzFFQTZCAA==', 8503, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-29 04:23:53', '2025-05-29 04:23:54', NULL, '', NULL, '', 1, 0),
(5755, 'wamid.HBgNNTIxMjI5MTA3OTk2NRUCABEYEjZDNTM0NDdFNjkzNzEwN0EyRQA=', 8503, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-29 04:23:53', '2025-05-29 04:23:56', NULL, '', NULL, NULL, 0, 0),
(5756, 'wamid.HBgNNTIxMjI5MTM3NTAxMhUCABIYFDNBMUM4RkU0NTIwNzkxRUMxOTE1AA==', 8543, 1, '', '', '', '', '', '', '[]', 'Datos de la Coordinación', '', 0, 1, 1, 1, '2025-05-29 14:47:14', '2025-05-29 14:47:16', NULL, '', NULL, '', 1, 0),
(5757, 'wamid.HBgNNTIxMjI5MTM3NTAxMhUCABEYEkRFNDE3MURGNDA5M0UwNkU5QwA=', 8543, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-29 14:47:14', '2025-05-29 14:47:19', NULL, '', NULL, NULL, 0, 0),
(5758, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABEYEjk3ODUwNUE4OEM5MTg1QjNENQA=', 8527, 1, '', '', '', '', '', '', '[]', 'Por favor contactar a :', '', 0, 0, 1, 3, '2025-05-29 19:44:35', '2025-05-29 19:44:41', NULL, '', NULL, '', 0, 0),
(5759, 'wamid.HBgNNTIxOTIxMTEzNTkzMxUCABEYEkM5REFBOEJGMDkwQkE4QUI3NQA=', 8527, 1, '', '', '', '', '', '', '[]', 'Arysa Esthibaly Del Angel Zumaya Coordinadora de Programa Idiomas ✉ Email: arysa.delangel@uvmnet.edu ☎ Teléfono:(229) 923-62-90 Ext. 59242 ✅ Whatsapp: 2297326317 ⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 3, '2025-05-29 19:44:37', '2025-05-29 19:44:40', NULL, '', NULL, '', 0, 0),
(5760, 'wamid.HBgNNTIxMjI5NTMwOTQ0OBUCABIYIDVDNzQ0QkE0MjY2RDFCQzRFOTUwNDFDMjEyQkExMjcxAA==', 8535, 1, '', '', '', '', '', '', '[]', 'Ficha de la Coordinación', '', 0, 1, 1, 1, '2025-05-29 23:15:10', '2025-05-29 23:15:10', NULL, '', NULL, '', 0, 0),
(5761, NULL, 8535, 1, '', '', '', '', '', '', '[{\"link\":\"https:\\/\\/movil.alever.mx\\/archivos\\/FichaIdiomas.pdf\",\"filename\":\"Ficha Coordinaci\\u00f3n idiomas\"}]', '', '', 0, 0, 1, 1, '2025-05-29 23:15:10', '2025-05-29 23:15:10', NULL, '', NULL, NULL, 0, 0),
(5762, 'wamid.HBgNNTIxMjk3MTAyMzcyNhUCABIYIEEwQzRCRjZGRjc4Qzc0RTY4OEFDNzFGQzAyQTIwMzJGAA==', 8395, 1, '', '', '', '', '', '', '[]', 'Datos de contacto', '', 0, 1, 1, 1, '2025-05-30 06:35:24', '2025-05-30 06:35:26', NULL, '', NULL, '', 1, 0),
(5763, 'wamid.HBgNNTIxMjk3MTAyMzcyNhUCABEYEjVGQzU5MDAwREM3RDYyREQxNAA=', 8395, 1, '', '', '', '', '', '', '[]', 'Mtro. Arturo Cadenas Andrade\r\nCoordinador del programa Médico Cirujano\r\n\r\n✉️ Email: arturo.cadenas@uvmnet.edu\r\n\r\n☎️ Teléfono:(229) 923-62-90  Ext. 59240\r\n\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', '', 0, 0, 1, 4, '2025-05-30 06:35:24', '2025-05-30 06:35:28', NULL, '', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_02_27_230105_create_plans', 1),
(7, '2021_02_27_232353_create_companies', 1),
(8, '2021_02_27_234032_create_posts', 1),
(9, '2023_02_27_171315_create_sessions_table', 1),
(10, '2023_02_27_225028_create_permission_tables', 1),
(11, '2023_02_27_233806_create_config', 1),
(12, '2023_04_05_191813_add_welcome_valid_until_field_to_users_table', 1),
(13, '2023_07_29_134946_create_contacts_table', 1),
(14, '2023_08_11_122409_create_contact_messages', 1),
(15, '2023_08_17_205139_create_wa_templates_table', 1),
(16, '2023_08_26_044436_create_campaings_table', 1),
(17, '2023_09_07_140918_create_replies_table', 1),
(18, '2023_09_14_193132_update_configs_table', 1),
(19, '2023_10_26_174758_update_contacts_table_with_enable_ai', 1),
(20, '2023_11_11_171841_add_cancel_url_to_users', 1),
(21, '2023_11_23_103106_update_replies_and_messages_table', 1),
(22, '2024_01_17_000000_rename_password_resets_table', 1),
(23, '2024_02_21_210321_update_wa_campaings_table', 1),
(24, '2024_02_26_121412_add_role_staff', 1),
(25, '2024_03_13_192149_update_wa_campaings', 1),
(26, '2024_04_20_183145_create_whatsappwidgets_table', 2),
(27, '2024_07_08_170721_create_update_user_with_paypal', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 2),
(6, 'App\\Models\\User', 5),
(6, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(100) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) NOT NULL,
  `guard_name` varchar(125) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'Whatstapp', '6d8c3b2f391a30e258c8f29b2cf261d7b52de2cf6f9b5e849414e6942ff9bd39', '[\"*\"]', NULL, NULL, '2024-05-25 18:40:14', '2024-05-25 18:40:14'),
(2, 'App\\Models\\User', 5, 'Whatstapp', 'a8d92e4dea00243c2b20a829b94b963897d125af7d6337e8b50b6d8ad7078b20', '[\"*\"]', NULL, NULL, '2024-06-09 11:45:38', '2024-06-09 11:45:38'),
(3, 'App\\Models\\User', 6, 'Whatstapp', '92731d33643249db9cf0652a6978f3d7d2fb02abd25b507c8bde6ace12e45c5f', '[\"*\"]', NULL, NULL, '2024-06-26 09:33:55', '2024-06-26 09:33:55'),
(4, 'App\\Models\\User', 1, 'Whatstapp', '48222f296fef0d4d85f2ff62c6fad0cf6355e62964c23e9df6d303775badece7', '[\"*\"]', NULL, NULL, '2025-05-21 00:14:53', '2025-05-21 00:14:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan`
--

CREATE TABLE `plan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `limit_items` int(11) DEFAULT 0 COMMENT '0 is unlimited',
  `limit_orders` int(11) DEFAULT 0 COMMENT '0 is unlimited',
  `price` double(8,2) NOT NULL,
  `period` int(11) NOT NULL DEFAULT 1 COMMENT '1 - monthly, 2-anually',
  `paddle_id` varchar(191) DEFAULT NULL,
  `description` varchar(555) NOT NULL DEFAULT '1',
  `features` varchar(555) NOT NULL DEFAULT '1',
  `limit_views` int(11) NOT NULL DEFAULT 0 COMMENT '0 is unlimited',
  `enable_ordering` int(11) NOT NULL DEFAULT 1,
  `stripe_id` varchar(191) DEFAULT NULL,
  `paypal_id` varchar(191) DEFAULT NULL,
  `mollie_id` varchar(191) DEFAULT NULL,
  `paystack_id` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plan`
--

INSERT INTO `plan` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `limit_items`, `limit_orders`, `price`, `period`, `paddle_id`, `description`, `features`, `limit_views`, `enable_ordering`, `stripe_id`, `paypal_id`, `mollie_id`, `paystack_id`) VALUES
(1, '2024-05-25 18:36:59', '2024-07-08 15:32:17', NULL, 'Light', 0, 0, 100.00, 1, NULL, 'UVM Veracruz', 'chat', 0, 1, NULL, '', NULL, NULL),
(2, '2024-07-08 00:05:28', '2024-07-08 00:05:28', NULL, 'Free', 0, 0, 0.00, 2, NULL, 'Completo', 'Todos los plugins', 0, 1, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `post_type` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `subtitle` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `link` varchar(191) DEFAULT NULL,
  `link_name` varchar(191) DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `created_at`, `updated_at`, `post_type`, `title`, `subtitle`, `description`, `image`, `link`, `link_name`, `vendor_id`) VALUES
(1, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'faq', '{\"en\":\"Can I cancel anytime?\"}', NULL, '{\"en\":\"Yes, you can! We believe in flexibility, and there are no long-term commitments. You can cancel your subscription at any time with no hidden fees or penalties.\"}', NULL, NULL, NULL, NULL),
(2, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'faq', '{\"en\":\"How do I create a marketing campaign?\"}', NULL, '{\"en\":\"Creating a marketing campaign is easy with our platform. We provide a user-friendly interface that allows you to design, target, and launch campaigns effortlessly. If you need assistance, our support team is always here to help.\"}', NULL, NULL, NULL, NULL),
(3, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'faq', '{\"en\":\"Is my data secure?\"}', NULL, '{\"en\":\"Absolutely. We take data security seriously. Our platform employs robust encryption protocols and follows industry best practices to ensure your data remains safe and confidential.\"}', NULL, NULL, NULL, NULL),
(4, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'faq', '{\"en\":\"Can I integrate this with my existing tools?\"}', NULL, '{\"en\":\"Yes, our platform is designed to be compatible with various third-party tools and services. We offer integrations that make it easy to connect with your existing marketing stack for a seamless experience.\"}', NULL, NULL, NULL, NULL),
(5, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'testimonial', '{\"en\":\"I love using the system\"}', '{\"en\":\"John Doe - CEO of Marketing LTD\"}', '{\"en\":\"This WhatsApp marketing platform has completely transformed how we engage with our customers. It\'s a game-changer for our marketing campaigns, and the direct WhatsApp chat feature has boosted our customer interactions. The platform is user-friendly, and the support team is incredibly responsive. Highly recommend!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/0.png?w=100&h=100', NULL, NULL, NULL),
(6, '2024-05-25 23:21:22', '2024-05-25 23:21:22', 'testimonial', '{\"en\":\"Exceptional WhatsApp Marketing\"}', '{\"en\":\"Jane Smith - Marketing Manager\"}', '{\"en\":\"Your WhatsApp marketing platform has been a game-changer for our marketing efforts. The campaigns are highly effective, and the direct chat feature allows us to connect with customers on a personal level. It\'s made a significant impact on our business growth!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/1.png?w=100&h=100', NULL, NULL, NULL),
(7, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Effortless Marketing Campaigns\"}', '{\"en\":\"David Williams - Digital Marketer\"}', '{\"en\":\"Using your WhatsApp marketing platform has made managing campaigns effortless. The results have been outstanding, and the direct WhatsApp chat has improved our customer engagement. The platform\'s simplicity and the support team\'s assistance have been invaluable to our success.\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/2.png?w=100&h=100', NULL, NULL, NULL),
(8, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"A Must-Have for Marketers\"}', '{\"en\":\"Susan Brown - Marketing Director\"}', '{\"en\":\"Your WhatsApp marketing SaaS platform is a must-have for any marketer. It\'s streamlined our marketing efforts, and the direct chat feature has enhanced our customer relationships. The platform is intuitive, and the support team is top-notch. We couldn\'t be happier with the results!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/3.png?w=100&h=100', NULL, NULL, NULL),
(9, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Great Customer Service\"}', '{\"en\":\"Alex Johnson - Customer Service Manager\"}', '{\"en\":\"The customer service from this WhatsApp marketing platform has been exceptional. They\'re always ready to assist and make using the platform a breeze. Highly recommend!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/4.png?w=100&h=100', NULL, NULL, NULL),
(10, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Improved Business Operations\"}', '{\"en\":\"Emily Davis - Business Owner\"}', '{\"en\":\"This WhatsApp marketing platform has improved our business operations significantly. The direct chat feature has made communication with customers so much easier. It\'s a fantastic tool!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/5.png?w=100&h=100', NULL, NULL, NULL),
(11, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Excellent Marketing Tool\"}', '{\"en\":\"Michael Miller - Marketing Specialist\"}', '{\"en\":\"This WhatsApp marketing platform is an excellent tool for any business. It\'s easy to use and has made our marketing campaigns much more effective. The customer service is also top-notch!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/6.png?w=100&h=100', NULL, NULL, NULL),
(12, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Incredible Results\"}', '{\"en\":\"Sarah Thompson - Sales Manager\"}', '{\"en\":\"This WhatsApp marketing platform has delivered incredible results for our sales team. The direct chat feature has significantly improved our customer engagement. The platform is easy to use and the support team is always ready to help. Highly recommend!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/7.png?w=100&h=100', NULL, NULL, NULL),
(13, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'testimonial', '{\"en\":\"Boosted Our Marketing\"}', '{\"en\":\"Robert Anderson - Marketing Executive\"}', '{\"en\":\"Your WhatsApp marketing platform has boosted our marketing efforts. The campaigns are highly effective and the direct chat feature allows us to connect with customers on a personal level. It\'s made a significant impact on our business growth!\"}', 'https://mobidonia-demo.imgix.net/img/testimonials/8.png?w=100&h=100', NULL, NULL, NULL),
(14, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'feature', '{\"en\":\"Email marketing is 🏴‍☠️. Say hi to Whatsapp marketing\"}', NULL, '{\"en\":\"Whatsapp Marketing is a new fields in Direct Marketing. Experience around 98% read rate on your campaigns and never fear your account to get blocked from Whatsapp.\"}', 'https://mobidonia-demo.imgix.net/img/campaign.png', NULL, NULL, NULL),
(15, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'feature', '{\"en\":\"Chat with your contacts\"}', NULL, '{\"en\":\"Here, you will find fully featured chat system, from where you can send docs, images, fast replies, and rich message templates. Offer manual and automated support via the reply bot triggered by the client message.\"}', 'https://mobidonia-demo.imgix.net/img/chat_clear.png', NULL, NULL, NULL),
(16, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'feature', '{\"en\":\"AI Chat 🤖\"}', NULL, '{\"en\":\"Engage with your customers using our AI chat feature. It can handle common queries, provide information, and direct the conversation to a human operator if needed. Improve your customer service with our AI chat.\"}', 'https://mobidonia-demo.imgix.net/img/ai_chat.png', NULL, NULL, NULL),
(17, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'mainfeature', '{\"en\":\"Outbound Campaigns\"}', NULL, '{\"en\":\"Execute your outbound campaigns effectively.\"}', 'https://mobidonia-demo.imgix.net/img/camp.png', NULL, NULL, NULL),
(18, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'mainfeature', '{\"en\":\"Better Support\"}', NULL, '{\"en\":\"Experience superior customer support.\"}', 'https://mobidonia-demo.imgix.net/img/rating.png', NULL, NULL, NULL),
(19, '2024-05-25 23:21:23', '2024-05-25 23:21:23', 'mainfeature', '{\"en\":\"AI Chat\"}', NULL, '{\"en\":\"Be there 24/7 for your users.\"}', 'https://mobidonia-demo.imgix.net/img/robot.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1- Just a quick reply, 2-on exact match, 3-on contains',
  `trigger` varchar(191) NOT NULL DEFAULT '',
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `header` varchar(191) NOT NULL DEFAULT '',
  `footer` varchar(191) NOT NULL DEFAULT '',
  `button1` varchar(191) NOT NULL DEFAULT '',
  `button1_id` varchar(191) NOT NULL DEFAULT '',
  `button2` varchar(191) NOT NULL DEFAULT '',
  `button2_id` varchar(191) NOT NULL DEFAULT '',
  `button3` varchar(191) NOT NULL DEFAULT '',
  `button3_id` varchar(191) NOT NULL DEFAULT '',
  `button_name` varchar(191) NOT NULL DEFAULT '',
  `button_url` varchar(191) NOT NULL DEFAULT '',
  `flow_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `replies`
--

INSERT INTO `replies` (`id`, `name`, `text`, `type`, `trigger`, `company_id`, `created_at`, `updated_at`, `used`, `header`, `footer`, `button1`, `button1_id`, `button2`, `button2_id`, `button3`, `button3_id`, `button_name`, `button_url`, `flow_id`) VALUES
(4, 'Horarios', 'Nuestros horarios son \r\n*Lunes a Viernes* de🕙 09:00 a 14:00 y de 16:00 a 19:00 horas\r\n*Sábados* en horario de 09:00 a  14:00 horas.', 3, 'Horarios,horario', 1, '2024-05-25 22:47:15', '2025-05-27 00:11:23', 83, '', '', '', '', '', '', '', '', '', '', NULL),
(40, 'xx', 'xxxxxxxxxx', 1, 'xx', 1, '2024-06-30 14:21:16', '2024-06-30 14:21:16', 0, '', '', '', '', '', '', '', '', '', '', NULL),
(51, 'Muchas Gracias', 'Estamos para servirle 👍🏻👍🏻', 3, 'gracias,Gracias', 1, '2024-07-03 19:30:18', '2025-05-27 02:37:36', 78, '', '', '', '', '', '', '', '', '', '', NULL),
(52, 'Ok', '😀👍', 2, 'ok,ok.,ok!', 1, '2024-07-05 23:10:49', '2025-05-21 00:34:44', 9, '', '', '', '', '', '', '', '', '', '', NULL),
(53, 'Hola', 'Hola, como estas, en qué te puedo apoyar hoy ?😼👍', 3, 'Buenos días,buenos dias,Buen día,hola,Hola,Buenas tardes,buenas tardes,buenos dias,buena tarde,Buena tarde,Buenas tardes', 1, '2024-07-07 15:20:46', '2025-05-29 02:18:02', 68, '', '', '', '', '', '', '', '', '', '', NULL),
(56, 'Croquis de la Universidad ( Archivo )', 'Croquis de la Universidad', 3, 'Croquis de la Universidad', 1, '2024-07-31 15:40:28', '2025-05-23 00:03:09', 94, '', '', '', '', '', '', '', '', 'Croquis', 'https://movil.alever.mx/archivos/CROQUIS.pdf', NULL),
(57, 'Atención Estudiante (CAE)', 'El Centro de Atención al Estudiante ( CAE ) cuenta con el siguiente correo ✉️: cae.veracruz@uvmnet.edu \r\ny el teléfono 📞: 22 99236290 ext. 59534\r\n\r\nCon gusto te apoyaremos en las dudas que tengas 😄👍', 3, 'Centro de Atención (info)', 1, '2024-07-31 15:42:31', '2025-05-21 16:33:52', 53, '', '', '', '', '', '', '', '', '', '', NULL),
(60, 'Datos Arturo Cadenas', 'Mtro. Arturo Cadenas Andrade\r\nCoordinador del programa Médico Cirujano\r\n\r\n✉️ Email: arturo.cadenas@uvmnet.edu\r\n\r\n☎️ Teléfono:(229) 923-62-90  Ext. 59240\r\n\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', 3, 'Datos de contacto', 1, '2025-05-21 17:23:50', '2025-05-30 06:35:24', 16, '', '', '', '', '', '', '', '', '', '', NULL),
(61, 'Coordinadores Academicos (Archivo)', '', 3, 'Coodinadores Academicos', 1, '2025-05-23 00:00:09', '2025-05-23 00:03:22', 2, '', '', '', '', '', '', '', '', 'Coordinadores Academicos', 'https://movil.alever.mx/archivos/CoodinadoresAcademicos.pdf', NULL),
(62, 'Ficha Arturo Cadenas ( Archivo )', '', 3, 'Ficha de contacto', 1, '2025-05-23 15:46:06', '2025-05-26 16:01:12', 6, '', '', '', '', '', '', '', '', 'Ficha Mtro. Arturo Cadenas', 'https://movil.alever.mx/archivos/FichaArturoCadenas.pdf', NULL),
(64, 'Datos de la Coordinación idiomas', 'Arysa Esthibaly Del Angel Zumaya\r\nCoordinadora de Programa Idiomas\r\n\r\n✉ Email: arysa.delangel@uvmnet.edu\r\n☎ Teléfono:(229) 923-62-90  Ext. 59242\r\n✅ Whatsapp: 2297326317\r\n⏰ Horarios: Lun - Vie de 9 a 14 y de 16 a 19', 3, 'Datos de la Coordinación', 1, '2025-05-26 19:43:46', '2025-05-29 14:47:14', 22, '', '', '', '', '', '', '', '', '', '', NULL),
(65, 'Ficha Coordinación idiomas', '', 3, 'Ficha de la Coordinación', 1, '2025-05-26 19:46:47', '2025-05-29 23:15:10', 15, '', '', '', '', '', '', '', '', 'Ficha Coordinación idiomas', 'https://movil.alever.mx/archivos/FichaIdiomas.pdf', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) NOT NULL,
  `guard_name` varchar(125) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'staff', 'web', NULL, NULL),
(5, 'admin', 'web', '2024-05-25 23:20:59', '2024-05-25 23:20:59'),
(6, 'owner', 'web', '2024-05-25 23:20:59', '2024-05-25 23:20:59'),
(7, 'client', 'web', '2024-05-25 23:20:59', '2024-05-25 23:20:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `actividad` varchar(250) DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `actividad`, `last_activity`) VALUES
(1, 2, NULL, '', '2025-05-29 23:35:55'),
(2, 7, NULL, '', '2025-05-29 23:39:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_status` varchar(191) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `welcome_valid_until` timestamp NULL DEFAULT NULL,
  `cancel_url` varchar(191) DEFAULT NULL,
  `subscription_plan_id` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `plan_id`, `plan_status`, `company_id`, `welcome_valid_until`, `cancel_url`, `subscription_plan_id`) VALUES
(1, 'Admin', 'antonio.lealel@gmail.com', '2024-05-25 23:20:59', '$2y$10$soCsd8I5O6lhzarGhhxho.xnUhU8JNxHGd8f9y5YxxOZ.KdRwvhBq', NULL, NULL, NULL, 'IvFHihv9MExMdBd7dR4gRJmFB6Qf3qKHkaTSqWDJvxNWXLqPbItcOvQ4uM2x', NULL, NULL, '2024-05-25 23:20:59', '2024-06-09 11:43:50', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Antonio Leal', 'antonio.lealel@uvmnet.edu', NULL, '$2y$10$AjdJQ6w3rDQ3/DC/16l9MO15xZg5JX9CNq/FxdthqJ5SWtZfDr.Nq', NULL, NULL, NULL, '7e2NpZrvUryuMXISJhDJhSd7d2ZVSfBy5fK6bvDAl75D69wo6ThgjuCSBXHW', NULL, NULL, '2024-05-25 18:20:50', '2024-05-25 18:38:41', 1, 'set_by_admin', 1, NULL, NULL, NULL),
(7, 'IDIOMA', 'arysa.delangel@uvmnet.edu', NULL, '$2y$10$KMk9xQgipw4O/CDPXRmnEerpNzpjKvjfantaWYs3v0s/Q8Vh9YtHS', NULL, NULL, NULL, 'A57v8LT5JCpeWH75HFCoZkwNjcxmqSLUL2RerKyaJpwP8Wm2SnSm3LvPIbHd', NULL, NULL, '2025-05-27 03:45:35', '2025-05-28 18:21:39', NULL, NULL, 1, NULL, NULL, NULL),
(8, 'GIOVANNA', 'giovanna.forcade@uvmnet.edu', NULL, '$2y$10$wCVhsJnFYI0.btvCdz0Twu9t8h8LocjpN1ifiUQkpiYd58w0eV19m', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-28 00:59:06', '2025-05-28 18:22:22', NULL, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wa_campaings`
--

CREATE TABLE `wa_campaings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `send_to` int(11) NOT NULL DEFAULT 1,
  `sended_to` int(11) NOT NULL DEFAULT 0,
  `delivered_to` int(11) NOT NULL DEFAULT 0,
  `read_by` int(11) NOT NULL DEFAULT 0,
  `contestado_por` int(11) NOT NULL DEFAULT 0,
  `total_contacts` int(11) NOT NULL DEFAULT 0,
  `timestamp_for_delivery` varchar(191) DEFAULT NULL,
  `variables` text NOT NULL,
  `variables_match` text NOT NULL,
  `media_link` varchar(191) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bot_type` int(11) NOT NULL DEFAULT 2 COMMENT '2-on exact match, 3-on contains',
  `trigger` varchar(191) NOT NULL DEFAULT '',
  `used` int(11) NOT NULL DEFAULT 0,
  `is_bot_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Flag to represent if the bot is active or not',
  `is_bot` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag to represent if the campaign is for bots',
  `is_api` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag to represent if the campaign is for API',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Flag to represent if the campaign is active or paused'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `wa_campaings`
--

INSERT INTO `wa_campaings` (`id`, `name`, `send_to`, `sended_to`, `delivered_to`, `read_by`, `contestado_por`, `total_contacts`, `timestamp_for_delivery`, `variables`, `variables_match`, `media_link`, `company_id`, `template_id`, `group_id`, `contact_id`, `created_at`, `updated_at`, `bot_type`, `trigger`, `used`, `is_bot_active`, `is_bot`, `is_api`, `is_active`) VALUES
(85, 'EXUBI 26052025', 81, 76, 71, 45, 27, 107, NULL, '{\"body\":{\"1\":\"NOMBRE\",\"2\":\"PROGRAMA\",\"3\":\"FECHA_DEL\",\"4\":\"FECHA_AL\"}}', '{\"body\":{\"1\":\"-1\",\"2\":\"3\",\"3\":\"19\",\"4\":\"18\"}}', NULL, 1, 729517763094173, 58, NULL, '2025-05-26 22:23:45', '2025-05-30 02:40:50', 2, '', 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wa_templates`
--

CREATE TABLE `wa_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `category` varchar(191) NOT NULL,
  `language` varchar(191) NOT NULL,
  `components` text NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `wa_templates`
--

INSERT INTO `wa_templates` (`id`, `name`, `status`, `category`, `language`, `components`, `company_id`, `created_at`, `updated_at`) VALUES
(702166518964790, 'hello_world', 'APPROVED', 'UTILITY', 'en_US', '[{\"type\":\"HEADER\",\"format\":\"TEXT\",\"text\":\"Hello World\"},{\"type\":\"BODY\",\"text\":\"Welcome and congratulations!! This message demonstrates your ability to send a WhatsApp message notification from the Cloud API, hosted by Meta. Thank you for taking the time to test with us.\"},{\"type\":\"FOOTER\",\"text\":\"WhatsApp Business Platform sample message\"}]', 1, '2025-05-27 19:53:31', '2025-05-27 19:53:31'),
(729517763094173, 'aviso_idiomas', 'APPROVED', 'UTILITY', 'es_MX', '[{\"type\":\"BODY\",\"text\":\"Hola *{{1}}* \\ud83d\\udc4b futur@ Lince de Programa *{{2}}* \\ud83d\\ude3a, \\u00a1Bienvenid@! a la *Universidad del Valle de M\\u00e9xico Campus Veracruz*\\n\\n Para completar el proceso de inscripci\\u00f3n, no olvides presentar tu *examen de ubicaci\\u00f3n a idiomas*\\ud83d\\udcdd\\n\\n Pr\\u00f3xima \\ud83d\\udcc5 fecha de examen de ubicaci\\u00f3n (EXUBI): *{{3}}* al *{{4}}*\\n\\n  Contacta a la Coordinadora *Lic. Arysa del \\u00c1ngel* para confirmar tu fecha y conocer el horario de aplicaci\\u00f3n \\ud83d\\udd52\",\"example\":{\"body_text\":[[\"NOMBRE\",\"PROGRAMA\",\"FECHA_DEL\",\"FECHA_AL\"]]}},{\"type\":\"FOOTER\",\"text\":\"Da clic en los botones para enviarte los datos deseados\"},{\"type\":\"BUTTONS\",\"buttons\":[{\"type\":\"PHONE_NUMBER\",\"text\":\"Llamar a la Coordinaci\\u00f3n\",\"phone_number\":\"+522297326317\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de la Coordinaci\\u00f3n\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de la Coordinaci\\u00f3n\"}]}]', 1, '2025-05-26 19:48:06', '2025-05-27 19:53:31'),
(1067914415190325, 'aviso_mensajes1', 'APPROVED', 'UTILITY', 'es_MX', '[{\"type\":\"BODY\",\"text\":\"Hola, *{{1}}* mand\\u00f3 un mensaje al chat de UVM y el bot no pudo contestar.\",\"example\":{\"body_text\":[[\"Alumno\"]]}}]', 1, '2025-05-27 19:53:31', '2025-05-27 19:53:31'),
(1748194812767926, 'aviso_medicina', 'APPROVED', 'UTILITY', 'es_MX', '[{\"type\":\"BODY\",\"text\":\"Hola *{{1}}* \\ud83d\\udc4b futur@ Lince de *{{2}}* de la *Universidad del Valle de M\\u00e9xico campus Veracruz*\\ud83d\\ude3a, \\u00a1Bienvenid@!\\n\\n Para completar el proceso de inscripci\\u00f3n, *no olvides presentar tu examen de admisi\\u00f3n*\\ud83d\\udcdd\\n\\n Pr\\u00f3xima \\ud83d\\udcc5 fecha  de examen de admisi\\u00f3n es: *{{3}}*\\n\\n  Contacta al *Mtro. Arturo Cadenas Andrade* para confirmar tu asistencia y conocer la documentaci\\u00f3n requerida\\ud83d\\udcc2. Te esperamos! \\ud83d\\ude00\",\"example\":{\"body_text\":[[\"Alumno\",\"Programa\",\"Fecha\"]]}},{\"type\":\"FOOTER\",\"text\":\"Clic en el bot\\u00f3n para conocer los datos de contacto\"},{\"type\":\"BUTTONS\",\"buttons\":[{\"type\":\"QUICK_REPLY\",\"text\":\"Datos de contacto\"},{\"type\":\"QUICK_REPLY\",\"text\":\"Ficha de contacto\"}]}]', 1, '2025-05-23 00:22:37', '2025-05-27 19:53:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `whatsappwidgets`
--

CREATE TABLE `whatsappwidgets` (
  `id` varchar(10) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) NOT NULL,
  `header_text` varchar(191) NOT NULL,
  `header_subtext` varchar(191) NOT NULL,
  `widget_text` text NOT NULL,
  `button_text` varchar(191) NOT NULL,
  `widget_type` varchar(191) NOT NULL,
  `input_field_placeholder` varchar(191) DEFAULT NULL,
  `button_color` varchar(191) NOT NULL,
  `header_color` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_index` (`user_id`);

--
-- Indices de la tabla `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_country_id_foreign` (`country_id`),
  ADD KEY `contacts_company_id_foreign` (`company_id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `custom_contacts_fields`
--
ALTER TABLE `custom_contacts_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_contacts_fields_company_id_foreign` (`company_id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `custom_contacts_fields_contacts`
--
ALTER TABLE `custom_contacts_fields_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_contact_custom_field` (`contact_id`,`custom_contacts_field_id`),
  ADD KEY `custom_contacts_field_id` (`custom_contacts_field_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `flows`
--
ALTER TABLE `flows`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `groups_contacts`
--
ALTER TABLE `groups_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_contacts_group_id_foreign` (`group_id`),
  ADD KEY `groups_contacts_contact_id_foreign` (`contact_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_contact_id_foreign` (`contact_id`),
  ADD KEY `messages_company_id_foreign` (`company_id`),
  ADD KEY `messages_campaign_id_foreign` (`campaign_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_vendor_id_foreign` (`vendor_id`);

--
-- Indices de la tabla `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replies_company_id_foreign` (`company_id`),
  ADD KEY `fk_replies_flows` (`flow_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_plan_id_foreign` (`plan_id`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `wa_campaings`
--
ALTER TABLE `wa_campaings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wa_campaings_company_id_foreign` (`company_id`),
  ADD KEY `wa_campaings_template_id_foreign` (`template_id`),
  ADD KEY `wa_campaings_group_id_foreign` (`group_id`),
  ADD KEY `wa_campaings_contact_id_foreign` (`contact_id`);

--
-- Indices de la tabla `wa_templates`
--
ALTER TABLE `wa_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wa_templates_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `whatsappwidgets`
--
ALTER TABLE `whatsappwidgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `whatsappwidgets_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8569;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `custom_contacts_fields`
--
ALTER TABLE `custom_contacts_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `custom_contacts_fields_contacts`
--
ALTER TABLE `custom_contacts_fields_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15313;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `flows`
--
ALTER TABLE `flows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `groups_contacts`
--
ALTER TABLE `groups_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8814;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5764;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `plan`
--
ALTER TABLE `plan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `wa_campaings`
--
ALTER TABLE `wa_campaings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `wa_templates`
--
ALTER TABLE `wa_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7788675324554726;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `contacts_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `custom_contacts_fields`
--
ALTER TABLE `custom_contacts_fields`
  ADD CONSTRAINT `custom_contacts_fields_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Filtros para la tabla `custom_contacts_fields_contacts`
--
ALTER TABLE `custom_contacts_fields_contacts`
  ADD CONSTRAINT `custom_contacts_fields_contacts_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_custom_contacts_field_id` FOREIGN KEY (`custom_contacts_field_id`) REFERENCES `custom_contacts_fields` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Filtros para la tabla `groups_contacts`
--
ALTER TABLE `groups_contacts`
  ADD CONSTRAINT `groups_contacts_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_contacts_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `wa_campaings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `messages_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `companies` (`id`);

--
-- Filtros para la tabla `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `fk_replies_flows` FOREIGN KEY (`flow_id`) REFERENCES `flows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `replies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `users_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`);

--
-- Filtros para la tabla `wa_campaings`
--
ALTER TABLE `wa_campaings`
  ADD CONSTRAINT `wa_campaings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `wa_campaings_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `wa_campaings_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `wa_campaings_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `wa_templates` (`id`);

--
-- Filtros para la tabla `wa_templates`
--
ALTER TABLE `wa_templates`
  ADD CONSTRAINT `wa_templates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Filtros para la tabla `whatsappwidgets`
--
ALTER TABLE `whatsappwidgets`
  ADD CONSTRAINT `whatsappwidgets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
