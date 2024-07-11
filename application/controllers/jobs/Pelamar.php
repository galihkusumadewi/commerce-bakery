<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once(APPPATH . 'controllers/base/PrivateBase.php');

// --
class Pelamar extends ApplicationBase
{

    // constructor
    public function __construct()
    {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('M_jobs', 'm_jobs');
        $this->load->library('form_validation');
        $this->load->library('session');
    }


    public function index()
    {
        // set template content
        $this->tsmarty->assign("template_content", "settings/pelamar/index.php");


        // get data
        $data['pelamar'] = $this->m_jobs->list_pelamar();

        // return var_dump($data['pelamar']);
        // die;

        $this->tsmarty->assign('pelamar', $data['pelamar']);

        parent::display();
    }

    public function whatsapp($id)
    {
        $pelamar = $this->m_jobs->getPelamar($id);
        // var_dump($latestName['nama_lengkap']);

        $message = 'Hi.. ' . $pelamar->nama_lengkap . ', 
Kami dari HRD Kenes Bakery & Resto menyampaikan bahwa lamaran anda telah kami terima dan anda LOLOS seleksi administrasi.

Berikut jadwal tes,
Hari : 
Tanggal : 
Jam : 
Tempat : Jl. Wijayakusuma No. 301, Sinduadi, Mlati, Sleman (Sebelah utara Aster Homestay)
Maps : https://goo.gl/maps/UV3eLgVbWDmfFdig8

Harap isi link berikut untuk konfirmasi kehadiran.
https://forms.gle/QPLbJ39npxkVv7Hd8';

        // Buat URL WhatsApp
        $whatsappUrl = 'https://wa.me/send?phone=' . urlencode($pelamar->phone) . '&text=' . rawurlencode($message);
        header("Location: " . $whatsappUrl);
    }


    public function download($id)
    {
        $file_info = $this->m_jobs->detail_pelamar($id);
        if (!$file_info) {
            echo "File not found.";
            return;
        }

        $file_path = FCPATH . './resource/assets-frontend/dist/pelamar/dokumen/' . $file_info['upload_cv'];

        // Periksa apakah file ada
        if (file_exists($file_path)) {
            // Mengatur header HTTP untuk proses download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
        } else {
            // Jika file tidak ditemukan, tampilkan pesan error
            echo "File not found.";
        }
    }

    public function add()
    {
        $this->tsmarty->assign("template_content", "settings/pelamar/add.php");

        parent::display();
    }


    public function detail($id)
    {
        $this->tsmarty->assign("template_content", "settings/pelamar/detail.php");
        $data['detail_pelamar'] = $this->m_jobs->detail_pelamar($id);
        $this->tsmarty->assign("detail_pelamar", $data['detail_pelamar']);
        parent::display();
    }


    public function edit()
    {
        $this->tsmarty->assign("template_content", "settings/pelamar/edit.php");

        parent::display();
    }

    public function delete($id)
    {
        $pelamar = $this->m_jobs->detail_pelamar($id);

        if (!$pelamar) {
            echo "Pelamar dengan ID $id tidak ditemukan.";
        } else {
            if (isset($pelamar['foto_pelamar'])) {
                $photo_path = FCPATH . './resource/assets-frontend/dist/pelamar/foto/' . $pelamar['foto_pelamar'];
                if (file_exists($photo_path)) {
                    if (unlink($photo_path)) {
                        echo "File foto {$pelamar['foto_pelamar']} berhasil dihapus.";
                    } else {
                        echo "Gagal menghapus file foto {$pelamar['foto_pelamar']}.";
                    }
                } else {
                    echo "File foto {$pelamar['foto_pelamar']} tidak ditemukan.";
                }
            }

            if (isset($pelamar['upload_cv'])) {
                $cv_path = FCPATH . './resource/assets-frontend/dist/pelamar/dokumen/' . $pelamar['upload_cv'];
                if (file_exists($cv_path)) {
                    if (unlink($cv_path)) {
                        echo "File CV {$pelamar['upload_cv']} berhasil dihapus.";
                    } else {
                        echo "Gagal menghapus file CV {$pelamar['upload_cv']}.";
                    }
                } else {
                    echo "File CV {$pelamar['upload_cv']} tidak ditemukan.";
                }
            }

            $this->m_jobs->delete_pelamar($id);

            $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
            redirect('jobs/pelamar');
        }
    }
}
