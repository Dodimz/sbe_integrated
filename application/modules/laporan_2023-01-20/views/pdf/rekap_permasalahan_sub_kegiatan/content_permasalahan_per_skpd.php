<style>
  .font_laporan{
    font-size:9px;
    font-family: 'arial';
  }
  .table {
    
    border-collapse: collapse;
    width:100%;
}
.table td, th {
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

<table class="font_laporan border table">
 <thead class="header">
    <tr>
    <th  width="30px">No</th>
    <th style="width:350px">Program, Kegiatan, Sub Kegiatan</th>
    <th style="width:80px">Permasalahan</th>
    <th style="width:80px">Rencana Tindak Lanjut</th>
   

   
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

   echo json_encode($program);
  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
    <tr style="background: #f0e0fb">
      <td><?php echo $no_program ?></td>
       <td colspan="3" style="font-size:10px"><div><b><?php echo $value->nama_program ?></b></div></td>
     </tr>
    <?php 
    $no_kegiatan=0;
    foreach ($kegiatan as $key => $value_kegiatan) {
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();
    ?>
    <tr style="background:#e0fbf3">
      <td><?php echo $no_program.'.'.$no_kegiatan ?></td>
       <td colspan="3" style="padding-left:1.5em" ><div class="nama_kegiatan"><b><?php echo $value_kegiatan->nama_kegiatan ?></b></div></td>
     </tr>
     <?php 
     foreach ($sub_kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $krsk = $value_sk->kode_rekening_sub_kegiatan;
      $kategori_sub_kegiatan = $value_sk->kategori;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }

         



      ?>
      <tr>
      <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan ?></td>
       <td style="padding-left:3em"><div><?php echo $nama_sub_kegiatan?></div></td>
      

       <td valign="top" align="left">
            <ol>
          <?php 
          $q_show_masalah = $this->db->query("SELECT permasalahan from permasalahan_sub_kegiatan where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_sub_kegiatan='$krsk'")->result();
          foreach ($q_show_masalah as $k_show_masalah => $v_show_masalah) { ?>
              <li><?php echo $v_show_masalah->permasalahan ?></li>
          <?php } ?>
            </ol>
        </td>


        <td valign="top" align="left">
            <ol>
          <?php 
          $q_show_solusi = $this->db->query("SELECT solusi,solusi_by from solusi_permasalahan_sub_kegiatan where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_sub_kegiatan='$krsk'")->result();
          foreach ($q_show_solusi as $k_show_solusi => $v_show_solusi) { 
            $warna = $v_show_solusi->solusi_by=='ADMIN' ? 'style="color:blue"':'';
            ?>
              <li><?php echo $v_show_solusi->solusi ?></li>
          <?php } ?>
            </ol>
        </td>
      
       
     </tr>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->



</table>


</body>