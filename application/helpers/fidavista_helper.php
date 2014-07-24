<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function parseFidavistaFile($data)
{

	$handle = @fopen($data['file'], "r");
	
	if ($handle) {
		$xml = simplexml_load_file($data['file']);
	    fclose($handle);
	}
	
	return $xml;
	
}



?>