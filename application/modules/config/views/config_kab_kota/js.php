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
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	
	$(document).ready(function()
	{
	   	data_pj_kab_kota();
	   	show_select2();
	});



	function show_select2() {
		
		$('#id_config').select2({
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
		$('#bulan').select2({
			placeholder: "Pilih Bulan Realisasi",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#id_instansi').select2({
			placeholder: "Pilih Instansi Penanggung jawab",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#pj').select2({
			placeholder: "Pilih Penanggung jawab",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}




function data_pj_kab_kota()
	{
		
		

		$('#tabel_pj').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('config/data_pj_pelaporan_kab_kota/'),
				            type 	: "POST",
				          	data 	: {}
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0 ],
							},
							{
								className	: "dt-center",
								targets		: [ -1 ],
							},
	        			  ],
	    
	     //    fnRowCallback : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		    //    var index = iDisplayIndex +1;
		    //    $('td:eq(0)',nRow).html(index);
		    //    return nRow;
		    // }

    	});
	}








function edit_config_kab_kota()
{
	$('#modal_config_kab_kota').modal('show');
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	$('#form_config_kab_kota')[0].reset();
	$('#form_config_kab_kota')[0].reset();
	
}				



function tambah_pj_pelaporan_kab_kota()
{
	$('#modal_add_pj').modal('show');
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	$('#modal_add_pj').find('#tbl_simpan').show();
	$('#modal_add_pj').find('#tbl_simpanedit').hide();
	$('#form_add_pj')[0].reset();
	$('#modal_add_pj').find('#id_instansi').val('').change();
	
}



function simpan_config()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_config_kab_kota').serialize();
    
	$.ajax({
		url: baseUrl('config/simpanedit_config_kab_kota'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if(datanya.success == true)
			{
				if (datanya.messages=='Gagal menyimpan. Tanggal mulai tidak boleh diatas tanggal selesai') {
					// Swal.fire('Gagal',datanya.messages,'error');

				}else{
					// Swal.fire('Disimpan',datanya.messages,'error');
					$('#form_config_kab_kota')[0].reset();
					$('#modal_config_kab_kota').modal('hide');
					window.location.href=baseUrl('config');

				}
				

		

			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#' + key);
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
				
			
		}
	});
}



function simpan_pj_pelaporan_kab_kota()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_add_pj').serialize();
    
	$.ajax({
		url: baseUrl('config/simpan_pj_pelaporan_kab_kota'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if(datanya.success == true)
			{
				
					Swal.fire('Disimpan','Data penanggung jawab pelaporan ditambahkan','success');
					$('#form_add_pj')[0].reset();
					$('#modal_add_pj').modal('hide');
				   	$('#tabel_pj').DataTable().ajax.reload(null, false);
					

			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#modal_add_pj').find('#' + key);;
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			
		}
	});
}


function simpanedit_pj_pelaporan_kab_kota()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_add_pj').serialize();
    
	$.ajax({
		url: baseUrl('config/simpanedit_pj_pelaporan_kab_kota'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if(datanya.success == true)
			{
				
					Swal.fire('Disimpan','Data penanggung jawab pelaporan diperbaharui','success');
					$('#form_add_pj')[0].reset();
					$('#modal_add_pj').modal('hide');
				   	$('#tabel_pj').DataTable().ajax.reload(null, false);
					

			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#modal_add_pj').find('#' + key);;
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			
		}
	});
}






































function edit_pj_pelaporan_kab_kota(id_pj)
{

	$('#modal_add_pj').find('#tbl_simpan').hide();
	$('#modal_add_pj').find('#tbl_simpanedit').show();
	$.ajax({
		url: baseUrl('config/get_pj_pelaporan_kab_kota/'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			'id_pj' : id_pj
		},
		success: function (data)
		{
			$('#modal_add_pj').modal('show');
			$('#form_add_pj')[0].reset();
			$('#modal_add_pj').find('#id_pj').val(data.data.id_pj);
			$('#modal_add_pj').find('#id_instansi').val(data.data.id_instansi).change();
			$('#modal_add_pj').find('#nama').val(data.data.nama);
			$('#modal_add_pj').find('#nip').val(data.data.nip);
			$('#modal_add_pj').find('#jabatan').val(data.data.jabatan);
			$('#modal_add_pj').find('#mulai_pj').val(data.data.mulai_pj);
			$('#modal_add_pj').find('#akhir_pj').val(data.data.akhir_pj);
			



			
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}


function simpanedit_instansi()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_edit_instansi').serialize();
    
	$.ajax({
		url: baseUrl('instansi/simpanedit_instansi_kab_kota'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if(datanya.success == true)
			{
				
					$('#form_edit_instansi')[0].reset();
					Swal.fire('Disimpan','Data Instansi Diperbaharui','success');
					$('#modal_edit_instansi').modal('hide');
				   	$('#table-instansi').DataTable().ajax.reload(null, false);
					

			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#modal_edit_instansi').find('#' + key);
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}



	function hapus_pj_pelaporan_kab_kota(id_pj, nama)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda ingin menghapus pj : '+ nama+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus PJ Pelaporan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('config/hapus_pj_pelaporan_kab_kota/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_pj : id_pj
							},
							success : function(data)
							{
								Swal.fire(
								      'Terhapus!',
								      'PJ Pelaporan Dihapus',
								      'success'
								    );
								$('#tabel_pj').DataTable().ajax.reload(null, false);
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}

</script>