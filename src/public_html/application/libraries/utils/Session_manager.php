<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_manager {
		
	private $CI;

	public function __construct(){
		$this->CI =& get_instance();
	}

	public function __destruct(){

	}


	public function IsSessionExpired(){
		
		if(!($this->CI->session->userdata("staff_std_no")))
		{
			return 	true;
		} else {
			return false;
		}
	}

	// public function IsSessionExpiredForAjax(){
		// $this->CI->load->helper('url');
		// if(!($this->CI->session->userdata("staff_std_no")))
		// {
			// $this->KillSession();
			// $results = array("is_session_expired" => true);
			// header('Content-type: application/json');
			// echo json_encode($results);
			// return true;
		// } else {
			// return false;
		// }
	// }

	// public function CheckSessionExpired(){
		// $this->CI->load->helper('url');
		// if(!($this->CI->session->userdata("staff_std_no")))
		// {
			// $this->KillSession();
			// header( "Location: " . $this->CI->config->base_url() . "session/expired");
			// exit();
		// }
	// }

	public function KillSession(){

		$this->CI->session->unset_userdata("staff_std_no");

	}

	public function LogOffUser(){
		
		$this->KillSession();

		//destroy all sessions
		$this->CI->session->sess_destroy();
		
		//redirect to login page
		redirect("login");
	}

}

