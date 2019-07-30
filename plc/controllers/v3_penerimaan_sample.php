<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_penerimaan_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb_ro';
        $this->main_table_pk='iro_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.plc2_upb_ro';
        $this->_table_po = 'plc2.plc2_upb_po';
        $this->_table_supplier = 'hrd.mnf_supplier';
        $this->_table_employee = 'hrd.employee';
        $this->_table_detail = 'plc2.plc2_upb_po_detail';

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Penerimaan Sample');       
        $grid->setTable($this->_table);     
        $grid->setUrl('v3_penerimaan_sample');
        $grid->addList('vro_nomor','plc2_upb_po.vpo_nomor','iclose_po','trequest','cnip','employee.vName');
        $grid->setJoinTable($this->_table_po, $this->_table_po.'.ipo_id = '.$this->_table.'.ipo_id', 'inner');
        $grid->setJoinTable($this->_table_supplier, $this->_table_supplier.'.isupplier_id = '.$this->_table_po.'.isupplier_id', 'left');
        $grid->setJoinTable($this->_table_employee, $this->_table_employee.'.cNip = '.$this->_table.'.cnip', 'left');
        $grid->setSortBy('iro_id');
        $grid->setSortOrder('desc');
        $grid->setSearch('vro_nomor','plc2_upb_po.vpo_nomor','trequest','cnip','employee.vName');

        $grid->setFormWidth('vpo_nomor', 50);
        $grid->setFormWidth('vro_nomor', 50);
        $grid->setFormWidth('trequest', 50);
        $grid->setFormWidth('cnip', 20);
        $grid->setFormWidth('employee.vName', 120);
        
        $grid->setLabel('cnip', 'NIP');
        $grid->setLabel('employee.vName', 'Nama');
        $grid->setLabel('vro_nomor', 'No. RO');
        $grid->setLabel('vpo_nomor', 'No. PO');
        $grid->setLabel('plc2_upb_po.vpo_nomor', 'No. PO');
        $grid->setLabel('iclose_po', 'Tutup PO');
        $grid->setLabel('trequest', 'Tanggal Terima');
        $grid->setLabel('isupplier_id','Supplier');
        $grid->setLabel('detail_batch','Detail Batch');     
        $grid->setLabel('detail_terima_sample','Detail Terima Sample');     
        $grid->setLabel('vnip_pur','Approval Purchasing');      
        $grid->setLabel('iapppr','Approval Purchasing');
    
        
        $grid->setQuery('plc2_upb_ro.ldeleted', 0);
        $grid->setQuery('plc2_upb_ro.iHide', 0);
        
        $grid->changeFieldType('iclose_po', 'combobox', '', array(''=>'--select--', 1=>'Ya', 0=>'Tidak'));

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

                            $controller = 'v3_penerimaan_sample';
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
                                $createname_space = 'v3_penerimaan_sample';
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

                                $sqlGetMainvalue= 'SELECT * FROM plc2.'.$this->main_table.' WHERE ldeleted = 0 AND '.$this->main_table_pk.' = '.$id.'   '; 
                                $dataHead = $this->db->query($sqlGetMainvalue)->row_array(); 

                                $data_field['dataHead']= $dataHead;
                                $data_field['main_table_pk']= $this->main_table_pk;
                                $data_field['pk_id'] = $get['id'];
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $sqlEdit = str_replace('$pkid$', $id, $form_field['vSource_input_edit']);
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
                $sqlDetail = "SELECT 0 AS irodet_id, 0 AS iro_id, d.ipo_id, d.ireq_id, r.vreq_nomor, d.raw_id, m.vnama, d.ijumlah, 0 AS vrec_jum_pr, d.vsatuan, d.imanufacture_id, s.vNmSatuan, d.plc2_master_satuan_id
                            FROM plc2.plc2_upb_po_detail d 
                            JOIN plc2.plc2_upb_po p ON d.ipo_id = p.ipo_id
                            JOIN plc2.plc2_upb_request_sample r ON d.ireq_id = r.ireq_id
                            JOIN plc2.plc2_raw_material m ON d.raw_id = m.raw_id
                            LEFT JOIN plc2.plc2_master_satuan s ON d.plc2_master_satuan_id = s.plc2_master_satuan_id
                            WHERE d.ipo_id = ? AND (s.ldeleted = 0 OR s.ldeleted IS NULL)";
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
                                    var url = "'.base_url().'processor/plc/v3/penerimaan/sample";                             
                                    if(o.status == true) {
                                        //alert($ipo_id);
                                        $("#alert_dialog_form").dialog("close");
                                        $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_upb_daftar").html(data);
                                        });
                                        // $.get(url+"processor/plc/v3/penerimaan/sample?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
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
            $echo .= '<form id="form_v3_penerimaan_sample_copyOri" action="'.base_url().'processor/plc/v3/penerimaan/sample?action=copyOri_process" method="post">';
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
            <button type="button" onclick="submit_ajax(\'form_v3_penerimaan_sample_copyOri\')">Simpan</button>';
                
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
                                    var url = "'.base_url().'processor/plc/v3/penerimaan/sample";                             
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
            $echo .= '<form id="form_v3_penerimaan_sample_copyKomp" action="'.base_url().'processor/plc/v3/penerimaan/sample?action=copyKomp_process" method="post">';
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
            <button type="button" onclick="submit_ajax(\'form_v3_penerimaan_sample_copyKomp\')">Simpan</button>';
                
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

        function listBox_v3_penerimaan_sample_iapppr($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function listBox_Action($row, $actions) {
            $peka = $row->iro_id;
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


        function insertBox_v3_penerimaan_sample_form_detail($field,$id){
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
                var sebelum = $("label[for=\'v3_penerimaan_sample_form_detail\']").parent();
                $("label[for=\'v3_penerimaan_sample_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/penerimaan/sample?action=getFormDetail&formaction=addnew&'.$g.'",
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

        function updateBox_v3_penerimaan_sample_form_detail($field,$id,$value,$rowData){
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
                var sebelum = $("label[for=\'v3_penerimaan_sample_form_detail\']").parent();
                $("label[for=\'v3_penerimaan_sample_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/penerimaan/sample?action=getFormDetail&formaction=update&'.$g.'",
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
                                        var url = "'.base_url().'processor/plc/v3_penerimaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_penerimaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_penerimaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_penerimaan_sample_approve" action="'.base_url().'processor/plc/v3_penerimaan_sample?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_penerimaan_sample_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName; 
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $lvl = $post['lvl'];

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
                                        var url = "'.base_url().'processor/plc/v3_penerimaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_penerimaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_penerimaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_penerimaan_sample_confirm" action="'.base_url().'processor/plc/v3_penerimaan_sample?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_penerimaan_sample_confirm\')">Confirm</button>';
                    
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
                                var remark = $("#v3_penerimaan_sample_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_penerimaan_sample";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_penerimaan_sample").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_penerimaan_sample");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_penerimaan_sample_reject" action="'.base_url().'processor/plc/v3_penerimaan_sample?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_penerimaan_sample_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_penerimaan_sample_reject\')">Reject</button>';
                    
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
        if($postData['isdraft'] == true && $postData['iclose_po'] == 1){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        }  

        return $postData;
    }

    function before_update_processor($row, $postData) { 
        $postData['tupdate'] = date('Y-m-d H:i:s');
        $postData['cnip'] = $this->user->gNIP;
        if($postData['isdraft'] == true && $postData['iclose_po'] == 1){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        } 
        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $post = $this->input->post(); 

        $ibatch_id = $post['ibatch_id'];
        $det_nobatch = $post['det_nobatch'];
        $detjumlah = $post['detjumlah'];
        $detsatuan = $post['detsatuan'];
        
        foreach ($ibatch_id as $bk => $bv) {
            if (empty($bv)){
                if (!empty($det_nobatch[$bk])){
                    $ibat['iro_id'] = $id;
                    $ibat['vbatch_nomor'] = $det_nobatch[$bk];
                    $ibat['iJumlah'] = $detjumlah[$bk];
                    $ibat['plc2_master_satuan_id'] = $detsatuan[$bk];
                    $ibat['cnip_insert'] = $this->user->gNIP;
                    $ibat['tinsert'] = date('Y-m-d H:i:s');
                    $ibat['ldeleted'] = 0;
                    $this->db->insert('plc2.plc2_upb_ro_batch',$ibat);
                }
            }
        }

        $irodet_id = $post['irodet_id'];
        $detpo_id = $post['detpo_id'];
        $detrawname = $post['detrawname'];
        $raw_id = $post['raw_id'];
        $rawname = $post['rawname'];
        $detjum_pr = $post['detjum_pr'];
        $imanufacture_id = $post['imanufacture_id'];
        $ireq_id = $post['ireq_id'];
        $ijumlah = $post['ijumlah'];
        $vsatuan = $post['vsatuan'];

        foreach($irodet_id as $dk => $dv) {
            if(empty($v)) {
                if(!empty($detrawname[$dk])) {
                    $det['iro_id']=$id;
                    $det['ipo_id']=$detpo_id[$dk];
                    $det['raw_id'] = $raw_id[$dk];
                    $det['ireq_id'] = $ireq_id[$dk];
                    $det['vnama_produk'] = $rawname[$dk];
                    $det['ijumlah'] = $ijumlah[$dk];
                    $det['vjumlah_po'] = $ijumlah[$dk];
                    $det['vrec_jum_pr'] = $detjum_pr[$dk];
                    $det['plc2_master_satuan_id'] = $vsatuan[$dk];
                    $det['imanufacture_id'] = $imanufacture_id[$dk];
                    $this->db->insert('plc2.plc2_upb_ro_detail', $det);
                }                       
            }
        }

        if ($postData['iSubmit'] == 1 && $postData['iclose_po'] == 1){
            $modul_id = $this->modul_id; 
            $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);
        }
    }

    function after_update_processor($fields, $id, $postData) {
        $post = $this->input->post();

        $ibatch_id = $post['ibatch_id'];
        $det_nobatch = $post['det_nobatch'];
        $detjumlah = $post['detjumlah'];
        $detsatuan = $post['detsatuan'];
        $batchRows = $this->db->get_where('plc2.plc2_upb_ro_batch', array('iro_id'=>$id, 'ldeleted' => 0))->result_array();
        foreach ($batchRows as $bk => $bv) {
            if(in_array($bv['ibatch_id'], $ibatch_id)) {
                $this->db->where('ibatch_id', $bv['ibatch_id']);
                $key = array_search($bv['ibatch_id'], $ibatch_id);
                $this->db->update('plc2.plc2_upb_ro_batch', array('vbatch_nomor'=>$det_nobatch[$key],'iJumlah'=>$detjumlah[$key],'plc2_master_satuan_id'=>$detsatuan[$key],'tupdate'=>date('Y-m-d H:i:s'),'cnip_update'=>$this->user->gNIP));
            } else {
                $this->db->where('ibatch_id', $bv['ibatch_id']);
                $this->db->update('plc2.plc2_upb_ro_batch', array('ldeleted'=>1,'tupdate'=>date('Y-m-d H:i:s'),'cnip_update'=>$this->user->gNIP));
            }
        }

        foreach ($ibatch_id as $bk => $bv) {
            if (empty($bv)){
                if (!empty($det_nobatch[$bk])){
                    $ibat['iro_id'] = $id;
                    $ibat['vbatch_nomor'] = $det_nobatch[$bk];
                    $ibat['iJumlah'] = $detjumlah[$bk];
                    $ibat['plc2_master_satuan_id'] = $detsatuan[$bk];
                    $ibat['cnip_insert'] = $this->user->gNIP;
                    $ibat['tinsert'] = date('Y-m-d H:i:s');
                    $ibat['ldeleted'] = 0;
                    $this->db->insert('plc2.plc2_upb_ro_batch',$ibat);
                }
            }
        }
        
        $irodet_id = $post['irodet_id'];
        $detpo_id = $post['detpo_id'];
        $detrawname = $post['detrawname'];
        $raw_id = $post['raw_id'];
        $rawname = $post['rawname'];
        $detjum_pr = $post['detjum_pr'];
        $imanufacture_id = $post['imanufacture_id'];
        $ireq_id = $post['ireq_id'];
        $ijumlah = $post['ijumlah'];
        $vsatuan = $post['vsatuan'];
        
        $detRows = $this->db->get_where('plc2.plc2_upb_ro_detail', array('iro_id'=>$id, 'ldeleted'=>0))->result_array();
        foreach($detRows as $dk => $dv) {
            if(in_array($dv['irodet_id'], $irodet_id)) {
                $this->db->where('irodet_id', $dv['irodet_id']);
                $key = array_search($dv['irodet_id'], $irodet_id);
                $this->db->update('plc2.plc2_upb_ro_detail', array('vrec_jum_pr'=>$detjum_pr[$key]));
            } else {
                $this->db->where('irodet_id', $dv['irodet_id']);
                $this->db->update('plc2.plc2_upb_ro_detail', array('ldeleted'=>1));
            }
        }

        foreach($irodet_id as $dk => $dv) {
            if(empty($dv)) {
                if(!empty($detrawname[$dk])) {
                    $det['iro_id']=$id;
                    $det['ipo_id']=$detpo_id[$dk];
                    $det['raw_id'] = $raw_id[$dk];
                    $det['ireq_id'] = $ireq_id[$dk];
                    $det['vnama_produk'] = $rawname[$dk];
                    $det['ijumlah'] = $ijumlah[$dk];
                    $det['vjumlah_po'] = $ijumlah[$dk];
                    $det['vrec_jum_pr'] = $detjum_pr[$dk];
                    $det['vsatuan'] = $vsatuan[$dk];
                    $det['imanufacture_id'] = $imanufacture_id[$dk];
                    $this->db->insert('plc2.plc2_upb_ro_detail', $det);
                }                       
            }
        }

        if ($postData['iSubmit'] == 1 && $postData['iclose_po'] == 1){
            $modul_id = $this->modul_id; 
            $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);
        }

    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_penerimaan_sample_frame" id="v3_penerimaan_sample_frame" height="0" width="0"></iframe>';

        $sql = "SELECT a.* FROM plc3.m_modul m JOIN plc3.m_modul_activity a ON m.iM_modul = a.iM_modul WHERE idprivi_modules = ? AND m.lDeleted = 0 AND a.lDeleted = 0 ORDER BY a.iSort ASC LIMIT 1";
        $act = $this->db->query($sql, array($this->modul_id))->row_array();

        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_penerimaan_sample\', \' '.base_url().'processor/plc/v3_penerimaan_sample?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_save_draft_v3_penerimaan_sample"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_penerimaan_sample\', \' '.base_url().'processor/plc/v3_penerimaan_sample?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_save_submit_v3_penerimaan_sample"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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

        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_penerimaan_sample_frame" id="v3_penerimaan_sample_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_penerimaan_sample\', \' '.base_url().'processor/plc/v3_penerimaan_sample?draft=true \',this,true )"  id="button_update_draft_v3_penerimaan_sample"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_penerimaan_sample\', \' '.base_url().'processor/plc/v3_penerimaan_sample?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_penerimaan_sample"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_penerimaan_sample\', \' '.base_url().'processor/plc/v3_penerimaan_sample?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_penerimaan_sample"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_penerimaan_sample?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_penerimaan_sample"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_penerimaan_sample?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_penerimaan_sample"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_penerimaan_sample?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_penerimaan_sample"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
        $sql = 'SELECT s.iupb_id FROM plc2.plc2_upb_ro_detail r JOIN plc2.plc2_upb_request_sample s ON r.ireq_id = s.ireq_id WHERE r.iro_id = ? AND r.ldeleted = 0 AND s.ldeleted = 0';
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
