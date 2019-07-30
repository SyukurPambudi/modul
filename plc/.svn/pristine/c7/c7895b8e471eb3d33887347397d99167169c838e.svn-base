 <div class="clear"></div>
    <div id="grid_wraper_monitoring_cost_budget">
        <div id="grid_search_monitoring_cost_budget">
            <div class="full_colums">
                <div class="top_form_head">                                 
                <span class="form_head top-head-content"> Detail Monitoring Cost Budget Parameter <?php echo $no ?> </span>

                </div> 
                <div class="clear"></div>
                <span style="margin-left:40%;margin-right:40%; font-size:16px;">LAPORAN KPI DAN COST BUDGET</span><br />
                <span style="margin-left:41.5%;margin-right:38%; font-size:14px;">Periode : <?php echo $tglAwal ?> s/d <?php echo $tglAkhir ?></span>
                <br />
                <div style="margin-top:10px">
                        <table style="padding-left:28%;" >
                            <tr>
                                <td>Category</td>
                                <td><input type="text" readonly="readonly" size="50" value='<?php echo $header['kategori'] ?>'></td>
                            </tr>
                            <tr>
                                <td>Parameter</td>
                                <td>
                                <textarea style='width: 360px; height: 75px;'size='250' readonly="readonly"><?php echo nl2br($header['kategori_parameter']) ?> </textarea>
                                </td>
                            </tr>
                             <tr>
                                <td>Nilai</td>
                                <td><input type="text" readonly="readonly" size="15" value= '<?php echo $uom?>'></td>
                            </tr>
                            <tr>
                                <td>UOM</td>
                                <td><input type="text" readonly="readonly" size="15" value= '<?php echo $header['vNmSatuan']?>'></td>
                            </tr>
                            <tr>
                                <td>Syarat & Ketentuan</td>
                                <td>
                                    <textarea style='width: 360px; height: 75px;'size='250' readonly="readonly"><?php echo nl2br($header['description']) ?> </textarea>
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="grid-list">
        <div style="padding-right: 30px;overflow:auto;" class="boxContent">
            <div class="ui-jqgrid ui-widget ui-widget-content ui-corner-all ui-resizable" id="gbox_grid_monitoring_cost_budget" dir="ltr" style="width: 1064px;">
                <div id="lui_grid_monitoring_cost_budget" class="ui-widget-overlay jqgrid-overlay"></div>
                <div id="load_grid_monitoring_cost_budget" class="loading ui-state-default ui-state-active" style="display: none;">Loading...</div>
                <div class="ui-jqgrid-view" id="gview_grid_monitoring_cost_budget" style="width: 1064px;">
                    <div class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
                    <a href="javascript:void(0)" role="link" class="ui-jqgrid-titlebar-close HeaderButton" style="right: 0px;">
                        <span class="ui-icon ui-icon-circle-triangle-n"></span>
                    </a>
                        <span class="ui-jqgrid-title">List Monitoring Cost</span>
                    </div>

                    <div style="width: 1064px;" class="ui-state-default ui-jqgrid-hdiv">
                    <div class="ui-jqgrid-hbox">
                    <table cellspacing="0" cellpadding="0" border="0" style="width: 100%;" id="grid_master_category" tabindex="1" role="grid" aria-multiselectable="false" aria-labelledby="gbox_grid_master_category" class="ui-jqgrid-btable">
                        <thead>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 2%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">No
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>

                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 8%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">UPB
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 40%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">Nama Usulan
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 12%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">Tgl Approve<br>Setting Prioritas
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 14%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">Tgl Approve <br> Prareg
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 14%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">Tgl Confirm <br> Prareg
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_monitoring_cost_budget_view" style="width: 8%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_monitoring_cost_budget_view" class="ui-jqgrid-sortable">Jumlah Hari
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            
                        </tr>
                        </thead>        
                        <tbody>

                        <?php 
                            $i = 1;
                            foreach($datanya as $data) {
                                $jml_hari = $data['jumlah_hari']-$data['hari_libur'];
                        ?>
                               <tr class="ui-widget-content jqgrow ui-row-ltr" role="row" id="param_id">
                                   <td class="ui-state-default jqgrid-rownum" style="text-align:right;" role="gridcell"><?php echo $i ?></td>
                                   <td style="text-align:left; " ><?php echo $data['vupb_nomor'] ?></td>
                                   <td style="text-align:left; " ><?php echo $data['nama_usulan'] ?></td>
                                   <td style="text-align:left; " ><?php echo $data['date_prioritas'] ?></td>
                                   <td style="text-align:left; " ><?php echo $data['tanggal_approve'] ?></td>
                                   <td style="text-align:left; " ><?php echo $data['tanggal_doc'] ?></td>
                                   <td style="text-align:left;" ><?php echo $jml_hari ?></td>
                                   
                                  
                                   
                               </tr>
                      <?php 
                        $i++;
                        }   
                      ?>
                        </tbody>
                    </table>
                    <span style='margin-left:93%;'><?php echo $per.' of '.$total ?> </span>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="control-group-btn">
        <div class="left-control-group-btn">
            <button id="btn_print_xl_monitoring_cost_budget_detail" class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"  type="button"  role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-save"></span>
                <span class="ui-button-text">Print to Excel</span>
            </button>
        </div>
        <div class="left-control-group-btn">
            <button id="btn_print_pdf_monitoring_cost_budget_detail" class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"  type="button"  role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-save"></span>
                <span class="ui-button-text">Print to PDF</span>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    function openWindow(url) {
        window.open (url, "Print","status=1,toolbar=1,menubar=1,resizable=1,height=250,width=350");
    }

<?php $url_print_detail = base_url()."processor/plc/monitoring/cost/budget/?action=printdetail"; ?>
    $('#btn_print_xl_monitoring_cost_budget_detail').click( function  () {
        var $tglAwal = '<?php echo $tglAwal ?>';
        var $tglAkhir = '<?php echo $tglAkhir ?>';
        var $parameter = '<?php echo $parameter ?>';
        var $uom = '<?php echo $uom ?>';
        var $no = '<?php echo $no ?>';
        var $total = '<?php echo $total ?>';
        var $per = '<?php echo $per ?>';
        var $extention = 'xls';
        
        if ($tglAkhir == '' || $tglAwal=='') {

            alert('Periode tidak boleh kosong');
        }else{
        
            var $url_print_detail_do = '<?php echo $url_print_detail;?>'+'&_ext='+$extention+'&_tglAwal='+$tglAwal+'&_tglAkhir='+$tglAkhir+'&_parameter='+$parameter+'&_uom='+$uom+'&_total='+$total+'&_per='+$per+'&_no='+$no;
            openWindow($url_print_detail_do);
        };
        
    
    });


    $('#btn_print_pdf_monitoring_cost_budget_detail').click( function  () {
        var $tglAwal = '<?php echo $tglAwal ?>';
        var $tglAkhir = '<?php echo $tglAkhir ?>';
        var $parameter = '<?php echo $parameter ?>';
        var $no = '<?php echo $no ?>';
        var $uom = '<?php echo $uom ?>';
        var $total = '<?php echo $total ?>';
        var $per = '<?php echo $per ?>';
        var $extention = 'pdf';

        if ($tglAkhir == '' || $tglAwal=='') {

            alert('Periode tidak boleh kosong');
        }else{
            var $url_print_detail_do = '<?php echo $url_print_detail;?>'+'&_ext='+$extention+'&_tglAwal='+$tglAwal+'&_tglAkhir='+$tglAkhir+'&_parameter='+$parameter+'&_uom='+$uom+'&_total='+$total+'&_per='+$per+'&_no='+$no;
            openWindow($url_print_detail_do);
        };
        
    
    });

</script>
