<!-- Author      : Alfikri -->
<!-- Created  By : Alfikri -->
<!-- E-Mail      : alfikri.name@gmail.com -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?> - <?php echo $this->template->settings('app_name'); ?></title>
  <!-- Favico -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/sbe/favicon.ico" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="author" content="Alfikri" />
  <meta name="description" content="SIMBANGDA Based Evidence, simbangda based evidence, SIMBANGDA berbasis pembuktian, simbangda berbasis pembuktian, SIMBANGDA SUMBAR, simbangda sumbar, Sistem Informasi Manajemen Pembangunan Daerah, Sistem Informasi Manajemen Pembangunan Daerah Sumbar, Sumatera Barat" />
  <meta name="keywords" content="Simbangda based evidence, Sistem Informasi Manajemen Pembangunan Daerah, simbangda berbasis pembuktian, simbangda sumbar, Sumbar, Sumatera Barat, Pemprov Sumbar, Pemerintah Provinsi Sumatera Barat, Alfikri, Al, Fikri, alfikri, alfikri, alfikridotname" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_lte/plugins/iCheck/square/blue.css">
  <?php echo $extra_css; ?>
  <style>
    body {
      background-color: white;
      background-image: url('assets/sbe/image/bg1.jpg');
      background-attachment: fixed;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: top;
    }

    .sub-title {
      position: absolute;
      top: 0px;
      right: 10px;
      bottom: 10px;
      padding-top: 55px;
      padding-left: 40px;
      font-size: 12px;
      color: black;
    }

    .login-logo {
      opacity: 0;
      transform: translateY(-100px);
      color: black;
      transition: 0.5s;
    }

    .logo-app {
      /*position: absolute;*/
      opacity: 0;
      transition: 2s;
    }

    .logo-app.lliShow {
      opacity: 1;
    }

    .login-logo a {
      color: black;
    }

    .login-logo.llShow {
      color: white;
      transform: translate(0);
      opacity: 1;
    }

    .login-box-body {
      opacity: 0;
      transform: translateY(100px);
      transition: 0.5s;
      box-shadow: 0px 25px 10px -15px rgba(0, 0, 0, 0.5);
    }

    .login-box-body.lbbShow {
      opacity: 1;
      transform: translate(0);
    }

    .login-box-body,
    .register-box-body {
      background: #fff;
      padding: 20px;
      border-top: 0;
      color: #666;
      box-shadow: 0px 5px 10px #888888;
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>

<body class="hold-transition register-page">

  <?php echo $contents; ?>

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/admin_lte/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url(); ?>assets/admin_lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url(); ?>assets/admin_lte/plugins/iCheck/icheck.min.js"></script>
  <script>
    // event window load
    $(window).on('load', function() {

      // identity focus
      $('input[id=identity]').focus();
      // login-logo
      $('.login-logo').addClass('llShow');

      // login-box-body
      $('.login-box-body').addClass('lbbShow');

      // login-logo img
      setTimeout(function() {
        $('.login-logo .logo-app').addClass('lliShow');
      }, 500);

    });

    function baseUrl(link = '') {
      let alamat = "<?php echo base_url(); ?>" + link;
      return alamat;
    }
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });
  </script>
  <?php echo $extra_js; ?>
</body>

</html>