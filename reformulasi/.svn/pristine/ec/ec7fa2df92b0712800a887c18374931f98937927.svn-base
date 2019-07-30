<?php 
//Config Variable//
$grid="export_best_formula";
$nmmodule='reformulasi';
$nmTable="tb_details_".$grid;
$pager="pager_tb_details_".$grid;
$caption = "";
$arrSearch=array('upload_file'=>'Nama File','vket'=>'Keterangan','action'=>'Action');
$wsearch=array('upload_file'=>300,'vket'=>300,'action'=>180);
$alsearch=array('action'=>'center');
foreach ($get as $kget => $vget) {
    if($kget!="action"){
        $in[]=$kget."=".$vget;
    }
}
$g=implode("&", $in);
$getUrl=str_replace('_','/',$grid);
$getUrl=$nmmodule.'/'.$getUrl;
?>
<input disabled="disabled" type="hidden" name="<?php echo $nmTable ?>_id" id="<?php echo $nmTable ?>_id" value="<?php echo $id ?>" class="input_rows1" size="20" />
<table id="list4"></table>

<table id="<?php echo $nmTable ?>"></table>
<div id="<?php echo $pager ?>"></div>
<iframe height="0" width="0" id="iframe_preview_<?php echo $grid; ?>"></iframe>
<div class="test_print_<?php echo $grid ?>"></div>
<script type="text/javascript">
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

    jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minWidth:300,maxWidth:1305,minHeight:80, maxHeight:370})
    .navGrid('#<?php echo $pager; ?>',{edit:false,add:false,del:false,search:false,refresh:false})
   <?php //if($get['action']!='view'){ ?>
            // .navButtonAdd('#<?php echo $pager; ?>',{
            //   caption:"Tambah", 
            //    buttonicon:"ui-icon-plus", 
            //   onClickButton: function(){ 
            //    addrow_<?php echo $nmTable; ?>();
            //   }, 
            //   position:"last"
            //})
    <?php 
    //}
    ?>

    function addrow_<?php echo $nmTable; ?>(){
            //get last num rows
            var n='';
            var i=0;
            $.each($(".num_rows_<?php echo $nmTable; ?>"),function(){
                if(i==0){
                    n+=$(this).val();
                }else{
                    n+=','+$(this).val();
                }
                i++;
            });
            var s=JSON.parse("["+n+"]");
            var rlast = parseInt(Math.max.apply(Math, s)) +1;
            var sa=[["<input type='hidden' class='num_rows_<?php echo $nmTable ?>' value='"+rlast+"' /><input type='file' id='<?php echo $grid; ?>_upload_file_"+rlast+"' class='fileupload1 multi multifile required' name='<?php echo $grid; ?>_upload_file[]' style='width: 90%' /> *","<textarea class='' id='<?php echo $grid; ?>_fileketerangan_"+rlast+"' name='<?php echo $grid; ?>_fileketerangan[]' style='width: 290px; height: 50px;' size='290'></textarea>", "<button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_<?php echo $nmTable ?>("+rlast+")' type='button'>Hapus</button><input type='hidden' name='iexport_best_formula_file[]' value='0' />"]];
            var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
            var names = [<?php $sas = implode(',', $nmf); echo $sas;?>];
            var mydata = [];
            for (var i = 0; i < sa.length; i++) {
                mydata[i] = {};
                for (var j = 0; j < sa[i].length; j++) {
                    mydata[i][names[j]] = sa[i][j];
                }
            }
            $("#<?php echo $nmTable; ?>").jqGrid('addRowData', rlast, mydata[0]);
            $( "button.icon_hapus" ).button({
                icons: {
                    primary: "ui-icon-close"
                },
                text: true
            });
    }

    function hapus_row_<?php echo $nmTable ?>(rowId){
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        if(lastr<=1){
             _custom_alert("Tidak Bisa, Minimal 1 Upload","Info","info", "tim_pengadaan_anggota_pip", 1, 20000);
             return false;
        }else{
            custom_confirm('Anda Yakin ?',function(){
                $('#<?php echo $nmTable; ?>').jqGrid('delRowData',rowId);
            });
        }
    }
    function reload_grid_<?php echo $nmTable ?>(){
        var id=$("#tb_details_export_best_formula_id").val();
        $("#<?php echo $nmTable ?>").jqGrid('setGridParam', { postData: { "id": id} }).trigger('reloadGrid');
    }
</script>