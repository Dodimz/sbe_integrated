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
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="nama_pptk"><strong>Nama PPTK</strong></label>
                            <div class="input-group mb-3">
                                <input type="hidden" id="id_realisasi_fisik" name="id_realisasi_fisik" value="<?php echo sbe_crypt($r_fisik->id_realisasi_fisik); ?>">
                                <input type="hidden" id="id_paket_pekerjaan" name="id_paket_pekerjaan" value="<?php echo $r_fisik->id_paket_pekerjaan; ?>">
                                <input type="hidden" id="dokumen" name="dokumen" value="<?php echo $r_fisik->dokumen; ?>">
                                <input type="text" class="form-control" id="nama_pptk" name="nama_pptk" readonly="true" value="<?php echo $r_fisik->full_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="nama_kegiatan"><strong>Nama Kegiatan</strong></label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" readonly="true" value="<?php echo $r_fisik->nama_kegiatan; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-8">
                            <label for="nama_paket"><strong>Nama Paket</strong></label>
                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" readonly="true" value="<?php echo $r_fisik->nama_paket; ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="masalah"><strong>Masalah</strong></label>
                            <input type="text" class="form-control" id="masalah" name="masalah" readonly="true" value="<?php echo $r_fisik->masalah; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="solusi"><strong>Solusi</strong></label>
                            <input type="text" class="form-control" id="solusi" name="solusi" readonly="true" value="<?php echo $r_fisik->solusi; ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for=""><strong><?php echo $r_fisik->dokumen; ?></strong></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload-file" name="upload_file" aria-describedby="inputGroupFileAddon04" onchange="get_file_name(this)">
                                    <label class="custom-file-label" id="label-upload" for="upload-file">Choose File</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="btn-upload-upload-file" onclick="do_upload()">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </>