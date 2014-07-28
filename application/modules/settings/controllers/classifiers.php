<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Classifiers extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model('mdl_classifiers');

	}

	function index() {

		$this->redir->set_last_index();
		
		
		$current_type = $this->input->post('type');
		
		if(empty($current_type))
			$current_type = uri_assoc('type');
		
		$classifiers_types = $this->mdl_classifiers->get_classifiers_types();
		
		if(!empty($classifiers_types) && empty($current_type))
		{
			$current_type = $classifiers_types[0]->type;
		}
		
		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page'),
			'where'		=>	array(
				'type' => $current_type,
			),
		);

		$data = array(
			'classifiers' =>	$this->mdl_classifiers->get($params),
			'classifiers_types' => $classifiers_types,
			'current_type' => $current_type,
		);

		$this->load->view('index', $data);

	}

	function form() {

		if (!$this->mdl_classifiers->validate()) {

			if (!$_POST AND uri_assoc('id')) {

				$this->mdl_classifiers->prep_validation(uri_assoc('id'));

			}
			
			$data = array(
				'current_type' => uri_assoc('type'),
			);
			
			$this->load->view('form', $data);

		}

		else {

			$rez = $this->mdl_classifiers->save($this->mdl_classifiers->db_array(), uri_assoc('id'));
			
			$this->redir->redirect('classifiers/index/type/' . uri_assoc('type'));

		}

	}

	function delete() {

		if (uri_assoc('id')) {

			$this->mdl_classifiers->delete(uri_assoc('id'));

		}

		$this->redir->redirect('classifiers/index/type/' . uri_assoc('type'));

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('classifiers/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('classifiers/index');

		}

	}

}

?>