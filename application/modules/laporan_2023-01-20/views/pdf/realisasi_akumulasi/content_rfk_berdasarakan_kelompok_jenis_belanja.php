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

  
 <!-- <tbody> -->
   <?php 
  $no_program   = 0;
  $pagu_program   = 0;

  $total_sub_kegiatan = 0;

  $total_fisik_semua=0;

  $total_pagu_bo=0;
  $total_pagu_bm=0;
  $total_pagu_btt=0;
  $total_pagu_bt=0;
  $total_pagu_semua=0;

  $total_realisasi_bo=0;
  $total_realisasi_bm=0;
  $total_realisasi_btt=0;
  $total_realisasi_bt=0;
  $total_realisasi_semua=0;





  $kumpul_program =[];




  foreach ($program as $key => $value) { 
    $no_program++;
    $pagu_program += $value->pagu;
    $nama_program = $value->nama_program;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); 





    $no_kegiatan=0;
    $kumpul_kegiatan =[];
          $jumlah_pagu_bo_program =0;
      $jumlah_pagu_bm_program =0;
      $jumlah_pagu_btt_program =0;
      $jumlah_pagu_bt_program =0;
      $jumlah_pagu_total_program =0;
      $show_realisasi_bo_program =0;
      $show_realisasi_bm_program =0;
      $show_realisasi_btt_program =0;
      $show_realisasi_bt_program =0;
      $total_realisasi_program =0;
      $persen_rk_bo_program =0;
      $persen_rk_bm_program =0;
      $persen_rk_btt_program =0;
      $persen_rk_bt_program =0;
      $persen_rk_total_program =0;
      $total_fisik_program =0;
    foreach ($kegiatan as $key => $value_kegiatan) {
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
      $nama_kegiatan = $value_kegiatan->nama_kegiatan;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();
  

     $kumpul_sub_kegiatan =[];
      $jumlah_pagu_bo_kegiatan =0;
      $jumlah_pagu_bm_kegiatan =0;
      $jumlah_pagu_btt_kegiatan =0;
      $jumlah_pagu_bt_kegiatan =0;
      $jumlah_pagu_total_kegiatan =0;
      $show_realisasi_bo_kegiatan =0;
      $show_realisasi_bm_kegiatan =0;
      $show_realisasi_btt_kegiatan =0;
      $show_realisasi_bt_kegiatan =0;
      $total_realisasi_kegiatan =0;
      $persen_rk_bo_kegiatan =0;
      $persen_rk_bm_kegiatan =0;
      $persen_rk_btt_kegiatan =0;
      $persen_rk_bt_kegiatan =0;
      $persen_rk_total_kegiatan =0;
      $total_fisik_kegiatan =0;
     foreach ($sub_kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $tahap= $value_sk->kode_tahap;
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



                $total_pagu_bo+=$jumlah_pagu_bo;
                $total_pagu_bm+=$jumlah_pagu_bm;
                $total_pagu_btt+=$jumlah_pagu_btt;
                $total_pagu_bt+=$jumlah_pagu_bt;
                $total_pagu_semua+=$jumlah_pagu_total;









































        $realisasi_dipilih = $keuangan->cek_realisasi_dipilih($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array();

                $realisasi_bo = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $keuangan->total_realisasi_perjenis($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];


                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;

                $show_realisasi_bo = $pagu_bo == 0 ?  '-' : $jumlah_realisasi_bo;
                $show_realisasi_bm = $pagu_bm == 0 ?  '-' : $jumlah_realisasi_bm;
                $show_realisasi_btt = $pagu_btt = 0  ? '-' :  $jumlah_realisasi_btt;
                $show_realisasi_bt = $pagu_bt == 0 ?  '-' : $jumlah_realisasi_bt;






               $total_realisasi = $jumlah_realisasi_bo + $jumlah_realisasi_bm + $jumlah_realisasi_btt + $jumlah_realisasi_bt ;//$keuangan->total_realisasi($value_sk->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array()['total_realisasi'] ;

               $persen_rk_bo = $pagu_bo ==0 ? 0 : ($jumlah_realisasi_bo / $pagu_bo) * 100;
               $persen_rk_bm = $pagu_bm ==0 ? 0 : ($jumlah_realisasi_bm / $pagu_bm) * 100;
               $persen_rk_btt = $pagu_btt ==0 ? 0 : ($jumlah_realisasi_btt / $pagu_btt) * 100;
               $persen_rk_bt = $pagu_bt ==0 ? 0 : ($jumlah_realisasi_bt / $pagu_bt) * 100;

               $persen_rk_total = $jumlah_pagu_total ==0 ? 0 : ($total_realisasi / $jumlah_pagu_total) * 100;

                $total_realisasi_bo += $pagu_bo==0 ? 0 : $jumlah_realisasi_bo;
                $total_realisasi_bm += $pagu_bm==0 ? 0 : $jumlah_realisasi_bm;
                $total_realisasi_btt += $pagu_btt==0 ? 0 : $jumlah_realisasi_btt;
                $total_realisasi_bt += $pagu_bt==0 ? 0 : $jumlah_realisasi_bt;
                $total_realisasi_semua +=$total_realisasi;










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
          $total_fisik_semua +=$total_fisik;





               $jumlah_pagu_bo_kegiatan+=$jumlah_pagu_bo;
               $jumlah_pagu_bm_kegiatan+=$jumlah_pagu_bm;
               $jumlah_pagu_btt_kegiatan+=$jumlah_pagu_btt;
               $jumlah_pagu_bt_kegiatan+=$jumlah_pagu_bt;
               $jumlah_pagu_total_kegiatan+=$jumlah_pagu_total;
               $show_realisasi_bo_kegiatan+=$show_realisasi_bo;
               $show_realisasi_bm_kegiatan+=$show_realisasi_bm;
               $show_realisasi_btt_kegiatan+=$show_realisasi_btt;
               $show_realisasi_bt_kegiatan+=$show_realisasi_bt;
               $total_realisasi_kegiatan+=$total_realisasi;
               $persen_rk_bo_kegiatan+=$persen_rk_bo;
               $persen_rk_bm_kegiatan+=$persen_rk_bm;
               $persen_rk_btt_kegiatan+=$persen_rk_btt;
               $persen_rk_bt_kegiatan+=$persen_rk_bt;
               $persen_rk_total_kegiatan+=$persen_rk_total;
               $total_fisik_kegiatan+=$total_fisik;



            $data_ski = [
              'no'=> $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan,
              'kode_tahap'=> $tahap,
              'nama_tahap'=> pilihan_nama_tahapan($tahap),
              'nama_sub_kegiatan'=> $nama_sub_kegiatan,
              'pagu_bo_ski'=> $jumlah_pagu_bo,
              'pagu_bm_ski'=> $jumlah_pagu_bm,
              'pagu_btt_ski'=> $jumlah_pagu_btt,
              'pagu_bt_ski'=> $jumlah_pagu_bt,
              'pagu_total_ski'=> $jumlah_pagu_total,
              'rp_realisasi_bo_ski'=> $show_realisasi_bo =='-' ? '-' : number_format($show_realisasi_bo),
              'rp_realisasi_bm_ski'=> $show_realisasi_bm =='-' ? '-' : number_format($show_realisasi_bm),
              'rp_realisasi_btt_ski'=> $show_realisasi_btt =='-' ? '-' : number_format($show_realisasi_btt),
              'rp_realisasi_bt_ski'=> $show_realisasi_bt =='-' ? '-' : number_format($show_realisasi_bt),
              'rp_realisasi_total_ski'=> $total_realisasi,
              'persen_realisasi_bo_ski'=> $persen_rk_bo,
              'persen_realisasi_bm_ski'=> $persen_rk_bm,
              'persen_realisasi_btt_ski'=> $persen_rk_btt,
              'persen_realisasi_bt_ski'=> $persen_rk_bt,
              'persen_realisasi_total_ski'=> $persen_rk_total,
              'total_fisik_ski'=> $total_fisik,
            ];
            array_push ($kumpul_sub_kegiatan , $data_ski);




        } //akhir foreach ($sub_kegiatan as $key => $value_sk)


               $jumlah_pagu_bo_program+=$jumlah_pagu_bo_kegiatan;
               $jumlah_pagu_bm_program+=$jumlah_pagu_bm_kegiatan;
               $jumlah_pagu_btt_program+=$jumlah_pagu_btt_kegiatan;
               $jumlah_pagu_bt_program+=$jumlah_pagu_bt_kegiatan;
               $jumlah_pagu_total_program+=$jumlah_pagu_total_kegiatan;
               $show_realisasi_bo_program+=$show_realisasi_bo_kegiatan;
               $show_realisasi_bm_program+=$show_realisasi_bm_kegiatan;
               $show_realisasi_btt_program+=$show_realisasi_btt_kegiatan;
               $show_realisasi_bt_program+=$show_realisasi_bt_kegiatan;
               $total_realisasi_program+=$total_realisasi_kegiatan;
               $persen_rk_bo_program+=$persen_rk_bo_kegiatan;
               $persen_rk_bm_program+=$persen_rk_bm_kegiatan;
               $persen_rk_btt_program+=$persen_rk_btt_kegiatan;
               $persen_rk_bt_program+=$persen_rk_bt_kegiatan;
               $persen_rk_total_program+=$persen_rk_total_kegiatan;


               $persen_rk_bo_kegiatan = ($show_realisasi_bo_kegiatan / $jumlah_pagu_bo_kegiatan) *100;
               $persen_rk_bm_kegiatan = ($show_realisasi_bm_kegiatan / $jumlah_pagu_bm_kegiatan) *100;
               $persen_rk_btt_kegiatan = ($show_realisasi_btt_kegiatan / $jumlah_pagu_btt_kegiatan) *100;
               $persen_rk_bt_kegiatan = ($show_realisasi_bt_kegiatan / $jumlah_pagu_bt_kegiatan) *100;
               $persen_rk_total_kegiatan = ($total_realisasi_kegiatan / $jumlah_pagu_total_kegiatan) *100;

              $banyak_sub_kegiatan = count($kumpul_sub_kegiatan);
              $ratarata_fisik_kegiatan = ($total_fisik_kegiatan / $banyak_sub_kegiatan);
               $total_fisik_program+=$ratarata_fisik_kegiatan;

             $data_kegiatan = [
              'no'=> $no_program.'.'.$no_kegiatan,
              'kode_tahap'=> '',
              'nama_tahap'=> '',
              'nama_kegiatan'=> $nama_kegiatan,
              'pagu_bo_kegiatan'=> $jumlah_pagu_bo_kegiatan,
              'pagu_bm_kegiatan'=> $jumlah_pagu_bm_kegiatan,
              'pagu_btt_kegiatan'=> $jumlah_pagu_btt_kegiatan,
              'pagu_bt_kegiatan'=> $jumlah_pagu_bt_kegiatan,
              'pagu_total_kegiatan'=> $jumlah_pagu_total_kegiatan,
              'rp_realisasi_bo_kegiatan'=> $jumlah_pagu_bo_kegiatan==0 ? '-' : number_format($show_realisasi_bo_kegiatan),
              'rp_realisasi_bm_kegiatan'=> $jumlah_pagu_bm_kegiatan==0 ? '-' : number_format($show_realisasi_bm_kegiatan),
              'rp_realisasi_btt_kegiatan'=> $jumlah_pagu_btt_kegiatan==0 ? '-' : number_format($show_realisasi_btt_kegiatan),
              'rp_realisasi_bt_kegiatan'=> $jumlah_pagu_bt_kegiatan==0 ? '-' : number_format($show_realisasi_bt_kegiatan),
              'rp_realisasi_total_kegiatan'=> $total_realisasi_kegiatan,
              'persen_realisasi_bo_kegiatan'=>  $jumlah_pagu_bo_kegiatan==0 ? '-' : round($persen_rk_bo_kegiatan,2),
              'persen_realisasi_bm_kegiatan'=> $jumlah_pagu_bm_kegiatan==0 ? '-' : round($persen_rk_bm_kegiatan,2),
              'persen_realisasi_btt_kegiatan'=> $jumlah_pagu_btt_kegiatan==0 ? '-' : round($persen_rk_btt_kegiatan,2),
              'persen_realisasi_bt_kegiatan'=> $jumlah_pagu_bt_kegiatan==0 ? '-' : round($persen_rk_bt_kegiatan,2),
              'persen_realisasi_total_kegiatan'=> round($persen_rk_total_kegiatan,2),
              'total_fisik_kegiatan'=> round($ratarata_fisik_kegiatan,2) ,
              'sub_kegiatan'=> $kumpul_sub_kegiatan ,
            ];
            array_push($kumpul_kegiatan, $data_kegiatan);



      } 


              $persen_rk_total_program = ($total_realisasi_program / $jumlah_pagu_total_program) * 100 ; 

               $persen_rk_bo_program = ($show_realisasi_bo_program / $jumlah_pagu_bo_program) *100;
               $persen_rk_bm_program = ($show_realisasi_bm_program / $jumlah_pagu_bm_program) *100;
               $persen_rk_btt_program = ($show_realisasi_btt_program / $jumlah_pagu_btt_program) *100;
               $persen_rk_bt_program = ($show_realisasi_bt_program / $jumlah_pagu_bt_program) *100;
               $persen_rk_total_program = ($total_realisasi_program / $jumlah_pagu_total_program) *100;

              $banyak_kegiatan = count($kumpul_kegiatan);
              $ratarata_fisik_program = ($total_fisik_program / $banyak_kegiatan);


             $data_program = [
              'no'=> $no_program,
              'kode_tahap'=> '',
              'nama_tahap'=> '',
              'nama_program'=> $nama_program,
              'pagu_bo_program'=> $jumlah_pagu_bo_program,
              'pagu_bm_program'=> $jumlah_pagu_bm_program,
              'pagu_btt_program'=> $jumlah_pagu_btt_program,
              'pagu_bt_program'=> $jumlah_pagu_bt_program,
              'pagu_total_program'=> $jumlah_pagu_total_program,
              'rp_realisasi_bo_program'=> $jumlah_pagu_bo_program ==0 ?'-' : number_format($show_realisasi_bo_program),
              'rp_realisasi_bm_program'=> $jumlah_pagu_bm_program ==0 ?'-' : number_format($show_realisasi_bm_program),
              'rp_realisasi_btt_program'=> $jumlah_pagu_btt_program ==0 ?'-' : number_format($show_realisasi_btt_program),
              'rp_realisasi_bt_program'=> $jumlah_pagu_bt_program ==0 ?'-' : number_format($show_realisasi_bt_program),
              'rp_realisasi_total_program'=> number_format($total_realisasi_program),
              'persen_realisasi_bo_program'=> $jumlah_pagu_bo_program ==0 ? '-' : round($persen_rk_bo_program,2),
              'persen_realisasi_bm_program'=> $jumlah_pagu_bm_program ==0 ? '-' : round($persen_rk_bm_program,2),
              'persen_realisasi_btt_program'=> $jumlah_pagu_btt_program ==0 ? '-' : round($persen_rk_btt_program,2),
              'persen_realisasi_bt_program'=> $jumlah_pagu_bt_program ==0 ? '-' : round($persen_rk_bt_program,2),
              'persen_realisasi_total_program'=> round($persen_rk_total_program,2),
              'total_fisik_program'=> round($ratarata_fisik_program,2),
              'kegiatan'=> $kumpul_kegiatan ,
            ];
            array_push($kumpul_program, $data_program);



      //akhir foreach ($kegiatan as $key => $value_kegiatan) 
    } //akhir foreach ($program as $key => $value) { 

?>
 <!-- </tbody> -->






<table class="font_laporan border table">
  <thead class="header">
    <tr>
    <th rowspan="4"  width="20px">No</th>
    <th rowspan="4">Tahapan APBD</th>
    <th rowspan="4">Program, Kegiatan, Sub Kegiatan</th>
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

<tbody> 
  <?php foreach ($kumpul_program as $k_program => $v_program) { ?>
   <tr style="background: #e8daef">
     <th><?php echo $v_program['no'] ?></th>
     <th>-</th>
     <th align="left"><?php echo $v_program['nama_program'] ?></th>
     <th align="right"><?php echo number_format($v_program['pagu_bo_program']) ?></th>
     <th align="right"><?php echo number_format($v_program['pagu_bm_program']) ?></th>
     <th align="right"><?php echo number_format($v_program['pagu_btt_program']) ?></th>
     <th align="right"><?php echo number_format($v_program['pagu_bt_program']) ?></th>
     <th align="right"><?php echo number_format($v_program['pagu_total_program']) ?></th>




     <th align="right"><?php echo $v_program['rp_realisasi_bo_program'] ?></th>
     <th><?php echo $v_program['persen_realisasi_bo_program'] ?></th>
     <th align="right"><?php echo $v_program['rp_realisasi_bm_program'] ?></th>
     <th><?php echo $v_program['persen_realisasi_bm_program'] ?></th>
     <th align="right"><?php echo $v_program['rp_realisasi_btt_program'] ?></th>
     <th><?php echo $v_program['persen_realisasi_btt_program'] ?></th>
     <th align="right"><?php echo $v_program['rp_realisasi_bt_program'] ?></th>
     <th><?php echo $v_program['persen_realisasi_bt_program'] ?></th>
     <th align="right"><?php echo $v_program['rp_realisasi_total_program'] ?></th>
     <th><?php echo $v_program['persen_realisasi_total_program'] ?></th>
     <th align="center"><?php echo $v_program['total_fisik_program'] ?></th>
   </tr>

    <?php foreach ($v_program['kegiatan'] as $k_kegiatan => $v_kegiatan) { ?>
       <tr style="background: #d6eaf8; ">
         <th><?php echo $v_kegiatan['no'] ?></th>
         <th>-</th>
         <th align="left"><?php echo $v_kegiatan['nama_kegiatan'] ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['pagu_bo_kegiatan']) ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['pagu_bm_kegiatan']) ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['pagu_btt_kegiatan']) ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['pagu_bt_kegiatan']) ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['pagu_total_kegiatan']) ?></th>




         <th align="right"><?php echo $v_kegiatan['rp_realisasi_bo_kegiatan'] ?></th>
         <th><?php echo $v_kegiatan['persen_realisasi_bo_kegiatan'] ?></th>
         <th align="right"><?php echo $v_kegiatan['rp_realisasi_bm_kegiatan'] ?></th>
         <th><?php echo $v_kegiatan['persen_realisasi_bm_kegiatan'] ?></th>
         <th align="right"><?php echo $v_kegiatan['rp_realisasi_btt_kegiatan'] ?></th>
         <th><?php echo $v_kegiatan['persen_realisasi_btt_kegiatan'] ?></th>
         <th align="right"><?php echo $v_kegiatan['rp_realisasi_bt_kegiatan'] ?></th>
         <th><?php echo $v_kegiatan['persen_realisasi_bt_kegiatan'] ?></th>
         <th align="right"><?php echo number_format($v_kegiatan['rp_realisasi_total_kegiatan']) ?></th>
         <th><?php echo $v_kegiatan['persen_realisasi_total_kegiatan'] ?></th>
         <th align="center"><?php echo $v_kegiatan['total_fisik_kegiatan'] ?></th>
       </tr>

       <?php  foreach ($v_kegiatan['sub_kegiatan'] as $k_ski => $v_ski) { ?>
         
         <tr>
           <td><?php echo $v_ski['no'] ?></td>
           <td><?php echo $v_ski['nama_tahap'] ?></td>
           <td><?php echo $v_ski['nama_sub_kegiatan'] ?></td>
           <td align="right"><?php echo number_format($v_ski['pagu_bo_ski']) ?></td>
           <td align="right"><?php echo number_format($v_ski['pagu_bm_ski']) ?></td>
           <td align="right"><?php echo number_format($v_ski['pagu_btt_ski']) ?></td>
           <td align="right"><?php echo number_format($v_ski['pagu_bt_ski']) ?></td>
           <td align="right"><?php echo number_format($v_ski['pagu_total_ski']) ?></td>




           <td align="right"><?php echo $v_ski['rp_realisasi_bo_ski'] ?></td>
           <td align="center"><?php echo round($v_ski['persen_realisasi_bo_ski'],2) ?></td>
           <td align="right"><?php echo $v_ski['rp_realisasi_bm_ski'] ?></td>
           <td align="center"><?php echo round($v_ski['persen_realisasi_bm_ski'],2) ?></td>
           <td align="right"><?php echo $v_ski['rp_realisasi_btt_ski'] ?></td>
           <td align="center"><?php echo round($v_ski['persen_realisasi_btt_ski'],2) ?></td>
           <td align="right"><?php echo $v_ski['rp_realisasi_bt_ski'] ?></td>
           <td align="center"><?php echo round($v_ski['persen_realisasi_bt_ski'],2) ?></td>
           <td align="right"><?php echo number_format($v_ski['rp_realisasi_total_ski']) ?></td>
           <td align="center"><?php echo round($v_ski['persen_realisasi_total_ski'],2) ?></td>
           <td align="center"><?php echo $v_ski['total_fisik_ski'] ?></td>
         </tr>
       <?php } ?>
    <?php } ?>


  <?php } 

$persen_total_realisasi_bo = $total_pagu_bo ==0 ? 0 : ($total_realisasi_bo / $total_pagu_bo)*100 ; 
$persen_total_realisasi_bm = $total_pagu_bm ==0 ? 0 : ($total_realisasi_bm / $total_pagu_bm)*100 ; 
$persen_total_realisasi_btt = $total_pagu_btt ==0 ? 0 : ($total_realisasi_btt / $total_pagu_btt)*100 ; 
$persen_total_realisasi_bt = $total_pagu_bt ==0 ? 0 : ($total_realisasi_bt / $total_pagu_bt)*100 ; 
$persen_total_realisasi_semua = $total_pagu_semua ==0 ? 0 : ($total_realisasi_semua / $total_pagu_semua)*100 ; 

$realisasi_fisik_tercapai = $total_fisik_semua / $total_sub_kegiatan ; 

  ?>
</tbody>
<tfoot>
  <tr>
    <th colspan="3" align="right">Total</th>
    <th align="right"><?php echo number_format($total_pagu_bo) ?></th>
    <th align="right"><?php echo number_format($total_pagu_bm) ?></th>
    <th align="right"><?php echo number_format($total_pagu_btt) ?></th>
    <th align="right"><?php echo number_format($total_pagu_bt) ?></th>
    <th align="right"><?php echo number_format($total_pagu_semua) ?></th>
    <th align="right"><?php echo number_format($total_realisasi_bo) ?></th>
    <th><?php echo round($persen_total_realisasi_bo,2) ?></th>
    <th align="right"><?php echo number_format($total_realisasi_bm) ?></th>
    <th><?php echo round($persen_total_realisasi_bm,2) ?></th>
    <th align="right"><?php echo number_format($total_realisasi_btt) ?></th>
    <th><?php echo round($persen_total_realisasi_btt,2) ?></th>
    <th align="right"><?php echo number_format($total_realisasi_bt) ?></th>
    <th><?php echo round($persen_total_realisasi_bt,2) ?></th>
    <th align="right"><?php echo number_format($total_realisasi_semua) ?></th>
    <th align="center"><?php echo round($persen_total_realisasi_semua,2) ?></th>
    <th align="center"><?php echo round($realisasi_fisik_tercapai,2) ?></th>
  </tr>
</tfoot>
</table>

<?php echo  
$controller = $this->router->fetch_class(); ?>
</body>