<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_application extends Base_Controller {

	private $view_module;
	private $view_folder;

	public function __construct()
	{
		$this->module_id = 2; // 'Activity application' module (see seed_min.sql)
		parent::__construct();

		// Load model
		$this->load->model("activity_model");

		// Define variable
		$this->data["form_id"] = "form_".$this->module_id;
		$this->view_module = sprintf("%s", strtolower(get_class()));
		$this->view_folder = sprintf("%s/", $this->view_module);
	}

	// Returns the create-activity form as an HTML fragment (loaded via AJAX)
	public function load_create_form()
	{
		try
		{
			// Feed the create-form dropdown/checkbox sources (sp_tam_Get*List)
			$m = $this->activity_model;

			$this->data["quality"]                = $m->GetLookupList("sp_tam_GetQualityList")->result();
			$this->data["co_organiser_dept"]      = $m->GetLookupList("sp_tam_GetDeptList")->result();
			$this->data["activity_component"]     = $m->GetLookupList("sp_tam_GetComponentList")->result();
			$this->data["activity_purpose"]       = $m->GetLookupList("sp_tam_GetActivityPurposeList")->result();
			$this->data["learning_outcome"]       = $m->GetLookupList("sp_tam_GetLearningOutcomeList")->result();
			$this->data["curricular_requirement"] = $m->GetLookupList("sp_tam_GetCurricularRequirementList")->result();

			// Grouped selects: the form does foreach($x as $group => $rows) -> wrap the flat list under one group
			$this->data["co_organiser_society"] = array("Society / Alumni" => $m->GetLookupList("sp_tam_GetSocietyList")->result());

			// Combined questionnaire list; the view splits it into activity/cr by mapping_type itself
			$this->data["questionnaire_questions"] = $m->GetLookupList("sp_tam_GetQuestionnaireQuestionList")->result();

			// Objective-evaluation methods (no lookup table -> inline; the "Others" id must match ACTIVITY_OBJ_EVALUATION_OTHER)
			$obj = function($id, $name) { $o = new stdClass(); $o->id = $id; $o->name = $name; $o->checked = 'N'; return $o; };
			$this->data["activity_obj_evaluation"] = array(
				$obj(1, "Survey / Questionnaire"), $obj(2, "Observation"),
				$obj(3, "Assessment / Test"),      $obj(99, "Others")
			);

			$html = $this->load->view($this->view_folder . 'create_form', $this->data, TRUE);
			$this->json_responder->response($html);
		}
		catch (Exception $ex)
		{
			$this->json_responder->error($ex);
		}
	}
}
