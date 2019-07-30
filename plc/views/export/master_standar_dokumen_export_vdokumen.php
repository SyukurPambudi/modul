<style type="text/css">
.m_s_vdokumen {
	background-color: #ffffff;
	border: 1px solid #cccccc;
	padding: 5px;
}
</style>
<script type="text/javascript">
function cek_centang_dokumen(id){
	j=0;
	$.each($(".master_standar_vdok_"+id), function(i,v){
		if($(this).attr('checked')){
		}else{
			j++;
		}
	});
	if(j>=1){
		$("#all_master_standar_vdok_"+id).attr('checked',false);
	}else if(j==0){
		$("#all_master_standar_vdok_"+id).attr('checked',true);
	}
}
</script>
<?php 
foreach ($vkat as $kkat => $valkat) {
	foreach ($vdok as $kdok => $valdok) {
		if($valdok['idossier_kat_dok_details_id']==$valkat['idossier_kat_dok_details_id']){
			$data[$valdok['idossier_kat_dok_details_id']][$valdok['idossier_dokumen_id']]=$valdok['vNama_Dokumen'];
		}
	}
	$sql="select * from dossier.dossier_kat_dok kat where kat.idossier_kat_dok_id=".$valkat['idossier_kat_dok_id'];
	$d=$this->db_plc0->query($sql)->row_array();
	$datakat[$valkat['idossier_kat_dok_details_id']]=$d['vNama_Kategori'].' - '.$valkat['vsubmodul_kategori'];
}
foreach ($data as $idossier_kat_dok_details_id => $valu) {
?>
<table class="hover_table" id="master_standar_kat_<?php echo $idossier_kat_dok_details_id ?>" style="width: 98%; border: 1px solid #dddddd; text-align: left; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;"><?php echo $datakat[$idossier_kat_dok_details_id] ?> <input type="checkbox" id="all_master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>" value=1 /></span></th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<div class="m_s_vdokumen">
				<table width="100%" style="padding:5px" id="master_standar_dokumen_<?php echo $idossier_kat_dok_details_id ?>">
					<?php
						$vount = count($valu);
						$i=0;
						foreach ($valu as $idossier_dokumen_id => $vnamedok) {
							$cek='';
							if(isset($vdetdok)){
								foreach ($vdetdok as $kdet => $vdet) {
									if($vdet== $idossier_dokumen_id){
										$cek='checked';
									}
								}
							}
							//if($i==0){
								echo '<tr><td width="50%"><input type="checkbox" name="master_standar_vdok['.$idossier_dokumen_id.']" class="master_standar_vdok_'.$idossier_kat_dok_details_id.'" value=1 '.$cek.' />'.$vnamedok.'</td>';
							//	$i++;
							//}else{
							//	echo '<td width="50%"><input type="checkbox" name="master_standar_vdok['.$idossier_dokumen_id.']" class="master_standar_vdok_'.$idossier_kat_dok_details_id.'" value=1 '.$cek.' />'.$vnamedok.'</td></tr>';
							//	$i=0;
							//}
						}
					?>
				</table>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<script>
	cek_centang_dokumen(<?php echo $idossier_kat_dok_details_id ?>);
	$("#all_master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>").change(function(){
		va=false;
		if($("#all_master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>").attr('checked')){
			va=true;
		}
		//ta=$("#all_master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>").parent().parent().parent().parent().next();
		$("#master_standar_dokumen_<?php echo $idossier_kat_dok_details_id ?>").find('input:checkbox.master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>').attr('checked',va);
	});
	$(".master_standar_vdok_<?php echo $idossier_kat_dok_details_id ?>").change(function(){
		cek_centang_dokumen(<?php echo $idossier_kat_dok_details_id ?>);
	});
	
</script>
<?php
}
?>