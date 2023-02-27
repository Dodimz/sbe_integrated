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
	   	tutorial();
	   	show_select2();
	});



	function show_select2() {
		$('#asisten').select2({
			placeholder: "Pilih Asisten",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#status').select2({
			placeholder: "Pilih Status",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tipe').select2({
			placeholder: "Pilih Tipe",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#akses').select2({
			placeholder: "Pilih Akses Login",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}




function tutorial()
	{
		
		

		$('#table-tutorial').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('tutorial/data_tutorial/'),
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








function tambah_tutorial()
{
	$('#modal_tambah_tutorial').modal('show');
	$('#modal_tambah_tutorial').find('#simpan').show();
	$('#modal_tambah_tutorial').find('#simpanedit').hide();
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	$('#form_tambah_tutorial')[0].reset();
	$('#modal_tambah_tutorial').find('#akses').val('').change();
	$('#modal_tambah_tutorial').find('#status').val('').change();
	
}				

function lihat_tutorial(id_tutorial)
{
	var iframe_yt ; 
	$('#modal_lihat_video_tutorial').modal('show');
	$.ajax({
		url: baseUrl('tutorial/lihat_video_yt'),
		type: 'POST',
		dataType: 'JSON',
		data: {id_tutorial : id_tutorial},
		success: function (data)
		{
			iframe_yt =`<iframe width="100%" height="600" src="https://www.youtube.com/embed/`+data.data.embed+`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
			$('#modal_lihat_video_tutorial').find('.judul').html(data.data.judul);
			$('#modal_lihat_video_tutorial').find('.video_yt').html(iframe_yt);
			console.log(iframe_yt);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			
		}
	});
	
}	
function edit_tutorial(id_tutorial)
{

	$('#modal_tambah_tutorial').find('#simpan').hide();
	$('#modal_tambah_tutorial').find('#simpanedit').show();
	var iframe_yt ; 
	$('#modal_tambah_tutorial').modal('show');
	$.ajax({
		url: baseUrl('tutorial/get_tutorial'),
		type: 'POST',
		dataType: 'JSON',
		data: {id_tutorial : id_tutorial},
		success: function (data)
		{
			console.log(data);
		$('#modal_tambah_tutorial').find('#id_tutorial').val(data.data.id_tutorial);
		$('#modal_tambah_tutorial').find('#akses').val(data.data.akses).change();
		$('#modal_tambah_tutorial').find('#urutan').val(data.data.urutan);
		$('#modal_tambah_tutorial').find('#judul').val(data.data.judul);
		$('#modal_tambah_tutorial').find('#keterangan').val(data.data.keterangan);
		$('#modal_tambah_tutorial').find('#tipe').val(data.data.tipe);
		$('#modal_tambah_tutorial').find('#link').val(data.data.link);
		$('#modal_tambah_tutorial').find('#status').val(data.data.status).change();
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			
		}
	});
	
}				


function simpan_tutorial()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_tambah_tutorial').serialize();
    
	$.ajax({
		url: baseUrl('tutorial/simpan_tutorial'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			console.log(datanya);
			
			if(datanya.success == true)
			{
				
					$('#form_tambah_tutorial')[0].reset();
					Swal.fire('Disimpan','Data Instansi Ditambhkan','success');
					$('#modal_tambah_tutorial').modal('hide');

			$('#form_tambah_tutorial')[0].reset();
				   	$('#table-tutorial').DataTable().ajax.reload(null, false);
					

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
function simpanedit_tutorial()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_tambah_tutorial').serialize();
    
	$.ajax({
		url: baseUrl('tutorial/simpanedit_tutorial'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			console.log(datanya);
			
			if(datanya.success == true)
			{
				
					$('#form_tambah_tutorial')[0].reset();
					Swal.fire('Disimpan','Data Instansi Ditambhkan','success');
					$('#modal_tambah_tutorial').modal('hide');

			$('#form_tambah_tutorial')[0].reset();
				   	$('#table-tutorial').DataTable().ajax.reload(null, false);
					

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
			console.log('e');	
		}
	});
}
function edit_instansi(id_instansi)
{
	$.ajax({
		url: baseUrl('instansi/get_instansi/'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			'id_instansi' : id_instansi
		},
		success: function (data)
		{
			$('#modal_edit_instansi').modal('show');
			$('#form_edit_instansi')[0].reset();
			$('#modal_edit_instansi').find('#id_instansi').val(data.data.id_instansi);
			$('#modal_edit_instansi').find('#kode').val(data.data.kode_opd);
			$('#modal_edit_instansi').find('#nama').val(data.data.nama_instansi);
			$('#modal_edit_instansi').find('#alamat').val(data.data.alamat_instansi);
			$('#modal_edit_instansi').find('#email').val(data.data.email_instansi);
			$('#modal_edit_instansi').find('#telp').val(data.data.telepon);
			$('#modal_edit_instansi').find('#web').val(data.data.website);

			$('#modal_edit_instansi').find('#asisten').val(data.data.id_parent).change();
			$('#modal_edit_instansi').find('#status').val(data.data.is_active).change();

			$('#modal_edit_instansi').find('#bulan_mulai').val(data.data.bulan_mulai_realisasi).change();
			$('#modal_edit_instansi').find('#bulan_selesai').val(data.data.bulan_akhir_realisasi).change();

			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('error');
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
		url: baseUrl('instansi/simpanedit_instansi'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			console.log(datanya);
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
			console.log('error');
		}
	});
}



	function hapus_tutorial(id_tutorial, nama_tutorial)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda ingin menghapus tutorial : '+ nama_tutorial+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus tutorial',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('tutorial/hapus_tutorial/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_tutorial : id_tutorial
							},
							success : function(data)
							{
								Swal.fire(
								      'Terhapus!',
								      'Tutorial Dihapus',
								      'success'
								    );
								$('#table-tutorial').DataTable().ajax.reload(null, false);
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}

</script>