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

<div class="register-box">
  <div class="text-center h3">
    <b>S</b>IMBANGDA Based Evidence
  </div>
  <div class="register-box-body">
    <div class="row">
      <div id="notifikasi">
        
      </div>
    </div>
    <form id="register-form">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="kab_kota" name="kab_kota" placeholder="Kabupaten/Kota" required="true">
        <span class="glyphicon glyphicon-home form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="true">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="terms" required="true"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn-register">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.form-box -->
</div>