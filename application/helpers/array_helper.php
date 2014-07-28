<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Covert associative array to string
 * @param array $arr
 */
function assocArrToStr($arr, $rowDelimiter="; ", $keyDelimiter=":") {
	
	if ( is_array($arr) ) {
		
		$str = '';
		
		if ( !empty($arr) ) {
			
			foreach ( $arr as $key => $value ) {
				
				$str .= $key . $keyDelimiter . assocArrToStr($value,$rowDelimiter,$keyDelimiter) . $rowDelimiter;
				
			}
			
		}
		
		return $str;
		
	}
	
	return $arr;
	
}

function object_to_array($data)
{
	if (is_array($data) || is_object($data))
	{
		$result = array();
		foreach ($data as $key => $value)
		{
			$result[$key] = object_to_array($value);
		}
		return $result;
	}
	return $data;
}


?>