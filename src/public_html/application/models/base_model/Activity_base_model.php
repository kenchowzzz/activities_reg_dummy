<?php class Activity_base_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	
	public function GetActivity(

	){
		$query = $this->db->query("
			exec sp_tam_GetActivity		"
		);

		$this->_check_db_error();

		return $query;
	}

	
	public function GetLookupList($proc)
	{
		$query = $this->db->query("exec " . $proc);
		$this->_check_db_error();
		return $query;
	}

	
	public function InsertActivity(
		$activity_name
	, 	$start_date
	, 	$end_date
	, 	$language
	, 	$organiser
	, 	$create_by
	, 	$form_data
	){
		$query = $this->db->query("
			exec sp_tam_InsertActivity
				@activity_name = ?
			, 	@start_date = ?
			, 	@end_date = ?
			, 	@language = ?
			, 	@organiser = ?
			, 	@create_by = ?
			, 	@form_data = ?
		"
		, 	array(
				$activity_name
			, 	$start_date
			, 	$end_date
			, 	$language
			, 	$organiser
			, 	$create_by
			, 	$form_data
			)
		);

		$this->_check_db_error();

		return $query;
	}

	// Shared DB error handling (same pattern as the other *_base_model classes)
	private function _check_db_error()
	{
		$error = $this->db->error();
		if ($error["message"])
		{
			log_message('error', $error["message"]);
			$errorCode = (int) str_replace("42000/", "", $error["code"]);
			throw new Exception($error["message"], $errorCode);
		}
	}
}
