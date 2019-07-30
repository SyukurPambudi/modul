<?php
$grid=str_replace("_".$field, "", $id);
$valueini=isset($dataHead['c_iteno'])?$dataHead['c_iteno']:0;
$no_mbr=isset($dataHead['no_mbr'])?$dataHead['no_mbr']:"";
$return='<input type="hidden" value="'.$no_mbr.'" id="'.$grid.'_no_mbr" />';
$sql="select z.itemasiteno as valval , concat( z.itemasiteno,' | ',z.c_nodoinp) as showshow FROM (select batpack0.*,itemas.c_iteno as itemasiteno
    from sales.itemas
    join prdtrial.trial on trial.c_itenonew=itemas.c_iteno
    join prdtrial.batpack0 on batpack0.c_iteno=trial.c_iteno
    order by batpack0.c_version DESC) as z
    group by z.c_iteno";
$result=$this->db_plc0->query($sql)->result_array();
$return .= '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" style="min-width:350px" >'; 
$return.='<option value="">---Pilih----</option>';           
foreach($result as $sasa => $me) {
    $selected = '';
    if ($me['valval'] == $valueini){
        $readonlyvalue = $me['showshow'];
        $selected = ' selected';
    }  
    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
}            
$return .= '</select>';
if($form_field['iRead_only_form']==1){
    $return ='<input type="hidden"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$value.'"><input type="text"  name="'.$field.'_dis" id="'.$id.'_details_formula" class="input_rows1 '.$field_required.'" size="45" '.$field_required.' readonly="readonly" value="'.$readonlyvalue.'">';
}

echo $return;
?>
<script>
    $("#<?php echo $id ?>").change(function(){
        var nilai = $(this).val();
        $.ajax({
            url: base_url+"processor/plc/v3/partial/controllers/plc?action=getMBRDetails",
            type: "post",
            data : {c_iteno:$(this).val()},
            success: function(data) {
                var o = $.parseJSON(data);
                $("#<?php echo $grid ?>_c_version").val(o.c_version);
                $("#<?php echo $grid ?>_dbuat_mbr").val(o.d_datent);
                $("#<?php echo $grid ?>_dtgl_appr_1").val(o.d_userid1);
                $("#<?php echo $grid ?>_dtgl_appr_2").val(o.d_userid2);
                $("#<?php echo $grid ?>_dtgl_appr_3").val(o.d_userid3);
                $("#<?php echo $grid ?>_dtgl_appr_4").val(o.d_userid4);
                $("#<?php echo $grid ?>_no_mbr").val(o.c_nodoinp);
                $("#<?php echo $grid ?>_c_iteno").val(nilai);
            }
        });
    });
</script>