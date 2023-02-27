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
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	let status_show_pptk = 'collapse';
	let status_paket 	 = 'save';
	$(document).ready(function()
	{
	   	showKpa();
	   	select2();
	   	showAutoCurrency();
	   	show_paket_export();




	});

	function showAutoCurrency(){
		$('input.currency').number( true, 0 );
	}

	/* Fungsi untuk menampilkan KPA */
	function showKpa()
	{
		$('#table-kpa').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('paket_pekerjaan/dt_kpa/'),
				            type 	: "POST",
				          	data 	: {},
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

    	});
	}

	$('#table-kpa').on('click', '#show-pptk', function()
	{
		let id_user 		= $(this).attr('id-user');
		let table       	= $(this).parent().parent()[0];
		var id_detail       = 'list-pptk-'+$(this).attr('id-user');
		let tr_detail_pptk 	= '';

		tr_detail_pptk  = '<tr colspan="6" class="card-body formulir" id="'+id_detail+'" rowspan="1">';
        tr_detail_pptk +=     '<td rowspan="1" colspan="6">';
        tr_detail_pptk +=     '<div class="table-responsive">';
	    tr_detail_pptk += 		'<table class="table table-sm">' +
			                  		'<thead>' +
			                    		'<tr>' +
			                        		'<th width="1%"></th>' +
			                            	'<th></th>' +
			                            	'<th></th>' +
			                            	'<th></th>' +
			                        	'</tr>' +
			                    	'</thead>' +
			                    	'<tbody id="list-pptk'+id_user+'">' +
			                    	'</tbody>' +
			                  	'</table>';
        tr_detail_pptk +=      '</td>';
        tr_detail_pptk +=     '</div>';
        tr_detail_pptk += '</tr>';

		if(status_show_pptk == 'collapse')
		{
			status_show_pptk = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_pptk);
			listPptk(id_user);
		}else{
			status_show_pptk = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
	});

	$('#table-kpa').on('click', '#list-kegiatan', function()
	{
		let id_user 			= $(this).attr('id-user');
		let table 				= $(this).parent().parent()[0];
		var id_detail       	= 'list-kegiatan-'+$(this).attr('id-user');
		let status_kegiatan 	= $(this).attr('status');
		let tr_detail_kegiatan	= '';

		tr_detail_kegiatan  = '<tr colspan="6" class="card-body formuliri" id="'+ id_detail +'" rowspan="1">';
		tr_detail_kegiatan +=     '<td rowspan="1" colspan="6">';
	    tr_detail_kegiatan +=   	'<table class="table table-sm">' +
		    							'<thead>' +
				                    		'<tr>' +
				                    			'<th width="1%">Action</th>' +
				                        		'<th width="1%">Kode Rekening</th>' +
				                            	'<th>Kegiatan</th>' +
				                            	'<th>Pagu</th>' +
				                            	'<th>Total Paket</th>' +
				                        	'</tr>' +
				                    	'</thead>' +
			                            '<tbody id="list-kegiatan-pptk-'+ id_user +'">' +

			                            '</tbody>' +
			                        '</table>';
		tr_detail_kegiatan +=     '</td>';
        tr_detail_kegiatan += '</tr>';

        if(status_kegiatan == 'collapse')
		{
			$(this).attr('status','expand');
			$(this).html('-');
			$(table).after(tr_detail_kegiatan);
			listKegiatan(id_user);
		}else{
			$(this).attr('status','collapse');
			$(this).html('+');
			$('#'+ id_detail).remove();
		}
	});

	$('#table-kpa').on('click', '#list-paket', function()
	{
		let id_pptk 		= $(this).attr('id-pptk');
		let table 			= $(this).parent().parent()[0];
		let kode_rekening   = $(this).attr('kode-rekening');
		let kode_urusan 	= $(this).attr('kode-urusan');
		let id_table 		= kode_rekening.split('.').join("-");
		var id_detail       = 'list-paket-'+ id_table;
		let status_paket 	= $(this).attr('status');
		let kedudukan 		= $(this).attr('kedudukan');
		let tr_detail_paket	= '';

		tr_detail_paket  = '<tr colspan="6" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_detail_paket +=     '<td rowspan="1" colspan="6">';
		// tr_detail_paket +=     tombol_tambah_paket(id_pptk, kode_rekening, kode_urusan);
		tr_detail_paket += 		'<button class="btn btn-info btn-sm mb-2" onclick="addMasterPaket('+"'"+ id_pptk +"','"+ kode_rekening +"','"+ kode_urusan +"'"+')">Tambah Paket</button>';
	    tr_detail_paket +=   	'<div class="mb-3 card">' +
                                    '<div class="card-body">' +
                                        '<table id="table-paket-'+ id_table +'" class="display" style="width:100%">' +
	                                        '<thead>' +
		                                        '<tr>' +
		                                            '<th width="1%">No</th>' +
		                                            '<th>Paket</th>' +
		                                            '<th>Jenis</th>' +
		                                            '<th>Metode</th>' +
		                                            '<th>Lokasi</th>' +
		                                            '<th>Vol</th>' +
		                                            '<th>Pagu</th>' +
		                                            '<th></th>';
		tr_detail_paket +=                      '</tr>';
	    tr_detail_paket +=                  '</thead>';
	    tr_detail_paket +=              '</table>';
        tr_detail_paket +=          '</div>';
        tr_detail_paket +=      '</div>';
		tr_detail_paket +=     '</td>';
        tr_detail_paket += '</tr>';

        if(status_paket == 'collapse')
		{
			$(this).attr('status','expand');
			$(this).html('-');
			$(table).after(tr_detail_paket);
			showPaket(id_table,id_pptk);
		}else{
			$(this).attr('status','collapse');
			$(this).html('+');
			$('#'+ id_detail).remove();
		}

	});
	function tombol_tambah_paket(id_pptk, kode_rekening, kode_urusan=''){
		var sisa_anggaran = anggaran_tersedia(kode_rekening);
		if (sisa_anggaran>0) {
			button= '<button class="btn btn-info btn-sm mb-2" onclick="addMasterPaket('+"'"+ id_pptk +"','"+ kode_rekening +"','"+ kode_urusan +"'"+')">Tambah Paket</button>';
		}else{
			button= '<button class="btn btn-danger btn-sm mb-2" onclick="anggaran_habis()">Tambah Paket</button>';
		}
		return button;
	}
	function anggaran_habis(){
		Swal.fire(
			      'Forbidden!',
			      'Anggaran bernilai 0. Anda tidak bisa menambahkan paket',
			      'warning'
			    );
	}
	function edit_paket(id_paket_pekerjaan, jenis_input)
	{
		status_paket = 'update';
		$('#modalMasterPaket').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#formMasterPaket').attr('style', '');
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/get_paket_pekerjaan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_paket_pekerjaan : id_paket_pekerjaan,
            	jenis_input : jenis_input 
            },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#input_type').val(jenis_input);
                	$('#id_pptk').val(data.data.id_pptk);
                	$('#kode_rekening_kegiatan').val(data.data.kode_rekening_kegiatan);
                	var pagu_tersedia = anggaran_tersedia(data.data.kode_rekening_kegiatan);
                	$('#anggaran_tersedia').val(pagu_tersedia);
                	$('#id_paket_pekerjaan').val(id_paket_pekerjaan);
                	$('#nama_paket').val(data.data.nama_paket);
                	$('#jenis_paket').val(data.data.jenis_paket).trigger('change');
                	$('#pagu').val(data.data.pagu);
                	$('#anggaran_sebelumnya').val(data.data.pagu);
                	list_metode(data.data.jenis_paket,data.data.id_metode);
                	$('#kategori').val(data.data.kategori).trigger('change');
                }
            }
        });

		$('#btnSaveMasterPaket').hide();
		$('#btnUpdateMasterPaket').show();
	}

	$('#table-kpa').on('click', '#list-detail-paket', function()
	{
		let id_paket_pekerjaan 		= $(this).attr('id-paket-pekerjaan');
		let table 					= $(this).parent().parent()[0];
		var id_detail       		= 'list-detail-paket-'+ id_paket_pekerjaan;
		let status_paket 			= $(this).attr('status');
		let kedudukan 				= $(this).attr('kedudukan');
		let tr_paket_detail			= '';

		tr_paket_detail  = '<tr colspan="8" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_paket_detail +=     '<td rowspan="1" colspan="8">';
	    tr_paket_detail +=   	'<div class="mb-3 card">';
        tr_paket_detail +=          '<div class="card-body">';
        tr_paket_detail += 				'<div class="col-md-6">' +
											'<div id="mapid"></div>' +
										'</div>';
        tr_paket_detail +=          '</div>';
        tr_paket_detail +=      '</div>';
		tr_paket_detail +=     '</td>';
        tr_paket_detail += '</tr>';

        if(status_paket == 'collapse')
		{
			$(this).attr('status','expand');
			$(this).html('-');
			$(table).after(tr_paket_detail);

			var map = L.map('mapid').setView([-0.9377094,100.3613245], 9);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			var myFeatureGroup 	= L.featureGroup().addTo(map).on("click", groupClick);
			var myMarker;

			$.getJSON(baseUrl('paket_pekerjaan/get_project'), function(data){
				$.each(data, function(i, field)
				{
					var v_lat  = parseFloat(data[i].latitude);
					var v_long = parseFloat(data[i].logitude);

					var iconMarker = L.icon({
						iconUrl  : baseUrl('assets/marker/default_marker.png'),
						iconSize : [ 50, 50]
					});

					myMarker    = L.marker([v_lat,v_long],{icon : iconMarker})
									.addTo(myFeatureGroup)
								 	.bindPopup(data[i].project_name)
					myMarker.id = data[i].id_project;
				});
			});

			map.on('click', onMapClick);
		}else{
			$(this).attr('status','collapse');
			$(this).html('+');
			$('#'+ id_detail).remove();
		}

	});

	function onMapClick(e) {
	    alert("You clicked the map at " + e.latlng);
	}

	function groupClick(event)
	{

		getLocation();
	}

	function getLocation() {
	   var geolocation = navigator.geolocation;
	   geolocation.getCurrentPosition(showLocation, errorHandler);
	}

	function showLocation( position ) {
	   var latitude = position.coords.latitude;
	   var longitude = position.coords.longitude;

	}

	function export_paket() {
		$('#modal-export-paket').modal('show')
			.find('.modal-title').text('Export Paket Pekerjaan');
	//	list_dokumen(id_instansi, id_kpa, id_pptk, id_paket_pekerjaan, kode_rekening_kegiatan, jenis_paket, id_metode);
	}


	function errorHandler( err )
	{
	   if (err.code == 1) {
	   }
	}

	function listPptk(id_user_top_parent = '')
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_pptk/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_user_top_parent : id_user_top_parent },
            success : function(data)
            {
                if(data.status == true)
                {
                	$.each(data.data, function(k, v){
                		$('#list-pptk'+id_user_top_parent).append('<tr>' +
		                                '<th scope="row"><button id="list-kegiatan" status="collapse" id-user="'+ v.id_user +'" class="btn btn-info btn-xs">+</button></th>' +
		                                '<td><strong>'+ v.sub_instansi +'</strong> [ '+ v.nama +' ]</td>' +
		                                '<td>'+ v.jml_keg +' Kegiatan </td>' +
		                                '<td>'+ v.jml_paket +' Paket </td>' +
		                            '</tr>');
                	});
                }
            }
        });
	}

	function listKegiatan(id_user = '')
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_user : id_user },
            success : function(data)
            {
                if(data.status == true)
                {
                	$.each(data.data, function(k, v){
                		$('#list-kegiatan-pptk-'+ id_user).append('<tr>' +
                								'<td><button id="list-paket" status="collapse" id-pptk="'+ v.id_pptk +'" kode-rekening="'+ v.rekening +'" kode-urusan="'+ v.kode_urusan +'" class="btn btn-info btn-xs">+</button></td>' +
				                                '<td>'+ v.rekening +'</td>' +
				                                '<td>'+ v.kegiatan +'</td>' +
				                                '<td>'+ v.pagu +'</td>' +
				                                '<td>'+ v.jml_paket +' Paket</td>' +
				                            '</tr>');
                	});
                }
            }
        });
	}

	/* Fungsi untuk menampilkan modal add master paket */
	function addMasterPaket(id_pptk, kode_rekening, kode_urusan)
	{
		$('#formMasterPaket')[0].reset();
		var pagu_tersedia = anggaran_tersedia(kode_rekening);

		status_paket = 'save';
	    $('#modalMasterPaket').modal('show')
					  		  .find('.modal-title').html('Tambah Paket<br>Anggaran Tersedia : ' + convert_ke_rupiah(pagu_tersedia));
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	    $('.text-danger').remove();
	    $('#btnUpdateMasterPaket').hide();


		if (pagu_tersedia<=0) {
			$('#formMasterPaket').attr('style', 'display:none');
			$('#pesan_mnodal_paket').html('<div class="alert alert-info">Anda tidak bisa menambahkan paket karena anggaran tersisa 0</div>');
			$('#btnSaveMasterPaket').hide();
			
		}else{
			$('#pesan_mnodal_paket').html('');
			$('#formMasterPaket').attr('style', '');
			$('#anggaran_sebelumnya').val(0);
			$('#anggaran_tersedia').val(pagu_tersedia);
			$('#id_pptk').val(id_pptk);
			$('#kode_rekening_kegiatan').val(kode_rekening);
			$('#kode_urusan').val(kode_urusan);
		    
		    $('#jenis_paket').trigger('change');
		    $('#id_metode').trigger('change');
		
		    $('#btnSaveMasterPaket').show();
			
		}
	}




	function convert_ke_rupiah(bilangan){
		//var bilangan = 23456789;
	
		var	number_string = bilangan.toString(),
			sisa 	= number_string.length % 3,
			rupiah 	= number_string.substr(0, sisa),
			ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
				
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		// Cetak hasil
		return rupiah;
	}


	function kelola_export_paket(){
		window.location.href= baseUrl('paket_pekerjaan/kelola_export_paket')
	}
	function select2()
	{
		$('#jenis_paket').select2(
		{
			placeholder : "Pilih Jenis Paket",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});

		$('#id_metode').select2(
		{
			placeholder : "Pilih Metode",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});

		$('#id_kab_kota').select2(
		{
			placeholder : "Pilih Kab/Kota",
			// allowClear	: false,
			// width 		: 'style',
			theme 		: 'bootstrap4'
		});
		list_kab_kota();
		list_provinsi();


		$('#id_provinsi').select2(
		{
			placeholder : "Pilih Provinsi",
			// allowClear	: false,
			// width 		: 'style',
			theme 		: 'bootstrap4'
		});
		$('#id_provinsi').select2(
		{
			placeholder : "Pilih Provinsi",
			// allowClear	: false,
			// width 		: 'style',
			theme 		: 'bootstrap4'
		});

		$('#id_kecamatan').select2(
		{
			placeholder : "Pilih Kecamatan",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
	}

	function list_metode(jenis_paket,x='')
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_metode/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { jenis_paket : jenis_paket },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#switch-metode').show();
                	$('#id_metode').html('');
					$('#id_metode').append('<option value=""></option>');
                	$.each(data.data, function(k, v){
                		var sel = 'selected';
                		if(v.id == x)
                		{
                			$('#id_metode').append('<option value='+ v.id +' '+ sel +'>'+ v.metode +'</option>');
                		}else{
                			$('#id_metode').append('<option value='+ v.id +'>'+ v.metode +'</option>');
                		}
                	});
                }else{
                	$('#switch-metode').hide();
                }
            }
        });

        $('#penyedia').html('');
        if(jenis_paket == 'PENYEDIA')
        {
	        $('#penyedia').append(
	        						'<label for="kategori">Kategori</label>' +
	        						'<select name="kategori" id="kategori" class="form-control">' +
	        							'<option value="NON KONTRUKSI">NON KONTRUKSI</option>' +
	        							'<option value="KONTRUKSI">KONTRUKSI</option>' +
	        						'</select>'
	        					 );
	    }

	    $('#kategori').select2(
		{
			placeholder : "Pilih Kategori",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
	}



	function list_provinsi()
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_provinsi/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : {  },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#id_kab_kota').html('');
					$('#id_kab_kota').append('<option value=""></option>');
                	$.each(data.data, function(k, v){
                		var sel = 'selected';
                		$('#id_provinsi').append('<option value='+ v.id_provinsi +'>'+ v.provinsi +'</option>');
                		// if(v.id == x)
                		// {
                		// 	$('#id_metode').append('<option value='+ v.id +' '+ sel +'>'+ v.metode +'</option>');
                		// }else{
                		// }
                	});
                }else{
                	
                }
            }
        });

      
	}
	function list_kab_kota(id_provinsi)
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_provinsi : id_provinsi},
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#id_kab_kota').html('');
					$('#id_kab_kota').append('<option value=""></option>');
                	$.each(data.data, function(k, v){
                		$('#id_kab_kota').append('<option value='+ v.id +'>'+ v.kab_kota +'</option>');
                	});
                }
            }
        });
	}

	function list_kecamatan(id_kab_kota)
	{
		var id_paket = $('#modal-lokasi-paket').find('#id_paket').val();
		console.log(id_paket);
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_kecamatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_kab_kota : id_kab_kota , id_paket : id_paket},
            success : function(data)
            {
            	console.log(data)
                if(data.status == true)
                {
                	$('#id_kecamatan').html('');
					$('#id_kecamatan').append('<option value=""></option>');
                	$.each(data.data, function(k, v){
                		$('#id_kecamatan').append('<option value='+ v.id +'>'+ v.kecamatan +'</option>');
                	});
                }
            }
        });
	}

	function show_paket_export() {
		$('#table-kelola-export-paket').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('paket_pekerjaan/dt_paket_export/'),
				type: "POST",
				data: {},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}
	function anggaran_tersedia(kode_rekening)
	{
		var sisa_anggaran ;
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/anggaran_tersedia/'),
            dataType: 'JSON',
            type    : 'POST',
            async: false,
            data    : { kode_rekening : kode_rekening},
            success : function(data)
            {
            	result = data.data.anggaran_tersedia
            }, 
            error : function(){

            }
        });
        return result;
	}
	

	function list_kec_kel(id_kab_kota)
	{
		$.ajax(
        {
            url     : baseUrl('paket_pekerjaan/list_kec_kel/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_kab_kota : id_kab_kota },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#id_kec_kel').html('');
					$('#id_kec_kel').append('<option value=""></option>');
                	$.each(data.data, function(k, v){
                		$('#id_kec_kel').append('<option value='+ v.id +'>'+ v.kec_kel +'</option>');
                	});
                }
            }
        });
	}

	function saveMasterPaket()
	{
		let id_pptk 	= $('#id_pptk').val();
		let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax({
			url: baseUrl('paket_pekerjaan/save_master_paket'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#formMasterPaket').serialize(),
			success: function (data)
			{

				if(data.success == true)
				{
					if(data.messages == "Anggaran paket melebihi pagu kegiatan"){
						var value = '<p class="text-danger">' +data.messages + ". Maksimal anggaran yang diperbolehkan " + data.anggaran_dibolehkan + '</p>';
						var element = $('#pagu');
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					}else{
						$('#formMasterPaket')[0].reset();
						$('#modalMasterPaket').modal('hide');
						showPaket(id_table, id_pptk);
					}
				}else{
					$.each(data.messages, function (key, value)
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

	function updateMasterPaket()
	{
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		let id_pptk 	= $('#id_pptk').val();
		let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$.ajax({
			url: baseUrl('paket_pekerjaan/update_master_paket'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#formMasterPaket').serialize(),
			success: function (data)
			{
				console.log(data);
				if(data.success == true)
				{
					if(data.messages == "Anggaran paket melebihi pagu kegiatan"){
						var value = '<p class="text-danger">' +data.messages + ". Maksimal anggaran yang diperbolehkan " + data.anggaran_dibolehkan + '</p>';
						var element = $('#pagu');
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					}else{
						$('#formMasterPaket')[0].reset();
						$('#modalMasterPaket').modal('hide');
						if (data.input_type=="export") {
							show_paket_export();
						}else{
							showPaket(id_table, id_pptk);
						}

					}


					// $('#formMasterPaket')[0].reset();
					// $('#modalMasterPaket').modal('hide');
					// showPaket(id_table, id_pptk);
				}else{
					$.each(data.messages, function (key, value)
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

	function showPaket(id_table, id_pptk)
	{
		let kode_rekening = id_table.split('-').join('.');
		id_table_active   = id_table;

		$('#table-paket-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('paket_pekerjaan/dt_paket/'),
				            type 	: "POST",
				          	data 	: { kode_rekening : kode_rekening, id_pptk : id_pptk },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ -1, 0, 5 ],
							},
							{
								className	: "text-nowrap",
								targets		: [ -1, 2 ],
							},
							{
								className	: "dt-center",
								targets		: [ 0 ],
							},
	        			  ],
	     //    fnRowCallback : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		    //    var index = iDisplayIndex +1;
		    //    $('td:eq(0)',nRow).html(index);
		    //    return nRow;
		    // }

    	});
	}

	function lokasi(id_paket_pekerjaan , jenis_input)
	{
		$('#modal-lokasi-paket').modal('show');
		$('#id_paket').val(id_paket_pekerjaan);
		$('#modal-lokasi-paket').find('#input_type').val(jenis_input);
		table_lokasi(id_paket_pekerjaan);
	  	list_provinsi();
		list_kab_kota(id_paket_pekerjaan);
		list_kecamatan(id_kab_kota);
	}

	function table_lokasi(id_paket_pekerjaan)
	{
		$('#id_provinsi').html('');
		$('#id_provinsi').append('<option value=""></option>');
		$('#table-lokasi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('paket_pekerjaan/dt_lokasi/'),
				            type 	: "POST",
				          	data 	: { id_paket_pekerjaan : id_paket_pekerjaan },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0, -1 ],
							},
							{
								className	: "dt-center",
								targets		: [ 0 ],
							},
	        			  ],

    	});
	}

	function tambah_lokasi()
	{
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		let id_paket 	= $('#id_paket').val();
		let id_kecamatan = $('#id_kecamatan').val();
		let id_kab_kota = $('#id_kab_kota').val();
		let id_provinsi	 = $('#id_provinsi	').val();
		let input_type = $('#modal-lokasi-paket').find('#input_type').val();
		
			$.ajax(
			{
				url     : baseUrl('paket_pekerjaan/save_lokasi/'),
				dataType: 'JSON',
				type    : 'POST',
				data    : { 
					id_paket : id_paket, 
					id_kecamatan : id_kecamatan, 
					id_kab_kota : id_kab_kota, 
					id_provinsi : id_provinsi, 
					input_type: input_type
				},
				success : function(data)
				{
					console.log(data);
					if(data.status == true)
					{
						let id_table 	= data.rekening.split('.').join('-');
						list_provinsi();
						$('#id_kab_kota').html('');
						$('#id_kecamatan').html('');
						table_lokasi(id_paket);
						if (data.input_by=='export') {
							show_paket_export();
						}else{
							showPaket(id_table, data.id_pptk);
						}
					}
					else{
						$.each(data.messages, function (key, value)
						{
							var element = $('#' + key);
							element.removeClass('is-invalid')
								.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
								.find('.text-danger')
								.remove();
							element.after(value);
						});
					}
				}
			});
		
	}

	function volume(id_paket_pekerjaan, jenis_input)
	{
		$('#modal-volume-paket').modal('show');
		$('#id_paket_volume').val(id_paket_pekerjaan);
		$('#modal-volume-paket').find('#input_type').val(jenis_input);
		$('#nama_pelaksanaan').val('');
		vol(id_paket_pekerjaan);
	}

	function vol(id_paket_pekerjaan)
	{
		let tipe_input = $('#modal-volume-paket').find('#input_type').val();
		$('#table-vol').DataTable(
		{
	        processing	: false,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('paket_pekerjaan/dt_vol/'),
				            type 	: "POST",
				          	data 	: { id_paket_pekerjaan : id_paket_pekerjaan, tipe_input : tipe_input },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0, -1 ],
							},
							{
								className	: "dt-center",
								targets		: [ 0 ],
							},
	        			  ],

    	});
	}

	function tambah_vol()
	{
		let id_paket = $('#id_paket_volume').val();
		let nama_pel = $('#nama_pelaksanaan').val();
		let tipe_input = $('#modal-volume-paket').find('#input_type').val();
		console.log(tipe_input);
		$.ajax(
		{
			url     : baseUrl('paket_pekerjaan/save_vol/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id_paket : id_paket, nama_pelaksanaan : nama_pel, tipe_input : tipe_input },
			success : function(data)
			{
				console.log(data)
				if(data.status == true)
				{
					let id_table 	= data.rekening.split('.').join('-');
					if (data.input=="export") {
						show_paket_export();
					}else{
						showPaket(id_table,data.id_pptk);
					}
						volume(id_paket);
				}
			}
		});
	}

	function delete_paket(id_paket_pekerjaan, jenis_input)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus paket pekerjaan.?',
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
							url     : baseUrl('paket_pekerjaan/delete_paket/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { id_paket : id_paket_pekerjaan },
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Dihapus!',
								      'Paket Dihapus',
								      'success'
								    );
									let id_table 	= data.rekening.split('.').join('-');
									if (jenis_input=='export') {
										show_paket_export();
									}else{
										showPaket(id_table,data.id_pptk);

									}
								}
							}
						});
			

			  
			  }
			});

















	
	}

	function delete_lokasi(id_lokasi_paket_pekerjaan, id_paket_pekerjaan)
	{
		$.ajax(
		{
			url     : baseUrl('paket_pekerjaan/delete_lokasi/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id_lokasi_paket_pekerjaan : id_lokasi_paket_pekerjaan, id_paket_pekerjaan : id_paket_pekerjaan },
			success : function(data)
			{
				if(data.status == true)
				{
					let id_table 	= data.rekening.split('.').join('-');
					showPaket(id_table,data.id_pptk);
					table_lokasi(id_paket_pekerjaan);
				}
			}
		});
	}

	 // function edit_vol(x) {
  //       $.fn.editableform.buttons = '<button type="submit" class="btn btn-info btn-sm editable-submit">OK</button>' +
  //           '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

  //       let id = $(x).attr('pk');
  //       let id_paket = $(x).attr('id_paket');
  //       $(x).editable({
  //           mode: 'inline',
  //           pk: id,
  //           savenochange: true,
  //           url: baseUrl('realisasi/update_realisasi_keuangan/'),
  //           success: function(c) {
  //               vol(id_paket);
  //           },
  //       });
  //   }


	 function urutkan_pelaksanaan(id_paket) {
        $.ajax({
        	url     : baseUrl('paket_pekerjaan/urutkan_pelaksanaan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id_paket_pekerjaan : id_paket_pekerjaan },
			success : function(data){

				vol(id_paket);

			},
			error : function(){}
        })
    }

	function delete_vol(id_vol_pelaksanaan_pekerjaan, id_paket_pekerjaan , pelaksanaan_ke, tipe_input)
	{




			Swal.fire({
			  title: 'Warning',
			  text: 'Jika anda menghapus volume ini evidence yang telah di upload akan dihapus dari Pelaksanaan ke-'+pelaksanaan_ke+' sampai laporan.',
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
							url     : baseUrl('paket_pekerjaan/delete_vol/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { id_vol_pelaksanaan_pekerjaan : id_vol_pelaksanaan_pekerjaan, id_paket_pekerjaan : id_paket_pekerjaan },
							success : function(data)
							{
								// if(data.status == true)
								// {
									Swal.fire(
								      'Dihapus!',
								      'Volume Dihapus',
								      'success'
								    );
									let id_table 	= data.rekening.split('.').join('-');
									if (tipe_input=='input') {
										showPaket(id_table,data.id_pptk);
									}else{
										show_paket_export();
									}
									vol(id_paket_pekerjaan);
								// }
							}, 
							error: function(){
								Swal.fire(
								      'Dihapus!',
								      'Volume Dihapus Error',
								      'error'
								    );
							}
						});
			

			  
			  }
			});


	}

	function hapus_export_paket()
	{




			Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda akan menghapus semua paket yang jenis inputannya Export Excel.?',
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
							url     : baseUrl('paket_pekerjaan/hapus_export_paket/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : {  },
							success : function(data)
							{
								// if(data.status == true)
								// {
									Swal.fire(
								      'Dihapus!',
								      'Semua paket inputan export telah dihapus.!',
								      'success'
								    );
									// let id_table 	= data.rekening.split('.').join('-');
									show_paket_export();
								// }
							}, 
							error: function(){
								Swal.fire(
								      'Dihapus!',
								      'Volume Dihapus Error',
								      'error'
								    );
							}
						});
			

			  
			  }
			});


	}
</script>
