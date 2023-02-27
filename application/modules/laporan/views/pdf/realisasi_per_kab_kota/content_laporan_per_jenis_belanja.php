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
    <th colspan="2">Belanja Operasi</th>
    <th colspan="2">Belanja Modal</th>
    <th colspan="2">Belanja Tidak Terduga</th>
    <th colspan="2">Belanja Transfer</th>
    <th colspan="2">Total</th>
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
    $id_instansi  = $v->id_instansi;
    $q_pagu = $this->db->query("SELECT pagu_bo,pagu_bm,pagu_btt,pagu_bt from v_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun = $tahun");
    $d_pagu = $q_pagu->row();
    $j_pagu = $q_pagu->num_rows();



    $pagu_bo = $j_pagu == 0 ? 0 : $d_pagu->pagu_bo ;
    $pagu_bm = $j_pagu == 0 ? 0 : $d_pagu->pagu_bm ;
    $pagu_btt = $j_pagu == 0 ? 0 : $d_pagu->pagu_btt ;
    $pagu_bt = $j_pagu == 0 ? 0 : $d_pagu->pagu_bt ;
    $pagu_total = $pagu_bo + $pagu_bm + $pagu_btt + $pagu_bt;
              $realisasi_dipilih = $fisik_keuangan->cek_realisasi_dipilih($tahun, $tahap, $id_instansi)->row_array();

              if ($realisasi_dipilih['realisasikan_bo']==1) {
                $hitung_realisasi_bo +=1;
              }
              if ($realisasi_dipilih['realisasikan_bm']==1) {
                $hitung_realisasi_bm +=1;
              }
              if ($realisasi_dipilih['realisasikan_btt']==1) {
                $hitung_realisasi_btt +=1;
              }
              if ($realisasi_dipilih['realisasikan_bt']==1) {
                $hitung_realisasi_bt +=1;
              }




                $realisasi_bo = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];
                // fusuk
                $realisasi_bo_rf = $pagu_bo == 0 ? 0 : $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo_rf'];
                $realisasi_bm_rf = $pagu_bm == 0 ? 0 : $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm_rf'];
                $realisasi_btt_rf = $pagu_btt == 0 ? 0 : $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt_rf'];
                $realisasi_bt_rf = $pagu_bt == 0 ? 0 : $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt_rf'];


                $realisasi_rf_total = $pagu_total == 0 ? 0 : $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahun, $tahap, $id_instansi, 'realisasi_fisik_total')->row_array()['realisasi_fisik_total'];

                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;
                // fisik
                $jumlah_realisasi_bo_rf = $realisasi_bo_rf =='' ? 0 : $realisasi_bo_rf;
                $jumlah_realisasi_bm_rf = $realisasi_bm_rf =='' ? 0 : $realisasi_bm_rf;
                $jumlah_realisasi_btt_rf = $realisasi_btt_rf =='' ? 0 : $realisasi_btt_rf;
                $jumlah_realisasi_bt_rf = $realisasi_bt_rf =='' ? 0 : $realisasi_bt_rf;
                $jumlah_realisasi_rf_total = $realisasi_rf_total =='' ? 0 : $realisasi_rf_total;




               
               $nilai_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? 0 : $jumlah_realisasi_bo;
               $nilai_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? 0 : $jumlah_realisasi_bm;
               $nilai_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? 0 : $jumlah_realisasi_btt;
               $nilai_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? 0 : $jumlah_realisasi_bt;

               $nilai_rk_instansi_total = $nilai_rk_instansi_bo +$nilai_rk_instansi_bm +$nilai_rk_instansi_btt +$nilai_rk_instansi_bt ;
               $nilai_rf_instansi_total = $jumlah_realisasi_bo_rf + $jumlah_realisasi_bm_rf + $jumlah_realisasi_btt_rf + $jumlah_realisasi_bt_rf;
               $pembagi_nilai_rf_total = $realisasi_dipilih['realisasikan_bo'] + $realisasi_dipilih['realisasikan_bm'] + $realisasi_dipilih['realisasikan_btt'] + $realisasi_dipilih['realisasikan_bt'];

               @$hasil_rf_total = $nilai_rf_instansi_total / $pembagi_nilai_rf_total;
               $show_nilai_rf_instansi_total = $hasil_rf_total == INF ? 0 : $hasil_rf_total  ;


              @$persen_rk_instansi_bo = ($nilai_rk_instansi_bo / $pagu_bo ) * 100; 
              @$persen_rk_instansi_bm = ($nilai_rk_instansi_bm / $pagu_bm ) * 100; 
              @$persen_rk_instansi_btt = ($nilai_rk_instansi_btt / $pagu_btt ) * 100; 
              @$persen_rk_instansi_bt = ($nilai_rk_instansi_bt / $pagu_bt ) * 100; 

              $show_persen_rk_instansi_bo = $persen_rk_instansi_bo >0 ? $persen_rk_instansi_bo : 0 ;
              $show_persen_rk_instansi_bm = $persen_rk_instansi_bm >0 ? $persen_rk_instansi_bm : 0 ;
              $show_persen_rk_instansi_btt = $persen_rk_instansi_btt >0 ? $persen_rk_instansi_btt : 0 ;
              $show_persen_rk_instansi_bt = $persen_rk_instansi_bt >0 ? $persen_rk_instansi_bt : 0 ;


              $show_persen_rk_instansi_bo = $show_persen_rk_instansi_bo == INF ? 0 : $show_persen_rk_instansi_bo;
              $show_persen_rk_instansi_bm = $show_persen_rk_instansi_bm == INF ? 0 : $show_persen_rk_instansi_bm;
              $show_persen_rk_instansi_btt = $show_persen_rk_instansi_btt == INF ? 0 : $show_persen_rk_instansi_btt;
              $show_persen_rk_instansi_bt = $show_persen_rk_instansi_bt == INF ? 0 : $show_persen_rk_instansi_bt;
               @$persen_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $show_persen_rk_instansi_bo;
               @$persen_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $show_persen_rk_instansi_bm;
               @$persen_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $show_persen_rk_instansi_btt;
               @$persen_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $show_persen_rk_instansi_bt;
               @$persen_rk_instansi_total  =  ($nilai_rk_instansi_total / $pagu_total ) * 100; 



               $tampil_nilai_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : number_format($jumlah_realisasi_bo);
               $tampil_nilai_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : number_format($jumlah_realisasi_bm);
               $tampil_nilai_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : number_format($jumlah_realisasi_btt);
               $tampil_nilai_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : number_format($jumlah_realisasi_bt);
                // fisik
               $tampil_nilai_rk_instansi_bo_rf  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $jumlah_realisasi_bo_rf;
               $tampil_nilai_rk_instansi_bm_rf  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $jumlah_realisasi_bm_rf;
               $tampil_nilai_rk_instansi_btt_rf  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $jumlah_realisasi_btt_rf;
               $tampil_nilai_rk_instansi_bt_rf  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $jumlah_realisasi_bt_rf;





               // untuk total
                    $total_pagu_bo += $pagu_bo;
                    $total_pagu_bm += $pagu_bm;
                    $total_pagu_btt += $pagu_btt;
                    $total_pagu_bt += $pagu_bt;
                    $total_pagu_semua += $pagu_total;

                  $total_nilai_realisasi_bo +=$jumlah_realisasi_bo;
                  $total_nilai_realisasi_bm +=$jumlah_realisasi_bm;
                  $total_nilai_realisasi_btt +=$jumlah_realisasi_btt;
                  $total_nilai_realisasi_bt +=$jumlah_realisasi_bt;



                  $total_persen_realisasi_bo_rf += $jumlah_realisasi_bo_rf;
                  $total_persen_realisasi_bm_rf += $jumlah_realisasi_bm_rf;
                  $total_persen_realisasi_btt_rf += $jumlah_realisasi_btt_rf;
                  $total_persen_realisasi_bt_rf += $jumlah_realisasi_bt_rf;

                  @$total_persen_realisasi_bo += $persen_rk_instansi_bo;
                  @$total_persen_realisasi_bm += $persen_rk_instansi_bm;
                  @$total_persen_realisasi_btt += $persen_rk_instansi_btt;
                  @$total_persen_realisasi_bt += $persen_rk_instansi_bt;

                  $total_rf_instansi = $show_nilai_rf_instansi_total >0 ? round($show_nilai_rf_instansi_total,2) : 0 ;
                  $total_rk_instansi = $persen_rk_instansi_total >0 ? round($persen_rk_instansi_total,2) : 0;

                    $total_rf += $realisasi_rf_total;//$total_rf_instansi;
                    $total_nilai_rk += $nilai_rk_instansi_total;
                    $total_persen_rk += $total_rk_instansi;

    ?>
   <tr>
     <td><?php echo $no++ ?></td>
     <td><?php echo $v->nama_instansi ?></td>
     <td class="rata_kanan"><?php echo number_format($pagu_bo); ?></td>
     <td class="rata_kanan"><?php echo number_format($pagu_bm); ?></td>
     <td class="rata_kanan"><?php echo number_format($pagu_btt); ?></td>
     <td class="rata_kanan"><?php echo number_format($pagu_bt); ?></td>
     <td class="rata_kanan"><?php echo number_format($pagu_total); ?></td>
     <td class="rata_kanan"><?php echo $tampil_nilai_rk_instansi_bo; ?></td>
     <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bo']==0 ? '-' :round($persen_rk_instansi_bo,2); ?></td>



     <td class="rata_kanan"><?php echo $tampil_nilai_rk_instansi_bm; ?></td>
     <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bm']==0 ? '-' : round($persen_rk_instansi_bm,2); ?></td>
     <td class="rata_kanan"><?php echo $tampil_nilai_rk_instansi_btt; ?></td>
     <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_btt']==0 ? '-' :round($persen_rk_instansi_btt,2); ?></td>
     <td class="rata_kanan"><?php echo $tampil_nilai_rk_instansi_bt; ?></td>
     <td class="rata_kanan"><?php echo $realisasi_dipilih['realisasikan_bt']==0 ? '-' :round($persen_rk_instansi_bt,2); ?></td>
     <td class="rata_kanan"><?php echo number_format($nilai_rk_instansi_total) ; ?></td>
     <td class="rata_kanan"><?php echo $total_rk_instansi; ?></td>
     <td class="rata_kanan"><?php echo $realisasi_rf_total; ?></td>
    
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

// @$persen_rf_total = $total_fisik_semua /  $pembagi_fisik_total ;
@$persen_rf_total = $total_rf / $total_skpd;///  $pembagi_fisik_total ;
$nilai_rf_kota_ratarata =$total_fisik_semua > 0 ? $persen_rf_total : 0 ;

 ?>
 </tbody>
 <tfoot>
   <tr>
     <td colspan="2">Total</td>
      <td class="rata_kanan"><?php echo number_format($total_pagu_bo); ?></td>
      <td class="rata_kanan"><?php echo number_format($total_pagu_bm); ?></td>
      <td class="rata_kanan"><?php echo number_format($total_pagu_btt); ?></td>
      <td class="rata_kanan"><?php echo number_format($total_pagu_bt); ?></td>
      <td class="rata_kanan"><?php echo number_format($total_pagu_semua); ?></td>
      <td class="rata_kanan"><?php echo number_format($show_total_nilai_realisasi_bo); ?></td>
      <td class="rata_kanan"> <?php echo round($show_ratarata_realisasi_bo,2);?> </td>
      <td class="rata_kanan"><?php echo number_format($show_total_nilai_realisasi_bm); ?></td>
      <td class="rata_kanan"> <?php echo round($show_ratarata_realisasi_bm,2);?> </td>
      <td class="rata_kanan"><?php echo number_format($show_total_nilai_realisasi_btt); ?></td>
      <td class="rata_kanan"> <?php echo round($show_ratarata_realisasi_btt,2);?> </td>
      <td class="rata_kanan"><?php echo number_format($show_total_nilai_realisasi_bt); ?></td>
      <td class="rata_kanan"> <?php echo round($show_ratarata_realisasi_bt,2);?> </td>
      <td class="rata_kanan"> <?php echo number_format($total_nilai_rk) ?> </td>
      <td class="rata_kanan"> <?php echo round($show_ratarata_total_rk,2) ?> </td>
      <td class="rata_kanan"> <?php echo round($persen_rf_total,2) ?> </td>
   </tr>
 </tfoot>






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