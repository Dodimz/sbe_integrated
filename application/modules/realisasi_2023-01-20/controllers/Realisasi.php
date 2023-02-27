<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // error_reporting(0);
        $this->load->model([

            'dashboard/dashboard_model'       => 'dashboard_model',


            'paket_pekerjaan/master_paket_model'      => 'master_paket_model',

            'realisasi/realisasi_fisik_model'       => 'realisasi_fisik_model',
            'realisasi/realisasi_keuangan_model'    => 'realisasi_keuangan_model',
            'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
            'realisasi/dokumen_evidence_model'      => 'dokumen_evidence_model',
            'validasi/validasi_fisik_model' => 'validasi_fisik_model',

            'synchronize/target_realisasi_model'     => 'target_realisasi_model',
            'datatables_model'                      => 'datatables_model'
        ]);
    }

    public function fisik()
    {
        $breadcrumbs        = $this->breadcrumbs;
        $realisasi_fisik    = $this->realisasi_fisik_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Fisik', base_url());
        $breadcrumbs->render();



        $data['fetch_method']       = $this->router->fetch_method();
        $data['title']       = "Realisasi Fisik";
        $data['icon']        = "metismenu-icon fa fa-list-ul";
        $data['description'] = "Input Realisasi Fisik";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $page                = 'realisasi/fisik/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/fisik/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/fisik/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/fisik/modal', $data, true);

        $config              = $this->db->get_where('config',['id_config'=>'1'])->row();
        $id_instansi = id_instansi();
        $nilai_rf            = $this->nilai_realisasi_fisik($id_instansi);
        $data['nilai_rf']       = $nilai_rf[bulan_aktif()-1];
        // $prs                = explode(' ', $config->realisasi_fisik_selesai);
        // $jam_deadline       = $prs[1];
        // $ptrs               = explode('-', $prs[0]);
        // $tgl_deadline       = $ptrs[2].'-'.$ptrs[1].'-'.$ptrs[0];
        $data['deadline']        = "";// $tgl_deadline.' | '.$jam_deadline;

        $cek_helpdesk = $realisasi_fisik->helpdesk();
        if ($cek_helpdesk->num_rows()==0) {
            $helpdesk = "Belum ditentukan";
        }else{
            $helpdesk = $cek_helpdesk->row()->helpdesk;
        }
        $data['helpdesk']        = $helpdesk;


        $validasi_fisik = $this->validasi_fisik_model;
        $data['total_paket']           = $validasi_fisik->total_paket_pekerjaan();
        $data['total_paket_rutin']     = $validasi_fisik->total_paket_rutin();
        $data['total_paket_swakelola'] = $validasi_fisik->total_paket_swakelola();
        $data['total_paket_penyedia']  = $validasi_fisik->total_paket_penyedia();
        $this->template->load('backend_template', $page, $data);
    }
    public function fisik_sub_kegiatan()
    {
        $breadcrumbs        = $this->breadcrumbs;
        $realisasi_fisik    = $this->realisasi_fisik_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Fisik', base_url());
        $breadcrumbs->render();


        $data['fetch_method']       = $this->router->fetch_method();

        $data['title']       = "Realisasi Fisik";
        $data['icon']        = "metismenu-icon fa fa-list-ul";
        $data['description'] = "Menampilkan Data Realisasi Fisik Berdasarkan Sub Kegiatan";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $page                = 'realisasi/fisik/by_sub_kegiatan';
        $id_instansi = id_instansi();
        $nilai_rf            = $this->nilai_realisasi_fisik($id_instansi);
        $data['nilai_rf']       = $nilai_rf[bulan_aktif()-1];
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/fisik/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/fisik/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/fisik/modal', $data, true);

        $config              = $this->db->get_where('config',['id_config'=>'1'])->row();
        // $prs                = explode(' ', $config->realisasi_fisik_selesai);
        // $jam_deadline       = $prs[1];
        // $ptrs               = explode('-', $prs[0]);
        // $tgl_deadline       = $ptrs[2].'-'.$ptrs[1].'-'.$ptrs[0];
        $data['deadline']        = '';// $tgl_deadline.' | '.$jam_deadline;

        $cek_helpdesk = $realisasi_fisik->helpdesk();
        if ($cek_helpdesk->num_rows()==0) {
            $helpdesk = "Belum ditentukan";
        }else{
            $helpdesk = $cek_helpdesk->row()->helpdesk;
        }
        $data['helpdesk']        = $helpdesk;


        $validasi_fisik = $this->validasi_fisik_model;
        $data['total_paket']           = $validasi_fisik->total_paket_pekerjaan();
        $data['total_paket_rutin']     = $validasi_fisik->total_paket_rutin();
        $data['total_paket_swakelola'] = $validasi_fisik->total_paket_swakelola();
        $data['total_paket_penyedia']  = $validasi_fisik->total_paket_penyedia();
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_kpa()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $tahun = tahun_anggaran();
            if ($this->session->userdata('kedudukan') == 'PPTK') {
                $where = [
                    'id_instansi'       => id_instansi(),
                    'id_kedudukan'      => 2,
                    'id_sub_instansi'   => $this->sbe_id_sub_instansi()
                ];
            } else {
                $where = [
                    'id_instansi'   => id_instansi(),
                    'id_kedudukan'  => 2
                ];
            }
            $column_order   = ['', 'nama_sub_instansi', 'full_name'];
            $column_search  = ['nama_sub_instansi', 'full_name'];
            $order          = ['nama_sub_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kpa', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $row    = [];
                $row[]  = '<button class="btn btn-info btn-sm" id="show-pptk" id-user="' . $lists->id_user . '"><i class="fa fa-plus"></i></button>';
                $row[]  = '<strong>' . $lists->nama_sub_instansi . '</strong>';
                $row[]  = '<strong>' . $lists->full_name . '</strong>';
                $row[]  = $lists->jml_pptk;

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_kpa', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_kpa', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    public function list_pptk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];
            $tahun = tahun_anggaran();
            $id_user_top_parent = $this->input->post('id_user_top_parent');
            $pptk               = $this->realisasi_fisik_model->pptk($id_user_top_parent);
            if ($pptk->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($pptk->result() as $key => $value) {
                    $output['data'][$key]['id_user']        = $value->id_user;
                    $output['data'][$key]['nama']           = $value->full_name;
                    $output['data'][$key]['sub_instansi']   = $value->nama_sub_instansi;
                    $output['data'][$key]['jml_keg']        = $this->jumlah_sub_kegiatan($value->id_user).' Sub ';
                    $output['data'][$key]['jml_paket']      = $this->jumlah_paket($value->id_user);
                }
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

    protected function jumlah_kegiatan($id_user)
    {
        return $this->db->query("SELECT COUNT(*) AS jml FROM users_kegiatan WHERE id_user = " . $id_user)->row()->jml;
    }
 protected function jumlah_sub_kegiatan($id_user)
    {
        $tahap = tahapan_apbd();
        $tahun = tahun_anggaran();
        return $this->db->query("SELECT COUNT(*) AS jml FROM users_sub_kegiatan WHERE id_user ='$id_user' and kode_tahap='$tahap' and tahun_anggaran = '$tahun'")->row()->jml;
    }

    protected function jumlah_paket($id_user)
    {
        $tahun = tahun_anggaran();
        return $this->db->query("SELECT COUNT(*) AS jml FROM paket_pekerjaan WHERE tahun='$tahun' and id_pptk = " . $id_user)->row()->jml;
    }

    public function list_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => '',
                'kedudukan' => ''
            ];
            $id_user    = $this->input->post('id_user');
            $where      = [
                'id_user'       => $id_user,
                'id_instansi'   => id_instansi(),
                'kode_tahap'    => tahapan_apbd()
            ];

            $kegiatan   = $this->realisasi_fisik_model->kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());
            if ($kegiatan->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                    $output['data'][$key]['id_pptk']    = $value->id_user;
                    $output['data'][$key]['rekening']   = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kegiatan']   = $value->nama_kegiatan;
                    $output['data'][$key]['jml_paket']  = $value->jml_paket;
                }

                $output['kedudukan'] = $this->session->userdata('kedudukan');
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

     public function list_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => '',
           
            ];
            $id_user     =$this->input->post('id_user');
            $where      = [
                'id_user' => $id_user,
                'id_instansi' => id_instansi(),
                'kode_tahap' => tahapan_apbd()
            ];
            $id_instansi = id_instansi();
            // $tahap = tahapan_apbd();
            $tahun = tahun_anggaran();
            $kegiatan     = $this->realisasi_fisik_model->sub_kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());

            $status_sub_kegiatan = ['Tidak Aktif','Aktif'];
            if ($kegiatan->num_rows() > 0) :
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                	$pecah = explode('.', $value->kode_rekening_sub_kegiatan);
                    $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                    $output['data'][$key]['id_pptk']     = $value->id_user;
                    $output['data'][$key]['kode_sub_kegiatan']     = $value->kode_rekening_sub_kegiatan;
                    $output['data'][$key]['kode_rekening_sub_kegiatan']     = $value->kode_rekening_sub_kegiatan;
                    $tahap = $value->kode_tahap;
                    $output['data'][$key]['tahapan_apbd'] = pilihan_nama_tahapan($tahap);
                    $status = $value->status;
                    $output['data'][$key]['status_sub_kegiatan'] = $status_sub_kegiatan[$status];
                    $output['data'][$key]['kode_bidang_urusan'] = $value->kode_bidang_urusan;
                    $output['data'][$key]['kode_kegiatan'] = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kode_program'] = $value->kode_rekening_program;

                    $output['data'][$key]['tahap'] = $value->kode_tahap;
                    $output['data'][$key]['tahun'] = $value->tahun;





                    $nama_sub_kegiatan = $value->kategori =='Sub Kegiatan SKPD' ? $value->nama_sub_kegiatan : $value->nama_sub_kegiatan.'<br>'.$value->jenis_sub_kegiatan.' - '.$value->keterangan; 
                    $output['data'][$key]['sub_kegiatan']     = $nama_sub_kegiatan;

                    $krsk = $value->kode_rekening_sub_kegiatan;
                    $krk = $value->kode_rekening_kegiatan;
                    $krp = $value->kode_rekening_program;
                    $kbu = $value->kode_bidang_urusan;

                     $cek_permasalahan = $this->db->query("SELECT id_permasalahan_sub_kegiatan from permasalahan_sub_kegiatan where id_instansi='$id_instansi' and kode_sub_kegiatan='$krsk' and tahun = '$tahun' and kode_tahap='$tahap'")->num_rows();
                    $qpagu = $this->db->query("SELECT pagu from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_rekening_sub_kegiatan='$krsk' and kode_rekening_kegiatan='$krk' and kode_rekening_program='$krp' and kode_bidang_urusan='$kbu'")->row()->pagu;

                    $jumlah_paket = $this->db->query("SELECT id_paket_pekerjaan from paket_pekerjaan where 
                        id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$krsk' and tahun='$tahun'
                        ")->num_rows();
                    $output['data'][$key]['jml_masalah']     = $cek_permasalahan;
                    $output['data'][$key]['jml_paket']     = $jumlah_paket;
                    $output['data'][$key]['pagu']     = $qpagu==''? 0: number_format($qpagu);
                }

            else :
                $output['status']     = false;
                $output['message']     = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

    public function dt_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $tahun = 
            $id_pptk        = $this->input->post('id_pptk');
            $kode_rekening  = $this->input->post('kode_rekening');
            $tahun  = tahun_anggaran();
            
            $kode_tahap = tahapan_apbd();

             if ($kode_tahap==4) {
                $where          = ['id_instansi' => id_instansi(), 'kode_rekening_sub_kegiatan' => $kode_rekening,'tahun'=>$tahun,'status'=>'1'];
                # code...
            }else{
                $where          = ['id_instansi' => id_instansi(), 'kode_rekening_sub_kegiatan' => $kode_rekening,'tahun'=>$tahun];

            }


            $column_order   = ['', 'nama_paket'];
            $column_search  = ['nama_paket'];
            $order          = ['nama_paket' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->jenis_paket;
                $row[]  = $lists->metode;

                $lokasi_paket = $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan) == 0 ? 'Belum Ada' : '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "','".$lists->nama_paket."'" . ')">' . $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan).' Lokasi' . '</button>';


                $row[]  = $lokasi_paket;

                $row[]  = $lists->volume;
                $row[]  = number_format($lists->pagu);
                if ($lists->jenis_paket=='RUTIN') {
                     $row[]  = '<button class="btn btn-success btn-sm" onclick="paket_rutin()"><i class="fas fa-check"></i></button>';
                     $id_instansi = $lists->id_instansi;
                    $bulan_mulai = mulai_realisasi_instansi($id_instansi);
                    $bulan_akhir = akhir_realisasi_instansi($id_instansi);
                    $lama_realisasi = $bulan_akhir - $bulan_mulai +1;
                    $bulan_ini = date('n') - $bulan_mulai;
                    $nilai_paket_rutin = round($bulan_ini / $lama_realisasi * 100, 2) ;
                    $show_nilai_paket_rutin = $nilai_paket_rutin > 0 ? $nilai_paket_rutin : 0 ;
                     $row[]  = '<button class="btn btn-info btn-sm" onclick="nilai_paket_rutin('.$show_nilai_paket_rutin.')"><i class="fa fa-list-ul"></i></button>';
                }else{
                    if ($lists->id_metode=='') {
                         $row[]  = '<button class="btn btn-danger btn-sm" onclick="metode_null()"><i class="fas fa-minus-circle"></i></button>';
                    }
                    elseif ($lokasi_paket=='Belum Ada') {
                         $row[]  = '<button class="btn btn-danger btn-sm" onclick="lokasi_0()"><i class="fas fa-minus-circle"></i></button>';
                    }else{
                        if ($this->cek_realisasi_fisik($lists->id_paket_pekerjaan, $lists->jenis_paket, $lists->id_metode) == true) {
                            $row[]  = '<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                        } else {
                            if ($lists->volume > 0) {
                                if (jadwal_rfk()['aktif']==0) {
                                    $row[]  = '<button class="btn btn-danger btn-sm" onclick="upload_berakhir()"><i class="fas fa-upload"></i></button>';
                                }else{

					                $nm_pk = str_replace('"', '', $lists->nama_paket);
    	                            $row[]  = '<button class="btn btn-info btn-sm" onclick="upload_dokumen(' . "'" . $lists->id_instansi . "','" . 'null' . "','" . $lists->id_pptk . "','" . $lists->id_paket_pekerjaan . "','" . $lists->kode_rekening_sub_kegiatan . "','" . $nm_pk . "','" . $lists->jenis_paket . "','" . $lists->id_metode . "'" . ')"><i class="fas fa-upload"></i></button>';
                                }
                            } else {
                                $row[]  = '<button class="btn btn-danger btn-sm" onclick="volume_0()"><i class="fas fa-minus-circle"></i></button>';
                            }
                        }
                    }
                $row[]  = '<button class="btn btn-info btn-sm" onclick="daftar_dokumen(' . "'" . sbe_crypt($lists->id_paket_pekerjaan, 'E') . "'" . ')"><i class="fa fa-list-ul"></i></button>';

                }



                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_paket', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_paket', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    protected function lokasi_paket_pekerjaan($id_paket_pekerjaan)
    {
        if ($id_paket_pekerjaan) {
            $list     = $this->db->get_where('v_lokasi_paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan])->num_rows();
            $hasil     = $list;
           
            return $hasil;
        }
    }



    public function dt_lokasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $where          = ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan];
            $column_order   = ['', 'nama_kecamatan'];
            $column_search  = ['nama_kecamatan','nama_kota','nama_provinsi'];
            $order          = ['nama_kecamatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_lokasi_paket_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->nama_provinsi. '<br> '.$lists->nama_kota;
                $row[]  = $lists->nama_kecamatan;
                
              

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_lokasi_paket_pekerjaan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_lokasi_paket_pekerjaan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }
    public function list_dokumen()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => '',
                'cek'       => []
            ];

            $id_instansi            = $this->input->post('id_instansi');
            $id_pptk                = $this->input->post('id_pptk');
            $id_paket_pekerjaan     = $this->input->post('id_paket_pekerjaan');
            $kode_rekening_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $jenis_paket            = $this->input->post('jenis_paket');
            $id_metode              = $this->input->post('id_metode');


            $realisasi_fisik = $this->db->get_where('realisasi_fisik', [
                'id_instansi'               => $id_instansi,
                'id_pptk'                   => $id_pptk,
                'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                'kode_rekening_sub_kegiatan'    => $kode_rekening_kegiatan
            ]);

            $where   = ['jenis_paket' => $jenis_paket, 'id_metode' => $id_metode];
            $dokumen = $this->db->get_where('master_bobot', $where);

            $rea        = [];
            $dok        = [];
            $judul_dok  = [];
            $list_pelaksanaan = [];
            if ($realisasi_fisik->num_rows() > 0) {
                foreach ($realisasi_fisik->result() as $key => $value) {
                    $rea[]  = $value->dokumen;
                }
            }

            if ($dokumen->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($dokumen->result() as $key => $value) {
                    $output['data'][$key]['nama_dokumen']   = $value->nama_dokumen;
                    $dok[]                                  = $value->nama_dokumen;
                }

                $result_pelaksanaan = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);

                foreach ($result_pelaksanaan->result() as $key => $value) {
                    $list_pelaksanaan[] = 'PELAKSANAAN-' . $value->pelaksanaan_ke . '_' . $value->nama_pelaksanaan. '___' . $value->id_vol_pelaksanaan_pekerjaan;
                }

                $this->sbe_array_insert($dok, $this->sbe_search_index("PELAKSANAAN", $dok), $list_pelaksanaan);
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
            endif;

            $output['dok'] = $dok;
            $output['rea'] = $rea;
            $output['cek'] = array_values(array_diff_assoc($dok, $rea));

            echo json_encode($output);
        }
    }

    public function upload_file()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'dokumen'   => [],
                'message'   => '',
                'cek'       => []
            ];

            $id_instansi            = $this->input->post('id_instansi');
            $id_kpa                 = $this->input->post('id_kpa');
            $id_pptk                = $this->input->post('id_pptk');
            $id_volume                = $this->input->post('id_volume');
            $id_paket_pekerjaan     = $this->input->post('id_paket_pekerjaan');
            $jenis_paket            = $this->input->post('jenis_paket');
            $dokumen                = $this->input->post('dokumen');
            $dokumen_key            = $this->input->post('dokumen_key');
            $id                     = $this->input->post('id');
            if ($id_volume==null) {
                $nama_file_disimpan = $dokumen;
            }else{
                $cek_pelaksanaan = $this->db->query("SELECT pelaksanaan_ke from vol_pelaksanaan_pekerjaan where id_vol_pelaksanaan_pekerjaan ='$id_volume'")->row()->pelaksanaan_ke ;
                $nama_file_disimpan = 'Pelaksanaan ke-'.$cek_pelaksanaan;
            }
            $fix_id_volume = str_replace("_", "", $id_volume);

            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $pecah = explode('.', $kode_rekening_sub_kegiatan );
            $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
            $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
            $kode_bu = $pecah[0].'.'.$pecah[1];


            
            $primary_folder         = './sbe_files_data/';
            $directory              = [
                tahun_anggaran(),
                id_instansi(),
                'REALISASI-FISIK',
                $id_paket_pekerjaan,
            ];
            $list_directory         = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }

            $config['upload_path']      = $list_directory;
            $config['overwrite']        = true;
            $config['allowed_types']    = 'pdf';
            $config['encrypt_name']     = false;
            $config['file_name']        = slug($nama_file_disimpan).'-'.date('Ymdhis');
            $config['max_size']         = '10000';
            $config['file_ext_tolower']         = true;


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($id)) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                $upload = ['upload_data' => $this->upload->data()];

                $primary = [
                    'id_instansi'               => $id_instansi,
                    'id_pptk'                   => $id_pptk,
                    'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                    'kode_rekening_sub_kegiatan'    => $kode_rekening_sub_kegiatan,
                    'dokumen'                   => $dokumen
                ];
                $simpan = [
                    'id_instansi'               => $id_instansi,
                    'id_pptk'                   => $id_pptk,
                    'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                    'id_vol_pelaksanaan_pekerjaan'        => $fix_id_volume,
                    'kode_rekening_sub_kegiatan'    => $kode_rekening_sub_kegiatan,
                    'kode_rekening_kegiatan'    => $kode_kegiatan,
                    'kode_rekening_program'    => $kode_program,
                    'kode_bidang_urusan'    => $kode_bu,
                    'bulan'                     => bulan_aktif(),
                    'tahun'                     => tahun_anggaran(),
                    'dokumen_key'               => $dokumen_key,
                    'dokumen'                   => $dokumen,
                    'file_dokumen'              => slug($nama_file_disimpan).'-'.date('Ymdhis').'.pdf', //$upload['upload_data']['file_name'],
                    'nilai'                     => 0,
                    'created_on'                => timestamp(),
                  //  'updated_on'                => timestamp(),
                    'created_by'                => $this->sbe_id_user(),
                    'updated_by'                => $this->sbe_id_user()
                ];
                $update = [
                    'updated_on' => timestamp(),
                    'updated_by' => $this->sbe_id_user()
                ];

                $cek = $this->db->get_where('realisasi_fisik', $primary)->num_rows();
                if ($cek > 0) {
                    $this->db->update('realisasi_fisik', $update, $primary);
                } else {
                    $this->db->insert('realisasi_fisik', $simpan);
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function dokumen_realisasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $realisasi_fisik = $this->realisasi_fisik_model;

            $output = [
                'status' => false,
                'data'   => []
            ];

            $id_instansi = id_instansi();
            $id_paket_pekerjaan = sbe_crypt($this->input->get('id_paket_pekerjaan'), 'D');
            $dokumen_realisasi  = $realisasi_fisik->dokumen_realisasi($id_paket_pekerjaan);
            $output['jumlah_evidence'] = $dokumen_realisasi->num_rows();
            $desc_paket  = $realisasi_fisik->total_nilai_realisasi($id_paket_pekerjaan);

            $primary_folder     = 'sbe_files_data/';
            $directory          = [
                tahun_anggaran(),
                $id_instansi,
                'REALISASI-FISIK',
                $id_paket_pekerjaan,
            ];
            $list_directory     = $this->sbe_directory($primary_folder, $directory);

            if ($dokumen_realisasi->num_rows()==0) {
                $output['caption'] = "<div class='alert alert-info'>Evidence belum di upload</div>";
            }else{
                foreach ($dokumen_realisasi->result() as $key => $value) {
                    $file_url = base_url().$list_directory . $value->file;
                    if (jadwal_rfk()['aktif']==0) {
                        $tombol_edit_evidence =    ' <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="upload ulang evidence" onclick="upload_berakhir()"><i class="metismenu-icon fas fa-file-signature"></i></a>';
                    }else{
                        $tombol_edit_evidence =    ' <a href="'.base_url('realisasi/evidence/'.sbe_crypt($value->id_realisasi_fisik)).'" class="btn btn-info btn-sm" data-toggle="tooltip" title="upload ulang evidence" target="_blank"><i class="metismenu-icon fas fa-file-signature"></i></a>';
                    }

                    $dokumen_evidence = $value->id_vol_pelaksanaan_pekerjaan=='' ? explode('_', $value->dokumen)[0] : explode('_', $value->dokumen)[0].' | '.$value->nama_pelaksanaan;

                    $nm_paket = str_replace('"', '', $desc_paket->nama_paket);

                    $tombol_lihat_evidence =    ' <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Evidence evidence" target="_blank" onclick="lihat_evidence('."'".$file_url."','".$nm_paket."','".$dokumen_evidence."'".')"><i class="metismenu-icon fas fa-folder-open"></i></button>';

                    $output['data'][$key]['dokumen'] = $dokumen_evidence;
                    $output['data'][$key]['file']    = $value->file;
                    $output['data'][$key]['status']    = $value->status;
                    $output['data'][$key]['nilai']   = $value->nilai;
                    $output['data'][$key]['option']   =  $tombol_edit_evidence.$tombol_lihat_evidence;
                    $output['status'] = true;
                }
                    $output['nilai'] = $desc_paket->total_nilai;
                    $output['id_paket_pekerjaan'] = $this->input->get('id_paket_pekerjaan');
            }

            $output['id_pptk'] = $desc_paket->id_pptk;
            $output['rekening'] = $desc_paket->kode_rekening_kegiatan;
            $output['nama_paket'] = $desc_paket->nama_paket;
            // header('Content-Type: application/json');
            echo json_encode($output);
        }
    }



    public function hapus_evidence()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $realisasi_fisik = $this->realisasi_fisik_model;

            $output = [
                'status' => false,
                'data'   => []
            ];

            $id_paket_pekerjaan = sbe_crypt($this->input->post('id_paket_pekerjaan'), 'D');




            $paket_pekerjaan    = $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
            $data               = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
            if ($paket_pekerjaan->num_rows() > 0) {
                $primary_folder         = './sbe_files_data/';
                $directory              = [
                    tahun_anggaran(),
                    id_instansi(),
                    'REALISASI-FISIK',
                    $id_paket_pekerjaan,
                ];
                $list_directory         = $this->sbe_directory($primary_folder, $directory);

                $this->sbe_delete_files($list_directory);
                $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
          

                $output['status']   = true;
                // $output['id_pptk']  = $data['id_pptk'];
                // $output['rekening'] = $data['kode_rekening_kegiatan'];
            }

 
            echo json_encode($output);
        }
    }
    public function evidence($id_realisasi_fisik)
    {
        if ($this->dokumen_evidence_model->cek_realisasi_fisik($id_realisasi_fisik)->num_rows() > 0) {

            $breadcrumbs            = $this->breadcrumbs;
            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
            $breadcrumbs->add('Update Dokumen Evidence', base_url());
            $breadcrumbs->render();

            $data['title']          = "Update Dokumen Evidence";
            $data['icon']           = "metismenu-icon fa fa-check-circle";
            $data['r_fisik']        = $this->dokumen_evidence_model->cek_realisasi_fisik($id_realisasi_fisik)->row();
            if ($data['r_fisik']->status=='Ditolak') {
               $description = "Update Dokumen Fisik yang ditolak";
            }else{
               $description = "Update Dokumen Fisik belum di validasi";
            }
            $data['description']    = $description;
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'realisasi/update_dokumen_evidence/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('realisasi/update_dokumen_evidence/css', $data, true);
            $data['extra_js']       = $this->load->view('realisasi/update_dokumen_evidence/js', $data, true);
            $data['modal']          = $this->load->view('realisasi/update_dokumen_evidence/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        } else {
            show_404();
        }
    }

    public function fix_evidence()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status' => false,
                'data'   => []
            ];

            $id                 = $this->input->post('id');
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $dokumen            = $this->input->post('dokumen');
            $pelaksanaan            = $this->input->post('pelaksanaan');
            $filelama            = $this->input->post('filelama');
            $inputnamadokumen = $dokumen . '-'.date('Ymdhis');
            $primary_folder     = './sbe_files_data/';
            $directory          = [
                tahun_anggaran(),
                id_instansi(),
                'REALISASI-FISIK',
                $id_paket_pekerjaan,
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya
            $namafiledisimpan = str_replace(" ", "_", $inputnamadokumen);

            if ($pelaksanaan=='') {
               $simpan_file_ok = $namafiledisimpan;
            }else{
               $simpan_file_ok = "PELAKSANAAN_".$pelaksanaan."_".date('Ymdhis');

            }

            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'pdf|zip';
            $config['encrypt_name']  = false;
            $config['file_name']     = $simpan_file_ok;
            $config['max_size']      = '10000';
            $config['file_ext_tolower']         = true;


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($id)) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                    $cekfilelama = $list_directory.$filelama;
                     if (file_exists($cekfilelama)) {
                       unlink($cekfilelama);
                    }
                $upload = ['upload_data' => $this->upload->data()];
   $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $this->dokumen_evidence_model->update_realisasi_fisik($simpan_file_ok.'.'.$file_ext);

                $output['status']   = true;
            }

            echo json_encode($output);
        }
    }

    public function keuangan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $keuangan       = $this->realisasi_keuangan_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Keuangan', base_url());
        $breadcrumbs->render();

        $data['title']       = "Realisasi Keuangan";
        $data['icon']        = "metismenu-icon fas fa-money-bill";
        $data['description'] = "Menampilkan Realisasi Keuangan";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $data['total']       = $this->data_realisasi(id_instansi())['total'];
        $data['persen_bo']   = $this->data_realisasi(id_instansi())['persen']['bo'];
        $data['persen_bm']  = $this->data_realisasi(id_instansi())['persen']['bm'];
        $data['persen_btt']   = $this->data_realisasi(id_instansi())['persen']['btt'];
        $data['persen_bt']   = $this->data_realisasi(id_instansi())['persen']['bt'];
        $data['persen_total']   = $this->data_realisasi(id_instansi())['persen']['total'];
        $data['keu_bo']      = $this->data_realisasi(id_instansi())['keu']['bo'];
        $data['keu_bm']     = $this->data_realisasi(id_instansi())['keu']['bm'];
        $data['keu_btt']      = $this->data_realisasi(id_instansi())['keu']['btt'];
        $data['keu_bt']      = $this->data_realisasi(id_instansi())['keu']['bt'];
        $data['keu_total']      = $this->data_realisasi(id_instansi())['keu']['total'];
        $data['total_anggaran']      = $this->data_realisasi(id_instansi())['anggaran'];
        $page                = 'realisasi/keuangan/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/keuangan/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/keuangan/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/keuangan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function fisik_keuangan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
        $id_kota = $this->session->userdata('id_kota');

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('fisik_keuangan', base_url());
        $breadcrumbs->render();

        $data['title']       = "Realisasi Fisik & Keuangan";
        $data['icon']        = "metismenu-icon fas fa-money-bill";
        $data['description'] = "Menampilkan Realisasi Fisik & Keuangan";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $data['total']       = $this->data_realisasi_kab_kota($id_kota)['total'];
        $data['persen_bo']   = $this->data_realisasi_kab_kota($id_kota)['persen']['bo'];
        $data['persen_bm']  = $this->data_realisasi_kab_kota($id_kota)['persen']['bm'];
        $data['persen_btt']   = $this->data_realisasi_kab_kota($id_kota)['persen']['btt'];
        $data['persen_bt']   = $this->data_realisasi_kab_kota($id_kota)['persen']['bt'];
        $data['persen_total']   = $this->data_realisasi_kab_kota($id_kota)['persen']['total'];
        $data['keu_bo']      = $this->data_realisasi_kab_kota($id_kota)['keu']['bo'];
        $data['keu_bm']     = $this->data_realisasi_kab_kota($id_kota)['keu']['bm'];
        $data['keu_btt']      = $this->data_realisasi_kab_kota($id_kota)['keu']['btt'];
        $data['keu_bt']      = $this->data_realisasi_kab_kota($id_kota)['keu']['bt'];
        $data['keu_total']      = $this->data_realisasi_kab_kota($id_kota)['keu']['total'];
        $data['total_anggaran']      = $this->data_realisasi_kab_kota($id_kota)['anggaran'];
        $page                = 'realisasi/fisik_keuangan/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/fisik_keuangan/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/fisik_keuangan/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/fisik_keuangan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function data_realisasi($id_instansi)
    {
        $keuangan   = $this->realisasi_keuangan_model;
        $output     = [
            'total'  => 0,
            'persen' => [],
            'keu'    => []
        ];
        $anggaran                = $keuangan->anggaran_apbd($id_instansi);
        $bo     = $keuangan->get_realisasi($id_instansi)->row()->realisasi_bo;
        $bm           = $keuangan->get_realisasi($id_instansi)->row()->realisasi_bm;
        $btt           = $keuangan->get_realisasi($id_instansi)->row()->realisasi_btt;
        $bt                   = $keuangan->get_realisasi($id_instansi)->row()->realisasi_btt;
        $total         = $keuangan->get_realisasi($id_instansi)->row()->total;

        $output['total']         = $total;
        $output['anggaran']         = $anggaran;
        @$output['persen']['bo']  = ROUND($bo =='' ? 0 : $bo / $anggaran * 100, 2);
        @$output['persen']['bm']  = ROUND($bm =='' ? 0 : $bm / $anggaran * 100, 2);
        @$output['persen']['btt'] = ROUND($btt =='' ? 0 : $btt / $anggaran * 100, 2);
        @$output['persen']['bt']  = ROUND($bt =='' ? 0 : $bt / $anggaran * 100, 2);
        @$output['persen']['total']  = ROUND($total =='' ? 0 : $total / $anggaran * 100, 2);

        $output['keu']['bo']     = $bo;
        $output['keu']['bm']    = $bm;
        $output['keu']['btt']    = $btt;
        $output['keu']['bt']     = $bt;
        $output['keu']['total']     = $total;
        // var_dump($total);
        return $output;
    }
    protected function data_realisasi_kab_kota($id_kota)
    {
        $keuangan   = $this->realisasi_keuangan_model;
        $dashboard       = $this->dashboard_model;
        $fisik_keuangan   = $this->realisasi_fisik_keuangan_model;
        $output     = [
            'total'  => 0,
            'persen' => [],
            'keu'    => []
        ];
        $tahap = tahapan_apbd();
        $tahun = tahun_anggaran();
        $pagu = $dashboard->pagu_kab_kota($id_kota,$tahap)->row();
        $pagu_total = $pagu->total == '' ? 0 : $pagu->total;
        $anggaran                = $pagu_total;//$fisik_keuangan->anggaran_kab_kota($id_kota);
        $bo     = $fisik_keuangan->get_realisasi($id_kota, $tahun, $tahap)->row()->realisasi_bo;
        $bm           = $fisik_keuangan->get_realisasi($id_kota, $tahun, $tahap)->row()->realisasi_bm;
        $btt           = $fisik_keuangan->get_realisasi($id_kota, $tahun, $tahap)->row()->realisasi_btt;
        $bt                   = $fisik_keuangan->get_realisasi($id_kota, $tahun, $tahap)->row()->realisasi_btt;
        $total         = $fisik_keuangan->get_realisasi($id_kota, $tahun, $tahap)->row()->total;

        $output['total']         = $total;
        $output['anggaran']         = $anggaran;
        @$output['persen']['bo']  = ROUND($bo =='' ? 0 : $bo / $anggaran * 100, 2);
        @$output['persen']['bm']  = ROUND($bm =='' ? 0 : $bm / $anggaran * 100, 2);
        @$output['persen']['btt'] = ROUND($btt =='' ? 0 : $btt / $anggaran * 100, 2);
        @$output['persen']['bt']  = ROUND($bt =='' ? 0 : $bt / $anggaran * 100, 2);
        @$output['persen']['total']  = ROUND($total =='' ? 0 : $total / $anggaran * 100, 2);

        $output['keu']['bo']     = $bo;
        $output['keu']['bm']    = $bm;
        $output['keu']['btt']    = $btt;
        $output['keu']['bt']     = $bt;
        $output['keu']['total']     = $total;

        return $output;
    }




    public function data_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {       
            $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
            $tahap = tahapan_apbd();
            $tahun_anggaran = tahun_anggaran();
                $id_kota = $this->session->userdata('id_kota') ;    
                $where          = ['kategori'=>'OPD', 'id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_instansi_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $bulan_aktif = bulan_aktif(); 
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
                $id_instansi  = $lists->id_instansi;
                $q_pagu = $this->db->query("SELECT pagu_bo,pagu_bm,pagu_btt,pagu_bt from v_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun_anggaran'");
                $d_pagu = $q_pagu->row();
                $j_pagu = $q_pagu->num_rows();
                $pagu_bo = $j_pagu == 0 ? 0 : $d_pagu->pagu_bo ;
                $pagu_bm = $j_pagu == 0 ? 0 : $d_pagu->pagu_bm ;
                $pagu_btt = $j_pagu == 0 ? 0 : $d_pagu->pagu_btt ;
                $pagu_bt = $j_pagu == 0 ? 0 : $d_pagu->pagu_bt ;
                $pagu_total = $pagu_bo + $pagu_bm + $pagu_btt + $pagu_bt;
               
                $q_direalisasikan = $this->db->query("SELECT * from realisasi_fisik_keuangan_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap'")->num_rows();
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;

                 $realisasi_dipilih = $fisik_keuangan->cek_realisasi_dipilih($tahap, $id_instansi)->row_array();

                $realisasi_bo = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];
                // fusuk
                $realisasi_bo_rf = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo_rf'];
                $realisasi_bm_rf = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm_rf'];
                $realisasi_btt_rf = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt_rf'];
                $realisasi_bt_rf = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt_rf'];

                $realisasi_rf_total = $fisik_keuangan->total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, 'realisasikan_fisik_total')->row_array()['realisasi_fisik_total'];
                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;
                // fisik
                $jumlah_realisasi_bo_rf = $realisasi_bo_rf =='' ? 0 : $realisasi_bo_rf;
                $jumlah_realisasi_bm_rf = $realisasi_bm_rf =='' ? 0 : $realisasi_bm_rf;
                $jumlah_realisasi_btt_rf = $realisasi_btt_rf =='' ? 0 : $realisasi_btt_rf;
                $jumlah_realisasi_bt_rf = $realisasi_bt_rf =='' ? 0 : $realisasi_bt_rf;

                $jumlah_realisasi_rf_total = $realisasi_rf_total =='' ? 0 : $realisasi_rf_total;




                $set_realisasi_bo = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bo','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($jumlah_realisasi_bo).'</button> ';
                $set_realisasi_bm = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bm','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($jumlah_realisasi_bm).'</button> ';
                $set_realisasi_btt = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'btt','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($jumlah_realisasi_btt).'</button> ';
                $set_realisasi_bt = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bt','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($jumlah_realisasi_bt).'</button> ';

                 $set_realisasi_bo_rf = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bo','".$lists->id_instansi."','".$pagu_total."'".')">'.$jumlah_realisasi_bo_rf.'</button> ';
                 $set_realisasi_bm_rf = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bm','".$lists->id_instansi."','".$pagu_total."'".')">'.$jumlah_realisasi_bm_rf.'</button> ';
                 $set_realisasi_btt_rf = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'btt','".$lists->id_instansi."','".$pagu_total."'".')">'.$jumlah_realisasi_btt_rf.'</button> ';
                 $set_realisasi_bt_rf = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'bt','".$lists->id_instansi."','".$pagu_total."'".')">'.$jumlah_realisasi_bt_rf.'</button> ';

                 $set_realisasi_rf_total = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'fisik','".$lists->id_instansi."','".$pagu_total."'".')">'.$jumlah_realisasi_rf_total.'</button> ';

               
               $nilai_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? 0 : $jumlah_realisasi_bo;
               $nilai_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? 0 : $jumlah_realisasi_bm;
               $nilai_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? 0 : $jumlah_realisasi_btt;
               $nilai_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? 0 : $jumlah_realisasi_bt;

               $nilai_rk_instansi_total = $nilai_rk_instansi_bo +$nilai_rk_instansi_bm +$nilai_rk_instansi_btt +$nilai_rk_instansi_bt ;
               $nilai_rf_instansi_total = $jumlah_realisasi_bo_rf + $jumlah_realisasi_bm_rf + $jumlah_realisasi_btt_rf + $jumlah_realisasi_bt_rf;
               $pembagi_nilai_rf_total = $realisasi_dipilih['realisasikan_bo'] + $realisasi_dipilih['realisasikan_bm'] + $realisasi_dipilih['realisasikan_btt'] + $realisasi_dipilih['realisasikan_bt'];
               @$show_nilai_rf_instansi_total = $nilai_rf_instansi_total / $pembagi_nilai_rf_total ;
               $show_nilai_rf_instansi_total = $show_nilai_rf_instansi_total == INF ? 0 : $show_nilai_rf_instansi_total;



               @$persen_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : ($nilai_rk_instansi_bo / $pagu_bo ) * 100; 
               @$persen_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : ($nilai_rk_instansi_bm / $pagu_bm ) * 100; 
               @$persen_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : ($nilai_rk_instansi_btt / $pagu_btt ) * 100; 
               @$persen_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : ($nilai_rk_instansi_bt / $pagu_bt ) * 100; 
               @$persen_rk_instansi_total  = ($nilai_rk_instansi_total / $pagu_total) * 100; 



               $tampil_nilai_rk_instansi_bo  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $set_realisasi_bo;
               $tampil_nilai_rk_instansi_bm  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $set_realisasi_bm;
               $tampil_nilai_rk_instansi_btt  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $set_realisasi_btt;
               $tampil_nilai_rk_instansi_bt  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $set_realisasi_bt;
                // fisik
               $tampil_nilai_rk_instansi_bo_rf  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $set_realisasi_bo_rf;

               $tampil_nilai_rk_instansi_bm_rf  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $set_realisasi_bm_rf;
               $tampil_nilai_rk_instansi_btt_rf  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $set_realisasi_btt_rf;

               $tampil_nilai_rk_instansi_total  =   $set_realisasi_rf_total;


               $lra =  $fisik_keuangan->total_lra($bulan_aktif, $tahap, $id_instansi)->row_array()['total_lra'];
               
               //  // $row[]  = number_format($total_realisasi);
               
                // $row[]  = $tampil_nilai_rk_instansi_bo_rf;
                $row[]  = $tampil_nilai_rk_instansi_bo;
                $row[]  = $realisasi_dipilih['realisasikan_bo']==0 ? '-' : ( $pagu_bo > 0 ? round($persen_rk_instansi_bo,2) : 0);
                // $row[]  = $tampil_nilai_rk_instansi_bm_rf;
                $row[]  = $tampil_nilai_rk_instansi_bm;
                $row[]  = $realisasi_dipilih['realisasikan_bm']==0 ? '-' :  ( $pagu_bo > 0 ? round($persen_rk_instansi_bm,2) : 0 );
                // $row[]  = $tampil_nilai_rk_instansi_btt_rf;
                $row[]  = $tampil_nilai_rk_instansi_btt;
                $row[]  = $realisasi_dipilih['realisasikan_btt']==0 ? '-' :  ( $pagu_bo > 0 ? round($persen_rk_instansi_btt,2) : 0 );
                // $row[]  = $tampil_nilai_rk_instansi_bt_rf;

                $row[]  = $tampil_nilai_rk_instansi_bt;
                $row[]  = $realisasi_dipilih['realisasikan_bt']==0 ? '-' :  ( $pagu_bo > 0 ? round($persen_rk_instansi_bt,2) : 0 );

                $set_realisasi_semua = '<button type="button" class="tombol" title="Input Realisasi Sub  Kegiatan '.$lists->nama_instansi.'"  onclick="input_realisasi('."'semua','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($nilai_rk_instansi_total).'</button> ';

                $row[]  = $set_realisasi_semua;
                $row[]  = $pagu_total > 0 ? ($persen_rk_instansi_total >0 ? round($persen_rk_instansi_total,2) : 0) : 0;
                $row[]  = $tampil_nilai_rk_instansi_total ;//how_nilai_rf_instansi_total > 0 ? round($show_nilai_rf_instansi_total,2) : 0 ;


                $tombol_copy = ' <button class="btn btn-outline-info btn-xs"  title="Copy Realisasi Fisik & Keuangan  APBD AWAL Instansi '.$lists->nama_instansi.'"  onclick="copy_realisasi_apbd_awal_kab_kota('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.', '."'".$lists->nama_instansi."'".')"><i class="fas fa-copy"></i></button>';
                $tombol_hapus = ' <button class="btn btn-danger btn-xs"  title="Hapus Realisasi '.nama_tahapan($tahap).' Instansi '.$lists->nama_instansi.'"  onclick="hapus_rfk_kab_kota('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.', '."'".$lists->nama_instansi."','".$tahap."'".')"><i class="fas fa-trash"></i></button>';


                 $set_lra = '<button type="button" class="tombol" title="Input LRA '.$lists->nama_instansi.'"  onclick="input_lra('."'lra','".$lists->id_instansi."','".$pagu_total."'".')">'.number_format($lra == '' ? 0 : $lra ).'</button> ';
                 @$persen_lra = $lra / $pagu_total * 100;

                $row[]  = $set_lra;
                $row[]  = round($persen_lra,2);
                $row[]  = $pagu_total > 0 && $q_direalisasikan == 0 ? $tombol_copy : $tombol_hapus;
              
               
            

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('master_instansi_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('master_instansi_kab_kota', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }



    public function sub_kegiatan_apbd_instansi_gabungan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $keuangan       = $this->realisasi_keuangan_model;
            $tahun = tahun_anggaran();
            $tahap = tahapan_apbd();
            if ($tahap==4) {
                $where          = ['status'=>1, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
                # code...
            }else{
                $where          = ['kode_tahap'=>$tahap, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            }    

            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['kode_rekening_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $id_instansi = id_instansi();
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $pagu_total = $lists->pagu=='' ? 0 : $lists->pagu;
                $kategori = $lists->kategori;
                $upel = $lists->kategori == 'Unit Pelaksana' ? '<br>'.$lists->jenis_sub_kegiatan .' - '.$lists->keterangan : '';
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $row[]  = '<b>'.pilihan_nama_tahapan($lists->kode_tahap).'</b>';
                $kode_tahap_kegiatan = $lists->kode_tahap;
                $row[]  = '<b>'.$krsk.'</b><br>'.$lists->nama_sub_kegiatan.$upel;
                $kode_tahap = $lists->kode_tahap;

                $realisasi_dipilih = $keuangan->cek_realisasi_dipilih($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi)->row_array();






                $realisasi_bo = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];


                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;





                $set_realisasi_bo = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bo','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."','".$lists->kode_tahap."','".$lists->tahun."'".')">'.number_format($jumlah_realisasi_bo).'</button> ';
                $set_realisasi_bm = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bm','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."','".$lists->kode_tahap."','".$lists->tahun."'".')">'.number_format($jumlah_realisasi_bm).'</button> ';
                $set_realisasi_btt = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'btt','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."','".$lists->kode_tahap."','".$lists->tahun."'".')">'.number_format($jumlah_realisasi_btt).'</button> ';
                $set_realisasi_bt = '<button type="button" class="tombol" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bt','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."','".$lists->kode_tahap."','".$lists->tahun."'".')">'.number_format($jumlah_realisasi_bt).'</button> ';

                $total_realisasi = $keuangan->total_realisasi($lists->kode_rekening_sub_kegiatan,$kode_tahap_kegiatan, $id_instansi)->row_array()['total_realisasi'] ;
                @$persentasi = ( $total_realisasi =='' ? 0 : $total_realisasi / $lists->pagu) * 100;


                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
                $nama_sub_kegiatan = $lists->nama_sub_kegiatan . str_replace('<br>', ' \n ', $keterangan) ;
                 $onclick_copy = "copy_realisasi_k_sub_kegiatan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$lists->kode_rekening_sub_kegiatan."')";
                 


               $tombolcopy = '<button class="btn btn-outline-info btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick_copy.'"><i class="fas fa-copy"></i></button> ';


               $onclick_hapus  = "hapus_realisasi_k_sub_kegiatan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$nama_sub_kegiatan."','semua')";
               $tombol_hapus = '<button class="btn btn-danger btn-xs"  title="Hapus realisasi keuangan sub kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick_hapus.'"><i class="fas fa-trash"></i></button> ';


                $krsk = $lists->kode_rekening_sub_kegiatan;
                $cek_count_data_realisasi = $this->db->query("SELECT id_realisasi_keuangan from realisasi_keuangan where id_instansi='$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$krsk' and tahun='$tahun'")->num_rows();
                if ($kode_tahap!=2 && $total_realisasi==0 && $cek_count_data_realisasi==0 && $lists->pagu >0) {
                $tombol = $tombolcopy;
                }else{
                $show_tombol_hapus = $pagu_total > 0 ? $tombol_hapus: '';
                $tombol = $show_tombol_hapus;
                }

                // $hapus_data = $tombol_hapus;





                $row[]  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $set_realisasi_bo;
                $row[]  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $set_realisasi_bm;
                $row[]  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $set_realisasi_btt;
                $row[]  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $set_realisasi_bt;
               
                $row[]  = number_format($total_realisasi);
                $row[]  = $lists->pagu=='' ? 0 : number_format($lists->pagu);
                $row[]  = $pagu_total > 0 ? round($persentasi,2).' %' : '0 %';
                $row[]     =  $tombol;


                $row[]  = '';
              
      

               $onclick3 = "get_realisasi('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->pagu."')";

               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }






    public function sub_kegiatan_apbd_instansi_r_fisik()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahap = tahapan_apbd();
            $tahun = tahun_anggaran();
            $id_instansi = id_instansi();

            $master_paket     = $this->master_paket_model;
            if ($tahap==4) {
                $where          = ['status'=>1, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
                # code...
            }else{
                $where          = ['kode_tahap'=>$tahap, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            }
           
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $kode_tahap = $lists->kode_tahap;
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $kategori = $lists->kategori;
                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
                // upel = unit pelaksana
            
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $kegiatan  = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_rekening_kegiatan'")->row();
                $program  = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_rekening_program'")->row();

                 $nama_sub_kegiatan ='<b>'.$kode_sub_kegiatan .'</b><br>'.$lists->nama_sub_kegiatan. $keterangan;
                $row    = [];
                $row[]     = $no;
                $jumlah_paket = $this->db->query("SELECT id_paket_pekerjaan from paket_pekerjaan where 
                        id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$krsk' and tahun='$tahun'
                        ")->num_rows();
                $pptk = $master_paket->pptk_sub_kegiatan($krsk, $lists->kode_tahap)->row_array();


                // $cek_permasalahan = $this->db->query("SELECT id_permasalahan_sub_kegiatan from permasalahan_sub_kegiatan where id_instansi='$id_instansi' and kode_sub_kegiatan='$krsk' and tahun = '$tahun' and kode_tahap='$kode_tahap'")->num_rows();


                // if ($cek_permasalahan==0) {
	               //  $nm_sk = str_replace('"', '', $lists->nama_sub_kegiatan. $keterangan);
                //     $tombol_buka_paket = '<button type="button" onclick="alert_isi_permasalahan('. "'".$nm_sk."','".$krsk."','".$kode_tahap."','".$tahun."'" .')" class="btn btn-danger btn-xs">+</button>';
                // }else{
                // }
                    $tombol_buka_paket = '<button id="list-paket" status="collapse" id-pptk="'."???".'" kode-sub-kegiatan="'.$lists->kode_rekening_sub_kegiatan.'" kode-kegiatan="'.$lists->kode_rekening_kegiatan.'" kode-program="'.$lists->kode_rekening_program.'" kode-bidang-urusan="'.$lists->kode_bidang_urusan.'" class="btn btn-info btn-xs">+</button>';
                $row[]  = $tombol_buka_paket; 
                $row[]  = pilihan_nama_tahapan($lists->kode_tahap); 
                $row[]  = $nama_sub_kegiatan ; 
               
                 $pagu   = $lists->pagu =='' ? 0 : $lists->pagu;
                $row[]  =  '<span style="float:right">'.number_format($pagu,0,'','.').'</span>';
                $row[]  = $pptk['full_name'];
                $row[]  = $jumlah_paket;

               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];
            // header('Content-Type: application/json');
            echo json_encode($output);
        }
    }






 public function get_realisasi_keuangan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $keuangan       = $this->realisasi_keuangan_model;

            // $kode_rekening_sub_kegiatan = '1.01.03.1.01.02';
            // $kode_kegiatan = '1.01.03.1.01';
            // $kode_program = '1.01.03';
            // $kode_bidang_urusan = '1.01';
            // $jenis_realisasi = 'bo';
            $pagu = $this->input->post('pagu');
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $jenis_realisasi = $this->input->post('jenis');
            $kategori = $this->input->post('kategori');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = id_instansi();
            $bulan_aktif = bulan_aktif();

            $pecah = explode('.', $kode_rekening_sub_kegiatan);
            if ($kategori == "Unit Pelaksana") {
            	$krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            }else{
            	$krsk = $kode_rekening_sub_kegiatan;
            }


            $whereask = [
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan ,
                'kode_kegiatan' => $kode_kegiatan ,
                'kode_program' => $kode_program ,
                'kode_bidang_urusan' => $kode_bidang_urusan ,
                'id_instansi' => $id_instansi ,
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
            ];
            $target                 = $this->db->query("SELECT id_target_apbd ,bulan from target_apbd
                where 
                kode_bidang_urusan ='$kode_bidang_urusan' and 
                kode_rekening_program ='$kode_program' and 
                kode_rekening_kegiatan ='$kode_kegiatan' and 
                kode_rekening_sub_kegiatan ='$kode_rekening_sub_kegiatan' and 
                kode_tahap ='$tahap' and 
                tahun ='$tahun' and 
                id_instansi ='$id_instansi' and 
                bulan<='$bulan_aktif' ");

            $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan from master_sub_kegiatan where kode_sub_kegiatan='$krsk'")->row()->nama_sub_kegiatan;

            $upel = $this->db->query("SELECT ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan,
            	total_anggaran_sub_kegiatan(ski.kode_sub_kegiatan,ski.kode_tahap,ski.id_instansi,ski.kode_kegiatan,ski.kode_program,ski.tahun) as pagu_sub_kegiatan 
             from sub_kegiatan_instansi ski where ski.kode_sub_kegiatan='$kode_rekening_sub_kegiatan' and ski.id_instansi='$id_instansi' and ski.kategori='$kategori' and ski.kode_tahap='$tahap'")->row();
            $output['totaldata']  = $target->num_rows();
            $output['nama_sub_kegiatan']  = $kategori == "Sub Kegiatan SKPD" ? $subkeg : $subkeg.'<br>'.$upel->jenis_sub_kegiatan .' - '. $upel->keterangan ;
            $output['nama_tahapan']  = pilihan_nama_tahapan($tahap);
            if ($target->num_rows() > 0) {
                foreach ($target->result()  as $key => $value) {
                    $bulan = $value->bulan;
                    $where = "
                    
                kode_sub_kegiatan='$kode_rekening_sub_kegiatan'  and
                kode_tahap='$tahap' and
                tahun='$tahun' and
                id_instansi='$id_instansi' and
                bulan = '$bulan'
                    ";
                    $realisasi = $keuangan->realisasi($where, $jenis_realisasi)->row_array();
                    $anggaran = $this->db->query("SELECT 
                         bo_bp, bo_bbj, bo_bs, bo_bh, bm_bmt, bm_bmpm, bm_bmgb, bm_bmjji, bm_bmatl, btt, bt_bbh, bt_bbk 
                     from anggaran_sub_kegiatan
                        where
                        kode_sub_kegiatan = '$kode_rekening_sub_kegiatan' and 
                        kode_kegiatan = '$kode_kegiatan' and 
                        kode_program = '$kode_program' and 
                        kode_bidang_urusan = '$kode_bidang_urusan' and 
                        id_instansi = '$id_instansi' and 
                        kode_tahap  = '$tahap' and tahun='$tahun' 
                        ");
                    $pagu = $anggaran->row_array();

                    $cek_data  =$this->db->query("SELECT 
                         id_realisasi_keuangan   
                     from realisasi_keuangan   
                        where
                      
                        kode_sub_kegiatan='$kode_rekening_sub_kegiatan'  and
                        kode_tahap='$tahap' and
                        tahun='$tahun' and
                        id_instansi='$id_instansi' and
                        bulan = '$bulan'
                ")->num_rows();

                    $warna_data = $cek_data > 1 ? 'style="background:#ffe2e2"' : '';
                    $output['data'][$key]['warna']      = $warna_data ;



                    $output['data'][$key]['id_target']         = sbe_crypt($value->id_target_apbd, 'E');
                    $output['data'][$key]['id_realisasi']         = sbe_crypt($realisasi['id_realisasi_keuangan']=='' ? '' : $realisasi['id_realisasi_keuangan'] , 'E');
                    $output['data'][$key]['bulan']      = $bulan;
                    if ($jenis_realisasi=='bo') {
                        $output['data'][$key]['bo_bp']      = $realisasi['bo_bp']=='' ? 0 : $realisasi['bo_bp'];
                        $output['data'][$key]['bo_bbj']      = $realisasi['bo_bbj']=='' ? 0 : $realisasi['bo_bbj'];
                        $output['data'][$key]['bo_bs']      = $realisasi['bo_bs']=='' ? 0 : $realisasi['bo_bs'];
                        $output['data'][$key]['bo_bh']      = $realisasi['bo_bh']=='' ? 0 : $realisasi['bo_bh'];

                        $output['data'][$key]['pagu_bo_bp']      = $pagu['bo_bp']=='' ? 0 : $pagu['bo_bp'];
                        $output['data'][$key]['pagu_bo_bbj']      = $pagu['bo_bbj']=='' ? 0 : $pagu['bo_bbj'];
                        $output['data'][$key]['pagu_bo_bs']      = $pagu['bo_bs']=='' ? 0 : $pagu['bo_bs'];
                        $output['data'][$key]['pagu_bo_bh']      = $pagu['bo_bh']=='' ? 0 : $pagu['bo_bh'];
                    }
                    else if ($jenis_realisasi=='bm') {
                        $output['data'][$key]['bm_bmt']      = $realisasi['bm_bmt']=='' ? 0 : $realisasi['bm_bmt'];
                        $output['data'][$key]['bm_bmpm']      = $realisasi['bm_bmpm']=='' ? 0 : $realisasi['bm_bmpm'];
                        $output['data'][$key]['bm_bmgb']      = $realisasi['bm_bmgb']=='' ? 0 : $realisasi['bm_bmgb'];
                        $output['data'][$key]['bm_bmjji']      = $realisasi['bm_bmjji']=='' ? 0 : $realisasi['bm_bmjji'];
                        $output['data'][$key]['bm_bmatl']      = $realisasi['bm_bmatl']=='' ? 0 : $realisasi['bm_bmatl'];

                        $output['data'][$key]['pagu_bm_bmt']      = $pagu['bm_bmt']=='' ? 0 : $pagu['bm_bmt'];
                        $output['data'][$key]['pagu_bm_bmpm']      = $pagu['bm_bmpm']=='' ? 0 : $pagu['bm_bmpm'];
                        $output['data'][$key]['pagu_bm_bmgb']      = $pagu['bm_bmgb']=='' ? 0 : $pagu['bm_bmgb'];
                        $output['data'][$key]['pagu_bm_bmjji']      = $pagu['bm_bmjji']=='' ? 0 : $pagu['bm_bmjji'];
                        $output['data'][$key]['pagu_bm_bmatl']      = $pagu['bm_bmatl']=='' ? 0 : $pagu['bm_bmatl'];
                    }
                    else if ($jenis_realisasi=='btt') {
                        $output['data'][$key]['btt']      = $realisasi['btt']=='' ? 0 : $realisasi['btt'];

                        $output['data'][$key]['pagu_btt']      = $pagu['btt']=='' ? 0 : $pagu['btt'];
                    }
                    else if ($jenis_realisasi=='bt') {
                        $output['data'][$key]['bt_bbh']      = $realisasi['bt_bbh']=='' ? 0 : $realisasi['bt_bbh'];
                        $output['data'][$key]['bt_bbk']      = $realisasi['bt_bbk']=='' ? 0 : $realisasi['bt_bbk'];

                        $output['data'][$key]['pagu_bt_bbh']      = $pagu['bt_bbh']=='' ? 0 : $pagu['bt_bbh'];
                        $output['data'][$key]['pagu_bt_bbk']      = $pagu['bt_bbk']=='' ? 0 : $pagu['bt_bbk'];
                    }
                }

                $output['status']  = true;
            } else {
                $output['status']  = false;
                
            }

            echo json_encode($output);
        }
    }



 public function get_realisasi_keuangan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;

            // $kode_rekening_sub_kegiatan = '1.01.03.1.01.02';
            // $kode_kegiatan = '1.01.03.1.01';
            // $kode_program = '1.01.03';
            // $kode_bidang_urusan = '1.01';
            // $jenis_realisasi = 'bo';

            $jenis_realisasi =  $this->input->post('jenis');
            $id_instansi = $this->input->post('id_instansi');
            $nama_tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];

        

         
          
          
            $bulan_aktif_realisasi = bulan_aktif();//config_kab_kota()->bulan_aktif;
            $tahap = tahapan_apbd();// config_kab_kota()->tahapan_apbd;
            $output['nama_tahapan']  = $nama_tahap[$tahap];
            $bulan_aktif = bulan_aktif();
            $tahun_anggaran = tahun_anggaran();
                for($i=1; $i<=$bulan_aktif_realisasi; $i++) {
                    $bulan = $i;
                    $key = $i-1;
                    $where = "

                kode_tahap='$tahap' and
                id_instansi='$id_instansi' and
                bulan = '$bulan' and
                tahun = '$tahun_anggaran'
                    ";
                    $realisasi = $fisik_keuangan->realisasi($where, $jenis_realisasi)->row_array();
                    $realisasi_lra = $fisik_keuangan->realisasi_lra($where, $jenis_realisasi)->row_array();
                    $anggaran = $this->db->query("SELECT 
                         bo_bp, bo_bbj, bo_bs, bo_bh, bo_bbs, bm_bmt, bm_bmpm, bm_bmgb, bm_bmjji, bm_bmatb, bm_bmatl, btt, bt_bbh, bt_bbk 
                     from anggaran_instansi_kab_kota
                        where
                        id_instansi = '$id_instansi' and 
                        kode_tahap  = '$tahap' and tahun='$tahun_anggaran'
                        ");
                    $pagu = $anggaran->row_array();




                    $output['data'][$key]['id_realisasi']         = sbe_crypt($realisasi['id_realisasi_fisik_keuangan_kab_kota']=='' ? '' : $realisasi['id_realisasi_fisik_keuangan_kab_kota'] , 'E');
                    $output['data'][$key]['bulan']      = $bulan;
                    if ($jenis_realisasi=='bo') {
                        $output['data'][$key]['bo_bp']      = $realisasi['bo_bp']=='' ? 0 : $realisasi['bo_bp'];
                        $output['data'][$key]['bo_bbj']      = $realisasi['bo_bbj']=='' ? 0 : $realisasi['bo_bbj'];
                        $output['data'][$key]['bo_bs']      = $realisasi['bo_bs']=='' ? 0 : $realisasi['bo_bs'];
                        $output['data'][$key]['bo_bh']      = $realisasi['bo_bh']=='' ? 0 : $realisasi['bo_bh'];
                        $output['data'][$key]['bo_rf']      = $realisasi['bo_rf']=='' ? 0 : $realisasi['bo_rf'];
                        $output['data'][$key]['bo_bbs']      = $realisasi['bo_bbs']=='' ? 0 : $realisasi['bo_bbs'];

                        $output['data'][$key]['pagu_bo_bp']      = $pagu['bo_bp']=='' ? 0 : $pagu['bo_bp'];
                        $output['data'][$key]['pagu_bo_bbj']      = $pagu['bo_bbj']=='' ? 0 : $pagu['bo_bbj'];
                        $output['data'][$key]['pagu_bo_bs']      = $pagu['bo_bs']=='' ? 0 : $pagu['bo_bs'];
                        $output['data'][$key]['pagu_bo_bh']      = $pagu['bo_bh']=='' ? 0 : $pagu['bo_bh'];
                        $output['data'][$key]['pagu_bo_bbs']      = $pagu['bo_bbs']=='' ? 0 : $pagu['bo_bbs'];
                    }
                    else if ($jenis_realisasi=='bm') {
                        $output['data'][$key]['bm_bmt']      = $realisasi['bm_bmt']=='' ? 0 : $realisasi['bm_bmt'];
                        $output['data'][$key]['bm_bmpm']      = $realisasi['bm_bmpm']=='' ? 0 : $realisasi['bm_bmpm'];
                        $output['data'][$key]['bm_bmgb']      = $realisasi['bm_bmgb']=='' ? 0 : $realisasi['bm_bmgb'];
                        $output['data'][$key]['bm_bmjji']      = $realisasi['bm_bmjji']=='' ? 0 : $realisasi['bm_bmjji'];
                        $output['data'][$key]['bm_bmatl']      = $realisasi['bm_bmatl']=='' ? 0 : $realisasi['bm_bmatl'];
                        $output['data'][$key]['bm_bmatb']      = $realisasi['bm_bmatb']=='' ? 0 : $realisasi['bm_bmatb'];
                        $output['data'][$key]['bm_rf']      = $realisasi['bm_rf']=='' ? 0 : $realisasi['bm_rf'];

                        $output['data'][$key]['pagu_bm_bmt']      = $pagu['bm_bmt']=='' ? 0 : $pagu['bm_bmt'];
                        $output['data'][$key]['pagu_bm_bmpm']      = $pagu['bm_bmpm']=='' ? 0 : $pagu['bm_bmpm'];
                        $output['data'][$key]['pagu_bm_bmgb']      = $pagu['bm_bmgb']=='' ? 0 : $pagu['bm_bmgb'];
                        $output['data'][$key]['pagu_bm_bmjji']      = $pagu['bm_bmjji']=='' ? 0 : $pagu['bm_bmjji'];
                        $output['data'][$key]['pagu_bm_bmatl']      = $pagu['bm_bmatl']=='' ? 0 : $pagu['bm_bmatl'];
                        $output['data'][$key]['pagu_bm_bmatb']      = $pagu['bm_bmatb']=='' ? 0 : $pagu['bm_bmatb'];
                    }
                    else if ($jenis_realisasi=='btt') {
                        $output['data'][$key]['btt']      = $realisasi['btt']=='' ? 0 : $realisasi['btt'];
                        $output['data'][$key]['btt_rf']      = $realisasi['btt_rf']=='' ? 0 : $realisasi['btt_rf'];

                        $output['data'][$key]['pagu_btt']      = $pagu['btt']=='' ? 0 : $pagu['btt'];
                    }
                    else if ($jenis_realisasi=='bt') {
                        $output['data'][$key]['bt_bbh']      = $realisasi['bt_bbh']=='' ? 0 : $realisasi['bt_bbh'];
                        $output['data'][$key]['bt_bbk']      = $realisasi['bt_bbk']=='' ? 0 : $realisasi['bt_bbk'];
                        $output['data'][$key]['bt_rf']      = $realisasi['bt_rf']=='' ? 0 : $realisasi['bt_rf'];

                        $output['data'][$key]['pagu_bt_bbh']      = $pagu['bt_bbh']=='' ? 0 : $pagu['bt_bbh'];
                        $output['data'][$key]['pagu_bt_bbk']      = $pagu['bt_bbk']=='' ? 0 : $pagu['bt_bbk'];
                    }
                    else  {
                        $output['data'][$key]['bo_bp']      = $realisasi['bo_bp']=='' ? 0 : $realisasi['bo_bp'];
                        $output['data'][$key]['bo_bbj']      = $realisasi['bo_bbj']=='' ? 0 : $realisasi['bo_bbj'];
                        $output['data'][$key]['bo_bs']      = $realisasi['bo_bs']=='' ? 0 : $realisasi['bo_bs'];
                        $output['data'][$key]['bo_bh']      = $realisasi['bo_bh']=='' ? 0 : $realisasi['bo_bh'];
                        $output['data'][$key]['bo_bbs']      = $realisasi['bo_bbs']=='' ? 0 : $realisasi['bo_bbs'];
                        $output['data'][$key]['bm_bmt']      = $realisasi['bm_bmt']=='' ? 0 : $realisasi['bm_bmt'];
                        $output['data'][$key]['bm_bmpm']      = $realisasi['bm_bmpm']=='' ? 0 : $realisasi['bm_bmpm'];
                        $output['data'][$key]['bm_bmgb']      = $realisasi['bm_bmgb']=='' ? 0 : $realisasi['bm_bmgb'];
                        $output['data'][$key]['bm_bmjji']      = $realisasi['bm_bmjji']=='' ? 0 : $realisasi['bm_bmjji'];
                        $output['data'][$key]['bm_bmatl']      = $realisasi['bm_bmatl']=='' ? 0 : $realisasi['bm_bmatl'];
                        $output['data'][$key]['bm_bmatb']      = $realisasi['bm_bmatb']=='' ? 0 : $realisasi['bm_bmatb'];
                        $output['data'][$key]['btt']      = $realisasi['btt']=='' ? 0 : $realisasi['btt'];
                        $output['data'][$key]['bt_bbh']      = $realisasi['bt_bbh']=='' ? 0 : $realisasi['bt_bbh'];
                        $output['data'][$key]['bt_bbk']      = $realisasi['bt_bbk']=='' ? 0 : $realisasi['bt_bbk'];




                        $output['data'][$key]['pagu_bo_bp']      = $pagu['bo_bp']=='' ? 0 : $pagu['bo_bp'];
                        $output['data'][$key]['pagu_bo_bbj']      = $pagu['bo_bbj']=='' ? 0 : $pagu['bo_bbj'];
                        $output['data'][$key]['pagu_bo_bs']      = $pagu['bo_bs']=='' ? 0 : $pagu['bo_bs'];
                        $output['data'][$key]['pagu_bo_bh']      = $pagu['bo_bh']=='' ? 0 : $pagu['bo_bh'];
                        $output['data'][$key]['pagu_bo_bbs']      = $pagu['bo_bbs']=='' ? 0 : $pagu['bo_bbs'];
                        $output['data'][$key]['pagu_bm_bmt']      = $pagu['bm_bmt']=='' ? 0 : $pagu['bm_bmt'];
                        $output['data'][$key]['pagu_bm_bmpm']      = $pagu['bm_bmpm']=='' ? 0 : $pagu['bm_bmpm'];
                        $output['data'][$key]['pagu_bm_bmgb']      = $pagu['bm_bmgb']=='' ? 0 : $pagu['bm_bmgb'];
                        $output['data'][$key]['pagu_bm_bmjji']      = $pagu['bm_bmjji']=='' ? 0 : $pagu['bm_bmjji'];
                        $output['data'][$key]['pagu_bm_bmatl']      = $pagu['bm_bmatl']=='' ? 0 : $pagu['bm_bmatl'];
                        $output['data'][$key]['pagu_bm_bmatb']      = $pagu['bm_bmatb']=='' ? 0 : $pagu['bm_bmatb'];
                        $output['data'][$key]['pagu_btt']      = $pagu['btt']=='' ? 0 : $pagu['btt'];
                        $output['data'][$key]['pagu_bt_bbh']      = $pagu['bt_bbh']=='' ? 0 : $pagu['bt_bbh'];
                        $output['data'][$key]['pagu_bt_bbk']      = $pagu['bt_bbk']=='' ? 0 : $pagu['bt_bbk'];
                    }
                        $output['data'][$key]['rf_total']      = $realisasi['rf_total']=='' ? 0 : $realisasi['rf_total'];

                        $output['data'][$key]['lra']      = $realisasi_lra['lra']=='' ? 0 : $realisasi_lra['lra'];
                        $output['data'][$key]['id_realisasi_lra']         = sbe_crypt($realisasi_lra['id_lra_kab_kota']=='' ? '' : $realisasi_lra['id_lra_kab_kota'] , 'E');
                }

                $output['status']  = true;
                $output['id_instansi']  = $id_instansi;
           
            echo json_encode($output);
        }
    }



 public function copy_realisasi_apbd_awal_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'messages'    => '',
                'data'      => []
            ];
            $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;

            $tahap =  $this->input->post('tahap');
            $skpd =  $this->input->post('skpd');
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $nama_tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];

            $where = ['id_instansi'=>$id_instansi, 'kode_tahap'=>'2'];
            $this->db->order_by('bulan', 'ASC');
            $q_realisasi = $this->db->get_where('realisasi_fisik_keuangan_kab_kota', $where);

            $kumpul_realisasi  =[];

            if ($q_realisasi->num_rows()>0) {
                foreach ($q_realisasi->result_array() as $k => $v) {
                    $data_realisasi = [
                        'id_provinsi'=> $v['id_provinsi'],
                        'id_kota'=> $v['id_kota'],
                        'id_instansi'=> $v['id_instansi'],
                        'kode_tahap'=> $tahap,
                        'bulan'=> $v['bulan'],
                        'tahun'=> $v['tahun'],
                        'bo_bp'=> $v['bo_bp'],
                        'bo_bbj'=> $v['bo_bbj'],
                        'bo_bs'=> $v['bo_bs'],
                        'bo_bh'=> $v['bo_bh'],
                        'bo_bbs'=> $v['bo_bbs'],
                        'bo_rf'=> $v['bo_rf'],
                        'bm_bmt'=> $v['bm_bmt'],
                        'bm_bmpm'=> $v['bm_bmpm'],
                        'bm_bmgb'=> $v['bm_bmgb'],
                        'bm_bmjji'=> $v['bm_bmjji'],
                        'bm_bmatl'=> $v['bm_bmatl'],
                        'bm_bmatb'=> $v['bm_bmatb'],
                        'bm_rf'=> $v['bm_rf'],
                        'btt'=> $v['btt'],
                        'btt_rf'=> $v['btt_rf'],
                        'bt_bbh'=> $v['bt_bbh'],
                        'bt_bbk'=> $v['bt_bbk'],
                        'bt_rf'=> $v['bt_rf'],
                        'created_on'=> timestamp(),
                        'created_by'=> id_user(),
                        'input_by'=> "Copy",
                    ];

                    array_push($kumpul_realisasi, $data_realisasi);
                }
                $this->db->insert_batch('realisasi_fisik_keuangan_kab_kota', $kumpul_realisasi);
                $output['status']  = true;
                $output['messages']   = "Data realisasi APBD AWAL SKPD ".$skpd." berhasil di copy";              
            }
            else{
                $output['status']  = false;
                $output['messages']   = "Data realisasi APBD AWAL SKPD ".$skpd." tidak ada";

            }

        


           
            echo json_encode($output);
        }
    }




 public function hapus_rfk_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'messages'    => '',
                'data'      => []
            ];
            $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;

            $id_kota =  $this->session->userdata('id_kota');
            $tahap =  $this->input->post('tahap');
            $skpd =  $this->input->post('skpd');
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $nama_tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];

            $where = ['id_instansi'=>$id_instansi, 'kode_tahap'=>$tahap];
            $this->db->order_by('bulan', 'ASC');
            $q_realisasi = $this->db->get_where('realisasi_fisik_keuangan_kab_kota', $where);

            $kumpul_realisasi  =[];
            if ($q_realisasi->num_rows()>0) {
                $this->db->delete('realisasi_fisik_keuangan_kab_kota', $where);
                $output['status']  = true;
                $output['messages']   = "Data realisasi ".$nama_tahap[$tahap]." SKPD ".$skpd." dihapus";              
            }
            else{
                $output['status']  = false;
                $output['messages']   = "Data realisasi ".$nama_tahap[$tahap]." SKPD ".$skpd." tidak ada";

            }



        


           
            echo json_encode($output);
        }
    }




 public function get_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $fisik_keuangan       = $this->realisasi_fisik_keuangan_model;

            // $kode_rekening_sub_kegiatan = '1.01.03.1.01.02';
            // $kode_kegiatan = '1.01.03.1.01';
            // $kode_program = '1.01.03';
            // $kode_bidang_urusan = '1.01';
            // $jenis_realisasi = 'bo';

            $jenis_realisasi =  $this->input->post('jenis');
            $tahap = tahapan_apbd() ;//config_kab_kota()->tahapan_apbd;
            $id_instansi = $this->input->post('id_instansi');
            
            $pagu = $this->db->query("SELECT * from v_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap'")->row();
            $direalisasikan = $this->db->query("SELECT * from realisasi_fisik_keuangan_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap'")->num_rows();


                $output['nama_instansi']  = $pagu->nama_instansi;
                $output['j_direalisasikan']  = $direalisasikan;
                $output['tahap']  = $tahap;
                $output['bo']  = number_format($pagu->pagu_bo);
                $output['bm']  = number_format($pagu->pagu_bm);
                $output['btt']  = number_format($pagu->pagu_btt);
                $output['bt']  = number_format($pagu->pagu_bt);
                $output['total']  = number_format($pagu->pagu_total);
                $output['status']  = true;
           
            echo json_encode($output);
        }
    }


    public function dt_realisasi_keuangan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $kode_rekening_program = $this->input->post('kode_rekening_program');

            if (!$kode_rekening_program) {
                $where = [
                    'id_instansi'   => id_instansi(),
                    'kode_tahap'    => tahapan_apbd()
                ];
            } else {
                $where = [
                    'id_instansi'           => id_instansi(),
                    'kode_tahap'            => tahapan_apbd(),
                    'kode_rekening_program' => $kode_rekening_program
                ];
            }
            $column_order   = ['kode_rekening_kegiatan', 'nama_kegiatan', 'belanja_pegawai', 'belanja_barang_jasa', 'belanja_modal', 'pagu'];
            $column_search  = ['kode_rekening_kegiatan', 'nama_kegiatan'];
            $order          = ['kode_rekening_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kode_rekening_kegiatan;
                $row[]  = $lists->nama_kegiatan;
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bp'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bbj'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bm'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['total'], 0, '', '.');
                $row[]  = '<button class="btn btn-success btn-sm" id="realisasi-keuangan" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" pagu="' . $lists->pagu . '"><i class="fas fa-money-bill"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    protected function get_data_realisasi($id_instansi, $kode_rekening_kegiatan)
    {
        $keuangan   = $this->realisasi_keuangan_model;
        $output     = [
            'total' => 0,
            'bp'    => 0,
            'bbj'   => 0,
            'bm'    => 0
        ];

        $belanja_pegawai     = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $belanja_barang_jasa = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $belanja_modal       = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $total               = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();

        $output['total']    = !empty($total['total']) ? $total['total'] : 0;
        $output['bp']       = !empty($belanja_pegawai['belanja_pegawai']) ? $belanja_pegawai['belanja_pegawai'] : 0;
        $output['bbj']      = !empty($belanja_barang_jasa['belanja_barang_jasa']) ? $belanja_barang_jasa['belanja_barang_jasa'] : 0;
        $output['bm']       = !empty($belanja_modal['belanja_modal']) ? $belanja_modal['belanja_modal'] : 0;

        return $output;
    }

    // public function get_realisasi_keuangan()
    // {
    //     if (!$this->input->is_ajax_request()) {
    //         show_404();
    //     } else {
    //         $output = [
    //             'status'    => false,
    //             'data'      => [],
    //             'opd'       => $this->db->get_where('master_instansi', ['id_instansi' => id_instansi()])->row()->sub_kategori,
    //             'message'   => ''
    //         ];


    //         $rekening           = $this->input->post('kode_rekening_kegiatan');
    //         $realisasi_keuangan = $this->db->order_by('bulan', 'ASC')->get_where('realisasi_keuangan', ['kode_rekening' => $rekening]);
    //         if ($realisasi_keuangan->num_rows() > 0) {
    //             $this->restruktur_keuangan($rekening);
    //             foreach ($realisasi_keuangan->result() as $key => $value) {
    //                 $output['data'][$key]['id']                     = $value->id_realisasi_keuangan;
    //                 $output['data'][$key]['bulan']                  = $value->bulan;
    //                 $output['data'][$key]['belanja_pegawai']        = $value->belanja_pegawai;
    //                 $output['data'][$key]['belanja_barang_jasa']    = $value->belanja_barang_jasa;
    //                 $output['data'][$key]['belanja_modal']          = $value->belanja_modal;
    //                 $output['data'][$key]['total']                  = $value->belanja_pegawai + $value->belanja_barang_jasa + $value->belanja_modal;
    //             }

    //             $output['status']   = true;
    //         } else {
    //             $this->restruktur_keuangan($rekening);
    //             $result = $this->db->order_by('bulan', 'ASC')->get_where('realisasi_keuangan', ['kode_rekening' => $rekening]);
    //             foreach ($result->result() as $key => $value) {
    //                 $output['data'][$key]['id']                     = $value->id_realisasi_keuangan;
    //                 $output['data'][$key]['bulan']                  = $value->bulan;
    //                 $output['data'][$key]['belanja_pegawai']        = $value->belanja_pegawai;
    //                 $output['data'][$key]['belanja_barang_jasa']    = $value->belanja_barang_jasa;
    //                 $output['data'][$key]['belanja_modal']          = $value->belanja_modal;
    //                 $output['data'][$key]['total']                  = $value->belanja_pegawai + $value->belanja_barang_jasa + $value->belanja_modal;
    //             }
    //             $output['status']   = true;
    //         }

    //         echo json_encode($output);
    //     }
    // }

    public function restruktur_keuangan($kode_rekening)
    {
        $data       = [];
        $kegiatan   = $this->db->get_where('kegiatan_apbd', ['kode_rekening' => $kode_rekening, 'kode_tahap' => tahapan_apbd()]);
        for ($i = 1; $i <= 12; $i++) {
            $realisasi = $this->db->get_where('realisasi_keuangan', ['kode_rekening' => $kode_rekening, 'bulan' => $i]);
            if (!$realisasi->num_rows() > 0) {
                $data[] = [
                    'kode_rekening'         => $kode_rekening,
                    'id_instansi'           => id_instansi(),
                    'kode_opd'              => $kegiatan->row()->kode_opd,
                    'kode_urusan'           => $kegiatan->row()->kode_urusan,
                    'kode_program'          => $kegiatan->row()->kode_program,
                    'kode_kegiatan'         => $kegiatan->row()->kode_kegiatan,
                    'nama_kegiatan'         => $kegiatan->row()->nama_kegiatan,
                    'bulan'                 => $i,
                    'tahun'                 => $kegiatan->row()->tahun,
                    'belanja_pegawai'       => 0,
                    'belanja_barang_jasa'   => 0,
                    'belanja_modal'         => 0,
                    'created_on'            => timestamp(),
                    'updated_on'            => timestamp(),
                    'created_by'            => id_user(),
                    'updated_by'            => id_user()
                ];
            }
        }
        if (!$realisasi->num_rows() > 0) {
            $this->db->insert_batch('realisasi_keuangan', $data);
        }
    }

    public function update_realisasi_keuangan($kode_rekening_sub_kegiatan, $bulan, $pagu, $tahap, $tahun)
    {
        // $pk     = $this->input->post('pk');
        // $id_realisasi = 6;
        // $target = 'r-bo_bp';
        // $value  = 1234;
        $pk     = $this->input->post('pk');
        $id_realisasi = sbe_crypt($pk, 'D');
        $target = $this->input->post('name');
        $value  = $this->input->post('value');

        $kode = $kode_rekening_sub_kegiatan;
               
        $pecah = explode('.', $kode);
        // $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
        $kode_sub_kegiatan = $kode_rekening_sub_kegiatan;
        $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
        $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];

        $kd_sub_kegiatan = $pecah[5];
        $kd_kegiatan = $pecah[3].'.'.$pecah[4];
        $kd_program = $pecah[2];
        $kode_bu = $pecah[0].'.'.$pecah[1];

        $cekdata = $this->db->query("SELECT id_realisasi_keuangan, 
        	(bo_bp+bo_bbj+bo_bs+bo_bh+bm_bmt+bm_bmpm+bm_bmgb+bm_bmjji+bm_bmatl+btt+bt_bbh+bt_bbk) as total_realisasi
         from realisasi_keuangan where id_realisasi_keuangan='$id_realisasi'");
        $realisasi_total = $cekdata->row_array()['total_realisasi'];
        $nilai = str_replace('.', '', $value);
        $persentasi_insert = ($nilai / $pagu) * 100 ; 
        $persentasi_update = $realisasi_total ;//- $nilai) + $nilai;//(($realisasi_total['total_realisasi'] - $nilai) / $pagu) * 100 ; 

        switch ($target) {
            case 'r-bo_bp':
                $data_update = [
                    'bo_bp' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bp' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bbj':
                $data_update = [
                    'bo_bbj' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bbj' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bs':
                $data_update = [
                    'bo_bs' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bs' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bh':
                $data_update = [
                    'bo_bh' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bh' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmt':
                $data_update = [
                    'bm_bmt' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmt' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmpm':
                $data_update = [
                    'bm_bmpm' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmpm' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmgb':
                $data_update = [
                    'bm_bmgb' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmgb' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmjji':
                $data_update = [
                    'bm_bmjji' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmjji' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmatl':
                $data_update = [
                    'bm_bmatl' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmatl' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-btt':
                $data_update = [
                    'btt' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'btt' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbh':
                $data_update = [
                    'bt_bbh' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bt_bbh' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbk':
                $data_update = [
                    'bt_bbk' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_update,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bt_bbk' => str_replace('.', '', $value),
                    'persen_realisasi_keuangan'=>$persentasi_insert,
                    'tahun'  => $tahun,
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
          
        }


        if ($cekdata->num_rows()==0) {
            $this->db->insert('realisasi_keuangan', $data_insert);
        }else{
            $this->db->update('realisasi_keuangan', $data_update, ['id_realisasi_keuangan' => $id_realisasi]);
        }
    }


    public function update_realisasi_keuangan_kab_kota($id_instansi, $bulan)
    {
        // $pk     = $this->input->post('pk');
        // $id_realisasi = 6;
        // $target = 'r-bo_bp';
        // $value  = 1234;
        $pk     = $this->input->post('pk');
        $id_realisasi = sbe_crypt($pk, 'D');
        $target = $this->input->post('name');
        $value  = $this->input->post('value');

        $id_provinsi = $this->session->userdata('id_provinsi');
        $id_kota = $this->session->userdata('id_kota');
        $tahap = tahapan_apbd();//config_kab_kota()->tahapan_apbd;
      


        switch ($target) {
            case 'r-bo_bp':
                $data_update = [
                    'bo_bp' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bp' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bbj':
                $data_update = [
                    'bo_bbj' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bbj' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bs':
                $data_update = [
                    'bo_bs' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bs' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bh':
                $data_update = [
                    'bo_bh' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bh' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bbs':
                $data_update = [
                    'bo_bbs' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_bbs' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmt':
                $data_update = [
                    'bm_bmt' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmt' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmpm':
                $data_update = [
                    'bm_bmpm' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmpm' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmgb':
                $data_update = [
                    'bm_bmgb' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmgb' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmjji':
                $data_update = [
                    'bm_bmjji' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmjji' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmatl':
                $data_update = [
                    'bm_bmatl' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmatl' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmatb':
                $data_update = [
                    'bm_bmatb' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_bmatb' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-btt':
                $data_update = [
                    'btt' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'btt' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbh':
                $data_update = [
                    'bt_bbh' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bt_bbh' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbk':
                $data_update = [
                    'bt_bbk' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bt_bbk' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;

                // fisik
            case 'r-bo_rf':
                $data_update = [
                    'bo_rf' => $value,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bo_rf' => $value,
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_rf':
                $data_update = [
                    'bm_rf' => $value,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bm_rf' => $value,
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-btt_rf':
                $data_update = [
                    'btt_rf' => $value,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'btt_rf' => $value,
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_rf':
                $data_update = [
                    'bt_rf' => $value,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'bt_rf' => $value,
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-rf_semua':
                $data_update = [
                    'rf_total' => $value,
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'rf_total' => $value,
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
          
        }
        $cekdata = $this->db->query("SELECT id_realisasi_fisik_keuangan_kab_kota from realisasi_fisik_keuangan_kab_kota where id_realisasi_fisik_keuangan_kab_kota='$id_realisasi'")->num_rows();

        if ($cekdata==0) {
            $this->db->insert('realisasi_fisik_keuangan_kab_kota', $data_insert);
        }else{
            $this->db->update('realisasi_fisik_keuangan_kab_kota', $data_update, ['id_realisasi_fisik_keuangan_kab_kota' => $id_realisasi]);
        }
    }



    public function update_realisasi_lra_kab_kota($id_instansi, $bulan)
    {
        // $pk     = $this->input->post('pk');
        // $id_realisasi = 6;
        // $target = 'r-bo_bp';
        // $value  = 1234;
        $pk     = $this->input->post('pk');
        $id_realisasi = sbe_crypt($pk, 'D');
        $target = $this->input->post('name');
        $value  = $this->input->post('value');

        $id_provinsi = $this->session->userdata('id_provinsi');
        $id_kota = $this->session->userdata('id_kota');
        $tahap = tahapan_apbd();//config_kab_kota()->tahapan_apbd;
      


       
                $data_update = [
                    'lra' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'id_instansi'  => $id_instansi ,
                    'id_provinsi'  => $id_provinsi,
                    'id_kota'  => $id_kota ,
                    'kode_tahap'  => $tahap,
                    'bulan'  => $bulan,
                    'lra' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
               
          
          
        
        $cekdata = $this->db->query("SELECT id_lra_kab_kota from lra_kab_kota where id_lra_kab_kota='$id_realisasi'")->num_rows();

        if ($cekdata==0) {
            $this->db->insert('lra_kab_kota', $data_insert);
        }else{
            $this->db->update('lra_kab_kota', $data_update, ['id_lra_kab_kota' => $id_realisasi]);
        }
    }



    public function reject_fisik()
    {
        $breadcrumbs        = $this->breadcrumbs;
        $realisasi_fisik    = $this->realisasi_fisik_model;

        // $breadcrumbs->add('Home', base_url());
        // $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        // $breadcrumbs->add('Fisik', base_url());
        // $breadcrumbs->render();

        $data['title']       = "Realisasi Fisik Reject";
        $data['icon']        = "metismenu-icon fa fa-list-ul";
        $data['description'] = "menampilkan list realisasi fisik yang ditolak";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $page                = 'realisasi/reject_fisik/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/reject_fisik/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/reject_fisik/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/reject_fisik/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function dt_reject_fisik()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            
                $where = [
                    'id_instansi'   => id_instansi()
                ];
            $column_order   = ['', 'nama_paket', 'nama_kegiatan'];
            $column_search  = ['nama_paket', 'nama_kegiatan'];
            $order          = ['id_realisasi_fisik' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_reject_fisik', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];

            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kode_rekening;
                $row[]  = $lists->full_name;
                $row[]  = $lists->nama_sub_kegiatan;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->dokumen_key;
                $row[]  = '<a href="'.base_url('realisasi/evidence/'.sbe_crypt($lists->id_realisasi_fisik)).'" class="btn btn-info btn-xs"><i class="fa fa-folder-open"></i></a>';
               

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_reject_fisik', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_reject_fisik', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


 public function hapus_r_keu_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $tahun = tahun_anggaran();
            $bulan_dihapus = $this->input->post('bulan');
            $id_instansi = id_instansi();
            if ($bulan_dihapus=='semua') {
                $where_rk = [
                    'kode_bidang_urusan' => $kode_bidang_urusan, 
                    'kode_program' => $kode_program, 
                    'kode_kegiatan' => $kode_kegiatan, 
                    'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                    'kode_tahap' => $tahap,
                    'tahun'=>tahun_anggaran(),
                    'id_instansi' => id_instansi()
                ];
            }else{
                $where_rk = [
                    'kode_bidang_urusan' => trim($kode_bidang_urusan), 
                    'kode_program' => trim($kode_program), 
                    'kode_kegiatan' => trim($kode_kegiatan), 
                    'kode_sub_kegiatan' => trim($kode_rekening_sub_kegiatan), 
                    'kode_tahap' => $tahap,
                    'tahun'=>tahun_anggaran(),
                    'bulan'=>$bulan_dihapus,
                    'id_instansi' => id_instansi()
                ];

            }
            $this->db->delete('realisasi_keuangan', $where_rk);
            $output['success'] = true; 
          

            
            echo json_encode($output);
        }
    }


   
 public function copy_r_keu_sub_kegiatan_tahap2()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $id_instansi = id_instansi();
            $where_awal = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_program' => $kode_program, 
                'kode_kegiatan' => $kode_kegiatan, 
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => 2,
                'id_instansi' => id_instansi()
            ];
          

            $where_perubahan = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_program' => $kode_program, 
                'kode_kegiatan' => $kode_kegiatan, 
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => tahapan_apbd(),
                'id_instansi' => id_instansi()
            ];
       
            // data APBD awal

            $realisasi                 = $this->db->order_by('bulan', 'ASC')->get_where('realisasi_keuangan', $where_awal);

        


            $kumpul_realisasi_baru = [];
            foreach ($realisasi->result_array() as $k => $v) {
                 $data_realisasi = [
                    'kode_sub_kegiatan'=>$v['kode_sub_kegiatan'],
                    'kode_kegiatan'=>$v['kode_kegiatan'],
                    'kode_program'=>$v['kode_program'],
                    'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                    'id_instansi'=>$v['id_instansi'],
                    'kode_tahap'=>tahapan_apbd(),
                    'bulan'=>$v['bulan'],
                    'tahun'=>$v['tahun'],
                    'bo_bp'=>$v['bo_bp'],
                    'bo_bbj'=>$v['bo_bbj'],
                    'bo_bs'=>$v['bo_bs'],
                    'bo_bh'=>$v['bo_bh'],
                    'bm_bmt'=>$v['bm_bmt'],
                    'bm_bmpm'=>$v['bm_bmpm'],
                    'bm_bmgb'=>$v['bm_bmgb'],
                    'bm_bmjji'=>$v['bm_bmjji'],
                    'bm_bmatl'=>$v['bm_bmatl'],
                    'btt'=>$v['btt'],
                    'bt_bbh'=>$v['bt_bbh'],
                    'bt_bbk'=>$v['bt_bbk'],
                    'created_on'=>timestamp(),
                    'created_by'=>id_user(),
                    'input_by'=>"Copy",
                  
                 
                   ];
                   array_push($kumpul_realisasi_baru, $data_realisasi);
            }
            $count_data = count($kumpul_realisasi_baru);
            $output['count'] = $count_data;
            if ($count_data > 0) {
               $this->db->insert_batch('realisasi_keuangan', $kumpul_realisasi_baru);
            }
            
            echo json_encode($output);
        }
    }



    public function nilai_realisasi_fisik($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];

        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);
      
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        foreach ($kegiatan as $key => $value) {
                if ($value->pagu >0) {
                    $satu = 1;
                }else{
                    $satu = 0;
                }

                array_push($tampung_kegiatan_berpagu, $satu);


            $total_paket    = $this->target_realisasi_model->total_paket($id_instansi, $value->kode_rekening_sub_kegiatan)->num_rows();
            $jenis_swakelola    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'SWAKELOLA')->num_rows();
            $jenis_penyedia    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'PENYEDIA')->num_rows();
            $jenis_rutin    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'RUTIN')->num_rows();
     
           
 
                // echo "<pre>".print_r($swakelola)."</pre>";
            for ($i = 1; $i <= bulan_aktif(); $i++) {

                $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->row()->total;
                $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->row()->total;


                //  if ($value->pagu > 0 ) {
                //     $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                // }else{
                //     $rutin          = 0;//$jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                // }
                    $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                    

             

                $total_fisik_perkegiatan = ($swakelola + $penyedia + $rutin); 
                @$ratarata_fisik = $total_fisik_perkegiatan / $total_paket;
                




                if ($swakelola + $penyedia + $rutin == 0) {
                    $total_fisik = 0;
                } else {
                    if ($total_paket==0) {
                        $total_fisik = 0;
                    }else{
                       $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
                    }
                }
                $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

                $total_fisik_bulan[$i][] = $total_fisik;
            }
        }



        if (empty($total_fisik_bulan)) :
            $fisik_array[] = 0;
        else :
            for ($i = 1; $i <= bulan_aktif(); $i++) {
                $hasil_fisik = ROUND(array_sum($total_fisik_bulan[$i]) / count($tampung_kegiatan_berpagu), 2);
                $fisik_array[] = $hasil_fisik;
               
            }
        endif;


        $realisasi_fisik[] = (!empty($fisik_array[0]) and $fisik_array[0] > 0) ? $fisik_array[0] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[1]) and $fisik_array[1] > 0) ? $fisik_array[1] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[2]) and $fisik_array[2] > 0) ? $fisik_array[2] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[3]) and $fisik_array[3] > 0) ? $fisik_array[3] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[4]) and $fisik_array[4] > 0) ? $fisik_array[4] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[5]) and $fisik_array[5] > 0) ? $fisik_array[5] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[6]) and $fisik_array[6] > 0) ? $fisik_array[6] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[7]) and $fisik_array[7] > 0) ? $fisik_array[7] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[8]) and $fisik_array[8] > 0) ? $fisik_array[8] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[9]) and $fisik_array[9] > 0) ? $fisik_array[9] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[10]) and $fisik_array[10] > 0) ? $fisik_array[10] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[11]) and $fisik_array[11] > 0) ? $fisik_array[11] : 0;
        return $realisasi_fisik;
    }


 public function rutin($bulan, $id_instansi)
    {
          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;
          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;
            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
            ];
            array_push($realisasi_rutin_bulan, $push);
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }




        return $realisasi_rutin;
    }
   

    public function tidak_ada_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $post               = $this->input->post();
            $output    = [
                'success' => false,
                'messages' => [],
                'cek' =>''
            ];
           

                
            $permasalahan = 'Tidak ada permasalahan';

                $data = [
                    'kode_sub_kegiatan'             => $post['kode_sub_kegiatan'],
                    'kode_kegiatan'             => '',//$post['kode_kegiatan'],
                    'kode_program'              => '',//$post['kode_program'],
                    'kode_bidang_urusan'                => '',//$post['kode_bidang_urusan'],
                    'id_instansi'               => id_instansi(),
                    'kode_tahap'                => $post['kode_tahap'],
                    'tahun'             => $post['tahun'],

                    'permasalahan'              => $permasalahan,

                    'created_on'                => timestamp(),
                    'created_by'                => id_user(),
                ];
                $this->db->insert('permasalahan_sub_kegiatan', $data);

            $output['cek'] = $data;
            echo json_encode($output);
        }
    }


}
