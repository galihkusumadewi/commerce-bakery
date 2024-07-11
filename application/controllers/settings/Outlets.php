<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Outlets extends ApplicationBase {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('M_outlets', 'm_outlets');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function index() {
        $this->tsmarty->assign("template_content", "settings/outlets/index.html");
        // get data
        $data = $this->m_outlets->get_list_data_outlets();
        $this->tsmarty->assign("outlets", $data);
        parent::display();
    }

    private function generate_kode()
    {
        $max_code = $this->m_outlets->get_last_outlet_sequence();

        // Calculate the new sequence
        if ($max_code) {
            $next_number = intval(substr($max_code, -4)) + 1;
        } else {
            $next_number = 1000;
        }

        // Generate the outlet code
        $prefix = 'OUT';
        $kode = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);
        return $kode;
    }

    public function add() {
        $this->tsmarty->assign("template_content", "settings/outlets/add.html");
        $outlet_code = $this->generate_kode();
        $this->tsmarty->assign('outlet_code', $outlet_code);
        
        if  ($this->input->post()) {
            $this->form_validation->set_rules('outlet_code', 'Kode Outlet', 'required');
            $this->form_validation->set_rules('outlet_name', 'Nama Outlet', 'required');
            $this->form_validation->set_rules('outlet_address', 'Alamat', 'required');
            $this->form_validation->set_rules('kota', 'Kota', 'required');
            $this->form_validation->set_rules('outlet_phone', 'Telepon', 'required');
            $this->form_validation->set_rules('outlet_status', 'Status', 'required');
            $this->form_validation->set_rules('outlet_highlight', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                redirect('settings/outlets/add');
            } else {
                if ($this->input->post()) {
                    //jika foto di upload
                    if ($_FILES['outlet_photo']['tmp_name']) {
                        $config['upload_path']          = './resource/assets-frontend/dist/outlet/';
                        $config['allowed_types']        = 'gif|jpg|png|PNG|jpeg';
                        $config['max_size']             = 3000;
                        $config['encrypt_name']         = TRUE;
                        $config['overwrite']            = TRUE;

                        $this->load->library('upload', $config);
                        
                        if ($this->upload->do_upload('outlet_photo')) {

                            $outlet_photo_data = $this->upload->data();
                            $outlet_photo = $outlet_photo_data['file_name'];
                            // Jika validasi berhasil, tambahkan produk ke database
                            $data = array(
                                'outlet_code' =>$this->input->post('outlet_code'),
                                'outlet_name' => $this->input->post('outlet_name'),
                                'outlet_status' => $this->input->post('outlet_status'),
                                'outlet_address' => $this->input->post('outlet_address'),
                                'kota' => $this->input->post('kota'),
                                'outlet_phone' => $this->input->post('outlet_phone'),
                                'outlet_photo' => $outlet_photo,
                                'outlet_highlight' => $this->input->post('outlet_highlight'),
                                'created' => date('Y-m-d H:i:s'),
                                'created_by' => $this->user_data['user_id'],
                            );

                            $this->m_outlets->add_data_outlets($data);
                            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                            redirect('settings/outlets');

                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error upload foto'));
                            redirect('settings/outlets/add');
                    }
                }

                } else { 
                    //tidak upload foto  
                    $data = array(
                        'outlet_code' =>$this->input->post('outlet_code'),
                        'outlet_name' => $this->input->post('outlet_name'),
                        'outlet_status' => $this->input->post('outlet_status'),
                        'outlet_address' => $this->input->post('outlet_address'),
                        'kota' => $this->input->post('kota'),
                        'outlet_phone' => $this->input->post('outlet_phone'),
                        'outlet_highlight' => $this->input->post('outlet_highlight'),
                        'created' => date('Y-m-d H:i:s'),
                        'created_by' => $this->user_data['user_id'],
                    );
                    $this->m_outlets->add_data_outlets($data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                    redirect('settings/outlets');
                }
            }
        }

        parent::display();
    }


    
    public function delete($id) {
        $outlet = $this->m_outlets->get_detail_outlets($id); // Get outlet data
        
        if ($outlet && isset($outlet['outlet_photo'])) {
            $this->m_outlets->delete_data_outlets($id);
        
            $file_path = FCPATH . './resource/assets-frontend/dist/outlet/' . $outlet['outlet_photo'];
        
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    echo "File {$outlet['outlet_photo']} berhasil dihapus.";
                } else {
                    echo "Gagal menghapus file {$outlet['outlet_photo']}.";
                }
            } else {
                echo "File {$outlet['outlet_photo']} tidak ditemukan.";
            }
        } elseif ($outlet) {
            // Jika tidak ada properti 'file_name'
            echo "Outlet dengan ID $id tidak memiliki informasi file.";
        } else {
            echo "Outlet dengan ID $id tidak ditemukan.";
        }
        
        $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
        redirect('settings/outlets');
    }
    

    public function edit($id) {
        $this->tsmarty->assign("template_content", "settings/outlets/edit.html");
        $outlet_code = $this->generate_kode();
        $data = $this->m_outlets->get_detail_outlets($id);
        $old_outlet_pict = $data['outlet_photo'];
        $this->tsmarty->assign('outlet_code', $outlet_code);
        $this->tsmarty->assign('outlet', $data);
    
        if ($this->input->post()) {
            //jika foto di upload
            if ($_FILES['outlet_photo']['tmp_name']) {
                $config['upload_path'] = './resource/assets-frontend/dist/outlet/';
                $config['allowed_types'] = 'gif|jpg|png|PNG|jpeg';
                $config['max_size'] = 3000;
                $config['encrypt_name'] = TRUE;
                $config['overwrite'] = TRUE;
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('outlet_photo')) {
                    $outlet_photo_data = $this->upload->data();
                    $outlet_photo = $outlet_photo_data['file_name'];
    
    
                    // Jika validasi berhasil, tambahkan produk ke database
                    $data = array(
                        'outlet_code' => $this->input->post('outlet_code'),
                        'outlet_name' => $this->input->post('outlet_name'),
                        'outlet_status' => $this->input->post('outlet_status'),
                        'outlet_address' => $this->input->post('outlet_address'),
                        'kota' => $this->input->post('kota'),
                        'outlet_phone' => $this->input->post('outlet_phone'),
                        'outlet_highlight' => $this->input->post('outlet_highlight'),
                      
                        'modified' => date('Y-m-d H:i:s'),
                        'modified_by' => $this->user_data['user_id'],
                    );

                    $data['outlet_photo'] = $outlet_photo;

                    
                    // temukan di folder dengan nama file
                    if (!empty($old_outlet_pict)) {
                        $old_file_path = './resource/assets-frontend/dist/outlet/' . $old_outlet_pict;
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                    }
    
                    $this->m_outlets->edit_data_outlets($id, $data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
                    redirect('settings/outlets');
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error upload foto'));
                    redirect('settings/outlet/edit');
                }


            } else { 
                //tidak upload foto  
                $data = array(
                    'outlet_code' =>$this->input->post('outlet_code'),
                    'outlet_name' => $this->input->post('outlet_name'),
                    'outlet_status' => $this->input->post('outlet_status'),
                    'outlet_address' => $this->input->post('outlet_address'),
                    'kota' => $this->input->post('kota'),
                    'outlet_phone' => $this->input->post('outlet_phone'),
                    'outlet_highlight' => $this->input->post('outlet_highlight'),
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->user_data['user_id'],
                );
                $this->m_outlets->edit_data_outlets($id, $data);
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
                redirect('settings/outlets');
            }
        }
    
        parent::display();
    }
    

    public function detail($id) {
        $this->tsmarty->assign("template_content", "settings/outlets/show.html");
        // get data
        $data['outlet'] = $this->m_outlets->get_detail_outlets($id);
        $this->tsmarty->assign("outlet", $data['outlet']);
        parent::display();
    }
    
}