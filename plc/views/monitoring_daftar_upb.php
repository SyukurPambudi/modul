<?php
	$CI = &get_instance();
	$dbset = $CI->load->database('hrd', true);
	$url = base_url()."processor/plc/monitoring/daftar/upb";
?>

<script type='text/javascript'>
	$(document).ready(function() {
		$('#<?php echo $class_name;?>_btn_cari').click(function() {
			$('.kotak').css('background', '#6495ED');
			$('#monitoring_daftar_upb_tbody_1').html("1. Daftar UPB");
			$('#monitoring_daftar_upb_tbody_2').html("2. Setting Prioritas Pra-Reg");
			$('#monitoring_daftar_upb_tbody_3').html("3. Sample Originator");
			$('#monitoring_daftar_upb_tbody_4').html("4. Penerimaan Sample");
			$('#monitoring_daftar_upb_tbody_5').html("5. Po Sample");
			$('#monitoring_daftar_upb_tbody_6').html("6. Penerimaan Sample");
			$('#monitoring_daftar_upb_tbody_7').html("7. Terima Bahan Baku");
			$('#monitoring_daftar_upb_tbody_8').html("8. Analisa Bahan Baku");
			$('#monitoring_daftar_upb_tbody_9').html("9. Release Bahan Baku");
			$('#monitoring_daftar_upb_tbody_10').html("10. SOI Bahan Baku");
			$('#monitoring_daftar_upb_tbody_11').html("11. Formula Skala Trial");
			$('#monitoring_daftar_upb_tbody_12').html("12. Street Test");
			$('#monitoring_daftar_upb_tbody_13').html("13. Formula Skala Lab");
			$('#monitoring_daftar_upb_tbody_14').html("14. Approval Ksk");
			$('#monitoring_daftar_upb_tbody_15').html("15. Stabilita Lab");
			$('#monitoring_daftar_upb_tbody_16').html("16. Best Formula");
			$('#monitoring_daftar_upb_tbody_17').html("17. Spek SOI FG");
			$('#monitoring_daftar_upb_tbody_18').html("18. SOI FG");
			$('#monitoring_daftar_upb_tbody_19').html("19. SOI Mikro Final");
			$('#monitoring_daftar_upb_tbody_20').html("20. Approval HPP");
			$('#monitoring_daftar_upb_tbody_21').html("21. Basic Formula + Valmoa");
			$('#monitoring_daftar_upb_tbody_22').html("22. Bahan Kemas");
			$('#monitoring_daftar_upb_tbody_23').html("23. Pembuatan MBR");
			$('#monitoring_daftar_upb_tbody_24').html("24. Produksi Pilot");
			$('#monitoring_daftar_upb_tbody_25').html("25. Stabilita Lab");
			$('#monitoring_daftar_upb_tbody_26').html("26. Praregistrasi");
			$('#monitoring_daftar_upb_tbody_27').html("27. Setting Prioritas Registrasi");
			$('#monitoring_daftar_upb_tbody_28').html("28. Registrasi");
			$('#monitoring_daftar_upb_tbody_29').html("29. Launching Product");
			var upb_val = $('#monitoring_daftar_upb_iupb_id').val();
			if($('#monitoring_daftar_upb_iupb_id').val()==''){
				alert("Harap Masukkan No UPB");
			}
			var html = getData_<?php echo $class_name;?>(upb_val);
			//html = html.split('~');
			
			
		});
		
		$('#<?php echo $class_name;?>_btn_reset').click(function() {
			$('#<?php echo $class_name;?>_iupb_id_dis').val('') ;
			$('#<?php echo $class_name;?>_iupb_id').val('') ;
			$('.kotak').css('background', '#6495ED');
			$('#monitoring_daftar_upb_tbody_1').html("1. Daftar UPB");
			$('#monitoring_daftar_upb_tbody_2').html("2. Setting Prioritas Pra-Reg");
			$('#monitoring_daftar_upb_tbody_3').html("3. Sample Originator");
			$('#monitoring_daftar_upb_tbody_4').html("4. Penerimaan Sample");
			$('#monitoring_daftar_upb_tbody_5').html("5. Po Sample");
			$('#monitoring_daftar_upb_tbody_6').html("6. Penerimaan Sample");
			$('#monitoring_daftar_upb_tbody_7').html("7. Terima Bahan Baku");
			$('#monitoring_daftar_upb_tbody_8').html("8. Analisa Bahan Baku");
			$('#monitoring_daftar_upb_tbody_9').html("9. Release Bahan Baku");
			$('#monitoring_daftar_upb_tbody_10').html("10. SOI Bahan Baku");
			$('#monitoring_daftar_upb_tbody_11').html("11. Formula Skala Trial");
			$('#monitoring_daftar_upb_tbody_12').html("12. Street Test");
			$('#monitoring_daftar_upb_tbody_13').html("13. Formula Skala Lab");
			$('#monitoring_daftar_upb_tbody_14').html("14. Approval Ksk");
			$('#monitoring_daftar_upb_tbody_15').html("15. Stabilita Lab");
			$('#monitoring_daftar_upb_tbody_16').html("16. Best Formula");
			$('#monitoring_daftar_upb_tbody_17').html("17. Spek SOI FG");
			$('#monitoring_daftar_upb_tbody_18').html("18. SOI FG");
			$('#monitoring_daftar_upb_tbody_19').html("19. SOI Mikro Final");
			$('#monitoring_daftar_upb_tbody_20').html("20. Approval HPP");
			$('#monitoring_daftar_upb_tbody_21').html("21. Basic Formula + Valmoa");
			$('#monitoring_daftar_upb_tbody_22').html("22. Bahan Kemas");
			$('#monitoring_daftar_upb_tbody_23').html("23. Pembuatan MBR");
			$('#monitoring_daftar_upb_tbody_24').html("24. Produksi Pilot");
			$('#monitoring_daftar_upb_tbody_25').html("25. Stabilita Lab");
			$('#monitoring_daftar_upb_tbody_26').html("26. Praregistrasi");
			$('#monitoring_daftar_upb_tbody_27').html("27. Setting Prioritas Registrasi");
			$('#monitoring_daftar_upb_tbody_28').html("28. Registrasi");
			$('#monitoring_daftar_upb_tbody_29').html("29. Launching Product");
			
		});
		
		
		
	});
	
	function confirmEmail(upb, status, proses,pic, pengirim) {
		  if (confirm("Are you sure you want to send mail")) {
				return $.ajax({
					type: 'get',
					url: '<?php echo $url;?>',
					data: 'action=sendMail&_parameter='+upb+'&_parameter1='+pic+'&_parameter2='+status+'&_parameter3='+proses+'&_parameter4='+pengirim+'&company_id=3&modul_id=2652&group_id=72', 
					success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var message ="Email Sedang dikirim. Terima Kasih";
								var info = 'Info';
								var header = 'Info';
								
								_custom_alert(message,header,info, '', 1, 20000);
									
							}
						
				}).responseText
		  }
		}
	function getData_<?php echo $class_name;?>(parameter) {				
		return $.ajax({
			type: 'get',
			dataType : "json",
			url: '<?php echo $url;?>',
			data: 'action=getData&_parameter='+parameter, 
			success: function( data ) {
			
				//$('#monitoring_daftar_upb_tbody_hijau').text(data);
				//	
				//	$('#monitoring_daftar_upb_tbody_originator').html('');					
				$.each(data, function(index, element) {
					//alert(element.status1);
					//alert(element.iupb_id);
					var html='';
					var link ='';
					$('.kotak').css('background', '#6495ED');
					if(element.box=='0'){alert("Nomor Upb Tersebut tidak ada");}
					else if(element.box=='29'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Launching Product </a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">29. Launching Product</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >29. Launching Product</a>');
						}
					}else if(element.box=='28'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Registrasi</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">28. Registrasi</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >28. Registrasi</a>');
						
						}
					}else if(element.box=='27'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Setting Prioritas Registrasi</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">27. Setting Prioritas Registrasi</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >27. Setting Prioritas Registrasi</a>');
						
						}
					}
					else if(element.box=='26'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Praregistrasi</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">26. Praregistrasi</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >26. Praregistrasi</a>');
						
						}
					}
					else if(element.box=='25'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Stabilita Pilot</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">25. Stabilita Pilot</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >25. Stabilita Pilot</a>');
						
						
						}
					}
					else if(element.box=='24'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Produksi Pilot</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">24. Produksi Pilot</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>24. Produksi Pilot</a>');
						
						}
					}
					else if(element.box=='23'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Pembuatan MBR</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">23. Pembuatan MBR</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >23. Pembuatan MBR</a>');
						
						}
					}else if(element.box=='22'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Bahan Kemas</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">22. Bahan Kemas</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>22. Bahan Kemas</a>');
						
						}
					}
					else if(element.box=='21'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Basic Formula + Valmoa</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">21. Basic Formula + Valmoa</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >21. Basic Formula + Valmoa</a>');
						
						}
					}
					else if(element.box=='20'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Approval HPP</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">20. Approval HPP</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >20. Approval HPP</a>');
						
						
						}
					}
					else if(element.box=='19'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Soi Mikro Final</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">19. Soi Mikro Final</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >19. Soi Mikro Final</a>');
						
						}
					}
					else if(element.box=='18'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Soi FG Final </a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">18. Soi FG Final</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>18. Soi FG Final</a>');
						
						}
					}
					else if(element.box=='17'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Spek. Soi FG FInal<a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">17. Spek. Soi FG FInal</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>17. Spek. Soi FG FInal</a>');
						
						}
					}
					else if(element.box=='16'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Best Formula</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">16. Best Formula</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >16. Best Formula</a>');
						
						}
					}
					else if(element.box=='15'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Stabilita Lab</a>';$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">15. Stabilita Lab</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >15. Stabilita Lab</a>');
						
						}
					}else if(element.box=='14'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >App Ksk</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">14. App Ksk</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >14. App Ksk</a>');
						
						}
					}else if(element.box=='13'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >For Skala Lab</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">13. For Skala Lab</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>13. For Skala Lab</a>');
						
						}
					}
					else if(element.box=='12'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Street Test</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">12. Street Test</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >12. Street Test</a>');
						
						}
					}
					else if(element.box=='11'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Formula Skala Trial</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">11. Formula Skala Trial</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >11. Formula Skala Trial</a>');
						
						}
					}else if(element.box=='10'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Soi Bahan Baku</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">10. Soi Bahan Baku</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >10. Soi Bahan Baku</a>');
						
						}
					}else if(element.box=='9'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Release Bahan Baku</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">9. Release Bahan Baku</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >9. Release Bahan Baku</a>');
						
						}
					}else if(element.box=='8'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Analisa Bahan Baku</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">8. Analisa Bahan Baku</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >8. Analisa Bahan Baku</a>');
						
						}
					}else if(element.box=='7'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Terima Bahan Baku</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">7. Terima Bahan Baku</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >7. Terima Bahan Baku</a>');
						
						}
					}
					else if(element.box=='6'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Penerimaa Sample</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">6. Penerimaa Sample</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >6. Penerimaa Sample</a>');
						
						}
					}
					else if(element.box=='5'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Po Sample</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">5. Po Sample</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >5. Po Sample</a>');
						
						}
					}
					else if(element.box=='4'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Permintaan Sample</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">4. Permintaan Sample</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >4. Permintaan Sample</a>');
						}
					}
					else if(element.box=='3'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Sample Originator</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">3. Sample Originator</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\'>3. Sample Originator</a>');
						}
					}
					else if(element.box=='2'){
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
						link = '<a href = "#" title=\"'+html+'\"  >Setting Prioritas Prareg</a>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#" title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">2. Setting Prioritas Prareg</a>');
						}
						else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#" title=\''+html+'\'>2. Setting Prioritas Prareg</a>');
						
						}
					}
					else if(element.box=='1'){
						//alert(element.box);
						html = '<table><tr><td>No. UPB </td><td>:</td><td>'+element.vupb_nomor+'</td></tr>';
						html +='<tr><td>Status  </td><td>:</td><td>'+element.status+'<td></tr>';
						
						html +='</table>';
					
						link = '<div title=\"'+html+'\" ></div>';
						$('#monitoring_daftar_upb_tbody_'+element.box).html("");
						if(element.click=='Yes'){
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' onClick="javascript:confirmEmail(\''+element.vupb_nomor+'\ \',\''+element.status+'\ \',\''+element.box+'\ \',\''+element.status1+'\ \',\''+element.pengirim+'\')">1. Daftar UPB</a>');
						}else{
							$('#monitoring_daftar_upb_tbody_'+element.box).css('background', '#FF0000').css('text-decoration', 'none').tooltip().append('<a href="#"  title=\''+html+'\' >1. Daftar UPB</a>');
						
						}
					}
					
					
					
				});	
			},
		//	async: false	
		}).responseText
	}
</script>

<!--<button name='<?php echo $class_name;?>_btn_cari' id='<?php echo $class_name;?>_btn_cari'>Cari</button>-->
<input type='button' name='<?php echo $class_name;?>_btn_cari' id='<?php echo $class_name;?>_btn_cari' value='Cari'/>
<input type='button' id='<?php echo $class_name;?>_btn_reset' name='<?php echo $class_name;?>_btn_reset' value='Reset'/>
<html>

<body class='std'><center>
<br><br><br>

<table id="<?php echo $class_name;?>"  width="100%" >
	<tbody>
	<tr>
	<div class="kotak" style="width: 150px;text-decoration:none; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_1' align="left">
		<span align="center">1. Daftar UPB  </span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_2' align="left">
		<span align="center">2. Setting Prioritas Pra-Reg</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_3' align="left">
		<span align="center">3. Sample Originator</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_4' align="left">
		<span align="center">4. Permintaan Sample</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_5' align="left">
		<span align="center">5. Po Sample</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_6' align="left">
		<span align="center">6. Penerimaan Sample</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_7' align="left">
		<span align="center">7. Terima Bahan Baku</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_8' align="left">
		<span align="center">8. Analisa Bahan Baku</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_9' align="left">
		<span align="center">9. Release Bahan Baku</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_10' align="left">
		<span align="center">10. Soi Bahan Baku</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_11' align="left">
		<span align="center">11. Formula Skala Trial</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_12' align="left">
		<span align="center">12. Street Test</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_13' align="left">
		<span align="center">13. Formula Skala Lab</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_14' align="left">
		<span align="center">14. App Ksk</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_15' align="left">
		<span align="center">15. Stabilita Lab</span>
	</div>
	<div class="kotak"style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_16' align="left">
		<span align="center">16. Best Formula</span>
	</div>
	
	<div class="kotak"style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_17' align="left">
		<span align="center">17. Spek Soi FG Final</span>
	</div>
	<div class="kotak"style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_18' align="left">
		<span align="center">18. Soi FG Final</span>
	</div>
	<div class="kotak"style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_19' align="left">
		<span align="center">19. Soi Mikro Final</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_20' align="left">
		<span align="center">20. Approval HPP</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_21' align="left">
		<span align="center">21. Basic Formula</span>
	</div>
	<div class="kotak"style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_22' align="left">
		<span align="center">22. Bahan Kemas</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_23' align="left">
		<span align="center">23. Pembuatan MBR</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_24' align="left">
		<span align="center">24. Produksi Pilot</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_25' align="left">
		<span align="center">25. Stabilita Pilot</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_26' align="left">
		<span align="center">26. Praregistrasi</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_27' align="left">
		<span align="center">27. Setting Prioritas Registrasi</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_28' align="left">
		<span align="center">28. Registrasi</span>
	</div>
	<div class="kotak" style="width: 150px; height:50px; margin:20px;border: 1px solid gray; float:left;background:#6495ED;line-height:50px;text-align:center; " id='<?php echo $class_name;?>_tbody_29' align="left">
		<span align="center">29. Launching Product</span>
	</div>
	
	</tbody>
	</tfoot>
</table></center>
</body></html>