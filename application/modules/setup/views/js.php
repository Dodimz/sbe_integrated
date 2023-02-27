<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Setup.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	/* Windows On Load */
	$(window).on('load',function(){
		$('input[id=kab_kota]').focus();
	});
	/* Focus on keypress */
	$('#kab_kota').keypress(function(e){
		if (e.which == 13) {
			$('#email').focus();
			return false;
		}
	});
	$('#email').keypress(function(e){
		if (e.which == 13) {
			$('#register').focus();
			return false;
		}
	});
	/* Action On Register */
	$('#register-form').on('submit',function(e){
		e.preventDefault();
		let me  = $(this);
		let isi = $('#terms').is(":checked");
		if(isi)
		{
			$.ajax({
				url: "<?php echo base_url('setup/save_identitas'); ?>",
				type: "POST",
				data: $('#register-form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('#notifikasi').html('<div class="alert alert-success">' +
								  '<span class="glyphicon glyphicon-ok"> </span>' +
								  ' Registrasi Berhasil'
								  );
					setTimeout(function(){
						window.location.href = base_url+"auth";
					});
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					console.log('Error adding / update data');
					$('#btn-register').text('Register');
					$('#btn-register').attr('disabled',false);
				}
			});
		}else{
			$('#notifikasi').html('<div class="alert alert-danger">' +
								  '<span class="glyphicon glyphicon-ok"> </span>' +
								  ' Silahkan checklist I agree to terms'
								  );
		}
	});
</script>
