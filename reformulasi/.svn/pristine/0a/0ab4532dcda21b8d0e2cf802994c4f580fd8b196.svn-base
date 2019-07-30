<style type="text/css">
.master_data_kat {
	background-color: #ffffff;
	border: 1px solid #cccccc;
	padding: 10px;
}
</style>


<table class="master_data_kat" id="master_kat" style="width: 80%; border: 1px solid #dddddd; text-align: left; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
	<thead>
	<tr style="width: 80%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="3" style="border: 1px solid #dddddd;">
		<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
		File Upload</span></th>
	</tr>
	</thead>
	<tbody>
		<?php 	
			if(!empty($sq_all)){
				$i=1;
				foreach ($sq_all as $v) {

					$id  = $v['iLocal_req_refor'];
					$value = $v['vFilename']; 
					$tempat = 'request_refor';	
					if (file_exists('./files/reformulasi/local/request_refor/'.$id.'/'.$value)) {
						$link = base_url().'processor/reformulasi/local/request/refor?action=download&id='.$id.'&file='.$value.'&path='.$tempat;
						$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>';
					}
					else {
						$linknya = '[File sudah tidak ada!]';
					}
					 	

					 ?>
					 	<tr>
					 		<td>&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $i++?></td>
					 		<td><?php echo $v['vFilename']?></td>
					 		<td><?php echo $linknya?></td>
						</tr>
					 <?php
				} 
			}else{
				?>
					<tr>
					 	<td colspan="3" style="text-align:center">...Tidak ada file upload...</td>
					</tr>
				<?php 
			}

		?>
		 
		
	</tbody>
</table>
 
