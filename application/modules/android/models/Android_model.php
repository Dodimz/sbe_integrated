<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Android_model extends CI_Model
{
	protected $tbl_users   			= "register_user";
	protected $tbl_session 			= "ci_sessions";
	protected $tbl_login_attempts 	= "login_attempts";
	public $email;
	public $password;

	public function rules()
	{
		return [
			[
				'field' => 'email',
				'label' => 'E-Mail',
				'rules' => 'required'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			]
		];
	}

	protected function get_by_username_email($username)
	{
		$data = ['email' => $username];
		$this->db->where($data);
		// $this->db->or_where('username', $username);
		return $this->db->get('register_user')->row_array();
	}
	protected function cek_group($id_user)
	{	
		$q = $this->db->query("SELECT id_group from users_groups where id_user='$id_user'");
		return $q->row();
	}

	public function login()
	{
		$output			= ['status' => false, 'message' => '', 'data'=>[]];
		$post 			= $this->input->post();
		$this->email 	= $post['username'];
		$this->password = $post['password'];
		$input_email = $this->email;
		$input_password = $this->password;
		$data			= ['nohp' => $this->email];
		$user			= $this->get_by_username_email($input_email);
		$output['cek'] 	= $user;
		$attempts_count = (int) $this->check_attempts($input_email);
		// if ($attempts_count < 3) {
			if ($user) {
				if (password_verify($this->password, $user['password'])) {
					if ($user['is_active'] == 1) {
						$output['status'] 	= true;
						$output['message']	= 'Success !';

						$output['data'] = [
							'id_user' 		=> $user['id_user'],
							'full_name' 	=> $user['full_name'],
							'nohp' 		=> $user['nohp'],
							'session_name' 	=> 'SBE_LOGIN',
							'alasan'	=> $user['alasan_register'],
							'pekerjaan' => $user['pekerjaan'],
							// 'id_group' 		=> $this->cek_group($user['id_user'])->id_group,
							// 'group_name' 	=> $user['group_name'],
							// 'id_kedudukan'	=> $user['id_kedudukan'],
							// 'kedudukan' 	=> $user['nama_kedudukan'],
							// 'id_session' 	=> session_id()
						];
						
						// $this->db->update('master_users', ['online' => 1, 'last_login' => time()], ['id_user' => $output['data']['id_user']]);
					} else {
						// $this->attempts($input_email);
						$namabulan = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
						$pw = explode(' ', $user['expired_confirmation']);
						$pt = explode('-', $pw[0]);
						if (date('Y-m-d H:i')>$user['expired_confirmation']) {
							$output['status'] 	= false;
							$output['message']	= 'Akun anda sudah terhapus dari sistem karena anda tidak menkonfirmasi email sebelum jadwal yang di tentukan sistem';
							$this->db->delete('register_user',['id_user'=>$user['id_user']]);
						}else{
							$output['status'] 	= false;
							$output['message']	= 'Akun anda sudah terdaftar namun belum di aktivasi. Silahkan cek email anda pada kotak masuk / spam untuk mengaktivasi akun anda. Harap aktivasi sebelum tanggal '.$pt[2].' '.$namabulan[$pt[1]].' '.$pt[0];
						}
						
					}
				} else {
					$output['status'] 	= false;
					$output['message']	= 'Password salah !';
				}
			} else {
				$output['status'] 	= false;
				$output['message']	= 'Email/Username tidak terdaftar';
			}
		// } else {
		// 	$output['status'] 	= false;
		// 	$output['message']	= 'Temporarily Locked Out. Contact Administrator !';
		// }

		return $output;
	}


	public function cek_password()
	{
		$output			= ['status' => false, 'message' => '', 'data'=>[]];
		$post 			= $this->input->post();
		$id_user = $post['id_user'];
		$pass_lama = $post['pass_lama'];
		$pass_baru = $post['pass_baru'];
		$where =['id_user'=>$id_user];
		$user = $this->db->get_where('register_user', $where)->row_array();
			if ($user) {
		
					if (password_verify($pass_lama, $user['password'])) {
						$password_baru = password_hash($pass_baru, PASSWORD_DEFAULT);
						$data = ['password'=> $password_baru];
						$where = ['id_user'=>$id_user];
						
						$this->db->update('register_user', $data, $where);
						$output['status'] = true;
						$output['message']	= 'Password diperbaharui';
					} 
				# code...
			}else{
				$output['status'] 	= false;
				$output['message']	= 'Data user tidak ditemukan';
			}
			

		return $output;
	}

	protected function attempts($email)
	{
		$data 		= [
			'ip_address' 	=> $this->input->ip_address(),
			'email' 			=> $email,
			'time' 			=> timestamp()
		];
		$attempts 	= $this->db->insert($this->tbl_login_attempts, $data);
	}

	protected function check_attempts($email)
	{
		return $this->db->get_where($this->tbl_login_attempts, ['email' => $email])->num_rows();
	}

	public function logout()
	{
		$this->db->update('master_users', ['online' => 0, 'last_login' => time()], ['id_user' => $this->session->userdata('id_user')]);
		$this->session->sess_destroy();
		redirect('/');
	}


	public function identitas_user($id_user)
	{	
		$q = $this->db->query("SELECT * FROM `register_user` where id_user='$id_user' and is_active='1'");
		return $q;
	}
	public function cek_register_user($email, $id_user='')
	{	
		if ($id_user=='') {
			$q = $this->db->query("SELECT * from register_user where email='$email'");
		}else{
			$q = $this->db->query("SELECT * from register_user where email='$email' and id_user!='$id_user'");

		}
		return $q;
	}
	public function daftar_skpd()
	{	
		$q = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where id_instansi not in (163,164,165, 200, 201,202,203,204,205,206) order by nama_instansi asc");
		return $q;
	}


	public function instansi($id_instansi, $id_group)
	{	
		if ($id_group==5) {
			$q = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where id_instansi ='$id_instansi'");
		}else{
			$q = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where id_instansi not in (163,164,165, 200, 201,202,203,204,205,206)");
		}
		return $q;
	}
	public function data_kontrak_pekerjaan($id_instansi)
	{	
		$q = $this->db->query("SELECT 
			kp.id_paket_pekerjaan, kp.no_kontrak, kp.tgl_register_kontrak, kp.pelaksana,kp.tgl_awal_pelaksanaan,kp.tgl_akhir_pelaksanaan,kp.nilai_kontrak,kp.latitude,kp.longitude,

			pp.nama_paket, pp.pagu,
			msk.nama_sub_kegiatan, mu.full_name as pptk
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan  = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi=ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on kp.id_pptk = mu.id_user
			where kp.id_instansi ='$id_instansi' ");
		return $q;
	}
	public function gis_all($filter, $params)
	{	
		if ($filter=='skpd') {
			$where = "where kp.id_instansi='$params'";
			
		}
		elseif ($filter=='keyword') {
			$where = "where pp.nama_paket like '%$params%' or msk.nama_sub_kegiatan like '%$params%'";
		}
		elseif ($filter=='kab_kota') {
			$where = "where kp.id_kota='$params'";
		}
		else{
			$where = "";
		}
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, kp.nilai_kontrak, kp.pelaksana, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, ski.kode_sub_kegiatan,
			total_anggaran_sub_kegiatan(ski.kode_sub_kegiatan,ski.kode_tahap,ski.id_instansi,ski.kode_kegiatan,ski.kode_program) as pagu,
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi, mi.id_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on substr(pp.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			$where

			");
		return $q;
	}
	public function gis_skpd($id_instansi)
	{	
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, 
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.id_instansi = '$id_instansi'
			");
		return $q;
	}
	public function gis_skpd_keyword($id_instansi, $keyword)
	{	
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, 
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.id_instansi = '$id_instansi' and ( msk.nama_sub_kegiatan  like '%$keyword%' or pp.nama_paket like '%$keyword%')
			");
		return $q;
	}
	public function gis_skpd_kab_kota($id_instansi, $id_kab_kota)
	{	
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, 
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.id_instansi = '$id_instansi' and kp.id_kota='$id_kab_kota'
			");
		return $q;
	}
	public function gis_domisili($id_kota)
	{	
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, 
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.id_kota = '$id_kota'
			");
		return $q;
	}
	public function gis_keyword($keyword)
	{	
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, 
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where msk.nama_sub_kegiatan  like '%$keyword%' or pp.nama_paket like '%$keyword%'
			");
		return $q;
	}
	public function kab_kota($id_provinsi)
	{	
		$q = $this->db->query("SELECT * from kota where id_provinsi = '$id_provinsi'
			");
		return $q;
	}


	public function detail_kontrak_pekerjaan($id_paket_pekerjaan)
	{	
		$q = $this->db->query("SELECT 
			kp.id_paket_pekerjaan, kp.no_kontrak, kp.tgl_register_kontrak, kp.pelaksana,kp.tgl_awal_pelaksanaan,kp.tgl_akhir_pelaksanaan,kp.nilai_kontrak,kp.latitude,kp.longitude,

			pp.nama_paket, pp.pagu, pp.id_instansi,
			msk.nama_sub_kegiatan, mu.full_name as pptk,
			k.nama_kota, p.nama_provinsi,
			mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan  = pp.id_paket_pekerjaan
			left join master_instansi mi on kp.id_instansi=mi.id_instansi
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi=ski.id_instansi
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			left join master_users mu on kp.id_pptk = mu.id_user
			left join kota k on kp.id_kota=k.id_kota
			left join provinsi p on kp.id_provinsi = p.id_provinsi
			where kp.id_paket_pekerjaan ='$id_paket_pekerjaan' ");
		return $q;
	}
	public function progress_pekerjaan($id_paket_pekerjaan)
	{	
		$q = $this->db->query("
			SELECT * from progress_pekerjaan
			where id_paket_pekerjaan ='$id_paket_pekerjaan' order by persentasi asc ");
		return $q;
	}

	    public function pagu($id_instansi, $tahap)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
					sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo,
					sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm,
					sum(btt) as pagu_btt,
					sum( bt_bbh+bt_bbk ) as pagu_bt,
					sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
					FROM
					anggaran_sub_kegiatan 
					WHERE
					id_instansi = '$id_instansi'
					and kode_tahap = '$tahap'
                                        ");
        return $query;
    }
    
    public function pagu_total($tahap)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm,
sum(btt) as pagu_btt,
 sum( bt_bbh+bt_bbk ) as pagu_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
                                      
                                    FROM
                                        anggaran_sub_kegiatan 
                                    WHERE
                                     kode_tahap = '$tahap'
                                        ");
        return $query;
    }


}
