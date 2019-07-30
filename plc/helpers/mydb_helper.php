<?php
function mydb($name,$boolean = TRUE) {
	$_ci =& get_instance();
	$_ci->db->close();
	return $_ci->load->database($name,$boolean);
}