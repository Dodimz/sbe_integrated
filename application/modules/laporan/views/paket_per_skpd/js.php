<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Script -->
<script>
	$(document).ready(function() {
		show_select2();
	});

	function show_select2() {
		$('#kategori').select2({
			placeholder: "Pilih Kategori",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tahun').select2({
			placeholder: "Pilih Tahun Anggaran",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tahap').select2({
			placeholder: "Pilih Tahapan APBD",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#metode').select2({
			placeholder: "Pilih Bulan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#id_opd').select2({
			placeholder: "Pilih OPD",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#jenis_paket').select2({
			placeholder: "Pilih Jenis Paket",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}

	function metode() {
		var jenis = $('#jenis_paket').val();
		$('#metode').html('');
		if (jenis=='RUTIN' || jenis=='Semua Paket' ) {
			$('#metode').append('<option selected></option>');
			$('#f_metode').hide();

		}else if(jenis=='PENYEDIA'){
			$('#f_metode').show();
			$('#f_kategori').show();

		}else {
			$('#f_metode').show();
			$('#f_kategori').hide();

		}
		$.ajax({
			url : baseUrl('paket_pekerjaan/list_metode/'),
            dataType: 'JSON',
			data : {
				jenis_paket : jenis
			},
			type : 'POST',
			success : function(data){
				$('#metode').append('<option value="semua">Semua Metode</option>');
				$.each(data.data, function(k,v){
					$('#metode').append('<option value="'+v.id+'">'+v.metode+'</option>');
					
				});

			},
			error : function(){
				alert('err');
			}
		});
	}

	function show_paket() {
		let id_opd = $('#id_opd').val();
		let tahun = $('#tahun').val();
		let tahap = $('#tahap').val();
		let jenis_paket = $('#jenis_paket').val();
		let metode = $('#metode').val();
		let kategori = $('#kategori').val();
		if (id_opd=='') {
			Swal.fire('Error','Harap Pilih OPD','error');
			return false;
		}
		else if (tahun=='') {
			Swal.fire('Error','Harap Pilih Tahun','error');
			return false;
		}
		else if (jenis_paket=='') {
			Swal.fire('Error','Harap Pilih Jenis Paket','error');
			return false;
		}

		else {
			$('#tampil_pdf').show();
			$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_paket_per_skpd?id_opd=') + id_opd  +'&kategori=' + kategori + '&tahun=' + tahun +  '&tahap=' + tahap + '&jenis_paket=' + jenis_paket + '&metode=' + metode + '#view=FitH');

		}
	


		
				
			
	}

	function export_excel_paket() {
		let id_opd = $('#id_opd').val();
		let tahun = $('#tahun').val();
		let tahap = $('#tahap').val();
		let jenis_paket = $('#jenis_paket').val();
		let metode = $('#metode').val();
		let kategori = $('#kategori').val();
		if (id_opd=='') {
			Swal.fire('Error','Harap Pilih OPD','error');
			return false;
		}
		else if (tahun=='') {
			Swal.fire('Error','Harap Pilih Tahun','error');
			return false;
		}
		else if (jenis_paket=='') {
			Swal.fire('Error','Harap Pilih Jenis Paket','error');
			return false;
		}

		else {

				var url =  baseUrl('laporan/excel_laporan_paket_per_skpd?id_opd=') + id_opd  +'&kategori=' + kategori + '&tahun=' + tahun +  '&tahap=' + tahap + '&jenis_paket=' + jenis_paket + '&metode=' + metode ;

				window.location = url;

		}
	


		
				
			
	}
</script>