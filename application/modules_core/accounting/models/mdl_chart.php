<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Chart extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'ba_chart';

		$this->primary_key = 'ba_chart.id';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS ba_chart.*";

		$this->order_by = 'ba_chart.account ASC';

	}

	public function validate() {

		$this->form_validation->set_rules('account', $this->lang->line('account'), 'required');
		$this->form_validation->set_rules('level', $this->lang->line('level'));
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'required');
		$this->form_validation->set_rules('type', $this->lang->line('type'));
		$this->form_validation->set_rules('sum_from', $this->lang->line('sum_from'));
		$this->form_validation->set_rules('sum_to', $this->lang->line('sum_to'));

		return parent::validate($this);

	}

	
	/**
	 * Insert new accounts
	 * $data	- data for table kontu_plans
	 * @return bool
	 */
	/*public function insertAccount($data)
	{
		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}*/
	
	
	/**
	 * Update Account
	 * $id	- accounts id
	 * $data	- data
	 * @return bool
	 */
	/*public function updateAccount($id, $data)
	{
		$id = intval($id);
		if(0 < $id)
		{
			$this->db->update($this->table_name, $data, array('id' => $id));
			return 1;
		}
		else
		{
			return 0;
		}
	}*/
	
	
	/**
	 * Get array with unused accounts from chart of accounts
	 * 
	 */
	public function getUnusedAccounts()
	{
	
		$query = "
		SELECT a.id
		FROM ba_chart a
		WHERE a.id not in (select b.account_id
			from ba_journal b
			where a.id = b.account_id);
		";
		return parent::runQuery($query);
	}
	
	
	/**
	 * Check whether the account is unused
	 * @param $params
	 */
	public function accountIsUnused($params)
	{
	
		$query = "
		SELECT a.id
		FROM ba_chart a
		WHERE a.id = ".$this->db->escape($params['id'])."
			and a.id not in (select b.account_id
			from ba_journal b
			where a.id = b.account_id);
		";
		$result = parent::runQuery($query);
		return count($result);
	}
	
	
	/**
	 * Delete account
	 * @see MY_Model::delete()
	 */
	public function delete($id) {
	
		$this->db->where('id', $id);
	
		$this->db->delete('ba_chart');
	
		$this->session->set_flashdata('success_delete', TRUE);
	
		return TRUE;
	
	}
	
	
	
	
}