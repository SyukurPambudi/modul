<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Yandi.Prabowo
 * Date: 12/18/2015
 * Time: 4:48 PM
 */
class ganttchart_byupb extends MX_Controller{
    public $arr_url;
    private $url;
    function __construct()    {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->arr_url['base'] = 'processor';
        $this->arr_url['parent']='plc';
        $this->arr_url['name']='ganttchart_byupb';

        $this->url = 'ganttchart_byupb';

        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->user = $this->auth->user();
        $this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
        $action = $this->input->get('action');

        $grid = new Grid;
        $grid->setTitle('Gantt Chart');
        $grid->setTable('plc2.plc2_upb');
        $grid->setUrl($this->arr_url['name']);
        $grid->addList('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ikategoriupb_id','ttanggal', 'istatus_launching');
        $grid->addFields('vupb_nomor','vgenerik','chart');

        $grid->setLabel('vupb_nomor', 'No. UPB');
        $grid->setLabel('vupb_nama', 'Nama Usulan');
        $grid->setLabel('ttanggal', 'Tanggal UPB');
        $grid->setLabel('vgenerik', 'Nama Generik');
        $grid->setLabel('iteambusdev_id', 'Team Busdev');
        $grid->setLabel('iteampd_id', 'Team PD');
        $grid->setLabel('iteamqa_id', 'Team QA');
        $grid->setLabel('iteamqc_id', 'Team QC');
        $grid->setLabel('iteammarketing_id', 'Team Marketing');
        $grid->setLabel('ikategoriupb_id', 'Kategori UPB');
        //$grid->setLabel('chart', 'Chart');
        $grid->setLabel('istatus_launching', 'Status Launching');

        $grid->setRequired('vupb_nomor');
        $grid->setSearch('vupb_nomor','vgenerik','istatus_launching');
        $grid->setSortBy('vupb_nomor');
        $grid->setSortOrder('desc'); //sort ordernya

        $grid->setAlign('vupb_nomor', 'center');
        $grid->setAlign('ikategoriupb_id', 'center');
        $grid->setAlign('ttanggal', 'center');

        $grid->setWidth('vupb_nomor', '100');
        $grid->setWidth('ikategoriupb_id', '100');
        $grid->setWidth('ibe', '100');
        $grid->setWidth('iteampd_id', '150');
        $grid->setWidth('vupb_nama', '250');
        $grid->setWidth('vgenerik', '250');
        $grid->setWidth('ttanggal', '100');

        $grid->setRelation('ikategoriupb_id','plc2.plc2_upb_master_kategori_upb','ikategori_id','vkategori','upb_kat','inner',array('ldeleted'=>0),array('upb_kat'=>'asc'));
        $grid->setRelation('ikategori_id','hrd.mnf_kategori','ikategori_id','vkategori','mnf_kat','inner',array('ldeleted'=>0),array('mnf_kat'=>'asc'));
        $grid->setRelation('isediaan_id','hrd.mnf_sediaan','isediaan_id','vsediaan','','inner',array('ldeleted'=>0),array('vsediaan'=>'asc'));
        $grid->setRelation('itipe_id','plc2.plc2_biz_process_type','idplc2_biz_process_type','vName','nama_type','inner',array('isDeleted'=>'0'),array('idplc2_biz_process_type'=>'asc'));
        $grid->setRelation('iteambusdev_id','plc2.plc2_upb_team','iteam_id','vteam','vteambd','inner',array('ldeleted'=>0),array('iteam_id'=>'asc'));

        $grid->changeFieldType('istatus_launching','combobox','',array(''=>'--Select--',0=>'On Progress', 1=>'Batal',2=>'Launching'));

        $grid->setQuery('plc2.plc2_upb.ldeleted', 0);

        $grid->setGridView('grid');

        switch ($action) {
            case 'json':
                $grid->getJsonData();
                break;
            case 'index':
                echo $this->getHome();
                break;
            case 'view':
                $grid->render_form($this->input->get('id'), true);
                break;
            case 'create':
                $grid->render_form();
                break;
            case 'getData':
                echo $this->getData('vupb_nomor');
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
            case 'updateBox_ganttchart_byupb_view':
                $field = $this->input->post('field');
                $id = $this->input->post('id');
                $value = $this->input->post('value');
                $rowdata = $this->input->post('rowdata');
                $html = $this->updateBox_ganttchart_byupb_view_ajax($field, $id, $value, $rowdata);
                echo $html;
                break;
            default:
                $grid->render_grid();
                break;
        }
    }
    function manipulate_update_button($button) {
        if( $this->input->get('action')=='view') {
            unset($button['update']);
        }
        return $button;
    }
    public function updateBox_ganttchart_byupb_chart($field, $id, $value, $rowdata)  {
        if ($this->input->get('action') == 'view') {
            $data['iupb_id'] = $rowdata['iupb_id'];
            $data['data_legend'] = include 'array_legend_data.php';
            print_r($data);
            
            $o= '<div id="ganttchart_byupb_chart_view">Please wait...</div>';

            $url = base_url().'processor/plc/ganttchart/byupb?action=updateBox_ganttchart_byupb_view';

            $o.= '<script type="text/javascript">
                $(".rows_label[for=ganttchart_byupb_chart]").remove();
                $("#ganttchart_byupb_chart_view").parent().closest(".rows_input").css("margin-left","0px");
				 $(document).ready(function() {
				 	var url = "'.$url.'";
				 	var field = "'.$field.'";
				 	var id = "'.$id.'";
				 	var value = "'.$value.'";
				 	var rowdata = new Array();
				 	rowdata = '.json_encode( $rowdata ).';
				 	$.ajax({
				 		url:url,
				 		type:"post",
				 		data:{field:field, id:id, value:value, rowdata:rowdata},
				 		success:function(data) {
                               //$("#ganttchart_byupb_chart_view").html( data );
                               my_window = window.open("target", "_blank");
                               my_window.document.write(data);
                               if (window.focus)
                                    my_window.focus();


				 		}
				 	});
				 });

				 </script>';
            return $o;

        }
    }

    function updateBox_ganttchart_byupb_view_ajax($field, $id, $value, $rowdata){
        $data['iupb_id'] = $rowdata['iupb_id'];
        //$data['data_legend'] = include 'array_legend_data.php';
        $o ="";
        $o.=  $this->load->view('gantt',$data,TRUE);
        return $o;

    }

    function output(){
        $this->index($this->input->get('action'));
    }

}
