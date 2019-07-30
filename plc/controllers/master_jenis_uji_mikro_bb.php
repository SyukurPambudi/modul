 
<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_jenis_uji_mikro_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Master Jenis Uji Mikro BB');
        $grid->setTable('plc2.plc2_master_jenis_uji_mikro');      
        $grid->setUrl('master_jenis_uji_mikro_bb');

        //List Table
        $grid->addList('vjenis_mikro','tdeskripsi','ldeleted'); 
        $grid->setSortBy('ijenis_mikro');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('vjenis_mikro','tdeskripsi','ldeleted'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('vjenis_mikro', '150');
        $grid->setAlign('vjenis_mikro', 'left');
        $grid->setLabel('vjenis_mikro','Jenis Uji Mikro BB ');
    
        $grid->setWidth('tdeskripsi', '200');
        $grid->setAlign('tdeskripsi', 'left');
        $grid->setLabel('tdeskripsi','Deskripsi ');

        $grid->setWidth('ldeleted', '100');
        $grid->setAlign('ldeleted', 'left');
        $grid->setLabel('ldeleted','Status ');
    
        // $grid->setQuery('ldeleted = 0 ', null); 

    //set search
        $grid->setSearch('vjenis_mikro');

        $grid->changeFieldType('ldeleted','combobox','',array(0=>'Aktif', 1=>'Tidak Aktif'));
        
    //set required
        $grid->setRequired('vjenis_mikro','tdeskripsi'); 
        $grid->setGridView('grid');


        switch ($action) {
            case 'json':
                    $grid->getJsonData();
                    break;
            case 'view':
                    $grid->render_form($this->input->get('id'), true);
                    break;

             case 'create':
                    $grid->render_form();
                    break;
             
                case 'createproses':
                    $post       = $this->input->post();
                    $jenis      = $post['vjenis_mikro'];
                    $cekJenis   = $this->db->get_where('plc2.plc2_master_jenis_uji_mikro', array('vjenis_mikro' => $jenis))->num_rows();

                    if ($cekJenis > 0){
                        $data['status'] = false;
                        $data['message'] = 'Jenis Uji "'.$jenis.'" sudah ada!';
                        echo json_encode($data);
                    } else {
                        echo $grid->saved_form();
                    }
                    break;
                  
           
            
            case 'update':
                    $grid->render_form($this->input->get('id'));
                    break;

        
            case 'updateproses':
                    $post   = $this->input->post();
                    $jenis  = $post['vjenis_mikro'];
                    $id     = $post['master_jenis_uji_mikro_bb_ijenis_mikro'];

                    $sqlCekJenis    = 'SELECT * FROM plc2.plc2_master_jenis_uji_mikro WHERE vjenis_mikro = ? AND ijenis_mikro <> ? ';
                    $cekJenis       = $this->db->query($sqlCekJenis, array($jenis, $id))->num_rows();

                    if ($cekJenis > 0){
                        $data['status'] = false;
                        $data['message'] = 'Jenis Uji "'.$jenis.'" sudah ada!';
                        echo json_encode($data);
                    } else {
                        echo $grid->updated_form();
                    }
                    break;
        
        
            case 'delete':
                    echo $grid->delete_row();
                    break; 

                case 'download':
                    $this->download($this->input->get('file'));
                    break;
            default:
                    $grid->render_grid();
                    break;
        }
    }


    function insertBox_master_jenis_uji_mikro_bb_vjenis_mikro($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_master_jenis_uji_mikro_bb_vjenis_mikro($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_master_jenis_uji_mikro_bb_tdeskripsi($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_master_jenis_uji_mikro_bb_tdeskripsi($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }

    function insertBox_master_jenis_uji_mikro_bb_ldeleted($field, $id) {
        $return  = '<select name="'.$field.'" id="'.$id.'">';
        $return .= '    <option value="0">Aktif</option>';
        $return .= '    <option value="1">Tidak Aktif</option>';
        $return .= '</select>';
        return $return;
    }
    
    function updateBox_master_jenis_uji_mikro_bb_ldeleted($field, $id, $value, $rowData) {
        $disabled = ($this->input->get('action') == 'view')?'disabled':'';
        $return  = '<select '.$disabled.' name="'.$field.'" id="'.$id.'">';
        $return .= '    <option '.($value==0?'selected':'').' value="0">Aktif</option>';
        $return .= '    <option '.($value==1?'selected':'').' value="1">Tidak Aktif</option>';
        $return .= '</select>';            
        return $return;
    }
    


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dcreate'] = date('Y-m-d H:i:s');
        $postData['ccreate']=$this->user->gNIP;
        $postData['vjenis_mikro'] = strtoupper($postData['vjenis_mikro']);
        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cupdate'] = $this->user->gNIP;
        $postData['vjenis_mikro'] = strtoupper($postData['vjenis_mikro']);
        return $postData; 
    }    

    function after_insert_processor($fields, $id, $postData) {
        //Example After Insert
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->dbset->query($sql);
        */
    }

    function after_update_processor($fields, $id, $postData) {
        //Example After Update
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->dbset->query($sql);
        */
    }

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/folder_app/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

}
