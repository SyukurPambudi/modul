<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pd_sourch {
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



    /* -- */

    /*AD N14615 Start*/
        function PDS_getParameter3($post){
            
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

            $iMont = 1;
            if($x_prd2['1']==12){
                $iMont = 2;
            }

            $iTahun = $x_prd2['2'];

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

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>No Request </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>No Penerimaan </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Approve <br>Request Sample</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Approve <br>Terima Sample</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Selisih Hari</b></td> 
                    <td style='border: 1px solid #dddddd;width:50px;' ><b>Hari Libur </br>(hari)</b></td>
                    <td style='border: 1px solid #dddddd;width:50px;' ><b>hari Kerja</br>(hari)</b></td>  
                    
                </tr>
            ";
     
            //DDS
            $sql2 = "
                SELECT c.iupb_id,c.vupb_nomor,c.vupb_nama,a.ireq_id,date(a.tapppd) as tappreq
                ,(  select date(ro1.tapp_pur)
                    from plc2.plc2_upb_ro ro1
                    join plc2.plc2_upb_ro_detail rod1 on rod1.iro_id=ro1.iro_id
                    join plc2.plc2_upb_request_sample urs on urs.ireq_id=rod1.ireq_id
                    where ro1.ldeleted=0
                    and rod1.ldeleted=0
                    and ro1.tapp_pur is not null
                    and urs.ireq_id =a.ireq_id
                    and date(ro1.tapp_pur)  >= '".$perode1."'
                    and date(ro1.tapp_pur)  <= '".$perode2."'
                    order by ro1.iro_id ASC limit 1
                    
                    ) as tapppurch

                ,(  select ro1.vro_nomor
                    from plc2.plc2_upb_ro ro1
                    join plc2.plc2_upb_ro_detail rod1 on rod1.iro_id=ro1.iro_id
                    join plc2.plc2_upb_request_sample urs on urs.ireq_id=rod1.ireq_id
                    where ro1.ldeleted=0
                    and rod1.ldeleted=0
                    and ro1.tapp_pur is not null
                    and urs.ireq_id =a.ireq_id
                    and date(ro1.tapp_pur)  >= '".$perode1."'
                    and date(ro1.tapp_pur)  <= '".$perode2."'
                    order by ro1.iro_id ASC limit 1
                    
                    ) as vro_nomor
                ,a.vreq_nomor
                from plc2.plc2_upb_request_sample a 
                join plc2.plc2_upb_request_sample_detail b on b.ireq_id=a.ireq_id
                join plc2.plc2_upb c on c.iupb_id=a.iupb_id
                
                where a.ldeleted=0
                and b.ldeleted=0
                #untuk pilot
                and a.iTujuan_req =3
                and c.ldeleted=0
                #bukan otc
                and c.itipe_id <>6

                #prioritas ada pada periode PK
                and c.iupb_id in (select upd.iupb_id 
                from plc2.plc2_upb_prioritas up 
                join plc2.plc2_upb_prioritas_detail upd on upd.iprioritas_id=up.iprioritas_id
                where up.ldeleted=0
                and upd.ldeleted=0
                and up.imonth='".$iMont."'
                and up.iyear='".$iTahun."'
                )

                #sudah approval terima dari supplier
                and a.ireq_id  in (
                    select rod.ireq_id
                    from plc2.plc2_upb_ro ro
                    join plc2.plc2_upb_ro_detail rod on rod.iro_id=ro.iro_id
                    where ro.ldeleted=0
                    and rod.ldeleted=0
                    and ro.tapp_pur is not null
                    and date(ro.tapp_pur)  >= '".$perode1."'
                    and date(ro.tapp_pur)  <= '".$perode2."'
                )
            ";
            //echo '<pre>'.$sql2.'</pre>';
            /*$sql2 ="SELECT pu.iteamad_id,pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.imaster_delivery, pu.tconfirm_dok_pd FROM plc2.plc2_upb pu 
                    WHERE pu.`ldeleted` = 0 
                    #AND pu.`iteampd_id` = 2 
                    AND pu.iteamad_id = 69
                    AND pu.`itipe_id` NOT IN(6) 
                    AND pu.iconfirm_dok_pd=1 
                    AND pu.tconfirm_dok_pd IS NOT NULL 
                    AND pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'"; */
     
            $b = $this->db_erp_pk->query($sql2)->result_array();
            $no = 1;
            $dds = 0;
            $req = 0;
            if(!empty($b)){
                foreach ($b as $v) {
                    if (fmod($no,2)==0){
                        $color = 'background-color: #eaedce';
                    }else{
                        $color = '';
                    }
                    

                    $start = strtotime($v['tappreq']);
                    $end   = strtotime($v['tapppurch']);
                    $diff  = $end - $start;

                    $hari = floor($diff / (60 * 60 * 24));
                    
                    /*Selisih HPR*/
                    $perode1=$v['tappreq'];
                    $perode2=$v['tapppurch'];
                    $se=$this->selisihHari($perode1, $perode2, $cNipNya);
                    $offkerjahpr=$this->getHoliday($perode1, $perode2, $cNipNya,'offkerja');
                    $hrliburbruttohpr=$this->getHoliday($perode1, $perode2, $cNipNya,'offbrutto');
                    $holidayhpr=$this->getHoliday($perode1, $perode2, $cNipNya);
                    $offhpr=$offkerjahpr+$holidayhpr;
                    $counthpr[]=$se;



                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$v['vupb_nomor']."</td> 
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$v['vupb_nama']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vreq_nomor']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vro_nomor']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['tappreq']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['tapppurch']."</td> 
                                <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$hari."</td>
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$offhpr."</td>
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$se."</td>
                                
                              </tr>"; 
                    

                    
                        $dds+=$se;

                    $no++;
                    $req++;
                }
            } 

            $html .="</table>"; 
            $totDDS     = $dds;
            $totb       = $this->db_erp_pk->query($sql2)->num_rows();  
            
            $result=0;
            if($req > 0){
               $result = (($totDDS/22) /$req) ;
            }

            $result     = number_format($result,2);
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
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Request</td>
                            
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$req." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Hari</td>
                            
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totDDS." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata Bulan</td>
                            
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>

                        
     
                    </table>";
            echo $result."~".$point."~".$warna."~".$html;
        }  

        

    /*AD N14615 End*/


     /*AD ARIES-------------------------------------------------------------------*/
    
       
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



    /*AD N15748 Start*/

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
