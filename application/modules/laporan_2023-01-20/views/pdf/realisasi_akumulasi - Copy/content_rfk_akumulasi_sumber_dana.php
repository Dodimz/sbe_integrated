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
    <th colspan="7">Sumber Dana (Rp.)</th>

   
  </tr>


  <tr>
    <th rowspan="2" style="width:80px">PAD</th>
    <th rowspan="2" style="width:80px">DAU</th>
    <th rowspan="2" style="width:80px">DAK</th>
    <th rowspan="2" style="width:80px">DBH</th>
    <th style="width:160px" colspan="2">Lainnya</th>
    <th rowspan="2" style="width:80px">Total</th>
  
  </tr>
  <tr>  
    <th style="width:80px">Rp.</th>
    <th style="width:80px">Keterangan</th>
  </tr>

  <tr></tr>
 </thead>
 <!-- <tbody> -->
   <?php 
  $no_program   = 0;
  $pagu_program   = 0;
  $total_pagu_sub_kegiatan_instansi = 0;
  $total_pad    = 0;
  $total_dau    = 0;
  $total_dak    = 0;
  $total_dbh    = 0;
  $total_lainnya  = 0;
  $total_target_fisik = 0;
  $total_sub_kegiatan = 0;


  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
    <tr style="background: #f0e0fb">
      <td><?php echo $no_program ?></td>
       <td colspan="9" style="font-size:10px"><div><b><?php echo $value->nama_program ?></b></div></td>
     </tr>
    <?php 
    $no_kegiatan=0;
    foreach ($kegiatan as $key => $value_kegiatan) {
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
      $pagu_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();
    ?>
    <tr style="background:#e0fbf3">
      <td><?php echo $no_program.'.'.$no_kegiatan ?></td>
       <td colspan="9" style="padding-left:1.5em" ><div class="nama_kegiatan"><b><?php echo $value_kegiatan->nama_kegiatan ?></b></div></td>
     </tr>
     <?php 
     foreach ($sub_kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $kategori_sub_kegiatan = $value_sk->kategori;

      $total_pagu_sub_kegiatan_instansi +=$value_sk->pagu ;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }

          $sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();


          $total_pad    += isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0;
          $total_dau    += isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0;
          $total_dak    += isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0;
          $total_dbh    += isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0;
          $total_lainnya  += isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0;

          $total_sumber_dana = $sumber_dana['pad'] + $sumber_dana['dau'] + $sumber_dana['dak'] + $sumber_dana['dbh'] + $sumber_dana['lainnya'];
      



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
       <td> <?php echo  $sumber_dana['lainnya']==0 ? '' : $sumber_dana['nama_sumber_dana_lainnya'] ?></td>
       <td align="right"><?php echo number_format($total_sumber_dana) ?></td>
    
     </tr>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->


   <tr>
     <td colspan="2" align="right">Total</td>
     <td align="right"><?php echo number_format($total_pagu_sub_kegiatan_instansi) ?></td>
     <td align="right"><?php echo number_format($total_pad) ?></td>
     <td align="right"><?php echo number_format($total_dau) ?></td>
     <td align="right"><?php echo number_format($total_dak) ?></td>
     <td align="right"><?php echo number_format($total_dbh) ?></td>
     <td align="right"><?php echo number_format($total_lainnya) ?></td>
     <td> - </td>
     <td align="right"> 
      <?php   
          $total_sumber_dana_semuanya = $total_pad + $total_dau + $total_dak + $total_dbh + $total_lainnya ;
          echo number_format($total_sumber_dana_semuanya);
       ?>
      </td>
  
</table>


</body>