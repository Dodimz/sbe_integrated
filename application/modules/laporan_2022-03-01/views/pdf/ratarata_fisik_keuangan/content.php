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

 $bg_rea_fisik = $realisasi=='fisik' ? 'background: #e5e8e8 ' :'';
        $bg_rea_keuangan = $realisasi=='keu' ? 'background: #e5e8e8 ' :'';

    ?>


  <h4 class="judul_laporan"><?php echo  $kelompok.'<br>'.$caption_realisasi ?></h4>

  <table class="font_laporan">
    <thead class="tabel_header">      
      <tr class="tabel_header">
        <th rowspan="2" style="width:40px"h>No</th>
        <th rowspan="2">SKPD</th>
        <?php if ($realisasi=='fisik') { ?>
        <th colspan="3">Fisik</th>
      <?php } 
      elseif ($realisasi=='keu') { ?>
        <th colspan="3">Keuangan</th>
        <?php } 
      else{ ?>
        <th colspan="3">Fisik</th>
        <th colspan="3">Keuangan</th>
        <?php } ?>
      </tr>
      <tr>
         <?php if ($realisasi=='fisik' || $realisasi=='keu') { ?>
        <th style="width:40px">Target</th>
        <th style="width:40px">Realisasi</th>
        <th style="width:40px">Deviasi</th>
        <?php }else{  ?>
        <th style="width:40px">Target</th>
        <th style="width:40px">Realisasi</th>
        <th style="width:40px">Deviasi</th>
        <th style="width:40px">Target</th>
        <th style="width:40px">Realisasi</th>
        <th style="width:40px">Deviasi</th>
      <?php } ?>
      </tr>
    </thead>
    <tbody >
      <?php
        $no = 0;
       
          $total_t_fisik_satu    = 0;
          $total_t_keu_satu      = 0;
          $total_r_fisik_satu    = 0;
          $total_r_keu_satu      = 0;
          $total_tertimbang_satu = 0;
          $jml_skpd_satu         = 0;
       foreach ($skpd as $v) { 
          $total_t_fisik_satu    += $v['tf'];
            $total_t_keu_satu      += $v['tk'];
            $total_r_fisik_satu    += $v['rf'];
            $total_r_keu_satu      += $v['rk'];
            $jml_skpd_satu++;
        $no++;
        ?>
         <tr>
          <td align="center"><?php echo $no ?></td>
          <td><?php echo $v['nama_instansi'] ?></td>
             <?php if ($realisasi=='fisik') { ?>
              <td class="rata_kanan"><?php echo $v['tf'] ?></td>
              <td class="rata_kanan" style="<?php echo $bg_rea_fisik ?>"><?php echo $v['rf'] ?></td>
              <td class="rata_kanan" style="<?php echo $v['wf'] ?>"><?php echo $v['df'] ?></td>
          <?php } 
          elseif ($realisasi=='keu') { ?>
            <td class="rata_kanan"><?php echo $v['tk'] ?></td>
            <td class="rata_kanan" style="<?php echo $bg_rea_keuangan ?>"><?php echo $v['rk'] ?></td>
            <td class="rata_kanan" style="<?php echo $v['wk'] ?>"><?php echo $v['dk'] ?></td>
            <?php } 
          else{ ?>
             <td class="rata_kanan"><?php echo $v['tf'] ?></td>
          <td class="rata_kanan" style="<?php echo $bg_rea_fisik ?>"><?php echo $v['rf'] ?></td>
          <td class="rata_kanan" style="<?php echo $v['wf'] ?>"><?php echo $v['df'] ?></td>
          <td class="rata_kanan"><?php echo $v['tk'] ?></td>
          <td class="rata_kanan" style="<?php echo $bg_rea_keuangan ?>"><?php echo $v['rk'] ?></td>
          <td class="rata_kanan" style="<?php echo $v['wk'] ?>"><?php echo $v['dk'] ?></td>
            <?php } ?>
        
          
         
        </tr>
       <?php } 
          @$total_t_fisik_satu    =  round($total_t_fisik_satu / $jml_skpd_satu, 2); 
          @$total_r_fisik_satu   =  round($total_r_fisik_satu / $jml_skpd_satu, 2); 
          @$total_dev_fisik_satu = $total_r_fisik_satu - $total_t_fisik_satu ;
          @$total_t_keu_satu   =  round($total_t_keu_satu / $jml_skpd_satu, 2); 
          @$total_r_keu_satu   =  round($total_r_keu_satu / $jml_skpd_satu, 2);
          @$total_dev_keu_satu = $total_r_keu_satu - $total_t_keu_satu ;



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
          ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"><b>Rata -Rata</b></td>
         <?php if ($realisasi=='fisik') { ?>
        <td class="rata_kanan"><?php echo $total_t_fisik_satu; ?></td>
        <td class="rata_kanan"><?php echo $total_r_fisik_satu; ?></td>
        <td class="rata_kanan" style="<?php echo $warna_peringatan_total_dev_fisik ?>"><?php echo $total_dev_fisik_satu; ?></td>
      <?php } 
      elseif ($realisasi=='keu') { ?>
         <td class="rata_kanan"><?php echo $total_t_keu_satu; ?></td>
        <td class="rata_kanan"><?php echo $total_r_keu_satu; ?></td>
        <td class="rata_kanan" style="<?php echo $warna_peringatan_total_dev_keu ?>"><?php echo $total_dev_keu_satu; ?></td>
        <?php } 
      else{ ?>
        <td class="rata_kanan"><?php echo $total_t_fisik_satu; ?></td>
        <td class="rata_kanan"><?php echo $total_r_fisik_satu; ?></td>
        <td class="rata_kanan" style="<?php echo $warna_peringatan_total_dev_fisik ?>"><?php echo $total_dev_fisik_satu; ?></td>
        <td class="rata_kanan"><?php echo $total_t_keu_satu; ?></td>
        <td class="rata_kanan"><?php echo $total_r_keu_satu; ?></td>
        <td class="rata_kanan" style="<?php echo $warna_peringatan_total_dev_keu ?>"><?php echo $total_dev_keu_satu; ?></td>
        <?php } ?>

        
        
       
      </tr>
    </tfoot>
   
  </table>

  <div class="font_laporan">
<br><br>
<u>Keterangan</u> <br>
  T : Target <br>
  R : Realisasi <br>
  D : Deviasi
</div>