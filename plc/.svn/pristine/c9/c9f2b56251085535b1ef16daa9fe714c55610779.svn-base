<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_partial_controllers_plc extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('lib_plc');
    }

    function index($action = '') {
    	switch ($action) {
    		case 'getDetailsUPB':
    			$post=$this->input->post();
    			switch ($post['jenis']) {
    				case 'ifor_id':
    					$this->db_plc0->select("plc2_upb.vupb_nomor AS 'Nomor UPB', plc2_upb.vupb_nama AS 'Nama Usulan',  plc2_upb.vgenerik AS 'Nama Generik', 
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteampd_id) as 'Team PD',
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteamqa_id) as 'Team QA',
                            ", FALSE);
    					$this->db_plc0->from('plc2.plc2_upb_formula');
    					$this->db_plc0->join('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2_upb_formula.iupb_id');
    					$this->db_plc0->where('plc2_upb_formula.ifor_id',$post['id']);
    					$this->db_plc0->where('plc2_upb_formula.ldeleted',0);
    					$this->db_plc0->where('plc2_upb.ldeleted',0);
    					$que=$this->db_plc0->get();
    					break;
                    case 'ireq_id':
                        $this->db_plc0->select("plc2_upb.vupb_nomor AS 'Nomor UPB', plc2_upb.vupb_nama AS 'Nama Usulan',  plc2_upb.vgenerik AS 'Nama Generik', 
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteampd_id) as 'Team PD',
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteamqa_id) as 'Team QA',
                            ", FALSE);
                        $this->db_plc0->from('plc2.plc2_upb_request_sample');
                        $this->db_plc0->join('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2_upb_request_sample.iupb_id');
                        $this->db_plc0->where('plc2_upb_request_sample.ireq_id',$post['id']);
                        $this->db_plc0->where('plc2_upb_request_sample.ldeleted',0);
                        $this->db_plc0->where('plc2_upb.ldeleted',0);
						$que=$this->db_plc0->get();
						break;
                    case 'ireqdet_id':
                        $this->db_plc0->select("plc2_upb.vupb_nomor AS 'Nomor UPB', plc2_upb.vupb_nama AS 'Nama Usulan',  plc2_upb.vgenerik AS 'Nama Generik', 
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteampd_id) as 'Team PD',
                            plc2_upb_request_sample.vreq_nomor AS 'Nomor Permintaan', plc2_upb_po.vpo_nomor AS 'Nomor PO', plc2_upb_ro.vro_nomor AS 'Nomor Penerimaan', plc2_upb_ro_detail.ijumlah AS 'Jumlah'
                            ", FALSE);
                        $this->db_plc0->from('plc2.plc2_upb_request_sample_detail');
                        $this->db_plc0->join('plc2.plc2_upb_request_sample','plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id', 'inner');
                        $this->db_plc0->join('plc2.plc2_upb_ro_detail','plc2_upb_ro_detail.ireq_id = plc2_upb_request_sample_detail.ireq_id','left');
                        $this->db_plc0->join('plc2.plc2_upb_po', 'plc2_upb_po.ipo_id = plc2_upb_ro_detail.ipo_id', 'left');
                        $this->db_plc0->join('plc2.plc2_upb_ro', 'plc2_upb_ro.iro_id = plc2_upb_ro_detail.iro_id', 'left');
                        $this->db_plc0->join('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id', 'left');
                        $this->db_plc0->join('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2_upb_request_sample.iupb_id', 'inner');
                        $this->db_plc0->join('plc2.plc2_upb_team', 'plc2_upb_team.iteam_id = plc2_upb.iteampd_id', 'inner');
                        $this->db_plc0->where('plc2_upb_request_sample_detail.ireqdet_id',$post['id']);
                        #$this->db_plc0->where('plc2_upb_ro_detail.irelease',2);
                        $que=$this->db_plc0->get();
                        break;
    				case 'iupb_id':
    					$this->db_plc0->select("plc2_upb.vupb_nomor AS 'Nomor UPB', plc2_upb.vupb_nama AS 'Nama Usulan',  plc2_upb.vgenerik AS 'Nama Generik', 
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteampd_id) as 'Team PD',
                            (select CONCAT(plc2_upb_team.vteam) from plc2.plc2_upb_team where plc2_upb_team.iteam_id=plc2_upb.iteamqa_id) as 'Team QA',
                            ", FALSE);
    					$this->db_plc0->from('plc2.plc2_upb');
    					$this->db_plc0->where('plc2_upb.iupb_id',$post['id']);
    					$this->db_plc0->where('plc2_upb.ldeleted',0);
    					$que=$this->db_plc0->get();
    				default:
    					$sql="";
    					break;
    			}
    			$dataret='<p style="background:#FFBBBB;border:solid 1px #FF0000;padding:5px 5px 5px 5px;"><strong>DETAILS UPB NOT FOUND</strong></p>'.$this->db_plc0->last_query();
    			if($que->num_rows>0){
    				$row=$que->row_array();
                    $dataret="<table style='width:100%;font-weight: bold;border-collapse: collapse;'>";
                    foreach ($row as $key => $value) {
                        $dataret.="<tr style='border-bottom: 1px solid #89b9e0;'><td style='width:100px;padding-top:10px;'>".$key."</td><td style='width:3px;align:center;padding-top:10px;'>:</td><td style='padding-left:5px;padding-top:10px;'>".$value."</td></tr>";
                    }
    				$dataret.="</table>";
    			}
    			$html='<div class="full_colums" style="background-color:white;max-width:98%;padding: 10px 10px 10px 10px;">'.$dataret.'</div>';
    			echo $html;
    			break;
    		case 'getnum':
				$ifor_id=$this->input->post('ifor_id');
				 $sql='select b.vNo_formula,b.iVersi,b.*,a.* 
						from pddetail.formula_process a 
						join pddetail.formula b on b.iFormula_process=a.iFormula_process
						join plc2.plc2_upb_formula on plc2_upb_formula.iupb_id=a.iupb_id
						where a.lDeleted=0
						and b.lDeleted=0
						and plc2_upb_formula.ifor_id="'.$ifor_id.'"
						and b.iFinishSkalaLab=1
						order by b.iFormula DESC';
				$qqq = $this->db_plc0->query($sql);
				
				if($qqq->num_rows()>0){
					$data['status']=TRUE;
					$count = $qqq->row_array();
					$data['vNo_formula']=$count['vNo_formula'];
					$data['iVersi']=$count['iVersi'];
				}else{
					$data['status']=FALSE;
					$data['vNo_formula']='-';
					$data['iVersi']='-';
				}
				echo json_encode($data);
				exit();
				break;
    		case 'getDetailsSoi':
				$iupb_id=$this->input->post('iupb_id');
				 $sql='select plc2_upb_soi_fg.*,concat(plc2_upb_soi_fg.vnip_formulator, "|", employee.vName) as nip from plc2.plc2_upb_soi_fg 
				 left join hrd.employee on employee.cNip=plc2_upb_soi_fg.vnip_formulator
				 where plc2_upb_soi_fg.ldeleted=0 and plc2_upb_soi_fg.iupb_id='.$iupb_id.' order by isoi_id DESC';
				$qqq = $this->db_plc0->query($sql);
				
				if($qqq->num_rows()>0){
					$data['status']=TRUE;
					$count = $qqq->row_array();
					$data['vkode_surat']=$count['vkode_surat'];
					$data['dmulai_draft']=$count['dmulai_draft'];
					$data['dselesai_draft']=$count['dselesai_draft'];
					$data['nip']=$count['nip'];
				}else{
					$data['status']=FALSE;
					$data['vkode_surat']='-';
					$data['dmulai_draft']='-';
					$data['dselesai_draft']='-';
					$data['nip']='-';
				}
				echo json_encode($data);
				exit();
				break;
    		case 'getMBRDetails':
				$c_iteno=$this->input->post('c_iteno');
				 $sql='select * FROM (select batpack0.*
				 from sales.itemas
				 join prdtrial.trial on trial.c_itenonew=itemas.c_iteno
				 join prdtrial.batpack0 on batpack0.c_iteno=trial.c_iteno
				 where itemas.c_iteno="'.$c_iteno.'"
				 order by batpack0.c_version DESC) as z
				 group by z.c_iteno';
				$qqq = $this->db_plc0->query($sql);
				
				if($qqq->num_rows()>0){
					$data['status']=TRUE;
					$count = $qqq->row_array();
					$data['c_version']=isset($count['c_version'])?$count['c_version']:"-";
					$data['c_nodoinp']=isset($count['c_nodoinp'])?$count['c_nodoinp']:'-';
					$data['d_userid1']=isset($count['d_userid1'])?$count['d_userid1']:"-";
					$data['d_userid2']=isset($count['d_userid2'])?$count['d_userid2']:'-';
					$data['d_userid3']=isset($count['d_userid3'])?$count['d_userid3']:'-';
					$data['d_userid4']=isset($count['d_userid4'])?$count['d_userid4']:'-';
					$data['d_datent']=isset($count['d_datent'])?$count['d_datent']:'-';
				}else{
					$data['status']=FALSE;
					$data['c_version']='-';
					$data['c_nodoinp']='-';
					$data['d_userid1']='-';
					$data['d_userid2']='-';
					$data['d_userid3']='-';
					$data['d_userid4']='-';
					$data['d_datent']='-';
				}
				echo json_encode($data);
				exit();
				break;
            case 'getDetailSoiFgTentative':
                $iupb_id    = $this->input->post('iupb_id');
                $irevisi    = $this->input->post('irevisi');
                $file       = $this->input->post('file');

                $sqlSOI = 'SELECT f.*, /*CONCAT(e.cNip , " | ", e.vName) AS nip*/ e.cNip AS nip FROM plc2.plc2_upb_soi_fg f
                            LEFT JOIN hrd.employee e ON f.vnip_formulator = e.cNip
                            WHERE f.ldeleted = 0 AND f.iapppd = 2 AND f.irevisi = ?
                                AND f.iupb_id = ?
                            ORDER BY f.isoi_id DESC ';
                $getSOI = $this->db_plc0->query($sqlSOI, array($irevisi, $iupb_id))->row_array();

                if (!empty($getSOI)){
                    $isoi_id = $getSOI['isoi_id'];

                    //mendapatkan file upload di table baru
                    $sqlFile = 'SELECT f.vFilename, f.vFilename_generate, f.tKeterangan, m.filepath, f.idHeader_File, m.filename
                                FROM plc2.group_file_upload f 
                                JOIN plc2.sys_masterdok m ON f.iM_modul_fileds = m.iM_modul_fileds
                                WHERE f.iM_modul_fileds = 197 AND f.idHeader_File = ? AND f.iDeleted = 0';
                    $getFile = $this->db_plc0->query($sqlFile, array($isoi_id))->result_array();

                    $filename       = 'filesoifgtentative';
                    foreach ($getFile as $f) {
                        $filename       = $f['filename'];
                    }

                    if (!empty($filename)){
                        
                        //pengecekan apakah upload file tsb sudah di set di master dokumen
                        $sqlCekDok = 'SELECT m.* FROM plc2.sys_masterdok m WHERE m.filetable IS NOT NULL AND m.fieldheader IS NOT NULL AND m.ffilename IS NOT NULL AND m.fvketerangan IS NOT NULL AND m.fldeleted IS NOT NULL AND m.filename = ? ';
                        $getCekDok = $this->db_plc0->query($sqlCekDok, array($filename))->row_array();

                        if (!empty($getCekDok)){
                            $filetable  = $getCekDok['filetable'];
                            $fieldfile  = $getCekDok['ffilename'];
                            $fieldket   = $getCekDok['fvketerangan'];
                            $fieldhead  = $getCekDok['fieldheader'];
                            $fielddel   = $getCekDok['fldeleted'];
                            $fieldname  = $getCekDok['ffilename'];
                            $filepath   = $getCekDok['filepath'];

                            //mendapatkan file upload dari table lama
                            $getOldFile = $this->db_plc0->get_where($filetable, array($fieldhead => $isoi_id, $fielddel => 0))->result_array(); 
                            foreach ($getOldFile as $o) {
                                $old['vFilename']           = $o[$fieldname];
                                $old['vFilename_generate']  = (!empty($o['vFilename_generate']))?$o['vFilename_generate']:$o[$fieldname];
                                $old['tKeterangan']         = $o[$fieldket];
                                $old['filepath']            = $filepath;
                                $old['idHeader_File']       = $isoi_id;
                                $old['filename']            = $filename;
                                array_push($getFile, $old);
                            }
                        }
                    }

                    $data['rows'] = $getFile;
                    $value = $this->load->view('partial/modul/'.$file, $data,true);

                    $data['status']         = TRUE;
                    $data['vkode_surat']    = $getSOI['vkode_surat'];
                    $data['dmulai_draft']   = $getSOI['dmulai_draft'];
                    $data['dselesai_draft'] = $getSOI['dselesai_draft'];
                    $data['nip']            = $getSOI['nip'];
                    $data['file']           = $value;
                } else {
                    $data['rows'] = array();
                    $value = $this->load->view('partial/modul/'.$file, $data,true);

                    $data['status']         = FALSE;
                    $data['vkode_surat']    = '-';
                    $data['dmulai_draft']   = '-';
                    $data['dselesai_draft'] = '-';
                    $data['nip']            = '-';
                    $data['file']           = $value;
                }
                
                echo json_encode($data);
                exit();
                break;
    		default:
				echo "default";
				break;
    	}
    }

    function output(){
    	$this->index($this->input->get('action'));
    }
}