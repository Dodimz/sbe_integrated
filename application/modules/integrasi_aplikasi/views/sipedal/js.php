
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>

	var fetch_method = '<?php echo $fetch_method ?>';
	if (fetch_method=='cek_import_sipedal') {
		var id_opd = '<?php echo @$id_opd ?>';
		kelola_import_sipedal(id_opd);
	}
	// // alert(fetch_method);
    $('#datatable_1').DataTable();
		$('#id_opd').select2(
		{
			placeholder : "Pilih OPD",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});


	 function get_data_integrasi_sipedal(){

    
	 	$('#searching_button').attr("disabled","disabled");
	 	// $('#loading').modal("show");
	 	$('#searching_button').html(`<i class="fa fa-cog fa-w-16 fa-spin"></i> Loading Data`);
		id_instansi =  $('#id_opd').val();
		tahun =  $('#tahun').val();
		tahap =  $('#tahap').val();
		kategori_data =  $('#kategori_data').val();

		start_loading('Mencari data di Sipedal');





		$.ajax({
			url: baseUrl('integrasi_aplikasi/get_data_sipedal'),
			type: 'POST',
			// dataType: 'JSON',
			data: {
				id_instansi : id_instansi,
				tahun : tahun,
				tahap : tahap
			}	,
			success: function(data) {

				stop_loading();
				$('#show_data_sipd').html(data);
					$('#searching_button').removeAttr("disabled","disabled");
				 	$('#searching_button').html(`Searching`);

			},
			error: function(jqXHR, textStatus, errorThrown) {
				Swal.fire
				stop_loading();
			}
		});
	


 }

	 function import_sipedal_ke_sbe(link_api, belum_terimport, id_instansi, tahun, jenis){

		Swal.fire({
			  title: 'Warning',
			  html: 'Apakah anda akan melakukan import data di Sipedal ke Data Paket Pekerjaan, '+ belum_terimport+' data akan di importkan.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonHtml: 'Import',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
					$('#progres_import').modal('show');
					start_loading('Import data paket pekerjaan dari Sipedal ke Simbangda');
					
  					$.ajax({
						url: baseUrl('integrasi_aplikasi/import_sipedal_ke_sbe'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							link : link_api,
							tahun : tahun,
							id_instansi : id_instansi,
							jenis : jenis
						},
						success: function(data) {
							Swal.fire(data.instruksi, data.message,data.swal_code);
							stop_loading();
							if (data.success==true) {
							}
								var id_opd = data.id_opd ; 
								window.location.href= baseUrl('integrasi_aplikasi/cek_import_sipedal?id_opd='+id_opd+'&tahun=' + tahun);
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert('e');
						}
					});
			  }
			});




	


 }
	



	function kelola_import_sipedal(id_instansi)
	{
		$('#list_paket_import_sipedal').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('integrasi_aplikasi/dt_paket_import_integrasi_sipedal/'),
				            type 	: "POST",
				          	data 	: {
				          		id_instansi : id_instansi,
				          	}
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



	function edit_sub_kegiatan_import_sipedal(kode_sub_kegiatan, id_paket_pekerjaan)
	{
		$('#edit_sub_kegiatan_import_sipedal').modal('show');
		$('#edit_sub_kegiatan_import_sipedal').find('#kode_sub_kegiatan').val(kode_sub_kegiatan);
		$('#edit_sub_kegiatan_import_sipedal').find('#id_paket_pekerjaan').val(id_paket_pekerjaan);




		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/get_paket_pekerjaan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_paket_pekerjaan : id_paket_pekerjaan,
            	jenis_input :' jenis_input' 
            },
            success : function(data)
            {
				console.log(data);
				$('#edit_sub_kegiatan_import_sipedal').find('#nama_paket').html(data.data.nama_paket);
				$('#edit_sub_kegiatan_import_sipedal').find('#jenis_paket').html(data.data.jenis_paket);
				$('#edit_sub_kegiatan_import_sipedal').find('#pagu_paket').html(data.data.pagu);
				$('#edit_sub_kegiatan_import_sipedal').find('.nama_sub_kegiatan').html(data.data.nama_sub_kegiatan);
				$('#edit_sub_kegiatan_import_sipedal').find('.kode_sub_kegiatan').html(data.data.kode_rekening_sub_kegiatan);
				$('#edit_sub_kegiatan_import_sipedal').find('.nama_metode').html(data.data.nama_metode);
            }
        });
	
	}

	function edit_kategori_import_sipedal(id_paket_pekerjaan)
	{
		$('#edit_kategori_import_sipedal').modal('show');
		$('#edit_kategori_import_sipedal').find('#id_paket_pekerjaan').val(id_paket_pekerjaan);




		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/get_paket_pekerjaan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_paket_pekerjaan : id_paket_pekerjaan,
            	jenis_input :' jenis_input' 
            },
            success : function(data)
            {
				console.log(data.data);
				$('#edit_kategori_import_sipedal').find('#nama_paket').html(data.data.nama_paket);
				$('#edit_kategori_import_sipedal').find('#jenis_paket').html(data.data.jenis_paket);
				$('#edit_kategori_import_sipedal').find('#pagu_paket').html(data.data.pagu);
				var kategori = data.data.kategori =='' ? 'Belum Ditentukan' : data.data.kategori;
				$('#edit_kategori_import_sipedal').find('#kategori').html(kategori);
            }
        });
	
	}

	function simpanedit_sub_kegiatan_import_sipedal(kode_sub_kegiatan, kode_kegiatan, kode_program, kode_bu)
	{
		var id_paket_pekerjaan = $('#edit_sub_kegiatan_import_sipedal').find('#id_paket_pekerjaan').val();

		console.log(id_paket_pekerjaan);


		$.ajax({
			url: baseUrl('integrasi_aplikasi/simpanedit_sub_kegiatan_import_sipedal'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_paket : id_paket_pekerjaan, 
				kode_sub_kegiatan : kode_sub_kegiatan,
				kode_kegiatan : kode_kegiatan,
				kode_program : kode_program,
				kode_bu : kode_bu,
			},
			success: function (data)
			{
				console.log(data);

		$('#edit_sub_kegiatan_import_sipedal').modal('hide');
				$('#list_paket_import_sipedal').DataTable().ajax.reload(null, false);
			},
			error: function (jqXHR, textStatus, errorThrown) {

			}
		});
	
	}
	function simpanedit_kategori_import_sipedal()
	{
		var id_paket_pekerjaan = $('#edit_kategori_import_sipedal').find('#id_paket_pekerjaan').val();
		var kategori = $('#edit_kategori_import_sipedal').find('#option_kategori').val();

		console.log(kategori);

		$.ajax({
			url: baseUrl('integrasi_aplikasi/simpanedit_kategori_import_sipedal'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_paket : id_paket_pekerjaan, 
				kategori : kategori, 
			
			},
			success: function (data)
			{
				console.log(data);

		$('#edit_kategori_import_sipedal').modal('hide');
				$('#list_paket_import_sipedal').DataTable().ajax.reload(null, false);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log('error');

			}
		});
	
	}

	function sinkron_lokasi_import_sipedal()
	{
		
		start_loading('Sinkronisasi Lokasi Sipedal ke Simbangda');
		// Swal.fire('Development', 'Jika sukses di redirect langsung ke halaman pengelolaan','info');
		$.ajax({
			url: baseUrl('integrasi_aplikasi/sinkron_lokasi_import_sipedal'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				
			
			},
			success: function (data)
			{
				stop_loading();
				$('#list_paket_import_sipedal').DataTable().ajax.reload(null, false);
				$('#tombol_sinkron_lokasi').attr('hidden','true');
							// if (data.success==true) {
							// 	var id_opd = data.id_opd ; 
							// 	window.location.href= baseUrl('integrasi_aplikasi/cek_import_sipedal?id_opd='+id_opd+'&tahun=' + tahun);
							// }
							// // get_data_integrasi_sipedal();
							// // $('#progres_import').modal('hide');
				Swal.fire(data.instruksi, data.message,data.swal_code);


			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log('error');

			}
		});
	
	}

</script>