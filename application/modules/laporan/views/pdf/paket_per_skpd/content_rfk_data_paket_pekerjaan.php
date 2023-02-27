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
    <th   width="20px">No</th>
    <th  style="width:550px">Program, Kegiatan, Sub Kegiatan, Paket Pekerjaan</th>
    <th > Pagu</th>
    <th > Jenis Paket</th>
    <th > Metode</th> 
    <th >Nilai Paket <br> Pekerjaan</th>
   
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

  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
    <tr style="background: #f0e0fb">
      <td><?php echo $no_program ?></td>
       <td colspan="5" style="font-size:10px;"><div><b><?php echo $value->nama_program ?></b></div></td>
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
       <td colspan="5" style="padding-left:1.5em" ><div class="nama_kegiatan"><b><?php echo $value_kegiatan->nama_kegiatan ?></b></div></td>
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

          $paket = $this->realisasi_akumulasi_model->get_paket_per_sub_kegiatan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan);


          $no_paket = 0;

       



















      ?>
      <tr style="background: #ebeeed">
      <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan ?></td>
       <td style="padding-left:3em"  colspan="5"><div><?php echo $nama_sub_kegiatan?></div></td>

      
       
     </tr>

     <?php 
     if ($paket->num_rows()==0) { ?>
       <tr>
         <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan ?>.0</td>
         <td colspan="5" style="padding-left:4.5em">Tidak ada data paket pekerjaan</td>
       </tr>
     <?php }else{
     
       foreach ($paket->result_array() as $k_paket => $v_paket) { 


        
            $no_paket++;?>
             <tr>
      <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan.'.'.$no_paket ?></td>
       <td style="padding-left:4.5em"><?php echo $v_paket['nama_paket']?></td>
       <td align="right"><?php echo number_format($v_paket['pagu']) ?></td>
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
       <td align="center"><?php echo $nilai_paket = $v_paket['nilai']==''? 0 : $v_paket['nilai'] ?></td>
      
       
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
       }
           ?>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->


   <tr>
     <td colspan="2" align="right">Total</td>
    
     <td align="right"><?php echo number_format($total_pagu_paket) ?></td>
     <td align="center"><?php echo $banyak_paket ?> Paket</td>
     <td align="center">-</td>
     <td align="center"><?php echo '-' ?></td>
   
    
   </tr>
   
</table>


</body>