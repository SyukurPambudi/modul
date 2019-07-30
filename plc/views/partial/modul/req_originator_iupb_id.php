<?php 
	//echo $row_row_value.'oke';
			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	


				$sFieldValidation = 'select a.vSource_input_edit_validtation 
									from plc3.m_modul_fileds_validation a 
									where a.lDeleted=0 
									and a.iValidation=1 
									and a.iM_modul_fileds= "'.$form_field['iM_modul_fileds'].'" ';
				$dFieldValidation = $this->db->query($sFieldValidation)->result_array();

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	 $dFieldValid['vSource_input_edit_validtation'].' ';					
					}
				}
			}else{
				$sql = $form_field['vSource_input'];	
			}
			
			if($sql<>''){
				$pilihan =  $this->db->query($sql, array($dataHead[$field]))->result_array();

	            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" '.$field_required.'>';            
	            foreach($pilihan as $me) {
	                if ($me['valval'] == $dataHead[$field]) $selected = ' selected';
                    else $selected = '';
                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';

			}else{
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
            
/*
	if($act <> 'update'){
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required choose" id="'.$nmfield.'" name="'.$nmfield.'">';
		
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';

		$echo .= '<input type="hidden" name="isdraft" id="isdraft">';
		

	}else{
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required choose" id="'.$nmfield.'" name="'.$nmfield.'">';
		
		for($i=$mulai; $i<=$sampai; $i++) {
			$selected = $row_value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		$echo .= '<input type="hidden" name="isdraft" id="isdraft">';
	}*/
		
		echo $return;
 ?>