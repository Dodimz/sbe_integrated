<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Backup_database.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_database extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		$this->load->dbutil();
		$this->load->helper('file');

		$config = array(
			'format'	=> 'zip',
			'filename'	=> 'sbe_2020.sql'
		);

		$backup = $this->dbutil->backup($config);

		$save = FCPATH.'backup/@backup-'.uniqid().'-'.date("d-m-Y H.i.s").'-db.zip';

		write_file($save, $backup);
	}
}