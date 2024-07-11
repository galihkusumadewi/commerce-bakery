<main>
    <div class="container products-container mb-5">
        <div class="d-flex flex-column align-items-center">
            <div class="heading-page p-2 mt-4">
                <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Tambah Data Produk</b></h2>
            </div>
        </div>
    </div>

    <form method="post" action="{site_url([$current_page.nav_url, 'add'])}" enctype="multipart/form-data">
        <div class="row" >
            <div class="col col-md-6 mx-auto" >
                {if $validasi = validation_errors()}
                <div class="d-flex flex-column alert alert-danger">
                    {$validasi}
                </div>
                {/if}
                <div class="card" >
                    <div class="card-body" >
                        <div class="form-group">
                            <label for="productCode">Product Code</label>
                            <input type="text" value="{$product_code|default:''}" class="form-control" name="product_code" id="productCode">
                        </div>
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="productName">
                        </div>
                        <div class="form-group">
                            <label for="productType">Product Type</label>
                            <select id="productType" name="product_type" class="form-control">
                                <!-- <option  value="konsinyasi">Konsinyasi</option> -->
                                <option selected value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                                <option value="bakery">Bakery</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="productCat">Product Categories</label>
                            <select id="cat_id" name="cat_id" class="form-control">
                                {foreach from=$categories key=key item=category}
                                <option value="{$category->cat_id}">{$category->cat_name}</option>
                                {/foreach}
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="text" class="form-control" name="product_price" id="productPrice">
                        </div>
                        <div class="form-group">
                            <label for="productPict">Product Pict</label>
                            <input type="file" class="form-control-file" name="product_pict" id="product_pict">
                        </div>
                        <div class="form-group">
                            <label for="product_desc" class="col-md-6 col-form-label">Deskripsi Product</label>
                            <textarea id="summernote" name="product_desc"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productSt">Status</label>
                            <select id="productSt" name="product_st" class="form-control">
                                <option value="0" selected>Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productSt">Status Product</label>
                            <select id="productSt" name="status_product" class="form-control">
                                <option value="Arrival" selected>Arrival</option>
                                <option value="Prelaunch">Prelaunch</option>
                                <option value="Product">Product</option>
                            </select>
                        </div>
                   
                        <div class="form-group">
                            <label for="sumbit"></label>
                            <button type="submit" style="background-color: #662A0C; color: #fff;" class="btn btn-primary" name="submit">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
