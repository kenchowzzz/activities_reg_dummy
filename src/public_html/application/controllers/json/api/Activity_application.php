<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_application extends Base_Controller {

	public function __construct()
	{
		$this->module_id = 2; // 'Activity application' module (see seed_min.sql)
		parent::__construct();

		// Load model
		$this->load->model("activity_model");

		// Define variable
		$this->data["form_id"] = "form_".$this->module_id;
	}

	// Returns the activity list as JSON (DataTable source)
	public function load_activity()
	{
		try
		{
			// Check permission
			if ( ! can_read($this->modulePermissions))
			{
				throw new Exception(sprintf("No permission to %s [<b>%s</b>].", "read", $this->data["module_name"]), ERROR_CODE_PERMISSION_DENIED);
			}

			$result = $this->activity_model->GetActivity()->result();

			$this->json_responder->response(
				array(
					'data' => $result
				)
			);
		}
		catch (Exception $ex)
		{
			$this->json_responder->Error($ex);
		}
	}

	// Creates an activity (no verification / workflow)
	public function create_activity()
	{
		try
		{
			if ( ! can_create($this->modulePermissions))
			{
				throw new Exception(sprintf("No permission to %s [<b>%s</b>].", "create", $this->data["module_name"]), ERROR_CODE_PERMISSION_DENIED);
			}

			$this->db->trans_start();

			$activity_name_value = $this->input->post("activity_name");
			if ($activity_name_value === NULL) {
				$activity_name_value = $this->input->post("title");
			}
			$start_date_value = $this->input->post("activity_start_date");
			if ($start_date_value === NULL) {
				$start_date_value = $this->input->post("start_dt_tm");
			}
			$end_date_value = $this->input->post("activity_end_date");
			if ($end_date_value === NULL) {
				$end_date_value = $this->input->post("end_dt_tm");
			}
			$language_value = $this->input->post("activity_language");
			if ($language_value === NULL) {
				$language_value = $this->input->post("main_language");
			}
			$organiser_value = $this->input->post("activity_organiser");
			if ($organiser_value === NULL) {
				$organiser_value = $this->input->post("organiser_dept");
			}

			// The create form submits date-times; tam_activity stores date values.
			if ($start_date_value !== NULL && $start_date_value !== '') {
				$start_date_value = substr($start_date_value, 0, 10);
			}
			if ($end_date_value !== NULL && $end_date_value !== '') {
				$end_date_value = substr($end_date_value, 0, 10);
			}

			$activity_name       = $this->value_validator->validate_text($activity_name_value, TRUE);
			$start_date          = $this->value_validator->validate_text($start_date_value, TRUE);
			$end_date            = $this->value_validator->validate_text($end_date_value, TRUE);
			$language            = $this->value_validator->validate_text($language_value, TRUE);
			$organiser           = $this->value_validator->validate_text($organiser_value, TRUE);

			if ( ! $activity_name or ! $start_date or ! $end_date or ! $language )
			{
				throw new Exception("Mandatory fields are required.", ERROR_CODE_MISSING_REQUIRED_FIELD);
			}

			$form_data = json_encode($this->input->post(NULL, TRUE), JSON_UNESCAPED_UNICODE);

			$insert_result = $this->activity_model->InsertActivity(
				$activity_name
			, 	$start_date
			, 	$end_date
			, 	$language
			, 	$organiser
			, 	$this->current_username
			, 	$form_data
			);

			$insert_row = ($insert_result === FALSE) ? NULL : $insert_result->row();
			if ( ! is_object($insert_row) || ! isset($insert_row->inserted_id) )
			{
				$this->db->trans_rollback();
				throw new Exception("Activity insert did not return inserted_id.");
			}
			$inserted_id = $insert_row->inserted_id;

			$this->db->trans_complete();

			$this->json_responder->Response(array("isSuccess" => TRUE, "inserted_id" => $inserted_id));
		}
		catch (Exception $ex)
		{
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			$this->json_responder->Error($ex);
		}
	}

}
