<style type="text/css">
	.ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="box-tambah">
	<div style="float: right"><button type="button" class="icon-tambah vName_member_div_add">Tambah</button></div>
	<div class="clear"></div>
	<table style="width: 100%" id="vName_member_div_table">
		<thead>
			<tr>
				<th style="width: 2%;"> No. </th>
				<th> Member </th>
				<th style="width: 10%;"> Action </th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($member)) {
					if(is_array($member) && count($member) > 0) {
						$n=1;
						foreach($member as $v) {	
			?>
							<tr>
								<td style="text-align: right"><span class="numberlist"><?php echo $n; ?></span></td>
								<td style="text-align: center"><input class="vName_member_div_cNip" value="<?php echo $v['cNip']; ?>" name="nip[]" type="hidden" ><input value="<?php echo $v['vName']; ?> - <?php echo $v['cNip']; ?>" class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td>
								<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td>
							</tr>
			<?php		$n++;}
					}
					else {
			?>
							<tr>
								<td style="text-align: right"><span class="numberlist">1</span></td>
								<td style="text-align: center"><input class="vName_member_div_cNip" name="nip[]" type="hidden" ><input class="input_rows-table vName_member_div" style="width: 98%" name="name[]" type="text" ></td>
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
				<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div_del">Hapus</a> ]</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>	
</div>