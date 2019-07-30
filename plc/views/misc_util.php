<?php 
//misc_util digunakan untuk menampung function2 yang muncul pada saat generate report
	$className	 = isset($className) ? $className : 'MiscUtil';
 	$img_url     = base_url().'assets/images/e-load.gif';
?>
<script type="text/javascript">

	function <?php echo $className; ?>_tryUPload(form , grid, formAction, url ){
   		var formData = new FormData($('form')[0]);
 		//formData = new FormData();    
 		formDatas = $('#form_update_'+grid).serialize();    

 		$('#' + form +' .multifile').each(function(){
 			myId = $(this).attr('id');
			uploadField = document.getElementById(myId);
			//files = uploadField.files; i = 0;
			files = $(this).prop('files') ;i = 0;
			//for (i = 0; i < files.length; i++) {
			for (i = 0; i < files['length']; i++) {
			  file = files[i];
			  // Add the file to the request.
			  formData.append('fileupload[]', file, file['name']);
			}
 		});
		
		<?php echo $className; ?>_doCallTClaimWaitDialog('Uploading File... Please Wait...');
   	
   	$.ajax({
   		url: formAction+formDatas,  
   		type: 'POST',
   		xhr: function() {  // Custom XMLHttpRequest
   	    var myXhr = $.ajaxSettings.xhr();
   	    if(myXhr.upload){ // Check if upload property exists
   	        myXhr.upload.addEventListener('progress',<?php echo $className; ?>_progressHandlingFunction, false); 
   	    }
   	    return myXhr;
   	  },
   		//Ajax events   						
   		success: function(data) {
   				<?php echo $className; ?>_doDestroyWaitDialog();		
   				var o = $.parseJSON(data);																
				_custom_alert(o.message,'info','info', grid, 1, 20000);
				$.get(url, function(data) {
						$('div#form_'+grid).html(data);
						$('#grid_'+grid).trigger('reloadGrid');
				});
   		},
   		// Form data
   		data: formData,
   		//Options to tell jQuery not to process data or worry about content-type.
   		cache: false,
   		contentType: false,
   		processData: false
   	});
	}

	function <?php echo $className; ?>_progressHandlingFunction(e){
		Victim = "<?php echo $className; ?>_";
	    if(e.lengthComputable){
	        $('#' + Victim + 'TCWaitDialog_progress').attr({value:e.loaded,max:e.total});
	    }
	}

	function <?php echo $className.'_'; ?>doCallTClaimWaitDialog(h3 =""){
		console.log('RaidenArmy');
		//Fungsi yang digunakan untuk menampilkan messagebox tunggu pada sat ajax berlangsung
		Victim = "<?php echo $className; ?>_";
		$("." + Victim + "TCWaitDialog").dialog({
			title: "Uploading File...",
			autoOpen: true, 
           	resizable: false,
           	height:350,
           	width:350,
			hide: {
				effect: "explode",
				duration: 500
			},
           	modal: true,
         open:function(){
         	h2 = (h3 == "") ? "Proccess Uploading ..." : h3; 
         	$("#" + Victim + "TCWaitDialog_h3").html(h2);
         },
			close : function(){
				$(this).dialog("destroy");
			}
    });	
	}

	function <?php echo $className.'_'; ?>doDestroyWaitDialog(){
		Victim = "<?php echo $className; ?>_";
		$("." + Victim + "TCWaitDialog").dialog('close');
	}

</script>
<?php
	$html_ ='
			<div class="'.$className.'_TCWaitDialog" style="display: none">
    		<div  style="margin: 0px 0px">
      	  	<img alt="" src="'.$img_url.'"  /><br/>
      	  	<span id="'.$className.'_TCWaitDialog_span"> </span>
        		<h3 id = "'.$className.'_TCWaitDialog_h3">J u s t  a m i n u t e ...</h3>
        		<progress id = "'.$className.'_TCWaitDialog_progress" ></progress>
    		</div>
		</div>';

		echo $html_;

?>