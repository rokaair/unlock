-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2018 at 11:58 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.1.17-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rms_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `reparation_id` int(11) DEFAULT NULL,
  `label` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `added_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `image`, `parent_id`) VALUES
(1, 'CAT1', 'Category 1', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `last_activity` varchar(255) NOT NULL,
  `user_data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(4) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cf` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Admin Group'),
(2, 'members', 'General Users');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` char(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `model_name` varchar(40) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category` varchar(250) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subcategory` varchar(250) DEFAULT NULL,
  `supplier` varchar(250) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) NOT NULL,
  `alert_quantity` decimal(15,4) DEFAULT '20.0000',
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `details` varchar(1000) DEFAULT NULL,
  `type` varchar(55) NOT NULL DEFAULT 'standard',
  `tax_method` int(11) NOT NULL DEFAULT '0',
  `tax_rate` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `reparation_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `log` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `repair-index` tinyint(1) NOT NULL,
  `repair-add` tinyint(1) NOT NULL,
  `repair-edit` tinyint(1) NOT NULL,
  `repair-delete` tinyint(1) NOT NULL,
  `repair-view_repair` tinyint(1) NOT NULL,
  `customers-delete` tinyint(1) NOT NULL,
  `customers-view_customer` tinyint(1) NOT NULL,
  `customers-index` tinyint(1) NOT NULL,
  `customers-add` tinyint(1) NOT NULL,
  `customers-edit` tinyint(1) NOT NULL,
  `inventory-index` tinyint(1) NOT NULL,
  `inventory-add` tinyint(1) NOT NULL,
  `inventory-edit` tinyint(1) NOT NULL,
  `inventory-delete` tinyint(1) NOT NULL,
  `inventory-print_barcodes` tinyint(1) NOT NULL,
  `inventory-product_actions` tinyint(1) NOT NULL,
  `inventory-suppliers` tinyint(1) NOT NULL,
  `inventory-add_supplier` tinyint(1) NOT NULL,
  `inventory-edit_supplier` tinyint(1) NOT NULL,
  `inventory-delete_supplier` tinyint(1) NOT NULL,
  `inventory-models` tinyint(1) NOT NULL,
  `inventory-add_model` tinyint(1) NOT NULL,
  `inventory-edit_model` tinyint(1) NOT NULL,
  `inventory-delete_model` tinyint(1) NOT NULL,
  `purchases-index` tinyint(1) NOT NULL,
  `purchases-add` tinyint(1) NOT NULL,
  `purchases-edit` tinyint(1) NOT NULL,
  `purchases-delete` tinyint(1) NOT NULL,
  `auth-index` tinyint(1) NOT NULL,
  `auth-create_user` tinyint(1) NOT NULL,
  `auth-edit_user` tinyint(1) NOT NULL,
  `auth-delete_user` tinyint(1) NOT NULL,
  `reports-stock` tinyint(1) NOT NULL,
  `reports-finance` tinyint(1) NOT NULL,
  `reports-quantity_alerts` tinyint(1) NOT NULL,
  `auth-user_groups` tinyint(1) NOT NULL,
  `auth-delete_group` tinyint(1) NOT NULL,
  `auth-create_group` tinyint(1) NOT NULL,
  `auth-edit_group` tinyint(1) NOT NULL,
  `auth-permissions` tinyint(1) NOT NULL,
  `utilities-index` tinyint(1) NOT NULL,
  `utilities-backup_db` tinyint(1) NOT NULL,
  `utilities-restore_db` tinyint(1) NOT NULL,
  `utilities-remove_db` tinyint(1) NOT NULL,
  `tax_rates-index` tinyint(1) NOT NULL,
  `tax_rates-add` tinyint(1) NOT NULL,
  `tax_rates-edit` tinyint(1) NOT NULL,
  `tax_rates-delete` tinyint(1) NOT NULL,
  `categories-index` tinyint(1) NOT NULL,
  `categories-add` tinyint(1) NOT NULL,
  `categories-edit` tinyint(1) NOT NULL,
  `categories-delete` tinyint(1) NOT NULL,
  `dashboard-qemail` tinyint(1) NOT NULL,
  `dashboard-qsms` tinyint(1) NOT NULL,
  `pos-index` tinyint(1) NOT NULL,
  `reports-sales` tinyint(1) NOT NULL,
  `reports-drawer` tinyint(1) NOT NULL,
  `inventory-manufacturers` tinyint(1) NOT NULL DEFAULT '0',
  `inventory-add_manufacturer` tinyint(1) NOT NULL DEFAULT '0',
  `inventory-edit_manufacturer` tinyint(1) NOT NULL DEFAULT '0',
  `inventory-delete_manufacturer` tinyint(1) NOT NULL DEFAULT '0',
  `reparation-print_barcodes` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_id`, `repair-index`, `repair-add`, `repair-edit`, `repair-delete`, `repair-view_repair`, `customers-delete`, `customers-view_customer`, `customers-index`, `customers-add`, `customers-edit`, `inventory-index`, `inventory-add`, `inventory-edit`, `inventory-delete`, `inventory-print_barcodes`, `inventory-product_actions`, `inventory-suppliers`, `inventory-add_supplier`, `inventory-edit_supplier`, `inventory-delete_supplier`, `inventory-models`, `inventory-add_model`, `inventory-edit_model`, `inventory-delete_model`, `purchases-index`, `purchases-add`, `purchases-edit`, `purchases-delete`, `auth-index`, `auth-create_user`, `auth-edit_user`, `auth-delete_user`, `reports-stock`, `reports-finance`, `reports-quantity_alerts`, `auth-user_groups`, `auth-delete_group`, `auth-create_group`, `auth-edit_group`, `auth-permissions`, `utilities-index`, `utilities-backup_db`, `utilities-restore_db`, `utilities-remove_db`, `tax_rates-index`, `tax_rates-add`, `tax_rates-edit`, `tax_rates-delete`, `categories-index`, `categories-add`, `categories-edit`, `categories-delete`, `dashboard-qemail`, `dashboard-qsms`, `pos-index`, `reports-sales`, `reports-drawer`, `inventory-manufacturers`, `inventory-add_manufacturer`, `inventory-edit_manufacturer`, `inventory-delete_manufacturer`, `reparation-print_barcodes`) VALUES
(1, 2, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_register`
--

CREATE TABLE `pos_register` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `cash_in_hand` decimal(25,4) NOT NULL,
  `cash_data` longtext NOT NULL,
  `total_cash_submitted` decimal(25,2) NOT NULL,
  `total_cheques_submitted` decimal(25,2) NOT NULL,
  `total_cc_submitted` decimal(25,2) NOT NULL,
  `total_cash` decimal(25,2) NOT NULL,
  `total_cheques` decimal(25,2) NOT NULL,
  `total_cc` decimal(25,2) NOT NULL,
  `total_others` decimal(25,2) NOT NULL,
  `total_ppp` decimal(25,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `total_cash_submitted_data` longtext NOT NULL,
  `note` text,
  `closed_at` timestamp NULL DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_settings`
--

CREATE TABLE `pos_settings` (
  `id` int(11) NOT NULL,
  `products_per_page` int(11) NOT NULL,
  `product_button_color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_settings`
--

INSERT INTO `pos_settings` (`id`, `products_per_page`, `product_button_color`) VALUES
(1, 10, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` int(11) DEFAULT NULL,
  `product_discount` decimal(25,4) NOT NULL,
  `total_discount` decimal(25,4) NOT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `product_tax` decimal(25,4) NOT NULL,
  `total_tax` decimal(25,4) NOT NULL,
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `status` varchar(55) DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `quantity_balance` decimal(25,4) NOT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reparation`
--

CREATE TABLE `reparation` (
  `id` int(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_id` int(11) NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sms` int(1) NOT NULL DEFAULT '0',
  `email` tinyint(1) NOT NULL,
  `defect` text CHARACTER SET utf8 NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `model_id` int(255) DEFAULT NULL,
  `model_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `imei` text NOT NULL,
  `advance` int(11) NOT NULL,
  `service_charges` int(255) NOT NULL,
  `date_opening` datetime NOT NULL,
  `date_closing` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '3',
  `comment` varchar(500) CHARACTER SET utf8 NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `custom_field` longtext CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax` decimal(25,4) NOT NULL,
  `total` decimal(25,4) NOT NULL,
  `grand_total` decimal(25,4) NOT NULL,
  `diagnostics` longtext NOT NULL,
  `manufacturer` varchar(250) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `expected_close_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reparation_items`
--

CREATE TABLE `reparation_items` (
  `id` int(11) NOT NULL,
  `reparation_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `subtotal` decimal(25,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `total_tax` decimal(25,2) DEFAULT '0.00',
  `total_discount` decimal(24,2) NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `grand_total` decimal(25,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `paid` decimal(25,2) DEFAULT '0.00',
  `note` longtext,
  `sale_status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `unit_cost` decimal(24,2) NOT NULL,
  `unit_price` decimal(25,2) DEFAULT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `item_tax` decimal(25,2) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `item_discount` decimal(25,2) DEFAULT NULL,
  `subtotal` decimal(25,2) NOT NULL,
  `real_unit_price` decimal(24,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payments`
--

CREATE TABLE `sale_payments` (
  `id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `paid_by` varchar(20) NOT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cc_no` varchar(20) DEFAULT NULL,
  `cc_holder` varchar(25) DEFAULT NULL,
  `cc_month` varchar(2) DEFAULT NULL,
  `cc_year` varchar(4) DEFAULT NULL,
  `cc_type` varchar(20) DEFAULT NULL,
  `amount` decimal(25,4) NOT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `pos_paid` decimal(25,4) DEFAULT '0.0000',
  `pos_balance` decimal(25,4) DEFAULT '0.0000',
  `approval_code` varchar(50) DEFAULT NULL,
  `cc_cvv2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(4) NOT NULL,
  `title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `language` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `disclaimer` varchar(370) COLLATE utf8_unicode_ci NOT NULL,
  `nexmo_api_key` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `nexmo_api_secret` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_mail` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `twilio_mode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `twilio_account_sid` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `twilio_auth_token` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `twilio_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `usesms` int(2) NOT NULL,
  `r_opening` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `r_closing` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `custom_fields` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `stampadue` int(2) NOT NULL,
  `product_discount` tinyint(1) NOT NULL,
  `purchase_prefix` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reference_format` int(11) NOT NULL,
  `decimals` int(11) NOT NULL,
  `qty_decimals` int(11) NOT NULL,
  `tax1` tinyint(1) NOT NULL,
  `tax2` int(11) NOT NULL,
  `default_tax_rate` int(11) NOT NULL,
  `default_tax_rate2` int(11) NOT NULL,
  `update_cost` tinyint(1) NOT NULL,
  `bc_fix` int(11) NOT NULL,
  `disable_editing` tinyint(1) NOT NULL,
  `version` decimal(25,2) NOT NULL,
  `model_based_search` tinyint(1) NOT NULL,
  `rows_per_page` int(11) NOT NULL,
  `iwidth` int(11) NOT NULL,
  `iheight` int(11) NOT NULL,
  `twidth` int(11) NOT NULL,
  `theight` int(11) NOT NULL,
  `watermark` tinyint(1) NOT NULL,
  `decimal_seperator` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `thousand_seperator` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `reparation_table_state` longtext COLLATE utf8_unicode_ci,
  `bg_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `header_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_active_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_text_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#8aa4af',
  `mmenu_text_color` longtext COLLATE utf8_unicode_ci NOT NULL,
  `bg_text_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#333',
  `invoice_table_color` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `body_font` int(11) NOT NULL DEFAULT '15',
  `use_dark_theme` tinyint(1) NOT NULL,
  `enable_recaptcha` tinyint(1) NOT NULL,
  `google_site_key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `google_secret_key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `google_api_key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `use_topbar` tinyint(1) NOT NULL,
  `theme` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_template` tinyint(4) NOT NULL DEFAULT '1',
  `invoice_template` tinyint(4) NOT NULL DEFAULT '1',
  `barcode_img` tinyint(4) NOT NULL DEFAULT '1',
  `show_settings_menu` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `language`, `disclaimer`, `nexmo_api_key`, `nexmo_api_secret`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `currency`, `address`, `invoice_mail`, `phone`, `vat`, `invoice_name`, `category`, `twilio_mode`, `twilio_account_sid`, `twilio_auth_token`, `twilio_number`, `usesms`, `r_opening`, `r_closing`, `logo`, `custom_fields`, `stampadue`, `product_discount`, `purchase_prefix`, `reference_format`, `decimals`, `qty_decimals`, `tax1`, `tax2`, `default_tax_rate`, `default_tax_rate2`, `update_cost`, `bc_fix`, `disable_editing`, `version`, `model_based_search`, `rows_per_page`, `iwidth`, `iheight`, `twidth`, `theight`, `watermark`, `decimal_seperator`, `thousand_seperator`, `reparation_table_state`, `bg_color`, `header_color`, `menu_color`, `menu_active_color`, `menu_text_color`, `mmenu_text_color`, `bg_text_color`, `invoice_table_color`, `body_font`, `use_dark_theme`, `enable_recaptcha`, `google_site_key`, `google_secret_key`, `google_api_key`, `use_topbar`, `theme`, `background`, `report_template`, `invoice_template`, `barcode_img`, `show_settings_menu`) VALUES
(1, 'Repairer', 'english', '(1) A MINIMUM ASSESSMENT FEE OF $45 WILL BE CHARGED: If the device is not covered by the Manufacturer’s warranty or Gadgets Online NZ LTD Warranty.\r\n(2) It is the customer’s responsibility to back up all data before presenting the device for repair. Gadgets Online NZ LTD takes no responsibility for any loss of data stored within the phone.\r\n(3) Customer agrees that th', 'a', 'c1cd03da6b47c21e', 'ssl://smtp.gmail.com', 'example@gmail.com', 'example', '465', '$', 'New York', 'no-reply@repairer.com', '123456789', 'Blue', 'Repair', 'Mobile, Laptops', 'sandbox', '', '', '', 2, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.%0', 'Hello %customer%, your order/repair for %model% is now complete, regards %businessname%. ', '4c5942de63655b13ec8e9cbb6ddd0836.png', 'nº interno,telemovel da mae', 1, 0, 'LCPO', 3, 0, 0, 0, 0, 0, 0, 0, 1, 7, '2.20', 0, 10, 800, 800, 150, 150, 0, '.', ',', NULL, 'rgb(248,248,248)', '#103a54', '#103a54', '#103a54', '#000000', 'rgba(197,197,197,0.92)', '#000000', '#103a54', 15, 0, 0, '', '', '', 1, 'adminlte', NULL, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `label` varchar(150) NOT NULL,
  `bg_color` varchar(50) NOT NULL,
  `fg_color` varchar(50) NOT NULL,
  `position` int(11) NOT NULL,
  `send_sms` tinyint(1) NOT NULL,
  `send_email` tinyint(1) NOT NULL,
  `sms_text` text,
  `email_text` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `label`, `bg_color`, `fg_color`, `position`, `send_sms`, `send_email`, `sms_text`, `email_text`) VALUES
(1, 'In Progress', '#000000', '#ffffff', 1, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.'),
(2, 'To Be Approved', '#ff0000', '#ffffff', 2, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% need to be approved '),
(3, 'Job done! ready to deliver', '#692121', '#ffffff', 3, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.'),
(4, 'Delivered', '#1be323', '#000000', 4, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was delivered by %businessname%. ');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `company` varchar(255) NOT NULL,
  `vat_no` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(55) NOT NULL,
  `state` varchar(55) DEFAULT NULL,
  `postal_code` varchar(8) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,2) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `name`, `code`, `rate`, `type`) VALUES
(1, 'No Tax', 'NT', '0.00', '2'),
(2, 'VAT', 'VAT', '16.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `member_unique_id` varchar(20) NOT NULL,
  `type_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section` varchar(2) NOT NULL,
  `image` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `gender`, `member_unique_id`, `type_id`, `class_id`, `section`, `image`, `address`) VALUES
(1, '202.163.79.3', NULL, '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'admin@admin.com', NULL, NULL, NULL, 'SGxrHSVyi1QbXxOISln89O', 1483613710, 1515512723, 1, 'Admin', 'Admin', 'Repairer', '666666', 'Male', '', 0, 0, '', 'no_image.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `pos_register`
--
ALTER TABLE `pos_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_settings`
--
ALTER TABLE `pos_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reparation`
--
ALTER TABLE `reparation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reparation_items`
--
ALTER TABLE `reparation_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`,`sale_id`),
  ADD KEY `sale_id_2` (`sale_id`,`product_id`);

--
-- Indexes for table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pos_register`
--
ALTER TABLE `pos_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_settings`
--
ALTER TABLE `pos_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reparation`
--
ALTER TABLE `reparation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reparation_items`
--
ALTER TABLE `reparation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_payments`
--
ALTER TABLE `sale_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
