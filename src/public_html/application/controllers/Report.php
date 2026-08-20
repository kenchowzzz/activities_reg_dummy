<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Base_Controller {
	
	public function __construct()
	{
		// Set module id
		$this->module_id = TAM_MODULE_ID_REPORT;
		
		parent::__construct();
		
		// Load model
		// $this->load->model("rpt_model");
		
		// Load library
		$this->load->library("utils/Menu_generator");
	}
	
	public function index()
	{
		try 
		{
			$this->data["tab_items"] = $this->menu_generator->get_menu_items(
				$this->current_user_id,
				$this->data["tam_user_profile"]->get_role_dept_unit_code(),
				$this->module_id,
				1,
				FALSE
			);
			
			$this->data['content_left'] = $this->load->view('report/index', $this->data, TRUE);
			$this->data['container'] = $this->load->view('report/container', $this->data, TRUE);
			$this->load->view('layout/base/view', $this->data);
		} 
		catch (Exception $ex) 
		{
			show_error_page("System Error", $ex);
		}
	}
	
}
