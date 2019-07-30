<?php
$grid="export_uji_mikro_fg";
$nmTable="tb_details_".$grid;
$pager="pager_tb_details_".$grid;
$caption = "";
$arrSearch=array('upload_file'=>'Nama File','vket'=>'Keterangan','action'=>'Action');
$wsearch=array('upload_file'=>300,'vket'=>400,'action'=>80);
$alsearch=array('action'=>'center');
foreach ($get as $kget => $vget) {
    if($kget!="action"){
        $in[]=$kget."=".$vget;
    }
}
$g=implode("&", $in);

?>
<table id="<?php echo $nmTable ?>" width="98%"></table>
<div id="<?php echo $pager ?>"></div>
<script type="text/javascript">
/*Modify Grid */

    $grid=$("#<?php echo $nmTable ?>");
    <?php
    foreach ($arrSearch as $kv => $vv) {
    	$nmf[]="'".$kv."'";
        $cn[]="'".$vv."'";
        $wi=isset($wsearch[$kv])?",width: ".$wsearch[$kv]:"";
        $al=isset($alsearch[$kv])?",align: '".$alsearch[$kv]."'":"";
        $cm[]="{name:'".$kv."'".$wi.$al."}";
    }
    ?>
    var outerwidth = $grid.width();    
    $grid.jqGrid({
        url: '<?php echo $gridurl; ?>',
        datatype: "json",
        mtype:'GET',
        colNames: [<?php echo implode(",", $cn)?>],
        colModel: [
             <?php echo implode(",", $cm); ?>              
        ],
        autowidth:false, 
        shrinkToFit:false,
        rownumbers:true,
        viewrecords: false,
        rowNum: 100,
        pgbuttons: false,
        pginput: false,
        pgtext: "",
        height: 'auto',
        pager:'#<?php echo $pager; ?>',
        caption: '<?php echo $caption ?>',
        loadComplete: function () {
            $( "button.icon_hapus" ).button({
                icons: {
                    primary: "ui-icon-close"
                },
                text: true
            }).tooltip({
                  disabled: false,
                  content: "Hapus File"
            });
            $( ".icon_cetak" ).button({
                icons: {
                    primary: "ui-icon-print"
                },
                text: true
            }).tooltip({
                  disabled: false,
                  content: "Download File"
            });
        }
        
    });
   jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minWidth:300,maxWidth:1305,minHeight:80, maxHeight:370}).navGrid('#<?php echo $pager; ?>',{edit:false,add:false,del:false,search:false,refresh:false})
   <?php if($rowData['iapppd']==0 || $get['action']!='view'){ ?>
            .navButtonAdd('#<?php echo $pager; ?>',{
               caption:"Tambah", 
               buttonicon:"ui-icon-plus", 
               onClickButton: function(){ 
                 addrow_detail_files_stablab_edit();
               }, 
               position:"last"
            })
    <?php 
    }
    ?>

    function addrow_detail_files_stablab_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_stablab_edit"),function(){
            /*if(i==0){
                n[i]=$(this).val();
            }else{
                n[i]=','+$(this).val();
            }*/
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
        	var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
        	var rlast =1;
        }
        
        var sa=[["<input type='file' id='fileupload_local_stablab_"+rlast+"' class='fileupload multi multifile' name='fileupload_local_stablab[]' style='width: 90%' />","<textarea id='file_keterangan_local_stablab_"+rlast+"' name='file_keterangan_local_stablab[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_stablab_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_stablab_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename", "vKeterangan", "iact"];
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
        }).tooltip({
                  disabled: false,
                  content: "Hapus File"
            });
        $(".inputan_tanggal").datepicker({dateFormat:"yy-mm-dd"});
    }
    function hapus_row_details_file_stablab_edit(rowId){
        custom_confirm('Anda Yakin ?',function(){
            $('#<?php echo $nmTable; ?>').jqGrid('delRowData',rowId);
        });
    }
</script>