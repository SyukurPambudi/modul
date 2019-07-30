<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $iprareg_ulang_reg=isset($dataHead["iprareg_ulang_reg"])?$dataHead["iprareg_ulang_reg"]:"";
    $ineed_prareg=isset($dataHead["ineed_prareg"])?$dataHead["ineed_prareg"]:"";
   
    $get=$this->input->get();
    ?>
    <script>
<?php
       if($iupb_id!="0" && $iappbusdev_registrasi==2 && $iprareg_ulang_reg==0 && $iprareg_ulang_reg<>""){?>
             $("label[for='v3_reg_applet_form_detail_ireg_ulang']").parent().show();

    <?php }else{ ?>
        $("label[for='v3_reg_applet_form_detail_ireg_ulang']").parent().hide();
    <?php }
if ($iappbd_applet ==2 ){ 
        $arra=array(0=>"Tidak",1=>"Ya");
        $value=isset($arra[$dataHead[$field]])?$arra[$dataHead[$field]]:"-";
        ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
      <?php } if($ineed_prareg==0 && $iupb_id!="0" && $iappbusdev_registrasi==2 && $iprareg_ulang_reg==0&& $iprareg_ulang_reg<>""){?>
        $("#<?php echo $id; ?>").parent().parent().show();
      <?php }?>
      $("#<?php echo $id ?>").change(function(){
            var v = $(this).val();
            if(v=="1"){
                $("label[for='v3_reg_applet_form_detail_imutu_reg']").parent().show();
                if($("#v3_reg_applet_form_detail_imutu_reg").val()==0){
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().show();
                }else{
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().hide();
                }
                $("#v3_reg_applet_form_detail_imutu_reg").val("");
                $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_vnie']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_iHasil_registrasi']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_iPic_Prareg_req_doc']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().hide();
            }else{
                $("label[for='v3_reg_applet_form_detail_imutu_reg']").parent().hide();
                 $("label[for='v3_reg_applet_form_detail_iHasil_registrasi']").parent().show();
                $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_iPic_Registrasi_req_doc']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().hide();
                $("#v3_reg_applet_form_detail_imutu_reg").val("");
                $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").parent().show();
                $("label[for='v3_reg_applet_form_detail_vnie']").parent().show();
                $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").parent().show();
                $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().show();
            }
        });
      </script>


<!-- add by mansur  -->

    
        <?php 
            if($iupb_id==0){
                ?>
                <script>            
                    $("#v3_reg_applet_tbayar_reg").parent().parent().next().next().next().next().hide();
					$("#<?php echo $id ?>").parent().parent().remove();
                </script>
                <?php 
			}
        ?>
    

<?php 
	/* mansur 2019-04-27 
			cek tambahan data sudah done semua baru munculkan isian tanggal HPR 
	*/
	$this->load->library('auth');

		$type='';
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}elseif(in_array('QA', $manager)){
				$type='QA';
			}elseif(in_array('PAC', $manager)){
				$type='PAC';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
				}elseif(in_array('PD', $team)){
					$type='PD';
				}elseif(in_array('QA', $team)){
					$type='QA';
				}elseif(in_array('PAC', $team)){
					$type='PAC';
				}
				else{$type='';}
			}
		}
			// cek apakah UPB butuh tambahan data
			$sqlcekbutuh = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$iupb_id.'"';
			$upebeh = $this->db_plc0->query($sqlcekbutuh)->row_array();
			$itambahan_applet =isset($upebeh['itambahan_applet'])?$upebeh['itambahan_applet']:"-";
            
			if($itambahan_applet==1){
				/* jika butuh tambahan data , maka pastikan semua tambahan data dan Done  */
				$sqlcekdokTambahDone = '
					select count(*) as jumlah 
					from plc2.hprfile3 a 
					join plc2.hprfile2 b on b.ihprfile2=a.ihprfile2
					join plc2.hprfile1 c on c.ihprfile1=b.ihprfile1
					where 
					a.ldelete=0
					and b.ldelete=0
					and c.ldelete=0
					and c.iupb_id = "'.$iupb_id.'"
				';
				
				$dJumfile = $this->db_plc0->query($sqlcekdokTambahDone)->row_array();

				$sqlcekdokTambahDone .= ' and a.iDone=0';
				$dudahdone = $this->db_plc0->query($sqlcekdokTambahDone)->row_array();

					//echo $dJumfile['jumlah'].' -- '.$dudahdone['jumlah'];

					if($dJumfile['jumlah'] < 1 or $type <> 'BD'){
						//echo	"okeh ajah";
				?>	
						<script>
							//alert("okeh");
							$("#v3_prareg_hpr_ttarget_hpr").removeClass('required');
							$("#v3_prareg_hpr_ttarget_hpr").parent().hide();
							
 							$("#v3_prareg_hpr_iprareg_ulang_prareg").removeClass('required');
							$("#v3_prareg_hpr_iprareg_ulang_prareg").parent().hide();

							$("#button_update_submit_v3_prareg_hpr").hide();

						</script>

				
				<?php
					}

					if($dudahdone['jumlah'] > 0 or $type <> 'BD'){
						//echo	"okeh ajah";
				?>	
						<script>
							//alert("jumlah done");
							$("#v3_prareg_hpr_ttarget_hpr").removeClass('required');
							$("#v3_prareg_hpr_ttarget_hpr").parent().hide();
							
 							$("#v3_prareg_hpr_iprareg_ulang_prareg").removeClass('required');
							$("#v3_prareg_hpr_iprareg_ulang_prareg").parent().hide();

							$("#button_update_submit_v3_prareg_hpr").hide();

						</script>

				
				<?php
					}

					

			}else{

                ?>
                    <script>
						<?php
						if($iupb_id!="0" && $iappbusdev_registrasi==2 && $iprareg_ulang_reg==0 && $iprareg_ulang_reg<>""){?>

    <?php }else{ ?>
                        $("#v3_reg_applet_tbayar_reg").parent().parent().next().next().next().next().hide();
	<?php }
	?>
                    </script>
            <?php
            }

?>
