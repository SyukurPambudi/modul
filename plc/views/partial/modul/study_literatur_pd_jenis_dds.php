<?php 
/*echo $row_value;
echo "<br>";
echo $hasTeamID;*/

    
	if($act == 'create'){

		$sql = "select a.imaster_delivery_system as valval,concat(a.vKey,' - ',a.vDeskripsi) as showshow
                from plc2.master_delivery_system a 
                where a.lDeleted=0";
    	$teams = $this->db->query($sql)->result_array();
    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose" >';
    	foreach($teams as $t) {
    		$echo .= '<option value="'.$t['valval'].'">'.$t['showshow'].'</option>';
    	}
    	$echo .= '</select>';


	}else{
        $sqlUPB = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$rowDataH['iupb_id'].'" ';
        $dUPB = $this->db->query($sqlUPB)->row_array();

		$sql = "select a.imaster_delivery_system as valval,concat(a.vKey,' - ',a.vDeskripsi) as showshow
                from plc2.master_delivery_system a 
                where a.lDeleted=0";
    	$teams = $this->db->query($sql)->result_array();

    	$echo = '<select name="'.$field.'" id="'.$id.'" class="choose">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $dUPB['imaster_delivery'] == $t['valval'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['valval'].'">'.$t['showshow'].'</option>';
    	}
    	$echo .= '</select>';
		


	}
		echo $echo;
		
		
			
		


 ?>