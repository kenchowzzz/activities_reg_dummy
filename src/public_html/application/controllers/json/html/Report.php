<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Base_Controller {
	
	public function __construct()
	{
		// Set module id
		$this->module_id = TAM_MODULE_ID_REPORT;
		
		parent::__construct();
		
		// Load model
		$this->load->model("rpt_model");
	}
	
	public function load_rpt_list($module_id)
	{
		try 
		{
			$this->data["current_role_dept_unit_code"] = $this->current_role_dept_unit_code;
			$this->data['rpt_list'] = $this->rpt_model->GetReportsByRptTypeIdRoleDept(
				(int) $module_id
			, 	$this->current_role_dept_unit_code
			)->result();
			$this->data['content_left'] = $this->load->view('report/attendance_list', $this->data, TRUE);

			$html = $this->load->view('report/container', $this->data, TRUE);
			$this->json_responder->response($html);
		} 
		catch (Exception $ex) 
		{
			$this->json_responder->error($ex);
		}
	}
	
	public function load_select_form()
	{
		try 
		{
			$rpt_id = $this->value_validator->validate_text($this->input->post("rpt_id"), TRUE);
			
			if ( ! $rpt_id)
			{
				throw new Exception("Report Id is required.", ERROR_CODE_MISSING_REQUIRED_FIELD);
			}
			
			// Check permission
			if(! can_read($this->modulePermissions))
			{
				throw new Exception(sprintf("No permission to %s [<b>%s</b>].", "read", $this->data["module_name"]), ERROR_CODE_PERMISSION_DENIED);	
			}
			
			$this->data['rpt'] = $this->rpt_model->GetReportByIdRoleDept(
				$rpt_id
			,	$this->data["tam_user_profile"]->get_role_dept_unit_code()
			)->row();
			$this->data['download_url'] = sprintf('%s%s/%s', base_url(), $this->data['rpt']->controller, $this->data['rpt']->method);

			$this->data["current_role_dept_unit_code"] = $this->current_role_dept_unit_code;
			
			switch ($rpt_id)
			{
				// Add a case per report, loading its selection form view.
				default:
					$html = "Report Not Found";
			}
			
			$this->json_responder->response($html);	
		} 
		catch (Exception $ex) 
		{
			$this->json_responder->error($ex);
		}
	}
}
