<main>
    <div class="container products-container mb-5">
        <div class="d-flex flex-column align-items-center">
            <div class="heading-page p-2 mt-4">
                <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Edit Produk</b></h2>
            </div>
        </div>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" value="{$product->product_name}" name="product_name" id="product_name">
                        </div>
                        <div class="form-group">
                            <label for="productType">Product Type</label>
                            <select id="productType" name="product_type" class="form-control">
                                <option value="konsinyasi" {if $product->product_type == 'konsinyasi'} selected {/if}>Konsinyasi</option>
                                <option value="makanan" {if $product->product_type == 'makanan'} selected {/if}>Makanan</option>
                                <option value="minuman" {if $product->product_type == 'minuman'} selected {/if}>Minuman</option>
                                <option value="bakery" {if $product->product_type == 'bakery'} selected {/if}>Bakery</option>
                            </select>
                        </div> 
                        <!-- <div class="form-group">
                            <label for="productCat">Product Categories</label>
                            <select id="cat_id" name="cat_id" class="form-control">
                               <option value="{$categories_edit.cat_id}">{$categories_edit.cat_name}</option>
                                {foreach from=$categories key=key item=category}
                                <option value="{$category->cat_id}">{$category->cat_name}</option>
                                {/foreach}
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="productName">Product Price</label>
                            <input type="text" class="form-control" value="{$product->product_price}" name="product_price" id="productprice">
                        </div>
                        <div class="form-group">
                            <label for="productPict">Product Pict</label>
                            <input type="file" class="form-control-file" name="product_pict" id="product_pict">
                        </div>
                        <div class="form-group">
                            <label for="product_desc" class="col-md-6 col-form-label">Deskripsi Product</label>
                            <textarea id="summernote" name="product_desc"> {$product->product_desc}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="productSt">Status</label>
                            <select id="productSt" name="product_st" class="form-control">
                                <option value="1" {if $product->product_st == '1'} selected {/if} >Inactive</option>
                                <option value="0" {if $product->product_st == '0'} selected {/if} >Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="statusProduct">Status Product</label>
                                <select id="statusProduct" name="statusProduct" class="form-control statusProduct">
                                    <option value="Arrival" {if $product->status_product == 'Arrival'} selected {/if}>Arrival</option>
                                    <option value="Prelaunch" {if $product->status_product == 'Prelaunch'} selected {/if}>Prelaunch</option>
                                    <option value="Product" {if $product->status_product == 'Product'} selected {/if}>Product</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="sumbit"></label>
                            <button type="submit" style="background-color: #662A0C; color: #fff;" class="btn btn-primary" name="submit">UPDATE</button>
                            <button type="submit" style="background-color: #AAAA; color: #fff;" class="btn btn-primary" name="submit">CANCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>