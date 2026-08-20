<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('now'))
{
	//Get Now Date Time
	function now()
	{
	   return date(DATETIME_FORMAT);	
	}
}	
	
if ( ! function_exists('today'))
{	
	function today()
	{
	   return date(DATE_FORMAT);	
	}
}

if ( ! function_exists('convert_to_date'))
{
	function convert_to_date($date_str, $format = null)
	{
		$format = is_null($format) ? DATE_FORMAT : $format;
		return convert_to_datetime($date_str, $format);
	}
}	
	
if ( ! function_exists('convert_to_datetime'))
{
	function convert_to_datetime($date_str, $format = null)
	{
		$format = is_null($format) ? DATETIME_FORMAT : $format;
		
		return $date_str && ! empty($date_str) ? date($format, strtotime($date_str)) : null;
	}
}	

if ( ! function_exists('current_ac_year_code'))
{
	function current_ac_year_code()
	{
		return date("m") >= 8 ? date("Y") : date("Y") - 1;
	}
}

if ( ! function_exists('get_ac_year_code_by_date'))
{
	function get_ac_year_code_by_date($ac_date)
	{
		$ac_date_timestamp = strtotime($ac_date);
		return date("m", $ac_date_timestamp) >= 8 ? date("Y", $ac_date_timestamp) : date("Y", $ac_date_timestamp) - 1;
	}
}

if ( ! function_exists('current_activity_year_key'))
{
	function current_activity_year_key()
	{
		return date("m") >= 9 ? 
			(string)date("y") . (string)(date("y") + 1)
		: 	(string)(date("y") - 1) . (string)date("y");
	}
}

if ( ! function_exists('get_activity_year_key_by_date'))
{
	function get_activity_year_key_by_date($activity_date)
	{
		$activity_date_timestamp = strtotime($activity_date);
		return date("m", $activity_date_timestamp) >= 9 ? 
			(string)date("y", $activity_date_timestamp) . (string)(date("y", $activity_date_timestamp) + 1)
		: 	(string)(date("y") - 1) . (string)date("y", $activity_date_timestamp);
	}
}

if ( ! function_exists('get_programme_year_key_by_date'))
{
	function get_programme_year_key_by_date($programme_date)
	{
		$programme_date_timestamp = strtotime($programme_date);
		return date("m", $programme_date_timestamp) >= 9 ? 
			(string)date("y", $programme_date_timestamp) . (string)(date("y", $programme_date_timestamp) + 1)
		: 	(string)(date("y") - 1) . (string)date("y", $programme_date_timestamp);
	}
}
