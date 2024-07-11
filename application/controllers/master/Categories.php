<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Categories extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('M_categories', 'm_categories');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "master/categories/index.html");
        // get data
        $this->load->model('M_categories');
        $data = $this->M_categories->get_list_data_categories();
        $this->tsmarty->assign("categories", $data);
        // output
        parent::display();
    }


    private function generate_kode()
    {
        $max_code = $this->m_categories->get_last_categories_sequence();

        // Calculate the new sequence
        if ($max_code) {
            $next_number = intval(substr($max_code, -4)) + 1;
        } else {
            $next_number = 1000;
        }


        // Generate the product code
        $prefix = 'CAT';
        $kode = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);
        return $kode;
    }

    public function add()
    {
        // set template content
        $this->tsmarty->assign("template_content", "master/categories/add.html");
        $category_code = $this->generate_kode();
        $this->tsmarty->assign('cat_code', $category_code);
        
            if($this->input->post()){
                $this->form_validation->set_rules('cat_name', 'Nama Kategori', 'required');
                $this->form_validation->set_rules('cat_st', 'Status', 'required');
         
                    if($this->form_validation->run() == FALSE){
                        $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                        redirect('master/categories/add');
                    }  else {
                        $data = array(
                            'cat_code' =>$this->input->post('cat_code'),
                            'cat_name' => $this->input->post('cat_name'),
                            'cat_st' => $this->input->post('cat_st'),
                            'created_by' => $this->user_data['user_id'],
                        );
                        $this->m_categories->add_categories_data($data);
                        $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                        redirect('master/categories');
                    } 
                // Redirect atau tampilkan pesan sukses
            }
         // output
         parent::display();
    }

    public function delete($id) {
        $this->load->model('M_categories');
        
        if ($this->m_categories->delete_categories_data($id)) {
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
        } else {
            $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
        }
        
        redirect('master/categories');
    }

    public function detail($id){
        // set template content
      
        $this->tsmarty->assign("template_content", "master/categories/show.html");
        // get data
        $data['category'] = $this->m_categories->get_detail_categories($id);
        $this->tsmarty->assign("categories", $data['category']);
        parent::display();
    }

    public function edit($id) {
        // Menampilkan halaman edit
        $this->tsmarty->assign("template_content", "master/categories/edit.html");
        $data = $this->m_categories->get_detail_categories($id);
        $this->tsmarty->assign('category', $data);
    
        if($this->input->post()){
            $this->form_validation->set_rules('cat_name', 'Nama Kategori', 'required');
            $this->form_validation->set_rules('cat_st', 'Status', 'required');
     
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                redirect('master/categories/add');
            }  else {
                $data = array(
                    
                    'cat_name' => $this->input->post('cat_name'),
                    'cat_st' => $this->input->post('cat_st'),
                    'modified_by' => $this->user_data['user_id'],
                );
                $this->m_categories->edit_data_categories($id, $data);
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                redirect('master/categories');
            }
            // Redirect atau tampilkan pesan sukses
        }
     // output
     parent::display();
    }
    
}