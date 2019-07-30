<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_terima_sample_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb_ro_detail';
        $this->main_table_pk='irodet_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.plc2_upb_ro_detail';
        $this->_table2 = 'plc2.plc2_upb_request_sample';
        $this->_table3 = 'plc2.plc2_upb';
        $this->_table4 = 'plc2.plc2_upb_ro';
        $this->_table5 = 'plc2.plc2_raw_material';
        $this->_table6 = 'hrd.employee';
        $this->_table7 = 'plc2.plc2_upb_po';

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Bahan Baku Terima Sample');       
        $grid->setTable($this->_table);     
        $grid->setUrl('v3_terima_sample_bb');
        $grid->addList('plc2_upb_ro.vro_nomor','plc2_upb_request_sample.vreq_nomor','plc2_upb_request_sample.iTujuan_req','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama');
        $grid->setJoinTable($this->_table2, $this->_table2.'.ireq_id = '.$this->_table.'.ireq_id', 'inner');
        $grid->setJoinTable($this->_table4, $this->_table4.'.iro_id = '.$this->_table.'.iro_id', 'inner');
        $grid->setJoinTable($this->_table3, $this->_table3.'.iupb_id = '.$this->_table2.'.iupb_id', 'inner');
        $grid->setJoinTable($this->_table5, $this->_table5.'.raw_id = '.$this->_table.'.raw_id', 'inner');
        $grid->setJoinTable($this->_table7, $this->_table4.'.ipo_id = '.$this->_table7.'.ipo_id', 'left');
        $grid->setSortBy('plc2_upb_ro.vro_nomor');
        $grid->setSortOrder('desc');       
        $grid->setGroupBy('irodet_id'); 
        $grid->setSearch('plc2_upb_ro.vro_nomor','plc2_upb_request_sample.vreq_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama');

        $grid->setWidth('plc2_upb.vupb_nama', 300);
        $grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
        $grid->setAlign('plc2_upb.vupb_nama', 'left');


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

                    $sqlFields = 'SELECT * FROM plc3.m_modul_fileds a WHERE a.lDeleted = 0 AND  a.iM_modul= ? ORDER BY a.iSort ASC';
                    $dFields = $this->db->query($sqlFields, array($this->iModul_id))->result_array(); 

                    $hate_emel = "";

                    if($get['formaction']=='update'){
                            $aidi = $get['id'];
                    }else{
                            $aidi = 0;
                    }

                    $getLastactivity = $this->lib_plc->get_current_module_activities($this->modul_id,$aidi);
                    $iSort = (count($getLastactivity)>0)?$getLastactivity[0]['iSort']:0;

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

                            $controller = 'v3_terima_sample_bb';
                            $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                            //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                            $data_field['field']= $form_field['vNama_field'] ;

                            $data_field['act']= $get['act'] ;
                            $data_field['hasTeam']= $this->team ;
                            $data_field['hasTeamID']= $this->teamID ;
                            $data_field['isAdmin']= $this->isAdmin ;

                            /*untuk keperluad file upload*/
                            if($form_field['iM_jenis_field'] == 7){
                                $data_field['tabel_file'] = $form_field['vTabel_file'] ;
                                $data_field['tabel_file_pk']= $this->main_table_pk;
                                $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                                $path = 'files/plc/bahan_kemas/bahan_kemas_primer';
                                $createname_space = 'v3_terima_sample_bb';
                                $tempat = 'bahan_kemas_primer';
                                $FOLDER_APP = 'plc';

                                $data_field['path'] = $path;
                                $data_field['FOLDER_APP'] = $FOLDER_APP;
                                $data_field['createname_space'] = $createname_space;
                                $data_field['tempat'] = $tempat;
                            }
                            /*untuk keperluad file upload*/


                            if($get['formaction']=='update'){
                                $id = $get['id'];

                                // $sqlGetMainvalue= 'SELECT * FROM plc2.'.$this->main_table.' WHERE ldeleted = 0 AND '.$this->main_table_pk.' = '.$id.'   '; 
                                $sqlGetMainvalue = 'SELECT rd.*, rs.*, ro.*, u.vupb_nomor, u.vupb_nama, r.vraw, r.vnama, st.vNmSatuan AS vsatuan, sd.ijumlah AS ijumlah_req
                                                    FROM plc2.plc2_upb_ro_detail rd
                                                    JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id
                                                    JOIN plc2.plc2_upb_request_sample_detail sd ON rs.ireq_id = sd.ireq_id AND sd.raw_id = rd.raw_id
                                                    JOIN plc2.plc2_upb_ro ro ON rd.iro_id = ro.iro_id
                                                    JOIN plc2.plc2_upb u ON rs.iupb_id = u.iupb_id
                                                    JOIN plc2.plc2_raw_material r ON rd.raw_id = r.raw_id
                                                    LEFT JOIN plc2.plc2_master_satuan st ON rd.plc2_master_satuan_id = st.plc2_master_satuan_id
                                                    WHERE sd.ldeleted = 0 AND rd.irodet_id = '.$id;
                                $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                                switch ($form_field['vNama_field']) {
                                    case 'ipo_id':
                                        $sql = 'SELECT vpo_nomor AS changed FROM plc2.plc2_upb_po WHERE ipo_id = ? ';
                                        break;
                                    case 'imanufacture_id':
                                        $sql = 'SELECT vnmmanufacture AS changed FROM hrd.mnf_manufacturer WHERE imanufacture_id = ? ';
                                        break;
                                    case 'raw_id':
                                        $sql = 'SELECT vnama AS changed FROM plc2.plc2_raw_material WHERE raw_id = ? ';
                                        break;
                                    case 'ireq_id':
                                        $sql = 'SELECT vreq_nomor AS changed FROM plc2.plc2_upb_request_sample WHERE ireq_id = ? AND ldeleted = 0';
                                        break;
                                    case 'iro_id':
                                        $sql = 'SELECT vro_nomor AS changed FROM plc2.plc2_upb_ro WHERE iro_id = ?';
                                        break;
                                    case 'iupb_id':
                                        $sql = 'SELECT CONCAT (u.vupb_nomor, " - ", u.vupb_nama) AS changed FROM plc2.plc2_upb_request_sample s JOIN plc2.plc2_upb u ON s.iupb_id = u.iupb_id WHERE s.ldeleted = 0 AND u.ldeleted = 0 AND s.ireq_id = '.$dataHead['ireq_id'];
                                        break;
                                    default:
                                        $sql = '';
                                        break;
                                }

                                if (strlen($sql) > 0){
                                    $dataChanged = $this->db->query($sql, array($dataHead[$form_field['vNama_field']]))->row_array();
                                    $dataHead[$form_field['vNama_field']] = (count($dataChanged) > 0)?$dataChanged['changed']:'-';
                                }

                                $getLastactivity = $this->lib_plc->get_current_module_activities($this->modul_id,$dataHead['irodet_id']);
                                $iSort = (count($getLastactivity)>0)?$getLastactivity[0]['iSort']:0;
                                
                                $dataHead['team'] = $this->team;
                                $dataHead['iSort'] = $iSort;
                                $data_field['dataHead']= $dataHead;
                                $data_field['main_table_pk']= $this->main_table_pk;
                                $data_field['pk_id'] = $get['id'];

                                switch ($iSort) {
                                    case 1:
                                        $arrField = array('iUjiMikro_bb','irodet_id','ijenis_mikro','vwadah','vrec_jum_pd','vrec_nip_pd','trec_date_pd');
                                        $data_field['form_field']['iRead_only_form'] = (in_array($form_field['vNama_field'], $arrField))?0:1;
                                        $data_field['form_field']['field_required'] = (in_array($form_field['vNama_field'], $arrField))?1:0;
                                        break;
                                    case 2:
                                        $arrField = array('vrec_jum_qc','vrec_nip_qc','trec_date_qc');
                                        $data_field['form_field']['iRead_only_form'] = (in_array($form_field['vNama_field'], $arrField))?0:1;
                                        $data_field['form_field']['field_required'] = (in_array($form_field['vNama_field'], $arrField))?1:0;
                                        break;
                                    case 3:
                                        $arrField = array('vrec_jum_qa','vrec_nip_qa','vrec_nip_qc','trec_date_qa');
                                        $data_field['form_field']['iRead_only_form'] = (in_array($form_field['vNama_field'], $arrField))?0:1;
                                        $data_field['form_field']['field_required'] = (in_array($form_field['vNama_field'], $arrField))?1:0;
                                        break;
                                    
                                    default:
                                        $data_field['form_field']['iRead_only_form'] = 1;
                                        $data_field['form_field']['field_required'] = 0;
                                        break;
                                }
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $mydivid=$this->user->gDivId; 
                                    $sqlEdit = str_replace('$div$', $mydivid, $form_field['vSource_input_edit']);
                                    switch ($form_field['vNama_field']) {
                                        case 'vrec_nip_pd':
                                            $sqlEdit = str_replace('$nipsel$', $dataHead['vrec_nip_pd'], $sqlEdit);
                                            break;
                                        case 'vrec_nip_qc':
                                            $sqlEdit = str_replace('$nipsel$', $dataHead['vrec_nip_qc'], $sqlEdit);
                                            break;
                                        case 'vrec_nip_qa':
                                            $sqlEdit = str_replace('$nipsel$', $dataHead['vrec_nip_qa'], $sqlEdit);
                                            break;
                                    }
                                    $data_field['vSource_input']=  $sqlEdit;
                                }else{
                                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                                }

                                if ($form_field['iRequired']==1) { 
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }
                                $data_field['iModul_id'] = $this->iModul_id;
                                $data_field['modul_id'] = $this->modul_id;
                                

                                $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);    
                            }else{
                                if ($form_field['iRequired']==1) { 
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }
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
                echo $grid->saved_form();
                break;

            case 'update':
                $grid->render_form($this->input->get('id'));
                break;
        
            case 'updateproses':
                echo $grid->updated_form();
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
            case 'cekjnsbk':
                $id=$this->input->post('id');
                $sql='SELECT mbk.itipe_bk AS idtipe_bk FROM plc2.plc2_master_jenis_bk mbk WHERE mbk.ldeleted=0 AND mbk.ijenis_bk_id = ?';
                $dt=$this->db->query($sql, array($id))->row_array();
                $data['id']=$dt['idtipe_bk'];
                $data['value']=$id;
                echo json_encode($data);
                break;
            case 'load_detail':
                $this->load_detail();
                break;

            default:
                    $grid->render_grid();
                    break;
        }
    }

        function load_detail(){
            $ipo_id = $this->input->post('ipo_id');
            $iModul_id = $this->input->post('iModul_id'); 

            $sql = "SELECT vFile_detail FROM plc3.m_modul_fileds WHERE iM_modul = ? AND lDeleted = 0 AND vNama_field = 'detail_sample' ";
            $field = $this->db->query($sql, array($iModul_id))->row_array();
            $value = "Value Not Found";

            if (count($field) > 0){
                $sqlDetail = "SELECT 0 AS irodet_id, 0 AS iro_id, d.ipo_id, d.ireq_id, r.vreq_nomor, d.raw_id, m.vnama, d.ijumlah, 0 AS vrec_jum_pr, d.vsatuan, d.imanufacture_id
                            FROM plc2.plc2_upb_po_detail d 
                            JOIN plc2.plc2_upb_po p ON d.ipo_id = p.ipo_id
                            JOIN plc2.plc2_upb_request_sample r ON d.ireq_id = r.ireq_id
                            JOIN plc2.plc2_raw_material m ON d.raw_id = m.raw_id
                            WHERE d.ipo_id = ?";
                $rows = $this->db->query($sqlDetail, array($ipo_id))->result_array();
                $data['rows'] = $rows;
                $value = $this->load->view('partial/modul/penerimaan_sample_detail', $data, TRUE);
            }

            echo $value;
        }

        // copy Komposisi Originator ke Komposisi UPB
        function copyOri_view() {
            $ipo_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ipo_id=$ipo_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi_ori a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ipo_id=$ipo_id and a.ldeleted ='0' ";         
        
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
                                    var url = "'.base_url().'processor/plc/v3/terima/sample/bb";                             
                                    if(o.status == true) {
                                        //alert($ipo_id);
                                        $("#alert_dialog_form").dialog("close");
                                        $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_upb_daftar").html(data);
                                        });
                                        // $.get(url+"processor/plc/v3/terima/sample/bb?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
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
            $echo .= '<form id="form_v3_terima_sample_bb_copyOri" action="'.base_url().'processor/plc/v3/terima/sample/bb?action=copyOri_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ipo_id" value="'.$this->input->get('upb_id').'" />
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
            <button type="button" onclick="submit_ajax(\'form_v3_terima_sample_bb_copyOri\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyOri_process() {
            $team=$this->auth_localnon->my_teams(TRUE);
            $post = $this->input->post();
            $ipo_id =$post['ipo_id'];
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
                    $kor['ipo_id']=$ipo_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vketerangan'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ipo_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }
        
        // copy Komposisi UPB ke Komposisi Originator
        function copyKomp_view() {
            $ipo_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ipo_id=$ipo_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ipo_id=$ipo_id and a.ldeleted ='0' ";         
        
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
                                    var url = "'.base_url().'processor/plc/v3/terima/sample/bb";                             
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
            $echo .= '<form id="form_v3_terima_sample_bb_copyKomp" action="'.base_url().'processor/plc/v3/terima/sample/bb?action=copyKomp_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ipo_id" value="'.$this->input->get('upb_id').'" />
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
            <button type="button" onclick="submit_ajax(\'form_v3_terima_sample_bb_copyKomp\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyKomp_process() {
            $post = $this->input->post();
            $ipo_id =$post['ipo_id'];
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
                    $kor['ipo_id']=$ipo_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vfungsi'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi_ori', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ipo_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }

        function listBox_v3_terima_sample_bb_iapppr($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function listBox_v3_terima_sample_bb_plc2_upb_request_sample_iTujuan_req($value) {
            if ($value <> ""){
                if ($value == 1){
                    $ret='Sample';
                }else if ($value == 2){
                    $ret='Pilot I';
                }else if ($value == 3){
                    $ret='Pilot II';
                }else if ($value == 4){
                    $ret='Re-Sample';
                }else{
                    $ret='-';   
                }
            }else{
                $ret='-';
            }
            return $ret;
        } 

        function listBox_Action($row, $actions) {
            $peka = $row->irodet_id;
            $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
            $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka); 

            if ( $getLastactivity == 0 ) { 
                    
            }else{
                if($isOpenEditing){

                }else{
                    unset($actions['edit']);  
                    unset($actions['delete']);  
                }
                
            }

            return $actions;
        }


        function insertBox_v3_terima_sample_bb_form_detail($field,$id){
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
                var sebelum = $("label[for=\'v3_terima_sample_bb_form_detail\']").parent();
                $("label[for=\'v3_terima_sample_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/terima/sample/bb?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: iro_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_terima_sample_bb_form_detail($field,$id,$value,$rowData){
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
                var sebelum = $("label[for=\'v3_terima_sample_bb_form_detail\']").parent();
                $("label[for=\'v3_terima_sample_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/terima/sample/bb?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: iro_id=0,
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
                                        var url = "'.base_url().'processor/plc/v3_terima_sample_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_terima_sample_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_terima_sample_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_terima_sample_bb_approve" action="'.base_url().'processor/plc/v3_terima_sample_bb?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_terima_sample_bb_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post           = $this->input->post();
                $cNip           = $this->user->gNIP;
                $vName          = $this->user->gName; 
                $pk             = $post[$this->main_table_pk];
                $vRemark        = $post['vRemark'];
                $modul_id       = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $lvl            = $post['lvl'];
                $now            = date('Y-m-d H:i:s');

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
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
                                        var url = "'.base_url().'processor/plc/v3_terima_sample_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_terima_sample_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_terima_sample_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_terima_sample_bb_confirm" action="'.base_url().'processor/plc/v3_terima_sample_bb?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_terima_sample_bb_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array(); 

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v3_terima_sample_bb_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_terima_sample_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_terima_sample_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_terima_sample_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_terima_sample_bb_reject" action="'.base_url().'processor/plc/v3_terima_sample_bb?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_terima_sample_bb_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_terima_sample_bb_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 1);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $query = "SELECT MAX(ro.iro_id) AS std FROM plc2.plc2_upb_ro ro";
        $rs = $this->db->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "RE".str_pad($nomor, 7, "0", STR_PAD_LEFT);
        $postData['vro_nomor'] = $nomor; 

        $postData['cnip'] = $this->user->gNIP;
        if($postData['isdraft'] == true){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        }  

        return $postData;
    }

    function before_update_processor($row, $postData) {
        $postData['tupdate'] = date('Y-m-d H:i:s');
        $postData['cnip'] = $this->user->gNIP;

        unset($postData['ipo_id']);
        unset($postData['imanufacture_id']);
        unset($postData['raw_id']);
        unset($postData['vnama_produk']);
        unset($postData['ijumlah_req']);
        unset($postData['ijumlah']);
        unset($postData['vsatuan']);
        unset($postData['ireq_id']);
        unset($postData['iro_id']);
        unset($postData['iupb_id']);

        $getLastactivity = $this->lib_plc->get_current_module_activities($this->modul_id,$postData['irodet_id']);
        $iSort = (count($getLastactivity)>0)?$getLastactivity[0]['iSort']:0;

        $arrTeam = explode(',', $this->team);
        if (in_array('PD', $arrTeam) && $iSort == 1){
            unset($postData['vrec_jum_qc']);
            unset($postData['vrec_nip_qc']);
            unset($postData['trec_date_qc']);

            unset($postData['vrec_jum_qa']);
            unset($postData['vrec_nip_qa']);
            unset($postData['trec_date_qa']);
        } else if (in_array('AD', $arrTeam) && $iSort == 2){
            unset($postData['iUjiMikro_bb']);
            unset($postData['irodet_jenis_id']);
            unset($postData['ijenis_mikro']);
            unset($postData['vwadah']);
            unset($postData['vrec_jum_pd']);
            unset($postData['vrec_nip_pd']);
            unset($postData['trec_date_pd']);
            
            unset($postData['vrec_jum_qa']);
            unset($postData['vrec_nip_qa']);
            unset($postData['trec_date_qa']);
        } else if (in_array('QA', $arrTeam) && $iSort == 3){
            unset($postData['iUjiMikro_bb']);
            unset($postData['irodet_jenis_id']);
            unset($postData['ijenis_mikro']);
            unset($postData['vwadah']);
            unset($postData['vrec_jum_pd']);
            unset($postData['vrec_nip_pd']);
            unset($postData['trec_date_pd']);

            unset($postData['vrec_jum_qc']);
            unset($postData['vrec_nip_qc']);
            unset($postData['trec_date_qc']);
        }
        
        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
       
    }

    function after_update_processor($fields, $id, $postData) {
        $post           = $this->input->post();
        $arrTeam        = explode(',', $this->team);
        $iUjiMikro_bb   = $postData['iUjiMikro_bb'];
        $irodet_id      = $postData['irodet_id'];
        $getLastactivity= $this->lib_plc->get_current_module_activities($this->modul_id,$postData['irodet_id']);
        $iSort          = (count($getLastactivity)>0)?$getLastactivity[0]['iSort']:0;
        $now            = date('Y-m-d H:i:s');
        $cNip           = $this->user->gNIP;

        if (in_array('PD', $arrTeam) && $iUjiMikro_bb == 1 && $iSort == 1){
            $this->db->where('irodet_id', $irodet_id);
            $this->db->update('plc2.plc2_upb_ro_detail_jenis', array('ldeleted'=>1,'dupdate'=>date('Y-m-d H:i:s'),'cupdate'=>$this->user->gNIP));

            $irodet_jenis_id = $post['irodet_jenis_id'];
            $ijenis_mikro = $post['ijenis_mikro'];

            foreach ($ijenis_mikro as $ijm) {
                $jenis['irodet_id'] = $irodet_id;
                $jenis['ijenis_mikro'] = $ijm;
                $jenis['ccreate'] = $this->user->gNIP;
                $jenis['dcreate'] = date('Y-m-d H:i:s');
                $jenis['ldeleted'] = 0;
                $this->db->insert('plc2.plc2_upb_ro_detail_jenis', $jenis);
            }
        }

        $modul_id = $this->modul_id; 
        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
        $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);
        //print_r($activity);
        if (intval($activity['iSort']) == 2){
        
            

                $rodata = $this->db->get_where($this->_table, array($this->main_table_pk => $irodet_id))->row_array();

                //get upb_id
                /* $qiupb="SELECT DISTINCT(rs.iupb_id) 
                FROM plc2.plc2_upb_request_sample rs 
                WHERE rs.ireq_id IN (SELECT pod.ireq_id FROM plc2.plc2_upb_po_detail pod WHERE pod.ipo_id = ? )"; 
                $riu = $this->db->query($qiupb, array($rodata['ipo_id']))->result_array(); */

                $qiupb="SELECT DISTINCT(rs.iupb_id) 
                FROM plc2.plc2_upb_request_sample rs 
                WHERE rs.ireq_id IN ( ".$rodata['ireq_id']." )"; 
                $riu = $this->db->query($qiupb)->result_array();
                //echo $ $riu;
                


                //print_r($riu);
                //exit;
                $iupb_id_to_next = '';
                foreach($riu as $xx){
                    $iupb_id = $xx['iupb_id'];
                    $iupb_id_to_next = $iupb_id;
                }

                /* syaratnya masuk skala trial terbaru
                        1. confirm study literatur PD
                        2. confirm study literatur AD
                        3. terima input sample originator oleh QA
                        4. terima bb oleh PD

                    */
                    $iupb_id = $iupb_id_to_next;

                    $stPD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            a.iM_modul in (3)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $stAD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (4)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $inpQA = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (11)
                            and b.iSort = 4
                            and c.iupb_id="'.$iupb_id.'" ';


                    $cPD = $this->db->query($stPD)->num_rows();
                    $cAD = $this->db->query($stAD)->num_rows();
                    $cQA = $this->db->query($inpQA)->num_rows();
                    

                    if( $cPD > 0 and $cAD > 0 and $cQA > 0 ){
                         $cek_upb = "SELECT * FROM plc2.plc2_upb_request_sample purs 
                            WHERE purs.ldeleted = 0 AND purs.iTujuan_req in(1,4)
                            AND purs.iupb_id IN (".$iupb_id_to_next.") ";
                        $cek = $this->db->query($cek_upb)->result_array();

                        //jika ada tujuan sample
                        if (count($cek) > 0){
                            $cek_form = "SELECT * FROM pddetail.formula_process fp WHERE fp.lDeleted = 0 AND fp.iMaster_flow = 1 AND fp.iupb_id IN (".$iupb_id_to_next.")";
                            $dcek = $this->db->query($cek_form)->result_array();

                            if (count($dcek) == 0){             
                                //Insert Formula Proses
                                $sqlto_Back     = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES (?, ?, ?, ?)"; 
                                $this->db->query($sqlto_Back, array($iupb_id_to_next, '1', $cNip, $now));
                                $iFormula_process = $this->db->insert_id();

                                //Insert Formula Proses Detail
                                $pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES (?,?,'1','1',?,?,?)";
                                $this->db->query($pn, array($iFormula_process, $cNip, $now, $cNip, $now));

                                //Insert Formula Awal
                                $ver = 0;
                                $iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated) VALUES(?,?,?,?)';
                                $this->db->query($iFd, array($iFormula_process, $ver, $now, $cNip));
                            }else{
                                $sqliMutu = 'select count(*) as jum
                                from plc2.log_mutu a 
                                where a.lDeleted=0 
                                and a.iupb_id= "'.$iupb_id_to_next.'" 
                                and a.idprivi_modules=3560 
                                and a.iDone=0';
                                $dmutu = $this->db->query($sqliMutu)->row_array();

                                if($dmutu['jum'] > 0){
                                    //Insert Formula Proses
                                    $sqlto_Back     = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES (?, ?, ?, ?)"; 
                                    $this->db->query($sqlto_Back, array($iupb_id_to_next, '1', $cNip, $now));
                                    $iFormula_process = $this->db->insert_id();

                                    //Insert Formula Proses Detail
                                    $pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES (?,?,'1','1',?,?,?)";
                                    $this->db->query($pn, array($iFormula_process, $cNip, $now, $cNip, $now));

                                    //Insert Formula Awal
                                    $ver = 0;
                                    $iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated) VALUES(?,?,?,?)';
                                    $this->db->query($iFd, array($iFormula_process, $ver, $now, $cNip));


                                }

                            }

                            $cek_fromPD = 'SELECT f.iFormula FROM pddetail.formula_process fp 
                                            JOIN pddetail.formula f ON f.iFormula_process = fp.iFormula_process
                                            WHERE fp.lDeleted = 0 AND f.lDeleted = 0
                                                #and f.iBackSample=1
                                                AND fp.iupb_id = ? ';
                            $dFormula = $this->db_plc0->query($cek_fromPD, array($iupb_id_to_next))->result_array(); 

                            if (count($dFormula) > 0) {
                                foreach ($dFormula as $forfor) {
                                    $this->db->where('iFormula', $forfor['iFormula']);
                                    $this->db->update('pddetail.formula', array('iBackSample'=>0));                                            
                                }
                                    
                            }

                        }


                    }


               
        }else{
            //echo "masuk bawah";
        }
    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_terima_sample_bb_frame" id="v3_terima_sample_bb_frame" height="0" width="0"></iframe>';

        $sql = "SELECT a.* FROM plc3.m_modul m JOIN plc3.m_modul_activity a ON m.iM_modul = a.iM_modul WHERE idprivi_modules = ? AND m.lDeleted = 0 AND a.lDeleted = 0 ORDER BY a.iSort ASC LIMIT 1";
        $act = $this->db->query($sql, array($this->modul_id))->row_array();

        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_terima_sample_bb\', \' '.base_url().'processor/plc/v3_terima_sample_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_save_draft_v3_terima_sample_bb"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_terima_sample_bb\', \' '.base_url().'processor/plc/v3_terima_sample_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_save_submit_v3_terima_sample_bb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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
        $peka=$rowData[$this->main_table_pk];
        $iupb_id = 0;
        $iUjiMikro_bb = $rowData['iUjiMikro_bb'];

        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_terima_sample_bb_frame" id="v3_terima_sample_bb_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_terima_sample_bb\', \' '.base_url().'processor/plc/v3_terima_sample_bb?draft=true \',this,true )"  id="button_update_draft_v3_terima_sample_bb"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_terima_sample_bb\', \' '.base_url().'processor/plc/v3_terima_sample_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_terima_sample_bb"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_terima_sample_bb\', \' '.base_url().'processor/plc/v3_terima_sample_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_terima_sample_bb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_terima_sample_bb?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_terima_sample_bb"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_terima_sample_bb?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_terima_sample_bb"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_terima_sample_bb?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_terima_sample_bb"  class="ui-button-text icon-save" >Confirm</button>';

                        

                        switch ($act['iType']) {
                            case '1':
                                if ($act['iSort'] == 3 && $iUjiMikro_bb == 0){
                                    $sButton .= '<span style="color:red;">Tidak Memerlukan Uji Mikro BB</span>';
                                }else{
                                    $sButton .= $update;
                                }
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
                                $magrAndCief = $this->lib_plc->managerAndChief(20);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;" <th style="border: 1px solid #dddddd; width: 30%;">By</th>>You\'re not Authorized to Approve</span>';
                                    }
                                }

/*                            }else{
                                $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            }*/


                            

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                            
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
        // $upb = $this->db->get_where('plc2.'.$this->main_table, array($this->main_table_pk=>$id, 'ldeleted'=>0))->result_array();
        $sql = 'SELECT rs.* FROM plc2.plc2_upb_ro_detail rd JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id WHERE rd.irodet_id = ? ';
        $upb = $this->db->query($sql, array($id))->result_array();
        $arrUPB = array();
        foreach ($upb as $u) {
            if (isset($u['iupb_id'])){
                array_push($arrUPB, $u['iupb_id']);
            }
        }
        return $arrUPB;
    }

}
