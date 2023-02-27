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
    <th rowspan="4"  width="20px">No</th>
    <th rowspan="4" style="width:350px">Program, Kegiatan, Sub Kegiatan</th>
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
    <th rowspan="3">Fisik <br>(%)</th>
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
 <!-- <tbody> -->
   <?php 
  $no_program   = 0;
  $pagu_program   = 0;

  $total_sub_kegiatan = 0;

  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
    <tr style="background: #f0e0fb">
      <td><?php echo $no_program ?></td>
       <td colspan="17" style="font-size:10px;"><div><b><?php echo $value->nama_program ?></b></div></td>
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
       <td colspan="17" style="padding-left:1.5em" ><div class="nama_kegiatan"><b><?php echo $value_kegiatan->nama_kegiatan ?></b></div></td>
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

       



















$pagu_bo = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'pagu_bo')->row_array()['pagu_bo'];
                $pagu_bm = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'pagu_bm')->row_array()['pagu_bm'];
                $pagu_btt = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'pagu_btt')->row_array()['pagu_btt'];
                $pagu_bt = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'pagu_bt')->row_array()['pagu_bt'];


                

                $jumlah_pagu_bo = $pagu_bo =='' ? 0 : $pagu_bo;
                $jumlah_pagu_bm = $pagu_bm =='' ? 0 : $pagu_bm;
                $jumlah_pagu_btt = $pagu_btt =='' ? 0 : $pagu_btt;
                $jumlah_pagu_bt = $pagu_bt =='' ? 0 : $pagu_bt;
                $jumlah_pagu_total = $jumlah_pagu_bo + $jumlah_pagu_bm + $jumlah_pagu_btt + $jumlah_pagu_bt ;










































        $realisasi_dipilih = $keuangan->cek_realisasi_dipilih($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array();

                $realisasi_bo = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];


                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;

                $show_realisasi_bo = $pagu_bo == 0 ?  '-' : number_format($jumlah_realisasi_bo);
                $show_realisasi_bm = $pagu_bm == 0 ?  '-' : number_format($jumlah_realisasi_bm);
                $show_realisasi_btt = $pagu_btt = 0  ? '-' : number_format( $jumlah_realisasi_btt);
                $show_realisasi_bt = $pagu_bt == 0 ?  '-' : number_format($jumlah_realisasi_bt);


               $total_realisasi = $keuangan->total_realisasi($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array()['total_realisasi'] ;

               $persen_rk_bo = $pagu_bo ==0 ? 0 : ($jumlah_realisasi_bo / $pagu_bo) * 100;
               $persen_rk_bm = $pagu_bm ==0 ? 0 : ($jumlah_realisasi_bm / $pagu_bm) * 100;
               $persen_rk_btt = $pagu_btt ==0 ? 0 : ($jumlah_realisasi_btt / $pagu_btt) * 100;
               $persen_rk_bt = $pagu_bt ==0 ? 0 : ($jumlah_realisasi_bt / $pagu_bt) * 100;

               $persen_rk_total = $jumlah_pagu_total ==0 ? 0 : ($total_realisasi / $jumlah_pagu_total) * 100;











        $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
        $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
        $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
        $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();

          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
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
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }
          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
          if ($total_paket != 0) {
            $total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
          } else {
            $total_fisik = 0;
          }

          $total_fisik    = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);


      ?>
      <tr>
      <td><?php echo $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan ?></td>
       <td style="padding-left:3em"><div><?php echo $nama_sub_kegiatan?></div></td>
       <td align="right"><?php echo number_format($jumlah_pagu_bo) ?></td>
       <td align="right"><?php echo number_format($jumlah_pagu_bm) ?></td>
       <td align="right"><?php echo number_format($jumlah_pagu_btt) ?></td>
       <td align="right"><?php echo number_format($jumlah_pagu_bt) ?></td>

       <td align="right"><?php echo number_format($jumlah_pagu_total) ?></td>
     
       <td align="right"><?php echo ($show_realisasi_bo) ?></td>
       <td align="center"><?php echo round($persen_rk_bo,2)  ?></td>
       <td align="right"><?php echo ($show_realisasi_bm) ?></td>
        <td align="center"><?php echo round($persen_rk_bm,2)  ?></td>
       <td align="right"><?php echo ($show_realisasi_btt) ?></td>
        <td align="center"><?php echo round($persen_rk_btt,2)  ?></td>
       <td align="right"><?php echo ($show_realisasi_bt) ?></td>
        <td align="center"><?php echo round($persen_rk_bt,2)  ?></td>
     
       <td align="right"><?php echo number_format($total_realisasi) ?></td>
        <td align="center"><?php echo round($persen_rk_total,2)  ?></td>
       <td align="center"><?php echo $total_fisik ?></td>
       
     </tr>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->


   <tr>
     <td colspan="2" align="right">Total</td>
    
     <td align="right"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
    
   </tr>
   
</table>


</body>