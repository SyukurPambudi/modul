 
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
    $('#example2').DataTable( {
        "columnDefs": [ {
            "visible": false,
            "targets": -1
        } ],
        "scrollY": '50vh',
        "scrollX": true,
        "paging": false

    } ); 
    $('#example2_filter').hide(); 

     
    
    //$('#example_wrapper').hide(); 
</script> 
<div style='width:100%;'>
<div width='100%' align="center" style="font-size: 16px;"><b>MIKRO</b></br><br></div>
<div width='100%' align="left" style="font-size: 16px;"><b><?php echo $row['vupb_nomor'].' || '.$row['vupb_nama'] ?></b></br></div>
<table border="1" id="example2" class="display dddd" cellspacing="0" width="100%" >
	<thead>
		 <tr>
			 
			<th colspan="8" >Uji Mikro BB</th>			
			<th colspan="4" >Draft SOI Mikro BB</th> 
			<th colspan="3" >SOI Mikro BB Final</th> 
			       
		</tr> 
		<tr>
			 <th>Jumlah Terima</th>
			 <th>Tgl Mulai Study Literatur</th>
			 <th>Tgl Selesai Study Literatur</th> 
			 <th>Tgl Mulai Pengujian</th>
			 <th>Tgl Selesai Pengujian</th>
			 <th>PIC</th> 
			 <th>Perlu Uji Spesifik</th>
			 <th>Approval Chief Mikro</th>
			 <th>Tgl Mulai Pembuatan Draft</th>  
			 <th>Tgl Selesai Pembuatan Draft </th> 
			 <th>No Draft</th>
			 <th>Approval Draft (Chief QA) </th> 
			 <th>Tgl Mulai Pembuatan Draft</th>
			 <th>Tgl Selesai Pembuatan Draft </th> 
			 <th>Approval Draft (Chief QA)</th> 
		</tr>
		 
	</thead> 
</table>
</div>
</body>