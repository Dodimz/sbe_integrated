<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */

$pilihan_bulan = [
    1=>'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'                                   
];
?>

<div class="modal fade" id="modal_edit_ckk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Konfigurasi Kab Kota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3" id="logo"></div>
                    <div class="col-md-8" id="kab_kota"></div>
                  
                </div>
                <br>

                <form id="form_edit_ckk">
                    
                        <input type="hidden" class="form-control" id="id_config" name="id_config">
                    <div class="form-group" >
                        <label for="kode">Replikasi Aplikasi</label>
                        <select class="form-control" id="replikasi" name="replikasi">
                            <option value=""></option>
                            <?php $replikasi = [
                                1=>'Belum Mereplikasikan',
                                'Install Localhost / Penyerahan Source Code',
                                'Instalasi & Testing Server',
                                'Instalasi Online Online',
                                'Testing, Maintenance, Penyesuaian Data',
                                'Implementasi & Maintenance Online',
                                'Terintegrasikan ',
                            ];
                            foreach ($replikasi as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form_replikasi" id="form_link_replikasi">
                        <label for="kode">Link Replikasi</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                    <div class="form-group form_replikasi">
                        <label for="kode">Integrasi Replikasi</label>
                         <select class="form-control" id="integrasi" name="integrasi">
                            <option value=""></option>
                            <?php $integrasi = [
                                'Tidak',
                                'Ya',
                            ];
                            foreach ($integrasi as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form_replikasi" id="form_token_integrasi">
                        <label for="kode">Token Integrasi Replikasi</label>
                         <input type="text" class="form-control" id="token_integrasi" name="token_integrasi">
                           
                    </div>
                    <div class="form-group form_replikasi">
                        <label for="kode">Sumber Data SIAP Sumbar</label>
                         <select class="form-control" id="sdss" name="sdss">
                            <option value=""></option>
                            <?php $sdss = [
                                'Replikasi',
                                'SBE Provinsi',
                            ];
                            foreach ($sdss as $k => $v) { ?>
                                <option value="<?php echo $v ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_ckk()">Simpan</button>
            </div>
        </div>
    </div>
</div>