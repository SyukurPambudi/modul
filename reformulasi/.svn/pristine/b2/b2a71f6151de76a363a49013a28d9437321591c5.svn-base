<style type="text/css">
.master_data_kat {
	background-color: #ffffff;
	border: 1px solid #cccccc;
	padding: 10px;
}
</style>
<script type="text/javascript">
function cek_centang_dokumen(id){
	j=0;
	$.each($(".katdetail_"+id), function(i,v){
		if($(this).attr('checked')){
		}else{
			j++;
		}
	});
	if(j>=1){
		$("#all_master_kategori"+id).attr('checked',false);
	}else if(j==0){
		$("#all_master_kategori"+id).attr('checked',true);
	}
}
</script>

<table class="master_data_kat" id="master_kat" style="width: 80%; border: 1px solid #dddddd; text-align: left; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
	<thead>
	<tr style="width: 80%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;">
		<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
		Detail Proses</span></th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$iswjb = array('0'=>'Melewati atau Tidak','1'=>'Wajib',''=>'Melewati atau Tidak' );
			foreach ($sq_all as $v) {
				$cek='';
				$dis='';
				foreach ($sq_cek as $k) {
					if( $k['imaster_proses_refor']== $v['imaster_proses_refor'] ){
						$cek=' checked ';
					}
				}

				if($v['iwajib']==1){
					$cek = ' checked onclick="return false" ';
				}

				if($isubmit_maping==1){
					$dis = ' disabled ';
				}
				?>
					<tr>
						<td width="50%">&nbsp&nbsp&nbsp&nbsp&nbsp<b><?php echo $v['vNamaProses']?></b></td>
					 	<td width="10%"><input type="checkbox" <?php echo $cek.$dis ?> name="katdetail[<?php echo $v['imaster_proses_refor'] ?>]" class="katdetail" value=1  /></td>
					 	<td width="40%"><?php echo $iswjb[$v['iwajib']]?></td>
					</tr>

				<?php
			}
		?>
		
	</tbody>
</table>
 
