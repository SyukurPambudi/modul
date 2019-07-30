<style>
.lbl_detail{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:10px;
	font-weight: bold;
}
.tb_det {
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:10px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:10px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
.tb_det th {
	padding:10px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
.tb_det th:first-child {
	padding-left:10px;
	border-left: 0;
}
.tb_det tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.tb_det tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.tb_det tr {
	text-align: left;
	padding-left:10px;
}
.tb_det td:first-child {
	text-align: center;
	padding-left:10px;
	border-left: 0;
}
.tb_det td {
	padding:5px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
</style>

<label class="lbl_detail">Details Per Task</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor SSID</th>
			<th>Problem Subject</th>
			<th>Accepted Date</th>
			<th>Date Posted</th>
			<!-- <th>Assigntime</th> -->
			<th>Selisih Jam</th>
		<tr>
	</thead>
	<tbody>

		
			<?php
			$c=0;
			$i=1;
			$x=0;
			//$sumselisih=array();
				foreach ($data1 as $data => $vmain) {
					$this->load->library('lib_calc_ts');
					$id = $vmain['id'];

					$subject = $vmain['problem_subject'];
					$date_posted = $vmain['date_posted'];
					$assignTime = $vmain['assignTime'];
					$actual_start = $vmain['actual_start'];


					if( $vmain['vType'] == 'Joblog' ) {
						$start_duration = (empty($assignTime)||strtotime($assignTime)<strtotime($date_posted))?$date_posted:$assignTime;
						$input_date = $vmain['startDuration'];
					} else {
						$start_def = (empty($assignTime))?$date_posted:$assignTime;
						$start_duration = (empty($vmain['startDuration']))?$start_def:$vmain['startDuration'];					
						$input_date = $vmain['input_date'];
					}
					
					$selisih=($this->lib_calc_ts->selisihJam($start_duration, $input_date, $nippemohon)) *24*3600;
					
	                $time = (strtotime($input_date)-strtotime($start_duration)) - $selisih;

					if($time <=0){
						$durasi = 0;
					}else{
						$durasi = number_format( $time/3600, 2, '.', '' ) ;
					}

					echo "<tr>";
					echo "<td>".$i."</td>";
					//echo "<td>".$id."</td>";
					$dlink=explode("/",base_url());
				    $dlink[3]="ss";
				    $linkss=implode("/",$dlink);
					?>
					
					<td><a href="javascript:void(0);" title="<?php echo $subject; ?>" 
						onclick="window.open('<?php echo $linkss ?>index.php/rawproblems/detail/<?php echo $id; ?>', '_blank', 
						'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283');">
						<?php echo $id; ?></a>
					</td>

					<?php
					echo "<td style='text-align:left'>".$subject."</td>";
					echo "<td>".$input_date."</td>";
					echo "<td>".$start_duration."</td>";
					//echo "<td>".$assignTime."</td>";
					echo "<td>".$durasi."</td>";
					echo "<tr>";

					$c += $durasi;
					$i++;
					$x++;
				}
			?>
		
	</tbody>
	<tfooter>
		<tr>
		<td colspan="5">Jumlah (JAM)</td>
			<td><?php echo $c ?> </td>
		</tr>
	</tfooter>

</table>

<label class="lbl_detail">Jumlah selisih : <?php echo $c; ?></label><br>
<label class="lbl_detail">Jumlah Task : <?php echo $x ?></label><br>
<?php 
	$n = $c/$x;
?>
<label class="lbl_detail">Rata-Rata Kecepatan  : <?php echo number_format( $n, 2, '.', '' ); ?> Jam</label>