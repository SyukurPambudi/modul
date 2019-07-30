<?php
$sql = "
		SELECT * 
		FROM reformulasi.export_protokol_valpro_detail a 
		JOIN reformulasi.export_protokol_valpro b ON b.iexport_protokol_valpro=a.iexport_protokol_valpro
		WHERE a.lDeleted=0
		AND b.lDeleted=0
		AND b.iexport_protokol_valpro=  '".$rowDataH['iexport_protokol_valpro']."'";

/* echo '<pre>'.$sql;
exit; */
$rows       = $this->db->query($sql)->result_array();
$iSubmit    = $rowDataH['iSubmit'];

$read = '';
if($iSubmit!=0){
$read = ' readonly ';
}
?>
<script type="text/javascript">
function browse_multi1_re_export_prot_valpro_batch(url, title, dis, param) {
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
<table class="hover_table" id="re_export_prot_valpro_batch" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
<thead>
<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
<th colspan="3" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Batch</span></th>
</tr>
<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
<th style="border: 1px solid #dddddd;">No</th>
<th style="border: 1px solid #dddddd;">Nomor Batch</th>
<th style="border: 1px solid #dddddd;">Action</th>		
</tr>
</thead>
<tbody>
<?php
    $i = 0;
    if(!empty($rows)) {
        foreach($rows as $row) {
        $i++;				
?>
        <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
            <td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
                <span class="re_export_prot_valpro_batch_num"><?php echo $i ?></span>
            </td>		
            <td style="border: 1px solid #dddddd; width: 15%">
                <input <?php echo $read ?>  type="text" name="detbatch[]" value="<?php echo $row['cpanumb'] ?>" class="detbatch" style="width: 80%" />
            </td>
            <td style="border: 1px solid #dddddd; width: 10%">
                <?php
                    if($iSubmit==0){
                        ?>
                            <span class="delete_btn"><a href="javascript:;" class="re_export_prot_valpro_batch_del" onclick="del_row(this, 're_export_prot_valpro_batch_del')">[Hapus]</a></span>
                        <?php
                    }else{
                        echo '-';
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
        <span class="re_export_prot_valpro_batch_num">1</span>
    </td>		
    <td style="border: 1px solid #dddddd; width: 15%">
        <input type="text" name="detbatch[]" value="" class="detbatch" style="width: 80%" />
    </td>
    <td style="border: 1px solid #dddddd; width: 10%">
        <span class="delete_btn"><a href="javascript:;" class="re_export_prot_valpro_batch_del" onclick="del_row(this, 're_export_prot_valpro_batch_del')">[Delete]</a></span>
    </td>		
</tr>
<?php } ?>
</tbody>

<tfoot>
<?php 

if ($this->input->get('action') != 'view') { 
    if($iSubmit==0){?>
        <tr>
            <td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('re_export_prot_valpro_batch')">Tambah</a></td>
        </tr>
<?php 
	} 
}
?>
</tfoot>
</table>
