<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Partners extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model(array('mdl_partners', 'classifiers/mdl_classifiers'));

	}

	function index() {

		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
		);

		$data = array(
			'partners'	=> $this->mdl_partners->get($params),
		);

		$this->load->view('index', $data);

	}

	function form() {
		
		$id = uri_assoc('id');
		
		if (!$this->mdl_partners->validate()) {

			if (!$_POST AND $id) {

				$this->mdl_partners->prep_validation($id);

			}
			
			$this->load->model(array('persons/mdl_persons', 'organizations/mdl_organizations'));
			
			$data = array(
				'partnership_types'	=> $this->mdl_classifiers->getByType('partner_type'),
				'persons'	=> $this->mdl_persons->get(),
				'organizations'	=> $this->mdl_organizations->get(),
			);
			
			$this->load->view('form', $data);

		}

		else {
			
			$this->mdl_partners->save($this->mdl_partners->db_array(), $id);

			$this->redir->redirect('partners');

		}

	}

	function delete() {
		
		$id = uri_assoc('id');
		
		if ($id) {

			$this->mdl_partners->delete($id);

		}

		$this->redir->redirect('partners');

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('partners/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('partners');

		}

	}

}

?>