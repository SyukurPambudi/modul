<script type="text/javascript">
	$('.vName_member_div2_add2').die();
	$('.vName_member_div2_add2').live('click', function() {
		
		var level = $('.master_divisi_iLevel_span').html();
		var row = '<tr><td style="text-align: right"><span class="numberlist2"></span></td><td style="text-align: center"><input class="vName_member_div2_cNip" name="nipcc[]" type="hidden" ><input class="input_rows-table vName_member_div2" style="width: 98%" name="name[]" type="text" ></td><td style="text-align: center">[ <a href="javascript:;" class="vName_member_div2_del2">Hapus</a> ]</td></tr>';		
		$("span.numberlist2:first").text('1');
		var n = $("span.numberlist2:last").text();
		var no = parseInt(n);
		var c = no + 1;		
		$('table#vName_member_div2_table2 tbody tr:last').after(row);
		//$("table#vName_member_div2_table2 tbody tr:last td span.effected_action").text("Choose Effected Proses first");
		$("table#vName_member_div2_table2 tbody tr:last input").val("");
		$("span.numberlist2:last").text(c);
		//$('.master_divisi_iLevel:last').prop('selectedIndex',0);
	})
	$('.vName_member_div2_del2').die();
	$('.vName_member_div2_del2').live('click', function() {
		var dis = $(this);
		custom_confirm('Delete Selected Record?', function(){
			if($('table#vName_member_div2_table2 tbody tr').length == 1) {
				custom_alert('Isi Minimal 1');
			}
			else {
				dis.parent().parent().remove();
			}
		})
	})

var config = {
		source: base_url+'processor/plc/master/divisi?action=employee_list',					
		select: function(event, ui){
			var i = $('.vName_member_div2').index(this);
			$('.vName_member_div2_cNip').eq(i).val(ui.item.id);						
		},
		minLength: 2,
		autoFocus: true,
	};
	$(".vName_member_div2").livequery(function(){
		$(this).autocomplete(config);
		var i = $('.vName_member_div2').index(this);
		$(this).keypress(function(e){
			if(e.which != 13) {
				$('.vName_member_div2_cNip').eq(i).val('');
			}			
		});
		$(this).blur(function(){
			if($('.vName_member_div2_cNip').eq(i).val() == '') {
				$(this).val('');
			}			
		});
	})

</script>
<style type="text/css">
	.ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="box-tambah">
	<div style="float: right"><button type="button" class="icon-tambah vName_member_div2_add2">Tambah</button></div>
	<div class="clear"></div>
	<table style="width: 100%" id="vName_member_div2_table2">
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
								<td style="text-align: right"><span class="numberlist2"><?php echo $n; ?></span></td>
								<td style="text-align: center"><input class="vName_member_div2_cNip" value="<?php echo $v['vNip']; ?>" name="nipcc[]" type="hidden" ><input value="<?php echo $v['vName']; ?> - <?php echo $v['vNip']; ?>" class="input_rows-table vName_member_div2" style="width: 98%" name="name[]" type="text" ></td>
								<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $slevel; ?></span></td>-->

								
								<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div2_del2">Hapus</a> ]</td>
								
							</tr>
			<?php		$n++;}
					}
					else {
			?>
							<tr>
								<td style="text-align: right"><span class="numberlist2">1</span></td>
								<td style="text-align: center"><input class="vName_member_div2_cNip" name="nipcc[]" type="hidden" ><input class="input_rows-table vName_member_div2" style="width: 98%" name="name[]" type="text" ></td>
								<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $level; ?></span></td>-->
								

								<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div2_del2">Hapus</a> ]</td>

							</tr>
			<?php
					}
				}
				else {
			?>
			<tr>
				<td style="text-align: right"><span class="numberlist2">1</span></td>
				<td style="text-align: center"><input class="vName_member_div2_cNip" name="nipcc[]" type="hidden" ><input class="input_rows-table vName_member_div2" style="width: 98%" name="name[]" type="text" ></td>
				<!--<td style="text-align: center"><span class="master_divisi_iLevel_span"><?php //echo $level; ?></span></td>-->
				
				<td style="text-align: center">[ <a href="javascript:;" class="vName_member_div2_del2">Hapus</a> ]</td>
			</tr>

			<?php
				}
			?>
		</tbody>
	</table>	


</div>