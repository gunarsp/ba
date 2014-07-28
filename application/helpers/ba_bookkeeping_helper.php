<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function parseAccountsChartFile($params)
{
		$rezult = array();
		//print_r($params);
		if(empty($params['file']) || empty($params['ext']) || (1 < $params['org_id']))
		{
			return $rezult;
		} else {
			$data = array(
				'file'		=> $params['file'],
				'org_id'	=> $params['org_id'],
			);
			switch($params['ext']) {
				case '.xml':
					$rezult = self::parseCOAXml($data);
					break;
					
				case '.txt':
					$rezult = self::parseCOATxt($data);
					break;
			}
			return $rezult;
		}
}

function parseCOAXml($data)
{
	$rezult = array();

	return $rezult;
}

function parseCOATxt($data)
{
	$rezult = array();
	$counter = 0;
	$handle = @fopen($data['file'], "r");
	if ($handle) {
		while (!feof($handle)) {
			$buffer = fgetss($handle, 4096);
			//$buffer = Common::strReplace(",", ";", $buffer);
			//$buffer = Common::strReplace("	", ";", $buffer);
			$buffer = Common::strReplace("\"", "", $buffer);
			$buffer = Common::strReplace("\'", "", $buffer);

			$temp = explode(";", $buffer);

			if(!empty($temp[0]) && !empty($temp[1]))
			{
				$rezult[$counter] = array(
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
				}

				$counter++;
			}
		}
		fclose($handle);
	}

	return $rezult;
}


function parseJournalFile($params)
{
	$rezult = array();
	
	if(empty($params['file']) || empty($params['ext']))
	{
		return $rezult;
	} else {
		$data = array(
			'file'		=> $params['file'],
		);
		switch($params['ext']) {
			case '.xml':
				$rezult = self::parseJournalXml($data);
				break;

			case '.txt':
				$rezult = self::parseJurnalTxt($data);
				break;
		}
		return $rezult;
	}
}

function parseJournalXml($data)
{
	$rezult = array();

	return $rezult;
}

function parseJurnalTxt($data)
{
	$rezult = array();
	$counter = 0;
	$handle = @fopen($data['file'], "r");
	if ($handle) {
		while (!feof($handle)) {
			$buffer = fgetss($handle, 4096);
			//$buffer = Common::strReplace(",", ";", $buffer);
			//$buffer = Common::strReplace("	", ";", $buffer);
			$buffer = Common::strReplace("\"", "", $buffer);
			$buffer = Common::strReplace("\'", "", $buffer);

			$temp = explode(";", $buffer);

			if(!empty($temp[0]) && !empty($temp[1]))
			{
				$rezult[$counter] = array(
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
				}

				$counter++;
			}
		}
		fclose($handle);
	}

	return $rezult;
}



?>