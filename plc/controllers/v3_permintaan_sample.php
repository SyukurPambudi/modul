 
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_permintaan_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb_request_sample';
        $this->main_table_pk='ireq_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.plc2_upb_request_sample';
        $this->_table_plc_upb = 'plc2.plc2_upb';
        $this->_table_plc_team = 'plc2.plc2_upb_team';
        $this->_table_employee = 'hrd.employee';  

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Permintaan Sample');       
        $grid->setTable($this->_table);     
        $grid->setUrl('v3_permintaan_sample');
        $grid->addList('vreq_nomor','trequest','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id','iapppd');
        $grid->setJoinTable($this->_table_plc_upb, $this->_table_plc_upb.'.iupb_id = '.$this->_table.'.iupb_id', 'inner');
        $grid->setSortBy('vreq_nomor');
        $grid->setSortOrder('desc');
        $grid->setRelation($this->_table_plc_upb.'.iteampd_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'PD','ldeleted'=>0), array('vteam'=>'asc'));      
        $grid->setSearch('vreq_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id'); //,'trequest'
        // $grid->setRequired('iupb_id','trequest');
        $grid->setWidth('vreq_nomor', 90);
        $grid->setWidth('trequest', 90);
        $grid->setWidth('plc2_upb.vupb_nomor', 70);
        $grid->setWidth('plc2_upb.iteampd_id', 120);
        
        $grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
        $grid->setLabel('iupb_id', 'No. UPB');
        $grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
        $grid->setLabel('vupb_nama', 'Nama Usulan');
        $grid->setLabel('plc2_upb.iteampd_id','Team PD');
        $grid->setLabel('iteampd_id','Team PD');
        $grid->setLabel('vreq_nomor','No. Permintaan');
        $grid->setLabel('itipe','Kemasan');
        $grid->setLabel('trequest','Tanggal permintaan');
        $grid->setLabel('detail','Detail Bahan Baku');
        $grid->setLabel('iapppd','Approval PD');
        $grid->setLabel('vnip_apppd','Approval PD');
        $grid->setLabel('iTujuan_req','Tujuan Request');
        $grid->setLabel('cRequestor','Requestor');
        
        $grid->setQuery('plc2_upb.ldeleted', 0);
        $grid->setQuery('plc2_upb_request_sample.ldeleted', 0);

            $grid->setQuery('plc2.plc2_upb.ldeleted', 0);
            $grid->setQuery('plc2.plc2_upb.iKill', 0);
            $grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
            $grid->setQuery('plc2_upb.ihold', 0);

        $this->lib_plc->gridFilterUPBbyTeam($grid, $this->modul_id);

        $grid->setGridView('grid');
        $grid->addFields('form_detail'); 


        switch ($action) {
            case 'json':
                    $grid->getJsonData();
                    break;
            case 'getFormDetail':
                    $post=$this->input->post();
                    $get=$this->input->get(); 
                    $data['html']="";

                    $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
                    /*echo $sqlFields;
                    exit;*/
                    $dFields = $this->db->query($sqlFields)->result_array(); 

                    $hate_emel = "";

                    if($get['formaction']=='update'){
                            $aidi = $get['id'];
                    }else{
                            $aidi = 0;
                    }

                    $hate_emel .= '
                        <table class="hover_table" style="width:99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                            <thead>
                                <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                                    <th style="border: 1px solid #dddddd; width: 10%;">Activity Name</th>
                                    <th style="border: 1px solid #dddddd;">Status</th>
                                    <th style="border: 1px solid #dddddd;">at</th>      
                                    <th style="border: 1px solid #dddddd; width: 30%;">By</th>      
                                    <th style="border: 1px solid #dddddd; width: 40%;">Remark</th>      
                                </tr>
                            </thead>
                            <tbody>';

                            $hate_emel .= $this->lib_plc->getHistoryActivity($this->modul_id,$aidi);

                    $hate_emel .='
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <hr>
                    ';


                    if(!empty($dFields)){

                        foreach ($dFields as $form_field) {
                            
                            $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                            
                            $data_field['form_field']= $form_field;

                            $controller = 'v3_permintaan_sample';
                            $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                            //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                            $data_field['field']= $form_field['vNama_field'] ;

                            $data_field['act']= $get['act'] ;
                            $data_field['hasTeam']= $this->team ;
                            $data_field['hasTeamID']= $this->teamID ;
                            $data_field['isAdmin']= $this->isAdmin ;


                            /*untuk keperluad file upload*/
                            if($form_field['iM_jenis_field'] == 7){
                                $data_field['tabel_file']= $form_field['vTabel_file'] ;
                                $data_field['tabel_file_pk']= $this->main_table_pk;
                                $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                                $path = 'files/plc/dok_tambah';
                                $createname_space = 'v3_permintaan_sample';
                                $tempat = 'dok_tambah';
                                $FOLDER_APP = 'plc';

                                $data_field['path'] = $path;
                                $data_field['FOLDER_APP'] = $FOLDER_APP;
                                $data_field['createname_space'] = $createname_space;
                                $data_field['tempat'] = $tempat;

                            }
                            /*untuk keperluad file upload*/


                            if($get['formaction']=='update'){
                                $id = $get['id'];

                                $sqlGetMainvalue= 'select * from plc2.'.$this->main_table.' where ldeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                                $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                                $data_field['dataHead']= $dataHead;
                                $data_field['main_table_pk']= $this->main_table_pk;
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                                    if ($form_field['vNama_field'] == 'iRefUpb_id'){
                                        $sqlEdit = $form_field['vSource_input_edit'] ;
                                        $sqlEdit .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id, 'u');
                                        $sqlEdit .= ' UNION SELECT iupb_id AS valval, CONCAT(vupb_nomor, " | ",vupb_nomor) AS showshow FROM plc2.plc2_upb WHERE iupb_id = '.$dataHead['iRefUpb_id'].' GROUP BY valval ORDER BY showshow ASC'; 
                                        $data_field['vSource_input'] = $sqlEdit;
                                    }
                                }else{
                                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                                }

                                if ($form_field['iRequired']==1) {
                                    // $hate_emel .='<span class="required_bintang">bintang*</span>';    
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }
                                $data_field['iModul_id'] = $this->iModul_id;
                                $data_field['modul_id'] = $this->modul_id;
                                

                                $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);    
                            }else{
                                $sqlCreate = $form_field['vSource_input'] ;
                                $sqlCreate .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                                $data_field['vSource_input']= $form_field['vSource_input'] ;
                                $data_field['iModul_id'] = $this->iModul_id;
                                $data_field['modul_id'] = $this->modul_id;

                                $return_field = $this->load->view('partial/v3_form_detail',$data_field,true);    
                            } 
                            

                            $hate_emel .='  <div class="rows_group" style="overflow:fixed;">
                                                <label for="'.$controller.'_form_detail_'.$form_field['vNama_field'].'" class="rows_label">'.$form_field['vDesciption'].'
                                                ';
                            if ($form_field['iRequired']==1) {
                                $hate_emel .='<span class="required_bintang">*</span>';    
                                $data_field['field_required']= 'required';
                            }else{
                                $data_field['field_required']= '';
                            }

                            if ($form_field['vRequirement_field']<> "") {
                                $hate_emel .='<span style="float:right;" title="'.$form_field['vRequirement_field'].'" class="ui-icon ui-icon-info"></span>';    
                            }else{
                                $hate_emel .='';    
                            }


                            

                            $hate_emel .='      </label>
                                                <div class="rows_input">'.$return_field.'</div>
                                            </div>';
                        }

                    }else{
                        $hate_emel .='Field belum disetting';
                    }

                    $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft" />'; 
                    
                    $data["html"] .= $hate_emel;
                    echo json_encode($data);
                break;

            case 'view':
                    $grid->render_form($this->input->get('id'), true);
                    break;

            case 'create':
                    $grid->render_form();
                    break;
             
            case 'createproses':
                    $post = $this->input->post();
                    if (isset($post['iupb_id'])){
                        echo $grid->saved_form();
                    }else{
                        $dt['message'] = 'UPB Harus Dipilih';
                        $dt['status'] = false;
                        echo json_encode($dt); 
                    }
                    break;

            case 'update':
                    $grid->render_form($this->input->get('id'));
                    break;
        
            case 'updateproses':
                    $post = $this->input->post();
                    if (isset($post['iupb_id'])){
                        echo $grid->updated_form();
                    }else{
                        $dt['message'] = 'UPB Harus Dipilih';
                        $dt['status'] = false;
                        echo json_encode($dt); 
                    }
                    break;
                                   
            case 'delete':
                    echo $grid->delete_row();
                    break;

            case 'gethistkomposisi':
                echo $this->gethistkomposisi();
                break;

            case 'rawmat_list':
                $this->rawmat_list();
                break;
            case 'copyOri':
                echo $this->copyOri_view();
                break;
            case 'copyOri_process':
                echo $this->copyOri_process();
                break;
            case 'copyKomp':
                echo $this->copyKomp_view();
                break;
            case 'copyKomp_process':
                echo $this->copyKomp_process();
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

            case 'confirm':
                echo $this->confirm_view();
                break;
            case 'confirm_process':
                echo $this->confirm_process();
                break;

                case 'download':
                    $this->download($this->input->get('file'));
                    break;
            case 'load_detail':
                echo $this->load_detail();
                break;
            case 'load_upb':
                echo $this->load_upb();
                break;
            default:
                    $grid->render_grid();
                    break;
        }
    }

        function load_detail(){
            $iupb_id = $this->input->post('iupb_id');
            $iModul_id = $this->input->post('iModul_id'); 
            $sql = "SELECT vFile_detail FROM plc3.m_modul_fileds WHERE iM_modul = ? AND lDeleted = 0 AND vNama_field = 'detail' ";
            $field = $this->db->query($sql, array($iModul_id))->row_array();
            $value = "Value Not Found";
            if (count($field) > 0){
                $view = $field['vFile_detail'];
                $sqlDetail = "SELECT 0 AS ireqdet_id, d.raw_id, r.vnama, d.vsatuan, d.ijumlah, d.tspecification FROM plc2.plc2_upb_request_sample_detail d JOIN plc2.plc2_raw_material r ON d.raw_id = r.raw_id WHERE d.ireq_id IN (SELECT ireq_id FROM plc2.plc2_upb_request_sample WHERE iupb_id = ? AND ldeleted = 0 AND iapppd = 2) AND d.ldeleted = 0";
                $detail = $this->db->query($sqlDetail, array($iupb_id))->result_array();
                $data['rows'] = $detail;
                $data['act'] = '';
                $value = $this->load->view('partial/modul/'.$view,$data,true);
            }
            echo $value;exit();
        }

        function load_upb(){
            $post = $this->input->post();
            $tujuan = $post['tujuan'];
            $upb = $post['upb'];
            $modul_id = $post['modul_id'];
            $existing = $post['existing'];
            $filter = $this->lib_plc->queryFilterUPBbyTeam($modul_id,'u');

            $basicSQL = '';
            if (intval($upb) > 0 && $existing){
                $basicSQL .= ' SELECT u.iupb_id AS valval, CONCAT(u.vupb_nomor, " | ",u.vupb_nama) AS showshow, u.vupb_nama FROM plc2.plc2_upb u WHERE u.iupb_id = ?  UNION ';
            }

            //cek apakah upb sudah melewati pembuatan mbr
            $cekMBR = ' AND (SELECT COUNT(*) FROM plc3.m_modul a 
                            JOIN plc3.m_modul_log_activity b ON b.idprivi_modules = a.idprivi_modules
                            JOIN plc3.m_modul_log_upb c ON c.iM_modul_log_activity = b.iM_modul_log_activity
                            WHERE a.iM_modul in (13) and b.iM_activity = 4
                                and c.iupb_id = u.iupb_id ) = 0';

            //cek apkaah upb sudah melewati produksi pilot
            $cekPilot = ' AND (SELECT COUNT(*) FROM plc2.plc2_upb_prodpilot p 
                            JOIN plc2.plc2_upb_formula f ON p.ifor_id = f.ifor_id
                            WHERE p.ldeleted = 0 AND p.iapppd_pp = 2 AND f.ldeleted = 0 AND f.iupb_id = u.iupb_id) = 0 ';

            $basicSQL .= 'SELECT u.iupb_id AS valval, CONCAT(u.vupb_nomor, " | ",u.vupb_nama) AS showshow, u.vupb_nama FROM plc2.plc2_upb u WHERE u.ldeleted = 0 AND u.ihold = 0 AND u.iKill = 0 ';
            /* Tambah Jika Dia Mutu */
            $tujuan1=$basicSQL.'AND u.iupb_id IN (SELECT d.iupb_id FROM plc2.plc2_upb_prioritas_detail d 
                JOIN plc2.plc2_upb_prioritas p ON d.iprioritas_id = p.iprioritas_id
                JOIN plc2.plc2_upb u ON d.iupb_id = u.iupb_id
                WHERE p.iappdir = 2 AND u.ldeleted = 0 AND u.ihold = 0 AND u.iKill = 0
                UNION SELECT a.iupb_id FROM plc2.study_literatur_pd a WHERE a.lDeleted = 0 AND a.iapppd = 2) 
                AND u.iupb_id IN (select iupb_id from plc2.log_mutu where lDeleted=0 and iDone=0 and idprivi_modules='.$modul_id.')
                UNION ';
            $tujuan1 .= $basicSQL.'AND u.iupb_id IN (SELECT d.iupb_id FROM plc2.plc2_upb_prioritas_detail d 
                                    JOIN plc2.plc2_upb_prioritas p ON d.iprioritas_id = p.iprioritas_id
                                    JOIN plc2.plc2_upb u ON d.iupb_id = u.iupb_id
                                    WHERE p.iappdir = 2 AND u.ldeleted = 0 AND u.ihold = 0 AND u.iKill = 0
                                    UNION SELECT a.iupb_id FROM plc2.study_literatur_pd a WHERE a.lDeleted = 0 AND a.iapppd = 2)
                        AND u.iupb_id NOT IN (SELECT d.iupb_id FROM plc2.plc2_upb_ro_detail  a 
                            JOIN plc2.plc2_upb_request_sample b ON b.ireq_id=a.ireq_id
                            JOIN plc2.plc2_upb_ro c ON c.iro_id=a.iro_id
                            JOIN plc2.plc2_upb d ON d.iupb_id=b.iupb_id
                            JOIN plc2.plc2_raw_material e ON e.raw_id=a.raw_id
                            WHERE a.vrec_nip_qc IS NULL AND a.trec_date_qc IS NULL AND a.ldeleted = 0 AND b.ldeleted = 0
                                AND c.ldeleted = 0 AND d.ldeleted = 0 AND e.ldeleted = 0) '.$filter.' '.$cekPilot.' ORDER BY vupb_nama ASC';
            $tujuan2 = $basicSQL.' AND u.iupb_id IN (SELECT fp.iupb_id FROM pddetail.formula f 
                            JOIN pddetail.formula_process fp ON fp.iFormula_process=f.iFormula_process
                            WHERE f.lDeleted = 0 AND fp.lDeleted = 0 AND f.iNextReqSample = 1
                            AND f.iFinishRegSample = 0 AND f.iFinishStresTest = 1) '.$filter.' '.$cekPilot.' ORDER BY vupb_nama ASC';
            $tujuan3 = $basicSQL. ' AND u.iupb_id IN (SELECT a.iupb_id FROM plc2.plc2_upb_formula a WHERE a.iapppd_basic=2 AND a.iwithbasic = 1)
                            AND u.iupb_id NOT IN (SELECT a1.iupb_id FROM plc2.plc2_upb_formula a1
                            JOIN plc2.plc2_upb_prodpilot b1 on b1.ifor_id=a1.ifor_id
                            WHERE (b1.dtglmulai_prod IS NOT NULL AND b1.dtglmulai_prod != "0000-00-00" )) '.$filter.' '.$cekPilot.' ORDER BY vupb_nama ASC';
            $tujuan4 = $basicSQL.' AND u.iupb_id IN (SELECT fp.iupb_id FROM pddetail.formula f 
                            JOIN pddetail.formula_process fp ON fp.iFormula_process = f.iFormula_process
                            WHERE f.lDeleted=0 AND fp.lDeleted=0 AND f.iBackSample=1) '.$filter.' '.$cekPilot.' ORDER BY vupb_nama ASC';

            if ($tujuan == 1){
                $arrUPB = $this->db->query($tujuan1, array($upb, $upb))->result_array();
            } else if ($tujuan == 2){
                $arrUPB = $this->db->query($tujuan2, array($upb, $upb))->result_array();
            } else if ($tujuan == 3){
                $arrUPB = $this->db->query($tujuan3, array($upb, $upb))->result_array();
            } else {
                $arrUPB = $this->db->query($tujuan4, array($upb, $upb))->result_array();
            }

            $html = '<select name="iupb_id" id="v3_permintaan_sample_upb_id" required class="input_rows1 choose">';
            foreach ($arrUPB as $u) {
                $selected = ($u['valval']==$upb)?'selected':'';
                $html .= '<option '.$selected.' value="'.$u['valval'].'" >'.$u['showshow'].'</option>';
            }
            $html .= '</select>';
            $html .= '<script>
                        $("select.choose").chosen();
                    </script>';

            echo $html;exit();
        }

        function listBox_v3_permintaan_sample_iapppd($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function gethistkomposisi(){
            $raw_id=$_POST['raw_id'];
            $data = array();
            $row_array = '';
            $sql2 = "select b.vupb_nomor 
                    from plc2.plc2_upb_prioritas_komposisi a 
                    join plc2.plc2_upb_prioritas b on b.ireq_id=a.ireq_id
                    where  a.ldeleted=0 and b.ldeleted=0 and a.raw_id='".$raw_id."'";
            $results = $this->db_plc0->query($sql2)->result_array();

            $i=1;
            foreach ($results as $item ) {
                if ($i==1) {
                    $row_array .= trim($item['vupb_nomor']);    
                }else{
                    $row_array .= ','.trim($item['vupb_nomor']);        
                }
                

                $i++;
            }
            
            
            
            array_push($data, $row_array);
            echo json_encode($data);
            exit;

        }

        function rawmat_list() {
            $term = $this->input->get('term');
            $return_arr = array();
            $this->db_plc0->like('vraw',$term);
            $this->db_plc0->or_like('vnama',$term);
            $this->db_plc0->limit(50);
            $lines = $this->db_plc0->get('plc2.plc2_raw_material')->result_array();
            $i=0;
            foreach($lines as $line) {
                $row_array["sat"] = trim($line["vsatuan"]);
                $row_array["value"] = trim($line["vnama"]).' - '.trim($line["vraw"]);
                $row_array["id"] = trim($line["raw_id"]);
                array_push($return_arr, $row_array);
            }
            echo json_encode($return_arr);exit();
            
        }

        // copy Komposisi Originator ke Komposisi UPB
        function copyOri_view() {
            $ireq_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ireq_id=$ireq_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi_ori a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ireq_id=$ireq_id and a.ldeleted ='0' ";         
        
            $rupa = $this->db_plc0->query($qupa);
            $rupb = $this->db_plc0->query($qupb)->row_array();
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            return $.ajax({
                                url: $("#"+form_id).attr("action"),
                                type: $("#"+form_id).attr("method"),
                                data: $("#"+form_id).serialize(),
                                success: function(data) {
                                    var o = $.parseJSON(data);
                                    var last_id = o.last_id;
                                    var company_id = 3;
                                    var group_id = o.group_id;
                                    var modul_id = o.modul_id;
                                    var foreign_id = "";
                                    var header = "Info";
                                    var info = "Info";
                                    var url = "'.base_url().'processor/plc/v3/permintaan/sample";                             
                                    if(o.status == true) {
                                        //alert($ireq_id);
                                        $("#alert_dialog_form").dialog("close");
                                        $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_upb_daftar").html(data);
                                        });
                                        // $.get(url+"processor/plc/v3/permintaan/sample?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                            // $("div#form_upb_daftar").html(data);
                                            // $("html, body").animate({scrollTop:$("#"+grid).offset().top - 20}, "slow");
                                        // });
                                        
                                    }
                                        _custom_alert("Copy data berhasil",header,info,"grid_upb_daftar", 1, 20000);
                                        reload_grid("grid_upb_daftar");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Copy Komposisi Originator ke Komposisi UPB</h1><br />';
            $echo .= '<form id="form_v3_permintaan_sample_copyOri" action="'.base_url().'processor/plc/v3/permintaan/sample?action=copyOri_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ireq_id" value="'.$this->input->get('upb_id').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
                        
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
                            ';  
                         if ($rupa->num_rows() > 0) {
                            $result = $rupa->result_array();
                            $i=1;
                            foreach($result as $row) {
                                    $echo .='<input type="checkbox" name="ikomp_ori[]" value="'.$row['ikomposisi_id'] .'">
                                    <label for="">'.$row['vnama'].'</label><br>
                                    ';
                                $i++;
                            }
                        }   
            
                $echo .='</td></tr>
                    </table>
                    </br>
            <button type="button" onclick="submit_ajax(\'form_v3_permintaan_sample_copyOri\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyOri_process() {
            $team=$this->auth_localnon->my_teams(TRUE);
            $post = $this->input->post();
            $ireq_id =$post['ireq_id'];
            $modul_id =$post['modul_id'];
            $group_id =$post['group_id'];
            $user = $this->auth_localnon->user();
            
            
            $ikomp_ori = array();
            foreach($_POST as $k=>$v) {
                if ($k == 'ikomp_ori') {
                    $ikomp_ori[] = $v; 
                }
            }
            $tes='';
            foreach($ikomp_ori as $value) {
                foreach($value as $k=>$v) {
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vfungsi from plc2.plc2_upb_prioritas_komposisi_ori where ikomposisi_id ={$v}";
                    $query = $this->db_plc0->query($sql);
                    $raw_id ='';
                    $ijumlah='';
                    $vsatuan='';
                    $ibobot='';
                    $vketerangan='';
                    if ($query->num_rows() > 0) {
                            $result = $query->result_array();
                            foreach($result as $row) {
                                $raw_id = $row['raw_id'];
                                $ijumlah=$row['ijumlah'];
                                $vsatuan=$row['vsatuan'];
                                $ibobot=$row['ibobot'];
                                $vketerangan=$row['vfungsi'];                                   
                            }
                    }
                    $kor['ireq_id']=$ireq_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vketerangan'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ireq_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }
        
        // copy Komposisi UPB ke Komposisi Originator
        function copyKomp_view() {
            $ireq_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ireq_id=$ireq_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ireq_id=$ireq_id and a.ldeleted ='0' ";         
        
            $rupa = $this->db_plc0->query($qupa);
            $rupb = $this->db_plc0->query($qupb)->row_array();
            
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            return $.ajax({
                                url: $("#"+form_id).attr("action"),
                                type: $("#"+form_id).attr("method"),
                                data: $("#"+form_id).serialize(),
                                success: function(data) {
                                    var o = $.parseJSON(data);
                                    var last_id = o.last_id;
                                    var company_id = 3;
                                    var group_id = o.group_id;
                                    var modul_id = o.modul_id;
                                    var foreign_id = "";
                                    var header = "Info";
                                    var info = "Info";
                                    var url = "'.base_url().'processor/plc/v3/permintaan/sample";                             
                                    if(o.status == true) {
                                        
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                $("div#form_upb_daftar").html(data);
                                            });
                                             
                                        
                                    }
                                        _custom_alert("Copy data berhasil ! ",header,info,"grid_upb_daftar", 1, 20000);
                                        reload_grid("grid_upb_daftar");
                                }
                                
                             })
                         }
                     </script>';
            
            
            $echo .= '<h1>Copy Komposisi UPB ke Komposisi Originator</h1><br />';
            $echo .= '<form id="form_v3_permintaan_sample_copyKomp" action="'.base_url().'processor/plc/v3/permintaan/sample?action=copyKomp_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ireq_id" value="'.$this->input->get('upb_id').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
                            ';  
                         if ($rupa->num_rows() > 0) {
                            $result = $rupa->result_array();
                            $i=1;
                            foreach($result as $row) {
                                    $echo .='<input type="checkbox" name="ikomp[]" value="'.$row['ikomposisi_id'] .'">
                                    <label for="">'.$row['vnama'].'</label><br>
                                    ';
                                $i++;
                            }
                        }   
            
                $echo .='</td></tr></table>
                    </br>
            <button type="button" onclick="submit_ajax(\'form_v3_permintaan_sample_copyKomp\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyKomp_process() {
            $post = $this->input->post();
            $ireq_id =$post['ireq_id'];
            $modul_id =$post['modul_id'];
            $group_id =$post['group_id'];
            $ikomp = array();
            foreach($_POST as $k=>$v) {
                if ($k == 'ikomp') {
                    $ikomp[] = $v; 
                }
            }
            $tes='';
            foreach($ikomp as $value) {
                foreach($value as $k=>$v) {
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vketerangan from plc2.plc2_upb_prioritas_komposisi where ikomposisi_id ={$v}";
                    $query = $this->db_plc0->query($sql);
                    $raw_id ='';
                    $ijumlah='';
                    $vsatuan='';
                    $ibobot='';
                    $vketerangan='';
                    if ($query->num_rows() > 0) {
                            $result = $query->result_array();
                            foreach($result as $row) {
                                $raw_id = $row['raw_id'];
                                $ijumlah=$row['ijumlah'];
                                $vsatuan=$row['vsatuan'];
                                $ibobot=$row['ibobot'];
                                $vketerangan=$row['vketerangan'];                                   
                            }
                    }
                    $kor['ireq_id']=$ireq_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vfungsi'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi_ori', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ireq_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }

        function listBox_v3_permintaan_sample_imonth ($value) {
            return 'Semester '.$value;
        }

        // function searchBox_v3_permintaan_sample_imonth ($field, $id) {
        //     $echo = '<select class="required choose" id="'.$id.'" name="'.$id.'">';
        //     $echo .= '<option value="">--Pilih--</option>';
        //     for($i=1; $i<=2; $i++) {
        //         $echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
        //     }
        //     $echo .= '</select>';
        //     return $echo;
        // }

        // function searchBox_v3_permintaan_sample_iyear ($field, $id) {
        //     $thn_sekarang = date('Y');
        //     $mulai = $thn_sekarang-3; // dari -2 diganti -3
        //     $sampai = $thn_sekarang+7;
        //     $echo = '<select id="'.$id.'" class="required choose">';
        //     $echo .= '<option value="">--Pilih--</option>';
        //     for($i=$mulai; $i<=$sampai; $i++) {
        //         $echo .= '<option value="'.$i.'">'.$i.'</option>';
        //     }
        //     $echo .= '</select>';
        //     return $echo;
        // }

        // function listBox_v3_permintaan_sample_iappdir($value) {
        //     if($value==0){$vstatus='Waiting for approval';}
        //     elseif($value==1){$vstatus='Rejected';}
        //     elseif($value==2){$vstatus='Approved';}
        //     return $vstatus;
        // }

        //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu

        function listBox_Action($row, $actions) {
            $peka = $row->ireq_id;
            $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
            $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

            if ( $getLastactivity == 0 ) { 
                    
            }else{
                if($isOpenEditing){

                }else{
                    unset($actions['edit']);    
                }
                
            }

            return $actions;
        }


        function insertBox_v3_permintaan_sample_form_detail($field,$id){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\'v3_permintaan_sample_form_detail\']").parent();
                $("label[for=\'v3_permintaan_sample_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/permintaan/sample?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: ireq_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_permintaan_sample_form_detail($field,$id,$value,$rowData){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\'v3_permintaan_sample_form_detail\']").parent();
                $("label[for=\'v3_permintaan_sample_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/permintaan/sample?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: ireq_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }


      
            //Ini Merupakan Standart Approve yang digunakan di erp
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
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_permintaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_permintaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_permintaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_permintaan_sample_approve" action="'.base_url().'processor/plc/v3_permintaan_sample?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_id" value="'.$this->input->get('ireq_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_permintaan_sample_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_id = $post['ireq_id'];
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $lvl = $post['lvl'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where('ireq_id', $ireq_id);
                $this->db->update('plc2.plc2_upb_request_sample', $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($ireq_id),$modul_id,$ireq_id,$activity['iM_activity'],$activity['iSort'],$vRemark,2);

                //insert ke penerimaan sample agar langsung masuk ke terima sample bb
                $dtRo = $this->db->get_where($this->_table, array($this->main_table_pk => $ireq_id))->row_array();
                $dtRoDetail = $this->db->get_where('plc2.plc2_upb_request_sample_detail', array('ireq_id' => $ireq_id, 'ldeleted' => 0))->result_array();
                if ($dtRo['ijenis_sample'] == 2 || $dtRo['ijenis_sample'] == 3){
                    $query = "SELECT MAX(iro_id) AS std FROM plc2.plc2_upb_ro";
                    $rs = $this->db->query($query)->row_array();
                    $nomor = intval($rs['std']) + 1;
                    $nomor = "RO".str_pad($nomor, 7, "0", STR_PAD_LEFT);

                    $insRO['vro_nomor']     = $nomor;
                    $insRO['ipo_id']        = 0;
                    $insRO['iclose_po']     = 1;
                    $insRO['iapprove']      = 2;
                    $insRO['trequest']      = date('Y-m-d H:i:s');
                    $insRO['vnip_pur']      = $cNip;
                    $insRO['tapp_pur']      = date('Y-m-d H:i:s');
                    $insRO['iapppr']        = 2;
                    $insRO['cnip']          = $cNip;
                    $insRO['istatus']       = 0;
                    $insRO['ldeleted']      = 0;
                    $insRO['isOldVersion']  = 0;
                    $insRO['iCompanyId']    = 0;
                    $insRO['iSubmit']       = 1;
                    $insRO['iHide']         = 1;
                    $this->db->insert('plc2.plc2_upb_ro', $insRO);
                    $roID = $this->db->insert_id();

                    foreach ($dtRoDetail as $drd) {
                        $raw_id = $drd['raw_id'];
                        $dtRaw = $this->db->get_where('plc2.plc2_raw_material', array('raw_id' => $raw_id))->row_array();
 
                        $roDetail['iro_id']         = $roID;
                        $roDetail['ipo_id']         = 0;
                        $roDetail['vnama_produk']   = (!empty($dtRaw))?$dtRaw['vnama']:'';
                        $roDetail['imanufacture_id']= 0;
                        $roDetail['iupb_id']        = 0;
                        $roDetail['ireq_id']        = $ireq_id;
                        $roDetail['vbatch_no']      = '-';
                        $roDetail['vanalisa_nomor'] = '-';
                        $roDetail['isupplier_id']   = 0;
                        $roDetail['raw_id']         = $raw_id;
                        $roDetail['ijumlah']        = $drd['ijumlah'];
                        $roDetail['vsatuan']        = $drd['vsatuan'];
                        $roDetail['plc2_master_satuan_id'] = $drd['plc2_master_satuan_id'];
                        $this->db->insert('plc2.plc2_upb_ro_detail', $roDetail);

                    }
                }


                $cek_upb= 'select * from plc2.plc2_upb_request_sample a where a.ireq_id="'.$ireq_id.'"';
		        $dcek_upb = $this->db_plc0->query($cek_upb)->row_array();
                if ($dcek_upb['iTujuan_req']==1) {
    				$tipe=1;
                }else if( $dcek_upb['iTujuan_req']==2 ){
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
                                                and f.iNextReqSample=1
                                                and f.iFinishRegSample=0
                                                and fp.iupb_id="'.$id_Upb.'"
                                                order by f.iFormula DESC limit 1';
                    $dFormula = $this->db->query($cek_fromPD)->row_array();	

                    if (!empty($dFormula)) {
                        $this->db->where('iFormula', $dFormula['iFormula']);
                        $this->db->update('pddetail.formula', array('iFinishRegSample'=>1));											
                    }										

                    

                }else if( $dcek_upb['iTujuan_req']==3 ){


                }else{
                    // tujuan 4 , reSample
                    $id_Upb=$dcek_upb['iupb_id'];
                    if($dcek_upb['iTujuan_req']==4){
                        /*tujuan re-sample*/
                        $cek_fromPD='select f.iFormula 
                                    from pddetail.formula_process fp 
                                    join pddetail.formula f on f.iFormula_process=fp.iFormula_process
                                    where fp.lDeleted=0
                                    and f.lDeleted=0
                                    #and f.iBackSample=1
                                    and fp.iupb_id="'.$id_Upb.'" ';
                        $dFormula = $this->db->query($cek_fromPD)->result_array();	

                        if (!empty($dFormula)) {
                            foreach ($dFormula as $forfor) {
                                
                                $this->db->where('iFormula', $forfor['iFormula']);
                                $this->db->update('pddetail.formula', array('iBackSample'=>0));											
                            }
                                
                        }
                    }

                }
            

    
                $data['status']  = true;
                $data['last_id'] = $post['ireq_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
            //Ini Merupakan Standart Confirm yang digunakan di erp
            function confirm_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_permintaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_permintaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_permintaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_permintaan_sample_confirm" action="'.base_url().'processor/plc/v3_permintaan_sample?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_id" value="'.$this->input->get('ireq_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_permintaan_sample_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_id = $post['ireq_id'];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where('ireq_id', $ireq_id);
                $this->db->update('plc2.plc2_upb_request_sample', $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($ireq_id),$modul_id,$ireq_id,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                
                $data['status']  = true;
                $data['last_id'] = $post['ireq_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v3_permintaan_sample_remark").val();
                                if (remark=="") {
                                    alert("Remark tidak boleh kosong ");
                                    return
                                }
    
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_permintaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_permintaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_permintaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_permintaan_sample_reject" action="'.base_url().'processor/plc/v3_permintaan_sample?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_id" value="'.$this->input->get('ireq_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_permintaan_sample_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_permintaan_sample_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_id = $post['ireq_id'];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 1);
                $this->db->where('ireq_id', $ireq_id);
                $this->db->update('plc2.plc2_upb_request_sample', $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($ireq_id),$modul_id,$ireq_id,$activity['iM_activity'],$activity['iSort'],$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['ireq_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {  
        $user = $this->auth_localnon->user();
        $query = "select max(ireq_id) as std from plc2.plc2_upb_request_sample";
        $rs = $this->db_plc0->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "L".str_pad($nomor, 7, "0", STR_PAD_LEFT);
        
        $skrg = date('Y-m-d H:i:s');
        unset($postData['ireqdet_id']);
        unset($postData['detrawid']);
        unset($postData['detjumlah']);
        unset($postData['detsatuan']);
        unset($postData['detspesifikasi']);
        $postData['cnip'] = $user->gNIP;
        $postData['tupdate'] = $skrg;
        $postData['vreq_nomor'] = $nomor;
        $postData['trequest'] = $postData['trequest'].' 00:00:00';
        // $postData['trequest'] = to_mysql($post['trequest']);

        if ($postData['iTujuan_req']==1) {
            $tipe=1;
        }else if($postData['iTujuan_req']==2){
            $tipe=2;
        }else{
            $tipe=3;
        }

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } 
        else{
            $postData['iSubmit']=1;
        //  $this->lib_flow->insert_logs($_GET['modul_id'],$postData['iupb_id'],1,0,$tipe);
        } 
        return $postData;

    }
    function before_update_processor($row, $postData) { //print_r($postData);exit();
        $user = $this->auth_localnon->user();
        $skrg = date('Y-m-d H:i:s');
        unset($postData['ireqdet_id']);
        unset($postData['detrawid']);
        unset($postData['detjumlah']);
        unset($postData['detsatuan']);
        unset($postData['detspesifikasi']);
        $postData['cnip'] = $user->gNIP;
        $postData['tupdate'] = $skrg;
        $postData['trequest'] = $postData['trequest'].' 00:00:00';

        $req_id=$postData['v3_permintaan_sample_ireq_id'] ;
        if ($postData['iTujuan_req']==1) {
            $tipe=1;
        }else if($postData['iTujuan_req']==2){
            $tipe=2;
        }else{
            $tipe=3;
        }

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } 
        else{
            $cek_upb= 'select * from plc2.plc2_upb_request_sample a where a.ireq_id="'.$req_id.'"';
            $dcek_upb = $this->db_plc0->query($cek_upb)->row_array();

            if ($dcek_upb['iSubmit']!=1) {
        //      $this->lib_flow->insert_logs($_GET['modul_id'],$postData['sample_permintaan_sample_iupb_id'],1,0,$tipe);
            }
            $postData['iSubmit']=1;
            
        } 


        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $modul_id = $this->modul_id;
        $post = $this->input->post();
        $ireqdet_id = $post['ireqdet_id'];
        $detrawid = $post['detrawid'];
        $detsatuan = $post['detsatuan'];
        $detspesifikasi = $post['detspesifikasi'];
        $detjumlah = $post['detjumlah'];
        foreach($ireqdet_id as $k => $v) {
            if(empty($v)) {
                if(!empty($detrawid[$k])) {
                    $idet['ireq_id'] = $id;
                    $idet['raw_id'] = $detrawid[$k];
                    $idet['ijumlah'] = $detjumlah[$k];
                    $idet['plc2_master_satuan_id'] = $detsatuan[$k];
                    $idet['tspecification'] = $detspesifikasi[$k];
                    $this->db->insert('plc2.plc2_upb_request_sample_detail', $idet);
                }                       
            }
        }  

        if ($postData['iSubmit'] == 1){
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,1,1);
        }
        
    }

    function after_update_processor($fields, $id, $postData) { 
        //Example After Update
        $modul_id = $this->modul_id;
        $post = $this->input->post();
        $ireqdet_id = $post['ireqdet_id'];
        $detrawid = $post['detrawid'];
        $detsatuan = $post['detsatuan'];
        $detspesifikasi = $post['detspesifikasi'];
        $detjumlah = $post['detjumlah'];
        $eRows = $this->db->get_where('plc2.plc2_upb_request_sample_detail', array('ireq_id'=>$id, 'ldeleted'=>0))->result_array();
        foreach($eRows as $k => $v) {
            if(in_array($v['ireqdet_id'], $ireqdet_id)) {
                $this->db->where('ireqdet_id', $v['ireqdet_id']);
                $key = array_search($v['ireqdet_id'], $ireqdet_id);
                $this->db->update('plc2.plc2_upb_request_sample_detail', array('raw_id'=>$detrawid[$key],'ijumlah'=>$detjumlah[$key],'plc2_master_satuan_id'=>$detsatuan[$key],'tspecification'=>$detspesifikasi[$key]));
            }
            else {
                $this->db->where('ireqdet_id', $v['ireqdet_id']);
                $this->db->update('plc2.plc2_upb_request_sample_detail', array('ldeleted'=>1));
            }
        }
        foreach($ireqdet_id as $k => $v) {
            if(empty($v)) {
                if(!empty($detrawid[$k])) {
                    $idet['ireq_id'] = $id;
                    $idet['raw_id'] = $detrawid[$k];
                    $idet['ijumlah'] = $detjumlah[$k];
                    $idet['plc2_master_satuan_id'] = $detsatuan[$k];
                    $idet['tspecification'] = $detspesifikasi[$k];
                    $this->db->insert('plc2.plc2_upb_request_sample_detail', $idet);
                }                       
            }
        }  

        if ($postData['iSubmit'] == 1){
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,1,1);
        }

    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_permintaan_sample_frame" id="v3_permintaan_sample_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_permintaan_sample\', \' '.base_url().'processor/plc/v3_permintaan_sample?draft=true \',this,true )"  id="button_save_draft_v3_permintaan_sample"  class="ui-button-text icon-save" >Save As Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_permintaan_sample\', \' '.base_url().'processor/plc/v3_permintaan_sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_v3_permintaan_sample"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id); 
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor)  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData['ireq_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_permintaan_sample_frame" id="v3_permintaan_sample_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_permintaan_sample\', \' '.base_url().'processor/plc/v3_permintaan_sample?draft=true \',this,true )"  id="button_update_draft_v3_permintaan_sample"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_permintaan_sample\', \' '.base_url().'processor/plc/v3_permintaan_sample?draft=true \',this,true )"  id="button_update_draft_v3_permintaan_sample"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_permintaan_sample\', \' '.base_url().'processor/plc/v3_permintaan_sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_v3_permintaan_sample"  class="ui-button-text icon-save" >Update &amp; Submit</button>';



                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_permintaan_sample?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&ireq_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_permintaan_sample"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_permintaan_sample?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&ireq_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_permintaan_sample"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_permintaan_sample?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&ireq_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_permintaan_sample"  class="ui-button-text icon-save" >Confirm</button>';

                        

                        switch ($act['iType']) {
                            case '1':
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                            case '2':
                                # Approval
                                if($getLastStatusApprove){
                                    $sButton .= $approve.$reject;
                                }else{
                                    $sButton .= 'Last Activity Reject';
                                }
                                
                                break;
                            case '3':
                                # Confirmation
                                if($getLastStatusApprove){
                                    $sButton .= $confirm;
                                }else{
                                    $sButton .= 'Last Activity Reject';
                                }
                                
                                break;
                            default:
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                        }
                        $arrNipAssign = explode(',',$act['vNip_assigned'] );
                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_plc->upbTeam($peka);

                        if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                            
                            /*// jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){*/
                                //get manager from Team ID
                                $magrAndCief = $this->lib_plc->managerAndChiefIn($this->teamID);
                                
                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;" title="'.$arrmgrAndCief.'">You\'re not Authorized to Approve 2</span>';
                                    }
                                }

/*                            }else{
                                $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            }*/


                            

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized 1</span>';
                            
                        }
                    }
                }


                $buttons['update'] = $sButton;        
                
            

            
        }
        
        return $buttons;
    }

    

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db_plc0->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);
    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

    private function ViewUPB ($id=0){
        $upb = $this->db->get_where('plc2.plc2_upb_request_sample', array('ireq_id'=>$id, 'ldeleted'=>0))->result_array();
        $arrUPB = array();
        foreach ($upb as $u) {
            array_push($arrUPB, $u['iupb_id']);
        }
        return $arrUPB;
    }

}
