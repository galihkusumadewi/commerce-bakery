<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Job extends ApplicationBase {

    function __construct() {
        parent::__construct();
        $this->load->model('M_jobs', 'm_jobs');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function index() {
        $this->tsmarty->assign("template_content", "settings/job/index.html");
        // get data
        $data = $this->m_jobs->get_list_data_jobs();
        $this->tsmarty->assign("job", $data);
        parent::display();
    }

    public function add() {
        $this->tsmarty->assign("template_content", "settings/job/add.html");
        $this->load->model('m_jobs');

        if ($this->input->post()) {
            $this->form_validation->set_rules('job_name', 'Job Name', 'required');
            $this->form_validation->set_rules('job_description', 'Deskripsi Job', 'required');
            $this->form_validation->set_rules('job_date', 'Job Date', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('msg' => 'Data Gagal Ditambahkan', 'status' => 'error'));
                redirect('jobs/job/add');
            } else {
                if ($this->input->post()) 
                    if ($_FILES['job_img']['tmp_name']) {
                        $config['upload_path']          = './resource/assets-frontend/dist/loker/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['max_size']             = 2048;
                        $config['encrypt_name']         = TRUE;
                        $config['overwrite']            = TRUE;

                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('job_img')) {
                            $job_pict_data = $this->upload->data();
                            $job_img = $job_pict_data['file_name'];

                            $data = array(
                                'job_name' => $this->input->post('job_name'),
                                'job_description' => $this->input->post('job_description'),
                                'job_date' => $this->input->post('job_date'),
                                'job_img' => $job_img,
                            );

                            $this->m_jobs->add_job($data);
                            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                            redirect('jobs/job');
        
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                            redirect('jobs/job');
                        }

                } else {
                    //Tidak upload foto
                    $data = array(
                        'job_name' => $this->input->post('job_name'),
                        'job_description' => $this->input->post('job_description'),
                        'job_date' => date('Y-m-d H:i:s'),
                    );

                    $this->m_jobs->add_job($data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                   
                    redirect('jobs/job');
                }
            } 
        }
        parent::display();
    }

    public function delete($id) {
        $job = $this->m_jobs->get_detail_job($id); // Get job data
        
        if ($job) {
            // Hapus data job terlepas dari apakah ada foto atau tidak
            $this->m_jobs->delete_data_job($id);
    
            if (isset($job['job_img'])) {
                $file_path = FCPATH . './resource/assets-frontend/dist/loker/' . $job['job_img'];
    
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        echo "File {$job['job_img']} berhasil dihapus.";
                    } else {
                        echo "Gagal menghapus file {$job['job_img']}.";
                    }
                } else {
                    echo "File {$job['job_img']} tidak ditemukan.";
                }
            } else {
                // Jika tidak ada properti 'job_img'
                echo "Job dengan ID $id tidak memiliki informasi file.";
            }
        } else {
            echo "Job dengan ID $id tidak ditemukan.";
        }
        
        $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
        redirect('jobs/job');
    }

    public function edit($id) {
        $this->tsmarty->assign("template_content", "settings/job/edit.html");
        $data = $this->m_jobs->get_detail_job($id);
        $old_job_pict = $data['job_img'];
        $this->tsmarty->assign('job', $data);
    
        if ($this->input->post()) {
            // Jika foto diunggah
            if ($_FILES['job_img']['tmp_name']) {
                $config['upload_path']          = './resource/assets-frontend/dist/loker/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 2048;
                $config['encrypt_name']         = TRUE;
                $config['overwrite']            = TRUE;
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('job_img')) {
                    $job_pict_data = $this->upload->data();
                    $job_img = $job_pict_data['file_name'];
    
                    $data = array(
                        'job_name' => $this->input->post('job_name'),
                        'job_description' => $this->input->post('job_description'),
                        'job_date' => date('Y-m-d H:i:s'),
                        'job_img' => $job_img,
                    );
    
                    // Hapus gambar lama jika ada
                    if (!empty($old_job_pict)) {
                        $old_file_path = './resource/assets-frontend/dist/loker/' . $old_job_pict;
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                    }
    
                    $this->m_jobs->edit_data_job($id, $data);
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
                    redirect('jobs/job');
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error upload foto'));
                    redirect('jobs/job');
                }
            } else { 
                // Tidak mengunggah foto  
                $data = array(
                    'job_name' => $this->input->post('job_name'),
                    'job_description' => $this->input->post('job_description'),
                    'job_date' => $this->input->post('job_date'),
                );
    
                $this->m_jobs->edit_data_job($id, $data);
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
                redirect('jobs/job');
            }
        }
        parent::display();
    }   
    
    public function detail($id) {
        $this->tsmarty->assign("template_content", "settings/job/show.html");
        // get data
        $data['job'] = $this->m_jobs->get_detail_job($id);
        $this->tsmarty->assign("job", $data['job']);
        parent::display();
    }

}
