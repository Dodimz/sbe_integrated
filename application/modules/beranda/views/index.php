<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth.php
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="login-box">
  <div class="login-logo">
    <!-- <small>SIMBANGDA</small> -->
    <img src="<?php echo base_url(); ?>assets/sbe/image/logo.png" width="70px" height="80px" alt="img-logo" class="logo-app text-left">
    <a><b>S</b>IMBANGDA</a>
    <small class="sub-title">Based Evidence V.5.0.0 <br>Tahun 2022</small>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan tekan Login untuk masuk ke dalam aplikasi</p>
    <div class="notifikasi"></div>
    <form id="form-login" method="post">
     
      <div class="row">
        <div class="col-xs-8">
         <!--  <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
          <a href="<?php echo base_url() ?>auth" class="btn btn-info btn-block btn-flat" id="btn-signin">Login</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>
        Copyright &copy 2021
        <br>
        <b>Biro Administrasi Pembangunan</b> <br>Setda Provinsi Sumatera Barat
      </p>

    </div>
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->