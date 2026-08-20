<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('ip_in_network'))
{
	function ip_in_network($ip, $net_addr, $net_mask){ 
		if($net_mask <= 0){ return true; } 
		$ip_binary_string = sprintf("%032b",ip2long($ip)); 
		$net_binary_string = sprintf("%032b",ip2long($net_addr)); 
		return (substr_compare($ip_binary_string,$net_binary_string,0,$net_mask) === 0); 
	}
}
