<?php

class lib_pk_spv_nbl_1_1
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
        $date1 = new DateTime($perode1);
        $date2 = new DateTime($perode2);

        $diff = $date1->diff($date2);
        $bulan = (($diff->format('%y') * 12) + $diff->format('%m')) + 1;

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
    function PK_SPV_PKG_2($post)    {
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
                        <td><h4><b>Total RPB Steril (X)</b></td>
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
        $sql2 ="SELECT a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                FROM purchase.pamsh a
                JOIN sales.itemas b ON b.c_iteno =a.c_iteno AND a.iCompanyID=3
                JOIN sales.jenis c ON c.c_jenis=b.c_jenis  AND c.iCompanyID=3
                JOIN mrp.kategori e ON e.c_kategori=c.c_kategori AND e.iCompanyID=3
                JOIN purchase.floor d ON d.c_floor=a.c_lokasi  AND d.iCompanyID=3
                WHERE 
                ( a.c_type in ('R','N')
                    OR b.c_toll = 'Y'
                    OR b.l_import= 0
                )
                AND d.c_floor IN ('0001','0003')
                #AND e.c_kategori = 'I' #steril
                AND a.iCompanyID=3
                AND a.d_plandate >= '".$perode1."'
                AND a.d_plandate <= '".$perode2."'
                ORDER BY a.d_plandate DESC
                
                ";

        $sql1 ="SELECT a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate,a.c_flgprd, re.d_packing
                FROM purchase.pamsh a
                JOIN sales.itemas b ON b.c_iteno =a.c_iteno AND a.iCompanyID=3
                JOIN sales.jenis c ON c.c_jenis=b.c_jenis  AND c.iCompanyID=3
                JOIN mrp.kategori e ON e.c_kategori=c.c_kategori AND e.iCompanyID=3
                JOIN purchase.floor d ON d.c_floor=a.c_lokasi  AND d.iCompanyID=3
                JOIN (SELECT *
                        FROM sales.recent r 
                        WHERE 
                        r.d_packing >= '".$perode1."'
                        AND r.d_packing <= '".$perode2."'
                        AND r.iCompanyID=3
                        GROUP BY r.c_batchno
                        ORDER BY r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb

                WHERE 
                ( a.c_type in ('R','N')
                OR b.c_toll = 'Y'
                OR b.l_import= 0
                )
                AND d.c_floor IN ('0001','0003')
                #AND e.c_kategori = 'I' #steril
                AND a.iCompanyID=3
                AND a.d_plandate >= '".$perode1."'
                AND a.d_plandate <= '".$perode2."'
                AND a.c_flgprd='W'
                ORDER BY a.d_plandate DESC
                
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
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x) Total MBR Steril</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Total MBR steril close</td>
                        
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>

                    

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase Produk (y/x * 100%)</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
}
?>