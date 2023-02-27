<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Setup_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_Model
{
	public function save($table,$data)
    {
        $this->db->insert($table,$data);
        return $this->db->affected_rows();
    }
}