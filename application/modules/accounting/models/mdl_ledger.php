<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_ledger extends MY_Model {

	public function __construct() {

		parent::__construct();
		
		$this->load->model(array(
			'accounting/mdl_chart',
			'accounting/mdl_journal',
			'accounting/mdl_transactions',
			
			)
		);
		
	}
	
	public function getLedger($data) {
		
		//print_r($data);
		
		$ledger = array();
		
		$accountSearch = array(
				
		);
		
		$accounts = $this->mdl_chart->get();
		
		//print_r($accounts);
		
		foreach($accounts as $key => $account) {
			
			$ledger[$account->account] = array(
				'account'	=> $account->account,
				'name'		=> $account->name,
				'level'		=> $account->level,
				'type'		=> $account->type,
			);
			
			$ledger[$key]['start_debit'] = 0;
			$ledger[$key]['start_credit'] = 0;
			$ledger[$key]['debit'] = 0;
			$ledger[$key]['credit'] = 0;
			$ledger[$key]['end_debit'] = 0;
			$ledger[$key]['end_credit'] = 0;
			
		}
		
		return $ledger;
		
	}
	
}