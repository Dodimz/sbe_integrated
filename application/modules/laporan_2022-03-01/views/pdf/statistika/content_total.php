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
    <th>No</th>
    <th>SKPD</th>
    <th>Total program</th>
    <th>Total kegiatan</th>
    <th>Total sub kegiatan</th>
    <th>Total Pagu</th>
  </tr>
 
  <?php 
  $no = 0;

$total_program = 0;
$total_kegiatan = 0;
$total_sub_kegiatan = 0;
$total_pagu_ok = 0;



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
    <td class="center"><?php echo $v['total_program'] ?></td>
    <td class="center"><?php echo $v['total_kegiatan'] ?></td>
    <td class="center"><?php echo $v['total_sub_kegiatan'] ?></td>
    <td align="right"><?php echo $v['total_pagu'] ?></td>
   
  </tr>
  <?php 
$total_program += $v['total_program'];
$total_kegiatan += $v['total_kegiatan'];
$total_sub_kegiatan += $v['total_sub_kegiatan'];



} ?>
 
</table>

</body>