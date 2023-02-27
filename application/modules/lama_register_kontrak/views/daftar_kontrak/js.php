<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		tampil_table_daftar_kontrak();
	});
	/* Fungsi untuk menampilkan daftar kontrak */
	function tampil_table_daftar_kontrak() {
		$('#table-daftar-kontrak').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('register_kontrak/dt_daftar_kontrak/'),
				type: "POST",
				data: {},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 1, 2],
				},
				{
					className: "dt-nowrap",
					targets: [1, 2],
				},
				{
					className: "dt-right",
					targets: [-1],
				},
			],

		});
	}





	function hapus_kontrak(id_kontrak, nama_pelaksana)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda ingin menghapus kontrak dengan '+ nama_pelaksana+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('register_kontrak/hapus_kontrak/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_kontrak : id_kontrak,
								
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Dihapus!',
								      'Data kontrak dihapus',
								      'success'
								    );
								
										tampil_table_daftar_kontrak();
									
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}

</script>