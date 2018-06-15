-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2018 at 09:45 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concept_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addCustomerLoad` (IN `pr_customer_profile_id` INTEGER(10), IN `pr_new_balance` DECIMAL(7,2), IN `pr_added_balance` DECIMAL(7,2))  BEGIN

	UPDATE customer_topups
    SET balance = pr_new_balance
    WHERE customer_profile_id = pr_customer_profile_id;
    
    INSERT INTO topup_transactions(customer_profile_id, amount, type)
    VALUES (pr_customer_profile_id, pr_added_balance, '1');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addItemToCart` (IN `pr_customer_profile_id` INTEGER(10), IN `pr_product_id` INTEGER(10), IN `pr_quantity` INTEGER(10))  BEGIN

	INSERT INTO customer_carts(customer_profile_id, product_id, quantity)
    VALUES (pr_customer_profile_id, pr_product_id, pr_quantity);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addToDeliveryItems` (IN `pr_delivery_id` INTEGER(10), IN `pr_product_id` INTEGER(10), IN `pr_quantity` INTEGER(10), IN `pr_price` DECIMAL(7,2))  BEGIN

	INSERT INTO delivery_items(delivery_id, product_id, quantity, price)
    VALUES (pr_delivery_id, pr_product_id, pr_quantity, pr_price);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `authenticateCustomerProfile` (IN `pr_email` VARCHAR(191), IN `pr_password` VARCHAR(191))  BEGIN

	SELECT customer_profiles.id AS profile_id, customer_profiles.first_name, customer_profiles.last_name
    FROM customer_profiles
    JOIN users
    ON customer_profiles.user_id = users.id
    WHERE users.email = pr_email AND users.password = pr_password;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkEmailAvailability` (IN `pr_email` VARCHAR(191))  BEGIN

	SELECT email
    FROM users WHERE email=pr_email;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkItemInCart` (IN `pr_cart_product_id` INT(10), IN `pr_customer_profile_id` INT(10))  BEGIN

	SELECT customer_carts.id, customer_carts.quantity, products.stock
    FROM customer_carts
    JOIN products
    ON products.id = customer_carts.product_id
    WHERE customer_carts.product_id = pr_cart_product_id
    AND customer_carts.customer_profile_id = pr_customer_profile_id
    AND customer_carts.isActive = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createDeliveryReference` (IN `pr_customer_profile_id` INT(10), IN `pr_contact_person` VARCHAR(191), IN `pr_location` VARCHAR(191), IN `pr_contact_number` VARCHAR(11), IN `pr_payment_type` VARCHAR(1), IN `pr_added` TIMESTAMP, IN `pr_arrival_time` TIMESTAMP)  BEGIN
	
    INSERT INTO deliveries(customer_profile_id, contact_person, location, contact_number, payment_type, added, arrival_date)
    VALUES (pr_customer_profile_id, pr_contact_person, pr_location, pr_contact_number, pr_payment_type, pr_added, pr_arrival_time);
    
    SELECT LAST_INSERT_ID() as delivery_id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteFromCart` (IN `pr_cart_id` INT(10))  BEGIN

	UPDATE customer_carts
    SET isActive = '0'
    WHERE id = pr_cart_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllProducts` ()  BEGIN

SELECT products.id, products.name, products.stock, products.price, shop_profiles.shop_name, product_pictures.image_location
    FROM products 
    JOIN shop_profiles 
    ON shop_profiles.id = products.shop_profile_id 
    JOIN product_pictures 
    ON product_pictures.product_id = products.id 
    WHERE product_pictures.image_location LIKE '%_0.%'
    ORDER BY products.id DESC ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartCount` (IN `pr_customer_profile_id` INT(10))  BEGIN

	SELECT COUNT(id) AS cart_items
    FROM customer_carts
    WHERE customer_profile_id = pr_customer_profile_id
    AND isActive = '1';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartItemsInformation` (IN `pr_customer_profile_id` INT(10))  BEGIN

	SELECT customer_carts.id AS cart_id, products.id AS product_id, products.price, products.name, shop_profiles.shop_name, customer_carts.quantity,
    products.stock, product_pictures.image_location
    FROM customer_carts
    JOIN products
    ON products.id = customer_carts.product_id
    JOIN shop_profiles
    ON shop_profiles.id = products.shop_profile_id
    JOIN product_pictures
    ON product_pictures.product_id = products.id 
    WHERE product_pictures.image_location LIKE '%_0.%'
    AND customer_carts.customer_profile_id = pr_customer_profile_id
AND customer_carts.isActive = '1'
ORDER BY customer_carts.id DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCurrentBalance` (IN `pr_customer_profile_id` INTEGER(10))  BEGIN

	SELECT balance
    FROM customer_topups
    WHERE customer_profile_id = pr_customer_profile_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDeliveryItems` (IN `pr_customer_profile_id` INT(10))  BEGIN

	SELECT products.name, shop_profiles.shop_name, delivery_items.quantity, delivery_items.price, product_pictures.image_location, delivery_items.status, deliveries.added, deliveries.arrival_date
    FROM deliveries
    JOIN delivery_items
    ON delivery_items.delivery_id = deliveries.id
    JOIN products
    ON delivery_items.product_id = products.id
    JOIN product_pictures
    ON products.id = product_pictures.product_id
    JOIN shop_profiles
    ON shop_profiles.id = products.shop_profile_id
    WHERE deliveries.customer_profile_id = pr_customer_profile_id
    AND product_pictures.image_location LIKE '%_0%';

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getLoadTransactions` (IN `pr_customer_profile_id` INTEGER(10))  BEGIN

	SELECT * FROM topup_transactions
    WHERE customer_profile_id = pr_customer_profile_id
    ORDER BY transaction_date DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductImageAddresses` (IN `pr_product_id` INTEGER(10))  BEGIN

	SELECT image_location
	FROM product_pictures
    WHERE product_id = pr_product_id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductInformation` (IN `pr_product_id` INTEGER(10))  BEGIN

	SELECT products.name, products.description, products.price, products.stock, shop_profiles.shop_name
    FROM products
    JOIN shop_profiles
    ON products.shop_profile_id = shop_profiles.id
    WHERE products.id = pr_product_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductViewProducts` (IN `pr_customer_profile_id` INT(10))  BEGIN

	SELECT products.id, products.name, products.price, shop_profiles.shop_name, product_pictures.image_location
    FROM products 
    JOIN customer_profiles 
    ON (customer_profiles.gender = products.gender OR products.gender = 'U') 
    JOIN shop_profiles 
    ON shop_profiles.id = products.shop_profile_id 
    JOIN product_pictures 
    ON product_pictures.product_id = products.id 
    WHERE customer_profiles.id = pr_customer_profile_id AND product_pictures.image_location LIKE '%_0.%'
    ORDER BY products.id DESC ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProfileInformation` (IN `pr_profile_id` INT(10))  BEGIN

	SELECT customer_profiles.first_name, customer_profiles.last_name, customer_profiles.address, customer_profiles.contact_number, users.email
    FROM customer_profiles
    JOIN users
    ON customer_profiles.user_id = users.id
    WHERE customer_profiles.id = pr_profile_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registerCustomerAccount` (IN `pr_first_name` VARCHAR(35), IN `pr_last_name` VARCHAR(35), IN `pr_gender` VARCHAR(1), IN `pr_address` VARCHAR(191), IN `pr_contact_number` VARCHAR(11), IN `pr_email` VARCHAR(191), IN `pr_password` VARCHAR(191))  BEGIN

	INSERT INTO users(email, password, user_type)
    VALUES (pr_email, pr_password, 2);
    
    INSERT INTO customer_profiles(first_name, last_name, gender, address, contact_number, user_id)
    VALUES (pr_first_name, pr_last_name, pr_gender, pr_address, pr_contact_number, LAST_INSERT_ID());
    
    SELECT LAST_INSERT_ID() as customer_id;
    
    INSERT INTO customer_topups(customer_profile_id)
    VALUES (LAST_INSERT_ID());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCartProcessedInfo` (IN `pr_cart_id` INTEGER(10), IN `pr_process_date` TIMESTAMP)  BEGIN

	UPDATE customer_carts
    SET isProcessed = '1', processedIn = pr_process_date
    WHERE id = pr_cart_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCartQuantity` (IN `pr_cart_id` INTEGER(10), IN `pr_new_quantity` INTEGER(10))  BEGIN

	UPDATE customer_carts
    SET quantity = pr_new_quantity
    WHERE id = pr_cart_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCustomerLoad` (IN `pr_customer_profile_id` INT(10), IN `pr_prev_balance` DECIMAL(7,2), IN `pr_added_balance` DECIMAL(7,2), IN `pr_new_balance` DECIMAL(7,2))  BEGIN

	UPDATE customer_topups
    SET balance = pr_new_balance
    WHERE customer_profile_id = pr_customer_profile_id;
    
    INSERT INTO topup_transactions(customer_profile_id, amount, type)
    VALUES (pr_customer_profile_id, pr_added_balance, '2');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCustomerPassword` (IN `pr_email` VARCHAR(191), IN `pr_new_password` VARCHAR(191))  BEGIN

	UPDATE users
    SET password = pr_new_password
    WHERE email = pr_email;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCustomerProfile` (IN `pr_first_name` VARCHAR(191), IN `pr_last_name` VARCHAR(191), IN `pr_email` VARCHAR(191), IN `pr_address` VARCHAR(191), IN `pr_contact_number` VARCHAR(11), IN `pr_profile_id` INT(10))  BEGIN

	UPDATE  customer_profiles
    SET first_name = pr_first_name, last_name = pr_last_name, address = pr_address,
    contact_number = pr_contact_number
    WHERE id = pr_profile_id;
    
    /* UPDATE users JOIN customer_profiles
    ON customer_profiles.user_id = users.id
    SET users.email = pr_email; */
    
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProductQuantity` (IN `pr_product_id` INTEGER(10), IN `pr_new_quantity` INTEGER(10))  BEGIN

	UPDATE products
    SET stock = pr_new_quantity
	WHERE id = pr_product_id;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_carts`
--

CREATE TABLE `customer_carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_profile_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `isActive` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `isProcessed` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `addedIn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedIn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_carts`
--

INSERT INTO `customer_carts` (`id`, `customer_profile_id`, `product_id`, `quantity`, `isActive`, `isProcessed`, `addedIn`, `processedIn`) VALUES
(1, 2, 5, 5, '0', '0', '2018-05-31 06:39:19', NULL),
(2, 2, 6, 1, '0', '0', '2018-05-31 06:48:04', NULL),
(3, 2, 6, 1, '0', '0', '2018-05-31 06:49:49', NULL),
(4, 2, 6, 1, '0', '0', '2018-05-31 08:01:12', NULL),
(5, 2, 7, 2, '0', '0', '2018-05-31 08:01:10', NULL),
(6, 2, 2, 3, '0', '0', '2018-05-31 08:01:08', NULL),
(7, 2, 4, 1, '0', '0', '2018-05-31 08:01:06', NULL),
(8, 2, 3, 1, '0', '1', '2018-05-31 16:31:03', '2018-05-31 16:31:02'),
(9, 2, 4, 1, '0', '1', '2018-05-31 16:31:03', '2018-05-31 16:31:02'),
(10, 2, 6, 1, '0', '1', '2018-05-31 16:31:03', '2018-05-31 16:31:02'),
(11, 2, 8, 1, '0', '1', '2018-05-31 16:31:03', '2018-05-31 16:31:02'),
(12, 2, 7, 2, '0', '1', '2018-05-31 16:31:03', '2018-05-31 16:31:02'),
(13, 2, 9, 1, '0', '1', '2018-05-31 16:31:02', '2018-05-31 16:31:02'),
(14, 2, 8, 1, '0', '1', '2018-05-31 16:34:49', '2018-05-31 16:34:49'),
(15, 2, 9, 1, '0', '1', '2018-06-01 01:40:51', '2018-06-01 01:40:51'),
(16, 2, 9, 1, '0', '1', '2018-06-01 01:43:31', '2018-06-01 01:43:31'),
(17, 2, 8, 1, '0', '1', '2018-06-01 01:44:58', '2018-06-01 01:44:57'),
(18, 2, 3, 1, '0', '1', '2018-06-01 03:21:26', '2018-06-01 03:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `customer_profiles`
--

CREATE TABLE `customer_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_profiles`
--

INSERT INTO `customer_profiles` (`id`, `first_name`, `last_name`, `gender`, `address`, `contact_number`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'JC', 'Cristobal', 'M', 'Lipa City', '09241325121', '2018-05-30 19:29:05', '2018-05-30 19:29:05', 2),
(2, 'Vince', 'Celemin', 'M', 'Batangas City', '09154507295', NULL, NULL, 3),
(3, 'Kathrina', 'Bamba', 'F', 'Batangas City', '09274884541', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `customer_topups`
--

CREATE TABLE `customer_topups` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_profile_id` int(10) UNSIGNED NOT NULL,
  `balance` decimal(7,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_topups`
--

INSERT INTO `customer_topups` (`id`, `customer_profile_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, '0.00', NULL, NULL),
(2, 2, '0.00', NULL, NULL),
(3, 3, '0.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_profile_id` int(10) UNSIGNED NOT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added` timestamp NULL DEFAULT NULL,
  `arrival_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `customer_profile_id`, `contact_person`, `location`, `contact_number`, `payment_type`, `added`, `arrival_date`) VALUES
(5, 2, 'Vince Celemin', 'Batangas City', '09154507295', '1', '2018-05-31 16:31:02', '2018-06-04 16:31:02'),
(6, 2, 'Vince Celemin', 'Batangas City', '09154507295', '1', '2018-05-31 16:34:49', '2018-06-04 16:34:49'),
(7, 2, 'Vince Celemin', 'Batangas City', '09154507295', '0', '2018-06-01 01:40:51', '2018-06-04 13:08:51'),
(8, 2, 'Vince Celemin', 'Batangas City', '09154507295', '0', '2018-06-01 01:43:31', '2018-06-05 01:43:31'),
(9, 2, 'Vince Celemin', 'Batangas City', '09154507295', '0', '2018-06-01 01:44:57', '2018-06-05 01:44:57'),
(10, 2, 'Vince Celemin', 'Batangas City', '09154507295', '0', '2018-06-01 03:21:25', '2018-06-05 03:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_items`
--

CREATE TABLE `delivery_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `delivery_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_items`
--

INSERT INTO `delivery_items` (`id`, `delivery_id`, `product_id`, `quantity`, `price`, `status`) VALUES
(19, 5, 9, 1, '250.00', '0'),
(20, 5, 7, 2, '500.00', '0'),
(21, 5, 8, 1, '1500.00', '0'),
(22, 5, 6, 1, '149.00', '0'),
(23, 5, 4, 1, '1299.00', '0'),
(24, 5, 3, 1, '250.00', '0'),
(25, 6, 8, 1, '1500.00', '0'),
(26, 7, 9, 1, '250.00', '0'),
(27, 8, 9, 1, '250.00', '0'),
(28, 9, 8, 1, '1500.00', '0'),
(29, 10, 3, 1, '250.00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_05_19_030710_create_user_types_table', 1),
(4, '2018_05_19_030819_add_foreign_key_from_users_to_user_types', 1),
(5, '2018_05_19_042912_create_shop_profiles_table', 1),
(6, '2018_05_19_043619_add_foreign_key_from_users_to_shop_profiles', 1),
(7, '2018_05_19_044200_create_customer_profiles_table', 1),
(8, '2018_05_19_051234_remove_fk_on_users_add_fk_for_users', 1),
(9, '2018_05_19_052058_remove_name_from_users_table', 1),
(10, '2018_05_19_081010_create_products_table', 1),
(11, '2018_05_19_094821_create_product_pictures_table', 1),
(12, '2018_05_19_113713_change_shop_id_name_on_products', 1),
(13, '2018_05_20_092845_add_gender_to_products_table', 1),
(14, '2018_05_25_162718_create_customer_carts_table', 1),
(15, '2018_05_28_050724_create_customer_topups_table', 1),
(16, '2018_05_28_051857_create_topup_transactions_table', 1),
(17, '2018_05_31_021728_add_category_column_to_products_table', 1),
(18, '2018_05_31_094216_add_contact_number_column_to_customer_profiles_table', 2),
(23, '2018_05_31_135614_create_deliveries_table', 3),
(24, '2018_05_31_135918_create_delivery_items_table', 3),
(25, '2018_05_31_161957_add_product_fk_from_delivery_items', 4),
(27, '2018_06_01_070113_add_status_to_delivery_items_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_profile_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shop_profile_id`, `name`, `description`, `category`, `gender`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'White Men\'s Shirt', 'A white shirt for men', '1', 'M', '199.00', 10, NULL, NULL),
(2, 1, 'Blue Longsleeves', 'A blue longsleeve shirt for men', '1', 'M', '499.00', 5, NULL, NULL),
(3, 1, 'White Slippers', 'Slippers for home use', '5', 'U', '250.00', 3, NULL, NULL),
(4, 1, 'Women\'s Jeans', 'Jeans for her', '2', 'F', '1299.00', 4, NULL, NULL),
(5, 1, 'Stripped Blue Longsleeves', 'Blue longsleeves for women', '1', 'F', '700.00', 5, NULL, NULL),
(6, 1, 'Pink Hoodie', 'Pang malamigan', '1', 'M', '149.00', 0, '2018-05-30 22:38:07', '2018-05-30 22:38:07'),
(7, 2, 'Red Hat', 'pananggalang sa bright rays ng araw oh diba', '5', 'U', '250.00', 148, '2018-05-30 23:58:49', '2018-05-30 23:58:49'),
(8, 2, 'Sunglasses', 'To protect your eyes from the sun', '5', 'M', '1500.00', 2, '2018-05-31 00:03:26', '2018-05-31 00:03:26'),
(9, 1, 'Payong', 'para di ka mabasa pag umulan ng malakas pauwi o papasok', '5', 'U', '250.00', 2, '2018-05-31 03:29:40', '2018-05-31 03:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_pictures`
--

CREATE TABLE `product_pictures` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `image_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_pictures`
--

INSERT INTO `product_pictures` (`id`, `product_id`, `image_location`, `created_at`, `updated_at`) VALUES
(1, 1, '1_0.jpg', NULL, NULL),
(2, 1, '1_1.jpeg', NULL, NULL),
(3, 2, '2_0.jpg', NULL, NULL),
(4, 2, '2_1.jpg', NULL, NULL),
(5, 3, '3_0.jpg', NULL, NULL),
(6, 4, '4_0.jpg', NULL, NULL),
(7, 4, '4_1.jpg', NULL, NULL),
(8, 5, '5_0.jpg', NULL, NULL),
(9, 5, '5_1.jpg', NULL, NULL),
(10, 5, '5_2.jpg', NULL, NULL),
(11, 6, '6_0.jpg', '2018-05-30 22:38:08', '2018-05-30 22:38:08'),
(12, 6, '6_1.jpeg', '2018-05-30 22:38:08', '2018-05-30 22:38:08'),
(13, 6, '6_2.jpg', '2018-05-30 22:38:08', '2018-05-30 22:38:08'),
(14, 7, '7_0.jpg', '2018-05-30 23:58:49', '2018-05-30 23:58:49'),
(15, 7, '7_1.jpg', '2018-05-30 23:58:49', '2018-05-30 23:58:49'),
(16, 7, '7_2.JPG', '2018-05-30 23:58:49', '2018-05-30 23:58:49'),
(17, 8, '8_0.jpg', '2018-05-31 00:03:26', '2018-05-31 00:03:26'),
(18, 9, '9_0.jpg', '2018-05-31 03:29:40', '2018-05-31 03:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `shop_profiles`
--

CREATE TABLE `shop_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_profiles`
--

INSERT INTO `shop_profiles` (`id`, `shop_name`, `shop_description`, `shop_location`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Concept Store', 'Store made, store distributed', 'Lipa City', NULL, NULL, 1),
(2, 'Another Store', 'this is another store', 'Mataas na Kahoy, Lipa City', '2018-05-30 23:48:15', '2018-05-30 23:48:15', 4);

-- --------------------------------------------------------

--
-- Table structure for table `topup_transactions`
--

CREATE TABLE `topup_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_profile_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(7,2) NOT NULL,
  `type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topup_transactions`
--

INSERT INTO `topup_transactions` (`id`, `customer_profile_id`, `amount`, `type`, `transaction_date`) VALUES
(12, 2, '500.00', '1', '2018-05-31 05:29:24'),
(13, 2, '50.00', '1', '2018-05-31 05:31:45'),
(14, 2, '50.00', '1', '2018-05-31 05:32:02'),
(15, 2, '50.00', '1', '2018-05-31 05:36:00'),
(16, 2, '50.00', '1', '2018-05-31 05:37:29'),
(17, 2, '50.00', '1', '2018-05-31 05:49:56'),
(18, 2, '50.00', '1', '2018-05-31 07:34:41'),
(19, 2, '1200.00', '1', '2018-06-01 01:44:45'),
(20, 2, '1500.00', '2', '2018-06-01 01:44:58'),
(21, 2, '250.00', '1', '2018-06-01 03:20:45'),
(22, 2, '250.00', '2', '2018-06-01 03:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'conceptstore@test.biz', '$2y$10$7con7CB/0wdl/oZjrkOdrO06yKNAwX.kFSZLafOJsLJPuK1XIzTcm', 1, 'MwCOtmR1dY5oFTvV3Ux5UvuAhL5E4jQJs3Qsw1MvBmflaEvPde439Su4CywD', '2018-05-30 19:29:05', '2018-05-30 22:37:31'),
(2, 'customer@concept.biz', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 2, NULL, '2018-05-30 19:29:05', '2018-05-30 19:29:05'),
(3, 'vince@test.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 2, NULL, NULL, NULL),
(4, 'another@store.com', '$2y$10$t64b9537oDJTUFjnjR.J8O5DS4hIhWN2FFW8D4mKtlOdZyMHZaL/.', 1, NULL, '2018-05-30 23:48:15', '2018-05-30 23:48:15'),
(5, 'kath@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `type_name`, `type_description`, `created_at`, `updated_at`) VALUES
(1, 'Store', 'Is able to add and manage products as well as the orders and sales generated from said products.', '2018-05-30 19:29:05', NULL),
(2, 'Customer', 'Can order and/or purchase products displayed by the Store Owners', '2018-05-30 19:29:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_carts`
--
ALTER TABLE `customer_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_carts_customer_profile_id_product_id_index` (`customer_profile_id`,`product_id`),
  ADD KEY `customer_carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_profiles_user_id_unique` (`user_id`),
  ADD KEY `customer_profiles_id_index` (`id`);

--
-- Indexes for table `customer_topups`
--
ALTER TABLE `customer_topups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_topups_customer_profile_id_index` (`customer_profile_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveries_customer_profile_id_index` (`customer_profile_id`);

--
-- Indexes for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_items_delivery_id_index` (`delivery_id`),
  ADD KEY `delivery_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_shop_id_index` (`shop_profile_id`);

--
-- Indexes for table `product_pictures`
--
ALTER TABLE `product_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_pictures_product_id_index` (`product_id`);

--
-- Indexes for table `shop_profiles`
--
ALTER TABLE `shop_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_profiles_shop_name_unique` (`shop_name`),
  ADD UNIQUE KEY `shop_profiles_user_id_unique` (`user_id`),
  ADD KEY `shop_profiles_id_index` (`id`);

--
-- Indexes for table `topup_transactions`
--
ALTER TABLE `topup_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topup_transactions_customer_profile_id_index` (`customer_profile_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_profile_id_user_type_index` (`id`,`user_type`),
  ADD KEY `users_user_type_foreign` (`user_type`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_types_id_unique` (`id`),
  ADD KEY `user_types_id_index` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_carts`
--
ALTER TABLE `customer_carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_topups`
--
ALTER TABLE `customer_topups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery_items`
--
ALTER TABLE `delivery_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_pictures`
--
ALTER TABLE `product_pictures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `shop_profiles`
--
ALTER TABLE `shop_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `topup_transactions`
--
ALTER TABLE `topup_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_carts`
--
ALTER TABLE `customer_carts`
  ADD CONSTRAINT `customer_carts_customer_profile_id_foreign` FOREIGN KEY (`customer_profile_id`) REFERENCES `customer_profiles` (`id`),
  ADD CONSTRAINT `customer_carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD CONSTRAINT `customer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `customer_topups`
--
ALTER TABLE `customer_topups`
  ADD CONSTRAINT `customer_topups_customer_profile_id_foreign` FOREIGN KEY (`customer_profile_id`) REFERENCES `customer_profiles` (`id`);

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_customer_profile_id_foreign` FOREIGN KEY (`customer_profile_id`) REFERENCES `customer_profiles` (`id`);

--
-- Constraints for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD CONSTRAINT `delivery_items_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  ADD CONSTRAINT `delivery_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_shop_id_foreign` FOREIGN KEY (`shop_profile_id`) REFERENCES `shop_profiles` (`id`);

--
-- Constraints for table `product_pictures`
--
ALTER TABLE `product_pictures`
  ADD CONSTRAINT `product_pictures_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `shop_profiles`
--
ALTER TABLE `shop_profiles`
  ADD CONSTRAINT `shop_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `topup_transactions`
--
ALTER TABLE `topup_transactions`
  ADD CONSTRAINT `topup_transactions_customer_profile_id_foreign` FOREIGN KEY (`customer_profile_id`) REFERENCES `customer_profiles` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_user_type_foreign` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
