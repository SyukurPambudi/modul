<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_request_originator extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_localnon->user();
		$this->url = 'upb_request_originator';
		$this->_table = 'plc2.plc2_upb_request_originator';
		$this->load->library('lib_utilitas');
		$this->load->library('lib_flow');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Request Originator');
		//$grid->setTitle($this->user->gName);
		//dc.m_vendor  database.tabel
		$grid->setTable($this->_table);	

		$grid->setUrl('upb_request_originator');
		$grid->addList('vreq_ori_no','plc2_upb.vupb_nomor','cnip','iapppd','vnip_apppd');
		$grid->setSortBy('vreq_ori_no');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vreq_ori_no','iTujuan_req','iupb_id','vnama_originator','ijum_ori','plc2_master_satuan_id','trequest_ori','ireq_ke');

		//setting widht grid 950 width total
		$grid ->setWidth('vreq_ori_no', '150'); 
		$grid->setWidth('plc2_upb.vupb_nomor', '140'); 
		$grid->setWidth('cnip', '280'); 
		$grid->setWidth('iapppd', '100'); 
		$grid->setWidth('vnip_apppd', '280'); 

		
		//modif label
		$grid->setLabel('vreq_ori_no','No Req.Sample Originator'); //Ganti Label
		$grid->setLabel('iupb_id','No UPB'); //Ganti Label
		$grid->setLabel('plc2_upb.vupb_nomor','No UPB'); //Ganti Label
		$grid->setLabel('cnip','Nama');
		$grid->setLabel('iapppd','Status'); //Ganti Label
		$grid->setLabel('iUjiMikro','Uji Mikro '); //Ganti Label
		$grid->setLabel('vnip_apppd','Approve by');
		$grid->setLabel('vnama_originator','Nama Originator');
		$grid->setLabel('ijum_ori','Qty');
		$grid->setLabel('trequest_ori','Tgl Request');
		$grid->setLabel('ireq_ke','Request Ke');
		$grid->setLabel('iTujuan_req','Tujuan Request');
		$grid->setLabel('plc2_master_satuan_id','Satuan');
		

		
		
		$grid->setSearch('vreq_ori_no');
		$grid->setSearch('plc2_upb.vupb_nomor');
		$grid->setRequired('vreq_ori_no');	//Field yg mandatori
		$grid->setRequired('iTujuan_req');	//Field yg mandatori
		$grid->setRequired('iupb_id');	//Field yg mandatori
		$grid->setRequired('vnama_originator');	//Field yg mandatori
		$grid->setRequired('ijum_ori');	//Field yg mandatori
		$grid->setRequired('trequest_ori');	//Field yg mandatori
		$grid->setRequired('ireq_ke');	//Field yg mandatori
		$grid->setRequired('iUjiMikro');	//Field yg mandatori
		$grid->setFormUpload(TRUE);
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iapppd','combobox','',array(''=>'Pilih',0=>'Need Approval',1=>'Reject',2=>'Approve'));
		$grid->changeFieldType('iUjiMikro','combobox','',array(''=>'Pilih',1=>'Ya',0=>'Tidak'));

		// join table
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2.plc2_upb_request_originator.iupb_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2_upb_team.iteam_id = plc2.plc2_upb.iteampd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team_item', 'plc2_upb_team_item.iteam_id = plc2.plc2_upb_team.iteam_id', 'inner');
		$grid->setQuery('plc2_upb_request_originator.ldeleted',0);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		$sql = 'select * from plc2.plc_sysparam a where a.cVariable= "SU" ';
        $data = $this->db_plc0->query($sql)->row_array();
        $in_su= explode(',', $data['vContent']);


		if ($this->auth_localnon->is_dir()==1 or in_array($this->user->gNIP, $in_su) ) {
			
		}else{
			$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
		}

		
		/*
		if ($this->auth_localnon->is_dir()==1) {
			
		}else{
			if ('PD') {
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}else if ('BD'){
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}else if ('QA'){
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			
		}
		

		*/
		
		//Set View Gridnya (Default = grid)
		$grid->setSortBy('vreq_ori_no');
		$grid->setSortOrder('DESC');
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
			// ubah mailer ini ketika statusnya udah submit aja
				/*
				$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
						(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
						(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
						(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
						(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
						from plc2.plc2_upb u where u.iupb_id='".$_POST['upb_request_originator_iupb_id']."'";
				$rupb = $this->db_plc0->query($qupb)->row_array();

				$qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
			                    from plc2.plc2_upb u where u.iupb_id='".$_POST['upb_request_originator_iupb_id']."'";
				$rsql = $this->db_plc0->query($qsql)->row_array();

				$pd = $rsql['iteampd_id'];
				$bd = $rsql['iteambusdev_id'];
				$qa = $rsql['iteamqa_id'];
			                        
				$team = $pd ;
				$toEmail2='';
				$toEmail = $this->lib_utilitas->get_email_leader( $pd );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

				$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

				$to = $cc = '';
					if(is_array($arrEmail)) {
						$count = count($arrEmail);
						$to = $arrEmail[0];
						for($i=1;$i<$count;$i++) {
							$cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
						}
					}		

					$to = $toEmail;
					//$to = 'mansur@novellpharm.com';
					$cc = $arrEmail.';'.$toEmail2;
					//$cc = '';
					$subject="Request Originator - Need Approval PD Manager";
					$content="
						Diberitahukan bahwa telah ada Request Originator UPB oleh Staff PD pada proses Request Originator(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
						<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
							<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
								<tr>
									<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
								</tr>
								<tr>
									<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
								</tr>
								<tr>
									<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
								</tr>
								<tr>
									<td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
								</tr>
								<tr>
									<td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
								</tr>
								<tr>
									<td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
								</tr>
								<tr>
									<td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
								</tr>
		                                                <tr>
									<td><b>Proses Selanjutnya</b></td><td> : </td><td>Request Originator - Approval PD Manager</td>
								</tr>
							</table>
						</div>
						<br/> 
						Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						Post Master";
					$this->lib_utilitas->send_email($to, $cc, $subject, $content);
				*/	
				echo $grid->saved_form();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;

			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'gethistory':
				echo $this->gethistory();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;

			case 'updateproses':
				echo $grid->updated_form();
				break;
				
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/
    public function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$approval=$row->iapppd;
    	//formulator
		if($approval!=0){
			unset($actions['edit']);
			unset($actions['delete']);
		}

		return $actions;
    }

    function listBox_upb_request_originator_iupb_id($value, $pk, $name, $rowData) {
    	$sql = 'select * from plc2_upb a where a.iupb_id = "'.$value.'" ';
		$query = $this->dbset->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vupb_nomor;
		}
		
		return $nama_group;
	}

	function listBox_upb_request_originator_cnip($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vName;
		}
		
		return $nama_group;
	}
	function listBox_upb_request_originator_vnip_apppd($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vName;
		}
		
		return $nama_group;
	}

	

/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
	function insertbox_upb_request_originator_trequest_ori($field, $id) {
		//$date = date('Y-m-d H:i:s');
		$date = date('Y-m-d');
		$o = "<input type='text' name='".$id."' id='".$id."' readonly='readonly' value='".$date."' size='8'/>";
		return $o;
	}

	function updateBox_upb_request_originator_trequest_ori($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$o=$value;

		}else{
			$o = "<input type='text' name='".$id."' id='".$id."' readonly='readonly' value='".$value."' size='8'/>";
		}
		
		return $o;
	}
	function insertbox_upb_request_originator_vnama_originator($field, $id) {
		//$date = date('Y-m-d H:i:s');
		
		$o = "<input type='text' name='".$id."' id='".$id."' class='required' size='40'/>";
		 $o .= " <script>
                $('#".$id."').keyup(function() {
                var len = this.value.length;
                if (len >= 50) {
                this.value = this.value.substring(0, 50);
                }
                $('#upb_request_originator_vnama_originator_max').text(50 - len);
                });
            </script>";
        $o .= '<br/>tersisa <span id="upb_request_originator_vnama_originator_max">50</span> karakter<br/>';             
		
		return $o;
	}
	function updatebox_upb_request_originator_vnama_originator($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$o=$value;

		}else{
		
			$o = "<input type='text' name='".$id."' id='".$id."' class='required' value='".$value."' size='40'/>";
		 	$o .= " <script>
	                $('#".$id."').keyup(function() {
	                var len = this.value.length;
	                if (len >= 50) {
	                this.value = this.value.substring(0, 50);
	                }
	                $('#upb_request_originator_vnama_originator_max').text(50 - len);
	                });
            		</script>";
        	$o .= '<br/>tersisa <span id="upb_request_originator_vnama_originator_max">50</span> karakter<br/>';             
		}
		return $o;
	}

	function insertbox_upb_request_originator_vreq_ori_no($field, $id) {
		$o = '<label title="Auto Number">Auto Generate</label>
		<input type="hidden" name="isdraft" id="isdraft">';
		return $o;
	}

	function updatebox_upb_request_originator_vreq_ori_no($field, $id, $value, $rowData) {
		$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$value."'/>
		<input type='hidden' name='isdraft' id='isdraft'>";
		$o .= "<label title='Auto Number'>".$value."</label>";
		return $o;
	}

	function insertbox_upb_request_originator_plc2_master_satuan_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_master_satuan', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['plc2_master_satuan_id'].'">'.$t['vNmSatuan'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updatebox_upb_request_originator_plc2_master_satuan_id($field, $id, $value, $rowData) {
    	$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 ";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['plc2_master_satuan_id'] == $t['plc2_master_satuan_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['plc2_master_satuan_id'].'">'.$t['vNmSatuan'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }


	function insertBox_upb_request_originator_iTujuan_req($field, $id) {
		$o='<select id="iTujuan_req" class="required combobox" name="iTujuan_req">
				<option value="">--Select--</option>
				<option value="1">Untuk Sample</option>
				<option value="2">Untuk Skala Lab</option>
			</select>';

		$o .='
				<script type="text/javascript">
					$("#bt_req_ori_1").hide();
					$("#bt_req_ori_2").hide();
					$("#bt_req_ori_3").hide();
					$("#iTujuan_req").die();
					$("#iTujuan_req").live("change",function(){
						if ($( this ).val()=="") {
							alert("Tujuan harus diisi");
							$("#bt_req_ori_1").hide();
							$("#bt_req_ori_2").hide();
							$("#bt_req_ori_3").hide();
						}else{
							if ($( this ).val()==1) {
								$("#bt_req_ori_1").show();	
								$("#bt_req_ori_2").hide();
								$("#bt_req_ori_3").hide();
							}else{
								if ($( this ).val()==2) {
									$("#bt_req_ori_2").show();	
									$("#bt_req_ori_1").hide();
									$("#bt_req_ori_3").hide();
								}else{
									$("#bt_req_ori_3").show();	
									$("#bt_req_ori_1").hide();
									$("#bt_req_ori_2").hide();
								}
								
							}
							
						}

					})
				</script>
		';	
		return $o;
		
	}
	function updateBox_upb_request_originator_iTujuan_req($field, $id, $value,$rowData) {
        
        if ($this->input->get('action') == 'view') {
        	$lchoose = array(0=>'Select -One', 1=>'Untuk Sample', 2=>'Untuk Skala Lab');
            $o = $lchoose[$value];
        } else {
        	if ($rowData['iSubmit']<>0) {
        		$disabled='disabled=disabled';
        	}else{
        		$disabled='';
        	}

        	$lchoose = array(""=>'Select One', 1=>'Untuk Sample', 2=>'Untuk Skala Lab');
            $o  = "<select  name='".$field."' ".$disabled." id='".$id."' class='required combobox'>";            
            foreach($lchoose as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }

        $o .='
				<script type="text/javascript">
					
					
					if ( $("#upb_request_originator_iTujuan_req").val()==1 ) {
						$("#bt_req_ori_2").hide();	
						$("#bt_req_ori_3").hide();	
					}else if( $("#upb_request_originator_iTujuan_req").val()==2 ){
						$("#bt_req_ori_1").hide();
						$("#bt_req_ori_3").hide();	
					}else if( $("#upb_request_originator_iTujuan_req").val()==3 ){
						$("#bt_req_ori_1").hide();
						$("#bt_req_ori_2").hide();	
					}else{
						$("#bt_req_ori_1").hide();
						$("#bt_req_ori_2").hide();	
						$("#bt_req_ori_3").hide();	
					}
					$("#upb_request_originator_iTujuan_req").die();
					$("#upb_request_originator_iTujuan_req").live("change",function(){
						if ($( this ).val()=="") {
							alert("Tujuan harus diisi");
							$("#bt_req_ori_1").hide();
							$("#bt_req_ori_2").hide();
							$("#bt_req_ori_3").hide();
						}else{
							if ($( this ).val()==1) {
								$("#bt_req_ori_1").show();	
								$("#bt_req_ori_2").hide();
								$("#bt_req_ori_3").hide();
							}else{
								if ($( this ).val()==2) {
									$("#bt_req_ori_2").show();	
									$("#bt_req_ori_1").hide();
									$("#bt_req_ori_3").hide();
								}else{
									$("#bt_req_ori_3").show();	
									$("#bt_req_ori_1").hide();
									$("#bt_req_ori_2").hide();
								}
								
							}
							
						}

					})
				</script>
		';	

        return $o;
    }	

	public function insertBox_upb_request_originator_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
		$return .= '&nbsp;<button id="bt_req_ori_1" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=1\',\'List UPB\')" type="button">&nbsp;</button>';                
		$return .= '&nbsp;<button id="bt_req_ori_2" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=2\',\'List UPB\')" type="button">&nbsp;</button>';                
		$return .= '&nbsp;<button id="bt_req_ori_3" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=3\',\'List UPB\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	public function updateBox_upb_request_originator_iupb_id($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama from plc2_upb pu where pu.iupb_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];

		}else{

			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'].'"/>';
			$return .= '&nbsp;<button id="bt_req_ori_1" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=1\',\'List UPB\')" type="button">&nbsp;</button>';                
			$return .= '&nbsp;<button id="bt_req_ori_2" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=2\',\'List UPB\')" type="button">&nbsp;</button>';                
			$return .= '&nbsp;<button id="bt_req_ori_3" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/request/originator?field=upb_request_originator&iTujuan_req=3\',\'List UPB\')" type="button">&nbsp;</button>';                
		}
		
		return $return;
	}

	
	function insertbox_upb_request_originator_ijum_ori($field, $id) {
		$o = "<input type='text' size='3' class='required' name='".$id."' id='".$id."' min='0' />";
		$o .= '<script>
						$("#upb_request_originator_ijum_ori").keydown(function (e) {
				        // Allow: backspace, delete, tab, escape, enter and .
				        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				             // Allow: Ctrl+A
				            (e.keyCode == 65 && e.ctrlKey === true) || 
				             // Allow: home, end, left, right, down, up
				            (e.keyCode >= 35 && e.keyCode <= 40)) {
				                 // let it happen, dont do anything
				                 return;
				        }
				        // Ensure that it is a number and stop the keypress
				        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				            e.preventDefault();
				        }
				    });
					</script>';
		return $o;
	}
	function updatebox_upb_request_originator_ijum_ori($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$o=$value;

		}else{

			$o = "<input type='text' size='3' class='required' name='".$id."' id='".$id."' min='0' value='".$value."' />";
			$o .= '<script>
						$("#upb_request_originator_ijum_ori").keydown(function (e) {
				        // Allow: backspace, delete, tab, escape, enter and .
				        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				             // Allow: Ctrl+A
				            (e.keyCode == 65 && e.ctrlKey === true) || 
				             // Allow: home, end, left, right, down, up
				            (e.keyCode >= 35 && e.keyCode <= 40)) {
				                 // let it happen, dont do anything
				                 return;
				        }
				        // Ensure that it is a number and stop the keypress
				        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				            e.preventDefault();
				        }
				    });
					</script>';
		}

		
		return $o;
	}

	function insertbox_upb_request_originator_ireq_ke($field, $id) {
		$o = "<div id='history_req_originator'>";
		$o .= "<input type='text' size='3' name='".$id."' class='required' id='".$id."' min='0' />";
		$o .= "</div>";
		return $o;
	}

	function updatebox_upb_request_originator_ireq_ke($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
		//	$o=$value;
			
			if (!empty($_GET['idupb'])) {
				$upb_id = $_GET['idupb'];
			}else{
				$upb_id = $rowData['iupb_id'];	
			}
			$sql='select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  from plc2_upb_request_originator a where a.iupb_id= "'.$upb_id .'"  order by ireq_ori_id';

			$data['datanya'] = $this->dbset->query($sql)->result_array();
			$data['jumlah'] = $rowData['ireq_ke'];
			return $this->load->view('request_originator_history_show',$data,TRUE);   

		}else{
/*
			$o = "<div id='history_req_originator'>";
			$o .= "<input type='text' size='3' name='".$id."' class='required' id='".$id."' min='0' value='".$value."' size='3' />";
			$o .= "</div>";

*/
			if (!empty($_GET['idupb'])) {
				$upb_id = $_GET['idupb'];
			}else{
				$upb_id = $rowData['iupb_id'];	
			}
			$sql='select a.vreq_ori_no , date(a.tcreate) as tcreate , date(a.tapppd) as tapppd,a.vnip_apppd  from plc2_upb_request_originator a where a.iupb_id= "'.$upb_id .'"  order by ireq_ori_id';

			$data['datanya'] = $this->dbset->query($sql)->result_array();
			$data['jumlah'] = $rowData['ireq_ke'];
			return $this->load->view('request_originator_history',$data,TRUE);    
			/*
			$data=$value;
			//$data['rows'] = $this->db_plc0->get_where('brosur.brochure_file', array('id_brochure'=>$id_brosur))->result_array();
			return $this->load->view('master_brosur_file',$data,TRUE);
			*/
		}

		
		return $o;
	}






/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	

   
   
/*manipulasi proses object form end*/    

/*function pendukung start*/    
public function after_insert_processor($fields, $id, $post) {

		$cNip = $this->user->gNIP;
		//$tgl = date('Y-m-d', mktime());
		$tUpdated = date('Y-m-d H:i:s', mktime());
		$SQL = "UPDATE plc2.plc2_upb_request_originator set cnip='{$cNip}', tcreate='{$tUpdated}' where ireq_ori_id = '{$id}'";
		$this->dbset->query($SQL);
		
		//update service_request autonumber No Brosur
		$nomor = "R".str_pad($id, 7, "0", STR_PAD_LEFT);
		$sql = "UPDATE plc2.plc2_upb_request_originator SET vreq_ori_no = '".$nomor."' WHERE ireq_ori_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );

		//$this->lib_flow->insert_logs($this->input->get('modul_id'),$post['iupb_id'],1,0);
		

		


		//send email ke atasan
		

}
function before_insert_processor($row, $postData) {

	//end 
	$postData['tcreate'] = date('Y-m-d H:i:s');
	$postData['cnip'] =$this->user->gNIP;

	// ubah status submit
		if ($postData['iTujuan_req']==1) {
			$tipe=1;
		}else{
			$tipe=2;
		}

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{
			$postData['iSubmit']=1;
		//	$this->lib_flow->insert_logs($_GET['modul_id'],$postData['upb_request_originator_iupb_id'],1,0,$tipe);
		} 
	
	return $postData;

}

function before_update_processor($row, $postData) {

	//end 
	$postData['tupdate'] = date('Y-m-d H:i:s');
	// ubah status submit
	if ($postData['iTujuan_req']==1) {
		$tipe=1;
	}else{
		$tipe=2;
	}

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{
		/*
			$cek_upb= 'select * from plc2.plc2_upb_request_originator a where a.ireq_ori_id="'.$req_id.'"';
			$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();

			if ($dcek_upb['iSubmit']!=1) {
			//	$this->lib_flow->insert_logs($_GET['modul_id'],$postData['upb_request_originator_iupb_id'],1,0,$tipe);
			}
		*/
			$postData['iSubmit']=1;
			
		} 
	
	return $postData;

}



public function after_update_processor($fields, $id, $post) {
		$cNip = $this->user->gNIP;
		$tUpdated = date('Y-m-d H:i:s', mktime());
		$SQL = "UPDATE plc2.plc2_upb_request_originator set vupdate_by='{$cNip}', tupdate='{$tUpdated}' where ireq_ori_id = '{$id}'";
		$this->dbset->query($SQL);

	}

public function gethistory(){
	$upb_id = $_POST['upb_id'];
	$sql='select a.vreq_ori_no , date(a.tcreate) as tcreate , date(a.tapppd) as tapppd,a.vnip_apppd  from plc2_upb_request_originator a where a.iupb_id= "'.$upb_id .'"  order by ireq_ori_id';

	$data['datanya'] = $this->dbset->query($sql)->result_array();
	if(count($data['datanya']) > 0) {
			$data['jumlah'] = count($data['datanya'])+1;
	}else{
			$data['jumlah'] = 1 ;
	}
	return $this->load->view('request_originator_history',$data,TRUE);    

}

function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upb_request_originator\', \''.base_url().'processor/plc/upb/request/originator?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_upb_request_originator">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'upb_request_originator\', \''.base_url().'processor/plc/upb/request/originator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_upb_request_originator">Save &amp; Submit</button>';
	$js = $this->load->view('lokal/request_originator_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}

function manipulate_update_button($buttons, $rowData) {
		if ($this->input->get('action') == 'view') {
			unset($buttons['update']);}
		else{
			$user = $this->auth_localnon->user();
			$js = $this->load->view('lokal/request_originator_js');
			$ireq_ori_id=$rowData['ireq_ori_id'];
			//$stat = $this->biz_process->get_last_status($rowData['iupb_id']);
			//print_r($stat);
			//if(isset($stat['idplc2_status'])){$laststatus=$stat['idplc2_status'];}
			unset($buttons['update']);

			$update = '<button onclick="javascript:update_btn_back(\'upb_request_originator\', \''.base_url().'processor/plc/upb/request/originator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_request_originator" id="button_update_request_originator">Update & Submit</button>';
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'upb_request_originator\', \''.base_url().'processor/plc/upb/request/originator?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_upb_request_originator">Update as Draft</button>';
			$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/request/originator?action=approve&ireq_ori_id='.$rowData['ireq_ori_id'].'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&company_id='.$this->input->get('company_id').'&foreign_key='.$this->input->get('foreign_key').'\')" class="ui-button-text icon-save bt_request_originator" id="button_approve_request_originator">Approve</button>';
			$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/request/originator?action=reject&ireq_ori_id='.$rowData['ireq_ori_id'].'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&company_id='.$this->input->get('company_id').'&foreign_key='.$this->input->get('foreign_key').'\')" class="ui-button-text icon-save bt_request_originator" id="button_reject_request_originator">Reject</button>';

			if($this->auth_localnon->is_manager()){
				if ($rowData['iSubmit']<>0) {
					if ($rowData['vnip_apppd']=='') {
						$buttons['update'] = $update.$approve.$reject.$js;	
					}
				}else{
					$buttons['update'] = $updatedraft.$update.$js;	
				}
				

			}else{
				if ($rowData['iSubmit']==0) {
					if ($rowData['vnip_apppd']=='') {
						$buttons['update'] = $updatedraft.$update.$js;	
					}	
				}
			}
			
			

		
			}
			
			
    	return $buttons;
	}

function approve_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/upb/request/originator";
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										// $.get(url+"?action=view&id="+last_id+"&foreign_key="+foreign_key+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
									 	$.get(url+"?action=view&id="+last_id+"&idupb="+last_id, function(data) {
										 $("div#form_request_originator_approve").html(data);
										 $(".bt_request_originator").hide();

									});
					
								}
									reload_grid("grid_upb_request_originator");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_request_originator_approve" action="'.base_url().'processor/plc/upb/request/originator?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
    			<input type="hidden" name="ireq_ori_id" value="'.$this->input->get('ireq_ori_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<input type="hidden" name="company_id" value="'.$this->input->get('company_id').'" />
				<input type="hidden" name="foreign_key" value="'.$this->input->get('foreign_key').'" />
				<textarea name="vremark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_request_originator_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }

    function approve_process() {
    	$req_id = $_POST['ireq_ori_id'];
    	$remark = $_POST['vremark'];
    	$this->db_plc0->where('ireq_ori_id', $req_id);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		//$iapprove = $post['type'] == 'PD' ? 'iformula_apppd' : '';
		$updete= $this->db_plc0->update('plc2.plc2_upb_request_originator', array('iapppd'=>2,'vnip_apppd'=>$nip,'tapppd'=>$skg,'vremark'=>$remark));
		$cek_upb= 'select * from plc2.plc2_upb_request_originator a where a.ireq_ori_id="'.$req_id.'"';
		$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();


		if ($updete) {
			if ($dcek_upb['iTujuan_req']==1) {
				$tipe=1;
			}else{
				$tipe=2;
				/*integrasi dengan aplikasi PD detail 20170510 by mansur*/
				/*update flag finish pada db pD Detail*/
				$id_Upb=$dcek_upb['iupb_id'];
				$cek_fromPD='
							select fp.iupb_id,f.iFormula 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iNextRegOriginator=1
											and f.iFinishRegOri=0
											and fp.iupb_id="'.$id_Upb.'"
											order by f.iFormula DESC limit 1';
				$dFormula = $this->db_plc0->query($cek_fromPD)->row_array();	

				if (!empty($dFormula)) {
					$this->db_plc0->where('iFormula', $dFormula['iFormula']);
					$this->db_plc0->update('pddetail.formula', array('iFinishRegOri'=>1));											
				}										

				

			}

			//cek next_proses
		//	$this->lib_flow->insert_logs($_POST['modul_id'],$dcek_upb['iupb_id'],9,2,$tipe);
		}
		

		//send email
		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
				from plc2.plc2_upb u where u.iupb_id='".$dcek_upb['iupb_id']."'";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		
			$qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
	                    from plc2.plc2_upb u where u.iupb_id='".$dcek_upb['iupb_id']."'";
		$rsql = $this->db_plc0->query($qsql)->row_array();

		$pd = $rsql['iteampd_id'];
		$bd = $rsql['iteambusdev_id'];
		$qa = $rsql['iteamqa_id'];
		                        
		$team = $pd ;
		$toEmail2='';
		$toEmail = $this->lib_utilitas->get_email_leader( $bd );
                    $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

		$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($arrEmail);
				$to = $arrEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
				}
			}		

		//detail request
		$req="select * from plc2.plc2_upb_request_originator a where a.ireq_ori_id ='".$req_id."'";
		$date_req = $this->db_plc0->query($req)->row_array();

			$to = $toEmail;
			//$to = 'mansur@novellpharm.com';
			$cc = $arrEmail.';'.$toEmail2;
			//$cc = '';
			$subject="Pengiriman & Input Sample Originator oleh Busdev";
			$content="
				Diberitahukan bahwa telah ada Approvel UPB oleh PD Manager pada proses Request Originator(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>QTY</b></td><td> : </td><td>".$date_req['ijum_ori']."</td>
						</tr>
						<tr>
							<td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
						</tr>
						<tr>
							<td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
						</tr>
						<tr>
							<td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
						</tr>
						<tr>
							<td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
						</tr>

                        <tr>
							<td><b>Proses Selanjutnya</b></td><td> : </td><td>Pengiriman & Input Sample Originator oleh Busdev</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);

		
    	$data['status']  = true;
    	$data['last_id'] = $req_id;
    	$data['company_id'] = $_POST['company_id'];
    	$data['group_id'] = $_POST['group_id'];
    	$data['modul_id'] = $_POST['modul_id'];
    	$data['foreign_key'] = $_POST['foreign_key'];
    	return json_encode($data);
    }

    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/upb/request/originator";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&idupb="+last_id, function(data) {
										 $("div#form_request_originator_reject").html(data);
									});
					
								}else{
									alert("Remark tidak boleh kosong");
								}
									reload_grid("grid_upb_request_originator");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_request_originator_reject" action="'.base_url().'processor/plc/upb/request/originator?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
    			<input type="hidden" name="ireq_ori_id" value="'.$this->input->get('ireq_ori_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vremark" required="required" class="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_request_originator_reject\')">Reject</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    function reject_process() {
    	if ($_POST['vremark']=='') {
    		$data['status']=false;
    		
    	}else{
	    	$req_id = $_POST['ireq_ori_id'];
	    	$remark = $_POST['vremark'];
	    	$this->db_plc0->where('ireq_ori_id', $req_id);
			$nip = $this->user->gNIP;
			$skg=date('Y-m-d H:i:s');
			//$iapprove = $post['type'] == 'PD' ? 'iformula_apppd' : '';
			$updete= $this->db_plc0->update('plc2.plc2_upb_request_originator', array('iapppd'=>1,'vnip_apppd'=>$nip,'tapppd'=>$skg,'vremark'=>$remark));
			$cek_upb= 'select * from plc2.plc2_upb_request_originator a where a.ireq_ori_id="'.$req_id.'"';
			$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();

			if ($updete) {
				if ($dcek_upb['iTujuan_req']==1) {
					$tipe=1;
				}else{
					$tipe=2;
				}
			
				//cek next_proses
			//	$this->lib_flow->insert_logs($_POST['modul_id'],$dcek_upb['iupb_id'],9,2,$tipe);
			}

    		$data['status']  = true;
    		$data['last_id'] = $req_id;
    	}
    	return json_encode($data);
		
    	
    }

	
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

