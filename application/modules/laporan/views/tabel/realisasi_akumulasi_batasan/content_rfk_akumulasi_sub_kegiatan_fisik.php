<div class="logo">
  <!-- <img src="<?php // echo base_url() ?>assets/sbe/image/logo.png" > -->
</div>
<div class="skpd">
  <center>
    <div class="kop">
      <div class="pemprov_sumbar"><b><?php echo $identitas['identitas'] ?></b></div>
      <div class="nama_instansi"><?php echo $nama_instansi ?> </div>
      <div class="tahun"><b><?php echo $nama_tahap ?> Tahun Anggaran <?php echo $tahun ?></b></div>


     
    </div>
  </center> 
  </div>
  <div class="clearfix"></div>

<div class="garis_kop1"></div>
<div class="garis_kop2"></div>

<div class="judul_laporan"><?php echo $judul_laporan ?></div>



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
  $total_kegiatan = 0;
  $total_program = 0;


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
   $total_fisik_semua =0;

   $angka_pembagi_fisik = $tot_subkeg * 100 ; 
   $total_porsi_target_fisik = 0;
   $total_porsi_realisasi_fisik = 0;


   $total_persen_target_keuangan = 0;
   $total_persen_realisasi_keuangan = 0;
   $total_persen_target_keuangan_besar = 0;
   $total_persen_realisasi_keuangan_besar = 0;

   $sisa_pagu_total = 0;

   $total_realisasi_fisik_semua =0;
  
  $kumpul_program = [];



  $total_pagu_skpd =0;
  foreach ($program as $key => $value) { 
    $total_program +=1;
    $no_program++;
    // $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
  
    <?php 
    $no_kegiatan=0;
    $kumpul_kegiatan = [];
    $pagu_program =0;

    $banyak_kegiatan =0;
    $persen_tf_program =0;
    $persen_rf_program =0;
    $persen_df_program =0;
    $nilai_tk_program =0;
    $persen_tk_program =0;
    $nilai_rk_program =0;
    $persen_rk_program =0;
    $persen_dk_program =0;
    $sisa_anggaran_program =0;
    foreach ($kegiatan as $key => $value_kegiatan) {
      $total_kegiatan +=1;
      $banyak_kegiatan +=1;
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan);
    ?>
    
     <?php 
     $kumpul_sub_kegiatan = [];




    $pagu_kegiatan =0;
    $banyak_sub_kegiatan =0;
    $persen_tf_kegiatan =0;
    $persen_rf_kegiatan =0;
    $persen_df_kegiatan =0;
    $nilai_tk_kegiatan =0;
    $persen_tk_kegiatan =0;
    $nilai_rk_kegiatan =0;
    $persen_rk_kegiatan =0;
    $persen_dk_kegiatan =0;
    $sisa_anggaran_kegiatan =0;


     foreach ($sub_kegiatan->result() as $key => $value_sk) {
      $banyak_sub_kegiatan +=1;
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $kategori_sub_kegiatan = $value_sk->kategori;
      $tahap = $value_sk->kode_tahap;
      $total_pagu_sub_kegiatan_instansi +=$value_sk->pagu ;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }

          $sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();




          $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $value_sk->kode_tahap)->row_array();
          $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)->row_array();

          if ($ope=='=') {
            $target_fisik = $target['target_fisik_bulanan'];
            $target_keuangan = $target['target_keuangan_bulanan'];
            $nilai_persen_target_keuangan = ($target['target_keuangan_bulanan'] / $value_sk->pagu) * 100 ; 
            
          }else{
            $target_keuangan = $target['target_keuangan'];
            $target_fisik = $target['target_fisik'];
            $nilai_persen_target_keuangan = ($target['target_keuangan'] / $value_sk->pagu) * 100 ; 

          }

          $porsi_target_fisik = ($target_fisik / $angka_pembagi_fisik) * 100 ; 
          $total_porsi_target_fisik += $porsi_target_fisik ;
          // $target_fisik_bulanan = $target['target_fisik_bulanan'];

          // 
          if ($value_sk->pagu == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
          } else {
          $persen_target_keuangan = $nilai_persen_target_keuangan; 
            $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);
          }

          
          $persen_target_keuangan_besar = ($target_keuangan / $pagu_skpd) *100 ; 
          $persen_realisasi_keuangan_besar = ($realisasi_keuangan['total_realisasi'] / $pagu_skpd) *100 ; 
          $total_persen_target_keuangan +=$persen_target_keuangan ;
          $total_persen_realisasi_keuangan +=$persen_realisasi_keuangan ;
          // $target_keuangan_bulanan = $target['target_keuangan_bulanan'];



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
              $i=>($ke / $lama_realisasi * 100)
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
              if ($ope=='=') {
                $realisasi_rutin = (1/$lama_realisasi) *100;
              }else{
                $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
              }
            }


          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
         

          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }

          $total_realisasi_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
          $porsi_realisasi_fisik    = ($total_realisasi_fisik / $angka_pembagi_fisik) * 100 ;
          $total_porsi_realisasi_fisik += $porsi_realisasi_fisik ;
          $total_realisasi_fisik_semua += $total_realisasi_fisik ;



          $dev_fisik = $total_realisasi_fisik - $target_fisik;
          $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;
          // $dev_fisik = $porsi_realisasi_fisik - $porsi_target_fisik;
          // $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
            }

        
           if ($ope=='=') {
            $total_target_fisik   += isset($target['target_fisik_bulanan']) ? $target['target_fisik_bulanan'] : 0;
            $total_angka_target_keuangan += $target['target_keuangan_bulanan'];
          }else{
            $total_target_fisik   += isset($target['target_fisik']) ? $target['target_fisik'] : 0;
            $total_angka_target_keuangan += $target['target_keuangan'];

          }

          $sisa_pagu = $value_sk->pagu -$realisasi_keuangan['total_realisasi'] ;
          $sisa_pagu_total += $sisa_pagu;


          // last update 09102020
          $total_target_keuangan += isset($persen_target_keuangan) ? $persen_target_keuangan : 0;
          $total_realisasi_keuangan += isset($realisasi_keuangan['total_realisasi']) ? $realisasi_keuangan['total_realisasi'] : 0;
          // $total_persen_realisasi_keuangan += isset($persen_realisasi_keuangan) ? $persen_realisasi_keuangan : 0;
          $total_persen_realisasi_fisik += isset($total_realisasi_fisik) ? $total_realisasi_fisik : 0;
          $total_persen_deviasi_f += isset($dev_fisik) ? ROUND($dev_fisik, 2) : 0;
          $total_persen_deviasi_k += isset($dev_keu) ? ROUND($dev_keu, 2) : 0;






      $total_persen_target_keuangan_besar += $persen_target_keuangan_besar;
      $total_persen_realisasi_keuangan_besar += $persen_realisasi_keuangan_besar;



      ?>
     

       <?php 
          $total_pagu_skpd +=$value_sk->pagu;

          $pagu_kegiatan+=$value_sk->pagu;
          $persen_tf_kegiatan+=$target_fisik;
          $persen_rf_kegiatan+=$total_realisasi_fisik;
          $persen_df_kegiatan+=$dev_fisik;
          $nilai_tk_kegiatan+=$target_keuangan;
          $persen_tk_kegiatan+=$persen_target_keuangan;
          $nilai_rk_kegiatan+=$realisasi_keuangan['total_realisasi'];
          $persen_rk_kegiatan+=$persen_realisasi_keuangan;
          $persen_dk_kegiatan+=$dev_keu;
          $sisa_anggaran_kegiatan+=$sisa_pagu;

         $data_kumpul_sub_kegiatan = [
          'no'=> $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan,
          'kode_tahap'=> $value_sk->kode_tahap,
          'kode_rekening_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
          'nama_sub_kegiatan'=> $nama_sub_kegiatan,
          'pagu_sub_kegiatan'=> $value_sk->pagu,
          'persen_tf_sub_kegiatan'=> $target_fisik,
          'persen_rf_sub_kegiatan'=> $total_realisasi_fisik,
          'persen_df_sub_kegiatan'=> $dev_fisik,
          'nilai_tk_sub_kegiatan'=> $target_keuangan,
          'persen_tk_sub_kegiatan'=> $persen_target_keuangan,
          'nilai_rk_sub_kegiatan'=> $realisasi_keuangan['total_realisasi'],
          'persen_rk_sub_kegiatan'=> $persen_realisasi_keuangan,
          'persen_dk_sub_kegiatan'=> $dev_keu,
          'warna_df_sub_kegiatan'=> $warna_peringatan_dev_fisik,
          'warna_dk_sub_kegiatan'=> $warna_peringatan_dev_keu,
          'sisa_anggaran_sub_kegiatan'=> $sisa_pagu,
         ];
         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);

       ?>


  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)


        $tampilkan_persen_tf_kegiatan = $persen_tf_kegiatan / $banyak_sub_kegiatan;
        $tampilkan_persen_rf_kegiatan = $persen_rf_kegiatan / $banyak_sub_kegiatan;
        $tampilkan_persen_df_kegiatan = $tampilkan_persen_rf_kegiatan - $tampilkan_persen_tf_kegiatan;

        $tampilkan_persen_tk_kegiatan = ($nilai_tk_kegiatan / $pagu_kegiatan) * 100;
        $tampilkan_persen_rk_kegiatan = ($nilai_rk_kegiatan / $pagu_kegiatan) * 100;
        $tampilkan_persen_dk_kegiatan = $tampilkan_persen_rk_kegiatan - $tampilkan_persen_tk_kegiatan;

        $pagu_program += $pagu_kegiatan;
        $persen_tf_program += $tampilkan_persen_tf_kegiatan;
        $persen_rf_program += $tampilkan_persen_rf_kegiatan;
        $persen_df_program += $persen_df_kegiatan;
        $nilai_tk_program += $nilai_tk_kegiatan;
        $persen_tk_program += $persen_tk_kegiatan;
        $nilai_rk_program += $nilai_rk_kegiatan;
        $persen_rk_program += $persen_rk_kegiatan;
        $persen_dk_program += $persen_dk_kegiatan;
        $sisa_anggaran_program += $sisa_anggaran_kegiatan;



        $data_kegiatan = [
           'no'=>  $no_program.'.'.$no_kegiatan,
          'kode_rekening_kegiatan'=> $value_kegiatan->kode_rekening_kegiatan,
          'nama_kegiatan'=> $value_kegiatan->nama_kegiatan,
          'pagu_kegiatan'=> $pagu_kegiatan,
          'persen_tf_kegiatan'=> $tampilkan_persen_tf_kegiatan,
          'persen_rf_kegiatan'=> $tampilkan_persen_rf_kegiatan,
          'persen_df_kegiatan'=> $tampilkan_persen_df_kegiatan,
          'nilai_tk_kegiatan'=> $nilai_tk_kegiatan,
          'persen_tk_kegiatan'=> $tampilkan_persen_tk_kegiatan,
          'nilai_rk_kegiatan'=> $nilai_rk_kegiatan,
          'persen_rk_kegiatan'=> $tampilkan_persen_rk_kegiatan,
          'persen_dk_kegiatan'=> $tampilkan_persen_dk_kegiatan,
          'sisa_anggaran_kegiatan'=> $sisa_anggaran_kegiatan,
          'data_sub_kegiatan' =>$kumpul_sub_kegiatan,
        ];
       array_push($kumpul_kegiatan, $data_kegiatan);
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 


      $tampilkan_persen_tf_program = $persen_tf_program / $banyak_kegiatan;
      $tampilkan_persen_rf_program = $persen_rf_program / $banyak_kegiatan;
      $tampilkan_persen_df_program = $tampilkan_persen_rf_program - $tampilkan_persen_tf_program;


      $tampilkan_persen_tk_program = ($nilai_tk_program / $pagu_program) * 100;
      $tampilkan_persen_rk_program = ($nilai_rk_program / $pagu_program) * 100;
      $tampilkan_persen_dk_program = $tampilkan_persen_rk_program - $tampilkan_persen_tk_program;

      $data_program = [
           'no'=> $no_program,
          'kode_rekening_program'=> $value->kode_rekening_program,
          'nama_program'=> $value->nama_program,
          'pagu_program'=>$pagu_program,
          'persen_tf_program'=>$tampilkan_persen_tf_program,
          'persen_rf_program'=>$tampilkan_persen_rf_program,
          'persen_df_program'=>$tampilkan_persen_df_program,
          'nilai_tk_program'=>$nilai_tk_program,
          'persen_tk_program'=>$tampilkan_persen_tk_program,
          'nilai_rk_program'=>$nilai_rk_program,
          'persen_rk_program'=>$tampilkan_persen_rk_program,
          'persen_dk_program'=>$tampilkan_persen_dk_program,
          'sisa_anggaran_program'=>$sisa_anggaran_program,
          'data_kegiatan' =>$kumpul_kegiatan,
        ];

        array_push($kumpul_program, $data_program);



    } //akhir foreach ($program as $key => $value) { 
      $deviasi_total_fisik = $total_porsi_realisasi_fisik - $total_porsi_target_fisik ; 
      $nilai_total_persen_target_keuangan = ($total_angka_target_keuangan / $total_pagu_sub_kegiatan_instansi) * 100;
      $persen_realisasi_keuangan_total = ($total_realisasi_keuangan / $total_pagu_sub_kegiatan_instansi) * 100 ;
      $deviasi_total_keuangan_akuntansi = round($persen_realisasi_keuangan_total,2) - round($nilai_total_persen_target_keuangan,2) ; 



      if ($deviasi_total_keuangan_akuntansi < -10) {
        $warna_peringatan_deviasi_total_keuangan_akuntansi = 'background: #f8b2b2'; 
      }
      elseif ($deviasi_total_keuangan_akuntansi <-5  && $deviasi_total_keuangan_akuntansi >-10) {
        $warna_peringatan_deviasi_total_keuangan_akuntansi = 'background: #fcf3cf';
      }else{
        $warna_peringatan_deviasi_total_keuangan_akuntansi = 'background: #d5f5e3';
      }



?>




     <?php 
     // $deviasi_fisik_total =  $grafik->realisasi_fisik - $grafik->target_fisik;
    // $deviasi_keuangan_ratarata = $grafik->realisasi_keuangan - $grafik->target_keuangan;


            



    // $ratarata_fisik = $total_fisik_semua / $total_sub_kegiatan ; 
     $ratarata_target_fisik = $total_target_fisik / $tot_subkeg;
     $ratarata_realisasi_fisik = $total_realisasi_fisik_semua / $tot_subkeg;
     $deviasi_fisik_total =  round($ratarata_realisasi_fisik,2) - round($ratarata_target_fisik,2) ;

    $ratarata_target_keuangan = $total_persen_target_keuangan / $tot_subkeg;
    $ratarata_realisasi_keuangan = $total_persen_realisasi_keuangan / $tot_subkeg;
    $deviasi_keuangan_ratarata = round($ratarata_realisasi_keuangan,2) - round($ratarata_target_keuangan,2) ;


    if ($deviasi_fisik_total < -10) {
              $warna_peringatan_deviasi_fisik_total = 'background: #f8b2b2'; 
            }
            elseif ($deviasi_fisik_total <-5  && $deviasi_fisik_total >-10) {
              $warna_peringatan_deviasi_fisik_total = 'background: #fcf3cf';
            }else{
              $warna_peringatan_deviasi_fisik_total = 'background: #d5f5e3';
            }

            if ($deviasi_keuangan_ratarata < -10) {
              $warna_peringatan_deviasi_keuangan_ratarata = 'background: #f8b2b2'; 
            }
            elseif ($deviasi_keuangan_ratarata <-5  && $deviasi_keuangan_ratarata >-10) {
              $warna_peringatan_deviasi_keuangan_ratarata = 'background: #fcf3cf';
            }else{
              $warna_peringatan_deviasi_keuangan_ratarata = 'background: #d5f5e3';
            }


          // header('Content-Type: application/json');
          // echo json_encode($kumpul_program);




 ?>














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
   float:center;
   
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
    <th rowspan="3"  width="30px">No</th>
    <th rowspan="2" colspan="3" >Program, Kegiatan, Sub Kegiatan</th>
    <!-- <th rowspan="3" style="width:80px">Pagu Anggaran</th> -->
    <th>Fisik </th>
  

   
  </tr>
  <tr>

    <th>Realisasi</th>
   
  </tr>
  <tr>
    <th  style="width:85px">Kode Rekening</th>
    <th>Uraian</th>
    <th style="width:80px">Pagu</th>
    <th style="width:35px">%</th>
   
  </tr>
  <tr>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
   
  </tr>

 </thead>
 <tbody>
  
  <?php 
$no=0;
$total_peringatan_dev_program_fisik_merah = 0;
$total_peringatan_dev_program_fisik_kuning = 0;
$total_peringatan_dev_program_fisik_hijau = 0;
$total_peringatan_dev_program_keu_merah = 0;
$total_peringatan_dev_program_keu_kuning = 0;
$total_peringatan_dev_program_keu_hijau = 0;

$total_peringatan_dev_kegiatan_fisik_merah = 0;
$total_peringatan_dev_kegiatan_fisik_kuning = 0;
$total_peringatan_dev_kegiatan_fisik_hijau = 0;
$total_peringatan_dev_kegiatan_keu_merah = 0;
$total_peringatan_dev_kegiatan_keu_kuning = 0;
$total_peringatan_dev_kegiatan_keu_hijau = 0;

$display_none = "style='display:none'";


   foreach ($kumpul_program as $k_program => $v_program) { 

    $deviasi_fisik_program = round($v_program['persen_df_program'],2);
    $deviasi_keuangan_program = round($v_program['persen_dk_program'],2);


    if ($deviasi_fisik_program < -10) {
      $warna_peringatan_deviasi_fisik_program = 'background: #f8b2b2'; 
      $total_peringatan_dev_program_fisik_merah += 1 ;
    }
    elseif ($deviasi_fisik_program <-5  && $deviasi_fisik_program >-10) {
      $warna_peringatan_deviasi_fisik_program = 'background: #fcf3cf';
      $total_peringatan_dev_program_fisik_kuning += 1 ;
    }else{
      $warna_peringatan_deviasi_fisik_program = 'background: #d5f5e3';
      $total_peringatan_dev_program_fisik_hijau += 1 ;
    }

    if ($deviasi_keuangan_program < -10) {
      $warna_peringatan_deviasi_keuangan_program = 'background: #f8b2b2'; 
      $total_peringatan_dev_program_keu_merah += 1 ;
    }
    elseif ($deviasi_keuangan_program <-5  && $deviasi_keuangan_program >-10) {
      $warna_peringatan_deviasi_keuangan_program = 'background: #fcf3cf';
      $total_peringatan_dev_program_keu_kuning += 1 ;
    }else{
      $warna_peringatan_deviasi_keuangan_program = 'background: #d5f5e3';
      $total_peringatan_dev_program_keu_hijau += 1 ;
    }


    ?>
 


<?php 
    foreach ($v_program['data_kegiatan'] as $k_kegiatan => $v_kegiatan) { 

      




      $deviasi_fisik_kegiatan = round($v_kegiatan['persen_df_kegiatan'],2);
      $deviasi_keuangan_kegiatan = round($v_kegiatan['persen_dk_kegiatan'],2);


      if ($deviasi_fisik_kegiatan < -10) {
        $warna_peringatan_deviasi_fisik_kegiatan = 'background: #f8b2b2'; 
        $total_peringatan_dev_kegiatan_fisik_merah += 1 ;
      }
      elseif ($deviasi_fisik_kegiatan <-5  && $deviasi_fisik_kegiatan >-10) {
        $warna_peringatan_deviasi_fisik_kegiatan = 'background: #fcf3cf';
        $total_peringatan_dev_kegiatan_fisik_kuning += 1 ;
      }else{
        $warna_peringatan_deviasi_fisik_kegiatan = 'background: #d5f5e3';
        $total_peringatan_dev_kegiatan_fisik_hijau += 1 ;
      }

      if ($deviasi_keuangan_kegiatan < -10) {
        $warna_peringatan_deviasi_keuangan_kegiatan = 'background: #f8b2b2'; 
        $total_peringatan_dev_kegiatan_keu_merah += 1 ;
      }
      elseif ($deviasi_keuangan_kegiatan <-5  && $deviasi_keuangan_kegiatan >-10) {
        $warna_peringatan_deviasi_keuangan_kegiatan = 'background: #fcf3cf';
        $total_peringatan_dev_kegiatan_keu_kuning += 1 ;
      }else{
        $warna_peringatan_deviasi_keuangan_kegiatan = 'background: #d5f5e3';
        $total_peringatan_dev_kegiatan_keu_hijau += 1 ;
      }







		   foreach ($v_kegiatan['data_sub_kegiatan'] as $k_ski => $v_sub_kegiatan) { 

		   	  if ($pilihan_batasan=='dibawah') {
		          if ($v_sub_kegiatan['persen_rf_sub_kegiatan'] <= $batasan) {
		            $tanda_rf_sub_kegiatan = "";
		            $no++;
		          }else{
		            $tanda_rf_sub_kegiatan = $display_none;

		          }
		          # code...
		        }else{
		           if ($v_sub_kegiatan['persen_rf_sub_kegiatan'] >= $batasan) {
		            $tanda_rf_sub_kegiatan = "";
		            $no++;
		          }else{
		            $tanda_rf_sub_kegiatan = $display_none;

		          }
		        }
      ?>

       <tr  <?php echo $tanda_rf_sub_kegiatan ?>>
        <th align="left"> <?php echo $no ?></th>
        <th align="left"> <?php echo $v_sub_kegiatan['kode_rekening_sub_kegiatan'] ?></th>
        <th align="left"> <?php echo $v_sub_kegiatan['nama_sub_kegiatan'] ?></th>
        <th align="right"> <?php echo number_format($v_sub_kegiatan['pagu_sub_kegiatan']) ?></th>
        <th align="center" > <?php echo round($v_sub_kegiatan['persen_rf_sub_kegiatan'],2) ?></th>

      </tr>
<?php  
  


    }// end sub kegiatan  
   } //end kegiatan
} //end program

?>
</tbody>

</table>
