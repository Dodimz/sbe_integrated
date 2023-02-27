<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Helpdesk_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk_model extends CI_Model
{
	public function get_helpdesk()
	{
		$q  = $this->db->query("SELECT
									ug.id_user,
									mu.full_name,
									mu.username,
									COUNT( hi.id_instansi ) AS jml_instansi 
								FROM
									users_groups ug
									LEFT JOIN master_users mu ON ug.id_user = mu.id_user
									LEFT JOIN helpdesk_instansi hi ON ug.id_user = hi.id_user 
								WHERE
									ug.id_group = 4 
									AND ug.id_instansi = 91 
								GROUP BY
									ug.id_user"
							  );
		return $q;
	}

	public function get_opd()
	{
		$q  = $this->db->query("SELECT
									mi.id_instansi,
									mi.kode_opd,
									mi.nama_instansi 
								FROM
									master_instansi mi 
								WHERE
									kategori = 'OPD' 
									AND is_active =1
									AND id_instansi NOT IN (SELECT id_instansi FROM helpdesk_instansi)"
							  );
		return $q;
	}

	public function save($data)
	{
		return $this->db->insert('helpdesk_instansi', $data);
	}

	public function delete($id_helpdesk_instansi)
	{
		return $this->db->delete('helpdesk_instansi', ['id_helpdesk_instansi' => $id_helpdesk_instansi]);	
	}
}