<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pk_nonsteril {
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
    function QC_NONSTERIL_6($post){

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
                        ,b.d_packing as f5,b.c_timepack,b.c_packuser
                        ,d.d_qc as altf6 ,d.c_qc,d.c_qcby
                        ,b.c_status
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


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>No DN</th>
                            <th>Tanggal F5</th>
                            <th>Tanggal ALT F6</th>
                            <th>Selisih</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;
            $totSelisih = 0;
            foreach ($bacthDetail as $ub) {

                $f6     = strtotime($ub['f5']);
                $altf6  = strtotime($ub['altf6']);
                $diff   = $altf6 - $f6;
                //$selisih = abs(floor($diff / (60 * 60 * 24)));

                //function selisihHari($tglAwal, $tglAkhir, $nip, $type="day");
                $selisih = $this->selisihHari($ub['f5'],$ub['altf6'],$cNipNya);

                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_iteno']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_itnam']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['c_dnnumb']."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['f5']))."</td>
                             <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['altf6']))."</td>
                             <td style='border: 1px solid #dddddd;'>".$selisih."</td>
                          </tr>";
                $totSelisih +=$selisih;
            }

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
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totSelisih." </td>
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


    /*AD N14615 End*/
    function QC_NONSTERIL_2($post){
            //Hitungan Sudah OK, Rencana Ambil data temporary update setiap jam 12 Malem per 10 Semester
            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
            //$perode1 = "2017-01-01";

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];
            //$perode2 = "2017-05-05";

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            //Query Untuk Cari Yang Finish dulu
            $sql = 'select CONCAT(d.id, "-", j.iProses_id) as keykey ,j.iProses_id,d.id as mbr_id,d.vNama as nm_produk ,
              e.vnama_jenis,h.vName as group_proses_qc,j.vProses_name,i.vName as nm_zat,
              d.vBatch_no,a.iCount,a.mapping_proses_perkategori_id,a.qc_mesin_waiting_id,a.mesin_waiting_id,d.vKode_obat
      				from kanban.kbn_qc_mesin_waiting a
      				join kanban.kbn_qc_mesin_waiting_detail b on b.qc_mesin_waiting_id=a.qc_mesin_waiting_id
      				join kanban.kbn_mesin_waiting c on c.mesin_waiting_id=a.mesin_waiting_id
      				join kanban.kbn_mbr d on d.id=c.mbr_id
      				join kanban.kbn_master_jenis e on e.ijenis_id=d.ijenis_id
      				join kanban.kbn_qc_master_mapping_proses_perkategori f on f.mapping_proses_perkategori_id=a.mapping_proses_perkategori_id
      				join kanban.kbn_qc_master_proses_group g on g.iProses_id=c.proses_qc_id
      				join kanban.kbn_qc_master_group_kategori h on h.group_kategori_id=g.group_kategori_id
      				join kanban.kbn_qc_master_zat_aktif i on i.zat_aktif_id=f.zat_aktif_id
      				join kanban.kbn_master_proses j on j.iProses_id=g.iProses_id
      				where
      				a.iDeleted=0
      				and b.iDeleted=0
      				and d.iDeleted=0
      				and e.iDeleted=0
      				and f.iDeleted=0
      				and g.iDeleted=0
      				and h.iDeleted=0
      				and i.iDeleted=0
      				and a.iReleaseQC = 2
              and a.iMerge = 1
              and a.qc_mesin_waiting_id in (
									select qc_mesin_waiting_id
									from kanban.kbn_qc_mesin_waiting_detail a
									where
									a.iDeleted=0
									and (a.dFinish_time is not null or a.dFinish_time !="0000-00-00 00:00:00")
									and a.dFinish_time >="'.$perode1.'"
                  and a.dFinish_time <="'.$perode2.'"
								)
      				group by a.qc_mesin_waiting_id order by keykey ';


              $this->db_erp_pk->cache_on();
              $rows  = $this->db_erp_pk->query($sql)->result_array();
              //Load semua data yang ada di qc yang udah release
              $i = 1;
              $vKode_obat_in = "";
              $loop = 0;
              //Dapetin Kode Produk yang Abis pada qc Terakhir
              foreach($rows as $cell){
                $sqlCek = "select distinct(a.vProses_akhir) as grup_id,c.iProses_id
                    from kanban.kbn_qc_master_mapping_proses_perkategori a
                    join kanban.kbn_qc_master_proses_group c on c.master_proses_group_id=a.vProses_akhir
                    join kanban.kbn_qc_master_group_kategori b on b.group_kategori_id=c.group_kategori_id
                    where a.iDeleted=0
                    and b.iDeleted=0
                    and a.vKode_obat='".$cell['vKode_obat']."' order by a.mapping_proses_perkategori_id DESC LIMIT 1";
                $cek = $this->db_erp_pk->query($sqlCek)->row_array();
                if(!empty($cek['iProses_id']) && $cek['iProses_id']==$cell['iProses_id']){
                  if($loop==0){
                    $vKode_obat_in .='"'.$cell['vKode_obat'].'"';
                  }else{
                    $vKode_obat_in .=',"'.$cell['vKode_obat'].'"';
                  }
                  $loop++;
                }
          		}


              $html = "
                      <table cellspacing='0' cellpadding='3' width='850px'>
                          <tr>
                              <td><b>Point Untuk Aspek :</b></td>
                              <td>".$vAspekName."</td>
                          </tr>
                      </table><br><hr>";


              $html .= "<table cellspacing='0' cellpadding='3' width='850px' border=1>
                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th rowspan='4'>No</th>
                            <th rowspan='4'>Nama Produk</th>
                            <th rowspan='4'>No Batch</th>
                            <th rowspan='4'>Kategori</th>

                            <th rowspan='4'>Kategori Proses</th>
                            <th rowspan='4'>Zat Aktif</th>


                          </tr>

                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th colspan='2'>Preparation</th>
                            <th colspan='2'>Pengelolaan</th>
                            <th rowspan='3'>Selisih Hari<br>(Non Hari Kerja)</th>
                            <th rowspan='3'>Selisih Hari<br>(Hari Kerja)</th>
                          </tr>

                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th colspan='2'>Waiting</th>
                            <th colspan='2'>Proses</th>
                          </tr>
                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>Mulai</th>
                            <th>Selesai</th>

                            <th>Mulai</th>
                            <th>Selesai</th>

                          </tr>
              ";

            $totdata   = 0;
            $totalhari = 0;
            $perio = $perode1.'/'.$perode2;
            $sqlDataLo = "SELECT * FROM kanban.temporary_pk_non_steril t where
                        t.vKode_obat IN(".$vKode_obat_in.") AND t.iCompany=3 AND t.dPeriode='".$perio."'";
            $rows_all = $this->db_erp_pk->query($sqlDataLo)->result_array();
            $key ='';
            $jum ='';
            $totdata   = 0;
            $totalhari = 0;
            foreach($rows_all as $cell){
                if(isset($total[$cell['keykey']]['jml'])) {
                  $total[$cell['keykey']]['jml']++;
                }else{
                  $total[$cell['keykey']]['jml']=1;
                }
            }
            foreach ($rows_all as $data) {

                $html .= '<tr>';
                if($key!=$data['keykey']){
                  $totdata++;
                  $html .= '<td style="width:5%;" rowspan="'.$data['count_tbl'].'">'.$totdata.'</td>';
                  $html .= '<td style="width:25%;" rowspan="'.$data['count_tbl'].'">'.$data['vKode_obat'].'-'.$data['nm_produk'].'</td>';
                  $html .= '<td style="width:5%;" rowspan="'.$data['count_tbl'].'">'.$data['vBatch_no'].'</td>';
                }

                $html .= '<td style="width:15%;">'.$data['vnama_jenis'].'</td>';

                $html .= '<td style="width:15%;">'.$data['group_proses_qc'].' - '.$data['vProses_name'].'</td>';
                $html .= '<td style="width:10%;">'.$data['nm_zat'].'</td>';


                $html .= '<td style="width:5%;">'.$data['dStart_time_wait'].'</td>';
                $html .= '<td style="width:5%;">'.$data['dFinish_time_wait'].'</td>';

                $html .= '<td style="width:5%;">'.$data['dStart_time_pro'].'</td>';
                $html .= '<td style="width:5%;">'.$data['dFinish_time_pro'].'</td>';
                if($key!=$data['keykey']){
                  $html .= '<td style="width:5%;" rowspan="'.$data['count_tbl'].'">'.$data['selisih_hari_non'].'</td>'; 
                }
                if($key!=$data['keykey']){
                  $html .= '<td style="width:5%;" rowspan="'.$data['count_tbl'].'">'.$data['selisih_hari'].'</td>';
                  $totalhari += $data['selisih_hari'];
                }
                $key=$data['keykey'];
                $jum=$data['count_tbl'];
              }

            if($totdata==0){
              $hsl = 0;
            }else{
              $hsl = $totalhari/$totdata;
            }
            $result     = number_format($hsl,2);
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 700px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Data </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totdata."</td>
                        </tr>";
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Hari</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalhari."</td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-rata</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function QC_NONSTERIL_3($post){

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

          $html = "
                  <table cellspacing='0' cellpadding='3' width='850px'>
                      <tr>
                          <td><b>Point Untuk Aspek :</b></td>
                          <td>".$vAspekName."</td>
                      </tr>
                  </table><br><hr>";


          $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                      <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th >No</th>
                          <th >Hari / Tanggal</th>
                          <th >Flow QC</th>
                          <th >Nama Produk</th>
                          <th >No Batch</th>
                          <th >Kategori Proses</th>
                          <th >Pengujian</th>
                          <th >Retest</th>
                      </tr>
          ";

          $sqlKapAllA = '
              select a.cNip, b.vName,c.vDescription from kanban.kbn_pic a
              join hrd.employee b on b.cNip=a.cNip
              join hrd.position c on c.iPostId=b.iPostID
              where a.iAnalis =1 and a.iDeleted=0 and b.iPostID IN (191,301)
              and b.iCompanyID = 3
          ';

          $tempoPeranalisi = array();

          $dtAnalis   = $this->db_erp_pk->query($sqlKapAllA)->result_array();
          foreach ($dtAnalis as $dt) {
            $html .= "<tr style='width:100%;border-collapse: collapse;'>
                          <td colspan='8'><hr></td>
                      </tr>";
            $html .= "<tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;'>
                          <td colspan='8'><b>".$dt['cNip']."-".$dt['vName']."<b></td>
                      </tr>";
            $sqlpar = '
                select date(a.dFinish_time) AS dFinish_time,d.vNama,d.vBatch_no,f.vName as pengujian,h.vProses_name,a.iFlow_qc_id,
                b.iCount, if(b.iCount !=0,"Y","N") sretest,g.cNip,g.vName,hh.vName as group_proses_qc
                from kanban.kbn_qc_mesin_waiting_detail a
                join kanban.kbn_qc_mesin_waiting b on b.qc_mesin_waiting_id=a.qc_mesin_waiting_id
                join kanban.kbn_mesin_waiting c on c.mesin_waiting_id=b.mesin_waiting_id
                join kanban.kbn_mbr d on d.id=c.mbr_id
                join kanban.kbn_qc_master_mapping_proses_perkategori e on e.mapping_proses_perkategori_id=b.mapping_proses_perkategori_id
                /*join kanban.kbn_qc_master_pengujian f on f.pengujian_id=e.metode_pengujian_id*/
                join kanban.kbn_qc_master_pengujian f on f.pengujian_id=e.pengujian_id
                join hrd.employee g on g.cNip=a.vNipAnalis
                join kanban.kbn_qc_master_proses_group gg on gg.iProses_id=c.proses_qc_id
                join kanban.kbn_master_proses h on h.iProses_id=gg.iProses_id
                join kanban.kbn_qc_master_group_kategori hh on hh.group_kategori_id=gg.group_kategori_id
                where
                a.iDeleted=0
                and b.iDeleted=0
                and a.dFinish_time is not null
                and a.vNipAnalis="'.$dt['cNip'].'"
                and a.iFlow_qc_id IN(3,4,5)
                and a.isProses=1
                and a.dFinish_time >="'.$perode1.'"
                and a.dFinish_time <="'.$perode2.'"
                ORDER BY date(a.dFinish_time)
              ';
              $rowdate = $this->db_erp_pk->query($sqlpar)->result_array();
              $i=0;
              $doubleTgl = '';

              $totalHari = 0;
              $totalData = 0;
              $nipData   ='';
              $namaData  ='';
              foreach ($rowdate as $ub) {
                $sqlCount = '
                    select date(a.dFinish_time) AS dFinish_time
                    from kanban.kbn_qc_mesin_waiting_detail a
                    join kanban.kbn_qc_mesin_waiting b on b.qc_mesin_waiting_id=a.qc_mesin_waiting_id
                    join kanban.kbn_mesin_waiting c on c.mesin_waiting_id=b.mesin_waiting_id
                    join kanban.kbn_mbr d on d.id=c.mbr_id
                    join kanban.kbn_qc_master_mapping_proses_perkategori e on e.mapping_proses_perkategori_id=b.mapping_proses_perkategori_id
                    /*join kanban.kbn_qc_master_pengujian f on f.pengujian_id=e.metode_pengujian_id*/
                    join kanban.kbn_qc_master_pengujian f on f.pengujian_id=e.pengujian_id
                    join hrd.employee g on g.cNip=a.vNipAnalis
                    join kanban.kbn_qc_master_proses_group gg on gg.iProses_id=c.proses_qc_id
                    join kanban.kbn_master_proses h on h.iProses_id=gg.iProses_id
                    join kanban.kbn_qc_master_group_kategori hh on hh.group_kategori_id=gg.group_kategori_id
                    where
                    a.iDeleted=0
                    and b.iDeleted=0
                    and a.dFinish_time is not null
                    and a.vNipAnalis="'.$dt['cNip'].'"
                    and a.iFlow_qc_id IN(3,4,5)
                    and a.isProses=1
                    and date(a.dFinish_time) = "'.$ub['dFinish_time'].'"
                    and a.dFinish_time >="'.$perode1.'"
                    and a.dFinish_time <="'.$perode2.'"
                    ORDER BY date(a.dFinish_time)
                  ';

                $row = $this->db_erp_pk->query($sqlCount)->num_rows();
                $i++;
                $sqlMa = "select k.vMappingProses from kanban.kbn_qc_master_flow_qc k
                   where k.flow_qc_id = ".$ub['iFlow_qc_id'];
                $dbs = $this->db_erp_pk->query($sqlMa)->row_array();

                $col='';
                if($cNipNya!=$dt['cNip']){
                  $col = "bgcolor='#C0C0C0'";
                }

                $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='border: 1px solid #dddddd;'>".$i."</td>
                            ";
                if($doubleTgl!=$ub['dFinish_time']){
                  $html .= " <td style='border: 1px solid #dddddd;' rowspan='".$row."'>".$ub['dFinish_time']."</td> ";
                  $totalHari++;
                }
                $totalData++;
                //$html .= " <td style='border: 1px solid #dddddd;' >".$ub['dFinish_time']."</td> ";
                $doubleTgl=$ub['dFinish_time'];

                $html .= "  <td style='border: 1px solid #dddddd;'>".$dbs['vMappingProses']."</td>
                            <td style='border: 1px solid #dddddd;'>".$ub['vNama']."</td>
                            <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                            <td style='border: 1px solid #dddddd;'>".$ub['group_proses_qc']." - ".$ub['vProses_name']."</td>
                            <td style='border: 1px solid #dddddd;'>".$ub['pengujian']."</td>
                            <td style='border: 1px solid #dddddd;'>".$ub['sretest']."</td>
                         </tr>";
              }
              $tempoPeranalisi;
              $analis['totalHari'] = $totalHari;
              $analis['totalData'] = $totalData;
              $analis['nipData'] = $dt['cNip'];
              $analis['namaData'] = $dt['vName'];
              array_push($tempoPeranalisi,$analis);
          }

          $html .= "</table><br /> ";

          $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 700px;'>
                      <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                          <td colspan='3' style='text-align: left;border: 1px solid #dddddd;'></td>
                      </tr>";
                      $user=0;
                      $totalKaps =0;
                      foreach ($tempoPeranalisi as $k) {
                        $user++;
                        if(!empty($k['totalHari']) && $k['totalHari']!=0){
                          $totalKaps += $k['totalData']/$k['totalHari'];
                        }else{
                          $totalKaps += 0;
                        }

                        $col='';
                        if($cNipNya!=$k['nipData']){
                          $col = "bgcolor='#C0C0C0'";
                        }

                        $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Kapasitas Analisis <b>[".$k['nipData']."]-".$k['namaData']."</b></td>
                                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$k['totalData']." Sample & ".$k['totalHari']." Hari</td>
                                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($k['totalData']/$k['totalHari'],3)." Sample/Hari</td>
                                    </tr>";
                      }
                      if($user==0){
                        $hsl = 0;
                      }else{
                        $hsl = $totalKaps/$user;
                      }

                      $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;' colspan='2'>Total Kapasitas Seluruh Analisis</b></td>
                                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;' >".number_format($totalKaps,3)." Sample/Hari</td>
                                  </tr>";
                      $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;' colspan='2'>Rata - rata Kapasitas Seluruh Analisis</b></td>
                                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;' >".number_format($hsl,3)." Sample/Hari</td>
                                  </tr>";

          $html .= "</table>";



          $result     = number_format($hsl,3);
          $getpoint   = $this->getPoint($result,$iAspekId);
          $x_getpoint = explode("~", $getpoint);
          $point      = $x_getpoint['0'];
          $warna      = $x_getpoint['1'];

          echo $result."~".$point."~".$warna."~".$html;
    }
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


    /*AD N15748 End*/
    function QC_NONSTERIL_5($post){
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

      $sql_par5 ='select * from (select d.vNama as nm_produk,h.vName as group_proses_qc,j.vProses_name,i.vName as nm_zat,d.vBatch_no,i.zat_aktif_id,a.iCount,b.dFinish_time,
        b.qc_mesin_waiting_detail_id, if(a.iCount=0,"N","Y") as vretest
        from kanban.kbn_qc_mesin_waiting a
        join kanban.kbn_qc_mesin_waiting_detail b on b.qc_mesin_waiting_id=a.qc_mesin_waiting_id
        join kanban.kbn_mesin_waiting c on c.mesin_waiting_id=a.mesin_waiting_id
        join kanban.kbn_mbr d on d.id=c.mbr_id
        join kanban.kbn_master_jenis e on e.ijenis_id=d.ijenis_id
        join kanban.kbn_qc_master_mapping_proses_perkategori f on f.mapping_proses_perkategori_id=a.mapping_proses_perkategori_id
        join kanban.kbn_qc_master_proses_group g on g.iProses_id=c.proses_qc_id
        join kanban.kbn_qc_master_group_kategori h on h.group_kategori_id=g.group_kategori_id
        join kanban.kbn_qc_master_zat_aktif i on i.zat_aktif_id=f.zat_aktif_id
        join kanban.kbn_master_proses j on j.iProses_id=g.iProses_id
        where
        a.iDeleted=0
        and b.iDeleted=0
        and d.iDeleted=0
        and e.iDeleted=0
        and f.iDeleted=0
        and g.iDeleted=0
        and h.iDeleted=0
        and i.iDeleted=0
        and b.iFlow_qc_id=4
        and b.dFinish_time is not null AND b.dFinish_time !="0000-00-00 00:00:00"
        and a.iReleaseQC = 2
            and a.iMerge = 1) as z
            where
            z.dFinish_time>="'.$perode1.'"
            AND z.dFinish_time<="'.$perode2.'" ';

      $groupby=' group by z.vBatch_no,z.zat_aktif_id
                  ';

      $wherese=' AND z.vretest="Y"';

      $html = "
              <table cellspacing='0' cellpadding='3' width='850px'>
                  <tr>
                      <td><b>Point Untuk Aspek :</b></td>
                      <td>".$vAspekName."</td>
                  </tr>
              </table><br><hr>";


      $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                  <tr style='width:100%; border: 1px solid #4297d7; background: #4297d7; border-collapse: collapse;text-align: center;'>
                      <th colspan='6'>Produk Dengan Status Retest</th>
                  </tr>
                  <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>Batch No</th>
                      <th>Nama Produk</th>
                      <th>Nama Proses</th>
                      <th>Jenis Zat</th>
                      <th>Tanggal Finish</th>
                  </tr>
      ";

      $bacthrese = $this->db_erp_pk->query($sql_par5.$wherese.$groupby)->result_array();
      $numrowrese=$this->db_erp_pk->query($sql_par5.$wherese.$groupby)->num_rows();
      $i=0;
      foreach ($bacthrese as $ub) {
           $i++;
           $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <td style='border: 1px solid #dddddd;'>".$i."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['nm_produk']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['vProses_name']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['nm_zat']."</td>
                       <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dFinish_time']))."</td>
                    </tr>";
      }

      $html .= "</table><br /> ";

      $qupb = $this->db_erp_pk->query($sql_par5.$groupby);
      if($qupb->num_rows() > 0) {
          $tot = $qupb->num_rows();
          $totb = number_format( $tot, 2, '.', '' );
      }else{
          $totb       = 0;
      }


      $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                  <tr style='width:100%; border: 1px solid #4297d7; background: #4297d7; border-collapse: collapse;text-align: center;'>
                      <th colspan='6'>Produk Zat Aktif</th>
                  </tr>
                  <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>Batch No</th>
                      <th>Nama Produk</th>
                      <th>Nama Proses</th>
                      <th>Jenis Zat</th>
                      <th>Tanggal Finish</th>
                  </tr>
      ";

      $bacthDetail = $this->db_erp_pk->query($sql_par5.$groupby)->result_array();
      $numrowbatch=$this->db_erp_pk->query($sql_par5.$groupby)->num_rows();
      $i=0;
      $totSelisih = 0;
      foreach ($bacthDetail as $ub) {

           $i++;
           $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <td style='border: 1px solid #dddddd;'>".$i."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['vBatch_no']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['nm_produk']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['vProses_name']."</td>
                       <td style='border: 1px solid #dddddd;'>".$ub['nm_zat']."</td>
                       <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($ub['dFinish_time']))."</td>
                    </tr>";
      }

      $html .= "</table><br /> ";
      $pembagi=$numrowbatch+$numrowrese;
      $result     = number_format(($numrowrese/$pembagi)*100, 2, '.', '' );
      $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                  <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                      <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                  </tr>
                  <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Status Retest(A)</td>
                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$numrowrese." </td>
                  </tr>
                  <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Status Non Retest</td>
                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$numrowbatch." </td>
                  </tr>
                  <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Zat aktif(B)</td>
                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$pembagi." </td>
                  </tr>

                  <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                      <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase A dan B</td>
                      <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                  </tr>
              </table><br/><br/>";

      $getpoint   = $this->getPoint($result,$iAspekId);
      $x_getpoint = explode("~", $getpoint);
      $point      = $x_getpoint['0'];
      $warna      = $x_getpoint['1'];


      echo $result."~".$point."~".$warna."~".$html;
    }

    function QC_NONSTERIL_1($post){
            //Hitungan Sudah OK, Rencana Ambil data temporary update setiap jam 12 Malem per 10 Semester
            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
            //$perode1 = "2017-01-01";

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];
            //$perode2 = "2017-05-05";

            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            //Query Untuk Cari Yang Finish dulu
            $sql = 'select CONCAT(d.id, "-", j.iProses_id) as keykey ,j.iProses_id,d.id as mbr_id,d.vNama as nm_produk ,
              e.vnama_jenis,h.vName as group_proses_qc,j.vProses_name,i.vName as nm_zat,
              d.vBatch_no,a.iCount,a.mapping_proses_perkategori_id,a.qc_mesin_waiting_id,a.mesin_waiting_id,d.vKode_obat
              from kanban.kbn_qc_mesin_waiting a
              join kanban.kbn_qc_mesin_waiting_detail b on b.qc_mesin_waiting_id=a.qc_mesin_waiting_id
              join kanban.kbn_mesin_waiting c on c.mesin_waiting_id=a.mesin_waiting_id
              join kanban.kbn_mbr d on d.id=c.mbr_id
              join kanban.kbn_master_jenis e on e.ijenis_id=d.ijenis_id
              join kanban.kbn_qc_master_mapping_proses_perkategori f on f.mapping_proses_perkategori_id=a.mapping_proses_perkategori_id
              join kanban.kbn_qc_master_proses_group g on g.iProses_id=c.proses_qc_id
              join kanban.kbn_qc_master_group_kategori h on h.group_kategori_id=g.group_kategori_id
              join kanban.kbn_qc_master_zat_aktif i on i.zat_aktif_id=f.zat_aktif_id
              join kanban.kbn_master_proses j on j.iProses_id=g.iProses_id
              where
              a.iDeleted=0
              and b.iDeleted=0
              and d.iDeleted=0
              and e.iDeleted=0
              and f.iDeleted=0
              and g.iDeleted=0
              and h.iDeleted=0
              and i.iDeleted=0
              and a.iReleaseQC = 2
              and a.iMerge = 1
              and a.qc_mesin_waiting_id in (
                  select qc_mesin_waiting_id
                  from kanban.kbn_qc_mesin_waiting_detail a
                  where
                  a.iDeleted=0
                  and (a.dFinish_time is not null or a.dFinish_time !="0000-00-00 00:00:00")
                  and a.dFinish_time >="'.$perode1.'"
                  and a.dFinish_time <="'.$perode2.'"
                )
              group by a.qc_mesin_waiting_id order by keykey ';


              $this->db_erp_pk->cache_on();
              $rows  = $this->db_erp_pk->query($sql)->result_array();
              //Load semua data yang ada di qc yang udah release
              $i = 1;
              $vKode_obat_in = "";
              $loop = 0;
              //Dapetin Kode Produk yang Abis pada qc Terakhir
              foreach($rows as $cell){
                $sqlCek = "select distinct(a.vProses_akhir) as grup_id,c.iProses_id
                    from kanban.kbn_qc_master_mapping_proses_perkategori a
                    join kanban.kbn_qc_master_proses_group c on c.master_proses_group_id=a.vProses_akhir
                    join kanban.kbn_qc_master_group_kategori b on b.group_kategori_id=c.group_kategori_id
                    where a.iDeleted=0
                    and b.iDeleted=0
                    and a.vKode_obat='".$cell['vKode_obat']."' order by a.mapping_proses_perkategori_id DESC LIMIT 1";
                $cek = $this->db_erp_pk->query($sqlCek)->row_array();
                if(!empty($cek['iProses_id']) && $cek['iProses_id']==$cell['iProses_id']){
                  if($loop==0){
                    $vKode_obat_in .='"'.$cell['vKode_obat'].'"';
                  }else{
                    $vKode_obat_in .=',"'.$cell['vKode_obat'].'"';
                  }
                  $loop++;
                }
              }


              $html = "
                      <table cellspacing='0' cellpadding='3' width='850px'>
                          <tr>
                              <td><b>Point Untuk Aspek :</b></td>
                              <td>".$vAspekName."</td>
                          </tr>
                      </table><br><hr>";


              $html .= "<table cellspacing='0' cellpadding='3' width='850px' border=1>
                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th rowspan='4'>No</th>
                            <th rowspan='4'>Nama Produk</th>
                            <th rowspan='4'>Kategori</th>
                            <th rowspan='4'>Kategori Proses</th>
                            <th rowspan='4'>Zat Aktif</th>
                            <th rowspan='4'>No Batch</th>

                          </tr>

                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th colspan='2'>Preparation</th>
                            <th colspan='2'>Pengelolaan</th>
                            <th rowspan='3'>Selisih Hari</th>
                            <th rowspan='3'>Selisih Hari<br />(Hari Kerja)</th>
                          </tr>

                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th colspan='2'>Waiting</th>
                            <th colspan='2'>Proses</th>
                          </tr>
                          <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>Mulai</th>
                            <th>Selesai</th>

                            <th>Mulai</th>
                            <th>Selesai</th>

                          </tr>
              ";

            $totdata   = 0;
            $totalhari = 0;
            $perio = $perode1.'/'.$perode2;
            $sqlDataLo = "SELECT * FROM kanban.temporary_pk_non_steril t where
                        t.vKode_obat IN(".$vKode_obat_in.") AND t.iCompany=3 AND t.dPeriode='".$perio."' order by t.selisih_hari";
            $rows_all = $this->db_erp_pk->query($sqlDataLo)->result_array();
            $key ='';
            $jum ='';
            $totdata   = 0;
            $totalhari = 0;
            foreach($rows_all as $cell){
                if(isset($total[$cell['keykey']]['jml'])) {
                  $total[$cell['keykey']]['jml']++;
                }else{
                  $total[$cell['keykey']]['jml']=1;
                }
            }
            $total5=0;
            foreach ($rows_all as $data) {
                $bgtr=$data['selisih_hari']<=5?'bgcolor="#ddffcc"':'';
                $rowspan=$key!=$data['keykey']?'rowspan="'.$data['count_tbl'].'"':'';
                $html .= '<tr '.$bgtr.'>';
                if($key!=$data['keykey']){
                  $totdata++;
                  if($data['selisih_hari']<=5){
                    $total5++;
                  }
                  $html .= '<td style="width:5%;" '.$rowspan.'>'.$totdata.'</td>';
                  $html .= '<td style="width:25%;" '.$rowspan.'>'.$data['vKode_obat'].'-'.$data['nm_produk'].'</td>';
                  $html .= '<td style="width:15%;" '.$rowspan.'>'.$data['vnama_jenis'].'</td>';
                  $html .= '<td style="width:15%;" '.$rowspan.'>'.$data['group_proses_qc'].' - '.$data['vProses_name'].'</td>';
                }
                  $html .= '<td style="width:10%;">'.$data['nm_zat'].'</td>';
                if($key!=$data['keykey']){
                  $html .= '<td style="width:5%;" '.$rowspan.'>'.$data['vBatch_no'].'</td>';
                }
                $html .= '<td style="width:5%;">'.$data['dStart_time_wait'].'</td>';
                $html .= '<td style="width:5%;">'.$data['dFinish_time_wait'].'</td>';

                $html .= '<td style="width:5%;">'.$data['dStart_time_pro'].'</td>';
                $html .= '<td style="width:5%;">'.$data['dFinish_time_pro'].'</td>';
                if($key!=$data['keykey']){
                  $html .= '<td style="width:5%;text-align:center;" rowspan="'.$data['count_tbl'].'">'.$data['selisih_hari_non'].'</td>';
                  $html .= '<td style="width:5%;text-align:center;" rowspan="'.$data['count_tbl'].'">'.$data['selisih_hari'].'</td>';
                  $totalhari += $data['selisih_hari'];
                }
                $key=$data['keykey'];
                $jum=$data['count_tbl'];
              }

            if($totdata==0 or $total5==0){
              $hsl = 0;
            }else{
              $hsl = $total5/$totdata*100;
            }
            $result     = number_format($hsl,2);
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 700px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Produk QC Release (Y)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totdata."</td>
                        </tr>";
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Produk <= 5 Hari (X)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$total5."</td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase X dan Y</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

}
