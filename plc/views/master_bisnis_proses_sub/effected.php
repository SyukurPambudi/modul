<style type="text/css">
	.ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="box-tambah">
	<div style="float: right"><button type="button" class="icon-tambah effected_div_add">Tambah</button></div>
	<div class="clear"></div>
		<table style="width: 100%" id="vName_member_div_table">
			<thead>
				<tr>
					<th style="width: 2%;">No.</th>
					<th>When Action =></th>
					<th>Effected For</th>				
					<th>Logic</th>
					<th>Send Alert</th>
					<th style="width: 10%;">Delete</th>
				</tr>
			</thead>
			<tbody>
	<?php
		if(count($effecs_proses) > 0) {
			$i=1;
			foreach($effecs_proses as $e) {
	?>
				<tr>
					<td style="text-align: right"><span class="numberlist"><?php echo $i; ?></span></td>
					<td style="text-align: center">
						<span class="effected_action">
							<select name="action[]">
								<option value="">--Select--</option>
							<?php
								foreach($actions as $a) {
									$selected = $a['idplc_status'] == $e['idplc_status'] ? 'selected' : '';
									echo '<option '.$selected.' value="'.$a['idplc_status'].'">'.$a['vCaption'].'</option>';
								}
							?>
							</select>
						</span>
					</td>
					<td style="text-align: center">
						<select class=" effected_proses" name="sub_proses[]">
							<option value="">-- None --</option>';
						<?php
							foreach($rows as $r) {
								$selected = $r['idplc_biz_process_sub'] == $e['iAffectedProcess'] ? 'selected' : '';
								echo '<option '.$selected.' value="'.$r['idplc_biz_process_sub'].'">'.$r['vName'].' > '.$r['vStepName'].' > '.$r['vActivityName'].' ('.$r['vCode'].')</option>';
							}
						?>
						</select>
					</td>				
					<td style="text-align: center">
						<select name="logic[]" class="">
						<?php
							foreach($logics as $l) {
								$selected = $l == $e['cUsedLogic'] ? 'selected' : '';
								echo '<option '.$selected.' value="'.$l.'">'.$l.'</option>';
							}
						?>
						</select>
					</td>
					<td style="text-align: center">
						<select name="alert[]" class="">
							<?php
								if($e['isSendAlert'] == 1) {
							?>
									<option value="0">No</option>
									<option selected="selected" value="1">Yes</option>
							<?php
								}
								else {
							?>
									<option selected="selected" value="0">No</option>
									<option value="1">Yes</option>
							<?php	
								}
							?>							
						</select>
					</td>
					<td style="text-align: center">[ <a href="javascript:;" class="effected_proses_del">Hapus</a> ]</td>
				</tr>
	<?php
				$i++;
			}
		}
		else {
	?>
		
				<tr>
					<td style="text-align: right"><span class="numberlist">1</span></td>
					<td style="text-align: center">
						<span class="effected_action">
							<select name="action[]">
								<option value="">--Select--</option>
							<?php
								foreach($actions as $a) {
									echo '<option value="'.$a['idplc_status'].'">'.$a['vCaption'].'</option>';
								}
							?>
							</select>
						</span>
					</td>
					<td style="text-align: center">
						<select class=" effected_proses" name="sub_proses[]">
							<option value="">-- None --</option>';
						<?php
							foreach($rows as $r) {
								echo '<option value="'.$r['idplc_biz_process_sub'].'">'.$r['vName'].' > '.$r['vStepName'].' > '.$r['vActivityName'].' ('.$r['vCode'].')</option>';
							}
						?>
						</select>
					</td>				
					<td style="text-align: center">
						<select name="logic[]" class="">
						<?php
							foreach($logics as $l) {
								echo '<option value="'.$l.'">'.$l.'</option>';
							}
						?>
						</select>
					</td>
					<td style="text-align: center">
						<select name="alert[]" class="">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
					</td>
					<td style="text-align: center">[ <a href="javascript:;" class="effected_proses_del">Hapus</a> ]</td>
				</tr>
	<?php
		}
	?>
			</tbody>
		</table>
</div>