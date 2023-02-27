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
    font-size:15px;
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

  .center{
    text-align: center;
  }
</style>

<head>
  <title><?php echo $judul_laporan ?></title>
</head>


<body>

<table class="font_laporan border">
  <tr>
    <th rowspan="2">No</th>
    <th rowspan="2">SKPD</th>
    <th rowspan="2">Helpdesk</th>
    <th rowspan="2">Total paket</th>
    <th rowspan="2">Total evidence di upload</th>
    <th colspan="2"  style="background:  #f1f5fe ">Total evidence belum di periksa</th>
    <th rowspan="2">Total evidence di setujui</th>
    <th rowspan="2">Total evidence di tolak</th>
  </tr>
  <tr  style="background:  #f1f5fe ">
    <th>Swakelola</th>
    <th>Penyedia</th>
  </tr>

  <?php 
  $no = 0;

$total_program = 0;
$total_kegiatan = 0;
$total_sub_kegiatan = 0;
$total_paket = 0;
$total_evidence_diupload = 0;
$total_evidence_belum_validasi_swakelola = 0;
$total_evidence_belum_validasi_penyedia = 0;
$total_evidence_approve = 0;
$total_evidence_reject = 0;



  foreach ($skpd as $k => $v ) { 
    $no++;
    if ($v['is_active']=='0') {
      $css = 'style="background:#fee4df"';
    }else{
      $css = '';

    }



    if ($v['total_evidence_belum_validasi_swakelola']==0) {
      $background_swa = 'style="background: #d5f5e3"';
    }
    elseif ($v['total_evidence_belum_validasi_swakelola']>100) {
      $background_swa = 'style="background#f8b2b2"';
    }else{
      $background_swa = 'style="background:#fcf3cf"';
    }
    if ($v['total_evidence_belum_validasi_penyedia']==0) {
      $background_pen = 'style="background: #d5f5e3"';
    }
    elseif ($v['total_evidence_belum_validasi_penyedia']>100) {
      $background_pen = 'style="background:#f8b2b2"';
    }else{
      $background_pen = 'style="background:#fcf3cf"';
    }


    ?>
   <tr <?php echo $css ?>>
    <td><?php echo $no ?></td>
    <td><?php echo $v['nama_instansi'] ?></td>
    <td><?php echo $v['helpdesk'] ?></td>
    <td class="center"><?php echo $v['total_paket'] ?></td>
    <td class="center"><?php echo $v['total_evidence_diupload'] ?></td>
    <td class="center" <?php echo $background_swa ?>><?php echo $v['total_evidence_belum_validasi_swakelola'] ?></td>
    <td class="center" <?php echo $background_pen ?>><?php echo $v['total_evidence_belum_validasi_penyedia'] ?></td>
    <td class="center"><?php echo $v['total_evidence_approve'] ?></td>
    <td class="center"><?php echo $v['total_evidence_reject'] ?></td>
   
  </tr>
  <?php 
$total_program += $v['total_program'];
$total_kegiatan += $v['total_kegiatan'];
$total_sub_kegiatan += $v['total_sub_kegiatan'];
$total_paket += $v['total_paket'];
$total_evidence_diupload += $v['total_evidence_diupload'];
$total_evidence_belum_validasi_swakelola += $v['total_evidence_belum_validasi_swakelola'];
$total_evidence_belum_validasi_penyedia += $v['total_evidence_belum_validasi_penyedia'];
$total_evidence_approve += $v['total_evidence_approve'];
$total_evidence_reject += $v['total_evidence_reject'];

} 



    if ($total_evidence_belum_validasi_swakelola==0) {
      $background_swa_total = 'style="background: #d5f5e3"';
    }
    elseif ($total_evidence_belum_validasi_swakelola>500) {
      $background_swa_total = 'style="background#f8b2b2"';
    }else{
      $background_swa_total = 'style="background:#fcf3cf"';
    }
    if ($total_evidence_belum_validasi_penyedia==0) {
      $background_pen_total = 'style="background: #d5f5e3"';
    }
    elseif ($total_evidence_belum_validasi_penyedia>500) {
      $background_pen_total = 'style="background:#f8b2b2"';
    }else{
      $background_pen_total = 'style="background:#fcf3cf"';
    }

    ?>
  <tr>
    <td class="center" colspan="3">Total</td>
    <td class="center"><?php echo $total_paket; ?></td>
    <td class="center"><?php echo $total_evidence_diupload; ?></td>
    <td class="center" <?php echo $background_swa_total ?>><?php echo $total_evidence_belum_validasi_swakelola; ?></td>
    <td class="center" <?php echo $background_pen_total ?>><?php echo $total_evidence_belum_validasi_penyedia; ?></td>
    <td class="center"><?php echo $total_evidence_approve; ?></td>
    <td class="center"><?php echo $total_evidence_reject; ?></td>
  </tr>
</table>

</body>