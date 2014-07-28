<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Persons extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_persons', 'classifiers/mdl_classifiers'));

	}

	function index() {

		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
		);

		$data = array(
			'persons'	=> $this->mdl_persons->get($params),
		);

		$this->load->view('index', $data);

	}

	function form() {
		
		$personId = uri_assoc('id');
		
		if (!$this->mdl_persons->validate()) {

			if (!$_POST AND $personId) {

				$this->mdl_persons->prep_validation($personId);

			}
			
			$data = array(
				'genders'	=> $this->mdl_classifiers->getByType('gender'),
			);
			
			$this->load->view('form', $data);

		}

		else {
			//print_r($_POST);
			$this->mdl_persons->save($this->mdl_persons->db_array(), $personId);

			$this->redir->redirect('persons');

		}

	}

	function delete() {
		
		$personId = uri_assoc('id');
		
		if ($personId) {

			$this->mdl_persons->delete($personId);

		}

		$this->redir->redirect('persons');

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('persons/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('persons');

		}

	}

}

?>