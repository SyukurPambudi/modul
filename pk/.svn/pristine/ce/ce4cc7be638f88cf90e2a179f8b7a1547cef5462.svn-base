<?php 
$sql_j="select * from pk.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
$qt=$this->db->query($sql_j)->row_array();
$cse = $qt['iCse'];
$is_confirm_karyawan=$qt['is_confirm_karyawan'];
$iSubmit=$qt['iSubmit'];
$teamid = $qt['iteam_id'];
if($qt['vnip']==$vnip){
	$it='<input type="hidden" name="it" id="it" value="0" />';
	$type=0;
}else{
	$it='<input type="hidden" name="it" id="it" value="1" />';
	$type=1;
}
?>	
    <label class="lbl_detail">CSE :</label>
    <input type="text" size = "3"  value="<?php echo $cse; ?>" id="cse" class="tabs5" name="cse" /> </td>    
<?php    
?>	
 <br />	
 <br />	
 <div><?php

	 if ($this->input->get('action') == 'view') {
	 }else{
		 //$ca='<button type="button" id="submit_draft_tab1" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>';
		 $ca='<button type="button" id="submit_tab5" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>';
		 if($type==0){
			 if($is_confirm_karyawan==0){
				 echo $ca;
			 }
		 }else{
			 if($iSubmit<5){
				 if($is_confirm_karyawan<=3 ){
					 echo $ca;
				 }
			 }
		 }
	 }

	?>
</div>


<script type="text/javascript">
	$( "tr.trdetil:not(:first)" ).find('th.thdetil').text("");

	$('#submit_tab5').die();
	$('#submit_tab5').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		var it = $("#it").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_softdev_mgr?action=cse',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs5').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=2'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id+'&it='+it,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par_tab5");
					var conf=0;
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							conf++;
						}		
					});
					if(conf > 0) {
						alert("Semua Parameter Harus Diisi");
						xhr.abort();
					}

			},
			success: function(data) {
				var o = $.parseJSON(data);												
				var info = 'Info';
				var header = 'Info';
				var last_id =idmaster_id;
					if(o.status == true) {
						_custom_alert("Data Tersimpan","Info","Info","", 1, 20000);
						$('#grid_pk_softdev_mgr').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/softdev/mgr?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_softdev_mgr').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_softdev_mgr').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});


</script>