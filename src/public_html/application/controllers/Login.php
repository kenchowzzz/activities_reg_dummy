<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Load Library
		$this->load->library("utils/Session_manager");

		// Load Model
		$this->load->model('tam_model');
		
		// Load Helper
		$this->load->helper('login');
	}
	
	public function index()
	{
		$this->load->view('login/index');
	}
	
	public function manual_login()
	{
		try 
		{
			if ($this->config->item("service_termination") != '' && time() >= strtotime($this->config->item("service_termination")))
			{
				redirect("login");
				exit;
			}
	
			$username = $this->value_validator->validate_text($this->input->post("username"), TRUE);
			
			if ( ! $username)
			{
				throw new Exception("Username is required.", ERROR_CODE_MISSING_REQUIRED_FIELD);
			}
			
			$db_user = $this->tam_model->GetAclUserByUsername($username)->row();
			
			if (! $db_user)
			{
				throw new Exception("User not found.", ERROR_CODE_UNKNOWN_USER);
			}
			
			$sso_object = build_sso_user_portfolio(
				$db_user->staff_std_type,
				$db_user->username, 
				$db_user->user_id,
				sprintf("%s %s", $db_user->fam_name, $db_user->oth_name),
				$db_user->dept_unit_code,
				$db_user->email
			);
			
			$redirect_path = process_login($sso_object);

            redirect($redirect_path);
		}
		catch (Exception $ex) 
		{
			$this->session->set_flashdata("error", array("code" => $ex->getCode(), "msg" => $ex->getMessage()));
			redirect("login");
		}
	}
	
	public function logout(){
		delete_cookie("autherPanel.isShow");
		$this->session_manager->LogOffUser();
	}

	public function expired()
	{
		$this->session->set_flashdata("error", array("code" => ERROR_CODE_SESSION_EXPIRED, "msg" => "Please Login!"));
		redirect("login");
	}
	
	public function unauthorized()
	{
		$this->session->set_flashdata("error", array("code" => ERROR_CODE_UNAUTHORIZED, "msg" => "Unauthorised login.   "));
		redirect("login");
	}

}
