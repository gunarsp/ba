<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Transactions extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_transactions';

		$this->primary_key = 'ba_transactions.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS 
		ba_transactions.*";

		$this->order_by = 'ba_transactions.id DESC';

		$this->limit = $this->mdl_ba_data->setting('results_per_page');
		
	}

	public function validate() {
		
		$this->form_validation->set_rules('account', $this->lang->line('account'), 'required|xss_clean');
		$this->form_validation->set_rules('debit_credit', $this->lang->line('debit_credit'), 'required');
		$this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
		//$this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
		$this->form_validation->set_rules('notes', $this->lang->line('notes'), '');
		$this->form_validation->set_rules('amount_base_curr', $this->lang->line('amount_base_curr'), '');
		$this->form_validation->set_rules('journal_id', $this->lang->line('journal_id'), '');

		return parent::validate();

	}

	public function delete($id) {

		$this->db->where('id', $id);

		$this->db->delete('ba_transactions');

		$this->session->set_flashdata('success_delete', TRUE);

		return TRUE;

	}
	
	public function db_array() {
	
		$db_array = parent::db_array();
		
		//$db_array['date'] = strtotime(standardize_date($db_array['date']));
		$db_array['amount_base_curr'] = $db_array['amount'];
		
		return $db_array;
	
	}
	
	public function prep_validation($key) {
	
		parent::prep_validation($key);
	
		if (!$_POST) {
	
			$this->set_form_value('date', format_date($this->form_value('date')));
	
		}
	
	}
	
}

?>