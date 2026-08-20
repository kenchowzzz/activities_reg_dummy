<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tam_user_profile {
	
	private $user_type;	// E.g.: student / staff 
	private $username;
	private $user_id;
	private $eng_name;
	private $dept_unit_code;
	private $role_id;
	private $role_dept_unit_code;
	private $role_list;
	private $role_id_list;
	private $role_list_by_role_dept;
	private $menu_items;
	
	public function __construct($sso_user_profile, $role_id, $role_dept_unit_code, $acl_dept_unit_code, $menu_items)
	{
		get_instance()->load->model('tam_model');
		
		$this->user_type = $sso_user_profile->get_user_type();
		$this->username = $sso_user_profile->get_ad_username();
		$this->user_id = $sso_user_profile->get_staff_std_no();
		$this->eng_name = $sso_user_profile->get_eng_name();
		$this->dept_unit_code = $acl_dept_unit_code;
		$this->role_id = $role_id;
		$this->role_dept_unit_code = $role_dept_unit_code;
		$this->role_list = get_instance()->tam_model->GetAclRolesByUserIdDeptUnitCode($this->user_id, null)->result();
		$this->role_id_list = array();
		foreach ($this->role_list as $role)
		{
			if (!in_array($role->role_id, $this->role_id_list))
			{
				array_push($this->role_id_list, $role->role_id);
			}
		}
		$this->role_list_by_role_dept = get_instance()->tam_model->GetAclRolesByUserIdDeptUnitCode($this->user_id, $this->role_dept_unit_code)->result();
		$this->menu_items = $menu_items;
		
		get_instance()->session->set_userdata(SESSION_KEY_TAM_USER_PROFILE, json_encode(serialize($this)));
	}
	
	
	public function get_user_type()
	{
		return $this->user_type;
	}
	
	public function get_username()
	{
		return $this->username;
	}
	
	public function get_user_id()
	{
		return $this->user_id;
	}
	
	public function get_eng_name()
	{
		return $this->eng_name;
	}
	
	public function get_dept_unit_code()
	{
		return $this->dept_unit_code;
	}
	
	public function get_role_id()
	{
		return $this->role_id;
	}
	
	public function get_role_dept_unit_code()
	{
		return $this->role_dept_unit_code;
	}
	
	public function get_role_list()
	{
		return $this->role_list;
	}

	public function get_role_id_list()
	{
		return $this->role_id_list;
	}
	
	public function get_role_list_by_role_dept()
	{
		return $this->role_list_by_role_dept;
	}
	
	public function get_menu_items()
	{
		return $this->menu_items;
	}
	
}
	