<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Data extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('settings/M_users', 'm_users');
        $this->load->model('apps/M_account', 'm_account');
        $this->load->model('settings/M_chart', 'm_chart');
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "users/profile.html");
        // user id
        $user_id = $this->user_data['user_id'];
        // save data
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('user_alias', 'Fullname', 'trim|required');
            $this->form_validation->set_rules('user_name', 'Username', 'trim|required');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('user_pass', 'Password', 'trim');
            $this->form_validation->set_rules('user_pass_verif', 'Password', 'trim');
            $this->form_validation->set_rules('user_photo', 'photo', 'trim');
            if ($this->form_validation->run() !== FALSE) {
                $data = [
                    'user_alias' => $this->input->post('user_alias'),
                    'user_name' => $this->input->post('user_name'),
                    'user_email' => $this->input->post('user_name'),
                ];
                $user_pass = $user_key = NULL;
                if(!empty($this->input->post('user_pass'))){
                    if($this->input->post('user_pass') != $this->input->post('user_pass_verif')) {
                        $this->session->set_flashdata('message', array('msg' => 'Verifikasi password berbeda dengan password baru.', 'status' => 'error'));
                        redirect(site_url('administrator/profile'));
                    } else {
                        // load encrypt
                        $this->load->library('encrypt');
                        $user_key = $this->m_account->rand_key(8);
                        $this->encryption->initialize(
                            array(
                                    'cipher' => 'aes-256',
                                    'mode' => 'ctr',
                                    'key' => $user_key
                            )
                        );
                        $user_pass = $this->encryption->encrypt(md5($this->input->post('user_pass')));
                        // -- encode($msg, $key);
                        $data['user_key'] = $user_key;
                        $data['user_pass'] = $user_pass;
                    }
                }

                if($_FILES['user_photo']['tmp_name'] !== '') {
                    // upload image
                    $config['upload_path']          = './resource/assets/default/images/uploads/users';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['file_name']            = $user_id . '.png';
                    $config['overwrite']            = TRUE;
                    $config['width']                = 70; 
                    $config['height']               = 70; 

                    $this->load->library('upload', $config);
                    if (!$this->upload->resize('user_photo')){
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                    }
                    else {
                        $data_upload = $this->upload->data();
                        $data['user_photo'] = $data_upload['file_name'];
                    }
                } 

                if($this->m_users->update_user_data($this->input->post('user_id'), $data)) {
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan', 'status' => 'success'));
                } else {
                    $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                }
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
            }
            redirect(site_url('administrator/profile'));
        }
        // output
        parent::display();
    }
      // user dashboard
      public function dashboard() {
        // Set template content
        $this->tsmarty->assign("template_content", "users/dashboard.html");
        
    
        // Ambil tanggal mulai dan tanggal akhir dari permintaan POST atau dari parameter lainnya
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
    
        if (!$startDate || !$endDate) {
            // Jika tanggal tidak tersedia, atur tanggal awal dan akhir ke nilai default atau ke tanggal lain sesuai kebutuhan
            $startDate = '2000-01-01';
            $endDate = '2045-01-07';
        }
    
        // Ambil data produk dengan pemfilteran tanggal
        $data_produk = $this->m_chart->ambilDataProdukByDate($startDate, $endDate);
    
        $data_produk_json = json_encode($data_produk);
    
        $this->tsmarty->assign('data_produk', $data_produk);
    
        parent::display();
    }
    
    

    // public function updatechart(){
    
        
             
    //          $startDate = $this->input->post('startDate');
    //          $endDate = $this->input->post('endDate');
    //          $data_produk = $this->m_chart->ambilDataProdukByDate($startDate, $endDate);
              
    //          $response = [
    //              'dataNew' => $data_produk
    //          ];
    //          // Kirim data produk sebagai respons JSON
    //          echo json_encode($response);
             
        
    // }
    
    

   
      
    // public function tampilkanGrafik() {
    //     // Ambil data produk dari database menggunakan model CodeIgniter
    //     // Gantilah 'nama_model' dengan nama model Anda

    //     // Kirim data produk ke tampilan Smarty
    //     $this->smarty->assign('data_produk', $data_produk);
        

    //     // Tampilkan tampilan Smarty yang berisi grafik
    //     parent::display();
    // }
    
    
    }