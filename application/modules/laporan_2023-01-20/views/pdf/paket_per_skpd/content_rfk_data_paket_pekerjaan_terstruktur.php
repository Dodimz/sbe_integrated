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
      <th rowspan="2" width="20px">No</th>
      <th colspan="3">Data APBD</th>
      <th colspan="6">Data Paket Pekerjaan</th>
      <!-- <th rowspan="2">Nilai Fisik Sub Kegiatan</th> -->
    </tr>
    <tr>
    <th>Program</th>
    <th>Kegiatan</th>
    <th>Sub Kegiatan</th>
    <th>Paket Pekerjaan</th>
    <th > Pagu</th>
    <th>Nilai Kontrak</th>
    <th > Jenis Paket</th>
    <th > Metode</th> 
    <th >Realisasi Fisik</th>

   
  </tr>



 </thead>
 <!-- <tbody> -->
   <?php 
  $no_program   = 0;
  $pagu_program   = 0;

  $total_sub_kegiatan = 0;

  $total_pagu_paket = 0;
  $banyak_paket = 0;
  $total_volume = 0;
  $total_lokasi =0;
  $total_evidence_diupload =  0;
  $total_evidence_divalidasi = 0;
  $total_evidence_belum_validasi =0;
  $total_nilai = 0;


  $bulan_mulai = mulai_realisasi_instansi($id_instansi);
  $bulan_akhir = akhir_realisasi_instansi($id_instansi);
  $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

  $nilai_rutin_perbulan = 100 / $lama_realisasi;
  $nilai_rutin_bulan_ini = bulan_aktif() * $nilai_rutin_perbulan;
  if (bulan_aktif()<$bulan_mulai) {
    $nilai_rutin = 0 ; 
  }
  elseif (bulan_aktif()>$bulan_akhir) {
    $nilai_rutin = 100 ; 
  }else{
    $nilai_rutin = round($nilai_rutin_bulan_ini,2) ; 
  }


  $total_pagu_terkontrak =0;
  $banyak_terkontrak =0;
  foreach ($paket->result_array() as $k_paket => $v_paket) { 
    $kode_sub_kegiatan = $v_paket['kode_rekening_sub_kegiatan'];
    $kode_kegiatan = $v_paket['kode_rekening_kegiatan'];
    $kode_program = $v_paket['kode_rekening_program'];

    $program = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_program'")->row_array();
    $kegiatan = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_kegiatan'")->row_array();
    $ski = $this->db->query("SELECT  nama_sub_kegiatan, kategori, jenis_sub_kegiatan, keterangan, pagu from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_sub_kegiatan' and tahun='$tahun' and kode_tahap='$tahap'")->row_array();

    $nama_sub_kegiatan = $ski['kategori'] == 'Unit Pelaksana' ? $ski['nama_sub_kegiatan'] : $ski['nama_sub_kegiatan'] ;
        

          $total_pagu_terkontrak +=$v_paket['nilai_kontrak'];
          if ($v_paket['id_kontrak_pekerjaan']==null && $v_paket['jenis_paket']=='PENYEDIA') {
              $banyak_terkontrak +=1;
            # code...
          }else{

          }

            $no_paket++;?>
             <tr>
      <td><?php echo $no_paket ?></td>
      <td><?php echo $program['nama_program'] ?></td>
      <td><?php echo $kegiatan['nama_kegiatan'] ?></td>
      <td><?php echo $nama_sub_kegiatan ?></td>
       <td><?php echo $v_paket['nama_paket']?></td>
       <td align="right"><?php echo number_format($v_paket['pagu']) ?></td>

       <td align="right"><?php echo number_format($v_paket['nilai_kontrak'])?></td>
       <td align="center"><?php echo $v_paket['jenis_paket']?></td>
       <td>
         <?php 
          if ($v_paket['jenis_paket']=='RUTIN') {
            echo "";
          }else if ($v_paket['jenis_paket']=='SWAKELOLA') {
            echo $v_paket['metode'];
          }else{
            echo $v_paket['kategori'].' - '.$v_paket['metode'];
          }
           ?>
       </td>
       <td align="center">
        <?php 
          if ($v_paket['jenis_paket']=='RUTIN') {
             $nilai_paket = $nilai_rutin;
          }else{
             $nilai_paket = $v_paket['nilai']==''? 0 : $v_paket['nilai'];
          }
          echo round($nilai_paket,2);
        ?>
          
        </td>
        <!-- <td><center>-</center></td> -->
       
     </tr>
          <?php

        $total_pagu_paket += $v_paket['pagu'];
        $banyak_paket += 1;
        $total_volume += $v_paket['volume'];
        $total_lokasi += $v_paket['banyak_lokasi'];
        $total_evidence_diupload +=  $v_paket['evidence_diupload'];
        $total_evidence_divalidasi += $divalidasi;
        $total_evidence_belum_validasi +=$v_paket['belum_validasi'];
        $total_nilai += $nilai_paket;



         }
?>
 <!-- </tbody> -->


   <tr>
     <td colspan="5" align="right">Total</td>
    
     <td align="right"><?php echo number_format($total_pagu_paket) ?></td>
     <td align="right"><?php echo number_format($total_pagu_terkontrak) ?></td>
     <td align="center" colspan="3">
      <?php echo $banyak_paket ?> Paket <br>
      <?php echo $banyak_terkontrak ?> Terkontrak <br>
    </td>
   
    
   </tr>
   
</table>


</body>