<?php class Tam_base_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}	



	
	public function GetAclModuleByUserIdDeptUnitCodeModuleId(
		$user_id 
	,	$dept_unit_code 
	,	$module_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclModuleByUserIdDeptUnitCodeModuleId
				@user_id = ?
			,	@dept_unit_code = ?
			,	@module_id = ?
		"
 
		,	array(
				$user_id
			,	$dept_unit_code
			,	$module_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}


	
	public function GetAclModulePermissionByRoleIdModuleId(
		$role_id 
	,	$module_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclModulePermissionByRoleIdModuleId
				@role_id = ?
			,	@module_id = ?
		"
 
		,	array(
				$role_id
			,	$module_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

	
	public function GetAclModulePermissionByUserIdDeptUnitCodeModuleId(
		$user_id 
	,	$dept_unit_code 
	,	$module_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclModulePermissionByUserIdDeptUnitCodeModuleId
				@user_id = ?
			,	@dept_unit_code = ?
			,	@module_id = ?
		"
 
		,	array(
				$user_id
			,	$dept_unit_code
			,	$module_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

	
	public function GetAclModulePermissionByUserIdModuleId(
		$user_id 
	,	$module_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclModulePermissionByUserIdModuleId
				@user_id = ?
			,	@module_id = ?
		"
 
		,	array(
				$user_id
			,	$module_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

	
	public function GetAclModulesByUserIdDeptUnitCodeParentModuleId(
		$user_id 
	,	$dept_unit_code 
	,	$parent_module_id 
	,	$is_visible_in_header_menu 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclModulesByUserIdDeptUnitCodeParentModuleId
				@user_id = ?
			,	@dept_unit_code = ?
			,	@parent_module_id = ?
			,	@is_visible_in_header_menu = ?
		"
 
		,	array(
				$user_id
			,	$dept_unit_code
			,	$parent_module_id
			,	$is_visible_in_header_menu		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}



	
	public function GetAclRoleDeptByUserId(
		$user_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclRoleDeptByUserId
				@user_id = ?
		"
 
		,	array(
				$user_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}


	
	public function GetAclRolesByUserIdDeptUnitCode(
		$user_id 
	,	$dept_unit_code 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclRolesByUserIdDeptUnitCode
				@user_id = ?
			,	@dept_unit_code = ?
		"
 
		,	array(
				$user_id
			,	$dept_unit_code		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

	
	public function GetAclRolesByUserIdRoleId(
		$user_id 
	,	$role_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclRolesByUserIdRoleId
				@user_id = ?
			,	@role_id = ?
		"
 
		,	array(
				$user_id
			,	$role_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}


	
	public function GetAclUserByUserId(
		$user_id 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclUserByUserId
				@user_id = ?
		"
 
		,	array(
				$user_id		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

	
	public function GetAclUserByUsername(
		$username 	
	){
		$query = $this->db->query("
			exec sp_tam_GetAclUserByUsername
				@username = ?
		"
 
		,	array(
				$username		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}






	
	public function GetDefaultAclModuleByUserIdDeptUnitCode(
		$user_id 
	,	$dept_unit_code 	
	){
		$query = $this->db->query("
			exec sp_tam_GetDefaultAclModuleByUserIdDeptUnitCode
				@user_id = ?
			,	@dept_unit_code = ?
		"
 
		,	array(
				$user_id
			,	$dept_unit_code		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}







	
	public function UpdateUserLastLoginDt(
		$user_id 
	,	$username 	
	){
		$query = $this->db->query("
			exec sp_tam_UpdateUserLastLoginDt
				@user_id = ?
			,	@username = ?
		"
 
		,	array(
				$user_id
			,	$username		
			)
		);
		
        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			//$errorCode = 50000;
			throw new Exception($error["message"], $errorCode);
		}
        
		return $query;   
	}

}