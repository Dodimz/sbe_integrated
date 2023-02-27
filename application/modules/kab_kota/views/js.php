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
	   	kab_kota();
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




function kab_kota()
	{
		
		

		$('#table-kab-kota').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('kab_kota/data_kab_kota/'),
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







function edit_config_kab_kota(id_config)
{
	$.ajax({
		url: baseUrl('kab_kota/get_ckk/'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			'id_config' : id_config
		},
		success: function (data)
		{
			console.log(data);
			$('#modal_edit_ckk').modal('show');
			$('#form_edit_ckk')[0].reset();
			$('#modal_edit_ckk').find('#id_config').val(data.data.id_config);

			$('#modal_edit_ckk').find('#kab_kota').html(data.data.nama_kota +'<br>Wilayah '+ data.data.wilayah);
			$('#modal_edit_ckk').find('#logo').html(data.data.logo);
			$('#modal_edit_ckk').find('#link').val(data.data.url_replikasi);
			$('#modal_edit_ckk').find('#token_integrasi').val(data.data.token_integrasi_replikasi);


			$('#modal_edit_ckk').find('#replikasi').change(function(){
			var replikasi = $('#modal_edit_ckk').find('#replikasi').val();
			if (replikasi>='5') {
				$('#modal_edit_ckk').find('.form_replikasi').show();
				if (data.data.integrasi_replikasi==1) {
					$('#modal_edit_ckk').find('#form_token_integrasi').show();

				}else{
					$('#modal_edit_ckk').find('#form_token_integrasi').hide();

				}



			} else{
				$('#modal_edit_ckk').find('.form_replikasi').hide();

			}
			});


			$('#modal_edit_ckk').find('#replikasi').val(data.data.replikasi_aplikasi).change();
			$('#modal_edit_ckk').find('#integrasi').val(data.data.integrasi_replikasi).change();
			$('#modal_edit_ckk').find('#sdss').val(data.data.sumber_data_sumbar_siap).change();

			$('#modal_edit_ckk').find('#integrasi').change(function(){
				var integrasi = $('#modal_edit_ckk').find('#integrasi').val();
				console.log(integrasi);
				if (integrasi==1) {
					$('#modal_edit_ckk').find('#form_token_integrasi').show();

				}else{
					$('#modal_edit_ckk').find('#form_token_integrasi').hide();

				}
			});
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});
}

$('#modal_edit_ckk').find('#replikasi').change(function(){
var replikasi = $('#modal_edit_ckk').find('#replikasi').val();
console.log(replikasi);
});
function simpanedit_ckk()
{
	
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_edit_ckk').serialize();
    
	$.ajax({
		url: baseUrl('kab_kota/simpanedit_ckk'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			console.log(datanya);
		
				
					$('#form_edit_ckk')[0].reset();
					$('#modal_edit_ckk').find('#replikasi').val('').change();
					$('#modal_edit_ckk').find('#integrasi').val('').change();
					$('#modal_edit_ckk').find('#sdss').val('').change();
					Swal.fire('Disimpan','Data Config Kab Kota Diperbaharui','success');
					$('#modal_edit_ckk').modal('hide');
				   	$('#table-kab-kota').DataTable().ajax.reload(null, false);
					

			
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