<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : MY_Form_validation.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	public $CI;
	
    function run($module = '', $group = '')
    {
       (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }
}