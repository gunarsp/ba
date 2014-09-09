<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Organizations extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_organizations';

		$this->primary_key = 'ba_organizations.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_organizations.*";

		$this->order_by = 'name ASC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');

	}

	public function validate() {
		
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'required|xss_clean');
		$this->form_validation->set_rules('org_type', $this->lang->line('organization_type'), '');
		$this->form_validation->set_rules('registration_nr', $this->lang->line('registration_nr'), '');
		$this->form_validation->set_rules('tax_number', $this->lang->line('tax_nr'), '');
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');

		return parent::validate();

	}

	public function delete($organization_id) {

		$this->db->where('id', $organization_id);

		$this->db->delete('ba_organizations');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

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
		
		$organization = self::getById($id);
		
		return $organization[0]->name;
		
	}
	
	/**
	 * Insert organization if not exists
	 * @param unknown_type $organization
	 */
	public function searchInsert($organization) {
		
		log_message('debug', "Search organization: ".assocArrToStr(object_to_array($organization), "\r\n", ': '));
		$orgs = parent::get(array('where' => $organization));
		log_message('debug', "Found organization: ".assocArrToStr($orgs, "\r\n", ': '));
		
		if(isset($orgs[0]) && isset($orgs[0]->id)) {
			
			$orgId = $orgs[0]->id;
			
		} else {
			
			parent::save($organization);
			$orgId = parent::insert_id();
			
		}
		
		return $orgId;
		
	}
	
}

?>