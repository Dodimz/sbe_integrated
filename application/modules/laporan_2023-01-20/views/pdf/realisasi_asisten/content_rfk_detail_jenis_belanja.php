<style>
  .font_laporan{
    font-size:9px;
    font-family: 'calibri';
  }
  .laporan_asisten{
   
    border-collapse: collapse;
    width:100%;
  }
 
.table td, th {
    border: 0.01em solid ;
    padding:3px;

}

  .tabel_header{
    font-weight:bold;
    text-align : center;
    font-size:9px;

  }

  .rata_kanan{
    text-align : right;

  }
  .rata_tengah{
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
</style>

<?php 
  $total_peringatan_dev_fisik_merah = 0;
   $total_peringatan_dev_fisik_kuning = 0;
   $total_peringatan_dev_fisik_hijau = 0;
   $total_peringatan_dev_keu_merah = 0;
   $total_peringatan_dev_keu_kuning = 0;
   $total_peringatan_dev_keu_hijau = 0;



  $total_peringatan_dev_fisik_merah_satu = 0;
   $total_peringatan_dev_fisik_kuning_satu = 0;
   $total_peringatan_dev_fisik_hijau_satu = 0;
   $total_peringatan_dev_keu_merah_satu = 0;
   $total_peringatan_dev_keu_kuning_satu = 0;
   $total_peringatan_dev_keu_hijau_satu = 0;



  $total_peringatan_dev_fisik_merah_dua = 0;
   $total_peringatan_dev_fisik_kuning_dua = 0;
   $total_peringatan_dev_fisik_hijau_dua = 0;
   $total_peringatan_dev_keu_merah_dua = 0;
   $total_peringatan_dev_keu_kuning_dua = 0;
   $total_peringatan_dev_keu_hijau_dua = 0;



  $total_peringatan_dev_fisik_merah_tiga = 0;
   $total_peringatan_dev_fisik_kuning_tiga = 0;
   $total_peringatan_dev_fisik_hijau_tiga = 0;
   $total_peringatan_dev_keu_merah_tiga = 0;
   $total_peringatan_dev_keu_kuning_tiga = 0;
   $total_peringatan_dev_keu_hijau_tiga = 0;

   $total_data_skpd = 0;
   $total_data_skpd_satu = 0;
   $total_data_skpd_dua = 0;
   $total_data_skpd_tiga = 0;
    ?>
<div class="judul_laporan" style="margin-bottom:15px"><?php echo $judul_laporan ?></div> 







<div >

      <?php
          $tertimbang_satu       = 0;
          $total_t_fisik_satu    = 0;
          $total_t_keu_satu      = 0;
          $total_r_fisik_satu    = 0;
          $total_r_keu_satu      = 0;
          $total_tertimbang_satu = 0;
          $jml_skpd_satu         = 0;

          $total_pagu =0;
          $total_rp_t_keu = 0;  
          $total_rp_r_keu = 0;

          $total_pagu_satu =0;
          $total_rp_t_keu_satu = 0;  
          $total_rp_r_keu_satu = 0;
          $no = 0;
       foreach ($asisten_1 as $satu) { 
          $no++;
        $total_pagu_satu +=$satu->pagu_total;
        $total_rp_t_keu_satu +=$satu->rp_target_keuangan;
        $total_rp_r_keu_satu +=$satu->rp_realisasi_keuangan;


        $total_pagu +=$satu->pagu_total;
        $total_rp_t_keu +=$satu->rp_target_keuangan;
        $total_rp_r_keu +=$satu->rp_realisasi_keuangan;

        $total_data_skpd +=1;
        $total_data_skpd_satu +=1;


        $dev_fisik = round($satu->realisasi_fisik -$satu->target_fisik ,2);
          $dev_keu = round($satu->realisasi_keuangan - $satu->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_satu += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_satu += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_satu += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_satu += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_satu += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_satu += 1; 
            }


            $total_t_fisik_satu    += $satu->target_fisik;
            $total_t_keu_satu      += $satu->target_keuangan;
            $total_r_fisik_satu    += $satu->realisasi_fisik;
            $total_r_keu_satu      += $satu->realisasi_keuangan;
            $jml_skpd_satu++;
        


            $show_tf = $satu->target_fisik;
            $show_tk = $satu->target_keuangan;
            $show_rf = $satu->realisasi_fisik == '' ? 0 : $satu->realisasi_fisik;
            $show_rk = $satu->realisasi_keuangan == '' ? 0 :  $satu->realisasi_keuangan;


            $pisah_decimal_show_tf = explode('.', $satu->target_fisik);
            $pisah_decimal_show_tk = explode('.', $satu->target_keuangan);
            $pisah_decimal_show_rf = explode('.', $show_rf);
            $pisah_decimal_show_rk = explode('.', $show_rk);
            $pisah_decimal_dev_fisik = explode('.', $dev_fisik);
            $pisah_decimal_dev_keu = explode('.', $dev_keu);

            $digit_show_tf = count($pisah_decimal_show_tk);
            $digit_show_tk = count($pisah_decimal_show_tf);
            $digit_show_rf = count($pisah_decimal_show_rf);
            $digit_show_rk = count($pisah_decimal_show_rk);
            $digit_dev_fisik = count($pisah_decimal_dev_fisik);
            $digit_dev_keu = count($pisah_decimal_dev_keu);

            // Fisik
            if ($digit_show_tf>1) {
              $didepan_koma_tf = $pisah_decimal_show_tf[0] ; 
              $dibelakang_koma_tf = strlen($pisah_decimal_show_tf[1]) >1 ? $pisah_decimal_show_tf[1] : $pisah_decimal_show_tf[1].'0';
              $hasil_tf = $didepan_koma_tf.'.'.$dibelakang_koma_tf;
            }else{
              $hasil_tf = $show_tf.'.00';
            }

            if ($digit_show_rf>1) {
              $didepan_koma_rf = $pisah_decimal_show_rf[0] ; 
              $dibelakang_koma_rf = strlen($pisah_decimal_show_rf[1]) >1 ? $pisah_decimal_show_rf[1] : $pisah_decimal_show_rf[1].'0';
              $hasil_rf = $didepan_koma_rf.'.'.$dibelakang_koma_rf;
            }else{
              $hasil_rf = $show_rf.'.00';
            }

            if ($digit_dev_fisik>1) {
              $didepan_koma_dev_fisik = $pisah_decimal_dev_fisik[0] ; 
              $dibelakang_koma_dev_fisik = strlen($pisah_decimal_dev_fisik[1]) >1 ? $pisah_decimal_dev_fisik[1] : $pisah_decimal_dev_fisik[1].'0';
              $hasil_dev_fisik = $didepan_koma_dev_fisik.'.'.$dibelakang_koma_dev_fisik;
            }else{
              $hasil_dev_fisik = $dev_fisik.'.00';
            }

            // keuangan
            if ($digit_show_tk>1) {
              $didepan_koma_tk = $pisah_decimal_show_tk[0] ; 
              $dibelakang_koma_tk = strlen($pisah_decimal_show_tk[1]) >1 ? $pisah_decimal_show_tk[1] : $pisah_decimal_show_tk[1].'0';
              $hasil_tk = $didepan_koma_tk.'.'.$dibelakang_koma_tk;
            }else{
              $hasil_tk = $show_tk.'.00';
            }

            if ($digit_show_rk>1) {
              $didepan_koma_rk = $pisah_decimal_show_rk[0] ; 
              $dibelakang_koma_rk = strlen($pisah_decimal_show_rk[1]) >1 ? $pisah_decimal_show_rk[1] : $pisah_decimal_show_rk[1].'0';
              $hasil_rk = $didepan_koma_rk.'.'.$dibelakang_koma_rk;
            }else{
              $hasil_rk = $show_rk.'.00';
            }

            if ($digit_dev_keu>1) {
              $didepan_koma_dev_keu = $pisah_decimal_dev_keu[0] ; 
              $dibelakang_koma_dev_keu = strlen($pisah_decimal_dev_keu[1]) >1 ? $pisah_decimal_dev_keu[1] : $pisah_decimal_dev_keu[1].'0';
              $hasil_dev_keu = $didepan_koma_dev_keu.'.'.$dibelakang_koma_dev_keu;
            }else{
              $hasil_dev_keu = $dev_keu.'.00';
            }


             if ($hasil_tf<$hasil_tk) {
              $blok = 'style="background: #fef2ff  "';
            }else{
              $blok = '';

            }
        ?>
       












<table class="table font_laporan laporan_asisten" width="100%"  >
  <tr>
    <td colspan="5"><b><?php echo $no.'. '. $satu->nama_instansi ?></b></td>
  </tr>
  <tr>
    <th colspan="2">Pagu</th>
    <th colspan="2">Realisasi</th>
    <th >Pencapaian</th>
  </tr>
  <tr >



    <?php 
    $pagu_belanja_operasi = $satu->pagu_bo_bp + $satu->pagu_bo_bbj + $satu->pagu_bo_bs + $satu->pagu_bo_bh; 
    $realisasi_belanja_operasi = $satu->rp_realisasi_keuangan_akumulasi_bo_bp + $satu->rp_realisasi_keuangan_akumulasi_bo_bbj + $satu->rp_realisasi_keuangan_akumulasi_bo_bs + $satu->rp_realisasi_keuangan_akumulasi_bo_bh; 
     ?>




    <td  style="background: aqua">Belanja Operasi</td>
    <td  style="background: aqua; text-align: right"> <?php  echo number_format($pagu_belanja_operasi) ?> </td>
    <td  style="background: aqua">Belanja Operasi</td>
    <td  style="background: aqua; text-align: right">  <?php echo number_format($realisasi_belanja_operasi) ?>  </td>
    <td rowspan="17" valign="top"> 
      <b> Fisik</b>


      <table class="table font_laporan laporan_asisten"  style="margin-top:4px">
        <tr>
          <td>Target</td>
          <td><?php echo $hasil_tf ?></td>
        </tr>
        <tr>
          <td>Realisasi</td>
          <td><?php echo $hasil_rf ?></td>
        </tr>
        <tr>
          <td>Deviasi</td>
          <td style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo $hasil_dev_fisik ?></td>
        </tr>
      </table>

        <br>  <br>  
      <b> Keuangan</b>
      <table class="table font_laporan laporan_asisten"  style="margin-top:4px">
        <tr>
          <td>Target</td>
          <td><?php echo $hasil_tk ?></td>
        </tr>
        <tr>
          <td>Realisasi</td>
          <td><?php echo $hasil_rk ?></td>
        </tr>
        <tr>
          <td>Deviasi</td>
          <td style="<?php echo $warna_peringatan_dev_keu ?>"><?php echo $hasil_dev_keu ?></td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td> Belanja Pegawai </td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bp) ?> </td>
    <td> Belanja Pegawai </td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bp) ?> </td>
  </tr>
  <tr>
    <td>Belanja Barang Jasa</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bbj) ?></td>
    <td>Belanja Barang Jasa</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bbj) ?></td>
  </tr>
  <tr>
    <td> Belanja Subsidi </td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bs) ?></td>
    <td> Belanja Subsidi </td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bs) ?></td>
  </tr>
  <tr>
    <td>Belanja Hibah</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bh) ?></td>
    <td>Belanja Hibah</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bh) ?></td>
  </tr>
  <tr style="background: aqua">
    <td>Belanja Modal</td>
   
    <td style="text-align: right"> <?php 
    $pagu_belanja_modal = $satu->pagu_bm_bmt + $satu->pagu_bm_bmpm + $satu->pagu_bm_bmgb + $satu->pagu_bm_bmjji + $satu->pagu_bm_bmatl  ; 
    $realisasi_belanja_modal = $satu->rp_realisasi_keuangan_akumulasi_bm_bmt + $satu->rp_realisasi_keuangan_akumulasi_bm_bmpm + $satu->rp_realisasi_keuangan_akumulasi_bm_bmgb + $satu->rp_realisasi_keuangan_akumulasi_bm_bmjji + $satu->rp_realisasi_keuangan_akumulasi_bm_bmatl  ; 
    echo number_format($pagu_belanja_modal) ?> </td>

    <td>Belanja Modal</td>
    <td style="text-align: right"> <?php echo number_format($realisasi_belanja_modal) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Tanah</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmt) ?> </td>
    <td>Belanja Modal Tanah</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmt) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Peralatan Dan Mesin</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmpm) ?> </td>
    <td>Belanja Modal Peralatan Dan Mesin</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmpm) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Gedung dan Bangunan</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bm_bmgb) ?> </td>
    <td>Belanja Modal Gedung dan Bangunan</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmgb) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Jalan, Jaringan, dan Irigasi</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmjji) ?> </td>
    <td>Belanja Modal Jalan, Jaringan, dan Irigasi</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmjji) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal dan Aset Tetap Lainnya</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmatl) ?> </td>
    <td>Belanja Modal dan Aset Tetap Lainnya</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmatl) ?> </td>
  </tr>
 <tr style="background: aqua">
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_btt) ?> </td>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_btt) ?> </td>
  </tr>
  <tr>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_btt) ?> </td>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_btt) ?> </td>
  </tr>
  <tr style="background: aqua">
    <td>Belanja Transfer</td>
    <td style="text-align: right"> <?php 
    $pagu_belanja_transfer = $satu->pagu_bt_bbh + $satu->pagu_bt_bb; 
    $realisasi_belanja_transfer = $satu->rp_realisasi_keuangan_akumulasi_bt_bbh + $satu->rp_realisasi_keuangan_akumulasi_bt_bb; 
    echo number_format($pagu_belanja_transfer) ?> </td>
    <td>Belanja Transfer</td>
    <td style="text-align: right"> <?php echo number_format($realisasi_belanja_transfer) ?> </td>
  </tr>
  <tr>
    <td>Belanja Bagi Hasil</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bt_bbh) ?> </td>
    <td>Belanja Bagi Hasil</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bt_bbh) ?> </td>
  </tr>
  <tr>
    <td>Belanja Bantuan Keuangan</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bt_bbk) ?> </td>
    <td>Belanja Bantuan Keuangan</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bt_bbk) ?> </td>
  </tr>
  <tr>
    <td>Total</td>
    <td style="text-align: right"> <?php echo  number_format($satu->pagu_total) ?>   </td>
    <td>Total</td>
    <td style="text-align: right"> <?php echo  number_format($satu->rp_realisasi_keuangan_akumulasi) ?>   </td>
  </tr>
</table>
 
 <hr> 









       <?php } 

       foreach ($asisten_1_belum_terekap as $satu) { 
          $no++;
        $total_data_skpd +=1;
        $total_data_skpd_satu +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;
        $total_peringatan_dev_fisik_hijau_satu+=1;
        $total_peringatan_dev_keu_hijau_satu+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_satu++;
        




           
        ?>
         <table class="table font_laporan laporan_asisten" width="100%"  >
  <tr style="background: #dbe7fc ">
    <td colspan="5"><b><?php echo $no.'. '. $satu->nama_instansi ?></b></td>
  </tr>
  <tr>
    <th colspan="2">Pagu</th>
    <th colspan="2">Realisasi</th>
    <th >Pencapaian</th>
  </tr>
  <tr >



    <?php 
    $pagu_belanja_operasi = $satu->pagu_bo_bp + $satu->pagu_bo_bbj + $satu->pagu_bo_bs + $satu->pagu_bo_bh; 
    $realisasi_belanja_operasi = $satu->rp_realisasi_keuangan_akumulasi_bo_bp + $satu->rp_realisasi_keuangan_akumulasi_bo_bbj + $satu->rp_realisasi_keuangan_akumulasi_bo_bs + $satu->rp_realisasi_keuangan_akumulasi_bo_bh; 
     ?>




    <td  style="background: aqua">Belanja Operasi</td>
    <td  style="background: aqua; text-align: right"> <?php  echo number_format($pagu_belanja_operasi) ?> </td>
    <td  style="background: aqua">Belanja Operasi</td>
    <td  style="background: aqua; text-align: right">  <?php echo number_format($realisasi_belanja_operasi) ?>  </td>
    <td rowspan="17" valign="top"> 
      <b> Fisik</b>


      <table class="table font_laporan laporan_asisten"  style="margin-top:4px">
        <tr>
          <td>Target</td>
          <td><?php echo $hasil_tf ?></td>
        </tr>
        <tr>
          <td>Realisasi</td>
          <td><?php echo $hasil_rf ?></td>
        </tr>
        <tr>
          <td>Deviasi</td>
          <td style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo $hasil_dev_fisik ?></td>
        </tr>
      </table>

        <br>  <br>  
      <b> Keuangan</b>
      <table class="table font_laporan laporan_asisten"  style="margin-top:4px">
        <tr>
          <td>Target</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>Realisasi</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>Deviasi</td>
          <td style="<?php echo $warna_peringatan_dev_keu ?>">0.00</td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td> Belanja Pegawai </td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bp) ?> </td>
    <td> Belanja Pegawai </td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bp) ?> </td>
  </tr>
  <tr>
    <td>Belanja Barang Jasa</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bbj) ?></td>
    <td>Belanja Barang Jasa</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bbj) ?></td>
  </tr>
  <tr>
    <td> Belanja Subsidi </td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bs) ?></td>
    <td> Belanja Subsidi </td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bs) ?></td>
  </tr>
  <tr>
    <td>Belanja Hibah</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bo_bh) ?></td>
    <td>Belanja Hibah</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bo_bh) ?></td>
  </tr>
  <tr style="background: aqua">
    <td>Belanja Modal</td>
   
    <td style="text-align: right"> <?php 
    $pagu_belanja_modal = $satu->pagu_bm_bmt + $satu->pagu_bm_bmpm + $satu->pagu_bm_bmgb + $satu->pagu_bm_bmjji + $satu->pagu_bm_bmatl  ; 
    $realisasi_belanja_modal = $satu->rp_realisasi_keuangan_akumulasi_bm_bmt + $satu->rp_realisasi_keuangan_akumulasi_bm_bmpm + $satu->rp_realisasi_keuangan_akumulasi_bm_bmgb + $satu->rp_realisasi_keuangan_akumulasi_bm_bmjji + $satu->rp_realisasi_keuangan_akumulasi_bm_bmatl  ; 
    echo number_format($pagu_belanja_modal) ?> </td>

    <td>Belanja Modal</td>
    <td style="text-align: right"> <?php echo number_format($realisasi_belanja_modal) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Tanah</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmt) ?> </td>
    <td>Belanja Modal Tanah</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmt) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Peralatan Dan Mesin</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmpm) ?> </td>
    <td>Belanja Modal Peralatan Dan Mesin</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmpm) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Gedung dan Bangunan</td>
    <td style="text-align: right"><?php echo number_format($satu->pagu_bm_bmgb) ?> </td>
    <td>Belanja Modal Gedung dan Bangunan</td>
    <td style="text-align: right"><?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmgb) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal Jalan, Jaringan, dan Irigasi</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmjji) ?> </td>
    <td>Belanja Modal Jalan, Jaringan, dan Irigasi</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmjji) ?> </td>
  </tr>
  <tr>
    <td>Belanja Modal dan Aset Tetap Lainnya</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bm_bmatl) ?> </td>
    <td>Belanja Modal dan Aset Tetap Lainnya</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bm_bmatl) ?> </td>
  </tr>
 <tr style="background: aqua">
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_btt) ?> </td>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_btt) ?> </td>
  </tr>
  <tr>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_btt) ?> </td>
    <td>Belanja Tidak Terduga</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_btt) ?> </td>
  </tr>
  <tr style="background: aqua">
    <td>Belanja Transfer</td>
    <td style="text-align: right"> <?php 
    $pagu_belanja_transfer = $satu->pagu_bt_bbh + $satu->pagu_bt_bb; 
    $realisasi_belanja_transfer = $satu->rp_realisasi_keuangan_akumulasi_bt_bbh + $satu->rp_realisasi_keuangan_akumulasi_bt_bb; 
    echo number_format($pagu_belanja_transfer) ?> </td>
    <td>Belanja Transfer</td>
    <td style="text-align: right"> <?php echo number_format($realisasi_belanja_transfer) ?> </td>
  </tr>
  <tr>
    <td>Belanja Bagi Hasil</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bt_bbh) ?> </td>
    <td>Belanja Bagi Hasil</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bt_bbh) ?> </td>
  </tr>
  <tr>
    <td>Belanja Bantuan Keuangan</td>
    <td style="text-align: right"> <?php echo number_format($satu->pagu_bt_bbk) ?> </td>
    <td>Belanja Bantuan Keuangan</td>
    <td style="text-align: right"> <?php echo number_format($satu->rp_realisasi_keuangan_akumulasi_bt_bbk) ?> </td>
  </tr>
  <tr>
    <td>Total</td>
    <td style="text-align: right"> <?php echo  number_format($satu->pagu_total) ?>   </td>
    <td>Total</td>
    <td style="text-align: right"> <?php echo  number_format($satu->rp_realisasi_keuangan_akumulasi) ?>   </td>
  </tr>
</table>
    
<hr>  
       <?php } //akhir foreach  ($asisten_1_belum_terekap as $satu) {

          @$ratarata_t_fisik_satu    =  round($total_t_fisik_satu / $jml_skpd_satu, 2); 
          @$ratarata_r_fisik_satu   =  round($total_r_fisik_satu / $jml_skpd_satu, 2); 
          @$total_dev_fisik_satu = $ratarata_r_fisik_satu - $ratarata_t_fisik_satu ;


          @$ratarata_t_keu_satu   = round((($total_rp_t_keu_satu / $total_pagu_satu) * 100),2) ;// round($total_t_keu_satu / $jml_skpd_satu, 2); 
          @$ratarata_r_keu_satu   =  round((($total_rp_r_keu_satu / $total_pagu_satu) * 100),2) ;//round($total_r_keu_satu / $jml_skpd_satu, 2);
          @$total_dev_keu_satu = $ratarata_r_keu_satu - $ratarata_t_keu_satu ;



            if ($total_dev_fisik_satu < -10) {
              $warna_peringatan_total_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_fisik_satu <-5  && $total_dev_fisik_satu >-10) {
              $warna_peringatan_total_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_fisik = 'background: #d5f5e3';
            }

            if ($total_dev_keu_satu < -10) {
              $warna_peringatan_total_dev_keu = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_keu_satu <-5  && $total_dev_keu_satu >-10) {
              $warna_peringatan_total_dev_keu = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_keu = 'background: #d5f5e3';
            }



            $show_total_tf = $ratarata_t_fisik_satu;
            $show_total_rf = $ratarata_r_fisik_satu;
            $show_total_tk = $ratarata_t_keu_satu;
            $show_total_rk = $ratarata_r_keu_satu;


            $pisah_decimal_show_total_tf = explode('.', $show_total_tf);
            $pisah_decimal_show_total_tk = explode('.', $show_total_tk);
            $pisah_decimal_show_total_rf = explode('.', $show_total_rf);
            $pisah_decimal_show_total_rk = explode('.', $show_total_rk);

            $pisah_decimal_total_dev_fisik = explode('.', $total_dev_fisik_satu);
            $pisah_decimal_total_dev_keu = explode('.', $total_dev_keu_satu);

            $digit_show_total_tf = count($pisah_decimal_show_total_tf);
            $digit_show_total_tk = count($pisah_decimal_show_total_tk);
            $digit_show_total_rf = count($pisah_decimal_show_total_rf);
            $digit_show_total_rk = count($pisah_decimal_show_total_rk);

            $digit_total_dev_fisik = count($pisah_decimal_total_dev_fisik);
            $digit_total_dev_keu = count($pisah_decimal_total_dev_keu);



            if ($digit_show_total_tf>1) {
              $didepan_koma_total_tf = $pisah_decimal_show_total_tf[0] ; 
              $dibelakang_koma_total_tf = strlen($pisah_decimal_show_total_tf[1]) >1 ? $pisah_decimal_show_total_tf[1] : $pisah_decimal_show_total_tf[1].'0';
              $hasil_total_tf = $didepan_koma_total_tf.'.'.$dibelakang_koma_total_tf;
            }else{
              $hasil_total_tf = $show_total_tf.'.00';
            }

            if ($digit_show_total_rf>1) {
              $didepan_koma_total_rf = $pisah_decimal_show_total_rf[0] ; 
              $dibelakang_koma_total_rf = strlen($pisah_decimal_show_total_rf[1]) >1 ? $pisah_decimal_show_total_rf[1] : $pisah_decimal_show_total_rf[1].'0';
              $hasil_total_rf = $didepan_koma_total_rf.'.'.$dibelakang_koma_total_rf;
            }else{
              $hasil_total_rf = $show_total_rf.'.00';
            }

            if ($digit_total_dev_fisik>1) {
              $didepan_koma_total_dev_fisik = $pisah_decimal_total_dev_fisik[0] ; 
              $dibelakang_koma_total_dev_fisik = strlen($pisah_decimal_total_dev_fisik[1]) >1 ? $pisah_decimal_total_dev_fisik[1] : $pisah_decimal_total_dev_fisik[1].'0';
              $hasil_total_dev_fisik = $didepan_koma_total_dev_fisik.'.'.$dibelakang_koma_total_dev_fisik;
            }else{
              $hasil_total_dev_fisik = $total_dev_fisik_satu.'.00';
            }


            if ($digit_show_total_tk>1) {
              $didepan_koma_total_tk = $pisah_decimal_show_total_tk[0] ; 
              $dibelakang_koma_total_tk = strlen($pisah_decimal_show_total_tk[1]) >1 ? $pisah_decimal_show_total_tk[1] : $pisah_decimal_show_total_tk[1].'0';
              $hasil_total_tk = $didepan_koma_total_tk.'.'.$dibelakang_koma_total_tk;
            }else{
              $hasil_total_tk = $show_total_tk.'.00';
            }

            if ($digit_show_total_rk>1) {
              $didepan_koma_total_rk = $pisah_decimal_show_total_rk[0] ; 
              $dibelakang_koma_total_rk = strlen($pisah_decimal_show_total_rk[1]) >1 ? $pisah_decimal_show_total_rk[1] : $pisah_decimal_show_total_rk[1].'0';
              $hasil_total_rk = $didepan_koma_total_rk.'.'.$dibelakang_koma_total_rk;
            }else{
              $hasil_total_rk = $show_total_rk.'.00';
            }

            if ($digit_total_dev_keu>1) {
              $didepan_koma_total_dev_keu = $pisah_decimal_total_dev_keu[0] ; 
              $dibelakang_koma_total_dev_keu = strlen($pisah_decimal_total_dev_keu[1]) >1 ? $pisah_decimal_total_dev_keu[1] : $pisah_decimal_total_dev_keu[1].'0';
              $hasil_total_dev_keu = $didepan_koma_total_dev_keu.'.'.$dibelakang_koma_total_dev_keu;
            }else{
              $hasil_total_dev_keu = $total_dev_keu_satu.'.00';
            }






          ?>
   
</div>

<div style="width:33.33%; float:left">
  <table class="font_laporan laporan_asisten table">
    <thead class="tabel_header">      
      <tr class="tabel_header">
        <th rowspan="2">ASISTEN PEREKONOMIAN DAN PEMBANGUNAN</th>
        <th colspan="3">Fisik</th>
        <th colspan="3">Keuangan</th>
      </tr>
      <tr>
        <th style="width:33px">T</th>
        <th style="width:33px">R</th>
        <th style="width:33px">D</th>
        <th style="width:33px">T</th>
        <th style="width:33px">R</th>
        <th style="width:33px">D</th>
      </tr>
    </thead>
    <tbody >
      <?php
          $tertimbang_dua       = 0;
          $total_t_fisik_dua    = 0;
          $total_t_keu_dua      = 0;
          $total_r_fisik_dua    = 0;
          $total_r_keu_dua      = 0;
          $total_tertimbang_dua = 0;
          $jml_skpd_dua         = 0;



          $total_pagu_dua =0;
          $total_rp_t_keu_dua = 0;  
          $total_rp_r_keu_dua = 0;
       foreach ($asisten_2 as $dua) { 

        $total_data_skpd +=1;
        $total_data_skpd_dua +=1;


        $total_pagu +=$dua->pagu_total;
        $total_rp_t_keu +=$dua->rp_target_keuangan;
        $total_rp_r_keu +=$dua->rp_realisasi_keuangan;

        $total_pagu_dua +=$dua->pagu_total;
        $total_rp_t_keu_dua +=$dua->rp_target_keuangan;
        $total_rp_r_keu_dua +=$dua->rp_realisasi_keuangan;


        $dev_fisik = round($dua->realisasi_fisik -$dua->target_fisik ,2);
          $dev_keu = round($dua->realisasi_keuangan - $dua->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_dua += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_dua += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_dua += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_dua += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_dua += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_dua += 1; 
            }


            $total_t_fisik_dua    += $dua->target_fisik;
            $total_t_keu_dua      += $dua->target_keuangan;
            $total_r_fisik_dua    += $dua->realisasi_fisik;
            $total_r_keu_dua      += $dua->realisasi_keuangan;
            $jml_skpd_dua++;
        


            $show_tf = $dua->target_fisik;
            $show_tk = $dua->target_keuangan;
            $show_rf = $dua->realisasi_fisik == '' ? 0 : $dua->realisasi_fisik;
            $show_rk = $dua->realisasi_keuangan == '' ? 0 :  $dua->realisasi_keuangan;


            $pisah_decimal_show_tf = explode('.', $dua->target_fisik);
            $pisah_decimal_show_tk = explode('.', $dua->target_keuangan);
            $pisah_decimal_show_rf = explode('.', $show_rf);
            $pisah_decimal_show_rk = explode('.', $show_rk);
            $pisah_decimal_dev_fisik = explode('.', $dev_fisik);
            $pisah_decimal_dev_keu = explode('.', $dev_keu);

            $digit_show_tf = count($pisah_decimal_show_tk);
            $digit_show_tk = count($pisah_decimal_show_tf);
            $digit_show_rf = count($pisah_decimal_show_rf);
            $digit_show_rk = count($pisah_decimal_show_rk);
            $digit_dev_fisik = count($pisah_decimal_dev_fisik);
            $digit_dev_keu = count($pisah_decimal_dev_keu);

            // Fisik
            if ($digit_show_tf>1) {
              $didepan_koma_tf = $pisah_decimal_show_tf[0] ; 
              $dibelakang_koma_tf = strlen($pisah_decimal_show_tf[1]) >1 ? $pisah_decimal_show_tf[1] : $pisah_decimal_show_tf[1].'0';
              $hasil_tf = $didepan_koma_tf.'.'.$dibelakang_koma_tf;
            }else{
              $hasil_tf = $show_tf.'.00';
            }

            if ($digit_show_rf>1) {
              $didepan_koma_rf = $pisah_decimal_show_rf[0] ; 
              $dibelakang_koma_rf = strlen($pisah_decimal_show_rf[1]) >1 ? $pisah_decimal_show_rf[1] : $pisah_decimal_show_rf[1].'0';
              $hasil_rf = $didepan_koma_rf.'.'.$dibelakang_koma_rf;
            }else{
              $hasil_rf = $show_rf.'.00';
            }

            if ($digit_dev_fisik>1) {
              $didepan_koma_dev_fisik = $pisah_decimal_dev_fisik[0] ; 
              $dibelakang_koma_dev_fisik = strlen($pisah_decimal_dev_fisik[1]) >1 ? $pisah_decimal_dev_fisik[1] : $pisah_decimal_dev_fisik[1].'0';
              $hasil_dev_fisik = $didepan_koma_dev_fisik.'.'.$dibelakang_koma_dev_fisik;
            }else{
              $hasil_dev_fisik = $dev_fisik.'.00';
            }

            // keuangan
            if ($digit_show_tk>1) {
              $didepan_koma_tk = $pisah_decimal_show_tk[0] ; 
              $dibelakang_koma_tk = strlen($pisah_decimal_show_tk[1]) >1 ? $pisah_decimal_show_tk[1] : $pisah_decimal_show_tk[1].'0';
              $hasil_tk = $didepan_koma_tk.'.'.$dibelakang_koma_tk;
            }else{
              $hasil_tk = $show_tk.'.00';
            }

            if ($digit_show_rk>1) {
              $didepan_koma_rk = $pisah_decimal_show_rk[0] ; 
              $dibelakang_koma_rk = strlen($pisah_decimal_show_rk[1]) >1 ? $pisah_decimal_show_rk[1] : $pisah_decimal_show_rk[1].'0';
              $hasil_rk = $didepan_koma_rk.'.'.$dibelakang_koma_rk;
            }else{
              $hasil_rk = $show_rk.'.00';
            }

            if ($digit_dev_keu>1) {
              $didepan_koma_dev_keu = $pisah_decimal_dev_keu[0] ; 
              $dibelakang_koma_dev_keu = strlen($pisah_decimal_dev_keu[1]) >1 ? $pisah_decimal_dev_keu[1] : $pisah_decimal_dev_keu[1].'0';
              $hasil_dev_keu = $didepan_koma_dev_keu.'.'.$dibelakang_koma_dev_keu;
            }else{
              $hasil_dev_keu = $dev_keu.'.00';
            }

          if ($hasil_tf<$hasil_tk) {
              $blok = 'style="background: #fef2ff  "';
            }else{
              $blok = '';

            }
        ?>
         <tr <?php echo $blok ?>>
          <td><?php echo $dua->nama_instansi ?></td>
          <td class="rata_tengah"><?php echo $hasil_tf ?></td>
          <td class="rata_tengah"><?php echo $hasil_rf ?></td>
          <td class="rata_tengah" style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo $hasil_dev_fisik ?></td>
          <td class="rata_tengah"><?php echo $hasil_tk ?></td>
          <td class="rata_tengah"><?php echo $hasil_rk ?></td>
          <td class="rata_tengah" style="<?php echo $warna_peringatan_dev_keu ?>"><?php echo $hasil_dev_keu?></td>
        
        </tr>


       <?php } //akhir foreach  ($asisten_2 as $dua) {



       foreach ($asisten_2_belum_terekap as $dua) { 

        $total_data_skpd +=1;
        $total_data_skpd_dua +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;

        $total_peringatan_dev_fisik_hijau_dua+=1;
        $total_peringatan_dev_keu_hijau_dua+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_dua++;
        




           
        ?>
          <tr style="background: #dbe7fc ">
          <td><?php echo $dua->nama_instansi ?></td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
        
        </tr>


       <?php } //akhir foreach  ($asisten_1_belum_terekap as $satu) {
          @$ratarata_t_fisik_dua    =  round($total_t_fisik_dua / $jml_skpd_dua, 2); 
          @$ratarata_r_fisik_dua   =  round($total_r_fisik_dua / $jml_skpd_dua, 2); 
          @$total_dev_fisik_dua = $ratarata_r_fisik_dua - $ratarata_t_fisik_dua ;
          @$ratarata_t_keu_dua   =  round((($total_rp_t_keu_dua / $total_pagu_dua) * 100),2);//round($total_t_keu_dua / $jml_skpd_dua, 2); 
          @$ratarata_r_keu_dua   =  round((($total_rp_r_keu_dua / $total_pagu_dua) * 100),2);// round($total_r_keu_dua / $jml_skpd_dua, 2);
          @$total_dev_keu_dua = $ratarata_r_keu_dua - $ratarata_t_keu_dua ;



            if ($total_dev_fisik_dua < -10) {
              $warna_peringatan_total_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_fisik_dua <-5  && $total_dev_fisik_dua >-10) {
              $warna_peringatan_total_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_fisik = 'background: #d5f5e3';
            }

            if ($total_dev_keu_dua < -10) {
              $warna_peringatan_total_dev_keu = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_keu_dua <-5  && $total_dev_keu_dua >-10) {
              $warna_peringatan_total_dev_keu = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_keu = 'background: #d5f5e3';
            }



            $show_total_tf = $ratarata_t_fisik_dua;
            $show_total_rf = $ratarata_r_fisik_dua;
            $show_total_tk = $ratarata_t_keu_dua;
            $show_total_rk = $ratarata_r_keu_dua;


            $pisah_decimal_show_total_tf = explode('.', $show_total_tf);
            $pisah_decimal_show_total_tk = explode('.', $show_total_tk);
            $pisah_decimal_show_total_rf = explode('.', $show_total_rf);
            $pisah_decimal_show_total_rk = explode('.', $show_total_rk);

            $pisah_decimal_total_dev_fisik = explode('.', $total_dev_fisik_dua);
            $pisah_decimal_total_dev_keu = explode('.', $total_dev_keu_dua);

            $digit_show_total_tf = count($pisah_decimal_show_total_tf);
            $digit_show_total_tk = count($pisah_decimal_show_total_tk);
            $digit_show_total_rf = count($pisah_decimal_show_total_rf);
            $digit_show_total_rk = count($pisah_decimal_show_total_rk);

            $digit_total_dev_fisik = count($pisah_decimal_total_dev_fisik);
            $digit_total_dev_keu = count($pisah_decimal_total_dev_keu);



            if ($digit_show_total_tf>1) {
              $didepan_koma_total_tf = $pisah_decimal_show_total_tf[0] ; 
              $dibelakang_koma_total_tf = strlen($pisah_decimal_show_total_tf[1]) >1 ? $pisah_decimal_show_total_tf[1] : $pisah_decimal_show_total_tf[1].'0';
              $hasil_total_tf = $didepan_koma_total_tf.'.'.$dibelakang_koma_total_tf;
            }else{
              $hasil_total_tf = $show_total_tf.'.00';
            }

            if ($digit_show_total_rf>1) {
              $didepan_koma_total_rf = $pisah_decimal_show_total_rf[0] ; 
              $dibelakang_koma_total_rf = strlen($pisah_decimal_show_total_rf[1]) >1 ? $pisah_decimal_show_total_rf[1] : $pisah_decimal_show_total_rf[1].'0';
              $hasil_total_rf = $didepan_koma_total_rf.'.'.$dibelakang_koma_total_rf;
            }else{
              $hasil_total_rf = $show_total_rf.'.00';
            }

            if ($digit_total_dev_fisik>1) {
              $didepan_koma_total_dev_fisik = $pisah_decimal_total_dev_fisik[0] ; 
              $dibelakang_koma_total_dev_fisik = strlen($pisah_decimal_total_dev_fisik[1]) >1 ? $pisah_decimal_total_dev_fisik[1] : $pisah_decimal_total_dev_fisik[1].'0';
              $hasil_total_dev_fisik = $didepan_koma_total_dev_fisik.'.'.$dibelakang_koma_total_dev_fisik;
            }else{
              $hasil_total_dev_fisik = $total_dev_fisik_dua.'.00';
            }


            if ($digit_show_total_tk>1) {
              $didepan_koma_total_tk = $pisah_decimal_show_total_tk[0] ; 
              $dibelakang_koma_total_tk = strlen($pisah_decimal_show_total_tk[1]) >1 ? $pisah_decimal_show_total_tk[1] : $pisah_decimal_show_total_tk[1].'0';
              $hasil_total_tk = $didepan_koma_total_tk.'.'.$dibelakang_koma_total_tk;
            }else{
              $hasil_total_tk = $show_total_tk.'.00';
            }

            if ($digit_show_total_rk>1) {
              $didepan_koma_total_rk = $pisah_decimal_show_total_rk[0] ; 
              $dibelakang_koma_total_rk = strlen($pisah_decimal_show_total_rk[1]) >1 ? $pisah_decimal_show_total_rk[1] : $pisah_decimal_show_total_rk[1].'0';
              $hasil_total_rk = $didepan_koma_total_rk.'.'.$dibelakang_koma_total_rk;
            }else{
              $hasil_total_rk = $show_total_rk.'.00';
            }

            if ($digit_total_dev_keu>1) {
              $didepan_koma_total_dev_keu = $pisah_decimal_total_dev_keu[0] ; 
              $dibelakang_koma_total_dev_keu = strlen($pisah_decimal_total_dev_keu[1]) >1 ? $pisah_decimal_total_dev_keu[1] : $pisah_decimal_total_dev_keu[1].'0';
              $hasil_total_dev_keu = $didepan_koma_total_dev_keu.'.'.$dibelakang_koma_total_dev_keu;
            }else{
              $hasil_total_dev_keu = $total_dev_keu_dua.'.00';
            }





          ?>
    </tbody>
      <tfoot>
      <?php if (count($asisten_2)==0) { ?>
      <tr>
        <td colspan="7"><b>Belum Ada Data</b></td>
       
      </tr>
      <?php }else{ ?>
       <tr>
        <td><b>Rata - rata</b></td>
        <th><?php echo $hasil_total_tf; ?></th>
        <th><?php echo $hasil_total_rf; ?></th>
        <th style="<?php echo $warna_peringatan_total_dev_fisik ?>"><?php echo $hasil_total_dev_fisik ?></th>
        <th><?php echo $hasil_total_tk ?></th>
        <th><?php echo $hasil_total_rk ?></th>
       <th style="<?php echo $warna_peringatan_total_dev_keu ?>"><?php echo $hasil_total_dev_keu ?></th>
      </tr>
    <?php } ?>
    </tfoot>
   
    
   
  </table>
</div>

<div style="width:33.33%; float:left">
  <table class="font_laporan laporan_asisten table">
    <thead class="tabel_header">      
      <tr class="tabel_header">
        <th rowspan="2">ASISTEN ADMINISTRASI UMUM</th>
        <th colspan="3">Fisik</th>
        <th colspan="3">Keuangan</th>
      </tr>
      <tr>
        <th style="width:33px">T</th>
        <th style="width:33px">R</th>
        <th style="width:33px">D</th>
        <th style="width:33px">T</th>
        <th style="width:33px">R</th>
        <th style="width:33px">D</th>
      </tr>
    </thead>
    <tbody >
      <?php
          $tertimbang_tiga       = 0;
          $total_t_fisik_tiga    = 0;
          $total_t_keu_tiga      = 0;
          $total_r_fisik_tiga    = 0;
          $total_r_keu_tiga      = 0;
          $total_tertimbang_tiga = 0;
          $jml_skpd_tiga         = 0;




          $total_pagu_tiga =0;
          $total_rp_t_keu_tiga = 0;  
          $total_rp_r_keu_tiga = 0;
       foreach ($asisten_3 as $tiga) { 

        $total_data_skpd +=1;
        $total_data_skpd_tiga +=1;


        $total_pagu +=$tiga->pagu_total;
        $total_rp_t_keu +=$tiga->rp_target_keuangan;
        $total_rp_r_keu +=$tiga->rp_realisasi_keuangan;

        $total_pagu_tiga +=$tiga->pagu_total;
        $total_rp_t_keu_tiga +=$tiga->rp_target_keuangan;
        $total_rp_r_keu_tiga +=$tiga->rp_realisasi_keuangan;


        $dev_fisik = round($tiga->realisasi_fisik -$tiga->target_fisik ,2);
          $dev_keu = round($tiga->realisasi_keuangan - $tiga->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_tiga += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_tiga += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_tiga += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_tiga += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_tiga += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_tiga += 1; 
            }


            $total_t_fisik_tiga    += $tiga->target_fisik;
            $total_t_keu_tiga      += $tiga->target_keuangan;
            $total_r_fisik_tiga    += $tiga->realisasi_fisik;
            $total_r_keu_tiga      += $tiga->realisasi_keuangan;
           $jml_skpd_tiga++;
        


            $show_tf = $tiga->target_fisik;
            $show_tk = $tiga->target_keuangan;
            $show_rf = $tiga->realisasi_fisik == '' ? 0 : $tiga->realisasi_fisik;
            $show_rk = $tiga->realisasi_keuangan == '' ? 0 :  $tiga->realisasi_keuangan;


            $pisah_decimal_show_tf = explode('.', $tiga->target_fisik);
            $pisah_decimal_show_tk = explode('.', $tiga->target_keuangan);
            $pisah_decimal_show_rf = explode('.', $show_rf);
            $pisah_decimal_show_rk = explode('.', $show_rk);
            $pisah_decimal_dev_fisik = explode('.', $dev_fisik);
            $pisah_decimal_dev_keu = explode('.', $dev_keu);

            $digit_show_tf = count($pisah_decimal_show_tk);
            $digit_show_tk = count($pisah_decimal_show_tf);
            $digit_show_rf = count($pisah_decimal_show_rf);
            $digit_show_rk = count($pisah_decimal_show_rk);
            $digit_dev_fisik = count($pisah_decimal_dev_fisik);
            $digit_dev_keu = count($pisah_decimal_dev_keu);

            // Fisik
            if ($digit_show_tf>1) {
              $didepan_koma_tf = $pisah_decimal_show_tf[0] ; 
              $dibelakang_koma_tf = strlen($pisah_decimal_show_tf[1]) >1 ? $pisah_decimal_show_tf[1] : $pisah_decimal_show_tf[1].'0';
              $hasil_tf = $didepan_koma_tf.'.'.$dibelakang_koma_tf;
            }else{
              $hasil_tf = $show_tf.'.00';
            }

            if ($digit_show_rf>1) {
              $didepan_koma_rf = $pisah_decimal_show_rf[0] ; 
              $dibelakang_koma_rf = strlen($pisah_decimal_show_rf[1]) >1 ? $pisah_decimal_show_rf[1] : $pisah_decimal_show_rf[1].'0';
              $hasil_rf = $didepan_koma_rf.'.'.$dibelakang_koma_rf;
            }else{
              $hasil_rf = $show_rf.'.00';
            }

            if ($digit_dev_fisik>1) {
              $didepan_koma_dev_fisik = $pisah_decimal_dev_fisik[0] ; 
              $dibelakang_koma_dev_fisik = strlen($pisah_decimal_dev_fisik[1]) >1 ? $pisah_decimal_dev_fisik[1] : $pisah_decimal_dev_fisik[1].'0';
              $hasil_dev_fisik = $didepan_koma_dev_fisik.'.'.$dibelakang_koma_dev_fisik;
            }else{
              $hasil_dev_fisik = $dev_fisik.'.00';
            }

            // keuangan
            if ($digit_show_tk>1) {
              $didepan_koma_tk = $pisah_decimal_show_tk[0] ; 
              $dibelakang_koma_tk = strlen($pisah_decimal_show_tk[1]) >1 ? $pisah_decimal_show_tk[1] : $pisah_decimal_show_tk[1].'0';
              $hasil_tk = $didepan_koma_tk.'.'.$dibelakang_koma_tk;
            }else{
              $hasil_tk = $show_tk.'.00';
            }

            if ($digit_show_rk>1) {
              $didepan_koma_rk = $pisah_decimal_show_rk[0] ; 
              $dibelakang_koma_rk = strlen($pisah_decimal_show_rk[1]) >1 ? $pisah_decimal_show_rk[1] : $pisah_decimal_show_rk[1].'0';
              $hasil_rk = $didepan_koma_rk.'.'.$dibelakang_koma_rk;
            }else{
              $hasil_rk = $show_rk.'.00';
            }

            if ($digit_dev_keu>1) {
              $didepan_koma_dev_keu = $pisah_decimal_dev_keu[0] ; 
              $dibelakang_koma_dev_keu = strlen($pisah_decimal_dev_keu[1]) >1 ? $pisah_decimal_dev_keu[1] : $pisah_decimal_dev_keu[1].'0';
              $hasil_dev_keu = $didepan_koma_dev_keu.'.'.$dibelakang_koma_dev_keu;
            }else{
              $hasil_dev_keu = $dev_keu.'.00';
            }

 if ($hasil_tf<$hasil_tk) {
              $blok = 'style="background: #fef2ff  "';
            }else{
              $blok = '';

            }
        ?>
         <tr <?php echo $blok ?>>
          <td><?php echo $tiga->nama_instansi ?></td>
          <td class="rata_tengah"><?php echo $hasil_tf ?></td>
          <td class="rata_tengah"><?php echo $hasil_rf ?></td>
          <td class="rata_tengah" style="<?php echo $warna_peringatan_dev_fisik ?>"><?php echo $hasil_dev_fisik ?></td>
          <td class="rata_tengah"><?php echo $hasil_tk ?></td>
          <td class="rata_tengah"><?php echo $hasil_rk ?></td>
          <td class="rata_tengah" style="<?php echo $warna_peringatan_dev_keu ?>"><?php echo $hasil_dev_keu?></td>
        
        </tr>


       <?php } 



       foreach ($asisten_3_belum_terekap as $tiga) { 

        $total_data_skpd +=1;
        $total_data_skpd_tiga +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;

        $total_peringatan_dev_fisik_hijau_tiga+=1;
        $total_peringatan_dev_keu_hijau_tiga+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_tiga++;
        




           
        ?>
          <tr style="background: #dbe7fc ">
          <td><?php echo $tiga->nama_instansi ?></td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
          <td class="rata_tengah">0.00</td>
        
        </tr>


       <?php } 

          @$ratarata_t_fisik_tiga    =  round($total_t_fisik_tiga / $jml_skpd_tiga, 2); 
          @$ratarata_r_fisik_tiga   =  round($total_r_fisik_tiga / $jml_skpd_tiga, 2); 
          @$total_dev_fisik_tiga = $ratarata_r_fisik_tiga - $ratarata_t_fisik_tiga ;
          @$ratarata_t_keu_tiga   = round(($total_rp_t_keu_tiga / $total_pagu_tiga * 100),2);
 ;//round($total_t_keu_tiga / $jml_skpd_tiga, 2); 
          @$ratarata_r_keu_tiga   =  round(($total_rp_r_keu_tiga / $total_pagu_tiga * 100),2);//round($total_r_keu_tiga / $jml_skpd_tiga, 2);
          @$total_dev_keu_tiga = $ratarata_r_keu_tiga - $ratarata_t_keu_tiga ;



            if ($total_dev_fisik_tiga < -10) {
              $warna_peringatan_total_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_fisik_tiga <-5  && $total_dev_fisik_tiga >-10) {
              $warna_peringatan_total_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_fisik = 'background: #d5f5e3';
            }

            if ($total_dev_keu_tiga < -10) {
              $warna_peringatan_total_dev_keu = 'background: #f8b2b2'; 
            }
            elseif ($total_dev_keu_tiga <-5  && $total_dev_keu_tiga >-10) {
              $warna_peringatan_total_dev_keu = 'background: #fcf3cf';
            }else{
              $warna_peringatan_total_dev_keu = 'background: #d5f5e3';
            }



            $show_total_tf = $ratarata_t_fisik_tiga;
            $show_total_rf = $ratarata_r_fisik_tiga;
            $show_total_tk = $ratarata_t_keu_tiga;
            $show_total_rk = $ratarata_r_keu_tiga;


            $pisah_decimal_show_total_tf = explode('.', $show_total_tf);
            $pisah_decimal_show_total_tk = explode('.', $show_total_tk);
            $pisah_decimal_show_total_rf = explode('.', $show_total_rf);
            $pisah_decimal_show_total_rk = explode('.', $show_total_rk);

            $pisah_decimal_total_dev_fisik = explode('.', $total_dev_fisik_tiga);
            $pisah_decimal_total_dev_keu = explode('.', $total_dev_keu_tiga);

            $digit_show_total_tf = count($pisah_decimal_show_total_tf);
            $digit_show_total_tk = count($pisah_decimal_show_total_tk);
            $digit_show_total_rf = count($pisah_decimal_show_total_rf);
            $digit_show_total_rk = count($pisah_decimal_show_total_rk);

            $digit_total_dev_fisik = count($pisah_decimal_total_dev_fisik);
            $digit_total_dev_keu = count($pisah_decimal_total_dev_keu);



            if ($digit_show_total_tf>1) {
              $didepan_koma_total_tf = $pisah_decimal_show_total_tf[0] ; 
              $dibelakang_koma_total_tf = strlen($pisah_decimal_show_total_tf[1]) >1 ? $pisah_decimal_show_total_tf[1] : $pisah_decimal_show_total_tf[1].'0';
              $hasil_total_tf = $didepan_koma_total_tf.'.'.$dibelakang_koma_total_tf;
            }else{
              $hasil_total_tf = $show_total_tf.'.00';
            }

            if ($digit_show_total_rf>1) {
              $didepan_koma_total_rf = $pisah_decimal_show_total_rf[0] ; 
              $dibelakang_koma_total_rf = strlen($pisah_decimal_show_total_rf[1]) >1 ? $pisah_decimal_show_total_rf[1] : $pisah_decimal_show_total_rf[1].'0';
              $hasil_total_rf = $didepan_koma_total_rf.'.'.$dibelakang_koma_total_rf;
            }else{
              $hasil_total_rf = $show_total_rf.'.00';
            }

            if ($digit_total_dev_fisik>1) {
              $didepan_koma_total_dev_fisik = $pisah_decimal_total_dev_fisik[0] ; 
              $dibelakang_koma_total_dev_fisik = strlen($pisah_decimal_total_dev_fisik[1]) >1 ? $pisah_decimal_total_dev_fisik[1] : $pisah_decimal_total_dev_fisik[1].'0';
              $hasil_total_dev_fisik = $didepan_koma_total_dev_fisik.'.'.$dibelakang_koma_total_dev_fisik;
            }else{
              $hasil_total_dev_fisik = $total_dev_fisik_tiga.'.00';
            }


            if ($digit_show_total_tk>1) {
              $didepan_koma_total_tk = $pisah_decimal_show_total_tk[0] ; 
              $dibelakang_koma_total_tk = strlen($pisah_decimal_show_total_tk[1]) >1 ? $pisah_decimal_show_total_tk[1] : $pisah_decimal_show_total_tk[1].'0';
              $hasil_total_tk = $didepan_koma_total_tk.'.'.$dibelakang_koma_total_tk;
            }else{
              $hasil_total_tk = $show_total_tk.'.00';
            }

            if ($digit_show_total_rk>1) {
              $didepan_koma_total_rk = $pisah_decimal_show_total_rk[0] ; 
              $dibelakang_koma_total_rk = strlen($pisah_decimal_show_total_rk[1]) >1 ? $pisah_decimal_show_total_rk[1] : $pisah_decimal_show_total_rk[1].'0';
              $hasil_total_rk = $didepan_koma_total_rk.'.'.$dibelakang_koma_total_rk;
            }else{
              $hasil_total_rk = $show_total_rk.'.00';
            }

            if ($digit_total_dev_keu>1) {
              $didepan_koma_total_dev_keu = $pisah_decimal_total_dev_keu[0] ; 
              $dibelakang_koma_total_dev_keu = strlen($pisah_decimal_total_dev_keu[1]) >1 ? $pisah_decimal_total_dev_keu[1] : $pisah_decimal_total_dev_keu[1].'0';
              $hasil_total_dev_keu = $didepan_koma_total_dev_keu.'.'.$dibelakang_koma_total_dev_keu;
            }else{
              $hasil_total_dev_keu = $total_dev_keu_tiga.'.00';
            }





          ?>
    </tbody>
      <tfoot>
      <?php if (count($asisten_3)==0) { ?>
      <tr>
        <td colspan="7"><b>Belum Ada Data</b></td>
       
      </tr>
      <?php }else{ ?>
        <tr>
        <td><b>Rata - rata</b></td>
        <th><?php echo $hasil_total_tf; ?></th>
        <th><?php echo $hasil_total_rf; ?></th>
        <th style="<?php echo $warna_peringatan_total_dev_fisik ?>"><?php echo $hasil_total_dev_fisik ?></th>
        <th><?php echo $hasil_total_tk ?></th>
        <th><?php echo $hasil_total_rk ?></th>
       <th style="<?php echo $warna_peringatan_total_dev_keu ?>"><?php echo $hasil_total_dev_keu ?></th>
      </tr>
    <?php } ?>
    </tfoot>
   
  
  </table>
</div>

<div style="clear:both"></div>
<hr>


<div style="width:55%; float: left">
<span class="font_laporan">
  <b>
    <u>Statistika Data Deviasi SKPD :</u>
  </b>
</span>
<br><br>
<table class="font_laporan table" style="border-collapse: collapse; width:100%;">
 <thead>
    
    <tr>
      <th rowspan="2">Keterangan</th>
      <th colspan="2">ASISTEN PEMERINTAHAN DAN KESRA</th>
      <th colspan="2">ASISTEN PEREKONOMIAN DAN PEMBANGUNAN</th>
      <th colspan="2">ASISTEN ADMINISTRASI UMUM</th>
      <th colspan="2">Total</th>
    </tr>
    <tr>
      <th style="width:55px">Fisik</th>
      <th style="width:55px">Keuangan</th>
      <th style="width:55px">Fisik</th>
      <th style="width:55px">Keuangan</th>
      <th style="width:55px">Fisik</th>
      <th style="width:55px">Keuangan</th>
      <th style="width:55px">Fisik</th>
      <th style="width:55px">Keuangan</th>
    </tr>
    <tr style="background: #f8b2b2;">
      <td>Deviasi Diatas -10%</td>
      <td align="center"><?= $total_peringatan_dev_fisik_merah_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_merah_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_merah_dua; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_merah_dua; ?></td>

      <td align="center"><?= $total_peringatan_dev_fisik_merah_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_merah_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_merah?></td>
      <td align="center"><?= $total_peringatan_dev_keu_merah?></td>
    </tr>
    <tr style="background: #fcf3cf;">
      <td>Deviasi Antara 5% sampai 10%</td>
      <td align="center"><?= $total_peringatan_dev_fisik_kuning_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_kuning_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_kuning_dua; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_kuning_dua; ?></td>

      <td align="center"><?= $total_peringatan_dev_fisik_kuning_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_kuning_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_kuning?></td>
      <td align="center"><?= $total_peringatan_dev_keu_kuning?></td>
    </tr>
    <tr style="background: #d5f5e3;">
      <td>Deviasi Dibawah -5%</td>
      <td align="center"><?= $total_peringatan_dev_fisik_hijau_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_hijau_satu; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_hijau_dua; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_hijau_dua; ?></td>

      <td align="center"><?= $total_peringatan_dev_fisik_hijau_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_keu_hijau_tiga; ?></td>
      <td align="center"><?= $total_peringatan_dev_fisik_hijau?></td>
      <td align="center"><?= $total_peringatan_dev_keu_hijau?></td>
    </tr>
     <tr>
      <th align="left">Total Data</th>
      
      <th colspan="2"><?= $total_data_skpd_satu; ?></th>
      <th colspan="2"><?= $total_data_skpd_dua; ?></th>
      <th colspan="2"><?= $total_data_skpd_tiga; ?></th>
      <th colspan="2"><?= $total_data_skpd; ?></th>
    </tr>
 </thead>
  
</table>
</div>
<div style="width:22%; float:left; margin-left:50px">

    <span class="font_laporan">
      <b>
        <u>Pencapaiai / Rata Rata <?php echo $identitas['caption_ratarata_rekap_asisten'] ?> :</u>
      </b>
    </span>
    <br><br>
	<table class="font_laporan laporan_asisten table">
    <tr>
     
      <th colspan="3">Fisik</th>
      <th colspan="3">Keuangan</th>
    </tr>
    <tr>
      <th style="width:33px">T</th>
      <th style="width:33px">R</th>
      <th style="width:33px">D</th>
      <th style="width:33px">T</th>
      <th style="width:33px">R</th>
      <th style="width:33px">D</th>
    </tr>
    <tr>
  <?php 
    $semua_skpd = $jml_skpd_satu + $jml_skpd_dua + $jml_skpd_tiga;
    $semua_total_t_fisik = ($total_t_fisik_satu +$total_t_fisik_dua +$total_t_fisik_tiga) / $semua_skpd;
    $semua_total_r_fisik = ($total_r_fisik_satu +$total_r_fisik_dua +$total_r_fisik_tiga)  / $semua_skpd ;
    $semua_total_dev_fisik = $semua_total_r_fisik - $semua_total_t_fisik  ;
    $semua_total_t_keu = ($total_rp_t_keu / $total_pagu) * 100 ;//($total_t_keu_satu +$total_t_keu_dua +$total_t_keu_tiga) / $semua_skpd;
    $semua_total_r_keu = ($total_rp_r_keu / $total_pagu) * 100 ;;//($total_r_keu_satu +$total_r_keu_dua +$total_r_keu_tiga) / $semua_skpd;
    $semua_total_dev_keu = $semua_total_r_keu - $semua_total_t_keu ;


    $show_total_tf = round($semua_total_t_fisik,2);
    $show_total_rf = round($semua_total_r_fisik,2);
    $show_total_tk = round($semua_total_t_keu,2);
    $show_total_rk = round($semua_total_r_keu,2);
    $show_semua_total_dev_fisik = $show_total_rf - $show_total_tf;
    $show_semua_total_dev_keu =  $show_total_rk - $show_total_tk;


    $pisah_decimal_show_total_tf = explode('.', $show_total_tf);
    $pisah_decimal_show_total_tk = explode('.', $show_total_tk);
    $pisah_decimal_show_total_rf = explode('.', $show_total_rf);
    $pisah_decimal_show_total_rk = explode('.', $show_total_rk);

    $pisah_decimal_total_dev_fisik = explode('.', $show_semua_total_dev_fisik);
    $pisah_decimal_total_dev_keu = explode('.', $show_semua_total_dev_keu);

    $digit_show_total_tf = count($pisah_decimal_show_total_tf);
    $digit_show_total_tk = count($pisah_decimal_show_total_tk);
    $digit_show_total_rf = count($pisah_decimal_show_total_rf);
    $digit_show_total_rk = count($pisah_decimal_show_total_rk);

    $digit_total_dev_fisik = count($pisah_decimal_total_dev_fisik);
    $digit_total_dev_keu = count($pisah_decimal_total_dev_keu);



            if ($digit_show_total_tf>1) {
              $didepan_koma_total_tf = $pisah_decimal_show_total_tf[0] ; 
              $dibelakang_koma_total_tf = strlen($pisah_decimal_show_total_tf[1]) >1 ? $pisah_decimal_show_total_tf[1] : $pisah_decimal_show_total_tf[1].'0';
              $hasil_total_tf = $didepan_koma_total_tf.'.'.$dibelakang_koma_total_tf;
            }else{
              $hasil_total_tf = $show_total_tf.'.00';
            }

            if ($digit_show_total_rf>1) {
              $didepan_koma_total_rf = $pisah_decimal_show_total_rf[0] ; 
              $dibelakang_koma_total_rf = strlen($pisah_decimal_show_total_rf[1]) >1 ? $pisah_decimal_show_total_rf[1] : $pisah_decimal_show_total_rf[1].'0';
              $hasil_total_rf = $didepan_koma_total_rf.'.'.$dibelakang_koma_total_rf;
            }else{
              $hasil_total_rf = $show_total_rf.'.00';
            }

            if ($digit_total_dev_fisik>1) {
              $didepan_koma_total_dev_fisik = $pisah_decimal_total_dev_fisik[0] ; 
              $dibelakang_koma_total_dev_fisik = strlen($pisah_decimal_total_dev_fisik[1]) >1 ? $pisah_decimal_total_dev_fisik[1] : $pisah_decimal_total_dev_fisik[1].'0';
              $hasil_total_dev_fisik = $didepan_koma_total_dev_fisik.'.'.$dibelakang_koma_total_dev_fisik;
            }else{
              $hasil_total_dev_fisik = $show_semua_total_dev_fisik.'.00';
            }


            if ($digit_show_total_tk>1) {
              $didepan_koma_total_tk = $pisah_decimal_show_total_tk[0] ; 
              $dibelakang_koma_total_tk = strlen($pisah_decimal_show_total_tk[1]) >1 ? $pisah_decimal_show_total_tk[1] : $pisah_decimal_show_total_tk[1].'0';
              $hasil_total_tk = $didepan_koma_total_tk.'.'.$dibelakang_koma_total_tk;
            }else{
              $hasil_total_tk = $show_total_tk.'.00';
            }

            if ($digit_show_total_rk>1) {
              $didepan_koma_total_rk = $pisah_decimal_show_total_rk[0] ; 
              $dibelakang_koma_total_rk = strlen($pisah_decimal_show_total_rk[1]) >1 ? $pisah_decimal_show_total_rk[1] : $pisah_decimal_show_total_rk[1].'0';
              $hasil_total_rk = $didepan_koma_total_rk.'.'.$dibelakang_koma_total_rk;
            }else{
              $hasil_total_rk = $show_total_rk.'.00';
            }

            if ($digit_total_dev_keu>1) {
              $didepan_koma_total_dev_keu = $pisah_decimal_total_dev_keu[0] ; 
              $dibelakang_koma_total_dev_keu = strlen($pisah_decimal_total_dev_keu[1]) >1 ? $pisah_decimal_total_dev_keu[1] : $pisah_decimal_total_dev_keu[1].'0';
              $hasil_total_dev_keu =  $didepan_koma_total_dev_keu.'.'.$dibelakang_koma_total_dev_keu;
            }else{
              $hasil_total_dev_keu = $show_semua_total_dev_keu.'.00';
            }



   ?>
        <td align="center"><?php echo $hasil_total_tf; ?></td>
        <td align="center"><?php echo $hasil_total_rf; ?></td>
        <td align="center"><?php echo $hasil_total_dev_fisik ?></td>
        <td align="center"><?php echo $hasil_total_tk ?></td>
        <td align="center"><?php echo $hasil_total_rk ?></td>
       <td align="center"><?php echo $hasil_total_dev_keu ?></td>
    </tr>
  </table>
</div>

<div style="width:15%; float:right; margin-left:50px;">

  <span class="font_laporan">
      <b>
        <u>Keterangan :</u>
      </b>
    </span>
    <br>
    <br>
  <table class="laporan_asisten font_laporan">
    <tr>
      <td>T</td>
      <td>Target</td>
    </tr>
    <tr>
      <td>R</td>
      <td>Realisasi</td>
    </tr>
    <tr>
      <td>D</td>
      <td>Deviasi</td>
    </tr>
    <tr>
      <td><span style="background:#f8b2b2; color:#f8b2b2;">----</span></td>
      <td>Deviasi diatas -10% </td>
    </tr>
    <tr>
      <td><span style="background:#fcf3cf; color:#fcf3cf;">----</span></td>
      <td>Deviasi antara -5% sampai -10% </td>
    </tr>
    <tr>
      <td><span style="background:#d5f5e3; color:#d5f5e3;">----</span></td>
      <td>Deviasi dibawah -5% </td>
    </tr>
  <!--   <tr>
      <td>Pagu</td>
      <td><?php echo $total_pagu ?></td>
    </tr>
    <tr>
      <td>Target</td>
      <td><?php echo $total_rp_t_keu ?></td>
    </tr>
    <tr>
      <td>Realisasi</td>
      <td><?php echo $total_rp_r_keu ?></td>
    </tr> -->
  </table>
   <div class="font_laporan">
    
 
        </div> 
  </div>
<div style="clear:both"></div>