<?php $path="uji_lab_histori_detail"; ?>
<script>
/* DOM */
window
  .document
  .body

/* CLICK */

.addEventListener( "click", function( event ) {
  var oTarget = event.target;

 /* FOR input[type="checkbox"] */


</script>
<div class="details" style="width:100%; overflow:auto;"; ?>
<?php foreach ($rows as $key) {
	$vn = $key['iujilab_id'];
}
?>
<div id="create_<?php echo $path.$vn?>" class="margin_0">
	<div style="overflow:auto; max-width:1580px">
		<table class="hover_table" id="table_create_<?php echo $path.$vn ?>" cellspacing="0" cellpadding="1" style="width: 160%; border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
			<thead>
			<tr style="width: 160%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
				<th style="border: 1px solid #dddddd; width: 25%;">Surat Penawaran Lab</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Parameter Pemeriksaan</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Bukti Pembayaran Lab</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Hasil Pemeriksaaan</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td style="border: 1px solid #dddddd; width: 25%;">
				<?php foreach ($penawaran as $a) {

					$id  = $a['iujilab_id'];
					$value = $a['vFilesuratpenawaran'];	
					if($value != '') {
						if (file_exists('./files/plc/surat_penawaran/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/import/uji/labs?action=downloadad&id='.$id.'&filead='.$value;
							echo $value.' || <a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a><br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
						else {
							echo $value.' || File sudah tidak ada!<br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
					}
					else {
						echo 'No File<br>';
					}/*
					$id1 = $a['ifilesuratpenawaran_id'];
					echo $a['vFilesuratpenawaran'];*/
				}?>
				</td>
				<td style="border: 1px solid #dddddd; width: 25%;">
				<?php foreach ($paramate as $b) {
					$id  = $b['iujilab_id'];
					$value = $b['vFileparameterperiksa'];	
					if($value != '') {
						if (file_exists('./files/plc/parameter_pemeriksaan/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/import/uji/labs?action=downloadprm&id='.$id.'&fileprm='.$value;
							echo $value.' || <a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a><br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
						else {
							echo $value.' || File sudah tidak ada!<br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
					}
					else {
						echo 'No File
						';
					}

					/*$id2 = $b['ifileparameterperiksa_id'];
					echo $b['vFileparameterperiksa'];*/
				}?>
				</td>
				<td style="border: 1px solid #dddddd; width: 25%;">
				<?php foreach ($bukti as $c) {
					$id  = $c['iujilab_id'];
					$value = $c['vFilefilebuktibayar'];	
					if($value != '') {
						if (file_exists('./files/plc/bukti_pembayaran/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/import/uji/labs?action=downloadbkt&id='.$id.'&filebkt='.$value;
							echo $value.' || <a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a><br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
						else {
							echo $value.' || File sudah tidak ada!<br>
							<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
					}
					else {
						echo 'No File<br>';
					}

				}?>
				</td>
				<td style="border: 1px solid #dddddd; width: 25%;">
				<?php foreach ($periksa as $d) {
					$id  = $d['iujilab_id'];
					$value = $d['vFilehasilperiksa'];	
					if($value != '') {
						if (file_exists('./files/plc/hasil_uji_labs/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/import/uji/labs?action=downloadhsl&id='.$id.'&filehsl='.$value;
							echo $value.' || <a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Downlolad</a><br><hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
						else {
							echo $value.' || File sudah tidak ada!<br><hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						}
					}
					else {
						echo 'No File <br>';
					}

					/*$id4 = $d['ifilehasilperiksa_id'];
					echo $d['vFilehasilperiksa'];*/
				}?>
				</td>

			</tr>

			</tbody>
			<tfoot>
			</tfoot>	
		</table>			
	</div>
</div>
</div>