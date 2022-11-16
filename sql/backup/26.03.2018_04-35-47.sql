#
# TABLE STRUCTURE FOR: attachments
#

DROP TABLE IF EXISTS `attachments`;

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reparation_id` int(11) DEFAULT NULL,
  `label` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (1, 1, 'prg_history', 'prg_history.jpeg', '2018-03-25 14:01:09');
INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (2, 1, 'prg_history1', 'prg_history1.jpeg', '2018-03-25 14:01:26');
INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (3, NULL, 'white-lion-attacking-zebra-354609', 'white-lion-attacking-zebra-354609.jpg', '2018-03-25 14:02:33');
INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (4, NULL, 'IDR_THEME_NTP_BACKGROUND', 'IDR_THEME_NTP_BACKGROUND.png', '2018-03-25 14:04:52');
INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (5, NULL, 'IDR_THEME_NTP_BACKGROUND1', 'IDR_THEME_NTP_BACKGROUND1.png', '2018-03-25 14:06:58');
INSERT INTO `attachments` (`id`, `reparation_id`, `label`, `filename`, `added_date`) VALUES (6, 5, 'IDR_THEME_NTP_BACKGROUND2', 'IDR_THEME_NTP_BACKGROUND2.png', '2018-03-25 14:08:04');


#
# TABLE STRUCTURE FOR: categories
#

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `code`, `name`, `image`, `parent_id`) VALUES (1, 'C1', 'Category', NULL, 0);


#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `last_activity` varchar(255) NOT NULL,
  `user_data` varchar(255) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: clients
#

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cf` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (1, 'Usman Sher', 'OTS', '+923009405789', 'Gulberg III', 'Lahore ', '54000', 'uskhan099@gmail.com', 'Test', 'sadsda', '2018-03-25', 'sadsad', NULL);
INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (3, 'usman sher khan', 'das', '', '', '', '', '', '', '', '2018-03-25', '', NULL);
INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (4, 'dasdsa', 'sad', '', '', '', '', '', '', '', '2018-03-25', '', NULL);
INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (5, 'hbjksdf', 'fds', '', '', '', '', '', '', '', '2018-03-25', '', NULL);
INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (7, 'dasdsa', 'dasads', '', '', '', '', '', '', '', '2018-03-25', '', NULL);
INSERT INTO `clients` (`id`, `name`, `company`, `telephone`, `address`, `city`, `postal_code`, `email`, `vat`, `cf`, `date`, `comment`, `image`) VALUES (8, 'edit', 'ediy', '', '', '', '', '', '', '', '2018-03-25', '', NULL);


#
# TABLE STRUCTURE FOR: events
#

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES (5, 'test', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES (7, 'tetst', '2018-03-25 07:00:00', '2018-03-25 13:00:00');
INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES (8, 'a', '2018-03-06 00:00:00', '2018-03-07 00:00:00');
INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES (11, 'test', '2018-03-31 00:00:00', '2018-04-01 00:00:00');
INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES (12, 'tstsd', '2018-03-25 15:00:00', '2018-03-25 19:30:00');


#
# TABLE STRUCTURE FOR: groups
#

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES (1, 'admin', 'Admin Group');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES (4, 'members', 'General Members');


#
# TABLE STRUCTURE FOR: inventory
#

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` char(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `model_name` varchar(40) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category` varchar(250) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subcategory` varchar(250) DEFAULT NULL,
  `supplier` varchar(250) NOT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) NOT NULL,
  `alert_quantity` decimal(15,4) DEFAULT '20.0000',
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `details` varchar(1000) DEFAULT NULL,
  `type` varchar(55) NOT NULL DEFAULT 'standard',
  `tax_method` int(11) NOT NULL DEFAULT '0',
  `tax_rate` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `inventory` (`id`, `code`, `name`, `unit`, `model_id`, `model_name`, `category_id`, `category`, `subcategory_id`, `subcategory`, `supplier`, `cost`, `price`, `alert_quantity`, `quantity`, `details`, `type`, `tax_method`, `tax_rate`, `isDeleted`, `image`) VALUES (1, '42412244', 'dsa', 'das', 2, 'LCD', 1, 'Category', NULL, NULL, '2', '12.0000', '13.0000', '3.0000', '5.0000', 'dasd', 'standard', 0, NULL, 0, 'no_image.png');


#
# TABLE STRUCTURE FOR: log
#

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reparation_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `log` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `log` (`id`, `reparation_id`, `updated_by`, `date`, `log`) VALUES (1, 2, 1, '2018-03-25 18:51:23', '[[\"status_name\",\"Delivered\",\"Job done! ready to deliver\"]]');
INSERT INTO `log` (`id`, `reparation_id`, `updated_by`, `date`, `log`) VALUES (2, 2, 1, '2018-03-25 18:51:42', '[[\"tax_name\",\"New\",\"No Tax\"]]');


#
# TABLE STRUCTURE FOR: models
#

DROP TABLE IF EXISTS `models`;

CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `models` (`id`, `name`, `manufacturer`, `description`) VALUES (1, 'Note 8', 'Samsung', '');
INSERT INTO `models` (`id`, `name`, `manufacturer`, `description`) VALUES (2, 'LCD', 'a', '');
INSERT INTO `models` (`id`, `name`, `manufacturer`, `description`) VALUES (3, 'tets', 'test', '');


#
# TABLE STRUCTURE FOR: permissions
#

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `permissions` (`id`, `group_id`, `repair-index`, `repair-add`, `repair-edit`, `repair-delete`, `repair-view_repair`, `customers-delete`, `customers-view_customer`, `customers-index`, `customers-add`, `customers-edit`, `inventory-index`, `inventory-add`, `inventory-edit`, `inventory-delete`, `inventory-print_barcodes`, `inventory-product_actions`, `inventory-suppliers`, `inventory-add_supplier`, `inventory-edit_supplier`, `inventory-delete_supplier`, `inventory-models`, `inventory-add_model`, `inventory-edit_model`, `inventory-delete_model`, `purchases-index`, `purchases-add`, `purchases-edit`, `purchases-delete`, `auth-index`, `auth-create_user`, `auth-edit_user`, `auth-delete_user`, `reports-stock`, `reports-finance`, `reports-quantity_alerts`, `auth-user_groups`, `auth-delete_group`, `auth-create_group`, `auth-edit_group`, `auth-permissions`, `utilities-index`, `utilities-backup_db`, `utilities-restore_db`, `utilities-remove_db`, `tax_rates-index`, `tax_rates-add`, `tax_rates-edit`, `tax_rates-delete`, `categories-index`, `categories-add`, `categories-edit`, `categories-delete`, `dashboard-qemail`, `dashboard-qsms`) VALUES (2, 4, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0);


#
# TABLE STRUCTURE FOR: purchase_items
#

DROP TABLE IF EXISTS `purchase_items`;

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `unit_cost` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `product_code`, `product_name`, `net_unit_cost`, `quantity`, `quantity_balance`, `item_tax`, `tax_rate_id`, `tax`, `discount`, `item_discount`, `subtotal`, `date`, `status`, `unit_cost`) VALUES (1, 1, 1, '42412244', 'dsa', '12.0000', '4.0000', '4.0000', '0.0000', 0, '', '0', '0.0000', '48.0000', '2018-03-25', 'received', '12.0000');


#
# TABLE STRUCTURE FOR: purchases
#

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `attachment` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `purchases` (`id`, `reference_no`, `date`, `supplier_id`, `supplier`, `note`, `total`, `order_discount`, `order_discount_id`, `product_discount`, `total_discount`, `order_tax`, `order_tax_id`, `product_tax`, `total_tax`, `shipping`, `grand_total`, `status`, `created_by`, `updated_by`, `updated_at`, `attachment`) VALUES (1, 'PO/2018/03/0001', '2018-03-25 03:17:00', 2, 'sdada', '&lt;p&gt;adsda&lt;&sol;p&gt;', '48.0000', '1.0000', 1, '0.0000', '1.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '47.0000', 'received', 1, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: reparation
#

DROP TABLE IF EXISTS `reparation`;

CREATE TABLE `reparation` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_id` int(11) NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sms` int(1) NOT NULL DEFAULT '0',
  `email` tinyint(1) NOT NULL,
  `defect` text CHARACTER SET utf8 NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `model_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `model_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `imei` text NOT NULL,
  `advance` int(11) NOT NULL,
  `service_charges` int(255) NOT NULL,
  `date_opening` datetime NOT NULL,
  `date_closing` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '3',
  `comment` varchar(500) CHARACTER SET utf8 NOT NULL,
  `diagnostics` longtext NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `custom_field` longtext CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `tax_id` int(11) NOT NULL,
  `tax` decimal(25,4) NOT NULL,
  `total` decimal(25,4) NOT NULL,
  `grand_total` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `reparation` (`id`, `name`, `client_id`, `telephone`, `sms`, `email`, `defect`, `category`, `model_id`, `model_name`, `imei`, `advance`, `service_charges`, `date_opening`, `date_closing`, `status`, `comment`, `diagnostics`, `code`, `custom_field`, `created_by`, `updated_by`, `tax_id`, `tax`, `total`, `grand_total`) VALUES (2, 'Usman Sher', 1, '+923009405789', 0, 0, 'dsa', 'Mobile', '1', 'Note 8', 'asdsa', 1, 10, '2018-03-25 03:41:51', '2018-03-25 18:49:05', 3, 'adsa', '', 'vzdt9bf7', '[]', 1, 1, 1, '0.0000', '0.0000', '10.0000');
INSERT INTO `reparation` (`id`, `name`, `client_id`, `telephone`, `sms`, `email`, `defect`, `category`, `model_id`, `model_name`, `imei`, `advance`, `service_charges`, `date_opening`, `date_closing`, `status`, `comment`, `diagnostics`, `code`, `custom_field`, `created_by`, `updated_by`, `tax_id`, `tax`, `total`, `grand_total`) VALUES (7, 'Omar', 2, '', 0, 0, 'sadas', 'Mobile', '1', 'Note 8', 'changethis again', 12, 123, '2018-03-25 03:46:33', NULL, 1, 'ads', '', 'bmsx2tk9', '[]', 1, 1, 1, '0.0000', '0.0000', '123.0000');


#
# TABLE STRUCTURE FOR: reparation_items
#

DROP TABLE IF EXISTS `reparation_items`;

CREATE TABLE `reparation_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reparation_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `settings` (`id`, `title`, `language`, `disclaimer`, `nexmo_api_key`, `nexmo_api_secret`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `currency`, `address`, `invoice_mail`, `phone`, `vat`, `invoice_name`, `category`, `twilio_mode`, `twilio_account_sid`, `twilio_auth_token`, `twilio_number`, `usesms`, `r_opening`, `r_closing`, `logo`, `custom_fields`, `stampadue`, `product_discount`, `purchase_prefix`, `reference_format`, `decimals`, `qty_decimals`, `tax1`, `tax2`, `default_tax_rate`, `default_tax_rate2`, `update_cost`, `bc_fix`, `disable_editing`, `version`, `model_based_search`, `rows_per_page`, `iwidth`, `iheight`, `twidth`, `theight`, `watermark`, `decimal_seperator`, `thousand_seperator`, `reparation_table_state`, `bg_color`, `header_color`, `menu_color`, `menu_active_color`, `menu_text_color`, `mmenu_text_color`, `bg_text_color`, `invoice_table_color`, `body_font`, `use_dark_theme`, `enable_recaptcha`, `google_site_key`, `google_secret_key`, `google_api_key`) VALUES (1, 'Repairer', 'english', 'Your Disclaimer Here', '3ccb0182', 'c36ed8fd594ebc3f', '', '', '', '', 'USD', 'New York', 'no-reply@repairer.com', '123456789', 'Blue', 'Repairer', 'Mobile,Laptop', 'sandbox', 'AC7e889fba46ca9854c8870dd7b353c5dc', 'ac508451a59989b1d4aecef47640a4d4', '+13134869481', 2, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.%0', 'Hello %customer%, your order/repair for %model% is now complete, regards %businessname%. ', 'a57d5d011027f611b56d71eed4e18f98.png', '', 1, 1, 'PO', 2, 2, 1, 0, 0, 0, 0, 1, 2, 30, '1.70', 0, 25, 3000, 3000, 150, 150, 1, '.', ',', '{\"time\":1522060547053,\"start\":0,\"length\":25,\"order\":[[6,\"desc\"]],\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true},\"columns\":[{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}},{\"visible\":true,\"search\":{\"search\":\"\",\"smart\":true,\"regex\":false,\"caseInsensitive\":true}}]}', 'rgb(248,248,248)', '#103a54', '#103a54', '#103a54', '#000000', 'rgba(197,197,197,0.92)', '#000000', '#103a54', 15, 0, 1, '6Lfg0EEUAAAAAOFf6JZWdl7bP4o_DsP1eL0sNsne', '6Lfg0EEUAAAAAIh82ck-sQH5mIXqvQii0Io3EDzs', 'AIzaSyCvjwWcbO2eRxs1-bSnkiZqBhflnBWexKY');


#
# TABLE STRUCTURE FOR: status
#

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(150) NOT NULL,
  `bg_color` varchar(50) NOT NULL,
  `fg_color` varchar(50) NOT NULL,
  `position` int(11) NOT NULL,
  `send_sms` tinyint(1) NOT NULL,
  `send_email` tinyint(1) NOT NULL,
  `sms_text` text,
  `email_text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `status` (`id`, `label`, `bg_color`, `fg_color`, `position`, `send_sms`, `send_email`, `sms_text`, `email_text`) VALUES (1, 'In Progress', '#000000', '#ffffff', 1, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.');
INSERT INTO `status` (`id`, `label`, `bg_color`, `fg_color`, `position`, `send_sms`, `send_email`, `sms_text`, `email_text`) VALUES (2, 'To Be Approved', '#ff0000', '#ffffff', 2, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% need to be approved ');
INSERT INTO `status` (`id`, `label`, `bg_color`, `fg_color`, `position`, `send_sms`, `send_email`, `sms_text`, `email_text`) VALUES (3, 'Job done! ready to deliver', '#692121', '#ffffff', 3, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair anytime on %site_url%.');
INSERT INTO `status` (`id`, `label`, `bg_color`, `fg_color`, `position`, `send_sms`, `send_email`, `sms_text`, `email_text`) VALUES (4, 'Delivered', '#1be323', '#000000', 4, 0, 1, NULL, 'Hello %customer%, your order/repair for %model% was delivered by %businessname%. ');


#
# TABLE STRUCTURE FOR: suppliers
#

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `company` varchar(255) NOT NULL,
  `vat_no` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(55) NOT NULL,
  `state` varchar(55) DEFAULT NULL,
  `postal_code` varchar(8) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `suppliers` (`id`, `name`, `company`, `vat_no`, `address`, `city`, `state`, `postal_code`, `country`, `phone`, `email`) VALUES (2, 'dsad', 'sdada', '', '', '', '', '', '', '', '');


#
# TABLE STRUCTURE FOR: tax_rates
#

DROP TABLE IF EXISTS `tax_rates`;

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,4) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `tax_rates` (`id`, `name`, `code`, `rate`, `type`) VALUES (1, 'No Tax', 'NT', '0.0000', '2');
INSERT INTO `tax_rates` (`id`, `name`, `code`, `rate`, `type`) VALUES (2, 'New', 'sda', '2.0000', '2');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
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
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `gender`, `member_unique_id`, `type_id`, `class_id`, `section`, `image`, `address`) VALUES (1, '202.163.79.3', NULL, '$2y$08$ri/9p5Xg3N71kEvbBaf82.p.WhKcB6Rinh9xP2qnrekQAhyJ9RCkO', NULL, 'admin@admin.com', NULL, NULL, NULL, 'Ueg4BIiS4OIXNc7LOs1tn.', 1483613710, 1522059535, 1, 'Admin', 'Admin', 'Repairer', '666666', 'Male', '', 0, 0, '', 'no_image.png', '');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `gender`, `member_unique_id`, `type_id`, `class_id`, `section`, `image`, `address`) VALUES (3, '10.0.2.2', NULL, '$2y$08$wiVgzNffkmBX744xcJX20u5rtuWp.4VhzhnyY60i.1I6e9vmhRmUe', NULL, 'member@member.com', NULL, NULL, NULL, NULL, 1502946236, 1514453253, 1, 'member', 'member', 'ots', '21212', 'Male', '', 0, 0, '', 'no_image.png', '');


#
# TABLE STRUCTURE FOR: users_groups
#

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES (5, 1, 1);
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES (10, 3, 4);


