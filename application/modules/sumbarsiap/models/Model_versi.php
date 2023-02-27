<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_versi extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function init_check_version()
  {
    $query = $this->db->query("SELECT 
                                        *
      from 
      _version
      ORDER BY no DESC
      LIMIT 1
      ");
    return $query->result_array();
  }


  public function init_permit_version($version_code, $version_name)
  {
    $data = $this->db->query("SELECT 
      COUNT(*) as no
      from 
      _version
      WHERE
      version_code = '$version_code' AND
      version_name = '$version_name'
      ");

    return $data->row()->no;
  }

  public function init_insert_version()
  {
    date_default_timezone_set("Asia/Bangkok");
    $created_date = date('Y-m-d H:i:s');

    $package_app            = $this->input->post('package_app');
    $version_code           = $this->input->post('version_code');
    $version_name           = $this->input->post('version_name');
    $status                 = 1;
    $prioritas              = 0;

    $this->db->trans_start();

    $this->db->set('package_app',$package_app);
    $this->db->set('version_code',$version_code);
    $this->db->set('version_name',$version_name);
    $this->db->set('created_date',$created_date);
    $this->db->set('status',$status);
    $this->db->set('prioritas',$prioritas);
    $this->db->insert('_version');
    
    $this->db->trans_complete();

    if ($this->db->trans_status()==false)
    {
      $this->db->trans_rollback();
      $this->error();
      return FALSE;
    }
    else
    {
      $this->db->trans_commit();
      return TRUE;
    }         
    
  }
	
}

// This is the end of auth signin model
