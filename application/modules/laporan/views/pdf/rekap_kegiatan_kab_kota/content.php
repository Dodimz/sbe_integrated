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


  .judul_laporan{
    margin-top:15px;
    text-align : center;
    font-family: 'arial';
    font-size:12px;
  }
  .skpd{
    font-size:15px;
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
    <th colspan="4"  >Sub Kegiatan</th>
    <th colspan="5">Paket Pekerjaan</th>
  </tr>
  <tr>
    <th rowspan="2">Kecamatan <br></th>  
    <th rowspan="2" width="75px">Kode Rekening <br></th>  
    <th rowspan="2">Sub Kegiatan <br></th>  
    <th rowspan="2">Pagu Sub Kegiatan <br></th>  
    <th rowspan="2" width="50px">Swakelola <br></th>  
    <th colspan="2">Penyedia</th>
    <th rowspan="2" width="50px">Total Paket <br></th>  
    <th rowspan="2" width="50px">Total Pagu Paket Pada Sub Kegiatan</th>  
  </tr>
  <tr>
    <th width="50px">Konstruksi</th>
    <th width="50px">Non Konstruksi</th>
  
  </tr>
 </thead>
 <tbody>
   <?php 
  $no   = 0;
  $total_pagu = 0;
  $totalpaket_swa = 0;
  $totalpaket_penyedia_konstruksi = 0;
  $totalpaket_penyedia_non_konstruksi = 0;
  $totalpaket_semua = 0;
  $totalpagu_paket_semua = 0;
 
  foreach ($lokasi_per_skpd as $k => $v) { 
    $tahap = 4;//tahapan_apbd();
    $no_ski = 0;
    $id_instansi = $v->id_instansi;
    $id_kab_kota = $v->id_kab_kota;
    $q_ski = $this->db->query("SELECT lpp.id_paket_pekerjaan as id_paket_pekerjaan,
      substr(pp.kode_rekening_sub_kegiatan,1,15) as kode_rekening_sub_kegiatan, msk.nama_sub_kegiatan, kec.nama_kecamatan,
      ski.kode_sub_kegiatan, total_anggaran_sub_kegiatan(pp.kode_rekening_sub_kegiatan,$tahap,pp.id_instansi,ski.kode_kegiatan,ski.kode_program, $tahun) AS pagu,
      ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan
      from lokasi_paket_pekerjaan lpp
      left join paket_pekerjaan pp on lpp.id_paket_pekerjaan = pp.id_paket_pekerjaan
      left join sub_kegiatan_instansi ski on ski.kode_sub_kegiatan = pp.kode_rekening_sub_kegiatan and ski.id_instansi = pp.id_instansi
      left join master_sub_kegiatan msk  on(trim(substr(pp.kode_rekening_sub_kegiatan,1,15)) = trim(msk.kode_sub_kegiatan))
      left join kecamatan kec on lpp.id_kecamatan=kec.id_kecamatan
      where lpp.id_instansi = '$id_instansi' and lpp.id_kab_kota='$id_kab_kota' and ski.tahun='$tahun'
      group by pp.kode_rekening_sub_kegiatan
      ");
    $j_ski = $q_ski->num_rows();
    $no++;

    ?>
      
      <tr class="skpd">
        <td ><b><?php echo $no ?></b></td>
        <td colspan="9"><b><?php echo $v->nama_instansi ?></b></td>
      </tr>
      <?php
      $n = 0; 
      foreach ($q_ski->result() as $key => $d_ski) {
        $no_ski ++;
        $kode_rekening_sub_kegiatan = $d_ski->kode_rekening_sub_kegiatan;
        $q_hitung_paket = $this->db->query("SELECT distinct  pp.kode_rekening_sub_kegiatan as krsk, pp.id_instansi,
        (SELECT count(id_paket_pekerjaan) from paket_pekerjaan where kode_rekening_sub_kegiatan=pp.kode_rekening_sub_kegiatan and jenis_paket='SWAKELOLA') as totalpaket_swakelola, 
        (SELECT count(id_paket_pekerjaan) from paket_pekerjaan where kode_rekening_sub_kegiatan=pp.kode_rekening_sub_kegiatan and jenis_paket='PENYEDIA' and kategori='KONTRUKSI') as totalpaket_penyedia_konstruksi, 
        (SELECT count(id_paket_pekerjaan) from paket_pekerjaan where kode_rekening_sub_kegiatan=pp.kode_rekening_sub_kegiatan and jenis_paket='PENYEDIA' and kategori='NON KONTRUKSI') as totalpaket_penyedia_non_konstruksi, 
        (SELECT sum(pagu) from paket_pekerjaan where kode_rekening_sub_kegiatan=pp.kode_rekening_sub_kegiatan and id_instansi=pp.id_instansi and tahun='$tahun') as total_pagu_paket 
          from paket_pekerjaan pp where pp.kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and pp.id_instansi='$id_instansi' and tahun = '$tahun'")->row_array();
        $swakelola = $q_hitung_paket['totalpaket_swakelola'] =='' ? 0 : $q_hitung_paket['totalpaket_swakelola'];
        $penyedia_kontruksi = $q_hitung_paket['totalpaket_penyedia_konstruksi'] =='' ? 0 : $q_hitung_paket['totalpaket_penyedia_konstruksi'];
        $penyedia_non_kontruksi = $q_hitung_paket['totalpaket_penyedia_non_konstruksi'] =='' ? 0 : $q_hitung_paket['totalpaket_penyedia_non_konstruksi'];
        $total_paket = $swakelola + $penyedia_kontruksi + $penyedia_non_kontruksi ;
        $total_pagu_paket = $q_hitung_paket['total_pagu_paket'] =='' ? 0 : $q_hitung_paket['total_pagu_paket'];;
        $n++; 
      if ($n==1) {
        $bottom_border = ' border-top:solid; border-width:0.01em; border-bottom:none';
        $nama_skpd = $v->nama_instansi;
      } 
      elseif ($n==$j_ski) {
        $bottom_border = ' border-bottom:solid; border-width:0.01em; border-top:none';
        $nama_skpd = '';
      }else{
        $bottom_border = 'border:none;';
        $nama_skpd = '';
      }

      $nama_sub_kegiatan = $d_ski->kategori=='Unit Pelaksana' ? $d_ski->nama_sub_kegiatan.'<br> ['.$d_ski->jenis_sub_kegiatan.' - '.$d_ski->keterangan.']': $d_ski->nama_sub_kegiatan;
       
        ?>
      <tr>
     
        <td><?php echo $no.'.'.$no_ski ?></td>
        <td><?php echo $d_ski->nama_kecamatan ?></td>
        <td><?php echo $d_ski->kode_rekening_sub_kegiatan ?></td>
        <td><?php echo $nama_sub_kegiatan ?></td>
        <td align="right"><?php echo number_format($d_ski->pagu) ?></td>
        <td><center><?php echo $swakelola ?></center></td>
        <td><center><?php echo $penyedia_kontruksi ?></center></td>
        <td><center><?php echo $penyedia_non_kontruksi ?></center></td>
        <td><center><?php echo $total_paket ?></center></td>
        <td align="right"><?php echo number_format($total_pagu_paket) ?></td>
     </tr>
  <?php 

    $total_pagu +=$d_ski->pagu;
  $totalpaket_swa +=$swakelola;
  $totalpaket_penyedia_konstruksi +=$penyedia_kontruksi;
  $totalpaket_penyedia_non_konstruksi +=$penyedia_non_kontruksi;
  $totalpaket_semua +=$total_paket;
  $totalpagu_paket_semua +=$total_pagu_paket;
     }
    } //akhir foreach ($kab_kota as $k => $v) { 
?>
 </tbody>
 <tfoot>
   <tr>
     <td colspan="4">Total</td>
     <td align="right"><?php echo number_format($total_pagu) ?></td>
     <td align="center"><?php echo number_format($totalpaket_swa) ?></td>
     <td align="center"><?php echo number_format($totalpaket_penyedia_konstruksi) ?></td>
     <td align="center"><?php echo number_format($totalpaket_penyedia_non_konstruksi) ?></td>
     <td align="center"><?php echo number_format($totalpaket_semua) ?></td>
     <td align="right"><?php echo number_format($totalpagu_paket_semua) ?></td>
   </tr>
 </tfoot>

</table>
</body>