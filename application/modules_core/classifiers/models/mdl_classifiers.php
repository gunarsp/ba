<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Classifiers extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_classifiers';

		$this->primary_key = 'ba_classifiers.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_classifiers.*";

		$this->order_by = 'type';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');

	}

	public function validate() {
		
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'required|xss_clean');
		$this->form_validation->set_rules('value', $this->lang->line('value'), 'required|xss_clean');

		return parent::validate();

	}

	public function delete($classifier_id) {

		$this->db->where('id', $classifier_id);

		$this->db->delete('ba_classifiers');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}

	public function get_classifiers_types() {
	
		$params = array(
				'select'	=>	array(
						'type',
				),
				'group_by'	=>	array(
						'type',
				),
		);
		
		return parent::get($params);
	
	}
	
	
	public function getByType($type = '') {
		
		if(!empty($type))
		{
			$params = array(
				'where'	=>	array(
						'type' => $type,
				),
			);
		}
		
		return parent::get($params);
		
	}
	
	
	public function getNameById($id = 0) {
	
		$params = array(
			'select'	=>	array(
				'name',
			),
			'where'	=>	array(
				'id' => intval($id),
			),
		);
		
		$rezult = parent::get($params);
		
		if(isset($rezult[0]->name))
		{
			return $rezult[0]->name;
		}
		else
		{
			return '';
		}
		
	}
	
	public function getValueByName($name = '') {
	
		$params = array(
			'select'	=>	array(
				'value',
			),
			'where'	=>	array(
				'name' => $name,
			),
		);
		
		$rezult = parent::get($params);
	
		if(isset($rezult[0]->value))
		{
			return $rezult[0]->value;
		}
		else
		{
			return '';
		}
	
	}
	
	public function getDocumentDirections() {
		
		$params = array(
			0 => 'Outgoing',
			1 => 'Incoming',
		);
		
		return $params;
		
	}
	
}

?>