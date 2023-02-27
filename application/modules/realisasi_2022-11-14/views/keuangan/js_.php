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
	let status_show_kegiatan 		= 'collapse';
	let status_show_kegiatan_all 		= 'collapse';
	
	$(document).ready(function()
	{
	   	show_program();
	   	show_sub_kegiatan_apbd_instansi_gabungan();
	   	show_program_all();
		showAutoCurrency();
	  




	});

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
			show_sub_kegiatan_apbd_all(id_table);
		}else{
			status_show_sub_kegiatan = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#'+id_detail).remove();
		}
		$(this).attr('status', status_show_sub_kegiatan );
	});





	function input_anggaran(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pengelompokan)
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
    	$('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#kode_kegiatan').val(kode_kegiatan);
    	$('#kode_program').val(kode_program);
		$.ajax(
        {
            url     : baseUrl('data_apbd/get_anggaran_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	tahap : tahap
            },
            success : function(data)
            {
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
                	$('#bt_bbk').val(data.data.bt_bbk );
                	
                	
                }
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
							show_sub_kegiatan_apbd_instansi_gabungan();
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
function get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu)
	{	
		$('#modal-target').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
		

		$('#modal-target').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
    	$('#modal-target').find('#tahap').val(tahap);
    	$('#modal-target').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal-target').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal-target').find('#kode_program').val(kode_program);
    	$('#modal-target').find('#pagu').val(pagu==''? 0: pagu);

		var tahap = "<?php echo tahapan_apbd() ?>";
		if (tahap=='4') {
			$('#modal-target').find('#btn_copy_target_awal').show();
		}else{
			$('#modal-target').find('#btn_copy_target_awal').hide();
		}
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
            	tahap : tahap
            },
            success : function(data)
            {
		    	$('#modal-target').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu==''? 0: pagu));
            	$('#modal-target').find('#exampleModalLabel').html("Setting Target APBD");
            	$('#modal-target').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal-target').find('#kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
            	$('#modal-target').find('#nama_tahapan').html(data.nama_tahapan);
            	if (data.totaldata == 0) {
            		get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu);
            	}else{

            	
					$('#target-apbd').html('');
	                if (data.status == true) {
						$.each(data.data, function(k, v) {
							$('#target-apbd').append(
								'<tr>' +
								'<td>' + (k + 1) + '</td>' +
								'<td>' + bulan(v.bulan) + '</td>' +
								'<td><a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</a></td>' +
								'<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
								'<td style="text-align: right;">' + '<a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan) + '</a>'  + '</td>' +
								'</tr>'
							);
						});
					}
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
		
		$(x).editable({
			mode: 'inline',
			pk: id,
			savenochange: true,
			url: baseUrl('data_apbd/update_target_fisik/' + kode_sub_kegiatan),
			success: function(c) {
				get_target(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu)
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
		
		$(x).editable({
			mode: 'inline',
			pk: id,
			savenochange: true,
			url: baseUrl('data_apbd/update_target_keuangan/' + kode_sub_kegiatan),
			success: function(c) {
				get_target(kode_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu)
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
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('realisasi_keuangan/sub_kegiatan_apbd_instansi_gabungan/'),
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
								
							}
						});
			

			  
			  }
			});	
	}



	function hapus_sub_kegiatan_instansi(kode_sub_kegiatan, kode_kegiatan, kode_program, show)
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
										show_sub_kegiatan_apbd_instansi_gabungan();
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



	function hapus_all_apbd_instansi(jenis)
	{
			Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda akan menghapus semua sub kegiatan yang jenis inputannya melalui '+jenis+'.?',
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
			  			$.ajax(
						{
							url     : baseUrl('data_apbd/copy_target_apbd_awal/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
				            	kode_kegiatan : kode_kegiatan,
				            	kode_program : kode_program,
				            	kode_bidang_urusan : kode_bidang_urusan,
							},
							success : function(data)
							{
								if(data.status == true)
								{
									Swal.fire(
								      'Copied!',
								      'Data target APBD Awal sub kegiatan '+nama_sub_kegiatan+' berhasil di copy',
								      'success'
								    );
									get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu);
								}
							},
							error : function(){
								
							}
						});
			

			  
			  }
			});	
	}



function copy_sub_kegiatan_apbd_awal()
	{
		Swal.fire(
	      'Gagal!',
	      'Tombol ini belum aktif',
	      'error'
	    );
		// Swal.fire({
		// 	  title: 'Warning',
		// 	  text: 'Copy Target di APBD Awal Untuk kegiatan '+ nama_sub_kegiatan+'.?',
		// 	  icon: 'warning',
		// 	  showCancelButton: true,
		// 	  confirmButtonColor: '#3085d6',
		// 	  cancelButtonColor: '#d33',
		// 	  confirmButtonText: 'Hapus',
		// 	  cancelButtonText: 'Batal'
		// 	}).then((result) => {
		// 	  if (result.isConfirmed) {
		// 	  			$.ajax(
		// 				{
		// 					url     : baseUrl('data_apbd/copy_target_apbd_awal/'),
		// 					dataType: 'JSON',
		// 					type    : 'POST',
		// 					data    : { 
		// 						kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
		// 		            	kode_kegiatan : kode_kegiatan,
		// 		            	kode_program : kode_program,
		// 		            	kode_bidang_urusan : kode_bidang_urusan,
		// 					},
		// 					success : function(data)
		// 					{
		// 						if(data.status == true)
		// 						{
		// 							Swal.fire(
		// 						      'Copied!',
		// 						      'Data target APBD Awal sub kegiatan '+nama_sub_kegiatan+' berhasil di copy',
		// 						      'success'
		// 						    );
		// 							get_target(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu);
		// 						}
		// 					},
		// 					error : function(){
								
		// 					}
		// 				});
			

			  
		// 	  }
		// 	});	
	}


</script>
