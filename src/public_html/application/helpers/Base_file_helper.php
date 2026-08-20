<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_file_cnt'))
{
	function get_file_cnt($dir, $include_sub_dir_cnt = FALSE)
	{
		$dir_file_info = get_dir_file_info($dir);
		
		$cnt = 0;
		
		if ($dir_file_info)
		{
			foreach ($dir_file_info as $name => $info)
			{
				if (is_file($info['server_path']) or (is_dir($info['server_path']) && $include_sub_dir_cnt))
				{
					$cnt++;
				}
			}
		}
		return $cnt;
	}
}

if ( ! function_exists('create_dir_recursive'))
{
	function create_dir_recursive($dir)
	{
 		if (!is_dir($dir)) 
 		{ 
 			return mkdir($dir, 0755, true);
   		} 
	}
}

if ( ! function_exists('delete_dir_recursive'))
{
	function delete_dir_recursive($dir, $deleteDir = null)
	{
 		if (is_dir($dir)) 
 		{ 
 			$objects = scandir($dir); 
 			foreach ($objects as $object) 
 			{ 
   				if ($object != "." && $object != "..") 
   				{ 
 					if (is_dir($dir."/".$object))
   						delete_dir_recursive($dir."/".$object);
 					else
   						unlink($dir."/".$object); 
       			} 
     		}
			
			if ($deleteDir === true) rmdir($dir); 
   		} 
	}
}

if ( ! function_exists('export_file'))
{
	function export_file($file_path, $data)
	{
		ob_clean();
		
		header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($file_path));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
		print trim($data);
	    exit;
	}
}

if ( ! function_exists('generate_csv'))
{
	function generate_csv($file_path, $data)
	{
		$csv = fopen($file_path, 'w');
		
		// Add BOM to fix UTF-8 in Excel
		fputs($csv, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		
		foreach ($data as $row)
		{
			fputcsv($csv, $row);
		}
		
		fclose($csv);
	}
}


if ( ! function_exists('export_csv'))
{
	function export_csv($file_name, $data)
	{
		ob_clean();
			
		header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"" . $file_name . "\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
		
		fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
		
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
    	fclose($handle);
        exit;
	}
}