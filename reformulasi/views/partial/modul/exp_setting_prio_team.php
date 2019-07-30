<?php 

	if($act == 'create'){

		$sql = "SELECT t.* 
                FROM reformulasi.reformulasi_team t
                JOIN reformulasi.reformulasi_master_departement rmd ON rmd.ireformulasi_master_departement=t.cDeptId
                WHERE rmd.vkode_departement = 'PD' 
                AND t.ldeleted = 0 
                AND t.iTipe=2
                AND rmd.lDeleted=0
                AND t.ireformulasi_team IN (".$hasTeamID.")";
    	$teams = $this->db->query($sql)->result_array();
    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose" >';
    	foreach($teams as $t) {
    		$echo .= '<option value="'.$t['ireformulasi_team'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';


	}else{
		$sql = "SELECT t.* 
                FROM reformulasi.reformulasi_team t
                JOIN reformulasi.reformulasi_master_departement rmd ON rmd.ireformulasi_master_departement=t.cDeptId
                WHERE rmd.vkode_departement = 'PD' 
                AND t.ldeleted = 0 
                AND t.iTipe=2
                AND rmd.lDeleted=0
                AND t.ireformulasi_team IN(".$hasTeamID.")";
    	$teams = $this->db->query($sql)->result_array();
    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $row_value == $t['ireformulasi_team'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['ireformulasi_team'].'">'.$t['vteam'].'</option>';
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