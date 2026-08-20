<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_base_url'))
{
	function get_base_url()
	{
		if (is_request_from_kiosk())
		{
			return base_url() . 'kiosk/';
		}
		return base_url();
	}
}

if ( ! function_exists('is_request_from_kiosk'))
{
	function is_request_from_kiosk()
	{
    	return start_with(get_instance()->uri->uri_string(), 'kiosk');
	}
}

if ( ! function_exists('is_kiosk_subnet'))
{
	function is_kiosk_subnet()
	{
		$client_ip = get_instance()->input->ip_address();
		$kiosk_subnets = get_instance()->config->item('kiosk_ip_subnets');
		foreach($kiosk_subnets as $subnet){
			if(start_with($client_ip, $subnet)){
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists('get_user_agent'))
{
	function get_user_agent()
	{
		get_instance()->load->library('user_agent');
		
		$user_agent = '';
	
		if (get_instance()->agent->is_browser())
		{
		    $user_agent = get_instance()->agent->browser() . " " . get_instance()->agent->version();
		}
		elseif (get_instance()->agent->is_robot())
		{
		    $user_agent = get_instance()->agent->robot();
		}
		elseif (get_instance()->agent->is_mobile())
		{
		    $user_agent = get_instance()->agent->mobile();
		}
		else
		{
		    $user_agent = 'Unidentified User Agent';
		}
		
		return $user_agent;
	}
}