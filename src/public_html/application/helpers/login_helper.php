<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('build_sso_user_portfolio'))
{
    function build_sso_user_portfolio($user_type, $username, $user_id, $eng_name, $dept_unit_code, $email = NULL)
    {
        $user_portfolio = new stdClass();
        $user_portfolio->user_type = $user_type;
        $user_portfolio->username = $username;
        $user_portfolio->email = $email;
        $user_portfolio->staff_std_no = $user_id;
        $user_portfolio->eng_name = $eng_name;
        $user_portfolio->dept_unit_code = $dept_unit_code;
        return $user_portfolio;
    }
}

if ( ! function_exists('build_menu_item'))
{
	function build_menu_item($module_name, $module_desc, $module_path, $json_api_path, $json_html_path, $is_visible_in_header_menu, $seq, $child_cnt)
	{
		$menu_item = new stdClass();
		$menu_item->module_name = $module_name;
		$menu_item->module_desc = $module_desc;
		$menu_item->module_path = $module_path;
		$menu_item->json_api_path = $json_api_path;
		$menu_item->json_html_path = $json_html_path;
		$menu_item->is_visible_in_header_menu = $is_visible_in_header_menu;
		$menu_item->seq = $seq;
		$menu_item->child_cnt = $child_cnt;
		
		return $menu_item;
	}
}

if ( ! function_exists('process_login'))
{
    function process_login($sso_user_portfolio)
    {
        // Load Library
        get_instance()->load->library("utils/Menu_generator");
        
        if (isset($sso_user_portfolio))
        {
            
            // Create Sso_user_profile and store it into session
            $sso_user_profile = new Sso_user_profile($sso_user_portfolio);
            
            // Check User Status (Active / Inactive)
            $user = get_instance()->tam_model->GetAclUserByUserId(
                $sso_user_profile->get_staff_std_no()
            )->row();
            
            if(isset($user) && isset($user->is_inactive)){
                $error_code = ERROR_CODE_UNAUTHORIZED;
                throw new Exception("Unauthorised login.   ", $error_code);
            }
            
            return determine_redirect_path_by_role_dept($sso_user_profile);

        }
    }
}

if ( ! function_exists('determine_redirect_path_by_role_dept'))
{
	function determine_redirect_path_by_role_dept($sso_user_profile)
	{
		// Get user roles
		$depts = get_instance()->tam_model->GetAclRoleDeptByUserId(
			$sso_user_profile->get_staff_std_no()
        )->result();
		
		if (sizeof($depts) == 1)
		{
			return process_role_selection(0, $depts[0]->dept_unit_code);
		}

		else
		{
			$error_code = ERROR_CODE_UNAUTHORIZED;
            throw new Exception("Unauthorised login.   ", $error_code);
		}
	}
}

if ( ! function_exists('process_role_selection'))
{
	function process_role_selection($role_id, $role_dept_unit_code)
	{
		// Load Library
		get_instance()->load->library("utils/Menu_generator");
		
		$sso_user_profile = unserialize(json_decode(get_instance()->session->userdata(SESSION_KEY_SSO_USER_PROFILE)));
		
		// Get acl info
		$acl = get_instance()->tam_model->GetAclUserByUserId(
			$sso_user_profile->get_staff_std_no()
		)->row();
		
		// Get user roles
		$roles = get_instance()->tam_model->GetAclRolesByUserIdRoleId(
			$sso_user_profile->get_staff_std_no()
		,	null
		)->result();
		
		foreach ($roles as $roles_row)
		{
			if ($role_dept_unit_code == $roles_row->dept_unit_code)
			{
                $menu_items = get_instance()->menu_generator->get_menu_items($sso_user_profile->get_staff_std_no(), $role_dept_unit_code);
				
				// Redirect to login page if no menu item is found
				if (count($menu_items) <= 0)
				{
					$error_code = ERROR_CODE_UNAUTHORIZED;
                    throw new Exception("Unauthorised login.   ", $error_code);
				}
				
				$tam_user_profile = new Tam_user_profile($sso_user_profile, $role_id, $role_dept_unit_code, $acl->dept_unit_code, $menu_items);
				// Update last login datetime
				get_instance()->tam_model->UpdateUserLastLoginDt($tam_user_profile->get_user_id(), $tam_user_profile->get_username());
				
				// Redirect to the default module according to the min role's default model
				// If cannot find default module of the role, redirect to the first menu item 
				$default_module = null;
				$db_default_module = get_instance()->tam_model->GetDefaultAclModuleByUserIdDeptUnitCode(
					$sso_user_profile->get_staff_std_no()
				,	$role_dept_unit_code
				)->result();
				
				foreach ($db_default_module as $row)
				{
					if ($row->module_id != null) {
						$default_module = $row;
						break;
					}
				}
				
				//find the first module without #
				$first_module_path = 'account';
				foreach($menu_items as $menu_item){
					if($menu_item->module_path != '#'){
						$first_module_path = $menu_item->module_path;
						break;
					}
                }
				
				return ($default_module && $default_module->module_path) ? $default_module->module_path : $first_module_path;
			}
		}
		
		$error_code = ERROR_CODE_UNAUTHORIZED;
        throw new Exception("Unauthorised login.   ", $error_code);
	}
}