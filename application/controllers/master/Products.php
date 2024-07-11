    <?php

    use products as GlobalProducts;

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    // load base
    require_once(APPPATH . 'controllers/base/PrivateBase.php');

    // --
    class Products extends ApplicationBase
    {

        // constructor
        public function __construct()
        {
            // parent constructor
            parent::__construct();
            // load model
            $this->load->model('M_products', 'm_products');
            $this->load->model('M_categories', 'm_categories');
            $this->load->library('form_validation');
            $this->load->library('session'); // Load the session library

        }

        // index
        public function index()
        {
            // Set template content
            $this->tsmarty->assign("template_content", "master/products/index.php");

            $data['products'] = $this->m_products->get_list_products();

            // Assign data to Smarty
            $this->tsmarty->assign("products", $data['products']);

            // output
            parent::display();
        }


        private function generate_kode()
        {
            $max_code = $this->m_products->get_last_product_sequence();

            // Calculate the new sequence
            if ($max_code) {
                $next_number = intval(substr($max_code, -4)) + 1;
            } else {
                $next_number = 1000;
            }

            // Generate the product code
            $prefix = 'PKE';
            $kode = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);
            return $kode;
        }

        public function add()
    {
        $this->tsmarty->assign("template_content", "master/products/add.php");
        // Get the last product sequence

        $data['kode'] = $this->generate_kode();
        $this->tsmarty->assign('product_code', $data['kode']);

        // Load the Category_model
        $this->load->model('M_products');
        $data['categories'] = $this->M_products->getAllCategories();
        $this->tsmarty->assign("categories", $data['categories']);

            if ($this->input->post()) {
                $this->form_validation->set_rules('product_code', 'Product Code', 'required|is_unique[data_product.product_code]');
                $this->form_validation->set_rules('product_name', 'Product Name', 'required');
                $this->form_validation->set_rules('product_type', 'Product Type', 'required');
                $this->form_validation->set_rules('product_price', 'Product Price', 'required|numeric');
                $this->form_validation->set_rules('product_st', 'Product St', 'required');
                $this->form_validation->set_rules('status_product', 'Status Product', 'required');
                $this->form_validation->set_rules('product_desc', 'Deskripsi Product', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                redirect('master/products/add');
            } else {

                    $data = array(
                        // 
                        'product_code' => $data['kode'],
                        'product_name' => $this->input->post('product_name'),
                        'product_type' => $this->input->post('product_type'),
                        'product_price' => $this->input->post('product_price'),
                        'product_st' => $this->input->post('product_st'),
                        'status_product' => $this->input->post('status_product'),
                        'product_desc' => $this->input->post('product_desc'),
                        'created_by' => $this->user_data['user_id'],
                        'created' => date('Y-m-d H:i:s'),

                    // Tambahkan data lainnya sesuai kebutuhan
                );

                if ($_FILES['product_pict']['tmp_name']) {
                    $config['upload_path'] = './resource/assets-frontend/dist/product/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 3048;
                    $config['encrypt_name'] = FALSE;
                    $config['overwrite'] = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('product_pict')) {

                        $product_pict_data = $this->upload->data();
                        $product_pict = $product_pict_data['file_name'];

                        $data['product_pict'] = $product_pict;
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                        redirect('master/products');
                    }
                }
                if ($this->m_products->add_product_data($data)) {
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan', 'status' => 'success'));
                    redirect('master/products');
                } else {
                    $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                }
            }
        }

        parent::display();
    }

    public function edit()
    {
        $id_product = $this->input->get('id');  // Get the 'id' parameter from the URL
        $this->load->model('M_products');
        $categories_edit = $this->m_products->getCategoriesEdit($id_product);
        $this->tsmarty->assign("categories_edit", $categories_edit);
        
        $categories = $this->m_products->getAllCategories();
        $this->tsmarty->assign("categories", $categories);
        // Load the model and get the product details
        $data['product'] = $this->m_products->get_edit_data_products($id_product);
        $old_product_pict = $data['product']->product_pict;

        $this->tsmarty->assign("template_content", "master/products/edit.php");
        $this->tsmarty->assign("product", $data['product']);  // Assign the product details to Smarty

            // Handle the form submission for editing
            if ($this->input->post()) {
                $data = array(
                    'product_name' => $this->input->post('product_name'),
                    'product_type' => $this->input->post('product_type'),
                    'product_st' => $this->input->post('product_st'),
                    'status_product' => $this->input->post('statusProduct'),
                    'product_price' => $this->input->post('product_price'),
                    'product_desc' => $this->input->post('product_desc'),
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->user_data['user_id'],
                );

            if ($_FILES['product_pict']['tmp_name']) {
                $config['upload_path']          = './resource/assets-frontend/dist/product/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 3048;
                $config['encrypt_name']         = TRUE;
                $config['overwrite']            = TRUE;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('product_pict')) {

                    $product_pict_data = $this->upload->data();
                    $product_picture = $product_pict_data['file_name'];

                    //ambil nama fila foto lama


                    $data['product_pict'] = $product_picture;

                    // temukan di folder dengan nama file
                    if (!empty($old_product_pict)) {
                        $old_file_path = './resource/assets-frontend/dist/product/' . $old_product_pict;
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                    }
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                    redirect('master/products');
                }
            }

            // Update product categories status
            // Assuming the product_id is the same as the $id
            // $status = $this->input->post('cat_id'); // Assuming you have a form field for product_st
                        
            // $this->m_products->product_categories($id_product, $status);


            // Update the product details using the model
            $update_success = $this->m_products->update_product($id_product, $data);

            if ($update_success) {
                $this->session->set_flashdata('message', array('msg' => 'Gagal mengupdate data', 'status' => 'error'));
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil diupdate', 'status' => 'success'));
            }
            redirect('master/products');  // Redirect after successful update
        }
        // Display the edit form
        parent::display();
    }

        public function add_variant()
        {

            $this->tsmarty->assign("template_content", "master/products/detail.php");
            // $this->tsmarty->assign('product_code', $data['kode']);

            // Validasi input
            $this->form_validation->set_rules('product_code', 'Product Code', 'required|is_unique[data_product.product_code]');
            $this->form_validation->set_rules('product_parent', 'Product Parent', 'required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'required');
            // $this->form_validation->set_rules('product_type', 'Product Type', 'required');
            $this->form_validation->set_rules('product_price', 'Product Price', 'required|numeric');
            //$this->form_validation->set_rules('product_pict', 'Product Pict', 'required');
            $this->form_validation->set_rules('product_st', 'Product St', 'required');
            // $this->form_validation->set_rules('created', 'Created', 'required');
            // $this->form_validation->set_rules('modified', 'Modified', 'required');
            // Tambahkan validasi lainnya sesuai kebutuhan

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));

                return redirect($_SERVER['HTTP_REFERER'])->withInput();
            } else {

                if ($this->input->post()) {
                    $data = array(
                        'product_code' => $this->input->post('product_code'),
                        'product_parent' => $this->input->post('product_parent'),
                        'product_name' => $this->input->post('product_name'),
                        'product_type' => $this->input->post('product_type'),
                        'product_price' => $this->input->post('product_price'),
                        'product_st' => $this->input->post('product_st'),
                        'status_product' => $this->input->post('status_product'),
                        'created_by' => $this->user_data['user_id'],
                        'created' => date('Y-m-d H:i:s'),
                        // Tambahkan data lainnya sesuai kebutuhan
                    );

                    if ($_FILES['product_pict']['tmp_name']) {
                        $config['upload_path']   = './resource/assets-frontend/dist/product/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size']      = 2048;
                        $config['encrypt_name']  = TRUE;
                        $config['overwrite']     = TRUE; // Sesuaikan dengan kebutuhan Anda

                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('product_pict')) {
                            $product_pict_data = $this->upload->data();
                            $product_pict = $product_pict_data['file_name'];
                            // Jika validasi berhasil, tambahkan produk ke database
                            $data['product_pict'] = $product_pict;

                            // return var_dump($product_pict);
                            // die;
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                            return redirect($_SERVER['HTTP_REFERER']);
                        }
                    }

                    if ($this->m_products->add_variant_data($data)) {
                        $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan', 'status' => 'success'));
                    } else {
                        $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                    }

                    //kembali ke tampilan sebelumnya
                    return redirect($_SERVER['HTTP_REFERER']);
                    // Redirect atau tampilkan pesan sukses
                }
            }
            // redirect('master/products/detail');
            parent::display();
        }

        public function detail()
        {
            $id = $this->input->get('id');

            $data['kode'] = $this->generate_kode();

            // Get data
            $this->load->model('M_products');

            $this->tsmarty->assign("template_content", "master/products/detail.php");
            $data['products'] = $this->M_products->get_detail_data_products($id);
            $data['product_variants'] = $this->M_products->get_list_variant_products($id);

            //print_r($data['product_variants']);exit();

            $id_product = $this->input->get('id');  // Get the 'id' parameter from the URL
            $this->load->model('M_products');
            $categories_edit = $this->M_products->getCategoriesEdit($id_product);
            $this->tsmarty->assign("categories_edit", $categories_edit);

            // print_r($categories_edit);exit();
            $categories = $this->M_products->getAllCategories();
            $this->tsmarty->assign("categories", $categories);

            // Assign data to Smarty
            $this->tsmarty->assign("product_code", $data['kode']);
            $this->tsmarty->assign("products", $data['products']);
            $this->tsmarty->assign("product_variants", $data['product_variants']);

            parent::display();
        }

        public function detail_variant()
        {
            $id = $this->input->get('id');
            $productDataDetail = $this->m_products->get_detail_data_products($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($productDataDetail));
        }


        public function delete()
        {
            $id = $this->input->get('id'); // Dapatkan product_id dari parameter URL
            //$this->load->model('M_products');
            $product = $this->m_products->get_detail_data_products($id);

            // Hapus foto produk utama jika ada
            if (!empty($product->product_pict)) {
                $foto_path = FCPATH . './resource/assets-frontend/dist/product/' . $product->product_pict;
                if (file_exists($foto_path)) {
                    unlink($foto_path);
                }

                $this->m_products->delete_product_category($id);
            }

            // Hapus foto-foto dari varian yang terkait jika ada
            $varians = $this->m_products->delete_all_varian_from_parent($id);
            foreach ($varians as $varian) {
                if (!empty($varian->product_pict)) {
                    $varian_foto_path = FCPATH . './resource/assets-frontend/dist/product/' . $varian->product_pict;
                    if (file_exists($varian_foto_path)) {
                        unlink($varian_foto_path);
                    }
                }
            }

            // Hapus data produk dan varian dari database
            if ($this->m_products->delete_data_products($id)) {

                $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
                redirect('master/products');
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
                redirect('master/products');
            }

            parent::display();
        }


        public function edit_variant()
        {
            $id = $this->input->get('id');
            $productData = $this->m_products->get_detail_data_products($id);

            $response_data = $productData;

            $id_product = $this->input->post('productId');
            if ($this->input->post()) {
                $productData = $this->m_products->get_detail_data_products($id_product);
                $old_product_pict = $productData->product_pict;
                $data = array(
                    'product_name' => $this->input->post('productNameVarian'),
                    'product_type' => $this->input->post('productType'),
                    'product_price' => $this->input->post('productPrice'),
                    'product_st' => $this->input->post('product_st'),
                    'status_product' => $this->input->post('statusProduct'),
                    'modified_by' => $this->user_data['user_id'],
                    'modified' => date('Y-m-d H:i:s'),
                );

                if ($_FILES['product_pict']['tmp_name']) {
                    $config['upload_path']          = './resource/assets-frontend/dist/product/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = 2048;
                    $config['encrypt_name']         = TRUE;
                    $config['overwrite']            = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('product_pict')) {

                        $product_pict_data = $this->upload->data();
                        $product_picture = $product_pict_data['file_name'];

                        $data['product_pict'] = $product_picture;

                        // Temukan foto lama di folder dan hapus jika ada
                        if (!empty($old_product_pict)) {
                            $old_file_path = './resource/assets-frontend/dist/product/' . $old_product_pict;
                            if (file_exists($old_file_path)) {
                                unlink($old_file_path); // Hapus foto lama
                            }
                        }
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                        redirect('master/products');
                    }
                }
                $this->m_products->edit_variant_data($id_product, $data);
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil diubah.', 'status' => 'success'));
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                // Jika tidak ada POST data, kirimkan JSON respons
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response_data)); // Menggunakan variabel $response_data
            }
        }

        public function delete_varian()
        {
            $id = $this->input->get('id');
            $this->load->model('M_products');
            $product = $this->M_products->get_detail_data_products($id);

            if (!empty($product->product_pict)) {
                $foto_path = FCPATH . './resource/assets-frontend/dist/product/' . $product->product_pict;
                if (file_exists($foto_path)) {
                    unlink($foto_path);
                }
            }

            // Hapus data produk dan varian dari database
            if ($this->M_products->delete_data_varian($id)) {
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
                redirect('master/products');
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
            }
        }

        public function delete_categories_product() {
            $id_product = $this->input->get('id');
            $this->load->model('M_products');

            $categories_edit = $this->M_products->getCategoriesEdit($id_product);
            $this->tsmarty->assign("categories_edit", $categories_edit);

            if ($this->m_products->delete_product_category_edit($id_product)) {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Category berhasil dihapus.', 'status' => 'success'));
            }
            
            redirect('master/products');
            
        }

        public function tambah_product_category() {
            $this->load->model('M_products');
        
            if ($this->input->post()) {
                $data = array(
                    'cat_id' => $this->input->post('cat_id'),
                    'status' => $this->input->post('product_st'),
                    'product_id' => $this->input->post('product_id'),
                    'created_by' => $this->user_data['user_id'],
                    'created' => date('Y-m-d H:i:s'),
                    // Tambahkan data lainnya sesuai kebutuhan
                );
        
                $insert_success = $this->m_products->add_product_category($data);

                if ($insert_success) {
                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                    redirect('master/products');
                } else {
                    $db_error = $this->db->error();
                    $this->session->set_flashdata('message', array('msg' => 'Gagal menyimpan data. Error: ' . $db_error['message'], 'status' => 'error'));
                    redirect('master/products');
                }

            }
        }
        
    }
