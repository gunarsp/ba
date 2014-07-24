-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2013 at 11:26 AM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ba01`
--

-- --------------------------------------------------------

--
-- Table structure for table `ba_auditlog`
--

DROP TABLE IF EXISTS `ba_auditlog`;
CREATE TABLE IF NOT EXISTS `ba_auditlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_type` varchar(50) DEFAULT NULL,
  `object_id` bigint(20) unsigned DEFAULT NULL,
  `date` varchar(14) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_chart`
--

DROP TABLE IF EXISTS `ba_chart`;
CREATE TABLE IF NOT EXISTS `ba_chart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(45) DEFAULT NULL,
  `level` varchar(40) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(40) NOT NULL,
  `sum_from` varchar(45) DEFAULT NULL,
  `sum_to` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_classifiers`
--

DROP TABLE IF EXISTS `ba_classifiers`;
CREATE TABLE IF NOT EXISTS `ba_classifiers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_documents`
--

DROP TABLE IF EXISTS `ba_documents`;
CREATE TABLE IF NOT EXISTS `ba_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL,
  `nr` varchar(45) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `notes` text,
  `amount` double DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `date` varchar(14) DEFAULT NULL,
  `amount_base_curr` double DEFAULT NULL,
  `partner_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_journal`
--

DROP TABLE IF EXISTS `ba_journal`;
CREATE TABLE IF NOT EXISTS `ba_journal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notes` text,
  `document_id` int(10) unsigned DEFAULT NULL,
  `date_created` varchar(14) DEFAULT NULL,
  `date_updated` varchar(14) DEFAULT NULL,
  `user_created` int(10) unsigned DEFAULT NULL,
  `user_updated` int(10) unsigned DEFAULT NULL,
  `date` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_organizations`
--

DROP TABLE IF EXISTS `ba_organizations`;
CREATE TABLE IF NOT EXISTS `ba_organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `org_type` int(10) unsigned DEFAULT NULL,
  `registration_nr` varchar(20) DEFAULT NULL,
  `tax_number` varchar(20) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_partners`
--

DROP TABLE IF EXISTS `ba_partners`;
CREATE TABLE IF NOT EXISTS `ba_partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_from` varchar(14) NOT NULL,
  `date_to` varchar(14) DEFAULT NULL,
  `organization_id` int(10) unsigned DEFAULT NULL,
  `person_id` int(10) unsigned DEFAULT NULL,
  `notes` text,
  `supplier` tinyint(3) unsigned DEFAULT NULL,
  `buyer` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_persons`
--

DROP TABLE IF EXISTS `ba_persons`;
CREATE TABLE IF NOT EXISTS `ba_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `personal_code` varchar(20) DEFAULT NULL,
  `birthdate` varchar(14) DEFAULT NULL,
  `gender` int(10) unsigned DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_settings`
--

DROP TABLE IF EXISTS `ba_settings`;
CREATE TABLE IF NOT EXISTS `ba_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_transactions`
--

DROP TABLE IF EXISTS `ba_transactions`;
CREATE TABLE IF NOT EXISTS `ba_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(45) DEFAULT NULL,
  `debit_credit` varchar(20) DEFAULT NULL,
  `amount` double NOT NULL,
  `amount_base_curr` double DEFAULT NULL,
  `notes` text,
  `journal_id` int(10) unsigned NOT NULL,
  `date_created` varchar(14) DEFAULT NULL,
  `date_updated` varchar(14) DEFAULT NULL,
  `user_created` int(10) unsigned DEFAULT NULL,
  `user_updated` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_clients`
--

DROP TABLE IF EXISTS `ba_clients`;
CREATE TABLE IF NOT EXISTS `ba_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL DEFAULT '',
  `client_address` varchar(100) NOT NULL DEFAULT '',
  `client_address_2` varchar(100) NOT NULL DEFAULT '',
  `client_city` varchar(50) NOT NULL DEFAULT '',
  `client_state` varchar(50) NOT NULL DEFAULT '',
  `client_zip` varchar(10) NOT NULL DEFAULT '',
  `client_country` varchar(50) NOT NULL DEFAULT '',
  `client_phone_number` varchar(25) NOT NULL DEFAULT '',
  `client_fax_number` varchar(25) NOT NULL DEFAULT '',
  `client_mobile_number` varchar(25) NOT NULL DEFAULT '',
  `client_email_address` varchar(100) NOT NULL DEFAULT '',
  `client_web_address` varchar(255) NOT NULL DEFAULT '',
  `client_notes` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `client_tax_id` varchar(25) NOT NULL DEFAULT '',
  `client_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_client_credits`
--

DROP TABLE IF EXISTS `ba_client_credits`;
CREATE TABLE IF NOT EXISTS `ba_client_credits` (
  `client_credit_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_credit_client_id` int(11) NOT NULL,
  `client_credit_date` varchar(14) NOT NULL DEFAULT '',
  `client_credit_amount` decimal(10,2) NOT NULL,
  `client_credit_note` longtext NOT NULL,
  PRIMARY KEY (`client_credit_id`),
  KEY `client_credit_client_id` (`client_credit_client_id`,`client_credit_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_client_data`
--

DROP TABLE IF EXISTS `ba_client_data`;
CREATE TABLE IF NOT EXISTS `ba_client_data` (
  `ba_client_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `ba_client_key` varchar(50) NOT NULL DEFAULT '',
  `ba_client_value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ba_client_data_id`),
  KEY `client_id` (`client_id`),
  KEY `ba_client_key` (`ba_client_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_contacts`
--

DROP TABLE IF EXISTS `ba_contacts`;
CREATE TABLE IF NOT EXISTS `ba_contacts` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `address_2` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(50) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `phone_number` varchar(25) NOT NULL DEFAULT '',
  `fax_number` varchar(25) NOT NULL DEFAULT '',
  `mobile_number` varchar(25) NOT NULL DEFAULT '',
  `email_address` varchar(100) NOT NULL DEFAULT '',
  `web_address` varchar(255) NOT NULL DEFAULT '',
  `notes` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`contact_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_data`
--

DROP TABLE IF EXISTS `ba_data`;
CREATE TABLE IF NOT EXISTS `ba_data` (
  `ba_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `ba_key` varchar(50) NOT NULL DEFAULT '',
  `ba_value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ba_data_id`),
  UNIQUE KEY `ba_data_key` (`ba_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_email_templates`
--

DROP TABLE IF EXISTS `ba_email_templates`;
CREATE TABLE IF NOT EXISTS `ba_email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_template_user_id` int(11) NOT NULL,
  `email_template_title` varchar(50) NOT NULL DEFAULT '',
  `email_template_body` longtext NOT NULL,
  `email_template_footer` longtext NOT NULL,
  PRIMARY KEY (`email_template_id`),
  KEY `email_template_user_id` (`email_template_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_fields`
--

DROP TABLE IF EXISTS `ba_fields`;
CREATE TABLE IF NOT EXISTS `ba_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `field_name` varchar(50) NOT NULL DEFAULT '',
  `field_index` int(11) NOT NULL DEFAULT '0',
  `column_name` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`field_id`),
  KEY `object_id` (`object_id`),
  KEY `field_index` (`field_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_inventory`
--

DROP TABLE IF EXISTS `ba_inventory`;
CREATE TABLE IF NOT EXISTS `ba_inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_type_id` int(11) NOT NULL DEFAULT '0',
  `inventory_tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `inventory_name` varchar(255) NOT NULL DEFAULT '',
  `inventory_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `inventory_description` longtext,
  `inventory_track_stock` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inventory_id`),
  KEY `inventory_type_id` (`inventory_type_id`),
  KEY `inventory_tax_rate_id` (`inventory_tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_inventory_stock`
--

DROP TABLE IF EXISTS `ba_inventory_stock`;
CREATE TABLE IF NOT EXISTS `ba_inventory_stock` (
  `inventory_stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` int(11) NOT NULL DEFAULT '0',
  `invoice_item_id` int(11) NOT NULL DEFAULT '0',
  `inventory_stock_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `inventory_stock_date` varchar(14) NOT NULL DEFAULT '',
  `inventory_stock_notes` longtext,
  PRIMARY KEY (`inventory_stock_id`),
  KEY `inventory_id` (`inventory_id`),
  KEY `invoice_item_id` (`invoice_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_inventory_types`
--

DROP TABLE IF EXISTS `ba_inventory_types`;
CREATE TABLE IF NOT EXISTS `ba_inventory_types` (
  `inventory_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_type` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`inventory_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoices`
--

DROP TABLE IF EXISTS `ba_invoices`;
CREATE TABLE IF NOT EXISTS `ba_invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `invoice_status_id` int(11) NOT NULL DEFAULT '0',
  `invoice_date_entered` varchar(14) NOT NULL DEFAULT '',
  `invoice_number` varchar(50) NOT NULL DEFAULT '',
  `invoice_notes` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `invoice_due_date` varchar(14) NOT NULL DEFAULT '',
  `invoice_is_quote` int(1) NOT NULL DEFAULT '0',
  `invoice_group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_id`),
  KEY `client_id` (`client_id`),
  KEY `user_id` (`user_id`),
  KEY `invoice_status_id` (`invoice_status_id`),
  KEY `invoice_group_id` (`invoice_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_amounts`
--

DROP TABLE IF EXISTS `ba_invoice_amounts`;
CREATE TABLE IF NOT EXISTS `ba_invoice_amounts` (
  `invoice_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `invoice_item_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_item_taxable` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_item_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`invoice_amount_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_groups`
--

DROP TABLE IF EXISTS `ba_invoice_groups`;
CREATE TABLE IF NOT EXISTS `ba_invoice_groups` (
  `invoice_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_group_name` varchar(50) NOT NULL DEFAULT '',
  `invoice_group_prefix` varchar(10) NOT NULL DEFAULT '',
  `invoice_group_next_id` int(11) NOT NULL DEFAULT '0',
  `invoice_group_left_pad` int(2) NOT NULL DEFAULT '0',
  `invoice_group_prefix_year` int(1) NOT NULL DEFAULT '0',
  `invoice_group_prefix_month` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_group_id`),
  KEY `invoice_group_next_id` (`invoice_group_next_id`),
  KEY `invoice_group_left_pad` (`invoice_group_left_pad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_history`
--

DROP TABLE IF EXISTS `ba_invoice_history`;
CREATE TABLE IF NOT EXISTS `ba_invoice_history` (
  `invoice_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `invoice_history_date` varchar(14) NOT NULL DEFAULT '',
  `invoice_history_data` longtext,
  PRIMARY KEY (`invoice_history_id`),
  KEY `user_id` (`user_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_items`
--

DROP TABLE IF EXISTS `ba_invoice_items`;
CREATE TABLE IF NOT EXISTS `ba_invoice_items` (
  `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `inventory_id` int(11) NOT NULL DEFAULT '0',
  `item_name` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `item_description` longtext,
  `item_date` varchar(14) NOT NULL DEFAULT '',
  `item_qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `is_taxable` int(1) NOT NULL DEFAULT '0',
  `item_tax_option` int(1) NOT NULL DEFAULT '0',
  `item_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_item_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `inventory_id` (`inventory_id`),
  KEY `item_order` (`item_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_item_amounts`
--

DROP TABLE IF EXISTS `ba_invoice_item_amounts`;
CREATE TABLE IF NOT EXISTS `ba_invoice_item_amounts` (
  `invoice_item_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_item_id` int(11) NOT NULL DEFAULT '0',
  `item_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`invoice_item_amount_id`),
  KEY `invoice_item_id` (`invoice_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_statuses`
--

DROP TABLE IF EXISTS `ba_invoice_statuses`;
CREATE TABLE IF NOT EXISTS `ba_invoice_statuses` (
  `invoice_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_status` varchar(255) NOT NULL DEFAULT '',
  `invoice_status_type` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_tags`
--

DROP TABLE IF EXISTS `ba_invoice_tags`;
CREATE TABLE IF NOT EXISTS `ba_invoice_tags` (
  `invoice_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_tag_id`),
  KEY `invoice_id` (`invoice_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_invoice_tax_rates`
--

DROP TABLE IF EXISTS `ba_invoice_tax_rates`;
CREATE TABLE IF NOT EXISTS `ba_invoice_tax_rates` (
  `invoice_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `tax_rate_option` int(1) NOT NULL DEFAULT '1',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`invoice_tax_rate_id`),
  KEY `invoice_id` (`invoice_id`,`tax_rate_id`),
  KEY `tax_rate_option` (`tax_rate_option`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_merchant_responses`
--

DROP TABLE IF EXISTS `ba_merchant_responses`;
CREATE TABLE IF NOT EXISTS `ba_merchant_responses` (
  `merchant_response_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_response_payment_id` int(11) NOT NULL,
  `merchant_response_client_id` int(11) NOT NULL,
  `merchant_response_invoice_id` int(11) NOT NULL,
  `merchant_response_amount` decimal(10,2) NOT NULL,
  `merchant_response_method` varchar(25) NOT NULL DEFAULT '',
  `merchant_response_status` varchar(25) NOT NULL DEFAULT '',
  `merchant_response_payment_status` varchar(25) NOT NULL DEFAULT '',
  `merchant_response_payment_processed` int(1) NOT NULL DEFAULT '0',
  `merchant_response_post` longtext NOT NULL,
  PRIMARY KEY (`merchant_response_id`),
  KEY `merchant_response_payment_id` (`merchant_response_payment_id`,`merchant_response_client_id`,`merchant_response_invoice_id`),
  KEY `merchant_response_payment_processed` (`merchant_response_payment_processed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_modules`
--

DROP TABLE IF EXISTS `ba_modules`;
CREATE TABLE IF NOT EXISTS `ba_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_path` varchar(50) NOT NULL DEFAULT '',
  `module_name` varchar(50) NOT NULL DEFAULT '',
  `module_description` varchar(255) NOT NULL DEFAULT '',
  `module_enabled` int(1) NOT NULL DEFAULT '0',
  `module_author` varchar(50) NOT NULL DEFAULT '',
  `module_homepage` varchar(255) NOT NULL DEFAULT '',
  `module_version` varchar(25) NOT NULL DEFAULT '',
  `module_available_version` varchar(25) NOT NULL DEFAULT '',
  `module_config` longtext,
  `module_core` int(1) NOT NULL DEFAULT '0',
  `module_order` int(2) NOT NULL DEFAULT '99',
  PRIMARY KEY (`module_id`),
  KEY `module_order` (`module_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_payments`
--

DROP TABLE IF EXISTS `ba_payments`;
CREATE TABLE IF NOT EXISTS `ba_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `payment_method_id` int(11) NOT NULL DEFAULT '0',
  `payment_date` varchar(14) NOT NULL DEFAULT '',
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_note` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`payment_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `payment_method_id` (`payment_method_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_payment_methods`
--

DROP TABLE IF EXISTS `ba_payment_methods`;
CREATE TABLE IF NOT EXISTS `ba_payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`payment_method_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_tags`
--

DROP TABLE IF EXISTS `ba_tags`;
CREATE TABLE IF NOT EXISTS `ba_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_tax_rates`
--

DROP TABLE IF EXISTS `ba_tax_rates`;
CREATE TABLE IF NOT EXISTS `ba_tax_rates` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate_name` varchar(25) NOT NULL DEFAULT '',
  `tax_rate_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_userdata`
--

DROP TABLE IF EXISTS `ba_userdata`;
CREATE TABLE IF NOT EXISTS `ba_userdata` (
  `ba_userdata_id` int(11) NOT NULL AUTO_INCREMENT,
  `ba_userdata_user_id` int(11) NOT NULL,
  `ba_userdata_key` varchar(50) NOT NULL DEFAULT '',
  `ba_userdata_value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ba_userdata_id`),
  KEY `ba_data_key` (`ba_userdata_key`),
  KEY `ba_userdata_user_id` (`ba_userdata_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ba_users`
--

DROP TABLE IF EXISTS `ba_users`;
CREATE TABLE IF NOT EXISTS `ba_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `global_admin` int(1) NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `address_2` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(50) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `phone_number` varchar(25) NOT NULL DEFAULT '',
  `fax_number` varchar(25) NOT NULL DEFAULT '',
  `mobile_number` varchar(25) NOT NULL DEFAULT '',
  `email_address` varchar(100) NOT NULL DEFAULT '',
  `web_address` varchar(255) NOT NULL DEFAULT '',
  `company_name` varchar(255) NOT NULL DEFAULT '',
  `last_login` varchar(25) NOT NULL DEFAULT '',
  `tax_id_number` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
