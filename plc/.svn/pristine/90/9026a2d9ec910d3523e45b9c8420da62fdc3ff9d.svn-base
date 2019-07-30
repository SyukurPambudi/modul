 
<body style="font-family: serif; font-size: 14px;">
<style>

.table1 {
    color: #000;
    border-collapse: collapse;
}
 
.dddd tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table1, .table1 th, .table1 td {
    text-align: left;
    border: 1px solid #BBB;
}

.table1 tbody tr:nth-child(even) {
    background-color: #f2f5f7;
}
.table1 thead tr td{
	background: #35A9DB;
     color: #fff;
    font-weight: normal;
    text-align: center;
}

.tablechild {
	color: #000;
    border-collapse: collapse;
}
.tablechild tr td{
    font-weight: normal;
    text-align: left;
}
</style>

<?php
$this->load->view('template/js/jquery_datatables_js'); 
$this->load->view('template/css/jquery_datatables_css'); 

?>
<script type="text/javascript">
    $('#example').DataTable( {
        "columnDefs": [ {
            "visible": false, 
        } ],
        "scrollY": '50vh',
        "scrollX": true,
        "paging": false

    } ); 
    $('#example_filter').hide(); 

     
    
    //$('#example_wrapper').hide(); 
</script>


<div style='width:100%;'>
<div width='100%' align="center" style="font-size: 16px;"><b>Laporan History Setting Prioritas</b></br><br></div>
<table border="1" id="example" class="display dddd" cellspacing="0" width="100%" >
	<thead>
		<tr>
			<th rowspan="2" width="10%">No UPB</th>
			<th rowspan="2" width="50%">Nama Usulan</th>
			<th colspan="4" width="50%">History Setting Prioritas</th>  
		</tr>
		<tr>
			<th>Tahun</th>
			<th>Semester</th>
			<th>Team Busdev</th>
			<th>Tanggal Approval</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$ar = array();
			$tampung = "";
			$i=0;
			foreach ($rowdata as $row) {
				 echo '<tr>';
				 echo '<td rowspan="'.$row['row'].'" >'.$row['vupb_nomor'].'</td>';
				 echo '<td rowspan="'.$row['row'].'" >'.$row['vupb_nama'].'</td>';

				 $sql = $query." AND p.iupb_id=".$row['iupb_id']." ORDER BY p2.`iyear`"; 

				 $data = $this->db_plc0->query($sql)->result_array();
				 $i = 0;
				 $min = $row['row']-1;
				 foreach ($data as $dt) {
				 	 
					 	 echo '<td>'.$dt['iyear'].'</td>';
					 	 echo '<td style="text-align:center">'.$dt['imonth'].'</td>'; 
					 	 
					 	 $sqTeam = "SELECT p.`vteam` FROM plc2.`plc2_upb_team` p WHERE p.`iteam_id` = '".$dt['iteambusdev_id']."'";
					 	 $team = $this->db_plc0->query($sqTeam)->row_array(); 
					 	 
					 	 echo '<td>'.$team['vteam'].'</td>';
					 	 echo '<td>'.$dt['tappbusdev'].'</td>';
					 	 $i++;

				 	 if($row['row']>1 && $i==$row['row']){
				 	 	 echo '</tr>';
				 	 }
				 	 if($row['row']>1){
				 	 	echo '</tr>';
				 	 	echo '<tr>';
				 	 }


				 	 
				 }
				 echo '</tr>';
			}

		?>
	</tbody>
	 
</table>
</div>
</body>