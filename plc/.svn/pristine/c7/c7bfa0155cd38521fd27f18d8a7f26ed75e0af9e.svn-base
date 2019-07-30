<?php 

	if($act == 'create'){
		$ret .= '<input type="hidden" name="isdraft" id="isdraft">';
		echo $ret;
	}else{
		if(($row_value <> 0) || (!empty($row_value))){
			$iupb_id=$main_table_pk_value;
			$ssql="select e.vName, uap.tupdate, (ifnull(uap.treason,'-')) as reason
					 from plc2.plc2_upb_approve uap 
						inner join hrd.employee e on e.cNip=uap.cnip
					where uap.iupb_id=$iupb_id and uap.vmodule in ('AppUPB-BD','2471') and uap.vtipe='BD' limit 1";
			$row = $this->db_plc0->query($ssql)->row_array();
			$jumrow = $this->db_plc0->query($ssql)->num_rows();
			if($jumrow>0){
				if($row_value==2){$st='<p style="color:green;font-size:120%;">Approved';}
				elseif($row_value==1){$st='<p style="color:red;font-size:120%;">Rejected';} 
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['tupdate'].'</br> Alasan: '.$row['reason'].'</p>';
			}
			else{
			if($row_value==2){$st='<p style="color:red;font-size:120%;">Approved';}
			elseif($row_value==1){$st='<p style="color:red;font-size:120%;">Rejected';} 
			$ret=$st.'&nbsp; (Detail Approval Belum Tersimpan!) </p>';}
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}

		$ret .= '<input type="hidden" name="isdraft" id="isdraft">';
		echo $ret;


	}
		
		
		
			
		


 ?>