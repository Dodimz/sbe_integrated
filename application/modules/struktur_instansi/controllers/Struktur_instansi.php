<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Struktur_instansi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Struktur_instansi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->load->model([
			'struktur_instansi/sub_instansi_model' 	=> 'sub_instansi_model',

            'data_apbd/data_apbd_model'      => 'data_apbd_model',
			'datatables_model'                  		=> 'datatables_model'
		]);
	}

	public function sub_instansi()
	{
		$breadcrumbs 	= $this->breadcrumbs;
		$sub_instansi 	= $this->sub_instansi_model;

    	$fetch_method = $this->router->fetch_method();

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Struktur Instansi', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Sub Instansi', base_url());
		$breadcrumbs->render();
		  $data['dropdown_option']                      = [
          
            ['tipe'=>'link', 'caption'=>'Daftar User Dalam Struktur Instansi', 'fa'=>'fa fa-thumbs-up', 'onclick'=>'struktur_instansi/daftar_sub_instansi', 'elemen_tambahan'=>'data-toggle="tooltip" title="Lihat Daftar Struktur Instansi"'],
            ['tipe'=>'link', 'caption'=>'PPTK Kegiatan', 'fa'=>'fa fa-bars', 'onclick'=>'struktur_instansi/pptk_kegiatan', 'elemen_tambahan'=>'data-toggle="tooltip" title="PPTK Sub Kegiatan"'],
        ];

		$data['fetch_method']			            = $fetch_method;
		$data['title']			            = "Sub Instansi";
		$data['icon']                       = "metismenu-icon fa fa-list-ul";
		$data['description']	            = "Sub instansi";
		$data['breadcrumbs']	            = '';
		$page 					            = 'struktur_instansi/sub_instansi/index';
		$data['link']                       = $this->router->fetch_method();
		$data['menu']                       = $this->load->view('layout/menu', $data, true);
		$data['extra_css']		            = $this->load->view('struktur_instansi/sub_instansi/css', $data, true);
		$data['extra_js']		            = $this->load->view('struktur_instansi/sub_instansi/js', $data, true);
		$data['modal']                      = $this->load->view('struktur_instansi/sub_instansi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}
	public function daftar_sub_instansi()
	{
    	$fetch_method = $this->router->fetch_method();

		$data['fetch_method']			            = $fetch_method;
		$breadcrumbs 	= $this->breadcrumbs;
		$sub_instansi 	= $this->sub_instansi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Struktur Instansi', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Sub Instansi', base_url());
		$breadcrumbs->render();
		  $data['dropdown_option']                      = [
          
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'struktur_instansi/sub_instansi', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
        ];

		$data['title']			            = "Sub Instansi";
		$data['icon']                       = "metismenu-icon fa fa-list-ul";
		$data['description']	            = "Sub instansi";
		$data['breadcrumbs']	            = '';
		$page 					            = 'struktur_instansi/sub_instansi/daftar_sub_instansi';
		$data['link']                       = $this->router->fetch_method();
		$data['menu']                       = $this->load->view('layout/menu', $data, true);
		$data['extra_css']		            = $this->load->view('struktur_instansi/sub_instansi/css', $data, true);
		$data['extra_js']		            = $this->load->view('struktur_instansi/sub_instansi/js', $data, true);
		$data['modal']                      = $this->load->view('struktur_instansi/sub_instansi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}

	public function pptk_kegiatan()
	{
    	$fetch_method = $this->router->fetch_method();

		$data['fetch_method']			            = $fetch_method;
		$breadcrumbs 	= $this->breadcrumbs;
		$sub_instansi 	= $this->sub_instansi_model;
		$tahun = tahun_anggaran();
		$tahap = tahapan_apbd();
		$id_instansi = id_instansi();
		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Struktur Instansi', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Sub Instansi', base_url());
		$breadcrumbs->render();
		  $data['dropdown_option']                      = [
          
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'struktur_instansi/sub_instansi', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
        ];


        $data_apbd_model   = $this->data_apbd_model;
           $data['tot_program']                = $data_apbd_model->total_data_per_instansi(id_instansi(), $tahap, $tahun)['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total_data_per_instansi(id_instansi(), $tahap, $tahun)['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total_data_per_instansi(id_instansi(), $tahap, $tahun)['subkeg'];
        $pptk =  $this->db->query("SELECT mu.id_user,mu.full_name, si.nama_sub_instansi from master_users mu
        left join sub_instansi si on mu.id_sub_instansi = si.id_sub_instansi where mu.id_instansi='$id_instansi' and mu.id_kedudukan=3");
        $data['tot_pptk'] =$pptk->num_rows();
        $data['data_pptk'] =$pptk->result_array();
		$data['title']			            = "Sub Instansi";
		$data['icon']                       = "metismenu-icon fa fa-list-ul";
		$data['description']	            = "Sub instansi";
		$data['breadcrumbs']	            = '';
		$page 					            = 'struktur_instansi/sub_instansi/pptk_kegiatan';
		$data['link']                       = $this->router->fetch_method();
		$data['menu']                       = $this->load->view('layout/menu', $data, true);
		$data['extra_css']		            = $this->load->view('struktur_instansi/sub_instansi/css', $data, true);
		$data['extra_js']		            = $this->load->view('struktur_instansi/sub_instansi/js', $data, true);
		$data['modal']                      = $this->load->view('struktur_instansi/sub_instansi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}







    public function sub_kegiatan_apbd_instansi_gabungan($input_by)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            



            $tahap = $this->input->post('tahap');
            $tahap_aktif = $tahap;
            $tahun = $this->input->post('tahun');
            $fetch_method = $this->input->post('fetch_method');
            $id_instansi = id_instansi();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            if ($tahap==4) {
            	if ($input_by=='expired') {
	                $where          = ['status'=>0, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            	}else{
	                $where          = ['status'=>1, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            	}
            }
            else{
                $where          = ['kode_tahap'=>$tahap, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            }
			$caption_status_tahapan = [2=>'Melanjutkan data APBD AWAL pada APBD PERUBAHAN', '','APBD PERUBAHAN'];
            $status_sub_kegiatan = ['Tidak Aktif','Aktif','Digeser'];
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $tahap_ski = $lists->kode_tahap;



                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $kategori = $lists->kategori;
                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
                // upel = unit pelaksana
                 $onclick_update_upel = "edit_ski_teknis('".$lists->kode_rekening_sub_kegiatan."','".$kode_sub_kegiatan."', '".$lists->nama_sub_kegiatan."', '".$lists->id_sub_kegiatan_instansi."', '".$lists->jenis_sub_kegiatan."', '".$lists->keterangan."')";
                 if ($fetch_method=='lihat_data_apbd') {
                    $tbl_update_upel ="";
                     # code...
                 }else{

                    $tbl_update_upel = $kategori =='Sub Kegiatan SKPD' ? '' : '<br><button class="btn btn-info btn-xs"  title="Edit Unit Pelaksana"  onclick="'.$onclick_update_upel.'"><i class="fas fa-edit"></i></button> ';
                 }
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $kegiatan  = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_rekening_kegiatan'")->row_array();
                $program  = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_rekening_program'")->row_array();

                 $nama_sub_kegiatan ='<b>'.$kode_sub_kegiatan .'</b><br>'.$lists->nama_sub_kegiatan. $keterangan;//. $tbl_update_upel ;
                $row    = [];
                $row[]     = $no;

                if ($tahap_aktif==4) {
                	$caption_tahapan = $caption_status_tahapan[$lists->kode_tahap];
                	$caption_status_sub_kegiatan = $status_sub_kegiatan[$lists->status];
                }else{
                	$caption_tahapan = pilihan_nama_tahapan($lists->kode_tahap);
                	if ($lists->status==1) {
	                	$caption_status_sub_kegiatan = $status_sub_kegiatan[$lists->status];
                		# code...
                	}else{
	                	$caption_status_sub_kegiatan = $status_sub_kegiatan[$lists->status].' <br>['.'Dinonaktifkan / Dialihkan pada APBD PERUBAHAN'.']';

                	}

                }
                // $row[]  = $caption_tahapan;


                $row[]  = '<b>'.$caption_tahapan.'</b>';
                $row[]  = '<b>'.$lists->kode_rekening_program.'</b><br>'. $program['nama_program'];
                $row[]  = '<b>'.$lists->kode_rekening_kegiatan.'</b><br>'. $kegiatan['nama_kegiatan'];
                $row[]  = $nama_sub_kegiatan ; 
                $row[]  = '<b>'.$lists->kategori;
                 $pagu   = $lists->pagu =='' ? 0 : $lists->pagu;



                 $pptk = $this->db->query("SELECT si.nama_sub_instansi, mu.full_name from users_sub_kegiatan usk
                 join master_users mu on usk.id_user = mu.id_user
                 left join sub_instansi si on mu.id_sub_instansi = si.id_sub_instansi
                 where usk.id_instansi='$id_instansi' and usk.tahun_anggaran='$tahun' AND usk.kode_rekening_sub_kegiatan='$krsk' and usk.kode_tahap='$tahap_ski'")->result_array();


                $tabel_pptk = '
	                <ol>
	                ';
            
            


                 foreach ($pptk as $k_pptk => $v_pptk) {
                 	$tabel_pptk .= '<li>'.$v_pptk['full_name'].'<br>['.$v_pptk['nama_sub_instansi'].']</li>';
                 }

                     $tabel_pptk .= '
		                </ol>
		                ';

                $row[]  =  $tabel_pptk;//'<span style="float:right">'.number_format($pagu,0,'','.').'</span>';


                // $row[]  = $caption_status_sub_kegiatan;
             
               $onclick4 = "set_pptk_kegiatan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".$lists->kode_tahap."','".$lists->tahun."','".$lists->kode_bidang_urusan."')";

             
                $tombolsumber_dana = '<button class="btn btn-outline-info btn-xs"  title="Atur PPTK  sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick4.'"><i class="fas fa-plus"></i></button> ';
              

                    $tombol = $tombolsumber_dana;
                     $row[]     =  $tombol;




                


               
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









    public function cek_pptk_kegiatan()
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
            $tahun = $this->input->post('tahun');
            $id_instansi = id_instansi();
            $where = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_rekening_program' => $kode_program, 
                'kode_rekening_kegiatan' => $kode_kegiatan, 
                'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
                'id_instansi' => id_instansi()
            ];
            $target                 = $this->db->get_where('target_apbd', $where);












              $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan, kategori, kode_tahap, jenis_sub_kegiatan, keterangan from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and id_instansi='$id_instansi' and tahun='$tahun'")->row();
            $nama_sub_kegiatan = $subkeg->kategori =='Sub Kegiatan SKPD' ? $subkeg->nama_sub_kegiatan : $subkeg->nama_sub_kegiatan.'<br>'.$subkeg->jenis_sub_kegiatan.' - '.$subkeg->keterangan;

            $pecah = explode('.', $kode_rekening_sub_kegiatan);
            $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
           


            $tahap = $subkeg->kode_tahap;
           	  $pptk = $this->db->query("SELECT usk.id_user_sub_kegiatan, si.nama_sub_instansi, mu.full_name from users_sub_kegiatan usk
                 join master_users mu on usk.id_user = mu.id_user
                 left join sub_instansi si on mu.id_sub_instansi = si.id_sub_instansi
                 where usk.id_instansi='$id_instansi' and usk.tahun_anggaran='$tahun' AND usk.kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan'	and usk.kode_tahap='$tahap' ")->result_array();


            $output['kategori']              = $subkeg->kategori;
            $output['nama_sub_kegiatan']     = $nama_sub_kegiatan;
            $output['kode_sub_kegiatan']     = $kode_sub_kegiatan;
            $output['nama_tahapan']  = pilihan_nama_tahapan($subkeg->kode_tahap);
            $output['data_pptk']  = $pptk;


                $output['status'] = true;
            echo json_encode($output);
        }
    }







    public function list_user_struktur_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            
    	$fetch_method = $this->router->fetch_method();
            $where          = ['id_instansi' => id_instansi()];
            $column_order   = ['', 'nama_sub_instansi'];
            $column_search  = ['nama_sub_instansi','title'];
            $order          = ['id_sub_instansi' => 'ASC'];
            $tahun = $this->input->post('tahun');
            $tahap = $this->input->post('tahap');
            $list           = $this->datatables_model->get_datatables('v_sub_instansi', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $kedudukan = [1=>'PA','KPA','PPTK','PPK'];
            foreach ($list as $lists) {
            	$id_user = $lists->id_user;
            	$q_usk = $this->db->query("SELECT id_user_sub_kegiatan from users_sub_kegiatan where id_user='$id_user' and tahun_anggaran = '$tahun' and kode_tahap = '$tahap'")->num_rows();
               $no++;
              $row    = [];
                $row[]  = $no ; 

                 $tombol_detail_struktur = '<button type="button" class="tombol" onclick="get_data_detail_user('.$lists->id_user.','."'".$fetch_method."'".')" id="" data-toggle="tooltip" title="Detail Struktur Instansi" style="border:none">'.$lists->title.'</button>';


                $row[]  = $tombol_detail_struktur ; 
                $row[]  = $lists->nama_sub_instansi ; 
                $row[]  = @$kedudukan[$lists->id_kedudukan] ; 

              
                $row[]  = $lists->id_kedudukan==3 ? $q_usk : '-' ; 
                $row[]  = $lists->dir ; 

                $tombol_hapus_struktur = '<button type="button" class="btn btn-danger btn-xs" onclick="konfirmasi_hapus_sub_instansi_via_list_struktur('.$lists->id_user.','.$lists->id_kedudukan.','.$lists->id_sub_instansi.')" id="hapus_sub_instansi" data-toggle="tooltip" title="Hapus Struktur Instansi"><i class="fa fa-trash"></i></button>';
                $tombol_hapus_user = '<button type="button" class="btn btn-warning btn-xs" onclick="hapus_user_sub_instansi('.$lists->id_user.')" id="hapus_sub_instansi" data-toggle="tooltip" title="Hapus User dari Struktur Instansi"><i class="fa fa-trash"></i></button>';
                if ($lists->id_sub_instansi==0) {
	                $row[]  = $tombol_hapus_user ; 
                	# code...
                }else{
	                $row[]  = $tombol_hapus_struktur ; 

                }
               
                


               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_instansi', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_instansi', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }




	public function get_sub_instansi()
	{
		$output = [];
		$sub_instansi = $this->db->get_where('v_sub_instansi', ['id_instansi' => id_instansi(), 'status'=>'1'])->result();
		foreach ($sub_instansi as $row) {
			$output[] = $row;
		}

		$sub_instansi_relation = $this->db->get_where('v_sub_instansi_relation', ['id_instansi' => id_instansi(),  'status'=>'1'])->result();
		foreach ($sub_instansi_relation as $row) {
			array_push($output, $row);
		}

		echo json_encode($output);
	}

	public function user_detail()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> [],
				'message' 	=> ''
			];
			$id_user	= $this->input->post('id');
			$tahap = tahapan_apbd();
			$user 		= $this->db->get_where('v_informasi_user', ['id_user' => $id_user]);
			$q_ski 		= $this->db->query("SELECT id_user_sub_kegiatan from users_sub_kegiatan where id_user='$id_user' and kode_tahap='$tahap'");
			if ($user->num_rows() > 0) {
				foreach ($user->result() as $key => $value) {
					$output['data']['nama_lengkap'] 	= $value->full_name;
					$output['data']['id_sub_instansi'] 	= $value->id_sub_instansi;
					$output['data']['sub_instansi'] 	= $value->nama_sub_instansi;
					$output['data']['kedudukan'] 		= $value->nama_kedudukan;
					$output['data']['id_user'] 		= $value->id_user;
					$output['data']['id_kedudukan'] 		= $value->id_kedudukan;
					$output['data']['username'] 		= $value->username;
					$output['data']['email'] 			= $value->email;
					$output['data']['aktif'] 			= $value->is_active == 1 ? 'Aktif' : 'Tidak Aktif';
				}

				$output['status'] = true;
				$output['jumlah_data'] = $q_ski->num_rows();
			} else {
				$output['status'] = false;
				$output['jumlah_data'] = 0;
			}

			echo json_encode($output);
		}
	}

	public function dt_list_kegiatan()
	{
		$this->load->library('datatables');

		$id_user 	= $this->input->post('id');
		$where 		= ['id_instansi' => id_instansi(), 'id_user' => $id_user, 'kode_tahap' => tahapan_apbd()];
		$this->datatables->select('"no",kode_rekening_kegiatan,kode_urusan, nama_kegiatan')
			->from('v_list_kegiatan_pptk')
			->where($where)
			->unset_column('kode_urusan')
			->add_column('view', '<button class="btn btn-danger btn-xs" onclick="delete_user_kegiatan(' . "'" . $id_user . "','$1','$2'" . ')">x</button>', 'kode_rekening_kegiatan, kode_urusan');

		return print_r($this->datatables->generate());
	}


	public function dt_list_sub_kegiatan()
	{
		

		$id_user 	= $this->input->post('id');
		$tahap = tahapan_apbd();
		$tahun = tahun_anggaran();
		$status=['Tidak Aktif','Aktif'];

		
            $where          = ['id_instansi' => id_instansi(), 'id_user' => $id_user, 'tahun_anggaran'=>$tahun];
            $column_order   = ['', 'nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['kode_rekening_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_list_sub_kegiatan_pptk', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
              $caption_status_tahapan = [2=>'Melanjutkan data APBD AWAL pada APBD PERUBAHAN', '','APBD PERUBAHAN'];
             $caption_status_pengalihan = ['Dinonaktifkan / Dialihkan ke APBD Perubahan', 'Aktif'];
            foreach ($list as $lists) {
            	$pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
            	$nama_sub_kegiatan = $lists->kategori =='Sub Kegiatan SKPD' ? $lists->nama_sub_kegiatan : $lists->nama_sub_kegiatan.'<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $row[]  = $nama_sub_kegiatan;

                $status = $lists->status;
                    if ($status==1) {
                        if ($tahap==4) {
                            $caption_tahapan = $caption_status_tahapan[$lists->kode_tahap];
                        }else{
                            $caption_tahapan = pilihan_nama_tahapan($lists->kode_tahap);
                        }
                     } else{
                            $caption_tahapan = pilihan_nama_tahapan($lists->kode_tahap);

                     }
                $row[]  = $caption_tahapan;
                $status_kegiatan = $lists->status=='' ? 0 : 	$lists->status;
                $row[]  = $caption_status_pengalihan[$status_kegiatan];
                
                $row[]  = '<button class="btn btn-danger btn-xs" onclick="delete_user_sub_kegiatan(' . "'" . $lists->id_user_sub_kegiatan . "','".$lists->id_user."'" . ')">x</button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_list_sub_kegiatan_pptk', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_list_sub_kegiatan_pptk', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
	}

	public function list_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> [],
				'message' 	=> ''
			];
			$id_instansi 	= id_instansi();
			$tahap 			= tahapan_apbd();
			$tahun 			= tahun_anggaran();
			if ($tahap==4) {
				$kegiatan = $this->db->query("SELECT * FROM v_sub_kegiatan_apbd vska where vska.id_instansi='$id_instansi' and vska.status='1'and vska.tahun='$tahun' and vska.kode_rekening_sub_kegiatan NOT IN ( SELECT kode_rekening_sub_kegiatan FROM users_sub_kegiatan WHERE kode_rekening_sub_kegiatan = vska.kode_rekening_sub_kegiatan and id_instansi='$id_instansi' and kode_tahap='4' and tahun_anggaran='$tahun'  and status=1) ");
			}else{
				$kegiatan = $this->db->query("SELECT * FROM v_sub_kegiatan_apbd vska where vska.id_instansi='$id_instansi' and vska.kode_tahap='$tahap'and vska.tahun='$tahun' and vska.kode_rekening_sub_kegiatan NOT IN ( SELECT kode_rekening_sub_kegiatan FROM users_sub_kegiatan WHERE kode_rekening_sub_kegiatan = vska.kode_rekening_sub_kegiatan and id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun_anggaran='$tahun' and status=1) ");
			}

			if ($kegiatan->num_rows() > 0) {
				foreach ($kegiatan->result() as $key => $value) {
					$output['data'][$key]['rekening_sub_kegiatan'] = $value->kode_rekening_sub_kegiatan;
					$output['data'][$key]['rekening_kegiatan'] = $value->kode_rekening_kegiatan;
					$output['data'][$key]['rekening_program'] = $value->kode_rekening_program;
					$output['data'][$key]['rekening_bu'] = $value->kode_bidang_urusan;
					$output['data'][$key]['keterangan'] = $value->kategori=='Sub Kegiatan SKPD' ? '' : ' ['.$value->jenis_sub_kegiatan.' - '. $value->keterangan.']';
					$output['data'][$key]['kode_tahap'] = $value->kode_tahap;
					$output['data'][$key]['nama_tahap'] = pilihan_nama_tahapan($value->kode_tahap);
					$output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan;
				}

				$output['status']  = true;
			} else {
				$output['status'] = false;
			}

			echo json_encode($output);
		}
	}

	public function save_pptk_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> [],
				'id' 		=> ''
			];
			$id_user  				= $this->input->post('id_user');
			$split 					= explode('_', $this->input->post('rekening'));
			$kode_rekening_kegiatan = $split[0];
			$kode_urusan 			= $split[1];

			$data 	= [
				'id_instansi' 			=> id_instansi(),
				'id_user' 				=> $id_user,
				'kode_rekening_kegiatan' => $kode_rekening_kegiatan,
				'kode_urusan'			=> $kode_urusan,
				'created_on'			=> timestamp(),
				'updated_on' 			=> timestamp(),
				'created_by' 			=> id_user(),
				'updated_by' 			=> id_user()
			];
			$simpan = $this->db->insert('users_kegiatan', $data);
			if ($simpan) {
				$output['status'] 	= true;
				$output['id'] 		= $id_user;
			} else {
				$output['status'] 	= false;
				$output['id'] 		= null;
			}

			echo json_encode($output);
		}
	}

	public function save_pptk_sub_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> [],
				'id' 		=> ''
			];
			$id_user  				= $this->input->post('id_user');
			$via  				= $this->input->post('via');
			if ($via=='pptk_kegiatan') {
				$split 					= explode('_', $this->input->post('rekening'));
				$kode_rekening_sub_kegiatan = $split[0];
				$kode_rekening_kegiatan 	= $split[1];
				$kode_rekening_program 		= $split[2];
				$kode_bu 					= $split[3];
				$kode_tahap 					= $split[4];
			}else{
				
				$kode_rekening_sub_kegiatan =  $this->input->post('kode_sub_kegiatan');
				$kode_rekening_kegiatan 	=  $this->input->post('kode_kegiatan');
				$kode_rekening_program 		=  $this->input->post('kode_program');
				$kode_bu 					=  $this->input->post('kode_bidang_urusan');
				$kode_tahap 					=  $this->input->post('tahap');
				

			}

			$data 	= [

				'id_instansi' 		=> id_instansi(),
				'id_user' 		=> $id_user,
				'kode_rekening_sub_kegiatan' 		=> $kode_rekening_sub_kegiatan,
				'kode_rekening_kegiatan' 		=> $kode_rekening_kegiatan,
				'kode_rekening_program' 		=> $kode_rekening_program,
				'kode_bidang_urusan ' 		=> $kode_bu,
				'kode_tahap' 		=> $kode_tahap,
				'status' 		=> 1,
				'tahun_anggaran' 		=> tahun_anggaran(),
			


				'created_on'			=> timestamp(),
				'created_by' 			=> id_user(),
			];
			$simpan = $this->db->insert('users_sub_kegiatan', $data);
			if ($simpan) {
				$output['status'] 	= true;
				$output['id'] 		= $id_user;
			} else {
				$output['status'] 	= false;
				$output['id'] 		= null;
			}

				$output['cek'] 		= $this->input->post('rekening');
			echo json_encode($output);
		}
	}
	public function copy_pptk_sub_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> [],
				'id' 		=> ''
			];
			$id_user  				= $this->input->post('id_user');
			$tahap  				= tahapan_apbd();
			$id_instansi  				= id_instansi();
			$tahun_anggaran = tahun_anggaran();


			// $data 	= [
			// 	'id_instansi' 		=> id_instansi(),
			// 	'id_user' 		=> $id_user,
			// 	'kode_tahap' 		=> 2,
			// 	'tahun_anggaran' 		=> $tahun_anggaran,
			// ];

			$data_usk = $this->db->query("SELECT * from users_sub_kegiatan where id_user='$id_user' and id_instansi = $id_instansi and tahun_anggaran='$tahun_anggaran' and kode_tahap='2'");
			$kumpul_usk = [];
			foreach ($data_usk->result_array() as $k => $v) {
				$data_insert 	= [
					'id_instansi' 		=> id_instansi(),
					'id_user' 		=> $id_user,
					'kode_rekening_sub_kegiatan' 		=> $v['kode_rekening_sub_kegiatan'],
					'kode_rekening_kegiatan' 		=> $v['kode_rekening_kegiatan'],
					'kode_rekening_program' 		=> $v['kode_rekening_program'],
					'kode_bidang_urusan ' 		=> $v['kode_bidang_urusan'],
					'kode_tahap' 		=> tahapan_apbd(),
					'tahun_anggaran' 		=> tahun_anggaran(),
					'created_on'			=> timestamp(),
					'created_by' 			=> id_user(),
				];
				array_push($kumpul_usk, $data_insert);
				# code...
			}

			if ($data_usk->num_rows()>0) {
				$simpan = $this->db->insert_batch('users_sub_kegiatan', $kumpul_usk);
				if ($simpan) {
					$output['status'] 	= true;
					$output['id'] 		= $id_user;
				} else {
					$output['status'] 	= false;
					$output['id'] 		= null;
				}
			}else{
					$output['status'] 	= false;
			}


			// $simpan = $this->db->insert('users_sub_kegiatan', $data);

				$output['cek'] 		= $kumpul_usk;
			echo json_encode($output);
		}
	}

	public function tes()
	{
		$result = [];
		$data 	= $this->db->get('users_kegiatan')->result();
		foreach ($data as $datas) {
			$tes = $this->db->query("SELECT kode_urusan FROM kegiatan_apbd WHERE kode_rekening = '{$datas->kode_rekening_kegiatan}' LIMIT 1");
			foreach ($tes->result() as $tess) {
				$update = $this->db->update('users_kegiatan', ['kode_urusan' => $tess->kode_urusan], ['kode_rekening_kegiatan' => $datas->kode_rekening_kegiatan]);
			}
		}

		// print_r($result);
	}

	public function delete_user_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false
			];

			$id_user 		= $this->input->post('id');
			$kode_rekening 	= $this->input->post('rekening');
			$kode_urusan 	= $this->input->post('kode_urusan');
			$delete 	= $this->db->delete('users_kegiatan', ['id_instansi' => id_instansi(), 'id_user' => $id_user, 'kode_rekening_kegiatan' => $kode_rekening, 'kode_urusan' => $kode_urusan]);

			if ($delete) {
				$output['status'] = true;
			} else {
				$output['status'] = false;
			}

			echo json_encode($output);
		}
	}

	public function delete_user_sub_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false
			];

			$id_user_sub_keg 		= $this->input->post('id');
		
			$delete 	= $this->db->delete('users_sub_kegiatan', ['id_user_sub_kegiatan' => $id_user_sub_keg]);

			if ($delete) {
				$output['status'] = true;
			} else {
				$output['status'] = false;
			}

			echo json_encode($output);
		}
	}

	public function cek_data_sub_instansi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false
			];
			$cek 		= $this->db->get_where('sub_instansi', ['id_instansi' => id_instansi()]);

			if ($cek->num_rows() > 0) {
				$output['status'] = true;
			} else {
				$output['status'] = false;
			}

			echo json_encode($output);
		}
	}

	public function list_kedudukan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];
			$kedudukan  = $this->db->query("SELECT * from master_kedudukan order by urutan asc, id_kedudukan asc");

			if ($kedudukan->num_rows() > 0) {
				foreach ($kedudukan->result() as $key => $value) {
					$output['data'][] = $value;
				}
				$output['status'] = true;
			} else {
				$output['status'] = false;
			}

			echo json_encode($output);
		}
	}

	public function save_sub_instansi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			$idx 					= $this->input->post('idx');
			$id_kpa 				= $this->input->post('id_kpa');
			$nama_sub_instansi 		= $this->input->post('nama_sub_instansi');
			$id_kedudukan 			= $this->input->post('id_kedudukan');
			$full_name 				= $this->input->post('full_name');
			$username 				= $this->input->post('username');
			$email  				= $this->input->post('email');
			$default_password 		= '123qweasd';

			$cek_kpa = $this->db->get_where('master_users', ['id_user' => $id_kpa, 'id_kedudukan' => 2]);
			$cek = $this->db->get_where(
				'sub_instansi',
				[
					'id_instansi' 		=> id_instansi(),
					'id_kedudukan !=' 	=> 4
				]
			)->num_rows();
			$data 					= [
				'id_instansi' 			=> id_instansi(),
				'id_top_parent' 		=> $cek > 0 ? $idx : 0,
				'id_parent' 			=> $idx > 0 ? $idx : 0,
				'id_kpa' 				=> $cek_kpa->num_rows() > 0 && $id_kedudukan == 3 ? $cek_kpa->row()->id_sub_instansi : 0,
				'id_kedudukan'			=> $id_kedudukan,
				'nama_sub_instansi'		=> $nama_sub_instansi,
				'dir'  					=> $cek > 0 ? 'vertical' : 'horizontal',
				'keterangan' 			=> '-'
			];
			$simpan  = $this->db->insert('sub_instansi', $data);
			$last_id = $this->db->insert_id();

			$id_top_parent = $this->db->query("SELECT MIN(id_sub_instansi) AS min FROM sub_instansi WHERE id_instansi=" . id_instansi())->row()->min;
			if ($cek == 0) {
				$this->db->update(
					'sub_instansi',
					['id_top_parent' => $last_id, 'id_parent' => $last_id],
					['id_instansi' => id_instansi(), 'id_sub_instansi' => $last_id]
				);
			} else {
				$this->db->update(
					'sub_instansi',
					['id_top_parent' => $id_top_parent],
					['id_instansi' => id_instansi()]
				);
			}

			$user 					= [
				'id_parent' 			=> 1,
				'id_instansi'			=> id_instansi(),
				'id_sub_instansi' 		=> $last_id,
				'id_kedudukan' 			=> $id_kedudukan,
				'full_name' 			=> $full_name,
				'username' 				=> $username,
				'email'					=> $email,
				'password' 				=> password_hash($default_password, PASSWORD_DEFAULT),
				'created_on'			=> timestamp(),
				'updated_on'			=> timestamp(),
				'created_by' 			=> id_user(),
				'updated_by' 			=> id_user()
			];
			$this->db->insert('master_users', $user);

			if ($simpan) {
				$output['status'] 	= true;
			} else {
				$output['status'] 	= false;
			}

			echo json_encode($output);
		}
	}

	public function update_data_user($table)
	{
		$output 	= [
			'status' => false
		];

		$primary 	= $this->input->post('pk');
		$name 		= $this->input->post('name');
		$value 		= $this->input->post('value');

		if ($table == 'user') {
			$tbl = 'master_users';
			$pk  = 'id_user';
		} 
		elseif ($table == 'kedudukan') {
			$tbl = 'master_users';
			$pk  = 'id_user';
		} elseif ($table == 'sub_instansi') {
			$tbl = 'sub_instansi';
			$pk  = 'id_sub_instansi';
		}

		$update     = $this->db->update($tbl, [$name => $value], [$pk => $primary]);

		if ($update) {
			$output['status'] = true;
		}

		echo json_encode($output);
	}

	public function cek_bawahan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			$id_user = $this->input->post('id_user');
			$id_kedudukan = $this->input->post('id_kedudukan');
			$id_sub_instansi = $this->input->post('id_sub_instansi');

			$data_sub_instansi = $this->db->query("SELECT si.nama_sub_instansi, mu.full_name from sub_instansi si left join master_users mu on si.id_sub_instansi=mu.id_sub_instansi where si.id_sub_instansi='$id_sub_instansi'")->row();
			$id_instansi = id_instansi();
			if ($id_kedudukan==1) {
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where id_top_parent='$id_sub_instansi' and id_sub_instansi!='$id_sub_instansi' and id_instansi='$id_instansi'")->num_rows();
			}else{
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where id_parent='$id_sub_instansi' and id_sub_instansi!='$id_sub_instansi' and id_instansi='$id_instansi'")->num_rows();
			}


			

			$output['status'] = true;
			$output['data']['bawahan'] = $q_cek_bawahan;
			$output['data']['nama_struktur'] = $data_sub_instansi->nama_sub_instansi;
			$output['data']['user'] = $data_sub_instansi->full_name;

			echo json_encode($output);
		}
	}



	public function hapus_struktur_instansi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			// $id_user = $this->input->post('id_user');
			$id_kedudukan = $this->input->post('id_kedudukan');
			$id_sub_instansi = $this->input->post('id_sub_instansi');

			
			$id_instansi = id_instansi();
			$tahap = tahapan_apbd();
			$tahun = tahun_anggaran();
			if ($id_kedudukan==1) {
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where (id_top_parent='$id_sub_instansi' or id_sub_instansi='$id_sub_instansi') and id_instansi='$id_instansi'")->result();
			}else{
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where (id_parent='$id_sub_instansi' or id_sub_instansi='$id_sub_instansi') and id_instansi='$id_instansi'")->result();
			}

			foreach ($q_cek_bawahan as $key => $value) {
			$output['data'][$key] = $value->id_sub_instansi;
				$data_id_sub_instansi = $value->id_sub_instansi;
				$qcekuser = $this->db->query("SELECT id_user from master_users where id_sub_instansi = '$data_id_sub_instansi' and id_instansi='$id_instansi'")->row();
				$id_user = $qcekuser->id_user;

				$this->db->delete('users_sub_kegiatan', ['id_user' => $id_user, 'id_instansi' => id_instansi(), 'kode_tahap' => $tahap, 'tahun_anggaran' => $tahun]);
				$this->db->update('master_users',['id_kedudukan'=>'', 'id_sub_instansi'=>''], ['id_user' => $id_user,'id_sub_instansi' => $data_id_sub_instansi, 'id_instansi' => id_instansi()]);
				$this->db->delete('sub_instansi', ['id_sub_instansi' => $data_id_sub_instansi, 'id_instansi' => id_instansi()]);
			}
			

			$output['status'] = true;
			

			echo json_encode($output);
		}
	}




	
	public function save_edit_sub_instansi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			// $id_user = $this->input->post('id_user');
			$id_kedudukan = $this->input->post('id_kedudukan');
			$id_sub_instansi = $this->input->post('id_sub_instansi_lama');

			$id_user = $this->input->post('id_user');
			// $id_kedudukan = $this->input->post('id_kedudukan');
			$id_sub_instansi = $this->input->post('id_sub_instansi');
			$nama_sub_instansi_lama = $this->input->post('nama_sub_instansi_lama');
			$full_name_lama = $this->input->post('full_name_lama');
			$nama_sub_instansi = $this->input->post('nama_sub_instansi');
			$nama_kedudukan = $this->input->post('nama_kedudukan');
			$full_name = $this->input->post('full_name');
			

			$q_sub_instansi_lama = $this->db->query("SELECT * from sub_instansi where id_sub_instansi='$id_sub_instansi'")->row_array();
			$id_kedudukan = $q_sub_instansi_lama['id_kedudukan'];
			$id_instansi = $q_sub_instansi_lama['id_instansi'];
			$id_top_parent = $q_sub_instansi_lama['id_top_parent'];
			$id_parent = $q_sub_instansi_lama['id_parent'];
			$id_kpa = $q_sub_instansi_lama['id_kpa'];
			$dir = $q_sub_instansi_lama['dir'];
			
			$tahap = tahapan_apbd();
			$tahun = tahun_anggaran();

			if ($id_kedudukan==1) {
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where (id_top_parent='$id_sub_instansi' or id_sub_instansi='$id_sub_instansi') and id_instansi='$id_instansi'")->result();
			}else{
				$q_cek_bawahan = $this->db->query("SELECT * from sub_instansi where (id_parent='$id_sub_instansi' or id_sub_instansi='$id_sub_instansi') and id_instansi='$id_instansi'")->result();
			}


				$data_sub_instansi_baru = [
					'id_instansi'=>$id_instansi,
					'id_top_parent'=>$id_top_parent,
					'id_parent'=>$id_parent,
					'id_kpa'=>$id_kpa,
					'id_kedudukan'=>$id_kedudukan,
					'nama_sub_instansi'=>$nama_sub_instansi,
					'dir'=>$dir,
					'keterangan'=>'-',
					'status'=>'1',
				];
				$this->db->insert('sub_instansi', $data_sub_instansi_baru);

				$id_sub_instansi_baru = $this->db->insert_id();
				$data_users_baru = [
					'id_instansi'=>$id_instansi,
					'id_sub_instansi'=>$id_sub_instansi_baru,
					'id_kedudukan'=>$id_kedudukan,
					'status_kedudukan'=>'1',
					'full_name'=>$full_name,
					'created_on'=>timestamp(),
					'created_by'=>id_user(),
				];
				$this->db->insert('master_users', $data_users_baru);
				$id_user_baru =  $this->db->insert_id();

				
			$usk = $this->db->get_where('users_sub_kegiatan', ['id_user' => $id_user, 'id_instansi' => id_instansi(), 'kode_tahap' => $tahap, 'tahun_anggaran' => $tahun]);
			$kumpul_usk = [];
			foreach ($usk->result_array() as $k=>$v){
				$data_usk_baru = [
					'id_instansi'=> $id_instansi ,
					'id_user'=> $id_user_baru,
					'kode_rekening_sub_kegiatan'=> $v['kode_rekening_sub_kegiatan'],
					'kode_rekening_kegiatan'=> $v['kode_rekening_kegiatan'],
					'kode_rekening_program'=> $v['kode_rekening_program'],
					'kode_bidang_urusan'=> $v['kode_bidang_urusan'],
					'kode_tahap'=> $v['kode_tahap'],
					'tahun_anggaran'=> $v['tahun_anggaran'],
					'created_on'=> timestamp() ,
					'created_by'=>id_user() ,
					'status'=> 1,
				];
				array_push($kumpul_usk, $data_usk_baru);
			}


			$this->db->update('master_users',['status_kedudukan'=>'0', 'id_sub_instansi'=>''], ['id_user' => $id_user,'id_sub_instansi' => $data_id_sub_instansi, 'id_instansi' => id_instansi()]);
			$this->db->update('sub_instansi', ['status'=>0], ['id_sub_instansi' => $id_sub_instansi]);
			if($usk->num_rows()>0){
				$this->db->insert_batch('users_sub_kegiatan', $kumpul_usk);
				
			}
			$usk = $this->db->update('users_sub_kegiatan', ['status'=>0], ['id_user' => $id_user, 'id_instansi' => id_instansi(), 'kode_tahap' => $tahap, 'tahun_anggaran' => $tahun]);
			$output['status'] = true;
			$output['cek'] = true;
			

			echo json_encode($data_sub_instansi_baru);
		}
	}
	// public function hapus_sub_instansi()
	// {
	// 	if (!$this->input->is_ajax_request()) {
	// 		show_404();
	// 	} else {
	// 		$output 	= [
	// 			'status' 	=> false,
	// 			'data' 		=> []
	// 		];

	// 		$id_sub_instansi = $this->input->post('id_sub_instansi');
	// 		$this->db->delete('sub_instansi', ['id_kpa' 	     => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('sub_instansi', ['id_top_parent' 	 => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('master_users', ['id_sub_instansi' => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('sub_instansi', ['id_sub_instansi' => $id_sub_instansi, 'id_instansi' => id_instansi()]);

	// 		$output['status'] = true;

	// 		echo json_encode($output);
	// 	}
	// }


	public function hapus_user_struktur_instansi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			// $id_user = $this->input->post('id_user');
			$id_user = $this->input->post('id_user');
			$id_instansi = id_instansi();
			$this->db->delete('master_users',['id_user'=>$id_user,'id_instansi'=>$id_instansi]);

	
			

			$output['status'] = true;
			

			echo json_encode($output);
		}
	}
	public function hapus_user_sub_kegiatan()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'data' 		=> []
			];

			// $id_user = $this->input->post('id_user');
			$id_usk = $this->input->post('id_usk');
			$id_instansi = id_instansi();
			$this->db->delete('users_sub_kegiatan',['id_user_sub_kegiatan'=>$id_usk]);

	
			

			$output['status'] = true;
			

			echo json_encode($output);
		}
	}
	// public function hapus_sub_instansi()
	// {
	// 	if (!$this->input->is_ajax_request()) {
	// 		show_404();
	// 	} else {
	// 		$output 	= [
	// 			'status' 	=> false,
	// 			'data' 		=> []
	// 		];

	// 		$id_sub_instansi = $this->input->post('id_sub_instansi');
	// 		$this->db->delete('sub_instansi', ['id_kpa' 	     => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('sub_instansi', ['id_top_parent' 	 => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('master_users', ['id_sub_instansi' => $id_sub_instansi, 'id_instansi' => id_instansi()]);
	// 		$this->db->delete('sub_instansi', ['id_sub_instansi' => $id_sub_instansi, 'id_instansi' => id_instansi()]);

	// 		$output['status'] = true;

	// 		echo json_encode($output);
	// 	}
	// }
}
