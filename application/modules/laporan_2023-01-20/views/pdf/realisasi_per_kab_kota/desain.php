<style>
  .font_laporan{
    font-size:8px;
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

  .rata_kanan{
    text-align : right;

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
  .ttd{
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
    <th rowspan="3"  width="20px">No</th>
    <th rowspan="3"  width="385px">SKPD</th>
    <th rowspan="3" width="85px">Pagu</th>
    <th colspan="3" width="85px">Fisik</th>
    <th colspan="4" width="85px">Keuangan</th>
  </tr>
  <tr>
    <th rowspan="2">Target</th>
    <th rowspan="2">Realisasi</th>
    <th rowspan="2">Deviasi</th>
    <th rowspan="2">Target</th>
    <th colspan="2">Realisasi</th>
    <th rowspan="2">Deviasi</th>
   
  
  </tr>
  
  <tr>
    <th>Rp.</th>
    <th>%</th>
   
   
  
  </tr>
  
  
 </thead>
 <tbody>
  <?php 
  $no=1;

  $total_pagu_bo = 0;
  $total_pagu_bm = 0;
  $total_pagu_btt = 0;
  $total_pagu_bt = 0;
  $total_pagu_semua = 0;

  $total_nilai_realisasi_bo = 0;
  $total_nilai_realisasi_bm = 0;
  $total_nilai_realisasi_btt = 0;
  $total_nilai_realisasi_bt = 0;

  $total_nilai_realisasi_bo_rf = 0;
  $total_nilai_realisasi_bm_rf = 0;
  $total_nilai_realisasi_btt_rf = 0;
  $total_nilai_realisasi_bt_rf = 0;



  $total_persen_realisasi_bo = 0;
  $total_persen_realisasi_bm = 0;
  $total_persen_realisasi_btt = 0;
  $total_persen_realisasi_bt = 0;

  $total_persen_realisasi_bo_rf = 0;
  $total_persen_realisasi_bm_rf = 0;
  $total_persen_realisasi_btt_rf = 0;
  $total_persen_realisasi_bt_rf = 0;


  $hitung_realisasi_bo =0;
  $hitung_realisasi_bm =0;
  $hitung_realisasi_btt =0;
  $hitung_realisasi_bt =0;

  $total_rf = 0;
  $total_nilai_rk = 0;
  $total_persen_rk = 0;
  $total_skpd = 0;
  foreach ($skpd as $k => $v) { 
    $total_skpd +=1;
  

    ?>
   <tr style="display:none">
     <td><?php echo $no++ ?></td>
     <td><?php echo $v->nama_instansi ?></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
    
   </tr>
 <?php } 

$ratarata_realisasi_bo_rf = $hitung_realisasi_bo > 0 ? $total_persen_realisasi_bo_rf / $hitung_realisasi_bo : $total_persen_realisasi_bo_rf ;
$ratarata_realisasi_bm_rf = $hitung_realisasi_bm > 0 ? $total_persen_realisasi_bm_rf / $hitung_realisasi_bm : 0 ;
$ratarata_realisasi_btt_rf = $hitung_realisasi_btt > 0 ? $total_persen_realisasi_btt_rf / $hitung_realisasi_btt : 0 ;
$ratarata_realisasi_bt_rf = $hitung_realisasi_bt > 0 ? $total_persen_realisasi_bt_rf / $hitung_realisasi_bt : 0 ;

$ratarata_realisasi_bo = $total_nilai_realisasi_bo > 0 ? ($total_nilai_realisasi_bo / $total_pagu_bo) * 100 : 0;
$ratarata_realisasi_bm = $total_nilai_realisasi_bm > 0 ? ($total_nilai_realisasi_bm / $total_pagu_bm) * 100 : 0;
$ratarata_realisasi_btt = $total_nilai_realisasi_btt > 0 ? ($total_nilai_realisasi_btt / $total_pagu_btt) * 100 : 0;
$ratarata_realisasi_bt = $total_nilai_realisasi_bt > 0 ? ($total_nilai_realisasi_bt / $total_pagu_bt) * 100 : 0;



$ratarata_total_rf = $total_rf / $total_skpd;

// $ratarata_total_rk = $total_persen_rk / $total_skpd;
$ratarata_total_rk = ($total_nilai_rk / $total_pagu_semua) * 100 ; // $total_skpd;
$show_ratarata_total_rk = $ratarata_total_rk >0 ? $ratarata_total_rk : 0 ;


$ratarata_realisasi_bo_rf = $total_pagu_bo > 0 ? $ratarata_realisasi_bo_rf : 0;
$ratarata_realisasi_bm_rf = $total_pagu_bm > 0 ? $ratarata_realisasi_bm_rf : 0;
$ratarata_realisasi_btt_rf = $total_pagu_btt > 0 ? $ratarata_realisasi_btt_rf : 0;
$ratarata_realisasi_bt_rf = $total_pagu_bt > 0 ? $ratarata_realisasi_bt_rf : 0;

$show_total_nilai_realisasi_bo = $total_pagu_bo > 0 ? $total_nilai_realisasi_bo : 0 ; 
$show_total_nilai_realisasi_bm = $total_pagu_bm > 0 ? $total_nilai_realisasi_bm : 0 ; 
$show_total_nilai_realisasi_btt = $total_pagu_btt > 0 ? $total_nilai_realisasi_btt : 0 ; 
$show_total_nilai_realisasi_bt = $total_pagu_bt > 0 ? $total_nilai_realisasi_bt : 0 ; 


$ratarata_realisasi_bo = $total_pagu_bo > 0 ? $ratarata_realisasi_bo : 0;
$ratarata_realisasi_bm = $total_pagu_bm > 0 ? $ratarata_realisasi_bm : 0;
$ratarata_realisasi_btt = $total_pagu_btt > 0 ? $ratarata_realisasi_btt : 0;
$ratarata_realisasi_bt = $total_pagu_bt > 0 ? $ratarata_realisasi_bt : 0;




$show_ratarata_realisasi_bo = $ratarata_realisasi_bo ==INF ? 0 : $ratarata_realisasi_bo;
$show_ratarata_realisasi_bm = $ratarata_realisasi_bm ==INF ? 0 : $ratarata_realisasi_bm;
$show_ratarata_realisasi_btt = $ratarata_realisasi_btt ==INF ? 0 : $ratarata_realisasi_btt;
$show_ratarata_realisasi_bt = $ratarata_realisasi_bt ==INF ? 0 : $ratarata_realisasi_bt;




$pembagi_fisik_bo_total = $total_pagu_bo == 0 ? 0 : 1;
$pembagi_fisik_bm_total = $total_pagu_bm == 0 ? 0 : 1;
$pembagi_fisik_btt_total = $total_pagu_btt == 0 ? 0 : 1;
$pembagi_fisik_bt_total = $total_pagu_bt == 0 ? 0 : 1;

$pembagi_fisik_total = $pembagi_fisik_bo_total + $pembagi_fisik_bm_total + $pembagi_fisik_btt_total + $pembagi_fisik_bt_total;

$total_fisik_semua = $ratarata_realisasi_bo_rf + $ratarata_realisasi_bm_rf + $ratarata_realisasi_btt_rf + $ratarata_realisasi_bt_rf;

@$persen_rf_total = $total_fisik_semua /  $pembagi_fisik_total ;
$nilai_rf_kota_ratarata =$total_fisik_semua > 0 ? $persen_rf_total : 0 ;

 ?>
 </tbody>


</table>
<?php   if ($config->id_pj!='') { 
  if ($config->ibukota_kab_kota=='') {
      $ibukota = ucwords($nama_kota);

  }else{
      $ibukota = ucwords($config->ibukota_kab_kota);
  }?>
<div style="float:right; width:220px; margin-top:20px;" class="ttd">
  <?php echo $ibukota.',  '.date('d').' '.bulan_global(date('n')).' '.date('Y') ?> <br>
  <?php echo $config->jabatan.'<br>'.$config->nama_instansi?>
  <br><br><br><br>
  <?php echo $config->nama.'<br>NIP : '.$config->nip?>
</div>
<?php   } ?>
</body>