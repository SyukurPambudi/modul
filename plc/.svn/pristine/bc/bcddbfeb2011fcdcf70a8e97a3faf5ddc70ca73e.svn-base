<style type="text/css" media="screen">
	.f {
    background-color: #eaf1f7;
    border: 1px solid #89b9e0;
    margin-bottom: 5px;
    width: 100%;
}
</style>
<div class="f">
	<div class="top_form_head">									
		<span class="form_head top-head-content">
		<?php echo $caption ?></span>
	</div> 
	<div class="clear"></div>
	<div class="content-table" style="overflow:auto;">
		<?php foreach ($rfilter as $kf => $vf) {?>
			<div class="form_horizontal_plc">
				<div class="rows_group"><label class="rows_label" for="search_grid_transaksi_kartu_call_busdev_itarget_kunjungan_id"><?php echo $vf ?></label>
					<div class="rows_input select_rows">
						<?php echo $rinput[$kf]; ?>
					</div>
				</div>
			</div>
		<?php	
		} ?>
		<div class="clear"></div>
		<div class="control-group-btn">
			<div class="left-control-group-btn">
				<?php echo $button; ?>								
			</div>
		</div>		

	</div>
</div>
<div class="preview_<?php echo $grid?>">
</div>
<script>
	function priview_report_export_progress_dokumen(grid,url){
		var dfrom=$("#search_grid_report_export_progress_dokumen_idossier_upd_id").val();
		var i=0;
		var msg="";
		if(dfrom==""){
			msg+="Pilih Nomor UPD!";
			i++;
		}
		if(i>=1){
			_custom_alert(msg,'Error!','info','rpt_kartu_call_busdev', 1, 5000);
		}else{
			$.ajax({
				url: url,
				type: 'post',
				data: 'grid='+grid+'&'+$(".search_box_<?php echo $grid?>").serialize(),
				success: function(data) {
					$(".preview_<?php echo $grid?>").html(data);
				}		
			});
		}
	}
</script>