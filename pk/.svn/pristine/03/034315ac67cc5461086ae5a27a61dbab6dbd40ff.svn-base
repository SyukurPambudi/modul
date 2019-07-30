<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pk_ppic_ex {
    private $_ci;
    private $sess_auth;
    private $db_erp_pk;

    function __construct() {
        $this->_ci = &get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->db_erp_pk = $this->_ci->load->database('pk',false, true);
    }



    function getPoint($result,$iAspekId){
        $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='".$iAspekId."' and '".$result."' between a.yNilai1 and a.yNilai2";
        $query = $this->db_erp_pk->query($sql);
        if ( $query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint."~".$row->warna;
        }else{
            $value = '20~#FF3333';
        }

        return $value;

    }

    function hitung_bulan($perode1,$perode2){
        $date1 = new DateTime($perode1);
        $date2 = new DateTime($perode2);

        $diff = $date1->diff($date2);
        $bulan = (($diff->format('%y') * 12) + $diff->format('%m'))+1;

        return $bulan;
    }

    function sumTime($times){
        // loop throught all the times
        $minutes = 0;
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }


    function datediff($tgl1,$tgl2,$cNip){
        $sql = "SELECT iCompanyId FROM hrd.employee WHERE cNip='".$cNip."' ";
        $query = $this->db_erp_pk->query($sql);
        if ( $query->num_rows() > 0) {
            $row = $query->row();
            $company = $row->iCompanyId;
        }

        $dstart = date('Y-m-d',strtotime($tgl1));
        $dend = date('Y-m-d',strtotime($tgl2));
        $increment = "++";
        if ($dstart > $dend){
             $dstart = date('Y-m-d',strtotime($tgl2));
             $dend = date('Y-m-d',strtotime($tgl1));
             $increment = "--";
            //echo "Lebih Besar ".$dstart." > ".$dend ;
            //exit();
        }

        $start      = new DateTime($dstart);
        $start->modify('+1 day');
        $end        = new DateTime($dend);
        $end->modify('+1 day');
        $period     = new DatePeriod($start, new DateInterval('P1D'), $end);
        $year1      = date('Y',strtotime($dstart));
        $year2      = date('Y',strtotime($dend));
        //cari hari liburnya
        $sql= "SELECT *
                FROM (SELECT a.dDate AS tgl,a.cYear, 'hol' AS src,a.cdescription AS ket
                      FROM hrd.holiday AS a
                  UNION ALL
                      SELECT b.dDate AS tgl,b.cYear,'cho' AS src,b.vDescription AS ket
                      FROM hrd.compholiday AS b
                        WHERE b.iCompanyId='".$company."'
                     )AS tabgab
                   WHERE cyear BETWEEN '".$year1."' AND '".$year2."'";


        $holidays = Array();
        $result = mysql_query($sql) or die(mysql_error()."</br>".$sql);

        while ($row = mysql_fetch_assoc($result)) {
            array_push($holidays, $row['tgl']);
        }

        $lama = 0;
        foreach($period as $dt) {

                $curr    = $dt->format('D');
                $tanggal = $dt->format('Y-m-d');
                // for the updated question
                if ($curr == 'Sat' || $curr == 'Sun') {
                    continue;
                }
                if (in_array($dt->format('Y-m-d'), $holidays)) {

                }else{
                    if ($increment=='++'){
                        $lama++;
                    }else{
                        $lama--;
                    }

                }


        }

        if ($increment=='++'){
            return $lama+1;
        }else{
            return $lama-1;
        }


    }


    function getvName($cNip) {

        $vName = '';

        $sql = "SELECT vName FROM hrd.employee WHERE cNip = '{$cNip}' AND lDeleted = 0";
        $query = $this->db_erp_pk->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $vName = $row->vName;
        }

        return $vName;
    }



    function SK_PPIC_EX_5($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            //$cNipNya = 'N09484';
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

            $jenis = array(1=>'UM',2=>'Claim');

            $bulan = $this->hitung_bulan($perode1,$perode2);

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            // $sql_par5 ='SELECT DISTINCT (mm.id) ,  k. vNopejadwalan_mbr , kc. vproduksi_company , kp.dPenjadwalan,
            //               kp.dterima_memo, kp.dplan_memo, km.vNameProduksi ,
            //           		kp.vBatch_no, mm.vNama, mm.vKode_obat
            //           	FROM kanban.kbn_pejadwalan_mbr k
            //           		JOIN kanban.kbn_pejadwalan_mbr_detail  kp ON kp.ipejadwalan_mbr = k.ipejadwalan_mbr
            //           		JOIN  kanban.kbn_master_group_produksi km ON km.igroup_produksi = kp.igroup_produksi
            //           		JOIN kanban.kbn_master_produksi_company kc ON kc.iproduksi_company = k.iproduksi_company
            //           		JOIN kanban.kbn_mbr mm ON mm.id = kp.mbr_id
            //           			WHERE km.iKode IN("PBL","PBE")
            //           			AND kp.dplan_memo IS NOT NULL AND kp.dplan_memo <>"0000-00-00 00:00:00"
            //           			AND kp.dPenjadwalan < kp.dplan_memo
            //           			AND km.ldeleted=0 AND kc.ldeleted=0
            //           			AND kp.dPenjadwalan >= "'.$perode1.'"
            //                 AND kp.dPenjadwalan <= "'.$perode2.'"';

            $sql_par5 ='SELECT DISTINCT (mm.id) ,  kp.vBatch_no, mm.vNama, mm.vKode_obat
                      	FROM kanban.kbn_pejadwalan_mbr k
                      		JOIN kanban.kbn_pejadwalan_mbr_detail  kp ON kp.ipejadwalan_mbr = k.ipejadwalan_mbr
                      		JOIN  kanban.kbn_master_group_produksi km ON km.igroup_produksi = kp.igroup_produksi
                      		JOIN kanban.kbn_master_produksi_company kc ON kc.iproduksi_company = k.iproduksi_company
                      		JOIN kanban.kbn_mbr mm ON mm.id = kp.mbr_id
                      			WHERE km.iKode IN("PBL","PBE")
                      			AND kp.dplan_memo IS NOT NULL AND kp.dplan_memo <>"0000-00-00 00:00:00"
                      			AND (kp.dPenjadwalan < kp.dplan_memo or kp.dPenjadwalan = kp.dplan_memo)
                      			AND km.ldeleted=0 AND kc.ldeleted=0
                      			AND kp.dPenjadwalan >= "'.$perode1.'"
                            AND kp.dPenjadwalan <= "'.$perode2.'"';

            $qupb = $this->db_erp_pk->query($sql_par5);
            if($qupb->num_rows() > 0) {
                $tot = $qupb->num_rows();
                if($tot>144){
                  $hasil1 = 144;
                }else{
                  $hasil = $tot;
                }
                $per = ($hasil/144)*100;
                $totb = number_format( $per, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table cellspacing='0' cellpadding='3' width='750px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No Batch</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tanggal Dijadwalkan</th>
                            <th>Tanggal Plan</th>
                            <th>Group Produksi</th>
                        </tr>
            ";

            // $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
            //             <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
            //                 <th>No</th>
            //                 <th>No Penjadwalan</th>
            //                 <th>No Batch</th>
            //                 <th>Kode Produk</th>
            //                 <th>Nama Produk</th>
            //                 <th>Group Produksi</th>
            //                 <th>Tanggal Dijadwalkan</th>
            //                 <th>Tanggal Plan</th>
            //             </tr>
            // ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;
            foreach ($bacthDetail as $ub) {
                 $i++;
                 // $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                 //             <td style='border: 1px solid #dddddd;'>".$i."</td>
                 //             <td style='border: 1px solid #dddddd;'>".$ub['vNopejadwalan_mbr']."</td>
                 //             <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                 //             <td style='border: 1px solid #dddddd;'>".$ub['vKode_obat']."</td>
                 //             <td style='border: 1px solid #dddddd;'>".$ub['vNama']."</td>
                 //             <td style='border: 1px solid #dddddd;'>".$ub['vNameProduksi']."</td>
                 //             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dPenjadwalan']))."</td>
                 //             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dplan_memo']))."</td>
                 //          </tr>";

                 $sql_tgl ='SELECT kp.dPenjadwalan, kp.dplan_memo,km.vNameProduksi
                             FROM kanban.kbn_pejadwalan_mbr k
                               JOIN kanban.kbn_pejadwalan_mbr_detail  kp ON kp.ipejadwalan_mbr = k.ipejadwalan_mbr
                               JOIN  kanban.kbn_master_group_produksi km ON km.igroup_produksi = kp.igroup_produksi
                               JOIN kanban.kbn_master_produksi_company kc ON kc.iproduksi_company = k.iproduksi_company
                               JOIN kanban.kbn_mbr mm ON mm.id = kp.mbr_id
                                 WHERE km.iKode IN("PBL","PBE")
                                 AND kp.dplan_memo IS NOT NULL AND kp.dplan_memo <>"0000-00-00 00:00:00"
                                 AND (kp.dPenjadwalan < kp.dplan_memo or kp.dPenjadwalan = kp.dplan_memo)
                                 AND km.ldeleted=0 AND kc.ldeleted=0
                                 AND mm.id = "'.$ub['id'].'"
                                 ORDER BY kp.ipejadwalan_mbr_detail LIMIT 1';
                  $tgl = $this->db_erp_pk->query($sql_tgl)->row_array();

                  $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                              <td style='border: 1px solid #dddddd;'>".$i."</td>
                              <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                              <td style='border: 1px solid #dddddd;'>".$ub['vKode_obat']."</td>
                              <td style='border: 1px solid #dddddd;'>".$ub['vNama']."</td>
                              <td style='border: 1px solid #dddddd;'>".$tgl['dPenjadwalan']."</td>
                              <td style='border: 1px solid #dddddd;'>".$tgl['dplan_memo']."</td>
                              <td style='border: 1px solid #dddddd;'>".$tgl['vNameProduksi']."</td>
                           </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Batch (x, max 144)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (x/144)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totb." %</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function selisihHari($tglAwal, $tglAkhir, $nip, $type="day"){
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc="select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr=$this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi="select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
        $qlholi=$this->dbseth->query($sqlholi);
        if($qlholi->num_rows()>=1){
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        }
        $pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1=0;
        $libur2=0;
        $libur3=0;
        for($i=1; $i<=$selisih; $i++){
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            if (in_array($tglstr, $tglLibur))
            {
                $libur1++;
            }
            if ((date("N", $tanggal) == 7))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur2++;
            }
            if ((date("N", $tanggal) == 6))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur3++;
            }
        }
        if($type=='day'){
            if($counthr==5){
                $hasil = $selisih-$libur1-$libur2-$libur3;
            }else{
                $hasil = $selisih-$libur1-$libur2;
            }
            if($hasil>=0){
                if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
                    $hasil=$hasil-1;
                }
            }
            return $hasil;
        }
    }

    /*------------------END OF AD-------------------------------------------------*/



    /*PPIC N15748 Start*/
    function SK_PPIC_EX_1($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            //$cNipNya = 'N09484';
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

            $jenis = array(1=>'UM',2=>'Claim');

            $bulan = $this->hitung_bulan($perode1,$perode2);

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par1 ='SELECT * FROM (SELECT plc2.plc2_upb.vupb_nomor,sales.recent.c_dnnumb,sales.itemas.c_itnam,progress_product.dTerima_memo,recent.d_packing,sales.recent.c_iteno,plc2.progress_product.iprogress_product_id
                FROM plc2.progress_product
                INNER JOIN plc2.plc2_req_memo_busdev ON plc2_req_memo_busdev.iplc2_req_memo_busdev_id = progress_product.iplc2_req_memo_busdev_id
                INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = plc2_req_memo_busdev.iupb_id
                INNER JOIN plc2.plc2_req_memo_mkt ON plc2_req_memo_mkt.iplc2_req_memo_busdev_id = plc2_req_memo_busdev.iplc2_req_memo_busdev_id
                INNER JOIN plc2.plc2_template_submemo_mkt_detail ON plc2_template_submemo_mkt_detail.iplc2_req_memo_mkt_id = plc2_req_memo_mkt.iplc2_req_memo_mkt_id
                INNER JOIN plc2.plc2_template_submemo_mkt ON plc2_template_submemo_mkt.iplc2_template_submemo_mkt_id = plc2_template_submemo_mkt_detail.iplc2_template_submemo_mkt_id
                INNER JOIN prdtrial.trial ON prdtrial.trial.c_iteno=plc2.plc2_req_memo_mkt.vKode_produk
                INNER JOIN sales.recent ON sales.recent.c_iteno=prdtrial.trial.c_itenonew
                INNER JOIN purchase.pamsh ON purchase.pamsh.c_panumb=sales.recent.c_batchno and purchase.pamsh.c_iteno=sales.recent.c_iteno
                INNER JOIN sales.itemas ON sales.itemas.c_iteno=sales.recent.c_iteno
                where sales.recent.c_status="W" and purchase.pamsh.c_flgprd="W"
                AND progress_product.dTerima_memo is NOT NULL AND progress_product.dTerima_memo!="0000-00-00 00:00:00"
                AND recent.d_packing >= "'.$perode1.'"
                AND recent.d_packing <= "'.$perode2.'"
                ORDER BY recent.d_packing ASC) as z GROUP BY z.iprogress_product_id,z.c_iteno';
            $qupb = $this->db_erp_pk->query($sql_par1);
            if($qupb->num_rows() > 0) {
                $dt=$qupb->result_array();
                $arrtot=array();
                foreach ($dt as $kt => $vt) {
                    $tgl1=$vt['d_packing'];
                    $tgl2=$vt['dTerima_memo'];
                    if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                        $tgl11=$tgl1;
                        $tgl22=$tgl2;
                        $tgl1=$tgl22;
                        $tgl2=$tgl11;
                    }
                   $arrtot[]=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                }
                $tt=array_sum($arrtot)/count($arrtot);
                $totb = number_format( $tt, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>No DN</th>
                            <th>Nama Produk</th>
                            <th>Tgl Terima Memo<br/>(A)</th>
                            <th>Tgl Packing (F5)<br/>(B)</th>
                            <th width ='10%'>Selisih<br/>(A & B)<br/>Hari</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par1)->result_array();
            $i=0;
            $grantot=array();
            foreach ($bacthDetail as $ub) {
                $i++;
                $tgl1=$ub['d_packing'];
                $tgl2=$ub['dTerima_memo'];
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['vupb_nomor']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['c_dnnumb']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_itnam']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['dTerima_memo']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['d_packing']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$selisih."</td>
                          </tr>";
                $grantot[]=$selisih;
            }
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;"><td colspan="7" style=text-align: left;border: 1px solid #dddddd;></td></tr>';
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="6" style="text-align: left;border: 1px solid #dddddd;text-align:center"><strong>Total<strong></td>
                        <td style="text-align: left;border: 1px solid #dddddd;"><strong>'.array_sum($grantot).'</strong></td>
                    </tr>';
            $html .= "</table><br/>";
            $tot=0;
            if(array_sum($grantot)!=0 and count($grantot)){
                $tot=array_sum($grantot)/count($grantot);
            }
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Kesiapan (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".array_sum($grantot)." Hari</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Produk (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".count($grantot)."</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>A/B</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format( $tot, 2, '.', '' )." Hari</td>
                        </tr>
                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }

    function SK_PPIC_EX_2($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            //$cNipNya = 'N09484';
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

            $jenis = array(1=>'UM',2=>'Claim');

            $bulan = $this->hitung_bulan($perode1,$perode2);

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par1 ='SELECT * FROM (SELECT m.vNOMemo,d.c_iteno,it.c_itnam,m.dAppr_ppic,re.d_gudang,m.iAppr_ppic,d.imemo_order_export_detail from ganttcart.memo_order_export_detail d
                join ganttcart.memo_order_export m on m.imemo_order_export=d.imemo_order_export
                join sales.recent re on re.c_iteno=d.c_iteno
                join purchase.pamsh pa on pa.c_panumb=re.c_batchno and pa.c_iteno=re.c_iteno
                join sales.itemas it on it.c_iteno=re.c_iteno
                where d.lDeleted=0 and m.lDeleted=0 and re.c_status="W" and pa.c_flgprd="W"
                and m.dAppr_ppic is not null and m.dAppr_ppic!="0000-00-00 00:00:00" and m.iAppr_ppic=1 and m.ljenisMemo=0
                and re.d_gudang  >= "'.$perode1.'"
                AND re.d_gudang <= "'.$perode2.'"
                ORDER BY re.d_gudang ASC) as z
                Group By z.imemo_order_export_detail';
            $qupb = $this->db_erp_pk->query($sql_par1);

            $sql_par2 ='SELECT * FROM (SELECT d.vUpd_no,d.c_iteno,it.c_itnam,d.dKemasanApp,re.d_gudang,d.icontract_review
                from ganttcart.contract_review d
                join sales.recent re on re.c_iteno=d.C_ITENO
                join purchase.pamsh pa on pa.c_panumb=re.c_batchno and pa.c_iteno=re.c_iteno
                join sales.itemas it on it.c_iteno=re.c_iteno
                join ganttcart.memo_order_export_detail det on det.vContractReview=d.icontract_review
                where d.lDeleted=0 and re.c_status="W" and pa.c_flgprd="W"
                and d.dKemasanApp is not null and d.dKemasanApp!="0000-00-00 00:00:00" and det.iStatusOrder=1
                and re.d_gudang  >= "'.$perode1.'"
                AND re.d_gudang <= "'.$perode2.'"
                ORDER BY re.d_gudang ASC) as z
                Group By z.icontract_review';
            $qupb2= $this->db_erp_pk->query($sql_par2);


            $sql_par3 ='SELECT * FROM (SELECT d.c_iteno
                from ganttcart.memo_order_export_detail d
                join ganttcart.memo_order_export m on m.imemo_order_export=d.imemo_order_export
                join sales.recent re on re.c_iteno=d.c_iteno
                join purchase.pamsh pa on pa.c_panumb=re.c_batchno and pa.c_iteno=re.c_iteno
                join sales.itemas it on it.c_iteno=re.c_iteno
                where d.lDeleted=0 and m.lDeleted=0 and re.c_status="W" and pa.c_flgprd="W"
                and m.dAppr_ppic is not null and m.dAppr_ppic!="0000-00-00 00:00:00" and m.iAppr_ppic=1 and m.ljenisMemo=1
                and re.d_gudang  >= "'.$perode1.'"
                AND re.d_gudang <= "'.$perode2.'"
                UNION
                SELECT d.c_iteno
                from ganttcart.contract_review d
                join sales.recent re on re.c_iteno=d.C_ITENO
                join purchase.pamsh pa on pa.c_panumb=re.c_batchno and pa.c_iteno=re.c_iteno
                join sales.itemas it on it.c_iteno=re.c_iteno
                join ganttcart.memo_order_export_detail det on det.vContractReview=d.icontract_review
                where d.lDeleted=0 and re.c_status="W" and pa.c_flgprd="W"
                and d.dKemasanApp is not null and d.dKemasanApp!="0000-00-00 00:00:00" and det.iStatusOrder=0
                and re.d_gudang  >= "'.$perode1.'"
                AND re.d_gudang <= "'.$perode2.'"
                ) as z
                Group By z.c_iteno';
            $qupb3= $this->db_erp_pk->query($sql_par3);
            $sa=0;
            if($qupb->num_rows() + $qupb2->num_rows() !=0) {
                $dt=$qupb->result_array();
                $arrtot=array();
                foreach ($dt as $kt => $vt) {
                    $tgl1=$vt['d_gudang'];
                    $tgl2=$vt['dAppr_ppic'];
                    if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                        $tgl11=$tgl1;
                        $tgl22=$tgl2;
                        $tgl1=$tgl22;
                        $tgl2=$tgl11;
                    }
                   $arrtot[]=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                }

                $dt2=$qupb2->result_array();
                foreach ($dt2 as $kt => $vt) {
                    $tgl1=$vt['d_gudang'];
                    $tgl2=$vt['dKemasanApp'];
                    if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                        $tgl11=$tgl1;
                        $tgl22=$tgl2;
                        $tgl1=$tgl22;
                        $tgl2=$tgl11;
                    }
                   $arrtot[]=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                }
                //$pembagi=$qupb3->num_rows() > 0?$qupb3->num_rows():1;
                $pembagi=$qupb->num_rows()+$qupb2->num_rows();
                $tt=0;
                if($pembagi!=0){
                    $tt=array_sum($arrtot)/$pembagi;
                }
                $totb = number_format( $tt, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <th colspan='7' style='text-align: left;border: 1px solid #dddddd;'>Repeat Order</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No Memo</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tgl Approval PPIC<br/>(A)</th>
                            <th>Tgl Terima Gudang (F8)<br/>(B)</th>
                            <th width ='10%'>Selisih<br/>(A & B)<br/>Hari</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par1)->result_array();
            $i=0;
            $grantot=array();
            foreach ($bacthDetail as $ub) {
                $i++;
                $tgl1=$ub['d_gudang'];
                $tgl2=$ub['dAppr_ppic'];
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['vNOMemo']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['c_iteno']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_itnam']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".date("Y-m-d",strtotime($ub['dAppr_ppic']))."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['d_gudang']."</td>
                             <td style='border: 1px solid #dddddd;text-align:right;padding-right:5px'>".$selisih."</td>
                          </tr>";
                $grantot[]=$selisih;
            }
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;"><td colspan="7" style=text-align: left;border: 1px solid #dddddd;></td></tr>';
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="6" style="text-align: left;border: 1px solid #dddddd;text-align:center"><strong>Total<strong></td>
                        <td style="text-align: right;padding-right:5px;border: 1px solid #dddddd;"><strong>'.array_sum($grantot).'</strong></td>
                    </tr>';
            $html .= "</table><br/>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <th colspan='7' style='text-align: left;border: 1px solid #dddddd;'>First Order</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPD</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tanggal Approval Kemasan<br/>(A)</th>
                            <th>Tgl Terima Gudang (F8)<br/>(B)</th>
                            <th width ='10%'>Selisih<br/>(A & B)<br/>Hari</th>
                        </tr>
            ";

            $bacthDetail2 = $this->db_erp_pk->query($sql_par2)->result_array();
            $i=0;
            $grantot2=array();
            foreach ($bacthDetail2 as $ub2) {
                $i++;
                $tgl1=$ub2['d_gudang'];
                $tgl2=$ub2['dKemasanApp'];
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih2=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub2['vUpd_no']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub2['c_iteno']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub2['c_itnam']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub2['dKemasanApp']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub2['d_gudang']."</td>
                             <td style='border: 1px solid #dddddd;text-align:right;padding-right:5px'>".$selisih2."</td>
                          </tr>";
                $grantot2[]=$selisih2;
            }
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;"><td colspan="7" style=text-align: left;border: 1px solid #dddddd;></td></tr>';
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="6" style="text-align: left;border: 1px solid #dddddd;text-align:center"><strong>Total<strong></td>
                        <td style="text-align: right;padding-right:5px;border: 1px solid #dddddd;"><strong>'.array_sum($grantot2).'</strong></td>
                    </tr>';
            $html .= "</table><br/>";
            $pembagi=$qupb3->num_rows() > 0?$qupb3->num_rows():1;
            $gr1=array_sum($grantot);
            $gr2=array_sum($grantot2);
            $ii=count($grantot)+count($grantot2);
            $totall=0;
            if($ii!=0){
                $totall=($gr1+$gr2)/$ii;
            }
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Repeat Order (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$gr1." Hari</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total First Order (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$gr2." Hari</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Produk (X)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$ii."</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(A+B)/X</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format( $totall, 2, '.', '' )."</td>
                        </tr>
                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }

    function SK_PPIC_EX_4($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            //$cNipNya = 'N09484';
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

            $jenis = array(1=>'UM',2=>'Claim');

            $bulan = $this->hitung_bulan($perode1,$perode2);

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;
            $grc_iteno="c_iteno";
            $grc_dnnumb="c_dnnumb";
            $sql_par1 ='SELECT * FROM (SELECT re.* from sales.recent re
                join purchase.pamsh pa on pa.c_iteno=re.c_iteno and pa.c_panumb=re.c_batchno
                #join sales.itemas it on it.c_iteno and re.c_iteno
                where re.c_status="W" and pa.c_flgprd="W"
                and re.d_packing!="0000-00-00" AND re.d_packing is not null
                and re.d_gudang!="0000-00-00" AND re.d_gudang is not null
                AND re.d_packing >= "'.$perode1.'"
                AND re.d_packing <= "'.$perode2.'"
                AND re.d_gudang >= "'.$perode1.'"
                AND re.d_gudang <= "'.$perode2.'"
                ORDER BY re.d_gudang ASC) as z GROUP BY z.';
            $qupb = $this->db_erp_pk->query($sql_par1.$grc_dnnumb);
            $qupbt = $this->db_erp_pk->query($sql_par1.$grc_iteno);
            if($qupb->num_rows() > 0) {
                $dt=$qupb->result_array();
                $arrtot=array();
                foreach ($dt as $kt => $vt) {
                    $tgl1=$vt['d_packing'];
                    $tgl2=$vt['d_gudang'];
                    if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                        $tgl11=$tgl1;
                        $tgl22=$tgl2;
                        $tgl1=$tgl22;
                        $tgl2=$tgl11;
                    }
                   $arrtot[]=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                }
                $tt=array_sum($arrtot)/count($arrtot);
                $totb = number_format( $tt, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No DN</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tgl Packing (F5)<br/>(A)</th>
                            <th>Tgl Gudang (F8)<br/>(A)</th>
                            <th width ='10%'>Selisih<br/>(A & B)<br/>Hari</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par1.$grc_dnnumb)->result_array();
            $i=0;
            $grantot=array();
            foreach ($bacthDetail as $ub) {
                $i++;
                $tgl1=$ub['d_packing'];
                $tgl2=$ub['d_gudang'];
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                $sqlgetc="select c_itnam from sales.itemas where c_iteno='".$ub['c_iteno']."'";
                $ritemas=$this->db_erp_pk->query($sqlgetc)->row_array();
                $c_itnam=isset($ritemas['c_itnam'])?$ritemas['c_itnam']:"-";
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['c_dnnumb']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['c_iteno']."</td>
                             <td style='border: 1px solid #dddddd;'>".$c_itnam."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['d_packing']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$ub['d_gudang']."</td>
                             <td style='border: 1px solid #dddddd;text-align:center;'>".$selisih."</td>
                          </tr>";
                $grantot[]=$selisih;
            }
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;"><td colspan="7" style=text-align: left;border: 1px solid #dddddd;></td></tr>';
            $html .='<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="6" style="text-align: left;border: 1px solid #dddddd;text-align:center"><strong>Total<strong></td>
                        <td style="text-align: left;border: 1px solid #dddddd;"><strong>'.array_sum($grantot).'</strong></td>
                    </tr>';
            $html .= "</table><br/>";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Closing MBR Eksport (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".array_sum($grantot)." Hari</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Produk (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".count($arrtot)."</td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>A/B</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format( array_sum($grantot)/count($arrtot), 2, '.', '' )." Hari</td>
                        </tr>
                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }

    /**/

    /*Optional FUNC*/
    function getHoliday($tglAwal, $tglAkhir, $nip, $type="holiday"){
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc="select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr=$this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi="select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
        $qlholi=$this->dbseth->query($sqlholi);
        if($qlholi->num_rows()>=1){
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        }
        $pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1=0;
        $libur2=0;
        $libur3=0;
        for($i=1; $i<=$selisih; $i++){
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            if (in_array($tglstr, $tglLibur))
            {
                $libur1++;
            }
            if ((date("N", $tanggal) == 7))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur2++;
            }
            if ((date("N", $tanggal) == 6))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur3++;
            }
        }
        $hasil=0;
        if($type=='holiday'){
            $hasil=$libur1;
        }elseif($type=='offkerja'){
            if($counthr==5){
                $hasil = $libur2+$libur3;
            }else{
                $hasil = $libur2;
            }
        }elseif($type=='offbrutto'){
           $hasil=$selisih;
        }
        return $hasil;
    }

}
