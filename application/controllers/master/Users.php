<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Users extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('settings/M_users', 'm_users');
        $this->load->model('apps/M_account', 'm_account');
        $this->load->library('form_validation'); 
        $this->load->library('session');
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "master/users/index.html");
        // get data
        $data = $this->m_users->get_list_data_users($this->app_portal['site_id']);
        $this->tsmarty->assign("users", $data);
        // output
        parent::display();
    }

    public function add() {
        $this->tsmarty->assign("template_content", "master/users/add.html");
        $roles['roles'] = $this->m_users->get_all_roles();
        $this->tsmarty->assign("roles", $roles['roles']);
    
        if ($this->input->post()) {
            $this->load->library('encryption');
            $user_key = $this->m_account->rand_key(8);
            $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => $user_key
                )
            );
            $user_pass = $this->encryption->encrypt(md5($this->input->post('password')));
    
            $dataa = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email'),
                'user_st' => $this->input->post('user_st'),
                'user_alias'=>$this->input->post('fullname'),
                'user_pass' => $user_pass,
                'user_key' => $user_key,
                'user_code' => '201' . $this->m_users->get_user_last_code(array('201'))
            );
            
            if ($_FILES['user_photo']['tmp_name']) {
                $config['upload_path'] = './resource/assets/images/user/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = FALSE;
                $config['overwrite'] = TRUE;
            
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('user_photo')) {
                    $user_photo_data = $this->upload->data();
                    $user_photo = $user_photo_data['file_name'];
            
                    $dataa['user_photo'] = $user_photo;
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                    redirect('master/users'); 
                }
            }
            
            $this->m_users->saveUser($dataa);
            
    
            // Mengambil user_id yang baru saja di-generate
            $user_id = $this->db->insert_id();
    
            $data_role = array(
                'role_id' => $this->input->post('user_role'),
                'role_default' => $this->input->post('user_role'),
                'user_id' => $user_id
            );
    
            // Menyimpan data role ke tabel app_role_user menggunakan model M_Role_User
            
            $this->m_users->saveRoleUser($data_role);

           
    
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
            redirect('master/users');
        }
    
        parent::display();
    }
    

    public function edit($id) {
        $this->tsmarty->assign("template_content", "master/users/edit.html");

        $role['role'] = $this->m_users->get_all_roles();
        $this->tsmarty->assign('role', $role['role']);

        // $data['data'] = $this->m_users->get_all_roles_id($id);
        // $this->tsmarty->assign('data', $data['data']);
        
        // print_r($data);exit();
        // $data = $this->m_users->get_detail_data_user($user_id);
        $roles['roles'] = $this->m_users->get_detail_data_user($id);
        $old_user_photo = $roles['roles']->user_photo;

        // print_r($roles);exit();
        $this->tsmarty->assign('roles', $roles['roles']);
    
        if ($this->input->post()) {
            $this->load->library('encryption');
            $user_key = $this->m_account->rand_key(8);
            $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => $user_key
                )
            );
            $user_pass = $this->encryption->encrypt(md5($this->input->post('password')));
    
            $dataa = array(
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('email'),
                'user_st' => $this->input->post('user_st'),
                'user_alias'=>$this->input->post('fullname'),
                'user_pass'=>$user_pass,
                'user_key'=>$user_key
                
                
            );
            
            if ($_FILES['user_photo']['tmp_name']) {
                $config['upload_path'] = './resource/assets/images/user/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = FALSE;
                $config['overwrite'] = TRUE;
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('user_photo')) {
                    $user_photo_data = $this->upload->data();
                    $user_photo = $user_photo_data['file_name'];
            
                    $dataa['user_photo'] = $user_photo;

                    if (!empty($old_user_photo)) {
                        $old_file_path = './resource/assets-frontend/dist/promotion/' .$old_user_photo;
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);                               
                        }
                    }

                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                    redirect('master/users'); 
                }
            }
            $this->m_users->edit_data_user($id, $dataa);
            // Mengambil user_id yang baru saja di-generate
           
    
            $data_role = array(
                'role_id' => $this->input->post('user_role'),
                'role_default' => $this->input->post('user_role'),
                
            );
    
            // Menyimpan data role ke tabel app_role_user menggunakan model M_Role_User
            
            $this->m_users->edit_data_role_user($id,$data_role);

           
            
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
            redirect('master/users');
        }
    
        parent::display();
    }

    public function detail($id)
    {
        $this->tsmarty->assign("template_content", "master/users/detail.html");
        $data['roles'] = $this->m_users->get_detail_data_user($id);
        $this->tsmarty->assign("roles", $data['roles']);

       
    
        parent::display();
    }

    public function delete($id)
{
    if ($this->m_users->delete_user_by_id($id)) {

        $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
       
    } else {

        $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
    }
    
    redirect('master/users');
}

}