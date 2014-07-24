<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Client_Center_Controller extends MY_Controller {

	function __construct($var_required = NULL) {

		parent::__construct();

		$this->load->database();

		$this->load->helper('url');

		$this->load->model('ba_modules/mdl_ba_modules');

		$this->load->library('session');

		if ($this->session->userdata('is_admin')) {

			redirect('client_center/admin');

		}

		if ($var_required and (!$this->session->userdata($var_required))) {

			redirect('sessions/login');

		}

		$this->load->model('ba_data/mdl_ba_data');

		$this->mdl_ba_data->set_session_data();
		
		$this->load->helper(array('uri', 'ba_currency', 'ba_invoice',
			'ba_date', 'ba_icon', 'ba_custom', 'ba_app',
			'ba_invoice_amount', 'ba_invoice_item',
			'ba_invoice_payment', 'ba_numbers'));

		$this->load->language('ba', $this->mdl_ba_data->setting('default_language'));

		$this->load->library('form_validation');

		$this->load->model('fields/mdl_fields');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	}

}

?>
