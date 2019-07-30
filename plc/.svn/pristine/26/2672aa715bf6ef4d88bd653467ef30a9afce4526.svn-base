<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahan_baku_terima_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
		$this->load->library('biz_process');
		$this->load->library('lib_flow');
		$this->_table = 'plc2.plc2_upb_ro_detail';
		$this->_table2 = 'plc2.plc2_upb_request_sample';
		$this->_table3 = 'plc2.plc2_upb';
		$this->_table4 = 'plc2.plc2_upb_ro';
		$this->_table5 = 'plc2.plc2_raw_material';
		$this->_table6 = 'hrd.employee';
		$this->load->helper('to_mysql');
		$mydivid=$this->user->gDivId; 
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setFormUpload(TRUE);
		$grid->setTitle('Terima Sample Bahan Baku');		
		$grid->setTable($this->_table);		
		$grid->setUrl('bahan_baku_terima_sample');
		$grid->addList('plc2_upb_ro.vro_nomor','plc2_upb_request_sample.vreq_nomor','plc2_upb_request_sample.iTujuan_req','plc2_upb.vupb_nomor','plc2_raw_material.vnama');
		$grid->setJoinTable($this->_table2, $this->_table2.'.ireq_id = '.$this->_table.'.ireq_id', 'inner');
		$grid->setJoinTable($this->_table4, $this->_table4.'.iro_id = '.$this->_table.'.iro_id', 'inner');
		$grid->setJoinTable($this->_table3, $this->_table3.'.iupb_id = '.$this->_table2.'.iupb_id', 'inner');
		$grid->setJoinTable($this->_table5, $this->_table5.'.raw_id = '.$this->_table.'.raw_id', 'inner');
		$grid->setSortBy('plc2_upb_ro.vro_nomor');
		$grid->setSortOrder('desc');
		//$grid->setRelation($this->_table_plc_upb.'.iteampd_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'PD','ldeleted'=>0), array('vteam'=>'asc'));		
		$grid->setSearch('plc2_upb_ro.vro_nomor','plc2_upb_request_sample.vreq_nomor','plc2_upb.vupb_nomor','plc2_raw_material.vnama');
		$grid->addFields('ipo_id','imanufacture_id','raw_id','vnama_produk','ijumlah_req','ijumlah','vsatuan','hist_terima','iUjiMikro_bb','vwadah');
		$grid->addFields('vrec_jum_pd','vrec_nip_pd','trec_date_pd','vrec_jum_qc','vrec_nip_qc','trec_date_qc','vrec_jum_qa','vrec_nip_qa','trec_date_qa');
		$grid->addFields('vreq_nomor','vro_nomor','iupb_id');
		//$grid->addFields('DMF','coars','ws','lsa','coabb');
		// $grid->setLabel('DMF','File DMF');
		// $grid->setLabel('coars','File COA RS');
		// $grid->setLabel('ws','File WS');
		// $grid->setLabel('lsa','File LSA Zat Aktif');		
		// $grid->setLabel('coabb','File COA Bahan Baku');	
//		$grid->changeFieldType('iUjiMikro_bb','combobox','',array(''=>'Pilih',1=>'Ya',0=>'Tidak'));		
		
		$grid->setWidth('plc2_upb_request_sample.vreq_nomor', 100);
		$grid->setWidth('plc2_upb_request_sample.iTujuan_req', 100);
		$grid->setWidth('plc2_upb_ro.vro_nomor', 100);
		$grid->setWidth('plc2_upb.vupb_nomor', 70);
		
		$grid->setLabel('iUjiMikro_bb','Uji Mikro BB');
		$grid->setLabel('ipo_id','No. PO');
		$grid->setLabel('imanufacture_id','Manufacturer');
		$grid->setLabel('raw_id','Bahan Baku');
		$grid->setLabel('vnama_produk','Nama Produk');
		//$grid->setLabel('vbatch_no','No. Batch');
		$grid->setLabel('ijumlah_req','Jumlah Request PD');
		$grid->setLabel('ijumlah','Jumlah Terima Purchasing');
		//$grid->setLabel('texp_date','Tanggal expired');
		$grid->setLabel('vsatuan','Satuan');
		$grid->setLabel('hist_terima','History Terima Sample');
		//$grid->setLabel('vwadah','Jumlah Wadah');
		$grid->setLabel('vwadah','Jumlah Wadah (Batch)');
		$grid->setLabel('vrec_jum_pd','Jumlah Total Terima PD');
		$grid->setLabel('vrec_nip_pd','Terima PD oleh');
		$grid->setLabel('trec_date_pd','Waktu Terima PD');
		$grid->setLabel('vrec_jum_qc','Jumlah Total Terima PD-AD');
		$grid->setLabel('vrec_nip_qc','Terima PD-AD oleh');
		$grid->setLabel('trec_date_qc','Waktu Terima PD-AD');
		$grid->setLabel('vrec_jum_qa','Jumlah Total Terima QA');
		$grid->setLabel('vrec_nip_qa','Terima QA oleh');
		$grid->setLabel('trec_date_qa','Waktu Terima QA');
		$grid->setLabel('vreq_nomor','No. Permintaan');
		$grid->setLabel('vro_nomor','No. Terima');
		$grid->setLabel('iupb_id','No. UPB');
		$grid->setLabel('plc2_upb_ro.vro_nomor','No. Terima');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb_request_sample.vreq_nomor','No. Permintaan');
		$grid->setLabel('plc2_upb_request_sample.iTujuan_req','Tujuan');
		$grid->setLabel('plc2_raw_material.vnama','Bahan Baku');
		
		$grid->setQuery('plc2_upb_ro_detail.ldeleted', 0);
		$grid->setQuery('plc2_upb_ro.ldeleted', 0);			
		$grid->setQuery('plc2_upb_request_sample.ldeleted', 0);			
		$grid->setQuery('plc2_upb_ro.iclose_po', 1);
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		$grid->setRequired('ipo_id','imanufacture_id','raw_id','vnama_produk','ijumlah_req','ijumlah','vsatuan','hist_terima','iUjiMikro_bb','vwadah');
		$grid->setRequired('vrec_jum_pd','vrec_nip_pd','trec_date_pd','vrec_jum_qc','vrec_nip_qc','trec_date_qc');
		$grid->setRequired('vreq_nomor','vro_nomor','iupb_id');

		//$grid->changeFieldType('plc2_upb_request_sample.iTujuan_req','combobox','',array(''=>'--Select--',1=>'Sample', 2=>'Pilot I', 3=>'Pilot II', 4=>'Re-Sample'));


		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			// elseif(in_array('QC', $manager)){
				// $type='QC';
				// $grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			// }
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			// elseif(in_array('QC', $team)){
				// $type='QC';
				// $grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			// }
			else{$type='';}
		}
		
		//$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'download':
				$this->download($this->input->get('file'));
			break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function listBox_Action($row, $actions) {

		$x=$this->auth_localnon->dept();
		$team=$x['team'];
		if(in_array('PD', $team)){
			if ($row->vrec_nip_pd !="") {
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}else if(in_array('QA', $team)){
			if ($row->vrec_nip_qa !="") {
				unset($actions['edit']);
				unset($actions['delete']);
			}

		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}

		
		
		return $actions;
	}

	function listBox_bahan_baku_terima_sample_plc2_upb_request_sample_iTujuan_req($value) {
    	
    	if($value<>""){
    		if($value==1){
    			$ret='Sample';
    		}else if($value==2){
    			$ret='Pilot I';
    		}else if($value==3){
    			$ret='Pilot II';
    		}else if($value==4){
    			$ret='Re-Sample';
    		}else{
    			$ret='-';	
    		}
    	}else{
    		$ret='-';
    	}
		return $ret;
    } 


	function manipulate_update_button($buttons, $rowData) {
    	unset($buttons['update_back']);
    	unset($buttons['update']);
		//print_r($rowData);
		//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
    	$user = $this->auth_localnon->user();
		$iapppd=$rowData['iapppd_analisa']; // tambahin kalo udah app analisa pd gak bisa update data
    	if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			//elseif(in_array('QC', $manager)){$type='QC';}
			elseif(in_array('QA', $manager)){$type='QA';}
    		else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			//elseif(in_array('QC', $team)){$type='QC';}
			elseif(in_array('QA', $team)){$type='QA';}
			else{$type='';}
		}
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			$irodet_id=$rowData['irodet_id'];
			
			//echo $this->auth_localnon->my_teams();
			//$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
		//	if(empty($arrhak)){
				//$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
				//if(empty($getbp)){}
				//else{

				/*Cek Uji Mikro BB*/
				$sql="SELECT plc2.uji_mikro_bb.*
						FROM (plc2.uji_mikro_bb)
						INNER JOIN plc2.plc2_upb_request_sample_detail ON plc2_upb_request_sample_detail.ireqdet_id = uji_mikro_bb.ireqdet_id
						INNER JOIN plc2.plc2_upb_request_sample ON plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id
						INNER JOIN plc2.plc2_raw_material ON plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id
						WHERE uji_mikro_bb.lDeleted =  0 and plc2_upb_request_sample.ireq_id=".$rowData['ireq_id'];
				$qujimikro=$this->db_plc0->query($sql);
				$iappqa=0;
				if($qujimikro->num_rows()>=1){
					$duji=$qujimikro->row_array();
					if($duji['iApprove_uji']>=1){
						$iappqa=1;
					}
				}

					if($this->auth_localnon->is_manager()){ //jika manager PR
					//	if(($iapppd==0)&&(($type=='PD')||($type=='QC')||($type=='QA'))){
						if(($iapppd==0)&&(($type=='PD'))){
							if ($type=='PD') {
								if ($rowData['vrec_nip_pd'] =="") {
									$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
									$buttons['update'] =$update;
								}
							}
						}elseif(($iappqa==0)&&($type="QA")){
							if ($rowData['vrec_nip_qa'] =="") {
								$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
								$buttons['update'] =$update;
							}

						}else{}
					}else{
						//if(($iapppd==0)&&(($type=='PD')||($type=='QC')||($type=='QA'))){
						if(($iapppd==0)&&(($type=='PD'))){
							if ($type=='PD') {
								if ($rowData['vrec_nip_pd'] =="") {
									$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
									$buttons['update'] =$update;
								}
							}
						}elseif(($iappqa==0)&&($type="QA")){
							if ($rowData['vrec_nip_qa'] =="") {
								$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
								$buttons['update'] =$update;
							}
						
						}else{}
					}
				//}
			/*

			}else{
				if($this->auth_localnon->is_manager()){ //jika manager PR
						//if(($iapppd==0)&&(($type=='PD')||($type=='QC')||($type=='QA'))){
						if(($iapppd==0)&&(($type=='PD')||($type=='QA'))){
							$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
							$buttons['update'] =$update;
						}
						else{}
				}
				else{
					//if(($iapppd==0)&&(($type=='PD')||($type=='QC')||($type=='QA'))){
					if(($iapppd==0)&&(($type=='PD')||($type=='QA'))){
						$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_terima_sample\', \''.base_url().'processor/plc/bahan/baku/terima/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_bahan_baku_terima_sample">Update</button>';
						$buttons['update'] = $update;
					}
				}
			}
			*/
   
    	return $buttons;
    }
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		
		//print_r($postData);
		
		$ipo_id = $postData['ipo_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		$iupb_id_to_next='';
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}*/
			$iupb_id_to_next = $iupb_id;
		}



		
		$cek_upb = "SELECT * FROM plc2.plc2_upb_request_sample purs 
		WHERE purs.ldeleted = 0 AND purs.iTujuan_req in(1,4)
		AND purs.iupb_id IN (".$iupb_id_to_next.") ";
		$cek = $this->db_plc0->query($cek_upb)->result_array();
		//Cek UPB Jenis Sample

		//Jika ada tujuan Sample nya
		if(!empty($cek)){
			$cek_form = "SELECT * FROM pddetail.formula_process fp WHERE fp.lDeleted = 0 AND fp.iMaster_flow = 1 AND fp.iupb_id IN (".$iupb_id_to_next.")";
			$dcek = $this->db_plc0->query($cek_form)->result_array();

			//Jika Kosong
			if(empty($dcek)){

					$cNip = $this->user->gNIP;
					$dUpdate_time = date("Y-m-d H:i:s");
					
					//Insert Formula Proses
					$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
						('".$iupb_id_to_next."','1','".$cNip."',SYSDATE())";
					$this->db_plc0->query($sqlto_Back);
					$iFormula_process = $this->db_plc0->insert_id();

					//Insert Formula Proses Detail
					$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
					$this->db_plc0->query($pn);

					//Insert Formula Awal
					$ver = 0;
					$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated)
							VALUES("'.$iFormula_process.'","'.$ver.'","'.$dUpdate_time.'","'.$cNip.'")';
					$this->db_plc0->query($iFd);


			}

			/*// cek 
			if($cek['iTujuan_req']==4){
				$sql='
					update pddetail.formula f set f.iBackSample=0 where f.iFormula_process in (
						select f.iFormula 
						from pddetail.formula_process fp 
						join pddetail.formula f on f.iFormula_process=fp.iFormula_process
						where fp.lDeleted=0
						and f.lDeleted=0
						and f.iBackSample=1
						and fp.iupb_id="'.$iupb_id_to_next.'"
					)

				';
				$query = $this->db_plc0->query($sql);
			}*/

				//if($cek['iTujuan_req']==4){
					/*tujuan re-sample*/
					$cek_fromPD='select f.iFormula 
								from pddetail.formula_process fp 
								join pddetail.formula f on f.iFormula_process=fp.iFormula_process
								where fp.lDeleted=0
								and f.lDeleted=0
								#and f.iBackSample=1
								and fp.iupb_id="'.$iupb_id_to_next.'" ';
					$dFormula = $this->db_plc0->query($cek_fromPD)->result_array();	

					if (!empty($dFormula)) {
						foreach ($dFormula as $forfor) {
							
							$this->db_plc0->where('iFormula', $forfor['iFormula']);
							$this->db_plc0->update('pddetail.formula', array('iBackSample'=>0));											
						}
							
					}
				//}

				
		}
			

		

	}

	function updateBox_bahan_baku_terima_sample_iUjiMikro_bb($field, $id, $value,$rowData) {
        
        if ($this->input->get('action') == 'view') {
        	$lchoose = array(''=>'Pilih', 1=>'Ya', 0=>'Tidak');
            $o = $lchoose[$value];
        } else {

        	$sql_get_upb ='select a.iupb_id  from plc2.plc2_upb_request_sample a where a.ireq_id="'.$rowData['ireq_id'].'" ';
        	$dtupb=$this->db_plc0->query($sql_get_upb)->row_array();
        	//print_r($dtupb);
        	$sql_cek_uji='select  c.iUjiMikro_bb
							from plc2.plc2_upb_request_sample a 
							join plc2.plc2_upb_request_sample_detail b on b.ireq_id=a.ireq_id
							join plc2.plc2_upb_ro_detail c on c.ireq_id=a.ireq_id
							join plc2.plc2_upb_ro d on d.iro_id=c.iro_id
							where a.iupb_id="'.$dtupb['iupb_id'].'"
							and a.iTujuan_req=1
							and a.ldeleted=0
							and b.ldeleted=0
							and c.ldeleted=0
							and d.ldeleted=0
							and c.irodet_id <> "'.$rowData['irodet_id'].'"
							and c.iUjiMikro_bb is not null
							order by a.ireq_id Desc limit 1
							';
			$duji=$this->db_plc0->query($sql_cek_uji)->row_array();							
			//print_r($duji);
        	$o='';
        	if (!empty($duji) and $duji['iUjiMikro_bb']<>"" ) {
        		$disabled='disabled=disabled';
        		$pal=$duji['iUjiMikro_bb'];
        		$o .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$duji['iUjiMikro_bb'].'" class="input_rows1 required" />';
        	}else{
        		$disabled='';
        		$pal=$value;
        	}


        	$lchoose = array(""=>'Select One', 1=>'Ya', 0=>'Tidak');
            $o  .= "<select  name='".$field."' ".$disabled." id='".$id."' class='required combobox'>";            
            foreach($lchoose as $k=>$v) {
                if ($k == $pal) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }

        return $o;
    }	


	function updateBox_bahan_baku_terima_sample_ipo_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_po', array('ipo_id'=>$rowData['ipo_id']))->row_array();
		return '<span>'.$row['vpo_nomor'].'</span><input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
	}
	function updateBox_bahan_baku_terima_sample_imanufacture_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.mnf_manufacturer', array('imanufacture_id'=>$rowData['imanufacture_id']))->row_array();
		//return '<span id="'.$id.'">'.$row['vnmmanufacture'].'</span>';
		if(sizeOf($row) > 0){
			return '<span id="'.$id.'">'.$row['vnmmanufacture'].'</span>';
		}
		else{
			return '-';
		}
	}
	function updateBox_bahan_baku_terima_sample_raw_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_raw_material', array('raw_id'=>$rowData['raw_id']))->row_array();
		return '<span id="'.$id.'">'.$row['vnama'].'</span>';
	}
	function updateBox_bahan_baku_terima_sample_vnama_produk($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_terima_sample_vbatch_no($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	
	function updateBox_bahan_baku_terima_sample_ijumlah_req($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_request_sample_detail', array('ireq_id'=>$rowData['ireq_id']))->row_array();
		return '<input type="hidden" value="'.$row['ijumlah'].'" nama="'.$name.'" id="'.$id.'"><span id="'.$id.'">'.$row['ijumlah'].'</span>';
	}

	function updateBox_bahan_baku_terima_sample_ijumlah($name, $id, $value, $rowData) {
		return '<input type="hidden" value="'.$rowData['vrec_jum_pr'].'" nama="'.$id.'" id="'.$id.'"><span id="'.$id.'">'.$rowData['vrec_jum_pr'].'</span>';
	}
	function updateBox_bahan_baku_terima_sample_texp_date($name, $id, $value, $rowData) {
		if($value != '' && $value != '0000-00-00') {
			$value = date('d M Y', strtotime($value));
		}
		else {
			$value = '';
		}		
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_terima_sample_vsatuan($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	
	function updateBox_bahan_baku_terima_sample_hist_terima($name, $id, $value, $rowData) {
		//print_r($rowData);
		$row = $this->db_plc0->get_where('plc2.plc2_raw_material', array('raw_id'=>$rowData['raw_id']))->row_array();
		$hsql= "select b.raw_id,a.vreq_nomor,b.ijumlah as jumlah_req,cc.vpo_nomor,c.ijumlah as jumlah_po,dd.vro_nomor,d.ijumlah as jml_terima_purc
				from plc2.plc2_upb_request_sample a 
				join plc2.plc2_upb_request_sample_detail b on b.ireq_id=a.ireq_id
				join plc2.plc2_upb_po_detail c on c.ireq_id=a.ireq_id 
				join plc2.plc2_upb_po cc on cc.ipo_id=c.ipo_id
				join plc2.plc2_upb_ro_detail d on d.raw_id=c.raw_id  and d.ipo_id=cc.ipo_id
				join plc2.plc2_upb_ro dd on dd.iro_id=d.iro_id
				where a.ireq_id='".$rowData['ireq_id']."'
				and b.raw_id='".$row['raw_id']."' 
				and a.ldeleted=0
				and b.ldeleted=0
				and c.ldeleted=0
				and cc.ldeleted=0
				and d.ldeleted=0
				and dd.ldeleted=0
				";
        $rraw = $this->db_plc0->query($hsql)->result_array();
        $data['datas']=$rraw ;
		return $this->load->view('lokal/history_terima_bb',$data,TRUE); 
		
	}

	function updateBox_bahan_baku_terima_sample_vreq_nomor($name, $id, $value, $rowData) {
		$sql = "SELECT vreq_nomor FROM ".$this->_table2." r WHERE r.ireq_id = '".$rowData['ireq_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="hidden" value="'.$rowData['ireq_id'].'" name="vreq_id" id="vreq_id"><span id="'.$id.'">'.$row['vreq_nomor'].'</span>';
	}
	function updateBox_bahan_baku_terima_sample_vro_nomor($name, $id, $value, $rowData) {
		$sql = "SELECT vro_nomor FROM ".$this->_table4." r WHERE r.iro_id = '".$rowData['iro_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<span id="'.$id.'">'.$row['vro_nomor'].'</span>';
	}
	function updateBox_bahan_baku_terima_sample_iupb_id($name, $id, $value, $rowData) {
		$sql = "SELECT vupb_nomor,u.iupb_id FROM ".$this->_table2." r INNER JOIN ".$this->_table3." u ON r.iupb_id = u.iupb_id WHERE r.ireq_id = '".$rowData['ireq_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '
		<input type="hidden" value="'.$row['iupb_id'].'" name="iupb_id" id="iupb_id">
		<span id="'.$id.'">'.$row['vupb_nomor'].'</span>';
	}
	function updateBox_bahan_baku_terima_sample_vrec_jum_pd($name, $id, $value, $rowData) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			return '<input type="text" class="add required" name="'.$id.'" id="'.$id.'" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> '.$rowData['vsatuan'].'';
		}else{
			return '<input type="text" class="add" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> '.$rowData['vsatuan'].'';
		}
	}
	function updateBox_bahan_baku_terima_sample_vwadah($name, $id, $value, $rowData) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			return '<input type="text" class="required" name="'.$id.'" id="'.$id.'" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> ';
		}
		else{
			return '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> ';
		}
	}
	function updateBox_bahan_baku_terima_sample_vrec_nip_pd($name, $id, $value, $rowData) {
		$mydivid=$this->user->gDivId; 
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="required" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class=" required input_rows1" size="35" />';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_pd&filterdiv='.$mydivid.'\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}
		else{
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_pd&filterdiv=5\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}
		
		
		return $return;
	}	
	function updateBox_bahan_baku_terima_sample_trec_date_pd($name, $id, $value) {
	
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			// //echo $value;
			// $value=to_mysql($val, TRUE);
			return '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />
			<input type="text" class="required input_tgl datepicker input_rows1" name="'.$id.'_dis" id="'.$id.'_dis" value="'.$val.'">';
		}
		else{
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			return '<input type="text" class="input_tgl input_rows1" value="'.$val.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis">';
		}
	}
	
	function updateBox_bahan_baku_terima_sample_vrec_jum_qc($name, $id, $value, $rowData) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			return '<input type="text" class="required add" name="'.$id.'" id="'.$id.'" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> '.$rowData['vsatuan'].'';
		}else{
			return '<input type="text" class="add" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isFloatKey(event)" /> '.$rowData['vsatuan'].'';
		}
	}
	function updateBox_bahan_baku_terima_sample_vrec_nip_qc($name, $id, $value, $rowData) {
		$mydivid=$this->user->gDivId; 
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="required" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="required input_rows1" size="35" />';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_qc&filterdiv='.$mydivid.'\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}

		else{
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_qc&filterdiv=2\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}
		
		return $return;
	}
	function updateBox_bahan_baku_terima_sample_trec_date_qc($name, $id, $value) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		if(($type=='PD')){
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			return '<input type="text" class="required input_tgl datepicker input_rows1" name="'.$id.'_dis" id="'.$id.'_dis" value="'.$val.'">
			<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
		}
		else{
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			return '<input type="text" class="input_tgl input_rows1" value="'.$val.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis">';
		}
	}
	
	function updateBox_bahan_baku_terima_sample_vrec_jum_qa($name, $id, $value, $rowData) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('QA', $manager)){$type='QA';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('QA', $team)){$type='QA';}
			else{$type='';}
		}
		if(($type=='QA')){
			return '<input type="text" class=" required add" name="'.$id.'" id="'.$id.'" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isNumberKey(event)" /> '.$rowData['vsatuan'].'';
		}else{
			return '<input type="text" class="add" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="5" value="'.$value.'" style="text-align: right;" onkeypress="return isNumberKey(event)" /> '.$rowData['vsatuan'].'';
		}
	}
	function updateBox_bahan_baku_terima_sample_vrec_nip_qa($name, $id, $value, $rowData) {
		$mydivid=$this->user->gDivId; 
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('QA', $manager)){$type='QA';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('QA', $team)){$type='QA';}
			else{$type='';}
		}
		if(($type=='QA')){
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="required" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis"  class=" required input_rows1" size="35" />';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_qa&filterdiv='.$mydivid.'\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}
		else{
			$row = $this->db_plc0->get_where($this->_table6, array('cNip'=>$value))->row_array();
			$disval = '';
			if(!empty($row)) {
				$disval = $row['cNip'].' - '.$row['vName'];
			}
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			//$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
			$return .= '<input type="text" value="'.$disval.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/employee/list/popup?field=bahan_baku_terima_sample&col=vrec_nip_qa&filterdiv=89\',\'List Karyawan\')" type="button">&nbsp;</button>';
		}
		return $return;
	}
	function updateBox_bahan_baku_terima_sample_trec_date_qa($name, $id, $value) {
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('QA', $manager)){$type='QA';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('QA', $team)){$type='QA';}
			else{$type='';}
		}
		if(($type=='QA')){
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			return '<input type="text" class=" required input_tgl datepicker input_rows1" name="'.$id.'_dis" id="'.$id.'_dis" value="'.$val.'">
			<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="" />';
		}
		else{
			$this->load->helper('to_mysql');
			$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
			return '<input type="text" class="input_tgl input_rows1" value="'.$val.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis">';
		}
	}
	
	 function before_update_processor($row, $post) {
		$iupb_id=$post['iupb_id'];
		unset($post['iupb_id']);
		unset($post['vsatuan']);
		unset($post['imanufacture_id']);
		unset($post['raw_id']);
		unset($post['vnama_produk']);
		unset($post['vbatch_no']);
		unset($post['ijumlah']);
		unset($post['texp_date']);
		
		if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
    		elseif(in_array('QA', $manager)){$type='QA';}
    		//elseif(in_array('QC', $manager)){$type='QC';}
			else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			//elseif(in_array('QC', $team)){$type='QC';}
			elseif(in_array('QA', $team)){$type='QA';}
			else{$type='';}
		}
		
		if(($type=='QA')){
			$post['trec_date_qa']=date('Y-m-d', strtotime($post['trec_date_qa_dis']));
			unset($post['vrec_jum_qc']);
			unset($post['vrec_nip_qc']);
			unset($post['trec_date_qc_dis']);
			unset($post['trec_date_qc']);
			unset($post['vrec_jum_pd']);
			unset($post['vrec_nip_pd']);
			unset($post['trec_date_pd_dis']);
			unset($post['trec_date_pd']);
			unset($post['vwadah']);
			
		//	$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,8,0);

		}
		// if(($type=='QC')){
			// $post['trec_date_qc']=date('Y-m-d', strtotime($post['trec_date_qc_dis']));
			// unset($post['vrec_jum_qa']);
			// unset($post['vrec_nip_qa']);
			// unset($post['trec_date_qa_dis']);
			// unset($post['trec_date_qa']);
			// unset($post['vrec_jum_pd']);
			// unset($post['vrec_nip_pd']);
			// unset($post['trec_date_pd_dis']);
			// unset($post['trec_date_pd']);
			// unset($post['vwadah']);
		// }
		if(($type=='PD')){
		//	$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,6,0);
			//$post['trec_date_pd']=date('Y-m-d', strtotime($post['trec_date_pd_dis']));
			if(isset($post['trec_date_qc'])){
				$post['trec_date_qc']=date('Y-m-d', strtotime($post['trec_date_qc_dis']));
			}
			if(isset($post['trec_date_pd'])){
				$post['trec_date_pd']=date('Y-m-d', strtotime($post['trec_date_pd_dis']));
			}
			unset($post['vrec_jum_qa']);
			unset($post['vrec_nip_qa']);
			unset($post['trec_date_qa_dis']);
			unset($post['trec_date_qa']);
			// unset($post['vrec_jum_qc']);
			// unset($post['vrec_nip_qc']);
			// unset($post['trec_date_qc_dis']);
			// unset($post['trec_date_qc']);
		
		}
		// if($post['vrec_jum_qc']==''){unset($post['vrec_jum_qc']);}
		// if($post['vrec_nip_qc']==''){unset($post['vrec_nip_qc']);}
		// if($post['trec_date_qc_dis']==''){unset($post['trec_date_qc']);}
		// else{$post['trec_date_qc']=date('Y-m-d', strtotime($post['trec_date_qc_dis']));}
		// if($post['vrec_jum_qa']==''){unset($post['vrec_jum_qa']);}
		// if($post['vrec_nip_qa']==''){unset($post['vrec_nip_qa']);}
		// if($post['trec_date_qa_dis']==''){unset($post['trec_date_qa']);}
		// else{$post['trec_date_qa']=date('Y-m-d', strtotime($post['trec_date_qa_dis']));}
		// if($post['vrec_jum_pd']==''){unset($post['vwadah']);}
		// if($post['vrec_jum_pd']==''){unset($post['vrec_jum_pd']);}
		// if($post['vrec_nip_pd']==''){unset($post['vrec_nip_pd']);}
		// if($post['trec_date_pd_dis']==''){unset($post['trec_date_pd']);}
		// else{$post['trec_date_pd']=date('Y-m-d', strtotime($post['trec_date_pd_dis']));}
		// // $post['trec_date_pd']=date('Y-m-d', strtotime($post['trec_date_pd_dis']));
		// //print_r($post);
		// unset($post['trec_date_pd_dis']);
		// unset($post['trec_date_qa_dis']);
		// unset($post['trec_date_qc_dis']);
	
		// print_r($post);
		// $user = $this->auth_localnon->user();
		// $skrg = date('Y-m-d H:i:s');
		 return $post;
	 }

	function output(){		
    	$this->index($this->input->get('action'));
    }
}