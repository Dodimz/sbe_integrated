<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form id="form-update-evidence">
                    <div class="form-row mb-5">
                      
                        <div class="col-md-7">
                            <input type="hidden" id="id_docs" name="id_docs" class="form-control" value="<?php echo sbe_crypt($docs->id_docs); ?>" readonly> 
                            <img src="<?php echo $image_file ?>" alt="<?php echo $image_file ?>" style="width:100%"><br>
                            
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <h6>Kategori</h6>
                                <?php echo $docs->kategori_menu; ?>
                            </div>
                            <div class="form-group">
                                <h6>Menu</h6>
                                <?php echo $docs->nama_menu; ?>
                            </div>
                            <div class="form-group">
                                <h6>Bagian Menu</h6>
                                <?php echo $docs->bagian_menu; ?>
                            </div>
                            <div class="form-group">
                                <h6>Keterangan</h6>
                                <?php echo $docs->desc_dokumentasi; ?>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-sm">Tambah Detail Dokumentasi</button><br>
                                pada bagian tambnah dokumentasi ini menggunakan modal seperti pada upload evidence. mempunyai 1 upload dan ada form inputan yang terdiri dari kode dan keterangan <br>File upload an harus dalam bentuk pdf (jika untuk membacanya nanti). untuk edit sama dengan input dan hapus seperti bi
                            </div>
                            
                            
                        </div>
                        <div class="divider"></div>
                    </div>
                    <hr>
                    <div class="form-row">
                      
                       <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table-sbe-detail-docs" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                  
                                         
                                            <th style="width:20%">Kode</th>
                                            <th>Keterangan</th>
                                            <th>File Pendukung</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                   
                    
                
                </form>
            </div>
        </div>
    </div>
    </>