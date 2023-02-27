<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (identitas() != true) {
            redirect('setup', 'refresh');
        }
        $this->load->model('auth/auth_model', 'auth_model');
    }

   
    public function index()
    {
           $data['title']        = "Login";
            $page                 = 'beranda/index';
            
            $data['extra_css']    = $this->load->view('beranda/css', $data, true);
            $data['extra_js']    = $this->load->view('beranda/js', $data, true);
            $this->template->load('homepage', $page, $data);
        
    }

   
}
