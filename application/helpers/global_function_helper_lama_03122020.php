<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * License    : Pemerintahan Provinsi Sumatera Barat
 * Class 	  : global_function_helper.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

/* CI Get Instance */
function CI()
{
	$CI = &get_instance();
	return $CI;
}
function bulan_aktif()
{
	return CI()->db->get('config')->row()->bulan_aktif;
}
// Konversi Bulan
function konversi_bulan($x)
{
	$bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
	return $bulan[$x];
}
/* Tahun Anggaran APBD */
function tahun_anggaran()
{
	return CI()->db->get('config')->row()->tahun_anggaran;
}
/* Tahapan APBD */
function tahapan_apbd()
{
	return $tahapan_apbd = CI()->db->get('config')->row()->tahapan_apbd;
}
/* Nama Tahapan APBD */
function nama_tahapan()
{
	$tahap = tahapan_apbd();
	if ($tahap == 2) {
		$nama_tahapan = "APBD AWAL";
	} elseif ($tahap == 4) {
		$nama_tahapan = "APBD PERUBAHAN";
	}

	return $nama_tahapan;
}
// Nama Instansi
function nama_instansi($id_instansi = '')
{
	if ($id_instansi) {
		$id = $id_instansi;
	} else {
		$id = id_instansi();
	}
	return CI()->db->get_where('master_instansi', ['id_instansi' => $id])->row()->nama_instansi;
}
/* ID instansi berdasarkan Kode OPD */
function id_instansi_kode_opd($kode_opd)
{
	$data = CI()->db->get_where('master_instansi', ['kode_opd' => $kode_opd]);
	if ($data->num_rows() > 0) {
		return $data->row()->id_instansi;
	} else {
		return 0;
	}
}
/* Check Internet Connection */
function internet_connection($sCheckHost = 'www.google.com')
{
	return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
}
/* Check Identitas Exist */
function identitas()
{
	$check = CI()->db->query("SELECT * FROM master_identitas")->num_rows();
	if ($check > 0) {
		return true;
	} else {
		return false;
	}
}
/* id user */
function id_user()
{
	return CI()->session->userdata('id_user');
}
/* nama user */
function nama_user()
{
	return CI()->session->userdata('full_name');
}
/* id instansi */
function id_instansi()
{
	return CI()->session->userdata('id_instansi');
}
/* Get Full Name */
function full_name($id_user)
{
	if ($id_user) {
		return CI()->db->get_where('master_users', ['id_user' => $id_user])->row()->full_name;
	}
}
/* get id by email */
function get_id_by_email($email)
{
	$id = CI()->db->query("SELECT id_user FROM master_users WHERE email ='{$email}'")->row()->id_user;
	return $id;
}
/* get group name */
function get_group_name($id_user)
{
	$group_name = CI()->db->query("SELECT group_name FROM v_users WHERE id_user={$id_user}")->row()->group_name;
	return $group_name;
}
// Where In Array
function flatten(array $array)
{
	$return = array();
	array_walk_recursive($array, function ($a) use (&$return) {
		$return[] = $a;
	});
	return $return;
}

// Create Folder and File Modules
function create_folder_file_modules($folder)
{
	$module_name    = ucfirst($folder);
	$current_dir    = APPPATH . 'modules';
	chdir($current_dir);
	mkdir("./" . lcfirst($module_name), 0700, true);
	chdir($module_name);
	mkdir("./controllers", 0700, true);
	mkdir("./models", 0700, true);
	mkdir("./views", 0700, true);
	mkdir("./views/" . lcfirst($module_name), 0700, true);
	chdir("controllers");
	$file_controllers = fopen($module_name . ".php", "w");
	fwrite($file_controllers, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n\t* Class      : {$module_name}.php\n*/\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\nclass {$module_name} extends MY_Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t}\n}");
	fclose($file_controllers);

	chdir($current_dir . "/" . lcfirst($module_name));
	chdir("models");
	$file_models = fopen($module_name . "_model.php", "w");
	fwrite($file_models, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n\t* Class      : {$module_name}_model.php\n*/\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\nclass {$module_name}_model extends CI_Model\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t}\n}");
	fclose($file_models);

	chdir($current_dir . "/" . lcfirst($module_name));
	chdir("views/" . lcfirst($module_name));
	$file_index = fopen("index.php", "w");
	fwrite($file_index, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n*/\n?>\n");
	$file_css = fopen("css.php", "w");
	fwrite($file_css, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n*/\n?>\n");
	$file_js = fopen("js.php", "w");
	fwrite($file_js, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n*/\n?>\n");
	$file_modal = fopen("modal.php", "w");
	fwrite($file_modal, "<?php\n/**\n\t* Author     : Alfikri, M.Kom\n\t* Created By : Alfikri, M.Kom\n\t* E-Mail     : alfikri.name@gmail.com\n\t* No HP      : 081277337405\n*/\n?>\n");
	fclose($file_index);
	fclose($file_css);
	fclose($file_js);
	fclose($file_modal);
}

// Function delete folder and file
function delete_directory($dirname)
{
	$current_dir    = APPPATH . 'modules';
	chdir($current_dir);
	if (is_dir($dirname))
		$dir_handle = opendir($dirname);
	if (!$dir_handle)
		return false;
	while ($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname . "/" . $file))
				unlink($dirname . "/" . $file);
			else
				delete_directory($dirname . '/' . $file);
		}
	}
	closedir($dir_handle);
	rmdir($dirname);
}
// Fungsi Encrypt
function encrypt($str)
{
	$hasil = '';
	$kunci = '979a218e0632df2935317f98d47956c7';
	for ($i = 0; $i < strlen($str); $i++) {
		$karakter = substr($str, $i, 1);
		$kuncikarakter = substr($kunci, ($i % strlen($kunci)) - 1, 1);
		$karakter = chr(ord($karakter) + ord($kuncikarakter));
		$hasil .= $karakter;
	}
	return urlencode(base64_encode($hasil));
}
// Fungsi Decrypt
function decrypt($str)
{
	$str = base64_decode(urldecode($str));
	$hasil = '';
	$kunci = '979a218e0632df2935317f98d47956c7';
	for ($i = 0; $i < strlen($str); $i++) {
		$karakter = substr($str, $i, 1);
		$kuncikarakter = substr($kunci, ($i % strlen($kunci)) - 1, 1);
		$karakter = chr(ord($karakter) - ord($kuncikarakter));
		$hasil .= $karakter;
	}
	return $hasil;
}
// Users Theme
function theme($kategori)
{

	$result = CI()->db->get_where('users_theme', ['id_user' => id_user()]);
	if ($result->num_rows() > 0) {
		if ($kategori == "header") {
			return $result->row()->header_class;
		} else {
			return $result->row()->sidebar_class;
		}
	} else {
		return "";
	}
}

// Slug
function slug($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	// trim
	$text = trim($text, '-');
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// Upper Case
	$text = strtoupper($text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	if (empty($text)) {
		return 'n-a';
	}

	return $text;
}

function sbe_crypt($string, $action = 'E')
{
	$secret_key = 'my_simple_secret_key';
	$secret_iv = 'my_simple_secret_iv';

	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'E') {
		$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	} else if ($action == 'D') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

function bulan_global($x)
{
	$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	return $bulan[$x];
}

function jml_hari_dalam_bulan($bulan, $tahun)
{
	$kalender = CAL_GREGORIAN;
	$jml_hari = cal_days_in_month($kalender, $bulan, $tahun);
	return $jml_hari;
}
