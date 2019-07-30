<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upb_input_sample_originator extends MX_Controller {
	private $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		 $this->load->library('auth_localnon');
        $this->load->library('biz_process');
        $this->load->library('lib_flow');
		$this->user = $this->auth_localnon->user();
		$this->url = 'upb_input_sample_originator'; 
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Input Sample Originator');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('upb_input_sample_originator');
		$grid->addList('plc2_upb_request_originator.vreq_ori_no','vupb_nomor','vupb_nama','vgenerik','plc2_upb_master_kategori_upb.vkategori','ibe','iteampd_id','plc2_upb_request_originator.isent_status');		
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('plc2_upb_request_originator.vreq_ori_no', '100');
		$grid->setWidth('vupb_nomor', '100');
		$grid->setWidth('ikategoriupb_id', '120');
		$grid->setWidth('ibe', '100');
		$grid->setWidth('iteampd_id', '150');
		$grid->setWidth('vupb_nama', '250');
		$grid->setWidth('vgenerik', '250');
		$grid->addFields('no_request','vgenerik','vupb_nomor','ttanggal','cnip','vupb_nama','vgenerik');
		$grid->addFields('iteampd_id','iteamqa_id','iteamqc_id','detail');
		$grid->setLabel('plc2_upb_request_originator.vreq_ori_no', 'No. Request');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori', 'Kategori UPB');
		$grid->setLabel('ibe', 'Tipe BE');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('ttanggal', 'Tanggal UPB');
		$grid->setLabel('cnip', 'Nip Pengusul');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('iteamqa_id', 'Team QA');
		$grid->setLabel('iteamqc_id', 'Team QC');
		$grid->setLabel('plc2_upb_request_originator.isent_status', 'Sent Status');
		
		
//		$grid->setRelation('ikategoriupb_id','plc2.plc2_upb_master_kategori_upb','ikategori_id','vkategori','upb_kat','inner','ldeleted=0');
//		$grid->setRelation('iupb_id','plc2.plc2_upb_request_originator','ireq_ori_id','vreq_ori_no','plc2_upb_request_originator.iupb_id','inner','ldeleted=0');

		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = plc2.plc2_upb.ikategoriupb_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_request_originator', 'plc2_upb_request_originator.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setQuery('plc2_upb.ldeleted', 0);
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('asc');
		$grid->setQuery('plc2_upb.iappdireksi', 2);
		$grid->setQuery('plc2_upb_request_originator.ldeleted', 0);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		$grid->setQuery('plc2_upb_request_originator.iapppd', 2);
		$grid->setGroupBy('plc2_upb_request_originator.ireq_ori_id');
		
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
			elseif(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
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
			elseif(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		
		$grid->changeFieldType('ibe','combobox','',array(''=>'--Select--',1=>'BE', 2=>'Non BE'));
		$grid->changeFieldType('plc2_upb_request_originator.isent_status','combobox','',array(''=>'--Select--',0=>'Have not been sent', 1=>'Sent'));
	
		$grid->setSearch('vupb_nomor','plc2_upb_request_originator.vreq_ori_no','vupb_nama','vgenerik','ibe','iteampd_id','plc2_upb_master_kategori_upb.vkategori','plc2_upb_request_originator.isent_status');
		$grid->searchOperand('iteampd_id', 'eq');
		
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
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				//echo $grid->updated_form();
				$this->saving();
				break;
			case 'detail':
				$this->detail();
			break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function output(){
    	$this->index($this->input->get('action'));
    }

    

	function manipulate_update_button($buttons) {
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update']);
			unset($buttons['update_back']);
			
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('BD', $manager)){$type='BD';}
				elseif(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('QA', $manager)){$type='QA';}
				elseif(in_array('AD', $manager)){$type='AD';}
				else{$type='';}
				//echo $type;
			}
			else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('BD', $team)){$type='BD';}
				elseif(in_array('PD', $team)){$type='PD';}
				elseif(in_array('QA', $team)){$type='QA';}
				elseif(in_array('AD', $team)){$type='AD';}
				else{$type='';}
			}
			
			if($type!=''){
				$js ="<script type='text/javascript'>

						function update_btn_".$this->url."(grid, url, dis) {
							var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
							var conf=0;
							var alert_message = '';
							$.each(req, function(i,v){
								$(this).removeClass('error_text');
								if($(this).val() == '') {
									var id = $(this).attr('id');
									var label = $('label[for=\"'+id+'\"]').text();
									label = label.replace('*','');
									// alert_message += '<br /><b>'+label+'</b> '+required_message;			
									alert_message +='<b>Field '+label+' Required!</b> <br/>';			
									$(this).addClass('error_text');			
									conf++;
								}		
							})
							if(conf > 0) {
								//$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
								//_custom_alert(alert_message,'Error!','info',grid, 1, 5000);		
								showMessage(alert_message);
							}
							else {
								custom_confirm(comfirm_message,function(){			
									$.ajax({
										url: $('#form_update_'+grid).attr('action'),
										type: 'post',
										data: $('#form_update_'+grid).serialize(),
										success: function(data) {
											var o = $.parseJSON(data);
											console.log(o);
											var info = 'Error';
											var header = 'Error';
											var last_id = o.iupb_id;
											var req_id = o.req_id;											
											if(o.status == true) {
												$('#button_update_upb_input_sample_originator').hide();
												//$('#form_update_'+grid)[0].reset();
												info = 'info';
												header = 'Info';
												_custom_alert(o.message,header,info, grid, 1, 20000);
												$.get(url+'&action=update&id='+last_id+'&req_id='+req_id, function(data) {
							                        $('div#form_'+grid).html(data);
							                        $('#button_update_upb_input_sample_originator').hide();
							                        //$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
												});
											}
											$('#grid_'+grid).trigger('reloadGrid');
										}
									})
								})
							}		
						}


					</script>";
				//$save = $js.'<button type="button" class="ui-button-text icon-save" id="btn_save_plc_input_sample_originator">Save</button>';
				$btnSave = $js."<button type='button'
                                    name='button_update_".$this->url."'
                                    id='button_update_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:update_btn_".$this->url."(\"upb_input_sample_originator\", \"".base_url()."processor/plc/upb_input_sample_originator?action=updateproses&id&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Update
                                    </button>";	
				$buttons['update'] = $btnSave;
			}
		}
		// array_unshift($buttons, $save);
		return $buttons;
	}
	function detail() {
		$echo = 'Note Pengiriman : <textarea></textarea><br />';
		$echo .= 'User Pengirim : ';
		echo $echo;
	}
	function updateBox_upb_input_sample_originator_vupb_nomor($field, $id, $value, $rowData) {
    	return $value;
    }
	function updateBox_upb_input_sample_originator_ttanggal($field, $id, $value, $rowData) {
    	return date('l, F jS, Y', strtotime($value));
    }
	function updateBox_upb_input_sample_originator_cnip($field, $id, $value, $rowData) {
		$user = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
    	return $user['cNip'].' | '.$user['vName'];
    }
	function updateBox_upb_input_sample_originator_vupb_nama($field, $id, $value, $rowData) {
    	return $value;
    }
	function updateBox_upb_input_sample_originator_vgenerik($field, $id, $value, $rowData) {
    	return $value;
    }
	function listBox_upb_input_sample_originator_iteampd_id($value) {
		/*$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	//print_r($team);
    	$x = $team->vteam;
    	//exit;
		return $x;*/
		
		$sql="select vteam from plc2.plc2_upb_team where iteam_id='".$value."'";
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$vteam = $row->vteam;
		} else {
			$vteam = '';
		}
		
		return $vteam;
    } 

    	function listBox_upb_input_sample_originator_plc2_upb_request_originator_isent_status($value) {
		
		if ($value==1) {
			$o='Sent';	
		}else{
			$o='Have not been sent';	
		}

		
		return $o;
    } 

    public function listBox_Action($row, $actions) {
    	$id= $row->iupb_id;
    	$status_sent = $row->plc2_upb_request_originator__isent_status;
    	$no_req = $row->plc2_upb_request_originator__vreq_ori_no;
    	//print_r($row);

    	$x=$this->auth_localnon->dept();
		$team=$x['team'];

		
		unset($actions['edit']);
		unset($actions['view']);
		unset($actions['delete']);
/*
		$sql_cek ='select *  from plc2.plc2_upb_date_sample a
				join plc2.plc2_upb_request_originator b on b.ireq_ori_id = a.iReq_ori_id
				join plc2.plc2_upb c on a.iupb_id=b.iupb_id
				where b.vreq_ori_no = "'.$no_req.'"
				group by a.iKirimID
				ORDER BY iCounter ASC';
*/
		$sql_cek ='select * from plc2.plc2_upb a 
				join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id
				left join plc2.plc2_upb_date_sample c on c.iReq_ori_id=b.ireq_ori_id
				where b.vreq_ori_no = "'.$no_req.'"
				group by c.iKirimID';
		$data_request = $this->db_plc0->query($sql_cek)->row_array();
		
		if(in_array('AD', $team) or in_array('PD', $team) ){
			
			if ($data_request['dTanggalTerimaAD']=='' and $status_sent==1  ) {
				$edit = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=update&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-pencil"></span></center></a>';
				$actions['edit'] = $edit ;
			}
				$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
				$actions['view'] = $view;
			
		}

		elseif(in_array('PD', $team)){
			
			
			//print_r($data_request);
			if ($status_sent==1 and $data_request['dTanggalTerimaPD']=='' ) {
				$edit = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=update&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-pencil"></span></center></a>';
				$actions['edit'] = $edit ;
			}
			$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
			$actions['view'] = $view;


		}
		elseif(in_array('QA', $team)){
			
			if ($data_request['dTanggalTerimaQA']=='' and $status_sent==1 ) {
				$edit = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=update&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-pencil"></span></center></a>';
				$actions['edit'] = $edit ;
			}
				$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
				$actions['view'] = $view;
			
		}

/*
		elseif(in_array('AD', $team) or in_array('PD', $team) ){
			
			if ($data_request['dTanggalTerimaAD']=='' and $status_sent==1  ) {
				$edit = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=update&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-pencil"></span></center></a>';
				$actions['edit'] = $edit ;
			}
				$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
				$actions['view'] = $view;
			
		}
*/
		elseif(in_array('BD', $team)){
			
			if ($status_sent==0) {
				$edit = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=update&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-pencil"></span></center></a>';
				$actions['edit'] = $edit ;
			}
			$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
			$actions['view'] = $view;
		}
		else{$type='';
			
			$view = '<a onclick="javascript:edit_btn( \''.base_url().'processor/plc/upb/input/sample/originator?action=view&id='.$id.'&req_id='.$row->plc2_upb_request_originator__vreq_ori_no.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'upb_input_sample_originator\')" ><center><span style="margin-bottom:2px;" class="ui-icon ui-icon-lightbulb"></span></center></a>';
			$actions['view'] = $view;


		}
		
		/*
		if (login = PD ) {
					# code...
		}elseif( login = BD ){

		}else{
			// login = AD
		}
		*/
		
		
		return $actions;
		
    }


    function searchBox_upb_input_sample_originator_iteampd_id($rowData, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
    	$o = '<select id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }

   

    function insertBox_upb_input_sample_originator_iteampd_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
    	$o = '<select name="'.$field.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_input_sample_originator_no_request($field, $id, $value, $rowData) {
			//$o=$rowData['vreq_ori_no'];
    	//$row->plc2_upb_request_originator__vreq_ori_no
    	if ($_GET['req_id']) {
    		$req_id=$_GET['req_id'];
    			//$req_id=print_r($rowData);
    	}else{
    		$req_id='';	
    	}
    	


    	if ($this->input->get('action') == 'view') {
			$o=$req_id;

		}else{
			$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$req_id."' size='8'/>";
			$o .= $req_id;
		}
		
		return $o;

	}

    function updateBox_upb_input_sample_originator_iteampd_id($field, $id, $value, $rowData) {
    	$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
    	if($value==0 || $value==''){
			return '-';
		}
		else{
			return $row['vteam'];
		}
		
    }
	function updateBox_upb_input_sample_originator_iteamqa_id($field, $id, $value, $rowData) {
    	$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
    	if($value==0 || $value==''){
			return '-';
		}
		else{
			return $row['vteam'];
		}
    }
	function updateBox_upb_input_sample_originator_iteamqc_id($field, $id, $value, $rowData) {
    	$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
    	if($value==0 || $value==''){
			return '-';
		}
		else{
			return $row['vteam'];
		}
    }
	function updateBox_upb_input_sample_originator_detail($field, $id, $value, $rowData) {
		//print_r($rowData);
		//$sql = "SELECT * FROM plc2.plc2_upb_date_sample ds WHERE ds.iupb_id = '".$rowData['iupb_id']."' ORDER BY iCounter ASC";
		$sql='select *  from plc2.plc2_upb_date_sample a
				join plc2.plc2_upb_request_originator b on b.ireq_ori_id = a.iReq_ori_id
				join plc2.plc2_upb c on a.iupb_id=b.iupb_id
				where b.iupb_id="'.$rowData['iupb_id'].'" 
				and b.ldeleted=0
				group by a.iKirimID
				ORDER BY iCounter ASC';
		$cek_ori_new ='select *  from plc2.plc2_upb_date_sample a
				join plc2.plc2_upb_request_originator b on b.ireq_ori_id = a.iReq_ori_id
				join plc2.plc2_upb c on a.iupb_id=b.iupb_id
				where b.iupb_id="'.$rowData['iupb_id'].'"
				and b.ldeleted=0
				and b.vreq_ori_no ="'.$_GET['req_id'].'"
				group by a.iKirimID
				ORDER BY iCounter ASC';

		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		$data['reqs'] = $this->db_plc0->query($cek_ori_new)->result_array();
		$data['iupb_id'] = $rowData['iupb_id'];
		return $this->load->view('upb_input_sample_originator_detail',$data, TRUE);
	}


	function savingold() {
		$this->load->helper('to_mysql');
		$post = $this->input->post();
		 //print_r($post);
		unset($post['upb_input_sampel_nama_nip_bd']);
		unset($post['upb_input_sampel_nama_nip_pd']);
		unset($post['upb_input_sampel_nama_nip_ad']);
		unset($post['upb_input_sampel_nama_nip_qa']);
		
		$post['cAdmPD']  = isset($post['dTanggalTerimaPD']) ? $this->user->gNIP : '';
		$post['cAdmAD']  = isset($post['dTanggalTerimaAD']) ? $this->user->gNIP : '';
		$post['cAdmQA']  = isset($post['dTanggalTerimaQA']) ? $this->user->gNIP : '';

		
			
		//$post['dTanggalKirimBD']  = !empty($post['dTanggalKirimBD'])  ? to_mysql($post['dTanggalKirimBD'])  : '';
		//echo $post['dTanggalKirimBD']; exit;
		$depts = $this->auth_localnon->my_depts(TRUE);
		if(in_array('BD', $depts)){
			$sql_req = 'select * from plc2_upb_request_originator a where a.vreq_ori_no="'.$post['upb_input_sample_originator_no_request'].'"';
			$data_req = $this->dbset->query($sql_req)->row_array();
				$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
				
				//print_r($post);exit;
				$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
				
				if(isset($rowc['iCounter'])){
					
				//print_r($post);exit;
				 if(isset($post['dTanggalKirimBD'])){
				 	
					foreach($post['dTanggalKirimBD'] as $k => $v) {
						if($v != '' and $v != '0000-00-00'  ) {
							if($post['cPengirimBD'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error 1!';//exit;
							}
							else{
								
								$idet['dTanggalKirimBD'] = to_mysql($v);
								$idet['cPengirimBD'] = $post['cPengirimBD'][$k];
								$idet['txtNoteBD'] = $post['txtNoteBD'][$k];
								$idet['cAdmBD'] = $this->user->gNIP;
								$idet['dInputBD'] = date('Y-m-d H:i:s');
								$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
								
								$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
								$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
								$resp['status'] = TRUE;
								$resp['message'] = 'Success!';
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];


							}
						}					
					}
					$dupb['isent_status']='1';
					$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
					$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
				 }
				 
				 else{
				 //print_r($post);exit;
				 	if(!empty($post['dTanggalKirimBDa']) && $post['dTanggalKirimBDa'] != '' && $post['dTanggalKirimBDa'] != '0000-00-00') {
						if(!empty($post['cPengirimBDa']) && $post['cPengirimBDa'] != '' ){
							
							$idet['dTanggalKirimBD'] = to_mysql($post['dTanggalKirimBDa']);
							$idet['cPengirimBD'] = $post['cPengirimBDa'];
							$idet['txtNoteBD'] = $post['txtNoteBDa'];
							$idet['cAdmBD'] = $this->user->gNIP;
							$idet['dInputBD'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];

							$dupb['isent_status']='1';
							$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
							$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 2'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 3'; //exit;
						}
				 }
				}
				else{
					if(!empty($post['dTanggalKirimBDa']) && $post['dTanggalKirimBDa'] != '' && $post['dTanggalKirimBDa'] != '0000-00-00') {
						if(!empty($post['cPengirimBDa']) && $post['cPengirimBDa'] != '' ){
							
							$idet['dTanggalKirimBD'] = to_mysql($post['dTanggalKirimBDa']);
							$idet['cPengirimBD'] = $post['cPengirimBDa'];
							$idet['txtNoteBD'] = $post['txtNoteBDa'];
							$idet['cAdmBD'] = $this->user->gNIP;
							$idet['dInputBD'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];


							$dupb['isent_status']='1';
							$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
							$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
				}

		//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],5,0);
		}
		//PD
		elseif(in_array('PD', $depts)){
		$x=0;
		$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
		$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
						
		//print_r($post);
				//if($post['iKirimID']){
				//if(isset($post['dTanggalTerimaPD'])){echo"ss";}else{echo "ff";}
				if(isset($rowc['iCounter'])){
					if(isset($post['dTanggalTerimaPD'])){
						foreach($post['dTanggalTerimaPD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00' ) {
								//print_r($post);
								if($post['cPenerimaPD'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
								}
								// elseif(($post['dTanggalTerimaAD'][$k]!='')&&($post['cPenerimaAD'][$k]=='')){
									// $resp['status'] = FALSE;
									// $resp['message'] = 'Error!';//exit;
								// }
								else{
									$idet['dTanggalTerimaPD'] = to_mysql($v);
									$idet['cPenerimaPD'] = $post['cPenerimaPD'][$k];
									$idet['txtNotePD'] = $post['txtNotePD'][$k];
									$idet['cAdmPD'] = $this->user->gNIP;
									$idet['dInputPD'] = date('Y-m-d H:i:s');
									// $idet['dTanggalTerimaAD'] = to_mysql($v);
									// $idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									// $idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									// $idet['cAdmAD'] = $this->user->gNIP;
									// $idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'PD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								}
								
								
								
								
					

				

								
							}
						}
					}
					if(isset($post['dTanggalTerimaAD'])){
						foreach($post['dTanggalTerimaAD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00') {
								//print_r($post);
								if(($post['cPenerimaAD'][$k]=='')){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
								}
								else{
									$idet['dTanggalTerimaAD'] = to_mysql($v);
									$idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									$idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									$idet['cAdmAD'] = $this->user->gNIP;
									$idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'AD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								}
								
							}
						}
					}
					if((empty($post['dTanggalTerimaPD']))&&(empty($post['dTanggalTerimaAD']))){
						if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
							if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
								$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
								$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
								$idet['txtNotePD'] = $post['txtNotePDa'];
								$idet['cAdmPD'] = $this->user->gNIP;
								$idet['dInputPD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'PD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
							if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
								$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
								$idet['cPenerimaAD'] = $post['cPenerimaADa'];
								$idet['txtNoteAD'] = $post['txtNoteADa'];
								$idet['cAdmAD'] = $this->user->gNIP;
								$idet['dInputAD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'AD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if($resp['status'] == true){
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						}
					}
				}
				else{
					if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
						if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
							$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
							$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
							$idet['txtNotePD'] = $post['txtNotePDa'];
							$idet['cAdmPD'] = $this->user->gNIP;
							$idet['dInputPD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'PD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
						if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
							$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
							$idet['cPenerimaAD'] = $post['cPenerimaADa'];
							$idet['txtNoteAD'] = $post['txtNoteADa'];
							$idet['cAdmAD'] = $this->user->gNIP;
							$idet['dInputAD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'AD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if($resp['status'] == true){
						$idet['iCounter'] = $post['iCounter'];
						$idet['iupb_id'] = $post['iupb_id'];
						$idet['iCompanyId'] = $post['company_id'];
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						
						$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
						$resp['status'] = TRUE;
						$resp['message'] = 'Success!';
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
					}
					
				}

				if ($resp['posisi'] == 'PD') {
				//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],6,0);		
				}else{
				//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],7,0);	
				}
				
		}
		//QA		
		elseif(in_array('QA', $depts)){
		$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
				
				//print_r($post);exit;
				$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
				
				if(isset($rowc['iCounter'])){
				//print_r($post);exit;
				 if(isset($post['dTanggalTerimaQA'])){
					foreach($post['dTanggalTerimaQA'] as $k => $v) {
						if($v != '') {
							if($post['cPenerimaQA'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
							}
							else{
								$idet['dTanggalTerimaQA'] = to_mysql($v);
								$idet['cPenerimaQA'] = $post['cPenerimaQA'][$k];
								$idet['txtNoteQA'] = $post['txtNoteQA'][$k];
								$idet['cAdmQA'] = $this->user->gNIP;
								$idet['dInputQA'] = date('Y-m-d H:i:s');
								
								$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
								$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
								$resp['status'] = TRUE;
								$resp['message'] = 'Success!';
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							}
						}					
					}
				 }
				 else{
				 //print_r($post);exit;
				 	if(!empty($post['dTanggalTerimaQAa']) && $post['dTanggalTerimaQAa'] != '' && $post['dTanggalTerimaQAa'] != '0000-00-00') {
						if(!empty($post['cPenerimaQAa']) && $post['cPenerimaQAa'] != '' ){
							$idet['dTanggalTerimaQA'] = to_mysql($post['dTanggalTerimaQAa']);
							$idet['cPenerimaQA'] = $post['cPenerimaQAa'];
							$idet['txtNoteQA'] = $post['txtNoteQAa'];
							$idet['cAdmQA'] = $this->user->gNIP;
							$idet['dInputQA'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
				 }
				}
				else{
					if(!empty($post['dTanggalTerimaQAa']) && $post['dTanggalTerimaQAa'] != '' && $post['dTanggalTerimaQAa'] != '0000-00-00') {
						if(!empty($post['cPenerimaQAa']) && $post['cPenerimaQAa'] != '' ){
							$idet['dTanggalKirimQA'] = to_mysql($post['dTanggalTerimaQAa']);
							$idet['cPenerimaQA'] = $post['cPenerimaQAa'];
							$idet['txtNoteQA'] = $post['txtNoteQAa'];
							$idet['cAdmQA'] = $this->user->gNIP;
							$idet['dInputQA'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
				}
			//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],8,0);	
				
		}
		/*
		if($resp['status'] == TRUE){
			$resp['iupb_id'] = $post['iupb_id'];
			$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
			$iupb_id=$post['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
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
			}		
		}
		*/
		echo json_encode($resp);
	}
	function saving() {
		$this->load->helper('to_mysql');
		$post = $this->input->post();
		 //print_r($post);
		unset($post['upb_input_sampel_nama_nip_bd']);
		unset($post['upb_input_sampel_nama_nip_pd']);
		unset($post['upb_input_sampel_nama_nip_ad']);
		unset($post['upb_input_sampel_nama_nip_qa']);
		
		$post['cAdmPD']  = isset($post['dTanggalTerimaPD']) ? $this->user->gNIP : '';
		$post['cAdmAD']  = isset($post['dTanggalTerimaAD']) ? $this->user->gNIP : '';
		$post['cAdmQA']  = isset($post['dTanggalTerimaQA']) ? $this->user->gNIP : '';

		//$detil_id = $_POST['detil_id'];
			
		//$post['dTanggalKirimBD']  = !empty($post['dTanggalKirimBD'])  ? to_mysql($post['dTanggalKirimBD'])  : '';
		//echo $post['dTanggalKirimBD']; exit;
		$depts = $this->auth_localnon->my_depts(TRUE);
		if(in_array('BD', $depts)){
			
			$sql_req = 'select * from plc2_upb_request_originator a where a.vreq_ori_no="'.$post['upb_input_sample_originator_no_request'].'"';
			/*
			$sql_req = 'select * 
						from plc2_upb_request_originator a 
						join plc2.otc_request_ori_detail b on b.ireq_ori_id=a.ireq_ori_id
						where a.ldeleted=0
						and b.lDeleted=0
						and b.irequest_ori_detail="'.$detil_id.'"';
			*/
			$data_req = $this->dbset->query($sql_req)->row_array();
				$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
				
				//print_r($post);exit;
				$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
				
				if(isset($rowc['iCounter'])){
					
				//print_r($post);exit;
				 if(isset($post['dTanggalKirimBD'])){
				 	
					foreach($post['dTanggalKirimBD'] as $k => $v) {
						if($v != '' and $v != '0000-00-00'  ) {
							if($post['cPengirimBD'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error! 1';//exit;
							}
							else{
								
								$idet['dTanggalKirimBD'] = to_mysql($v);
								$idet['cPengirimBD'] = $post['cPengirimBD'][$k];
								$idet['txtNoteBD'] = $post['txtNoteBD'][$k];
								$idet['cAdmBD'] = $this->user->gNIP;
								$idet['dInputBD'] = date('Y-m-d H:i:s');
								$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
								//$idet['irequest_ori_detail'] = $data_req['irequest_ori_detail'];
								
								$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
								$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
								$resp['status'] = TRUE;
								$resp['message'] = 'Success!';
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								$resp['detil_id'] = $detil_id;


							}
						}					
					}
					
					
					$dupb['isent_status']='1';
					$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
					$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
					
					

				 }
				 
				 else{
				 //print_r($post);exit;
				 	if(!empty($post['dTanggalKirimBDa']) && $post['dTanggalKirimBDa'] != '' && $post['dTanggalKirimBDa'] != '0000-00-00') {
						if(!empty($post['cPengirimBDa']) && $post['cPengirimBDa'] != '' ){
							
							$idet['dTanggalKirimBD'] = to_mysql($post['dTanggalKirimBDa']);
							$idet['cPengirimBD'] = $post['cPengirimBDa'];
							$idet['txtNoteBD'] = $post['txtNoteBDa'];
							$idet['cAdmBD'] = $this->user->gNIP;
							$idet['dInputBD'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
							//$idet['irequest_ori_detail'] = $data_req['irequest_ori_detail'];
							
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);		


							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;

							$dupb['isent_status']='1';
							$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
							$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 2'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 3'; //exit;
						}
				 }
				}
				else{
					if(!empty($post['dTanggalKirimBDa']) && $post['dTanggalKirimBDa'] != '' && $post['dTanggalKirimBDa'] != '0000-00-00') {
						if(!empty($post['cPengirimBDa']) && $post['cPengirimBDa'] != '' ){
							
							$idet['dTanggalKirimBD'] = to_mysql($post['dTanggalKirimBDa']);
							$idet['cPengirimBD'] = $post['cPengirimBDa'];
							$idet['txtNoteBD'] = $post['txtNoteBDa'];
							$idet['cAdmBD'] = $this->user->gNIP;
							$idet['dInputBD'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$idet['iReq_ori_id'] = $data_req['ireq_ori_id'];
							//$idet['irequest_ori_detail'] = $data_req['irequest_ori_detail'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;


							$dupb['isent_status']='1';
							$this->db_plc0->where('vreq_ori_no', $post['upb_input_sample_originator_no_request']);
							$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 4'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error! 5'; //exit;
						}
				}

		//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],5,0);
		}
		//AD
		elseif(in_array('PD', $depts)){
		$x=0;
		$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
		$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
						
		//print_r($post);
				//if($post['iKirimID']){
				//if(isset($post['dTanggalTerimaPD'])){echo"ss";}else{echo "ff";}
				if(isset($rowc['iCounter'])){
					if(isset($post['dTanggalTerimaPD'])){
						foreach($post['dTanggalTerimaPD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00' ) {
								//print_r($post);
								if($post['cPenerimaPD'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error PD input cuy!';//exit;
								}
								// elseif(($post['dTanggalTerimaAD'][$k]!='')&&($post['cPenerimaAD'][$k]=='')){
									// $resp['status'] = FALSE;
									// $resp['message'] = 'Error!';//exit;
								// }
								else{
									$idet['dTanggalTerimaPD'] = to_mysql($v);
									$idet['cPenerimaPD'] = $post['cPenerimaPD'][$k];
									$idet['txtNotePD'] = $post['txtNotePD'][$k];
									$idet['cAdmPD'] = $this->user->gNIP;
									$idet['dInputPD'] = date('Y-m-d H:i:s');
									// $idet['dTanggalTerimaAD'] = to_mysql($v);
									// $idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									// $idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									// $idet['cAdmAD'] = $this->user->gNIP;
									// $idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'PD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
									//$resp['detil_id'] = $detil_id;
								}
								
								
								
								
					

				

								
							}
						}
					}
					if(isset($post['dTanggalTerimaAD'])){
						foreach($post['dTanggalTerimaAD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00') {
								//print_r($post);
								if(($post['cPenerimaAD'][$k]=='')){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error AD sini cuy!';//exit;
								}
								else{
									$idet['dTanggalTerimaAD'] = to_mysql($v);
									$idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									$idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									$idet['cAdmAD'] = $this->user->gNIP;
									$idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'AD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
									//$resp['detil_id'] = $detil_id;
								}
								
							}
						}
					}
					if((empty($post['dTanggalTerimaPD']))&&(empty($post['dTanggalTerimaAD']))){
						if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
							if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
								$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
								$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
								$idet['txtNotePD'] = $post['txtNotePDa'];
								$idet['cAdmPD'] = $this->user->gNIP;
								$idet['dInputPD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'PD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								$resp['detil_id'] = $detil_id;
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
							if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
								$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
								$idet['cPenerimaAD'] = $post['cPenerimaADa'];
								$idet['txtNoteAD'] = $post['txtNoteADa'];
								$idet['cAdmAD'] = $this->user->gNIP;
								$idet['dInputAD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'AD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								//$resp['detil_id'] = $detil_id;
								
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if($resp['status'] == true){
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							$resp['detil_id'] = $detil_id;
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
						}
					}
				}
				else{
					if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
						if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
							$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
							$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
							$idet['txtNotePD'] = $post['txtNotePDa'];
							$idet['cAdmPD'] = $this->user->gNIP;
							$idet['dInputPD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'PD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
						if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
							$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
							$idet['cPenerimaAD'] = $post['cPenerimaADa'];
							$idet['txtNoteAD'] = $post['txtNoteADa'];
							$idet['cAdmAD'] = $this->user->gNIP;
							$idet['dInputAD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'AD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
							
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if($resp['status'] == true){
						$idet['iCounter'] = $post['iCounter'];
						$idet['iupb_id'] = $post['iupb_id'];
						$idet['iCompanyId'] = $post['company_id'];
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						//$resp['detil_id'] = $detil_id;
						
						$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
						$resp['status'] = TRUE;
						$resp['message'] = 'Success!';
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
					//	$resp['detil_id'] = $detil_id;
					}
					
				}

				
				
		}
		elseif(in_array('AD', $depts)){
		$x=0;
		$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
		$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
						
		//print_r($post);
				//if($post['iKirimID']){
				//if(isset($post['dTanggalTerimaPD'])){echo"ss";}else{echo "ff";}
				if(isset($rowc['iCounter'])){
					if(isset($post['dTanggalTerimaPD'])){
						foreach($post['dTanggalTerimaPD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00' ) {
								//print_r($post);
								if($post['cPenerimaPD'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
								}
								// elseif(($post['dTanggalTerimaAD'][$k]!='')&&($post['cPenerimaAD'][$k]=='')){
									// $resp['status'] = FALSE;
									// $resp['message'] = 'Error!';//exit;
								// }
								else{
									$idet['dTanggalTerimaPD'] = to_mysql($v);
									$idet['cPenerimaPD'] = $post['cPenerimaPD'][$k];
									$idet['txtNotePD'] = $post['txtNotePD'][$k];
									$idet['cAdmPD'] = $this->user->gNIP;
									$idet['dInputPD'] = date('Y-m-d H:i:s');
									// $idet['dTanggalTerimaAD'] = to_mysql($v);
									// $idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									// $idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									// $idet['cAdmAD'] = $this->user->gNIP;
									// $idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'PD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
									//$resp['detil_id'] = $detil_id;
								}
								
								
								
								
					

				

								
							}
						}
					}
					if(isset($post['dTanggalTerimaAD'])){
						foreach($post['dTanggalTerimaAD'] as $k => $v) {
							if($v != '' and $v != '0000-00-00') {
								//print_r($post);
								if(($post['cPenerimaAD'][$k]=='')){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
								}
								else{
									$idet['dTanggalTerimaAD'] = to_mysql($v);
									$idet['cPenerimaAD'] = $post['cPenerimaAD'][$k];
									$idet['txtNoteAD'] = $post['txtNoteAD'][$k];
									$idet['cAdmAD'] = $this->user->gNIP;
									$idet['dInputAD'] = date('Y-m-d H:i:s');
									
									$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
									$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
									
									$resp['posisi'] = 'AD';
									$resp['status'] = TRUE;
									$resp['message'] = 'Success!';
									$resp['iupb_id'] = $post['iupb_id'];
									$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
									//$resp['detil_id'] = $detil_id;
								}
								
							}
						}
					}
					if((empty($post['dTanggalTerimaPD']))&&(empty($post['dTanggalTerimaAD']))){
						if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
							if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
								$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
								$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
								$idet['txtNotePD'] = $post['txtNotePDa'];
								$idet['cAdmPD'] = $this->user->gNIP;
								$idet['dInputPD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'PD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
								//$resp['detil_id'] = $detil_id;
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
							if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
								$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
								$idet['cPenerimaAD'] = $post['cPenerimaADa'];
								$idet['txtNoteAD'] = $post['txtNoteADa'];
								$idet['cAdmAD'] = $this->user->gNIP;
								$idet['dInputAD'] = date('Y-m-d H:i:s');
								
								$resp['posisi'] = 'AD';
								$resp['status'] = true;
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//	$resp['detil_id'] = $detil_id;
								
							}
							else{
								$resp['status'] = FALSE;
								$resp['message'] = 'Error!'; //exit;
							}
						}
						if($resp['status'] == true){
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
						}
					}
				}
				else{
					if(!empty($post['dTanggalTerimaPDa']) && $post['dTanggalTerimaPDa'] != '' && $post['dTanggalTerimaPDa'] != '0000-00-00') {
						if(!empty($post['cPenerimaPDa']) && $post['cPenerimaPDa'] != '' ){
							$idet['dTanggalTerimaPD'] = to_mysql($post['dTanggalTerimaPDa']);
							$idet['cPenerimaPD'] = $post['cPenerimaPDa'];
							$idet['txtNotePD'] = $post['txtNotePDa'];
							$idet['cAdmPD'] = $this->user->gNIP;
							$idet['dInputPD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'PD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						//	$resp['detil_id'] = $detil_id;
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if(!empty($post['dTanggalTerimaADa'])&& $post['dTanggalTerimaADa'] != '' && $post['dTanggalTerimaADa'] != '0000-00-00'){
						if(!empty($post['cPenerimaADa']) && $post['cPenerimaADa'] != ''){
							$idet['dTanggalTerimaAD'] = to_mysql($post['dTanggalTerimaADa']);
							$idet['cPenerimaAD'] = $post['cPenerimaADa'];
							$idet['txtNoteAD'] = $post['txtNoteADa'];
							$idet['cAdmAD'] = $this->user->gNIP;
							$idet['dInputAD'] = date('Y-m-d H:i:s');

							$resp['posisi'] = 'AD';
							$resp['status'] = true;
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						//	$resp['detil_id'] = $detil_id;
							
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					if($resp['status'] == true){
						$idet['iCounter'] = $post['iCounter'];
						$idet['iupb_id'] = $post['iupb_id'];
						$idet['iCompanyId'] = $post['company_id'];
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						$resp['detil_id'] = $detil_id;
						
						$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);
						$resp['status'] = TRUE;
						$resp['message'] = 'Success!';
						$resp['iupb_id'] = $post['iupb_id'];
						$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
						//$resp['detil_id'] = $detil_id;
					}
					
				}

				
				
		}
		//QA		
		elseif(in_array('QA', $depts)){
		$sql = "SELECT d.iCounter FROM plc2.plc2_upb_date_sample d WHERE d.iupb_id=".$post['iupb_id']." ORDER by d.iCounter DESC LIMIT 1";
				$rowc = $this->db_plc0->query($sql)->row_array();
				
				//print_r($post);exit;
				$post['iCounter'] = isset($rowc['iCounter']) ? intval($rowc['iCounter']) + 1 : 1;
				
				if(isset($rowc['iCounter'])){
				//print_r($post);exit;
				 if(isset($post['dTanggalTerimaQA'])){
					foreach($post['dTanggalTerimaQA'] as $k => $v) {
						if($v != '') {
							if($post['cPenerimaQA'][$k]==''){
									$resp['status'] = FALSE;
									$resp['message'] = 'Error!';//exit;
							}
							else{
								$idet['dTanggalTerimaQA'] = to_mysql($v);
								$idet['cPenerimaQA'] = $post['cPenerimaQA'][$k];
								$idet['txtNoteQA'] = $post['txtNoteQA'][$k];
								$idet['cAdmQA'] = $this->user->gNIP;
								$idet['dInputQA'] = date('Y-m-d H:i:s');
								
								$this->db_plc0->where('iKirimID', $post['iKirimID'][$k]);
								$this->db_plc0->update('plc2.plc2_upb_date_sample', $idet);
								$resp['status'] = TRUE;
								$resp['message'] = 'Success!';
								$resp['iupb_id'] = $post['iupb_id'];
								$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//	$resp['detil_id'] = $detil_id;
							}
						}					
					}
				 }
				 else{
				 //print_r($post);exit;
				 	if(!empty($post['dTanggalTerimaQAa']) && $post['dTanggalTerimaQAa'] != '' && $post['dTanggalTerimaQAa'] != '0000-00-00') {
						if(!empty($post['cPenerimaQAa']) && $post['cPenerimaQAa'] != '' ){
							$idet['dTanggalTerimaQA'] = to_mysql($post['dTanggalTerimaQAa']);
							$idet['cPenerimaQA'] = $post['cPenerimaQAa'];
							$idet['txtNoteQA'] = $post['txtNoteQAa'];
							$idet['cAdmQA'] = $this->user->gNIP;
							$idet['dInputQA'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
				 }
				}
				else{
					if(!empty($post['dTanggalTerimaQAa']) && $post['dTanggalTerimaQAa'] != '' && $post['dTanggalTerimaQAa'] != '0000-00-00') {
						if(!empty($post['cPenerimaQAa']) && $post['cPenerimaQAa'] != '' ){
							$idet['dTanggalKirimQA'] = to_mysql($post['dTanggalTerimaQAa']);
							$idet['cPenerimaQA'] = $post['cPenerimaQAa'];
							$idet['txtNoteQA'] = $post['txtNoteQAa'];
							$idet['cAdmQA'] = $this->user->gNIP;
							$idet['dInputQA'] = date('Y-m-d H:i:s');
							$idet['iCounter'] = $post['iCounter'];
							$idet['iupb_id'] = $post['iupb_id'];
							$idet['iCompanyId'] = $post['company_id'];
							
							$this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet);				
							$resp['status'] = TRUE;
							$resp['message'] = 'Success!';
							$resp['iupb_id'] = $post['iupb_id'];
							$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
							//$resp['detil_id'] = $detil_id;
						}
						else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
					}
					else{
							$resp['status'] = FALSE;
							$resp['message'] = 'Error!'; //exit;
						}
				}
			//	$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],8,0);	
				
		}
		/*
		if($resp['status'] == TRUE){
			$resp['iupb_id'] = $post['iupb_id'];
			$resp['req_id'] = $post['upb_input_sample_originator_no_request'];
			$iupb_id=$post['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
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
			}		
		}
		*/
		echo json_encode($resp);
	}

	/*function searchPost_upb_input_sample_originator_vupb_nomor($value, $field) {
		if($value == 'U01833')
			$value = 'U01832';
		return $value;
	}*/
}
