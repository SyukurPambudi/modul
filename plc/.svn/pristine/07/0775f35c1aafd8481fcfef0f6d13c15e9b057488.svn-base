<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 120%; border: 1px solid #dddddd; text-align: center; margin-left: -180px;  margin-top: 30px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">History Tambahan Data</span></th>
	</tr>
	<?php 
		 $this->load->helper('to_mysql');
		 $qr="select td.id_td, td.iupb_id,DATE_FORMAT(td.tTamb_Data_td,'%d-%m-%Y') as tTamb_Data_td, 
					DATE_FORMAT(td.tSub_TD_td,'%d-%m-%Y') as tSub_TD_td, 
					DATE_FORMAT(td.tSub_Dok_AppLet_td,'%d-%m-%Y') as tSub_Dok_AppLet_td, 
					DATE_FORMAT(td.tTD_AppLet_td,'%d-%m-%Y') as tTD_AppLet_td 
				from plc2.plc2_upb_reg_td td
				where td.iupb_id=1341 and td.ldeleted=0";
		 $nums=$this->db_plc0->query($qr)->num_rows();
		 if($nums==0){echo '<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
								<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Tidak Ada History</span></th>
							</tr>';}
		 else{
		 echo '<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
					<th style="border: 1px solid #dddddd;">Tgl TD</th>
					<th style="border: 1px solid #dddddd;">Tgl Submit TD</th>
					<th style="border: 1px solid #dddddd;">Tgl Submit Dok.AppLet</th>
					<th style="border: 1px solid #dddddd;">Tgl TD AppLet</th>
					<th style="border: 1px solid #dddddd;">Memo TD</th>
					<th style="border: 1px solid #dddddd;">Divisi</th>
				</tr>
				</thead>';
		 $row=$this->db_plc0->query($qr)->result_array();
		 foreach($row as $rows){
			
		 //print_r($row);
	?>
	<tbody>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width:90px;" valign="top">
				<?php echo $rows['tTamb_Data_td'];?>
			</td>
			<td style="border: 1px solid #dddddd; width:90px;" valign="top">
				<?php echo $rows['tSub_TD_td'];?>
			</td>
			<td style="border: 1px solid #dddddd; width:90px;" valign="top">
				<?php echo $rows['tSub_Dok_AppLet_td'];?>
			</td>
			<td style="border: 1px solid #dddddd; width:90px;"valign="top">
				<?php echo $rows['tSub_Dok_AppLet_td'];?>
			</td>
			<td valign="top" style="border: 1px solid #dddddd; width: 150px">
				<?php 
				$id_td=$rows['id_td'];
				$qf="select * from plc2.plc2_upb_file_reg_td tdf
				where tdf.id_td='$id_td' and tdf.ldeleted=0";
				$numsf=$this->db_plc0->query($qf)->num_rows();
				$dfile=$this->db_plc0->query($qf)->row_array();
				if($numsf > 0) {
					if (file_exists('./files/plc/dok_td/'.$id_td.'/'.$dfile['filename'])) {
						$link = base_url().'processor/plc/registrasi/upb?action=download&id='.$id_td.'&dok=dok_td&file='.$dfile['filename'];
						$linknya = $dfile['filename'].'</br><a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
					}
					else {
						$linknya = 'File sudah tidak ada!';
					}
				}
				else {
					$linknya = 'No File';
				}	
				echo $linknya;
				?>
			
			</td>
			<td style="border: 1px solid #dddddd; width: 52%">
			<?php 
				$qd="select * from plc2.plc2_upb_reg_td_detail tdd
				where tdd.id_td='$id_td' and tdd.ldeleted=0";
				$numsd=$this->db_plc0->query($qd)->num_rows();
				$ddetail=$this->db_plc0->query($qd)->result_array();
				
				if($numsd > 0) {
				$s=0;
					foreach($ddetail as $datad){
					$s++;
						if($datad['vDivisi_tujuan']=='PR'){$datad['vDivisi_tujuan']='Purchasing PD';}
						if($datad['vDivisi_tujuan']=='PDV'){$datad['vDivisi_tujuan']='Packdev';}
						if($datad['vDivisi_tujuan']=='QAM'){$datad['vDivisi_tujuan']='QA Mikro';}
						echo '<div>
								<div style="height: 30px; width:15px; float:left; text-align: left; margin-left: 5px">'.$s.'</div>
								<div style="height: 30px; width:75px; float:left; text-align: left; margin-left: 5px">'.$datad['vDivisi_tujuan'].'</div> 
								<div style="height: 30px; width:425px; text-align: left; float:left; margin-left: 5px">
									( Catatan : '.$datad['vCatatan'].' )
								</div>
							</div>';
					}
				}
			?>
			</td>		
		</tr>
	<?php  }
	} ?>
	</tbody>
</table>