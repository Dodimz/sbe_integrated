<style>
  .font_laporan{
    font-size:9px;
    font-family: 'arial';
  }
  .judul_laporan{
    font-size:12px;
    font-family: 'arial';
    text-align : center;
  }
  table {
    
    border-collapse: collapse;
    width:100%;
}
table td, th {
    border: 0.01em solid ;
    padding:3px;

}

  .rata_kanan{
    text-align : right;

  }

  .tabel_header{
    font-weight:bold;
    text-align : center;
    font-size:9px;

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
</style>

<?php 
  // $total_peringatan_dev_fisik_merah = 0;
  //  $total_peringatan_dev_fisik_kuning = 0;
  //  $total_peringatan_dev_fisik_hijau = 0;
  //  $total_peringatan_dev_keu_merah = 0;
  //  $total_peringatan_dev_keu_kuning = 0;
  //  $total_peringatan_dev_keu_hijau = 0;

 $bg_rea_fisik =  '';//$realisasi=='fisik' ? 'background: #e5e8e8 ' :'';
        $bg_rea_keuangan = '';// $realisasi=='keu' ? 'background: #e5e8e8 ' :'';

    ?>


  <h4 class="judul_laporan"><?php echo  "Data Kelompok Pagu dan Realisasi SKPD Berdasarkan Jenis Belanja" ?></h4>

  <table class="font_laporan">
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
    <tbody >
      <?php
        $no = 0;
       
       $total_pagu_bo = 0 ;
       $total_pagu_bm = 0 ;
       $total_pagu_btt = 0 ;
       $total_pagu_bt = 0 ;
       $total_pagu_semua = 0 ;

       $total_realisasi_bo = 0 ;
       $total_realisasi_bm = 0 ;
       $total_realisasi_btt = 0 ;
       $total_realisasi_bt = 0 ;
       $total_realisasi_semua = 0 ;
       foreach ($skpd as $v) { 
       $total_pagu_bo += $v['pagu_bo'] ;
       $total_pagu_bm += $v['pagu_bm'] ;
       $total_pagu_btt += $v['pagu_btt'] ;
       $total_pagu_bt += $v['pagu_bt'] ;
       $total_pagu_semua += $v['pagu_total'] ;

       $total_realisasi_bo += $v['rp_realisasi_keuangan_bo'] ;
       $total_realisasi_bm += $v['rp_realisasi_keuangan_bm'] ;
       $total_realisasi_btt += $v['rp_realisasi_keuangan_btt'] ;
       $total_realisasi_bt += $v['rp_realisasi_keuangan_bt'] ;
       $total_realisasi_semua += $v['rp_realisasi_keuangan'] ;

         
        $no++;
        ?>
         <tr>
          <td align="center"><?php echo $no ?></td>
          <td><?php echo $v['nama_instansi'] ?></td>
          
          <td align="right"><?php echo number_format($v['pagu_bo']) ?></td>
          <td align="right"><?php echo number_format($v['pagu_bm']) ?></td>
          <td align="right"><?php echo number_format($v['pagu_btt']) ?></td>
          <td align="right"><?php echo number_format($v['pagu_bt']) ?></td>
          <td align="right"><?php echo number_format($v['pagu_total']) ?></td>

          <?php 
$persen_r_bo= $v['pagu_bo']==0 ? 0 : $v['rp_realisasi_keuangan_bo'] / $v['pagu_bo'] * 100;
$persen_r_bm= $v['pagu_bm']==0 ? 0 : $v['rp_realisasi_keuangan_bm'] / $v['pagu_bm'] * 100;
$persen_r_btt= $v['pagu_btt']==0 ? 0 : $v['rp_realisasi_keuangan_btt'] / $v['pagu_btt'] * 100;
$persen_r_bt= $v['pagu_bt']==0 ? 0 : $v['rp_realisasi_keuangan_bt'] / $v['pagu_bt'] * 100;
$persen_r_total= $v['pagu_total']==0 ? 0 : $v['rp_realisasi_keuangan'] / $v['pagu_total'] * 100;
           ?>


          <td align="right"><?php echo number_format($v['rp_realisasi_keuangan_bo']) ?></td>
          <td align="center"><?php echo round($persen_r_bo,2) ?></td>
          <td align="right"><?php echo number_format($v['rp_realisasi_keuangan_bm']) ?></td>
          <td align="center"><?php echo round($persen_r_bm,2) ?></td>
          <td align="right"><?php echo number_format($v['rp_realisasi_keuangan_btt']) ?></td>
          <td align="center"><?php echo round($persen_r_btt,2) ?></td>
          <td align="right"><?php echo number_format($v['rp_realisasi_keuangan_bt']) ?></td>
          <td align="center"><?php echo round($persen_r_bt,2) ?></td>
          <td align="right"><?php echo number_format($v['rp_realisasi_keuangan']) ?></td>
          <td align="center"><?php echo round($persen_r_total,2) ?></td>
        
         
            
        
          <td class="rata_kanan" ><?php echo $v['rf'] ?></td>
         
        </tr>
       <?php } 
        
          ?>
    </tbody>
    <tfoot>


      <?php 
      $persen_r_bo_semua = $total_pagu_bo ==0 ? 0 : ($total_realisasi_bo / $total_pagu_bo) * 100;
$persen_r_bm_semua = $total_pagu_bm ==0 ? 0 : ($total_realisasi_bm / $total_pagu_bm) * 100;
$persen_r_btt_semua = $total_pagu_btt ==0 ? 0 : ($total_realisasi_btt / $total_pagu_btt) * 100;
$persen_r_bt_semua = $total_pagu_bt ==0 ? 0 : ($total_realisasi_bt / $total_pagu_bt) * 100;
$persen_r_total_semua = $total_pagu_semua ==0 ? 0 : ($total_realisasi_semua / $total_pagu_semua) * 100;

 ?>
      <tr>
        <td colspan="2"><b>Total / Rata -Rata</b></td>
          
        <td class="rata_kanan"><?php echo number_format($total_pagu_bo); ?></td>
        <td class="rata_kanan"><?php echo number_format($total_pagu_bm); ?></td>
        <td class="rata_kanan"><?php echo number_format($total_pagu_btt); ?></td>
        <td class="rata_kanan"><?php echo number_format($total_pagu_bt); ?></td>
        <td class="rata_kanan"><?php echo number_format($total_pagu_semua); ?></td>
          
        <td class="rata_kanan"><?php echo number_format($total_realisasi_bo); ?></td>
        <td align="center"><?php echo round($persen_r_bo_semua,2) ?></td>
        <td class="rata_kanan"><?php echo number_format($total_realisasi_bm); ?></td>
        <td align="center"><?php echo round($persen_r_bm_semua,2) ?></td>
        <td class="rata_kanan"><?php echo number_format($total_realisasi_btt); ?></td>
        <td align="center"><?php echo round($persen_r_btt_semua,2) ?></td>
        <td class="rata_kanan"><?php echo number_format($total_realisasi_bt); ?></td>
        <td align="center"><?php echo round($persen_r_bt_semua,2) ?></td>
        <td class="rata_kanan"><?php echo number_format($total_realisasi_semua); ?></td>
        <td align="center"><?php echo round($persen_r_total_semua,2) ?></td>

        <td align="center">??</td>



       

      
        
        
       
      </tr>
    </tfoot>
   
  </table>
