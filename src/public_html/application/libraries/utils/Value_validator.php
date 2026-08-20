<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Value_validator 
{
	public function validate_text($value = null, $isMandatory = false, $isAllowNull = true)
	{
		if ($value === false && $isMandatory)
		{				
			return false;
		} 
		else if ($isAllowNull && empty($value))
		{				
			return null;
		} 
		else 
		{
			return trim($value);
		}
	}
	
	public function validate_checkbox($value, $isMandatory = false)
	{
		if ($value === false && $isMandatory)
		{
			return false;
		} 
		else 
		{
			return (strtolower($value) == "on" || strtolower($value) == "y" || strtolower($value) == "1") ? "Y" : null;
		}
	}
	
	public function validate_numeric($value, $isMandatory = false)
	{
		if ($value === false && $isMandatory)
		{				
			return false;
		} 
		elseif ($value === false) 
		{				
			return null;
		} 
		elseif (!empty($value) && is_numeric($value)) 
		{
			return $value;	
		} 
		else
		{
			return false;	
		}
	}
	
	public function validate_integer($value, $isMandatory = false)
	{
		if ($value === false && $isMandatory)
		{				
			return false;
		} 
		elseif ($value === false) 
		{				
			return null;
		} 
		// elseif (!empty($value) && is_int(intval($value)) && strval(intval($value)) == $value)
		// {
			// return $value;	
		// } 
		elseif (is_int(intval($value)))
		{
			return intval($value);	
		} 
		else
		{
			return false;	
		}
	}
	
	public function validate_datetime($value, $isMandatory = false)
	{
		if ($value == false && $isMandatory)
		{
			return false;
		} 
		elseif ($value == false) 
		{
			return null;
		} 
		elseif (!empty($value) && DateTime::createFromFormat('Y-m-d H:i:s', $value))
		{
			return $value;	
		} 
		else 
		{
			return false;
		}
	}

	public function validate_datetime_without_second($value, $isMandatory = false)
	{
		if ($value == false && $isMandatory)
		{
			return false;
		} 
		elseif ($value == false) 
		{
			return null;
		} 
		elseif (!empty($value) && DateTime::createFromFormat('Y-m-d H:i', $value))
		{
			return $value;	
		} 
		else 
		{
			return false;
		}
	}
	
	public function validate_date($value, $isMandatory = false)
	{
		if ($value == false && $isMandatory)
		{
			return false;
		} 
		else if ($value == false) 
		{
			return null;
		} 
		else if (!empty($value) && DateTime::createFromFormat('Y-m-d', $value))
		{
			return $value;	
		} 
		else 
		{
			return false;
		}
	}
	
	public function validate_php_array($array, $isMandatory = false)
	{
		if ($array == false && $isMandatory)
		{
			return false;
		} 
		else if($array == false) 
		{
			return array();
		} 
		else if(is_array($array)) 
		{
			return $array;	
		} 
		else
		{
			return false;	
		}
	}
	
	public function validate_boolean($value)
	{
		return (strtolower($value) == "true") ? true : false;
	}
	
	public function validate_email($value, $isMandatory = false)
	{
		if ((! empty($value) && ! filter_var($value, FILTER_VALIDATE_EMAIL)) or ($value === false && $isMandatory))
		{
			return false;
		} 
		elseif (empty($value)) 
		{
			return null;
		} 
		else
		{
			return $value;	
		}
	}
	
	public function validate_radio($value, $isMandatory = false)
	{
		if ($value === false && $isMandatory)
		{
			return false;
		} 
		else 
		{
			return ! empty($value) ? $value : null;
		}
	}
}
