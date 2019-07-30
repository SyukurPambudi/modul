<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"0";
    $arrayi=array(0=>"Tidak",1=>"Ya");
    $value="0";
    if(isset($dataHead[$field])){
        $value=isset($arrayi[$dataHead[$field]])?$arrayi[$dataHead[$field]]:"0";
    }
    $get=$this->input->get();
?>
<script>
            var ire =<?php echo $iappbusdev_prareg ?>;
    <?php   
       if($iupb_id!="0"){?>
        var nilai = $("#<?php echo $id ?>").val();
        if(nilai=="1"){
            $("#<?php echo $id ?>").parent().parent().next().show();
            /* Cek Untuk Idone */
            $.ajax({
                url: base_url+"processor/plc/v3/prareg/hpr?action=cekDoneProses",
                type: 'post',
                data: $.param({'iupb_id': '<?php echo $iupb_id ?>'}),
                success: function(data) {
                    var o = $.parseJSON(data);
                    if(o.status=="1" && ire==2){
                        $("#<?php echo $id ?>").parent().parent().next().next().show();
                    }else{
                        $("#<?php echo $id ?>").parent().parent().next().next().hide();
                    }
                }
            });
        }else{
            $("#<?php echo $id ?>").parent().parent().next().hide();
            if(ire!=2){
                $("#v3_prareg_hpr_ttarget_hpr").parent().parent().hide();
            }else{
                $("#<?php echo $id ?>").parent().parent().next().next().show();
            }
        }
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().next().next().hide();
    <?php } ?>
        $("#<?php echo $id ?>").change(function(){
            var v = $(this).val();
            if(v=="1"){
                $(this).parent().parent().next().show();
                $.ajax({
                url: base_url+"processor/plc/v3/prareg/hpr?action=cekDoneProses",
                type: 'post',
                data: $.param({'iupb_id': '<?php echo $iupb_id ?>'}),
                success: function(data) {
                    var o = $.parseJSON(data);
                    if(o.status=="1"){
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
        <script>
            /*  mansur 2019-04-27 
                hide PIC dan dokumen revise saat diawal, jika sudah ada butuh dkumen ya, maka show
            */ 
            
            <?php 
                $sqlcekbutuh = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$iupb_id.'"';
                $upebeh = $this->db_plc0->query($sqlcekbutuh)->row_array();
                $ibutuh_dok_prareg =isset($upebeh['ibutuh_dok_prareg'])?$upebeh['ibutuh_dok_prareg']:'';
                $itambahan_hpr =isset($upebeh['itambahan_hpr'])?$upebeh['itambahan_hpr']:'';
                    if($ibutuh_dok_prareg == 0){
            ?>  
                            $("#v3_prareg_hpr_iPic_Prareg_req_doc").removeClass('required');
                            $("#v3_prareg_hpr_tsubmit_prareg").parent().parent().next().next().next().next().next().next().next().next().hide();
                            $("#v3_prareg_hpr_tPrareg_req_doc").removeClass('required');
                            $("#v3_prareg_hpr_tsubmit_prareg").parent().parent().next().next().next().next().next().next().next().next().next().hide();
            <?php 
                        
                    }
            ?>

        </script>
        

        
<?php
if ($iappbusdev_prareg ==2 ){ ?>
    <script>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
    </script>
      <?php } ?>