<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Frontpage_Controller extends MX_Controller {

	function __construct() {

		parent::__construct();

		$this->load->database();

		$this->load->helper('url');

		$this->load->model('ba_modules/mdl_ba_modules');

		$this->load->library('session');
		
	}

}

?>