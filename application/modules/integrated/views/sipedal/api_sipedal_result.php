<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>
		
<div style=" max-height:700px;	overflow-x: scroll">
	<div style="margin:10px;">
		<table class='table table-striped table-bordered' style='margin-top:10px; font-size: 12px' id="data_sipedal">
		       <thead>
		       	<tr>
		       		<th colspan="10"><center>Master Paket Pekerjaan</center></th>
		       		<th colspan="6"><center>Kontrak Pekerjaan</center></th>
		       	</tr>
		       	<tr>
		           <th>No</th>
		           <th>ID RUP</th>
		           <th>SKPD</th>
		           <th>Sub Kegiatan</th>
		           <th>Tahapan APBD</th>
		           <th>Paket Pekerjaan</th>
		           <th>Jenis Paket</th>
		           <th>Pagu Paket</th>
		           <th>Metode Paket</th>
		           <th>Keterangan</th>

		           <th>No Kontrak</th>
		           <th>Jenis Kontrak</th>
		           <th>Pelaksana</th>
		           <th>Mulai</th>
		           <th>Berakhir</th>
		           <th>Nilai Kontrak</th>
		       </tr>
		       </thead>


		       <?php 

		        $no=0;

		        $sudah_terimport = 0;
		        $belum_terimport = 0;
		        foreach ($data_sipedal->data as $key => $value) {
		            $no++;
		            $id_rup = $value->id_rup;
		            // $q_paket_pekerjaan = $integrasi_sipedal->cek_paket_sipedal($id_rup);
		            // $cek_paket_pekerjaan = $q_paket_pekerjaan->row_array();
		            // $countdata_paket_pekerjaan = $q_paket_pekerjaan->num_rows();

		            // if ($countdata_paket_pekerjaan>0) {
		            //     $keterangan = '<div class="ml-auto badge badge-secondary">Telah Di Import ke Simbangda</div>';
		            // }else{
		            //     $keterangan = "";

		            // }
		            if (in_array($id_rup, $data_paket_sbe)) {
		                $keterangan = '<div class="ml-auto badge badge-secondary">Telah Di Import ke Simbangda</div>';
		                $sudah_terimport ++;
		            }else{
		                $belum_terimport ++;
		                $keterangan = "";

		            }
		            ?>
		        
			        <tr>
			            <td><?php echo $no; ?></td>
			            <td><?php echo $value->id_rup; ?></td>
			            <td><?php echo $value->namasatker; ?></td>
			            <td><?php echo $value->kode_subkegiatans; ?><br><?php echo $value->nama_subkegiatan; ?></td>
			            <td><?php echo $value->sumberdana; ?> <?php echo $value->tahun; ?></td>
			            <td><?php echo $value->namapaket; ?></td>
			            <td>PENYEDIA</td>
			            <td><?php echo number_format($value->jumlahpagu); ?></td>
			            <td><?php echo $value->metodepengadaan; ?></td>
			            <td><?php echo $keterangan; ?></td>

			            <td> ???? </td>
			            <td> ???? </td>
			            <td> ???? </td>
			            <td><?php echo $value->tanggalawalpekerjaan; ?></td>
			            <td><?php echo $value->tanggalakhirpekerjaan; ?></td>
			            <td> ???? </td>
			          
			            
			        </tr>
		        
		        <?php }

		        $semua_data = $no ; 
		        // $belum_terimport = $semua_data - $sudah_terimport;
		         ?>
		   </table>






	    <div class="dropdown d-inline-block">
	        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-primary">Import Database</button>
	        <a href="<?php echo base_url() ?>integrasi_aplikasi/cek_import_sipedal?id_opd=<?php echo $id_instansi ?>&tahun=<?php echo $tahun ?>" class="mb-2 mr-2 btn btn-info">Kelola Hasil Pengintegrasian</a>
	        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-lg">
	            <ul class="nav flex-column">
	                <li class="nav-item-header nav-item">Import Sipedal ke Simbangda</li>
	                <li class="nav-item"><a href="javascript:void(0);" class="nav-link"  onclick="import_sipedal_ke_sbe('<?php echo $link_api ?>','<?php echo $belum_terimport ?>','<?php echo $id_instansi ?>','<?php echo $tahun ?>','<?php echo $jenis_paket ?>')" >Import yang belum tercopy
	                    <div class="ml-auto badge badge-success"><?php echo $belum_terimport ?></div>
	                </a></li>
	               <!--  <li class="nav-item"><a href="javascript:void(0);" class="nav-link">Import bersama yang sudah tercopy
	                    <div class="ml-auto badge badge-warning">512</div>
	                </a></li>
	                <li class="nav-item"><a href="javascript:void(0);" class="nav-link">Logs</a></li> -->
	              
	            </ul>
	        </div>
	    </div>
	</div>
</div>


   <script type="text/javascript">
   	
$(document).ready( function () {
    $('#data_sipedal').DataTable();
} );
   </script>

   