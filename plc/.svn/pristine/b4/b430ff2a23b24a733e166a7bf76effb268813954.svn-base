<?php 
	$url_color = base_url()."processor/plc/upb/injector?action=getInject"; 
	$url_requirement = base_url()."processor/plc/upb/injector?action=getrequirement"; 
	$url_detail = base_url()."processor/plc/upb/injector?action=getdetail"; 
	$url_cekkey = base_url()."processor/plc/upb/injector?action=getkey"; 
 ?>
<script type="text/javascript">
	$( document ).ready(function() {
	    var ini = $("#id_dis");
	    ini.val('Pilih Modul');
	    $(".btn_iupbid").hide();
	    $(".btn_iforid").hide();

	});
	
	function hidebtn(){
		$(".btn_iupbid").hide();
	    $(".btn_iforid").hide();
	}
	// get requirement on change modul
	$("#module_id").die();
	$("#module_id").live("change",function(){
		var module_id= $("#module_id").val();
		$("#detail_hint").html('');
		$("#rkotak").css('background-color','#ffffff');
		$.ajax({
		     url: "<?php echo $url_cekkey ?>", 
		     type: "POST", 
		     data: {
		     		module_id: module_id,
		     		}, 
		     success: function(response){
		     	var o =$.parseJSON(response);
		     	if(o.status==true){
		     		hidebtn();
		     		if(o.hasil=='iupb_id'){
			        	$(".btn_iupbid").show();
			        	$("#id_dis").val('');
			        	$("#id").val('');
			        	$("#lbl_cek").text('No UPB');
			        } else if(o.hasil=='ifor_id'){
			        	$(".btn_iforid").show();
			        	$("#id_dis").val('');
			        	$("#id").val('');
			        	$("#lbl_cek").text('No Formula');
			        }
		     	}else{
		     		$("#id_dis").val('Pilih Modul');
		     		$("#id").val('');
				    $(".btn_iupbid").hide();
				    $(".btn_iforid").hide();
				    $("#lbl_cek").text('Key');
				    return false;
		     	}
		     }

		});
		$.ajax({
		     url: "<?php echo $url_requirement ?>", 
		     type: "POST", 
		     data: {
		     		module_id: module_id,
		     		}, 
		     success: function(response){
		         $("#div_requirement").html(response);
		     }

		});

		

	});


	// function proses 


	$("#reset").die();
	$("#reset").live("click",function(){

		$("#id").val("");
		$("#id_dis").val("");
		$("#iTipe").val("");
		$("#rkotak").html("-");
		$("#ddModule").html("<select style='width: 300px' class='input' > </select>");
		
		
	})

	$("#submit").die();
	$("#submit").live("click",function(){
		var id= $("#id").val();
		var module_id= $("#module_id").val();
		var thasil=0;
		//alert(module_id);
		/*
		$.ajax({
		     url: "<?php echo $url_color ?>", 
		     type: "POST", 
		     data: {iupb_id: iupb_id,
		     		module_id: module_id,
		     		}, 
		     success: function(response){
		       //  $("#green").css('color','green');
		       alert(response);
		     }

		});
		*/
		if (module_id!="" &&  id !="") {
			$.ajax({
				url: "<?php echo $url_color ?>", 
				type: "post",
				data: {id: id,
		     		module_id: module_id,
		     		}, 
				//dataType: "json",
		        success: function( data ) {
		            
		            $("#rkotak").html(data);
		            
		        }

				
			})

		}else{
			_custom_alert("Modul dan UPB tidak boleh kosong","Info","Error", "Checkinput", 1, 20000);
		}



		

	});


</script>