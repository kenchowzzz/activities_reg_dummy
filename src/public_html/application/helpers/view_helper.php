<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('to_html_entities'))
{
	function to_html_entities($obj)
	{
		$result = (object) array();
		
		if ( ! empty($obj))
		{
			foreach ($obj as $key => $value)
			{
				$type = gettype($key);
				
				switch ($type) 
				{
					case 'array':
						throw new Exception("[to_html_entities] Array To Do");
					break;
					case 'object':
						throw new Exception("[to_html_entities] Object To Do");
					break;
					case 'string':
						$result->$key = htmlentities($value, ENT_QUOTES, "UTF-8");
					break;
					case 'integer':
						$result->$key = $value;
					break;
					default:
						throw new Exception("[to_html_entities] Default To Do [type: $type]");
					break;
				}
			}	
		}
		
		return $result;
	}
}

if ( ! function_exists('load_author_panel'))
{
	function load_author_panel($create_by, $create_dt, $update_by, $update_dt)
	{
		$data = array();
		
		// if ( ! is_null($create_by)) 
		// {
			$data['create_by'] = $create_by;
		// }
		// if ( ! is_null($create_dt)) 
		// {
			$data['create_dt'] = convert_to_datetime($create_dt, DATETIME_FORMAT) == null ? "" : convert_to_datetime($create_dt, DATETIME_FORMAT);
		// }
		// if ( ! is_null($update_by))
		// {
			$data['update_by'] = $update_by;
		// }
		// if ( ! is_null($update_dt))
		// {
			$data['update_dt'] = convert_to_datetime($update_dt, DATETIME_FORMAT) == null ? "" : convert_to_datetime($update_dt, DATETIME_FORMAT);
		// }
		
   		return get_instance()->load->view("layout/base/author_panel", $data, TRUE);
	}
}


if ( ! function_exists('construct_alu_don_name'))
{
	function construct_alu_don_name($fam_name, $oth_name, $chi_name = null, $title = null)
	{
		return sprintf(
			"%s%s%s%s",
			empty($title) ? '' : $title.' ',
			$fam_name,
			empty($oth_name) ? '' : ', '.$oth_name,
			empty($chi_name) ? '' : ' ('.$chi_name.')'
		);
	}
}

if ( ! function_exists('construct_career_detail_name'))
{
	function construct_career_detail_name($comp_name, $dept_name, $job_title)
	{
		$name = trim($comp_name);
		$name .= empty($dept_name) ? '' : ', '.$dept_name;
		$name .= empty($job_title) ? '' : ', '.$job_title;
		$name = empty($name) ? $name : '('.$name.')';
		return $name;
	}
}