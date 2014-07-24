<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class General_ledger extends Admin_Controller {

	public function __construct() {

		parent::__construct();
		
		$this->load->model(array('mdl_ledger'));

	}
	
	
	function index() {
		
		$data = array();
		
		if (!$_POST) {
			
			$this->load->view('ledger_index', $data);
			
		} else {
			
			$q = array(
				'date_from' => $this->input->post('date_from'),
				'date_to' => $this->input->post('date_to'),
			);
			
			$data['ledger'] = $this->mdl_ledger->getLedger($q);
			
			$this->load->view('ledger_table', $data);
			
		}
		
	}
}