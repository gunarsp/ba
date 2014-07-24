<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Generate Timestamp for database
 * @return MySQL timestamp
 */
function getIsoDateTime()
{
	return date("Y-m-d H:i:s");
}


/**
 * Return password hash
 * @param string $pass
 */
function makePassword($pass)
{
	return sha1($pass);
}


/**
 * Replace all items in string
 * @param stri
 */
function strReplace($find, $replace, $string)
{
	$string = str_replace($find, $replace, $string, $count);
	while(0 < $count)
	{
		$string = str_replace($find, $replace, $string, $count);
	}
	return $string;
}


/**
 * Get formatted value of money
 * @param $val
 */
function formatMoney($val)
{
	//return round($val, 2);
	return number_format($val, 2, '.', ' ');
}


/**
 * Prepare select values from passed array, usually from config_item function
 * @param <array> $values
 */
function prepareDropdown(&$values)
{
	if(!empty($values))
	{
		foreach($values as $key => $val)
		{
			$values[$key] = lang($val);
		}
	}
}
