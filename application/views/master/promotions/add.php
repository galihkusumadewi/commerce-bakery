<main>
    <div class="container promotions-container mb-5">
        <div class="d-flex flex-column align-items-center">
            <div class="heading-page p-2 mt-4">
                <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Tambah Data promotion</b></h2>
            </div>
        </div>
    </div>

    <form method="post" action="{site_url([$current_page.nav_url, 'add'])}" enctype="multipart/form-data">
        <div class="row">
            <div class="col col-md-9 mx-auto">
              
                {if $validasi = validation_errors()}
                <div class="d-flex flex-column alert alert-danger">
                    {$validasi}
                </div>
                {/if}
                 
            
           
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="promotionCode">Promotion Code</label>
                            <input type="text"  class="form-control" name="promotion_code" id="promotionCode">
                        </div>
                        <div class="form-group">
                            <label for="promotionType">Promotion name</label>
                             <input type="text" class="form-control" name="promotion_name" id="promotion_name">
                        </div>
                        <div class="form-group">
                            <label for="promotionType">Promotion Price</label>
                             <input type="text" class="form-control" name="promotion_price" id="promotion_price">
                        </div>
                        <div class="row justify-content mb-4">
                        <div class="col-md-3">
                            <label for="promotion_description" class="col-md-12 col-form-label">Promotion Description</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="summernote" name="promotion_description" ></textarea>
                        
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="promotionPict">promotion Pict</label>
                            <input type="file" class="form-control-file" name="promotion_photo" id="promotion_pict">
                        </div>
                        <div class="form-group">
                            <label for="promotionSt">promotion Status</label>
                            <select id="promotionSt" name="promotion_st" class="form-control">
                                <option value="0" selected>Active</option>
                                <option value="1">Inactive</option>
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
