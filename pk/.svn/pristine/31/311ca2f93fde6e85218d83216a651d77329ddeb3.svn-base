<?php
    $CI = &get_instance();
    $dbset = $CI->load->database('hrd', true);

    $url = base_url().'processor/pk/pk/pd3/asc?action=saveSupportData';
?>
<script type="text/javascript"> 
  var action = '<?php echo $this->input->get('action');?>';


  function save_data_pendukung(iAspekId,iPkTransId){
    var iAspekId    = '<?php echo $iAspekId; ?>'
    var iPkTransId  = '<?php echo $iPkTransId; ?>'
    var url         = '<?php echo $url; ?>'
    $.ajax({
     type: 'POST',
     url: url,
     data: $('#input_support_data_PD3_ASC_getParameter8').serialize()+'&_parameter=PD3_ASC_getParameter8&_iPkTransId='+iPkTransId+'&_iAspekId='+iAspekId,
     success: function(data)
     {
         custom_alert("Saved");
        
     }
   });

  }

</script>

<form id='input_support_data_PD3_ASC_getParameter8' >
  
<center>
<div class="box_cbox" style="width: 150px">
    <table id="table_support_data_<?php echo $iAspekId ?>" cellspacing="0" cellpadding="3" style=" text-align: center; margin-left: 5px; border-collapse: collapse">
  <thead>
  <tr style="width: 60%; border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
    <th style="border: 1px solid #dddddd;">Jumlah Reformulasi</th>
  </tr>
  </thead>
  <tbody>
  <?php 
    //
    $sql = "SELECT vValue from hrd.pk_trans_support_data where iPkTransId ='".$iPkTransId."' and iAspekId='".$iAspekId."' ";
    $query = $dbset->query($sql);
    if ($query->num_rows() > 0) {
      $i = 1;
      foreach($query->result() as $row) {
        $vValue = $row->vValue;

        $x_value = explode('||', $vValue);
        $klaim_bulan = $x_value['0'];
        $tgl_kirim   = $x_value['1'];
      
  ?>
  <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
    <?php 
      if ($action != 'view') {
    ?>

         <td style="border: 1px solid #dddddd; width: 8%; text-align: left;">                        
          <input style="width: 90%;float:left;text-align: left" type="text" class="klaim_bulan angka" name="klaim_bulan" value='<?php echo $klaim_bulan;?>'/>                        
        </td>
    <?php 
      } else {
    ?>
      <td style="border: 1px solid #dddddd; width: 15%;text-align: left;">
        <?php echo $klaim_bulan;?>
      </td>
      
    
  <?php 
      }
        $i++;
      }
    }else{


  ?>
    <tr>
      <td style="border: 1px solid #dddddd; width: 8%; text-align: left;">                        
          <input style="width: 90%;float:left;text-align: left" type="text" class="angka klaim_bulan" name="klaim_bulan" />
        </td>
    </tr>
    <?php 

  } ?>
</tr>
  <script type="text/javascript">
    $('.angka').numeric();
  </script>
  </tbody>
  <tfoot>
    <?php 
      if ($action != 'view') {
    ?>
<!--     <tr>
      <td style="text-align: right" colspan="3"></td>
      <td style="text-align: center">
      <a class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="javascript:;" onclick="javascript:add_row_data('table_support_data_<?php echo  $iAspekId ?>')">Add</a>
      </td>
    </tr> -->

    <tr>
      <td colspan="4" style="text-align: center">
        <div class='ui-dialog-buttonpane ui-widget-content ui-helper-clearfix'></div>
      <a class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="javascript:;" onclick="javascript:save_data_pendukung()">Save</a>
      </td>
    </tr>

    <?php 
      }
    ?>

    

  </tfoot>
    </table>


</div>
</center>
</form>