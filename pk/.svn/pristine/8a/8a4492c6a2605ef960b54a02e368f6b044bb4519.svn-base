<script type="text/javascript">
	$('.vName_member_div_add1').die();
	$('.vName_member_div_add1').live('click', function() {
		
		var level = $('.master_divisi_iLevel_span').html();
		var row = '<tr><td style="text-align: right"><span class="numberlist"></span></td><td style="text-align: center"><input class="vName_member_div_cNip" name="nip[]" type="hidden" ><input class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td><td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td></tr>';		
		$("span.numberlist:first").text('1');
		var n = $("span.numberlist:last").text();
		var no = parseInt(n);
		var c = no + 1;		
		$('table#vName_member_div_table tbody tr:last').after(row);
		//$("table#vName_member_div_table tbody tr:last td span.effected_action").text("Choose Effected Proses first");
		$("table#vName_member_div_table tbody tr:last input").val("");
		$("span.numberlist:last").text(c);
		//$('.master_divisi_iLevel:last').prop('selectedIndex',0);
	})
	$('.vName_member_div_del').die();
	$('.vName_member_div_del').live('click', function() {
		var dis = $(this);
		custom_confirm('Delete Selected Record?', function(){
			if($('table#vName_member_div_table tbody tr').length == 1) {
				custom_alert('Isi Minimal 1');
			}
			else {
				dis.parent().parent().remove();
			}
		})
	})


</script>
<style type="text/css">
	.ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="box-tambah">
	<div style="float: right"><button type="button" class="icon-tambah vName_member_div_add1">Tambah</button></div>
	<div class="clear"></div>
	<table style="width: 100%" id="vName_member_div_table">
		<thead>
			<tr>
				<th style="width: 2%;"> No. </th>
				<th> Nama </th>
				<!--<th> Level </th>-->
				<!-- <th style="width: 10%;">Approve</th> -->
				<th style="width: 10%;"> Action </th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($member)) {
					if(is_array($member) && count($member) > 0) {
						$n=1;
						foreach($member as $v) {
							// $conf_level = $this->config->item('plc_level');
							// $slevel = '<select name="iLevel[]" class="master_divisi_iLevel">';
							// $slevel .= '<option value="">--select--</option>';
							// foreach($conf_level as $d) {
								// $selected = $d == $v['iLevel'] ? 'selected' : '';
								// $slevel .= '<option '.$selected.' value="'.$d.'">'.$d.'</option>';
							// }
							// $slevel .= '</select>';
			?>
							<tr>
								<td style="text-align: right"><span class="numberlist"><?php echo $n; ?></span></td>
								<td style="text-align: center"><input class="vName_member_div_cNip" value="<?php echo $v['vNip']; ?>" name="nip[]" type="hidden" ><input value="<?php echo $v['vName']; ?> - <?php echo $v['vNip']; ?>" class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td>
								<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $slevel; ?></span></td>-->

								
								<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td>
								
							</tr>
			<?php		$n++;}
					}
					else {
			?>
							<tr>
								<td style="text-align: right"><span class="numberlist">1</span></td>
								<td style="text-align: center"><input class="vName_member_div_cNip" name="nip[]" type="hidden" ><input class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td>
								<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $level; ?></span></td>-->
								

								<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td>

							</tr>
			<?php
					}
				}
				else {
			?>
			<tr>
				<td style="text-align: right"><span class="numberlist">1</span></td>
				<td style="text-align: center"><input class="vName_member_div_cNip" name="nip[]" type="hidden" ><input class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td>
				<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $level; ?></span></td>-->
				
				<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td>
			</tr>

			<?php
				}
			?>
		</tbody>
	</table>	


</div>