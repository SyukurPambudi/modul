<?php $table_id="file_lokal_hasil_ujibe";
$caption = "File Hasil Uji BE";
 ?>
<table id="<?php echo $table_id; ?>" width="900px"></table> 
<div id="<?php echo $table_id; ?>_pager2"></div>
<?php
//$jr=$dquery->num_rows();
$i=0;
$o='["<input type=\'hidden\' class=\'num_rows_table_undangan_perusahaan_details\' value=\'1\' /><input type=\'file\' id=\'fileupload_local_req_ujibe_1\' class=\'fileupload multi multifile\' name=\'fileupload_local_req_ujibe[]\' style=\'width: 90%\' />","<textarea id=\'file_keterangan_local_ujibe_1\' name=\'file_keterangan_local_ujibe[]\' style=\'width: 240px; height: 50px;\'></textarea>","<button id=\'ihapus_'.$table_id.'\' class=\'ui-button-text icon_hapus\' style=\'width:75px\' onclick=\'javascript:hapus_row_details_file_study(1)\' type=\'button\'>Hapus</button>"]';
?>

<script>
	var data = [<?php echo $o ?>];
		$("#<?php echo $table_id; ?>").jqGrid({
		    datatype: "local",
		  	colNames: ["Pilih File","Keterangan","Action"],
		    colModel: [{
		        name: 'vfile',
		        index: 'vfile',
		        width:350,
				sorttype: "float"},
			{
		        name: 'vketerangan',
		        index: 'vketerangan',
		        width:260,
				sorttype: "float"},
		    {
		        name:'iact',
		        index:'iact',
		        align:'center',
		        width:80,
				sorttype: "float"}
		    ],
	        autowidth:false, 
	        shrinkToFit:false,
	        rownumbers:true,
	        viewrecords: false,
	        rowNum: 100,

		    pgbuttons: false,
		    pginput: false,
	        pgtext: "",
	        height: 'auto',
	        pager:'#<?php echo $table_id; ?>_pager2',
		    caption: '<?php echo $caption ?>'
		});

		var names = ["vfile", "vketerangan", "iact"];
		var mydata = [];

		for (var i = 0; i < data.length; i++) {
		    mydata[i] = {};
		    for (var j = 0; j < data[i].length; j++) {
		        mydata[i][names[j]] = data[i][j];
		    }
		}

		/*for (var i = 0; i <= mydata.length; i++) {
		    $("#<?php echo $table_id; ?>").jqGrid('addRowData', i + 1, mydata[i]);
		}*/
		jQuery("#<?php echo $table_id; ?>").navGrid('#<?php echo $table_id; ?>_pager2',{edit:false,add:false,del:false,search:false,refresh:false})
			.navButtonAdd('#<?php echo $table_id; ?>_pager2',{
			   caption:"Tambah", 
			   buttonicon:"ui-icon-plus", 
			   onClickButton: function(){ 
			     addrow_disolusi_terbanding_detail_files();
			   }, 
			   position:"last"
			})

		$(".inputan_tanggal").datepicker({dateFormat:"yy-mm-dd"});

	$( "button.icon_hapus" ).button({
        icons: {
            primary: "ui-icon-close"
        },
        text: true
    });
		
	function addrow_disolusi_terbanding_detail_files(){
		//get last num rows
		var n='';
		var i=0;
		$.each($(".num_rows_table_undangan_perusahaan_details"),function(){
			if(i==0){
				n+=$(this).val();
			}else{
				n+=','+$(this).val();
			}
			i++;
		});
		var s=[n]
		var rlast = parseInt(Math.max.apply(Math, s)) +1;
		var sa=[["<input type='hidden' class='num_rows_table_undangan_perusahaan_details' value='"+rlast+"' /><input type='file' id='fileupload_local_req_ujibe_"+rlast+"' class='fileupload multi multifile' name='fileupload_local_req_ujibe[]' style='width: 90%' />","<textarea id='file_keterangan_local_ujibe_"+rlast+"' name='file_keterangan_local_ujibe[]' style='width: 240px; height: 50px;'></textarea>","<button id='ihapus_<?php echo $table_id ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_details_file_study("+rlast+")' type='button'>Hapus</button>"]];
		var lastr=jQuery("#<?php echo $table_id; ?>").jqGrid('getGridParam', 'records');
		var names = ["vfile", "vketerangan", "iact"];
		for (var i = 0; i < sa.length; i++) {
		    mydata[i] = {};
		    for (var j = 0; j < sa[i].length; j++) {
		        mydata[i][names[j]] = sa[i][j];
		    }
		}
		$("#<?php echo $table_id; ?>").jqGrid('addRowData', rlast, mydata[0]);
		$( "button.icon_hapus" ).button({
	        icons: {
	            primary: "ui-icon-close"
	        },
	        text: true
	    });
	    $(".inputan_tanggal").datepicker({dateFormat:"yy-mm-dd"});
	}	

	function hapus_row_details_file_study(rowId){
		custom_confirm('Anda Yakin ?',function(){
			$('#<?php echo $table_id; ?>').jqGrid('delRowData',rowId);
		});
	}
</script>