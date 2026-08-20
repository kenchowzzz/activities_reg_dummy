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

	public function index()
	{
		try
		{
			$this->data['content_left'] = $this->load->view($this->view_folder . 'list', $this->data, TRUE);
			$this->data['container']    = $this->load->view($this->view_folder . 'container', $this->data, TRUE);
			$this->load->view('layout/base/view', $this->data);
		}
		catch (Exception $ex)
		{
			show_error_page("System Error", $ex);
		}
	}
}
