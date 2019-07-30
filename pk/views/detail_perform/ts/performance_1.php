<?php
$this->load->library('lib_calc_ts');
?>
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
<?php 
$jenis=array(1=>'FeedBack',2=>'Assigment',3=>'Follow up',4=>'Validation', 5=>'Unfinish', 6=>'Rework v&v', 7=>'Confirm', 8 =>'Documentation Verification', 9=>'Documentation Confirm', 70=>'rejected', 71=>'Approve', 50=>'accepted', 52=>'postpone', 53=>'rejected', 59=>'acceptance error', 60=>'submit schedule', 61=>'approve schedule', 62=>'execution schedule', 63=>'aggreed schedule', 99=>'joblog', 98=>'sizing');
?>
<label class="lbl_detail">Details Per Task</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor SSID</th>
			<th>Problem Subject</th>
			<th>Comment Type</th>
			<th>Date Post</th>
			<th>Actual Finish</th>
			<th>Selisih</th>
		<tr>
	</thead>
	<tbody>

		
			<?php
			$i=1;
			$c=0;
			$sumselisih=array();
			if($datas->num_rows>=1){
				foreach ($datas->result_array() as $r => $data) {
					//Menghitung Selisih
					$date_posted = $data['date_posted'];
					$s=$this->lib_calc_ts->selisihHari($date_posted, $data['actual_finish'], $nippemohon,'minute');
					//mencari hari 
					$jmlhr = floor($s/1440);
					$sisahr = $s%1440;
					
					//mencari jam
					$jmljam = floor($sisahr/60);
					$sisajam = $sisahr%60; //sisa dari menit

					$selisih=$jmlhr." Hari ".$jmljam. " Jam ".$sisajam." Menit";
				    $mn[]=$s;
				    $dlink=explode("/",base_url());
				    $dlink[3]="ss";
				    $linkss=implode("/",$dlink);
					echo "<tr>";
					echo "<td>".$i."</td>";?>
					<td>
					<a href="javascript:void(0);" title="<?php echo $data['problem_subject']; ?>" 
						onclick="window.open('<?php echo $linkss ?>index.php/rawproblems/detail/<?php echo $data['id']; ?>', '_blank', 
						'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283');">
						<?php echo $data['id'] ?></a></td>
						<?php
					echo "<td style='text-align:left'>".$data['problem_subject']."</td>";
					echo "<td>".$jenis[$data['commentType']]."</td>";
					echo "<td>".$date_posted."</td>";
					echo "<td>".$data['actual_finish']."</td>";
					echo "<td>".$selisih."</td>";
					echo "<tr>";

					$i++;
					$c++;
				}
			}
			?>
		
	</tbody>
	<tfooter>
		<tr><td colspan="6">Jumlah</td>
			<td><?php 
			if($datas->num_rows>=1){
			echo number_format(array_sum($mn)/1440,2); ?> <br /> <?php
			$jmlhr1 = floor(array_sum($mn)/1440);
			$sisahr1 = array_sum($mn)%1440;
			//mencari jam
			$jmljam1 = floor($sisahr1/60);
			$sisajam1 = $sisahr1%60; //sisa dari menit
			echo $jmlhr1." Hari ".$jmljam1. " Jam ".$sisajam1." Menit";
			}
			else{
				echo "0 Hari 0 Jam 0 Menit";
			}
			?></td>
		</tr>
	</tfooter>
</table>
<br>

<?php 
	if ($c<>0) {
		$pembilang = number_format(array_sum($mn)/1440,2);	
		$penyebut = count($mn);
		$rat=number_format(($pembilang/$penyebut),2);
	}else{
		$pembilang =0; 	
		$penyebut = 0;
		$rat=0;
	}
?>

<label class="lbl_detail">Jumlah selisih : <?php echo $pembilang; ?></label><br>
<label class="lbl_detail">Jumlah SSID Memenuhi Syarat : <?php echo $penyebut ?> SSID</label><br>
<label class="lbl_detail">Rata - Rata  : <?php echo number_format( $rat, 2, '.', '' ); ?> Hari</label>