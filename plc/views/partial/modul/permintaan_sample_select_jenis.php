<?php 
	$grid = str_replace("_".$field, "", $id);
    $modul_id = $rowData['iM_modul'];
?> 

<script>
    var idjenis = "#<?php echo $grid; ?>_ijenis_sample";
    var idref = "<?php echo $grid; ?>_iRefUpb_id";

    if ($(idjenis).val()==3) {
        $("label[for='v3_permintaan_sample_form_detail_iRefUpb_id']").parent().show();
        $("#"+idref).addClass("required");
        $(".permintaan_sample_edit").hide();
    }else{
        $("#"+idref).removeAttr("value");
        $("label[for='v3_permintaan_sample_form_detail_iRefUpb_id']").parent().hide();
        $("#"+idref).removeClass("required error_text");
        $(".permintaan_sample_edit").show();
    }

    $("#<?php echo $id ?>").die();
    $("#<?php echo $id ?>").change(function(){
        var value = $(this).val();
        if (parseInt(value) == 3){
            $("label[for='v3_permintaan_sample_form_detail_iRefUpb_id']").parent().show();
            $("#"+idref).addClass("required");
            $(".permintaan_sample_edit").hide();
        }else{
            $("#"+idref).removeAttr("value");
            $("label[for='v3_permintaan_sample_form_detail_iRefUpb_id']").parent().hide();
            $("#"+idref).removeClass("required error_text");
            $(".permintaan_sample_edit").show();
        }
        $("#"+idref).val("");
        $.ajax({
            url: base_url+"processor/plc/v3_permintaan_sample?action=load_detail",
            type: "POST",
            async: false,
            data: { 
                iupb_id: 0,
                iModul_id: '<?php echo $modul_id; ?>'
            }, 
            success: function(data){
                $(".v3_table_permintaan_sample_detail").html(data);  
            }
         });
    })
</script>