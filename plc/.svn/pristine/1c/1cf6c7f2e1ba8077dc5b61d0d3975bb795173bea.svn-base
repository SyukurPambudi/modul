<script type="text/javascript">
	$("label[for='copy_brand_form_detail_detail_copy']").remove();
	$("#copy_brand_proses_views").parent().css('margin-left','0');
	
	var bar = $('.bar');
	var percent = $('.percent');
	var status = $('#status');
		
	$("#copy_brand_iupb_id").die();
	$("#copy_brand_iupb_id").live('change',function(){
			$('#list_modules').html('');
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);

			$("#button_save_draft_copy_brand").show();
	});


    $("#button_save_draft_copy_brand").show();

</script>

<style type="text/css">
	.progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
	.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	.percent { position:absolute; display:inline-block; top:3px; left:48%; }

</style>
<div id="copy_brand_proses_views">
			
	    <div class="progress">
	        <div class="bar"></div >
	        <div class="percent">0%</div >
	    </div>

	    <!-- <div style="width:75%;">
	    	
	    	<div id="kotak_modul" style="width: 40%;">
			  <span id="h2">List Modul Yang akan dicopy</span>
			  <ul id="list_modules">
			    
			  </ul>
			</div> -->
			<!-- <div id="kotak_loading" style="width: 80%;">
				
			</div> -->

	    </div>
		<!-- <ul id="list_modules" style="list-style: decimal inside;">
			
		</ul> -->
</div>

<style type="text/css">
	#h2 {
	  font: 200 15px/1.5 Helvetica, Verdana, sans-serif;
	  margin: 0;
	  padding: 0;
	}
	 
	ul#list_modules {
	  list-style-type: none;
	  /*list-style: decimal inside;*/
	  margin: 0;
	  padding: 0;
	}
	 
	ul#list_modules li {
	  font: 200 20px/1.5 Helvetica, Verdana, sans-serif;
	  border-bottom: 1px solid #ccc;
	}
	 
	ul#list_modules li:last-child {
	  border: none;
	}
	 
	ul#list_modules li a {
	  text-decoration: none;
	  color: #000;
	  display: block;
	  width: 200px;
	 
	  -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
	  -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
	  -o-transition: font-size 0.3s ease, background-color 0.3s ease;
	  -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
	  transition: font-size 0.3s ease, background-color 0.3s ease;
	}
	 
	ul#list_modules li a:hover {
	  font-size: 30px;
	  background: #f6f6f6;
	}
</style>