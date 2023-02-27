<?php 
$data_masuk = 0;
	foreach ($asisten_1 as $v) { 
	$data_masuk += 1;
	}
	foreach ($asisten_2 as $v) { 
	$data_masuk += 1;
	}
	foreach ($asisten_3 as $v) { 
	$data_masuk += 1;
	}
 ?>
<table width="100%">
	<tr>
		<td>
			<div class="copyright" style="float:right" >Powered By IT - Biro Administrasi Pembangunan Tahun 2021 <br>
Penarikan Tanggal <?php echo $tanggal_penarikan ?></div>


		</td>
		<td align="right">
		<span class="page" style="text-align:right" >Data Masuk : <?php echo $data_masuk ?></span> <br>
		<span class="page" style="text-align:right" >Page {PAGENO}/{nbpg}</span>
	</td>
	</tr>
</table>