<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sso_user_profile {
	
	private $user_type;
	private $staff_std_no;
	private $eng_name;
	private $chi_name;
	private $dept_unit_code;
	private $email;
	private $ad_username;
	private $default_locale;
	
	private $menu_items;
	
	public function __construct($sso_obj)
	{
		$this->staff_std_no = $sso_obj->staff_std_no;
		$this->email = $sso_obj->email;
		$this->user_type = isset($sso_obj->user_type) ? strtolower($sso_obj->user_type) : "";
		
		$this->ad_username = $sso_obj->username;
		
		$this->dept_unit_code = $sso_obj->dept_unit_code;	
		$this->eng_name = $sso_obj->eng_name;
		
		$this->chi_name = isset($sso_obj->chi_name) ? urldecode($sso_obj->chi_name) : "";
		$this->default_locale = isset($sso_obj->default_locale) ? $sso_obj->default_locale : "";
		
		get_instance()->session->set_userdata(SESSION_KEY_SSO_USER_PROFILE, json_encode(serialize($this)));
		
	}
	
	public function get_user_type()
	{
		return $this->user_type;
	}
	
	public function get_staff_std_no()
	{
		return $this->staff_std_no;
	}
	
	public function get_eng_name()
	{
		return $this->eng_name;
	}
	
	public function get_chi_name()
	{
		return $this->chi_name;
	}
	
	public function get_dept_unit_code()
	{
		return $this->dept_unit_code;
	}
	
	public function get_email()
	{
		return $this->email;
	}
	
	public function get_ad_username()
	{
		return $this->ad_username;
	}
	
	public function get_default_locale()
	{
		return $this->default_locale;
	}
	
}
	