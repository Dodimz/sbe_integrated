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


   <?php 
  $no_program   = 0;
  $total_pagu_sub_kegiatan_instansi = 0;
  $total_pad    = 0;
  $total_dau    = 0;
  $total_dak    = 0;
  $total_dbh    = 0;
  $total_lainnya  = 0;
  $total_target_fisik = 0;
  $total_sub_kegiatan = 0;

  $kumpul_program = [];

  foreach ($program as $key => $value) { 
  $pagu_program   = 0;
    $no_program++;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
  
    <?php 
    $no_kegiatan=0;
    $total_pad_program  =0;
    $total_dau_program  =0;
    $total_dak_program  =0;
    $total_dbh_program  =0;
    $total_lainnya_program  =0;
    $kumpul_kegiatan = [];
    foreach ($kegiatan as $key => $value_kegiatan) {
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
      $pagu_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();
    ?>
   
     <?php 
      $total_pad_kegiatan  =0;
      $total_dau_kegiatan  =0;
      $total_dak_kegiatan  =0;
      $total_dbh_kegiatan  =0;
      $total_lainnya_kegiatan  =0;
     $kumpul_sub_kegiatan = [];
     foreach ($sub_kegiatan as $key => $value_sk) {

      $pagu_kegiatan +=$value_sk->pagu;
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

          $total_pad_kegiatan    += isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0;
          $total_dau_kegiatan    += isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0;
          $total_dak_kegiatan    += isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0;
          $total_dbh_kegiatan    += isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0;
          $total_lainnya_kegiatan  += isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0;

          $total_sumber_dana = $sumber_dana['pad'] + $sumber_dana['dau'] + $sumber_dana['dak'] + $sumber_dana['dbh'] + $sumber_dana['lainnya'];
      
           $data_kumpul_sub_kegiatan = [
          'no'=> $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan,
          'kode_rekening_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
          'nama_sub_kegiatan'=> $nama_sub_kegiatan,
          'pagu_sub_kegiatan'=> $value_sk->pagu,
          'pad'=> $sumber_dana['pad']=='' ? 0 : $sumber_dana['pad'],
          'dau'=> $sumber_dana['dau']=='' ? 0 : $sumber_dana['dau'],
          'dak'=> $sumber_dana['dak']=='' ? 0 : $sumber_dana['dak'],
          'dbh'=> $sumber_dana['dbh']=='' ? 0 : $sumber_dana['dbh'],
          'lainnya'=> $sumber_dana['lainnya']=='' ? 0 : $sumber_dana['lainnya'],
          'ket_lainnya'=> $sumber_dana['lainnya']==0 ? '' : $sumber_dana['nama_sumber_dana_lainnya'],
          'total'=> $total_sumber_dana,
         ];

         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);

      ?>
  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)


          $total_sumber_dana_kegiatan = $total_pad_kegiatan + $total_dau_kegiatan + $total_dak_kegiatan + $total_dbh_kegiatan + $total_lainnya_kegiatan ;

          $pagu_program += $pagu_kegiatan;
          $total_pad_program += $total_pad_kegiatan;
          $total_dau_program += $total_dau_kegiatan;
          $total_dak_program += $total_dak_kegiatan;
          $total_dbh_program += $total_dbh_kegiatan;
          $total_lainnya_program += $total_lainnya_kegiatan;

          $data_kumpul_kegiatan = [
          'no'=> $no_program.'.'.$no_kegiatan,
          'kode_rekening_kegiatan'=> $value_kegiatan->kode_rekening_kegiatan,
          'nama_kegiatan'=> $value_kegiatan->nama_kegiatan,
          'pagu_kegiatan'=> $pagu_kegiatan,
          'pad'=> $total_pad_kegiatan,
          'dau'=> $total_dau_kegiatan,
          'dak'=> $total_dak_kegiatan,
          'dbh'=> $total_dbh_kegiatan,
          'lainnya'=> $total_lainnya_kegiatan,
          'ket_lainnya'=> '',
          'total'=> $total_sumber_dana_kegiatan,
          'data_sub_kegiatan' =>$kumpul_sub_kegiatan,
         ];

         array_push($kumpul_kegiatan, $data_kumpul_kegiatan);

      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 


       $total_sumber_dana_program = $total_pad_program + $total_dau_program + $total_dak_program + $total_dbh_program + $total_lainnya_program ;

          // $total_pad_program += $total_pad_program;
          // $total_dau_program += $total_dau_program;
          // $total_dak_program += $total_dak_program;
          // $total_dbh_program += $total_dbh_program;
          // $total_lainnya_program += $total_lainnya_program;

          $data_kumpul_program = [
          'no'=> $no_program,
          'kode_rekening_program'=> $value->kode_rekening_program,
          'nama_program'=> $value->nama_program,
          'pagu_program'=> $pagu_program,
          'pad'=> $total_pad_program,
          'dau'=> $total_dau_program,
          'dak'=> $total_dak_program,
          'dbh'=> $total_dbh_program,
          'lainnya'=> $total_lainnya_program,
          'ket_lainnya'=> '',
          'total'=> $total_sumber_dana_program,
          'data_kegiatan' =>$kumpul_kegiatan,
         ];

         array_push($kumpul_program, $data_kumpul_program);
    } //akhir foreach ($program as $key => $value) { 
?>
 <!-- </tbody> -->


<table class="font_laporan border table">
 <thead class="header">
   <tr>
    <th rowspan="3"  width="30px">No</th>
    <th colspan="3" >Program, Kegiatan, Sub Kegiatan</th>
    <th colspan="7">Sumber Dana (Rp.)</th>
   
  </tr>
  <tr>

    <th rowspan="2">Kode Rekening</th>
    <th rowspan="2">Uraian</th>
    <th rowspan="2" style="width:80px">Pagu</th>
    <th rowspan="2" style="width:80px">PAD</th>
    <th rowspan="2" style="width:80px">DAU</th>
    <th rowspan="2" style="width:80px">DAK</th>
    <th rowspan="2" style="width:80px">DBH</th>
    <th colspan="2" style="width:80px">Lainnya</th>
    <th rowspan="2" style="width:80px">Total</th>
  </tr>
  <tr>
  
    <th style="width:80px">Rp.</th>
    <th style="width:35px">Keterangan</th>
  </tr>
  <tr>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6</th>
    <th>7</th>
    <th>8</th>
    <th>9</th>
    <th>10</th>
    <th>11=5+6+7+8+9</th>
  </tr>
    
 </thead>

<tbody>
  <?php foreach ($kumpul_program as $k_program => $v_program) { ?>

  <tr  style="background: #e8daef">
   <th align="left"> <?php echo $v_program['no'] ?></th>
    <th align="left"> <?php echo $v_program['kode_rekening_program'] ?></th>
    <th align="left"> <?php echo $v_program['nama_program'] ?></th>
    <th align="right"> <?php echo number_format($v_program['pagu_program']) ?></th>
    <th align="right"> <?php echo number_format($v_program['pad']) ?></th>
    <th align="right"> <?php echo number_format($v_program['dau']) ?></th>
    <th align="right"> <?php echo number_format($v_program['dak']) ?></th>
    <th align="right"> <?php echo number_format($v_program['dbh']) ?></th>
    <th align="right"> <?php echo number_format($v_program['lainnya']) ?></th>
    <th></th>
    <th align="right"> <?php echo number_format($v_program['total']) ?></th>
  </tr>
  <?php 

  foreach ($v_program['data_kegiatan'] as $k_kegiatan => $v_kegiatan) { ?>
     <tr  style="background: #d6eaf8 ">
       <th align="left"> <?php echo $v_kegiatan['no'] ?></th>
        <th align="left"> <?php echo $v_kegiatan['kode_rekening_kegiatan'] ?></th>
        <th align="left"> <?php echo $v_kegiatan['nama_kegiatan'] ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['pagu_kegiatan']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['pad']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['dau']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['dak']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['dbh']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['lainnya']) ?></th>
        <th></th>
        <th align="right"> <?php echo number_format($v_kegiatan['total']) ?></th>
      </tr>
  <?php 
      foreach ($v_kegiatan['data_sub_kegiatan'] as $k_sk => $v_sk) { ?>
        <tr>
         <td align="left"> <?php echo $v_sk['no'] ?></td>
          <td align="left"> <?php echo $v_sk['kode_rekening_sub_kegiatan'] ?></td>
          <td align="left"> <?php echo $v_sk['nama_sub_kegiatan'] ?></td>
          <td align="right"> <?php echo number_format($v_sk['pagu_sub_kegiatan']) ?></td>
          <td align="right"> <?php echo number_format($v_sk['pad']) ?></td>
          <td align="right"> <?php echo number_format($v_sk['dau']) ?></td>
          <td align="right"> <?php echo number_format($v_sk['dak']) ?></td>
          <td align="right"> <?php echo number_format($v_sk['dbh']) ?></td>
          <td align="right"> <?php echo number_format($v_sk['lainnya']) ?></td>
          <td><?php echo $v_sk['ket_lainnya'] ?></td>
          <td align="right"> <?php echo number_format($v_sk['total']) ?></td>
        </tr>
       
  <?php     
      }
    } 
  }
?>
</tbody>
  <tfoot>
    <tr>
      <th colspan="3">Total</th>
      
     <th align="right"><?php echo number_format($total_pagu_sub_kegiatan_instansi) ?></th>
        <th align="right"><?php echo number_format($total_pad) ?></th>
     <th align="right"><?php echo number_format($total_dau) ?></th>
     <th align="right"><?php echo number_format($total_dak) ?></th>
     <th align="right"><?php echo number_format($total_dbh) ?></th>
     <th align="right"><?php echo number_format($total_lainnya) ?></th>
     <th> - </th>
     <th align="right"> 
      <?php   
          $total_sumber_dana_semuanya = $total_pad + $total_dau + $total_dak + $total_dbh + $total_lainnya ;
          echo number_format($total_sumber_dana_semuanya);
       ?>
      </th>    </tr>
  </tfoot>
</table>



</body>