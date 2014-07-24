<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Journal extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_journal', 'classifiers/mdl_classifiers'));

	}

	function index() {

		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
		);

		$data = array(
			'entries'	=> $this->mdl_journal->get($params),
		);

		$this->load->view('journal_index', $data);

	}

	function transaction_form() {
		
		//$id = uri_assoc('id');
		$id = uri_assoc('id', 4);
		
		if (!$this->mdl_journal->validate()) {

			if (!$_POST AND $id) {

				$this->mdl_journal->prep_validation($id);

			}
			
			$data = array(
				'debit_credit'	=> $this->mdl_classifiers->getByType('debit_credit'),
			);
			
			$this->load->view('transaction_form', $data);

		}

		else {
			//print_r($_POST);
			$this->mdl_journal->save($this->mdl_journal->db_array(), $id);

			$this->redir->redirect('accounting/journal');

		}

	}

	function delete() {
		
		$id = uri_assoc('id');
		
		if ($id) {

			$this->mdl_journal->delete($id);

		}

		$this->redir->redirect('accounting/journal');

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('accounting/persons/journal');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('accounting/journal');

		}

	}

}

?>