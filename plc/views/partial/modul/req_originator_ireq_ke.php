<?php 

	$url_header = base_url()."processor/plc/v3/request/originator/?action=getrekKe"; 
	$url_detail = base_url()."processor/plc/v3/request/originator/?action=getDetail";

	$url_cekCurrentPost = base_url()."processor/plc/v3/request/originator/?action=cekCurrentPost";  


	if($act == 'create'){
		$ret = '<input type="text" readonly="readonly" size="3" class="'.$field_required.'" name="'.$nmfield.'" id="'.$nmfield.'">';

		$ret .= '<div id="detail_req">';

		$ret .= '</div>';


		echo $ret;

?>
	<script type="text/javascript">

		$("#v3_request_originator_iupb_id").die();
		$("#v3_request_originator_iupb_id").live('change',function(){
			$.ajax({
				url: "<?php echo $url_cekCurrentPost ?>",
				type: "post",
				data: {
					iupb_id: $(this).val()
					},
				dataType: "json",
		        success: function( data ) {
		            $.each(data, function(index, element) {
		        		var sample = element.sample;
						var satu = "1";
		        		var dua = "2";
		        		if(sample == 1){
		        			
							$("#v3_request_originator_iTujuan_req option[value="+satu+"]").show();
							$("#v3_request_originator_iTujuan_req option[value="+dua+"]").hide();
		        			
		        		}else{

		        			$("#v3_request_originator_iTujuan_req option[value="+satu+"]").hide();
							$("#v3_request_originator_iTujuan_req option[value="+dua+"]").show();
		        		}
		        		
		            	

		            	
           			})
				}
			});


			
		})

		$("#v3_request_originator_iTujuan_req").die();
		$("#v3_request_originator_iTujuan_req").live('change',function(){
			var iupb_id = $("#v3_request_originator_iupb_id").val();
			$.ajax({
				url: "<?php echo $url_header ?>",
				type: "post",
				data: {
					iupb_id:  iupb_id ,
					iTujuan_req: $(this).val()
					},
				dataType: "json",
		        success: function( data ) {
		            $.each(data, function(index, element) {
		        
		            	$("#ireq_ke").val(element.jumlah);

		            	if(element.jumlah_before > 0){
		            		$("#v3_request_originator_vKeterangan").addClass('required');
		            	}else{
		            		$("#v3_request_originator_vKeterangan").removeClass('required');
		            	}	

           			})
				}
			});


			$.ajax({
				url: "<?php echo $url_detail ?>",
				type:"post",
				data:"iupb_id="+iupb_id+"&iTujuan_req="+$(this).val(),
				success: function(data) {
					$("#detail_req").html(data);
				}
			})

		})

	</script>


<?php 
	}else{
		
		$ret = '<input type="text" readonly="readonly" size="3" class="'.$field_required.'" value="'.$row_value.'" name="'.$nmfield.'" id="'.$nmfield.'">';
		echo $ret;
?>


<?php 

	}

?>