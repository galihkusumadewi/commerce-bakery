<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_products extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function countAllProducts()
    {
        $status = '0';
        $this->db->from('data_product'); // Gunakan alias "t" untuk tabel "temp_cart_detail"

        // $this->db->where('product_parent' => '0', 'product_st' => '0', 'status_product' => 'Product');
        $this->db->where('product_parent', '0');
        $this->db->where('status_product', 'product');
        $this->db->where('product_st', $status);

        return $this->db->count_all_results();
    }
    //list product member
    function get_list_data_products()
    {
        // $this->db->limit($limit, $offset);
        $query = $this->db->get_where('data_product', array('product_parent' => '0', 'product_st' => '0', 'status_product' => 'Product'));



        return $query->result();
        // return $query->row(); 
    }


    public function getProductsByPrice($order = 'ASC')
    {
        $status = '0';
        $status_product = 'Product';
        $this->db->from('data_product');
        $this->db->where('product_parent', $status);
        $this->db->where('product_st', $status);
        $this->db->where('status_product', $status_product);
        $this->db->order_by('product_price', $order);
        $query = $this->db->get();
        return $query->result();
    }


    //list product yang ditampilkan di recommend cart
    function get_list_recommend()
    {
        $this->db->limit(10);
        $query = $this->db->get_where('data_product', array('product_parent' => '0'));
        return $query->result();
    }

    // get list data admin
    function get_list_products()
    {
        $query = $this->db->get_where('data_product', array('product_parent' => '0'));
        return $query->result();
    }

    function get_list_variant_products($product_id)
    {
        $query = $this->db->where(array('product_parent !=' => 0));

        if ($product_id) {
            $query = $query->where('product_parent', $product_id);
        }

        return $query->get('data_product')->result();
    }

    function get_detail_data_products($id)
    {
        //=== $asd = $this->get_list_data_products();
        $query = $this->db->get_where('data_product', array('product_id' => $id));
        return $query->row();

        //  return $query->result();
    }

    function show_button_cart($id)
    {
        //=== $asd = $this->get_list_data_products();
        $query = $this->db->get_where('data_product', array('product_parent' => $id));
        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan seluruh baris yang sesuai dengan kondisi
        } else {
            return array();
        }

        //  return $query->result();
    }

    function get_detail_products($id)
    {
        $query = $this->db->get_where('data_product', array('product_id' => $id, 'product_parent' => $id));
        return $query->row();
    }



    function add_product_data($data)
    {
        return $this->db->insert('data_product', $data);
    }

    function add_variant_data($data)
    {
        return $this->db->insert('data_product', $data);
    }

    function edit_variant_data($id_product, $data)
    {
        $this->db->where('product_id', $id_product);
        $this->db->update('data_product', $data);
    }

    public function getAllCategories()
    {
        $query = $this->db->get('data_categories');
        return $query->result();
    }

    // public function getCategoriesEdit($id_product)
    // {
    //     $where = "product_id = $id_product";
    //     $query = $this->db->select('a.cat_name')
    //         ->from('product_categories b')
    //         ->join('data_categories a', 'a.cat_id = b.cat_id', 'inner')
    //         ->where($where)
    //         ->get()
    //         ->row_array();
    //     if ($query) {
    //         return $query;
    //     } else {
    //         return array();
    //     }
    // }

    public function getCategoriesEdit($id_product)
    {
        $where = "product_id = $id_product";
        $query = $this->db->select('*')
            ->from('product_categories b')
            ->join('data_categories a', 'a.cat_id = b.cat_id', 'inner')
            ->where($where)
            ->get();
    
        if (!$query) {
            $db_error = $this->db->error();
            echo "Database Error: " . $db_error['message'];
            // Atau lakukan penanganan kesalahan lainnya sesuai kebutuhan Anda
            return false;
        }
    
        return $query->result_array();
    }
    


    public function get_edit_data_products($id)
    {
        $query = $this->db->get_where('data_product', array('product_id' => $id));
        return $query->row();
    }

    public function update_product($id, $data)
    {
        $this->db->where('product_id', $id);
        $this->db->update('data_product', $data);
    }

    public function delete_data_products($id) //untuk delete parent dengan varian nya
    {
        $this->db->where('product_id', $id);
        $this->db->or_where('product_parent', $id);
        $this->db->delete('data_product');
        return $this->db->affected_rows() > 0;
    }

    public function delete_product_category($id)
    {
        $this->db->where('product_id', $id);
        $this->db->delete('product_categories');
    }

    public function delete_data_varian($id) //untuk delete hanya varian
    {
        $this->db->where('product_id', $id);
        $this->db->delete('data_product');
        return $this->db->affected_rows() > 0;
    }

    public function product_categories($id_product, $status)
    {
        $data = array(
            'cat_id' => $status
        );
        $this->db->where('product_id', $id_product);
        $this->db->update('product_categories', $data);
        return $this->db->affected_rows() > 0;
    }


    public function get_last_product_sequence()
    {
        $this->db->select_max('product_code');
        $query = $this->db->get('data_product');
        $row = $query->row();
        return $row->product_code;
    }

    // get last inserted id
    function get_last_inserted_id()
    {
        return $this->db->insert_id();
    }


    public function getProductStatuses()
    {
        $query = $this->db->insert('product_st');
        return $query->result();
    }

    //menampilkan product sesuai categories dan menampilkan product harga terendah/tertinggi
    public function getCategoriesWithProducts($order = 'ASC', $sort = '')
    {
        $where = "c.cat_st='0' AND p.status_product='Product' AND p.product_st='0'";

        $result = $this->db->select('c.cat_name, p.product_id, p.product_name, p.product_price, p.product_st, p.product_pict, p.status_product')
            ->from('data_product p')
            ->join('product_categories pc', 'p.product_id = pc.product_id', 'left')
            ->join('data_categories c', 'pc.cat_id = c.cat_id', 'left')
            ->order_by('p.product_price', $order)
            ->where($where)
            ->get()
            ->result_array();


        if ($sort === 'hargaMin') {
            $result = $result->order_by('p.product_price ', $order);
        } elseif ($sort === 'hargaMax') {
            $result = $result->order_by('p.product_price ', $order);
        }

        $categories_with_products = array();
        foreach ($result as $row) {
            $category_name = $row['cat_name']; // Gunakan 'cat_name' sesuai dengan kolom yang ada di tabel data_categories
            $product_name = $row['product_name'];
            $product_id = $row['product_id'];
            $product_price = $row['product_price'];
            $product_st = $row['product_st'];
            $product_pict = $row['product_pict'];

            if (!isset($categories_with_products[$category_name])) {
                $categories_with_products[$category_name] = array(
                    'products' => array()
                );
            }

            if ($product_name) {
                $categories_with_products[$category_name]['products'][$product_id]['product_name'] = $product_name;
            }
            if ($product_st) {
                $categories_with_products[$category_name]['products'][$product_id]['product_st'] = $product_st;
            }
            if ($product_price) {
                $categories_with_products[$category_name]['products'][$product_id]['product_price'] = $product_price;
            }
            if ($product_pict) {
                $categories_with_products[$category_name]['products'][$product_id]['product_pict'] = $product_pict;
            }
        }

        return $categories_with_products;
    }

    public function add_to_cart($product_id, $quantity)
    {
        $cart = $this->session->userdata('cart');

        if (!$cart) {
            $cart = array();
        }

        // Check if the product is already in the cart
        if (array_key_exists($product_id, $cart)) {
            $cart[$product_id] += $quantity;
        } else {
            $cart[$product_id] = $quantity;
        }

        $this->session->set_userdata('cart', $cart);
    }

    public function get_cart_contents()
    {
        return $this->session->userdata('cart');
    }

    public function get_all_varian_from_parent($id)
    {
        $this->db->where('product_parent', $id)
            ->where('status_product', 'Product');

        $query = $this->db->select('product_id, product_parent, product_name, product_pict, product_price')
            ->from('data_product')
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan seluruh baris yang sesuai dengan kondisi
        } else {
            return array();
        }
    }
    public function delete_all_varian_from_parent($id)
    {
        $this->db->where('product_parent', $id);

        $query = $this->db->select('product_id, product_parent, product_name, product_pict, product_price')
            ->from('data_product')
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan seluruh baris yang sesuai dengan kondisi
        } else {
            return array();
        }
    }


    public function get_product_prelaunch()
    {
        $query = $this->db->where('product_parent', '0')
            ->where('product_st', '0')
            ->where('status_product', 'Prelaunch')
            ->get('data_product');

        return $query->result();
    }

    public function get_product_arrival()
    {
        $query = $this->db->where('product_parent', '0')
            ->where('product_st', '0')
            ->where('status_product', 'Arrival')
            ->get('data_product');

        return $query->result();
    }

    public function delete_product_category_edit($id_product)
    {
        $this->db->where('id', $id_product);
        $this->db->delete('product_categories');
    }

    public function add_product_category($data) {
        return $this->db->insert('product_categories', $data);
    }
}
