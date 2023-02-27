<style>
  .font_laporan{
    font-size:8px;
    font-family: 'arial';
  }

  .kondisi_laporan{
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
    <th rowspan="4"  width="20px">No</th>
    <th rowspan="4">SKPD</th>
    <th colspan="5"> Pagu</th>
    <th colspan="11"> Realisasi</th>
   
  </tr>
  <tr>
    <th rowspan="3">Belanja Operasi</th>
    <th rowspan="3">Belanja Modal</th>
    <th rowspan="3">Belanja <br>Tidak Terduga</th>
    <th rowspan="3">Belanja Transfer</th>
    <th rowspan="3">Total</th>
    <th colspan="10">Keuangan</th>
    <th rowspan="3">Fisik</th>
  </tr>
  <tr>
    <th colspan="2" style="width:100px">Belanja Operasi</th>
    <th colspan="2" style="width:100px">Belanja Modal</th>
    <th colspan="2" style="width:100px">Belanja Tidak Terduga</th>
    <th colspan="2" style="width:100px">Belanja Transfer</th>
    <th colspan="2" style="width:100px">Total</th>
  </tr>
  <tr>
      <?php for ($i=0; $i < 5; $i++) {  ?>
      <th>Rp.</th>
      <th width="10px">%</th>
  <?php } ?>
  </tr>

 </thead>
 <tbody>
  <?php 
  $no=0;
    $hitung_realisasi_bo =0;
  $hitung_realisasi_bm =0;
  $hitung_realisasi_btt =0;
  $hitung_realisasi_bt =0;

  $total_pagu_bo_semua = 0;
  $total_pagu_bm_semua = 0;
  $total_pagu_btt_semua = 0;
  $total_pagu_bt_semua = 0;

  $total_rk_bo_semua = 0;
  $total_rk_bm_semua = 0;
  $total_rk_btt_semua = 0;
  $total_rk_bt_semua = 0;

  $total_rf_bo_semua = 0;
  $total_rf_bm_semua = 0;
  $total_rf_btt_semua = 0;
  $total_rf_bt_semua = 0;
  $total_rf_semua = 0;

  $jumlah_kab_kota = 0;

  foreach ($list_kota as $k => $v) { 
    $jumlah_kab_kota++;
    $id_kota = $v->id_kota;
    $pagu = $model_realisasi_gabungan->pagu_kota($id_kota, $tahap, $tahun);
    $pagu_bo = $pagu->total_pagu_bo=='' ? 0 : $pagu->total_pagu_bo;
    $pagu_bm = $pagu->total_pagu_bm=='' ? 0 : $pagu->total_pagu_bm;
    $pagu_btt = $pagu->total_pagu_btt=='' ? 0 : $pagu->total_pagu_btt;
    $pagu_bt = $pagu->total_pagu_bt=='' ? 0 : $pagu->total_pagu_bt;




    $total_pagu_bo_semua += $pagu_bo ;
    $total_pagu_bm_semua += $pagu_bm ;
    $total_pagu_btt_semua += $pagu_btt ;
    $total_pagu_bt_semua += $pagu_bt ;
    $pagu_total = $pagu_bo + $pagu_bm + $pagu_btt + $pagu_bt ;
    $no++; 


              $realisasi_dipilih = $model_realisasi_gabungan->cek_realisasi_dipilih($tahap, $tahun, $id_kota)->row_array();

              if ($realisasi_dipilih['realisasikan_bo']>0) {
                $hitung_realisasi_bo +=1;
              }
              if ($realisasi_dipilih['realisasikan_bm']>0) {
                $hitung_realisasi_bm +=1;
              }
              if ($realisasi_dipilih['realisasikan_btt']>0) {
                $hitung_realisasi_btt +=1;
              }
              if ($realisasi_dipilih['realisasikan_bt']>0) {
                $hitung_realisasi_bt +=1;
              }


  $realisasi_bo = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bo')->row_array()['realisasi_bo'];
  $realisasi_bm = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bm')->row_array()['realisasi_bm'];
  $realisasi_btt = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_btt')->row_array()['realisasi_btt'];
  $realisasi_bt = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bt')->row_array()['realisasi_bt'];
  // fusuk
  $realisasi_bo_rf = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bo')->row_array()['realisasi_bo_rf'];
  $realisasi_bm_rf = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bm')->row_array()['realisasi_bm_rf'];
  $realisasi_btt_rf = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_btt')->row_array()['realisasi_btt_rf'];
  $realisasi_bt_rf = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_bt')->row_array()['realisasi_bt_rf'];
  $realisasi_rf_total = $model_realisasi_gabungan->total_realisasi_perjenis($bulan, $tahap,$tahun, $id_kota, 'realisasikan_rf_total')->row_array()['realisasi_rt_total'];


  $pembagi_bo  = $model_realisasi_gabungan->banyak_realisasikan($tahun , $tahap, $id_kota, 'realisasikan_bo')->row_array()['banyak_realisasikan_bo'];
  $pembagi_bm  = $model_realisasi_gabungan->banyak_realisasikan($tahun , $tahap, $id_kota, 'realisasikan_bm')->row_array()['banyak_realisasikan_bm'];
  $pembagi_btt  = $model_realisasi_gabungan->banyak_realisasikan($tahun , $tahap, $id_kota, 'realisasikan_btt')->row_array()['banyak_realisasikan_btt'];
  $pembagi_bt  = $model_realisasi_gabungan->banyak_realisasikan($tahun , $tahap, $id_kota, 'realisasikan_bt')->row_array()['banyak_realisasikan_bt'];

  $pembagi_rf_total = $model_realisasi_gabungan->total_skpd_kab_kota($id_kota)->num_rows();


  $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
  $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
  $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
  $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;
  // fisik

@$ratarata_bo_rf = ($realisasi_bo_rf > 0 && $pagu_bo) ? ($realisasi_bo_rf / $pembagi_bo) : 0 ;
@$ratarata_bm_rf = ($realisasi_bm_rf > 0 && $pagu_bm) ? ($realisasi_bm_rf / $pembagi_bm) : 0 ;
@$ratarata_btt_rf = ($realisasi_btt_rf > 0 && $pagu_btt) ? ($realisasi_btt_rf / $pembagi_btt) : 0 ;
@$ratarata_bt_rf = ($realisasi_bt_rf > 0 && $pagu_bt) ? ($realisasi_bt_rf / $pembagi_bt) : 0 ;
@$ratarata_rf_total = ($realisasi_rf_total > 0 && $pagu_total) ? ($realisasi_rf_total  / $pembagi_rf_total) : 0 ;


  $jumlah_realisasi_bo_rf = $realisasi_bo_rf =='' ? 0 : round($ratarata_bo_rf, 2);
  $jumlah_realisasi_bm_rf = $realisasi_bm_rf =='' ? 0 : round($ratarata_bm_rf, 2);
  $jumlah_realisasi_btt_rf = $realisasi_btt_rf =='' ? 0 : round($ratarata_btt_rf, 2);
  $jumlah_realisasi_bt_rf = $realisasi_bt_rf =='' ? 0 : round($ratarata_bt_rf, 2);
  $jumlah_realisasi_rf_total = $realisasi_rf_total =='' ? 0 : round($ratarata_rf_total, 2);





$nilai_rk_kota_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? 0 : $jumlah_realisasi_bo;
               $nilai_rk_kota_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? 0 : $jumlah_realisasi_bm;
               $nilai_rk_kota_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? 0 : $jumlah_realisasi_btt;
               $nilai_rk_kota_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? 0 : $jumlah_realisasi_bt;

               // $nilai_rk_kota_total = $nilai_rk_kota_bo +$nilai_rk_kota_bm +$nilai_rk_kota_btt +$nilai_rk_kota_bt ;
               $nilai_rf_kota_total =  $jumlah_realisasi_rf_total;
               // $nilai_rf_kota_total = $jumlah_realisasi_bo_rf + $jumlah_realisasi_bm_rf + $jumlah_realisasi_btt_rf + $jumlah_realisasi_bt_rf;
               $pembagi_nilai_rf_total = $realisasi_dipilih['realisasikan_bo'] + $realisasi_dipilih['realisasikan_bm'] + $realisasi_dipilih['realisasikan_btt'] + $realisasi_dipilih['realisasikan_bt'];
               @$show_nilai_rf_kota_total = $nilai_rf_kota_total ;// $pembagi_nilai_rf_total ;
               // @$show_nilai_rf_kota_total = $nilai_rf_kota_total / $pembagi_nilai_rf_total ;


              @$persen_rk_kota_bo = ($nilai_rk_kota_bo / $pagu_bo ) * 100; 
              @$persen_rk_kota_bm = ($nilai_rk_kota_bm / $pagu_bm ) * 100; 
              @$persen_rk_kota_btt = ($nilai_rk_kota_btt / $pagu_btt ) * 100; 
              @$persen_rk_kota_bt = ($nilai_rk_kota_bt / $pagu_bt ) * 100; 

              $show_persen_rk_kota_bo = $persen_rk_kota_bo >0 ? $persen_rk_kota_bo : 0 ;
              $show_persen_rk_kota_bm = $persen_rk_kota_bm >0 ? $persen_rk_kota_bm : 0 ;
              $show_persen_rk_kota_btt = $persen_rk_kota_btt >0 ? $persen_rk_kota_btt : 0 ;
              $show_persen_rk_kota_bt = $persen_rk_kota_bt >0 ? $persen_rk_kota_bt : 0 ;


              // $show_persen_rk_kota_bo = $show_persen_rk_kota_bo == INF ? 0 : $show_persen_rk_kota_bo;
              // $show_persen_rk_kota_bm = $show_persen_rk_kota_bm == INF ? 0 : $show_persen_rk_kota_bm;
              // $show_persen_rk_kota_btt = $show_persen_rk_kota_btt == INF ? 0 : $show_persen_rk_kota_btt;
              // $show_persen_rk_kota_bt = $show_persen_rk_kota_bt == INF ? 0 : $show_persen_rk_kota_bt;
              $show_persen_rk_kota_bo = $show_persen_rk_kota_bo == INF ? 0 : $show_persen_rk_kota_bo;
              $show_persen_rk_kota_bm = $show_persen_rk_kota_bm == INF ? 0 : $show_persen_rk_kota_bm;
              $show_persen_rk_kota_btt = $show_persen_rk_kota_btt == INF ? 0 : $show_persen_rk_kota_btt;
              $show_persen_rk_kota_bt = $show_persen_rk_kota_bt == INF ? 0 : $show_persen_rk_kota_bt;
               @$persen_rk_kota_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $show_persen_rk_kota_bo;
               @$persen_rk_kota_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $show_persen_rk_kota_bm;
               @$persen_rk_kota_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $show_persen_rk_kota_btt;
               @$persen_rk_kota_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $show_persen_rk_kota_bt;
               @$persen_rk_kota_total  =  $nilai_rk_kota_total / $v->pagu_total; 



$total_rk_bo_semua += $jumlah_realisasi_bo;
$total_rk_bm_semua += $jumlah_realisasi_bm;
$total_rk_btt_semua += $jumlah_realisasi_btt;
$total_rk_bt_semua += $jumlah_realisasi_bt;

$total_rf_bo_semua += $jumlah_realisasi_bo_rf;
$total_rf_bm_semua += $jumlah_realisasi_bm_rf;
$total_rf_btt_semua += $jumlah_realisasi_btt_rf;
$total_rf_bt_semua += $jumlah_realisasi_bt_rf;
$total_rf_semua += $jumlah_realisasi_rf_total ;



  $tampil_nilai_rk_kota_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : number_format($jumlah_realisasi_bo);
  $tampil_nilai_rk_kota_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : number_format($jumlah_realisasi_bm);
  $tampil_nilai_rk_kota_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : number_format($jumlah_realisasi_btt);
  $tampil_nilai_rk_kota_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : number_format($jumlah_realisasi_bt);
  // fisik
  $tampil_nilai_rk_kota_bo_rf  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $jumlah_realisasi_bo_rf;
  $tampil_nilai_rk_kota_bm_rf  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $jumlah_realisasi_bm_rf;
  $tampil_nilai_rk_kota_btt_rf  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $jumlah_realisasi_btt_rf;
  $tampil_nilai_rk_kota_bt_rf  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $jumlah_realisasi_bt_rf;

  $banyak_skpd_kab_kota = $this->db->query("SELECT * from master_instansi_kab_kota where id_kota='$id_kota'")->num_rows();
  @$persen_rf_total = $nilai_rf_kota_total /  $banyak_skpd_kab_kota ;
  // $nilai_rf_kota_ratarata = $persen_rf_total > 0 ? $persen_rf_total : 0 ;

  $pembagi_fisik_bo_total = $pagu_bo == 0 ? 0 : 1;
  $pembagi_fisik_bm_total = $pagu_bm == 0 ? 0 : 1;
  $pembagi_fisik_btt_total = $pagu_btt == 0 ? 0 : 1;
  $pembagi_fisik_bt_total = $pagu_bt == 0 ? 0 : 1;

  $pembagi_fisik_total = $pembagi_fisik_bo_total + $pembagi_fisik_bm_total + $pembagi_fisik_btt_total + $pembagi_fisik_bt_total;
  $nilai_rf_total = $jumlah_realisasi_bo_rf + $jumlah_realisasi_bm_rf + $jumlah_realisasi_btt_rf + $jumlah_realisasi_bt_rf;
  @$persen_rf_total = $nilai_rf_total /  $pembagi_fisik_total ;
  $nilai_rf_kota_ratarata =  $realisasi_rf_total > 0 ? $jumlah_realisasi_rf_total : 0 ;


  $nilai_rk_kota_total = $nilai_rk_kota_bo +$nilai_rk_kota_bm +$nilai_rk_kota_btt +$nilai_rk_kota_bt ; 
  @$persen_rk_instansi_total  =  $nilai_rk_instansi_total / $pagu_total; 
  @$persen_rk_total = (($nilai_rk_kota_total / $pagu_total) * 100);
  $show_persen_rk_total = $persen_rk_total >0 ? $persen_rk_total : 0;



    ?>
   <tr> 
    <td><?php echo $no ?></td>
      <td><?php echo $v->nama_kota ?></td>
      <td class="rata_kanan"><?php echo number_format($pagu_bo) ?></td>
      <td class="rata_kanan"><?php echo number_format($pagu_bm) ?></td>
      <td class="rata_kanan"><?php echo number_format($pagu_btt) ?></td>
      <td class="rata_kanan"><?php echo number_format($pagu_bt) ?></td>
      <td class="rata_kanan"><?php echo number_format($pagu_total) ?></td>
      <td class="rata_kanan"><?php echo $tampil_nilai_rk_kota_bo; ?></td>
      <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bo']==0 ? '-' :round($persen_rk_kota_bo,2); ?></td>
      <td class="rata_kanan"><?php echo $tampil_nilai_rk_kota_bm; ?></td>
      <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bm']==0 ? '-' :round($persen_rk_kota_bm,2); ?></td>
      <td class="rata_kanan"><?php echo $tampil_nilai_rk_kota_btt; ?></td>
      <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_btt']==0 ? '-' :round($persen_rk_kota_btt,2); ?></td>
      <td class="rata_kanan"><?php echo $tampil_nilai_rk_kota_bt; ?></td>
      <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bt']==0 ? '-' :round($persen_rk_kota_bt,2); ?></td>
   
      <td class="rata_kanan"><?php echo number_format($nilai_rk_kota_total) ?></td>
      <td class="rata_kanan"><?php echo round($show_persen_rk_total,2) ?></td>
      <td class="rata_kanan"><?php echo round($nilai_rf_kota_ratarata,2) ?></td>

   </tr> 
  <?php } 

	$show_total_rk_bo_semua =  $total_pagu_bo_semua > 0 ? $total_rk_bo_semua : 0;
	$show_total_rk_bm_semua =  $total_pagu_bm_semua > 0 ? $total_rk_bm_semua : 0;
	$show_total_rk_btt_semua =  $total_pagu_btt_semua > 0 ? $total_rk_btt_semua : 0;
	$show_total_rk_bt_semua =  $total_pagu_bt_semua > 0 ? $total_rk_bt_semua : 0;


	$total_pagu_semuanya = $total_pagu_bo_semua + $total_pagu_bm_semua + $total_pagu_btt_semua + $total_pagu_bt_semua;
	$total_rk_semuanya = $total_rk_bo_semua + $total_rk_bm_semua + $total_rk_btt_semua + $total_rk_bt_semua;


	@$persen_total_rk_bo_semua = ($total_rk_bo_semua / $total_pagu_bo_semua) * 100 ;
	@$persen_total_rk_bm_semua = ($total_rk_bm_semua / $total_pagu_bm_semua) * 100 ;
	@$persen_total_rk_btt_semua = ($total_rk_btt_semua / $total_pagu_btt_semua) * 100 ;
	@$persen_total_rk_bt_semua = ($total_rk_bt_semua / $total_pagu_bt_semua) * 100 ;
	@$persen_total_rk_semuanya = ($total_rk_semuanya / $total_pagu_semuanya) * 100 ;

	$show_persen_rk_bo_semua =  $total_pagu_bo_semua > 0 ? $persen_total_rk_bo_semua : 0;
	$show_persen_rk_bm_semua =  $total_pagu_bm_semua > 0 ? $persen_total_rk_bm_semua : 0;
	$show_persen_rk_btt_semua =  $total_pagu_btt_semua > 0 ? $persen_total_rk_btt_semua : 0;
	$show_persen_rk_bt_semua =  $total_pagu_bt_semua > 0 ? $persen_total_rk_bt_semua : 0;
	$show_persen_rk_semuanya =  $total_pagu_semuanya > 0 ? $persen_total_rk_semuanya : 0;


@$show_total_bo_rf_semua = $total_rf_bo_semua / $hitung_realisasi_bo ; 
@$show_total_bm_rf_semua = $total_rf_bm_semua / $hitung_realisasi_bm ; 
@$show_total_btt_rf_semua = $total_rf_btt_semua / $hitung_realisasi_btt ; 
@$show_total_bt_rf_semua = $total_rf_bt_semua / $hitung_realisasi_bt ; 

$total_rf_semuannya = $show_total_bo_rf_semua + $show_total_bm_rf_semua + $show_total_btt_rf_semua + $show_total_bt_rf_semua;
$show_total_rf_semuanya = $total_rf_semua / $jumlah_kab_kota;



  ?>
 </tbody> 
 <tfoot>
   <tr>
       <td colspan="2">Total</td> 
       <td class="rata_kanan"> <?php echo number_format($total_pagu_bo_semua); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($total_pagu_bm_semua); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($total_pagu_btt_semua); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($total_pagu_bt_semua); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($total_pagu_semuanya); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($show_total_rk_bo_semua) ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_persen_rk_bo_semua,2); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($show_total_rk_bm_semua) ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_persen_rk_bm_semua,2); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($show_total_rk_btt_semua) ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_persen_rk_btt_semua,2); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($show_total_rk_bt_semua) ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_persen_rk_bt_semua,2); ?> </td> 
       <td class="rata_kanan"> <?php echo number_format($total_rk_semuanya) ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_persen_rk_semuanya,2); ?> </td> 
       <td class="rata_kanan"> <?php echo round($show_total_rf_semuanya,2) ?> </td> 

   </tr>  
 </tfoot> 

</table>


</body>