<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_chart extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('settings/M_chart', 'm_chart');
    }

    public function ambilDataProdukByDate($startDate, $endDate) {
        // $startDate = '2024-01-06';
        // $endDate = '2024-01-06';
        $this->db->select('data_product.product_id, data_product.product_name, SUM(purchase_history_details.product_qty) AS total_qty, purchase_history_details.created');
        $this->db->from('data_product');
        $this->db->join('purchase_history_details', 'data_product.product_id = purchase_history_details.product_id');
        $this->db->group_by('data_product.product_id');
        $this->db->where('purchase_history_details.created >=', $startDate);
        $this->db->where('purchase_history_details.created <=', $endDate);
        $query = $this->db->get();
    
        return $query->result_array();
    }
    



    public function updateChart() {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
      
        // Gunakan model untuk melakukan pemfilteran data berdasarkan tanggal
        $filteredData = $this->m_chart->ambilDataProdukByDate($startDate, $endDate);
    
        $filteredDataJson = json_encode($filteredData);
    
        $this->output
             ->set_content_type('application/json')
             ->set_output($filteredDataJson);
    }
    
    
    

// public function getInfoProduk(){
//     // Pilih kolom DISTINCT product_id dan product_name dari data_product
//     $this->db->select('DISTINCT(data_product.product_id), data_product.product_name');
//     $this->db->from('data_product');
//     $this->db->join('purchase_history_details', 'data_product.product_id = purchase_history_details.product_id');
//     $query = $this->db->get();
//     if ($query) {
//         return $query->result_array();
//     } else {
//         return false;
//     }
// }
    
}