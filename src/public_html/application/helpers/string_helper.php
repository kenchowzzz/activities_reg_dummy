<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('start_with'))
{
	function start_with($haystack, $needle)
	{
		// search backwards starting from haystack length characters from the end
    	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}
}

if ( ! function_exists('end_with'))
{
	function end_with($haystack, $needle)
	{
		// search forward starting from end minus needle length characters
    	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
}

