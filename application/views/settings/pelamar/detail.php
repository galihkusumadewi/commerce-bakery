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
                        <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Detail Pelamar</b></h2>
                    </div>
                </div>
            </div>

                    <style>
            .custom-card {
                margin-bottom: 20px; /* Adjust the margin as needed to control the spacing */
            }
        </style>
              <div class="row justify-content-center mb-4">
    <div class="col-md-6">
        <div class="card custom-card" style="width: 380px; height: auto; margin: 0 auto;">
            <img src="{$BASEURL}/resource/assets-frontend/dist/pelamar/foto/{$detail_pelamar.foto_pelamar}" alt="Foto Pelamar" class="img-fluid rounded-2 product-kenes" style="width: 100%; height: auto;">
        </div>
    </div>
    <div class="col-md-6" style="margin-left: -15px;"> <!-- Menambahkan margin ke kiri untuk mengurangi jarak -->
        <div class="card custom-card mx-auto">
            <div class="form-group">
                <label for="pelamar_id" class="col-sm-6 control-label">ID Pelamar :</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.id_pelamar}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Pelamar Name :</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.nama_lengkap}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Email:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.email}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-6 control-label">Phone:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.phone}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Tempat Lahir:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.tempat_lahir}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Tanggal Lahir:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.tanggal_lahir}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Jenis Kelamin:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.jenis_kelamin}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="pelamar_name" class="col-sm-6 control-label">Tanggal Daftar:</label>
                <div class="col-sm-6">
                    <p class="form-control-static">{$detail_pelamar.created}</p>
                </div>
            </div>
        </div>
    </div>
</div>




</div>





          
