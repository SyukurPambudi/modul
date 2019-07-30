<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_utilitas {
	private $_ci;
	public $url;
	public $session;
	public $userinfo;
	public $moduleinfo;
	public $tmp;
	private $db_erp_pk;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$this->set_userinfo();
	}
	public function set_url($url) {
		$this->url = $url;
	}
	public function set_moduleinfo($method) {
		$this->moduleinfo[]=$method;
	}
	function set_session() {
		$this->_ci->load->library('MySession');
	
		$sess_auth  = new Zend_Session_Namespace('auth');
		$this->session['nip']= $sess_auth->gNIP;
		$this->session['name']= $sess_auth->gName;
		$this->session['comId']= $sess_auth->gComId;
		$this->session['comNm']= $sess_auth->gComName;
	}
	function set_userinfo() {
		$this->set_session();
		
		$this->_ci->load->model('m_employee');
		$rows = $this->_ci->m_employee->getEmployeeByNip($this->session['nip']);
		$this->userinfo['iDeptId'] = isset($rows[0]['iDeptId'])?$rows[0]['iDeptId']:'';
		$this->userinfo['iLvlemp'] = isset($rows[0]['iLvlemp'])?$rows[0]['iLvlemp']:0;
		
		$this->session['deptId'] = $this->userinfo['iDeptId'];
		$this->session['lvlEmp'] = $this->userinfo['iLvlemp'];
	}
	
	function get_pic_by_divisi($divisi='') {
		$this->_ci->load->model('m_employee');
		
		$divisi = ($divisi)?$divisi:$this->session['deptId'];
		$sql = "SELECT * FROM employee WHERE ( dResign='0000-00-00' OR date(dResign<'".date('Y-m-d')."') ) AND iDivisionID ='".$divisi."'";
		$sql.= "ORDER BY vName";
		
		$rows = $this->_ci->m_employee->custom( $sql );
		if($rows) {
			$o=array();
			foreach($rows as $key =>$row) {
				$nip = $row['cNip'];
				$nama = $row['vName'];
				
				$o[]=array('nip'=>$nip,'nama'=>$nama);
			}
			return $o;
		}
		return false;
	}
	function getWholeInferior( $nip = '' ) {
		if($nip=='') return false;
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$sql = "SELECT cNip FROM employee
				WHERE  cUpper = '".$nip."';";
		$query = $this->db_erp_pk->query($sql);
		if($query->num_rows()>0) {
			$rows = $query->result_array();
			foreach($rows as $row) {
				$this->tmp[] = $row['cNip'];
				
				$this->get_all_inferior( $row['cNip'] );
			}
			return $this->tmp;
		}
		return false;
	}
	function get_all_inferior( $nip = '' ) {
		if($nip=='') return false;
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$sql = "SELECT cNip FROM employee
				WHERE ( dResign='0000-00-00' OR dResign > CURRENT_DATE() )
				AND cUpper = '".$nip."';";
		$query = $this->db_erp_pk->query($sql);
		if($query->num_rows()>0) {
			$rows = $query->result_array();
			foreach($rows as $row) {
				$this->tmp[] = $row['cNip'];
				
				$this->get_all_inferior( $row['cNip'] );
			}
			return $this->tmp;
		}
		return false;
	}

	function get_all_superior( $nip ='') {
		if($nip=='') return false;
		
		$this->_ci->load->model('m_employee');
		$rows = $this->_ci->m_employee->get_all_superior($nip);
		if($rows) {
			return $rows;
		}
		return false;
	}
	function is_superiornya( $logged_nip, $nip ='') {
		$arrx= $this->get_all_superior( $nip );
		if($arrx) {
			foreach($arrx[0] as $key=>$val) {
				if(trim($logged_nip) == trim($val)) {
					return true;
				}
			}
		}
		return false;
	}

	function getSingleAybs($cNip){
		//Fungsi untuk mendapatkan nip atasan langsung saja
		$tCUpper = '';
		$sql = "Select cUpper from hrd.employee where cNip='".$cNip."'";
		$query = $this->db_erp_pk->query($sql);
		if ($query->num_rows > 0) {
			$row = $query->row();
        	$tCUpper = $row->cUpper;
		}

		return $tCUpper;
	}

	
	function getDeptInfo($iDeptId=''){
		if($iDeptId=='') return false;
		
		$this->_ci->load->model('m_division');
		$rows = $this->_ci->m_division->getDivById($iDeptId);
		if($rows) {
			return $rows;
		}
		return false;
	}
	
	function getPostInfo($iPostId=''){
		if($iPostId=='') return false;
	
		$this->_ci->load->model('m_position');
		$rows = $this->_ci->m_position->getPostById($iPostId);
		if($rows) {
			return $rows;
		}
		return false;
	}
	
	function get_pm_number($table='',$id='') {
		/*if($table=='' || $id=='') return false;
		$model = 'm_'.$table.'_number';
		$this->_ci->load->model($model);
		$rows = $this->_ci->$model->select_by_id($id);
		if($rows) {
			return $rows[0]['vDEPT'].'/'.$rows[0]['iYY'].'/'.$rows[0]['iMM'].'/'.$rows[0]['iID'];
		}*/
		return '';
	}
	function status_executor_list($url=false, $param='', $thisUrl='') {
		$list = array(0=>'Need Acceptance',1=>'Accepted',2=>'Postponed',3=>'Rejected');
		$id = isset($param['id'])?$param['id']:0;
		$url = array(
					0=>$this->browse_onclick('project_request_acceptance?parentUrl='.$thisUrl.'&action=form_acceptance&id='.$id,'Project Request:Need Acceptance'),
					1=>$this->browse_onclick('project_request_acceptance?parentUrl='.$thisUrl.'&action=form_acceptance&id='.$id,'Project Request:Accepted'),
					2=>$this->browse_onclick('project_request_acceptance?parentUrl='.$thisUrl.'&action=form_acceptance&id='.$id,'Project Request:Postponed'),
					3=>$this->browse_onclick('project_request_acceptance?parentUrl='.$thisUrl.'&action=form_acceptance&id='.$id,'Project Request:Rejected'));
		if($url) {
			return array('list'=>$list,'url'=>$url);
		} else {
			return $list;
		}
	}
	function status_executor($value='',$param='', $thisUrl='') {
		$link = '';
		$arr = $this->status_executor_list(true, $param, $thisUrl);
		$list = $arr['list'];
		$url = $arr['url'];
		
		foreach($list as $k=>$v) {
			if($k==$value) $status = $v;
		}

		$link = $status;
		
		if(!empty($this->userinfo)) {
			if($this->userinfo['iDeptId']==$param['iDeptId'] && $this->userinfo['iLvlemp']>=4) {
				if($url[$k]) {
					/*
					 *  $link_approve = 'javascript:browse_with_no_close(\'';
						$link_approve.= $this->root_url.'/project_request_need_approve?';
						$link_approve.= 'pCon='.$this->curr_controller;
						$link_approve.= '&pMdlId='.$this->curr_modul;
						$link_approve.= '&pGrpId='.$this->curr_group;
						$link_approve.= '&pComId='.$this->curr_company;
						$link_approve.= '&action=need_approve&id='.$rowData->ID;
						$link_approve.= '\',\'Need Approve\');';
					 */
					$link = '<a href="javascript:'.$url[$k].'">'.$status.'</a>';
				}
			}
		}
		
		return $link;
	}
	function get_name_by_nip($nip='') {
		if($nip=='') return false;
		$this->_ci->load->model('m_employee');
		$rows=$this->_ci->m_employee->getEmployeeByNip($nip);
		if($rows && count($rows)>0) {
			$name = trim($rows[0]['vName']);
			return $name;
		}
	
		return false;
	}
	function get_email_by_dept_pos($iDeptId='', $lvlPos='') {
		if($iDeptId=='' || $lvlPos=='') return false;
		
		$this->_ci->load->helper('email');
		$this->_ci->load->model('m_employee');
		$rows=$this->_ci->m_employee->getEmployeeByDeptPos($iDeptId, $lvlPos);
		if($rows && count($rows)>0) {
		$email = trim($rows[0]['vEmail']);
			if(valid_email($email)){
				return $email;
			}
		}
		
		return false;
	}
	function get_email_by_nip($nip='') {
		if($nip=='') return false;
		$this->_ci->load->helper('email');
		$this->_ci->load->model('m_employee');
		$rows=$this->_ci->m_employee->getEmployeeByNip($nip);
		if($rows && count($rows)>0) {
			$email = trim($rows[0]['vEmail']);
			if(valid_email($email)){
				return $email;
			}
		}
		
		return false;
	}
	function send_email($to, $cc, $subject, $content, $path) {
		$this->_ci->load->helper('email');
		$this->_ci->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = '10.1.48.4';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['wordwrap'] = FALSE;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		
		$from = "postmaster@novellpharm.com";
		$to = $to;//"aliwidi.maulana@novellpharm.com";
		$cc = $cc;//"";
		$subject = $subject;//"test email aplikasi pm-bic";
		$content = $content;//"test email aplikasi pm-bic";
		$path=$path;//"";
		
		$this->_ci->email->initialize($config);
		$this->_ci->email->from($from, 'Project Management');
		$this->_ci->email->to($to);
		//if(valid_email($cc))
			$this->_ci->email->cc($cc);
		$this->_ci->email->subject($subject);
		$this->_ci->email->message($content);
			
		if(file_exists($path)){
			$files = get_filenames($path);
			if(count($files)>0){
				foreach($files as $f){
					$f2=$path."/".$f;
					$this->_ci->email->attach($f2);
				}
			}
		}
		$this->_ci->email->send();
	}
	function browse_onclick($module,$title='Window') {
		$js_browse = 'javascript:browse_with_no_close(\''.base_url().'processor/pm/'.$module.'\',\''.$title.'\');';
		return $js_browse;
	}
	function get_link($module) {
		return base_url().'processor/pm/'.$module;
	}
	function get_root_url() {
		$curr_url = current_url();
		$last_str = strstr(current_url(), "processor");
		$curr_url = str_replace( $last_str, '', $curr_url );
		return $curr_url;
	}
	function get_request_status($value='') {
		$status = array();
		$status[0] = 'New';
		$status[1] = 'Approved';
		$status[2] = 'Postponed';
		$status[3] = 'Accepted';
		$status[4] = 'Charter';
		$status[5] = 'Plan';
		$status[6] = 'Realisasi';
		$status[7] = 'Closed';
		$status[8] = 'Confirmed';
		$status[9] = 'Rejected';
		
		return isset($status[$value])?$status[$value]:$value;
	}
	function pm_request_isConfirmByHeadOfDiv() {
		$a = array(0=>'Need Approval',1=>'Approved',2=>'Postponed',3=>'Rejected');
		return $a;
	}
	function pm_request_isConfirmByHeadOfDiv_link($id='', $thisUrl='') {
		$a = array(0=>$this->browse_onclick('project_request_need_approve?parentUrl='.$this->_ci->curr_controller.'&action=need_approve&id='.$id),1=>'',2=>'',3=>'');
		return $a;
	}
	function pm_request_isAccepted() {
		$a = array(0=>'Need Acceptance',1=>'Accepted',2=>'Postponed',3=>'Rejected');
		return $a;
	}
	function pm_request_isAccepted_link($id='') {
		$a = array(0=>$this->browse_onclick('project_request_need_accept?action=need_accept&id='.$id),1=>'',2=>'',3=>'');
		return $a;
	}
	function pm_charter_eCategory() {
		$a = array('A'=>'Category A','B'=>'Category B','C'=>'Category C');
		return $a;
	}
	function pm_charter_approval($arrdata='') {
		$this->_ci->load->model('m_employee');
		if($arrdata=='') return false;
		
		$id = $arrdata->id;
		/*
		$nipPM    = $arrdata->cNipPM;
		$submitPM = $arrdata->iCharterStatus;
		$nipReq = $arrdata->pm_request__cNipReq;
		$appReq = $arrdata->isApprByRequestor;
		$dAppReq = $arrdata->dApprByRequestor;
		$nipHeadReq = $arrdata->cNipHeadOfDiv;
		$appHeadReq = $arrdata->isApprByHeadOfDiv;
		$dAppHeadReq = $arrdata->dApprByHeadOfDiv;
		$nipSupReq = $arrdata->cNipSuperior;
		$appSupReq = $arrdata->isApprBySuperior;
		$dAppSupReq = $arrdata->dApprBySuperior;
		$nipSupPM = $arrdata->cPlanNipPMSuperior;
		$appSupPM = $arrdata->isPlanApprByPMSuperior;
		$dAppSupPM = $arrdata->dPlanApprByPMSuperior;
		*/
		$cNipPM    = $arrdata->cNipPM;
		$iCharterStatus = $arrdata->iCharterStatus;
		$cNipReq = $arrdata->pm_request__cNipReq;
		/* $isApprByRequestor = $arrdata->isApprByRequestor;
		$dApprByRequestor = $arrdata->dApprByRequestor;
		$cNipHeadOfDiv = $arrdata->cNipHeadOfDiv;
		$isApprByHeadOfDiv = $arrdata->isApprByHeadOfDiv;
		$dApprByHeadOfDiv = $arrdata->dApprByHeadOfDiv;
		$cNipSuperior = $arrdata->cNipSuperior;
		$isApprBySuperior = $arrdata->isApprBySuperior;
		$dApprBySuperior = $arrdata->dApprBySuperior; */
		$cPlanNipPMSuperior = $arrdata->cPlanNipPMSuperior;
		$isPlanApprByPMSuperior = $arrdata->isPlanApprByPMSuperior;
		$dPlanApprByPMSuperior = $arrdata->dPlanApprByPMSuperior;
		
		//echo $iCharterStatus.','.$cNipPM;
		
		if(!$iCharterStatus) {
			$vName ='';
			$rows = $this->_ci->m_employee->getEmployeeByNip($cNipPM);
			if($rows) {
				$vName = $rows[0]['vName'];
			}
			return 'Need Submit By '.$vName;
		} /*else if (!$isPlanApprByPMSuperior) {
			$vName ='';
			$rows = $this->_ci->m_employee->getEmployeeByNip($cPlanNipPMSuperior);
			if($rows) {
				$vName = $rows[0]['vName'];
			}
			return 'Need Approved By '.$vName;
		}*/ else {
			$link = $this->pm_charter_approval_link($id,'readonly');
			return '<a href="'.$link.'">Approval List</a>';
		}
		
		/*else if($cNipPM == $this->session['nip']) {
			if($iCharterStatus ) {
				if($isPlanApprByPMSuperior==1) {
					$link = $this->pm_charter_approval_link($id,'readonly');
					return '<a href="'.$link.'">Approval List</a>';
				} elseif($isPlanApprByPMSuperior==2) {
					$vName = '';
					$rows = $this->_ci->m_employee->getEmployeeByNip($cPlanNipPMSuperior);
					if($rows) {
						$vName = $rows[0]['vName'];
					}
					return '<span>Rejected By '.$vName.'</span>';
				} elseif($isPlanApprByPMSuperior==3) {
					return '<span>Need Revise</span>';
				} else {
					$vName = '';
					$rows = $this->_ci->m_employee->getEmployeeByNip($cPlanNipPMSuperior);
					if($rows) {
						$vName = $rows[0]['vName'];
					}
					return '<span>Need Approve By '.$vName.'</span>';
				}
			} else {
				return 'Need Submit';
			}
		} else if($cPlanNipPMSuperior == $this->session['nip']) {
			if($iCharterStatus) {
				if(strtotime($dPlanApprByPMSuperior)>0) {
					$link = $this->pm_charter_approval_link($id,'readonly');
					return '<a href="'.$link.'">Approval List</a>';
				} else {
					$link = $this->pm_charter_approval_link($id,1);
					return '<a href="'.$link.'">Need Approve</a>';
				}
			} else {
				$vName ='';
				$rows = $this->_ci->m_employee->getEmployeeByNip($cNipPM);
				if($rows) {
					$vName = $rows[0]['vName'];
				}
				return 'Need Submit By '.$vName;
			}
		} else if($cNipReq == $this->session['nip']) {
			if(strtotime($dPlanApprByPMSuperior)>0) {
				if(strtotime($dApprByRequestor)>0) {
					$link = $this->pm_charter_approval_link($id,'readonly');
					return '<a href="'.$link.'">Approval List</a>';
				} else {
					$link = $this->pm_charter_approval_link($id,2);
					return '<a href="'.$link.'">Need Approve</a>';
				}
			} else {
				$vName ='';
				$rows = $this->_ci->m_employee->getEmployeeByNip($cPlanNipPMSuperior);
				if($rows) {
					$vName = $rows[0]['vName'];
				}
				return 'Need Approve By '.$vName;
			}
		}  else if($cNipSuperior == $this->session['nip']) {
			if(strtotime($dApprByRequestor)>0) {
				if(strtotime($dApprBySuperior)>0) {
					$link = $this->pm_charter_approval_link($id,'readonly');
					return '<a href="'.$link.'">Approval List</a>';
				} else {
					$link = $this->pm_charter_approval_link($id,3);
					return '<a href="'.$link.'">Need Approve</a>';
				}
			} else {
				$vName = '';
				$rows = $this->_ci->m_employee->getEmployeeByNip($cNipReq);
				if($rows) {
					$vName = $rows[0]['vName'];
				}
				return 'Need Approve By '.$vName;
			}
		} else if($cNipHeadOfDiv == $this->session['nip']) {
			if(strtotime($dApprBySuperior)>0) {
				if(strtotime($dApprByHeadOfDiv)>0) {
					$link = $this->pm_charter_approval_link($id,'readonly');
					return '<a href="'.$link.'">Approval List</a>';
				} else {
					$link = $this->pm_charter_approval_link($id,4);
					return '<a href="'.$link.'">Need Approve</a>';
				}
			} else {
				$vName = '';
				$rows = $this->_ci->m_employee->getEmployeeByNip($cNipSuperior);
				if($rows) {
					$vName = $rows[0]['vName'];
				}
				return 'Need Approve By '.$vName;
			}
		} else {
			//return "au : ".$iCharterStatus.','.$cNipPM.','.$cPlanNipPMSuperior.','.$cNipReq.','.$cNipSuperior.','.$cNipHeadOfDiv.','.$cNipReq.' => '.$this->session['nip'];
			return ' Failed to get status ';
		} */
	}
	function pm_charter_approval_link($id='',$i='') {
		if($id=='' || $i=='') return false;
		
		$link  = array(
					'readonly'=>$this->browse_onclick('project_charter_need_approve?action=need_approve&id='.$id.'&status='.$i),
					1=>$this->browse_onclick('project_charter_need_approve?action=need_approve&id='.$id.'&status='.$i),
					2=>$this->browse_onclick('project_charter_need_approve?action=need_approve&id='.$id.'&status='.$i),
					3=>$this->browse_onclick('project_charter_need_approve?action=need_approve&id='.$id.'&status='.$i),
					4=>$this->browse_onclick('project_charter_need_approve?action=need_approve&id='.$id.'&status='.$i));
		
		return $link[$i];
	}
	function pm_charter_final($row='') {
		if($row=='') return false;
		
		/*if($row->isPlanApprByPMSuperior==1 &&
			$row->isApprByRequestor==1 &&
			$row->isApprBySuperior==1 &&
			$row->isApprByHeadOfDiv==1) {
			return true;
		}*/
		
		if ($row->iCharterStatus ==1 && $row->isPlanApprByPMSuperior == 1) {
			return true;
		}

		
		return false;
	}
	function pm_charter_print($row='') {
		if($row=='') return false;
		
		//$link = $this->browse_onclick('project_charter?action=print&id='.$row->id,'Project Charter - Report');
		
		return $link;
	}
	function pm_tabcount_getNumber($compId='', $deptId='', $year='', $month='') {
		$this->_ci->load->model('m_pm_tabcount');
		$this->_ci->load->model('m_division');
		
		$where['iCompanyId'] = $compId;
		$where['iDeptId'] = $deptId;
		$where['iYY'] = $year;
		$where['iMM'] = $month;
		$rows = $this->_ci->m_pm_tabcount->select( $where );
		if($rows) {
			$new_number = $rows[0]['iNumber'] + 1;
			
			$data['iNumber'] = $new_number;
			$success = $this->_ci->m_pm_tabcount->update($data, $where);
			
			$aaa =  str_pad($new_number, 4, "0", STR_PAD_LEFT);
				
			$bbb = $where['iDeptId'];
			$rows = $this->_ci->m_division->getDivById($where['iDeptId']);
			if($rows) {
				$bbb = isset($rows[0]['vInitial'])?$rows[0]['vInitial']:$where['iDeptId'];
			}
			$bbb.="-NPL";
				
			$ccc = $where['iMM'];
			$ddd = $where['iYY'];
				
			$number = $aaa."/".$bbb."/".$ccc."/".$ddd;
				
			return $number;
			
		} else {
			$data['iCompanyId'] = $compId;
			$data['iDeptId'] = $deptId;
			$data['iYY'] = $year;
			$data['iMM'] = $month;
			$data['iNumber'] = 1;
			$success = $this->_ci->m_pm_tabcount->insert( $data );
			
			$aaa =  str_pad($data['iNumber'], 4, "0", STR_PAD_LEFT);
			
			$bbb = $data['iDeptId'];
			$rows = $this->_ci->m_division->getDivById($data['iDeptId']);
			if($rows) {
				$bbb = isset($rows[0]['vInitial'])?$rows[0]['vInitial']:$data['iDeptId'];
			}
			$bbb.="-NPL";
			
			$ccc = $data['iMM'];
			$ddd = $data['iYY'];
			
			$number = $aaa."/".$bbb."/".$ccc."/".$ddd;
			
			return $number;
		}
	}
	function get_headdiv_by_nip($nip='') {
		if($nip=='') return false;
		
		$this->_ci->load->model('m_employee');
		$rows = $this->_ci->m_employee->getEmployeeByNip( $nip );
		if($rows) {
			$iDeptId = $rows[0]['iDeptId'];
			$rows = $this->_ci->m_employee->getEmployeeByDeptPos( $iDeptId, 5 );
			
			if($rows) {
				return $rows[0]['cNip'];
			}
		}
		
		return '-';
	}
	function get_aybs_by_nip($nip='') {
		if($nip=='') return false;
		
		$this->_ci->load->model('m_employee');
		$rows = $this->_ci->m_employee->getEmployeeByNip( $nip );
		if($rows) {
			return $rows[0]['cUpper'];
		}
		
		return '-';
	}
	function insert_stakeholder($id='',$param='') {
		if($id=='') return false;
		
		$this->_ci->load->model('m_pm_stakeholder');
		$this->_ci->load->model('m_pm_charter');
		
		$deptId = '';
		$compId = '';
		$rows = $this->_ci->m_pm_charter->select_by_id($id);
		if($rows) {
			$deptId = $rows[0]['iDeptID'];
			$compId = $rows[0]['iCompanyId'];
		}
		
		if(is_array($param)) {
			
			$data=$where=array();
			$data['isDeleted']=1;
			$where['idpm_charter'] = $id;
			$this->_ci->m_pm_stakeholder->update($data, $where);
			
			foreach($param as $key => $val) {
				$data=array();
				$data['idpm_charter']=$id;
				$data['cNip']=$val;
				$data['iDeptID']=$deptId;
				$data['iCompanyId']=$compId;
				$data['tCreatedAt'] = date('Y-m-d H:i:s');
				$data['cCreatedBy'] = $this->session['nip'];
				$data['cUpdatedBy'] = $this->session['nip'];
				$success = $this->_ci->m_pm_stakeholder->insert($data);
			}
			
			if($success) {
				return true;
			}

		}
		
		return false;
		
	}
	function delete_stakeholder($id='') {
		if($id=='') return false;
		
		$this->_ci->load->model('m_pm_stakeholder');
		$this->_ci->load->model('m_pm_charter');
		
		$deptId = '';
		$compId = '';
		$rows = $this->_ci->m_pm_charter->select_by_id($id);
		if($rows) {
			$deptId = $rows[0]['iDeptID'];
			$compId = $rows[0]['iCompanyId'];
		}
			
		$data=$where=array();
		$data['isDeleted']=1;
		$where['idpm_charter'] = $id;
		$this->_ci->m_pm_stakeholder->update($data, $where);
		
		return true;
	}
	function insert_paramsucceed($id='',$arr_desc='',$arr_target='',$arr_weight='') {
		if($id=='') return false;
	
		$this->_ci->load->model('m_pm_paramsucceed');
		$this->_ci->load->model('m_pm_charter');
	
		$deptId = '';
		$compId = '';
		$rows = $this->_ci->m_pm_charter->select_by_id($id);
		if($rows) {
			$deptId = $rows[0]['iDeptID'];
			$compId = $rows[0]['iCompanyId'];
		}
		$param = $arr_weight;
		if(is_array($param)) {
			$data=$where=array();
			$data['isDeleted']=1;
			$where['idpm_charter'] = $id;
			$this->_ci->m_pm_paramsucceed->update($data, $where);
				
			foreach($param as $key => $val) {
				$vDesc = isset($arr_desc[$key])?$arr_desc[$key]:'';
				$vTarget = isset($arr_target[$key])?$arr_target[$key]:'';
				$iWeight = isset($arr_weight[$key])?$arr_weight[$key]:'';
				
				$data=array();
				$data['idpm_charter']=$id;
				$data['vDesc']=$vDesc;
				$data['vTarget']=$vTarget;
				$data['iWeight']=$iWeight;
				$data['iDeptID']=$deptId;
				$data['iCompanyId']=$compId;
				$data['tCreatedAt'] = date('Y-m-d H:i:s');
				$data['cCreatedBy'] = $this->session['nip'];
				$data['cUpdatedBy'] = $this->session['nip'];
				$success = $this->_ci->m_pm_paramsucceed->insert($data);
			}
				
			if($success) {
				return true;
			}
		}
	
		return false;
	
	}
	function delete_paramsucceed($id='') {
		if($id=='') return false;
	
		$this->_ci->load->model('m_pm_paramsucceed');
		$this->_ci->load->model('m_pm_charter');
	
		$deptId = '';
		$compId = '';
		$rows = $this->_ci->m_pm_charter->select_by_id($id);
		if($rows) {
			$deptId = $rows[0]['iDeptID'];
			$compId = $rows[0]['iCompanyId'];
		}

		$data=$where=array();
		$data['isDeleted']=1;
		$where['idpm_charter'] = $id;
		$this->_ci->m_pm_paramsucceed->update($data, $where);
				
		return true;
	}
	function insertRecordHistory($tableSource, $tableDest, $arrWhere,$pk=''){
		// * Nama, type field harus sama persis
		// * $tableDest tidak boleh ada field dengan type auto increment atau PK selain  id kolom pertama
		// * $arrWhere harus berbentuk array assosiatif
	
		//////$CI=& get_instance();
		//$novellpharm = $CI->load->database('default', TRUE);
		$selectFrom = "SELECT * FROM ".$tableSource;
		$sqlSource = $selectFrom." LIMIT 1";
	
		$arrField=array();
		$query = $this->_ci->db->query($sqlSource);
		foreach ($query->list_fields() as $field)$arrField[] = $field;
		/*
		 $strWhere="";
		foreach($arrWhere as $key=>$value){
		if($strWhere=="") $strWhere.="$key='$value'";
		else $strWhere=$strWhere." AND $key='$value'";
		}
	
		$sqlDest = $selectFrom." WHERE ".$strWhere;
		$dataDest = $CI->db->query($sqlDest)->row_array();
		*/
		$dataDest = $this->_ci->db->get_where($tableSource, $arrWhere)->row_array();
		//log_message('info',$arrField[39]);
		$ret = 0;
		if(count($dataDest)>0){
			$data=array();
			foreach($arrField as $detField=>$f){
				$ar1=array($f=>$dataDest[$f]);
				$data = array_merge($data,$ar1);
			}
			//print_r($data);
			if(count($data)>0){
				if(isset($pk['base']) && isset($pk['target'])) {
					$data[ $pk['target'] ] = $data[ $pk['base'] ];
					unset($data[ $pk['base'] ]);
				}
				//if(TRUE===$CI->db->simple_query($CI->db->insert_string($tableDest,$data))) $ret=1;
				//log_message('info',$CI->db->insert_string($tableDest,$data));
				////$ret = $CI->Menu_model->insertRecordHistory($tableDest, $data);
				if(TRUE===$this->_ci->db->simple_query($this->_ci->db->insert_string($tableDest,$data))) {
					$ret=1;
				} else {
					$ret=0;
				}
				//$ret = 1;
			}
		}
	
		return $ret;
	}
	function restoreRecordHistory($tableSource, $tableDest, $arrWhere,$pk=''){
		// * Nama, type field harus sama persis
		// * $tableDest tidak boleh ada field dengan type auto increment atau PK selain  id kolom pertama
		// * $arrWhere harus berbentuk array assosiatif
	
		//////$CI=& get_instance();
		//$novellpharm = $CI->load->database('default', TRUE);
		$selectFrom = "SELECT * FROM ".$tableSource;
		$sqlSource = $selectFrom." LIMIT 1";
	
		$arrField=array();
		$query = $this->_ci->db->query($sqlSource);
		foreach ($query->list_fields() as $field)$arrField[] = $field;
		/*
		 $strWhere="";
		foreach($arrWhere as $key=>$value){
		if($strWhere=="") $strWhere.="$key='$value'";
		else $strWhere=$strWhere." AND $key='$value'";
		}
	
		$sqlDest = $selectFrom." WHERE ".$strWhere;
		$dataDest = $CI->db->query($sqlDest)->row_array();
		*/
		$dataDest = $this->_ci->db->get_where($tableSource, $arrWhere)->row_array();
		//log_message('info',$arrField[39]);
		$ret = 0;
		if(count($dataDest)>0){
			$data=array();
			foreach($arrField as $detField=>$f){
				$ar1=array($f=>$dataDest[$f]);
				$data = array_merge($data,$ar1);
			}
			//print_r($data);
			if(count($data)>0){
				$where=array();
				if(isset($pk['base']) && isset($pk['target'])) {
					$data[ $pk['target'] ] = $data[ $pk['base'] ];
					
					$where= " {$pk['target']} = {$data[ $pk['target'] ]} ";
					unset($data[ $pk['base'] ]);
					unset($data[ $pk['target'] ]);
				}
				//print_r($data);
				//print_r($where);
				//exit();
				//if(TRUE===$CI->db->simple_query($CI->db->insert_string($tableDest,$data))) $ret=1;
				//log_message('info',$CI->db->insert_string($tableDest,$data));
				////$ret = $CI->Menu_model->insertRecordHistory($tableDest, $data);
				
				if(TRUE===$this->_ci->db->query($this->_ci->db->update_string($tableDest,$data, $where))) {
					$ret=1;
				} else {
					$ret=0;
				}
				//$ret = 1;
			}
		}
	
		return $ret;
	}
	function calcDate($startdate='',$enddate='') {
		if($startdate=='' || $enddate =='') return false;
		
		$startdate = date('Y-m-d',strtotime($startdate));
		$enddate = date('Y-m-d',strtotime($enddate));
		
		$d1 = strtotime($startdate);
		$d2 = strtotime($enddate);
		$diff= $d2-$d1;
		$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
		$days+=1; //if d1 == d2 , result :1 not 0.
		
		$hours=round(($diff-$days*60*60*24)/(60*60));
		
		return array('days'=>$days,'hours'=>$hours);
	}
	function calcBussinessDate($startdate='', $enddate='') {
		if($startdate=='' || $enddate =='') return false;
		
		$startdate = date('Y-m-d',strtotime($startdate));
		$enddate = date('Y-m-d',strtotime($enddate));
		
		$holidays = $this->getHolidayDate( $startdate, $enddate );
		
		$weekend = array(6,7); //1 = monday, 7 = sunday
		
		$t_startdate = strtotime($startdate);
		$t_enddate = strtotime($enddate);
		
		$onDay=0;
		
		//hitung tanpa weekend
		$x = $t_startdate;
		$y = $t_enddate;
		while($x <= $y) {
			$day = date('N', $x);
			if( in_array($day, $weekend) ) {
				$onDay = $onDay - 1;
			}
			
			$x+=86400;
			$onDay = $onDay + 1;
		}
		
		//hitung tanpa holiday
		foreach($holidays as $id => $holiday) {
			$time_stamp=strtotime($holiday);
			if ( $t_startdate <= $time_stamp && $time_stamp <= $t_enddate 
				 && !in_array( date('N', $time_stamp), $weekend ) ) {
				$onDay = $onDay - 1;
			}
		}
		
		return $onDay;
	}
	function getHolidayDate($startdate='',$enddate='') {
		if($startdate=='' || $enddate =='') return false;
		
		$startdate = date('Y-m-d',strtotime($startdate));
		$enddate = date('Y-m-d',strtotime($enddate));
		
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$sql = "SELECT iID, ddate FROM hrd.holiday 
				WHERE bDeleted=0 AND 
				ddate BETWEEN '".$startdate."' 
				AND LAST_DAY('".$enddate."')";
		$query = $this->db_erp_pk->query($sql);
		$tmpHoliday=array();
		if($query->num_rows()>0) {
			$rows = $query->result_array();
			foreach($rows as $key => $row) {
				$tmpHoliday[ $row['iID'] ]=$row['ddate'];
			}
		}
		return $tmpHoliday;
	}
	function realizationCharterClosed($idpm_charter) {
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		$logged_nip = $this->session['nip'];
		
		$sql_select = "SELECT * FROM pm_task WHERE isDeleted = 0 AND idpm_charter =':id' AND fCompletion != 100";
		$sql_update = "UPDATE pm_charter SET isClosed = ':isclosed', cUpdatedBy = '$logged_nip'
					   WHERE isDeleted = 0 AND id = ':id';";
		
		$sql = str_replace(':id',$idpm_charter, $sql_select);
		
		$query = $this->db_erp_pk->query($sql);

		if($query->num_rows()>0) { //masih ada yang belum complete
			//do nothing
		} else { //sudah complete semua task
			$sql = str_replace(':id',$idpm_charter, $sql_update);
			$sql = str_replace(':isclosed',1, $sql);
			//$sql = str_replace(':tclosed',date('Y-m-d H:i:s'), $sql);
			
			//echo $sql;
			$query = $this->db_erp_pk->query($sql);
		}
	}
	function realizationParentFinish($idpm_charter, $_vno) {
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		$logged_nip = $this->session['nip'];
	
		$sql_select = "SELECT * FROM pm_task WHERE isDeleted = 0 AND idpm_charter =':id' AND vNo = ':vno';";
		$sql_select_child = "SELECT * FROM pm_task WHERE isDeleted = 0 AND idpm_charter=':id' AND IDParent = ':vno';";
		$sql_update = "UPDATE pm_task SET txtRealization = ':real', fCompletion = ':comp', tActualStarted = ':star', tActualFinished = ':fini',
		cUpdatedBy = '$logged_nip'
		WHERE isDeleted = 0 AND idpm_charter = ':id' AND vNo = ':vno';";
	
		$sql = str_replace(':id',$idpm_charter, $sql_select);
		$sql = str_replace(':vno',$_vno, $sql);
	
		$query = $this->db_erp_pk->query($sql);
	
		$finished_task = false;
		$fCompletion = '';
		$vNoParent = '';
		if($query->num_rows()>0) {
			$row = $query->row();
			$fCompletion = $row->fCompletion;
			$vNoParent = $row->IDParent;
			$finished_task = ( intval($fCompletion)==100 )?true:false;
		}
	
	
		if($finished_task && !empty($vNoParent)) { // step 1 dan 2 , fCompletion == 100 and IDParent not empty
			$sql = str_replace(':id',$idpm_charter, $sql_select_child);
			$sql = str_replace(':vno',$vNoParent, $sql);
				
			$query = $this->db_erp_pk->query($sql); // step 3, select all child by parent id
				
			if($query->num_rows()>0) {
				$rows = $query->result_array();
				$jumlah_finish = 0;
				foreach($rows as $row) {
					$fCompletion = $row['fCompletion'];
					$finished_task = ( intval($fCompletion)==100 )?true:false;
					if($finished_task) {
						$jumlah_finish++;
					}
				}
				if($jumlah_finish == count($rows)) { // step 4, if all child completion ==100
					$sql = str_replace(':real','', $sql_update);
					$sql = str_replace(':comp',100, $sql);
					$sql = str_replace(':star',date('Y-m-d H:i:s'), $sql);
					$sql = str_replace(':fini',date('Y-m-d H:i:s'), $sql);
					$sql = str_replace(':id',$idpm_charter, $sql);
					$sql = str_replace(':vno',$vNoParent, $sql);
						
					$success = $this->db_erp_pk->query( $sql ); // step 5, update parent task completion = finished
	
					$this->realizationParentFinish($idpm_charter, $vNoParent);
				}
			}
		}
	}
	function updateRequestStatus($idpm_request=false, $status=false) {
		if(!$idpm_request) return false;
		
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		$logged_nip = $this->session['nip'];
		
		$sql = "SELECT iStatus FROM pm_request WHERE ID ='".$idpm_request."'";
		$query = $this->db_erp_pk->query($sql);
		if($query->num_rows()>0) {
			$row = $query->row();

			if($status < $row->iStatus) {
				return false;
			}
		}
		
		$sql = "UPDATE pm_request SET iStatus = '$status' WHERE ID = '".$idpm_request."'";
		$query = $this->db_erp_pk->query($sql);
		return $query;
	}
	function isAllTaskApproved($idpm_charter) {
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$sql = "SELECT COUNT(ID) AS jumlah_approve,
				(SELECT COUNT(ID)
				FROM pm_task WHERE isDeleted=0
				AND idpm_charter = '".$idpm_charter."') AS jumlah_task
				FROM pm_task
				WHERE isDeleted = 0 AND idpm_charter = '".$idpm_charter."'
				AND DATE(tApprovalAt ) > 0;";
		$query = $this->db_erp_pk->query($sql);
		if($query->num_rows()>0) {
			$row = $query->row();
			if( $row->jumlah_approve == $row->jumlah_task) {
				return true;
			}
		}
		
		return false;
	}
	function getDeptIdByName($name='') {
		$deptId=0;
		if($name) {
			$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
			$sql = "SELECT * FROM hrd.msdivision WHERE vAbbreviation LIKE '".$name."' LIMIT 1";
			$query = $this->db_erp_pk->query($sql);
			if($query->num_rows()>0) {
				$row = $query->row();
				$deptId = $row->iDivID;
			}
		}
		return $deptId;
	}
	
	function getSysParam($cVariable) {
		$vContent = '';
		$sql = "SELECT vContent FROM pk.sysparam where cVariable = '{$cVariable}' limit 1";
		$query = $this->db_erp_pk->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
            $vContent = $row->vContent;
		}
		
		return $vContent;
	}
	
	function splitSysParamWC($vContent) {
		$rslt = explode(",", $vContent);
		return $rslt;
	}
	
	function getListDivByHOD($nip) {
		$sql = "SELECT a.iDivisionId, b.vDescription FROM hrd.employee a, 
					hrd.msdivision b WHERE a.iDivisionId = b.iDivId AND a.cUpper = '".$nip."' 
					AND (a.dResign = '0000-00-00' OR a.dResign > CURDATE()) 
					GROUP BY a.iDivisionId";
		$query = $this->db_erp_pk->query($sql);
		$l_divisi = "0,";
		if ( $query->num_rows() > 0 ) {
			foreach($query->result_array() as $rx) {
				$l_divisi .= $rx['iDivisionId'].",";
			}
			$l_divisi = substr($l_divisi, 0, strlen($l_divisi) - 1);
		}
		
		return $l_divisi;
	}


	function getStakeholder($idpm_charter,$role){
		if ($role=='ALL'){
			$sql = "SELECT cNip FROM pm.pm_stakeholder WHERE idpm_charter='".$idpm_charter."' ";
		}else{
			$sql = "SELECT cNip FROM pm.pm_stakeholder 
					WHERE idpm_charter='".$idpm_charter."' AND iRole='".$role."' ";
		}

		$result = '';
		$query = $this->db_erp_pk->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result_array() as $row) {
				
				$result .= $row['cNip'].",";
			}
		}

		if ($role=='ALL' || $role==1){
			//plust cari di charternya
			$sql = "SELECT cNipPM FROM pm.pm_charter WHERE id='".$idpm_charter."'";
			$query = $this->db_erp_pk->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
			        $result .= $row->cNipPM;
			}
		}

		$result = rtrim($result,',');
		return 	$result;

	}

	// Krisna

	function getvName($cNip) {

		$vName = '';

		$sql = "SELECT vName FROM hrd.employee WHERE cNip = '{$cNip}' AND lDeleted = 0";
		$query = $this->db_erp_pk->query($sql);

		if ($query->num_rows() > 0) {
			$row = $query->row();

			$vName = $row->vName;
		}

		return $vName;
	}



	function getNipSubOrdinat($cNip, &$tmpNip){ //cari bawahan
        $nipUnder = array();
        $nipUnder = $this->scanNipAll($cNip, $tmpNip);
        $jmlUnder = sizeOf($nipUnder);
        
        $in = 'IN (';
        if ($jmlUnder > 0) {
            
            foreach ($nipUnder as $nUnder) {
                $in .= '"'.$nUnder.'",';
            }
            $in = substr($in, 0, strlen($in) - 1);          
        } else {
            $in .= '""';
        }

        $q = $in.')';
        return $q;
        
    }


    function scanNipAll($cNip, &$tmpNip) {

        $sql = "Select cUpper from hrd.employee where cNip='".$cNip."' limit 1";
        $query = $this->db_erp_pk->query($sql);
            $row = $query->row();
            $tCUpper = $row->cUpper;

        $sql = "Select cNip from hrd.employee where cUpper='".$cNip."' GROUP BY cNip";

        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows > 0) {
            foreach($query->result_array() as $row) {

            $tmpNip[] .= $row['cNip'];
            $cNip = $row['cNip'];

            if (strlen($tCUpper)  > 0) 
                $this->scanNipAll($cNip, $tmpNip);
                
            }
        }
        return $tmpNip;

        

    }




    function getAybs($cUpper,&$tmpNip){
        //Fungsi untuk mendapatkan nip Semua atasan
        $sql = "Select cUpper from hrd.employee where cNip='".$cUpper."'";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows > 0) {
            foreach($query->result_array() as $row) {
                //echo $sql;
                $cUpper = $row['cUpper'];
                if ($cUpper=='') {
                     break;
                }
                $tmpNip[] .= $cUpper;
                $this->getAybs($cUpper,$tmpNip);

            }
        }

        return $tmpNip;
    }

    function getTopAybs($nip){
        $tmpNip = array();
        $tmpNip = $this->getAybs($nip,$tmpNip);
        $topAybs = '';
        $ke = 0;
        foreach ($tmpNip as $key => $value) {
            $ke = $ke +1;
            if ($ke == 1 && $value=='N00923'){
                $topAybs = $value ;
                
                
            }else if ($value != 'N00923' ) {
                $topAybs = $value;
            }

            
        }

        return $topAybs;
    }

    function getKateGoriPk($value){
        $result = '-Buruk';
        $sql = "SELECT vKeterangan FROM hrd.pk_kategori 
                WHERE {$value} BETWEEN iNilai1 AND iNilai2";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->vKeterangan;
        }

        return $result; 

    }

    function getColorPK($value){
        $result = '#ffffff';
        $sql = "SELECT cWarna FROM hrd.pk_warna WHERE iPoint='".$value."'";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->cWarna;
        }

        return $result;
    }

    function getHolyday($year1,$year2,$company){
        $sql= "SELECT *
                FROM (SELECT a.dDate AS tgl,a.cYear, 'hol' AS src,a.cdescription AS ket
                      FROM hrd.holiday AS a
                  UNION ALL
                      SELECT b.dDate AS tgl,b.cYear,'cho' AS src,b.vDescription AS ket
                      FROM hrd.compholiday AS b
                        WHERE b.iCompanyId='".$company."'
                     )AS tabgab
                   WHERE cyear BETWEEN '".$year1."' AND '".$year2."'";
    
        
        $holidays = Array();
        $result = mysql_query($sql) or die(mysql_error()."</br>".$sql);
        
        while ($row = mysql_fetch_assoc($result)) {
            array_push($holidays, $row['tgl']);
        }

        return $holidays;

    }

	function getDivId($nip){
		$iDivisionID = '';
		$sql = "SELECT iDivisionID  FROM hrd.employee WHERE cNip='".$nip."' AND lDeleted=0";
		$query = $this->db_erp_pk->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$row = $query->row();
			$iDivisionID  = $row->iDivisionID;

		}
		return $iDivisionID;
	}

	function getSkemaPKOld($nip){
		$iSkemaId = '';
		$sql = "SELECT id  from hrd.pk_skema where iPostId in(
			select iPostId FROM hrd.employee WHERE cNip = '".$nip."' )";
			//echo '<pre> ulala'.$sql;
		$query = $this->db_erp_pk->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$row = $query->row();
			$iSkemaId  = $row->id;

		}
		return $iSkemaId;
	}

	function getSkemaPK($nip){
		$iSkemaId = '';
		$sql = "SELECT id  from hrd.pk_skema where iPostId in(
			select iPostId FROM hrd.employee WHERE cNip = '".$nip."' )";
			//echo '<pre> ulala'.$sql;
		$query = $this->db_erp_pk->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			//$iSkemaId  = $row->id;
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$iSkemaId = $data['id'];
				}else{
					$iSkemaId .= ','.$data['id'];
				}
				$i++;
			}

		}
		//echo 'ulala'.$iSkemaId;

		return $iSkemaId;
	}

    function getEmail($nip){
        $email = '';
        $sql = "SELECT vEmail  FROM hrd.employee WHERE cNip='".$nip."' AND lDeleted=0";
        $query = $this->db_erp_pk->query($sql);
        $jmlRow = $query->num_rows();
        if ($jmlRow > 0) {
            $row = $query->row();
            $email  = $row->vEmail;
            
        }
        return $email;
    }

    function sendEmailPK($id,$sub){
        $sql = "SELECT a.cNip,b.vName,b.vEmail,
                (SELECT vDescription FROM hrd.msdivision WHERE iDivID=b.iDivisionID) AS divisi,
                (SELECT vDescription FROM hrd.msdepartement WHERE iDeptID=b.iDepartementId) AS departement,
                (SELECT vDescription FROM hrd.bagian WHERE ibagid=b.ibagid) AS bagian,
                (SELECT vDescription FROM hrd.position WHERE iPostId=b.iPostId) AS jabatan
                FROM hrd.pk_trans AS a 
                INNER JOIN hrd.employee AS b ON b.cNip=a.cNip
                WHERE a.id='".$id."' ";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row        = $query->row();
            $cNip       = $row->cNip;
            $vName      = $row->vName;
            $vEmail     = $row->vEmail;
            $divisi     = $row->divisi;
            $departement = $row->departement;
            $bagian     = $row->bagian;
            $jabatan    = $row->jabatan;

            $tmpnip = array();
            $aybs = $this->getAybs($cNip,$tmpnip);

           
            $ke = 1;
            $to = '';
            $cc = '';

            foreach ($aybs as $key) {
                $email = $this->getEmail($key);

                if ($key=='N00923'){
                    break;
                }
                
                if ($ke==1){
                    $to = $email;
                }else{
                    $cc = $email.",";
                }

                $ke = $ke + 1;
            }

            $cc = rtrim($cc,",");

            $subject = "Need Aggrement ".$sub." Atas Nama ".ucwords(strtolower($vName));

$content = "<pre> 
Dengan Hormat,

Kamiberitahunkan bahwa terdapat Pengajuan Penilian Kinerja yang membutuhkan Aggrement
atas nama <b>".ucwords(strtolower($vName))." - (".$cNip.")</b> 
Proses Aggrement tersebut dapat anda lakukan pada Aplikasi ERP (http://www.npl-net.com/erp/) 
dan pada menu General Affair => Penilian Kinerja => ".$sub."

Terimakasih
--mail autogenerated--
".date('d-m-Y H:i:s')."


</pre>";

        //echo $subject.$content;
        $path = '';
        $this->send_email($to, $cc, $subject, $content, $path, $from='postmaster@novellpharm.com');
        exit();
            
        } 
    }

    function getDivisionName($iDivId) {

    	$query = $this->db_erp_pk->get_where('hrd.msdivision', array('iDivID' => $iDivId));
    	$row = $query->row();

    	$namaDivisi = $row->vDescription;
    	return $namaDivisi;
    }

}