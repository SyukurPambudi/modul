<?php 
$iupb_id=isset($dataHead['iupb_id'])?$dataHead['iupb_id']:0;
$this->db_plc0->where('iupb_id',$iupb_id);
$row=$this->db_plc0->get('plc2.study_literatur_pd')->row_array();
$jenis=isset($row['ijenis_sediaan'])?$row['ijenis_sediaan']:0;
$iJenis_pengujian=isset($dataHead["iJenis_pengujian"])?$dataHead["iJenis_pengujian"]:0;
if($jenis==0){
?>
<script>
$("#<?php echo $id ?>").parent().parent().remove();
</script>
<?php }else{
    echo "<input type='hidden' name='".$field."' id='".$id."' value='".$iJenis_pengujian."' />";
} ?>