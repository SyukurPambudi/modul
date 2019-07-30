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
			<th>Mark Finish</th>
			<th>Satisfaction</th>
			
		<tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		$c=0;
		$satis=array();
			foreach ($datas as $data) {				
				$mark='';
				if($data['tMarkedAsFinished']!='' or $data['tMarkedAsFinished']!=NULL or $data['tMarkedAsFinished']!='1970-01-01' or $data['tMarkedAsFinished']!='0000-00-00'){
					$mark=date('Y-m-d H:m:s', strtotime($data['tMarkedAsFinished']));
					if($mark=='1970-01-01'){
						$mark='';
					}
				}
				$actual='';
				if($data['actual_start']!='' or $data['actual_start']!=NULL or $data['actual_start']!='1970-01-01' or $data['actual_start']!='0000-00-00'){
					$actual=date('Y-m-d H:m:s', strtotime($data['actual_start']));
					if($actual=='1970-01-01'){
						$actual='';
					}
				}
				echo "<tr>";
				echo "<td>".$i."</td>";
				//echo "<td>".$data['id']."</td>";
				?>
				<td><a href="javascript:void(0);" title="<?php echo $data['problem_subject']; ?>" 
					onclick="window.open('http://10.1.49.16/ss/index.php/rawproblems/detail/<?php echo $data['id']; ?>', '_blank', 
					'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283');">
					<?php echo $data['id']; ?></a>
				</td>

				<?php
				echo "<td style='text-align:left'>".$data['problem_subject']."</td>";
				echo "<td>".$actual."</td>";
				echo "<td>".$mark."</td>";
				echo "<td>".$data['satisfaction_value']."</td>";

				$satis[]=$data['satisfaction_value'];
				echo "<tr>";

				$i++;
				$c++;
			}
		?>
		
	</tbody>
	<tfooter>
		<tr><td colspan="5">Jumlah Satisfaction</td>
			<td><?php echo array_sum($satis); ?> </td>
		</tr>
	</tfooter>
</table>
<br>

<?php 
	if ($c<>0) {
		$pembilang = array_sum($satis);	
		$rat=0;
		if($pembilang!=0){
			$rat=number_format(($pembilang/6),2);
		}
	}else{
		$pembilang =0; 
		$rat=0;
	}
?>

<label class="lbl_detail">Jumlah Satisfaction: <?php echo $pembilang; ?></label><br>
<label class="lbl_detail">Jumlah / 6  : <?php echo number_format( $rat, 2, '.', '' ); ?></label>