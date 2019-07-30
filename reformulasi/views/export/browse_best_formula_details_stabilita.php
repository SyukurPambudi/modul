<?php 
//Config Variable//
$grid="export_details_stabilita_lab";
$gridurl='browse_export_best_formula';
$nmmodule='reformulasi';
$nmTable="tb_details_".$grid;
$pager="pager_tb_details_".$grid;
$caption = "";
$arrSearch=array('stb'=>'Stabilita','dTanggalStabilita_lab'=>'Tanggal','ihslStabilita_lab'=>'Status','iappd_StabilitaLab'=>'Approval');
$wsearch=array('stb'=>100,'dTanggalStabilita_lab'=>150,'ihslStabilita_lab'=>100,'iappd_StabilitaLab'=>400);
$alsearch=array('stb'=>'center','ihslStabilita_lab'=>'center','dTanggalStabilita_lab'=>'center');
foreach ($get as $kget => $vget) {
    if($kget!="action"){
        $in[]=$kget."=".$vget;
    }
}
$g=implode("&", $in);
$getUrl=str_replace('_','/',$gridurl);
$getUrl=$nmmodule.'/'.$getUrl;
$id=isset($id)?$id:0;
?>
<script type="text/javascript">
    var sa = "<div class='rows_group' style='overflow:auto;'><div id='details_stabilita' style='padding-left:20px;padding-top:5px;width:95%'><input disabled='disabled' type='hidden' name='<?php echo $nmTable ?>_id' id='<?php echo $nmTable ?>_id' value='<?php echo $id ?>' class='input_rows1' size='20' /><table id='<?php echo $nmTable ?>'></table><div id='<?php echo $pager ?>'></div></div></div>"; 
    $("#export_best_formula_cPicFormulator").parent().parent().append(sa);

    $grid=$("#<?php echo $nmTable ?>");
    <?php
    $nmf=array();
    foreach ($arrSearch as $kv => $vv) {
        $nmf[]="'".$kv."'";
        $cn[]="'".$vv."'";
        $wi=isset($wsearch[$kv])?",width: ".$wsearch[$kv]:"";
        $al=isset($alsearch[$kv])?",align: '".$alsearch[$kv]."'":"";
        $cm[]="{name:'".$kv."'".$wi.$al."}";
    }
    ?>
    var outerwidth = $("#<?php echo $nmTable ?>").parent().width() - 20;
    var id=$("#<?php echo $nmTable ?>_id").val();
    $("#<?php echo $nmTable ?>").jqGrid({
        url: base_url+"processor/<?php echo $getUrl ?>?action=get_data_prev",
        postData: {"id":id},
        datatype: "json",
        mtype:'POST',
        colNames: [<?php echo implode(",", $cn)?>],
        colModel: [
           <?php echo implode(",", $cm); ?> 
        ],
        //loadonce: true,
        rowNum: '1000',
        pager:'#<?php echo $pager; ?>',
        width:outerwidth,
        shrinkToFit:false,
        rownumbers:true,

        pgbuttons: false,
        pginput: false,
        pgtext: "",

        caption:"<?php echo $caption ?>",
        autowidth:false,
        cmTemplate: {
            title: false,
            sortable: false
        },
        gridComplete: function () {
            $('#lbl_rowcount').val($("#<?php echo $nmTable ?>").getGridParam('records'));
            $(".icon-play").button({
                icons:{
                    primary: "ui-icon-play"
                },
                text: true
            });
            $(".icon-extlink").button({
                icons:{
                    primary: "ui-icon-extlink"
                },
                text: true
            }); 
            $(".icon-disk").button({
                icons:{
                    primary: "ui-icon-disk"
                },
                text: true
            });
            $(".icon-pause").button({
                icons:{
                    primary: "ui-icon-pause"
                },
                text: true
            });
            $(".icon-stop").button({
                icons:{
                    primary: "ui-icon-stop"
                },
                text: true
            });

            $( "button.icon_hapus" ).button({
                icons: {
                    primary: "ui-icon-close"
                },
                text: true
            });

            jQuery.fn.ForceNumericOnly =
            function()
            {
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
                        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                        // home, end, period, and numpad decimal
                        return (
                            key == 8 || 
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 110 ||
                            key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };
            $(".numbersOnly").ForceNumericOnly();
        }
    
    });

    jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minWidth:300,maxWidth:800,minHeight:80, maxHeight:500})
    .navGrid('#<?php echo $pager; ?>',{edit:false,add:false,del:false,search:false,refresh:false});
    function reload_grid_<?php echo $nmTable ?>(){
        var id=$("#tb_details_export_details_stabilita_lab_id").val();
        $("#<?php echo $nmTable ?>").jqGrid('setGridParam', { postData: { "id": id} }).trigger('reloadGrid');
    }
</script>