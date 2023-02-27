<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="notifikasi"></div>
                <button type="button" class="btn btn-primary" id="addMasterUser" onclick="addMasterUser()">Add New Data</button>
                <hr>
                <table id="table-master-user-kab-kota" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
							<th>Wilayah</th>

							<th>Group</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>E-Mail</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
