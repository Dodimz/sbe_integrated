<div class="row">
                                <div class="col-md-12">










                                    <div class="main-card mb-3 card">
                                        <div class="card-header">
                                            Preview 
                                            <div class="btn-actions-pane-right actions-icon-btn">
                                                <div role="group" class="btn-group-sm nav btn-group">
                                                    <a href="<?php echo base_url() ?>integrasi_aplikasi/get_auto_evidence?id_opd=<?php echo $id_opd ?>&tahun=<?php echo $tahun ?>" class="btn-shadow active btn btn-dark" onclick="start_loading('Mendapatkan evidence Otomatis')">Auto Evidence</a>
                                                    <!-- <a data-toggle="tab" href="#tab-eg3-1" class="btn-shadow  btn btn-dark">Tab 2</a> -->
                                                    <!-- <a data-toggle="tab" href="#tab-eg3-2" class="btn-shadow  btn btn-dark">Tab 3</a> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="overflow-y: scroll; height: 600px">
                                    <?php echo $this->session->flashdata('pesan') ?>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Kode Sub Kegiatan</td>
                                                        <td>Nama Sub Kegiatan</td>
                                                        <td>Jenis Sub Kegiatan</td>
                                                        <td>Pagu</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($sub_kegiatan_instansi as $k => $v) { ?>
                                                         <tr style="background: aqua">
                                                            <td><?php echo $k+1 ?></td>
                                                            <td><?php echo $v['kode_sub_kegiatan'] ?></td>
                                                            <td><?php echo $v['nama_sub_kegiatan'] ?></td>
                                                            <td><?php echo $v['kategori'] ?></td>
                                                            <td><?php echo $v['pagu']=='' ? 0 : number_format($v['pagu']) ?></td>
                                                        </tr>
                                                         <tr>
                                                            <td colspan="5">
                                                                <?php if (count($v['paket'])>0) { ?>
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>No</td>
                                                                        <td>Nama Paket</td>
                                                                        <td>Jenis Paket</td>
                                                                        <td>Metode</td>
                                                                        <td>Pagu</td>
                                                                        <td>ID RUP</td>
                                                                        <td>Input By</td>
                                                                        <td>Auto Evidence</td>
                                                                    </tr>
                                                                    <?php foreach ($v['paket'] as $k_paket => $v_paket) { 
                                                                        $id_paket = $v_paket['id_paket_pekerjaan'] ; ?>
                                                                         <tr>
                                                                            <td><?php echo $k_paket+1 ?></td>
                                                                            <td><?php echo $v_paket['nama_paket'] ?></td>
                                                                            <td><?php echo $v_paket['jenis_paket'] ?></td>
                                                                            <td><?php echo $v_paket['metode'] ?></td>
                                                                            <td><?php echo number_format($v_paket['pagu']) ?></td>
                                                                            <td><?php echo $v_paket['integrasi_sipedal_id_rup'] ?></td>
                                                                            <td><?php echo $v_paket['input_by'] ?></td>
                                                                            <td>
                                                                                <?php if ($v_paket['integrasi_sipedal_id_rup']=='') {
                                                                                    echo "Tidak bisa auto Evidence";
                                                                                }else{
                                                                                    $rf = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket' and auto_evidence=1 ");
                                                                                    echo $rf->num_rows() . ' Auto Evidence';
                                                                                } ?>
                                                                            </td>
                                                                          
                                                                        </tr>
                                                                    <?php } ?>
                                                                </table>
                                                            <?php }else{
                                                                echo "Belum ada data paket pekerjaan";
                                                            } ?>
                                                            </td>
                                                            
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                       













                                       <div class="widget-content" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Jumlah Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Non Urusan  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Jumlah Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Swakelola
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Jumlah Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Penyedia  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Semua Paket
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Terintegrasi Sipedal</b></div>
                                                                    <div class="widget-heading">
                                                                        Telah Di Importkan  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Evidence Auto</b></div>
                                                                    <div class="widget-heading">
                                                                        Swakelola
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        ????                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>




                                  
                                </div>
                              
                            </div>

