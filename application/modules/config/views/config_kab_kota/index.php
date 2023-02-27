
<div class="mb-3 card">
    <div class="card-body">
            <?php echo $this->session->flashdata('pesan') ?>
        <div class="row">
            <div class="col-md-4">
                <h6>Konfigurasi Aplikasi</h6> <br>
                <table class="table table-striped">
                    <tr>
                        <td>Wilayah</td>
                        <td>:</td>
                        <td>
                        PROVINSI <?php echo $data->nama_provinsi ?><br>
                        <?php echo $data->nama_kota ?><br>
                        Wilayah <?php echo $data->wilayah ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Anggaran</td>
                        <td>:</td>
                        <td><?php echo tahun_anggaran() ?></td>
                    </tr>
                    <tr>
                        <td>Tahapan APBD</td>
                        <td>:</td>
                        <td><?php echo $nama_tahap[tahapan_apbd()] ?></td>
                    </tr>
                
                    <tr>
                        <td>Bulan Aktif</td>
                        <td>:</td>
                        <td><?php echo bulan_global(bulan_aktif()) ?></td>
                    </tr>
                    <tr>
                        <td>Penanggung Jawab Pelaporan</td>
                        <td>:</td>
                        <td>
                            <?php 
                            if ($data->id_pj=='') {
                                echo "Belum ditetapkan";
                            }else{
                                echo 'SKPD : '.$data->nama_instansi.'<br>';
                                echo 'Nama : '.$data->nama.'<br>';
                                echo 'NIP : '.$data->nip.'<br>';
                                echo 'Jabatan : '.$data->jabatan.'<br>';
                            }
                             ?>
                        </td>
                    </tr>
                </table>
                <button type="button" class="btn btn-info" onclick="edit_config_kab_kota()">Edit Konfigurasi</button>
            </div>
            <div class="col-md-8">
                <div style="float:left">
                    <h6>Penanggung Jawab Pelaporan</h6>
                </div>
                <div style="float:right">
                    <button type="button" class="btn btn-info btn-sm" onclick="tambah_pj_pelaporan_kab_kota()">Tambah Penanggung Jawab</button>
                </div>
                <div class="clearfix"></div>
                <br>
                <table class="table table-striped table-bordered" id="tabel_pj">
                   <thead>
                        <tr>
                            <td rowspan="2">No</td>
                            <td rowspan="2">Instansi Penanggung Jawab</td>
                            <td colspan="5"><center>Penanggung Jawab</center></td>
                            <td rowspan="2">Option</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>NIP</td>
                            <td>Jabatan</td>
                            <td>Mulai Penanggung Jawab Pelaporan</td>
                            <td>Akhir Penanggung Jawab Pelaporan</td>
                        </tr>
                   </thead>
                   
                </table>
                
            </div>
        </div>
    </div>
</div>