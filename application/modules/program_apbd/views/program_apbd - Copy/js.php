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
<script>
	$(document).ready(function()
	{
	   showProgramApbd();
	});

	/* Fungsi untuk menampilkan Program APBD */
	function showProgramApbd()
	{
		$('#table-program-apbd').DataTable({
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('program_apbd/dt_program_apbd/'),
				            type 	: "POST",
				          	data 	: {},
	        			  },
	        columnDefs  : [
						  	{ 
						    	targets	 	: [0,-1],
						    	orderable 	: false,
						    },
	        			  ],
 
    	});
	}


	function export_program() {
		$('#modal-export-program').modal('show')
			.find('.modal-title').text('Export Program APBD');
	//	list_dokumen(id_instansi, id_kpa, id_pptk, id_paket_pekerjaan, kode_rekening_kegiatan, jenis_paket, id_metode);
	}



	function simpan_export_program() {
		// $('#btn-upload-export-program').attr('disabled', true);
		$('#btn-upload-export-program').text('Loading...').attr('disabled', true);
		let form_data = new FormData(document.getElementById("form-export-program"));
		let file_data = $('#upload-file').prop('files')[0];
		form_data.append('file', file_data);

		$.ajax({
			url: baseUrl('program_apbd/export_program/'),
			dataType: 'json',
			mimeType: "multipart/form-data",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
				console.log(data);
				if (data.status == true) {
			
					window.location.href = baseUrl('program_apbd');
				}
			}
		});
	}

	function get_file_name(prop) {
		let file = prop.value.split("\\");
		let result = file[file.length - 1];
		$(prop).next().text(result);
	}
	function download_format_excel_program() {
		window.location.href='https://drive.google.com/file/d/1N9nXH8rgEv0dsAVlc9gxWvIg6lsAUagb/view?usp=sharing'
		// $.ajax({
		// 		url: baseUrl('program_apbd/download_format_excel_program	/'),
		// 		dataType: 'json',
			
		// 		data: {},
		// 		type: 'POST',
		// 		success: function(data) {
		// 			console.log(data);
		// 			if (data.status == true) {
		// 				console.log('harusnya berhasil')
				
		// 				window.location.href = baseUrl('program_apbd');
		// 			}
		// 		},
		// 		error : function(){
		// 			console.log('error');
		// 		}
		// 	});	
	}
</script>