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
    <th rowspan="2">Pagu Total</th>
    <th rowspan="2">Total program</th>
    <th rowspan="2">Total kegiatan</th>
    <th rowspan="2">Total sub kegiatan</th>
    <th colspan="4">Total Paket</th>
    <th rowspan="2">Total Kontrak</th>
  </tr>
  <tr>
    <th>Non Urusan</th>
    <th>Swakelola</th>
    <th>Penyedia</th>
    <th>Total</th>
  </tr>

  <?php 
  $no = 0;

$total_program = 0;
$total_kegiatan = 0;
$total_sub_kegiatan = 0;
$total_paket_rutin = 0;
$total_paket_swakelola = 0;
$total_paket_penyedia = 0;
$total_paket_semua = 0;
$total_pagu = 0;
$total_kontrak = 0;



  foreach ($skpd as $k => $v ) { 
    $no++;
    if ($v['is_active']=='0') {
      $css = 'style="background:#fee4df"';
    }else{
      $css = '';

    }
  

    ?>
   <tr <?php echo $css ?>>
    <td><?php echo $no ?></td>
    <td><?php echo $v['nama_instansi'] ?></td>
    <td align="right"><?php echo number_format($v['total_pagu']) ?></td>
    <td class="center"><?php echo $v['total_program'] ?></td>
    <td class="center"><?php echo $v['total_kegiatan'] ?></td>
    <td class="center"><?php echo $v['total_sub_kegiatan'] ?></td>
    <td class="center"><?php echo $v['total_paket_rutin'] ?></td>
    <td class="center"><?php echo $v['total_paket_swakelola'] ?></td>
    <td class="center"><?php echo $v['total_paket_penyedia'] ?></td>
    <td class="center"><?php echo $v['total_paket_semua'] ?></td>
    <td class="center"><?php echo $v['total_kontrak'] ?></td>
   
  </tr>
  <?php 
$total_pagu += $v['total_pagu'];
$total_program += $v['total_program'];
$total_kegiatan += $v['total_kegiatan'];
$total_sub_kegiatan += $v['total_sub_kegiatan'];

$total_paket_rutin += $v['total_paket_rutin'];
$total_paket_swakelola += $v['total_paket_swakelola'];
$total_paket_penyedia += $v['total_paket_penyedia'];
$total_paket_semua += $v['total_paket_semua'];
$total_kontrak += $v['total_kontrak'];

} ?>
  <tr>
    <td colspan="2">Total</td>
    <td align="right"><?php echo number_format($total_pagu); ?></td>
    <td align="center"><?php echo $total_program; ?></td>
    <td align="center"><?php echo $total_kegiatan; ?></td>
    <td align="center"><?php echo $total_sub_kegiatan; ?></td>
    <td align="center"><?php echo $total_paket_rutin; ?></td>
    <td align="center"><?php echo $total_paket_swakelola; ?></td>
    <td align="center"><?php echo $total_paket_penyedia; ?></td>
    <td align="center"><?php echo $total_paket_semua; ?></td>
    <td align="center"><?php echo $total_kontrak; ?></td>
  </tr>
</table>

</body>