           <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">
                            <i class="{$current_page.nav_icon}"></i>
                            <span>{$current_page.nav_title}</span>
                        </h4>
                    </div> 

            </div> 

            <div class="container promotions-container mb-5">
                <div class="d-flex flex-column align-items-center">
                    <div class="heading-page p-2 mt-4">
                        <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Detail Promosi</b></h2>
                    </div>
                </div>
            </div>

                    <style>
            .custom-card {
                margin-bottom: 20px; /* Adjust the margin as needed to control the spacing */
            }
        </style>

<div class="row justify-content-center mb-4">
    <div class="mt-4col-md-6">
        <div class="card custom-card" style="width: 380px; height: auto;">
        <img src="{$BASEURL}/resource/assets-frontend/dist/promotion/{$promotions->promotion_photo}"  alt="product-kenes" class="img-fluid rounded-2 product-kenes" style="width: 100%; height: auto;">
            <div class="card-body">
                <p class="card-text"></p>
            </div>
        </div>    
    </div>
    <div class="col-md-6">
        <div class="card custom-card">
            <div class="form-group">
                <label for="promotion_code" class="col-sm-6 control-label">Promotion Code : </label>
                <div class="col-sm-4">
                    <p class="form-control-static bg-success">{$promotions->promotion_code}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_code" class="col-sm-6 control-label">ID Promotion :</label>
                <div class="col-sm-4">
                    <p class="form-control-static">{$promotions->promotion_id}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_name" class="col-sm-6 control-label">Promotion Name :</label>
                <div class="col-sm-4">
                    <p class="form-control-static">{$promotions->promotion_name}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_name" class="col-sm-6 control-label">Promotion Price:</label>
                <div class="col-sm-4">
                    <p class="form-control-static">Rp. {$promotions->promotion_price|number_format:0:".":"."}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_st" class="col-sm-6 control-label">Promotion Status:</label>
                <div class="col-sm-4">
                    <p class="form-control-static">{if {$promotions->promotion_st} == 0}Active{else}Inactive{/if}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_type" class="col-sm-6 control-label">Promotion Desc :</label>
                <div class="col-sm-4">
                    <p class="form-control-static">{$promotions->promotion_desc}</p>
                </div>
            </div>
        </div>
    </div>
</div>





          
