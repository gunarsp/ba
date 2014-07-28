<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Journal extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_journal';

		$this->primary_key = 'ba_journal.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS 
		ba_journal.id AS journal_id,
		ba_journal.notes AS journal_notes,
		ba_journal.document_id,
		ba_documents.name AS doc_name,
		ba_documents.amount AS doc_amount,
		ba_documents.nr AS doc_nr";
		
		$this->order_by = 'ba_journal.id ASC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');
		
		$this->joins = array(
			'ba_documents'	=>	array(
				'ba_documents.id = ba_journal.document_id',
				'left'
			),
			'ba_transactions'	=>	array(
				'ba_transactions.journal_id = ba_journal.id',
				'left'
			),
		);
		//log_message('debug', "journal construction");
	}

	public function validate() {
		
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');
		$this->form_validation->set_rules('document_id', $this->lang->line('document_id'), '');

		return parent::validate();

	}

	public function delete($id) {

		$this->db->where('id', $id);

		$this->db->delete('ba_journal');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}
	
	public function db_array() {
	
		$db_array = parent::db_array();
		
		/*$db_array['date'] = strtotime(standardize_date($db_array['date']));
		$db_array['amount_base_curr'] = $db_array['amount'];*/
		
		return $db_array;
	
	}
	
	public function prep_validation($key) {
	
		parent::prep_validation($key);
	
		/*if (!$_POST) {
	
			$this->set_form_value('date', format_date($this->form_value('date')));
	
		}*/
	
	}
	
	public function get_journal_transactions($journal_id) {
	
		$this->load->model('accounting/mdl_transactions');
	
		$params = array(
				'where'	=>	array(
						'mdl_transactions.journal_id'	=>	$journal_id
				)
		);
	
		return $this->mdl_transactions->get($params);
	
	}
	
}

?>