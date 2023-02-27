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
	   	instansi_pembantu_teknis();
	   	show_select2();
	});



	function show_select2() {
		$('#jenis').select2({
			placeholder: "Pilih jenis",
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
		$('#kota').select2({
			placeholder: "Pilih kota",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}




function instansi_pembantu_teknis()
	{
		
		

		$('#table-instansi-teknis').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('instansi/data_instansi_pembantu_teknis/'),
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








function tambah_instansi_teknis()
{
	$('#modal_tambah_instansi').modal('show');
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	$('#form_tambah_instansi')[0].reset();
	$('#modal_tambah_instansi').find('#jenis').val('').change();
	$('#modal_tambah_instansi').find('#kota').val('').change();
	$('#modal_tambah_instansi').find('#status').val('').change();
	$('#modal_tambah_instansi').find('#tombol_simpanedit').hide();
	$('#modal_tambah_instansi').find('#tombol_simpan').show();
	
}				


function simpan_instansi_teknis()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_tambah_instansi').serialize();
    
	$.ajax({
		url: baseUrl('instansi/simpan_instansi_teknis'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			
			if(datanya.success == true)
			{
				
					$('#form_tambah_instansi')[0].reset();
					Swal.fire('Disimpan','Data Instansi Ditambhkan','success');
					$('#modal_tambah_instansi').modal('hide');

			$('#form_tambah_instansi')[0].reset();
				   	$('#table-instansi-teknis').DataTable().ajax.reload(null, false);
					

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
			alert('error');
		}
	});
}
function edit_instansi_teknis(id_instansi)
{

	$('#modal_tambah_instansi').find('#tombol_simpanedit').show();
	$('#modal_tambah_instansi').find('#tombol_simpan').hide();
	$.ajax({
		url: baseUrl('instansi/get_instansi_teknis/'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			'id_instansi' : id_instansi
		},
		success: function (data)
		{
			console.log(data)
			$('#modal_tambah_instansi').modal('show');
			$('#form_tambah_instansi')[0].reset();
			$('#modal_tambah_instansi').find('#id_instansi_pembantu_teknis').val(data.data.id_instansi_pembantu_teknis);
			$('#modal_tambah_instansi').find('#kode').val(data.data.kode);
			$('#modal_tambah_instansi').find('#nama').val(data.data.nama_instansi_teknis);
			
			$('#modal_tambah_instansi').find('#jenis').val(data.data.jenis_teknis).change();
			$('#modal_tambah_instansi').find('#kota').val(data.data.id_kota).change();

			$('#modal_tambah_instansi').find('#status').val(data.data.is_active).change();

			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});
}




function simpanedit_instansi_teknis()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_tambah_instansi').serialize();
    
	$.ajax({
		url: baseUrl('instansi/simpanedit_instansi_teknis'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			
			if(datanya.success == true)
			{
				
					$('#form_tambah_instansi')[0].reset();
					Swal.fire('Disimpan','Data Instansi Diperbaharui','success');
					$('#modal_tambah_instansi').modal('hide');

					$('#form_tambah_instansi')[0].reset();
				   	$('#table-instansi-teknis').DataTable().ajax.reload(null, false);
					

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
			alert('error');
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



	function hapus_instansi_teknis(id_instansi, nama_instansi)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda ingin menghapus instansi teknis : '+ nama_instansi+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus Instansi Teknis',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('instansi/hapus_instansi_teknis/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_instansi : id_instansi
							},
							success : function(data)
							{
								Swal.fire(
								      'Terhapus!',
								      'Instansi Teknis Dihapus',
								      'success'
								    );
								$('#table-instansi-teknis').DataTable().ajax.reload(null, false);
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}

</script>