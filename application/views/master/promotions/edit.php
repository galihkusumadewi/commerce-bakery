<main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content p-4">
                                    <div class="modal-header border-0">
                                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Sign Up</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <script>
                                            document.getElementById('showRegisterModal').addEventListener('click', function(event) {
                                                event.preventDefault();
                                                var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                                modal.show();
                                            });
                                        </script>
                                        

                                        <form action="{site_url('register')}" method="post">
                                            <div class="mb-3">
                                            <label for="fullName" class="form-label">Name</label>
                                            <input name="fullname" type="text" class="form-control" id="fullName" placeholder="Enter Your Name" required="">
                                            </div>
                                            <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email address" required="">
                                            </div>
                                
                                            <div class="mb-5">
                                            <label for="password" class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" required="">
                                            <small class="form-text">By Signup, you agree to our <a href="#!">Terms of Service</a> &amp; <a href="#!">Privacy Policy</a></small>
                                            </div>
                                
                                            <button type="submit" class="btn" style="background-color: #662A0C; color: #fff;">Sign Up</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-0 justify-content-center">
                                        <small class="text-nowrap mt-2">Already have an account? <a href="login" class="link-underline link-underline-opacity-0"><small class="fw-bold" style="color: #662A0C;">Login</small></a> </small>
                                    </div>
                                </div>
                            </div>
                        </div> 
    <div class="container promotions-container mb-5">
        <div class="d-flex flex-column align-items-center">
            <div class="heading-page p-2 mt-4">
                <h2 class="text-uppercase fw-medium text-center"><b style="color:#662A0C">Edit Promosi</b></h2>
            </div>
        </div>
    </div>

    <form method="post" action="{site_url([$current_page.nav_url, 'edit', {$promotions->promotion_id}])}" enctype="multipart/form-data">
        <div class="row">
            <div class="col col-md-6 mx-auto">
              
                <div class="d-flex flex-column ">
                 
                </div>
           
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="promotionCode">Promotion ID</label>
                            <input type="text" value="{$promotions->promotion_id}" class="form-control" name="promotion_id" id="promotionId">
                        </div>
                        <div class="form-group">
                            <label for="promotionCode">Promotion Code</label>
                            <input type="text" value="{$promotions->promotion_code}" class="form-control" name="promotion_code" id="promotionCode">
                        </div>
                        
                        <div class="form-group">
                            <label for="promotionType">Promotion name</label>
                            <input type="text" class="form-control" name="promotion_name" id="promotion_name" value="{$promotions->promotion_name}">
                        </div>
                        <div class="form-group">
                            <label for="promotionType">Promotion Price</label>
                            <input type="text" class="form-control" name="promotion_price" id="promotion_price" value="{$promotions->promotion_price}">
                        </div>
                        <div class="form-group">
                            
                            <label for="promotion_description" class="col-form-label">Promotion Description</label>
                            <textarea id="summernote" name="promotion_description" value="" >{$promotions->promotion_desc}</textarea>
                        </div>
                       
                        <div class="form-group">
                            <label for="promotionPict">promotion Pict</label>
                            <input type="file" class="form-control-file" name="promotion_photo" id="promotion_photo">
                        </div>
                        <div class="form-group">
                            <label for="promotionSt">promotion Status</label>
                            <select id="promotionSt" name="promotion_st" class="form-control" value="{$promotions->promotion_st}">
                                <option value="1" {if $promotions->promotion_st == '1'} selected {/if} >Inactive</option>
                                <option value="0" {if $promotions->promotion_st == '0'} selected {/if} >Active</option>
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
