<?php
/**
 * User: Yandi.Prabowo
 * Date: 12/21/2015
 * Time: 10:00 AM
 */

class Gantt_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }

    function getUpbInfo($upb){
        $sql = "SELECT a.iupb_id,a.vupb_nomor,a.vupb_nama,
                a.ttanggal as dStart_A0, b.tupdate as dEnd_A0,c.tupdate as dEnd_B0, /*Daftar Upb*/
                c.tupdate as dStart1,d.tappbusdev as dEnd1,/*Setting Prioritas*/
                e.tcreate as dStart2,e.tapppd as dEnd2, /*Req. Sample Originator*/
                e.tapppd as dStart_A3,f.dTanggalKirimBD as dEnd_A3,f.dTanggalTerimaPD as dEnd_B3, /*Distribusi sample Originator*/
                g.trequest as dStart4,g.gtapppd as dEnd4, /*Permintaan Sample*/
                g.po_req as dStart5,g.po_app as dEnd5, /*PO Sample*/
                g.ro_req as dStart6,g.ro_app as dEnd6, /*Penerimaan Sample*/
                g.ro_app as dStart_A7,g.trec_date_pd as dEnd_A7,g.trec_date_qa as dEnd_B7, /*Terima Sample BB*/
                LEAST(g.trec_date_pd, g.trec_date_qa, g.trec_date_qc) AS dStart8, g.tapppd_analisa as dEnd8, /*Analisa BB*/
                g.tapppd_analisa as dStart9,g.tapppd_rls as dEnd9, /*Release BB*/
                g.tapppd_rls as dStart10,GREATEST(h.tapp_qc, h.tapp_qa) as dEnd10,  /*SOI BB*/
                GREATEST(h.tapp_qc, h.tapp_qa) as dStart11,i.tformula_apppd as dEnd11, /*Form. Skala Trial*/
                i.tformula_apppd as dStart12, i.tstress_apppd as dEnd12, /*Strest Test*/
                GREATEST(i.tstress_apppd, i.tformula_apppd) as dStart13, i.tlab_apppd as dEnd13, /*Skala Lab*/
                g.ro_app as dStart14, g.tappqa_ksk as dEnd14, /*Approval KSK*/
                i.slStart as dStart15, i.slEnd as dEnd15, /*Stabilita Lab*/
                i.slEnd as dStart16, i.tbest_apppd as dEnd16, /*Best Formula*/
                i.tbest_apppd as dStart17, GREATEST(j.tapp_pd, j.tapp_qa) as dEnd17,/*Spesifikasi SOI FG*/
                GREATEST(j.tapp_pd, j.tapp_qa) as dStart18, GREATEST(k.tapp_qc, k.tapp_qa) as dEnd18,/*SOI FG*/
                GREATEST(k.tapp_qc, k.tapp_qa) as dStart19, l.tapp_qa as dEnd19,/*Spesifikasi Mikrobiologi*/
                l.tapp_qa as dStart20, i.tappdir as dEnd20,/*approval HPP*/
                i.tappdir as dStart21, i.tbasic_apppd as dEnd21,/*Basic Formula*/
                i.tbasic_apppd as dStart22, GREATEST(n.tapppd, n.tappqa, n.tappbd) as dEnd22,/*Bahan Kemas*/
                GREATEST(n.tapppd, n.tappqa, n.tappbd) as dStart23, i.tapppd_bm as dEnd23,/*Pembuatan MBR*/
                i.tapppd_bm as dStart24, i.tapppd_pp as dEnd24,/*Produksi Pilot*/
                i.tapppd_pp as dStart25, i.tapppd_sp as dEnd25,/*Stabilita Pilot*/
                i.tbest_apppd as dStart26, a.tappbusdev_prareg as dEnd26,/*Praregistrasi*/
                a.tappbusdev_prareg as dStart27, s.tappbusdev as dEnd27,/*Setting Prioritas registrasi*/
                s.tappbusdev as dStart28, a.tappbusdev_registrasi as dEnd28,/*Registrasi*/
                a.tappbusdev_registrasi as dStart29, n.tappdr_launch as dEnd29/*Launching Produk*/
                FROM plc2.plc2_upb a
                    left outer join plc2.plc2_upb_approve b on a.iupb_id = b.iupb_id and b.vtipe = 'BD'
                    left outer join plc2.plc2_upb_approve c on a.iupb_id = c.iupb_id and c.vtipe = 'DR'
                    left outer join (select d1.iupb_id,d2.tupdate,d2.tappbusdev from plc2.plc2_upb_prioritas_detail d1
                        left outer join plc2.plc2_upb_prioritas d2 on d1.iprioritas_id = d2.iprioritas_id
                        left outer join plc2.plc2_upb d3 on d3.iupb_id = d1.iupb_id and d2.ldeleted = 0
									 where d1.ldeleted = 0 and d3.iupb_id = '$upb' order by d2.tupdate desc limit 1) d on d.iupb_id = a.iupb_id
					left outer join (select iupb_id, max(tcreate) tcreate, max(tapppd)tapppd
						from plc2.plc2_upb_request_originator e1 where e1.iupb_id='$upb'  group by iupb_id) e
						on a.iupb_id = e.iupb_id
					left outer join (select iupb_id, max(dTanggalKirimBD) dTanggalKirimBD, max(dTanggalTerimaPD)dTanggalTerimaPD
						from plc2.plc2_upb_date_sample f1 where f1.iupb_id='$upb'  group by iupb_id) f
						on a.iupb_id = f.iupb_id
					left outer join (select g1.iupb_id, max(g1.trequest) trequest, max(g1.tapppd) gtapppd,
									max(ph1.trequest)po_req, max(ph1.tapp_pur)po_app,
									max(rh1.trequest)ro_req, max(rh1.tapp_pur)ro_app,
									max(r1.trec_date_pd)trec_date_pd, max(r1.trec_date_qa)trec_date_qa,
									max(r1.trec_date_qc)trec_date_qc, max(r1.tapppd_analisa)tapppd_analisa,
									max(r1.tapppd_rls)tapppd_rls, max(r1.tappqa_ksk)tappqa_ksk
						from plc2.plc2_upb_request_sample g1
							left outer join plc2.plc2_upb_po_detail h1 on h1.ireq_id = g1.ireq_id
							left outer join plc2.plc2_upb_po ph1 on ph1.ipo_id = h1.ipo_id
							left outer join plc2.plc2_upb_ro_detail r1 on r1.ireq_id = g1.ireq_id
	                        left outer join plc2.plc2_upb_ro rh1 on rh1.iro_id = r1.iro_id
						where g1.iupb_id='$upb'  group by g1.iupb_id) g
						on a.iupb_id = g.iupb_id
				  left outer join plc2.plc2_upb_soi_bahanbaku	h on h.iupb_id = a.iupb_id
				  left outer join (select i1.iupb_id, max(i1.tformula_apppd) tformula_apppd,
				      max(i1.tstress_apppd)tstress_apppd,max(i1.tlab_apppd) tlab_apppd,j1.tdate slStart,j2.tapppd as slEnd,
				      max(i1.tbest_apppd)tbest_apppd,max(m1.tappdir)tappdir,max(i1.tbasic_apppd)tbasic_apppd,
				      max(o1.tapppd_bm)tapppd_bm, max(p1.tapppd_pp)tapppd_pp, max(q1.tapppd)tapppd_sp
				    from plc2.plc2_upb_formula i1
				        left outer join plc2.plc2_upb_stabilita j1 on j1.ifor_id = i1.ifor_id and j1.inumber = 0
					  	left outer join plc2.plc2_upb_stabilita j2 on j2.ifor_id =  i1.ifor_id and j2.inumber = 6
					  	left outer join plc2.plc2_hpp m1 on m1.ifor_id = i1.ifor_id
					  	left outer join plc2.plc2_upb_buat_mbr o1 on o1.ifor_id = i1.ifor_id
					  	left outer join plc2.plc2_upb_prodpilot p1 on p1.ifor_id = i1.ifor_id
					  	left outer join plc2.plc2_upb_stabilita_pilot q1 on q1.ifor_id =  i1.ifor_id and q1.isucced = 2
				  where i1.iformula_apppd = 2 and i1.iupb_id='$upb' and i1.iapppd = 2) i on i.iupb_id = a.iupb_id
				  left outer join (select j1.iupb_id ,max(j1.tapp_pd)tapp_pd,max(j1.tapp_qa)tapp_qa from
				    plc2.plc2_upb_spesifikasi_fg j1 where j1.iupb_id = '$upb')j on a.iupb_id = j.iupb_id
				  left outer join (select k1.iupb_id ,max(k1.tapp_qc)tapp_qc,max(k1.tapp_qa)tapp_qa from
				    plc2.plc2_upb_soi_fg k1 where k1.iupb_id = '$upb')k on a.iupb_id = k.iupb_id
				  left outer join plc2.plc2_upb_mikro_fg l on l.iupb_id = a.iupb_id
				  left outer join (select n1.iupb_id, max(n1.tapppd)tapppd, max(n1.tappqa)tappqa,max(n1.tappbd)tappbd,
				    max(n1.tappdr_launch) tappdr_launch
				    from plc2.plc2_upb_bahan_kemas n1 where n1.iupb_id = '$upb')n on a.iupb_id = n.iupb_id
				  left outer join (select s1.iupb_id,s2.tupdate,s2.tappbusdev from plc2.plc2_upb_prioritas_reg_detail s1
                        left outer join plc2.plc2_upb_prioritas_reg s2 on s1.iprioritas_id = s2.iprioritas_id
                        left outer join plc2.plc2_upb s3 on s3.iupb_id = s1.iupb_id and s2.ldeleted = 0
									 where s1.ldeleted = 0 and s3.iupb_id = '$upb' order by s2.tupdate desc limit 1) s on s.iupb_id = a.iupb_id
            where a.iupb_id = '$upb' Limit 1";
        return $this->db->query($sql)->row_array();
    }

    function getBizStep(){
        $sql = "select b.* from plc2.plc2_biz_process a
                left outer join plc2.plc2_biz_has_steps b on a.idplc2_biz_has_steps = b.idplc2_biz_has_steps
                where a.idplc2_biz_process_type = 1 and b.isDeleted = 0 order by a.iUrutan";
        return $this->db->query($sql)->result_array();
    }

    function getUpbNo($upb){
        $sql = "select vupb_nomor from plc2.plc2_upb where iupb_id = '$upb' Limit 1";
        return $this->db->query($sql)->row_array();

    }
}
