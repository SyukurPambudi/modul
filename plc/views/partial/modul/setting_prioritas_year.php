<?php 
	//echo $row_row_value.'oke';

	if($act == 'create'){
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-1; //dari -2 diganti -3
		$sampai = $thn_sekarang+30;
		$echo = '<select class=" '.$field_required.' choose" id="'.$nmfield.'" name="'.$nmfield.'">';
		/*$echo .= '<option value="">--Pilih--</option>';*/
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';

	}else{
		/*$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-1; //dari -2 diganti -3
		$sampai = $thn_sekarang+1;
		$echo = '<select class="required choose" id="'.$nmfield.'" name="'.$nmfield.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$selected = $row_value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';*/
		$echo = $row_value;
		$echo .= '<input type="hidden" value="'.$row_value.'" name="'.$nmfield.'" id="'.$nmfield.'" >';
	}
		

	  $echo .= '
					<style>
						#'.$nmfield.'{
							min-width: 150px;
						}
					</style>
					';


		echo $echo;
 ?>