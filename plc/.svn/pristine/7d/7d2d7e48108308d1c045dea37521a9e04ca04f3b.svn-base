<?php 
	$grid       = str_replace("_".$field, "", $id);
    $query      = $rowData['vSource_input'];
    $field_id   = $rowData['iM_modul_fileds'];
    $modul      = $rowData['iM_modul'];
    $union      = '';
    $isoibb_id  = 0;
    $existing   = 0;
    $upb_id     = 0;
    $revisi     = 0;

    if (isset($dataHead)){
        $isoibb_id  = $dataHead['isoibb_id'];
        $existing   = $dataHead['iexisting'];
        $upb_id     = $dataHead['iupb_id'];
        $revisi     = $dataHead['irevisi'];
    }

    $field_id = $rowData['iM_modul_fileds'];
?> 

<script>
    var idfield = "#<?php echo $grid; ?>_ineed_revisi";
    var idexist = "#<?php echo $grid; ?>_iexisting";

    var upb_id = $("#<?php echo $id ?>").val();
    var upb_text = $("option:selected",$("#<?php echo $id ?>")).text();
    
    get_existing(upb_id, upb_text);
    get_file_draft(upb_id, upb_text);


    $("#<?php echo $id ?>").change(function(){
        var text = $("option:selected",$(this)).text();
        var value = $(this).val();

        get_existing(value, text);
        get_file_draft(value, text);

    })

    function get_existing (upb_id, upb_text){
        $.ajax({
            url: base_url+"processor/plc/v3/spesifikasi/soi/bb?action=getUPBfrom",
            type: "post",
            data : {
                upb: upb_id,
                id: "<?php echo $isoibb_id; ?>",
                field: "<?php echo $field_id; ?>",
                text: upb_text
            },
            success: function(data) {
                if (parseInt(data) == 1){
                    $(idfield).removeAttr("value");
                    // $(idfield).parent().parent().hide();
                    $("label[for='v3_spesifikasi_soi_bb_form_detail_ineed_revisi']").parent().hide();
                    $("label[for='v3_spesifikasi_soi_bb_form_detail_file_draft']").parent().hide();
                    $(idfield).removeClass("required error_text");
                }else{
                    // $(idfield).parent().parent().show();
                    $("label[for='v3_spesifikasi_soi_bb_form_detail_ineed_revisi']").parent().show();
                    $("label[for='v3_spesifikasi_soi_bb_form_detail_file_draft']").parent().show();
                    $(idfield).addClass("required");
                }
                $(idexist).val(data);
            }
        });
    }

    function get_file_draft(upb_id, upb_text){
        $.ajax({
            url: base_url+"processor/plc/v3/spesifikasi/soi/bb?action=getUploadedFileDraft",
            type: "post",
            data : {
                upb: upb_id,
                text: upb_text,
                revisi: "<?php echo $revisi; ?>",
                field: "<?php echo $field; ?>",
                field_id: "<?php echo $field_id; ?>",
                modul: "<?php echo $modul; ?>"
            },
            success: function(data) {
                $(".v3_table_soi_bb_file_draft").html(data);
            }
        });  
    }
</script>