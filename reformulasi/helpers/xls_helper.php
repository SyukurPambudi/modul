<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('array_to_xls'))
{
	function array_to_xls($array, $download = "")
	{
		if ($download != "")
		{	
			header('Content-type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment; filename="' . $download . '"'); 
			header('Pragma: no-cache'); 
			header('Expires: 0');
		}		
		$data = '';
		for($i=0;$i<count($array);$i++) 
 		{ 
 			$line = ''; 
 			foreach($array[$i] as $value) 
			{ 
 				if ((!isset($value)) OR ($value == "")) 
				{ 
 					$value = "\t"; 
 				} 
				else 
				{ 
 					$value = str_replace('"', '""', $value); 
 					$value = '"' . $value . '"' . "\t"; 
 				} 
 				$line .= $value; 
 			} 
 			$data .= trim($line)."\n"; 
 		}
 		$data = str_replace("\r", "", $data); 
		if ($data == "") 
 		{ 
 			$data = "\n(0) Records Found!\n"; 
 		} 

		if ($download == "")
		{
			return $data;	
		}
		else
		{	
			echo $data;
		}		
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_xls'))
{
	function query_to_xls($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_xls($array, $download);
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */