<script type="text/javascript">
function cetak(grid, url, dis, jns, vnip){
	$.ajax({
		url: url,
		type: 'post',
		data: 'jns='+jns+'&vnip='+vnip,
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
			$.get(base_url+'processor/plc/pk/pk/busdev?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                    $('div#form_'+grid).html(data);
                    //$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
            });
		}		
	});
}
</script>