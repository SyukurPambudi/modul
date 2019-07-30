 
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
        } ],
        "scrollY": '50vh',
        "scrollX": true,
        "paging": false

    } ); 
    $('#example2_filter').hide(); 

     
    
    //$('#example_wrapper').hide(); 
</script>


<div style='width:100%;'>
	<hr>
<div width='100%' align="center" style="font-size: 16px;"><b>History Activity UPB</b></br><br></div>
<table border="1" id="example2" class="display dddd" cellspacing="0" width="100%" >
	<thead>
		 <tr>
					<th >No UPB</th>
					<th >Nama Usulan</th>
			<?php 
				foreach ($datas as $dModul ) {
			?>
			 		<th ><?php echo $dModul['vNama_modul'].' - '.$dModul['idprivi_modules'] ?></th>
			<?php 
				}
			?>
		</tr> 
	</thead>
	<tbody>
			<?php 
				foreach ($row as $kr => $vr) {
					

			?>
				<tr>
					<td><?php echo $vr['vupb_nomor'] ?></td>
					<td><?php echo $vr['vupb_nama'] ?></td>

						<?php 
							foreach ($datas as $dModul) {
								/*get log activity modul from upb*/
								$this->load->library('lib_plc');
								$histActivity = $this->lib_plc->getHistoryActivityUPB($dModul['idprivi_modules'],$vr['iupb_id']);
						?>
							<td valign="top">
		                        <table class="hover_table" style="width:100%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
		                            <thead>
		                                <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		                                    <th style="border: 1px solid #dddddd;">Activity Name</th>
		                                    <th style="border: 1px solid #dddddd;">Status</th>
		                                    <th style="border: 1px solid #dddddd;">at</th>      
		                                    <th style="border: 1px solid #dddddd;">by</th>      
		                                    <th style="border: 1px solid #dddddd;">Remark</th>      
		                                </tr>
		                            </thead>
		                            <tbody>
		                            	<?php echo $histActivity; ?>
                            		</tbody>
                        		</table>
							</td>

						<?php 
							}
						?>
				</tr>


			<?php 
				} //end foreach
			?>
	</tbody>
</table>
</div>
</body>