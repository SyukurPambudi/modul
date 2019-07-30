<?php
	defined('BASEPATH') or exit('No direct script access');	 
	if ( !function_exists('second2day') ) {
		function second2day($secs) {
			$secs = (int)$secs;
			if ( $secs === 0 ) {
	            return '0 Detik';
	        }
	        $mins  = 0;
	        $hours = 0;
	        $days  = 0;
	       // $weeks = 0;
	        if ( $secs >= 86400 ) {
	            $days = (int)($secs / 86400);
	            $sisa = $secs % 86400;
				$hours = (int)($sisa / 3600);
	            $sisa = $sisa % 3600;
				$mins = (int)($sisa / 60);
	            $det = $sisa % 60;
	        }
	        else if ( $secs < 86400 ) {
	            $hours = (int)($secs / 3600);
	            $sisa = $secs % 3600;
				$mins = (int)($sisa / 60);
	            $det = $sisa % 60;
	        }
	        else if ( $secs < 3600 ) {
	            $mins = (int)($secs / 60);
	            $det = $secs % 60;
	        }
			elseif ( $secs == 3600 ) {
				$hours= (int) ($secs/3600);
			}
			else
			{
				$det = $secs;
			}
			
	        /*if ( $sisa >= 7 ) {
	            $weeks = (int)($days / 7);
	            $days = $days % 7;
	        }
			*/
	        $result = '';
	        /*if ( $weeks ) {
	            $result .= "{$weeks} Minggu, ";
	        }
			*/
	        if ( $days ) {
	            $result .= "{$days} Hari ";
	        }
	        if ( $hours ) {
	            $result .= "{$hours} Jam, ";
	        }
	        if ( $mins ) {
	            $result .= "{$mins} Menit, ";
	        }
	        if ( $det ) {
	            $result .= "{$det} Detik ";
	        }
	        $result = rtrim($result);
	        return $result;
		}
		function second2hour($secs) {
			$secs = (int)$secs;
			if ( $secs === 0 ) {
				return '0 Detik';
			}
			$mins  = 0;
			$hours = 0;
			//$days  = 0;
			// $weeks = 0;
			
			if ($secs > 3600){
				$hours = (int)($secs / 3600);
				$sisa = $secs % 3600;
				$mins = (int)($sisa / 60);
				$det = $sisa % 60;
			}
			elseif ( $secs < 3600 ) {
				$mins = (int)($secs / 60);
				$det = $secs % 60;
			}
			elseif ( $secs == 3600 ) {
				$hours= (int) ($secs/3600);
			}
			else
			{
				$det = $secs;
			}
				
			/*if ( $sisa >= 7 ) {
			 $weeks = (int)($days / 7);
			$days = $days % 7;
			}
			*/
			$result = '';
			/*if ( $weeks ) {
			 $result .= "{$weeks} Minggu, ";
			}
			*/
			if ( $hours ) {
				$result .= "{$hours} Jam, ";
			}
			if ( $mins ) {
				$result .= "{$mins} Menit, ";
			}
			if ( $det ) {
				$result .= "{$det} Detik, ";
			}
			$result = rtrim($result);
			return $result;
		}

		function numberwithsparator($number) {
			$number = (int)$number;
			if ( $number === 0 ) {
				$result= '0';
			}else{
				$result=number_format($number, 2, '.', ',');
			}
			return $result;
		}

		function numberwithsparator2($number) {
			$number = (int)$number;
			if ( $number === 0 ) {
				$result= '0';
			}else{
				$result=number_format($number, 0, '', ' ');
			}
			return $result;
		}

	}