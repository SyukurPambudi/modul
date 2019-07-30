<style>
.table {
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:10px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
.table th {
	padding:10px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
.table th:first-child {
	padding-left:10px;
	border-left: 0;
}
.table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.table tr {
	text-align: left;
	padding-left:10px;
}
.table td:first-child {
	text-align: center;
	padding-left:10px;
	border-left: 0;
}
.table td {
	padding:5px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
</style>

<table cellspacing='0' width="99%" class="table"> <!-- cellspacing='0' is important, must stay -->

	<!-- Table Header -->
	<thead>
		<tr>
			<th rowspan="2" width="20px">No</th>
			<th rowspan="2" colspan="2">Kepemimpinan</th>
			<th colspan="2" width="60px">Point Penilaian Oleh</th>
			<th rowspan="2" width="50px">Point Sepakat atau Point (a+b)/2</th>
			<th rowspan="2" width="50px">Bobot</th>
			<th rowspan="2" width="50px">Nilai (Point X Bobot)</th>
		<tr>
			<th style="border-left: 1px solid #e0e0e0;" width="35px">Karyawan (a)</th>
			<th width="30px">Atasan (a)</th>
		<tr>
	</thead>
	<!-- Table Header -->

	<!-- Table Body -->
	<tbody>
	<?php
	$this->database = $this->load->database('plc', true);
	$sql1="select * from pk.pk_nilai ni
		inner join pk.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
		where ni.idmaster_id=".$id." and ni.ikategori_id=3 and pa.ldeleted=0 and ni.lDeleted=0";
	$dtni=$this->database->query($sql1)->result_array();
	$i=1;
	$nilaitot=array();
	foreach ($dtni as $key => $val) {
		$sql2="select * from pk.pk_parameter_detail padet
			inner join pk.pk_kategori kat on kat.ikategori_id=padet.kategori_id
			where padet.iparameter_id=".$val['iparameter_id']." and padet.ldeleted=0 and padet.kategori_id=3 and kat.ldeleted=0";
		$query=$this->database->query($sql2);
		$jrow=$query->num_rows();
		$r=$jrow+1;
		echo "<tr>";
		echo "<td rowspan='".$r."' style='vertical-align:top;'>".$i."</td>";
		echo "<td style='text-align: left;' colspan='2';background:'#EFEFEF';font-weight:bold;>".$val['parameter']."</td>";
		echo "<td rowspan='".$r."'>".$val['poin']."</td>";
		echo "<td rowspan='".$r."'>".$val['poin_sepakat']."</td>";
		$ab=($val['poin']+$val['poin_sepakat'])/2;
		echo "<td rowspan='".$r."'>".$ab."</td>";
		$bobot=$val['poin_bobot']*100;
        $nPoint = $val['poin_bobot'] * $val['poin_sepakat_atasan'];
		echo "<td rowspan='".$r."'>".$bobot."%</td>";
		echo "<td rowspan='".$r."'>".$nPoint."</td>";
		echo "</tr>";
		foreach ($query->result_array() as $k => $nidet) {
			echo "<tr>";
			echo "<td style='text-align: left;border-left: 1px solid #e0e0e0;'>".$nidet['deskripsi']."</td>";
			echo "<td>".$nidet['poin']."</td>";
			echo "</tr>";
		}
		$nilaitot[]=$nPoint;
		$i++;
	}
	?>
	<tr style="padding:10px;border-top:1px solid #fafafa;border-bottom:1px solid #e0e0e0;border-left: 1px solid #e0e0e0;text-align: center;font-weight:bold;">
		<td colspan="7">Nilai akhir Aspek Kepemimpinan</td>
		<td ><?php echo array_sum($nilaitot); ?></td>
	</tr>
	</tbody>
	<!-- Table Body -->

</table>