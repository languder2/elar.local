-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MariaDB-11.2
-- Время создания: Июл 11 2024 г., 16:12
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
-- Структура таблицы `advisors`
--

CREATE TABLE `advisors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `advisors`
--

INSERT INTO `advisors` (`id`, `name`, `cnt`, `display`) VALUES
(1, 'advisor 1', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `name`, `cnt`, `display`) VALUES
(1, 'asdasddas', 0, 1),
(2, 'asdasd', 0, 1),
(3, 'Султан С.В.', 1, 1),
(4, 'Sultan SV', 0, 1),
(5, 'asd', 1, 1),
(6, 'yest', 1, 1),
(7, 'Test3', 1, 1),
(8, 'yte1', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

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
(4, 2, 'Коллекции', '/admin/collections', NULL, 'admin', 30, 0, 'false', '', '0'),
(5, 2, 'Типы публикаций', '/admin/types', NULL, 'admin', 40, 0, 'false', '', '1'),
(6, 0, 'Публикации', '/admin/publications', NULL, 'admin', 20, 0, 'false', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `authors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `advisor` varchar(255) DEFAULT NULL,
  `speciality` varchar(255) DEFAULT NULL,
  `pdf` text DEFAULT NULL,
  `fileName` text DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text NOT NULL,
  `section` int(11) DEFAULT NULL,
  `sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `type` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `publications`
--

INSERT INTO `publications` (`id`, `date`, `authors`, `name`, `advisor`, `speciality`, `pdf`, `fileName`, `tags`, `description`, `section`, `sections`, `type`, `display`) VALUES
(27, '2024-07-10', '[3,6]', 'zsadsa', 'Test 1', 'Test 1', 'publications/27_publication.pdf', '27_publication.pdf', '[4,5]', '<p>lkutjiglhpg,;</p>', 5, '[5]', 1, 1),
(29, '2024-07-11', '[5]', 'asd', 'asd', 'asd', 'Publications/29_publication.pdf', '29_publication.pdf', '[7]', '<p>asd</p>', 27, '[22,27]', 2, 1),
(30, '2024-07-11', '[7,8]', 'test 3', '[1]', 'test 7', 'publications/30_publication.pdf', '30_publication.pdf', '[8,9]', '<p>asdasd</p>', 19, '[5,19]', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

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
(5, 'Агротехнологический факультет', 0, '', 1000, 1, 2),
(6, 'Технический факультет', 0, '', 1000, 1, 0),
(7, 'Кафедра \"Технические системы в АПК\"', 6, '', 1000, 1, 0),
(8, 'Кафедра \"Детали машин и технология конструкционных материалов\" ', 6, '', 1000, 1, 0),
(9, 'Кафедра \"Инженерная механика\" ', 6, '', 1000, 1, 0),
(10, 'Кафедра \"Информационные технологии имени профессора В.М. Найдыша\" ', 6, '', 1000, 1, 0),
(11, 'Кафедра \"Электротехника и электромеханика\" ', 6, '', 1000, 1, 0),
(12, 'Кафедра \"Электроэнергетика\" имени профессора И.П. Назаренко ', 6, '', 1000, 1, 0),
(13, 'Факультет \"Управление, экономика и право\"', 0, '', 1000, 1, 0),
(14, 'Кафедра \"Менеджмент\"', 13, '', 1000, 1, 0),
(15, 'Кафедра \"Экономика\" ', 13, '', 1000, 1, 0),
(16, 'Кафедра \"Финансы и учёт\"', 13, '', 1000, 1, 0),
(17, 'Кафедра \"Юриспруденция (Право)\"', 13, '', 1000, 1, 0),
(18, 'Кафедра \"Растениеводство имени профессора В.В. Калитки\" ', 5, '', 1000, 1, 0),
(19, 'Кафедра \"Пищевые технологии и сфера услуг\" ', 5, '', 1000, 1, 1),
(20, 'Кафедра \"Оборудование пищевых и перерабатывающих производств\"', 5, '', 1000, 1, 0),
(21, 'Кафедра \"Гражданская безопасность\"', 5, '', 1000, 1, 0),
(22, 'Гуманитарно-педагогический факультет', 0, '', 1000, 1, 1),
(23, 'Кафедра \"Дошкольное и специальное образования\"', 22, '', 1000, 1, 0),
(24, 'Кафедра «Начальное образование»', 22, '', 1000, 1, 0),
(25, 'Кафедра «Психология»', 22, '', 1000, 1, 0),
(26, 'Кафедра «Социальная работа и социальная педагогика»', 22, '', 1000, 1, 0),
(27, 'Кафедра «Музыкальное и хореографическое образование»', 22, '', 1000, 1, 1),
(28, 'Кафедра «Философия и управление образованием»', 22, '', 1000, 1, 0),
(29, 'Кафедра «История»', 22, '', 1000, 1, 0),
(30, 'Кафедра «Физическая культура и спорт»', 22, '', 1000, 1, 0),
(31, 'Факультет естественных наук', 0, '', 1000, 1, 0),
(32, 'Кафедра «Химия и химическое образование»', 31, '', 1000, 1, 0),
(33, 'Кафедра «Биология и биологическое образование»', 31, '', 1000, 1, 0),
(34, 'Кафедра «Экология и природопользование»', 31, '', 1000, 1, 0),
(35, 'Кафедра «Географическое образование и лесное дело»', 31, '', 1000, 1, 0),
(36, 'Кафедра «Иностранные языки»', 31, '', 1000, 1, 0),
(37, 'Кафедра «Русский язык и литература»', 31, '', 1000, 1, 0),
(38, 'Кафедра «Высшая математика, физика и методика преподавания физико-математических дисциплин»', 31, '', 1000, 1, 0),
(39, 'Кафедра «Здравоохранение и общественное здоровье»', 31, '', 1000, 1, 0),
(40, 'Монографии', 0, '', 1000, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`, `cnt`, `display`) VALUES
(1, 'asdas asd asd', 0, 1),
(2, 'asdas asd', 0, 1),
(3, '123', 0, 1),
(4, 'tag', 1, 1),
(5, 'tag 2', 1, 1),
(6, 'asdd', 0, 1),
(7, 'asd', 1, 1),
(8, 'teg 5', 1, 1),
(9, 'tes7', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT 0,
  `name` varchar(256) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `def` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id`, `cnt`, `name`, `display`, `def`) VALUES
(1, 2, 'Статья', '1', 0),
(2, 1, 'Учебник', '1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

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
(2, 'redactor', '$2y$10$cHKpA531UJPA43oPFXxpyujtupAXMpRTTfCm5vO7XhlzLzbY2LA2K', 'Приемная комиссия', 'admin', '1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
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
-- Индексы таблицы `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
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
-- AUTO_INCREMENT для таблицы `advisors`
--
ALTER TABLE `advisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT для таблицы `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
