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
<script>
	let status_show_pptk = 'collapse';
	$(document).ready(function() {
		var id_group = '<?php echo $this->session->userdata('id_group') ?>';
		if (id_group==5) {
			showbantuan();
		}
		else if (id_group==7) {
			showbantuan_kab_kota();
		}else{
			showbantuan();
			showbantuan_kab_kota();
		}
	});

	/* Fungsi untuk menampilkan KPA */
	function showbantuan() {

		$('#table-bantuan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('informasi/dt_bantuan/'),
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

	function showbantuan_kab_kota() {

		$('#table-bantuan_kab_kota').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('informasi/dt_bantuan_kab_kota/'),
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

	
	function tambah_bantuan(){
		$('#modal-tambah-bantuan').modal('show');
	}

	function detail_bantuan(id_bantuan, id_group_pelapor){
		$('#id_bantuan').val(id_bantuan);
		$('#id_group_pelapor').val(id_group_pelapor);
		$('#modal-detail-bantuan').modal('show');

		var id_group = '<?php echo $this->session->userdata('id_group') ?>';
		$('#modal-detail-bantuan').find('#form_close_bantuan').hide();


		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
    	$('#penyelesaian').html('');
		$.ajax(
        {
            url     : baseUrl('informasi/detail_bantuan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_bantuan : id_bantuan
            },
            success : function(data)
            {
            	console.log(data);
            	show_tracking(id_bantuan);


            	$('#modal-detail-bantuan').find('#show_tracking_ke_operator').click(function(){
            		var ditandai = $('#modal-detail-bantuan').find('#show_tracking_ke_operator').is(':checked');
            		if (ditandai) {
            			$('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('1');
            		}else{
            			$('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('0');
            		}
					// $('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('1');
				});
				$('#modal-detail-bantuan').find('.pelapor').html(data.data.pelapor);
				$('#modal-detail-bantuan').find('.skpd').html(data.data.skpd);
				$('#modal-detail-bantuan').find('.no_wa').html(data.data.no_wa);
				$('#modal-detail-bantuan').find('.menu').html(data.data.menu);
				$('#modal-detail-bantuan').find('#kode_ticket').html(data.data.kode_ticket);
				$('#modal-detail-bantuan').find('.masalah').html(data.data.masalah);
				$('#modal-detail-bantuan').find('.keterangan_masalah').html(data.data.deskripsi_masalah);
				if (data.data.kode_status=='1') {
					if (id_group==0) {

					var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="proses_bantuan(' + "'" +id_bantuan + "'" +')">Proses Bantuan</button>';
					}else{
					var tombol = '';

					}

					$('#modal-detail-bantuan').find('#tracking').hide();
					$('#modal-detail-bantuan').find('#form_tracking').hide();
				}
				else if (data.data.kode_status=='2') {
					$('#modal-detail-bantuan').find('#tracking').show();
					if (id_group==0) {
					var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="close_bantuan(' + "'" +id_bantuan + "'" +')">Tutup Bantuan</button>';
					}else{
					// var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="akhiri_bantuan()">Akhiri Bantuan</button>';
					var tombol = '';
					}
					$('#modal-detail-bantuan').find('#form_tracking').show();
				}else{
					if (id_group=='0') {

						var penyelesaian = `<tr>
	                          <td>Jenis Penyelesaian</td>
	                          <td>:</td>
	                          <td>`+data.data.jenis_penyelesaian+`</td>
	                        </tr>`;
						$('#penyelesaian').append(`
						<table class="table">
	                        ` + penyelesaian + `
	                        <tr>
	                          <td>Penyebab</td>
	                          <td>:</td>
	                          <td>`+data.data.penyebab+`</td>
	                        </tr>
	                        <tr>
	                          <td>Solusi</td>
	                          <td>:</td>
	                          <td>`+data.data.solusi+`</td>
	                        </tr>
	                        <tr>
	                          <td>Boleh Dilihat Operator</td>
	                          <td>:</td>
	                          <td>`+data.data.lihat_penyelesaian_operator+`</td>
	                        </tr>
	                      </table>`);
						$('#modal-detail-bantuan').find('#form_tracking').hide();
					}else{
						if (data.data.publikasikan=='1') {
							$('#penyelesaian').append(`
								<table class="table">
			                      
			                        <tr>
			                          <td>Penyebab</td>
			                          <td>:</td>
			                          <td>`+data.data.penyebab+`</td>
			                        </tr>
			                        <tr>
			                          <td>Solusi</td>
			                          <td>:</td>
			                          <td>`+data.data.solusi+`</td>
			                        </tr>
			                      </table>`);
						}
						var penyelesaian ='';
						$('#modal-detail-bantuan').find('#form_tracking').hide();
					}
					var tombol = '';
				}

				$('#modal-detail-bantuan').find('.status').html(data.data.status + tombol);
			
	        },
	        error : function(){
	        	console.log('error');
	        }
        });
	}


	function detail_bantuan_kab_kota(id_bantuan, id_group_pelapor){
		$('#id_bantuan').val(id_bantuan);
		$('#id_group_pelapor').val(id_group_pelapor);
		$('#modal-detail-bantuan').modal('show');

		var id_group = '<?php echo $this->session->userdata('id_group') ?>';
		$('#modal-detail-bantuan').find('#form_close_bantuan').hide();


		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
    	$('#penyelesaian').html('');
		$.ajax(
        {
            url     : baseUrl('informasi/detail_bantuan_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_bantuan : id_bantuan
            },
            success : function(data)
            {
            	console.log(data);
            	show_tracking(id_bantuan);


            	$('#modal-detail-bantuan').find('#show_tracking_ke_operator').click(function(){
            		var ditandai = $('#modal-detail-bantuan').find('#show_tracking_ke_operator').is(':checked');
            		if (ditandai) {
            			$('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('1');
            		}else{
            			$('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('0');
            		}
					// $('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('1');
				});
				$('#modal-detail-bantuan').find('.pelapor').html(data.data.pelapor);
				$('#modal-detail-bantuan').find('.skpd').html(data.data.skpd);
				$('#modal-detail-bantuan').find('.no_wa').html(data.data.no_wa);
				$('#modal-detail-bantuan').find('.menu').html(data.data.menu);
				$('#modal-detail-bantuan').find('#kode_ticket').html(data.data.kode_ticket);
				$('#modal-detail-bantuan').find('.masalah').html(data.data.masalah);
				$('#modal-detail-bantuan').find('.keterangan_masalah').html(data.data.deskripsi_masalah);
				if (data.data.kode_status=='1') {
					if (id_group==0) {

					var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="proses_bantuan_kab_kota(' + "'" +id_bantuan + "'" +')">Proses Bantuan</button>';
					}else{
					var tombol = '';

					}

					$('#modal-detail-bantuan').find('#tracking').hide();
					$('#modal-detail-bantuan').find('#form_tracking').hide();
				}
				else if (data.data.kode_status=='2') {
					$('#modal-detail-bantuan').find('#tracking').show();
					if (id_group==0) {
					var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="close_bantuan(' + "'" +id_bantuan + "'" +')">Tutup Bantuan</button>';
					}else{
					// var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="akhiri_bantuan()">Akhiri Bantuan</button>';
					var tombol = '';
					}
					$('#modal-detail-bantuan').find('#form_tracking').show();
				}else{
					if (id_group=='0') {

						var penyelesaian = `<tr>
	                          <td>Jenis Penyelesaian</td>
	                          <td>:</td>
	                          <td>`+data.data.jenis_penyelesaian+`</td>
	                        </tr>`;
						$('#penyelesaian').append(`
						<table class="table">
	                        ` + penyelesaian + `
	                        <tr>
	                          <td>Penyebab</td>
	                          <td>:</td>
	                          <td>`+data.data.penyebab+`</td>
	                        </tr>
	                        <tr>
	                          <td>Solusi</td>
	                          <td>:</td>
	                          <td>`+data.data.solusi+`</td>
	                        </tr>
	                        <tr>
	                          <td>Boleh Dilihat Operator</td>
	                          <td>:</td>
	                          <td>`+data.data.lihat_penyelesaian_operator+`</td>
	                        </tr>
	                      </table>`);
						$('#modal-detail-bantuan').find('#form_tracking').hide();
					}else{
						if (data.data.publikasikan=='1') {
							$('#penyelesaian').append(`
								<table class="table">
			                      
			                        <tr>
			                          <td>Penyebab</td>
			                          <td>:</td>
			                          <td>`+data.data.penyebab+`</td>
			                        </tr>
			                        <tr>
			                          <td>Solusi</td>
			                          <td>:</td>
			                          <td>`+data.data.solusi+`</td>
			                        </tr>
			                      </table>`);
						}
						var penyelesaian ='';
						$('#modal-detail-bantuan').find('#form_tracking').hide();
					}
					var tombol = '';
				}

				$('#modal-detail-bantuan').find('.status').html(data.data.status + tombol);
			
	        },
	        error : function(){
	        	console.log('error');
	        }
        });
	}



	function simpan_bantuan()
	{
		
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
		$.ajax({
			url: baseUrl('informasi/simpan_bantuan'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_tambah_bantuan').serialize(),
			success: function (data)
			{

				if(data.success == true)
				{
					$('#form_tambah_bantuan')[0].reset();
					Swal.fire(
				      'Disimpan!',
				      'Bantuan anda sudah di sampaikan',
				      'success'
				    );
					$('#clodemodal_add_bantuan').click();
					
						$('#table-bantuan').DataTable().ajax.reload(null, false);
						$('#table-bantuan_kab_kota').DataTable().ajax.reload(null, false);
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

	function proses_bantuan(id_bantuan)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Proses bantuan..?.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Proses',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			
			
				$('#modal-detail-bantuan').find('#form_close_bantuan').hide();
				$('#modal-detail-bantuan').find('#tracking').show();
				
				$.ajax({
					url: baseUrl('informasi/proses_bantuan'),
					type: 'POST',
					dataType: 'JSON',
					data: { id_bantuan : id_bantuan},
					success: function (data)
					{
							
							Swal.fire(
						      'Processing!',
						      'Bantuan Diproses',
						      'success'
						    );



						    $('#modal-detail-bantuan').find('#tracking').show();
						    $('#modal-detail-bantuan').find('#form_tracking').show();
							var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="close_bantuan(' + "'" +id_bantuan + "'" +')">Tutup Bantuan</button>';
							$('#modal-detail-bantuan').find('.status').html('Processing' + tombol);
							
							
						$('#table-bantuan').DataTable().ajax.reload(null, false);
					
					},
					error: function (jqXHR, textStatus, errorThrown) {

					}
				});
			  
			  }
			});

		
	}

	function proses_bantuan_kab_kota(id_bantuan)
	{
		console.log(id_bantuan);
		Swal.fire({
			  title: 'Warning',
			  text: 'Proses bantuan..?.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Proses',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			
			
				$('#modal-detail-bantuan').find('#form_close_bantuan').hide();
				$('#modal-detail-bantuan').find('#tracking').show();
				
				$.ajax({
					url: baseUrl('informasi/proses_bantuan_kab_kota'),
					type: 'POST',
					dataType: 'JSON',
					data: { id_bantuan : id_bantuan},
					success: function (data)
					{
						console.log(data);
							
							Swal.fire(
						      'Processing!',
						      'Bantuan Diproses',
						      'success'
						    );



						    $('#modal-detail-bantuan').find('#tracking').show();
						    $('#modal-detail-bantuan').find('#form_tracking').show();
							var tombol = '<br><button type="button" class="btn btn-info btn-xs" onclick="close_bantuan(' + "'" +id_bantuan + "'" +')">Tutup Bantuan</button>';
							$('#modal-detail-bantuan').find('.status').html('Processing' + tombol);
							
							
						$('#table-bantuan').DataTable().ajax.reload(null, false);
						$('#table-bantuan_kab_kota').DataTable().ajax.reload(null, false);
					
					},
					error: function (jqXHR, textStatus, errorThrown) {

					}
				});
			  
			  }
			});

		
	}

	function close_bantuan(id_bantuan)
	{
		console.log(id_bantuan)
	$('#modal-detail-bantuan').find('#penyebab').val('');
	$('#modal-detail-bantuan').find('#solusi').val('');
	$('#modal-detail-bantuan').find('#penyelesaian').val('');
				$('#modal-detail-bantuan').find('#form_close_bantuan').show();
				$('#modal-detail-bantuan').find('#form_tracking').hide();


	$('#modal-detail-bantuan').find('#show_permasalahan_ke_operator').click(function(){
		var ditandai = $('#modal-detail-bantuan').find('#show_permasalahan_ke_operator').is(':checked');
		if (ditandai) {
		$('#modal-detail-bantuan').find('#show_permasalahan_ke_operator').val('1');
		}else{
		$('#modal-detail-bantuan').find('#show_permasalahan_ke_operator').val('0');
		}
		// $('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('1');
	});
		
	}

	function akhiri_bantuan()
	{
		var id_bantuan = $('#modal-detail-bantuan').find('#id_bantuan').val();
		var id_group_pelapor = $('#modal-detail-bantuan').find('#id_group_pelapor').val();
		var penyebab = $('#modal-detail-bantuan').find('#penyebab').val();
		var solusi = $('#modal-detail-bantuan').find('#solusi').val();
		var penyelesaian = $('#modal-detail-bantuan').find('#penyelesaian').val();
		var show = $('#modal-detail-bantuan').find('#show_permasalahan_ke_operator').val();
		



		Swal.fire({
			  title: 'Warning',
			  text: 'Akhiri bantuan..?.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Akhiri',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			
			
				$.ajax({
					url: baseUrl('informasi/akhiri_bantuan'),
					type: 'POST',
					dataType: 'JSON',
					data: { 
						id_bantuan : id_bantuan,
						penyebab : penyebab,
						solusi : solusi,
						penyelesaian : penyelesaian,
						id_group_pelapor : id_group_pelapor,
						show : show,
					},
					success: function (data)
					{
							
							Swal.fire(
						      'Ticket Closed!',
						      'Bantuan Berakhir',
						      'success'
						    );

						    $('#close_modal_detail_bantuan').click();


							
						$('#table-bantuan').DataTable().ajax.reload(null, false);
						$('#table-bantuan_kab_kota').DataTable().ajax.reload(null, false);
					
					},
					error: function (jqXHR, textStatus, errorThrown) {

					}
				});
				
				
			  
			  }
			});






		
	}

	function simpan_tracking()
	{
		var id_bantuan = $('#modal-detail-bantuan').find('#id_bantuan').val();
		var id_group_pelapor = $('#modal-detail-bantuan').find('#id_group_pelapor').val();
		var input_tracking = $('#modal-detail-bantuan').find('#input_tracking').val();
		var show_operator = $('#modal-detail-bantuan').find('#show_tracking_ke_operator').val();

		if (input_tracking=='') {
			Swal.fire('Error','Isikan Tracking','error');
		}else{
			$.ajax({
				url: baseUrl('informasi/simpan_tracking'),
				type: 'POST',
				dataType: 'JSON',
				data: { 
					id_bantuan : id_bantuan,
					input_tracking : input_tracking,
					show_operator : show_operator,
					id_group_pelapor : id_group_pelapor,
				},
				success: function (data)
				{
						
						
					var input_tracking = $('#modal-detail-bantuan').find('#input_tracking').val('');
					var show_operator = $('#modal-detail-bantuan').find('#show_tracking_ke_operator').val('0');
					var clear_check = $('#modal-detail-bantuan').find('#show_tracking_ke_operator').removeAttr('checked');
					    
						show_tracking(id_bantuan);
				
				},
				error: function (jqXHR, textStatus, errorThrown) {

				}
			});
		}
	}


	function show_tracking(id_bantuan) {
		$('#table-tracking-bantuan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('informasi/dt_tracking_bantuan/'),
				type: "POST",
				data: {
					id_bantuan : id_bantuan
				},
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
</script>