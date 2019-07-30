 <?php 
 	//echo $iPkTransId;
 	$urlgetValuePk = base_url().'processor/pk/pk/pd3/asc?action=getValuePk';
 	$action      = $this->input->get('action');
 	$urlCek = base_url()."processor/pk/pk/pd3/asc/?action=cekSupport";  
 	/*echo '<a href="javascript:void(0);" id="link_'.$this->url.'_hitung_'.$iAspekId.'"
                          onClick= "ceksuport();'.$this->url.'_hitungPk(\''.$vFunctionLink.'\','.$iAspekId.',1,'.$nBobot.')" >
                          <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" ><i>'.$kataAnto.'</i></span></b></a>';*/
    echo '<a href="javascript:void(0);" id="link_'.$this->url.'_hitung_'.$iAspekId.'"
                          onClick= "ceksuport_'.$vFunctionLink.'();" >
                          <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" ><i>'.$kataAnto.'</i></span></b></a>';

                          //print_r($iPkTransId);
                          //echo $iPkTransId.'ulele';
  ?>

<script type="text/javascript">
	
	/*$(document).ready(function(){
	    // jalankan function siapin data , kemudian function insert aja
	    $.when($.ajax(siapindata())).then(function () {
	      insertaja();
	    });

	});*/

	function ceksuport_<?php echo $vFunctionLink ?>(){
			//var val7A = $('input[name="pk_pd3_asc_nPointKry_9270\\[\\]"]:checked').val(); 

			/*if(val7A === undefined){
				alert('Isi Parameter 7 terlebih dahulu');
			}else{*/

				$.ajax({
			  	url: "<?php echo $urlCek ?>",
			    type: 'POSt',
			    data: {

			    		iPkTransId : <?php echo $iPkTransId ?>,
			    		iAspekId : <?php echo $iAspekId ?>,
			    					    		
					},
			    success: function(data){
			    	if(data != 1){
						alert('Support data belum dibuat');
						return false;
					}else{
						<?php echo $this->url ?>_hitungPk_<?php echo $vFunctionLink ?>( "<?php echo $vFunctionLink ?>","<?php echo $iAspekId ?>",1,"<?php echo $nBobot ?>")
					}  
			    }
			  });
			//}


				

	}

	function <?php echo $this->url ?>_hitungPk_<?php echo $vFunctionLink ?>(vFunctionLink,iAspekId,tampil,bobot){

           var action = "<?php echo $action ?>";
          $('#img_<?php echo $this->url ?>_nNilai_'+iAspekId).show();
          $('#link_<?php echo $this->url ?>_hitung_'+iAspekId).hide();

          var hasil = <?php echo $this->url ?>_getValuePk_<?php echo $vFunctionLink ?>(vFunctionLink,iAspekId)
          var x_hasil = hasil.split('~');
          value = x_hasil['0'];
          point = x_hasil['1'];
          color = x_hasil['2'];
          html  = x_hasil['3'];

          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_100').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_80').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_60').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_40').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_20').style.backgroundColor='#ffffff';

          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_'+point).style.backgroundColor = color;

          $('#img_<?php echo $this->url ?>_nNilai_'+iAspekId).hide();
          $('#detail_<?php echo $this->url ?>_hitung_'+iAspekId).hide();
          $('#link_<?php echo $this->url ?>_hitung_'+iAspekId).show();
          $('#link_<?php echo $this->url ?>_hitung_'+iAspekId).html(value);
          $('#detail_<?php echo $this->url ?>_hitung_'+iAspekId).show();
          

          //=====================================

          
          var nilai  = (parseFloat(point) * parseFloat(bobot))/100;

          $('#<?php echo $this->url ?>_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#<?php echo $this->url ?>_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#<?php echo $this->url ?>_tmpPilih_'+iAspekId+'').val(point);
          $('#lable_<?php echo $this->url ?>_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
          $('#<?php echo $this->url ?>_ySource_'+iAspekId+'').val(value);
          $('#<?php echo $this->url ?>_nPointSepakat_'+iAspekId+'').val(point);
          $('#lable_<?php echo $this->url ?>_nPointSepakat_'+iAspekId+'').html(point);
          $('#<?php echo $this->url ?>_tmpAybs_'+iAspekId+'').val(point);

          var iMsGroupAspekId = $('.<?php echo $this->url ?>_iMsGroupAspekIdNya_'+iAspekId+'').val();
          sum_<?php echo $this->url ?>(iMsGroupAspekId);

          if (action!='view'){
             simpanPointDetail(iMsGroupAspekId);
          }
         

          //===================================== 

          if (tampil==2){
            //browse('".$urlDetail."&html='+html,'Detail Point')
            $('#detailPointPk').html(html);
            $('#detailPointPk').dialog({
              title : 'Detail Point',
              modal : true,
              show: 'slide',
              hide: 'slide',
              closeOnEscape: true,
              width: 'auto',
              minHeight: 0,
              create: function() {
                  $(this).css('maxHeight', 400);   
              },
              buttons: {
                'Close': function () {
                  $('#detailPointPk').dialog('close');
                }
              }
            });
          }

      }

      function <?php echo $this->url ?>_getValuePk_<?php echo $vFunctionLink ?>(vFunctionLink,iAspekId){

        var nip = $('#pk_pd3_asc_cNip').val();
        var dPeriode1 = $('#pk_pd3_asc_dPeriode1').val();
        var dPeriode2 = $('#pk_pd3_asc_dPeriode2').val();
        var valval = 0;
        var val7A = $('input[name="pk_pd3_asc_nPointKry_9270\\[\\]"]:checked').val(); 
        if (val7A == 100) 
        {
        	valval = 6;
        }else if(val7A==80){
        	valval = 5;
        }else if(val7A==60){
        	valval = 4;
        }else if(val7A==40){
        	valval = 2;
        }else{
        	valval = 1;

        }

        var iPkTransId = <?php echo $iPkTransId ?>;
        return $.ajax({
            type: 'POST', 
            url: '<?php echo $urlgetValuePk ?>',
            data: '_vFunctionLink='+vFunctionLink+'&_iAspekId='+iAspekId+'&_cNipNya='+nip+'&_dPeriode1='+dPeriode1+'&_dPeriode2='+dPeriode2+'&_iPkTransId='+iPkTransId+'&_val7A='+valval,
            async:false
        }).responseText
      }


</script>

