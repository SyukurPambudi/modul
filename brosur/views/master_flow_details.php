<?php 
//Config Variable//
$grid="master_flow";
$nmmodule='brosur';
$actiondata='dataDetailsFlow';
$namegrid_tambahan='flow_details';
$caption = "-";

$isubmit=isset($isubmit)?$isubmit:0;
$arrSearch=array(
    'editi'         => '',
    'vNama_modul'   => 'Nama Modul',
    'iUrut'         => 'No Urut',
);

$wsearch=array('editi'=>25,'vNama_modul'=>300,'iUrut'=>75);

$alsearch=array('editi'=>'center','vNama_modul'=>'left');
foreach ($get as $kget => $vget) {
    if($kget!="action"){
        $in[]=$kget."=".$vget;
    }elseif($kget=="action"){
    }
}


$nmTable="tb_details_".$grid;
$pager="pager_tb_details_".$grid;

$g=implode("&", $in);
//$g=$g."&isubmit=".$isubmit;
$getUrl=str_replace('_','/',$grid);
$getUrl=$nmmodule.'/'.$getUrl;

/*Action Get URL */
$action ="?action=".$actiondata."&nmTable=".$nmTable."&grid=".$grid."&";
$getUrl=$getUrl.$action.$g;


?>
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
    var outerwidth = $grid.parent().width() - 20;
    $(document).ready(function(){
        $grid.jqGrid({
            url: base_url+"processor/<?php echo $getUrl ?>",
            postData: {id:'<?php echo $id ?>'},
            datatype: "json",
            mtype:'POST',
            colNames: [<?php echo implode(",", $cn)?>],
            colModel: [
               <?php echo implode(",", $cm); ?> 
            ],
            loadonce: true,
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
                $(".input_tgl").datepicker({dateFormat:"yy-mm-dd"});

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


                $(".autocomplate_flow_process" ).livequery(function() {
                    var idPost = $("#master_flow_iM_application").val();
                    $( this ).autocomplete({
                        source: function( request, response) {
                            $.ajax({
                                url: base_url+"processor/brosur/setup/modul?action=getProcess",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    id: idPost,
                                },
                                success: function( data ) {
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui){
                            var id_text = $(this).attr('id');
                            var id=id_text.replace('_text', '');
                            $( "#"+id ).val(ui.item.id);
                            $( "#"+id_text ).val(ui.item.value);
                            return false;
                        },
                        minLength: 2,
                        autoFocus: true,
                    });
                });

            }
    
        });

        jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minHeight:150, maxHeight:500}).navGrid('#<?php echo $pager; ?>',{edit:false,add:false,del:false,search:false,refresh:false})
        <?php if($get['action']!='view' and $isubmit==0){ ?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                    addrow_<?php echo $nmTable; ?>();
                   }, 
                   position:"last"
                })
        <?php 
        }
        ?>
    })
    

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
            if(n==""){
                var rlast=1;   
            }else{
                var s=JSON.parse("["+n+"]");
                var rlast = parseInt(Math.max.apply(Math, s)) +1;
            }
            var sa=
                [
                    [
                        "<input type='hidden' class='num_rows_<?php echo $nmTable ?>' value='"+rlast+"' /><a href='javascript:;' onclick='javascript:hapus_row_<?php echo $nmTable ?>("+rlast+")'><center><span class='ui-icon ui-icon-close'></span></center></a>",
                        "<input type='text' size='35' id='<?php echo $grid ?>_vkode_text_"+rlast+"' class='autocomplate_flow_process required' name='<?php echo $grid ?>_vkode_text[0][]'>\n\
                            <input type='hidden' size='10' class='required classiMmodul' id='<?php echo $grid ?>_vkode_"+rlast+"' name='<?php echo $grid ?>_vkode[0][]'>",
                        "<input type='text' size='5' id='<?php echo $grid ?>_iUrut_"+rlast+"' class='numbersOnly required' name='<?php echo $grid ?>_iUrut[0][]'>"
                    ]
                ];

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
                text: false
            });
            $( "button.icon_pop" ).button({
                icons: {
                    primary: "ui-icon-newwin"
                },
                text: false
            });
            $("#<?php echo $grid; ?>_dpermintaan_"+rlast).datepicker({dateFormat:"yy-mm-dd"});
    }

    function hapus_row_<?php echo $nmTable ?>(rowId){
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        if(lastr<=1){
             _custom_alert("Tidak Bisa, Minimal 1 Row","Info","info", "<?php echo $grid ?>", 1, 20000);
             return false;
        }else{
            custom_confirm('Anda Yakin ?',function(){
                $('#<?php echo $nmTable; ?>').jqGrid('delRowData',rowId);
            });
        }
    }
</script>