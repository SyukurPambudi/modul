<?php
$this->load->library('lib_calc');
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
            <th>Size Project</th>
			<th>Finish Date</th>
		<tr>
	</thead>
	<tbody>

		
			<?php
			$i=1;
			$c=0;
            $x=0;
			$sumselisih=array();

			if($datas->num_rows>=1){
				foreach ($datas->result_array() as $r => $data) {
					//Menghitung Selisih
					$date_approval = $data['dclosePm'];
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
                    echo "<td>".$data['iSizeProject']."</td>";
					echo "<td>".$date_approval."</td>";
					
					echo "<tr>";
                    $x = $x + $data['iSizeProject'];
					$i++;
					$c++;
				}
			}
			?>
		
	</tbody>
	<tfooter>
		<tr><td colspan="3">Jumlah Size Project</td>
			<td><?php echo $x ?> </td>
		</tr>
	</tfooter>    
</table>
<br>

<label class="lbl_detail">Jumlah Size : <?php echo $x; ?></label>