<?php 
	$grid=str_replace("_".$field, "", $id);
    $idossier_upd_id=isset($dataHead["idossier_upd_id"])?$dataHead["idossier_upd_id"]:"0";
    $iexport_req_refor=isset($dataHead["iexport_req_refor"])?$dataHead["iexport_req_refor"]:"0";
   
    $get=$this->input->get();
    
        $sqlcek ='SELECT * 
            FROM reformulasi.kategori_refor_export a 
            join reformulasi.master_kategori b on b.idKategori=a.idKategori
            WHERE a.lDeleted=0
            AND a.iexport_req_refor= "'.$rowDataH['iexport_req_refor'].'"
            AND b.iPacking=1
            ';
        $dCheck = $this->db->query($sqlcek)->row_array();

    ?>


    
    <script>
    
    
    <?php
    
       if(!empty($dCheck)){?>
            $("#<?php echo $id ?>").parent().parent().next().show();
                 
    <?php 
        }else{ ?>

            $("#v2_exp_confirm_refor_form_detail_komposisi").parent().parent().next().hide();

    <?php 
        }
    ?>

      
    </script>