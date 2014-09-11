<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Frontpage extends Frontpage_Controller {

	function __construct() {

		parent::__construct();

		//$this->_post_handler();

		//$this->load->model('ba_data/mdl_ba_data');

        //$this->mdl_ba_data->set_application_title();

	}

	function index() {

		$this->_load_language();

		/*
		 $this->redir->set_last_index();

		$params = array(
				'paginate'	=>	TRUE,
				'page'		=>	uri_assoc('page'),
		);

		$data = array(
				'persons'	=> $this->mdl_persons->get($params),
		);
		*/

		$this->load->view('index');

	}

	function _load_language() {

		$this->load->model('ba_data/mdl_ba_data');

		$default_language = $this->mdl_ba_data->get('default_language');

		if ($default_language) {

			$this->load->language('ba', $default_language);

		}

		else {

			$this->load->language('ba');

		}

	}

}

?>