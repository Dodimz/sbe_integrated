
<?php 
$aktiv = ['Tidak Aktif','Aktif'] ?>










<div class="tabs-animation">
 
    <div class="row">
        <div class="col-lg-8 col-xl-8">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-striped">
                        	
                        	<tr>
                        		<td>Hak Akses</td>
                        		<td>:</td>
                        		<td><?php  echo $this->session->userdata('group_name'); ?></td>
                        	</tr>
                        	
                        	
                        	
                        </table>
                    </div>
                 
                    <div class="form-group">
                        <button class="btn btn-info btn-sm" onclick="ganti_password()" style="" id="ganti_pass"><i class="fas fa-refresh"></i>Edit Password</button>
                        <!-- <button class="btn btn-info btn-sm" onclick="edit_user()"><i class="fas fa-refresh"></i>Edit Akun</button> -->
                    </div>
                    
                </div>
            </div>
        </div>
    
    </div>
</div>





