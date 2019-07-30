<?php
class lib_flow { 	
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
    }
    function user() {
		return $this->sess_auth;
	}

	
	function insert_logs($modul_id,$iupb_id,$action_id,$iapproval= 0,$tipe=1){
		$icount=0;
		$isFinish=0;
		
		$datalast_act= $this->get_last_act_module($modul_id);

		$sqlp_action = 'select * 
						from plc2.master_proses_action a
						join plc2.master_action b on b.master_action_id=a.master_action_id
						join plc2.master_proses c on c.master_proses_id=a.master_proses_id
						where c.idprivi_modules="'.$modul_id.'"
						and b.master_action_id="'.$action_id.'"
						and c.iTipe="'.$tipe.'"
						and a.lDeleted=0
						and b.lDeleted=0
						and c.lDeleted=0';
		$datap = $this->_ci->db->query($sqlp_action)->row_array();						
		//echo $sqlp_action;
		$datap['master_action_id'];

		// jika sudah berapa kali proses input di modul tersebut
		
			$sql_check_log ='select * from plc2.upb_proses_logs a 
							where a.lDeleted=0
							and a.iupb_id="'.$iupb_id.'"
							and a.master_proses_action_id="'.$datap['master_proses_action_id'].'"
							order by a.iupb_proses_logs DESC limit 1';
			$datacl = $this->_ci->db->query($sql_check_log)->row_array();								
			// jika ditemukan pernah input di log 
			if (!empty($datacl)) {
				$icount=$datacl['iCount']+1;
			}else{
				$icount=0;
			}

		// jika adalah action terakhir dari modul 			
		if ($datalast_act['master_proses_action_id'] == $datap['master_proses_action_id']  ) {

			$isFinish=1;
		}	
		
		$user = $this->_ci->auth->user();
		$ins['iupb_id'] = $iupb_id;
		$ins['master_proses_action_id'] = $datap['master_proses_action_id'];
		$ins['iApprove'] = $iapproval;
		$ins['cNip'] = $user->gNIP;
		$ins['iCount'] = $icount;
		$ins['isFinish'] = $isFinish;
		$ins['dCreate'] = date('Y-m-d H:i:s');
		return $this->_ci->db->insert('plc2.upb_proses_logs', $ins);
	}

	function prev_process($modul_id,$iupb_id){
		$check_required_process ='select dd.idprivi_modules as idreq_proses, dd.vNameModule as req_proses
						from plc2.master_proses a 
						join plc2.master_proses_parent b on b.master_proses_id=a.master_proses_id
						join plc2.master_proses_child c on c.master_proses_parent_id=b.master_proses_parent_id
						join plc2.master_proses cc on cc.master_proses_id=c.master_proses_id
						join erp_privi.privi_modules d on d.idprivi_modules=a.idprivi_modules
						join erp_privi.privi_modules dd on dd.idprivi_modules=cc.idprivi_modules
						where a.idprivi_modules="'.$modul_id.'"
						and a.lDeleted=0
						and b.lDeleted=0
						and c.lDeleted=0';
		$datarps = $this->_ci->db->query($check_required_process)->result_array();
		$datarps_count=count($datarps);
		$ar_iupb=array();
		$ireq_proc = 0;
		foreach ($datarps as $datarp) {
			
			$check_log_prev_proc ='select a.iupb_id 
							from plc2.upb_proses_logs a 
							join plc2.master_proses_action b on b.master_proses_action_id=a.master_proses_action_id
							join plc2.master_proses c on c.master_proses_id=b.master_proses_id
							where a.iupb_id="'.$iupb_id.'" and a.isFinish=1
							and c.idprivi_modules ="'.$datarp['idreq_proses'].'" order by a.iupb_proses_logs DESC limit 1';
			$datalog_prev_proc = $this->_ci->db->query($check_log_prev_proc)->row_array();

			if (!empty($datalog_prev_proc)) {
				array_push($ar_iupb,$datalog_prev_proc['iupb_id']);
//				print_r($a);	
				$ireq_proc ++;
			}


		}	

		if ($datarps_count == $ireq_proc) {
			$idupb=$ar_iupb;
		}else{
			$idupb=0;
		}
		
		

	}

	function next_proses($modul_id,$iupb_id,$action_id,$iapproval= 0){
		
		$datalast_log= $this->get_last_log($modul_id,$iupb_id);
		$datalast_act= $this->get_last_act_module($modul_id);
		
		$ichild=0;
		$iflow=0;

		if (!empty($datalast_log)) {
			// cek apakah proses terakhir pada log adalah action terakhir dari modul
			if ($datalast_log['master_proses_action_id'] == $datalast_act['master_proses_action_id']  ) {
				$get_flow = $this->get_flow($iupb_id);
				
				$get_flow_wajib = $this->get_flow_wajib($iupb_id);
				$count_flow_wajib = count($get_flow_wajib);

				if (!empty($get_flow)) {
					$count_child_wajib = 0;
					foreach ($get_flow as $gf ) {
						$get_child = $this->get_child($gf['master_proses_parent_id']);
						$get_child_wajib = $this->get_child_wajib($gf['master_proses_parent_id']);
						$count_child_wajib_p = count($get_child_wajib);

						if (!empty($get_child)) {
							foreach ($get_child as $gc ) { // foreach array

								$last_act_id= $this->get_last_act_id_module($gc['idprivi_modules']);
								$last_log_pf= $this->get_last_log_with_key($gc['idprivi_modules'],$iupb_id,$last_act_id['master_proses_action_id']);

								
								if (!empty($last_log_pf)) {
									// jika log child tidak kosong
									if ( ($last_log_pf['master_action_id'] == 1 ) or ($last_log_pf['master_action_id'] == 3 and $last_log_pf['iApprove']==2  ) or ($last_log_pf['master_action_id'] == 4 and $last_log_pf['iApprove']== 2  )  ) {
											$ichild ++;
									}else{
										// jika tidak ada di lognya , apakah ada kondisi khusus dari modul?
										$check_modul = 'check_modul'.'_'.$gc['path'];
										$cek_modul = $this->$check_modul($gc['idprivi_modules'],$iupb_id);
										if ($cek_modul==1) {
											$ichild ++;			
										}else if($cek_modul== '-1'){
											$ichild = $ichild-1;			
										}

									}
							
								}else{
									// jika log child kosong , apakah ada kondisi khusus dari modul?
									$check_modul = 'check_modul'.'_'.$gc['path'];
									$cek_modul = $this->$check_modul($gc['idprivi_modules'],$iupb_id);
									if ($cek_modul==1) {
											$ichild ++;			
									}else if($cek_modul== '-1'){
										$ichild = $ichild-1;			
									}

								}

							}
						}

						$get_parent = $this->get_parent_detail($gf['master_proses_parent_id']);
						$flast_act_id= $this->get_last_act_id_module($get_parent['idprivi_modules']);
						$flast_log_pf= $this->get_last_log_with_key($get_parent['idprivi_modules'],$iupb_id,$flast_act_id['master_proses_action_id']);

						if (!empty($flast_log_pf)) {
							$iflow ++;
						}else{
							$check_modul = 'check_modul'.'_'.$gf['path'];
							$cek_modul = $this->$check_modul($gf['idprivi_modules'],$iupb_id);
							if ($cek_modul==1) {
								$iflow ++;			
							}
						}
						$count_child_wajib +=$count_child_wajib_p;

					}
				}
				
				
				//echo $count_flow_wajib.$iflow.$count_child_wajib.$ichild;
				//exit;
				if (  $iflow  >= $count_flow_wajib and $ichild >= $count_child_wajib   ) {
					$hasil=1;
				}else{
					$hasil=0;
				}

				if ($hasil==1) {
						
					$dupb=$this->get_upb($iupb_id);				
					
					$data['master_flow_id']=$dupb['master_flow_id']+1;
					$this->_ci->db->where('iupb_id',$iupb_id);
					$update = $this->_ci->db->update('plc2.plc2_upb',$data);
				}	


			}
		}

			
	

		

										

	}

	function get_flow($iupb_id){
		$dupb=$this->get_upb($iupb_id);				
		$sql_flow =
		'select * ,REPLACE (e.vPathModule, "/", "_") as path
		from plc2.master_flow a 
		join plc2.master_flow_detail b on b.master_flow_id=a.master_flow_id
		join plc2.master_proses_parent c on c.master_proses_parent_id=b.master_proses_parent_id
		join plc2.master_proses d on d.master_proses_id=c.master_proses_id
		join erp_privi.privi_modules e on e.idprivi_modules=d.idprivi_modules
		where a.lDeleted=0
		and b.lDeleted=0
		and c.lDeleted=0
		and d.lDeleted=0
		and e.isDeleted=0
		and a.master_flow_id ="'.$dupb['master_flow_id'].'"';
		return $this->_ci->db->query($sql_flow)->result_array();
	}

	function get_flow_wajib($iupb_id){
		$dupb=$this->get_upb($iupb_id);				
		$sql_flow =
		'select * 
		from plc2.master_flow a 
		join plc2.master_flow_detail b on b.master_flow_id=a.master_flow_id
		where a.lDeleted=0
		and b.lDeleted=0
		and b.isFmandatory=1
		and a.master_flow_id ="'.$dupb['master_flow_id'].'"';
		return $this->_ci->db->query($sql_flow)->result_array();
	}

	function get_parent_detail($parent_id){
		$sql_parent = 'select * 
		from plc2.master_proses_parent a
		join plc2.master_proses b on b.master_proses_id=a.master_proses_id 
		where a.lDeleted=0
		and b.lDeleted=0
		and a.master_proses_parent_id="'.$parent_id.'" ';
		$pro_flow = $this->_ci->db->query($sql_parent)->row_array();

		return $pro_flow;
	}

	function get_child($parent_id){
		$sql_child = '
		select * ,REPLACE (d.vPathModule, "/", "_") as path
		from plc2.master_proses_parent a 
		join plc2.master_proses_child b on b.master_proses_parent_id = a.master_proses_parent_id
		join plc2.master_proses c on c.master_proses_id=b.master_proses_id
		join erp_privi.privi_modules d on d.idprivi_modules=c.idprivi_modules
		where a.lDeleted=0
		and b.lDeleted=0
		and c.lDeleted=0
		and d.isDeleted=0
		and a.master_proses_parent_id="'.$parent_id.'" ';
		return $pro_flow = $this->_ci->db->query($sql_child)->result_array();
	}

	function get_child_wajib($parent_id){
		$sql_child = 'select * 
		from plc2.master_proses_parent a 
		join plc2.master_proses_child b on b.master_proses_parent_id = a.master_proses_parent_id
		where a.lDeleted=0
		and b.lDeleted=0
		and b.isCmandatory=1
		and a.master_proses_parent_id="'.$parent_id.'" ';
		return $pro_child = $this->_ci->db->query($sql_child)->result_array();
	}



	function cek_proses_finish($modul_id,$iupb_id){
		$cek_child =  $this->get_child_proses($iupb_id);
		if ($cek_child == 1) {
			$return =  1;
		}else{
			$return =  0;
		}

		return $return;
	}

	function get_child_proses($iupb_id){
		$sql_cek_flow = 'select b.master_flow_id,c.master_flow_id,f.idprivi_modules,g.vNameModule,e.isCmandatory,REPLACE (g.vPathModule, "/", "_") as path
		from plc2.plc2_upb a 
		join plc2.master_flow b on b.master_flow_id=a.master_flow_id
		join plc2.master_flow_detail c on c.master_flow_id=b.master_flow_id
		join plc2.master_proses_parent d on d.master_proses_parent_id=c.master_proses_parent_id
		join plc2.master_proses_child e on e.master_proses_parent_id = d.master_proses_parent_id
		join plc2.master_proses f on f.master_proses_id=e.master_proses_id
		join erp_privi.privi_modules g on g.idprivi_modules=f.idprivi_modules
		where a.iupb_id="'.$iupb_id.'" ';
		$pro_flow = $this->_ci->db->query($sql_cek_flow)->result_array();
		$count_flow= count($pro_flow);

		$ilogf=0;
		foreach ($pro_flow as $pf ) {
			$datalast_act_id= $this->get_last_act_id_module($pf['idprivi_modules']);
			$datalast_log_pf= $this->get_last_log_with_key($pf['idprivi_modules'],$iupb_id,$datalast_act_id['master_proses_action_id']);
				// cek flow sudah finish 
				if (!empty($datalast_log_pf)) {
					if ( ($datalast_log_pf['master_action_id'] == 1 ) or ($datalast_log_pf['master_action_id'] == 3 and $datalast_log_pf['iApprove']==2  ) or ($datalast_log_pf['master_action_id'] == 4 and $datalast_log_pf['iApprove']== 2  )  ) {
						$ilogf ++;	
					}
									
				}else{
					// jika child tidak mandatory , dan ketika tidak ada di log. maka bypass
				//	if($pf['isCmandatory']==0){
				//		$ilogf ++;	
				//	}else{
						// cek modul requirement ,
						$cek_modul = $this->check_modul.'_'.$pf['path']($pf['idprivi_modules'],$iupb_id);
						if ($cek_modul==1) {
							$ilogf ++;			
						}

				//	}
					
				}
		}

		if ($ilogf==$count_flow) {
			$hasil=1;
		}else{
			$hasil=0;
		}
		return	$hasil;

	}

	function get_upb($iupb_id){
		$sql_upb =
		'select * from  plc2.plc2_upb a where a.iupb_id="'.$iupb_id.'"and a.ldeleted=0';
		return $this->_ci->db->query($sql_upb)->row_array();
	}

	function cek_finish_flow($modul_id,$iupb_id){
		$sql_cek_flow = 'select b.master_flow_id,c.master_flow_id,f.idprivi_modules,g.vNameModule
		from plc2.plc2_upb a 
		join plc2.master_flow b on b.master_flow_id=a.master_flow_id
		join plc2.master_flow_detail c on c.master_flow_id=b.master_flow_id
		join plc2.master_proses_parent d on d.master_proses_parent_id=c.master_proses_parent_id
		join plc2.master_proses_child e on e.master_proses_parent_id = d.master_proses_parent_id
		join plc2.master_proses f on f.master_proses_id=e.master_proses_id
		join erp_privi.privi_modules g on g.idprivi_modules=f.idprivi_modules
		where a.iupb_id="'.$iupb_id.'" ';
		$pro_flow = $this->_ci->db->query($sql_cek_flow)->result_array();

		$count_flow= count($pro_flow);
		
		$ilogf=0;
		foreach ($pro_flow as $pf ) {
			//$datalast_log= $this->get_last_log($pf['idprivi_modules'],$iupb_id);
			$datalast_act_id= $this->get_last_act_id_module($pf['idprivi_modules']);
			$datalast_log_pf= $this->get_last_log_with_key($pf['idprivi_modules'],$iupb_id,$datalast_act_id['master_proses_action_id']);
				// cek flow sudah finish 
				if (!empty($datalast_log_pf)) {
					if ( ($datalast_log_pf['master_action_id'] == 1 ) or ($datalast_log_pf['master_action_id'] == 3 and $datalast_log_pf['iApprove']==2  ) or ($datalast_log_pf['master_action_id'] == 4 and $datalast_log_pf['iApprove']== 2  )  ) {
						$ilogf ++;	
					}
									
				}
				// cek dari child proses sudah finish semua belum 

			//$valid_child=$this->cek_child_finish($pf['idprivi_modules'],$iupb_id);	


			//$ilogf +=$valid_child;
		}

		//echo $ilog;
		if ($ilogf==$count_flow) {
			$hasil=1;
		}else{
			$hasil=0;
		}
		//echo $hasil;
		return	$hasil;

	}

	function cek_child_finish($modul_id,$iupb_id){
		$sql_cek_child='	
				select e.master_proses_action_id 
				from plc2.master_proses_child a
				join plc2.master_proses_parent b on b.master_proses_parent_id=a.master_proses_parent_id
				join plc2.master_proses c on c.master_proses_id=a.master_proses_id
				join plc2.master_proses cc on cc.master_proses_id=b.master_proses_id
				join erp_privi.privi_modules d on d.idprivi_modules=c.idprivi_modules
				join plc2.master_proses_action e on e.master_proses_id=c.master_proses_id
				join plc2.master_action f on f.master_action_id=e.master_action_id
				where cc.idprivi_modules="'.$modul_id.'"
				and c.idprivi_modules not in ("'.$modul_id.'")
				order by e.iUrutan ';
		//echo $sql_cek_child;
		$pro_child = $this->_ci->db->query($sql_cek_child)->result_array();
		$count_child= count($pro_child);
			//echo $count_child;
			$ilog=0;
			foreach ($pro_child as $pro ) {
				$datalast_log= $this->get_last_log($modul_id,$iupb_id);

				$sql_cek_child_log ='select * 
				from plc2.upb_proses_logs a 
				where a.iupb_id="'.$iupb_id.'"
				and a.master_proses_action_id = "'.$pro['master_proses_action_id'].'" 
				and a.iCount= "'.$datalast_log['iCount'].'" ';
				$log_child = $this->_ci->db->query($sql_cek_child_log)->row_array();

				if (!empty($log_child)) {
					$ilog++;
				}

			}

			//echo $ilog;
			if ($ilog==$count_child) {
				$hasil=1;
			}else{
				$hasil=0;
			}
			//echo $hasil;
			return	$hasil;

	}

	function get_last_act_module($modul_id){
		$sql_last_act_module =
			'select * 
			from plc2.master_proses_action a
			join plc2.master_action b on b.master_action_id=a.master_action_id
			join plc2.master_proses c on c.master_proses_id=a.master_proses_id
			where c.idprivi_modules="'.$modul_id.'"
			and a.lDeleted=0
			and b.lDeleted=0
			and c.lDeleted=0
			order by a.master_proses_action_id DESC limit 1';
		return $this->_ci->db->query($sql_last_act_module)->row_array();

	}

	function get_last_act_id_module($modul_id){
		$sql_last_act_module =
			'select a.master_proses_action_id 
			from plc2.master_proses_action a
			join plc2.master_action b on b.master_action_id=a.master_action_id
			join plc2.master_proses c on c.master_proses_id=a.master_proses_id
			where c.idprivi_modules="'.$modul_id.'"
			and a.lDeleted=0
			and b.lDeleted=0
			and c.lDeleted=0
			order by a.master_proses_action_id DESC limit 1';
		return $this->_ci->db->query($sql_last_act_module)->row_array();

	}

	function get_last_log($modul_id,$iupb_id){
		$sql_last_log_proses =
			'select c.master_proses_action_id,d.vAction_name,a.vupb_nomor,a.vupb_nama,f.vNameModule,b.*
			from plc2.plc2_upb a 
			join plc2.upb_proses_logs b on b.iupb_id=a.iupb_id
			join plc2.master_proses_action c on c.master_proses_action_id=b.master_proses_action_id
			join plc2.master_action d on d.master_action_id=c.master_action_id
			join plc2.master_proses e on e.master_proses_id=c.master_proses_id
			join erp_privi.privi_modules f on f.idprivi_modules=e.idprivi_modules
			where a.iupb_id="'.$iupb_id.'"
			and f.idprivi_modules="'.$modul_id.'"
			and a.ldeleted=0
			and b.lDeleted=0
			order by b.iupb_proses_logs DESC limit 1';
		return $this->_ci->db->query($sql_last_log_proses)->row_array();

	}

	function get_last_log_with_key($modul_id,$iupb_id,$act_pro){
		$sql_last_log_proses =
			'select c.master_proses_action_id,d.vAction_name,a.vupb_nomor,a.vupb_nama,f.vNameModule,d.master_action_id,b.*
			from plc2.plc2_upb a 
			join plc2.upb_proses_logs b on b.iupb_id=a.iupb_id
			join plc2.master_proses_action c on c.master_proses_action_id=b.master_proses_action_id
			join plc2.master_action d on d.master_action_id=c.master_action_id
			join plc2.master_proses e on e.master_proses_id=c.master_proses_id
			join erp_privi.privi_modules f on f.idprivi_modules=e.idprivi_modules
			where a.iupb_id="'.$iupb_id.'"
			and f.idprivi_modules="'.$modul_id.'"
			and c.master_proses_action_id="'.$act_pro.'"
			and a.ldeleted=0
			and b.lDeleted=0
			order by b.iupb_proses_logs DESC limit 1';
		return $this->_ci->db->query($sql_last_log_proses)->row_array();

	}	

	
	function check_modul_upb_daftar($modul_id,$iupb_id){
		return 1;
	}

	function check_modul_plc_upb_setting_prioritas_prareg($modul_id,$iupb_id){
		//return 1;
	}


	function check_modul_plc_upb_request_originator($modul_id,$iupb_id){
		$dupb=$this->get_upb($iupb_id);				
		if ($dupb['vkat_originator'] !=3) {
			$return= 1;
		}else{
			$return= 0;
		}
		
		return $return;

	}

	function check_modul_plc_upb_input_sample_originator($modul_id,$iupb_id){
		$sreq='select * from plc2.plc2_upb_request_originator a where a.iupb_id = "'.$iupb_id.'" and a.isent_status is null order by a.ireq_ori_id DESC limit 1';
		$dreq = $this->_ci->db->query($sreq)->row_array();
		if (!empty($dreq)) {
			// jika request originator sudah dibuat maka modul ini wajib dilalui
			$return = '-1';
		}else{ 
			// jika request originator tidak dibuat maka modul ini tidak wajib dilalui
			$return= 1;
		}
		//echo $return;
		return $return;
	}

	function check_modul_plc_bahan_kemas($modul_id,$iupb_id){
		return 1;
	}

	function check_modul_plc_study_literatur_pd($modul_id,$iupb_id){
		return 1;
	}
	
}
