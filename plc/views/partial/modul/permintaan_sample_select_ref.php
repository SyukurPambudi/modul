<?php 
	$grid = str_replace("_".$field, "", $id);
    $modul_id = $rowData['iM_modul'];
?> 

<script>

    $("#<?php echo $id ?>").change(function(){
        $.ajax({
            url: base_url+"processor/plc/v3_permintaan_sample?action=load_detail",
            type: "POST",
            async: false,
            data: {
                    iupb_id: $(this).val(),  
                    iModul_id: "<?php echo $modul_id; ?>"
                }, 
            success: function(data){
                $(".v3_table_permintaan_sample_detail").html(data);  
                $(".permintaan_sample_detail_add_row").hide();
                $(".btn_browse_bb").hide();
            }
         });
    })
</script>