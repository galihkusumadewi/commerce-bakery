<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once(APPPATH . 'controllers/base/MemberBase.php');

// --
class Login extends ApplicationBase
{

    // constructor
    public function __construct()
    {
        // parent constructor
        parent::__construct();

        // load model
        $this->load->model('settings/M_users', 'M_users');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->library('session');
    }

    // dashboard
    public function index()
    {
        // set template content
        $this->tsmarty->assign("template_content", "member/login.html");
        parent::display();
    }


    public function login_member()
    {
        // $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('public/login');
        } else {
            $email = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->M_users->check_login($email, $password);

            if ($user) {
                // Set session data and redirect to dashboard or home page
                $this->session->set_userdata('member', $user);



                // $this->user_data = $this->session->userdata('member');
                // echo "<pre>";
                // print_r($this->user_data);
                // echo "</pre>";
                redirect('/');
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Login gagal Username dan Password tidak sesuai.', 'status' => 'error'));
                redirect('/login');

                // $this->tsmarty->assign("template_content", "public/login.html");
                // parent::display();
            }
        }
    }



    // Logout
    public function logout()
    {

        $this->session->unset_userdata('member');
        $this->tsmarty->clearAssign('member');
        $this->session->set_flashdata('message', array('msg' => 'Logout berhasil', 'status' => 'success'));

        redirect('/login');
    }

    // forgotPassword
    // public function forgot_password() {
    //     // set template content
    //     $this->tsmarty->assign("template_content", "member/forgot_password.html");
    //     parent::display();
    // }
}
