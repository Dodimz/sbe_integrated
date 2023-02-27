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
   
    <!-- <tr>
    <th>No</th>
    <th>Sub Kegiatan / Paket Pekerjaan</th>
    <th>Pagu</th>
    <th>Paket Pekerjaan</th>
    <th > Pagu</th>
    <th>Nilai Kontrak</th>
    <th > Jenis Paket</th>
    <th > Metode</th> 
    <th >Realisasi Fisik</th> -->

    <tr>
      <th rowspan="4">No</th>
      <th rowspan="2" colspan="4">Data Sub Kegiatan & Paket Pekerjaan</th>
      <th colspan="8">Realisasi Fisik Dan Keuangan</th>
      <th colspan="3" rowspan="2">Terkontrak</th>
    </tr>
    <tr>
      <th colspan="3">Fisik</th>
      <th colspan="5">Keuangan</th>
    </tr>
    <tr>
      <th rowspan="2">Uraian</th>
      <th rowspan="2">Pagu</th>
      <th rowspan="2">Jenis</th>
      <th rowspan="2">Metode</th>
      <th rowspan="2">Target</th>
      <th rowspan="2">Realisasi</th>
      <th rowspan="2">Deviasi</th>
      <th colspan="2">Target</th>
      <th colspan="2">Realisasi</th>
      <th rowspan="2">Deviasi</th>
      <th rowspan="2">Mulai</th>
      <th rowspan="2">Akhir</th>
      <th rowspan="2">Nilai Kontrak</th>
    </tr>
    <tr>
      <th>Rp.</th>
      <th>%</th>
      <th>Rp.</th>
      <th>%</th>
    </tr>


 </thead>
   <tbody>
     <?php 
     $no_sub_kegiatan = 0;
     $hitung_kontrak =0;
     $hitung_paket =0;

     $total_pagu_ski = 0; 
     $total_pagu_paket =0;
     $total_nilai_kontrak =0;
     foreach ($sub_kegiatan_paket->result() as $key => $value_sk) { 
      $no_sub_kegiatan++;
      $krsk = $value_sk->kode_rekening_sub_kegiatan;

      if ($tahap==2) {
       $where = "where kode_rekening_sub_kegiatan='$krsk' and kode_tahap='$tahap' and tahun='$tahun' and id_instansi='$id_instansi'";
      }else{
       $where = "where kode_rekening_sub_kegiatan='$krsk' and status='1' and tahun='$tahun' and id_instansi='$id_instansi'";

      }

      $q_sub_kegiatan = $this->db->query("SELECT kode_rekening_sub_kegiatan, nama_sub_kegiatan, pagu, kode_tahap, tahun, kategori, jenis_sub_kegiatan, keterangan  from v_sub_kegiatan_apbd $where")->row_array();

      $paket = $this->realisasi_akumulasi_model->get_paket_opd_per_sub_kegiatan($id_instansi, $krsk);

      
      $kategori_sub_kegiatan = $value_sk->kategori;
      if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }

          


      $total_pagu_ski += $q_sub_kegiatan['pagu'];
















      $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $krsk, $bulan, $q_sub_kegiatan['kode_tahap'], $q_sub_kegiatan['tahun'])->row_array();
          $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $krsk, $bulan, $ope, $tahun, $tahap)->row_array();

          if ($ope=='=') {
            $target_fisik = $target['target_fisik_bulanan'];
            $target_keuangan = $target['target_keuangan_bulanan'];
            $nilai_persen_target_keuangan = ($target['target_keuangan_bulanan'] / $q_sub_kegiatan['pagu']) * 100 ; 
            
          }else{
            $target_keuangan = $target['target_keuangan'];
            $target_fisik = $target['target_fisik'];
            $nilai_persen_target_keuangan = ($target['target_keuangan'] / $q_sub_kegiatan['pagu']) * 100 ; 

          }

          $porsi_target_fisik = ($target_fisik / $angka_pembagi_fisik) * 100 ; 
          $total_porsi_target_fisik += $porsi_target_fisik ;
          // $target_fisik_bulanan = $target['target_fisik_bulanan'];

          // 
          if ($q_sub_kegiatan['pagu'] == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
          } else {
          $persen_target_keuangan = $nilai_persen_target_keuangan; 
            $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $q_sub_kegiatan['pagu']) * 100, 2);
          }

          
          $persen_target_keuangan_besar = ($target_keuangan / $pagu_skpd) *100 ; 
          $persen_realisasi_keuangan_besar = ($realisasi_keuangan['total_realisasi'] / $pagu_skpd) *100 ; 
          $total_persen_target_keuangan +=$persen_target_keuangan ;
          $total_persen_realisasi_keuangan +=$persen_realisasi_keuangan ;
          // $target_keuangan_bulanan = $target['target_keuangan_bulanan'];



          $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $krsk, $tahun, $tahap)->num_rows();
          $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $krsk, "RUTIN", $tahun, $tahap)->num_rows();
          $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $krsk, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
          $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $krsk, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();





          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=>($ke / $lama_realisasi * 100)
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
              if ($ope=='=') {
                $realisasi_rutin = (1/$lama_realisasi) *100;
              }else{
                $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
              }
            }


          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
         

          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }

          $total_realisasi_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
          $porsi_realisasi_fisik    = ($total_realisasi_fisik / $angka_pembagi_fisik) * 100 ;
          $total_porsi_realisasi_fisik += $porsi_realisasi_fisik ;
          $total_realisasi_fisik_semua += $total_realisasi_fisik ;



          $dev_fisik = $total_realisasi_fisik - $target_fisik;
          $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;
          // $dev_fisik = $porsi_realisasi_fisik - $porsi_target_fisik;
          // $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;


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




      ?>
      <tr style="background:#f6e2f9 ">
        <td><?php echo $no_sub_kegiatan; ?></td>
        <td><?php echo $q_sub_kegiatan['nama_sub_kegiatan'] ?></td>
        <td align="right"><?php echo number_format($q_sub_kegiatan['pagu']) ?></td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center"><?php echo round($target_fisik,2) ?></td>
        <td align="center"><?php echo round($total_realisasi_fisik,2) ?></td>
        <td align="center" style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo round($dev_fisik,2) ?></td>
        <td align="right"><?php echo number_format($target_keuangan) ?></td>
        <td align="center"><?php echo round($persen_target_keuangan,2) ?></td>
        <td align="right"><?php echo number_format($realisasi_keuangan['total_realisasi']) ?></td>
        <td align="center"><?php echo round($persen_realisasi_keuangan,2) ?></td>
        <td align="center" style="<?php echo $warna_peringatan_dev_keu ?>"><?php echo round($dev_keu,2) ?></td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
      </tr>
    <?php 
    $no_paket = 0;
    foreach ($paket->result_array() as $k_paket => $v_paket) {
      $hitung_paket +=1;
      $no_paket++;
      $id_paket_pekerjaan = $v_paket['id_paket_pekerjaan'];


      $nilai_evidence = $this->db->query("SELECT sum(nilai)as rf FROM realisasi_fisik WHERE id_paket_pekerjaan = '$id_paket_pekerjaan' and bulan<='$bulan'")->row_array();
      $rf_paket =  $v_paket['jenis_paket']=='RUTIN' ?  round($rut,2) : ($nilai_evidence['rf'] =='' ? 0 : $nilai_evidence['rf']);
      $total_pagu_paket += $v_paket['pagu'];
      $total_nilai_kontrak += $v_paket['nilai_kontrak'];


      ?>
        <tr>
        <td><?php echo $no_sub_kegiatan.'.'.$no_paket ?></td>
        <td><?php echo $v_paket['nama_paket'] ?></td>
        <td align="right"><?php echo number_format($v_paket['pagu']) ?></td>
        <td><?php echo $v_paket['jenis_paket']=='PENYEDIA' ?  $v_paket['jenis_paket'] .' - '. $v_paket['kategori'] : $v_paket['jenis_paket'];


          ?></td>
        <td><?php echo $v_paket['metode'] ?></td>
        <td align="center">-</td>
        <td align="center"><?php echo $rf_paket ?></td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <?php if ($v_paket['id_kontrak_pekerjaan']=='') { 

          ?>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <?php }else{ 
          $hitung_kontrak +=1;
          ?>
          <td><?php echo $v_paket['tgl_awal_pelaksanaan'] ?></td>
          <td><?php echo $v_paket['tgl_akhir_pelaksanaan'] ?></td>
          <td><?php echo number_format($v_paket['nilai_kontrak']) ?></td>

        <?php } ?>
      </tr>
  <?php 
        } // end  foreach ($paket->result_array() as $k_paket => $v_paket)
     } // end foreach ($sub_kegiatan_paket->result() as $key => $value_sk)
  ?>
   </tbody>
   <tfoot>
    <tr>
       <th colspan="2">Total Pagu Paket <?php echo $jenis_paket ?></th>
       <th align="right"><?php echo number_format($total_pagu_paket) ?></th>
       <th colspan="2"><?php echo $hitung_paket ?> Paket Pekerjaan</th>
       <th colspan="8">-</th>
       <th colspan="2"><?php echo $hitung_kontrak ?> Terkontrak</th>
       <th align="right"><?php echo number_format($total_nilai_kontrak) ?></th>
      </tr>
   </tfoot>
</table>


</body>