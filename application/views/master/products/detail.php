<div class="container products-container mb-5">
	<div class="row row-cols-1 row-cols-md-2 mb-4">
		<div class="col-12 col-md-6 col-lg-6">
			<div class="card">
				<img src="{$BASEURL}/resource/assets-frontend/dist/product/{$products->product_pict}" alt="product-kenes" class="img-fluid rounded-2 product-kenes">
			</div>
            
		</div>
		<div class="col-12 col-md-6 col-lg-6 flex-column">
			<li class="list-group-item active" aria-current="true">Detail Product {$products->product_name}</li>
			<ul class="list-group">
				<div class="modal-body">
					<label class="col-md-4">Nama Product</label>
					<span class="col-md-8">: {$products->product_name}</span>
				</div>
                <div class="modal-body">
					<label class="col-md-4">Deskripsi Product</label>
					<span class="col-md-4">: {$products->product_desc}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Kode Product</label>
					<span class="col-md-8">: {$products->product_code}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Tipe Product</label>
					<span class="col-md-8">: {$products->product_type}</span>
				</div>
				<!-- <div class="modal-body">
					<label class="col-md-4">Kategori Product</label>
					<span class="col-md-8">: {$categories_edit.cat_name}</span>
				</div> -->
				<div class="modal-body">
					<label class="col-md-4">Harga</label>
					<span class="col-md-8">: Rp {$products->product_price|number_format}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Product_st</label>
					<span class="col-md-8">: {if {$products->product_st} == 0}Active{else}Tidak Aktif{/if}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Status Product</label>
					<span class="col-md-8">: {$products->status_product}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Created</label>
					<span class="col-md-8">: {$products->created}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Created By</label>
					<span class="col-md-8">: {$products->created_by}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Modified</label>
					<span class="col-md-8">: {$products->modified}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Modified By</label>
					<span class="col-md-8">: {$products->modified_by}</span>
				</div>
				<div class="modal-body">
					<label class="col-md-4">Created By</label>
					<span class="col-md-8">: {$products->created_by}</span>
				</div>

			</ul>
		</div>
	</div>

    <!-- Product Categories -->
    <div class="d-flex flex-column align-items-center">
        <div class="heading-page p-2 mt-4">
            <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C"> Product Categories</b></h2>
        </div>
    </div>

    <!-- MODAL TAMBAH KATEGORI PRODUCT -->

    <div class="card">
				<div class="card-body">
					<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahkategori">
						ADD 
					</button>
                    <!-- Modal Tambah Varian-->
                    <div class="modal fade" id="tambahkategori" tabindex="-1" aria-labelledby="tambahkategorilabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Product Category {$products->product_name}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{site_url([$current_page.nav_url, 'tambah_product_category'])}" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="{$products->product_id}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <!-- <label for="productName">Product Parent</label> -->
                                            <!-- <input type="hidden" class="form-control" value="{$products->product_id}" name="product_id" id="productparent"> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="productCat">Product Categories</label>
                                            <select id="cat_id" name="cat_id" class="form-control">
                                                {foreach from=$categories key=key item=category}
                                                <option value="{$category->cat_id}">{$category->cat_name}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productSt">Status</label>
                                            <select id="productSt" name="product_st" class="form-control">
                                                <option value="0">Active</option>
                                                <option value="1">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>

    <div class="card-body">
    <table id="datatable" class="table data-tables table-striped">
        <thead>
            <tr class="light center">
                <th>No</th>
                <th>Product Categories</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {assign var="no" value=1}
            {foreach from=$categories_edit key=key item=category}
                <tr>
                    <td align="center">{$no++}</td>
                    <td>{$category.cat_name}</td>
                    <input type="hidden" name="id" value="{$category.id}">
                    <td>{if {$category.status} == 0}Active{else}Tidak Aktif{/if}</td>
                    <td align="center">
                        {if $allowed.delete}
                            <a class="btn btn-sm btn-outline-danger rounded" data-toggle="tooltip" data-placement="top" title="Delete" href="{site_url([$current_page.nav_url, 'delete_categories_product'])}?id={$category.id}"><i class="fa-solid fa-trash"></i></a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

	<!-- list varian -->

    <div class="d-flex flex-column align-items-center">
        <div class="heading-page p-2 mt-4">
            <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C"> List Varian</b></h2>
        </div>
    </div>


			<div class="card">
				<div class="card-body">
					<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
						ADD
					</button>
                    <!-- Modal Tambah Varian-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Varian {$products->product_name}</h5>
                                    <div class="form-group">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{site_url([$current_page.nav_url, 'add_variant', {$products->product_id}])}" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="{$products->product_id}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <!-- <label for="productName">Product Parent</label> -->
                                            <input type="hidden" class="form-control" value="{$products->product_id}" name="product_parent" id="productparent">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" value="{$product_code|default:''}" class="form-control" name="product_code" id="productCode">
                                        </div>
                                        <div class="form-group">
                                            <label for="productName">Product Varian</label>
                                            <input type="text" class="form-control" value="{$products->product_name}" name="product_name" id="productName">
                                        </div>
                                        <div class="form-group">
                                        <label for="productType">Product Type</label>
                                            <select id="productType" name="product_type" class="form-control">
                                                <!-- <option value="konsinyasi" {if $products->product_type == 'konsinyasi'} selected {/if} selected>Konsinyasi</option> -->
                                                <option value="makanan" {if $products->product_type == 'makanan'} selected {/if}>Makanan</option>
                                                <option value="minuman" {if $products->product_type == 'minuman'} selected {/if}>Minuman</option>
                                                <option value="bakery" {if $products->product_type == 'bakery'} selected {/if}>Bakery</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="productName">Product Price</label>
                                            <input type="text" class="form-control" value="{$products->product_price}" name="product_price" id="productprice">
                                        </div>
                                        <div class="form-group">
                                            <label for="productPict">Product Pict</label>
                                            <input type="file" class="form-control-file" name="product_pict" id="product_pict" size="20">
                                        </div>
                                        <div class="form-group">
                                            <label for="productSt">Product St</label>
                                            <select id="productSt" name="product_st" class="form-control">
                                                <option value="0" {if $products->product_st == '0'} selected {/if} selected>Active</option>
                                                <option value="1" {if $products->product_st == '1'} selected {/if}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productSt">Status Product</label>
                                            <select id="productSt" name="status_product" class="form-control">
                                                <option value="Arrival" {if $products->status_product == 'Arrival'} selected {/if} selected>Arrival</option>
                                                <option value="Prelaunch" {if $products->status_product == 'Prelaunch'} selected {/if}>Prelaunch</option>
                                                <option value="Product" {if $products->status_product == 'Product'} selected {/if}>Product</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    

                <div class="card-body">
                    <table id="datatable" class="table data-tables table-striped">
                        <thead>
                            <tr class="light center">
                                <th>No</th>
                                <th>Varian</th>
                                <th>Product Parent</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="no" value=1}
                            {foreach from=$product_variants key=key item=product}
                            <tr>
                                <td align="center">{$no++}</td>

                                <td>{$product->product_name}</td>
                                <td>{$product->product_parent}</td>
                                <td align="center">
                                    <a class="btn btn-sm btn-outline-info rounded modal_detail_variant" type="button" data-placement="top" data-toggle="modal" title="" data-original-title="View" data-product-id-detail="{$product->product_id}"data-target="#detailvarian"><i class="fa-regular fa-file"></i></a>
                                    {if $allowed.edit}
                                    <a class="btn btn-sm btn-outline-secondary rounded modal_edit_variant" type="button" data-toggle="modal" data-placement="top" title="" data-original-title="Edit" data-product-id="{$product->product_id}" data-target="#editvarian"><i class="fa-regular fa-pen-to-square"></i></a>
                                    {/if}
                                    {if $allowed.delete}
                                    <a class="btn btn-sm btn-outline-danger rounded" id="btn-delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{site_url([$current_page.nav_url, 'delete_varian'])}?id={$product->product_id}"><i class="fa-solid fa-trash"></i></a>
                                    {/if}
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>

                <!-- Modal Detail Varian -->
                <div class="card-body">
                    <div class="modal fade" id="detailvarian" tabindex="-1" aria-labelledby="modalDetailVarian" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title productNameVarianDetailTitle"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            	<!-- <form action="{site_url([$current_page.nav_url, 'detail_variant'])}" enctype="multipart/form-data"> -->
								<div class="row row-cols-1 row-cols-md-2 mb-4">
									<div class="col-12 col-md-6 col-lg-6">
										<div class="card">
											<img src="" class="productPictDetail img-fluid" id="productPictDetail" alt="product-kenes" style="width: 400px; height: auto;">
										</div>    
									</div>
									<div class="col-12 col-md-6 col-lg-6 flex-column">
										<ul class="list-group">
										<div class="modal-body">
											<div class="col">
												<label for="productNameVarianDetail">Product Varian</label>
												<span class="col-md-8" id="productNameVarianDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productParentDetail">Product Parent</label>
												<span class="col-md-8" id="productParentDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productPriceDetail">Product Price</label>
												<span class="col-md-8" id="productPriceDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productTypeDetail">Product Type</label>
												<span class="col-md-8" id="productTypeDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productStatusDetail">Product Status</label>
												<span class="col-md-8" id="productStatusDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productStatusProductDetail">Status Product</label>
												<span class="col-md-8" id="productStatusProductDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productModifiedDetail">Modified</label>
												<span class="col-md-8" id="productModifiedDetail"></span>
											</div>
										</div>
										<div class="modal-body">
											<div class="col">
												<label for="productModifiedByDetail">Modified By</label>
												<span class="col-md-8" id="productModifiedByDetail"></span>
											</div>
										</div>
										</ul>
									</div>  
								</div>
							</div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Varian -->
                <div class="card-body">
                    <div class="modal fade" id="editvarian" tabindex="-1" aria-labelledby="modalEditVarian" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title productName"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{site_url([$current_page.nav_url, 'edit_variant'])}" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="productNameVarian">Product Varian</label>
                                            <input type="text" class="form-control productNameVarian" name="productNameVarian">
                                            <input type="hidden" class="form-control productId" name="productId">

                                        </div>
                                        <div class="form-group">
                                            <label for="productType">Product Type</label>
                                            <select name="productType" class="form-control productType">
                                                <option value="Konsinyasi" {if $products->product_type == 'Konsinyasi'} selected {/if}>Konsinyasi</option>
                                                <option value="Makanan" {if $products->product_type == 'Makanan'} selected {/if}>Makanan</option>
                                                <option value="Minuman" {if $products->product_type == 'Minuman'} selected {/if}>Minuman</option>
                                                <option value="Bakery" {if $products->product_type == 'Bakery'} selected {/if}>Bakery</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productPrice">Product Price</label>
                                            <input type="text" class="form-control productPrice" name="productPrice" id="productprice">
                                        </div>
                                        <div class="form-group">
                                            <label for="productPict">Product Pict</label>
                                            <input type="file" class="form-control-file" name="product_pict" id="product_pict" size="20">
                                        </div>
                                        <div class="form-group">
                                            <label class="status" for="productSt">Product St</label>
                                            <select name="product_st" class="form-control productStatus">
                                                <option value="0" {if $products->product_st == '0'} selected {/if}>Active</option>
                                                <option value="1" {if $products->product_st == '1'} selected {/if}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="statusProduct">Status Product</label>
                                            <select id="statusProduct" name="statusProduct" class="form-control statusProduct">
                                                <option value="Arrival" {if $products->status_product == 'Arrival'} selected {/if}>Arrival</option>
                                                <option value="Prelaunch" {if $products->status_product == 'Prelaunch'} selected {/if}>Prelaunch</option>
                                                <option value="Product" {if $products->status_product == 'Product'} selected {/if}>Product</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
	</div>
</div>

<script>
    var editModalButtons = document.querySelectorAll('.modal_edit_variant');
    var editModal = document.getElementById('editvarian');
    var editHref = '{site_url([$current_page.nav_url, 'edit_variant'])}';

    editModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-product-id');

            fetch(editHref + '?id=' + id)
                .then(response => response.json())
                .then(productData => {
                    editModal.querySelector('.productName').textContent = productData.product_name;
                    editModal.querySelector('.productNameVarian').value = productData.product_name;
                    editModal.querySelector('.productId').value = productData.product_id;
                    editModal.querySelector('.productType').value = productData.product_type;
                    editModal.querySelector('.productPrice').value = productData.product_price;
                    editModal.querySelector('.productStatus').value = productData.product_st;
                    editModal.querySelector('.statusProduct').value = productData.status_product;
                    // editModal.style.display = 'block';
                })
        })
    });

		var detailModalButtons = document.querySelectorAll('.modal_detail_variant');
		var detailModal = document.getElementById('detailvarian');
		var detailHref = '{site_url([$current_page.nav_url, 'detail_variant'])}';
		var src= '{$BASEURL}/resource/assets-frontend/dist/product';

		detailModalButtons.forEach(button => {
		button.addEventListener('click', function() {
			var id = this.getAttribute('data-product-id-detail');

			fetch(detailHref + '?id=' + id)
				.then(response => response.json())
				.then(productDataDetail => {
					detailModal.querySelector('#productNameVarianDetail').textContent = productDataDetail.product_name;
					var product_st  = productDataDetail.product_st == 0 ? 'Active' : 'Inactive';
					detailModal.querySelector('#productStatusDetail').textContent = product_st;
					detailModal.querySelector('#productParentDetail').textContent = productDataDetail.product_parent;
					detailModal.querySelector('#productPriceDetail').textContent = productDataDetail.product_price;
					detailModal.querySelector('#productModifiedDetail').textContent = productDataDetail.modified;
					detailModal.querySelector('#productModifiedByDetail').textContent = productDataDetail.modified_by;
					detailModal.querySelector('#productStatusProductDetail').textContent = productDataDetail.status_product;
					detailModal.querySelector('#productTypeDetail').textContent = productDataDetail.product_type;
					var pictVarian = detailModal.querySelector('#productPictDetail');
					pictVarian.src = src + '/' + productDataDetail.product_pict;
					
				})
		})
	});

</script>
