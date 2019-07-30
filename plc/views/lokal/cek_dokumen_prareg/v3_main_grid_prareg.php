<?php
$nmTable="table_grid_".$id;
$pager="pager_".$nmTable;
$gridurl=base_url()."processor/".$this->urlpath."?action=getuploadfile&id=".$get['id']."&field=".$id."&act=".$get['act'];
if($ibk==0){
    if($get['act']!="view"){
        $arrSearch=array('vFilename'=>'File Name','iconfirm'=>'Confirm','istatus'=>'Status','tKetRevQA'=>'Keterangan Revisi QA','vKeterangan'=>'Keterangan','iact'=>'Action');
    }else{
         $arrSearch=array('vFilename'=>'File Name','iconfirm'=>'Confirm','istatus'=>'Status','tKetRevQA'=>'Keterangan Revisi QA','vKeterangan'=>'Keterangan');
    }
    $wsearch=array('iconfirm'=>180,'istatus'=>80,'vFilename'=>280,'vKeterangan'=>280,'tKetRevQA'=>280,'iact'=>100);
    $alsearch=array('iact'=>'center','iconfirm'=>'center','istatus'=>'center');
}else{
    if($get['act']!="view"){
        $arrSearch=array('vFilename'=>'File Name','iconfirm'=>'Confirm','istatus'=>'Status','tKetRevQA'=>'Keterangan Revisi QA','ijenis_bk_id'=>'Jenis Bahan Kemas','vKeterangan'=>'Keterangan','iact'=>'Action');
    }else{
         $arrSearch=array('vFilename'=>'File Name','iconfirm'=>'Confirm','istatus'=>'Status','tKetRevQA'=>'Keterangan Revisi QA','ijenis_bk_id'=>'Jenis Bahan Kemas','vKeterangan'=>'Keterangan');
    }
    $wsearch=array('iconfirm'=>180,'istatus'=>80,'vFilename'=>280,'ijenis_bk_id'=>200,'vKeterangan'=>280,'tKetRevQA'=>280,'iact'=>100);
    $alsearch=array('iact'=>'center','iconfirm'=>'center','istatus'=>'center');
}
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
   <?php 
    if($ddd!=0){
        if($isPackdev==1 && $type=='PAC' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                    <?php if($ibk==0){ ?>
                        addrow_pd_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_pd_bk_detail_files_non_<?php echo $id ?>_edit();
                     <?php } ?>
                   },
                   position:"last"
                })
        <?php 
            }
        }
        if($isPD==1 && $type=='PD' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                    <?php if($ibk==0){ ?>
                        addrow_pd_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_pd_bk_detail_files_non_<?php echo $id ?>_edit();
                     <?php } ?>
                   }, 
                   position:"last"
                })
        <?php 
            }
        }
        if($type=='QA' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                     <?php if($ibk==0){ ?>
                        addrow_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_bk_detail_files_<?php echo $id ?>_edit();
                     <?php } ?>
                   }, 
                   position:"last"
                })
        <?php 
            }
        }
        if($type=='BD' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                        <?php if($ibk==0){ ?>
                            addrow_detail_bd_files_<?php echo $id ?>_edit();
                        <?php }else{?>
                            addrow_detail_bd_bk_files_<?php echo $id ?>_edit();
                        <?php } ?>
                     
                   }, 
                   position:"last"
                })
        <?php 
            }
        if($cekdone==0){ ?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Done", 
                   buttonicon:"ui-icon-check", 
                   onClickButton: function(){ 
                        done_process_<?php echo $id ?>_edit();
                   }, 
                   position:"last"
                })<?php
          }
        }
    }elseif($rowData['iNew_formula']==1){
        if($isPackdev==1 && $type=='PAC' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                    <?php if($ibk==0){ ?>
                        addrow_pd_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_pd_bk_detail_files_non_<?php echo $id ?>_edit();
                     <?php } ?>
                   },
                   position:"last"
                })
        <?php 
            }
        }
        if($isPD==1 && $type=='PD' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2 && $rowData['iconfirm_dok_pd']==0){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                    <?php if($ibk==0){ ?>
                        addrow_pd_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_pd_bk_detail_files_non_<?php echo $id ?>_edit();
                     <?php } ?>
                   }, 
                   position:"last"
                })
        <?php 
            }
        }
        if($type=='QA' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2  && $rowData['iconfirm_dok_qa']==0){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                     <?php if($ibk==0){ ?>
                        addrow_detail_files_<?php echo $id ?>_edit();
                    <?php }else{?>
                        addrow_bk_detail_files_<?php echo $id ?>_edit();
                     <?php } ?>
                   }, 
                   position:"last"
                })
        <?php 
            }
        }
        if($type=='BD' && $get['act']!='view'){ 
            if($rowData['isubmit_bd']!=2){?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Tambah", 
                   buttonicon:"ui-icon-plus", 
                   onClickButton: function(){ 
                        <?php if($ibk==0){ ?>
                            addrow_detail_bd_files_<?php echo $id ?>_edit();
                        <?php }else{?>
                            addrow_detail_bd_bk_files_<?php echo $id ?>_edit();
                        <?php } ?>
                     
                   }, 
                   position:"last"
                })
        <?php 
            }
        if($cekdone==0){ ?>
                .navButtonAdd('#<?php echo $pager; ?>',{
                   caption:"Done", 
                   buttonicon:"ui-icon-check", 
                   onClickButton: function(){ 
                        done_process_<?php echo $id ?>_edit();
                   }, 
                   position:"last"
                })<?php
          }
        }
    }
    ?>

    function addrow_detail_bd_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        $arr2=array(0=>"Draft",1=>"Finish");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $sel=$karr2==1?"selected":"";
            $opt2.="<option value='".$karr2."' ".$sel.">".$varr2."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[0][]' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[]' disabled='disabled'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' disabled='disabled' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;'></textarea>","<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA","vKeterangan", "iact"];
        mydata=[];
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
    function addrow_detail_bd_bk_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        $arr2=array(0=>"Draft",1=>"Finish");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $sel=$karr2==1?"selected":"";
            $opt2.="<option value='".$karr2."' ".$sel.">".$varr2."</option>";
        }
        $opt3="";
        foreach ($arr3 as $karr3 => $varr3) {
            $opt3.="<option value='".$varr3['ijenis_bk_id']."'>".$varr3['itipe_bk']." > ".$varr3['vjenis_bk']."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[0][]' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[]' disabled='disabled'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var opt3="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id[0][]'>";
        opt3+="<?php echo $opt3; ?>";
        opt3+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' disabled='disabled' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;'></textarea>",opt3,"<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA","ijenis_bk_id","vKeterangan", "iact"];
        mydata=[];
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

    function addrow_detail_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        /*$arr2=array(0=>"Draft",1=>"Finish");*/
        $arr2=array(1=>"Finish");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $opt2.="<option value='".$karr2."'>".$varr2."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[]' disabled='disabled' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[0][]'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;'></textarea>","<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA", "vKeterangan", "iact"];
        mydata=[];
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
    function addrow_pd_detail_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        /*$arr2=array(0=>"Draft",1=>"Finish");*/
        $arr2=array(0=>"Draft");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $opt2.="<option value='".$karr2."'>".$varr2."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[]' disabled='disabled' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[0][]'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;' disabled='disabled'></textarea>","<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA", "vKeterangan", "iact"];
        mydata=[];
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
    function addrow_pd_bk_detail_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        /*$arr2=array(0=>"Draft",1=>"Finish");*/
        $arr2=array(0=>"Draft");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $opt2.="<option value='".$karr2."'>".$varr2."</option>";
        }
        $opt3="";
        foreach ($arr3 as $karr3 => $varr3) {
            $opt3.="<option value='".$varr3['ijenis_bk_id']."'>".$varr3['itipe_bk']." > ".$varr3['vjenis_bk']."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[]' disabled='disabled' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[0][]'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var opt3="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id[0][]'>";
        opt3+="<?php echo $opt3; ?>";
        opt3+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;'></textarea>",opt3,"<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA","ijenis_bk_id", "vKeterangan", "iact"];
        mydata=[];
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
    function addrow_pd_bk_detail_files_non_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
            var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
            var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        /*$arr2=array(0=>"Draft",1=>"Finish");*/
        $arr2=array(0=>"Draft");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $opt2.="<option value='".$karr2."'>".$varr2."</option>";
        }
        $opt3="";
        foreach ($arr3 as $karr3 => $varr3) {
            $opt3.="<option value='".$varr3['ijenis_bk_id']."'>".$varr3['itipe_bk']." > ".$varr3['vjenis_bk']."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[]' disabled='disabled' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[0][]'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var opt3="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id[0][]'>";
        opt3+="<?php echo $opt3; ?>";
        opt3+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;' disabled='disabled'></textarea>",opt3,"<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA","ijenis_bk_id","vKeterangan", "iact"];
        mydata=[];
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
    function addrow_bk_detail_files_<?php echo $id ?>_edit(){
        //get last num rows
        var n=[];
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            n[i]=$(this).val();
            i++;
        });
        if(n.length>=1){
        	var rlast = parseInt(Math.max.apply(Math, n)) +1;
        }else{
        	var rlast =1;
        }
        <?php
        $arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
        /*$arr2=array(0=>"Draft",1=>"Finish");*/
        $arr2=array(1=>"Finish");
        $opt="";
        foreach ($arr as $karr => $varr) {
            $opt.="<option value='".$karr."'>".$varr."</option>";
        }
        $opt2="";
        foreach ($arr2 as $karr2 => $varr2) {
            $opt2.="<option value='".$karr2."'>".$varr2."</option>";
        }
        $opt3="";
        foreach ($arr3 as $karr3 => $varr3) {
            $opt3.="<option value='".$varr3['ijenis_bk_id']."'>".$varr3['itipe_bk']." > ".$varr3['vjenis_bk']."</option>";
        }
        ?> 
        var opt="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_iconfirm_prareg[]' disabled='disabled' >";
        opt+="<?php echo $opt; ?>";
        opt+="</select>";
        var opt2="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_istatus[0][]'>";
        opt2+="<?php echo $opt2; ?>";
        opt2+="</select>";
        var opt3="<select id='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_ijenis_bk_id[0][]'>";
        opt3+="<?php echo $opt3; ?>";
        opt3+="</select>";
        var sa=[["<input type='file' id='fileupload_local_prareg_<?php echo $id ?>_"+rlast+"' class='fileupload multi multifile required' name='fileupload_local_prareg_<?php echo $id ?>[]' style='width: 90%' />",opt,opt2,"<textarea id='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA_"+rlast+"' name='v3_cek_dokumen_prareg_<?php echo $id ?>_tKetRevQA[0][]' style='width: 240px; height: 50px;'></textarea>",opt3,"<textarea id='file_keterangan_local_prareg_<?php echo $id ?>_"+rlast+"' name='file_keterangan_local_prareg_<?php echo $id ?>[]' style='width: 240px; height: 50px;'></textarea>","<input type='hidden' class='num_rows_details_file_<?php echo $id ?>_edit' value='"+rlast+"' /><button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_<?php echo $id ?>_edit("+rlast+")' type='button'>Hapus</button>"]];
        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
        var names = ["vFilename","iconfirm","istatus","tKetRevQA","ijenis_bk_id","vKeterangan", "iact"];
        mydata=[];
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
    function hapus_row_details_file_<?php echo $id ?>_edit(rowId){
        var i=0;
        $.each($(".num_rows_details_file_<?php echo $id ?>_edit"),function(){
            i++;
        });
        if(i<=1){
            _custom_alert('Minimal Satu Upload','Error!','info','v3_cek_dokumen_prareg', 1, 5000);
            return false;
        }else{
            custom_confirm('Anda Yakin ?',function(){
                $('#<?php echo $nmTable; ?>').jqGrid('delRowData',rowId);
            });
        }
    }

    function done_process_<?php echo $id ?>_edit(){
        setuju('v3_cek_dokumen_prareg', '<?php echo base_url() ?>processor/plc/v3/cek/dokumen/prareg?action=doneprocess&field=<?php echo $id ?>&last_id=<?php echo $get['id'] ?>&foreign_key=<?php echo $get['foreign_key'] ?>&company_id=<?php echo $get['company_id'] ?>&group_id=<?php echo $get['group_id'] ?>&modul_id=<?php echo $get['modul_id'] ?>', this, '<?php echo $rowData['iupb_id'] ?>', '<?php echo $rowData['vupb_nomor'] ?>','processor/plc/v3/cek/dokumen/prareg?action=update','Apakah Yakin akan Done',false);        
    }
</script>