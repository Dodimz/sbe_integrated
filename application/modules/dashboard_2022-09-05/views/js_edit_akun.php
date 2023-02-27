<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Chart -->
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<!-- Export -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>


	function sync(id_instansi) {
		$('#tombol_sync').text('Loading...').attr('disabled', true);
		$.ajax({
			url: baseUrl('synchronize/sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_instansi: id_instansi
			},
			success: function(data) {
				if (data.status == true) {
					window.location.href = "<?php echo base_url(); ?>";
				}
			},
			error : function(){
				$('#tombol_sync').text('Reload Page').attr('disabled', false);
				$('#tombol_sync').attr('onclick', "reload()");
			}
		});
	}

	function reload(){
		window.location.href = "<?php echo base_url(); ?>";
	}



	let options = $.ajax({
		url: baseUrl('dashboard/simulasi'),
		dataType: 'JSON',
		async: false,
		success: function(data) {}
	});

	var exportUrl = 'https://export.highcharts.com/';

	// POST parameter for Highcharts export server
	var object = {
		options: JSON.stringify(options.responseJSON),
		type: 'image/jpeg',
		async: true
	};

	// Ajax request
	$.ajax({
		type: 'post',
		url: exportUrl,
		data: object,
		success: function(data) {
			clog(data);
		}
	});



	function ganti_password(){
		$('#modal_ganti_password').modal('show');
		$('#form_edit_password')[0].reset();
	}




    function ganti_password_default(){
        $('#modal_ganti_password_default').modal('show');
        $('#form_edit_password_default')[0].reset();
    }



	function simpan_perubahan_password(){
		var full_name = $('#full_name').val();
		var email = $('#email').val();
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('dashboard/saveedit_password'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_edit_password').serialize(),
			success: function (datanya)
			{
				if(datanya.success == true)
				{
					if(datanya.messages == "Password Lama Anda tidak cocok"){
						var value = '<p class="text-danger">' +datanya.messages + ". Silahkan coba kembali " + '</p>';
						var element = $('#pass_lama');
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					}else{
						$('#form_edit_password')[0].reset();
						$('#modal_ganti_password').modal('hide');
						Swal.fire('Berhasil','Password berhasil diubah','success');
					}
					
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

	function simpan_perubahan_password_default(){
		var full_name = $('#full_name').val();
		var email = $('#email').val();
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('dashboard/saveedit_password_default'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_edit_password_default').serialize(),
			success: function (datanya)
			{
				if(datanya.success == true)
				{
						$('#form_edit_password_default')[0].reset();
						$('#modal_ganti_password_default').modal('hide');
						Swal.fire('Berhasil','Password berhasil diubah','success');
					
					
				}else{
					$.each(datanya.messages, function (key, value)
					{
						var element = $('#modal_ganti_password_default').find('#' + key);
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


	function edit_user(){
		$('#modal_edit_user').modal('show');
		$('#form_edit_user')[0].reset();
	}


	function simpan_edit_user(){
		var full_name = $('#full_name').val();
		var email = $('#email').val();

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();



		$.ajax(
        {
            url     : baseUrl('dashboard/saveedit_user/'),
            dataType: 'JSON',
            type    : 'POST',
            data: $('#form_edit_user').serialize(),
            success : function(data)
            {
                if(data.success == true)
                {
                	window.location.href="<?php echo base_url() ?>dashboard/my_profile"
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
</script>