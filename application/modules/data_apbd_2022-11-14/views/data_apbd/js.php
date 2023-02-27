<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
	// echo $controller;
?>

<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	let status_show_kegiatan 		= 'collapse';
	let status_show_kegiatan_all 		= 'collapse';
	
	$(document).ready(function()
	{
		select2();
	   	show_program();


	   	var fetch_method_pemilihan_data_apbd = '<?php echo $input_by ?>';
	   	if (fetch_method_pemilihan_data_apbd=='pengalihan_tahapan_apbd_ski') {
		   	show_pengalihan_sub_kegiatan_apbd_instansi_gabungan();

	   	}else{
		   	show_sub_kegiatan_apbd_instansi_gabungan();

	   	}
	   	show_pilihan_sub_kegiatan_apbd();

	   	show_usulan_program();
	   	show_usulan_kegiatan();
	   	show_usulan_sub_kegiatan();


	   	<?php if(isset($controller)=='laporan'){ ?>
	   		var id_instansi = '<?php echo sbe_crypt($id_instansi, 'E') ?>';
	   		var tahun = '<?php echo $tahun ?>';
	   		var tahap = '<?php echo $tahap ?>';
	   		var controller = 'laporan';
	   <?php }else{ ?>

	   		var id_instansi = '<?php echo sbe_crypt(id_instansi(), 'E') ?>';
	   		var tahun = '<?php echo tahun_anggaran() ?>';
	   		var tahap = '<?php echo tahapan_apbd() ?>';
	   		var controller = 'data_apbd';
	   <?php } ?>
	   	show_permasalahan_sub_kegiatan_apbd(id_instansi, controller, tahun, tahap);
	   	show_program_all();
		showAutoCurrency();
	  




	});
	function select2()
	{
		$('#pilih_tahun_copy').select2(
		{
			placeholder : "Pilih Tahun Anggaran",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
		$('#pilih_tahap_copy').select2(
		{
			placeholder : "Pilih Tahapan APBD",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
	}
	function showAutoCurrency(){
		$('input.currency').number( true, 0 );
	}



	function get_apbd_instansi() {
		var req = 'get_apbd_instansi';
		$('#' + req).text('Loading...')
			.attr('disabled', true);
		
		$.ajax({
			url: baseUrl('data_apbd/sync_eplanning'),
			type: 'POST',
			dataType: 'JSON',
			data: {				
			},
			success: function(data) {
				
				$('#' + req).attr('class', ' btn btn-success btn-xs');
				$('#' + req).html('<i class="fa fa-download"></i>');
				$('#' + req).attr('disabled', false);
				window.location.href="<?php echo base_url() ?>data_apbd"
			},
			error: function(jqXHR, textStatus, errorThrown) {
				
			}
		});
	}


	/* Fungsi untuk menampilkan KPA */
	function show_program_all()
	{
		$('#table-apbd-all').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/dt_program_all/'),
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


	$('#table-apbd-all').on('click', '#show-kegiatan-all', function()
	{
		let kode_program 		= $(this).attr('kode_program');
		let table       	= $(this).parent().parent()[0];
		let id_table 		= kode_program.split('.').join("-");
		var id_detail       = 'list-kegiatan-'+id_table;
		let tr_detail_program	= '';

		tr_detail_program  = '<tr colspan="6" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_detail_program +=     '<td rowspan="1" colspan="6">';

	    tr_detail_program +=   	'<div class="mb-3 card">' +
                                    '<div class="card-body">' +
                                        '<table id="table-kegiatan-all-'+ id_table +'" class="display" style="width:100%">' +
	                                        '<thead>' +
		                                        '<tr>' +
		                                            '<th width="1%">No</th>' +
		                                            '<th>Kode Rekening Kegiatan</th>' +
		                                            '<th>Nama Kegiatan</th>' +
		                                            '<th></th>';
		tr_detail_program +=                      '</tr>';
	    tr_detail_program +=                  '</thead>';
	    tr_detail_program +=              '</table>';
        tr_detail_program +=          '</div>';
        tr_detail_program +=      '</div>';
		tr_detail_program +=     '</td>';
        tr_detail_program += '</tr>';

		if(status_show_kegiatan_all == 'collapse')
		{
			status_show_kegiatan_all = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_program);
			show_kegiatan_apbd_all(id_table);
		}else{
			status_show_kegiatan_all = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
	});




	$('#table-apbd-all').on('click', '#show-sub-kegiatan-all', function()
	{

		let kode_program 		= $(this).attr('kode_program');
		let kode_kegiatan 		= $(this).attr('kode_kegiatan');
		let status_show_sub_kegiatan 		= $(this).attr('status');
		

		let table       	= $(this).parent().parent()[0];
		let id_table 		= kode_kegiatan.split('.').join("-");
		var id_detail       = 'list-sub-kegiatan-' + id_table;
		let tr_detail_paket	= '';
		
		tr_detail_paket  = '<tr colspan="6" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_detail_paket +=     '<td rowspan="1" colspan="6">';

	    tr_detail_paket +=   	'<div class="mb-3 card">' +
                                    '<div class="card-body">' +
                                        '<table id="table-sub-kegiatan-all-'+ id_table +'" class="display" style="width:100%">' +
	                                        '<thead>' +
		                                        '<tr>' +
		                                            '<th width="1%">No</th>' +
		                                            '<th>Kode Rekening Sub Kegiatan</th>' +
		                                            '<th>Nama Sub Kegiatan</th>' +
		                                            '<th>Status</th>' +
		                                            '<th>Action</th>';
		tr_detail_paket +=                      '</tr>';
	    tr_detail_paket +=                  '</thead>';
	    tr_detail_paket +=              '</table>';
        tr_detail_paket +=          '</div>';
        tr_detail_paket +=      '</div>';
		tr_detail_paket +=     '</td>';
        tr_detail_paket += '</tr>';

		if(status_show_sub_kegiatan == 'collapse')
		{
			status_show_sub_kegiatan = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_paket);
			show_sub_kegiatan_apbd_all(id_table);
		}else{
			status_show_sub_kegiatan = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
		$(this).attr('status', status_show_sub_kegiatan );
	});



	function pilih_copy_data_apbd()
	{
		$('#modal_pilih_copy_sub_kegiatan').modal('show');
	}


	function input_anggaran(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pengelompokan)
	{
		$('#modal_input_anggaran').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_anggaran_sub_kegiatan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_anggaran_sub_kegiatan').attr('style', '');
		$('#pengelompokan').val(pengelompokan );
		$('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#tahap').val(tahap);
    	$('#tahun').val(tahun);
    	$('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#kode_kegiatan').val(kode_kegiatan);
    	$('#kode_program').val(kode_program);

    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_anggaran_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahun : tahun,
            	tahap : tahap,
            },
            success : function(data)
            {
            	
            	$('#modal_input_anggaran').find('.kategori').html(data.data.kategori);
            	$('#modal_input_anggaran').find('.nama_sub_kegiatan').html(data.data.nama_sub_kegiatan);
            	$('#modal_input_anggaran').find('.kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
                if(data.status == true)
                {
                	
                	
                	$('#bo_bp').val(data.data. bo_bp);
                	$('#bo_bbj').val(data.data.bo_bbj);
                	$('#bo_bs').val(data.data.bo_bs);
                	$('#bo_bh').val(data.data.bo_bh);
                	$('#bm_bmt').val(data.data.bm_bmt);
                	$('#bm_bmpm').val(data.data.bm_bmpm);
                	$('#bm_bmgb').val(data.data.bm_bmgb);
                	$('#bm_bmjji').val(data.data.bm_bmjji);
                	$('#bm_bmatl').val(data.data.bm_bmatl);
                	$('#btt').val(data.data.btt);
                	$('#bt_bbh').val(data.data.bt_bbh);
                	$('#bt_bbk').val(data.data.bt_bbk);
                }
                
                	data.data.rea_bo ==1 ? $('#rea_bo').attr('checked','checked') : $('#rea_bo').removeAttr('checked');
                	data.data.rea_bm ==1 ? $('#rea_bm').attr('checked','checked') : $('#rea_bm').removeAttr('checked');
                	data.data.rea_btt ==1 ? $('#rea_btt').attr('checked','checked') : $('#rea_btt').removeAttr('checked');
                	data.data.rea_bt ==1 ? $('#rea_bt').attr('checked','checked') : $('#rea_bt').removeAttr('checked');
            }
        });


	}




	function lihat_data_apbd()
	{
		let tahun 	= $('#pilih_tahun_copy').val();
		let tahap 	= $('#pilih_tahap_copy').val();
		if (tahun=='') {
			Swal.fire('Error','Harap Pilih Tahun','error');
			return false ; 
		}
		else if (tahap=='') {
			Swal.fire('Error','Harap Pilih Tahapan APBD','error');
			return false ; 
		}else{
			window.location.href=baseUrl('data_apbd/lihat_data_apbd/')+ tahun+ '/' + tahap;

		}

		
	}





	function input_permasalahan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan)
	{
		$('#modal_input_permasalahan').find('#simpanedit_permasalahan').hide();
    	$('#modal_input_permasalahan').find('#hapus_permasalahan').hide();
		
		$('#modal_input_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_permasalahan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal_input_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_permasalahan').find('#tahun').val(tahun);
    	$('#modal_input_permasalahan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal_input_permasalahan').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal_input_permasalahan').find('#kode_program').val(kode_program);

    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_anggaran_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahap : tahap,
            	tahun : tahun
            },
            success : function(data)
            {
            	
            	$('#modal_input_permasalahan').find('.kategori').html(data.data.kategori);
            	$('#modal_input_permasalahan').find('.nama_sub_kegiatan').html(data.data.nama_sub_kegiatan);
            	$('#modal_input_permasalahan').find('.kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
            	$('#modal_input_permasalahan').find('#simpan_permasalahan').show();

            }
        });


	}




	function input_solusi_permasalahan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, id_instansi)
	{
		
    	$('#modal_input_solusi_permasalahan').find('#simpanedit_solusi').hide();
    	$('#modal_input_solusi_permasalahan').find('#hapus_solusi').hide();
		$('#modal_input_solusi_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_solusi_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_solusi_permasalahan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal_input_solusi_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_solusi_permasalahan').find('#tahun').val(tahun);
    	$('#modal_input_solusi_permasalahan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal_input_solusi_permasalahan').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal_input_solusi_permasalahan').find('#kode_program').val(kode_program);
    	$('#modal_input_solusi_permasalahan').find('#id_instansi').val(id_instansi);
    	$('#list_permasalahan').html('');
    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_permasalahan_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahap : tahap,
            	tahun : tahun,
            	id_instansi : id_instansi,
            },
            success : function(data)
            {

            	$('#modal_input_solusi_permasalahan').find('.kategori').html(data.sub_kegiatan.kategori);
            	$('#modal_input_solusi_permasalahan').find('.nama_sub_kegiatan').html(data.sub_kegiatan.nama_sub_kegiatan);
            	$('#modal_input_solusi_permasalahan').find('.kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);

            	$.each(data.permasalahan, function(k, v) {
							$('#list_permasalahan').append('<li>'+v.masalah+'</li>');
						});
            },
            error : function(){
            }
        });


	}



	function edit_solusi_permasalahan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, id_solusi, id_instansi)
	{
		$('#modal_input_solusi_permasalahan').find('#simpan_solusi').hide();
		$('#modal_input_solusi_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_solusi_permasalahan').find('#id_solusi').val(id_solusi);
		$('#modal_input_solusi_permasalahan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal_input_solusi_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_solusi_permasalahan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal_input_solusi_permasalahan').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal_input_solusi_permasalahan').find('#kode_program').val(kode_program);
    	$('#list_permasalahan').html('');
    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('data_apbd/detail_solusi_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_solusi : id_solusi,
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahap : tahap,
            	id_instansi : id_instansi
            },
            success : function(data)
            {
            	
            	$('#modal_input_solusi_permasalahan').find('.kategori').html(data.sub_kegiatan.kategori);
            	$('#modal_input_solusi_permasalahan').find('.nama_sub_kegiatan').html(data.sub_kegiatan.nama_sub_kegiatan);
            	$('#modal_input_solusi_permasalahan').find('.kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
            	$('#modal_input_solusi_permasalahan').find('#solusi').html(data.data.solusi);
            	$('#modal_input_solusi_permasalahan').find('#simpanedit_solusi').show();
            	$('#modal_input_solusi_permasalahan').find('#hapus_solusi').show();
            	

            	$.each(data.permasalahan, function(k, v) {
            		
							$('#list_permasalahan').append('<li>'+v.masalah+'</li>');
						});
            },
            error : function(){
            	
            }
        });


	}



	function edit_permasalahan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, id_permasalahan)
	{
		$('#modal_input_permasalahan').find('#simpan_permasalahan').hide();
		$('#modal_input_permasalahan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_input_permasalahan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_input_permasalahan').attr('style', '');
		$('#modal_input_permasalahan').find('#id_permasalahan').val(id_permasalahan);
		$('#modal_input_permasalahan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal_input_permasalahan').find('#tahap').val(tahap);
    	$('#modal_input_permasalahan').find('#tahun').val(tahun);
    	$('#modal_input_permasalahan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal_input_permasalahan').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal_input_permasalahan').find('#kode_program').val(kode_program);
    	$('#list_permasalahan').html('');
    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('data_apbd/detail_permasalahan_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	id_permasalahan : id_permasalahan,
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahap : tahap
            },
            success : function(data)
            {
            	$('#modal_input_permasalahan').find('.kategori').html(data.sub_kegiatan.kategori);
            	$('#modal_input_permasalahan').find('.nama_sub_kegiatan').html(data.sub_kegiatan.nama_sub_kegiatan);
            	$('#modal_input_permasalahan').find('.kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
            	$('#modal_input_permasalahan').find('#permasalahan').html(data.data.permasalahan);
            	$('#modal_input_permasalahan').find('#simpanedit_permasalahan').show();
            	$('#modal_input_permasalahan').find('#hapus_permasalahan').show();
            	

            
            },
            error : function(){
            	
            }
        });


	}



	function hapus_solusi_permasalahan_sub_kegiatan()
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
							url     : baseUrl('data_apbd/hapus_solusi_permasalahan_sub_kegiatan/'),
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
								      'Duhapus!',
								      'Solusi dihapus',
								      'success'
								    );
									$('#modal_input_solusi_permasalahan').modal('hide');
									$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}
	function hapus_permasalahan_sub_kegiatan()
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
							url     : baseUrl('data_apbd/hapus_permasalahan_sub_kegiatan/'),
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
									$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}
	function save_anggaran_sub_kegiatan()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax({
			url: baseUrl('data_apbd/save_anggaran_sub_kegiatan'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_anggaran_sub_kegiatan').serialize(),
			success: function (datanya)
			{
				if(datanya.success == true)
				{
					
						$('#form_anggaran_sub_kegiatan')[0].reset();
						$('#modal_input_anggaran').modal('hide');

						let id_table_sub_kegiatan 		= datanya.kode_kegiatan.split('.').join("-");
						let id_table_kegiatan 		= datanya.kode_program.split('.').join("-");
						if (datanya.pengelompokan=='instansi') {
							show_sub_kegiatan_apbd_instansi(id_table_sub_kegiatan);
						}else{
							$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
						}	
						// show_kegiatan_apbd_instansi(id_table_kegiatan);
						
						// showPaket(id_table, id_pptk);

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


	function save_permasalahan_sub_kegiatan()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('data_apbd/save_permasalahan_sub_kegiatan'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				
				if(datanya.success == true)
				{
					
						$('#form_input_permasalahan')[0].reset();
						Swal.fire('Disimpan','Permasalahan anda sudah ditambahkan','success');
						$('#modal_input_permasalahan').modal('hide');
					   	$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
						

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

	function saveedit_permasalahan_sub_kegiatan()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('data_apbd/saveedit_permasalahan_sub_kegiatan'),
			type: 'POST',
			dataType: 'JSON',
			data: formdata,
			success: function (datanya)
			{
				
				if(datanya.success == true)
				{
					
						$('#form_input_permasalahan')[0].reset();
						Swal.fire('Disimpan','Permasalahan anda sudah diperbaharui','success');
						$('#modal_input_permasalahan').modal('hide');
					   	$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
						

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

	function save_solusi_permasalahan_sub_kegiatan()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_solusi_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('data_apbd/save_solusi_permasalahan_sub_kegiatan'),
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
					   	$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
						

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

	function saveedit_solusi_permasalahan_sub_kegiatan()
	{

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        var formdata = $('#form_input_solusi_permasalahan').serialize();
        
		$.ajax({
			url: baseUrl('data_apbd/saveedit_solusi_permasalahan_sub_kegiatan'),
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
					   	$('#table-permasalahan-sub-kegiatan-instansi').DataTable().ajax.reload(null, false);
						

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

function convert_to_rupiah(angka) {
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for (var i = 0; i < angkarev.length; i++)
			if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
		return rupiah.split('', rupiah.length - 1).reverse().join('');
	}
function bulan(x) {
		let bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		return bulan[x];
	}
function get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pagu)
	{	
		$('#modal-target').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
		

		$('#modal-target').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal-target').find('#tahap').val(tahap);
    	$('#modal-target').find('#tahun').val(tahun);
    	$('#modal-target').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal-target').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal-target').find('#kode_program').val(kode_program);
    	$('#modal-target').find('#pagu').val(pagu==''? 0: pagu);

		// var tahap = "<?php //echo tahapan_apbd() ?>";
		// if (tahap=='4') {
		// 	$('#modal-target').find('#btn_copy_target_awal').show();
		// }else{
		// 	$('#modal-target').find('#btn_copy_target_awal').hide();
		// }
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_target/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	kode_bidang_urusan : kode_bidang_urusan,
            	tahap : tahap,
            	tahun : tahun,
            },
            success : function(data)
            {
            	console.log(data);
				$('#modal-target').find('.kode_sub_kegiatan').html(data.kode_sub_kegiatan);
		    	$('#modal-target').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu==''? 0 : pagu));
            	$('#modal-target').find('#exampleModalLabel').html("Setting Target APBD");
            	$('#modal-target').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal-target').find('#kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
            	$('#modal-target').find('#nama_tahapan').html(data.nama_tahapan);
            	if (data.totaldata == 0) {
            		get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pagu);
            	}else{

            	
					$('#target-apbd').html('');
	                if (data.status == true) {
						$.each(data.data, function(k, v) {
							$('#target-apbd').append(
								'<tr>' +
								'<td style="text-align: right;">' + (k + 1) + '</td>' +
								'<td style="text-align: right;">' + bulan(v.bulan) + '</td>' +
								'<td style="text-align: right;"><a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '", tahun="' + tahun + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik_bulanan + '</a></td>' +

								'<td style="text-align: right;">' + v.t_fisik + '</td>' +
								'<td style="text-align: right;">' + ((v.t_keuangan_bulanan / pagu) * 100).toFixed(2) + '</td>' +
								'<td style="text-align: right;">' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
								'<td style="text-align: right;">' + '<a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '", tahun="' + tahun + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan_bulanan) + '</a>'  + '</td>' +
								'<td>' + convert_to_rupiah(v.t_keuangan) + '</td>' +
								'</tr>'
							);
						});
					}
	            }
	        }
        });


	}



	function get_sumber_dana(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pagu) {
		$('#modal-sumber_dana').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
		$('#form-sumber_dana')[0].reset();

		$('#modal-sumber_dana').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal-sumber_dana').find('#tahap').val(tahap);
    	$('#modal-sumber_dana').find('#tahun').val(tahun);
    	$('#modal-sumber_dana').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal-sumber_dana').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal-sumber_dana').find('#kode_program').val(kode_program);
    	$('#modal-sumber_dana').find('#pagu').val(pagu==''? 0: pagu);

		
		if (tahap=='4') {
			$('#modal-sumber_dana').find('#btn_copy_sumber_dana_awal').show();
		}else{
			$('#modal-sumber_dana').find('#btn_copy_sumber_dana_awal').hide();
		}

				





		$.ajax({
			url: baseUrl('data_apbd/cek_sumber_dana/'),
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
				$('#modal-sumber_dana').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu=='0'? 0: pagu));
            	$('#modal-sumber_dana').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal-sumber_dana').find('.kode_sub_kegiatan').html(data.kode_sub_kegiatan);
            	$('#modal-sumber_dana').find('#nama_tahapan').html(data.nama_tahapan);


				if (data.status == true) {
					$('#pad').val(data.data.pad);
					$('#dau').val(data.data.dau);
					$('#dak').val(data.data.dak);
					$('#dbh').val(data.data.dbh);
					$('#lainnya').val(data.data.lainnya);
					$('#nama_sumber_dana_lainnya').val(data.data.nama_sumber_dana_lainnya);
					if (data.data.lainnya==0) {
						$('#modal-sumber_dana').find('#form_nama_sumber_dana').hide();
					}else{
						$('#modal-sumber_dana').find('#form_nama_sumber_dana').show();

					}
				} else {
					$('#status').val('insert');
				}
			}
		});


		$('#modal-sumber_dana').find('#lainnya').keyup(function(){
			var nilai_lainnya = $('#modal-sumber_dana').find('#lainnya').val();
			if (nilai_lainnya==0) {
				$('#modal-sumber_dana').find('#form_nama_sumber_dana').hide();
			}else{
				$('#modal-sumber_dana').find('#form_nama_sumber_dana').show();

			}
		});



	}






	function input_ski_teknis(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu) {
		$('#modal-ski_teknis').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
		$('#form-ski_teknis')[0].reset();

		$('#modal-ski_teknis').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal-ski_teknis').find('#tahap').val(tahap);
    	$('#modal-ski_teknis').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal-ski_teknis').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal-ski_teknis').find('#kode_program').val(kode_program);


		$.ajax({
			url: baseUrl('data_apbd/cek_master_sub_kegiatan/'),
			type: "POST",
			dataType: "JSON",
			data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	
            },
			success: function(data) {
				
            	$('#modal-ski_teknis').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal-ski_teknis').find('#kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);


				if (data.status == true) {
				
				}
			},
			error : function(){
				
			}
		});
	}



	function save_ski_teknis()
	{

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax({
			url: baseUrl('data_apbd/save_ski_teknis'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form-ski_teknis').serialize(),
			success: function (data)
			{

				if(data.success == true)
				{
					
					Swal.fire('Disimpan','Sub Kegiatan Unit Pelaksana Disimpan','success');
					$('#closemodal').click();


	   	show_pilihan_sub_kegiatan_apbd();
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
			error: function () {
				
			}
		});
	}


	function edit_ski_teknis(kode_rekening_sub_kegiatan, kode_sub_kegiatan, nama_sub_kegiatan, id_sub_kegiatan, jenis, keterangan) {
		$('#modal-edit_ski_teknis').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
		$('#form-edit_ski_teknis')[0].reset();

		$('#modal-edit_ski_teknis').find('.kode_sub_kegiatan').html(kode_sub_kegiatan);
		$('#modal-edit_ski_teknis').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
		$('#modal-edit_ski_teknis').find('#nama_sub_kegiatan').html(nama_sub_kegiatan);
		$('#modal-edit_ski_teknis').find('#id_sub_kegiatan_instansi').val(id_sub_kegiatan);
    	$('#modal-edit_ski_teknis').find('#keterangan').val(keterangan);
    	$('#modal-edit_ski_teknis').find('#kelompok').val(jenis).change();
    


	}



	function save_edit_ski_teknis()
	{

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax({
			url: baseUrl('data_apbd/save_edit_ski_teknis'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form-edit_ski_teknis').serialize(),
			success: function (data)
			{
				
				if(data.success == true)
				{
					
					Swal.fire('Disimpan','Sub Kegiatan Unit Pelaksana Diperbaharui','success');
					$('.closemodal').click();
				   	$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						var element = $('.' + key);
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					});
				}
			},
			error: function () {
				
				
			}
		});
	}





	function save_sumber_dana() {
		$.ajax({
			url: baseUrl('data_apbd/save_sumber_dana/'),
			type: "POST",
			dataType: "JSON",
			data: $('#form-sumber_dana').serialize(),
			success: function(data) {
				
				if (data.status == true) {
					$('#modal-sumber_dana').modal('hide');
				}
			}
		});
	}

function edit_target_fisik(x) {
		$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-xs editable-submit">OK</button>' +
			'<button type="button" class="btn btn-default btn-xs editable-cancel">Batal</button>';

		let id = $(x).attr('pk');
		let kode_sub_kegiatan = $(x).attr('kode_sub_kegiatan');
		let kode_bidang_urusan = $(x).attr('kode_bidang_urusan');
		let kode_program = $(x).attr('kode_program');
		let kode_kegiatan = $(x).attr('kode_kegiatan');
		let pagu = $(x).attr('pagu');
		let tahap = $(x).attr('tahap');
		let tahun = $(x).attr('tahun');
		
		$(x).editable({
			mode: 'inline',
			pk: id,
			savenochange: true,
			url: baseUrl('data_apbd/update_target_fisik/' + kode_sub_kegiatan),
			success: function(c) {
				get_target(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pagu)
			},
		});
	}
function edit_target_keuangan(x) {
		$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-xs editable-submit">OK</button>' +
			'<button type="button" class="btn btn-default btn-xs editable-cancel">Batal</button>';
		let id = $(x).attr('pk');
		let kode_sub_kegiatan = $(x).attr('kode_sub_kegiatan');
		let kode_bidang_urusan = $(x).attr('kode_bidang_urusan');
		let kode_program = $(x).attr('kode_program');
		let kode_kegiatan = $(x).attr('kode_kegiatan');
		let pagu = $(x).attr('pagu');
		let tahap = $(x).attr('tahap');
		let tahun = $(x).attr('tahun');
		
		$(x).editable({
			mode: 'inline',
			pk: id,
			savenochange: true,
			url: baseUrl('data_apbd/update_target_keuangan/' + kode_sub_kegiatan),
			success: function(c) {
				get_target(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun, kode_bidang_urusan, pagu)
			},
		});
	}


function export_excel_apbd()
	{
		$('#modal_export_apbd_excel').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  

	}

function show_kegiatan_apbd_all(id_table)
	{
		let kode_rekening = id_table.split('-').join('.');
		kode_program   = kode_rekening;
		
		$('#table-kegiatan-all-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/kegiatan_apbd_all/'),
				            type 	: "POST",
				          	data 	: { kode_program : kode_program },
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


function show_sub_kegiatan_apbd_all(id_table)
	{
		let kode_rekening = id_table.split('-').join('.');
		kode_kegiatan   = kode_rekening;

		
		$('#table-sub-kegiatan-all-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/sub_kegiatan_apbd_all/'),
				            type 	: "POST",
				          	data 	: { kode_kegiatan : kode_kegiatan }
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




function show_sub_kegiatan_apbd_instansi_gabungan()
	{
		var input_by = "<?php echo $input_by=="" ? "" : $input_by ?>";
		var fetch_method = "<?php echo $fetch_method; ?>";
		var tahun = "<?php echo $tahun; ?>";
		var kode_tahap = "<?php echo $kode_tahap; ?>";
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/sub_kegiatan_apbd_instansi_gabungan/' + input_by),
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




function show_pengalihan_sub_kegiatan_apbd_instansi_gabungan()
	{
		var input_by = "<?php echo $input_by=="" ? "" : $input_by ?>";
		
		var tahun = "<?php echo $tahun; ?>";
		var kode_tahap = "<?php echo $kode_tahap; ?>";
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/pengalihan_apbd_sub_kegiatan_apbd_instansi_gabungan/' + input_by),
				            type 	: "POST",
				          	data 	: {
				          		tahun : tahun,
				          		tahap : kode_tahap,
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






function show_permasalahan_sub_kegiatan_apbd(id_instansi, controller, tahun, tahap)
	{
		var tabel_target = '#table-permasalahan-sub-kegiatan-instansi';
		$(tabel_target).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/permasalahan_sub_kegiatan_apbd_instansi/'+ id_instansi),
				            type 	: "POST",
				          	data 	: {
				          		tahun : tahun,
				          		tahap : tahap
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





function show_pilihan_sub_kegiatan_apbd()
	{
		

		$('#table-pilihan-sub-kegiatan-apbd').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/show_pilihan_sub_kegiatan_apbd/'),
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





function show_kegiatan_apbd_instansi(id_table)
	{
		let kode_rekening = id_table.split('-').join('.');
		kode_program   = kode_rekening;

		
		$('#table-kegiatan-all-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/kegiatan_apbd_all/'),
				            type 	: "POST",
				          	data 	: { kode_program : kode_program },
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


function show_program()
	{
		$('#table-apbd-instansi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/dt_program_apbd/'),
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

	$('#table-apbd-instansi').on('click', '#show-kegiatan', function()
	{
		let kode_program 		= $(this).attr('kode_program');
		let table       	= $(this).parent().parent()[0];
		let id_table 		= kode_program.split('.').join("-");
		var id_detail       = 'list-kegiatan-'+id_table;
		let tr_detail_program	= '';

		tr_detail_program  = '<tr colspan="6" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_detail_program +=     '<td rowspan="1" colspan="6">';

	    tr_detail_program +=   	'<div class="mb-3 card">' +
                                    '<div class="card-body">' +
                                        '<table id="table-kegiatan-'+ id_table +'" class="display" style="width:100%">' +
	                                        '<thead>' +
		                                        '<tr>' +
		                                            '<th width="1%">No</th>' +
		                                            '<th>Kode Rekening Kegiatan</th>' +
		                                            '<th>Nama Kegiatan</th>' +
		                                            '<th>Pagu</th>' +
		                                            '<th></th>';
		tr_detail_program +=                      '</tr>';
	    tr_detail_program +=                  '</thead>';
	    tr_detail_program +=              '</table>';
        tr_detail_program +=          '</div>';
        tr_detail_program +=      '</div>';
		tr_detail_program +=     '</td>';
        tr_detail_program += '</tr>';

		if(status_show_kegiatan == 'collapse')
		{
			status_show_kegiatan = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_program);
			show_kegiatan_apbd_instansi(id_table);
		}else{
			status_show_kegiatan = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
	});


function show_kegiatan_apbd_instansi(id_table)
	{
		let kode_rekening = id_table.split('-').join('.');
		kode_program   = kode_rekening;

		
		$('#table-kegiatan-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/kegiatan_apbd_instansi/'),
				            type 	: "POST",
				          	data 	: { kode_program : kode_program },
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




	$('#table-apbd-instansi').on('click', '#show-sub-kegiatan', function()
	{

		let kode_program 		= $(this).attr('kode_program');
		let kode_kegiatan 		= $(this).attr('kode_kegiatan');
		let status_show_sub_kegiatan 		= $(this).attr('status');
		

		let table       	= $(this).parent().parent()[0];
		let id_table 		= kode_kegiatan.split('.').join("-");
		var id_detail       = 'list-sub-kegiatan-' + id_table;
		let tr_detail_paket	= '';
		
		tr_detail_paket  = '<tr colspan="6" class="card-body formulira" id="'+ id_detail +'" rowspan="1">';
		tr_detail_paket +=     '<td rowspan="1" colspan="6">';

	    tr_detail_paket +=   	'<div class="mb-3 card">' +
                                    '<div class="card-body">' +
                                        '<table id="table-sub-kegiatan-'+ id_table +'" class="display" style="width:100%">' +
	                                        '<thead>' +
		                                        '<tr>' +
		                                            '<th width="1%">No</th>' +
		                                            '<th>Kode Rekening Sub Kegiatan</th>' +
		                                            '<th>Nama Sub Kegiatan</th>' +
		                                            '<th>Pagu</th>' +

		                                            '<th>Tahapan APBD</th>' +
		                                            '<th></th>';
		tr_detail_paket +=                      '</tr>';
	    tr_detail_paket +=                  '</thead>';
	    tr_detail_paket +=              '</table>';
        tr_detail_paket +=          '</div>';
        tr_detail_paket +=      '</div>';
		tr_detail_paket +=     '</td>';
        tr_detail_paket += '</tr>';

		if(status_show_sub_kegiatan == 'collapse')
		{
			status_show_sub_kegiatan = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_paket);
			show_sub_kegiatan_apbd_instansi(id_table);
		}else{
			status_show_sub_kegiatan = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
		$(this).attr('status', status_show_sub_kegiatan );
	});


function show_sub_kegiatan_apbd_instansi(id_table)
	{
		let kode_rekening = id_table.split('-').join('.');
		kode_kegiatan   = kode_rekening;

		
		$('#table-sub-kegiatan-'+ id_table).DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('data_apbd/sub_kegiatan_apbd_instansi/'),
				            type 	: "POST",
				          	data 	: { kode_kegiatan : kode_kegiatan },
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



	function tambah_sub_kegiatan_instansi(kode_sub_kegiatan, kode_kegiatan, kode_program, kode_bidang_urusan)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Tambahkan sub kegiatan dengan kode rekening : '+ kode_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Simpan Sub Kegiatan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/tambah_sub_kegiatan_instansi/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								kode_sub_kegiatan : kode_sub_kegiatan,
								kode_kegiatan : kode_kegiatan,
								kode_program : kode_program,
								kode_bidang_urusan	 : kode_bidang_urusan	,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Ditambahkan!',
								      'Sub kegiatan ditambahkan',
								      'success'
								    );
									let id_table 	= data.kode_kegiatan.split('.').join('-');
									
										show_sub_kegiatan_apbd_all(id_table);
								}
							},
							error : function(){
								console.log('error');
							}
						});
			

			  
			  }
			});	
	}



	function hapus_sub_kegiatan_instansi(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, tahun,  show)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus sub kegiatan dengan kode rekening : '+ kode_sub_kegiatan+'.?',
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
							url     : baseUrl('data_apbd/hapus_sub_kegiatan_instansi/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								kode_sub_kegiatan : kode_sub_kegiatan,
								kode_kegiatan : kode_kegiatan,
								kode_program : kode_program,
								tahap : tahap,
								tahun : tahun,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Dihapus!',
								      'Sub kegiatan dihapus',
								      'success'
								    );
									let id_table 	= data.kode_kegiatan.split('.').join('-');
									if (show=='instansi') {
										show_sub_kegiatan_apbd_instansi(id_table);
									}
									else if (show=='gabungan') {
										$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									}else{
										show_sub_kegiatan_apbd_all(id_table);
									}
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}
	function alihkan_sub_kegiatan_instansi_apbd_awal_ke_perubahan(id_sub_kegiatan_instansi, nama_sub_kegiatan)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Alihkan  sub kegiatan  '+ nama_sub_kegiatan+' ke APBD Perubahan.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Alihkan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/simpan_pengalihan_sub_kegiatan_instansi_apbd_awal_ke_perubahan/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_sub_kegiatan_instansi : id_sub_kegiatan_instansi,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'DIalihkan!',
								      'Sub kegiatan dialihkan dari APBD Awal ke APBD Perubahan',
								      'success'
								    );
										$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									
								}
							},
							error : function(){
								console.log('error');
							}
						});
			

			  
			  }
			});	
	}


	function akhiri_sub_kegiatan_instansi_apbd_awal(id_sub_kegiatan_instansi, nama_sub_kegiatan)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Akhiri  sub kegiatan  '+ nama_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Akhiri',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/akhiri_sub_kegiatan_instansi_apbd_awal/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_sub_kegiatan_instansi : id_sub_kegiatan_instansi,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Diakhiri!',
								      'Sub kegiatan diakhiri',
								      'success'
								    );
										$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									
								}
							},
							error : function(){
								console.log('error');
							}
						});
			

			  
			  }
			});	
	}

	function tidak_berubah_sub_kegiatan_instansi_apbd_awal_dan_perubahan(id_sub_kegiatan_instansi, nama_sub_kegiatan)
	{
		Swal.fire({
			  title: 'Warning',
			  text: 'Tidak ada perubahan data pada sub kegiatan  '+ nama_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Akhiri',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/tidak_berubah_sub_kegiatan_instansi_apbd_awal_dan_perubahan/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_sub_kegiatan_instansi : id_sub_kegiatan_instansi,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Diakhiri!',
								      'Sub kegiatan tidak ada perubahan data',
								      'success'
								    );
										$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									
								}
							},
							error : function(){
								console.log('error');
							}
						});
			

			  
			  }
			});	
	}



	function hapus_all_apbd_instansi(jenis)
	{
			Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda akan menghapus semua sub kegiatan yang jenis inputannya melalui '+jenis+'.?\n Semua data yang berhubungan dengan sub kegiatan akan ikut terhapus.! Tetap dilanjutkan.?',
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
							url     : baseUrl('data_apbd/hapus_all_apbd_instansi/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { jenis:jenis },
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Dihapus!',
								      'Semua data apbd inputan export telah dihapus.!',
								      'success'
								    );
								    // window.location.href="<?php echo base_url() ?>data_apbd";
									// setting_apbd();
								}
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



	function setting_apbd(){
		window.location.href= baseUrl('data_apbd/setting');
	}
	function sub_kegiatan_instansi_gabungan(input_by){
		window.location.href= baseUrl('data_apbd/sub_kegiatan/'+input_by);
	}
	function setting_apbd_teknis(){
		window.location.href= baseUrl('data_apbd/setting_apbd_teknis/');
	}
	function permasalahan_sub_kegiatan(){
		window.location.href= baseUrl('data_apbd/permasalahan/');
	}


	function target_forbidden(){
		Swal.fire(
		      'Error!',
		      'Anda tidak bisa menginputkan target karena tidak ada anggaran. Target bisa di inputkan jika ada anggaran',
		      'error'
		    );
	}
	function sumber_dana_forbidden(){
		Swal.fire(
		      'Error!',
		      'Anda tidak bisa menginputkan sumber dana karena tidak ada anggaran. Sumber dana bisa di inputkan jika ada anggaran',
		      'error'
		    );
	}


function show_laporan(id_instansi) {
	$('#modal_laporan').modal('show');
		
		var id_opd = id_instansi
		var bulan = '<?php echo bulan_aktif() ?>';
		var kategori = 'akumulasi';
		// let id_opd = $('#id_opd').val();
		// let kategori = $('#kategori').val();
		// $('#bulan').val('');
		// if (id_opd) {
		// 	if (x != 0) {
		$('#tampil_pdf').show();
		$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_realisasi_akumulasi?id_opd=') + id_opd + '&kategori=' + kategori + '&bulan=' + bulan + '#view=FitH');
		// 	}
		// }
	}






function copy_target_apbd_awal()
	{
		var nama_sub_kegiatan = $('#modal-target').find('#nama_sub_kegiatan').html();
		var kode_rekening_sub_kegiatan = $('#modal-target').find('#kode_sub_kegiatan').val();

    	var kode_bidang_urusan = $('#modal-target').find('#kode_bidang_urusan').val();
    	var kode_kegiatan = $('#modal-target').find('#kode_kegiatan').val();
    	var kode_program = $('#modal-target').find('#kode_program').val();
    	var tahap = $('#modal-target').find('#tahap').val();
    	var pagu = $('#modal-target').find('#pagu').val();

		Swal.fire({
			  title: 'Warning',
			  text: 'Copy Target di APBD Awal Untuk kegiatan '+ nama_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Copy Target',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	// 		$.ajax(
						// {
						// 	url     : baseUrl('data_apbd/copy_target_apbd_awal/'),
						// 	dataType: 'JSON',
						// 	type    : 'POST',
						// 	data    : { 
						// 		kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
				  //           	kode_kegiatan : kode_kegiatan,
				  //           	kode_program : kode_program,
				  //           	kode_bidang_urusan : kode_bidang_urusan,
						// 	},
						// 	success : function(data)
						// 	{
						// 		if(data.status == true)
						// 		{
									Swal.fire(
								      'Gagal!',
								      'Fitur ini belum aktif',
								      'error'
								    );
						// 			get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu);
						// 		}
						// 	},
						// 	error : function(){
								
						// 	}
						// });
			

			  
			  }
			});	
	}



function copy_sub_kegiatan_apbd_awal()
	{
		// Swal.fire(
	 //      'Gagal!',
	 //      'Tombol ini belum aktif',
	 //      'error'
	 //    );
		Swal.fire({
			  title: 'Warning',
			  text: 'Copy semua data program, kegiatan, dan sub kehiatan pada APBD Awal.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Lanjutkan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/copy_sub_kegiatan_apbd_awal/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
						
							},
							success : function(data)
							{
								console.log(data);
								if(data.status == true)
								{
									$('#tombol_copy_apbd_awal').hide();
									Swal.fire(
								      'Sukses!',
								     data.messages,
								      'success'
								    );
					$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									// window.location.href = baseUrl('data_apbd/sub_kegiatan/all');
								}else{
									Swal.fire(
								      'Gagal!',
								     data.messages,
								      'error'
								    );
								}
							},
							error : function(){
								Swal.fire(
								      'Gagal!',
								    'Error',
								      'error'
								    );
							}
						});
			

			  
			  }
			});	
	}


function copy_sub_kegiatan_data_apbd(tahap, tahun, nama_tahap,tot_program,tot_kegiatan,tot_subkeg)
	{
		// Swal.fire(
	 //      'Gagal!',
	 //      'Tombol ini belum aktif',
	 //      'error'
	 //    );

	 var html_caption = `Copy Data `+nama_tahap +` Tahun `+tahun+`.?<br>
	     ` + tot_program+` Program,  
	     ` + tot_kegiatan+` Kegiatan,  
	     ` + tot_subkeg+` Sub Kegiatan  
	 

	 `;
		Swal.fire({
			  title: 'Warning',
			  html: html_caption,
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Lanjutkan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/copy_sub_kegiatan_data_apbd/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								tahap : tahap,
								tahun : tahun,
							},
							success : function(data)
							{
								console.log(data);
								if(data.status == true)
								{
									window.location.href=baseUrl('data_apbd/sub_kegiatan/all');				
					
								}else{
									Swal.fire(
								      'Gagal!',
								     data.messages,
								      'error'
								    );
								}
							},
							error : function(){
								Swal.fire(
								      'Gagal!',
								    'Error',
								      'error'
								    );
							}
						});
			

			  
			  }
			});	
	}


function ceklis_realisasi(id){
	$("#" + id).change(function(){

	  if ($(this).is('checked')) {
	      var nilai = 1;
	  } else {
	      var nilai = 0;
	  }       
	
	});
	
}



function copy_data_apbd_sub_kegiatan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, nama_sub_kegiatan)
	{	


		Swal.fire({
			  title: 'Warning',
			  text: 'Copy Pagu, target, sumber dana pada APBD Awal sub kegiatan ' + nama_sub_kegiatan +' ke APBD Perubahan.??',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Lanjutkan',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
				        {
				            url     : baseUrl('data_apbd/copy_data_apbd_sub_kegiatan/'),
				            dataType: 'JSON',
				            type    : 'POST',
				            data    : { 
				            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
				            	kode_kegiatan : kode_kegiatan,
				            	kode_program : kode_program,
				            	kode_bidang_urusan : kode_bidang_urusan,
				            	tahap : tahap
				            },
				            success : function(data)
				            {
				            	var id_table_kegiatan = data.data.id_table_kegiatan;
				            	var id_table_program = data.data.id_table_program;
								Swal.fire(
						      'Sukses!',
						       'Copy Pagu, target, sumber dana pada APBD Awal sub kegiatan ' + nama_sub_kegiatan +' ke APBD Perubahan berhasil',
						      'success'
						    );
									$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									// $('#table-kegiatan-'+ id_table_program).DataTable().ajax.reload(null, false);
									$('#table-sub-kegiatan-'+ id_table_kegiatan).DataTable().ajax.reload(null, false);

					        },
					        error : function(){

								console.log('eror');
								$('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
									$('#table-sub-kegiatan-'+ id_table_kegiatan).DataTable().ajax.reload(null, false);
					        }
				        });
			  }
			});	
	}





// =============================================================================================================================================================================================
// Bagian untuk pengusulan data APBD





	function usulkan_data_apbd(id_instansi) {
		$('#modal-usulkan-data-apbd').modal('show');
		show_usulan_program(id_instansi);

	
	}


	function show_usulan_program() {
		$('#table-usulan-program').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('data_apbd/dt_usulan_program/'),
				type: "POST",
				data: {
					
				},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});

	}
	function show_usulan_kegiatan() {
		$('#table-usulan-kegiatan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('data_apbd/dt_usulan_kegiatan/'),
				type: "POST",
				data: {
					
				},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}
	function show_usulan_sub_kegiatan() {
		$('#table-usulan-sub-kegiatan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('data_apbd/dt_usulan_sub_kegiatan/'),
				type: "POST",
				data: {
					
				},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}

	function tambah_usulan_program() {
		status = 'save';
	    $('#modal_master_program').modal('show')
					  		  .find('.modal-title').text('Usulkan Program');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_program')[0].reset();
		$('#btnSave_master_program').show();
		$('#btnUpdate_master_program').hide();
	}


	function save_master_program() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/save_master_program'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_program').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_program').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Program Disimpan..!',
						      'success'
						    );
					$('#form_master_program')[0].reset();
					$('#clodemodalmodal_master_program').click();
					$('#table-usulan-program').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_program').find('#' + key);
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
		// if (status == 'save') {
		// 	url_data = 'management_users/save_master_user';
		// } else {
		// 	url_data = 'management_users/update_master_user';
		// }

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_program', 'btnSave_master_program', 'Save Change', 'modal_master_program');
		// show_master_program();
	}


	function edit_program(id_program)
	{
		status = 'update';
		$('#clodemodal_usulan_data_apbd').click();
		$('#modal_master_program').modal('show').find('.modal-title').text('Edit Program');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax(
        {
            url     : baseUrl('data_apbd/get_program/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_program : id_program },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#modal_master_program').find('#id').val(data.data.id);
                	$('#modal_master_program').find('#kode').val(data.data.kode);
                	$('#modal_master_program').find('#nama').val(data.data.nama);
                }
            },
            error : function(){

            }
        });

		$('#btnSave_master_program').hide();
		$('#btnUpdate_master_program').show();
	}

function update_master_program() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/saveedit_master_program'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_program').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_program').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Program Disimpan..!',
						      'success'
						    );
					$('#form_master_program')[0].reset();
					$('#clodemodalmodal_master_program').click();
					$('#table-usulan-program').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_program').find('#' + key);
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




	function delete_program(id_program, nama_program) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_program+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('data_apbd/delete_program/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_program: id_program
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master Program Dihapus..!',
						      'success'
						    );
							
					$('#table-usulan-program').DataTable().ajax.reload(null, false);
						}
			  		},
			  		error : function (){
			  			 Swal.fire(
					      'Error!',
					      'Error',
					      'error'
					    )
			  		}
			  	});

			  
			  }
			});
	}











	function tambah_usulan_kegiatan() {
		status = 'save';
	    $('#modal_master_kegiatan').modal('show')
					  		  .find('.modal-title').text('Usulkan Kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_kegiatan')[0].reset();
		$('#btnSave_master_kegiatan').show();
		$('#btnUpdate_master_kegiatan').hide();
	}
	
	function save_master_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/save_master_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_kegiatan')[0].reset();
					$('#clodemodalmodal_master_kegiatan').click();
					$('#table-usulan-kegiatan').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_kegiatan').find('#' + key);
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
		// if (status == 'save') {
		// 	url_data = 'management_users/save_master_user';
		// } else {
		// 	url_data = 'management_users/update_master_user';
		// }

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_kegiatan', 'btnSave_master_kegiatan', 'Save Change', 'modal_master_kegiatan');
		// show_master_kegiatan();
	}


	
	/* Fungsi untuk menyimpan/mengupdate master user */
	function update_master_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/saveedit_master_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_kegiatan')[0].reset();
					$('#clodemodalmodal_master_kegiatan').click();
					$('#table-usulan-kegiatan').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_kegiatan').find('#' + key);
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





	function edit_kegiatan(id_kegiatan)
	{
		status = 'update';
		$('#modal_master_kegiatan').modal('show').find('.modal-title').text('Edit Kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_kegiatan : id_kegiatan },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#modal_master_kegiatan').find('#id').val(data.data.id);
                	$('#modal_master_kegiatan').find('#kode').val(data.data.kode);
                	$('#modal_master_kegiatan').find('#nama').val(data.data.nama);
                }
            },
            error : function(){
            }
        });

		$('#btnSave_master_kegiatan').hide();
		$('#btnUpdate_master_kegiatan').show();
	}



	function delete_kegiatan(id_kegiatan, nama_kegiatan) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('data_apbd/delete_kegiatan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_kegiatan: id_kegiatan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master kegiatan Dihapus..!',
						      'success'
						    );
							$('#table-usulan-kegiatan').DataTable().ajax.reload(null, false);
						}
			  		},
			  		error : function (){
			  			 Swal.fire(
					      'Error!',
					      'Error',
					      'error'
					    )
			  		}
			  	});

			  
			  }
			});
	}




	function tambah_usulan_sub_kegiatan () {
		status = 'save';
	    $('#modal_master_sub_kegiatan').modal('show')
					  		  .find('.modal-title').text('Usulkan Sub Kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_sub_kegiatan')[0].reset();
		$('#btnSave_master_sub_kegiatan').show();
		$('#btnUpdate_master_sub_kegiatan').hide();
	}
	
	function save_master_sub_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/save_master_sub_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_sub_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_sub_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Sub Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_sub_kegiatan')[0].reset();
					$('#clodemodalmodal_master_sub_kegiatan').click();
					
					$('#table-usulan-sub-kegiatan').DataTable().ajax.reload(null, false);
				}else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_sub_kegiatan').find('#' + key);
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
		// if (status == 'save') {
		// 	url_data = 'management_users/save_master_user';
		// } else {
		// 	url_data = 'management_users/update_master_user';
		// }

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_sub_kegiatan', 'btnSave_master_sub_kegiatan', 'Save Change', 'modal_master_sub_kegiatan');
		// show_master_sub_kegiatan();
	}


	
	/* Fungsi untuk menyimpan/mengupdate master user */
	function update_master_sub_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('data_apbd/saveedit_master_sub_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_sub_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_sub_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Sub Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_sub_kegiatan')[0].reset();
					$('#clodemodalmodal_master_sub_kegiatan').click();
					
					$('#table-usulan-sub-kegiatan').DataTable().ajax.reload(null, false);
				} else{
					$.each(data.messages, function (key, value)
					{
						
						var element = $('#modal_master_sub_kegiatan').find('#' + key);
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





	function edit_sub_kegiatan(id_sub_kegiatan)
	{
		status = 'update';
		$('#modal_master_sub_kegiatan').modal('show').find('.modal-title').text('Edit Sub Kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_sub_kegiatan : id_sub_kegiatan },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#modal_master_sub_kegiatan').find('#id').val(data.data.id);
                	$('#modal_master_sub_kegiatan').find('#kode').val(data.data.kode);
                	$('#modal_master_sub_kegiatan').find('#nama').val(data.data.nama);
                }
            },
            error : function(){
            }
        });

		$('#btnSave_master_sub_kegiatan').hide();
		$('#btnUpdate_master_sub_kegiatan').show();
	}



	function delete_sub_kegiatan(id_sub_kegiatan, nama_sub_kegiatan) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('data_apbd/delete_sub_kegiatan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_sub_kegiatan: id_sub_kegiatan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master sub_kegiatan Dihapus..!',
						      'success'
						    );
							
							$('#table-usulan-sub-kegiatan').DataTable().ajax.reload(null, false);
						}
			  		},
			  		error : function (){
			  			 Swal.fire(
					      'Error!',
					      'Error',
					      'error'
					    )
			  		}
			  	});

			  
			  }
			});
	}
	






		function alert_isi_permasalahan(nama_sub_kegiatan, kode_sub_kegiatan, kode_tahap, tahun, id_user=''){
		// Swal.fire({
		//   title: 'error',
		//   icon: 'error',
		//   html: 'Sub kegiatan ' + x + ' belum menginputkan permasalahan <br>Silahkan inputkan dulu permasalahan melalui link isi permasalahan untuk membuka upload evidence' ,
		//   footer : '<a href="'+ baseUrl('data_apbd/permasalahan/')+'" target="_blank">Isi Permasalahan</a>'
		 
		// });
		Swal.fire({
		  title: 'Error',
		  icon: 'warning',
		  html: 'Sub kegiatan ' + nama_sub_kegiatan + ' belum menginputkan permasalahan <br>Silahkan inputkan dulu permasalahan melalui link isi permasalahan untuk membuka upload evidence',
		  footer : `<button type="button" onclick="tidak_ada_permasalahan('` +kode_sub_kegiatan+`', `+kode_tahap +`,`+tahun+`,`+id_user+`)"  class="btn btn-info btn-sm" style="margin-right : 10px">Tidak Ada Permasalahan</button> <a href="`+ baseUrl(`data_apbd/permasalahan/`)+`" target="_blank" class="btn btn-info btn-sm">Isi Permasalahan</a>`,
		  // showCloseButton: false,
		  // showCancelButton: false,
		  showConfirmButton: false,
		  // focusConfirm: false,
		  // confirmButtonText: '<a href="#" style="color:white" onclick="tidak_ada_permasalahan('+kode_sub_kegiatan+','+kode_tahap+','+tahun+ ')">Tidak Ada Permasalahan</a>',
		  // cancelButtonText:
		  //   '<a href="'+ baseUrl('data_apbd/permasalahan/')+'" target="_blank" style="color:white">Isi Permasalahan</a>',
		
		});
	}






	function pilih_dan_alihkan_data_apbd(){
		// Swal.fire({
		//   title: 'error',
		//   icon: 'error',
		//   html: 'Sub kegiatan ' + x + ' belum menginputkan permasalahan <br>Silahkan inputkan dulu permasalahan melalui link isi permasalahan untuk membuka upload evidence' ,
		//   footer : '<a href="'+ baseUrl('data_apbd/permasalahan/')+'" target="_blank">Isi Permasalahan</a>'
		 
		// });
		Swal.fire({
		  title: 'Warning',
		  icon: 'warning',
		  html: 'Apakah data APBD dipilih baru atau tetap menggunakan yang sudah ada.?',
		  footer : `<button type="button" onclick="setting_apbd()"  class="btn btn-info btn-sm" style="margin-right : 10px">Pilih Data APBD Sub Kegiatan Baru</button> <a href="`+ baseUrl(`data_apbd/pengalihan_tahapan_apbd_ski/`)+`"class="btn btn-info btn-sm">Alihkan Sub Kegiatan APBD Awal Ke APBD Perubahan</a>`,
		  // showCloseButton: false,
		  // showCancelButton: false,
		  showConfirmButton: false,
		  // focusConfirm: false,
		  // confirmButtonText: '<a href="#" style="color:white" onclick="tidak_ada_permasalahan('+kode_sub_kegiatan+','+kode_tahap+','+tahun+ ')">Tidak Ada Permasalahan</a>',
		  // cancelButtonText:
		  //   '<a href="'+ baseUrl('data_apbd/permasalahan/')+'" target="_blank" style="color:white">Isi Permasalahan</a>',
		
		});
	}
</script>
