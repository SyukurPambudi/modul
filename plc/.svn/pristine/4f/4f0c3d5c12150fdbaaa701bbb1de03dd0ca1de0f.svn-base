<?php 
/*echo $row_value;
echo "<br>";
echo $hasTeamID;*/


	if($act == 'create'){

		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'BD' AND t.ldeleted = '0' AND t.iteam_id IN (".$hasTeamID.")";
    	$teams = $this->db->query($sql)->result_array();
    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose" >';
    	foreach($teams as $t) {
    		$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';


	}else{
		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'BD' AND t.ldeleted = '0' AND t.iteam_id IN (".$hasTeamID.")";
    	$teams = $this->db->query($sql)->result_array();
    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $row_value == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
		


	}
		$echo .= '
					<style>
						#'.$id.'{
							min-width: 150px;
						}
					</style>
			';

		echo $echo;
		
		
			
		


 ?>