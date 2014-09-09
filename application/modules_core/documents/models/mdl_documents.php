<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Documents extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_documents';

		$this->primary_key = 'ba_documents.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_documents.*";

		$this->order_by = 'date DESC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');

	}

	public function validate() {
		
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'required|xss_clean');
		$this->form_validation->set_rules('nr', $this->lang->line('nr'), '');
		$this->form_validation->set_rules('attachment', $this->lang->line('attachment'), '');
		$this->form_validation->set_rules('amount', $this->lang->line('amount'), '');
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');
		$this->form_validation->set_rules('currency', $this->lang->line('currency'), '');
		$this->form_validation->set_rules('date', $this->lang->line('date'), '');
		$this->form_validation->set_rules('amount_base_curr', $this->lang->line('amount_base_curr'), '');
		$this->form_validation->set_rules('partner_id', $this->lang->line('partner_id'), '');
		
		return parent::validate();

	}

	public function delete($id) {

		$this->db->where('id', $id);

		$this->db->delete('ba_documents');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}
	
	public function db_array() {
	
		$db_array = parent::db_array();
		
		$db_array['date'] = strtotime(standardize_date($db_array['date']));
		
		return $db_array;
	
	}
	
	public function prep_validation($key) {
	
		parent::prep_validation($key);
	
		if (!$_POST) {
	
			$this->set_form_value('date', format_date($this->form_value('date')));
	
		}
	
	}
	
	/**
	 * Insert document if not exists
	 * @param unknown_type $organization
	 */
	public function searchInsert($document) {
		
		log_message('debug', "Search doc: ".assocArrToStr($document, "\r\n", ': '));
		$docs = parent::get(array('where' => $document)); //'debug' => true,
		log_message('debug', "Found doc: ".assocArrToStr(object_to_array($docs), "\r\n", ': '));
		
		if(isset($docs[0]) && isset($docs[0]->id)) {
			
			$docId = $docs[0]->id;
			log_message('debug', "Found related document:".$docId);
			
		} else {
		
			parent::save($document);
			$docId = parent::insert_id();
			
			log_message('debug', "Inserting new doc: ".assocArrToStr($document, "\r\n", ': '));
			log_message('debug', "New document id:".$docId);
			
		}
		
		
		return $docId;
		
	}
	
}

?>