<?php class Rpt_base_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}	
	
		

	
	public function GetReportByIdRoleDept(
		$rpt_id 
	,	$role_dept 	
	){
		$query = $this->db->query("
			exec sp_rpt_GetReportByIdRoleDept
				@rpt_id = ?
			,	@role_dept = ?
		"
 
		,	array(
				$rpt_id
			,	$role_dept		
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

	
	public function GetReportsByRptTypeIdRoleDept(
		$rpt_type_id 
	,	$role_dept 	
	){
		$query = $this->db->query("
			exec sp_rpt_GetReportsByRptTypeIdRoleDept
				@rpt_type_id = ?
			,	@role_dept = ?
		"
 
		,	array(
				$rpt_type_id
			,	$role_dept		
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

	
	public function GetAttendanceReportData(){
		$query = $this->db->query("
			exec sp_rpt_GetAttendanceReportData
		");

        $error = $this->db->error();
        if ($error["message"]){
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			throw new Exception($error["message"], $errorCode);
		}

		return $query;
	}

}