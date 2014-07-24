<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

	public static $is_loaded;

	function __construct() {

		parent::__construct();

		$this->load->library('session');

        $this->load->helper('url');

		$user_id = $this->session->userdata('user_id');

        if (!$user_id) {

            redirect('sessions/login');

        }

		if (!isset(self::$is_loaded)) {

			self::$is_loaded = TRUE;

            $this->load->config('ba_menu/ba_menu');

            modules::run('ba_menu/check_permission', $this->uri->uri_string(), $this->session->userdata('global_admin'));

			$this->load->database();

			$this->load->helper(array('uri', 'ba_currency', 'ba_invoice',
				'ba_date', 'ba_icon', 'ba_custom', 'ba_app',
				'ba_invoice_amount', 'ba_invoice_item',
				'ba_invoice_payment', 'ba_numbers'));

            $this->load->model(array('ba_modules/mdl_ba_modules','ba_data/mdl_ba_data','ba_data/mdl_ba_userdata'));

			$this->mdl_ba_modules->set_module_data();

            $this->mdl_ba_data->set_session_data();

			$this->mdl_ba_userdata->set_session_data($user_id);

			$this->mdl_ba_modules->load_custom_languages();

			$this->load->language('ba', $this->mdl_ba_data->setting('default_language'));

            $this->load->model('fields/mdl_fields');

			$this->load->library(array('form_validation', 'redir'));

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->mdl_ba_data->setting('enable_profiler')) {

                $this->output->enable_profiler();

            }

		}

	}

}

?>
