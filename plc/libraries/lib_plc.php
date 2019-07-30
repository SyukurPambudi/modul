<?php
class lib_plc { 	
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
		$this->logged_nip = $this->sess_auth->gNIP;
		
		//$this->updetIformula();
    }
    function user() {
		return $this->sess_auth;
	}
	

	/*-------------------------------------------------  auth    					start-------------------------------------------------------*/

	

	/*-------------------------------------------------  auth       				end --------------------------------------------------------*/

	/*get activity  modul*/
	
	function get_module_activities($modul_id){
		$sql = '
				select * 
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= 	"'.$modul_id.'"
				';
		$datas = $this->_ci->db->query($sql)->result_array();
		
		return $datas;
	}

	function get_module_activities_last($modul_id){

		$sql = '
				select * 
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"
				order by b.iSort DESC
				limit 1
				';
		//echo $sql;
		$data = $this->_ci->db->query($sql)->row_array();
		
		return $data;

	}

	function get_last_module_activity($modul_id,$iKey_id){
		$sql ='sELECT IFNULL( (	select   b1.iSort
								from plc3.m_modul_log_activity a1 
								join plc3.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join plc3.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
								where a1.idprivi_modules="'.$modul_id.'"  and a1.iKey_id="'.$iKey_id.'"
								and a1.lDeleted=0
								and b1.lDeleted=0
								and c1.lDeleted=0
								order by b1.iSort DESC limit 1) ,0) as last_sort ';
		$data = $this->_ci->db->query($sql)->row_array();
		
		return $data;
	}

	function get_current_module_activities($modul_id,$iKey_id){
		$sql = '
				select * 
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"

				and b.iSort > (
							SELECT IFNULL( (	select   b1.iSort
								from plc3.m_modul_log_activity a1 
								join plc3.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join plc3.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
								where a1.idprivi_modules="'.$modul_id.'"  and a1.iKey_id="'.$iKey_id.'"
								and a1.lDeleted=0
								and b1.lDeleted=0
								and c1.lDeleted=0
								order by b1.iSort DESC limit 1) ,0) as last_sort
				)
				limit 1

				';
				/* echo '<pre>'.$sql; */
		$datas = $this->_ci->db->query($sql)->result_array();
		
		return $datas;
	}

	function updetIformula(){
		$sql='SELECT 
				plc2_upb.iupb_id,formula_process.iFormula_process ,formula_stabilita.vNo_formula AS formula_stabilita_vNo_formula
				FROM (`pddetail`.`formula_process`)
				INNER JOIN `pddetail`.`formula_process_detail` ON `formula_process_detail`.`iFormula_process` = `formula_process`.`iFormula_process`
				INNER JOIN `pddetail`.`formula_stabilita` ON `formula_stabilita`.`iFormula_process` = `formula_process`.`iFormula_process`
				INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id` = `formula_process`.`iupb_id`
				WHERE `formula_process_detail`.`lDeleted` = "0" 
				AND `formula_stabilita`.`lDeleted` = "0" 
				AND `formula_process`.`lDeleted` = "0" 
				GROUP BY plc2_upb.iupb_id, formula_stabilita.iVersi
				order by plc2_upb.iupb_id, formula_stabilita.iVersi 
		';		
		/* echo '<pre>'.$sql;
		exit; */
		$datas = $this->_ci->db->query($sql)->result_array();

		foreach ($datas as $data) {
			/* update ditabel formula untuk get last iFormula_process pada pddetail, karena yang dipakai adalah formula terakhir */
			$data_ss=array('iFormula_process'=>$data['iFormula_process']);
			$this->_ci->db-> where('iupb_id', $data['iupb_id']);
			$this->_ci->db->update('plc2.plc2_upb_formula', $data_ss);


		}



	}

	function getLastactivity($modul_id,$iKey_id){

		
		$iFinish = 0;
		$activity_last_mapping = $this->get_module_activities_last($modul_id);
		$last_mapping = $activity_last_mapping['iSort'];

		$last_module_activity = $this->get_last_module_activity($modul_id,$iKey_id);
		$last_sort = $last_module_activity['last_sort'];

		
		if( $last_sort == $last_mapping){
			$iFinish = 1;
		}

		return $iFinish;

	}

	function getCurrent_modul($iupb_id){
		$sql = 'select c.vNama_modul,d.iUrut
				from plc3.m_modul_log_upb a 
				join plc3.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
				join plc3.m_modul c on c.idprivi_modules=b.idprivi_modules 
				join plc3.m_flow_proses d on d.iM_modul=c.iM_modul and d.iM_flow=1
				where a.lDeleted=0 and  a.iupb_id = "'.$iupb_id.'" 
				order by d.iUrut DESC
				limit 1';

		$dMod = $this->_ci->db->query($sql)->row_array();

		if(empty($dMod)){
			$data['vNama_modul'] = 'Log Modul tidak ditemukan';
			$data['iUrut'] = 0;
		}else{
			$data['vNama_modul'] = $dMod['vNama_modul'];
			$data['iUrut'] = $dMod['iUrut'];
		}

		/*print_r($data);*/
		return $data;
	}

	function getOpenEditing($modul_id,$iKey_id){

		
		$iOpen = 0;

		$sql = '
				select * 
				from plc3.m_modul a 
				join plc3.t_modul_open b on b.idprivi_modules=a.idprivi_modules
				where a.lDeleted=0
				and b.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"
				and b.iKey_id = "'.$iKey_id.'"
				and b.iActive = 1
				';
		
		$data = $this->_ci->db->query($sql)->row_array();
		
		if(!empty($data)){
			$iOpen = 1;	
		}


		return $iOpen;

	}

	function getLastStatusApprove($modul_id,$iKey_id){
		$sql='select a.iApprove 
			from plc3.m_modul_log_activity a 
			where a.lDeleted=0 
			and a.iKey_id = "'.$iKey_id.'"
			and a.idprivi_modules= "'.$modul_id.'"
			and a.iM_activity <> 1
			order by a.iSort DESC
			limit 1
			';

		$data = $this->_ci->db->query($sql)->row_array();
		$iBoleh = false;

		if(!empty($data)){
			if($data['iApprove']==2){
				$iBoleh = true;	
			}else{
				$iBoleh = false;	
			}
			
		}else{
			$iBoleh = true;	
		}


		return $iBoleh;

	}

	function getIDActivityAndSort($iM_modul_activity){
		$sql = 'select * from plc3.m_modul_activity a where a.iM_modul_activity = "'.$iM_modul_activity.'" 		';
		$dAct = $this->_ci->db->query($sql)->row_array();

		if(empty($dMod)){
			$data = $dAct;
		}else{
			$data = array();
		}

		/*print_r($data);*/
		return $data;



	}

	function MigrasiInsertActivityModule($iupb_ids,$modul_id,$iKey_id,$iM_activity,$iSort,$vRemark='',$iApprove=0,$dapp,$capp){
		$isTrue = 0;
		$data=array();
		$data['iKey_id'] =$iKey_id;
		$data['idprivi_modules'] = $modul_id;
		$data['iM_activity'] = $iM_activity;
		$data['iSort'] = $iSort;

		$data['vRemark'] = $vRemark;
		$data['iApprove'] = $iApprove;
		$data['dCreate'] = $dapp;
		$data['cCreated'] = $capp;
		

		/* check sudah ada belum , jika sudah / jangan masukin */
			$cekLog = 'SELECT * 
						FROM plc3.m_modul_log_activity a 
						WHERE a.iKey_id= "'.$iKey_id.'" 
						and a.idprivi_modules= "'.$modul_id.'" 
						and a.iM_activity= "'.$iM_activity.'" 
						and a.iSort= "'.$iSort.'" 
						';
						/* echo '<pre>'.$cekLog; 
						exit; */           
			$dCekLog = $this->_ci->db->query($cekLog)->result_array();
			if(!empty($dCekLog)){ 
				//echo 'masuk sini';
				$isTrue = 1;
			}else{
				/* hanya yang belum dimigrasikan saja */
				$ins = $this->_ci->db-> insert('plc3.m_modul_log_activity', $data);	
				$insertID =$this->_ci->db->insert_id();

				if($ins){
					

					foreach ($iupb_ids as $key => $value) {
						$data2['iM_modul_log_activity'] = $insertID;
						$data2['iupb_id'] = $value;
						$data2['dCreate'] = $dapp;
						$data2['cCreated'] = $capp;
						$ins2 = $this->_ci->db-> insert('plc3.m_modul_log_upb', $data2);	

					}

					$isTrue = 1;
				}

			}

		
		

		
		return $isTrue;

	}

	function InsertActivityModule($iupb_ids,$modul_id,$iKey_id,$iM_activity,$iSort,$vRemark='',$iApprove=0){
		$isTrue = 0;
		$data=array();
		$data['iKey_id'] =$iKey_id;
		$data['idprivi_modules'] = $modul_id;
		$data['iM_activity'] = $iM_activity;
		$data['iSort'] = $iSort;

		$data['vRemark'] = $vRemark;
		$data['iApprove'] = $iApprove;
		

		$data['dCreate'] = date('Y-m-d H:i:s');
		$data['cCreated'] = $this->logged_nip;
		$ins = $this->_ci->db-> insert('plc3.m_modul_log_activity', $data);	
		$insertID =$this->_ci->db->insert_id();

		//echo $insertID;
		//print_r($iupb_ids);


		

		if($ins){
			
			



			
			$iupb_id = 0;
			foreach ($iupb_ids as $key => $value) {
				$data2['iM_modul_log_activity'] = $insertID;
				$data2['iupb_id'] = $value;
				$data2['dCreate'] = date('Y-m-d H:i:s');
				$data2['cCreated'] = $this->logged_nip;
				$ins2 = $this->_ci->db-> insert('plc3.m_modul_log_upb', $data2);	

				$insertID2 = $this->_ci->db->insert_id();

				$iupb_id = $value;

				/* tutup imutu */	
				$sqlCekMutu = 'select * from plc2.log_mutu a where a.iupb_id="'.$iupb_id.'" and a.idprivi_modules="'.$modul_id.'" and a.iDone=0';
				$dMutu = $this->_ci->db->query($sqlCekMutu)->row_array();
				
				if(!empty($dMutu)){
					$aidi = $dMutu['ilog_mutu'];
					$sql = "UPDATE plc2.log_mutu SET iDone = 1 WHERE ilog_mutu=$aidi LIMIT 1";
					$query = $this->_ci->db->query( $sql );
				}

			/* tutup imutu */

				

			}

			/*send mail */
				$tambahan = '';
				$getBecece = 'select * 
							from plc2.plc_sysparam a 
							where a.cVariable="BCC" ';
				$sqlBecece = $this->_ci->db->query($getBecece)->row_array();

				$dBcc = $sqlBecece['vContent'];

				$sqlSetupNotif="
											select  
												a.*,e.*,f.*,g.*,h.*
												from plc3.m_modul_log_activity a
												join plc3.m_modul e on e.idprivi_modules=a.idprivi_modules
												join plc3.m_notif h on h.iM_notif=e.iM_notif
												join plc3.m_activity f on f.iM_activity=a.iM_activity
												join plc3.m_modul_activity g on g.iM_modul=e.iM_modul and g.iM_activity=a.iM_activity and g.iSort=a.iSort
												where a.lDeleted=0
												and e.lDeleted=0
												and h.lDeleted=0
												and f.lDeleted=0
												and g.lDeleted=0
												and a.iM_modul_log_activity=  ".$insertID."
				";


				 //echo '<pre>'.$sqlSetupNotif;
				// exit;
				$dSetupNotif = $this->_ci->db->query($sqlSetupNotif)->row_array();

				if(!empty($dSetupNotif)){
					//echo '<pre> atas';

				
					$dSqlCC = $dSetupNotif['vNotif_sql_cc'];
					$dSqlTo = $dSetupNotif['vNotif_sql_to'];

					$sql_vNotif_sql = $dSetupNotif['vSql_notif'];
					$contentNotif = '';
					$to = '0';
					$cc = '0';

					

					if($dSetupNotif['iTipe_notif'] == 2){
						// jika reference by UPB disettingan notif
						
						
						$sql_get_upb_team = 'select  									
													ifnull(d1.iteam_id,0) as iTimBD
													,ifnull(d2.iteam_id,0) as iTimPD
													,ifnull(d3.iteam_id,0) as iTimQA
													,ifnull(d4.iteam_id,0) as iTimAD
													,ifnull(d5.iteam_id,0) as iTimQC
													,ifnull(d6.iteam_id,0) as iTimMKT

													,ifnull(d1.vteam,"-") as vTimBD
													,ifnull(d2.vteam,"-") as vTimPD
													,ifnull(d3.vteam,"-") as vTimQA
													,ifnull(d4.vteam,"-") as vTimAD
													,ifnull(d5.vteam,"-") as vTimQC
													,ifnull(d6.vteam,"-") as vTimMKT


													,c.*
													from 
													plc2.plc2_upb c
													left join plc2.plc2_upb_team d1 on d1.iteam_id=c.iteambusdev_id
													left join plc2.plc2_upb_team d2 on d2.iteam_id=c.iteampd_id
													left join plc2.plc2_upb_team d3 on d3.iteam_id=c.iteamqa_id
													left join plc2.plc2_upb_team d4 on d4.iteam_id=c.iteamad_id
													left join plc2.plc2_upb_team d5 on d5.iteam_id=c.iteamqc_id
													left join plc2.plc2_upb_team d6 on d6.iteam_id=c.iteammarketing_id
													where c.iupb_id= "'.$iupb_id.'"
						';
						/* echo '<pre>'.$sql_get_upb_team;
						echo'<br>';
						echo 'test1';
						echo'<br>'; */
						$dUpebeh_tim = $this->_ci->db->query($sql_get_upb_team)->row_array();

						/* echo 'test';
						echo'<br>'; */

						$iTimBD = 	$dUpebeh_tim['iTimBD'];
						$iTimPD = 	$dUpebeh_tim['iTimPD'];
						$iTimQA = 	$dUpebeh_tim['iTimQA'];
						$iTimAD = 	$dUpebeh_tim['iTimAD'];
						$iTimQC = 	$dUpebeh_tim['iTimQC'];
						$iTimMKT = 	$dUpebeh_tim['iTimMKT'];


						$vTimBD = 	$dUpebeh_tim['vTimBD'];
						$vTimPD = 	$dUpebeh_tim['vTimPD'];
						$vTimQA = 	$dUpebeh_tim['vTimQA'];
						$vTimAD = 	$dUpebeh_tim['vTimAD'];
						$vTimQC = 	$dUpebeh_tim['vTimQC'];
						$vTimMKT = 	$dUpebeh_tim['vTimMKT'];


						$vNo_upb 			=		$dUpebeh_tim['vupb_nomor'];
						$vNama_usulan = 	$dUpebeh_tim['vupb_nama'];
						$vTanggal_upb = 	$dUpebeh_tim['ttanggal'];

						

						if($dSqlTo <> "" and $dSqlTo <> "-" ){

							#$tambahan .=' and plc2_upb.iupb_id in ('.$value.') ';
							$tambahan .=' and plc2_upb_team.iteam_id in ('.$iTimBD.','.$iTimPD.','.$iTimQA.','.$iTimAD.','.$iTimQC.','.$iTimMKT.') ';
							$dSqlTo = str_replace('$tambahan$', $tambahan, $dSqlTo);
						}

						if($dSqlCC <> "" and $dSqlCC <> "-" ){
							#$tambahan .=' and plc2_upb.iupb_id in ('.$value.') ';
							$tambahan .=' and plc2_upb_team.iteam_id in ('.$iTimBD.','.$iTimPD.','.$iTimQA.','.$iTimAD.','.$iTimQC.','.$iTimMKT.') ';
							$dSqlCC = str_replace('$tambahan$', $tambahan, $dSqlCC);

						}

						$sql_vNotif_sql = str_replace('$peka$', $iupb_id, $sql_vNotif_sql);

						/* echo $sql_vNotif_sql;
						echo'<br>'; */
						
						$contentNotif = $dSetupNotif['vContent_notif'];

						$contentNotif = str_replace('$vNo_upb$', $vNo_upb, $contentNotif);
						$contentNotif = str_replace('$vNama_usulan$', $vNama_usulan, $contentNotif);
						$contentNotif = str_replace('$vTanggal_upb$', $vTanggal_upb, $contentNotif);

						$contentNotif = str_replace('$vTimBD$', $vTimBD, $contentNotif);
						$contentNotif = str_replace('$vTimPD$', $vTimPD, $contentNotif);
						$contentNotif = str_replace('$vTimQA$', $vTimQA, $contentNotif);
						$contentNotif = str_replace('$vTimAD$', $vTimAD, $contentNotif);
						$contentNotif = str_replace('$vTimQC$', $vTimQC, $contentNotif);
						$contentNotif = str_replace('$vTimMKT$', $vTimMKT, $contentNotif);


					}else{


						if($dSqlTo <> "" and $dSqlTo <> "-"){

							$dSqlTo = str_replace('$tambahan$', "", $dSqlTo);
							

						}

						if($dSqlCC <> "" and $dSqlCC <> "-"){

							$dSqlCC = str_replace('$tambahan$', "", $dSqlCC);
							
						}

						$sql_vNotif_sql = $dSetupNotif['vSql_notif_custom'];


						$sql_vNotif_sql = str_replace('$peka$', $iKey_id, $sql_vNotif_sql);

						$contentNotif = $dSetupNotif['vContent_notif_custom'];

					}

					
						if($dSqlTo <> "" and $dSqlTo <> "-"){
							$dArrTo = $this->_ci->db->query($dSqlTo)->result_array();
							if(!empty($dArrTo)){
								foreach ($dArrTo as $item) {
								$to .=','.$item['cNip'];
								}
							}

							

						}
						/* echo 'satu';
						echo'<br>'; */
						

						if($dSqlCC <> "" and $dSqlCC <> "-"){
							$dArrCC = $this->_ci->db->query($dSqlCC)->result_array();

							if(!empty($dArrCC)){
								foreach ($dArrCC as $item) {
								$cc .=','.$item['cNip'];
								}
							}
						}
						/* echo 'satu';
						echo'<br>'; */

					


					/* echo $contentNotif;
					echo $dSetupNotif['vNotif_content'];
					exit; */

					$cc .= ','.$dBcc.','.$this->logged_nip;
					
					if($sql_vNotif_sql <> ""){
						/* echo 'sampai sini'; */
						$dContentData = $this->_ci->db->query($sql_vNotif_sql)->row_array();

						if(!empty($dContentData)){
							$subject = 'PLC - '.$dSetupNotif['vNama_activity'].' '.$dSetupNotif['vNama_modul'].' '.$dContentData['onSubject'];
							$content ="
											Diberitahukan bahwa telah ada activity ".$dSetupNotif['vNama_activity']." pada modul ".$dSetupNotif['vNama_modul']."  .
											<br><br>";

								$content .= $contentNotif;
							
								$content .= '<br>';
								$content .= '<br>';
							
								$content .= $dSetupNotif['vNotif_info'];

							$content .="                            

								<br/> <br/>

								Demikian, mohon segera follow up  pada aplikasi ERP PLC. Terimakasih.<br><br><br>
								Post Master"; 

							$this->_ci->sess_auth->send_message_erp($this->_ci->uri->segment_array(),$to, $cc, $subject, $content);

						}

					}
					
				}else{
				//	echo '<pre> bawah';
				}
				

				







			/*send mail */



			$isTrue = 1;


		}
		

		
		return $isTrue;

	}

	function hasTeam($nip){
		$teams = '';
		$sql = "select t.cDeptId
				from plc2.plc2_upb_team t
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=1

				union 

				select t1.cDeptId 
				from plc2.plc2_upb_team_item ti 
				join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
				where ti.ldeleted=0
				and t1.iTipe=1
				and ti.vnip='".$nip."'
				  ";
		
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$teams = $data['cDeptId'];
				}else{
					$teams .= ','.$data['cDeptId'];
				}
				$i++;
			}

		}

		return $teams;
	}

	function hasTeamID($nip){
		$teams = '';
		$sql = "select t.iteam_id
				from plc2.plc2_upb_team t
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=1

				union 

				select t1.iteam_id 
				from plc2.plc2_upb_team_item ti 
				join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
				where ti.ldeleted=0
				and t1.iTipe=1
				and ti.vnip='".$nip."'
				  ";
		/*echo $sql;*/
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$teams = $data['iteam_id'];
				}else{
					$teams .= ','.$data['iteam_id'];
				}
				$i++;
			}

		}

		return $teams;
	}

	function getNamaTeamUPB($iupb_id){
		$sql = 'select 
				*
				,ifnull(b.vteam,"-") as nmPD
				,ifnull(c.vteam,"-") as nmBD
				,ifnull(d.vteam,"-") as nmMKT
				,ifnull(e.vteam,"-") as nmQA
				,ifnull(f.vteam,"-") as nmAD

				
				from plc2.plc2_upb a 
				left join plc2.plc2_upb_team b on b.iteam_id=a.iteampd_id
				left join plc2.plc2_upb_team c on c.iteam_id=a.iteambusdev_id
				left join plc2.plc2_upb_team d on d.iteam_id=a.iteammarketing_id
				left join plc2.plc2_upb_team e on e.iteam_id=a.iteamqa_id 
				left join plc2.plc2_upb_team f on f.iteam_id=a.iteamad_id
				where a.ldeleted=0 
				and a.iupb_id="'.$iupb_id.'"';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;

	}

	function managerAndChief($iteam_id){
		$nips = '';
		$sql = 'select t.vnip
					from plc2.plc2_upb_team t
					where t.ldeleted=0
					and t.iteam_id = "'.$iteam_id.'"
					and t.iTipe=1

					union 

					select t1.vnip
					from plc2.plc2_upb_team_item ti 
					join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
					where ti.ldeleted=0
					and ti.iapprove=1
					and t1.iTipe=1
					and t1.iteam_id = "'.$iteam_id.'"
				';

				/*echo $sql;
				exit;*/
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$nips = $data['vnip'];
				}else{
					$nips .= ','.$data['vnip'];
				}
				$i++;
			}

		}

		return $nips;

	}

	function managerAndChiefIn($iteam_id){
		$nips = '';
		$sql = 'select t.vnip
					from plc2.plc2_upb_team t
					where t.ldeleted=0
					and t.iteam_id in ('.$iteam_id.')
					and t.iTipe=1

					union 

					select t1.vnip
					from plc2.plc2_upb_team_item ti 
					join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
					where ti.ldeleted=0
					and ti.iapprove=1
					and t1.iTipe=1
					and t1.iteam_id in ('.$iteam_id.')
				';

				/*echo $sql;
				exit;*/
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$nips = $data['vnip'];
				}else{
					$nips .= ','.$data['vnip'];
				}
				$i++;
			}

		}

		return $nips;

	}

	function upbTeam($iupb_id){
		$sql = 'select 
				ifnull(a.iteambusdev_id,0) as BD
				, ifnull(a.iteampd_id,0) as PD
				, ifnull(a.iteamqa_id,0) as QA
				, ifnull(a.iteamad_id,0) as AD
				,ifnull(a.iteammarketing_id,0) as MR
				,20 as DR
		from plc2.plc2_upb a 
		where a.ldeleted=0 
		and a.iupb_id= "'.$iupb_id.'"';

		//echo $sql;
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows = array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;

	}

	function getAuthorModul($modul_id){		

		$sql = 'select * 
				from plc3.m_modul a 
				where a.lDeleted=0 
				and a.idprivi_modules="'.$modul_id.'"

				';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows=array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;
	}

	function getIModulID($modul_id){

		$sql = 'select *
				from plc3.m_modul a 
				where a.lDeleted=0 
				and a.idprivi_modules="'.$modul_id.'"

				';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows=array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}
		$return=isset($rows['iM_modul'])?$rows['iM_modul']:'';
		return $return;

	}

	function getHistoryActivityUPB($modul_id,$iupb_id){
	    $sql = '
	            select b.vNama_activity,a.dCreate,c.vName,a.vRemark
	            ,if(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) as setatus
	            from plc3.m_modul_log_activity a 
				join plc3.m_activity b on b.iM_activity=a.iM_activity
				join plc3.m_modul_log_upb c on c.iM_modul_log_activity=a.iM_modul_log_activity 
	            join hrd.employee c on c.cNip=a.cCreated
	            where 
	            a.lDeleted=0
	            and a.idprivi_modules ="'.$modul_id.'"
	            and c.iupb_id ="'.$iupb_id.'"

	    ';

	    $query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		
		$html = '';

		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vRemark'].'</span>
                        </td>
                    </tr>';


				$i++;
			}
		}else{
			$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">No Data</span>
                        </td>
                    </tr>';


		}

		return $html;

	}

	function getHistoryActivity($modul_id,$iKey_id){
	    $sql = '
	            select b.vNama_activity,a.dCreate,c.vName,a.vRemark
	            ,if(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) as setatus
	            from plc3.m_modul_log_activity a 
	            join plc3.m_activity b on b.iM_activity=a.iM_activity
	            join hrd.employee c on c.cNip=a.cCreated
	            where 
	            a.lDeleted=0
	            and a.idprivi_modules ="'.$modul_id.'"
	            and a.iKey_id ="'.$iKey_id.'"

	    ';

	    $query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		
		$html = '';

		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vRemark'].'</span>
                        </td>
                    </tr>';


				$i++;
			}
		}else{
			$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">No Data</span>
                        </td>
                    </tr>';


		}

		return $html;

	}

	function isAdmin($isNiP=0){
		$this->_ci->db->like('vContent',$isNiP);
		$this->_ci->db->where('cVariable','ADMINPLCACCESS');
		$query = $this->_ci->db->get('plc2.plc_sysparam');
		$ret=false;
		if($query->num_rows()>0){
			$ret=true;
		}
		return $ret;
	}

	function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->_ci->db->query($sql)->row_array();
        return $data;
    }
    


	function getUploadFileFromField($iModul_id){
		$where=array(
				"m_modul_fileds.iM_jenis_field"=>16
				,"m_modul.idprivi_modules"=>$iModul_id
			);
		$this->_ci->db->select("*")
						->from("plc3.m_modul_fileds")
						->join("plc3.m_modul","m_modul.iM_modul=m_modul_fileds.iM_modul")
						->join("plc2.sys_masterdok","sys_masterdok.iM_modul_fileds=m_modul_fileds.iM_modul_fileds")
						->where($where);
		$q=$this->_ci->db->get();
		$row=array();
		if($q->num_rows()>=1){
			$row=$q->result_array();
		}
		return $row;
	}

	function getUpbId($keyi,$id){
		$iupb_id="0";
		$sql="dasdas";
		switch ($keyi) {
			case 'ifor_id':
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_formula")
					->where("ifor_id",$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case 'ibuatmbr_id':
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_buat_mbr")
					->join("plc2.plc2_upb_formula","plc2_upb_formula.ifor_id=plc2_upb_buat_mbr.ifor_id")
					->where($keyi,$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "imikro_fg_id":
				$this->_ci->db->select("*")
					->from("plc2.mikro_fg")
					->join("plc2.plc2_upb_formula","plc2_upb_formula.ifor_id=mikro_fg.ifor_id")
					->where("imikro_fg_id",$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "irodet_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_ro_detail")
					->join("plc2.plc2_upb_request_sample","plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id")
					->where("irodet_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "isoi_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_soi_fg")
					->where("isoi_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "ivalmoa_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_vamoa")
					->where("ivalmoa_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			default:
				$iupb_id=$id;
				break;
		}
		return $iupb_id;
	}

	function generateFilename ($filename, $urut=0){
		$exDot = explode('.', $filename);
		$ext = $exDot[count($exDot)-1];
		$generated = str_replace(' ', '_', $filename);
		$generated = str_replace('.'.$ext, '', $generated);
		$generated = preg_replace('/[^A-Za-z0-9\-]/', '_', $generated);
		$dateNow = date('Y_m_d__H_i_s');
		$nameGenerated = $urut.'__'.$dateNow.'__'.$generated.'.'.$ext;
		return $nameGenerated;
	}

	function getUpbLog($iM_modul,$ijenis=0){
		$ii=000;
		$qReqModul=$this->getRequirmentModule($iM_modul);
		$sqlAnd='';
		if($qReqModul->num_rows()>0){
			foreach ($qReqModul->result_array() as $kreq => $vreq) {
				$iM_modul_activity=$vreq["iM_modul_activity"];
				$arraywhere=array('m_modul_activity.lDeleted'=>0
								,'m_modul.lDeleted'=>0
								,'m_modul_activity.iM_modul_activity'=>$iM_modul_activity);
				$arrid=array(1,3,4);
				/* $this->_ci->db->select('*')
						->from('plc3.m_modul_log_activity')
						->join('plc3.m_modul','m_modul.idprivi_modules=m_modul_log_activity.idprivi_modules')
						->join('plc3.m_modul_activity','m_modul_activity.iM_modul=m_modul.iM_modul')
						->where($arraywhere)
						->where_in($arrid)
						->where("(CASE 
							WHEN m_modul_activity.iM_activity=1
							THEN m_modul_log_activity.iApprove=1
							ELSE m_modul_log_activity.iApprove=2
							END)",NULL,TRUE); */
				$qq="SELECT m_modul_log_activity.*,m_modul.* FROM (`plc3`.`m_modul_log_activity`) 
						JOIN `plc3`.`m_modul` ON `m_modul`.`idprivi_modules`=`m_modul_log_activity`.`idprivi_modules` 
						JOIN `plc3`.`m_modul_activity` ON `m_modul_activity`.`iM_modul`=`m_modul`.`iM_modul` AND m_modul_activity.iM_activity=m_modul_log_activity.iM_activity
						WHERE `m_modul_activity`.`lDeleted` = 0 AND `m_modul`.`lDeleted` = 0 
						AND `m_modul_activity`.`iM_modul_activity` = '".$iM_modul_activity."'
						AND m_modul_activity.iM_activity IN (1,3,4)
						AND CASE WHEN m_modul_activity.iM_activity=1
						THEN m_modul_log_activity.iApprove=1
						ELSE m_modul_log_activity.iApprove=2
						END";
				$quee=$this->_ci->db->query($qq);
				
				if($quee->num_rows()>0){
					$sqlAndTambah=array();
					foreach ($quee->result_array() as $kk => $vv) {
						$sqlAndTambah[$vv["vTable_name"].".".$vv["vFieldPK"]][]=$vv["iKey_id"];
					}
					if(count($sqlAndTambah)>0){
						foreach ($sqlAndTambah as $kk => $vv) {
							$ini=implode(",",$vv);
							if($ijenis==0){
								$sqlAnd.=" AND ".$kk." IN (".$ini.")";
							}else{
								$sqlAnd.=$kk." IN (".$ini.")~~~";
							}
						}
					}
				}
			}
		}
		return $sqlAnd;
	}
	
	function getRequirmentModule($iM_modul){
		$arraywhere=array('m_modul_requirement.lDeleted'=>0,'isMainGrid'=>0,'m_modul_requirement.iM_modul'=>$iM_modul);
		$this->_ci->db->select('*')
						->from('plc3.m_modul_requirement')
					/* 	->join('plc3.m_modul','m_modul.iM_modul=m_modul_requirement.iM_modul')
						->join('plc3.m_modul_activity','m_modul_activity.iM_modul_activity=m_modul_requirement.iM_modul_activity') */
						->where($arraywhere);
		$quee=$this->_ci->db->get();
		/* print_r($this->_ci->db->last_query());exit(); */
		return $quee;
		// return $this->_ci->db->last_query();
	}
	
	/* Get Modul Data */
	function getDataModul($iM_modul){
		$this->_ci->db->select('*')
						->from('plc3.m_modul')
						->where('iM_modul',$iM_modul);
		$data=$this->_ci->db->get()->row_array();
		return $data;
	}
	/*  */

	/*get activity  modul*/
	function gridFilterUPBbyTeam($grid, $modul_id){
		$nip = $this->user()->gNIP; 
		$isAdmin = $this->isAdmin($nip);
		if (!$isAdmin){
			$arrTeam = explode(',',$this->hasTeam($nip));
            $AuthModul = $this->getAuthorModul($modul_id);
            $nipAuthor = explode(',', $AuthModul['vNip_author']);
            $nipParticipant = explode(',', $AuthModul['vNip_author']);
            $teamID = $this->hasTeamID($nip);

            if(in_array('PD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteampd_id in ('.$teamID.')', NULL);                        
            }else if(in_array('AD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteamad_id in ('.$teamID.')', NULL);                        
            }else if(in_array('QA', $arrTeam)){
                $grid->setQuery('plc2_upb.iteamqa_id in ('.$teamID.')', NULL);                        
            }else if(in_array('BD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteambusdev_id in ('.$teamID.')', NULL);                        
            }else if( in_array($nip, $nipAuthor )|| in_array($nip, $nipParticipant)  ){

            }
		}

	}

	function queryFilterUPBbyTeam($modul_id, $tableAlias = 'plc2_upb'){
		$nip = $this->user()->gNIP; 
		$isAdmin = $this->isAdmin($nip);
		$filter = '';
        if(!$isAdmin){
			$arrTeam = explode(',',$this->hasTeam($nip));
            $AuthModul = $this->getAuthorModul($modul_id);
            $nipAuthor = explode(',', $AuthModul['vNip_author']);
            $nipParticipant = explode(',', $AuthModul['vNip_author']);
            $teamID = $this->hasTeamID($nip);

            if(in_array('PD', $arrTeam)){     
                $filter = ' AND '.$tableAlias.'.iteampd_id IN ('.$teamID.')';        
            }else if(in_array('AD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamad_id IN ('.$teamID.')';                        
            }else if(in_array('QA', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamqa_id IN ('.$teamID.')';                        
            }else if(in_array('BD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteambusdev_id IN ('.$teamID.')';                         
            }else if( in_array($nip, $nipAuthor )|| in_array($nip, $nipParticipant)  ){

            }
        }  
        return $filter;
	}

	/*  */

	/*get activity  modul*/
	
	function getDataFilterMainGrid($iM_modul){
		$return=array();
		$sql=$this->getUpbLog($iM_modul,1);
		if(strlen($sql)>0){
			$return = explode('~~~',trim($sql));
		}
		$where =array('lDeleted'=>0,'iM_modul'=>$iM_modul,'isMainGrid'=>1);
		$this->_ci->db->select('*')
						->from('plc3.m_modul_requirement')
						->where($where);
		$data=$this->_ci->db->get()->result_array();
		foreach ($data as $kd => $vv) {
			if($vv['tSource_Optional']!=""){
				$iM_modul_activity=$vv["iM_modul_activity"];
				$qq="SELECT m_modul_log_activity.*,m_modul.* FROM (`plc3`.`m_modul_log_activity`) 
						JOIN `plc3`.`m_modul` ON `m_modul`.`idprivi_modules`=`m_modul_log_activity`.`idprivi_modules` 
						JOIN `plc3`.`m_modul_activity` ON `m_modul_activity`.`iM_modul`=`m_modul`.`iM_modul` AND m_modul_activity.iM_activity=m_modul_log_activity.iM_activity
						WHERE `m_modul_activity`.`lDeleted` = 0 AND `m_modul`.`lDeleted` = 0 
						AND `m_modul_activity`.`iM_modul_activity` = '".$iM_modul_activity."'
						AND m_modul_activity.iM_activity IN (1,3,4)
						AND CASE WHEN m_modul_activity.iM_activity=1
						THEN m_modul_log_activity.iApprove=1
						ELSE m_modul_log_activity.iApprove=2
						END";
				$quee=$this->_ci->db->query($qq);
				
				if($quee->num_rows()>0){
					$sqlAndTambah=array();
					foreach ($quee->result_array() as $kk => $vv3) {
						$sqlAndTambah[$vv3["vTable_name"].".".$vv3["vFieldPK"]][]=$vv3["iKey_id"];
					}
					if(count($sqlAndTambah)>0){
						foreach ($sqlAndTambah as $kk1 => $vv1) {
							$ini=implode(",",$vv1);
							$returns=$kk1." IN (".$ini.")";
							$stsourch=str_replace('(?)',$returns,$vv['tSource_Optional']);
							$return[]=$stsourch;
						}
					}
				}else{
					$return[]=$vv['tSource_Optional'];
				}
			}
		}
		$ret=array_filter($return);
		return $ret;
	}


	/* Get Upload File Upload */
	function get_data_prev($urlpath){
		$this->input=$this->_ci->input;
		$this->db_plc0=$this->_ci->load->database('plc0',false, true);
    	$post=$this->input->post();
    	$get=$this->input->get();
    	$nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$ireq=isset($post["iReq"])?$post["iReq"]:"0";
    	$namefield=isset($post["namefield"])?$post["namefield"]:"0";

    	$this->db_plc0->select("*")
    				->from("plc2.sys_masterdok")
    				->where("filename",$namefield);
        $row=$this->db_plc0->get()->row_array();
		
		$where=array('iDeleted'=>0,'idHeader_File'=>$post["id"],'iM_modul_fileds'=>$row['iM_modul_fileds']);
		$this->db_plc0->where($where);
		$q=$this->db_plc0->get('plc2.group_file_upload');
		$rsel=array('vFilename','tKeterangan','iact');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i;
			$z=0;

			$value=$k->vFilename_generate;
			$id=$k->idHeader_File;
			$linknya = 'No File';
			if($value != '') {
				if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
					$link = base_url().'processor/'.$urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
					$linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
				}
			}
			$linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$post["namefield"].'_iFile[]" value="'.$k->iFile.'" />';


			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="iact"){
					$dataar[$dsel]=$linknya;
				}else{
					$dataar[$dsel]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		if($q->num_rows()==0 && $ireq>0){
			$data = new StdClass;
			$data->records=1;
			$dataar[0]="<input type='hidden' class='num_rows_".$nmTable."' value='1' /><input type='file' id='".$grid."_upload_file_1' class='fileupload1 multi multifile required' name='".$grid."_upload_file[]' style='width: 90%' /> *";
			$dataar[1]="<textarea class='' id='".$grid."_fileketerangan_1' name='".$grid."_fileketerangan[]' style='width: 290px; height: 50px;' size='290'></textarea>";
			$dataar[2]="<button id='ihapus_".$nmTable."' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_".$nmTable."(1)' type='button'>Hapus</button>";
			$data->rows[0]['cell']=$dataar;
		}
		return json_encode($data);
    }
	
}
