<?php
$this->load->library('lib_calc_ts');
?>
<style>
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
			<th>Actual Start</th>
			<th>Actual Finish</th>
			<th>SLA Rate</th>
			<th>Selisih</th>
			<th>Persentase SLA dan Selisih</th>
		<tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		$row=0;
		$mem=0;
		$sumselisih=array();
			foreach ($datas as $data) {
				$takhir= date('Y-m-d H:i:s', strtotime($data['actual_finish']));
				$tawal= date('Y-m-d H:i:s', strtotime($data['actual_start']));
				$selisih=$this->lib_calc_ts->selisihHari($tawal,$takhir,$nip,'minute');
			
				$mark='';
				if($data['actual_finish']!='' or $data['actual_finish']!=NULL or $data['actual_finish']!='1970-01-01' or $data['actual_finish']!='0000-00-00'){
					$mark=date('Y-m-d H:i:s', strtotime($data['actual_finish']));
					if($mark=='1970-01-01'){
						$mark='';
					}
				}
				$actual='';
				if($data['actual_start']!='' or $data['actual_start']!=NULL or $data['actual_start']!='1970-01-01' or $data['actual_start']!='0000-00-00'){
					$actual=date('Y-m-d H:i:s', strtotime($data['actual_start']));
					if($actual=='1970-01-01'){
						$actual='';
					}
				}
				$dlink=explode("/",base_url());
			    $dlink[3]="ss";
			    $linkss=implode("/",$dlink);
				echo "<tr>";
				echo "<td>".$i."</td>";?>
				<td>
				<a href="javascript:void(0);" title="<?php echo $data['problem_subject']; ?>" 
						onclick="window.open('<?php echo $linkss ?>index.php/rawproblems/detail/<?php echo $data['id']; ?>', '_blank', 
						'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283');">
						<?php echo $data['id'] ?></a>
				</td>	
				<?Php
				echo "<td style='text-align:left'>".$data['problem_subject']."</td>";
				echo "<td>".$actual."</td>";
				echo "<td>".$mark."</td>";
				echo "<td>".$data['iSLARate']."</td>";
				echo "<td>".$selisih."</td>";
				$persen="Tidak Memenuhi";
				if($data['iSLARate']>=$selisih){ //Cek Apabila rate SLA kurang dari durasi pengerjaan - by minute
					$mem++;
					$persen="Memenuhi";
				}
				echo "<td>".$persen."</td>";
				echo "<tr>";

				$i++;
				$row++;
			}
		?>
		
	</tbody>
	<tfooter>
		<tr>
		</tr>
	</tfooter>
</table>
<br>

<?php 
	$hasil=0;
	if($row != 0 and $mem !=0){
		$hasil=$mem/$row*100;
	}
?>

<label class="lbl_detail">Jumlah SSID: <?php echo $row; ?> SSID</label><br>
<label class="lbl_detail">Jumlah SSID Memenuhi Syarat SLA: <?php echo $mem ?> SSID</label><br>
<label class="lbl_detail">Persentase  : <?php echo number_format( $hasil, 2, '.', '' ); ?> %</label>