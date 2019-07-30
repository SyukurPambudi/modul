<script>
    $("#<?php echo $id ?>").change(function(){
        var valu =  $("#<?php echo $id ?>").val();
        jQuery("#tb_details_plc2_v3_prareg_hpr_fileDokPrareg_fileDokPrareg").jqGrid('setGridParam', { 
            postData: { id: valu }
            }).trigger('reloadGrid');
            $.ajax({
				url: base_url + 'processor/plc/v3/prareg/hpr?action=getUPB',
				type: 'post',
				data: {id:valu},
				success: function(data) {
                    var o = $.parseJSON(data);
                    if(o.ibe==1){
                        $("#v3_prareg_hpr_dPraregTglPPUB").parent().parent().show();
                        $("#v3_prareg_hpr_dPraregTglPPUB").removeClass("required").addClass("required");
                    }else{
                        $("#v3_prareg_hpr_dPraregTglPPUB").parent().parent().hide();
                        $("#v3_prareg_hpr_dPraregTglPPUB").removeClass("required");
                    }
                }
            });
    });
</script>