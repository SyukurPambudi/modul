
<?php
    $sql = "
            SELECT * 
            FROM reformulasi.refor_bahan_kemas a 
            WHERE a.lDeleted=0
            AND a.iexport_req_refor= '".$rowDataH['iexport_req_refor']."'
            ";

    /* echo '<pre>'.$sql;
    exit; */
    $rows       = $this->db->query($sql)->result_array();
    $iSubmit    = $rowDataH['iSubmitPD'];
    $ikonfimref = 0;
    $browse_url = base_url().'processor/reformulasi/browse/bb';

    $satuan = $this->db->get_where('plc2.plc2_master_satuan', array('ldeleted' => 0))->result_array();

    $read = '';
    if($iSubmit!=0){
    $read = ' readonly ';
    }
?>
<script type="text/javascript">
    function browse_multi1_re_export_req_refor_bahan_kemas(url, title, dis, param) {
        var i = $('.btn_browse_bb').index(dis);	
        load_popup_multi(url+'&'+param,'','',title,i);
        }
        function get_rawmaterial_exists() {
        var i = 0;
        var l_irawmat_id = '';
        $('.detraw_id').each(function() {
            if  ($('.detraw_id').eq(i).val() != '') {
                l_irawmat_id += $('.detraw_id').eq(i).val()+'_';
            }
            
            i++;
        });

        l_irawmat_id = l_irawmat_id.substring(0, l_irawmat_id.length - 1);
        if (l_irawmat_id === undefined) l_ireq_id = 0;
        $('.list_raw_material_exists').val(l_irawmat_id);
            var x= $('.list_raw_material_exists').val(l_irawmat_id);
    }


</script>
<style type="text/css">
    table.hover_table tr:hover {

    }
</style>
<div id='grp_input_bk'>
    <table class="hover_table" id="re_export_req_refor_bahan_kemas" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
        <thead>
            <tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
            <th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Bahan Kemas</span></th>
            </tr>
            <tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
            <th style="border: 1px solid #dddddd;">No</th>
            <th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
            <th style="border: 1px solid #dddddd;">Keterangan</th>
            <th style="border: 1px solid #dddddd;">Action</th>		
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                if(!empty($rows)) {
                    foreach($rows as $row) {
                    $i++;				
                    $this->db->where('raw_id', $row['raw_id']);
                    $m = $this->db->get('plc2.plc2_raw_material')->row_array();
            ?>
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
                            <span class="re_export_req_refor_bahan_kemas_num"><?php echo $i ?></span>
                        </td>		
                        <td style="border: 1px solid #dddddd; width: 10%">
                            <input <?php echo $read ?> type="text" name="detjenis[]" value="<?php echo $row['vJenis'] ?>" class="detjenis " style="width: 80%; text-align: left;" />
                        </td>
                        <td style="border: 1px solid #dddddd; width: 15%">
                            <input <?php echo $read ?>  type="text" name="detremark[]" value="<?php echo $row['vRemark'] ?>" class="detremark" style="width: 80%" />
                        </td>
                        <td style="border: 1px solid #dddddd; width: 10%">
                            <?php
                            if($ikonfimref==0){ 
                                if($iSubmit==0){
                                    ?>
                                        <span class="delete_btn"><a href="javascript:;" class="re_export_req_refor_bahan_kemas_del" onclick="del_row(this, 're_export_req_refor_bahan_kemas_del')">[Hapus]</a></span>
                                    <?php
                                }else{
                                    echo '-';
                                }
                            }
                            ?> 
                        </td>		
                    </tr>
            <?php
                    }
                }
                else {
                //$i++;
            ?>
            <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                <td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
                    <span class="re_export_req_refor_bahan_kemas_num">1</span>
                </td>		
                <td style="border: 1px solid #dddddd; width: 10%">
                    <input type="text" name="detjenis[]" value="" class="detjenis " style="width: 80%; text-align: left;"/>
                </td>
                <td style="border: 1px solid #dddddd; width: 15%">
                    <input type="text" name="detremark[]" value="" class="detremark" style="width: 80%" />
                </td>
                <td style="border: 1px solid #dddddd; width: 10%">
                    <span class="delete_btn"><a href="javascript:;" class="re_export_req_refor_bahan_kemas_del" onclick="del_row(this, 're_export_req_refor_bahan_kemas_del')">[Delete]</a></span>
                </td>		
            </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <?php 
            if($ikonfimref==0){
            if ($this->input->get('action') != 'view') { 
                if($iSubmit==0){?>
                    <tr>
                        <td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('re_export_req_refor_bahan_kemas')">Tambah</a></td>
                    </tr>
            <?php } 
                }}?>
        </tfoot>
    </table>
</div>
