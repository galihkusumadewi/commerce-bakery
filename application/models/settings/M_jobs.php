<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_jobs extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_list_data_jobs()
    {
        $query = $this->db->get('job');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_list_data_jobs_active()
    {
        $today = date("Y-m-d H:i:s");

        $this->db->where('job_date >=', $today);
        $query = $this->db->get('job');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    public function add_job($data)
    {
        return $this->db->insert('job', $data);
    }

    public function get_detail_job($id)
    {
        $query = $this->db->get_where('job', array('job_id' => $id));
        return $query->row_array(); // Mengembalikan satu baris hasil
    }

    function delete_data_job($id)
    {
        $this->db->where('job_id', $id);
        $this->db->delete('job');
    }

    public function edit_data_job($id, $data)
    {
        $this->db->where('job_id', $id);
        $this->db->update('job', $data);
    }

    public function lamar_job($data)
    {
        return $this->db->insert('member_job', $data);
    }

    public function detail_pelamar($id)
    {
        $query = $this->db->get_where('member_job', array('id_pelamar' => $id));
        return $query->row_array();
    }
    public function list_pelamar()
    {
        $this->db->select('member_job.nama_lengkap, member_job.id_pelamar, member_job.job_id, job.job_name, member_job.phone');
        $this->db->from('member_job');
        $this->db->join('job', 'member_job.job_id = job.job_id', 'left');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function delete_pelamar($id)
    {
        $this->db->where('id_pelamar', $id);
        $this->db->delete('member_job');
    }

    public function getPelamar($id)
    {
        $this->db->select('*');
        $this->db->where('id_pelamar', $id);
        $query = $this->db->get('member_job');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return null; // Jika tidak ada data yang sesuai
        }
    }

    public function getWhatsAppNumber($id)
    {

        $this->db->select('phone');
        $this->db->where('id_pelamar', $id);
        $query = $this->db->get('member_job');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->phone;
        } else {
            return null; // Nomor WhatsApp tidak ditemukan
        }
    }
}
