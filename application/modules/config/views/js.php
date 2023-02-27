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
	   	data_config();
	   	show_select2();
	});

<?php 	
foreach ($data_config as $k => $v) {  ?>
skpd_pemprov(<?php echo $v['id_config'];?>);
skpd_kab_kota(<?php echo $v['id_config'];?>);
<?php 	} ?>


	function show_select2() {
		$('#tahapan_apbd').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#bulan_aktif').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_input_rfk_mulai').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_input_rfk_akhir').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_validasi_rfk_mulai').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_validasi_rfk_akhir').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_input_rfk_kab_kota_awal').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tgl_input_rfk_kab_kota_akhir').select2({
			placeholder: "Pilih Tanggal",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#penginputan_provinsi').select2({
			placeholder: "Pilih Penginputan Provinsi",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#penginputan_kab_kota').select2({
			placeholder: "Pilih Penginputan Kab Kota",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#izin_konfigurasi').select2({
			placeholder: "Pilih Izin Konfigurasi",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}




function data_config()
	{
		$('#table-config').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('config/data_konfigurasi/'),
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








function tambah_config()
{
	$('#modal_add_config').modal('show');
	$('#modal_add_config').find('#tahun_anggaran').val('<?php echo date('Y') ?>');
	$('#modal_add_config').find('#caption_tambah_konfig').html('Tambah Konfigurasi');
		$('#tombol_simpan_config').show();
	$('#tombol_simpanedit_config').hide();
	$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	
}	

function izin_config()
{
	$('#modal_izin_config').modal('show');
	
	
}				


function simpan_config()
{
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_config').serialize();

    var jadwal_input_data_dasar_awal = $('#jadwal_input_data_dasar_awal').val();
    var jadwal_input_data_dasar_akhir = $('#jadwal_input_data_dasar_akhir').val();

   
	$.ajax({
		url: baseUrl('config/simpan_konfigurasi'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if (datanya.success==true) {
					$('#tombol_add_config').hide();
					$('#tempat_tombol_option_config').html('<div class="alert alert-info">Data konfigurasi ditambahkan. <br>Anda tidak bisa lagi menambahkan konfigurasi untuk tahun ini dan bisa ditambahkan kembali di tahun selanjutnya</div>');
					$('#modal_add_config').modal('hide');
					// Swal.fire('Disimpan','Data konfigurasi aplikasi ditambahkan','success');
			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#modal_add_config').find('#' + key);
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});



					// Swal.fire('Forbidden','Data konfigurasi gagal ditambahkan. Tahun anggaran '+datanya.tahun_ini+' sudah ada','error');
			}
				   window.location.href=baseUrl('config');
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}
function simpanedit_izin_config()
{

    var formdata = $('#form_izin_config').serialize();

	$.ajax({
		url: baseUrl('config/simpan_izin_konfigurasi'),
		type: 'POST',
		data: formdata,
		success: function (datanya)
		{
			
				   window.location.href=baseUrl('config');
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}
function edit_config(id_config)
{
	$('#modal_add_config').find('#tombol_simpan_config').hide();
	$('#modal_add_config').find('#tombol_simpanedit_config').show();

	$.ajax({
		url: baseUrl('config/get_config/'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			'id_config' : id_config
		},
		success: function (data)
		{
			console.log(data);
			$('#modal_add_config').modal('show');

			$('#modal_add_config').find('#exampleModalLabel').html('Edit Konfigurasi');
			$('#form_config')[0].reset();
			$('#modal_add_config').find('#id_config').val(data.data.id_config);
			$('#modal_add_config').find('#tahun_anggaran').val(data.data.tahun_anggaran);
			$('#modal_add_config').find('#tahapan_apbd').val(data.data.tahapan_apbd).change();
			$('#modal_add_config').find('#bulan_aktif').val(data.data.bulan_aktif).change();
			$('#modal_add_config').find('#jadwal_input_data_dasar_awal').val(data.data.jadwal_input_data_dasar_awal);
			$('#modal_add_config').find('#jadwal_input_data_dasar_akhir').val(data.data.jadwal_input_data_dasar_akhir);
			$('#modal_add_config').find('#tgl_input_rfk_mulai').val(data.data.tgl_input_rfk_mulai).change();
			$('#modal_add_config').find('#tgl_input_rfk_akhir').val(data.data.tgl_input_rfk_akhir).change();
			$('#modal_add_config').find('#tgl_validasi_rfk_mulai').val(data.data.tgl_validasi_rfk_mulai).change();
			$('#modal_add_config').find('#tgl_validasi_rfk_akhir').val(data.data.tgl_validasi_rfk_akhir).change();
			$('#modal_add_config').find('#tgl_input_rfk_kab_kota_awal').val(data.data.tgl_input_rfk_kab_kota_awal).change();
			$('#modal_add_config').find('#tgl_input_rfk_kab_kota_akhir').val(data.data.tgl_input_rfk_kab_kota_akhir).change();
			$('#modal_add_config').find('#penginputan_provinsi').val(data.data.penginputan).change();
			$('#modal_add_config').find('#penginputan_kab_kota').val(data.data.penginputan_kab_kota).change();
			$('#modal_add_config').find('#waktu_awal_kota').val(data.data.waktu_mulai_penginputan_kab_kota);
			$('#modal_add_config').find('#waktu_kunci_kota').val(data.data.waktu_akhir_penginputan_kab_kota);


			$('#modal_add_config').find('#waktu_awal').val(data.data.jam_mulai_penginputan);
			$('#modal_add_config').find('#waktu_kunci').val(data.data.jam_akhir_penginputan);
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}


function simpanedit_config()
{
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.text-danger').remove();
    var formdata = $('#form_config').serialize();


   
	$.ajax({
		url: baseUrl('config/simpanedit_konfigurasi'),
		type: 'POST',
		dataType: 'JSON',
		data: formdata,
		success: function (datanya)
		{
			if (datanya.success==true) {
					$('#modal_add_config').modal('hide');
					// Swal.fire('Disimpan','Data konfigurasi aplikasi tahun anggaran '+datanya.tahun_anggaran+'diperbaharui','success');
					window.location.href=baseUrl('config');
			}else{
				$.each(datanya.messages, function (key, value)
				{
					var element = $('#modal_add_config').find('#' + key);
					element.removeClass('is-invalid')
						.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
						.find('.text-danger')
						.remove();
					element.after(value);
				});



					// Swal.fire('Forbidden','Data konfigurasi gagal ditambahkan. Tahun anggaran '+datanya.tahun_ini+' sudah ada','error');
			}
				   	// $('#table-config').DataTable().ajax.reload(null, false);
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
		}
	});
}


  function skpd_pemprov(id_config){
  		$('#list_skpd_pemprov_' + id_config).html('');
        $.ajax({
            url: baseUrl('config/list_config_skpd_provinsi'),
            type: 'POST',
            dataType: 'JSON',
            data: {id_config : id_config },
            success: function (data)
            {
                $.each(data.data, function (k,v){
		  		$('#list_skpd_pemprov_' + id_config).append(`
		  			<li class="list-group-item">
                        <div class="todo-indicator bg-info"></div>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                
                                <div class="widget-content-left">
                                    <div class="widget-heading">` + v.nama_instansi+`
                                       
                                    </div>
                                    <div class="widget-subheading"><i>`+ v.nama_tahap +`</i></div>
                                </div>
                                
                            </div>
                        </div>
                    </li>
                    `);


                })
               
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }
  function skpd_kab_kota(id_config){
  		$('#list_skpd_kab_kota_' + id_config).html('');
        $.ajax({
            url: baseUrl('config/list_config_skpd_kab_kota'),
            type: 'POST',
            dataType: 'JSON',
            data: {id_config : id_config },
            success: function (data)
            {
                $.each(data.data, function (k,v){
		  		$('#list_skpd_kab_kota_' + id_config).append(`
		  			<li class="list-group-item">
                        <div class="todo-indicator bg-info"></div>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                
                                <div class="widget-content-left">
                                    <div class="widget-heading">` + v.nama_kota+`
                                       
                                    </div>
                                    <div class="widget-subheading"><i>`+ v.nama_tahap +`</i></div>
                                </div>
                                
                            </div>
                        </div>
                    </li>
                    `);


                })
               
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }
</script>