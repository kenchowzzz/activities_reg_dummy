<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('show_error_panel'))
{
	function show_error_panel($heading, $exception)
	{
		$data['heading'] = $heading;
		$data['exception'] = $exception;
		get_instance()->load->view('errors/html/error_custom', $data);
		get_instance()->output->_display();
		exit;
	}
}

if ( ! function_exists('show_error_page'))
{
	function show_error_page($heading, $exception)
	{
		$data['heading'] = $heading;
		$data['exception'] = $exception;
		$data['container'] = get_instance()->load->view('errors/html/error_custom', $data, TRUE);
		$data['sys_user_profile'] = unserialize(json_decode(get_instance()->session->userdata(SESSION_KEY_TAM_USER_PROFILE)));
		$data['current_user_id'] = $data['sys_user_profile']->get_user_id();
		$data['current_role_dept_unit_code'] = $data['sys_user_profile']->get_role_dept_unit_code();

		get_instance()->load->view('layout/base/view', $data);
		get_instance()->output->_display();
		exit;
	}
}

if ( ! function_exists('get_error_page_json_html'))
{
	function get_error_page_json_html($heading, $exception)
	{
		$data['heading'] = $heading;
		$data['exception'] = $exception;
		$data['container'] = get_instance()->load->view('errors/html/error_custom', $data, TRUE);
		$data['sys_user_profile'] = unserialize(json_decode(get_instance()->session->userdata(SESSION_KEY_TAM_USER_PROFILE)));
		
		get_instance()->load->view('layout/base/view', $data, TRUE);
		get_instance()->output->_display();
		exit;
	}
}

