<?php
function tanggal($date, $format) {
	return date($format, strtotime($date));
}