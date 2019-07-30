<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $arrayi=array(0=>"Tidak",1=>"Ya");
    $value="0";
    if(isset($dataHead[$field])){
        $value=isset($arrayi[$dataHead[$field]])?$arrayi[$dataHead[$field]]:"-";
    }
    $get=$this->input->get();
?>
<script>
    <?php   
       if($iupb_id!="0"){?>
        var nilai = $("#<?php echo $id ?>").val();
        if(nilai=="1"){
            $("#<?php echo $id ?>").parent().parent().next().show();
            var iappbusdev_registrasi = <?php echo $iappbusdev_registrasi; ?>;
            /* Cek Untuk Idone */
            $.ajax({
                url: base_url+"processor/plc/v3/prareg/hpr?action=cekDoneProses",
                type: 'post',
                data: $.param({'iupb_id': '<?php echo $iupb_id ?>'}),
                success: function(data) {
                    var o = $.parseJSON(data);
                    if(o.status=="1" && iappbusdev_registrasi=="2"){
                        $("#<?php echo $id ?>").parent().parent().next().next().show();
                    }else{
                        $("#<?php echo $id ?>").parent().parent().next().next().hide();
                    }
                }
            });
        }else{
            $("#<?php echo $id ?>").parent().parent().next().hide();
            $("#<?php echo $id ?>").parent().parent().next().next().show();
        }
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().next().next().hide();
    <?php } ?>
        $("#<?php echo $id ?>").change(function(){
            var iappbusdev_registrasi = <?php echo $iappbusdev_registrasi; ?>;
            var v = $(this).val();
            if(v=="1"){
                $(this).parent().parent().next().show();
                $.ajax({
                url: base_url+"processor/plc/v3/prareg/hpr?action=cekDoneProses",
                type: 'post',
                data: $.param({'iupb_id': '<?php echo $iupb_id ?>'}),
                success: function(data) {
                    var o = $.parseJSON(data);
                    if(o.status=="1" && iappbusdev_registrasi=="2"){
                        $("#<?php echo $id ?>").parent().parent().next().next().show();
                    }else{
                        $("#<?php echo $id ?>").parent().parent().next().next().hide();
                    }
                }
            });
            }else{
                $(this).parent().parent().next().hide();
            }
        });        
</script>
<?php
if ($iappbusdev_registrasi ==2 ){ ?>
    <script>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
    </script>
      <?php } ?>


