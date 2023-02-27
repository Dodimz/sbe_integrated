<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- X-editable -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
	let skala = 0.9;
	let lebar = 0;

	window.setTimeout("lebars()",1000);

	$(document).on('ready', function(){
		var fetch_method = '<?php echo $fetch_method; ?>';
		if (fetch_method=='daftar_sub_instansi') {
		   	list_user('<?php echo tahun_anggaran() ?>','<?php echo tahapan_apbd() ?>');
		}
		else if (fetch_method=='pptk_kegiatan') {
		   	pptk_kegiatan('<?php echo tahun_anggaran() ?>','<?php echo tahapan_apbd() ?>', fetch_method);
		}else{
			show_diagram();
		}

	});



function list_user(tahun, kode_tahap)
	{
		var nama_tahap ; 
		if (kode_tahap==2) {
			nama_tahap = "APBD Awal";
		}else if(kode_tahap ==4){
			nama_tahap = "APBD Perubahan";

		}else{
			nama_tahap = "APBD Pergeseran";

		}
		$('#periode').html("<br>" +nama_tahap + " "+ tahun );
		

		$('#table-user-struktur').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('struktur_instansi/list_user_struktur_instansi/'),
				            type 	: "POST",
				          	data 	: {
				          		tahun : tahun,
				          		tahap : kode_tahap
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




function pptk_kegiatan(tahun, kode_tahap, fetch_method)
	{
		var input_by = "all";
	
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('struktur_instansi/sub_kegiatan_apbd_instansi_gabungan/' + input_by),
				            type 	: "POST",
				          	data 	: {
				          		tahun : tahun,
				          		tahap : kode_tahap,
				          		fetch_method : fetch_method,
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





	function show_diagram()
	{
		$('#diagram_container').html('');
		lebar = $('#diagram').width();
		var diagram = new dhx.Diagram("diagram_container",
		{
			type 			: "org",
			defaultShapeType: "img-card",
			scale 			: skala
		});

		diagram.data.load("<?php echo base_url('struktur_instansi/get_sub_instansi'); ?>").then(function(){
			cek_data_sub_instansi();
		});

		diagram.events.on("ShapeClick", function (id)
		{
			let id_user = diagram.data.getItem(id).id_user;
			$('#modal-informasi-detail').modal('show')
										.find('.modal-title').text('Informasi Detail');
			$('#idx').val(id);
			$('#id_kpa').val(id_user);
			get_data_detail_user(id_user);
		});
	}

	function cek_data_sub_instansi()
	{
		$.getJSON(baseUrl('struktur_instansi/cek_data_sub_instansi/'), function(data) {
			if(data.status == false)
			{
				$('.tambah-sub-instansi').show();
			}else{
				$('.tambah-sub-instansi').hide();
			}
		});
	}

	function tambah_sub_instansi(id_kedudukan = "")
	{
		$('#modal-tambah-sub-instansi').modal('show')
									   .find('.modal-title').text('Tambah Struktur Instansi');
		$('#form-tambah-sub-instansi')[0].reset();
		$("#id_kedudukan").select2(
		{
			theme 		: "bootstrap4",
			placeholder	: "Pilih Kedudukan"
		});

		$.ajax(
        {
            url     : baseUrl('struktur_instansi/list_kedudukan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : {},
            success : function(data)
            {
                if(data.status == true)
                {
					$('#id_kedudukan').html('');
					$('#id_kedudukan').append('<option></option>');
					$.each(data.data, function(k, v)
					{
						$('#id_kedudukan').append(
													'<option value="'+ v.id_kedudukan +'">'+ v.nama_kedudukan +'</option>'
											 	 );
					});
				}
			}
		});
	}

	function save_sub_instansi(form)
	{
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/save_sub_instansi/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : $('#'+ form).serialize(),
			success : function(data)
			{
				if(data.status == true)
				{
					list_kegiatan();
					show_list_kegiatan(data.id);
					$('#modal-tambah-sub-instansi').modal('hide');
					$('#form-tambah-sub-instansi')[0].reset();
					show_diagram();
				}
			}
		});
	}

	function lebars()
	{
		$('svg').attr('width',lebar);
		setTimeout("lebars()",1000);
	}

	function get_data_detail_user(id, fetch_method)
	{
		if (fetch_method=='list_user_struktur_instansi') {
			$('#modal-informasi-detail').modal('show')
										.find('.modal-title').text('Informasi Detail');
		}
		// alert(fetch_method);
		$.ajax(
        {
            url     : baseUrl('struktur_instansi/user_detail/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : {
						id : id
            		  },
            success : function(data)
            {


            	console.log(data);
                if(data.status == true)
                {
	            	if(data.jumlah_data==0){
						$('.copy_sub_kegiatan').show();
	            	}else{
						$('.copy_sub_kegiatan').hide();
	            	}



					if(data.data.id_kedudukan==3){
						$('#ganti_struktur_instansi').html(`<button type="button" class="btn btn-outline-info" onclick="ganti_sub_instansi_pptk('`+data.data.id_kedudukan+`','`+data.data.id_user+`')" id="hapus_sub_instansi">Ganti PPTK</button>`);
					}else{
						$('#ganti_struktur_instansi').html(`<button type="button" class="btn btn-danger" onclick="ganti_sub_instansi_pptk('`+data.data.id_kedudukan+`','`+data.data.id_user+`')" id="hapus_sub_instansi">Ganti PA /KPA</button>`);

					}
					$('#id_user').val(id);
                	$('#detail-user').html('');
                	$('#detail-user').append('<input type="hidden" id="id_sub_instansi" value="'+ data.data.id_sub_instansi +'">');
                	$('#detail-user').append('<input type="hidden" id="id_kedudukan_user" value="'+ data.data.id_kedudukan +'">');
                	$('#detail-user').append('<tr>' +
                							  	'<th scope="row">Nama Lengkap</th>' +
												'<th width="1%" >:</th>' +
												'<th><a href="#" id="full_name" name="full_name" pk="'+ id +'" data-type="text" onclick="edit_data(this,'+"'user'"+')">'+ data.data.nama_lengkap +'</a></th>' +
											 '</tr>' +
											 '<tr>' +
												'<th scope="row">Sub Instansi</th>' +
												'<th width="1%" >:</th>' +
												'<th><a href="#" id="nama_sub_instansi" name="nama_sub_instansi" pk="'+ data.data.id_sub_instansi +'" data-type="text" onclick="edit_data(this,'+"'sub_instansi'"+')">'+ data.data.sub_instansi +'</a></th>' +
											 '</tr>' +
											 '<tr>' +
												'<th scope="row">Kedudukan</th>' +
												'<th width="1%" >:</th>' +
												'<th><a href="#" id="id_kedudukan" name="id_kedudukan" pk="'+ id +'" data-type="select" onclick="edit_data(this,'+"'user'"+')">'+ data.data.kedudukan +'</a></th>' +
											 '</tr>' +
											 '<tr>' +
												'<th scope="row">Username</th>' +
												'<th width="1%" >:</th>' +
												'<th><a href="#" id="username" name="username" pk="'+ id +'" data-type="text" onclick="edit_data(this,'+"'user'"+')">'+ data.data.username +'</a></th>' +
											 '</tr>' +
											 '<tr>' +
												'<th scope="row">E-Mail</th>' +
												'<th width="1%" >:</th>' +
												'<th><a href="#" id="email" name="email" pk="'+ id +'" data-type="text" onclick="edit_data(this,'+"'user'"+')">'+ data.data.email +'</a></th>' +
											 '</tr>' +
											 '<tr>' +
												'<th scope="row">Status User</th>' +
												'<th width="1%" >:</th>' +
												'<th>'+ data.data.aktif +'</th>' +
											 '</tr>');
                	if(data.data.kedudukan == 'PPTK')
                	{
						list_kegiatan();
                		show_list_kegiatan(id);
                		$('#btn_tambah_sub_instansi').hide();
                	}else{
						$('.select-kegiatan').hide();
						$('.list-kegiatan').hide();
                		$('#hapus_sub_instansi').hide();
                		$('#btn_tambah_sub_instansi').show();
					}

                	if(data.data.id_kedudukan != 1)
                	{
                	}else{
						
					}
                		$('#hapus_sub_instansi').show();
				}
			}
		});
	}

	function ganti_sub_instansi_pptk(id_kedudukan, id_user){
		$('#modal-ganti-struktur').modal('show');
		
		$('#modal-ganti-struktur').find('#id_kedudukan').val(id_kedudukan);
		$('#modal-ganti-struktur').find('#id_user').val(id_user);
		$.ajax(
        {
            url     : baseUrl('struktur_instansi/user_detail/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : {
						id : id_user
            		  },
            success : function(data)
            {
				console.log(data);
				$('#modal-ganti-struktur').find('#nama_kedudukan').val(data.data.kedudukan);
				$('#modal-ganti-struktur').find('#full_name').val(data.data.nama_lengkap);
				$('#modal-ganti-struktur').find('#nama_sub_instansi').val(data.data.sub_instansi);
				$('#modal-ganti-struktur').find('#id_sub_instansi').val(data.data.id_sub_instansi);

				
				$('#modal-ganti-struktur').find('#full_name_lama').val(data.data.nama_lengkap);
				$('#modal-ganti-struktur').find('#nama_sub_instansi_lama').val(data.data.sub_instansi);
			},
			error : function(){

			}
		});
	}
	function edit_data(x,y)
	{
		$.fn.editableform.buttons  = '<button type="submit" class="btn btn-primary editable-submit">OK</button>' +
			'<button type="button" class="btn btn-info editable-cancel">Batal</button>';

		let id = $(x).attr('pk');

		$(x).editable({
			validate: function(value) {
	           if($.trim(value) == '') return 'Tidak boleh kosong !';
	        },
	        prepend: 'Silahkan Pilih',
	        source: [
	            {value: 1, text: 'PA'},
	            {value: 2, text: 'KPA'},
	            {value: 3, text: 'PPTK'},
	            {value: 4, text: '-'}
	        ],
    		mode : 'inline',
    		pk : id,
    		savenochange : false,
    		url : baseUrl('struktur_instansi/update_data_user/'+ y),
    		success: function(c)
    		{
    			// get_target(rekening, pagu);
    		},
    	});
	}

	function list_kegiatan()
	{
		$("#sub_kegiatan").select2(
		{
			theme 		: "bootstrap4",
			placeholder	: "Pilih Sub Kegiatan"
		});

		$.ajax(
        {
            url     : baseUrl('struktur_instansi/list_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : {},
            success : function(data)
            {
				
                if(data.status == true)
                {
					$('.select-kegiatan').show();
					$('#sub_kegiatan').html('');
					$('#sub_kegiatan').append('<option></option>');
					$.each(data.data, function(k, v)
					{
						$('#sub_kegiatan').append(
											'<option value="'+ v.rekening_sub_kegiatan +'_'+ v.rekening_kegiatan +'_'+ v.rekening_program +'_'+ v.rekening_bu +'_'+ v.kode_tahap +'">['+v.nama_tahap+'] '+ v.nama_sub_kegiatan + v.keterangan +'</option>'
										 	 );
					});
				}else{
					$('.select-kegiatan').hide();
				}
			},
			error : function (){
				
			}
		});
	}

	function show_list_kegiatan(id)
	{
		$('.list-kegiatan').show();
		$('#table-list-sub-kegiatan').DataTable(
		{
			processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('struktur_instansi/dt_list_sub_kegiatan/'),
				            type 	: "POST",
				          	data 	: { id : id },
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
	     //    processing	: false,
	     //    serverSide	: true,
	     //    bDestroy	: true,
	     //    responsive	: true,
	     //    ajax		: {
				  //         	url 	: baseUrl('struktur_instansi/dt_list_sub_kegiatan/'),
				  //           type 	: "POST",
				  //         	data 	: { id : id },
	     //    			  },
	     //    columnDefs  : [
						//   	{
						//     	targets	 	: [ 0, -1 ],
						//     	orderable 	: false,
						//     },
						//     {
						// 		width		: "1%",
						// 		targets		: [ 0, 1, -1 ],
						// 	},
						// 	{
						// 		className	: "dt-center",
						// 		targets		: [ -1 ],
						// 	}
	     //    			  ],
	     //    fnRowCallback : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		    //    var index = iDisplayIndex +1;
		    //    $('td:eq(0)',nRow).html(index);
		    //    return nRow;
		    // }
    	});
	}

	function tambah_kegiatan()
	{
		let id_user  = $('#id_user').val();
		let rekening = $('#sub_kegiatan').val();
		let via = 'kegiatan_pptk';
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/save_pptk_kegiatan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id_user : id_user,
			 rekening : rekening,
			 via : via 
			},
			success : function(data)
			{
				if(data.status == true)
				{
					list_kegiatan();
					show_list_kegiatan(data.id);
				}
			}
		});
	}

	function tambah_sub_kegiatan()
	{
		let id_user  = $('#id_user').val();
		let rekening = $('#sub_kegiatan').val();
		let via = 'pptk_kegiatan';
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/save_pptk_sub_kegiatan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { 
				id_user : id_user, 
				rekening : rekening , 
				via : via 
				 },
			success : function(data)
			{
				
				if(data.status == true)
				{
					$('.copy_sub_kegiatan').hide();
					list_kegiatan();
				   	$('#table-list-sub-kegiatan').DataTable().ajax.reload(null, false);
					// show_list_kegiatan(data.id);
				}
			}
		});
	}

	function tambah_pptk_kegiatan()
	{
		let id_user  = $('#modal_set_pptk').find('#id_user_pptk').val();
		let kode_sub_kegiatan = $('#kode_sub_kegiatan').val();
		let kode_kegiatan = $('#kode_kegiatan').val();
		let kode_program = $('#kode_program').val();
		let kode_bidang_urusan = $('#kode_bidang_urusan').val();
		let tahap = $('#tahap').val();
		let tahun = $('#tahun').val();
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/save_pptk_sub_kegiatan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { 
				id_user : id_user,
				kode_sub_kegiatan : kode_sub_kegiatan,
				kode_kegiatan : kode_kegiatan,
				kode_program : kode_program,
				kode_bidang_urusan : kode_bidang_urusan,
				tahap : tahap,
				 },
			success : function(data)
			{
				
				if(data.status == true)
				{
					Swal.fire('Ditambahkan','PPTK kegiatan ditambahkan','success');

					set_pptk_kegiatan(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan)


					// $('#modal_set_pptk').modal('hide');
				   	$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
					// show_list_kegiatan(data.id);
				}
			}
		});
	}

	function copy_sub_kegiatan()
	{
		let id_user  = $('#id_user').val();
		let nama_user  = $('#detail-user').find('#full_name').html();

		Swal.fire({
			  title: 'Copy Sub Kegiatan APBD AWAL.?',
			  text: "Copy Sub Kegiatan PPTK " + nama_user + " APBD AWAL <?php echo tahun_anggaran() ?> ke APBD PERUBAHAN  <?php echo tahun_anggaran() ?>.?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Copy',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
				$.ajax(
				{
					url     : baseUrl('struktur_instansi/copy_pptk_sub_kegiatan/'),
					dataType: 'JSON',
					type    : 'POST',
					data    : { id_user : id_user},
					success : function(data)
					{
						
						if(data.status == true)
						{
							Swal.fire('Di Copy','Sub Kegiatan APBD AWAL <?php echo tahun_anggaran() ?> berhasil dicopy','success');
							$('#modal-informasi-detail').find('.copy_sub_kegiatan').attr('style','display:none');
							list_kegiatan();
							show_list_kegiatan(id_user);
						}else{
							Swal.fire('Gagal','Tidak ada data Sub Kegiatan APBD AWAL <?php echo tahun_anggaran() ?> pada PPTK ' + nama_user,'error');
							list_kegiatan();
							show_list_kegiatan(id_user);
						}
					}
				});
			  }
			});



		
	}

	function delete_user_kegiatan(id, rekening, kode_urusan)
	{
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/delete_user_kegiatan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id : id, rekening : rekening, kode_urusan },
			success : function(data)
			{
				if(data.status == true)
				{
					show_list_kegiatan(id);
					list_kegiatan();
				}
			}
		});
	}
	function delete_user_sub_kegiatan(id_user_sub_keg, id_pptk)
	{
		$.ajax(
		{
			url     : baseUrl('struktur_instansi/delete_user_sub_kegiatan/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { id : id_user_sub_keg },
			success : function(data)
			{
		
				if(data.status == true)
				{
					// show_list_kegiatan(id_pptk);
					
				   	$('#table-list-sub-kegiatan').DataTable().ajax.reload(null, false);
					list_kegiatan();
				}
			}
		});
	}

	function konfirmasi_hapus_sub_instansi()
	{
		let id_user = $('#id_user').val();
		let id_kedudukan = $('#id_kedudukan_user').val();
		let id_sub_instansi = $('#id_sub_instansi').val();
		$.ajax(
        {
            url     : baseUrl('struktur_instansi/cek_bawahan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_user : id_user , 
            	id_kedudukan : id_kedudukan, 
            	id_sub_instansi : id_sub_instansi
            },
            success : function(data)
            {
                if(data.status == true)
                {
                	if (id_kedudukan==3) {
                		var peringatan = 'Struktur ' + data.data.nama_struktur +'.?';
                	}else{
                		var peringatan = 'Struktur ' + data.data.nama_struktur + ' memiliki ' + data.data.bawahan +' struktur dibawahnya. jika dihapus stuktur di bawah ' + data.data.nama_struktur + ' ikut terhapus. tetap dilanjutkan.?';
                	}
                	
					Swal.fire({
						  title: 'Hapus Struktur Instansi.?',
						  text: peringatan,
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Hapus',
						  cancelButtonText: 'Batal'
						}).then((result) => {
						  if (result.isConfirmed) {
							hapus_sub_instansi(id_user, id_sub_instansi, id_kedudukan);
						  }
						});
					
				}
			}
		});
		
	}
	function konfirmasi_hapus_sub_instansi_via_list_struktur(id_user, id_kedudukan, id_sub_instansi)
	{

		$.ajax(
        {
            url     : baseUrl('struktur_instansi/cek_bawahan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_user : id_user , 
            	id_kedudukan : id_kedudukan, 
            	id_sub_instansi : id_sub_instansi
            },
            success : function(data)
            {
                if(data.status == true)
                {
                	if (id_kedudukan==3) {
                		var peringatan = 'Struktur ' + data.data.nama_struktur +'.?';
                	}else{
                		var peringatan = 'Struktur ' + data.data.nama_struktur + ' memiliki ' + data.data.bawahan +' struktur dibawahnya. jika dihapus stuktur di bawah ' + data.data.nama_struktur + ' ikut terhapus. tetap dilanjutkan.?';
                	}
                	
					Swal.fire({
						  title: 'Hapus Struktur Instansi.?',
						  text: peringatan,
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Hapus',
						  cancelButtonText: 'Batal'
						}).then((result) => {
						  if (result.isConfirmed) {
							hapus_sub_instansi(id_user, id_sub_instansi, id_kedudukan);
						  }
						});
					
				}
			}
		});
		
	}




	
	function warning_save_edit_sub_instansi()
	{
		let id_user = $('#modal-ganti-struktur').find('#id_user').val();
		let id_kedudukan = $('#modal-ganti-struktur').find('#id_kedudukan').val();
		let id_sub_instansi = $('#modal-ganti-struktur').find('#id_sub_instansi').val();
		let full_name_lama = $('#modal-ganti-struktur').find('#full_name_lama').val();
		let full_name_baru = $('#modal-ganti-struktur').find('#full_name').val();
		let nama_sub_instansi = $('#modal-ganti-struktur').find('#nama_sub_instansi').val();
		let nama_sub_instansi_lama = $('#modal-ganti-struktur').find('#nama_sub_instansi_lama').val();
		$.ajax(
        {
            url     : baseUrl('struktur_instansi/cek_bawahan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_user : id_user , 
            	id_kedudukan : id_kedudukan, 
            	id_sub_instansi : id_sub_instansi
            },
            success : function(data)
            {
                if(data.status == true)
                {
                	if (id_kedudukan==3) {
                		var peringatan = full_name_lama + ' Sebagai ' +nama_sub_instansi_lama +' <br><br>Menjadi<br><br>'+ full_name_baru + ' Sebagai ' + nama_sub_instansi;
                	}else{
                		var peringatan = 'Struktur ' + data.data.nama_struktur + ' memiliki ' + data.data.bawahan +' struktur dibawahnya. jika dihapus stuktur di bawah ' + data.data.nama_struktur + ' ikut terhapus. tetap dilanjutkan.?';
                	}
                	
					Swal.fire({
						  title: 'Perbaharui Struktur Instansi.?',
						  html: peringatan,
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Perbaharui',
						  cancelButtonText: 'Batal'
						}).then((result) => {
						  if (result.isConfirmed) {
							save_edit_sub_instansi(id_user, id_sub_instansi, id_kedudukan);
						  }
						});
					
				}
			}
		});
		
	}





	
	function save_edit_sub_instansi(id_user, id_sub_instansi, id_kedudukan){
		var formdata = $('#form_edit_struktur').serialize();
	$.ajax(
		{
			url     : baseUrl('struktur_instansi/save_edit_sub_instansi/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : formdata,
			success : function(data)
			{
				
				if(data.status == true)
				{
					Swal.fire(
								      'Dihapus!',
								      'Struktur instansi  Dihapus',
								      'success'
								    );
					$('#modal-informasi-detail').modal('hide')
				   	$('#table-user-struktur').DataTable().ajax.reload(null, false);
					show_diagram();

				}
			},
			error : function(){
				
			}
		});
	}

	function hapus_user_sub_instansi(id_user)
	{




		Swal.fire({
			  title: 'Hapus Struktur Instansi.?',
			  text: 'Hapus User',
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
						url     : baseUrl('struktur_instansi/hapus_user_struktur_instansi/'),
						dataType: 'JSON',
						type    : 'POST',
						data    : { 
			            	id_user : id_user , 
			            },
						success : function(data)
						{
							
							if(data.status == true)
							{
								Swal.fire(
											      'Dihapus!',
											      'Struktur instansi  Dihapus',
											      'success'
											    );
								$('#modal-informasi-detail').modal('hide')
							   	$('#table-user-struktur').DataTable().ajax.reload(null, false);
								// show_diagram();

							}
						},
						error : function(){
							
						}
					});
			  }
			});



		
		
	}

function hapus_sub_instansi(id_user, id_sub_instansi, id_kedudukan){
	$.ajax(
		{
			url     : baseUrl('struktur_instansi/hapus_struktur_instansi/'),
			dataType: 'JSON',
			type    : 'POST',
			data    : { 
            	id_user : id_user , 
            	id_sub_instansi : id_sub_instansi,
            	id_kedudukan : id_kedudukan
            },
			success : function(data)
			{
				
				if(data.status == true)
				{
					Swal.fire(
								      'Dihapus!',
								      'Struktur instansi  Dihapus',
								      'success'
								    );
					$('#modal-informasi-detail').modal('hide')
				   	$('#table-user-struktur').DataTable().ajax.reload(null, false);
					show_diagram();

				}
			},
			error : function(){
				
			}
		});
}





	function set_pptk_kegiatan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan) {


		$('#modal_set_pptk').modal('show');
		// $('.form-control').removeClass('is-valid')
		// 				  .removeClass('is-invalid');
	 
		$("#id_user_pptk").select2(
		{
			theme 		: "bootstrap4",
			placeholder	: "Pilih Sub Kegiatan"
		});
  //       $('.text-danger').remove();
        

		$('#modal_set_pptk').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal_set_pptk').find('#tahap').val(tahap);
    	$('#modal_set_pptk').find('#tahun').val(tahun);
    	$('#modal_set_pptk').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal_set_pptk').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal_set_pptk').find('#kode_program').val(kode_program);

    	$('#list_pptk_kegiatan').html('');
		
		

		



		$.ajax({
			url: baseUrl('struktur_instansi/cek_pptk_kegiatan/'),
			type: "POST",
			dataType: "JSON",
			data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	kode_bidang_urusan : kode_bidang_urusan,
            	tahap : tahap,
            	tahun : tahun
            },
			success: function(data) {
				// $('#modal_set_pptk').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu=='0'? 0: pagu));
            	$('#modal_set_pptk').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal_set_pptk').find('.kode_sub_kegiatan').html(data.kode_sub_kegiatan);
            	$('#modal_set_pptk').find('#nama_tahapan').html(data.nama_tahapan);

            	$.each(data.data_pptk, function(k,v){
            		$('#list_pptk_kegiatan').append(`
            			<tr>
            			<td>`+ (k+1)+`</td>
            			<td>`+ v.full_name+`</td>
            			<td>`+ v.nama_sub_instansi+`</td>
            			<td>
            			<button type="button" class="btn btn-danger btn-xs" onclick="hapus_usk('`+ v.id_user_sub_kegiatan+`','`+ v.kode_rekening_sub_kegiatan+`','`+ v.kode_kegiatan+`','`+ v.kode_program+`','`+ v.tahap+`','`+ v.tahun+`','`+ v.kode_bidang_urusan+`')" data-toggle="tooltip" title="Hapus PPTK Kegiatan"><i class="fa fa-times"></i></button>

            			</td>
            			</tr>
            			`)	

            	});
			}
		});






	}





	function hapus_usk(id_usk, kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan)
	{


				$.ajax(
					{
						url     : baseUrl('struktur_instansi/hapus_user_sub_kegiatan/'),
						dataType: 'JSON',
						type    : 'POST',
						data    : { 
			            	id_usk : id_usk , 
			            },
						success : function(data)
						{
							
							if(data.status == true)
							{
								Swal.fire('Dihapus','PPTK kegiatan Dihapus','success');

								set_pptk_kegiatan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan)


								// $('#modal_set_pptk').modal('hide');
							   	$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);

							}
						},
						error : function(){
							alert('error aplikasi')
						}
					});
			 



		
		
	}


</script>
