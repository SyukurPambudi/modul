<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
function pdf_create($html, $filename, $stream=TRUE, $orientation="Portrait")   
{
	$ci = &get_instance();
    require_once("dompdf/dompdf_config.inc.php");  
    spl_autoload_register('DOMPDF_autoload');
	
	$dompdf = new DOMPDF();
    $dompdf->load_html($html);  
	$dompdf->set_paper("A4",$orientation);  
    $dompdf->render();  
    if ($stream) {
    	if($ci->input->is_ajax_request()) {
    		echo $dompdf->stream($filename.".pdf");
    	}
		else {
			$dompdf->stream($filename.".pdf");
			return true;
		}
    } else {  
        $CI =& get_instance();  
        $CI->load->helper('file');  
        write_file("./file/report/$filename.pdf", $dompdf->output());  
    }  
}     
/*if (!defined('BASEPATH')) exit('No direct script access allowed');  
function pdf_create($html, $filename, $stream=TRUE)   
{  
    require_once("dompdf/dompdf_config.inc.php");
	ini_set("memory_limit","850M");
	set_time_limit('1000');   
    spl_autoload_register('DOMPDF_autoload');  
    $dompdf = new DOMPDF();  
    $dompdf->load_html($html);  
	$dompdf->set_paper("A4","landscape");  
    $dompdf->render();  
    if ($stream) {  
        $dompdf->stream($filename.".pdf");  
    } else {  
        $CI =& get_instance();  
        $CI->load->helper('file');  
        write_file("./uploads/$filename.pdf", $dompdf->output());  
    }  
}*/