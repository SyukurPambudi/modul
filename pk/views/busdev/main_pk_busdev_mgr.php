<div class="tab">
<input type="hidden" name="idmaster_id" value="<?php echo $idmaster_id ?>" id="idmaster_id">
<input type="hidden" name="company_id" value="<?php echo $_GET['company_id'] ?>" id="company_id">
<input type="hidden" name="group_id" value="<?php echo $_GET['group_id']?>" id="group_id">
<input type="hidden" name="modul_id" value="<?php echo $_GET['modul_id'] ?>" id="modul_id">

	<ul>
	<?php
		foreach($team as $t) {
			echo '<li>
					  <a href="#tab-'.$t['ikategori_id'].'">'.$t['kategori'].'</a>
				  </li>';
		}
		if($rowData['vnip']==$this->user->gNIP){
			if(($rowData['iSubmit_Performance']>=2)&&($rowData['iSubmit_Sikap']>=2)
				&&($rowData['iSubmit_Kepemimpinan']>=2)
				&&($rowData['is_confirm']==0)){
			echo '<li>
					  <a href="#tab_last">PROSES AKHIR</a>
				  </li>';
			}else if(($rowData['iSubmit_Performance']>=2)&&($rowData['iSubmit_Sikap']>=2)
				&&($rowData['iSubmit_Kepemimpinan']>=2)
				&&($rowData['is_confirm']==1)){
				echo '<li>
					  <a href="#tab_last">HASIL AKHIR</a>
				  </li>';
			}
		}else{
			if($rowData['is_confirm']==1){
				echo '<li>
					  <a href="#tab_last">HASIL AKHIR</a>
				  </li>';
			}else{
				if($employee['cUpper']==$this->user->gNIP && $rowData['iSubmit_Performance']>=4 && $rowData['iSubmit_Sikap']>=4
				&& $rowData['iSubmit_Kepemimpinan']>=4){
					echo '<li>
					  <a href="#tab_last">PROSES AKHIR</a>
				  </li>';
				}
			}
		}
	?>	
	</ul>
	<?php
		foreach($team as $t) {				
	?>
		<div id="tab-<?php echo $t['ikategori_id'] ?>" class="margin_0">
			<div>
				<?php
					switch ($t['ikategori_id']) {
					case '1':
						echo $tab1;
						break;			
					case '2':
						echo $tab2;
						break;
					case '3':
						echo $tab3;
						break;   
					case '4':
						echo $tab4;
						break;     
					case '8':
						echo $tab5;
						break;                                                                        
					default:
						echo $tab1;
						break;
				}

				?>
			</div>			
		</div>
	<?php
		}
		if($rowData['vnip']==$this->user->gNIP){
			if(($rowData['iSubmit_Performance']>=2)&&($rowData['iSubmit_Sikap']>=2)
				&&($rowData['iSubmit_Kepemimpinan']>=2)&&($rowData['is_confirm']==0)){
				?>
				<div id="tab_last" class="margin_0">
					<div>
						<?php
							echo $tab_karyawan;
						?>
					</div>			
				</div>
				<?php
			}else if(($rowData['iSubmit_Performance']>=2)&&($rowData['iSubmit_Sikap']>=2)
				&&($rowData['iSubmit_Kepemimpinan']>=2)&&($rowData['is_confirm']==1)){
				?>
				<div id="tab_last" class="margin_0">
					<div>
						<?php
							echo $tab_last;
						?>
					</div>
				</div>
				<?php
			}
		}else{
			if($rowData['is_confirm']==1){ ?>
				<div id="tab_last" class="margin_0">
					<div>
						<?php
							echo $tab_last;
						?>
					</div>
				</div>
<?php		}else{
				if($employee['cUpper']==$this->user->gNIP && $rowData['iSubmit_Performance']>=4 && $rowData['iSubmit_Sikap']>=4
				&& $rowData['iSubmit_Kepemimpinan']>=4){
					?>
					<div id="tab_last" class="margin_0">
						<div>
							<?php
								echo $tab_atasan;
							?>
						</div>
					</div>
				<?php
				}
			}
		}
	?>	
</div>