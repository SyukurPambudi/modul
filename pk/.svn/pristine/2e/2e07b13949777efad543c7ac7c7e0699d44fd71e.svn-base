<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance_busdev_22 extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->user = $this->auth->user();
        $this->load->library('calc_bd2');
		//$this->load->model('details_busdev');
    }
    function index($action = '') {
    	$iparameter_id=$this->input->get('iparameter_id');
        $ssid=$this->input->get('ssid');
    	$imaster_id=$this->input->get('id');
        if(!empty($ssid)){
            switch ($action) {
                case "view":
                    echo $this->renderfunc_po($imaster_id,$iparameter_id,$ssid);
                    break;
                default:
                    echo $this->renderfunc_po($imaster_id,$iparameter_id,$ssid);
                    break;
            }
        }else{
            switch ($action) {
                case "view":
                    echo $this->renderfunc($imaster_id,$iparameter_id);
                    break;
                default:
                    echo $this->renderfunc($imaster_id,$iparameter_id);
                    break;
            }
        }

    }
    public function renderfunc($imaster_id,$iparameter_id){
        $q="select * from pk.pk_parameter where ldeleted=0 and iparameter_id=$iparameter_id limit 1";
        $st=$this->db_erp_pk->query($q)->row_array();
        if(method_exists($this, $st['vFunction'])){
            $func=$st['vFunction'];
            return $this->$func($imaster_id);
        }else{
            return "NOT FOUND FUNCTION";
        }
    }

     public function BD2_1($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $itim = $dmas['iteam_id'];
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];

        $sql='SELECT u.tinfo_paten, u.`iupb_id`, m.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = '.$itim.'
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  


        $sql_iGroup_produk='SELECT COUNT(DISTINCT(u.`iGroup_produk`)) as iGroup_produk FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = '.$itim.'
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  
        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/bd2/details_bd2_1',$data,true);
        return $view;
    }

    public function BD2_2($imaster_id){

       $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];

        $itim = $dmas['iteam_id'];

        $sql='SELECT ut.vteam ,u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = "'.$itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  


        $sql_iGroup_produk='SELECT COUNT(DISTINCT(u.iteammarketing_id)) as iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = "'.$itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"
            and u.iteammarketing_id in (29,8)
            ';  

        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/bd2/details_bd2_2',$data,true);
        return $view;
    }


    public function BD2_3($imaster_id){

       $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $itim = $dmas['iteam_id'];
        $tgl1=$dmas['tgl1'];


        $sql='SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`  
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = "'.$itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'" 
            '; 

        $sql_iGroup_produk='SELECT COUNT(u.`iupb_id`) As t_upb2 FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = "'.$itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'"
            AND ua.`tupdate` <= "'.$tgl2.'"
            ';

        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/bd2/details_bd2_3',$data,true);
        return $view;
    }


    public function BD2_4($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev,d.vNama_Group from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'" 
                #Tanggal Prareg not null
                and a.tsubmit_prareg is not null
                #Tanggal Approve BDM not NUll
                and c.tappbusdev is not null
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.tsubmit_prareg >= "'.$dm['tgl1'].'"
                and a.tsubmit_prareg <= "'.$dm['tgl2'].'"
                group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_4',$data,true);
        return $view;
    }
    public function BD2_5($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev,kat.vkategori,a.ikategori_id,app.tupdate 
                from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" and app.vmodule="AppUPB-DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 and kat.ldeleted=0
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'"  
                #Tanggal Prareg not null 
                and a.tsubmit_prareg is not null 
                #Tanggal Approve BDM not NUll 
                and c.tappbusdev is not null 
                #Tanggal app dir not null 
                and a.iappdireksi = 2 and app.tupdate is not null 
                #Kategori UPB A
                and a.ikategori_id=10
                #periode tanggal 
                and app.tupdate >= "'.$dm['tgl1'].'" 
                and app.tupdate <= "'.$dm['tgl2'].'" 
                group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_5',$data,true);
        return $view;
    }
    public function BD2_6($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.tsubmit_prareg,a.ttarget_hpr,kat.vkategori
                from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'" 
                #Tanggal Prareg not null 
                and a.tsubmit_prareg is not null 
                #Tanggal Approve BDM not NUll 
                and c.tappbusdev is not null 
                #Tanggal HPR Not NULl 
                and a.ttarget_hpr is not null 
                #Kategori UPB A
                and a.ikategori_id=10
                #Tanggal app dir not null 
                and a.iappdireksi = 2 and app.tupdate is not null 
                #periode tanggal prareg 
                and a.ttarget_hpr >= "'.$dm['tgl1'].'" 
                and a.ttarget_hpr <= "'.$dm['tgl2'].'" 
                group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_6',$data,true);
        return $view;
    }
    public function BD2_7($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.tregistrasi,a.ttarget_hpr,kat.vkategori 
                from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'" 
                #Tanggal HPR Not NULl 
                and a.ttarget_hpr is not null 
                #Tanggal Registrasi Not Null
                and a.tregistrasi is not null
                #Kategori UPB A 
                and a.ikategori_id=10 
                #Tanggal app dir not null 
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg 
                and a.tregistrasi >= "'.$dm['tgl1'].'" 
                and a.tregistrasi <= "'.$dm['tgl2'].'" 
                group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_7',$data,true);
        return $view;
    } 
    public function BD2_8($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select 
                    #group distinct karena hanya mengambil jumlah group produk 
                    #count(distinct(a.iGroup_produk)) jum
                    a.dinput_applet,a.*,d.vNama_Group,kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal Applet Not NULl 
                    and a.dinput_applet is not null 
                    #Kategori UPB A 
                    and a.ikategori_id=10 
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.dinput_applet >= "'.$dm['tgl1'].'" 
                    and a.dinput_applet <= "'.$dm['tgl2'].'"  
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_8',$data,true);
        return $view;
    }
    public function BD2_9($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select 
                    #group distinct karena hanya mengambil jumlah group produk 
                    #count(distinct(a.iGroup_produk)) jum
                    a.dinput_applet,a.*,d.vNama_Group,kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal Applet Not NULl 
                    and a.dinput_applet is not null 
                    #Kategori UPB B 
                    and a.ikategori_id=11 
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.dinput_applet >= "'.$dm['tgl1'].'" 
                    and a.dinput_applet <= "'.$dm['tgl2'].'"  
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_9',$data,true);
        return $view;
    }

    public function BD2_10($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.dinput_applet,a.tregistrasi,kat.vkategori 
                from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'" 
                #Tanggal Applet Not NULl 
                and a.dinput_applet is not null 
                #Tanggal Registrasi Not Null
                and a.tregistrasi is not null
                #Kategori UPB A 
                and a.ikategori_id=10 
                #Tanggal app dir not null 
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg 
                and a.dinput_applet >= "'.$dm['tgl1'].'" 
                and a.dinput_applet <= "'.$dm['tgl2'].'" 
                group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_10',$data,true);
        return $view;
    }  
    public function BD2_11($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.dinput_applet, 
                    #Filter Dokumen Applet Dsubmit Not NUll and Last Update
                    (select dap.dsubmit_dok from plc2.applet_dokumen dap where dap.lDeleted=0 and dap.dsubmit_dok is not null and dap.iupb_id=a.iupb_id order by dap.dsubmit_dok DESC limit 1) as dsubmit_dok,kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    join plc2.applet_dokumen d on d.iupb_id=a.iupb_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 #and d.lDeleted=0
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal HPR Not NULl 
                    and a.dinput_applet is not null 
                    #Kategori UPB B 
                    and a.ikategori_id=11 
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg 
                    and a.dinput_applet >= "'.$dm['tgl1'].'" 
                    and a.dinput_applet <= "'.$dm['tgl2'].'"
                    group by a.iupb_id
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/details_bd2_11',$data,true);
        return $view;
    } 
    public function BD2_13($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $data['datamaster']=$dm;
        $sql_par = 'SELECT cc.*,i.tReceived,ma.vtarget_kunjungan
                    FROM kartu_call.call_card cc 
                    JOIN gps_msg.inbox i on i.ID=cc.igpsm_id 
                    JOIN kartu_call.master_target_kunjungan ma on ma.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.lDeleted = 0 
                    AND cc.itarget_kunjungan_id = 5  
                    AND cc.vNIP LIKE "%'.$this->user->gNIP.'%"
                    AND i.tReceived >= "'.$dm['tgl1'].'" 
                    AND i.tReceived <= "'.$dm['tgl2'].'"
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $view=$this->load->view('busdev/detail_perform/details_bd2_13',$data,true);
        return $view;
    } 

    public function getmasterdata($imaster_id){
        $sql="select * from pk.pk_master ma where ma.idmaster_id=".$imaster_id." and ma.ldeleted=0 LIMIT 1";
        $data=$this->db->query($sql)->row_array();
        return $data;
    }
    
    public function itim($nip){
        $itim=0;
        $sqltim='select a.iteam_id,a.* 
                from plc2.plc2_upb_team a 
                where a.ldeleted=0 
                and a.iteam_id in(4,5,22) 
                and  a.vnip="'.$nip.'"'; 
        $dTim = $this->db->query($sqltim)->row_array();
        if(!empty($dTim)){
            $itim=$dTim['iteam_id'];
        }
        return $itim;
    }

    public function getDetMaster($imaster_id){
        $tq="select * from pk.pk_master mas where mas.ldeleted=0 and mas.idmaster_id=$imaster_id";
        $qmas=$this->db_erp_pk->query($tq)->row_array();
        return $qmas;

        
        
       
    }

	public function output(){
		$this->index($this->input->get('action'));
	}

}

