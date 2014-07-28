<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Setup extends MY_Model {

	public $install_version = '0.1.0';

	public $upgrade_path;

	function __construct() {

		parent::__construct();

		$this->table_name = 'ba_users';

		$this->primary_key = 'ba_users.user_id';

		$this->upgrade_path = array(
				array(
						'from'		=> '0.1.0',
						'to'		=> '0.1.1',
						'function'	=> 'u010'
				),
				array(
						'from'		=> '0.1.1',
						'to'		=> '0.1.2',
						'function'	=> 'u011'
				),
					
		);

		$this->load->model('ba_data/mdl_ba_data');
		$this->load->model('ba_modules/mdl_ba_modules');
		$this->load->model('invoices/mdl_invoice_amounts');
		$this->load->model('fields/mdl_fields');

	}

	function validate_database() {

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('hostname', $this->lang->line('database_server'), 'required');
		$this->form_validation->set_rules('database', $this->lang->line('database_name'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('database_username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('database_password'), 'required');

		return parent::validate();

	}

	function validate() {

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required');
		$this->form_validation->set_rules('passwordv', $this->lang->line('password_verify'), 'required|matches[password]');
		$this->form_validation->set_rules('address', $this->lang->line('street_address'));
		$this->form_validation->set_rules('address', $this->lang->line('street_address_2'));
		$this->form_validation->set_rules('city', $this->lang->line('city'));
		$this->form_validation->set_rules('state', $this->lang->line('state'));
		$this->form_validation->set_rules('zip', $this->lang->line('zip'));
		$this->form_validation->set_rules('country', $this->lang->line('country'));
		$this->form_validation->set_rules('phone_number', $this->lang->line('phone_number'));
		$this->form_validation->set_rules('fax_number', $this->lang->line('fax_number'));
		$this->form_validation->set_rules('mobile_number', $this->lang->line('mobile_number'));
		$this->form_validation->set_rules('email_address', $this->lang->line('email_address'));
		$this->form_validation->set_rules('web_address', $this->lang->line('web_address'));
		$this->form_validation->set_rules('company_name', $this->lang->line('company_name'));

		return parent::validate();

	}

	function db_install() {

		$return = array();

		$this->load->database();

		// $this->db->db_debug = 0;

		if ($this->db_install_tables()) {

			$return[] = $this->lang->line('install_database_success');

		}

		else {

			$return[] = $this->lang->line('install_database_problem');

			return $return;

		}

		$db_array = parent::db_array();

		$db_array['password'] = md5($db_array['password']);
		$db_array['global_admin'] = 1;

		unset($db_array['passwordv']);

		if (parent::save($db_array, NULL, FALSE)) {

			$return[] = $this->lang->line('install_admin_account_success');

		}

		else {

			$return[] = $this->lang->line('install_admin_account_problem');

			return $return;

		}

		$return[] = $this->lang->line('installation_complete');

		$return[] = $this->lang->line('install_delete_folder');

		$return[] = APPPATH . 'modules_core/setup';

		$return[] = anchor('sessions/login', $this->lang->line('log_in'));

		$this->mdl_ba_modules->refresh();

		return $return;

	}

	function db_install_tables() {

		foreach ($this->db_tables() as $query) {

			if (!$this->db->query($query)) {

				return FALSE;

			}

		}

		$this->install_table_data();

		$this->install_ba_data();
		
		$this->install_classifiers_data();

		$this->mdl_ba_data->save('version', $this->install_version);

		return TRUE;

	}

	function db_tables() {

		return array(
				
				"CREATE TABLE IF NOT EXISTS `ba_attachments` (
						`attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						`attachment_file` varchar(200) DEFAULT NULL,
						`attachment_note` varchar(200) DEFAULT NULL,
						`document_id` int(10) unsigned DEFAULT NULL,
						PRIMARY KEY (`attachment_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",
		
				"CREATE TABLE IF NOT EXISTS `ba_auditlog` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`object_type` varchar(50) DEFAULT NULL,
				`object_id` bigint(20) unsigned DEFAULT NULL,
				`date` varchar(14) DEFAULT NULL,
				`action` varchar(100) DEFAULT NULL,
				`user_id` int(10) unsigned DEFAULT NULL,
				`notes` text,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_chart` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`account` varchar(45) DEFAULT NULL,
				`level` varchar(40) NOT NULL,
				`name` varchar(200) DEFAULT NULL,
				`type` varchar(40) NOT NULL,
				`sum_from` varchar(45) DEFAULT NULL,
				`sum_to` varchar(45) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_classifiers` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`type` varchar(40) NOT NULL,
				`name` varchar(100) NOT NULL,
				`value` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;",

				"CREATE TABLE IF NOT EXISTS `ba_documents` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_journal` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`notes` text,
				`document_id` int(10) unsigned DEFAULT NULL,
				`date_created` varchar(14) DEFAULT NULL,
				`date_updated` varchar(14) DEFAULT NULL,
				`user_created` int(10) unsigned DEFAULT NULL,
				`user_updated` int(10) unsigned DEFAULT NULL,
				`date` varchar(14) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_organizations` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) DEFAULT NULL,
				`org_type` int(10) unsigned DEFAULT NULL,
				`registration_nr` varchar(20) DEFAULT NULL,
				`tax_number` varchar(20) DEFAULT NULL,
				`notes` text,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_partners` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`date_from` varchar(14) NOT NULL,
				`date_to` varchar(14) DEFAULT NULL,
				`organization_id` int(10) unsigned DEFAULT NULL,
				`person_id` int(10) unsigned DEFAULT NULL,
				`notes` text,
				`supplier` tinyint(3) unsigned DEFAULT NULL,
				`buyer` tinyint(3) unsigned DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_persons` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) DEFAULT NULL,
				`surname` varchar(100) DEFAULT NULL,
				`personal_code` varchar(20) DEFAULT NULL,
				`birthdate` varchar(14) DEFAULT NULL,
				`gender` int(10) unsigned DEFAULT NULL,
				`notes` text,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_settings` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`value` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_transactions` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_clients` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_client_credits` (
				`client_credit_id` int(11) NOT NULL AUTO_INCREMENT,
				`client_credit_client_id` int(11) NOT NULL,
				`client_credit_date` varchar(14) NOT NULL DEFAULT '',
				`client_credit_amount` decimal(10,2) NOT NULL,
				`client_credit_note` longtext NOT NULL,
				PRIMARY KEY (`client_credit_id`),
				KEY `client_credit_client_id` (`client_credit_client_id`,`client_credit_date`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_client_data` (
				`ba_client_data_id` int(11) NOT NULL AUTO_INCREMENT,
				`client_id` int(11) NOT NULL DEFAULT '0',
				`ba_client_key` varchar(50) NOT NULL DEFAULT '',
				`ba_client_value` varchar(100) NOT NULL DEFAULT '',
				PRIMARY KEY (`ba_client_data_id`),
				KEY `client_id` (`client_id`),
				KEY `ba_client_key` (`ba_client_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_contacts` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_data` (
				`ba_data_id` int(11) NOT NULL AUTO_INCREMENT,
				`ba_key` varchar(50) NOT NULL DEFAULT '',
				`ba_value` varchar(100) NOT NULL DEFAULT '',
				PRIMARY KEY (`ba_data_id`),
				UNIQUE KEY `ba_data_key` (`ba_key`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;",

				"CREATE TABLE IF NOT EXISTS `ba_email_templates` (
				`email_template_id` int(11) NOT NULL AUTO_INCREMENT,
				`email_template_user_id` int(11) NOT NULL,
				`email_template_title` varchar(50) NOT NULL DEFAULT '',
				`email_template_body` longtext NOT NULL,
				`email_template_footer` longtext NOT NULL,
				PRIMARY KEY (`email_template_id`),
				KEY `email_template_user_id` (`email_template_user_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_fields` (
				`field_id` int(11) NOT NULL AUTO_INCREMENT,
				`object_id` int(11) NOT NULL DEFAULT '0',
				`field_name` varchar(50) NOT NULL DEFAULT '',
				`field_index` int(11) NOT NULL DEFAULT '0',
				`column_name` varchar(25) NOT NULL DEFAULT '',
				PRIMARY KEY (`field_id`),
				KEY `object_id` (`object_id`),
				KEY `field_index` (`field_index`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_inventory` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_inventory_stock` (
				`inventory_stock_id` int(11) NOT NULL AUTO_INCREMENT,
				`inventory_id` int(11) NOT NULL DEFAULT '0',
				`invoice_item_id` int(11) NOT NULL DEFAULT '0',
				`inventory_stock_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
				`inventory_stock_date` varchar(14) NOT NULL DEFAULT '',
				`inventory_stock_notes` longtext,
				PRIMARY KEY (`inventory_stock_id`),
				KEY `inventory_id` (`inventory_id`),
				KEY `invoice_item_id` (`invoice_item_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_inventory_types` (
				`inventory_type_id` int(11) NOT NULL AUTO_INCREMENT,
				`inventory_type` varchar(50) NOT NULL DEFAULT '',
				PRIMARY KEY (`inventory_type_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

				"CREATE TABLE IF NOT EXISTS `ba_invoices` (
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
				`document_type_id` smallint(5) unsigned DEFAULT NULL,
				`document_incoming` tinyint(3) unsigned DEFAULT NULL COMMENT 'Is incoming.',
				`document_attachment` varchar(200) DEFAULT NULL,
				PRIMARY KEY (`invoice_id`),
				KEY `client_id` (`client_id`),
				KEY `user_id` (`user_id`),
				KEY `invoice_status_id` (`invoice_status_id`),
				KEY `invoice_group_id` (`invoice_group_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_amounts` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_groups` (
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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_history` (
				`invoice_history_id` int(11) NOT NULL AUTO_INCREMENT,
				`invoice_id` int(11) NOT NULL DEFAULT '0',
				`user_id` int(11) NOT NULL DEFAULT '0',
				`invoice_history_date` varchar(14) NOT NULL DEFAULT '',
				`invoice_history_data` longtext,
				PRIMARY KEY (`invoice_history_id`),
				KEY `user_id` (`user_id`),
				KEY `invoice_id` (`invoice_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_items` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_item_amounts` (
				`invoice_item_amount_id` int(11) NOT NULL AUTO_INCREMENT,
				`invoice_item_id` int(11) NOT NULL DEFAULT '0',
				`item_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
				`item_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
				`item_total` decimal(10,2) NOT NULL DEFAULT '0.00',
				PRIMARY KEY (`invoice_item_amount_id`),
				KEY `invoice_item_id` (`invoice_item_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_statuses` (
				`invoice_status_id` int(11) NOT NULL AUTO_INCREMENT,
				`invoice_status` varchar(255) NOT NULL DEFAULT '',
				`invoice_status_type` int(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`invoice_status_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_tags` (
				`invoice_tag_id` int(11) NOT NULL AUTO_INCREMENT,
				`invoice_id` int(11) NOT NULL DEFAULT '0',
				`tag_id` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`invoice_tag_id`),
				KEY `invoice_id` (`invoice_id`,`tag_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_invoice_tax_rates` (
				`invoice_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
				`invoice_id` int(11) NOT NULL DEFAULT '0',
				`tax_rate_id` int(11) NOT NULL DEFAULT '0',
				`tax_rate_option` int(1) NOT NULL DEFAULT '1',
				`tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
				PRIMARY KEY (`invoice_tax_rate_id`),
				KEY `invoice_id` (`invoice_id`,`tax_rate_id`),
				KEY `tax_rate_option` (`tax_rate_option`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_merchant_responses` (
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_modules` (
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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;",

		"CREATE TABLE IF NOT EXISTS `ba_payments` (
		`payment_id` int(11) NOT NULL AUTO_INCREMENT,
		`invoice_id` int(11) NOT NULL DEFAULT '0',
		`payment_method_id` int(11) NOT NULL DEFAULT '0',
		`payment_date` varchar(14) NOT NULL DEFAULT '',
		`payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
		`payment_note` longtext CHARACTER SET utf8 COLLATE utf8_bin,
		PRIMARY KEY (`payment_id`),
		KEY `invoice_id` (`invoice_id`),
		KEY `payment_method_id` (`payment_method_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_payment_methods` (
		`payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
		`payment_method` varchar(25) NOT NULL DEFAULT '',
		PRIMARY KEY (`payment_method_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;",

		"CREATE TABLE IF NOT EXISTS `ba_tags` (
		`tag_id` int(11) NOT NULL AUTO_INCREMENT,
		`tag` varchar(50) NOT NULL DEFAULT '',
		PRIMARY KEY (`tag_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_tax_rates` (
		`tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
		`tax_rate_name` varchar(25) NOT NULL DEFAULT '',
		`tax_rate_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
		PRIMARY KEY (`tax_rate_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;",

		"CREATE TABLE IF NOT EXISTS `ba_userdata` (
		`ba_userdata_id` int(11) NOT NULL AUTO_INCREMENT,
		`ba_userdata_user_id` int(11) NOT NULL,
		`ba_userdata_key` varchar(50) NOT NULL DEFAULT '',
		`ba_userdata_value` varchar(100) NOT NULL DEFAULT '',
		PRIMARY KEY (`ba_userdata_id`),
		KEY `ba_data_key` (`ba_userdata_key`),
		KEY `ba_userdata_user_id` (`ba_userdata_user_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",

		"CREATE TABLE IF NOT EXISTS `ba_users` (
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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;",

		);

	}

	function db_upgrade() {

		$this->load->database();

		$return = array();

		if ($this->mdl_ba_data->get('version') <> $this->install_version) {

			foreach ($this->upgrade_path as $path) {

				$app_version = $this->mdl_ba_data->get('version');

				if ($path['from'] == $app_version) {

					if ($this->{$path['function']}()) {

						$return[] = 'Upgrade from ' . $path['from'] . ' to ' . $path['to'] . ' successful<br />';

					}

					else {

						$return[] = 'Upgrade from ' . $path['from'] . ' to ' . $path['to'] . ' FAILED. Script exiting.';

						return $return;

					}

				}

			}

			$return[] = $this->lang->line('upgrade_complete');

			$return[] = $this->lang->line('install_delete_folder');

			$return[] = APPPATH . 'modules_core/setup';

			$return[] = anchor('sessions/login', $this->lang->line('log_in'));

			$this->install_ba_data();

			$this->mdl_ba_modules->refresh();

			$this->mdl_invoice_amounts->adjust();

			return $return;

		}

		else {
				
			$return[] = anchor('sessions/login', $this->lang->line('log_in'));

			$return[] = $this->lang->line('install_already_current');

			return $return;

		}

	}

	function u010() {

		$queries = array(

				"CREATE TABLE `ba_fields` (
				`field_id` int(11) NOT NULL AUTO_INCREMENT,
				`object_id` int(11) NOT NULL,
				`field_name` varchar(50) NOT NULL DEFAULT '',
				`field_index` int(11) NOT NULL,
				`column_name` varchar(25) NOT NULL DEFAULT '',
				PRIMARY KEY (`field_id`),
				KEY `object_id` (`object_id`),
				KEY `field_index` (`field_index`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",

				"ALTER TABLE `ba_modules` ADD `module_order` INT( 2 ) NOT NULL DEFAULT '99',
				ADD INDEX ( `module_order` )",

				"ALTER TABLE `ba_invoice_groups` ADD `invoice_group_prefix_year` INT( 1 ) NOT NULL DEFAULT '0',
				ADD `invoice_group_prefix_month` INT( 1 ) NOT NULL DEFAULT '0'"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		if ($this->db->field_exists('invoice_stored_description', 'ba_invoice_stored_items')) {

			$this->db->query("ALTER TABLE `ba_invoice_stored_items` CHANGE `invoice_stored_description` `invoice_stored_item_description` LONGTEXT NOT NULL");

		}

		$this->mdl_ba_data->save('version', '0.1.0');

		return TRUE;

	}

	function u011() {

		$this->mdl_ba_data->save('version', '0.1.1');

		return TRUE;

	}

	function u0112() {

		$queries = array(
				"ALTER TABLE `ba_clients` CHANGE `client_name` `client_name` varchar(255) NOT NULL DEFAULT '' AFTER client_id",
				"ALTER TABLE `ba_clients` CHANGE `client_country` `client_country` VARCHAR( 50 ) NOT NULL DEFAULT ''"
		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mdl_ba_data->save('version', '0.1.1.2');

		return TRUE;

	}

	function u012() {

		$queries = array(

				"RENAME TABLE `ba_invoice_stored_items` TO `ba_inventory`",

				"ALTER TABLE `ba_inventory`
				CHANGE `invoice_stored_item_id` `inventory_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
				CHANGE `invoice_stored_item` `inventory_name` VARCHAR( 255 ) NOT NULL DEFAULT '',
				CHANGE `invoice_stored_unit_price` `inventory_unit_price` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
				CHANGE `invoice_stored_item_description` `inventory_description` LONGTEXT NOT NULL,
				ADD `inventory_type_id` INT NOT NULL AFTER `inventory_id` ,
				ADD `inventory_track_stock` int(1) NOT NULL DEFAULT '0',
				ADD `tax_rate_id` INT NOT NULL AFTER `inventory_type_id`,
				ADD INDEX ( `inventory_type_id` ),
				ADD INDEX ( `tax_rate_id` )",

				"ALTER TABLE `ba_invoice_items` ADD `inventory_id` INT NOT NULL AFTER `invoice_id` ,
				ADD INDEX ( `inventory_id` )",

				"CREATE TABLE `ba_inventory_stock` (
				`inventory_stock_id` int(11) NOT NULL AUTO_INCREMENT,
				`inventory_id` int(11) NOT NULL,
				`invoice_item_id` int(11) NOT NULL,
				`inventory_stock_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
				`inventory_stock_date` varchar(14) NOT NULL DEFAULT '',
				`inventory_stock_notes` LONGTEXT NOT NULL,
				PRIMARY KEY (`inventory_stock_id`),
				KEY `inventory_id` (`inventory_id`),
				KEY `invoice_item_id` (`invoice_item_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

				"CREATE TABLE `ba_inventory_types` (
				`inventory_type_id` int(11) NOT NULL AUTO_INCREMENT,
				`inventory_type` varchar(50) NOT NULL DEFAULT '',
				PRIMARY KEY (`inventory_type_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

				"ALTER TABLE `ba_invoice_items` ADD `item_order` INT NOT NULL ,
				ADD INDEX ( `item_order` )",

				"ALTER TABLE `ba_users` ADD `client_id` INT NOT NULL AFTER `user_id` ,
				ADD INDEX ( `client_id` ) "

		);

		$this->run_queries($queries);

		$this->db->select('invoice_item_id, invoice_id, item_order');
		$this->db->order_by('invoice_item_id');
		$items = $this->db->get('ba_invoice_items')->result();

		foreach ($items as $item) {

			if (!isset($tmp_invoice_id) or isset($tmp_invoice_id) and $tmp_invoice_id <> $item->invoice_id) {

				$x = 1;

			}

			$this->db->where('invoice_item_id', $item->invoice_item_id);
			$this->db->set('item_order', $x);
			$this->db->update('ba_invoice_items');

			$x++;

			$tmp_invoice_id = $item->invoice_id;

		}

		if ($this->db->table_exists('ba_client_center')) {

			$client_accounts = $this->db->get('ba_client_center')->result();

			foreach ($client_accounts as $user) {

				if ($user->client_id) {

					$db_array = array(
							'client_id' => $user->client_id,
							'username' => $user->username,
							'password' => $user->password,
							'last_login' => $user->last_login
					);

					$this->db->insert('ba_users', $db_array);

				}

			}

			$this->load->dbforge();

			$this->dbforge->drop_table('ba_client_center');

		}

		$this->mdl_ba_data->save('version', '0.1.2');

		return TRUE;

	}

	function u013() {

		$queries = array(
				"ALTER TABLE `ba_users` CHANGE `client_id` `client_id` INT( 11 ) NOT NULL DEFAULT '0'"
		);

		$this->run_queries($queries);

		$this->mdl_ba_data->save('version', '0.1.3');

		return TRUE;

	}

	function install_ba_data() {

		$this->mdl_ba_data->save('application_title', $this->lang->line('businessassistant'), TRUE);
		$this->mdl_ba_data->save('cc_enable_client_tax_id', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_address', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_address_2', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_city', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_state', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_zip', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_country', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_phone_number', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_fax_number', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_mobile_number', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_email_address', 0, TRUE);
		$this->mdl_ba_data->save('cc_enable_client_web_address', 0, TRUE);
		$this->mdl_ba_data->save('cc_edit_enabled', 0, TRUE);
		$this->mdl_ba_data->save('cron_key', '', TRUE);
		$this->mdl_ba_data->save('currency_symbol', '$', TRUE);
		$this->mdl_ba_data->save('currency_symbol_placement', 'before', TRUE);
		$this->mdl_ba_data->save('dashboard_override', '', TRUE);
		$this->mdl_ba_data->save('dashboard_show_closed_invoices', 'TRUE', TRUE);
		$this->mdl_ba_data->save('dashboard_show_open_invoices', 'TRUE', TRUE);
		$this->mdl_ba_data->save('dashboard_show_overdue_invoices', 'TRUE', TRUE);
		$this->mdl_ba_data->save('dashboard_show_pending_invoices', 'TRUE', TRUE);
		$this->mdl_ba_data->save('dashboard_total_paid_cutoff_date', '', TRUE);
		$this->mdl_ba_data->save('decimal_symbol', '.', TRUE);
		$this->mdl_ba_data->save('decimal_taxes_num', 2, TRUE);
		$this->mdl_ba_data->save('default_bcc', '', TRUE);
		$this->mdl_ba_data->save('default_cc', '', TRUE);
		$this->mdl_ba_data->save('default_closed_status_id', 3, TRUE);
		$this->mdl_ba_data->save('default_date_format', 'm/d/Y', TRUE);
		$this->mdl_ba_data->save('default_date_format_mask', '99/99/9999', TRUE);
		$this->mdl_ba_data->save('default_date_format_picker', 'mm/dd/yy', TRUE);
		$this->mdl_ba_data->save('default_email_body', '', TRUE);
		$this->mdl_ba_data->save('default_invoice_group_id', 1, TRUE);
		$this->mdl_ba_data->save('default_invoice_template', 'default', TRUE);
		$this->mdl_ba_data->save('default_item_tax_rate_id', 1, TRUE);
		$this->mdl_ba_data->save('default_item_tax_rate_option', 0, TRUE);
		$this->mdl_ba_data->save('default_language', 'english', TRUE);
		$this->mdl_ba_data->save('default_open_status_id', 1, TRUE);
		$this->mdl_ba_data->save('default_quote_group_id', 1, TRUE);
		$this->mdl_ba_data->save('default_quote_template', 'default_quote', TRUE);
		$this->mdl_ba_data->save('default_receipt_template', 'default', TRUE);
		$this->mdl_ba_data->save('default_tax_rate_id', 1, TRUE);
		$this->mdl_ba_data->save('default_tax_rate_option', 1, TRUE);
		$this->mdl_ba_data->save('disable_invoice_audit_history', 0, TRUE);
		$this->mdl_ba_data->save('display_quantity_decimals', 1, TRUE);
		$this->mdl_ba_data->save('email_protocol', 'php_mail_function', TRUE);
		$this->mdl_ba_data->save('enable_profiler', 0, TRUE);
		$this->mdl_ba_data->save('include_logo_on_invoice', 'FALSE', TRUE);
		$this->mdl_ba_data->save('invoices_due_after', '30', TRUE);
		$this->mdl_ba_data->save('merchant_currency_code', 'USD', TRUE);
		$this->mdl_ba_data->save('merchant_driver', 'Paypal', TRUE);
		$this->mdl_ba_data->save('merchant_enabled', 0, TRUE);
		$this->mdl_ba_data->save('pdf_plugin', 'dompdf', TRUE);
		$this->mdl_ba_data->save('results_per_page', 15, TRUE);
		$this->mdl_ba_data->save('sendmail_path', '', TRUE);
		$this->mdl_ba_data->save('smtp_host', '', TRUE);
		$this->mdl_ba_data->save('smtp_pass', '', TRUE);
		$this->mdl_ba_data->save('smtp_port', '', TRUE);
		$this->mdl_ba_data->save('smtp_timeout', '', TRUE);
		$this->mdl_ba_data->save('smtp_user', '', TRUE);
		$this->mdl_ba_data->save('thousands_separator', ',', TRUE);

	}

	function install_table_data() {

		$this->db->insert('ba_tax_rates', array('tax_rate_id'=>1,'tax_rate_name'=>$this->lang->line('no_tax'),'tax_rate_percent'=>'0.00'));
		$this->db->insert('ba_tax_rates', array('tax_rate_id'=>2,'tax_rate_name'=>$this->lang->line('vat'),'tax_rate_percent'=>'22.00'));

		$this->db->insert('ba_payment_methods', array('payment_method'=>$this->lang->line('cash')));
		$this->db->insert('ba_payment_methods', array('payment_method'=>$this->lang->line('check')));
		$this->db->insert('ba_payment_methods', array('payment_method'=>$this->lang->line('credit')));

		$this->db->insert('ba_invoice_statuses', array('invoice_status_id'=>1,'invoice_status'=>$this->lang->line('open'),'invoice_status_type'=>1));
		$this->db->insert('ba_invoice_statuses', array('invoice_status_id'=>2,'invoice_status'=>$this->lang->line('pending'),'invoice_status_type'=>2));
		$this->db->insert('ba_invoice_statuses', array('invoice_status_id'=>3,'invoice_status'=>$this->lang->line('closed'),'invoice_status_type'=>3));

		$this->db->insert('ba_invoice_groups', array('invoice_group_name'=>$this->lang->line('simple_increment'),'invoice_group_next_id'=>1));

	}
	
	function install_classifiers_data() {
		
		$queries = array(
		"INSERT INTO `ba_classifiers` (`id`, `type`, `name`, `value`) VALUES
		(1, 'organization_type', 'Sabiedrība ar ierobežotu atbildību', 'SIA'),
		(2, 'organization_type', 'Akciju sabiedrība', 'AS'),
		(3, 'organization_type', 'Individuālais komersants', 'IK'),
		(4, 'currency', 'Lat', 'LVL'),
		(5, 'currency', 'Euro', 'EUR'),
		(6, 'currency', 'US Dollar', 'USD'),
		(7, 'country', '', ''),
		(8, 'profession', '', ''),
		(9, 'partner_type', 'supplier', 'supplier'),
		(10, 'partner_type', 'buyer', 'buyer'),
		(11, 'account_type', 'balance_active', 'balance_active'),
		(12, 'account_type', 'balance_pasive', 'balance_pasive'),
		(13, 'account_type', 'operation_receipts', 'operation_receipts'),
		(14, 'account_type', 'operation_payments', 'operation_payments'),
		(15, 'account_level', 'header', '10'),
		(16, 'account_level', 'account', '100'),
		(17, 'debit_credit', 'Debit', 'debit'),
		(18, 'debit_credit', 'Credit', 'credit'),
		(19, 'document_type', 'Unknown', 'unknown'),
		(20, 'document_type', 'Invoice', 'invoice'),
		(21, 'gender', 'Male', 'm'),
		(22, 'gender', 'Female', 'f');"
		);
		
		$this->run_queries($queries);
		
		return TRUE;
		
	}

	function run_queries($queries) {

		foreach ($queries as $query) {

			if (!$this->db->query($query)) {

				return FALSE;

			}

		}

		return TRUE;

	}

}

?>