<?php
$gridurl=base_url()."processor/reformulasi/local_study_literatur_pd_popup?action=getdetailsMR&id=".$post['id'];
$arrSearch=array('vFilename'=>'File Name','vKeterangan'=>'Keterangan','iact'=>'Action');
$wsearch=array('vFilename'=>350,'vKeterangan'=>350,'iact'=>100);
$alsearch=array('vFilename'=>'left');
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
        pager:'#<?php echo $pager; ?>',
        shrinkToFit: true,
        rowNum: 10,
        height:'auto',
        rowList:['10','20','50','100','1000'],
        rownumbers:true,
        caption:"<?php echo $caption ?>",
        width:"100%",
        viewrecords: true,
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
    

   jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minWidth:300,maxWidth:1305,minHeight:80, maxHeight:370});
</script>