<?php 
	foreach ($kats as $kat ) {

?>	

	<ul>
		
		<li><?php echo $kat['vNama_Kategori'] ?></li>
			<table class="hover_table" id="brosur_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
				<thead>
				<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
					<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Dokumen Dossier</span></th>
				</tr>
				<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
					<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
					<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Nama <br> Dokumen</th>
					<th colspan="1" style="border: 1px solid #dddddd; width: 10%;">PIC</th>
					<th colspan="1" style="border: 1px solid #dddddd; width: 30%;">Pilih File</th>
					<th colspan="3" style="border: 1px solid #dddddd; width: 5%;">Keterangan</th>
					<th style="border: 1px solid #dddddd; width: 10%;">Action</th>		
				</tr>
				</thead>
				<tbody>
					<?php

					$sql_doc='	select * ,b.idossier_dok_list_id as id_doklis,d.iSubmit_upload
					from dossier.dossier_dokumen a 
					join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					join dossier.dossier_review d on d.idossier_review_id=b.idossier_review_id
					join dossier.dossier_kat_dok e on e.idossier_kat_dok_id=a.idossier_kat_dok_id
					join dossier.dossier_dok_list_file c on c.idossier_dok_list_id =b.idossier_dok_list_id
					where a.lDeleted=0
					and b.lDeleted=0
					and b.idossier_review_id="'.$idossier_review_id.'"
					and e.idossier_kat_dok_id = "'.$kat['idossier_kat_dok_id'].'" 

					';
					$rows = $this->db_plc0->query($sql_doc)->result_array();

			$i = 1;
			$linknya = "";
			if(!empty($rows)) {
				foreach($rows as $row) {
					//tambahan untuk download file
					$id  = $row['idossier_review_id'];
					$value = $row['vFilename'];	
					if($value != '') {
						if (file_exists('./files/plc/dossier_dok/'.$id.'/'.$value)) {
							
							$link = base_url().'processor/plc/download/dokumen/export?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
							
						}
						else {
							$linknya = 'File sudah tidak ada!';
						}
					}
					else {

						$file = 'No File';
					}		

					// variable dokumen
					$tersedia = $row['istatus_keberadaan'];
					$submit_upload = $row['iSubmit_upload'];
			//selesai tambahan download
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="brosur_bb_upload_num"><?php echo $i ?></span>
					</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
						<?php echo $row['vNama_Dokumen'] ?>
					</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">

						<?php 

							if ($tersedia == 1) {
								$value=$row['cPic'] ;
								$sql = 'select * from hrd.employee a	where a.cNip = "'.$value.'"	';
								$rows = $this->db_plc0->query($sql)->row_array();
								echo $rows['vName'];
							
						?>
							
						<?php
							}else{

								$value=$row['cPic'] ;
								$sql = 'select b.cNip,b.vName 
										from plc2.plc2_upb_team_item a 
										join hrd.employee b on a.vnip=b.cNip
										where a.iteam_id = "'.$iTeam_andev.'"
										and a.ldeleted=0
										and b.lDeleted = 0';
								$teams = $this->db_plc0->query($sql)->result_array();
								$o  = "<select id='dossier_upload_dokumen_cPic' class='combobox required' name='cPic[]'>";            
								$o .= '<option value="">--Select--</option>';
					            foreach($teams as $item) {
					                if ($item['cNip'] == $value) $selected = " selected";
					                else $selected = "";
					                $o .= "<option {$selected} value='".$item['cNip']."'>".$item['vName']."</option>";
					            }            
					            $o .= "</select>";

					            echo $o;
					        }

						 ?>

						
					</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
						<input type="hidden" name="iHapus[]" class='lDeleted'style="width: 70%"  />
						<input type="hidden" name="idossier_review_id" style="width: 70%" value="<?php echo $row['idossier_review_id'] ?>" />
						<input type="hidden" name="namafile[]" style="width: 70%" value="<?php echo $row['vNama_Dokumen'] ?>" />
						<input type="hidden" name="doklis_file_id[]" style="width: 70%" value="<?php echo $row['idossier_dok_list_file_id'] ?>" />
						<input type="hidden" name="doklis_id[]" style="width: 70%" value="<?php echo $row['id_doklis'] ?>" />

						<?php 
							if ($tersedia == 1) {
								$value=$row['idossier_dok_list_file_id'] ;
								$sql = 'select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_file_id = "'.$value.'"	';
								$rows = $this->db_plc0->query($sql)->row_array();
								echo $rows['vFilename'];

								
							?>
							
						<?php

							}else{


						 ?>
							<input type="file" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /><br> *max 5 mb
							<input type="hidden" name="idossier_dok_list_id[]" style="width: 70%" value="<?php echo $row['id_doklis'] ?>" />
					        <input type="hidden" name="idossier_dok_list_file_id[]" style="width: 70%" value="<?php echo $row['idossier_dok_list_file_id'] ?>" />
						<?php 
							}
						 ?>
					</td>
					<td colspan="3" style="border: 1px solid #dddddd; width: 10%">
						<?php 
							if ($tersedia == 1) {
								$value=$row['idossier_dok_list_file_id'] ;
								$sql = 'select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_file_id = "'.$value.'"	';
								$rows = $this->db_plc0->query($sql)->row_array();
								echo $rows['vKeterangan'];

							?>
								
						<?php

							}else{


						 ?>
							<textarea class="required" id="filekt1"name="fileketerangan[]" style="width: 240px; height: 50px;"size="250">
							<?php  echo $row['vKeterangan'] ?>
							</textarea>
						<?php 
							}
						 ?>

						
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php echo $linknya ?>
						
					</td>	
				</tr>
		<?php
			$i++;	
				}

			}
			else {

				if ($this->input->get('action') == 'view') {
					//untuk view yang tidak ada file upload sama sekali
				?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td colspan="8"style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span>Tidak ada file diupload</span>
						</td>		
					</tr>

					

				<?php 
				}else{
		
				} }?>


				</tbody>
			</table>
		<br/>
	</ul>


<?php 
	}
?>

 
