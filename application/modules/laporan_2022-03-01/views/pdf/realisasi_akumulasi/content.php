<style>
  .font_laporan{
    font-size:9px;
    font-family: 'arial';
  }
  table {
    
    border-collapse: collapse;
    width:100%;
}
table td, th {
    border: 0.01em solid ;
    padding:3px;
}

  .header{
    font-weight:bold;
    text-align : center;
  }


  .logo{
   float:left;
   width : 60px;
  }
  .skpd{
   float:right;
   
  }
  .clearfix{
   clear:both;
   
  }
  .kop{
   text-align:center;
   font-family: 'arial';
  }
  .penutup{
    font-size:6px;
  }
  .copyright{
    font-size:7px;
    float:left;
  }
  .page{
    float:right;
    font-size:7px;
  }
  .pemprov_sumbar{
    font-size:20px;
  }
  .garis_kop1{
    margin-top:5px;
    border-width: 1.6px;
      border-style: solid;
  }
  .garis_kop2{
    margin-top:1px;
    border-width: 1px;
      border-style: solid;
  }
  .judul_laporan{
    margin-top:15px;
    text-align : center;
    font-family: 'arial';
    font-size:10px;
  }
  .nama_kegiatan{
    white-space:pre;
    left: 30px;
  }
</style>

<head>
  <title><?php echo $title ?></title>
</head>


<body>

<table class="font_laporan border">
 <thead class="header">
    <tr>
    <th rowspan="3"  width="30px">No</th>
    <th rowspan="3" style="width:350px">Program, Kegiatan, Sub Kegiatan</th>
    <th rowspan="3" style="width:80px">Pagu</th>
    <th rowspan="2" colspan="5">Sumber Dana (Rp.)</th>
    <th rowspan="2" colspan="2">Target </th>
    <th colspan="3" >Realisasi</th>
    <th rowspan="2" colspan="2">Deviasi</th>

   
  </tr>
  <tr>
    <th colspan="2">Keuangan</th>
    <th rowspan="2" style="width:32px">Fisik <br>%</th>  
  </tr>
  <tr>
    <th style="width:80px">PAD</th>
    <th style="width:80px">DAU</th>
    <th style="width:80px">DAK</th>
    <th style="width:80px">DBH</th>
    <th style="width:80px">Lainnya</th>
    <th style="width:32px">Fisik</th>
    <th style="width:32px">Keu</th>
    <th style="width:80px">Rp</th>
    <th style="width:32px">%</th>
    <th style="width:35px">F</th>
    <th style="width:35px">K</th>
  
  </tr>
 </thead>
 <!-- <tbody> -->
   <?php 
  $no_program   = 0;
  $pagu_program   = 0;
  $total_pad    = 0;
  $total_dau    = 0;
  $total_dak    = 0;
  $total_dbh    = 0;
  $total_lainnya  = 0;
  $total_target_fisik = 0;
  $total_sub_kegiatan = 0;


  $total_angka_target_keuangan = 0 ; //05012021
  $total_angka_realisasi_keuangan = 0; //06012021
  $total_target_keuangan = 0;
  $total_realisasi_keuangan = 0;
  $total_persen_realisasi_keuangan = 0;
  $total_persen_realisasi_fisik = 0;
  $total_persen_deviasi_f = 0;
  $total_persen_deviasi_k = 0;
  $hitungdata = 0;

   $total_peringatan_dev_fisik_merah = 0;
   $total_peringatan_dev_fisik_kuning = 0;
   $total_peringatan_dev_fisik_hijau = 0;
   $total_peringatan_dev_keu_merah = 0;
   $total_peringatan_dev_keu_kuning = 0;
   $total_peringatan_dev_keu_hijau = 0;
  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
    <tr>
      <td><?php echo $no_program ?></td>
       <td colspan="14" style="font-size:10px"><div><b><?php echo $value->nama_program ?></b></div></td>
     </tr>
    <?php 
    $no_kegiatan=0;
    foreach ($kegiatan as $key => $value_kegiatan) {
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();
    ?>
    <tr>
      <td><?php echo $no_program.'.'.$no_kegiatan ?></td>
       <td colspan="14" style="padding-left:1.5em" ><div class="nama_kegiatan"><b><?php echo $value_kegiatan->nama_kegiatan ?></b></div></td>
     </tr>
     <?php 
     foreach ($sub_kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $kategori_sub_kegiatan = $value_sk->kategori;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }

          $sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();




          $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan)->row_array();
          $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope)->row_array();

          if ($value_sk->pagu == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
          } else {
            $persen_target_keuangan     = round(($target['target_keuangan'] / $value_sk->pagu) * 100, 2);
            $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);
          }




          $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
          $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
          $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
          $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();





          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
            ];
            array_push($realisasi_rutin_bulan, $push);
            
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }


          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $total_angka_target_keuangan += $target['target_keuangan'];
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
         

          if ($total_paket != 0) {
            $total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
          } else {
            $total_fisik = 0;
          }

          $total_fisik    = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);
          $dev_fisik = $total_fisik - $target['target_fisik'];
          $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
            }

          $total_pad    += isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0;
          $total_dau    += isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0;
          $total_dak    += isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0;
          $total_dbh    += isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0;
          $total_lainnya  += isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0;
          $total_target_fisik   += isset($target['target_fisik']) ? $target['target_fisik'] : 0;
          // last update 09102020
          $total_target_keuangan += isset($persen_target_keuangan) ? $persen_target_keuangan : 0;
          $total_realisasi_keuangan += isset($realisasi_keuangan['total_realisasi']) ? $realisasi_keuangan['total_realisasi'] : 0;
          $total_persen_realisasi_keuangan += isset($persen_realisasi_keuangan) ? $persen_realisasi_keuangan : 0;
          $total_persen_realisasi_fisik += isset($total_fisik) ? $total_fisik : 0;
          $total_persen_deviasi_f += isset($dev_fisik) ? ROUND($dev_fisik, 2) : 0;
          $total_persen_deviasi_k += isset($dev_keu) ? ROUND($dev_keu, 2) : 0;












      ?>
      <tr>
      <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan ?></td>
       <td style="padding-left:3em"><div><?php echo $nama_sub_kegiatan?></div></td>
       <td align="right"><?php echo number_format($value_sk->pagu) ?></td>
       <td align="right"><?php echo number_format(isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0) ?></td>
       <td align="right"><?php echo number_format(isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0) ?></td>
       <td align="right"><?php echo number_format(isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0) ?></td>

       <td align="right"><?php echo number_format(isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0) ?></td>
       <td align="right"><?php echo number_format(isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0) ?></td>
       <td align="center"><?php echo $target['target_fisik'] =='' ? 0: $target['target_fisik'] ?></td>
       <td align="center"><?php echo $persen_target_keuangan ?></td>
       <td align="right"><?php echo number_format($realisasi_keuangan['total_realisasi']) ?></td>
       <td align="center"><?php echo round($persen_realisasi_keuangan,2) ?></td>
       <td align="center"><?php echo $total_fisik ?></td>
       <td align="center" style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo ROUND($dev_fisik, 2) ?></td>
       <td align="center" style="<?php echo $warna_peringatan_dev_keu ?>"><?php echo ROUND($dev_keu, 2) ?></td>
       
     </tr>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->


   <tr>
     <td colspan="2" align="right">Total</td>
     <td align="right"><?php echo number_format($pagu_program) ?></td>
     <td align="right"><?php echo number_format($total_pad) ?></td>
     <td align="right"><?php echo number_format($total_dau) ?></td>
     <td align="right"><?php echo number_format($total_dak) ?></td>
     <td align="right"><?php echo number_format($total_dbh) ?></td>
     <td align="right"><?php echo number_format($total_lainnya) ?></td>
     <td align="center"><?php echo $grafik->target_fisik ?></td>
     <td align="center"><?php echo $grafik->target_keuangan ?></td>
     <!-- <td align="center"><?php //echo number_format($ratarata_target_fisik, 2, '.', '') ?></td>
     <td align="center"><?php //echo number_format($ratarata_target_keuangan, 2, '.', '') ?></td> -->
     <?php 
     $total_dev_fisik =  $grafik->realisasi_fisik - $grafik->target_fisik;
    $total_dev_keuangan = $grafik->realisasi_keuangan - $grafik->target_keuangan;


            if ($total_dev_fisik < -10) {
              $warna_peringatan_total_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_fisik <-5  && $total_dev_fisik >-10) {
              $warna_peringatan_total_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_fisik = 'background: #d5f5e3';
            }

            if ($total_dev_keuangan < -10) {
              $warna_peringatan_total_dev_keuangan = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_keuangan <-5  && $total_dev_keuangan >-10) {
              $warna_peringatan_total_dev_keuangan = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_keuangan = 'background: #d5f5e3';
            }

 ?>
     <td align="right"><?php echo number_format($total_realisasi_keuangan) ?></td>
     <td align="center"><?php echo $grafik->realisasi_keuangan ?></td>
     <td align="center"><?php echo $grafik->realisasi_fisik ?></td>
     <td align="center" style="<?php echo $warna_peringatan_total_dev_fisik ?>"><?php echo $total_dev_fisik;?></td>
     <td align="center" style="<?php echo $warna_peringatan_total_dev_keuangan ?>"><?php echo $total_dev_keuangan;?></td>
     <!-- <td align="center"><?php // echo number_format($ratarata_persen_realisasi_keuangan, 2, '.', '') ?></td>
     <td align="center"><?php // echo number_format($ratarata_persen_realisasi_fisik, 2, '.', '') ?></td>
     <td align="center"><?php // echo number_format($total_persen_deviasi_f, 2, '.', '') ?></td>
     <td align="center"><?php // echo number_format($total_persen_deviasi_k, 2, '.', '') ?></td> -->
   </tr>
    <tr>
      <td colspan="15" style="font-size:12px"><div><b>Perhitungan Deviasi / Sub Kegiatan</b></div></td>
     
    </tr>
    <tr style="background: #f8b2b2;">
      <td colspan="13">Deviasi Diatas -10%</td>
      <td><center><?= $total_peringatan_dev_fisik_merah  ?></center></td>
      <td><center><?= $total_peringatan_dev_keu_merah  ?></center></td>
    </tr>
    <tr style="background: #fcf3cf;">
      <td colspan="13">Deviasi antara -5% sampai -10%</td>
      <td><center><?= $total_peringatan_dev_fisik_kuning  ?></center></td>
      <td><center><?= $total_peringatan_dev_keu_kuning  ?></center></td>
    </tr>
    <tr style="background: #d5f5e3;">
      <td colspan="13">Deviasi dibawah -5%</td>
      <td><center><?= $total_peringatan_dev_fisik_hijau  ?></center></td>
      <td><center><?= $total_peringatan_dev_keu_hijau  ?></center></td>
    </tr>
    <tr>
      <td colspan="13">Total Sub Kegiatan SKPD </td>
      <td colspan="2"><center><?= $total_sub_kegiatan  ?></center></td>
    </tr>

</table>


</body>