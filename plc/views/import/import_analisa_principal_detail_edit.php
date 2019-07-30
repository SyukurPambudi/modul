<div id="detail_principal">
		<span id="bt_add">Tambah</span> | 
<span id="bt_remove">Remove</span>
<table border="1" style="border-collapse: collapse;">
	<tbody>

		<tr id="nomor">
			<td>No</td>
			<td class="rec">1</td>
		</tr>
		<tr id="nama">
			<td>Nama</td>
			<?php 
				$sql_nam='select * from plc2.analisa_prinsipal a where a.iupi_id=4 ';
				$dnama =$this->db_plc0->query($sql_nam)->result_array();

				foreach ($dnama as $inama ) {
			 ?>
				<td class="rec"><input name="nama[]" value='<?php echo $inama['nama'] ?>'></td>

			<?php } ?>
		</tr>
		<tr id="email">
			<td>Email</td>
			<?php 
				$sql_email='select * from plc2.analisa_prinsipal a where a.iupi_id=4 ';
				$demail =$this->db_plc0->query($sql_email)->result_array();

				foreach ($demail as $iemail ) {
			 ?>
				<td class="rec"><input name="email[]" value='<?php echo $iemail['email'] ?>'></td>

			<?php } ?>

		</tr>
		<tr id="sudah">
			<td>Sudah Berhasil</td>
			<td class="rec"><input name="sudah[]" ></td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
	$("#bt_add").die();
	$("#bt_add").live('click',function(){
		//alert('lol');
		$("#nomor").append('<td>2</td>');
		$("#nama").append('<td><input name="nama[]"></td>');
		$("#email").append('<td><input name="email[]"></td>');
		$("#sudah").append('<td><input name="sudah[]"></td>');
		//$("#nama").append('<input name="text">');

		//$('table tr').each(function(){
			//$(this).clone().appendTo( ".goodbye" )
			//$(this).find('td:last').addClass('kampret');
		//	$(this).find('td:last').append('<td><input name="text"></td>');
		//});

	});

	$("#bt_remove").die();
	$("#bt_remove").live('click',function(){

			$('#nomor').find('td:last').remove();
			$('#nama').find('td:last').remove();
			$('#email').find('td:last').remove();
			$('#sudah').find('td:last').remove();

	});
</script>

</div>

