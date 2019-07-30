<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_best_formula extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
		$this->dbset = $this->load->database('formulasi', false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_export->user();
		$this->filepath="files/reformulasi/export/export_reg_file";
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Reformulasi - Best Formula');		
		$grid->setTable('reformulasi.export_refor_best_formula');		
		$grid->setUrl('export_best_formula');
		$grid->addList('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan','iapproveBest');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');
		$grid->addFields('iexport_refor_formula','vUpd_no','vNama_usulan','cInisiator_export','iDapartemen_export','tAlasan_export','vUploadfile','iTeamPD','dPermintaan_req_export','cApproval_ats_inisiator','cPicFormulator','iapproveBest');
		$grid->setLabel('daftar_upd.vNama_usulan', 'Nama Produk');
		$grid->setLabel('iexport_refor_formula', 'Nomor Request');
		$grid->setLabel('vUpd_no', 'No UPD');
		$grid->setLabel('vNama_usulan', 'Nama Produk');
		$grid->setLabel('cInisiator_export', 'Nama Inisiator');
		$grid->setLabel('iDapartemen_export', 'Departement');
		$grid->setLabel('tAlasan_export', 'Alasan Refor');
		$grid->setLabel('vUploadfile', 'Upload File');
		$grid->setLabel('iTeamPD', 'Team PD');
		$grid->setLabel('dPermintaan_req_export', 'Tgl Permintaan Refor Export');
		$grid->setLabel('cApproval_ats_inisiator', 'Approval Atasan Inisiator');
		$grid->setLabel('cPicFormulator', 'PIC Formulator Refor');
		$grid->setLabel('iapproveBest', 'Status Approval');

		$grid->setLabel('export_refor_formula.vnoFormulasi', 'No Formulasi');
		$grid->setLabel('export_req_refor.vno_export_req_refor', 'No Req Refor');
		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama Produk');

		$grid->setJoinTable('reformulasi.export_refor_formula', 'export_refor_formula.iexport_refor_formula=reformulasi.export_refor_best_formula.iexport_refor_formula', 'inner');
		$grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id', 'inner');

		$grid->setSearch('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan');
		$grid->setRequired('iexport_refor_formula');

		$grid->setQuery('dossier_upd.ldeleted',0);
		$grid->setQuery('export_refor_best_formula.ldeleted',0);
		$grid->setQuery('export_refor_formula.ihslStabilita_lab',1);

		$grid->setGridView('grid');
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
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'updateproses':
                echo $grid->updated_form();
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
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
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'get_data_prev':
				echo $this->getdetailsprev();
				break;
			default:
				$grid->render_grid();
				break;
		}
	}

	function listBox_export_best_formula_iapproveBest($v, $pk, $name, $rowData) {
		$re="-";
		if($v==2){
			$re="Approved";
		}else{
			$ret="Waiting Aprroval";
		}
		return $re;
	}

	function listBox_Action($row, $actions) {
		unset($actions['edit']);
		return $actions;
	}

	/*Insert FORM MOdification*/
	function insertBox_export_best_formula_iexport_refor_formula($f, $i){
		$r = '<script>
					$( "button.icon_pop" ).button({
						icons: {
							primary: "ui-icon-newwin"
						},
						text: false
					})
				</script>';
		$r .= '<input type="hidden" name="isdraft" id="isdraft">';
		$r .= '<input type="hidden" name="'.$i.'" id="'.$i.'" class="input_rows1 required" />';
		$r .= '<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" />';
		$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/browse_export_best_formula?field=export_best_formula&modul_id='.$this->input->get('modul_id').'\',\'\')" type="button">&nbsp;</button>';
		return $r;
	}

	function insertBox_export_best_formula_vUpd_no($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_best_formula_vNama_usulan($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_best_formula_cInisiator_export($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_best_formula_iDapartemen_export($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_best_formula_tAlasan_export($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_best_formula_vUploadfile($f, $i){
		$data['id']=0;
		$data['get']=$this->input->get();
		return $this->load->view('export/export_best_formula_file',$data,TRUE);
	}

	function insertBox_export_best_formula_iTeamPD($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_best_formula_dPermintaan_req_export($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_best_formula_cApproval_ats_inisiator($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_best_formula_cPicFormulator($f, $i){
		$r= '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
		$data=array();
		$r.=$this->load->view('export/browse_best_formula_details_stabilita',$data,TRUE);
		return $r;
	}

	function insertBox_export_best_formula_iapproveBest($f, $i){
		return 'Waiting Approval';
	}

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$grid='export_best_formula';
		$data['grid']=$grid;
		$js = $this->load->view('export/js/export_best_formula_js',$data);
		$approve = '<button onclick="javascript:cek_id_'.$grid.'(\''.base_url().'processor/reformulasi/'.$grid.'?action=approve&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&company_id='.$this->input->get('company_id').'&foreign_id=0\',\'\',\'Approve Best Formula\');" class="ui-button-text icon-save" id="button_approve_'.$grid.'">Approve</button>';
		$buttons['save'] = $approve.$js;
		return $buttons;
	}

	/*End Insert Form*/


	/*Update FORM MOdification*/

	function updateBox_export_best_formula_iexport_refor_formula($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$val['vno_export_req_refor'].'" />';
		return $r;
	}

	function updateBox_export_best_formula_vUpd_no($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['vUpd_no'].'" />';
		return $r;
	}
	
	function updateBox_export_best_formula_vNama_usulan($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['vNama_usulan'].'</textarea>';
		return $r;
	}

	function updateBox_export_best_formula_cInisiator_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cInisiator_export'].'</textarea>';
		return $r;
	}

	function updateBox_export_best_formula_iDapartemen_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['iDapartemen_export'].'" />';
		return $r;
	}

	function updateBox_export_best_formula_tAlasan_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['tAlasan_export'].'</textarea>';
		return $r;
	}

	function updateBox_export_best_formula_iTeamPD($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$this->getTeamByID($val['iTeamPD']).'" />';
		return $r;
	}

	function updateBox_export_best_formula_dPermintaan_req_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['dPermintaan_req_export'].'" />';
		return $r;
	}

	function updateBox_export_best_formula_cApproval_ats_inisiator($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cApproval_ats_inisiator'].'</textarea>';
		return $r;
	}

	function updateBox_export_best_formula_cPicFormulator($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cPicFormulator'].'</textarea>';
		$data=array();
		$data['id']=$row['iexport_refor_formula'];
		$r.=$this->load->view('export/browse_best_formula_details_stabilita',$data,TRUE);
		return $r;
	}

	function updateBox_export_best_formula_vUploadfile($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$data['id']=$val['iexport_req_refor'];
		$data['get']=$this->input->get();
		return $this->load->view('export/export_best_formula_file',$data,TRUE);
	}

	function updateBox_export_best_formula_iapproveBest($f, $i, $v, $row){
		$ret='';
		if($v==1){
			$ret="Rejected";
		}elseif($v==2){
			$ret="Approved";
		}
		$usr=$this->getDetailsEmploye($row['capproveBest']);
		if(count($usr>=1)){
			$ret=" By ".$usr['vName']." at ".$row['dapproveBest'];
		}
		return $ret;
	}

	function manipulate_update_button($buttons, $rowData){
		unset($buttons['update']);
		return $buttons;
	}

	/*End Update Form*/


	/*Public Output*/
	public function output(){
		$this->index($this->input->get('action'));
	}

	/*OPTIONAL FUNCTION*/

	function getTeamByID($id=0){
        $sql='select * from reformulasi.reformulasi_team t where t.ldeleted=0 and t.ireformulasi_team='.$id;
        $qr=$this->db->query($sql);
        $ret="-";
        if($qr->num_rows()>=1){
            $row=$qr->row_array();
            $ret=isset($row['vteam'])?$row['vteam']:'-';
        }
        return $ret;
    }

    function getdetailsprev(){
    	$post=$this->input->post();
		$sql_data="select * from reformulasi.export_req_refor_file p where p.lDeleted=0 and p.iexport_req_refor=".$post['id'];
		$q=$this->dbset->query($sql_data);
		$rsel=array('vFilename','tKeterangan','update');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->iexport_req_refor_file;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_export_best_formula' value='".$ini."' /><button id='ihapus_tb_details_harga_database' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_tb_details_export_best_formula(".$ini.")' type='button'>Hapus</button><input type='hidden' name='iexport_best_formula_file[]' value='".$k->iexport_req_refor_file."' />";
					$value=$k->tKeterangan;
					$id=$k->iexport_req_refor_file;
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$this->filepath.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().'processor/reformulasi/export/best/formula?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
							$btn2="<button id='ihapus_tb_details_harga_database' class='ui-button-text icon_hapus' style='width:100px' onclick='javascript:hapus_row_tb_details_export_best_formula(".$ini.")' type='button'>".$caption."</button>";
						}
						else {
							$btn2 = ' [No File!]';
						}
					}
					else {
						$btn2 = ' [No File!]';
					}

					
					$dataar[$dsel]=$btn2;
				}else{
					$dataar[$dsel]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
	}

	function approve_view(){
		$get=$this->input->get();
		$andwhere='';
		foreach ($get as $kg => $vg) {
			if($kg!='action'){
				$andwhere.="&".$kg."=".$vg;
			}
		}
		$echo = '<h1>Approve</h1><br />';
		$echo .= '<form id="form_popup_export_best_formula" action="'.base_url().'processor/reformulasi/export/best/formula?action=approve_process'.$andwhere.'" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iexport_refor_formula" value="'.$this->input->get('iexport_refor_formula').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea id="vRemark" name="vRemark"></textarea>';
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post=$this->input->post();
		$get=$this->input->get();
		$datain['iexport_refor_formula']=$post['iexport_refor_formula'];
		$datain['iapproveBest']=2;
		$datain['capproveBest']=$this->user->gNIP;
		$datain['dapproveBest']=date("Y-m-d H:i:s");
		$datain['cCreate']=$this->user->gNIP;
		$datain['dCreate']=date("Y-m-d H:i:s");
		$this->dbset->insert('reformulasi.export_refor_best_formula',$datain);
		$last_id=$this->dbset->insert_id();

		/*Send Inbox*/
		$dform = $this->getreqdata($last_id);
		$vteampd=$this->getdetailteam($dform['iTeamPD']);
		$teampd=isset($vteampd['vteam'])?$vteampd['vteam']:'-';
		$vteamad=$this->getdetailteam($dform['iTeamAndev']);
		$teamad=isset($vteamad['vteam'])?$vteamad['vteam']:'-';
		$data['cdata'] = array(
			'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
			'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
			'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
			'iTeamPD'=>$teampd,
			'iTeamAndev'=>$teamad
		);

		$data['capdata']  = array(
			'vno_export_req_refor'=>'No Req Refor',
			'vUpd_no'=>'No UPD',
			'vNama_usulan'=>'Nama Usulan',
			'iTeamPD'=>'Team PD',
			'iTeamAndev'=>'Team Andev'
		);
		$data['menuapp']="ERP -> Reformulasi -> Export -> Best Formula";
		$data['caption']="Diberitahukan telah ada Approval pada Aplikasi Reformulasi Export module Best Formula, dengan rincian sebagai berikut :";
		$subject = "Reformulasi Export - Uji Mikro FG (".$dform['export_req_refor__vno_export_req_refor'].")";

		$teamPD=$this->getnipbytipe("PD");
		$teamAD=$this->getnipbytipe("AD");
		$to=implode(";", $teamPD['atasan']);
		$to.=";".implode(";", $teamAD['atasan']);
		$cc=implode(";", $teamPD['bawahan']);
		$cc.=implode(";", $teamAD['bawahan']);
		$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
		$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

		$data=$get;
		$data['last_id']=$last_id;
		$data['message']="Approve Success";
		$data['status']=true;
		echo json_encode($data);
	}

	function getreqdata($id=0){
    	$sql="SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev,export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan,dossier_upd.vUpd_no AS dossier_upd__vUpd_no, reformulasi.export_refor_formula.*, export_refor_best_formula.iexport_refor_best_formula
			FROM (reformulasi.export_refor_formula)
			INNER JOIN reformulasi.export_req_refor ON export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id
			INNER JOIN reformulasi.export_refor_best_formula ON export_refor_best_formula.iexport_refor_formula=reformulasi.export_refor_formula.iexport_refor_formula
			WHERE export_refor_best_formula.iexport_refor_best_formula=".$id;
		$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }

     function getnipbytipe($type="",$id=0){
    	$nipatasan=array();
    	$tp=" and t.ireformulasi_team=".$id." and t.vtipe='".$type."'";
    	if($id==0){
    		$tp=" and t.vtipe='".$type."'";
    	}
    	$sqla="select t.* from reformulasi.reformulasi_team t where t.ldeleted=0 and t.iTipe=2 ".$tp;
		$qra=$this->db->query($sqla);
		if($qra->num_rows>=1){
			foreach ($qra->result_array() as $kqra => $vqra) {
				$nipatasan[]=$vqra['vnip'];
			}
		}

		$sqlb="select te.* from reformulasi.reformulasi_team_item te
			join reformulasi.reformulasi_team t on t.ireformulasi_team=te.ireformulasi_team
			where t.ldeleted=0 and t.iTipe=2 ".$tp;
		$qrb=$this->db->query($sqlb);
		$nipb=array();
		if($qrb->num_rows>=1){
			foreach ($qrb->result_array() as $kqrb => $vqrb) {
				$nipb[]=$vqrb['vnip'];
			}
		}
		$data['atasan']=$nipatasan;
		$data['bawahan']=$nipb;
		return $data;
    }

    function getdetailteam($id,$h=0){
    	$ret=array();
    	if($h==0){
    		$sql="select t.* from reformulasi.reformulasi_team t where t.ldeleted=0 and t.iTipe=2 and t.ireformulasi_team=".$id;
    		$qr=$this->db->query($sql);
    		if($qr->num_rows>=1){
    			$ret=$qr->row_array();
    		}
    	}else{
    		$sql="select t.* from reformulasi.reformulasi_team_item it
    				join reformulasi.reformulasi_team t on t.ireformulasi_team=it.ireformulasi_team
    				where it.ldeleted=0 and t.ldeleted=0 and t.iTipe=2 and it.ireformulasi_team_item=".$id."
    				group by t.ireformulasi_team";
    				$qr=$this->db->query($sql);
    		if($qr->num_rows>=1){
    			$ret=$qr->row_array();
    		}
    	}
    	return $ret;
    }

	function getdetails($id){
		$post=$this->input->post();
		$sql="select r.vno_export_req_refor,u.vUpd_no,u.vNama_usulan,r.cInisiator_export,r.iDapartemen_export,r.tAlasan_export,r.iTeamPD,r.dPermintaan_req_export,r.cApproval_ats_inisiator,r.cPicFormulator,r.iexport_req_refor 
			from reformulasi.export_refor_formula f
			join reformulasi.export_req_refor r on r.iexport_req_refor=f.iexport_req_refor
			join dossier.dossier_upd u on r.idossier_upd_id=u.idossier_upd_id
			where f.lDeleted=0 and r.lDeleted=0 and u.lDeleted=0 and f.iexport_refor_formula=".$id;
		$row=$this->db->query($sql)->row_array();
		$cInisiator_export=$this->getDetailsEmploye($row['cInisiator_export']);
		$row['cInisiator_export']="[".$row['cInisiator_export']."] ".$cInisiator_export['vName'];
		$depart=$this->getDetailsDepart($row['iDapartemen_export']);
		$row['iDapartemen_export']=$depart['vDescription'];
		$cApproval_ats_inisiator=$this->getDetailsEmploye($row['cApproval_ats_inisiator']);
		$row['cApproval_ats_inisiator']="[".$row['cApproval_ats_inisiator']."] ".$cApproval_ats_inisiator['vName'];
		$cPicFormulator=$this->getDetailsEmploye($row['cPicFormulator']);
		$row['cPicFormulator']="[".$row['cPicFormulator']."] ".$cPicFormulator['vName'];
		return $row;
	}
	function getDetailsEmploye($nip=0){
    	$sql="select * from hrd.employee em where em.cNip='".$nip."'";
    	$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }
    function getDetailsDepart($id=0){
    	$sql="select * from hrd.msdepartement em where em.iDeptID='".$id."'";
    	$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }

}