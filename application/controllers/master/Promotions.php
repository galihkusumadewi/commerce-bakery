<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Promotions extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        $this->load->model('M_promotions', 'm_promotions');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // index
    public function index() {
        $this->tsmarty->assign("template_content", "master/promotions/index.php");
        
        $data['promotions'] = $this->m_promotions->get_list_data_promotion();
        $this->tsmarty->assign("promotions", $data['promotions']);
        
        
        // $data = $this->m_members->get_list_data_members_with_app_user();
        // $this->tsmarty->assign("members", $data);
        parent::display();
    }
    

    public function add()
    {
        $this->tsmarty->assign("template_content", "master/promotions/add.php");
        
        // $this->tsmarty->assign('cat_code', $category_code);
        
        if($this->input->post()){

            $this->form_validation->set_rules('promotion_st', 'Promotion St', 'required');

     
                if($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                    redirect('master/promotions/add');
                }  else {
                    $data = array(
                        'promotion_code' => $this->input->post('promotion_code'),
                        'promotion_name' => $this->input->post('promotion_name'),
                        'promotion_st' => $this->input->post('promotion_st'),
                        'promotion_desc' => $this->input->post('promotion_description'),
                        'created' => date('Y-m-d H:i:s'),
                        'created_by' => $this->user_data['user_id'],
                        'promotion_price' => $this->input->post('promotion_price'),
                        // 'promotion_member' => $this->input->post('promotion_member'),
                        // 'promotion_type' => $this->input->post('promotion_st'),
                        // 'promotion_product' => $this->input->post('promotion_product'),         
                    );
                    if ($_FILES['promotion_photo']['tmp_name']) {
                        $config['upload_path']          = './resource/assets-frontend/dist/promotion/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['max_size']             = 5120;
                        $config['encrypt_name']         = FALSE;
                        $config['overwrite']            = TRUE;
    
                        $this->load->library('upload', $config);
                        // $this->upload->initialize($config);
                        if ($this->upload->do_upload('promotion_photo')) {
    
                            $promotion_photo_data = $this->upload->data();
                            $promotion_photo = $promotion_photo_data['file_name'];
    
                            $data['promotion_photo'] = $promotion_photo;
                             //$old_user_photo = $user_photo;
                         
                            
                            
                            if (!empty($old_user_photo)) {
                                $old_file_path = './resource/assets-frontend/dist/promotion/' .$old_promotion_photo;
                                if (file_exists($old_file_path)) {
                                    unlink($old_file_path);                               
                                }
                            }
                            
                            
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                            
                            // redirect('member/account');
                        }
                    }

                    $this->m_promotions->add_promotion_data($data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                    redirect('master/promotions');
                    
                } 
        
        }

        parent::display();
    }

    public function edit($id)
    {
        $this->tsmarty->assign("template_content", "master/promotions/edit.php");
        $data = $this->m_promotions->get_detail_data_promotion($id);
        $old_promotion_photo = $data->promotion_photo;
        $this->tsmarty->assign('promotions', $data);
        // $data['promotion_photo'] = $promotion_photo;
        
        if($this->input->post()){

            $this->form_validation->set_rules('promotion_st', 'Promotion St', 'required');

     
                if($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                    redirect('master/promotions/add');
                }  else {
                    $data = array(
                        'promotion_code' => $this->input->post('promotion_code'),
                        'promotion_name' => $this->input->post('promotion_name'),
                        'promotion_st' => $this->input->post('promotion_st'),
                        'promotion_desc' => $this->input->post('promotion_description'),
                        'modified' => date('Y-m-d H:i:s'),
                        'modified_by' => $this->user_data['user_id'],
                        'promotion_price' => $this->input->post('promotion_price'),
                        // 'promotion_type' => $this->input->post('promotion_st'),
                        // 'promotion_product' => $this->input->post('promotion_product'),         
                    );
                    if ($_FILES['promotion_photo']['tmp_name']) {
                        $config['upload_path']          = './resource/assets-frontend/dist/promotion/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['max_size']             = 5120;
                        $config['encrypt_name']         = FALSE;
                        $config['overwrite']            = TRUE;
    
                        $this->load->library('upload', $config);
                        // $this->upload->initialize($config);
                        if ($this->upload->do_upload('promotion_photo')) {
    
                            $promotion_photo_data = $this->upload->data();
                            $promotion_photo = $promotion_photo_data['file_name'];
    
                            $data['promotion_photo'] = $promotion_photo;
                             //$old_user_photo = $user_photo;
                         
                            
                            
                            if (!empty($old_promotion_photo)) {
                                $old_file_path = './resource/assets-frontend/dist/promotion/' .$old_promotion_photo;
                                if (file_exists($old_file_path)) {
                                    unlink($old_file_path);                               
                                }
                            }
                            
                            
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                            
                            // redirect('member/account');
                        }
                    }

                    $this->m_promotions->edit_data_promotion($id, $data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                    redirect('master/promotions');
                    
                } 
            }
       
    
        parent::display();
    }

    public function detail($id)
    {

            $this->tsmarty->assign("template_content", "master/promotions/detail.php");
            $data['promotions'] = $this->m_promotions->get_detail_data_promotion($id);
            $this->tsmarty->assign("promotions", $data['promotions']);
 
        parent::display();
        
    }
    
    public function delete($id) {
        // Memanggil model untuk menghapus data promosi
            
        if ($this->m_promotions->delete_promotion_data($id)) {
            // Jika penghapusan berhasil, set pesan sukses
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
        } else {
            // Jika penghapusan gagal, set pesan error
            $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
        }
    
        // Redirect ke halaman yang sesuai
        redirect('master/promotions');
    }

   
    
    
}





                          