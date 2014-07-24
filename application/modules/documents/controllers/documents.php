<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Documents extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_documents', 'classifiers/mdl_classifiers'));

	}

	function index() {

		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
		);

		$data = array(
			'documents'	=> $this->mdl_documents->get($params),
		);

		$this->load->view('index', $data);

	}

	function form() {
		
		$id = uri_assoc('id');
		
		if (!$this->mdl_document->validate()) {

			if (!$_POST AND $id) {

				$this->mdl_document->prep_validation($id);

			}
			
			$data = array(
				'document_types'	=> $this->mdl_classifiers->getByType('document_type'),
				'currencies'	=> $this->mdl_classifiers->getByType('currency'),
			);
			
			$this->load->view('form', $data);

		}

		else {
			
			$this->mdl_documents->save($this->mdl_documents->db_array(), $id);

			$this->redir->redirect('documents');

		}

	}

	function delete() {
		
		$id = uri_assoc('id');
		
		if ($id) {

			$this->mdl_documents->delete($id);

		}

		$this->redir->redirect('documents');

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('documents/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('documents');

		}

	}

}

?>