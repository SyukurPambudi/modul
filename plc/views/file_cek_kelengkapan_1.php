<style type="text/css" media="screen">
.ui-jqgrid tr.jqgrow td {
        word-wrap: break-word; /* IE 5.5+ and CSS3 */
        white-space: pre-wrap; /* CSS3 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        overflow: hidden;
        height: auto;
        vertical-align: middle;
        padding-top: 3px;
        padding-bottom: 3px
    }    
</style>
<table id="jqGrid" width="98%"></table>
<script type="text/javascript">

/*check box dengan name sama*/
/* DOM */
window
  .document
  .body

/* CLICK */

.addEventListener( "click", function( event ) {
  var oTarget = event.target;

 /* FOR input[type="checkbox"] */

if( oTarget.tagName == "INPUT" && oTarget.type == "checkbox" ) {
  var chkbox = document.getElementsByTagName("INPUT"),
  i = 0;
  for( ;i < chkbox.length; i++ ) {
     if( oTarget.name == chkbox[i].name ) {
       if( chkbox[i] == oTarget ) continue;
       chkbox[i].checked = false;
     }
   }
 }

 /* --- */

}, false );

/*Cek Centang Semua */
function ceckcentang(id,idall,idrevall){
    j=0;
    $.each($("."+id), function(i,v){
        if($(this).attr('checked')){
        }else{
            j++;
        }
    });
    if(j>=1){
        $("#"+idall).attr('checked',false);
    }else if(j==0){
        $("#"+idall).attr('checked',true);
    }
    $("#"+idrevall).attr('checked',false);
}
$("#app_all_cek_1").change(function(){
    va=false;
    da=false;
    if($(this).attr('checked')){
        va=true;
        da=false;
    }
    tr=$(this).parent().parent().parent().next();
    $(tr).find('input:checkbox.appr_cek_1').attr('checked',va);
    $(tr).find('input:checkbox.rev_cek_1').attr('checked',da);
});
$("#rev_all_cek_1").click(function(){
    va=false;
    da=false;
    if($(this).attr('checked')){
        va=true;
        da=false;
    }
    tr=$(this).parent().parent().parent().next();
    $(tr).find('input:checkbox.rev_cek_1').attr('checked',va);
    $(tr).find('input:checkbox.appr_cek_1').attr('checked',da);
});
$(".appr_cek_1").change(function(){
    ceckcentang("appr_cek_1","app_all_cek_1","rev_all_cek_1")
});
$(".rev_cek_1").change(function(){
    ceckcentang("rev_cek_1","rev_all_cek_1","app_all_cek_1")
});

/*Modify Grid */

    $grid = $("#jqGrid");
    resizeColumnHeader = function () {
        var rowHight, resizeSpanHeight,
            // get the header row which contains
            headerRow = $(this).closest("div.ui-jqgrid-view")
                .find("table.ui-jqgrid-htable>thead>tr.ui-jqgrid-labels");

        // reset column height
        headerRow.find("span.ui-jqgrid-resize").each(function () {
            this.style.height = '';
        });

        // increase the height of the resizing span
        resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
        headerRow.find("span.ui-jqgrid-resize").each(function () {
            this.style.cssText = resizeSpanHeight;
        });

        // set position of the dive with the column header text to the middle
        rowHight = headerRow.height();
        headerRow.find("div.ui-jqgrid-sortable").each(function () {
            var $div = $(this);
            $div.css('top', (rowHight - $div.outerHeight()) / 2 + 'px');
        });
    },
    fixPositionsOfFrozenDivs = function () {
        var $rows;
        if (this.grid.fbDiv !== undefined) {
            $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
            $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
                var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
                if ($(this).hasClass("jqgrow")) {
                    $(this).height(rowHight);
                    rowHightFrozen = $(this).height();
                    if (rowHight !== rowHightFrozen) {
                        $(this).height(rowHight + (rowHight - rowHightFrozen));
                    }
                }
            });
            $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
            $(this.grid.fbDiv).css($(this.grid.bDiv).position());
        }
        if (this.grid.fhDiv !== undefined) {
            $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
            $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
                var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
                $(this).height(rowHight);
                rowHightFrozen = $(this).height();
                if (rowHight !== rowHightFrozen) {
                    $(this).height(rowHight + (rowHight - rowHightFrozen));
                }
            });
            $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
            $(this.grid.fhDiv).css($(this.grid.hDiv).position());
        }
    },
    fixGboxHeight = function () {
        var gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight(),
            pagerHeight = $(this.p.pager).outerHeight();

        $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
        gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight();
        pagerHeight = $(this.p.pager).outerHeight();
        $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
    };
    var outerwidth = $grid.width();    
    $grid.jqGrid({
        url: '<?php echo base_url(); ?>processor/plc/kelengkapan/dokumen/export?action=getdetailsdok&id=<?php echo $idossier_review_id ?>',
        datatype: "json",
        mtype:'GET',
        colNames: ['Modul','Sub Modul','Dokumen', 'Nilai Bobot Dokumen', 'Divisi', 'Tersedia','Belum Tersedia','Keterangan Review','Status Dokumen','Status Upload','Upload Dokumen','Revised','Approved','Keterangan','Revisi Oleh Dossier','Revised','Approved','Keterangan','Revisi Oleh IR','Revised','Approved','Keterangan','Revisi Oleh BDIRM','Revised','Approved','Keterangan IM'],
        colModel: [
            { label: 'Modul', name: 'vmodul_kategori', width: 80, frozen: true },                 
            { label: 'Sub Modul', name: 'vsubmodul_kategori', frozen: true },                  
            { label: 'Dokumen', name: 'vNama_Dokumen', width: 200, frozen: true },                  
            { label: 'Nilai Bobot Dokumen', name: 'ibobot', align:'center' },                  
            { label: 'Divisi', name: 'vDescription'},                  
            { label: 'Tersedia', name: 'istatusrev1', formatter:formatistatusrev1, width:60, align:'center'},                
            { label: 'Belum Tersedia', name: 'istatusrev2', formatter:formatistatusrev2, width:60, align:'center'},            
            { label: 'Keterangan Review', name: 'vKeterangan_review'},            
            { label: 'Status Dokumen', name: 'istatus_dokumen', width:100, formatter:formatistatusdok},
            { label: 'Status Upload', name: 'istatus_upload', width:100},
            { label: 'Upload Dokumen', name: 'updok'},               
            { label: 'Revised', name: 'Rev1', width:100, align:'center'},               
            { label: 'Approved', name: 'App1', width:100, align:'center'},               
            { label: 'Keterangan', name: 'vKeterangan_kelengkapan1'},
            { label: 'Revisi Oleh Dossier', width:100, align:'center', name: 'rev_dossier'},                
            { label: 'Revised', name: 'Rev2', width:100, align:'center'},               
            { label: 'Approved', name: 'App2', width:100, align:'center'},               
            { label: 'Keterangan', name: 'vKeterangan_kelengkapan2'},
            { label: 'Revisi Oleh IR', width:100, align:'center', name: 'rev_ir'},                
            { label: 'Revised', name: 'Rev3', width:100, align:'center'},               
            { label: 'Approved', name: 'App3', width:100, align:'center'},               
            { label: 'Keterangan', name: 'vKeterangan_kelengkapan3'},
            { label: 'Revisi Oleh BDIRM', width:100, align:'center',name: 'rev_bdir'},
            { label: 'Revised', name: 'Rev4', width:100, align:'center'},               
            { label: 'Approved', name: 'App4', width:100, align:'center'},               
            { label: 'Keterangan IM', name: 'vKeterangan_kelengkapan4'}               
        ],
        loadonce: true,
        shrinkToFit: false, // must be set with frozen columns, otherwise columns will be shrank to fit the grid width
        height: 400,
        rowNum: '',
        width: outerwidth,
        caption:"Rincian Dokumen",
        cmTemplate: {
            title: false,
            sortable: false
        },
        loadComplete: function () {
            fixPositionsOfFrozenDivs.call(this);
        }
        
    });

    $grid.jqGrid('setGroupHeaders',{
        useColSpanStyle:true,
        groupHeaders:[{startColumnName:'istatusrev1', numberOfColumns:2, titleText:'Status Review'},
        {startColumnName:'Rev1', numberOfColumns:3, titleText:'Cek Kelengkapan I'},
        {startColumnName:'Rev2', numberOfColumns:3, titleText:'Cek Kelengkapan II'},
        {startColumnName:'Rev3', numberOfColumns:3, titleText:'Cek Kelengkapan III'},
        {startColumnName:'Rev4', numberOfColumns:3, titleText:'Cek Kelengkapan IV'}]
    });

    function formatistatusrev1(cellValue, options, rowObject) {
        var check = "";
        if(cellValue==1){
            check="checked";
        }
        o='<input type="checkbox" '+check+' disabled="disabled">';
        return o;
    }
    function formatistatusrev2(cellValue, options, rowObject) {
        var check = "";
        if(cellValue==0){
            check="checked";
        }
        o='<input type="checkbox" '+check+' disabled="disabled">';
        return o;
    }
    function formatistatusdok(cellValue, options, rowObject) {
        var o="Belum Tersedia";
        if(cellValue==1){
            o="Tersedia";
        }
        return o;
    }

   $("#jqGrid").jqGrid("setFrozenColumns");

    $grid.jqGrid('gridResize', {
        minWidth: 450,
        stop: function () {
            fixPositionsOfFrozenDivs.call(this);
            fixGboxHeight.call(this);
        }
    });
    $grid.bind("jqGridResizeStop", function () {
        resizeColumnHeader.call(this);
        fixPositionsOfFrozenDivs.call(this);
        fixGboxHeight.call(this);
    });
    resizeColumnHeader.call($grid[0]);
    $grid.jqGrid('setFrozenColumns');
    $grid.triggerHandler("jqGridAfterGridComplete");
    fixPositionsOfFrozenDivs.call($grid[0]);
    full_colums=$('.form_kelengkapan_dokumen_export').find('full_colums');
</script>