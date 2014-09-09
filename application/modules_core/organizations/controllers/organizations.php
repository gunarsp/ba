<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Organizations extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_organizations', 'classifiers/mdl_classifiers'));

	}

	function index() {

		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
		);

		$data = array(
			'organizations'	=> $this->mdl_organizations->get($params),
		);

		$this->load->view('index', $data);

	}

	function form() {
		
		$id = uri_assoc('id');
		
		if (!$this->mdl_organizations->validate()) {

			if (!$_POST AND $id) {

				$this->mdl_organizations->prep_validation($id);

			}
			
			$data = array(
				'org_types'	=> $this->mdl_classifiers->getByType('organization_type'),
			);
			
			$this->load->view('form', $data);

		}

		else {
			//print_r($_POST);
			$this->mdl_organizations->save($this->mdl_organizations->db_array(), $id);

			$this->redir->redirect('organizations');

		}

	}

	function delete() {
		
		$d = uri_assoc('id');
		
		if ($id) {

			$this->mdl_organizations->delete($id);

		}

		$this->redir->redirect('organizations');

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('organizations/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('organizations');

		}

	}

}

?>