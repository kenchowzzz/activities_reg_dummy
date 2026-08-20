<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Menu_generator
{
	
	private $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		//load model
		$this->CI->load->model("tam_model");
	}
	
	public function __destruct()
	{
		
	}
	
	public function get_menu_items($user_id, $role_dept_unit_code, $parent_module_id = null, $is_visible_in_header_menu = 1, $include_child_modules = TRUE)
	{
		$menu_items = array(); 
		
		$db_menu_items = $this->CI->tam_model->GetAclModulesByUserIdDeptUnitCodeParentModuleId($user_id, $role_dept_unit_code, $parent_module_id, $is_visible_in_header_menu)->result();
		
		foreach ($db_menu_items as $i => $db_menu_item)
		{
			if ($is_visible_in_header_menu == $db_menu_item->is_visible_in_header_menu) 
			{
				if ($include_child_modules)
				{
					$child_modules = array();
			
					if ($db_menu_item->child_cnt > 0)
					{
						$child_modules = $this->get_menu_items($user_id, $role_dept_unit_code, $db_menu_item->module_id, $is_visible_in_header_menu);
					}
					
					if (isset($child_modules) && sizeof($child_modules) > 0)
					{
						$db_menu_item->child_modules = $child_modules;
					}
				}
				
				array_push($menu_items, $db_menu_item);
			}
		}

		return $menu_items;
	}
	
}


