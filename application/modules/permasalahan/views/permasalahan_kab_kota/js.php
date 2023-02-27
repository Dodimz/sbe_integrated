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
	   	master_instansi_kab_kota();
	   	show_select2();
	});



	function show_select2() {
		
		$('#status').select2({
			placeholder: "Pilih Status",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}




function master_instansi_kab_kota()
	{
		
		

		$('#table-instansi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('permasalahan/data_instansi_kab_kota/'),
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







	function input_permasalahan(id_instansi, tahap, tahun, nama_instansi)
	{
		var nama_tahap = ['','','APBD AWAL','','APBD PERUBAHAN'];
		$('#modal_input_permasalahan').find('#simpanedit_permasalahan').hide();
    	$('#modal_input_permasalahan').find('#hapus_permasalahan').hide();

		$('#modal_input_permasalahan').find('#simpan_permasalahan').show();
		
		$('#modal_input_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_permasalahan').find('.nama_instansi').html(nama_instansi);
    	$('#modal_input_permasalahan').find('.nama_tahap').html(nama_tahap[tahap]);
    	$('#modal_input_permasalahan').find('.tahun_anggaran').html(tahun);
		$('#modal_input_permasalahan').find('#id_instansi').val(id_instansi);
    	$('#modal_input_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_permasalahan').find('#tahun').val(tahun);

  		

	}




	function save_permasalahan_skpd_kab_kota()
	{
	
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('permasalahan/save_permasalahan_skpd_kab_kota'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				console.log(datanya);
				if(datanya.success == true)
				{
					
						$('#form_input_permasalahan')[0].reset();
						Swal.fire('Disimpan','Permasalahan anda sudah ditambahkan','success');
						$('#modal_input_permasalahan').modal('hide');
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
				console.log('error');
			}
		});
	}




	function edit_permasalahan(id_permasalahan)
	{
		console.log(id_permasalahan);
		$('#modal_input_permasalahan').find('#simpan_permasalahan').hide();

		$('#modal_input_permasalahan').find('#simpanedit_permasalahan').show();
    	$('#modal_input_permasalahan').find('#hapus_permasalahan').show();
		$('#modal_input_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');

    	$('#list_permasalahan').html('');
    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('permasalahan/detail_permasalahan_skpd_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_permasalahan : id_permasalahan,
            
            },
            success : function(data)
            {
            	console.log(data);
            	$('#modal_input_permasalahan').find('#simpanedit_permasalahan').show();
            	$('#modal_input_permasalahan').find('#hapus_permasalahan').show();
            	$('#modal_input_permasalahan').find('#id_permasalahan').val(data.data.id_permasalahan);
            	$('#modal_input_permasalahan').find('#id_instansi').val(data.data.id_instansi);
            	$('#modal_input_permasalahan').find('#tahap').val(data.data.kode_tahap);
            	$('#modal_input_permasalahan').find('#tahun').val(data.data.tahun);
            	$('#modal_input_permasalahan').find('#permasalahan').val(data.data.permasalahan);

            	$('#modal_input_permasalahan').find('.nama_instansi').html(data.data.nama_instansi);
            	$('#modal_input_permasalahan').find('.nama_tahap').html(data.data.nama_tahap);
            	$('#modal_input_permasalahan').find('.tahun_anggaran').html(data.data.tahun);

            	$('#modal_input_permasalahan').find('#simpanedit_permasalahan').show();
            	$('#modal_input_permasalahan').find('#hapus_permasalahan').show();
            	

            
            },
            error : function(){
            	console.log('error');
            }
        });


	}


	function saveedit_permasalahan_skpd_kab_kota()
	{
	
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('permasalahan/saveedit_permasalahan_skpd_kab_kota'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				console.log(datanya);
				if(datanya.success == true)
				{
					
						$('#form_input_permasalahan')[0].reset();
						Swal.fire('Disimpan','Permasalahan anda sudah ditambahkan','success');
						$('#modal_input_permasalahan').modal('hide');
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
				console.log('error');
			}
		});
	}


	function hapus_permasalahan_skpd_kab_kota()
	{
		var id_permasalahan = $('#modal_input_permasalahan').find('#id_permasalahan').val();
		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus permasalahan .?',
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
							url     : baseUrl('permasalahan/hapus_permasalahan_skpd_kab_kota/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_permasalahan : id_permasalahan,
								
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Duhapus!',
								      'Permasalahan dihapus',
								      'success'
								    );
									$('#modal_input_permasalahan').modal('hide');
									$('#table-instansi').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}





	function input_solusi_permasalahan(id_instansi, tahap, tahun, nama_instansi)
	{
		var nama_tahap = ['','','APBD AWAL','','APBD PERUBAHAN'];

		$('#modal_input_solusi_permasalahan').modal('show');
    	$('#modal_input_solusi_permasalahan').find('#simpanedit_solusi').hide();
    	$('#modal_input_solusi_permasalahan').find('#hapus_solusi').hide();
    	$('#modal_input_solusi_permasalahan').find('#simpan_solusi').show();
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_solusi_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
    	$('#modal_input_solusi_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_solusi_permasalahan').find('#tahun').val(tahun);
    	$('#modal_input_solusi_permasalahan').find('#id_instansi').val(id_instansi);
    	$('#modal_input_solusi_permasalahan').find('.nama_tahap').html(nama_tahap[tahap]);
    	$('#modal_input_solusi_permasalahan').find('.tahun_anggaran').html(tahun);
    	$('#modal_input_solusi_permasalahan').find('.nama_instansi').html(nama_instansi);
    	$('#list_permasalahan').html('');
    
		$.ajax(
        {
            url     : baseUrl('permasalahan/get_permasalahan_skpd_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	
            	tahun : tahun,
            	tahap : tahap,
            	id_instansi : id_instansi,
            },
            success : function(data)
            {

            	
            	$.each(data.permasalahan, function(k, v) {
							$('#list_permasalahan').append('<li>'+v.masalah+'</li>');
						});
            },
            error : function(){
            	console.log('error');
            }
        });


	}









	function edit_solusi_permasalahan(id_solusi, id_instansi, tahap, tahun, nama_instansi)
	{
		$('#modal_input_solusi_permasalahan').find('#simpan_solusi').hide();
		$('#modal_input_solusi_permasalahan').find('#simpanedit_solusi').show();
    	$('#modal_input_solusi_permasalahan').find('#hapus_solusi').show();
		$('#modal_input_solusi_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_solusi_permasalahan').find('#id_solusi').val(id_solusi);
		$('#list_permasalahan').html('');
		
    	$.ajax(
        {
            url     : baseUrl('permasalahan/get_permasalahan_skpd_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	
            	tahun : tahun,
            	tahap : tahap,
            	id_instansi : id_instansi,
            },
            success : function(data)
            {

            	
            	$.each(data.permasalahan, function(k, v) {
							$('#list_permasalahan').append('<li>'+v.masalah+'</li>');
						});
            },
            error : function(){
            	console.log('error');
            }
        });
    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('permasalahan/detail_solusi_skpd_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_solusi : id_solusi,
            
            },
            success : function(data)
            {
            	console.log(data);
            	$('#modal_input_solusi_permasalahan').find('#simpanedit_permasalahan').show();
            	$('#modal_input_solusi_permasalahan').find('#hapus_permasalahan').show();
            	$('#modal_input_solusi_permasalahan').find('#id_permasalahan').val(data.data.id_permasalahan);
            	$('#modal_input_solusi_permasalahan').find('#id_instansi').val(data.data.id_instansi);
            	$('#modal_input_solusi_permasalahan').find('#tahap').val(data.data.kode_tahap);
            	$('#modal_input_solusi_permasalahan').find('#tahun').val(data.data.tahun);
            	$('#modal_input_solusi_permasalahan').find('#solusi').val(data.data.solusi);

            	$('#modal_input_solusi_permasalahan').find('.nama_instansi').html(data.data.nama_instansi);
            	$('#modal_input_solusi_permasalahan').find('.nama_tahap').html(data.data.nama_tahap);
            	$('#modal_input_solusi_permasalahan').find('.tahun_anggaran').html(data.data.tahun);

            	$('#modal_input_solusi_permasalahan').find('#simpanedit_permasalahan').show();
            	$('#modal_input_solusi_permasalahan').find('#hapus_permasalahan').show();
            	

            
            },
            error : function(){
            	console.log('error');
            }
        });


	}





	function save_solusi_permasalahan_skpd_kab_kota()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_solusi_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('permasalahan/save_solusi_permasalahan_skpd_kab_kota'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				
				if(datanya.success == true)
				{
					
						$('#form_input_solusi_permasalahan')[0].reset();
						Swal.fire('Disimpan','Solusi Permasalahan anda sudah ditambahkan','success');
						$('#modal_input_solusi_permasalahan').modal('hide');
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

	function saveedit_solusi_permasalahan_skpd_kab_kota()
	{

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_solusi_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('permasalahan/saveedit_solusi_permasalahan_skpd_kab_kota'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				
				if(datanya.success == true)
				{
					
						$('#form_input_solusi_permasalahan')[0].reset();
						Swal.fire('Disimpan','Solusi Permasalahan anda sudah ditambahkan','success');
						$('#modal_input_solusi_permasalahan').modal('hide');
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




	function hapus_solusi_permasalahan_skpd_kab_kota()
	{
		var id_solusi = $('#modal_input_solusi_permasalahan').find('#id_solusi').val();
		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus Solusi permasalahan .?',
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
							url     : baseUrl('permasalahan/hapus_solusi_permasalahan_skpd_kab_kota/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_solusi : id_solusi,
								
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Dihapus!',
								      'Solusi dihapus',
								      'success'
								    );
									$('#modal_input_solusi_permasalahan').modal('hide');
									$('#table-instansi').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}
</script>