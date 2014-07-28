<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Partners extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_partners';

		$this->primary_key = 'ba_partners.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_partners.*";

		$this->order_by = 'id DESC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');

	}

	public function validate() {
		
		$this->form_validation->set_rules('date_from', $this->lang->line('date_from'), '');
		$this->form_validation->set_rules('date_to', $this->lang->line('date_to'), '');
		$this->form_validation->set_rules('organization_id', $this->lang->line('organization'), '');
		$this->form_validation->set_rules('person_id', $this->lang->line('person'), '');
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');
		$this->form_validation->set_rules('supplier', $this->lang->line('supplier'), '');
		$this->form_validation->set_rules('buyer', $this->lang->line('buyer'), '');
		
		return parent::validate();

	}

	public function delete($id) {

		$this->db->where('id', $id);

		$this->db->delete('ba_partners');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}
	
	public function db_array() {
	
		$db_array = parent::db_array();
		
		$db_array['date_from'] = strtotime(standardize_date($db_array['date_from']));
		$db_array['date_to'] = strtotime(standardize_date($db_array['date_to']));
		
		return $db_array;
	
	}
	
	public function prep_validation($key) {
	
		parent::prep_validation($key);
	
		if (!$_POST) {
	
			$this->set_form_value('date_from', format_date($this->form_value('date_from')));
			$this->set_form_value('date_to', format_date($this->form_value('date_to')));
	
		}
	
	}
	
	public function getNameById($id)
	{
		
	}
	
	public function get($params = NULL) {
	
		$partners = parent::get($params);
		
		if(!empty($partners))
		{
			foreach($partners as $key => $partner)
			{
				if(!empty($partner->organization_id))
				{
					$this->load->model('organizations/mdl_organizations');
					
					$partners[$key]->name = $this->mdl_organizations->getNameById($partner->organization_id);
				}
				else if(!empty($partner->person_id))
				{
					$this->load->model('persons/mdl_persons');
				
					$partners[$key]->name = $this->mdl_persons->getNameById($partner->person_id);
				}
			}
		}
		
		
		return $partners;
		
	}
	
	/**
	 * Insert partner if not exist
	 * @param unknown_type $partner
	 */
	public function searchInsert($partner) {
		
		log_message('debug', "Search partner: ".assocArrToStr($partner, "\r\n", ': '));
		$partners = parent::get(array('where' => $partner));
		log_message('debug', "Found partner: ".assocArrToStr(object_to_array($partners), "\r\n", ': '));
		
		if(isset($partners[0]) && isset($partners[0]->id)) {
			
			$partnerId = $partners[0]->id;
			
		} else {
		
			$partner['date_from'] = time();
		
			parent::save($partner);
			$partnerId = parent::insert_id();
			log_message('debug', "Inserting partner: ".assocArrToStr($partner, "\r\n", ': '));
			
		}
		
		return $partnerId;
	
	}
	
}

?>