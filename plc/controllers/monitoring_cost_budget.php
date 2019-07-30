<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitoring_cost_budget extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->dbset = $this->load->database('plc', true);
        $this->dbset2 = $this->load->database('hrd', true);
        $this->user = $this->auth->user();
    }
    function index($action = '') {
        //$action = $this->input->get('action');
        $action = $this->input->get('action') ? $this->input->get('action') : 'index'; 
        switch ($action) {
                case 'index':
                        echo $this->getHome();
                        break;
                case 'json':
                        $grid->getJsonData();
                        break;
                case 'view':
                        $grid->render_form($this->input->get('id'), true);
                        break;
                case 'create':
                        $grid->render_form();
                        break;
                case 'getdetail':
                        echo $this->getDetail();
                        break;
                case 'getheader':
                        echo $this->getHeader();
                        break;
                case 'printto':
                        echo $this->print_to();
                        break;
                case 'printdetail':
                        echo $this->printdetail();
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
                default:
                        $grid->render_grid();
                        break;
        }
    }

    function getHome(){
        $data['string']= 'string';
        //$data['datanya'] = $this->db_plc0->query($sql)->result_array();
        // $data['datanya'] = $this->dbset->query($sql)->result_array();
        return $this->load->view('monitoring_cost_budget',$data,TRUE);
    }

    public function getHeader(){
        $tglAwal = $_POST['tglAwal'];
        $tglAkhir = $_POST['tglAkhir'];
        $sql='select mp.iparameter_id, kp.vkategori_parameter, mp.vparameter ,ms.vNmSatuan,
                ( select if (mp.iparameter_id = 7,
                             ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as total
                    ,
                  ( select if (mp.iparameter_id = 7,
                             ( select Count(*) as troll from 
                  (select c.vupb_nomor 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                              join plc2_upb_date_sample  e on e.iReq_ori_id = d.ireq_ori_id                              
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and d.isent_status ="1"
                              ) as troll
                        )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                  (select  c.iupb_id,c.vupb_nomor,c.vupb_nama as nama_usulan, date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg as tanggal_prareg,c.iappbusdev_prareg , date (c.tappbusdev_prareg) as tanggal_approve
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.tsubmit_prareg is not null or c.tsubmit_prareg !="0000-00-00")
                              and c.iappbusdev_prareg ="2"
                              group by c.iupb_id,c.vupb_nomor,c.vupb_nama , date(a.tappbusdev )  , c.tsubmit_prareg ,c.iappbusdev_prareg , date (c.tappbusdev_prareg)
                              ) as troll
                        )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select Count(*) as troll from 
                  (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg as tanggal_prareg, date (c.tappbusdev_prareg) as tanggal_approve, date(c.tconfirm_dok) as tanggal_doc, datediff(c.tconfirm_dok,c.tsubmit_prareg) as jumlah_hari , 
                          (select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                 and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                       and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  
                                group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg , date (c.tappbusdev_prareg) , date(c.tconfirm_dok), datediff(c.tconfirm_dok,c.tsubmit_prareg)
                              ) as troll
                        )    
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select Count(*) as troll from 
                  (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, 
                              c.tsubmit_prareg as tanggal_prareg,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                              datediff(if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ),c.tsubmit_prareg) as jumlah_hari,
                              (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as hari_libur 
                              
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    group by  c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg ,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )
                              ) as troll
                        )   
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,
                    c.tTd_applet as tanggal_aplet,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                    datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as jumlah_hari,
                    (select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,
                    c.tTd_applet ,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )                         
                                ) as troll
                            )   
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,c.tTglTD_prareg as tgl_tamb_data,c.tTgl_SubDokTD_prareg as tanggal_sub_dokumen,datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) as jumlah_hari,(select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg) as hari_libur 

                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,c.tTglTD_prareg ,c.tTgl_SubDokTD_prareg                                           ) as troll
                            )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas ,c.tTd_applet as tanggal_aplet ,c.tterima_noreg
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                                                and c.tterima_noreg != "0000-00-00" 
                        and c.tterima_noreg is not null 
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev )  ,c.tTd_applet  ,c.tterima_noreg
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, e.tapp_memo as t_memo_direksi , c.ttarget_noreg as target_noreg,datediff(e.tapp_memo,c.ttarget_noreg) as jumlah_hari,(select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
                       group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ), e.tapp_memo  , c.ttarget_noreg
                                ) as troll
                            )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , e.istatus_launching
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and e.istatus_launching ="1"
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ) , e.istatus_launching
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih,q.iapprove_id
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                    and (year(a.t1stCreatedAt) - year(q.tupdate)  > 4 )
                             and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                        
                              group by p.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select  p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori
                      from 
                      plc2_upb p 
                      join plc2_upb_approve q on p.iupb_id=q.iupb_id
                      join plc2_upb_status_log a on a.idplc2_upb = p.iupb_id
                      join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                      join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                      join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                      join plc2_status e on a.idplc2_status = e.idplc2_status
                      join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                      join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                      join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                      where q.vtipe="DR" and q.iapprove="2"
                      and h.vkategori in ("Suplemen","OC","OC1","Obat Tradisional")
                      and g.tappbusdev >= "'.$tglAwal .'"
                      and g.tappbusdev <= "'.$tglAkhir.'"
                      and (if((h.vkategori="Suplemen"),(year(a.t1stCreatedAt) - year(q.tupdate) > 3 ),(year(a.t1stCreatedAt) - year(q.tupdate) > 2 ))) 
                      group by p.vupb_nomor
                      order by a.plc2_upb_status_log DESC
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as per
                    ,
                  ( select if (mp.iparameter_id = 7,
                             ( select sum(datediff(e.dTanggalKirimBD,d.trequest ) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                    join plc2_upb_date_sample e on e.iReq_ori_id = d.ireq_ori_id
                     where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                      
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                      and d.isent_status ="1"


                        )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select sum(datediff(c.tconfirm_dok,c.tsubmit_prareg ) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                     where 
                      a.iappbusdev = "2"
                     and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                      and c.iconfirm_dok="1"

                        )    
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select sum(datediff( if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )  ,c.tsubmit_prareg  ) ) as selisih 
                      from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                        )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select sum(datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                    and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")

                        )    
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select sum(datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                    and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                    and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")           

                        ) 
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select sum(datediff(e.tapp_memo,c.ttarget_noreg) )as selisih
                                                   from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
              

                        )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as hari
                    ,
                  ( select if (mp.iparameter_id = 7,
      ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between d.trequest and e.dTanggalKirimBD)) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                        join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                          join plc2_upb_date_sample e on e.iReq_ori_id = d.ireq_ori_id
                         where 
                          a.iappbusdev = "2"
                          and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                          
                          and a.tappbusdev >= "'.$tglAwal .'"
                          and a.tappbusdev <= "'.$tglAkhir.'"

    )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok)) as hari_libur
                        from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                  and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  

                )   
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select sum(  (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) ) as hari_libur
                        from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")

                )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet)) as hari_libur
                       from plc2_upb_prioritas a
                       join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                       join plc2_upb c on c.iupb_id = b.iupb_id
                        where 
                         a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                       and a.tappbusdev >= "'.$tglAwal .'"
                       and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")

                )    
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg)) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                         where 
                          a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                        and a.tappbusdev >= "'.$tglAwal .'"
                        and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")

                )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                         ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) ) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                        join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                         where 
                          a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                        and a.tappbusdev >= "'.$tglAwal .'"
                        and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")     

                        )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as hari_libur
                    
                    
                    
                   
                                                                                                    
                from plc2_upb_master_kategori_parameter kp 
          join plc2_upb_master_parameter mp on kp.ikat_parameter_id = mp.ikat_parameter_id
          join plc2_master_satuan ms on ms.plc2_master_satuan_id = mp.plc2_master_satuan_id
          where mp.iparameter_id > 6  and mp.iparameter_id < 18              ';
                

        //$data['datanya'] = $this->db_plc0->query($sql)->result_array();
         $data['tglAwal'] = $tglAwal;                
         $data['tglAkhir'] = $tglAkhir;                
         $data['datanya'] = $this->dbset->query($sql)->result_array();
        return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_tbody',$data,TRUE);
    }
    
    public function getDetail(){
        

        $parameter= $_POST['parameter'];
        $tglAwal = $_POST['tglAwal'];
        $tglAkhir = $_POST['tglAkhir'];
        $total = $_POST['total'];
        $per = $_POST['per'];
        $hari = $_POST['hari'];
        $hari_libur = $_POST['hari_libur'];
        $no = $_POST['no'];
        $uom = $_POST['uom'];

        $sql_header='select b.iparameter_id , a.vkategori_parameter as kategori , b.vparameter as kategori_parameter , b.vdescription as description,c.vNmSatuan
                    from plc2_upb_master_kategori_parameter a
                    join plc2_upb_master_parameter b on a.ikat_parameter_id = b.ikat_parameter_id
                    join plc2_master_satuan c on c.plc2_master_satuan_id = b.plc2_master_satuan_id
                    where b.iparameter_id ="'.$_POST['parameter'].'" ';
        // datatable 
        

        if ($no==1) {
                 $sql='select d.ireq_ori_id, e.iKirimID, c.vupb_nomor ,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , d.trequest as tgl_request , e.dTanggalKirimBD as tgl_kirim , datediff(e.dTanggalKirimBD,d.trequest) as jumlah_hari , 
                        (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between d.trequest and e.dTanggalKirimBD) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                                join plc2_upb_date_sample  e on e.iReq_ori_id = d.ireq_ori_id
                                 where 
                                  a.iappbusdev = "2"
                                    and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                    and a.tappbusdev >= "'.$tglAwal .'"
                                    and a.tappbusdev <= "'.$tglAkhir.'"
                                    and d.isent_status ="1"   ';    
          
           
        }else if ($no==2){

             $sql='select  c.iupb_id,c.vupb_nomor,c.vupb_nama as nama_usulan, date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg as tanggal_prareg,c.iappbusdev_prareg , date (c.tappbusdev_prareg) as tanggal_approve
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.tsubmit_prareg is not null or c.tsubmit_prareg !="0000-00-00")
                              and c.iappbusdev_prareg ="2"
                              group by c.iupb_id,c.vupb_nomor,c.vupb_nama , date(a.tappbusdev )  , c.tsubmit_prareg ,c.iappbusdev_prareg , date (c.tappbusdev_prareg)';    
           

        }else if ($no==3){
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg as tanggal_prareg, date (c.tappbusdev_prareg) as tanggal_approve, date(c.tconfirm_dok) as tanggal_doc, datediff(c.tconfirm_dok,c.tsubmit_prareg) as jumlah_hari , 
                          (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                  and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                  and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  
  group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg , date (c.tappbusdev_prareg) , date(c.tconfirm_dok), datediff(c.tconfirm_dok,c.tsubmit_prareg)  ';    
            
        }else if ($no==4){
            
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, 
                              c.tsubmit_prareg as tanggal_prareg,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                              datediff(if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ),c.tsubmit_prareg) as jumlah_hari,
                              (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as hari_libur 
                              
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    group by  c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg ,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )';    

        }else if ($no==5){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,
                    c.tTd_applet as tanggal_aplet,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                    datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as jumlah_hari,
                    (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,
                    c.tTd_applet ,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) ';    
        }else if ($no==6){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,c.tTglTD_prareg as tgl_tamb_data,c.tTgl_SubDokTD_prareg as tanggal_sub_dokumen,datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) as jumlah_hari,(select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg) as hari_libur 

                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,c.tTglTD_prareg ,c.tTgl_SubDokTD_prareg ';    
        }else if ($no==7){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas ,c.tTd_applet as tanggal_aplet ,c.tterima_noreg
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and c.tterima_noreg != "0000-00-00" 
                        and c.tterima_noreg is not null 
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev )  ,c.tTd_applet  ,c.tterima_noreg';    
        }else if ($no==8){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, e.tapp_memo as t_memo_direksi , c.ttarget_noreg as target_noreg,datediff(e.tapp_memo,c.ttarget_noreg) as jumlah_hari,(select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
                       group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ), e.tapp_memo  , c.ttarget_noreg ';    
        }else if ($no==9){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , e.istatus_launching
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and e.istatus_launching ="1"
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ) , e.istatus_launching';    
        }else if ($no==10){
                $sql='select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                              and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                              and (year(a.t1stCreatedAt) - year(q.tupdate)  > 4 )
                              group by p.vupb_nomor';
           
                   
        }else {
            //param 11
                $sql='select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                              and h.vkategori in ("Suplemen","OC","OC1","Obat Tradisional")
                             and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                          and (if((h.vkategori="Suplemen"),(year(a.t1stCreatedAt) - year(q.tupdate) > 3 ),(year(a.t1stCreatedAt) - year(q.tupdate) > 2 ))) 
                              group by p.vupb_nomor
                            ';    
        }
        $data['uom'] = $uom;
        $data['total'] = $total;
        $data['per'] = $per;
        $data['tglAwal'] = $_POST['tglAwal'];
        $data['tglAkhir'] = $_POST['tglAkhir'];
        $data['parameter'] = $parameter;
        $data['no'] = $no;
        $data['hari_libur'] = $hari_libur;
        $data['hari'] = $hari;
        $data['header'] = $this->dbset->query($sql_header)->row_array();
        $data['datanya'] = $this->dbset->query($sql)->result_array();
        
        if ($no==1) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail',$data,TRUE);    
        }else if($no==2) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_2',$data,TRUE);    
        }else if($no==3) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_3',$data,TRUE);    
        }else if($no==4) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_4',$data,TRUE);    
        }else if($no==5) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_5',$data,TRUE);    
        }else if($no==6) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_6',$data,TRUE);    
        }else if($no==7) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_7',$data,TRUE);    
        }else if($no==8) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_8',$data,TRUE);    
        }else if($no==9) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_9',$data,TRUE);    
        }else if($no==10) {
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_10',$data,TRUE);    
        }else {
          
            // param 11
            return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_11',$data,TRUE);    
        }
        

           

    }

    public function print_to(){
        $this->load->helper('xls');
        $this->load->helper('to_pdf');
        $tglAwal = $_GET['_tglAwal'];
        $tglAkhir = $_GET['_tglAkhir'];

        $sql='select mp.iparameter_id, kp.vkategori_parameter, mp.vparameter , ms.vNmSatuan,
                ( select if (mp.iparameter_id = 7,
                             ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                      and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as total
                    ,
                  ( select if (mp.iparameter_id = 7,
                             ( select Count(*) as troll from 
                  (select c.vupb_nomor 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                              join plc2_upb_date_sample  e on e.iReq_ori_id = d.ireq_ori_id                              
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and d.isent_status ="1"
                              ) as troll
                        )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                  (select  c.iupb_id,c.vupb_nomor,c.vupb_nama as nama_usulan, date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg as tanggal_prareg,c.iappbusdev_prareg , date (c.tappbusdev_prareg) as tanggal_approve
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.tsubmit_prareg is not null or c.tsubmit_prareg !="0000-00-00")
                              and c.iappbusdev_prareg ="2"
                              group by c.iupb_id,c.vupb_nomor,c.vupb_nama , date(a.tappbusdev )  , c.tsubmit_prareg ,c.iappbusdev_prareg , date (c.tappbusdev_prareg)
                              ) as troll
                        )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select Count(*) as troll from 
                  (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg as tanggal_prareg, date (c.tappbusdev_prareg) as tanggal_approve, date(c.tconfirm_dok) as tanggal_doc, datediff(c.tconfirm_dok,c.tsubmit_prareg) as jumlah_hari , 
                          (select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                 and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                       and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  
              group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg , date (c.tappbusdev_prareg) , date(c.tconfirm_dok), datediff(c.tconfirm_dok,c.tsubmit_prareg)
                              ) as troll
                        )    
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select Count(*) as troll from 
                  (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, 
                              c.tsubmit_prareg as tanggal_prareg,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                              datediff(if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ),c.tsubmit_prareg) as jumlah_hari,
                              (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as hari_libur 
                              
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    group by  c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg ,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )
                              ) as troll
                        )   
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,
                    c.tTd_applet as tanggal_aplet,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                    datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as jumlah_hari,
                    (select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,
                    c.tTd_applet ,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )                         
                                ) as troll
                            )   
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,c.tTglTD_prareg as tgl_tamb_data,c.tTgl_SubDokTD_prareg as tanggal_sub_dokumen,datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) as jumlah_hari,(select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg) as hari_libur 

                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,c.tTglTD_prareg ,c.tTgl_SubDokTD_prareg                                           ) as troll
                            )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas ,c.tTd_applet as tanggal_aplet ,c.tterima_noreg
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (c.tterima_noreg is not null or c.tterima_noreg !="0000-00-00")
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev )  ,c.tTd_applet  ,c.tterima_noreg
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, e.tapp_memo as t_memo_direksi , c.ttarget_noreg as target_noreg,datediff(e.tapp_memo,c.ttarget_noreg) as jumlah_hari,(select count(*) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
                       group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ), e.tapp_memo  , c.ttarget_noreg
                                ) as troll
                            )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , e.istatus_launching
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                              
                    and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and e.istatus_launching ="1"
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ) , e.istatus_launching
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih,q.iapprove_id
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                    and (year(a.t1stCreatedAt) - year(q.tupdate)  > 4 )
                             and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                        
                              group by p.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select  p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori
                      from 
                      plc2_upb p 
                      join plc2_upb_approve q on p.iupb_id=q.iupb_id
                      join plc2_upb_status_log a on a.idplc2_upb = p.iupb_id
                      join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                      join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                      join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                      join plc2_status e on a.idplc2_status = e.idplc2_status
                      join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                      join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                      join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                      where q.vtipe="DR" and q.iapprove="2"
                      and h.vkategori in ("Suplemen","OC","OC1","Obat Tradisional")
                      and g.tappbusdev >= "'.$tglAwal .'"
                      and g.tappbusdev <= "'.$tglAkhir.'"
                      and (if((h.vkategori="Suplemen"),(year(a.t1stCreatedAt) - year(q.tupdate) > 3 ),(year(a.t1stCreatedAt) - year(q.tupdate) > 2 ))) 
                      group by p.vupb_nomor
                      order by a.plc2_upb_status_log DESC
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as per
                    ,
                  ( select if (mp.iparameter_id = 7,
                             ( select sum(datediff(e.dTanggalKirimBD,d.trequest ) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                    join plc2_upb_date_sample e on e.iReq_ori_id = d.ireq_ori_id
                     where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                      
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                      and d.isent_status ="1"


                        )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select sum(datediff(c.tconfirm_dok,c.tsubmit_prareg ) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                     where 
                      a.iappbusdev = "2"
                     and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                      and c.iconfirm_dok="1"

                        )    
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select sum(datediff( if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )  ,c.tsubmit_prareg  ) ) as selisih 
                      from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                        )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select sum(datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                    and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")

                        )    
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select sum(datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) ) as selisih
                    from plc2_upb_prioritas a
                    join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                    join plc2_upb c on c.iupb_id = b.iupb_id
                    where 
                      a.iappbusdev = "2"
                      and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                      and a.tappbusdev >= "'.$tglAwal .'"
                      and a.tappbusdev <= "'.$tglAkhir.'"
                    and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                    and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")           

                        ) 
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                        ( select sum(datediff(e.tapp_memo,c.ttarget_noreg) )as selisih
                                                   from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
              

                        )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as hari
                    ,
                  ( select if (mp.iparameter_id = 7,
      ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between d.trequest and e.dTanggalKirimBD)) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                        join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                          join plc2_upb_date_sample e on e.iReq_ori_id = d.ireq_ori_id
                         where 
                          a.iappbusdev = "2"
                          and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                          
                          and a.tappbusdev >= "'.$tglAwal .'"
                          and a.tappbusdev <= "'.$tglAkhir.'"

    )  
                        ,
                if (mp.iparameter_id = 8,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )   
                                         ,
                  if (mp.iparameter_id = 9,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok)) as hari_libur
                        from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                  and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  

                )   
                                        ,
                  if (mp.iparameter_id = 10,
                        ( select sum(  (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) ) as hari_libur
                        from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                              and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")

                )  
                                        ,
                  if (mp.iparameter_id = 11,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet)) as hari_libur
                       from plc2_upb_prioritas a
                       join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                       join plc2_upb c on c.iupb_id = b.iupb_id
                        where 
                         a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                       and a.tappbusdev >= "'.$tglAwal .'"
                       and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")

                )    
                                        ,
                                        
                  if (mp.iparameter_id = 12,
                        ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg)) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                         where 
                          a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                        and a.tappbusdev >= "'.$tglAwal .'"
                        and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")

                )  
                         ,
                                        
                  if (mp.iparameter_id = 13,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 14,
                         ( select sum((select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) ) as hari_libur
                        from plc2_upb_prioritas a
                        join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                        join plc2_upb c on c.iupb_id = b.iupb_id
                        join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                         where 
                          a.iappbusdev = "2"
                        and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                        and a.tappbusdev >= "'.$tglAwal .'"
                        and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")     

                        )  
                           ,
                                        
                  if (mp.iparameter_id = 15,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )  
                             ,
                                        
                  if (mp.iparameter_id = 16,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )
                     ,
                                        
                  if (mp.iparameter_id = 17,
                        ( select Count(*) as troll from 
                    (select c.vupb_nomor 
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                              where 
                                  a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                and a.tappbusdev >= "'.$tglAwal .'"
                                and a.tappbusdev <= "'.$tglAkhir.'"
                                group by c.vupb_nomor
                                ) as troll
                            )    
                                        ,""
                                        
                  )                                        
                           )
                           )
                           )
                  )
                  )
                           )
                           )
                           )
                           )
                           )
                    ) as hari_libur
                    
                from plc2_upb_master_kategori_parameter kp 
          join plc2_upb_master_parameter mp on kp.ikat_parameter_id = mp.ikat_parameter_id
          join plc2_master_satuan ms on ms.plc2_master_satuan_id = mp.plc2_master_satuan_id
          where mp.iparameter_id > 6  and mp.iparameter_id < 18              ';
                
        
                

            if(strtolower($_GET['_ext']) == 'xls') {
                $data['tglAwal'] = $tglAwal;                
                $data['tglAkhir'] = $tglAkhir; 
                $data['datanya'] = $this->dbset->query($sql)->result_array();
                return $this->load->view('monitoring_cost_budget_xls',$data,TRUE);    

               
            }
            else {
                $data['tglAwal'] = $tglAwal;                
                $data['tglAkhir'] = $tglAkhir; 
                $data['datanya'] = $this->dbset->query($sql)->result_array();
                $output = $this->load->view('monitoring_cost_budget_pdf',$data,TRUE);
                pdf_create($output,'Monitoring KPI',TRUE,'landscape');
            }
    }

    public function printdetail(){
        $this->load->helper('xls');
        $this->load->helper('to_pdf');
        $tglAwal = $_GET['_tglAwal'];
        $tglAkhir = $_GET['_tglAkhir'];
        $parameter= $_GET['_parameter'];
        $uom = $_GET['_uom'];
        $total = $_GET['_total'];
        $per = $_GET['_per'];
        $no = $_GET['_no'];
        


        $sql_header='select b.iparameter_id , a.vkategori_parameter as kategori , b.vparameter as kategori_parameter, b.vdescription as description,c.vNmSatuan
                    from plc2_upb_master_kategori_parameter a
                    join plc2_upb_master_parameter b on a.ikat_parameter_id = b.ikat_parameter_id
                    join plc2_master_satuan c on c.plc2_master_satuan_id = b.plc2_master_satuan_id
                    where b.iparameter_id ="'.$parameter.'" ';

         if ($no==1) {
                 $sql='select d.ireq_ori_id, e.iKirimID, c.vupb_nomor ,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , d.trequest as tgl_request , e.dTanggalKirimBD as tgl_kirim , datediff(e.dTanggalKirimBD,d.trequest) as jumlah_hari , 
                        (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between d.trequest and e.dTanggalKirimBD) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                join plc2_upb_request_originator d on d.iupb_id = c.iupb_id
                                join plc2_upb_date_sample  e on e.iReq_ori_id = d.ireq_ori_id
                                 where 
                                  a.iappbusdev = "2"
                                    and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0
                                    and a.tappbusdev >= "'.$tglAwal .'"
                                    and a.tappbusdev <= "'.$tglAkhir.'"
                                    and d.isent_status ="1"   ';    
          
           
        }else if ($no==2){

             $sql='select  c.iupb_id,c.vupb_nomor,c.vupb_nama as nama_usulan, date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg as tanggal_prareg,c.iappbusdev_prareg , date (c.tappbusdev_prareg) as tanggal_approve
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.tsubmit_prareg is not null or c.tsubmit_prareg !="0000-00-00")
                              and c.iappbusdev_prareg ="2"
                              group by c.iupb_id,c.vupb_nomor,c.vupb_nama , date(a.tappbusdev )  , c.tsubmit_prareg ,c.iappbusdev_prareg , date (c.tappbusdev_prareg)';    
           

        }else if ($no==3){
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg as tanggal_prareg, date (c.tappbusdev_prareg) as tanggal_approve, date(c.tconfirm_dok) as tanggal_doc, datediff(c.tconfirm_dok,c.tsubmit_prareg) as jumlah_hari , 
                          (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and c.tconfirm_dok) as hari_libur
                                from plc2_upb_prioritas a
                                join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                                join plc2_upb c on c.iupb_id = b.iupb_id
                                 where 
                                  a.iappbusdev = "2"
                                  and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                  
                                  and a.tappbusdev >= "'.$tglAwal .'"
                                  and a.tappbusdev <= "'.$tglAkhir.'"
                                  and c.iconfirm_dok = "1"  
  group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg,c.iappbusdev_prareg, c.tsubmit_prareg , date (c.tappbusdev_prareg) , date(c.tconfirm_dok), datediff(c.tconfirm_dok,c.tsubmit_prareg)  ';    
            
        }else if ($no==4){
            
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, 
                              c.tsubmit_prareg as tanggal_prareg,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                              datediff(if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ),c.tsubmit_prareg) as jumlah_hari,
                              (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tsubmit_prareg and if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as hari_libur 
                              
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                              and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                    group by  c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) , c.tsubmit_prareg ,c.tterima_hpr,c.ttarget_hpr, if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )';    

        }else if ($no==5){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,
                    c.tTd_applet as tanggal_aplet,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) as tanggal_hpr, 
                    datediff(c.tTd_applet,if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr )) as jumlah_hari,
                    (select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) and c.tTd_applet) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.ttarget_hpr is not null or c.ttarget_hpr !="0000-00-00")
                      and (c.tTd_applet is not null or c.tTd_applet !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,
                    c.tTd_applet ,
                    if (c.tterima_hpr is not null,GREATEST(c.ttarget_hpr,c.tterima_hpr),c.ttarget_hpr ) ';    
        }else if ($no==6){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas,c.tTglTD_prareg as tgl_tamb_data,c.tTgl_SubDokTD_prareg as tanggal_sub_dokumen,datediff(c.tTglTD_prareg,c.tTgl_SubDokTD_prareg) as jumlah_hari,(select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.tTgl_SubDokTD_prareg and c.tTglTD_prareg) as hari_libur 

                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                      and (c.tTglTD_prareg is not null or c.tTglTD_prareg !="0000-00-00")
                      and (c.tTgl_SubDokTD_prareg is not null or c.tTgl_SubDokTD_prareg !="0000-00-00")
                      group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev ) ,c.tTglTD_prareg ,c.tTgl_SubDokTD_prareg ';    
        }else if ($no==7){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas ,c.tTd_applet as tanggal_aplet ,c.tterima_noreg
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and c.tterima_noreg != "0000-00-00" 
                        and c.tterima_noreg is not null 
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama  , date(a.tappbusdev )  ,c.tTd_applet  ,c.tterima_noreg';    
        }else if ($no==8){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas, e.tapp_memo as t_memo_direksi , c.ttarget_noreg as target_noreg,datediff(e.tapp_memo,c.ttarget_noreg) as jumlah_hari,(select count(Distinct pkl.dTanggal) as troll from plc2_kalender_libur pkl where pkl.dTanggal between c.ttarget_noreg and e.tapp_memo) as hari_libur 
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and (e.tapp_memo is not null or e.tapp_memo !="0000-00-00")                     
                       and (c.ttarget_noreg is not null or c.ttarget_noreg !="0000-00-00")
                       group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ), e.tapp_memo  , c.ttarget_noreg ';    
        }else if ($no==9){
           
                $sql='select c.vupb_nomor ,c.iupb_id,c.vupb_nama as nama_usulan , date(a.tappbusdev ) as date_prioritas , e.istatus_launching
                              from plc2_upb_prioritas a
                              join plc2_upb_prioritas_detail b on a.iprioritas_id = b.iprioritas_id
                              join plc2_upb c on c.iupb_id = b.iupb_id
                              join plc2_upb_bahan_kemas e on e.iupb_id = c.iupb_id
                               where 
                                a.iappbusdev = "2"
                               and b.ldeleted =0 and a.ldeleted=0 and c.ldeleted=0                                
                              and a.tappbusdev >= "'.$tglAwal .'"
                              and a.tappbusdev <= "'.$tglAkhir.'"
                        and e.istatus_launching ="1"
                        group by c.vupb_nomor ,c.iupb_id,c.vupb_nama , date(a.tappbusdev ) , e.istatus_launching';    
        }else if ($no==10){
                $sql='select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                              and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                              and (year(a.t1stCreatedAt) - year(q.tupdate)  > 4 )
                              group by p.vupb_nomor';
           
                   
        }else {
            //param 11
                $sql='select p.vupb_nomor,p.vupb_nama as nama_usulan,d.vStepName as posisi_upb,e.vCaption as status_upb,year(a.t1stCreatedAt),year(q.tupdate) as approve_direksi , h.vkategori, a.plc2_upb_status_log, a.t1stCreatedAt, p.iupb_id,q.tupdate, (year(a.t1stCreatedAt) - year(q.tupdate) )as selisih
                       from 
                              plc2_upb p 
                              join plc2_upb_approve q on p.iupb_id=q.iupb_id
                              
                      JOIN      (
                              SELECT s.plc2_upb_status_log,s.idplc2_upb,s.t1stCreatedAt ,s.idplc2_biz_process_sub,s.idplc2_status
                              FROM      plc2_upb_status_log s
                              where s.plc2_upb_status_log in (select max(plc2_upb_status_log)
                          from plc2_upb_status_log group by idplc2_upb )
                         ) as a ON a.idplc2_upb = p.iupb_id
                              join plc2_biz_process_sub b on a.idplc2_biz_process_sub=b.idplc2_biz_process_sub
                              join plc2_biz_process c on b.idplc2_biz_process = c.idplc2_biz_process
                              join plc2_biz_has_steps d on c.idplc2_biz_has_steps = d.idplc2_biz_has_steps
                              join plc2_status e on a.idplc2_status = e.idplc2_status
                              join plc2_upb_prioritas_detail f on f.iupb_id = p.iupb_id
                              join plc2_upb_prioritas g on g.iprioritas_id = f.iprioritas_id
                              join plc2_upb_master_kategori_upb h on p.ikategoriupb_id = h.ikategori_id
                              where q.vtipe="DR" and q.iapprove="2"
                              and h.vkategori in ("Suplemen","OC","OC1","Obat Tradisional")
                             and g.tappbusdev >= "'.$tglAwal .'"
                             and g.tappbusdev <= "'.$tglAkhir.'"
                          and (if((h.vkategori="Suplemen"),(year(a.t1stCreatedAt) - year(q.tupdate) > 3 ),(year(a.t1stCreatedAt) - year(q.tupdate) > 2 ))) 
                              group by p.vupb_nomor
                            ';    
        }
        $data['total'] = $total;                
        $data['per'] = $per;  
        $data['uom'] = $uom;
        $data['no'] = $no;
        $data['parameter'] = $parameter;
        $data['tglAwal'] = $tglAwal;                
        $data['tglAkhir'] = $tglAkhir; 
        $data['header'] = $this->dbset->query($sql_header)->row_array();
        $data['datanya'] = $this->dbset->query($sql)->result_array();
        
            if(strtolower($_GET['_ext']) == 'xls') {
              if ($no==1) {
                    return $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_xls',$data,TRUE);
              }else if($no==2) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_2_xls',$data,TRUE);
              }else if($no==3) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_3_xls',$data,TRUE);
              }else if($no==4) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_4_xls',$data,TRUE);   
              }else if($no==5) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_5_xls',$data,TRUE);  
              }else if($no==6) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_6_xls',$data,TRUE);  
              }else if($no==7) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_7_xls',$data,TRUE);  
              }else if($no==8) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_8_xls',$data,TRUE);  
              }else if($no==9) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_9_xls',$data,TRUE);  
              }else if($no==10) {
                    return  $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_10_xls',$data,TRUE);  
              }else {
                  // param 11
                  $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_11_xls',$data,TRUE);
              }

            }
            else {
                if ($no==1) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_pdf',$data,TRUE);
                }else if($no==2) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_2_pdf',$data,TRUE);
                }else if($no==3) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_3_pdf',$data,TRUE);
                }else if($no==4) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_4_pdf',$data,TRUE);   
                }else if($no==5) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_5_pdf',$data,TRUE);  
                }else if($no==6) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_6_pdf',$data,TRUE);  
                }else if($no==7) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_7_pdf',$data,TRUE);  
                }else if($no==8) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_8_pdf',$data,TRUE);  
                }else if($no==9) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_9_pdf',$data,TRUE);  
                }else if($no==10) {
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_10_pdf',$data,TRUE);  
                }else {
                    // param 6
                    $output = $this->load->view('kpi_and_cost_budget/monitoring_cost_budget_detail_11_pdf',$data,TRUE);
                }

                pdf_create($output,'Monitoring Cost Budget Detail ',TRUE,'landscape');
            }

        

    }    


    







    public function output(){
        $this->index($this->input->get('index'));
    }

}
