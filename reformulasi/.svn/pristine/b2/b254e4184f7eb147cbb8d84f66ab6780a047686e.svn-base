<?php

	$link = base_url().'processor/reformulasi/'.str_replace('_', '/', $controller).'?action=download';
?>

<script type="text/javascript">
	var count = parseInt("<?php echo count($rows); ?>");
	if (count == 0){
		add_row_<?php echo $id; ?>();
	}

	function add_row_<?php echo $id; ?> () {
		var table 	= "<?php echo $id; ?>";
		var num 	= $("span."+table+"_num:last").text();
		var row 	= $('table#'+table+' tbody tr:last').clone();

		var numlast = ( num.length == 0 ) ? 1 : (parseInt(num) + 1);

		var content = '';

		content += '<tr>';
		content += '	<td>';
		content += '		<span class="'+table+'_num">'+numlast+'</span>';
		content += '		<input type="hidden" name="'+table+'_id[]" style="width: 90%;" />';
		content += '	</td>';
		content += '	<td>';
		content += '		<input type="file" id="'+table+'_file_'+numlast+'" class="fileupload multi multifile required" name="'+table+'_file[]" style="width: 90%;" />';
		content += '		<input type="hidden" name="'+table+'_name[]" style="width: 90%;" />';
		content += '	</td>';
		content += '	<td>';
		content += '		<textarea name="'+table+'_keterangan[]" style="width: 90%;" rows="2"></textarea>';
		content += '	</td>';
		content += '	<td>';
		content += '		<span>';
		content += '			<a href="javascript:;" class="'+table+'_del" onclick="del_row(this, \''+table+'_del\')">[ Hapus ]</a>';
		content += '		</span>';
		content += '	</td>';
		content += '</tr>';

		jQuery("#"+table+" tbody").append(content);

		$('#'+table+'_file_'+numlast).change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table, 1, 20000);
	        	$(this).val('');
	        }
	    });
	}
</script>

<style type="text/css">
	#<?php echo $id; ?>{ 
		border 			: 2px #A1CCEE solid;
		padding 		: 5px;
		background 		: #fff;
		border-radius 	: 5px;
		width   		: 99%;
		margin 			: 5px;
	}

	#<?php echo $id; ?> thead tr th{    
		border 			: 1px solid #89b9e0;
	    text-align 		: center;
	    color 			: #FFFFFF;
	    background 		: -webkit-gradient(linear, left top, left bottom, from(#1e5f8f), to(#3496df)) repeat-x;
	    background 		: -moz-linear-gradient(top, #1e5f8f, #3496df) repeat-x;
	    text-transform 	: uppercase; 
	    padding 		: 5px;
	}

	#<?php echo $id; ?> tbody tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	#<?php echo $id; ?> tbody tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}

	#<?php echo $id; ?> tfoot tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	#<?php echo $id; ?> tfoot tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}
</style>

<table id="<?php echo $id; ?>">
	<input type="hidden" class="required" name="id_form_upload" value="<?php echo $id; ?>" />
	<input type="hidden" class="required" name="iM_modul_fields" value="<?php echo $dokumen['iM_modul_fields']; ?>" />
	<thead>
		<tr>
			<th colspan="4">Upload File</th>
		</tr>
		<tr>
			<th style="width: 10px;">No.</th>
			<th>File</th>
			<th>Keterangan</th>
			<th style="width: 120px;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if (count($rows) > 0){
				foreach ($rows as $num => $row) {
					$idsp  = $row['idHeader_File'];
					$value = $row['vFilename_generate'];
					$path  = $dokumen['filepath'];

					$linknya = 'No File';
					if ( $value != "" ){
						$url = $link.'&id='.$idsp.'&path='.$path.'&file='.$value;
						if (file_exists('./'.$path.'/'.$idsp.'/'.$value)){
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$url.'\'">Download</a>';
						} else {
							$linknya = 'File Not Found';
						}
					}

					?>
						<tr>
							<td>
								<span class="<?php echo $id; ?>_num"><?php echo ($num + 1); ?></span>
								<input type="hidden" name="<?php echo $id; ?>_id[]" value="<?php echo $row['iFile']; ?>" style="width: 90%;" />
							</td>
							<td>
								<input type="hidden" name="<?php echo $id; ?>_name[]" value="<?php echo $row['vFilename']; ?>" style="width: 90%;" />
								<?php echo $row['vFilename'] ?> 
							</td>
							<td>
								<input type="hidden" name="<?php echo $id; ?>_keterangan[]" value="<?php echo $row['tKeterangan']; ?>" style="width: 90%;" />
								<?php echo $row['tKeterangan'] ?>
							</td>
							<td>
								<span>
									<?php echo $linknya; ?>
									<a href="javascript:;" class="<?php echo $id; ?>_del" onclick="del_row(this, '<?php echo $id; ?>_del')">[ Hapus ]</a>
								</span>
							</td>
						</tr>
					<?php
				}
			} 
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td>
			<td>
				<a href="javascript:;" onclick="javascript:add_row_<?php echo $id; ?>()">[ Tambah ]</a>
			</td>
		</tr>
	</tfoot>
</table>