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
	   	master_instansi();
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
		
	}




function master_instansi()
	{
		
		

		$('#table-instansi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('instansi/data_instansi/'),
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








function tambah_instansi()
{
	$('#modal_tambah_instansi').modal('show');
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	$('#form_tambah_instansi')[0].reset();
	
}				


function simpan_instansi()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_tambah_instansi').serialize();
    
	$.ajax({
		url: baseUrl('instansi/simpan_instansi'),
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
				   	$('#table-instansi').DataTable().ajax.reload(null, false);
					

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



	function hapus_instansi(id_instansi, nama_instansi)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda ingin menghapus instansi : '+ nama_instansi+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus Instansi',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('instansi/hapus_instansi/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_instansi : id_instansi
							},
							success : function(data)
							{
								Swal.fire(
								      'Terhapus!',
								      'Instansi Dihapus',
								      'success'
								    );
								$('#table-instansi').DataTable().ajax.reload(null, false);
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}

</script>