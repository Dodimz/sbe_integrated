<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
	$(window).on('load', function(){
		$('#email').focus();
	});

	$('#email').keypress(function(e){
		if(e.which == 13){
			$('#password').focus();
			return false;
		}
	});

	$('#password').keypress(function(e){
		if(e.which == 13){
			$('#btn-signin').focus();
			return false;
		}
	});

	$('#form-login').on('submit', function(e){
		e.preventDefault();
		let me 			= $(this);
		let email 		= $('#email').val();
		let password	= $('#password').val();

		$('#btn-signin').html('Loading....');
		$.ajax({
			url		: baseUrl('auth/login'),
			type	: "POST",
			data 	: $(this).serialize(),
			cache 	: false,
			success	: function(data)
			{
				let output = JSON.parse(data);

				if(output.status==false)
				{
					if(output.message)
					{
						$(".notifikasi").html('<div class="alert alert-danger alert-dismissible" id="notif">'+'<span></span>'+output.message)
			            $(".notifikasi").fadeTo(1000,1000).slideUp(1000, function(){
			              $(".notifikasi").slideUp(1000);
			            });
			        }
					me[0].reset();
		            $('#btn-signin').html('Sign In');
					$('#email').focus();
				}else{
					$(".login-box").slideUp(500,function(){
		              setTimeout(function(){
		                window.location.href = baseUrl('dashboard');
		              });
		            });
				}
			}
		});
	});
</script>