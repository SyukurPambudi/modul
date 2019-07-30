<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pk_chief_qc {
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

            $sql_par5 ='SELECT DISTINCT (mm.id) ,  k. vNopejadwalan_mbr , kc. vproduksi_company , kp.dPenjadwalan,
                          kp.dterima_memo, kp.dplan_memo, km.vNameProduksi ,
                      		kp.vBatch_no, mm.vNama, mm.vKode_obat
                      	FROM `kanban`.`kbn_pejadwalan_mbr` k
                      		JOIN `kanban`.`kbn_pejadwalan_mbr_detail`  kp ON kp.ipejadwalan_mbr = k.ipejadwalan_mbr
                      		JOIN  `kanban`.`kbn_master_group_produksi` km ON km.igroup_produksi = kp.igroup_produksi
                      		JOIN `kanban`.`kbn_master_produksi_company` kc ON kc.iproduksi_company = k.iproduksi_company
                      		JOIN `kanban`.`kbn_mbr` mm ON mm.id = kp.mbr_id
                      			WHERE km.iKode IN("PBL","PBE")
                      			AND kp.dplan_memo IS NOT NULL AND kp.dplan_memo <>"0000-00-00 00:00:00"
                      			AND kp.dPenjadwalan < kp.dplan_memo
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
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No Penjadwalan</th>
                            <th>No Batch</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Group Produksi</th>
                            <th>Tanggal Dijadwalkan</th>
                            <th>Tanggal Plan</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;
            foreach ($bacthDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vNopejadwalan_mbr']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vKode_obat']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vNama']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vNameProduksi']."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dPenjadwalan']))."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dplan_memo']))."</td>
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


    function CQ_11($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par5 ='select
                        a.c_iteno,a.c_itnam,b.c_dnnumb
                        ,b.d_qc as f6,b.c_timeqc,b.c_qcuser
                        ,d.d_qc as altf6 ,d.c_qc,d.c_qcby,b.c_status
                        from sales.itemas a
                        join sales.recent b on b.c_iteno=a.c_iteno
                        JOIN purchase.pamsh c ON c.c_panumb=b.c_batchno and c.c_iteno=b.c_iteno
                        JOIN sales.recentqa d on d.c_iteno=a.c_iteno and b.c_dnnumb=d.c_dnnumb
                        where
                        b.c_status="W"
                        and c.c_flgprd="W"
                        and d.d_qc >= "'.$perode1.'"
                        and d.d_qc <= "'.$perode2.'"
                        ';

            $qupb = $this->db_erp_pk->query($sql_par5);
            if($qupb->num_rows() > 0) {
                $tot = $qupb->num_rows();
                $totb = number_format( $tot, 2, '.', '' );
            }else{
                $totb       = 0;
            }




            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='100%;'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>No DN</th>
                            <th>Tanggal F6</th>
                            <th>Tanggal ALT F6</th>
                            <th>Selisih Hari</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;
            $totSelisih = 0;
            foreach ($bacthDetail as $ub) {

                $f6     = strtotime($ub['f6']);
                $altf6  = strtotime($ub['altf6']);
                $diff   = $altf6 - $f6;
                //$selisih = abs(floor($diff / (60 * 60 * 24)));
                $selisih = $this->selisihHari($ub['f6'],$ub['altf6'],$cNipNya);
                $selisih = abs($selisih) ;

                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_iteno']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_itnam']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_dnnumb']."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['f6']))."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['altf6']))."</td>
                             <td style='border: 1px solid #dddddd;'>".$selisih."</td>
                          </tr>";
                $totSelisih +=$selisih;
            }

            $html .= "<tfoot>";
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>";
                    $html .= "<td style='border: 1px solid #dddddd;text-align:right;' colspan='6' >Total Selisih Hari</td>";
                    $html .= "<td style='border: 1px solid #dddddd;text-align:right;'>".number_format($totSelisih,0)."</td>";
                $html .= "</tr>";

            $html .= "</tfoot>";

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Produk (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih Hari (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($totSelisih,0)." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format(($totSelisih/$i), 2, '.', '' )."</td>
                        </tr>
                    </table><br/><br/>";

            $result     = number_format(($totSelisih/$i), 2, '.', '' );

            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];


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

    function CQ_01($post){

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
        $p1=date("Y-m-d",strtotime($perode1));
        $p2=date("Y-m-d",strtotime($perode2));
        $m1=date("m",strtotime($perode1));
        $y1=date("Y",strtotime($perode1));
        if($m1==1){
            $m1=12;
            $y1=date("Y",strtotime($perode1))-1;
        }else{
            $m1=$m1-1;
        }
        $p1=$y1."-".$m1."-26";
        $sql_par5 = "SELECT p1.c_lpbnumb, im.c_itemnumb,im.c_itemname,p1.d_datecon as dconfirm_lpb,s1.d_datecon as dconfirm_lsa from purchase.lstr02 s2
            join purchase.lstr01 s1 on s1.c_itemnumb=s2.c_itemnumb and s2.c_lsanumb=s1.c_lsanumb
            join purchase.lptr01 p1 on p1.c_lpbnumb=s2.c_lpbnumb
            JOIN purchase.imsh im ON s2.c_itemnumb = im.c_itemnumb
            where s1.d_datecon BETWEEN '".$perode1."' AND  '".$perode2."'
            group by p1.c_lpbnumb";
        $qupb = $this->db_erp_pk->query($sql_par5);
        $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
        $tot = 0;
        $sum = 0;
        $totb1=0;
        if($qupb->num_rows() > 0) {
            $tot = $qupb->num_rows();
            foreach ($bacthDetail as $key) {
                $tgl1=$key['dconfirm_lpb'];
                $tgl2=$key['dconfirm_lsa'];
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                if($selisih<=4){
                    $sum++;
                }
            }
            $totb1       = $sum / $tot * 100;
        }else{
            $totb1       = 0;
        }
        $sql_par2 = "
            SELECT * FROM (

            SELECT r2.c_lsanumb,im.c_itemnumb,im.c_itemname,r2.c_result,r1.d_datent as dproses,r2.d_confirm as dconfirm
                from purchase.reassay2 r2
            join purchase.reassay1 r1 on r2.c_rsynumb=r1.c_rsynumb
            #join purchase.lstr01 l1 on l1.c_lsanumb=r2.c_lsanumb and r2.c_itemnumb=l1.c_itemnumb
            join purchase.imsh im on im.c_itemnumb=r2.c_itemnumb
            where  r2.d_confirm BETWEEN '".$p1."' AND  '".$p2."' and r2.ipemutihan=0

            UNION

            SELECT r2.c_lsanumb,im.c_itemnumb,im.c_itemname,r2.c_result,r1.d_datent as dproses,r2.d_confirm as dconfirm
                from purchase.reassay2 r2
            join purchase.reassay1 r1 on r2.c_rsynumb=r1.c_rsynumb
            #join purchase.lstr01 l1 on l1.c_lsanumb=r2.c_lsanumb and r2.c_itemnumb=l1.c_itemnumb
            join purchase.imsh im on im.c_itemnumb=r2.c_itemnumb
            where r2.d_confirm is null and r2.ipemutihan=0

            ) as z
            ";
        $qupb2 = $this->db_erp_pk->query($sql_par2);
        $bacthDetail2 = $this->db_erp_pk->query($sql_par2)->result_array();
        $tot2 = 0;
        $sum2 = 0;
        $tott2=0;
        $ndiluarp=0;
        $totb2=0;
        if($qupb2->num_rows() > 0) {
            $tot2 = $qupb2->num_rows();
            foreach ($bacthDetail2 as $key) {
                if ($key['dconfirm']!=""){
                    $tgl1=$key['dproses'];
                    $tgl2=$key['dconfirm'];
                    $pp1=date("Y-m-d",strtotime($perode1));
                    $pp2=date("Y-m-d",strtotime($perode2));
                    $mm2=date("m",strtotime($perode2));
                    $yy2=date("Y",strtotime($perode2));
                    $pp2=$yy2."-".$mm2."-25";
                    $pp1=$p1;
                    if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                        $tgl11=$tgl1;
                        $tgl22=$tgl2;
                        $tgl1=$tgl22;
                        $tgl2=$tgl11;
                    }
                    $selisih2=$this->selisihHari($tgl1,$tgl2,$cNipNya);
                    if($selisih2<5&&$key['dconfirm']!=""&&$key['c_result']!=""){
                        if(date("Y-m-d",strtotime($perode1))<date("Y-m-d",strtotime($key['dconfirm']))&&date("Y-m-d",strtotime($perode2))>date("Y-m-d",strtotime($key['dconfirm']))){
                            $sum2++;
                        }
                    }

                    if(date("Y-m-d",strtotime($pp1))<date("Y-m-d",strtotime($key['dconfirm']))&&date("Y-m-d",strtotime($pp2))>date("Y-m-d",strtotime($key['dconfirm']))){
                       // $colorf="color:black";
                    }else{
                        $ndiluarp++;
                    }
                }
            }

            $tott2=$tot2-$ndiluarp;
            $totb2 = $sum2/$tott2*100;

        }else{
            $totb2       = 0;
        }

        $totb=($totb1+$totb2)/2;

        $result     = number_format($totb,2);
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
        $html .= "<table class='scroll_table' cellspacing='0' cellpadding='3' width='850px' style='height: 500px;overflow: scroll;'>
                    <thead>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No LPB</th>
                        <th>No Produk</th>
                        <th>Nama Produk</th>
                        <th>Tanggal LPB</th>
                        <th>Tanggal LSA</th>
                        <th>Selisih <br /> (Hari)</th>
                    </tr>
                    </thead>
                    <tbody>
        ";

        $i=0;
        foreach ($bacthDetail as $ub) {
            $tgl1=$ub['dconfirm_lpb'];
            $tgl2=$ub['dconfirm_lsa'];
            if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                $tgl11=$tgl1;
                $tgl22=$tgl2;
                $tgl1=$tgl22;
                $tgl2=$tgl11;
            }
            $selisih=$this->selisihHari($tgl1,$tgl2,$cNipNya);
             $i++;
             $colorbg=$selisih>=5?"background-color:#ffadad":"";
             $html .= "<tr style='width:100%; border: 1px solid #dddddd; border-collapse: collapse;".$colorbg."'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_lpbnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_itemnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_itemname']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['dconfirm_lpb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['dconfirm_lsa']."</td>
                         <td style='border: 1px solid #dddddd;'>".$selisih."</td>
                      </tr>";
        }

        $html .= "<tbody></table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 850px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total LPB <= 4 hari</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$sum." </td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total LPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase LPB Terhadap LSA (A) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($totb1,2)." %</td>
                    </tr>
                </table><br/><br/>";


        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <thead>
                    <tr><th colspan='8' align='left' style='background:#1d5987;color:#ffffff'>Material yang di Reassay <=4 Hari dengan Cut Off 30/31</th></tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No LSA</th>
                        <th>No Produk</th>
                        <th>Nama Produk</th>
                        <th>Status</th>
                        <th>Tanggal Proses</th>
                        <th>Tanggal Confirm</th>
                        <th>Selisih <br> (Hari)</th>
                    </tr>
                    </thead>
                    <tbody>
        ";

        $i=0;
        foreach ($bacthDetail2 as $ub2) {
            $tgl1=$ub2['dproses'];
            $tgl2=$ub2['dconfirm'];
            $selisih2=0;
            if($ub2['dconfirm']!=""){
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih2=$this->selisihHari($tgl1,$tgl2,$cNipNya);
            }
            $array=array("L"=>"Release","J"=>"Reject");
            $st=isset($array[$ub2['c_result']])?$array[$ub2['c_result']]:"";
            $colorbg=$selisih2>=5?"background-color:#ffadad":"";


            $pp1=date("Y-m-d",strtotime($perode1));
            $pp2=date("Y-m-d",strtotime($perode2));
            $mm2=date("m",strtotime($perode2));
            $yy2=date("Y",strtotime($perode2));
            $pp2=$yy2."-".$mm2."-25";
            $pp1=$p1;
            $colorf="";

            if($selisih2<5&&$ub2['dconfirm']!=""&&$ub2['c_result']!=""){
                if(date("Y-m-d",strtotime($perode1))<date("Y-m-d",strtotime($ub2['dconfirm']))&&date("Y-m-d",strtotime($perode2))>date("Y-m-d",strtotime($ub2['dconfirm']))){
                      $i++;
                   $html .= "<tr style='width:100%; border: 1px solid #dddddd; border-collapse: collapse;".$colorbg.";".$colorf."'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_lsanumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemname']."</td>
                         <td style='border: 1px solid #dddddd;'>".$st."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dproses']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dconfirm']."</td>
                         <td style='border: 1px solid #dddddd;'>".$selisih2."</td>
                      </tr>";
                }else{
                }
            }


        }

        $html .= "</tbody></table><br /> ";

        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <thead>
                    <tr><th colspan='8' align='left' style='background:#1d5987;color:#ffffff'>Material yang di Reassay dengan Cut Off 26/25 dan Outstanding</th></tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No LSA</th>
                        <th>No Produk</th>
                        <th>Nama Produk</th>
                        <th>Status</th>
                        <th>Tanggal Proses</th>
                        <th>Tanggal Confirm</th>
                        <th>Selisih <br> (Hari)</th>
                    </tr>
                    </thead>
                    <tbody>
        ";
        $i=0;
        foreach ($bacthDetail2 as $ub2) {
            $tgl1=$ub2['dproses'];
            $tgl2=$ub2['dconfirm'];
            $selisih2=0;
            if($ub2['dconfirm']!=""){
                if(date("Ymd",strtotime($tgl1))>date("Ymd",strtotime($tgl2))){
                    $tgl11=$tgl1;
                    $tgl22=$tgl2;
                    $tgl1=$tgl22;
                    $tgl2=$tgl11;
                }
                $selisih2=$this->selisihHari($tgl1,$tgl2,$cNipNya);
            }
            $array=array("L"=>"Release","J"=>"Reject");
            $st=isset($array[$ub2['c_result']])?$array[$ub2['c_result']]:"";
            $colorbg=$selisih2>=5?"background-color:#ffadad":"";


            $pp1=date("Y-m-d",strtotime($perode1));
            $pp2=date("Y-m-d",strtotime($perode2));
            $mm2=date("m",strtotime($perode2));
            $yy2=date("Y",strtotime($perode2));
            $pp2=$yy2."-".$mm2."-25";
            $pp1=$p1;
            $colorf="";
            $colorbg="";

            if(date("Y-m-d",strtotime($pp1))<date("Y-m-d",strtotime($ub2['dconfirm']))&&date("Y-m-d",strtotime($pp2))>date("Y-m-d",strtotime($ub2['dconfirm']))){
                      $i++;
                   $html .= "<tr style='width:100%; border: 1px solid #dddddd; border-collapse: collapse;".$colorbg.";".$colorf."'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_lsanumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemname']."</td>
                         <td style='border: 1px solid #dddddd;'>".$st."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dproses']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dconfirm']."</td>
                         <td style='border: 1px solid #dddddd;'>".$selisih2."</td>
                      </tr>";
            }
            if($ub2['dconfirm']==""){
                      $i++;
                   $html .= "<tr style='width:100%; border: 1px solid #dddddd; border-collapse: collapse;".$colorbg.";".$colorf."'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_lsanumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['c_itemname']."</td>
                         <td style='border: 1px solid #dddddd;'>".$st."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dproses']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub2['dconfirm']."</td>
                         <td style='border: 1px solid #dddddd;'>".$selisih2."</td>
                      </tr>";
            }


        }
        $html .= "</tbody></table><br /> ";

        $result2 =$sum2/$tott2*100;
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 850px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Material yang di Reassay <=4 Hari dengan Cut Off 30/31</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$sum2."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Material yang di Reassay dengan Cut Off 26/25 dan Outstanding</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tott2."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase Material yang di Reassay(B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($result2,2)." %</td>
                    </tr>
                </table><br/><br/>";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 850px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase LPB Terhadap LSA (A) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($totb1,2)."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase Material yang di Reassay(B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($totb2,2)."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-Rata Persentase A dan B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                    </tr>
                </table><br/><br/>";



        echo $result."~".$point."~".$warna."~".$html;
    }


    //Start Modified P 2 & 3 By N16945

    function CQ_02($post){
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

        $sql_par5 = "SELECT
                        DISTINCT(p.c_lpbnumb),p.d_datecon AS lpb_con, s1.d_datecon AS lsa_con, s1.c_lsanumb,
                        im.c_itemname, im.c_tradmark, im.c_type
                    FROM purchase.lptr01 p
                    JOIN purchase.lstr02 s2 ON p.c_lpbnumb = s2.c_lpbnumb
                    JOIN purchase.lstr01 s1 ON s2.c_lsanumb = s1.c_lsanumb
                    JOIN purchase.imsh im ON s2.c_itemnumb = im.c_itemnumb
                    WHERE im.c_type = 'P'
                    and p.iCompanyID=3
                    and s2.iCompanyID=3
                    and s1.iCompanyID=3
                    and im.iCompanyID=3
                    AND s1.d_datecon BETWEEN '".$perode1."' AND '".$perode2."' ";

        $qupb = $this->db_erp_pk->query($sql_par5);
        $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
        $tot =0;
        $sum = 0;
        if($qupb->num_rows() > 0) {
            $tot = $qupb->num_rows();
            $sum = 0;
            $sumi = 0;
            foreach ($bacthDetail as $key) {
              if($this->selisihHari($key['lpb_con'], $key['lsa_con'], $cNipNya)<3){
                $sum ++;
              }else{
                $sumi++;
              }
            }
            $totb       = ($sum / $tot)*100;
        }else{
            $totb       = 0;
        }

        $result     = number_format($totb,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table cellspacing='0' cellpadding='3' width='950px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table><br><hr>";

        $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Nama Trademark</th>
                        <th>No LPB</th>
                        <th>No LSA</th>
                        <th>Type</th>
                        <th>Tanggal LPB</th>
                        <th>Tanggal LSA</th>
                        <th>Selisih</th>
                    </tr>
        ";

        $i=1;
        $ii=1;
        $leb2='';
        $kur2='';
        foreach ($bacthDetail as $ub) {
          $ty = '';
          if($ub['c_type']=="P"){
            $ty = "Bahan Kemas";
          }
          $sel = $this->selisihHari($ub['lpb_con'], $ub['lsa_con'], $cNipNya);
          if($sel>2){
            $leb2 .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse; background-color: #C0C0C0;'>
                        <td style='border: 1px solid #dddddd;'>".$i."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_itemname']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_tradmark']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_lpbnumb']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_lsanumb']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ty."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['lpb_con']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['lsa_con']."</td>
                        <td style='border: 1px solid #dddddd;'>".$sel." Hari</td>
                     </tr>";
                 $i++;
          }else{
            $kur2 .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;'>".$ii."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_itemname']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_tradmark']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_lpbnumb']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['c_lsanumb']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ty."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['lpb_con']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['lsa_con']."</td>
                        <td style='border: 1px solid #dddddd;'>".$sel." Hari</td>
                     </tr>";
                 $ii++;
          }
        }
        $html .= $leb2;
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td colspan='9'><hr></td>
                  </tr>";
        $html .= $kur2;
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td colspan='8' style='border: 1px solid #dddddd; text-align: right' ><b> Total Seluruh UPB</b</td>
                    <td style='border: 1px solid #dddddd;'><b>".$tot."</b></td>
                  </tr>";
        $html .= "</table><br /> ";

        //Detail Keseluruhan Data

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 650px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse; background-color: #C0C0C0;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Lebih dari 2 Hari (y)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$sumi."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Kurang dari sama dengan 2 Hari (x)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$sum."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh LPB (z)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-Rata Selisih (x/z)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                    </tr>
                </table><br/><br/>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    function CQ_03($post){

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

        $sql_par5 = "SELECT TIMESTAMPDIFF( DAY, p.d_datecon, s1.d_datecon ) AS selisih,
                        p.c_lpbnumb,p.d_datecon AS lpb_con, s1.d_datecon AS lsa_con, s1.c_lsanumb,
                        im.c_itemname, im.c_tradmark,im.c_type
                    FROM purchase.lptr01 p
                    JOIN purchase.lstr02 s2 ON p.c_lpbnumb = s2.c_lpbnumb
                    JOIN purchase.lstr01 s1 ON s2.c_lsanumb = s1.c_lsanumb
                    JOIN purchase.imsh im ON s2.c_itemnumb = im.c_itemnumb
                    WHERE im.c_type = 'R'
                    and p.iCompanyID=3
                    and s2.iCompanyID=3
                    and s1.iCompanyID=3
                    and im.iCompanyID=3
                    AND s1.d_datecon BETWEEN '".$perode1."' AND '".$perode2."' ";

        $qupb = $this->db_erp_pk->query($sql_par5);
        $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
        $tot = 0;
        if($qupb->num_rows() > 0) {
            $tot = $qupb->num_rows();
            $sum = 0;
            foreach ($bacthDetail as $key) {
                $selisih = $this->selisihHari($key['lpb_con'], $key['lsa_con'], $cNipNya);
                $sum += $selisih;
            }
            $totb       = $sum / $tot;
        }else{
            $totb       = 0;
        }

        $result     = number_format($totb,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table cellspacing='0' cellpadding='3' width='950px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                    <tr>
                      <td colspan='2'><span id='download_excel'><b><i><u>Download</u></i></b></span></td>
                    </tr>
                </table><br><hr>";
        $url_download = base_url().'processor/pk/pk/chief/qc/?action=download_excel&periode1='.$perode1.'&periode2='.$perode2.'&nip='.$cNipNya;
        $html .= "
                  <script>
                    $('#download_excel').live('click', function(){
                       window.open('".$url_download."','_blank');
                    });
                  </script>
                ";

        $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Nama Trademark</th>
                        <th>No LPB</th>
                        <th>No LSA</th>
                        <th>Type</th>
                        <th>Tanggal LPB</th>
                        <th>Tanggal LSA</th>
                        <th>Selisih</th>
                    </tr>
        ";

        $i=0;
        foreach ($bacthDetail as $ub) {
             $selisih = $this->selisihHari($ub['lpb_con'], $ub['lsa_con'], $cNipNya);
             $i++;
             $ty = '';
             if($ub['c_type']=="R"){
               $ty = "Bahan Baku";
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_itemname']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_tradmark']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_lpbnumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['c_lsanumb']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ty."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['lpb_con']."</td>
                         <td style='border: 1px solid #dddddd;'>".$ub['lsa_con']."</td>
                         <td style='border: 1px solid #dddddd;'>".$selisih." Hari</td>
                      </tr>";
        }
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td colspan='8' style='border: 1px solid #dddddd; text-align: right' ><b> Total Selisih Waktu</b</td>
                    <td style='border: 1px solid #dddddd;'><b>".$sum."</b> Hari</td>
                  </tr>";

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 850px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Waktu (x)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$sum." Hari</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total LPB (y)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-Rata Selisih (x/y)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Hari</td>
                    </tr>
                </table><br/><br/>";



        echo $result."~".$point."~".$warna."~".$html;
    }
}
