<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_lang'))
{
	function get_lang($lang_code)
	{
		$lang = LANGUAGE_CODE_ENG;
		switch($lang_code)
		{
			case 'ENG':
				$lang = LANGUAGE_CODE_ENG;
			break;
			case 'CAN':
				$lang = LANGUAGE_CODE_CAN;
			break;
			case 'MAN':
				$lang = LANGUAGE_CODE_MAN;
			break;
		}
	   return $lang;	
	}
}	