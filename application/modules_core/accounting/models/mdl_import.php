<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_import extends MY_Model {

	public function __construct() {

		parent::__construct();
		
		$this->load->model(array(
			'accounting/mdl_chart',
			'accounting/mdl_journal',
			'accounting/mdl_transactions',
			'documents/mdl_documents',
			'organizations/mdl_organizations',
			'partners/mdl_partners',
			'persons/mdl_persons',
			)
		);
		
	}
	
	
	public function parseJournalFile($params)
	{
		$rezult = array();
	
		if(empty($params['file']) || empty($params['ext']))
		{
			return $rezult;
		} else {
			$data = array(
				'file'	=> $params['file'],
			);
			switch($params['ext']) {
				case '.xml':
					$rezult = self::parseJournalXml($data);
					break;
	
				case '.csv':
					$rezult = self::parseJurnalCsv($data);
					break;
			}
			return $rezult;
		}
	}
	
	public function parseJournalXml($data)
	{
		$rezult = array();
	
		return $rezult;
	}
	
	public function parseJurnalCsv($data)
	{
		$this->load->helper('array');
		
		$rezult = array();
		$counter = 0;
		$handle = @fopen($data['file'], "r");
		if ($handle) {
			
			if(!feof($handle)) {
				$buffer = fgetss($handle, 4096);
				$buffer = strReplace("\"", "", $buffer);
				$buffer = strReplace("\'", "", $buffer);
				$buffer = strReplace("\r\n", "", $buffer);
				$buffer = strReplace("\n", "", $buffer);
				$temp = explode(";", $buffer);
				
				$titles = array();
				
				for($i=0; $i<count($temp); $i++) {
					$titles[$i] = $temp[$i];
				}
			}
			
			while (!feof($handle)) {
				$buffer = fgetss($handle, 4096);
				//$buffer = Common::strReplace(",", ";", $buffer);
				//$buffer = Common::strReplace("	", ";", $buffer);
				$buffer = strReplace("\"", "", $buffer);
				$buffer = strReplace("\'", "", $buffer);
				$buffer = strReplace("\r\n", "", $buffer);
				$buffer = strReplace("\n", "", $buffer);
				$temp = explode(";", $buffer);
				
				
				
				if(!empty($temp[0]) && !empty($temp[1]))
				{
					/*$rezult[$counter] = array(
							'organizacijas_id' => $data['org_id'],
							'konts' => trim($temp[1]),
							'nosaukums' => trim($temp[0]),
							'konta_tips' => (isset($temp[2]) ? trim($temp[2]) : ''),
					);
	
					if(strlen( $rezult[$counter]['konts']) > config_item('group_account_max_len'))
					{
						$rezult[$counter]['grupa'] = 0;
					} else {
						$rezult[$counter]['grupa'] = 1;
					}*/
					
					$row = array();
					
					for($i=0; $i<count($temp); $i++) {
						$row[$titles[$i]] = $temp[$i];
					}
					
					$personId = 0;
					$orgId = 0;
					$partner = array();
					$partnerId = 0;
					
					if(!empty($row['reg_num'])) {
						
						$organization = array(
								'name' => $row['partner_name'],
								'registration_nr' => $row['reg_num'],
						);
						
						$orgId = $this->mdl_organizations->searchInsert($organization);
						
						$partner = array(
								'organization_id' => $orgId,
						);
						
					} else if(!empty($row['personal_code'])) {
						
						$person = array(
								'name' => $row['partner_name'],
								'personal_code' => $row['personal_code'],
						);
						
						$personId = $this->mdl_persons->searchInsert($person);
						
						$partner = array(
								'person_id' => $personId,
						);
						
					}
					
					if ( !empty($partner) ) {
						
						$partnerId = $this->mdl_partners->searchInsert($partner);
						
					}
					
					$document = array(
							'nr' => $row['doc_nr'],
							'notes' => $row['notes'],
							'name' => $row['doc_nr'],
							'date' => strtotime($row['date']),
							'currency' => 'LVL',
							'amount' => $row['amount'],
							'amount_base_curr' => $row['amount'],
							'partner_id' => $partnerId,
					);
					
					$docId = $this->mdl_documents->searchInsert($document);
					
					
					
					$journalSearch = array(
							'document_id' => $docId,
							'date_created' => time(),
							'date' => strtotime($row['date']),
					);
					
					$journal = $journalSearch;
					$journal['notes'] = $row['notes'];
					
					$this->mdl_journal->save($journal);
					//$tmp = $this->mdl_journal->get(array('where' => $journalSearch));
					//$journalId = $tmp[0]->id;
					$journalId = $this->db->insert_id();
					log_message('debug', "New journal id:".$journalId);
					
					$debit_transaction = array(
							'notes' => $row['notes'],
							'debit_credit' => 'debit',
							'account' => $row['debit_account'],
							'amount' => $row['amount'],
							'amount_base_curr' => $row['amount'],
							'journal_id' => $journalId,
							'date_created' => time(),
					);
					
					$this->mdl_transactions->save($debit_transaction);
					
					$credit_transaction = array(
							'notes' => $row['notes'],
							'debit_credit' => 'credit',
							'account' => $row['credit_account'],
							'amount' => $row['amount'],
							'amount_base_curr' => $row['amount'],
							'journal_id' => $journalId,
							'date_created' => time(),
					);
					
					$this->mdl_transactions->save($credit_transaction);
					
					//print_r($row);
					
					$counter++;
				}
			}
			fclose($handle);
		}
	
		return $counter;
	}
	
	
	public function parseChartFile($params)
	{
		$rezult = array();
	
		if(empty($params['file']) || empty($params['ext']))
		{
			return $rezult;
		} else {
			$data = array(
					'file'	=> $params['file'],
			);
			switch($params['ext']) {
				
				case '.csv':
					$rezult = self::parseChartCsv($data);
					break;
			}
			return $rezult;
		}
	}
	
	public function parseChartCsv($data) {
		echo 1;
		$rezult = array();
		$counter = 0;
		$handle = @fopen($data['file'], "r");
		if ($handle) {
			echo 2;
			if(!feof($handle)) {
				$buffer = fgetss($handle, 4096);
				$buffer = strReplace("\"", "", $buffer);
				$buffer = strReplace("\'", "", $buffer);
				$buffer = strReplace("\r\n", "", $buffer);
				$buffer = strReplace("\n", "", $buffer);
				$temp = explode(";", $buffer);
		
				$titles = array();
		
				for($i=0; $i<count($temp); $i++) {
					$titles[$i] = $temp[$i];
				}
			}
		
			while (!feof($handle)) { echo 3;
				$buffer = fgetss($handle, 4096);
				$buffer = strReplace("\"", "", $buffer);
				$buffer = strReplace("\'", "", $buffer);
				$buffer = strReplace("\r\n", "", $buffer);
				$buffer = strReplace("\n", "", $buffer);
				$temp = explode(";", $buffer);
		
				if(!empty($temp[0]) && !empty($temp[1]))
				{
					echo 4;
					$row = array();
					
					for($i=0; $i<count($temp); $i++) {
						$row[$titles[$i]] = $temp[$i];
					}
					print_r($row);
					$accountSearch = array(
							'account' => $row['account'],
					);
					
					$account = $this->mdl_chart->get(array('where' => $accountSearch));
					
					if(!isset($account[0]) && !isset($account[0]->id)) {
						
						$this->mdl_chart->save($row);
						
					}
					
					$counter++;
					
				}
				
			}
			
			fclose($handle);
			
		}
		
		return $counter;
		
	}
	
	
}