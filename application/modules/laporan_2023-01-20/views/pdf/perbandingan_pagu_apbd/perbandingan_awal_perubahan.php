   <?php 
  $no_program   = 0;
  $pagu_program   = 0;

  
  $kumpul_program = [];



  $total_pagu_awal =0;
  $total_pagu_perubahan =0;
  foreach ($program as $key => $value) { 
    $total_program +=1;
    $no_program++;
    // $pagu_program += $value->pagu;
    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result(); ?>
  
    <?php 
    $no_kegiatan=0;
    $kumpul_kegiatan = [];
     $pagu_program_awal = 0;
     $pagu_program_perubahan = 0;
   
    foreach ($kegiatan as $key => $value_kegiatan) {
      $total_kegiatan +=1;
      $banyak_kegiatan +=1;
      $no_kegiatan++;
      $no_sub_kegiatan = 0;
        $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan_perbandingan_tahapan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan);
    ?>
    
     <?php 
     $kumpul_sub_kegiatan = [];
     $pagu_kegiatan_awal = 0;
     $pagu_kegiatan_perubahan = 0;



     foreach ($sub_kegiatan->result() as $key => $value_sk) {
      $banyak_sub_kegiatan +=1;
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;
      $kategori_sub_kegiatan = $value_sk->kategori;
      $tahap = $value_sk->kode_tahap;
      $tahun = $value_sk->tahun;
      $kode_sub_kegiatan = $value_sk->kode_rekening_sub_kegiatan;
      $total_pagu_sub_kegiatan_instansi +=$value_sk->pagu ;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }


          $pagu_awal = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($kode_sub_kegiatan,2, $id_instansi, 'total')->row_array()['pagu_total'];
          $pagu_perubahan = $this->realisasi_akumulasi_model->total_pagu_sub_kegiatan($kode_sub_kegiatan,4, $id_instansi, 'total')->row_array()['pagu_total'];



          if ($pagu_perubahan==0) {
              $cek_kegiatan_perubahan = $this->db->query("SELECT * from sub_kegiatan_instansi where id_instansi='$id_instansi' and tahun = '$tahun' and status=1 and kode_sub_kegiatan='$kode_sub_kegiatan'");
            if ($cek_kegiatan_perubahan->num_rows()==0) {
              $pagu_perubahan = 0 ; 
              # code...
            }else{
              $pagu_perubahan = $pagu_awal ; 

            }
          }else{
            $pagu_perubahan = $pagu_perubahan ; 

          }
          $selisih_pagu = $pagu_perubahan -  $pagu_awal;

          $pagu_kegiatan_awal += $pagu_awal;        
          $pagu_kegiatan_perubahan += $pagu_perubahan;  


          $total_pagu_awal += $pagu_awal;        
          $total_pagu_perubahan += $pagu_perubahan;        


      ?>
     

       <?php 

         $data_kumpul_sub_kegiatan = [
          'no'=> $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan,
          'kode_tahap'=> $value_sk->kode_tahap,
          'kode_rekening_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
          'nama_sub_kegiatan'=> $nama_sub_kegiatan,
          'pagu_awal'=> $pagu_awal,
          'pagu_perubahan'=> $pagu_perubahan,
          'selisih_pagu'=> $selisih_pagu,
         ];
         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);

       ?>


  <?php 
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)


        $selisih_pagu_kegiatan = $pagu_kegiatan_perubahan -  $pagu_kegiatan_awal;

          $pagu_program_awal += $pagu_kegiatan_awal;        
          $pagu_program_perubahan += $pagu_kegiatan_perubahan;  



        $data_kegiatan = [
           'no'=>  $no_program.'.'.$no_kegiatan,
          'kode_rekening_kegiatan'=> $value_kegiatan->kode_rekening_kegiatan,
          'nama_kegiatan'=> $value_kegiatan->nama_kegiatan,
          'pagu_kegiatan_awal'=> $pagu_kegiatan_awal,
          'pagu_kegiatan_perubahan'=> $pagu_kegiatan_perubahan,
          'selisih_pagu_kegiatan'=> $selisih_pagu_kegiatan,
          'data_sub_kegiatan' =>$kumpul_sub_kegiatan,
        ];
       array_push($kumpul_kegiatan, $data_kegiatan);
      } //akhir foreach ($kegiatan as $key => $value_kegiatan) 


      $selisih_pagu_program = $pagu_program_perubahan - $pagu_program_awal;
      $data_program = [
           'no'=> $no_program,
          'kode_rekening_program'=> $value->kode_rekening_program,
          'nama_program'=> $value->nama_program,

          'pagu_program_awal'=> $pagu_program_awal,
          'pagu_program_perubahan'=> $pagu_program_perubahan,
          'selisih_pagu_program'=> $selisih_pagu_program,
          'data_kegiatan' =>$kumpul_kegiatan,
        ];

        array_push($kumpul_program, $data_program);



    } //akhir foreach ($program as $key => $value) { 
      

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
    <th rowspan="2"  width="30px">No</th>
    <th colspan="2" >Program, Kegiatan, Sub Kegiatan</th>
    <!-- <th rowspan="3" style="width:80px">Pagu Anggaran</th> -->
    <th>APBD AWAL</th>
    <th>APBD PERUBAHAN </th>
    <th>Bertambah / Berkurang</th>
   

    

     ?>
   

   
  </tr>
  <tr>
    <th  style="width:85px"><?php echo $id_instansi ?> Kode Rekening</th>
    <th>Uraian</th>
    <th style="width:80px">Rp</th>
    <th style="width:80px">Rp</th>
    <th style="width:80px">Rp</th>
  </tr>
  <tr>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6=5-4</th>
  </tr>

 </thead>
 <tbody>
  
  <?php 


   foreach ($kumpul_program as $k_program => $v_program) { 

   

    ?>
  <tr style="background: #e8daef">
    <th align="left"> <?php echo $v_program['no'] ?></th>
    <th align="left"> <?php echo $v_program['kode_rekening_program'] ?></th>
    <th align="left"> <?php echo $v_program['nama_program'] ?></th>
        <th align="right"> <?php echo number_format($v_program['pagu_program_awal']) ?></th>
        <th align="right"> <?php echo number_format($v_program['pagu_program_perubahan']) ?></th>
        <th align="right"> <?php echo number_format($v_program['selisih_pagu_program']) ?></th>

  </tr>



<?php 
    foreach ($v_program['data_kegiatan'] as $k_kegiatan => $v_kegiatan) { 
      
      ?>

       <tr style="background: #d6eaf8 ">
        <th align="left"> <?php echo $v_kegiatan['no'] ?></th>
        <th align="left"> <?php echo $v_kegiatan['kode_rekening_kegiatan'] ?></th>
        <th align="left"> <?php echo $v_kegiatan['nama_kegiatan'] ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['pagu_kegiatan_awal']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['pagu_kegiatan_perubahan']) ?></th>
        <th align="right"> <?php echo number_format($v_kegiatan['selisih_pagu_kegiatan']) ?></th>
      </tr>
<?php  
      foreach ($v_kegiatan['data_sub_kegiatan'] as $k_ski => $v_sub_kegiatan) { ?>
          <tr>
            <td> <?php echo $v_sub_kegiatan['no'] ?></td>
            <td> <?php echo $v_sub_kegiatan['kode_rekening_sub_kegiatan'] ?></td>
            <td> <?php echo $v_sub_kegiatan['nama_sub_kegiatan'] ?></td>
            <td align="right"> <?php echo number_format($v_sub_kegiatan['pagu_awal']) ?></td>
            <td align="right"> <?php echo number_format($v_sub_kegiatan['pagu_perubahan']) ?></td>
            <td align="right"> <?php echo number_format($v_sub_kegiatan['selisih_pagu']) ?></td>
          
          </tr>


<?php 
     }
   } //end kegiatan
} //end program


$total_pagu_sisa = $total_pagu_perubahan - $total_pagu_awal; 
?>
</tbody>
<tfoot>



   <tr>
     <th colspan="3" align="center">Total</th>
     <th align="right"> <?php echo number_format($total_pagu_awal)   ?> </th>
            <th align="right"> <?php echo number_format($total_pagu_perubahan)  ?> </th>
            <th align="right"> <?php echo number_format($total_pagu_sisa)  ?> </th>
   </tr>

  

</tfoot>
</table>


</table>
