<?php
$sql = "
        SELECT e.* 
        FROM reformulasi.`export_request_sample_detail` e 
        JOIN reformulasi.`export_request_sample` r ON r.iexport_request_sample = e.iexport_request_sample
        WHERE e.lDeleted = 0 
        AND r.lDeleted = 0 
        AND r.iexport_req_refor = '".$rowDataH['iexport_req_refor']."'";

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
function browse_multi1_re_export_req_refor_bahan_baku(url, title, dis, param) {
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
//alert (l_irawmat_id);
}
jQuery('.detjumlah').live('keyup', function() {
this.value = this.value.replace(/[^0-9\.]/g, '');
});
// jQuery(function($) {
// $('.detjumlah').autoNumeric('init');
  
// });
</script>
<style type="text/css">
table.hover_table tr:hover {

}
</style>
<table class="hover_table" id="re_export_req_refor_bahan_baku" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
<thead>
<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Kemasan Bahan Kemas Primer</span></th>
</tr>
<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
<th style="border: 1px solid #dddddd;">No</th>
<th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
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
                <span class="re_export_req_refor_bahan_baku_num"><?php echo $i ?></span>
            </td>		
            <td style="border: 1px solid #dddddd; width: 30%">
                <input type="hidden" name="iexport_request_sample_detail[]" value="<?php echo $row['iexport_request_sample_detail'] ?>" class="iexport_request_sample_detail" />
                <input type="hidden" name="detrawid[]" value="<?php echo $row['raw_id'] ?>" class="detraw_id" />
                <input disabled="true" type="text" name="rawname[]" value="<?php echo $m['vnama'] ?>" class="detraw_id_dis required" style="width: 65%" />
                <?php if ($this->input->get('action') != 'view') { 
                    if($iSubmit==0){?>
                        <button class="btn_browse_bb" type="button" onClick="javascript:get_rawmaterial_exists();javascript:browse_multi1_re_export_req_refor_bahan_baku('<?php echo $browse_url ?>?field=re_export_req_refor_bahan_baku&col=detraw_id','List Bahan Baku',this,'irawmat_id='+$('.list_raw_material_exists').val());return false;">...</button>
                <?php } }?>
                <input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
            </td>	
            <td style="border: 1px solid #dddddd; width: 10%">
                <input <?php echo $read ?> type="text" name="detjumlah[]" value="<?php echo $row['iJumlah'] ?>" class="detjumlah required" style="width: 80%; text-align: right;" />
            </td>
            <td style="border: 1px solid #dddddd; width: 15%">
                <select name="detsatuan[]" value="<?php echo $row['vsatuan'] ?>" class="detsatuan required">
                    <option value="">-- Pilih Satuan --</option>
                    <?php
                        foreach ($satuan as $s) {
                            $selected = ($s['plc2_master_satuan_id'] == $row['vSatuan'])?'selected':'';
                            ?>
                                <option <?php echo $selected; ?> value="<?php echo $s['plc2_master_satuan_id']; ?>"><?php echo $s['vNmSatuan']; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </td>

            
            
            <td style="border: 1px solid #dddddd; width: 15%">
                <input <?php echo $read ?>  type="text" name="detspesifikasi[]" value="<?php echo $row['vSpesifikasi'] ?>" class="detspesifikasi" style="width: 80%" />
            </td>
            <td style="border: 1px solid #dddddd; width: 15%">
                <?php 
                    $lmarketing = array( 1=>'New', 2=>'Existing');
                    $o  = "<select name='detsource[]' class='detsatuan detsource'>";            
                    foreach($lmarketing as $k=>$v) {
                        if ($k == $row['iMaterialMR']) $selected = " selected";
                        else $selected = "";
                        $o .= "<option {$selected} value='".$k."'>".$v."</option>";
                    }            
                    $o .= "</select>";
                    echo $o;
                ?>
            </td>

            <td style="border: 1px solid #dddddd; width: 10%">
                <?php
                if($ikonfimref==0){ 
                    if($iSubmit==0){
                        ?>
                            <span class="delete_btn"><a href="javascript:;" class="re_export_req_refor_bahan_baku_del" onclick="del_row(this, 're_export_req_refor_bahan_baku_del')">[Hapus]</a></span>
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
            <span class="re_export_req_refor_bahan_baku_num">1</span>
        </td>		
        	
        <td style="border: 1px solid #dddddd; width: 90%">
            <input type="text" name="detjumlah[]" value="" class="detjumlah required" style="width: 80%; text-align: right;"/>
        </td>

        <!-- <td style="border: 1px solid #dddddd; width: 30%">
            <input type="hidden" name="iexport_request_sample_detail[]" value="" class="iexport_request_sample_detail" />
            <input type="hidden" name="detrawid[]" value="" class="detraw_id" />    
            <input disabled="true" type="text" name="rawname[]" value="" class="detraw_id_dis required" style="width: 60%" />
            <button class="btn_browse_bb" type="button" onClick="javascript:get_rawmaterial_exists();javascript:browse_multi1_re_export_req_refor_bahan_baku('<?php echo $browse_url ?>?upbid='+$('#re_export_req_refor_bahan_baku_iupb_id').val()+'&field=re_export_req_refor_bahan_baku&col=detraw_id','List Bahan Baku',this,'irawmat_id='+$('.list_raw_material_exists').val());return false;">...</button>
            <input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
        </td> -->
        <!-- <td style="border: 1px solid #dddddd; width: 15%">
            
            <select name="detsatuan[]" value="" class="detsatuan required">
                <option value="">-- Pilih Satuan --</option>
                <?php
                    foreach ($satuan as $s) {
                        ?>
                            <option value="<?php echo $s['plc2_master_satuan_id']; ?>"><?php echo $s['vNmSatuan']; ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
 -->        
        <!-- <td style="border: 1px solid #dddddd; width: 15%">
            <input type="text" name="detspesifikasi[]" value="" class="detspesifikasi" style="width: 80%" />
        </td> -->
        <!-- <td style="border: 1px solid #dddddd; width: 15%">
            <?php 
                $lmarketing = array( 1=>'New', 2=>'Existing');
                $o  = "<select name='detsource[]' class='detsatuan detsource'>";            
                foreach($lmarketing as $k=>$v) {
                    $o .= "<option value='".$k."'>".$v."</option>";
                }            
                $o .= "</select>";
                echo $o;
            ?>
        </td> -->

        <td style="border: 1px solid #dddddd; width: 10%">
            <span class="delete_btn"><a href="javascript:;" class="re_export_req_refor_bahan_baku_del" onclick="del_row(this, 're_export_req_refor_bahan_baku_del')">[Delete]</a></span>
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
            <td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('re_export_req_refor_bahan_baku')">Tambah</a></td>
        </tr>
<?php } 
    }}?>
</tfoot>
</table>
