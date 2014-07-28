<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Fidavista extends Admin_Controller {

	public function __construct() {

		parent::__construct();

		//$this->_post_handler();

		//$this->load->model(array('mdl_chart', 'classifiers/mdl_classifiers'));

	}
	
	
	function index() {
	
		
	
	}
	
	function view() {
		
		
		$messages = array();
		
		//print_r($_POST);
		//print_r($_FILES);
		if(isset($_FILES['file'])) {
			
			$config['upload_path'] = './uploads/';	//TODO - kur augsupladet datnes?
			$config['allowed_types'] = '*';
			$config['max_size']	= '100';
			
			$this->load->library('table');
			$this->load->library('upload', $config);
			$this->load->helper('ba_fidavista');
			//print_r($_FILES);
			if( ! $this->upload->do_upload('file'))
			{
				$messages['static_error'] = $this->upload->display_errors();
				//$this->fidavista($errors);
			}
			else
			{
				$data = $this->upload->data();
			
				$results = parseFidavistaFile(array(
						'file' => $data['full_path'],
				));
			
				$messages['data'] = $results;
				//$messages['template'] = 'view_fidavista';
				
			}
			
		}
		
		//print_r($messages);
		$this->load->view('view_fidavista', $messages);
		
	}
	
}

?>