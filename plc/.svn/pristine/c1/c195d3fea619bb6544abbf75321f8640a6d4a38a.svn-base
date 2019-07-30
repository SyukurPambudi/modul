<script>
function setuju(grid, url, dis, upbid, upbno){
	custom_confirm('Anda Yakin Confirm UPB : '+upbno,function(){
		$.ajax({
			url: url,
			type: 'post',
			data: 'grid='+grid+'&iupb_id='+upbid,
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					var info = 'success';
					var header = 'success';
					_custom_alert(o.message,header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');
				}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
				$.get(base_url+'processor/plc/product/trial/stabilita/lab?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}
	
</script>
<iframe name="validasi_moa_frame" id="validasi_moa_frame" height="0" width="0"></iframe>