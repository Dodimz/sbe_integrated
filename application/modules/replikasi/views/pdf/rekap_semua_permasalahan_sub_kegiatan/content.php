<style>
  .font_laporan{
    font-size:9px;
    font-family: 'arial';
  }
  table {
    
    border-collapse: collapse;
    width:100%;
}
table th, td {
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

<table class="font_laporan border">
 <thead class="header">
    <tr>
    <th  width="30px">No</th>
    <th >Sub Kegiatan</th>
    <th >Permasalahan</th>
    <th >Rencana tindak lanjut</th>
   
  </tr>
 </thead>
  <?php 
  $no =0;
  foreach ($instansi_yang_menyampaikan as $k => $v) { 
    $idinstansi = $v->id_instansi;
   
    $no++;
    $warna_instansi = $v->is_active=='0' ? "style='background: #f8d0d0 '" :'';

    ?>
    <tr <?php echo $warna_instansi ?>>
      <td align="left"><?php echo $no ?></td>
      <td colspan="3" align="left"><?php echo $v->nama_instansi ?></td>
    </tr>
  <?php
   $q_sk_permasalahan = $this->db->query("SELECT distinct psk.kode_sub_kegiatan, msk.nama_sub_kegiatan,ski.kategori, ski.jenis_sub_kegiatan , ski.keterangan  from permasalahan_sub_kegiatan psk 
    left join master_sub_kegiatan msk on(trim(substr(psk.kode_sub_kegiatan,1,15)) = trim(msk.kode_sub_kegiatan))
    left join sub_kegiatan_instansi ski on psk.id_instansi=ski.id_instansi and psk.kode_sub_kegiatan=ski.kode_sub_kegiatan
     where psk.id_instansi='$idinstansi'")->result();
   $no_sk = 0;
   foreach ($q_sk_permasalahan  as $k_sk_permasalahan => $v_sk_permasalahan) { 
    $no_sk++;
    $nama_sub_kegiatan = $v_sk_permasalahan->kategori =='Unit Pelaksana' ? $v_sk_permasalahan->nama_sub_kegiatan.'<br>'.$v_sk_permasalahan->jenis_sub_kegiatan.' - '.$v_sk_permasalahan->keterangan : $v_sk_permasalahan->nama_sub_kegiatan;
    $ksk = $v_sk_permasalahan->kode_sub_kegiatan;
    ?>
     <tr <?php echo $warna_instansi ?>>
        <td valign="top" align="left"><?php echo $no.'.'.$no_sk ?></td>
        <td valign="top" align="left"><?php echo $nama_sub_kegiatan ?></td>
        <td valign="top" align="left">
            <ol>
          <?php 
          $q_show_masalah = $this->db->query("SELECT permasalahan from permasalahan_sub_kegiatan where id_instansi='$idinstansi' and kode_tahap='$kode_tahap' and kode_sub_kegiatan='$ksk'")->result();
          foreach ($q_show_masalah as $k_show_masalah => $v_show_masalah) { ?>
              <li><?php echo $v_show_masalah->permasalahan ?></li>
          <?php } ?>
            </ol>
        </td>
         <td valign="top" align="left">
            <ol>
          <?php 
          $q_show_solusi = $this->db->query("SELECT solusi,solusi_by from solusi_permasalahan_sub_kegiatan where id_instansi='$idinstansi' and kode_tahap='$kode_tahap' and kode_sub_kegiatan='$ksk'")->result();
          foreach ($q_show_solusi as $k_show_solusi => $v_show_solusi) { 
            $warna = $v_show_solusi->solusi_by=='ADMIN' ? 'style="color:blue"':'';
            ?>
              <li><?php echo $v_show_solusi->solusi ?></li>
          <?php } ?>
            </ol>
        </td>
      </tr>
      <?php }
   } ?>


 <!-- <tbody> -->
 
  
 

</table>


</body>