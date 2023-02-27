<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>

<script>
	function get_file_name(prop) {
		let file = prop.value.split("\\");
		let result = file[file.length - 1];
		$(prop).next().text(result);
	}

	function do_upload() {
		let form_data = new FormData(document.getElementById("form-update-evidence"));
		let file_data = $('#upload-file').prop('files')[0];
		let id_realisasi_fisik = $('#id_realisasi_fisik').val();
		let id_paket_pekerjaan = $('#id_paket_pekerjaan').val();
		let pelaksanaan = $('#pelaksanaan').val();
		form_data.append('file', file_data);
		form_data.append('id', 'upload_file');
		form_data.append('id_realisasi_fisik', id_realisasi_fisik);
		form_data.append('id_paket_pekerjaan', id_paket_pekerjaan);
		form_data.append('pelaksanaan', pelaksanaan);

		$.ajax({
			url: baseUrl('realisasi/fix_evidence/'),
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
					get_paket_ditolak();
					window.location.href = baseUrl('dashboard');
				}
			},
			error : function(){
				console.log('error');
			}
		});
	}

	function upload_berakhir(){
		Swal.fire('Gagal','<?php echo jadwal_rfk()['pesan'] ?>','error')
	}
</script>