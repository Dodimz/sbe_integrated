
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
                        	<tr>
                        		<td>SKPD</td>
                        		<td>:</td>
                        		<td><?php echo $data_user->nama_instansi ?></td>
                        	</tr>
                        	<tr>
                        		<td>Full Name</td>
                        		<td>:</td>
                        		<td><?php echo $data_user->full_name ?></td>
                        	</tr>
                            <tr>
                                <td>No HP</td>
                                <td>:</td>
                                <td><?php echo $data_user->nohp ?></td>
                            </tr>
                        	<tr>
                        		<td>Email</td>
                        		<td>:</td>
                        		<td><?php echo $data_user->email ?></td>
                        	</tr>
                        	<tr>
                        		<td>Status</td>
                        		<td>:</td>
                        		<td><?php echo $aktiv[$data_user->is_active] ?></td>
                        	</tr>
                        	
                        	
                        </table>
                    </div>
                 
                    <div class="form-group">
                        <?php if ($this->session->userdata('id_group')==0): ?>
                            
                        <button class="btn btn-info btn-sm" onclick="ganti_password_default()" style="" id="ganti_password_default"><i class="fas fa-refresh"></i>Edit Password Default</button>
                        <?php endif ?>
                        <button class="btn btn-info btn-sm" onclick="ganti_password()" style="" id="ganti_pass"><i class="fas fa-refresh"></i>Edit Password</button>
                        <button class="btn btn-info btn-sm" onclick="edit_user()"><i class="fas fa-refresh"></i>Edit Akun</button>
                    </div>
                    
                </div>
            </div>
        </div>
    
    </div>
</div>





