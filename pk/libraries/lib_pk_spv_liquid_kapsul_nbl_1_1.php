<?php

class lib_pk_spv_liquid_kapsul_nbl_1_1
{
    private $_ci;
    private $sess_auth;
    private $db_erp_pk;

    function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->db_erp_pk = $this->_ci->load->database('pk',false, true);
    }


    function getPoint($result, $iAspekId)
    {
        $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        if($result < 0){
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai2 and a.yNilai1";
            
        }else{
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        }
        
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint . "~" . $row->warna;
        } else {
            $value = '20~#FF3333';
        }

        return $value;

    }
    function getPointDynamic($result, $iAspekId)
    {
        if($result < 0){
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_dynamic_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai2 and a.yNilai1";
        }else{
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_dynamic_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        }

        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint . "~" . $row->warna;
        } else {
            $value = '20~#FF3333';
        }

        return $value;

    }
    function hitung_bulan($perode1, $perode2)
    {
        $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
        $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));

        $cek_val ="";
        $bulan=0;
        do { 
            if($cek_val!=$tgl_skr->format("Y-m")){
                // $tgl = $tgl_skr->format("Y-m"); 
                // $htmlxy .= "<td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$tgl."</td> ";
                $bulan++;
            }
            $cek_val=$tgl_skr->format("Y-m");  
            $tgl_skr->modify('-1 month');
        } while ($tgl_skr >= $tgl_lalu);

        // $date1 = new DateTime($perode1);
        // $date2 = new DateTime($perode2);

        // $diff = $date1->diff($date2);
        // $bulan = (($diff->format('%y') * 12) + $diff->format('%m')) + 1;

        return $bulan;
    }

    function sumTime($times)
    {
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


    function datediff($tgl1, $tgl2, $cNip)
    {
        $sql = "SELECT iCompanyId FROM hrd.employee WHERE cNip='" . $cNip . "' ";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $company = $row->iCompanyId;
        }

        $dstart = date('Y-m-d', strtotime($tgl1));
        $dend = date('Y-m-d', strtotime($tgl2));
        $increment = "++";
        if ($dstart > $dend) {
            $dstart = date('Y-m-d', strtotime($tgl2));
            $dend = date('Y-m-d', strtotime($tgl1));
            $increment = "--";
            //echo "Lebih Besar ".$dstart." > ".$dend ;
            //exit();
        }

        $start = new DateTime($dstart);
        $start->modify('+1 day');
        $end = new DateTime($dend);
        $end->modify('+1 day');
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $year1 = date('Y', strtotime($dstart));
        $year2 = date('Y', strtotime($dend));
        //cari hari liburnya
        $sql = "SELECT *
                FROM (SELECT a.dDate AS tgl,a.cYear, 'hol' AS src,a.cdescription AS ket
                      FROM hrd.holiday AS a
                  UNION ALL
                      SELECT b.dDate AS tgl,b.cYear,'cho' AS src,b.vDescription AS ket
                      FROM hrd.compholiday AS b
                        WHERE b.iCompanyId='" . $company . "'
                     )AS tabgab
                   WHERE cyear BETWEEN '" . $year1 . "' AND '" . $year2 . "'";


        $holidays = Array();
        $result = mysql_query($sql) or die(mysql_error() . "</br>" . $sql);

        while ($row = mysql_fetch_assoc($result)) {
            array_push($holidays, $row['tgl']);
        }

        $lama = 0;
        foreach ($period as $dt) {

            $curr = $dt->format('D');
            $tanggal = $dt->format('Y-m-d');
            // for the updated question
            if ($curr == 'Sat' || $curr == 'Sun') {
                continue;
            }
            if (in_array($dt->format('Y-m-d'), $holidays)) {

            } else {
                if ($increment == '++') {
                    $lama++;
                } else {
                    $lama--;
                }

            }


        }

        if ($increment == '++') {
            return $lama + 1;
        } else {
            return $lama - 1;
        }


    }


    function getvName($cNip)
    {

        $vName = '';

        $sql = "SELECT vName FROM hrd.employee WHERE cNip = '{$cNip}' AND lDeleted = 0";
        $query = $this->db_erp_pk->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $vName = $row->vName;
        }

        return $vName;
    }



    //Cek Tanggal libur, dan tanggal kerja
    function selisihHari($tglAwal, $tglAkhir, $nip, $type = "day")
    {
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc = "select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='" . $nip . "' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr = $this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi = "select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '" . $tglAwal . "' AND '" . $tglAkhir . "'";
        $qlholi = $this->dbseth->query($sqlholi);
        if ($qlholi->num_rows() >= 1) {
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        }
        $pecah1 = explode("-", date("Y-m-d", strtotime($tglAwal)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $pecah2 = explode("-", date("Y-m-d", strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 = $pecah2[0];

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1 = 0;
        $libur2 = 0;
        $libur3 = 0;
        for ($i = 1; $i <= $selisih; $i++) {
            $tanggal = mktime(0, 0, 0, $month1, $date1 + $i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            if (in_array($tglstr, $tglLibur)) {
                $libur1++;
            }
            if ((date("N", $tanggal) == 7)) {
                if (in_array($tglstr, $tglLibur)) {
                    $libur1 = $libur1 - 1;
                }
                $libur2++;
            }
            if ((date("N", $tanggal) == 6)) {
                if (in_array($tglstr, $tglLibur)) {
                    $libur1 = $libur1 - 1;
                }
                $libur3++;
            }
        }
        if ($type == 'day') {
            if ($counthr == 5) {
                $hasil = $selisih - $libur1 - $libur2 - $libur3;
            } else {
                $hasil = $selisih - $libur1 - $libur2;
            }
            if ($hasil >= 0) {
                if (date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))) {
                    $hasil = $hasil - 1;
                }
            }
            return $hasil;
        }
        if($type='minute'){
            if($counthr==5){
                $hasil = $selisih-$libur1-$libur2-$libur3;
            }else{
                $hasil = $selisih-$libur1-$libur2;
            }
            $hmennt=0;
            if($hasil>=1){
                if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
                    #$hasil=$hasil-1;
                    $hmennt=(int)$hasil*1440;
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAkhir)),date('H:i:s', strtotime($tglAwal)));
                    $selmnt=1440-(int)$selmnt;
                    $hmennt=$hmennt+(int)$selmnt;
                    return $hmennt;
                }else{
                    $hmennt=(int)$hasil*1440;
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
                    $hmennt=$hmennt+(int)$selmnt;
                    return $hmennt;
                }
            }else{
                if(date('H:i:s', strtotime($tglAkhir)) > date('H:i:s', strtotime($tglAwal))){
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
                    return $selmnt;
                    $hmennt=(int)$selmnt;
                    return $hmennt;
                }else{
                    return "0";
                }
            }
        }

    }

    function CekoptionalFunc11($tgl, $nip)
    {
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc = "select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='" . $nip . "' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr = $this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi = "select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate = '".$tgl."'";
        $qlholi = $this->dbseth->query($sqlholi);
        $retlibur=false;
        if ($qlholi->num_rows() >= 1) {
            $retlibur=true;
        }
        $pecah1 = explode("-", date("Y-m-d", strtotime($tgl)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $tanggal = mktime(0, 0, 0, $month1, $date1, $year1);
        if ((date("N", $tanggal) == 7)) {
             $retlibur=true;
        }
        if ((date("N", $tanggal) == 6)) {
             $retlibur=true;
        }        
        return $retlibur;

    }
    /*===============Start Function=======================*/ 

    function LKS_NBL11_1($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                        
                    </tr>
                </table>";
        $html .= "<table>
                    <tr>
                        <td><h4><b>Total RPB Liquid , Softgel (X)</b></td>
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Type</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Toll</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Import</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Kategori</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Plan Date</b></td>  
            </tr>
        ";


        //Kategory A
        $sql2 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                where 
                a.c_type in ('N')
                and d.c_floor IN ('0001','0003') # lantai 1
                and e.c_kategori in ('L','G') #liquid Softgel
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                order by a.d_plandate ASC
                
                ";

        $sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate,a.c_flgprd, re.d_packing
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                join (select *
                    from sales.recent r 
                    where 
                    r.d_packing >= '".$perode1."'
                    and r.d_packing <= '".$perode2."'
                    and r.iCompanyID=3
                    group by r.c_batchno
                    order by r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb

                where 
                a.c_type in ('N')
                and d.c_floor IN ('0001','0003') # lantai 1
                and e.c_kategori in ('L','G') #liquid Softgel
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                and a.c_flgprd='W'
                order by a.d_plandate ASC
                ";
 
        $b = $this->db_erp_pk->query($sql2)->result_array();
        $c = $this->db_erp_pk->query($sql1)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_type']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_toll']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['l_import']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmfloor']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmkateg']."</td> 

                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_plandate']."</td> 

                          </tr>"; 
                $no++;
            }

            
            $html .= "<table>
                    <tr>
                        <td><b>Total MBR Liquid, Softgel close (Y)</b></td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Status</b></td>  
                    <td style='border: 1px solid #dddddd;' ><b>Packing Date</b></td>  
                </tr>
            ";
            $no1 = 1;
            if(!empty($c)){
                foreach ($c as $v) {
                    if (fmod($no1,2)==0){
                        $color = 'background-color: #eaedce';
                    }else{
                        $color = '';
                    }
                    
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no1."</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_flgprd']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_packing']."</td> 

                              </tr>"; 
                    $no1++;
                }
            }



        } 

        $html .="</table>";
        $totA       = $this->db_erp_pk->query($sql1)->num_rows();
        $totb       = $this->db_erp_pk->query($sql2)->num_rows(); 
        if($totb==0){
            $hasil_b    =0;
        }else{
            $hasil_b    =   $totA / $totb  ;
        }
        
        $result     = number_format($hasil_b * 100,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Total MBR Liquid Softgel close</td>
                        
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x) Total MBR Liquid, Softgel</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr> 

                    

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase Produk (y/x * 100%)</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function LKS_NBL11_4($post)    {
            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
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
                        <tr>
                          <td colspan='2'><span id='download_excel_e' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'><b><i><u>Data Detail !!</u></i></b></span></td>
                        </tr>
                    </table><hr>";

                    $url_download = base_url().'processor/pk/pk_spv_liquid_kapsul_nbl_1_1/?action=download_excel&periode1='.$perode1.'&periode2='.$perode2.'&nip='.$cNipNya;
            $html .= "
                  <script>
                    $('#download_excel_e').die();
                    $('#download_excel_e').live('click', function(){
                       window.open('".$url_download."','_blank');
                    });
                  </script>
                ";

            //Ambil Jenisnya 
            $sqlJenis = 'select distinct(km.ijenis_id), kj.vnama_jenis 
                from kanban.kbn_mesin_waiting kw 
                JOIN kanban.kbn_mbr km on kw.mbr_id = km.id 
                JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                where 
                kmj.ijenis_kategori in (2)
                and kw.proses_qc_id NOT IN ("P0051","P0000","P0008","P0063") 
                and km.iCompany=3
                and kw.mesin_waiting_id NOT IN (
                        SELECT kmw.mesin_waiting_id 
                        FROM kanban.kbn_mesin_waiting kmw 
                        where kmw.proses_qc_id in("P0006","P0010")
                        and kmw.is_proses=0 )
                and kw.mbr_id IN( 
                    SELECT kmw2.mbr_id
                    FROM kanban.kbn_mesin_waiting kmw2 
                    where kmw2.proses_qc_id in("P0010") 
                    and kmw2.is_proses=1 and kmw2.finish_time 
                    BETWEEN "'.$perode1.'" and "'.$perode2.'") ';
            //echo $sqlJenis;exit;
            //$sqlJenis = "SELECT km.ijenis_id, km.vnama_jenis FROM kanban.kbn_master_jenis km where km.isTipeSolid = 1 and km.iDeleted=0";
            $dtJenis = $this->db_erp_pk->query($sqlJenis)->result_array();
            $totalHari = 0 ;
            $totalBatch = 0;
            $num = 1;
            foreach ($dtJenis as $dj) {
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' ><b>".$dj['vnama_jenis']."</b></td> 
                            </tr>
                          </table>
                ";
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='background: #C0C0C0;border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >No</td> 
                                <td style='border: 1px solid #dddddd;' >No Batch</td>
                                <td style='border: 1px solid #dddddd;' >Nama</td>";

                                $sqlP = "SELECT kp.vProses_name, kp.iProses_id FROM kanban.kbn_jenis_proses_rel kpl
                                    JOIN kanban.kbn_master_proses kp on kpl.iProsesQC_id = kp.iProses_id
                                    where kp.iDeleted = 0 and kpl.ijenis_id='".$dj['ijenis_id']."' and kp.iProses_id NOT IN('P0051','P0000','P0008','P0063') ORDER by kpl.iUrutan ASC";
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                foreach ($dpro as $dp) {
                                     $html .= "<td style='border: 1px solid #dddddd;' >".$dp['vProses_name']."</td>";
                                }
                $html .= "<td style='border: 1px solid #dddddd;' >Total</td> </tr>";  

                //Ambil Mbrnya
                $sqlMbr = 'select DISTINCT(km.id),km.vBatch_no, km.vNama from kanban.kbn_mesin_waiting kw 
                    JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                    JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                    join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                    where 
                    kmj.ijenis_kategori in (2)
                    and kw.proses_qc_id NOT IN ("P0051","P0000","P0008","P0063") 
                    and km.iCompany=3
                    and km.ijenis_id = "'.$dj['ijenis_id'].'" 
                    and kw.mbr_id IN( 
                        SELECT kmw2.mbr_id
                        FROM kanban.kbn_mesin_waiting kmw2 
                        where kmw2.proses_qc_id in("P0010") 
                        and kmw2.is_proses=1 and kmw2.finish_time 
                        BETWEEN "'.$perode1.'" and "'.$perode2.'") '; 
                 $dMBR = $this->db_erp_pk->query($sqlMbr)->result_array(); 
                    foreach ($dMBR as $dm) {
                        $totalBatch++;
                        $html .="<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >".$num++."</td> 
                                <td style='border: 1px solid #dddddd;'>".$dm['vBatch_no']."</td>
                                <td style='border: 1px solid #dddddd;'>".$dm['vNama']."</td>"; 
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                $hitung = 0;
                                foreach ($dpro as $dp) {
                                    //Ambil Jenisnya dan Prosess ya termasuk rework lalu di jumlah 
                                    $sqlHari = "select sum(TIMESTAMPDIFF(SECOND,kw.receive_time,kw.finish_time)) as totalhari from kanban.kbn_mesin_waiting kw 
                                         JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                                         JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                                         join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                                        where 
                                        kmj.ijenis_kategori in (2)
                                         and kw.proses_qc_id NOT IN ('P0051','P0000','P0008','P0063') 
                                         and km.iCompany=3
                                         and km.id ='".$dm['id']."' 
                                         and km.ijenis_id = '".$dj['ijenis_id']."' 
                                         and kw.proses_qc_id ='".$dp['iProses_id']."'
                                         and kw.mesin_waiting_id NOT IN (
                                                SELECT kmw.mesin_waiting_id 
                                                FROM kanban.kbn_mesin_waiting kmw 
                                                where kmw.proses_qc_id in('P0006')
                                                and kmw.is_proses=0 )
                                        and kw.mbr_id IN( 
                                            SELECT kmw2.mbr_id
                                            FROM kanban.kbn_mesin_waiting kmw2 
                                            where kmw2.proses_qc_id in('P0010') 
                                            and kmw2.is_proses=1 and kmw2.finish_time 
                                            BETWEEN '".$perode1."' and '".$perode2."')   
                                         ";
                                        $hari = $this->db_erp_pk->query($sqlHari)->row_array();
                                        if(!empty($hari['totalhari'])){
                                            $hari['totalhari'] = number_format(($hari['totalhari']/3600)/24,3);
                                            if($hari['totalhari']==0.000){
                                                $hari['totalhari'] = 0;
                                            }
                                            $html .= "<td style='border: 1px solid #dddddd;' >".$hari['totalhari']." Hari</td>";
                                            $hitung += $hari['totalhari']; 
                                        }else{
                                            $html .= "<td style='border: 1px solid #dddddd;' >0 Hari</td>";
                                        } 
                                        
/*                                        if(!empty($hari['totalhari'])){
                                            $html .= "<td style='border: 1px solid #dddddd;' >".$hari['totalhari']." Hari</td>";
                                            $hitung += $hari['totalhari']; 
                                        }else{
                                            $html .= "<td style='border: 1px solid #dddddd;' >0 Hari</td>";
                                        } */
                                }
                                $html .= "<td style='border: 1px solid #dddddd;'>".$hitung." Hari</td>"; 
                                $html .= "</tr>";   
                                $totalHari += $hitung;
                    }
                 
                 $html .="</table>
                ";
            }
            
            if($totalBatch==0){
                $hasil = 0;
            }else{
                $hasil = $totalHari / $totalBatch;
            }

            $result     = number_format($hasil,2);
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html .= "<br><table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh MBR</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalBatch." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Hari</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalHari." hari</td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." hari</td>
                        </tr>

                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }

    function LKS_NBL11_5($post)    {
            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
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
                        <tr>
                          <td colspan='2'><span id='download_excel_e1' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'><b><i><u>Data Detail !!</u></i></b></span></td>
                        </tr>
                    </table><hr>";

                    $url_download = base_url().'processor/pk/pk_spv_liquid_kapsul_nbl_1_1/?action=download_excel1&periode1='.$perode1.'&periode2='.$perode2.'&nip='.$cNipNya;
            $html .= "
                  <script>
                    $('#download_excel_e1').die();
                    $('#download_excel_e1').live('click', function(){
                       window.open('".$url_download."','_blank');
                    });
                  </script>
                ";

            //Ambil Jenisnya 
            $sqlJenis = 'select distinct(km.ijenis_id), kj.vnama_jenis 
                from kanban.kbn_mesin_waiting kw 
                JOIN kanban.kbn_mbr km on kw.mbr_id = km.id 
                JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                where 
                kmj.ijenis_kategori in (3)
                and kw.proses_qc_id NOT IN ("P0051","P0000","P0008","P0063") 
                and km.iCompany=3
                and kw.mesin_waiting_id NOT IN (
                        SELECT kmw.mesin_waiting_id 
                        FROM kanban.kbn_mesin_waiting kmw 
                        where kmw.proses_qc_id in("P0006","P0005")
                        and kmw.is_proses=0 )
                and kw.mbr_id IN( 
                    SELECT kmw2.mbr_id
                    FROM kanban.kbn_mesin_waiting kmw2 
                    where kmw2.proses_qc_id in("P0005") 
                    and kmw2.is_proses=1 and kmw2.finish_time 
                    BETWEEN "'.$perode1.'" and "'.$perode2.'") ';
            //echo $sqlJenis;exit;
            //$sqlJenis = "SELECT km.ijenis_id, km.vnama_jenis FROM kanban.kbn_master_jenis km where km.isTipeSolid = 1 and km.iDeleted=0";
            $dtJenis = $this->db_erp_pk->query($sqlJenis)->result_array();
            $totalHari = 0 ;
            $totalBatch = 0;
            $num = 1;
            foreach ($dtJenis as $dj) {
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' ><b>".$dj['vnama_jenis']."</b></td> 
                            </tr>
                          </table>
                ";
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='background: #C0C0C0;border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >No</td> 
                                <td style='border: 1px solid #dddddd;' >No Batch</td>
                                <td style='border: 1px solid #dddddd;' >Nama</td>";

                                $sqlP = "SELECT kp.vProses_name, kp.iProses_id FROM kanban.kbn_jenis_proses_rel kpl
                                    JOIN kanban.kbn_master_proses kp on kpl.iProsesQC_id = kp.iProses_id
                                    where kp.iDeleted = 0 and kpl.ijenis_id='".$dj['ijenis_id']."' and kp.iProses_id NOT IN('P0051','P0000','P0008','P0063') ORDER by kpl.iUrutan ASC";
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                foreach ($dpro as $dp) {
                                     $html .= "<td style='border: 1px solid #dddddd;' >".$dp['vProses_name']."</td>";
                                }
                $html .= "<td style='border: 1px solid #dddddd;' >Total</td> </tr>";  

                //Ambil Mbrnya
                $sqlMbr = 'select DISTINCT(km.id),km.vBatch_no, km.vNama from kanban.kbn_mesin_waiting kw 
                    JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                    JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                    join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                    where 
                    kmj.ijenis_kategori in (3)
                    and kw.proses_qc_id NOT IN ("P0051","P0000","P0008","P0063") 
                    and km.iCompany=3
                    and km.ijenis_id = "'.$dj['ijenis_id'].'" 
                    and kw.mbr_id IN( 
                        SELECT kmw2.mbr_id
                        FROM kanban.kbn_mesin_waiting kmw2 
                        where kmw2.proses_qc_id in("P0005") 
                        and kmw2.is_proses=1 and kmw2.finish_time 
                        BETWEEN "'.$perode1.'" and "'.$perode2.'") '; 
                 $dMBR = $this->db_erp_pk->query($sqlMbr)->result_array(); 
                    foreach ($dMBR as $dm) {
                        $totalBatch++;
                        $html .="<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >".$num++."</td> 
                                <td style='border: 1px solid #dddddd;'>".$dm['vBatch_no']."</td>
                                <td style='border: 1px solid #dddddd;'>".$dm['vNama']."</td>"; 
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                $hitung = 0;
                                foreach ($dpro as $dp) {
                                    //Ambil Jenisnya dan Prosess ya termasuk rework lalu di jumlah 
                                    $sqlHari = "select sum(TIMESTAMPDIFF(SECOND,kw.receive_time,kw.finish_time)) as totalhari from kanban.kbn_mesin_waiting kw 
                                         JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                                         JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                                         join kanban.kbn_master_jenis_kategori kmj on kmj.ijenis_kategori = kj.ijenis_kategori
                                        where 
                                        kmj.ijenis_kategori in (3)
                                         and kw.proses_qc_id NOT IN ('P0051','P0000','P0008','P0063') 
                                         and km.iCompany=3
                                         and km.id ='".$dm['id']."' 
                                         and km.ijenis_id = '".$dj['ijenis_id']."' 
                                         and kw.proses_qc_id ='".$dp['iProses_id']."'
                                         and kw.mesin_waiting_id NOT IN (
                                                SELECT kmw.mesin_waiting_id 
                                                FROM kanban.kbn_mesin_waiting kmw 
                                                where kmw.proses_qc_id in('P0006','P0005')
                                                and kmw.is_proses=0 )
                                        and kw.mbr_id IN( 
                                            SELECT kmw2.mbr_id
                                            FROM kanban.kbn_mesin_waiting kmw2 
                                            where kmw2.proses_qc_id in('P0005') 
                                            and kmw2.is_proses=1 and kmw2.finish_time 
                                            BETWEEN '".$perode1."' and '".$perode2."')   
                                         ";
                                        $hari = $this->db_erp_pk->query($sqlHari)->row_array();
                                        if(!empty($hari['totalhari'])){
                                            $hari['totalhari'] = number_format(($hari['totalhari']/3600)/24,3);
                                            if($hari['totalhari']==0.000){
                                                $hari['totalhari'] = 0;
                                            }
                                            $html .= "<td style='border: 1px solid #dddddd;' >".$hari['totalhari']." Hari</td>";
                                            $hitung += $hari['totalhari']; 
                                        }else{
                                            $html .= "<td style='border: 1px solid #dddddd;' >0 Hari</td>";
                                        } 
                                }
                                $html .= "<td style='border: 1px solid #dddddd;'>".$hitung." Hari</td>"; 
                                $html .= "</tr>";   
                                $totalHari += $hitung;
                    }
                 
                 $html .="</table>
                ";
            }
            
            if($totalBatch==0){
                $hasil = 0;
            }else{
                $hasil = $totalHari / $totalBatch;
            }

            $result     = number_format($hasil,2);
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html .= "<br><table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh MBR</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalBatch." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Hari</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalHari." hari</td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." hari</td>
                        </tr>

                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }



    function LKS_NBL11_7($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  

        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah Produk yang di DN Batal Turun</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>DN Number</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Remark</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                </tr>
            ";

        $sqlBatalProd = "SELECT d.c_nmfloor, r.id, r.d_dndate , r.d_datent, r.c_dnnumb, i.c_iteno,i.c_itnam, r.c_batchno, r.c_status, r.c_remark FROM sales.recent r
                 JOIN sales.itemas i on r.c_iteno = i.c_iteno 
                 JOIN purchase.pamsh p on r.c_batchno = p.c_panumb  
                 join purchase.floor d on d.c_floor=p.c_lokasi   
                     WHERE r.d_dndate >= '".$perode1."' and r.d_dndate <= '".$perode2."' and
                     i.l_tolletc <>1 and p.c_jnsmbr = 1   
                     and r.n_dncode = 1 and r.l_canmbr = 1 
                     and d.c_floor IN ('0001','0003') # lantai 1
                     ORDER by r.d_dndate";
        $batal = $this->db_erp_pk->query($sqlBatalProd)->result_array(); 
        $x = 0 ;



        $simpanXperiode = array(); 
        foreach ($batal as $b) {  
             $x++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_batchno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_dnnumb']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$b['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['c_remark']."</td>  
                        <td style='border: 1px solid #dddddd;' >".$b['d_dndate']."</td>  
                      </tr>"; 
             $pecah = explode('-', $b['d_dndate']);
             $stringXo = $pecah['0'].$pecah['1'];  
             $simpanXperiode[$stringXo]++; 
             
        }
        //print_r($simpanXperiode);exit;
        $html .= "</table>";



        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>OPT Batch</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Real Produksi</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Floor</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                    </tr>
            ";
        $tgl1 = $x_prd1['2'].$x_prd1['1'];
        $tgl2 = $x_prd2['2'].$x_prd2['1'];
        $sqlJumlahTurun = "SELECT d.c_nmfloor, r.id, left(r.c_period,4) as perTahun, right(r.c_period,2) as perBulan, r.c_iteno, i.c_itnam, r.n_optbatch,r.c_userid, r3.n_realprod FROM mrp.rpb r 
                JOIN sales.itemas i on i.c_iteno = r.c_iteno
                JOIN mrp.rpb03 r3 on r3.c_iteno = r.c_iteno 

                JOIN purchase.pamsh p on i.c_iteno = p.c_iteno
                join purchase.floor d on d.c_floor=p.c_lokasi 
                where (i.c_export<>'Y' or i.l_import=0) and 
                i.c_status='A' and r3.n_realprod>0 
                and d.c_floor IN ('0001','0003') # lantai 1
                and CONVERT(r.c_period,UNSIGNED INTEGER)>=".$tgl1."
                and CONVERT(r.c_period,UNSIGNED INTEGER)<=".$tgl2."
                GROUP by i.c_iteno
                ";
        $turun = $this->db_erp_pk->query($sqlJumlahTurun)->result_array(); 
        $y = 0 ;
        $simpanYperiode = array(); 
        foreach ($turun as $t) {  
             $y++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_optbatch']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_realprod']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$t['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$t['perTahun']."-".$t['perBulan']."</td>  
                      </tr>"; 
             $stringYo = $t['perTahun'].$t['perBulan'];  
             $simpanYperiode[$stringYo]++; 
        }
        //print_r($simpanYperiode);exit;
        $html .= "</table>";

        $html .= "<br /> ";

        $bulan = $this->hitung_bulan($perode1,$perode2); 

        if($x==0 || $y==0){
            $hasil = 0;
        }else{
            $tot = 0;
            foreach ($simpanXperiode as $k  => $v) {
                if(!empty($simpanYperiode[$k]) || $simpanYperiode[$k]!=0){
                    //echo $k.' : '.$v.'/'.$simpanYperiode[$k].'<br>';
                    $hsl = $v/$simpanYperiode[$k];
                }
                $tot+=$hsl;
            }
            //echo $tot; 
        } 
        $hit = $tot/$bulan;
        $hasil = number_format($hit*100 ,2);
        
        $htmlxy = "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:2%;text-align: left;border: 1px solid #dddddd;'></td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));

                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = $tgl_skr->format("Y-m"); 
                            $htmlxy .= "<td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$tgl."</td> ";
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);
 
                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(x)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanXperiode[$tgl0]) || $simpanXperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanXperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);

                     

                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(y)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanYperiode[$tgl0]) || $simpanYperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanYperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);


        $htmlxy .= "</tr></table>";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x)Jumlah Produk yang di DN Batal Turun</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$x."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</td> 
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$y."</td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Detail Total (x) & (y) per Bulan</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $htmlxy  . "</b></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase MBR (x/y * 100%) per bulan</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$hasil." %</b></td>
                    </tr>
                </table>";      
        
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }


    function LKS_NBL11_8($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;

        $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td style='text-align:left'>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Kode Batch</th>
                            <th>Kode Obat</th>
                            <th>Nama Produk</th>
                            <th>No Rework</th>
                            <th>Rework Ke</th>
                            <th>Jenis</th>
                            <th>Prosess</th>
                            <th>Tanggal Approve Rework</th> 
                        </tr>
            ";

        //Rework Non Steril
        $sql = " SELECT km.vBatch_no, km.vNama, km.vKode_obat, kd.*, kr.*, 
                    kj.vnama_jenis ,kp.vProses_name FROM kanban.kbn_rework kr 
                    JOIN kanban.kbn_rework_detail kd on kr.iRework = kd.iRework
                    JOIN kanban.kbn_mbr km on km.id = kr.mbr_id
                    JOIN kanban.kbn_master_jenis kj on km.ijenis_id = kj.ijenis_id
                    JOIN kanban.kbn_master_jenis_kategori kjk on kjk.ijenis_kategori = kj.ijenis_kategori
                    JOIN kanban.kbn_master_proses kp on kp.iProses_id = kr.iProses_id

                    WHERE 
                        kr.ldeleted = 0 and
                        kd.ldeleted = 0 and 
                        km.iDeleted = 0 and
                        kd.iapp_rework = 2 and 
                        kj.ijenis_kategori in(2,3) and 
                        kd.dapp_rework >= '".$perode1."' and 
                        kd.dapp_rework <= '".$perode2."' ";

        $sql_loop = $this->db_erp_pk->query($sql)->result_array();
        $i=0; 
        foreach ($sql_loop as $sl) {  
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vBatch_no']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vKode_obat']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNama']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNo_request']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['iReq_count']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vnama_jenis']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vProses_name']."</td> 
                         <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($sl['dapp_rework']))."</td> 
                      </tr>"; 
        }

        $bulan = $this->hitung_bulan($perode1, $perode2);
        if($bulan==0){
            $hasil = 0;
        }else{
            $hasil = number_format(($i/$bulan),2);
        } 

        $html .= "</table><table align='left' cellspacing='0' cellpadding='3' style='width: 550px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $i . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .$hasil. "</b></td>
                    </tr> 
                </table>";
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function LKS_NBL11_10($post){

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



    function SPV_Solid_nbl_1_1_P01($post)    {
        
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                        
                    </tr>
                </table>";
        $html .= "<table>
                    <tr>
                        <td><h4><b>Total MBR solid, Liquid, Softgel, dan Steril. (X)</b></td>
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Type</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Toll</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Import</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Kategori</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Plan Date</b></td>  
            </tr>
        ";


        //Kategory A
        $sql2 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                where 
                a.c_type in ('R')
                #and b.c_toll = 'N'
                #and b.l_import= 0

                and (d.c_floor='0003' or d.c_floor='0001')
                and (e.c_kategori = 'S' or e.c_kategori = 'L' or e.c_kategori = 'G' or e.c_kategori = 'I')  
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                order by a.d_datent,a.d_plandate DESC
                
                ";

        $sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate,a.c_flgprd, re.d_packing
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                join (select *
                    from sales.recent r 
                    where 
                    r.d_packing >= '".$perode1."'
                    and r.d_packing <= '".$perode2."'
                    and r.iCompanyID=3
                    group by r.c_batchno
                    order by r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb

                where  
                a.c_type in ('R')
                #and b.c_toll = 'N'
                #and b.l_import= 0
                
                and (d.c_floor='0003' or d.c_floor='0001')
                and (e.c_kategori = 'S' or e.c_kategori = 'L' or e.c_kategori = 'G' or e.c_kategori = 'I')  
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                and a.c_flgprd='W'
                order by a.c_panumb,a.d_plandate DESC
                
                ";
        /*$sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                where 
                ( a.c_type in ('R','N')
                or b.c_toll = 'Y'
                or b.l_import= 0
                )
                and d.c_floor='0002'
                and e.c_kategori = 'I' #steril
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                and a.c_flgprd='W'
                order by a.d_datent DESC
                
                ";*/


        //Non Kategory A
       /* $sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam, re.d_packing
                from purchase.pamsh a 
                join sales.itemas b on b.c_iteno=a.c_iteno
                join (select *
                    from sales.recent r 
                    where 
                    r.d_packing >= '".$perode1."'
                    and r.d_packing <= '".$perode2."'
                    and r.iCompanyID=3
                    group by r.c_batchno
                    order by r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb
                where a.c_flgprd='W'

                "; */
 
        $b = $this->db_erp_pk->query($sql2)->result_array();
        $c = $this->db_erp_pk->query($sql1)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_type']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_toll']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['l_import']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmfloor']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmkateg']."</td> 

                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_plandate']."</td> 

                          </tr>"; 
                $no++;
            }

            
            $html .= "<table>
                    <tr>
                        <td><b>Total MBR steril close (Y)</b></td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Status</b></td>  
                    <td style='border: 1px solid #dddddd;' ><b>Packing Date</b></td>  
                </tr>
            ";
            $no1 = 1;
            if(!empty($c)){
                foreach ($c as $v) {
                    if (fmod($no1,2)==0){
                        $color = 'background-color: #eaedce';
                    }else{
                        $color = '';
                    }
                    
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no1."</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_flgprd']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_packing']."</td> 

                              </tr>"; 
                    $no1++;
                }
            }



        } 

        $html .="</table>";
        $totA       = $this->db_erp_pk->query($sql1)->num_rows();
        $totb       = $this->db_erp_pk->query($sql2)->num_rows(); 
        if($totb==0){
            $hasil_b    =0;
        }else{
            $hasil_b    =   $totA / $totb  ;
        }
        
        $result     = number_format($hasil_b * 100,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 550px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x) Total MBR solid, Liquid, Softgel, dan Steril.</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Total MBR solid, Liquid, Softgel, dan Steril close</td>
                        
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>

                    

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase Produk (y/x * 100%)</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

   
     
    function SPV_Solid_nbl_1_1_P06($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;

        $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td style='text-align:left'>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Kode Batch</th>
                            <th>Kode Obat</th>
                            <th>Nama Produk</th>
                            <th>No Rework</th>
                            <th>Rework Ke</th>
                            <th>Jenis</th>
                            <th>Prosess</th>
                            <th>Tanggal Approve Rework</th> 
                        </tr>
            ";

        //Rework Non Steril
        $sql = " SELECT km.vBatch_no, km.vNama, km.vKode_obat, kd.*, kr.*, 
                    kj.vnama_jenis ,kp.vProses_name FROM kanban.kbn_rework kr 
                    JOIN kanban.kbn_rework_detail kd on kr.iRework = kd.iRework
                    JOIN kanban.kbn_mbr km on km.id = kr.mbr_id
                    JOIN kanban.kbn_master_jenis kj on km.ijenis_id = kj.ijenis_id
                    JOIN kanban.kbn_master_proses kp on kp.iProses_id = kr.iProses_id
                    WHERE 
                        kr.ldeleted = 0 and
                        kd.ldeleted = 0 and 
                        km.iDeleted = 0 and
                        kd.iapp_rework = 2 and 
                        kj.isTipeSolid = 1 and #tambahan untuk solid add di sono
                        kd.dapp_rework >= '".$perode1."' and 
                        kd.dapp_rework <= '".$perode2."' ";

        $sql_loop = $this->db_erp_pk->query($sql)->result_array();
        $i=0; 
        foreach ($sql_loop as $sl) {  
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vBatch_no']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vKode_obat']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNama']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNo_request']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['iReq_count']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vnama_jenis']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vProses_name']."</td> 
                         <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($sl['dapp_rework']))."</td> 
                      </tr>"; 
        }

        $bulan = $this->hitung_bulan($perode1, $perode2);
        if($bulan==0){
            $hasil = 0;
        }else{
            $hasil = number_format(($i/$bulan),2);
        } 

        $html .= "</table><table align='left' cellspacing='0' cellpadding='3' style='width: 550px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $i . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .$hasil. "</b></td>
                    </tr> 
                </table>";
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }


    function SPV_Solid_nbl_1_1_P08($post)    {
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
            //                  kp.vBatch_no, mm.vNama, mm.vKode_obat
            //              FROM kanban.kbn_pejadwalan_mbr k
            //                  JOIN kanban.kbn_pejadwalan_mbr_detail  kp ON kp.ipejadwalan_mbr = k.ipejadwalan_mbr
            //                  JOIN  kanban.kbn_master_group_produksi km ON km.igroup_produksi = kp.igroup_produksi
            //                  JOIN kanban.kbn_master_produksi_company kc ON kc.iproduksi_company = k.iproduksi_company
            //                  JOIN kanban.kbn_mbr mm ON mm.id = kp.mbr_id
            //                      WHERE km.iKode IN("PBL","PBE")
            //                      AND kp.dplan_memo IS NOT NULL AND kp.dplan_memo <>"0000-00-00 00:00:00"
            //                      AND kp.dPenjadwalan < kp.dplan_memo
            //                      AND km.ldeleted=0 AND kc.ldeleted=0
            //                      AND kp.dPenjadwalan >= "'.$perode1.'"
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

            $result     = 0;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];
            echo $result."~".$point."~".$warna."~".$html;
    }

    function SPV_Solid_nbl_1_1_P04($post)    {
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

            //Ambil Jenisnya 
            $sqlJenis = 'select distinct(km.ijenis_id), kj.vnama_jenis from kanban.kbn_mesin_waiting kw 
                JOIN kanban.kbn_mbr km on kw.mbr_id = km.id 
                JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                where kj.isTipeSolid = 1 and kw.proses_qc_id NOT IN ("P0051","P0000","P0008") and km.iCompany=3
                and kw.mesin_waiting_id NOT IN (
                        SELECT kmw.mesin_waiting_id 
                        FROM kanban.kbn_mesin_waiting kmw 
                        where kmw.proses_qc_id in("P0006","P0005")
                        and kmw.is_proses=0 )
                and kw.mbr_id IN( 
                    SELECT kmw2.mbr_id
                    FROM kanban.kbn_mesin_waiting kmw2 
                    where kmw2.proses_qc_id in("P0005") 
                    and kmw2.is_proses=1 and kmw2.receive_time 
                    BETWEEN "'.$perode1.'" and "'.$perode2.'") ';
            //echo $sqlJenis;exit;
            //$sqlJenis = "SELECT km.ijenis_id, km.vnama_jenis FROM kanban.kbn_master_jenis km where km.isTipeSolid = 1 and km.iDeleted=0";
            $dtJenis = $this->db_erp_pk->query($sqlJenis)->result_array();
            foreach ($dtJenis as $dj) {
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='border: 1px solid #dddddd; background: #b5f2a6; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' ><b>".$dj['vnama_jenis']."</b></td> 
                            </tr>
                          </table>
                ";
                $html .= "<table cellspacing='0' cellpadding='3' width='950px'>
                            <tr style='background: #C0C0C0;border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >No</td>
                                <td style='border: 1px solid #dddddd;' >MBR</td>
                                <td style='border: 1px solid #dddddd;' >BATCH</td>
                                <td style='border: 1px solid #dddddd;' >Nama</td>";

                                $sqlP = "SELECT kp.vProses_name, kp.iProses_id FROM kanban.kbn_jenis_proses_rel kpl
                                    JOIN kanban.kbn_master_proses kp on kpl.iProsesQC_id = kp.iProses_id
                                    where kp.iDeleted = 0 and kpl.ijenis_id='".$dj['ijenis_id']."' and kp.iProses_id NOT IN('P0051','P0000','P0008') ORDER by kpl.iUrutan ASC";
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                foreach ($dpro as $dp) {
                                     $html .= "<td style='border: 1px solid #dddddd;' >".$dp['vProses_name']."</td>";
                                }
                $html .= "<td style='border: 1px solid #dddddd;' >Total</td> </tr>";  

                //Ambil Mbrnya
                $sqlMbr = 'select DISTINCT(km.id),km.vBatch_no, km.vNama from kanban.kbn_mesin_waiting kw 
                    JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                    JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                    where kj.isTipeSolid = 1 and kw.proses_qc_id NOT IN ("P0051","P0000","P0008") and km.iCompany=3
                    and km.ijenis_id = "'.$dj['ijenis_id'].'" 
                    and kw.mbr_id IN( 
                        SELECT kmw2.mbr_id
                        FROM kanban.kbn_mesin_waiting kmw2 
                        where kmw2.proses_qc_id in("P0005") 
                        and kmw2.is_proses=1 and kmw2.receive_time 
                        BETWEEN "'.$perode1.'" and "'.$perode2.'") ';
                 $num = 1;
                 $dMBR = $this->db_erp_pk->query($sqlMbr)->result_array(); 
                    foreach ($dMBR as $dm) {
                        $html .="<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='border: 1px solid #dddddd;' >".$num++."</td>
                                <td style='border: 1px solid #dddddd;'>".$dm['id']."</td>
                                <td style='border: 1px solid #dddddd;'>".$dm['vBatch_no']."</td>
                                <td style='border: 1px solid #dddddd;'>".$dm['vNama']."</td>"; 
                                $dpro = $this->db_erp_pk->query($sqlP)->result_array();
                                $hitung = 0;
                                foreach ($dpro as $dp) {
                                    //Ambil Jenisnya dan Prosess ya termasuk rework lalu di jumlah 
                                    $sqlHari = "select sum(datediff(kw.finish_time,kw.receive_time)) as totalhari from kanban.kbn_mesin_waiting kw 
                                         JOIN kanban.kbn_mbr km on kw.mbr_id = km.id
                                         JOIN kanban.kbn_master_jenis kj on kj.ijenis_id = km.ijenis_id
                                         where kj.isTipeSolid = 1 and kw.proses_qc_id NOT IN ('P0051','P0000','P0008') and km.iCompany=3
                                         and km.id ='".$dm['id']."' 
                                         and km.ijenis_id = '".$dj['ijenis_id']."' 
                                         and kw.proses_qc_id ='".$dp['iProses_id']."'
                                         and kw.mesin_waiting_id NOT IN (
                                                SELECT kmw.mesin_waiting_id 
                                                FROM kanban.kbn_mesin_waiting kmw 
                                                where kmw.proses_qc_id in('P0006','P0005')
                                                and kmw.is_proses=0 )
                                        and kw.mbr_id IN( 
                                            SELECT kmw2.mbr_id
                                            FROM kanban.kbn_mesin_waiting kmw2 
                                            where kmw2.proses_qc_id in('P0005') 
                                            and kmw2.is_proses=1 and kmw2.receive_time 
                                            BETWEEN '".$perode1."' and '".$perode2."')   
                                         ";
                                        $hari = $this->db_erp_pk->query($sqlHari)->row_array();
                                        if(!empty($hari['totalhari'])){
                                            $html .= "<td style='border: 1px solid #dddddd;' >".$hari['totalhari']." Hari</td>";
                                            $hitung += $hari['totalhari'];
                                        }else{
                                            $html .= "<td style='border: 1px solid #dddddd;' >0 Hari</td>";
                                        } 
                                }
                                $html .= "<td style='border: 1px solid #dddddd;'>".$hitung." Hari</td>"; 
                                $html .= "</tr>";   
                    }
                 
                 $html .="</table>
                ";
            }
             
            $result     = 0;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];
            echo $result."~".$point."~".$warna."~".$html;
    }
 
    function SPV_Solid_nbl_1_1_P05($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  

        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah Produk yang di DN Batal Turun</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>DN Number</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Remark</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                </tr>
            ";

        $sqlBatalProd = "SELECT d.c_nmfloor, r.id, r.d_dndate , r.d_datent, r.c_dnnumb, i.c_iteno,i.c_itnam, r.c_batchno, r.c_status, r.c_remark FROM sales.recent r
                 JOIN sales.itemas i on r.c_iteno = i.c_iteno 
                 JOIN purchase.pamsh p on r.c_batchno = p.c_panumb  
                 join purchase.floor d on d.c_floor=p.c_lokasi   
                     WHERE r.d_dndate >= '".$perode1."' and r.d_dndate <= '".$perode2."' and
                     i.l_tolletc <>1 and p.c_jnsmbr = 1   
                     and r.n_dncode = 1 and r.l_canmbr = 1 and (d.c_floor='0003' or d.c_floor='0001')
                ORDER by r.d_dndate";
        $batal = $this->db_erp_pk->query($sqlBatalProd)->result_array(); 
        $x = 0 ;



        $simpanXperiode = array(); 
        foreach ($batal as $b) {  
             $x++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_batchno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_dnnumb']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$b['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['c_remark']."</td>  
                        <td style='border: 1px solid #dddddd;' >".$b['d_dndate']."</td>  
                      </tr>"; 
             $pecah = explode('-', $b['d_dndate']);
             $stringXo = $pecah['0'].$pecah['1'];  
             $simpanXperiode[$stringXo]++; 
             
        }
        //print_r($simpanXperiode);exit;
        $html .= "</table>";



        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>OPT Batch</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Real Produksi</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Floor</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                    </tr>
            ";
        $tgl1 = $x_prd1['2'].$x_prd1['1'];
        $tgl2 = $x_prd2['2'].$x_prd2['1'];
        $sqlJumlahTurun = "SELECT d.c_nmfloor, r.id, left(r.c_period,4) as perTahun, right(r.c_period,2) as perBulan, r.c_iteno, i.c_itnam, r.n_optbatch,r.c_userid, r3.n_realprod FROM mrp.rpb r 
                JOIN sales.itemas i on i.c_iteno = r.c_iteno
                JOIN mrp.rpb03 r3 on r3.c_iteno = r.c_iteno 

                JOIN purchase.pamsh p on i.c_iteno = p.c_iteno
                join purchase.floor d on d.c_floor=p.c_lokasi 
                where (i.c_export<>'Y' or i.l_import=0) and 
                i.c_status='A' and r3.n_realprod>0 
                and (d.c_floor='0003' or d.c_floor='0001') 
                and CONVERT(r.c_period,UNSIGNED INTEGER)>=".$tgl1."
                and CONVERT(r.c_period,UNSIGNED INTEGER)<=".$tgl2."
                GROUP by i.c_iteno
                ";
        $turun = $this->db_erp_pk->query($sqlJumlahTurun)->result_array(); 
        $y = 0 ;
        $simpanYperiode = array(); 
        foreach ($turun as $t) {  
             $y++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_optbatch']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_realprod']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$t['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$t['perTahun']."-".$t['perBulan']."</td>  
                      </tr>"; 
             $stringYo = $t['perTahun'].$t['perBulan'];  
             $simpanYperiode[$stringYo]++; 
        }
        //print_r($simpanYperiode);exit;
        $html .= "</table>";
        /*
            SELECT r.id, r.c_period, r.c_iteno, i.c_itnam, r.n_optbatch,r.c_userid, r3.n_realprod FROM mrp.rpb r 
                JOIN sales.itemas i on i.c_iteno = r.c_iteno
                JOIN mrp.rpb03 r3 on r3.c_iteno = r.c_iteno 
                where (i.c_export<>'Y' or i.l_import=0) and 
                i.c_status='A' and r3.n_realprod>0 
                and CONVERT(r.c_period,UNSIGNED INTEGER)>=201707
                and CONVERT(r.c_period,UNSIGNED INTEGER)<=201712
    
        */
        /*
            SELECT r.id, r.d_datent, r.c_dnnumb, i.c_iteno,i.c_itnam, r.c_batchno, r.c_status, r.c_remark FROM sales.recent r
                 JOIN sales.itemas i on r.c_iteno = i.c_iteno 
                 JOIN purchase.pamsh p on r.c_batchno = p.c_panumb 
                     WHERE r.d_dndate >= "2017-07-01" and r.d_dndate <= "2018-12-31" and
                     i.l_tolletc <>1 and p.c_jnsmbr = 1 
                     and r.n_dncode = 1 and r.l_canmbr = 1 
                ORDER by r.d_dndate
        */

        $html .= "<br /> ";

        $bulan = $this->hitung_bulan($perode1,$perode2); 

        if($x==0 || $y==0){
            $hasil = 0;
        }else{
            $tot = 0;
            foreach ($simpanXperiode as $k  => $v) {
                if(!empty($simpanYperiode[$k]) || $simpanYperiode[$k]!=0){
                    //echo $k.' : '.$v.'/'.$simpanYperiode[$k].'<br>';
                    $hsl = $v/$simpanYperiode[$k];
                }
                $tot+=$hsl;
            }
            //echo $tot; 
        } 
        $hit = $tot/$bulan;
        $hasil = number_format($hit*100 ,2);
        
        $htmlxy = "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:2%;text-align: left;border: 1px solid #dddddd;'></td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));

                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = $tgl_skr->format("Y-m"); 
                            $htmlxy .= "<td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$tgl."</td> ";
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);
 
                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(x)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanXperiode[$tgl0]) || $simpanXperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanXperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);

                     

                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(y)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanYperiode[$tgl0]) || $simpanYperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanYperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);


        $htmlxy .= "</tr></table>";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x)Jumlah Produk yang di DN Batal Turun</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$x."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</td> 
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$y."</td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Detail Total (x) & (y) per Bulan</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $htmlxy  . "</b></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase MBR (x/y * 100%) per bulan</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$hasil." %</b></td>
                    </tr>
                </table>";      
        
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }



}
?>