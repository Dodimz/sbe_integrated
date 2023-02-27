<style>
  .font_laporan{
    font-size:7.5px;
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
    <th width="30px" rowspan="2">No</th>

    <th colspan="2" >Data APBD</th>
    <th colspan="3" >Paket Pekerjaan</th>
    <th colspan="8" >Data Kontrak</th>
   

   
  </tr>

  <tr>
    <th>Sub Kegiatan</th>
    <th>PPTK</th>
    <th>Nama Paket</th>
    <!-- <th>Jenis Paket</th> -->
    <th>Metode</th>
    <th>Pagu Paket</th>
    <th>Jenis Kontrak</th>
    <th>Nomor Kontrak</th>
    <th>Pelaksana</th>
    <th>Nilai Kontrak</th>
    <th>Jadwal Kontrak</th>
    <th>Domisili Kontrak</th>
    <th>Menggunakan <br>Titik Koordinat</th>
    <th>Sisa Tender</th>
 
  
  </tr>
 </thead>
 <tbody>
   <?php 
   $no = 0;
   $total_pagu_paket = 0;
   $total_nilai_kontrak = 0; 
   $total_sisa_tender = 0;
      foreach ($kontrak as $k => $v) { 
        $krsk = $v['kode_rekening_sub_kegiatan'];
        $ski  = $this->db->query("SELECT msk.kode_sub_kegiatan, msk.nama_sub_kegiatan,ski.kode_tahap,ski.tahun,ski.kategori AS kategori,ski.jenis_sub_kegiatan AS jenis_sub_kegiatan,ski.keterangan AS keterangan, 
          mu.full_name as pptk
          from  sub_kegiatan_instansi ski 
          left join users_sub_kegiatan usk on  ski.kode_sub_kegiatan =usk.kode_rekening_sub_kegiatan and ski.id_instansi=usk.id_instansi and ski.tahun = usk.tahun_anggaran
          left join master_users mu on usk.id_user = mu.id_user
          left join master_sub_kegiatan msk on  substr(ski.kode_sub_kegiatan,1,15)  = msk.kode_sub_kegiatan where ski.kode_sub_kegiatan='$krsk'")->row_array();

        $nama_sub_kegiatan = $ski['jenis_sub_kegiatan'] =='Unit Pelaksana' ? $ski['nama_sub_kegiatan'].'<br>'.$ski['jenis_sub_kegiatan'].' - '.$ski['keterangan'] : $ski['nama_sub_kegiatan'];


        $sisa_tender = $v['pagu_paket']-$v['nilai_kontrak'];
        $total_pagu_paket += $v['pagu_paket'];
        $total_nilai_kontrak += $v['nilai_kontrak']; 
        $total_sisa_tender += $sisa_tender;
        $no++;?>
        <tr>
          <td><?php echo $no ?></td>
          <td><?php echo $nama_sub_kegiatan ?></td>
          <td><?php echo $ski['pptk'] ?></td>
          <td><?php echo $v['nama_paket'] ?></td>
          <!-- <td><?php echo $v['jenis_paket'] ?></td> -->
          <td><?php echo $v['metode'] ?></td>
          <td align="right" ><?php echo number_format($v['pagu_paket']) ?></td>
          <td><?php echo $v['jenis_kontrak'] ?></td>
          <td><?php echo $v['no_kontrak'] ?></td>
          <td><?php echo $v['pelaksana'] ?></td>
          <td align="right" ><?php echo number_format($v['nilai_kontrak']) ?></td>
          <td><?php echo $v['tgl_awal_pelaksanaan'] ?> s/d <?php echo $v['tgl_akhir_pelaksanaan'] ?></td>

          <td><?php echo $v['nama_provinsi'].'<br>'.$v['nama_kota'].'<br>KECAMATAN '.$v['nama_kecamatan'] ?></td>
          <td align="center"><?php echo $v['latitude']=='' ? 'Tidak' : ' Ya' ?></td>
          <td align="right" ><?php echo number_format($sisa_tender) ?></td>
        </tr>
      <?php } ?>
 </tbody>
 <tfoot>
   <tr>
     <td colspan="5">Total</td>
     <td align="right"> <?php echo number_format($total_pagu_paket) ?> </td>
     <td align="right" colspan="4"> <?php echo number_format($total_nilai_kontrak) ?> </td>
     <td align="right" colspan="4"> <?php echo number_format($total_sisa_tender) ?> </td>
   </tr>
 </tfoot>


</table>


</body>