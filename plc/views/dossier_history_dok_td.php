<?php $path='dossier_history_dok_td'; ?>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="dossier_request_sample_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">HISTORY TD</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 10%;" >No</th>
		<th style="border: 1px solid #dddddd; width: 20%;">No Request</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Nomor Dossier</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Nama SRE</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Pengusul</th>
		<th style="border: 1px solid #dddddd; width: 10%;">Action</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$i = 1;
			foreach($rows as $row) {

		?>
			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="dossier_request_sample_upload_num"><?php echo $i ?></span>
					</td>	
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<?php echo $row['vNo_req_td'] ?>
					</td>
					<td style="border: 1px solid #dddddd; text-align: left; ">
						<?php echo $row['vUpd_no'] ?>
					</td>
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<?php 
							$tim = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iTeam_sre']))->row_array();
							echo $tim['vteam']; 
						?>
					</td>
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<?php 
							$tim = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$row['pengusul']))->row_array();
							echo $tim['vName']; 
						?>
					</td>
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<span class="<?php echo $path ?>_span"><a href="javascript:;" class="<?php echo $path.$row['idossier_dok_td_id'] ?>_details" onclick="details_history_td(this, '<?php echo $path.$row['idossier_dok_td_id'] ?>_details', <?php echo $row['idossier_dok_td_id'] ?>)">[Details]</a></span>
					</td>
			</tr>
		<?php		
			$i++;	
			}

		 ?>
				
		
	</tbody>
</table>
<script type="text/javascript">
function details_history_td(dis, path, id){
	var attr='';
	attr +='<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
	attr +='<td style="border: 1px solid #dddddd;  text-align: center;" colspan="6" id="'+path+'_details_td"></td>';		
	attr +='</tr>';
	$('.'+path).parent().parent().parent().after(attr);
	url=base_url+"processor/plc/partial/view/export?action=gethistoy_detailtd";
	$("."+path).text("[Hide]");
	$.ajax({
	     url: url, 
	     type: "POST", 
	     data: {idossier_dok_td_id:id}, 
	     success: function(response){
	         $("#"+path+"_details_td").html(response);
	     }

	});
	$("."+path).attr("onclick", "hide_details_history_td(this, '"+path+"', "+id+")");
}
function hide_details_history_td(dis, path, id){
	var attr='';
	$('.'+path).parent().parent().parent().next().remove();
	$("."+path).text("[Details]");
	$("."+path).attr("onclick", "details_history_td(this, '"+path+"', "+id+")");
}

</script>

