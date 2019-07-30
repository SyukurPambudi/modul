<!--- Bagian Dari JqGrid-->
<table id="<?php echo $table_id; ?>" width="100%"></table> 
<div id="<?php echo $table_id; ?>_pager2"></div>
<?php
$jr=$dquery->num_rows();
$i=0;
$o="";
if($jr>=1){
	foreach ($dquery->result_array() as $kq => $vq) {
		if($i==0){
			$o.='["'.$vq['pic'].'","'.$vq['dmulai'].'", "'.$vq['dselesai'].'"]';
			//$o.='["'.$z.'","","",""]';
		}else{
			$o.=',["'.$vq['pic'].'", "'.$vq['dmulai'].'", "'.$vq['dselesai'].'"]';
			//$o.=',["'.$z.'","","",""]';
		}
		$i++;
	}
}

?>
<script>
	var data = [<?php echo $o ?>];
		$("#<?php echo $table_id; ?>").jqGrid({
		    datatype: "local",
		  	colNames: ["PIC Dossier", "Tanggal Mulai", "Tanggal Selesai"],
		    colModel: [{
		        name: 'pic',
		        index: 'pic',
		        width:400,
				sorttype: "float"},
		    {
		        name: 'dmulai',
		        index: 'dmulai',
				sorttype: "float"},
		    {
		        name: 'dselesai',
		        index: 'dselesai',
				sorttype: "float"}
		    ],
		    sortname: "No",
	        sortorder: "asc",
	        autowidth:false, 
	        shrinkToFit:true,
				pager: "#<?php echo $table_id; ?>_pager2",
	        rownumbers:true,
	        rowNum: 10,
	        rowList: [10,20,50,100],
	        height: 'auto',
		    caption: '<?php echo $caption ?>'
		});

		var names = ["pic", "dmulai", "dselesai"];
		var mydata = [];

		for (var i = 0; i < data.length; i++) {
		    mydata[i] = {};
		    for (var j = 0; j < data[i].length; j++) {
		        mydata[i][names[j]] = data[i][j];
		    }
		}

		for (var i = 0; i <= mydata.length; i++) {
		    $("#<?php echo $table_id; ?>").jqGrid('addRowData', i + 1, mydata[i]);
		}
</script>