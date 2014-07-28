<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Chart extends Admin_Controller {

	public function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_chart', 'classifiers/mdl_classifiers'));

	}
	
	
	function index() {
	
		$data = array(
			'chart' =>	$this->mdl_chart->get(),
		);
	
		$this->load->view('chart_index', $data);
	
	}
	
	function chart_account_form() {
		
		$accountId = uri_assoc('id', 4);
		
		if (!$this->mdl_chart->validate()) {
			
			$data = array(
				'account_levels'	=>	$this->mdl_classifiers->getByType('account_level'),
				'account_types'		=>	$this->mdl_classifiers->getByType('account_type'),
			);
			
			if (!$_POST AND $accountId) {
				
				$this->mdl_chart->prep_validation($accountId);
	
			}
			
			$this->load->view('chart_account_form', $data);
	
		}
	
		else {
	
			$this->mdl_chart->save($this->mdl_chart->db_array(), $accountId);
	
			$this->session->set_flashdata('tab_index', 2);
	
			//$this->redir->redirect('accounting/chart/chart_account_form/account_id/' . uri_assoc('id', 4));
			$this->redir->redirect('accounting/chart');
	
		}
	
	}
	
	function delete() {
		
		$accountId = uri_assoc('id', 4);
		
		if ($accountId) {
			
			$this->mdl_chart->delete($accountId);
			
		}
	
		$this->session->set_flashdata('tab_index', 2);
	
		$this->redir->redirect('accounting/chart');
		
	}
	
	function _post_handler() {
	
		if ($this->input->post('btn_add')) {
			
			redirect('accounting/chart_account_form');
			
		}
		
		elseif ($this->input->post('btn_cancel')) {
			
			$this->session->set_flashdata('tab_index', 2);
			
			$this->redir->redirect('accounting/chart_account_form/id/' . uri_assoc('id'));
			
		}
		
	}
	
}

?>