-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MariaDB-11.2
-- Время создания: Июл 08 2024 г., 16:29
-- Версия сервера: 11.2.2-MariaDB
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `elar`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `fio` varchar(200) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `fio`, `cnt`) VALUES
(1, 'Sultan SV', 0),
(2, 'test', 0),
(3, 'asdasd', 0),
(4, 'Чебанов А.Б', 0),
(5, 'Ko', 0),
(6, 'Чебнов', 0),
(7, '[\"\\u0427\\u0435\\u0431\\u043d\\u043e\\u0432\"]', 0),
(8, '[\"\\u043f\\u0440\\u0438\\u0432\\u0435\\u04422\"]', 0),
(9, '[\"\\u043f\\u0440\\u0438\\u0432\\u0432\\u0435\\u0442\"]', 0),
(10, 'привет', 0),
(11, 'прифыв фыфывфы', 0),
(12, '[\"\\u043f\\u0440\\u0438\\u0444\\u044b\\u0432 \\u0444\\u044b\\u0444\\u044b\\u0432\\u0444\\u044b\"]', 0),
(13, 'паривет', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `cnt` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `collections`
--

INSERT INTO `collections` (`id`, `cnt`, `title`, `description`, `display`) VALUES
(1, 4, 'collection 1', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(200) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `op` varchar(200) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `external` tinyint(1) NOT NULL DEFAULT 0,
  `newTab` enum('true','false') DEFAULT 'false',
  `comment` text NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `parent`, `name`, `link`, `op`, `section`, `sort`, `external`, `newTab`, `comment`, `display`) VALUES
(1, 0, 'Выход', 'admin/exit/', NULL, 'admin', 100, 0, 'false', '', '1'),
(2, 0, 'Справочники', '/admin/', NULL, 'admin', 40, 0, 'false', '', '1'),
(3, 2, 'Разделы', '/admin/sections', NULL, 'admin', 10, 0, 'false', '', '1'),
(4, 2, 'Коллекции', '/admin/collections', NULL, 'admin', 30, 0, 'false', '', '1'),
(5, 2, 'Источники', '/admin/Types', NULL, 'admin', 40, 0, 'false', '', '1'),
(6, 0, 'Публикации', '/admin/Publications', NULL, 'admin', 20, 0, 'false', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `Publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `authors` longtext CHARACTER SET cp1251 COLLATE cp1251_general_ci DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `supervisor` varchar(200) DEFAULT NULL,
  `speciality` varchar(200) DEFAULT NULL,
  `pdf` text DEFAULT NULL,
  `fileName` text DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text NOT NULL,
  `section` int(11) DEFAULT NULL,
  `sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `collections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `source` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Publications`
--

INSERT INTO `publications` (`id`, `date`, `authors`, `name`, `supervisor`, `speciality`, `pdf`, `fileName`, `tags`, `description`, `section`, `sections`, `collections`, `source`, `display`) VALUES
(1, '2024-07-08', '[\"Sultan SV\",\"test\"]', 'azsdasd', '', '', 'Publications/1_38-46.pdf', '38-46.pdf', '[\"asdasd\",\"asd a\"]', '<p>asdasdas&nbsp;</p>', 2, '[\"1\",\"2\"]', '[\"1\"]', 1, 1),
(2, '2024-07-08', '[\"Sultan SV\",\"test\"]', 'azsdasd', NULL, NULL, 'Publications/2_38-46.pdf', '38-46.pdf', '[\"asdasd\",\"asd a\"]', '<p>asdasdas&nbsp;</p>', 1, '[\"1\"]', '[\"1\"]', 1, 1),
(3, '2024-07-08', '[\"Sultan SV\",\"test\"]', 'azsdasd', NULL, NULL, 'Publications/3_38-46.pdf', '38-46.pdf', '[\"asdasd\",\"asd a\"]', '<p>asdasdas&nbsp;</p>', 1, '[\"1\"]', '[\"1\"]', 1, 1),
(6, '2024-07-08', '[\"\\u043f\\u0430\\u0440\\u0438\\u0432\\u0435\\u0442\"]', 'фывфывфыфыв', 'явыфывфы', 'явыфывфы', 'Publications/6_NJD_78_(2).pdf', 'NJD_78_(2).pdf', '[\"\\u0442\\u0435\\u0433 1\",\"\\u0442\\u0435\\u04333\"]', '<p>фывфыв</p>', 2, '[\"1\",\"2\"]', '[\"1\"]', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 1000,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `cnt` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `name`, `parent`, `description`, `sort`, `display`, `cnt`) VALUES
(1, 'section 1', 0, '', 1000, 1, 4),
(2, 'subsection', 1, '', 1000, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `Types`
--

DROP TABLE IF EXISTS `sources`;
CREATE TABLE `sources` (
  `id` int(11) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Types`
--

INSERT INTO `sources` (`id`, `cnt`, `title`, `description`, `display`) VALUES
(1, 4, 'source 1', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `fio` varchar(255) DEFAULT NULL,
  `perm` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `fio`, `perm`, `status`) VALUES
(1, 'admin', '$2y$10$G7I7Gh9yEznkixKYierDTeslq0cVkFeSi89VbEjc5YW8warI.BzKq', 'Султан Сергей Викторович', 'admin', '1'),
(2, 'manager', '$2y$10$uubvKBZkTxReYrEakBs4BOflg/h5cMTlmIbFxo1tOdZsICSBQ9DkC', 'Приемная комиссия', 'admin', '1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Types`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `Types`
--
ALTER TABLE `sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
