-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 11 2024 г., 14:50
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `id_address` int(10) NOT NULL,
  `index_num` int(6) NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settlement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house` int(4) NOT NULL,
  `corpus` int(11) DEFAULT NULL,
  `liter` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id_address`, `index_num`, `country`, `region`, `settlement`, `district`, `street`, `house`, `corpus`, `liter`, `flat`) VALUES
(1, 450000, 'Russia', 'Bashkortostan', 'Ufa', 'Leninskiy', 'lenina', 15, NULL, NULL, 25),
(2, 450000, 'Russia', 'Bashkortostan', 'Ufa', 'Kalininskiy', 'Ferina', 65, NULL, NULL, 205),
(3, 450000, 'Russia', 'Bashkortostan', 'Ufa', 'Kalininskiy', 'Oktyabr', 110, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id_color` int(2) NOT NULL,
  `color_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id_color`, `color_name`) VALUES
(1, 'белый'),
(2, 'красный'),
(3, 'синий'),
(4, 'зелёный'),
(5, 'жёлтый'),
(6, 'чёрный'),
(7, 'розовый'),
(8, 'фиолетовый'),
(9, 'голубой'),
(10, 'оранжевый');

-- --------------------------------------------------------

--
-- Структура таблицы `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(10) NOT NULL,
  `userName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userLastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userSurname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `INN` int(12) DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_salt` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_address` int(20) NOT NULL,
  `pup_address` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `customer`
--

INSERT INTO `customer` (`id_customer`, `userName`, `userLastName`, `userSurname`, `birthdate`, `passport`, `INN`, `tel`, `email`, `password`, `password_salt`, `home_address`, `pup_address`) VALUES
(1, 'Иван', NULL, NULL, '2013-12-10', NULL, NULL, '89177412589', 'hisemail@ex.com', 'pswd', 'word', 2, 1),
(2, 'Сергей', NULL, NULL, NULL, NULL, NULL, '89178521478', '123@nbh.com', 'kjhgf', 'salt', 2, 1),
(3, 'Люда', NULL, NULL, NULL, NULL, NULL, '89171234567', 'pochta@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(4, 'user', NULL, NULL, NULL, NULL, NULL, '89171234567', 'user@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(5, 'lila', NULL, NULL, NULL, NULL, NULL, '', 'lila@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(6, 'jane', NULL, NULL, NULL, NULL, NULL, '7(987)654-32-10', 'jane@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(7, 'max', NULL, NULL, NULL, NULL, NULL, '7(987)654-32-11', 'max@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(8, 'maxim', NULL, NULL, NULL, NULL, NULL, '7(987)654-32-22', 'maxim@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(9, 'Maxim', NULL, NULL, NULL, NULL, NULL, '7(987)654-32-22', 'maxim@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(10, 'john', NULL, NULL, NULL, NULL, NULL, '+7(987)654-32-10', 'john@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(11, 'lida', NULL, NULL, NULL, NULL, NULL, '+7(987)654-32-77', 'lida@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(12, 'Lida', NULL, NULL, NULL, NULL, NULL, '+7(987)654-32-77', 'lida@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(13, 'rima', NULL, NULL, NULL, NULL, NULL, '+7(987)654-32-77', 'rima@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1),
(14, 'rita', NULL, NULL, NULL, NULL, NULL, '+7(987)654-32-88', 'rita@mail.ru', '202cb962ac59075b964b07152d234b70', 'salt', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `customer_carts`
--

CREATE TABLE `customer_carts` (
  `id_customer` int(10) NOT NULL,
  `id_product` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_types`
--

CREATE TABLE `delivery_types` (
  `id_delivery_type` int(2) NOT NULL,
  `delivery_type_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `delivery_types`
--

INSERT INTO `delivery_types` (`id_delivery_type`, `delivery_type_name`) VALUES
(1, 'ПВЗ'),
(2, 'курьером');

-- --------------------------------------------------------

--
-- Структура таблицы `gender_types`
--

CREATE TABLE `gender_types` (
  `id_gender` int(2) NOT NULL,
  `gender_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gender_types`
--

INSERT INTO `gender_types` (`id_gender`, `gender_name`) VALUES
(1, 'женский'),
(2, 'мужской'),
(3, 'девочки'),
(4, 'мальчики');

-- --------------------------------------------------------

--
-- Структура таблицы `material_types`
--

CREATE TABLE `material_types` (
  `id_material` int(4) NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `material_types`
--

INSERT INTO `material_types` (`id_material`, `material_name`) VALUES
(1, 'шёлк'),
(2, 'шерсть'),
(3, 'хлопок'),
(4, 'полиэстер');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int(10) NOT NULL,
  `id_customer` int(10) NOT NULL,
  `amount` float NOT NULL,
  `order_date` timestamp(6) NOT NULL,
  `payment_status` int(2) NOT NULL,
  `payment_type` int(2) NOT NULL,
  `delivery_status` int(2) NOT NULL,
  `delivery_type` int(2) NOT NULL,
  `id_address` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE `order_products` (
  `id_order` int(10) NOT NULL,
  `id_product` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_type`
--

CREATE TABLE `payment_type` (
  `id_payment_type` int(2) NOT NULL,
  `payment_type_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `payment_type`
--

INSERT INTO `payment_type` (`id_payment_type`, `payment_type_name`) VALUES
(1, 'оплата картой'),
(2, 'наличными');

-- --------------------------------------------------------

--
-- Структура таблицы `pick_up_points`
--

CREATE TABLE `pick_up_points` (
  `id_point` int(10) NOT NULL,
  `id_address` int(10) NOT NULL,
  `schedule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pick_up_points`
--

INSERT INTO `pick_up_points` (`id_point`, `id_address`, `schedule`) VALUES
(1, 3, 'пн-пт 9:00 - 21:00\r\nсб 10:00 - 18:00\r\nвс - выходной');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id_product` int(10) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked` int(2) NOT NULL DEFAULT '0',
  `add_date` timestamp NOT NULL,
  `update_date` timestamp NOT NULL,
  `id_gender` int(2) NOT NULL,
  `id_category` int(4) NOT NULL,
  `id_material` int(2) NOT NULL,
  `id_color` int(2) NOT NULL,
  `id_size` int(3) NOT NULL,
  `elements_count` int(2) NOT NULL DEFAULT '1',
  `store_count` int(10) NOT NULL,
  `price` float NOT NULL,
  `sale` int(3) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `artikul_store` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artikul_manufacture` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_manufacture` int(10) DEFAULT NULL,
  `make_date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `blocked`, `add_date`, `update_date`, `id_gender`, `id_category`, `id_material`, `id_color`, `id_size`, `elements_count`, `store_count`, `price`, `sale`, `new`, `product_description`, `artikul_store`, `artikul_manufacture`, `id_manufacture`, `make_date`, `exp_date`) VALUES
(1, 'платье', 0, '2024-02-24 23:53:14', '2024-02-24 23:53:14', 1, 1, 3, 7, 3, 1, 10, 1400, 0, 1, 'Облегающий крой\r\nС-образная горловина\r\nКороткий рукав\r\nПараметры:- грудь: 85 см- талия: 61 см- бёдра: 92 см', '', '', 0, '', ''),
(2, 'куртка', 0, '2024-02-24 23:53:50', '2024-02-24 23:53:50', 2, 1, 4, 2, 8, 1, 5, 2100, 0, 1, 'Regular Fit\r\nЗастежка на молнию\r\nДва боковых кармана\r\nУтеплитель - синтетический пух\r\nДлина изделия от плеча - 72.2 см для размера L\r\nПлотность утеплителя - 300 g/m2', NULL, NULL, NULL, NULL, NULL),
(3, 'брюки', 0, '2024-03-13 15:50:56', '2024-03-13 15:50:56', 2, 1, 3, 6, 4, 1, 5, 1000.5, 0, 1, 'Классические мужские брюки незаменимая вещь в гардеробе мужчины. Мужские брюки зауженные одна из самых трендовых позиций 2023 года благодаря своей универсальности. Изготовленные из плотного высококачественного хлопка, они легкие и приятные на ощупь, позволяют коже дышать и не сковывают движений. Мужские брюки это универсальная модель базового гардероба . Подойдут как подросткам, школьникам, студентам, так и в офис, на праздник, в гости и на свидание. Отличный повседневный вариант. Трендовые мужские брюки создадут стильный современный образ. Их по достоинству оценили те, кто предпочитает офисный, городской, классический и спортивный стиль в одежде. Стильный дизайн в сочетании с высокой функциональностью делает эти брюки неотъемлемой частью гардероба любого модного и практичного мужчины!', '123', '321', 1, '', ''),
(4, 'шапка', 0, '2024-01-22 07:36:29', '2024-01-22 07:36:29', 1, 1, 3, 1, 4, 1, 7, 500, 0, 1, 'шапка описание', '1234', '4321', 1, 'make_date', 'exp_date'),
(5, 'шапка', 0, '2024-01-22 07:36:47', '2024-01-22 07:36:47', 1, 1, 3, 2, 5, 1, 7, 500, 0, 1, 'шапка описание', '1234', '4321', 1, 'make_date', 'exp_date'),
(6, 'футболка', 0, '2024-03-13 15:54:24', '2024-03-13 15:54:24', 4, 1, 3, 3, 16, 1, 20, 450, 0, 1, 'Теплый и уютный, высококачественный трикотаж из хлопка, согреет в холодные дни в весенний летний период и идеально подойдет для создания стильного образа в повседневной жизни. Мягкий качественный материал футер, не деформируется при стирке, обеспечит комфорт на протяжении всего дня. Благодаря свободному крою, школьная кофта оверсайз не сковывает движения и станет любимым элементом гардероба. Детский свитшот прекрасно сочетается со спортивными брюками. Благодаря своему универсальному дизайну, кофта в школу легко сочетается с любыми предметами гардероба, что позволит вашей дочери или сыну выглядеть стильно и модно каждый день, а особенно в школьные будни.', '', '', 0, '', ''),
(7, 'футболка', 0, '2024-03-13 15:57:25', '2024-03-13 15:57:25', 4, 1, 3, 10, 22, 1, 20, 450, 0, 1, 'Особенностью этого худи является капюшон со шнурками, который становится отличным дополнением к стильному образу. Рукава с мягкими манжетами. Представлен в двух расцветках. Размеры можно подобрать как для детей среднего школьного возраста, так и для подростков. Спортивную кофту с капюшоном можно носить в повседневной жизни, а также дополнить им свой образ в школе, создав стильный молодежный образ.', '', '', 0, '', ''),
(8, 'носки', 0, '2024-01-22 07:17:29', '2024-01-27 06:27:40', 4, 1, 3, 6, 15, 2, 4, 105, 0, 1, 'носки описание', '', '', 0, '', ''),
(9, 'шарф', 0, '2024-01-22 07:37:59', '2024-01-22 07:37:59', 1, 1, 4, 1, 8, 1, 6, 200, 0, 1, 'шарф описание', '', '', 0, '', ''),
(10, 'брюки', 0, '2024-03-13 16:03:11', '2024-03-13 16:03:11', 3, 1, 2, 10, 10, 1, 7, 350, 0, 1, 'Джинсы палаццо черные - комфортный и практичный вариант для ежедневного использования. Удачная модель для Вашей модницы.', '', '', 0, '', ''),
(11, 'Женская блузка', 0, '2024-03-13 15:34:45', '2024-03-13 15:34:45', 1, 1, 1, 5, 1, 1, 9, 950, 0, 1, 'Женская блузка  станет универсальной вещью в Вашем гардеробе! Модель полуприлегающего кроя, рукава 3/4, с округлым вырезом и застежками по рукавам в виде пуговиц. Состав - хлопок 100%, материал - пике. Подойдет для офиса, учебы, повседневной носки, а также беременным. В нашей блузке Вы будете выглядеть бесподобно!', '', '', 0, '', ''),
(12, 'платье', 0, '2024-03-13 15:41:46', '2024-03-13 15:41:46', 1, 1, 1, 8, 1, 1, 9, 950, 0, 1, 'Модель универсальная, ее можно носить на работу как платье женское офисное, или платье женское повседневное. Платье пошито из современной ткани премиум-класса «ангора». Платье трикотажное в рубчик приятное к телу, плотное, не просвечивает, гладкое и легкое на ощупь, мягкое и эластичное, износостойкое, выдерживает много стирок, ткань не садится, не меняет форму. Платье уютное трикотажное полуприлегающего силуэта с горловиной лодочка, которая выгодно подчеркивает украшения на шее и концентрирует акцент на красоту женской груди. Платье женское повседневное не вызывает аллергических реакций на коже за счет современного экологичного материала, «дышащая» ткань обладает отличной теплопроводностью. ', '', '', 0, '', ''),
(13, 'футболка', 0, '2024-03-13 16:06:58', '2024-03-13 16:06:58', 2, 1, 2, 4, 9, 1, 8, 250, 0, 1, 'Изделие выполнено из трикотажа джерси. Мягкий материал хорошо пропускает воздух и поддерживает нужную температуру тела. \r\nRegular — это классический крой, который впишется в любую ситуацию и подойдёт всем. Футболка садится по фигуре и имеет четкие линии, которые обрамляют силуэт. \r\nСочетайте футболку со спортивными шортами для занятий спортом или широкими джинсами для вечерних прогулок. Для офиса и учебы это отличный нижний слой под джемпер или рубашку. \r\nДетали: прямой крой Regular, круглый вырез горловины, короткий рукав.', '', '', 0, '', ''),
(14, 'рубашка', 0, '2024-03-13 16:10:42', '2024-03-13 16:10:42', 4, 1, 4, 3, 21, 1, 9, 450, 10, 1, 'Рубашка в клетку изготовлена из высококачественного хлопка и кашемира, что обеспечивает комфорт и тепло даже в прохладные вечера. Приталенный крой подчеркивает фигуру и придает стильный вид.\r\nРубашка не колется, не мнется и легко гладится. Застежки выполнены в виде кнопок. Она устойчива к стирке и износу.\r\nБлагодаря своему универсальному дизайну, рубашка теплая и легко комбинируется с другими предметами гардероба, позволяя создавать различные стильные и модные образы. Теплая рубашка в клетку идеально подходит для повседневной носки, деловых встреч и особых случаев, гарантируя комфорт, стиль и надежность.', '', '', 0, '', ''),
(15, 'рубашка', 0, '2024-04-02 11:03:10', '2024-04-02 11:03:10', 2, 1, 4, 1, 9, 1, 15, 520, 10, 1, 'рубашка мужская белая', '', '', 0, '', ''),
(16, 'кепка', 0, '2024-04-02 11:14:24', '2024-04-02 12:37:31', 4, 1, 3, 7, 22, 1, 2, 250, 0, 1, 'кепка розовая для девочек', '', '', 0, '', ''),
(17, 'футболка', 1, '2024-04-02 11:32:07', '2024-04-02 11:32:07', 4, 1, 3, 3, 15, 1, 5, 350, 0, 1, 'футболка синяя для мальчика', '', '', 0, '', ''),
(18, 'футболка', 0, '2024-04-02 11:35:46', '2024-04-02 11:35:46', 4, 1, 3, 3, 15, 1, 5, 350, 0, 1, 'футболка синяя для мальчика', '', '', 0, '', ''),
(19, 'пальто', 0, '2024-04-02 11:37:43', '2024-04-02 11:37:43', 1, 1, 2, 8, 6, 1, 5, 1150, 0, 1, 'Пальто женское шерстяное фиолетовое', '', '', 0, '', ''),
(20, 'куртка', 0, '2024-04-02 11:51:54', '2024-04-02 11:51:54', 2, 1, 4, 6, 11, 1, 10, 1500, 0, 1, 'куртка мужская черная с капюшоном', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `id_category` int(4) NOT NULL,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`id_category`, `category_name`) VALUES
(1, 'одежда'),
(2, 'обувь'),
(3, 'аксессуары');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `customer_id` int(10) NOT NULL,
  `date_create` timestamp NOT NULL,
  `date_delete` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`customer_id`, `date_create`, `date_delete`, `token`) VALUES
(11, '2024-04-03 04:49:41', NULL, 'fb31a87c764adf4e41741391161bbcdf'),
(12, '2024-04-03 05:04:58', NULL, '057751d1a7fa16d5c01a65a04a78c7b5'),
(13, '2024-04-03 05:05:54', NULL, '1cdb58ca62d945f0b439eedb150c9983'),
(14, '2024-04-03 10:39:04', NULL, 'f08a19886cc708e8d57786764b7555b2'),
(10, '2024-04-04 11:04:03', NULL, '129c860153ea3e8be442af2498b637c4'),
(11, '2024-04-04 11:08:42', NULL, 'af12694c916edeb71d763ccbcafeb907'),
(6, '2024-04-09 10:10:37', NULL, '19ca2c8723bed1a04417ffb876846f93'),
(6, '2024-04-09 10:13:45', NULL, '8b2823a9c894b6e168c6cde9ea059fae'),
(10, '2024-04-09 10:19:24', NULL, 'ef5d80de381831cdc35abf0dd2d25aac'),
(10, '2024-04-09 10:19:44', NULL, '0e2b743e26b929c6b785a839f51369a9'),
(10, '2024-04-09 10:20:15', NULL, 'f38ab5c99979269c0b9cdda4b672093a'),
(10, '2024-04-09 10:26:17', NULL, 'ff7bda4c5209b2d560382437e0fcbe2c'),
(10, '2024-04-09 10:27:29', NULL, '7f9b532a4134d3f5346c73c725dfe10b'),
(10, '2024-04-09 10:29:31', NULL, '9f43ff8cce950e6794fe7c063c816f5a'),
(6, '2024-04-09 10:30:29', NULL, 'dc4d1ad4cb92b4dac001dbe255ab4589'),
(6, '2024-04-09 10:31:13', NULL, 'a4114a3e6aa85660b69c89f8d9e7deb6'),
(6, '2024-04-09 10:34:02', NULL, '7d6b5acb785208c78b5f8f17ea8b8eda');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id_size` int(3) NOT NULL,
  `size_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id_size`, `size_name`) VALUES
(1, '40'),
(2, '42'),
(3, '44'),
(4, '46'),
(5, '48'),
(6, '50'),
(7, '52'),
(8, '54'),
(9, '56'),
(10, '58'),
(11, '60'),
(12, '62'),
(13, '50 см'),
(14, '56 см'),
(15, '62 см'),
(16, '68 см'),
(17, '74 см'),
(18, '80 см'),
(19, '86 см'),
(20, '90 см'),
(21, '92 см'),
(22, '98 см');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `userName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userSurname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` int(1) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `userName`, `userSurname`, `gender`, `email`, `tel`, `password`, `avatar`) VALUES
(1, 'user1', NULL, 1, 'user1@mail.ru', '89876543210', 'd41d8cd98f00b204e9800998ecf8427e', NULL),
(2, 'user', NULL, 1, 'user@mail.ru', '89171234567', '202cb962ac59075b964b07152d234b70', NULL),
(3, 'user2', NULL, 1, 'user2@mail.ru', '89876543210', '202cb962ac59075b964b07152d234b70', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id_address`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`);

--
-- Индексы таблицы `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD KEY `home_address` (`home_address`),
  ADD KEY `pup_address` (`pup_address`);

--
-- Индексы таблицы `customer_carts`
--
ALTER TABLE `customer_carts`
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `delivery_types`
--
ALTER TABLE `delivery_types`
  ADD PRIMARY KEY (`id_delivery_type`);

--
-- Индексы таблицы `gender_types`
--
ALTER TABLE `gender_types`
  ADD PRIMARY KEY (`id_gender`);

--
-- Индексы таблицы `material_types`
--
ALTER TABLE `material_types`
  ADD PRIMARY KEY (`id_material`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `payment_type` (`payment_type`),
  ADD KEY `delivery_type` (`delivery_type`);

--
-- Индексы таблицы `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id_payment_type`);

--
-- Индексы таблицы `pick_up_points`
--
ALTER TABLE `pick_up_points`
  ADD PRIMARY KEY (`id_point`),
  ADD KEY `id_address` (`id_address`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_gender` (`id_gender`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_compound` (`id_material`),
  ADD KEY `id_color` (`id_color`),
  ADD KEY `product_size` (`id_size`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD KEY `sessions_ibfk_1` (`customer_id`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id_size`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender` (`gender`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id_address` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `delivery_types`
--
ALTER TABLE `delivery_types`
  MODIFY `id_delivery_type` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `gender_types`
--
ALTER TABLE `gender_types`
  MODIFY `id_gender` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id_payment_type` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `pick_up_points`
--
ALTER TABLE `pick_up_points`
  MODIFY `id_point` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id_size` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `customer_carts`
--
ALTER TABLE `customer_carts`
  ADD CONSTRAINT `customer_carts_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `customer_carts_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_type`) REFERENCES `payment_type` (`id_payment_type`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`delivery_type`) REFERENCES `delivery_types` (`id_delivery_type`);

--
-- Ограничения внешнего ключа таблицы `pick_up_points`
--
ALTER TABLE `pick_up_points`
  ADD CONSTRAINT `pick_up_points_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `addresses` (`id_address`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_gender`) REFERENCES `gender_types` (`id_gender`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `product_category` (`id_category`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`id_material`) REFERENCES `material_types` (`id_material`),
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`id_color`) REFERENCES `colors` (`id_color`),
  ADD CONSTRAINT `product_ibfk_5` FOREIGN KEY (`id_size`) REFERENCES `sizes` (`id_size`);

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id_customer`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`gender`) REFERENCES `gender_types` (`id_gender`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
