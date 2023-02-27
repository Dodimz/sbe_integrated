<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
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
        if (empty($this->session->userdata('email'))) {
            $data['title']        = "Login";
            $page                 = 'auth/auth';
            $data['extra_css']    = $this->load->view('auth/css', $data, true);
            $data['extra_js']    = $this->load->view('auth/js', $data, true);
            $this->template->load('auth_template', $page, $data);
        } else {
            redirect('dashboard');
        }
    }

    public function beranda()
    {
            $this->load->view('homepage');
        
    }

    public function login()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output     = ['status' => false, 'message' => ''];
            $auth       = $this->auth_model;
            $validation = $this->form_validation;
            $validation->set_rules($auth->rules());

            if ($validation->run()) {
                $login = $auth->login();
                $output['status']   = $login['status'];
                $output['message']  = $login['message'];
            } else {
                $output['status']   = false;
                foreach ($_POST as $key => $value) {
                    $output['validation'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }

    public function logout()
    {
        $this->auth_model->logout();
    }
}
