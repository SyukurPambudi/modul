<?php 
	$grid=str_replace("_".$field, "", $id);
    $iexport_uji_be=isset($dataHead["iexport_uji_be"])?$dataHead["iexport_uji_be"]:"0";
	$istatus_ujibe=isset($dataHead["istatus_ujibe"])?$dataHead["istatus_ujibe"]:"0";
	$iSubmit=isset($dataHead["iSubmit"])?$dataHead["iSubmit"]:"0";
    $arrayi=array(1=>"TMS",2=>"MS");
    $value="0";
    if(isset($dataHead[$field])){
        $value=isset($arrayi[$dataHead[$field]])?$arrayi[$dataHead[$field]]:"0";
    }
	$get=$this->input->get();
	
?>
<script>
    var ire = <?php echo $istatus_ujibe ?>;
    <?php   
       if($iexport_uji_be!="0"){?>
        var nilai = $("#<?php echo $id ?>").val();
        if(nilai == 1){
            $("#<?php echo $id ?>").parent().parent().next().show();
        }else{
            $("#<?php echo $id ?>").parent().parent().next().hide();
        
        }
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().next().hide();
    <?php } ?>

        $("#<?php echo $id ?>").change(function(){
            var v = $(this).val();
            if(v=="1"){
                $(this).parent().parent().next().show();
            }else{
                $(this).parent().parent().next().hide();
            }
        });  
        
       
</script>

        
<?php
	if ($iSubmit == 1 ){ ?>
		<script>
			$("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
		</script>
		<?php 
	} 
?>