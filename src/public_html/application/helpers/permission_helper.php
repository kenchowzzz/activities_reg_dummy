<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//=========================================
//	Module Level
//=========================================

if ( ! function_exists('get_module_permissions'))
{
	function get_module_permissions($role_id, $module_id)
	{
		$permissions = array();
		
		$db_permissions = get_instance()->tam_model->GetAclModulePermissionByRoleIdModuleId($role_id, $module_id)->result();
		foreach ($db_permissions as $db_permission)
		{
			array_push($permissions, $db_permission->perm_id);
		}
		
		return $permissions;
	}
}

if ( ! function_exists('get_user_module_permissions'))
{
	function get_user_module_permissions($user_id, $dept_unit_code, $module_id)
	{
		$permissions = array();
		
		$db_permissions = get_instance()->tam_model->GetAclModulePermissionByUserIdDeptUnitCodeModuleId($user_id, $dept_unit_code, $module_id)->result();
		//$db_permissions = get_instance()->tam_model->GetAclModulePermissionByUserIdModuleId($user_id, $module_id)->result();
		foreach ($db_permissions as $db_permission)
		{
			array_push($permissions, $db_permission->perm_id);
		}
		
		return $permissions;
	}
}

if ( ! function_exists('can_read'))
{
	function can_read($permissions)
	{
		return in_array(PERMISSION_ID_Read, $permissions);
	}
}

if ( ! function_exists('can_import_excel'))
{
	function can_import_excel($permissions)
	{
		return in_array(PERMISSION_ID_ImportExcel, $permissions);
	}
}

if ( ! function_exists('can_export_excel'))
{
	function can_export_excel($permissions)
	{
		return in_array(PERMISSION_ID_ExportExcel, $permissions);
	}
}

if ( ! function_exists('can_print_label'))
{
    function can_print_label($permissions)
    {
        return in_array(PERMISSION_ID_PrintLabel, $permissions);
    }
}

if ( ! function_exists('can_create'))
{
	function can_create($permissions)
	{
		return in_array(PERMISSION_ID_Create, $permissions);
	}
}


if ( ! function_exists('can_update'))
{
	function can_update($permissions)
	{
		return in_array(PERMISSION_ID_Update, $permissions);
	}
}

if ( ! function_exists('can_delete'))
{
	function can_delete($permissions)
	{
		return in_array(PERMISSION_ID_Delete, $permissions);
	}
}

if ( ! function_exists('can_add_or_delete'))
{
	function can_create_or_delete($permissions)
	{
		return can_create($permissions) or can_delete($permissions);
	}
}

if ( ! function_exists('can_read_or_update'))
{
	function can_read_or_update($permissions)
	{
		return can_read($permissions) or can_update($permissions);
	}
}

if ( ! function_exists('can_print_label'))
{
    function can_print_label($permissions)
    {
        return in_array(PERMISSION_ID_PrintLabel, $permissions);
    }
}
