<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{	
	protected $sso_user_profile;
	
	protected $current_dt;
	protected $current_username;
	protected $current_user_id;
	protected $current_dept_unit_code;
	protected $current_role_id;
	protected $current_role_dept_unit_code;
	
	protected $moduleName = '';
	protected $modulePath = '';
	protected $module_id;
	protected $modulePermissions = array();
	
	protected $data = array();

	public function __construct(){
			
		 parent::__construct();
		
         $this->load->model('tam_model');
		 $this->load->library('user_agent');
		 $this->load->library('json_responder');
         
         if(!$this->input->is_cli_request()){
		 	
			$session_sso_user_profile = $this->session->userdata(SESSION_KEY_SSO_USER_PROFILE);

			if ($session_sso_user_profile)
			{
				$this->sso_user_profile = unserialize(json_decode($session_sso_user_profile));
			}

			$session_tam_user_profile = $this->session->userdata(SESSION_KEY_TAM_USER_PROFILE);

			$is_ajax = start_with($this->uri->uri_string(), $this->config->item("path_prefix_json_api")) || start_with($this->uri->uri_string(), $this->config->item("path_prefix_json_html"));

			if ($session_tam_user_profile)
			{
				$this->tam_user_profile = unserialize(json_decode($session_tam_user_profile));

				$this->current_dt = now();
				$this->current_username = $this->tam_user_profile->get_username();
				$this->current_user_id = $this->tam_user_profile->get_user_id();
				$this->current_dept_unit_code = $this->tam_user_profile->get_dept_unit_code();
				$this->current_role_id = $this->tam_user_profile->get_role_id();
				$this->current_role_dept_unit_code = $this->tam_user_profile->get_role_dept_unit_code();
				
				//store foot print
				$module = $this->tam_model->GetAclModuleByUserIdDeptUnitCodeModuleId(
					$this->current_user_id
				,	$this->current_role_dept_unit_code
				,	$this->module_id
				)->row();

				if(!empty($module)){
					//set page title
					$this->data["page_title"] = $module->module_desc;
					
					$this->data["module_name"] = $module->module_name;
					$this->data["module_desc"] = $module->module_desc;
					$this->data["module_json_api_path"] = $module->json_api_path;
					$this->data["module_json_html_path"] = $module->json_html_path;
					$this->data["modulePath"] = $module->module_path;
					$this->data['notification_notread'] = 0;


				} else {
					//redirect to unauthorized page
					if($is_ajax){
						//----------- ajax  ------------------//
						$results = array(
							"is_unauthorized" => true
						,	"uri" => $this->uri->segment(1) . "/". $this->router->fetch_class()
						);
						$this->json_responder->Response($results);
						exit();
					} else {
						//----------- not ajax ------------------//
						redirect("login/unauthorized");
					}
				}
				
			} else {
				
				$this->session_manager->KillSession();
				
				if ($is_ajax)
				{
					// Ajax Request
					// For HTML Ajax Request - Return session expired JSON response. Then, trigger a redirection to login page and prompt session expired message
					// For API Ajax Request - Return session expired JSON response and prompt session expired message
					$require_redirect = start_with($this->uri->uri_string(), $this->config->item("path_prefix_json_html")) ? true : false;
					$this->json_responder->Session_expired($require_redirect);
					exit();
				}
				else	
				{
					// Non-ajax Request - Redirect to login page and prompt session expired message
					redirect("login/expired");
				}
			}

			$this->modulePermissions = get_user_module_permissions($this->current_user_id, $this->current_role_dept_unit_code, $this->module_id);
			
			// Check read permission
			if ( ! can_read($this->modulePermissions))
			{
				if ($is_ajax)
				{
					$this->json_responder->Error(new Exception(sprintf("No permission to %s [<b>%s</b>].", "read", $this->data["module_name"]), ERROR_CODE_PERMISSION_DENIED));
					exit();
				}
				else 
				{
					show_error_page("Permission Denied", new Exception(sprintf("No permission to %s [<b>%s</b>].", "read", $this->data["module_name"]), ERROR_CODE_PERMISSION_DENIED));	
				}
			}
			
			//write in $this->data
			$this->data["module_id"] = $this->module_id;
			$this->data["modulePermissions"] = $this->modulePermissions;
			$this->data["tam_user_profile"] = $this->tam_user_profile;
			$this->data["current_user_id"] = $this->current_user_id;
			$this->data["current_username"] = $this->current_username;
			$this->data["current_role_dept_unit_code"] = $this->current_role_dept_unit_code;
		}
	}

	private function getBrowser(){
		
		
		$tempstr ="";
	
		if ($this->agent->is_browser())
		{
		    $tempstr =  $this->agent->browser()." ".$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		    $tempstr = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		    $tempstr = $this->agent->mobile();
		}
		else
		{
		    $tempstr = 'Unidentified User Agent';
		}
		
		return $tempstr;
		
	}
		
}
?>	