<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Persons extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_persons';

		$this->primary_key = 'ba_persons.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_persons.*";

		$this->order_by = 'surname, name ASC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');

	}

	public function validate() {
		
		$this->form_validation->set_rules('surname', $this->lang->line('surname'), 'required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'required|xss_clean');
		$this->form_validation->set_rules('personal_code', $this->lang->line('personal_code'), '');
		$this->form_validation->set_rules('birthdate', $this->lang->line('birthdate'), '');
		$this->form_validation->set_rules('gender', $this->lang->line('gender'), '');
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');

		return parent::validate();

	}

	public function delete($person_id) {

		$this->db->where('id', $person_id);

		$this->db->delete('ba_persons');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}
	
	public function db_array() {
	
		$db_array = parent::db_array();
		
		$db_array['birthdate'] = strtotime(standardize_date($db_array['birthdate']));
		
		return $db_array;
	
	}
	
	public function prep_validation($key) {
	
		parent::prep_validation($key);
	
		if (!$_POST) {
	
			$this->set_form_value('birthdate', format_date($this->form_value('birthdate')));
	
		}
	
	}
	
	public function getById($id) {
	
		if(0 < intval($id))
		{
			/*$params = array(
					'where'	=>	array(
							'id' => $id,
					),
			);
	
			return parent::get($params);
			*/
			
			return parent::get_by_id($id);
			
		}
	
	}
	
	public function getNameById($id) {
	
		$tmp = self::getById($id);
	
		return $tmp[0]->name . ' ' . $tmp[0]->surname;
	
	}
	
	/**
	 * Insert person if not exist
	 * @param unknown_type $person
	 */
	public function searchInsert($person) {
		
		log_message('debug', "Search person: ".assocArrToStr($person, "\r\n", ': '));
		$pers = parent::get(array('where' => $person));
		log_message('debug', "Found person: ".assocArrToStr(object_to_array($pers), "\r\n", ': '));
		
		if(isset($pers[0]) && isset($pers[0]->id)) {
	
			$personId = $pers[0]->id;
	
		} else {
	
			parent::save($person);
			$personId = parent::insert_id();
	
		}
	
		return $personId;
	
	}
	
	
	
	
}

?>