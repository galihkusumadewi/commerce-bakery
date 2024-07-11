<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once(APPPATH . 'controllers/base/PublicBase.php');

// --
class products extends ApplicationBase
{

    // constructor
    public function __construct()
    {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('M_products', 'm_products');
        $this->load->library('session');
        $this->load->library('pagination');
    }

    // dashboard
    public function index()

    {
        $sort = $this->input->get('sort');


        // $total_row = $this->m_products->countAllProducts();
        // $config['base_url'] = base_url('products'); // Ganti dengan URL yang sesuai
        // $config['total_rows'] = $total_row; // Ganti dengan jumlah total data yang ingin Anda tampilkan
        // $config['per_page'] = 1;


        // $config['full_tag_open'] = '<nav><ul class="pagination">';
        // $config['full_tag_close'] = '</ul></nav>';

        // $config['first_link'] = 'First';
        // $config['first_tag_open'] = '<li class="page-item">';
        // $config['first_tag_close'] = '</li>';

        // $config['last_link'] = 'Last';
        // $config['last_tag_open'] = '<li class="page-item">';
        // $config['last_tag_close'] = '</li>';

        // $config['next_link'] = '&raquo';
        // $config['next_tag_open'] = '<li class="page-item">';
        // $config['next_tag_close'] = '</li>';

        // $config['prev_link'] = '&laquo';
        // $config['prev_tag_open'] = '<li class="page-item">';
        // $config['prev_tag_close'] = '</li>';

        // $config['cur_tag_open'] = '<li class="page-item-active"><a class="page-link" href="#">';
        // $config['cur_tag_close'] = '</a></li>';

        // $config['num_tag_open'] = '<li class="page-item">';
        // $config['num_tag_close'] = '</li>';
        // // Produces: class="myclass"
        // $config['attributes'] = array('class' => 'page-link');


        // $this->pagination->initialize($config);
        // $offset = $this->uri->segment(2, 0);
        // $order = '';

        $products = [];
        if ($sort === 'hargaMin') {
            $products = $this->m_products->getProductsByPrice('ASC');
            $productCategories = $this->m_products->getCategoriesWithProducts('ASC');
            //$pagination = $this->pagination->create_links();
        } elseif ($sort === 'hargaMax') {
            $products = $this->m_products->getProductsByPrice('DESC');
            $productCategories = $this->m_products->getCategoriesWithProducts('DESC');
            //$pagination = $this->pagination->create_links();
        } else {


            $products = $this->m_products->get_list_data_products();
            $productCategories = $this->m_products->getCategoriesWithProducts($sort);
            //$pagination = $this->pagination->create_links();
        }


        $this->tsmarty->assign("template_content", "public/products.html");
        $this->tsmarty->assign("products", $products);
        //$this->tsmarty->assign("pagination", $pagination);
        $this->tsmarty->assign("productCategories", $productCategories);

        if (isset($this->session->userdata['member'])) {
            $id_member =  $this->session->userdata['member'];
            $id = $id_member['user_id'];
            $this->tsmarty->assign("id_member", $id);
        } else {
            $id = '';
            $this->tsmarty->assign("id_member", $id);
        }


        // $products = $this->m_products->get_list_data_products($config['per_page'], $offset);
        // $productCategories = $this->m_products->getCategoriesWithProducts($sort, $order, $config['per_page'], $offset);
        // $pagination = $this->pagination->create_links();
        // output
        parent::display();
    }

    public function detail_produk()
    {
        $id = $this->input->get('id');
        $this->tsmarty->assign("template_content", "public/detail_produk.html");



        $products['products'] = $this->m_products->get_detail_data_products($id);
        $button_cart = $this->m_products->show_button_cart($id);

        if ($button_cart) {
            $this->tsmarty->assign("button_cart", $button_cart);
        }else{
            $this->tsmarty->assign("button_cart", $button_cart);
        }
        // Mengambil data varian
        $varian['varian'] = $this->m_products->get_all_varian_from_parent($id);


        $this->tsmarty->assign("products", $products['products']);
        $this->tsmarty->assign("varian", $varian['varian']);

        if (isset($this->session->userdata['member'])) {
            $id_member =  $this->session->userdata['member'];
            $id = $id_member['user_id'];
            $this->tsmarty->assign("id_member", $id);
        } else {
            $id = '';
            $this->tsmarty->assign("id_member", $id);
        }
        // Output the view
        parent::display();
    }

    public function get_data_from_db($page)
    {
    }
}
