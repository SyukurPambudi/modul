<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_partial_controllers_reformulasi extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db = $this->load->database('formulasi',false, true);
    }

    function index($action = '') {
    	switch ($action) {
    		case 'getDetails':
    			$post=$this->input->post();
    			switch ($post['jenis']) {
    				case 'iexport_req_refor':
    					$this->db->select("dossier_upd.vUpd_no AS 'Nomor UPD', dossier_upd.vNama_usulan AS 'Nama Usulan', export_req_refor.vno_export_req_refor AS 'No. Request Reformulasi',
                            (select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = export_req_refor.iTeamPD) as 'Team PD',
                            (select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = export_req_refor.iTeamAndev) as 'Team AD',
                            CONCAT(employee.cNip, ' - ', employee.vName) AS 'Nama Inisiator',
                            msdepartement.vDescription as 'Departement'
                            ", FALSE);
    					$this->db->from('reformulasi.export_req_refor');
    					$this->db->join('dossier.dossier_upd', 'export_req_refor.idossier_upd_id = dossier_upd.idossier_upd_id');
                        $this->db->join('hrd.employee', 'export_req_refor.cInisiator_export = employee.cNip');
                        $this->db->join('hrd.msdepartement', 'export_req_refor.iDepartemen_export = msdepartement.iDeptID');
    					$this->db->where('export_req_refor.iexport_req_refor', $post['id']);
    					$this->db->where('export_req_refor.lDeleted', 0);
    					$this->db->where('dossier_upd.lDeleted', 0);
    					$que = $this->db->get();
                        break;
                    case 'idossier_upd_id':
                            $sqlDetail  = 'SELECT  b.c_itnam AS "Nama Produk",
                                                        b.c_iteno AS "Kode Produk"
                                            FROM dossier.dossier_upd a 
                                            JOIN sales.itemas b ON b.c_iteno=a.iupb_id
                                            WHERE a.lDeleted=0
                                            AND a.idossier_upd_id = ?
                                            ';
                            $que        = $this->db->query($sqlDetail, array($post['id']));
                            break;

                    case 'ilpb_id':
                        $sqlDetail  = 'SELECT w.vWareHouse AS "Warehouse", s.vSupplierName AS "Supplier", h.cLPB_Number AS "Nomor Permintaan", 
                                            h.dLPB_Date AS "Tanggal Permintaan", h.dReceivedDate AS "Tanggal Penerimaan", 
                                            ph.cPONumber AS "Nomor PO", d.cRequestNo AS "Nomor Initial Request", CONCAT(e.cNip, " - ", e.vName) AS "PIC Penerimaan",
                                            u.vUpd_no AS "Nomor UPD", u.vNama_usulan AS "Nama UPD"
                                        FROM pd_source.lpb_header h 
                                        JOIN pd_source.warehouse w ON h.iWareHouseID = w.Id
                                        JOIN pd_source.supplier s ON h.iSupplierId = s.Id
                                        JOIN pd_source.lpb_detail d ON h.cLPB_Number = d.cLPB_Number
                                        JOIN pd_source.poir_header ph ON d.cPONumber = ph.cPONumber
                                        JOIN pd_source.inreq_header ir ON d.cRequestNo = ir.cRequestNo
                                        JOIN hrd.employee e ON ir.cFinalReceived = e.cNip
                                        LEFT JOIN dossier.dossier_upd u ON ir.iSampleID = u.idossier_upd_id
                                        WHERE h.lDeleted = 0 AND h.id = ?
                                        GROUP BY h.id ORDER BY h.cLPB_Number ASC ';
                        $que        = $this->db->query($sqlDetail, array($post['id']));
                        break;
                    case 'idok_mbr':
                        $sqlDetail  = 'SELECT 
                                        c.vnoFormulasi AS "No Formula"
                                        ,e.vUpd_no AS "No UPD"
                                        ,e.vNama_usulan AS "Nama Usulan"
                                        ,d.vno_export_req_refor AS "No Request Reformulasi"
                                        ,(select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = d.iTeamPD) as "Team PD"
                                        ,(select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = d.iTeamAndev) as "Team AD"
                                        FROM reformulasi.export_dok_mbr a 
                                        JOIN reformulasi.export_refor_basic_formula b ON b.iexport_refor_basic_formula=a.iexport_refor_basic_formula
                                        JOIN reformulasi.export_refor_formula c ON c.iexport_refor_formula=b.iexport_refor_formula
                                        JOIN reformulasi.export_req_refor d ON d.iexport_req_refor=c.iexport_req_refor
                                        JOIN dossier.dossier_upd e ON e.idossier_upd_id=d.idossier_upd_id
                                        WHERE a.lDeleted=0
                                        AND b.lDeleted=0
                                        AND c.lDeleted=0
                                        AND d.lDeleted=0
                                        AND a.idok_mbr= ?
                                        ';
                        $que        = $this->db->query($sqlDetail, array($post['id']));
                        break;
                    case 'iexport_protokol_valpro':
                        $sqlDetail  = 'SELECT pv.iexport_protokol_valpro AS "No Protokol Valpro",c.vnoFormulasi AS "No Formula"
                                        ,e.vUpd_no AS "No UPD"
                                        ,e.vNama_usulan AS "Nama Usulan"
                                        ,d.vno_export_req_refor AS "No Request Reformulasi"
                                        ,(select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = d.iTeamPD) as "Team PD"
                                        ,(select CONCAT(reformulasi_team.vteam) from reformulasi.reformulasi_team where reformulasi_team.ireformulasi_team = d.iTeamAndev) as "Team AD"
                                        FROM reformulasi.export_protokol_valpro pv 
                                                    JOIN  reformulasi.export_dok_mbr a ON a.idok_mbr = pv.idok_mbr
                                        JOIN reformulasi.export_refor_basic_formula b ON b.iexport_refor_basic_formula=a.iexport_refor_basic_formula
                                        JOIN reformulasi.export_refor_formula c ON c.iexport_refor_formula=b.iexport_refor_formula
                                        JOIN reformulasi.export_req_refor d ON d.iexport_req_refor=c.iexport_req_refor
                                        JOIN dossier.dossier_upd e ON e.idossier_upd_id=d.idossier_upd_id
                                        WHERE a.lDeleted=0
                                        AND b.lDeleted=0
                                        AND c.lDeleted=0
                                        AND d.lDeleted=0
                                        AND pv.iexport_protokol_valpro= ?
                                        ';
                        $que        = $this->db->query($sqlDetail, array($post['id']));
                        break;
    				default:
    					$sql="";
    					break;
    			}
    			$dataret = '<p style="background:#FFBBBB;border:solid 1px #FF0000;padding:5px 5px 5px 5px;"><strong>DETAILS NOT FOUND</strong></p>'.$this->db->last_query();
    			if($que->num_rows > 0){
    				$row = $que->row_array();
                    $dataret = "<table style='width:100%;font-weight: bold;border-collapse: collapse;'>";
                    foreach ($row as $key => $value) {
                        $dataret .= "<tr style='border-bottom: 1px solid #89b9e0;'>";
                        $dataret .= "   <td style='width:100px;padding-top:10px;'>".$key."</td>";
                        $dataret .= "   <td style='width:3px;align:center;padding-top:10px;'>:</td>";
                        $dataret .= "   <td style='padding-left:5px;padding-top:10px;'>".$value."</td>";
                        $dataret .= "</tr>";
                    }
                    
                    
                    if($post['jenis']=='iexport_protokol_valpro'){
                        $sql_getDetails = 'SELECT a.cpanumb 
                                            FROM export_protokol_valpro_detail a 
                                            WHERE 
                                            a.lDeleted=0
                                            AND a.iexport_protokol_valpro= "'.$row['No Protokol Valpro'].'" ';
                                            //echo '<pre>'.$sql_getDetails;
                        $ques        = $this->db->query($sql_getDetails);


                        if($ques->num_rows > 0){

                            $dataret .= "<tr style='border-bottom: 1px solid #89b9e0;'>";
                            $dataret .= "   <td style='width:100px;padding-top:10px;'>Batch</td>";
                            $dataret .= "   <td style='width:3px;align:center;padding-top:10px;'></td>";
                            
                            $dataret .= "   <td style='padding-left:5px;padding-top:10px;'>";
                                    $quess = $ques->result_array();
                                    $dataret .= "<ul>";
                                                    foreach($quess as $item){
                                                        $dataret .= "<li>";
                                                            $dataret .= $item['cpanumb'];
                                                        $dataret .= "</li>";
                                                    }
                                            
                                    $dataret .= "</ul>";
                            $dataret .= "   </td>";
                            
                            $dataret .= "</tr>";

                        }
                    }

                    $dataret .= "</table>";
    			}
    			$html = '<div class="full_colums" style="background-color:white;max-width:98%;padding: 10px 10px 10px 10px;">'.$dataret.'</div>';
    			echo $html;
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