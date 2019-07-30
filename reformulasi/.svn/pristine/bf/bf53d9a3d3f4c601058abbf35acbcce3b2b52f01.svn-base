<?php
function to_mysql($date, $inverse = FALSE) {
	if($inverse) {
		$d = substr($date, 8,2);
		$m = substr($date, 5,2);
		$y = substr($date, 0,4);
		return $d.'-'.$m.'-'.$y;
	}
	else {
		$d = substr($date, 0,2);
		$m = substr($date, 3,2);
		$y = substr($date, 6,4);
		return $y.'-'.$m.'-'.$d;
	}
}