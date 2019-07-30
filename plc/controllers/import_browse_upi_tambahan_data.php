<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_upi_tambahan_data extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPI');		
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('import_browse_upi_tambahan_data');
		$grid->addList('vNo_upi','dTgl_upi','vNama_usulan','pilih');
		$grid->setSortBy('vNo_upi');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vNo_upi', '55');
		$grid->setWidth('dTgl_upi', '190');
		$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('vNo_upi', 'No. UPD');
		$grid->setLabel('dTgl_upi', 'Tanggal UPD');				
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		
		$grid->setSearch('vNo_upi','dTgl_upi');
		
		$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		//$grid->setQuery('iSubmit_td_check = "1" ', null);
		//upi sudah approve prareg

		$grid->setQuery('iStatusKill = "0" ', null);
		
		//tampil ketika bentuk 1 dan no izin gx ada
		$grid->setQuery('daftar_upi.iupi_id in ( SELECT b.`iupi_id` FROM plc2.`registrasi_upi` b WHERE b.`iApprove_bdirm`=0 AND b.`iBentuk_td`=1 AND b.`vNo_ijin`="") ', null);
		//Tidak Tampil Ketika di Approve dan udah ada no izin
		//$grid->setQuery('daftar_upi.iupi_id Not in ( SELECT a.`iupi_id` FROM plc2.`daftar_upi` a JOIN plc2.`registrasi_upi` b ON a.`iupi_id` = b.`iupi_id` 
 				//WHERE b.`iApprove_bdirm`=2 AND b.`iBentuk_td`=0 AND b.`vNo_ijin`!="") ', null);

		//Tidak Tampil Kalo Belum Diaprove
		$grid->setQuery('daftar_upi.iupi_id Not in ( SELECT v.iupi_id FROM plc2.`upi_dok_td` v WHERE v.`iSubmit_td`=0 OR v.`iApprove_bdirm` NOT IN (2)) ', null);

		
		


		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

	function listBox_import_browse_upi_tambahan_data_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/import/praregistrasi/upi/?action=getdetil";  
		$url_rincian = base_url()."processor/plc/partial/view/tambahan/data?action=gethistorytd"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_prio('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->dTgl_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upi_prio (id, vNo_upi, dTgl_upi,vNama_usulan) {					
						custom_confirm("Yakin", function() {
							$("#'.$this->input->get('field').'_'.'iupi_id").val(id);
								$.ajax({
								     url: "'.$url_rincian.'", 
								     type: "POST", 
								     data: {iupi_id: id}, 
								     success: function(response){
								         $("#hist_dok_td_view").html(response);
								     }

								});
								$.ajax({
									url: "'.$url_header.'",
									type: "post",
									data: {
										iupi_id: id,
										},
									dataType: "json",
				                    success: function( data ) {
				                        
				                        $.each(data, function(index, element) {
				                        	$("#'.$this->input->get('field').'_'.'iupi_id_dis").val(element.vNo_upi);
				                        	$("#'.$this->input->get('field').'_'.'dTgl_upi").val(element.dTgl_upi);
				                        	$("#'.$this->input->get('field').'_'.'cPengusul_upi").val(element.cPengusul_upi);
											$("#'.$this->input->get('field').'_'.'vNama_usulan").val(element.vNama_usulan);

											$("#'.$this->input->get('field').'_'.'vKekuatan").val(element.vKekuatan);
											$("#'.$this->input->get('field').'_'.'vDosis").val(element.vDosis);
											$("#'.$this->input->get('field').'_'.'vNama_generik").val(element.vNama_generik);
											$("#'.$this->input->get('field').'_'.'vIndikasi").val(element.vIndikasi);
											$("#'.$this->input->get('field').'_'.'ikategori_id").val(element.ikategori_id);
											$("#'.$this->input->get('field').'_'.'ikategoriupi_id").val(element.ikategoriupi_id);
											$("#'.$this->input->get('field').'_'.'isediaan_id").val(element.isediaan_id);
											$("#'.$this->input->get('field').'_'.'itipe_id").val(element.itipe_id);
											$("#'.$this->input->get('field').'_'.'ibe").val(element.ibe);

											$("#'.$this->input->get('field').'_'.'vhpp_target").val(element.vhpp_target);
											$("#'.$this->input->get('field').'_'.'tunique").val(element.tunique);
											$("#'.$this->input->get('field').'_'.'tpacking").val(element.tpacking);
											$("#'.$this->input->get('field').'_'.'ttarget_prareg").val(element.ttarget_prareg);
											$("#'.$this->input->get('field').'_'.'ipatent").val(element.ipatent);


											$("#'.$this->input->get('field').'_'.'tinfo_paten").val(element.tinfo_paten);
											$("#'.$this->input->get('field').'_'.'patent_year").val(element.patent_year);
											$("#'.$this->input->get('field').'_'.'iteammarketing_id").val(element.iteammarketing_id);
											$("#'.$this->input->get('field').'_'.'iregister").val(element.iregister);


											$("#'.$this->input->get('field').'_'.'tmemo_bde").val(element.tmemo_bde);

											$("#'.$this->input->get('field').'_'.'fMkt_forcast").val(element.fMkt_forcast);
											$("#'.$this->input->get('field').'_'.'fSales_upbk").val(element.fSales_upbk);
											$("#'.$this->input->get('field').'_'.'fSales_upb").val(element.fSales_upb);
											$("#'.$this->input->get('field').'_'.'fSales_newk").val(element.fSales_newk);
											$("#'.$this->input->get('field').'_'.'fSales_new").val(element.fSales_new);
											$("#'.$this->input->get('field').'_'.'iForcast_year1").val(element.iForcast_year1);
											$("#'.$this->input->get('field').'_'.'iForcast_year2").val(element.iForcast_year2);
											$("#'.$this->input->get('field').'_'.'iForcast_year3").val(element.iForcast_year3);

											

				                        })
				                    }

									
								})

							

							

							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
