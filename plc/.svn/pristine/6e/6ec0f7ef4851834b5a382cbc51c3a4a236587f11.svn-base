<?php
$noupd="-";
$NamaProduk="-";
$NamaUsulan="-";
$StandarDok="-";
$rselesai="0";
$calldok="0";
$cfinishdok="0";
$cunfinishdok="0";
$persenf="0%";
if($qdatall->num_rows()>=1){
	$noupd=$dataupd['vUpd_no'];
	$NamaProduk=$dataupd['C_ITNAM'];
	$NamaUsulan=$dataupd['vNama_usulan'];
	$StandarDok=$dataupd['jenis'];
	$calldok=$qdatall->num_rows();
	$cfinishdok=$qdataapp->num_rows();
	if($cfinishdok>=1){
		$s=$cfinishdok/$calldok*100;
		$persenf=number_format($s,2)."%";
	}
	$cunfinishdok=$calldok-$cfinishdok;
}
?>
<body style="font-family: serif; font-size: 14px;">
<style>

.table1 {
    color: #444;
    border-collapse: collapse;
}
 
.table1 tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table1, th, td {
    text-align: left;
}

.table1 tr:nth-child(even) {
    background-color: #f2f5f7;
}
.table2 {
    color: #444;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #f2f5f7;
    background-color: #ffffff;
}
 
.table2 tr th tbody{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table2, th, td,tbody {
    padding: 10px 5px;
    text-align: left;
}
.table2 tbody tr:nth-child(even) {
    background-color: #f2f5f7;
}
</style>
<div style='width:100%;'>
<div width='100%' align="center" style="font-size: 14px;"><b>Skema Bentuk Report Aplikasi PLC Dossier (% Penyelesaian & Progress QTY Dokumen)</b></br></div>
<table class="table1" width="100%" >
	<?php 
		echo "<tr>";
		echo "<td>No UPD</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$noupd."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Nama Produk</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$NamaProduk."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Nama Usulan</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$NamaUsulan."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Standar Dokumen</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$StandarDok."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Report % Penyelesaian</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$persenf."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>All Qty Dokumen</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$calldok." Item</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Qty Dokumen Lengkap CK 3 (Approved)</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$cfinishdok." Item</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Qty Dokumen BELUM Lengkap CK 3 (Approved)</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$cunfinishdok." Item</td>";
		echo "</tr>";
	?>
</table>
</div>
</body>