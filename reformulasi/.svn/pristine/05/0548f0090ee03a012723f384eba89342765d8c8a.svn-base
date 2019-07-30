<div id='grp_kategori'>
<?php 
    $sql = 'SELECT * 
            FROM reformulasi.master_kategori a 
            WHERE a.lDeleted=0
    ';
    $datas = $this->db->query($sql)->result_array();

    foreach ($datas as $data){
        $checked='';

        $sqlcek ='SELECT * 
                    FROM kategori_refor_export a 
                    WHERE a.lDeleted=0
                    AND a.iexport_req_refor= "'.$rowDataH['iexport_req_refor'].'"
                    AND a.idKategori="'.$data['idKategori'].'"
                    ';
        $dCheck = $this->db->query($sqlcek)->row_array();

        if(!empty($dCheck)){
            $checked ="checked";
        }
        

        echo '<input '.$checked.' type="checkbox" id="kategori'.$data['idKategori'].'" name="kategori[]" value="'.$data['idKategori'].'"  > '.$data['kategori'];
        echo '&nbsp<input  type="text" name="vRemark_'.$data['idKategori'].'" value="'.$dCheck['vRemark'].'"  size="40" > ';
        
        
        echo '<br>';
    }
?>
</div>

<?php 

$get=$this->input->get();
    
    $sqlcek ='SELECT * 
        FROM reformulasi.kategori_refor_export a 
        join reformulasi.master_kategori b on b.idKategori=a.idKategori
        WHERE a.lDeleted=0
        AND a.iexport_req_refor= "'.$rowDataH['iexport_req_refor'].'"
        AND b.iPacking=1
        ';
    $dCheck = $this->db->query($sqlcek)->result_array();

?>

<script>
    

    <?php
       if(!empty($dCheck)){?>
            $("#grp_kategori").parent().parent().next().show();
                 
    <?php 
        }else{
    ?>
            $("#grp_kategori").parent().parent().next().hide();
    <?php         
        }
    ?>

        $('#kategori3').click(function(){
            if($(this).prop("checked") == true){
                $("#grp_kategori").parent().parent().next().show();
                $('#grp_input_bk input[type=text]').addClass('required');
            }
            else if($(this).prop("checked") == false){
                $("#grp_kategori").parent().parent().next().hide();
                $('#grp_input_bk input[type=text]').removeClass('required');
            }
        });


</script>



    
