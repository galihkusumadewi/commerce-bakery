<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">
                <i class="{$current_page.nav_icon}"></i>
                <span>{$current_page.nav_title}</span>
            </h4>
        </div>
        <div class="d-flex align-items-center">
            <div class="btn-group" role="group">
                {if $allowed.create}
                <a class="btn btn-md btn-outline-primary" href="{site_url([$current_page.nav_url, 'add'])}"><i class="fa-solid fa-circle-plus"></i> Tambah</a>
                {/if}
                <!-- Tambahkan tautan atau tombol lain di sini -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table data-tables table-striped">
                <thead>
                    <tr class="light">
                        <th>No            </th>
                        <th>Promotion Code</th>
                        <th>Promotion Name</th>
                        <th>Promotion Desc</th>
                        <th>Action        </th>
                    </tr>
                </thead>
                <tbody>
                   {assign var="no" value=1}
                {foreach from=$promotions key=key item=promotion}
                <tr>
                    <td>{$no++}</td>
                    <td>{$promotion.promotion_code}</td>
                    <td>{$promotion.promotion_name}</td>
                    <td>{$promotion.promotion_desc}</td>
                    <td>
                            <a class="btn btn-sm btn-outline-info rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detail" href="{site_url([$current_page.nav_url, 'detail', {$promotion.promotion_id}])}"><i class="fa-regular fa-file"></i></a>
                            <a class="btn btn-sm btn-outline-secondary rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{site_url([$current_page.nav_url, 'edit', {$promotion.promotion_id}])}"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a class="btn btn-sm btn-outline-danger rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{site_url([$current_page.nav_url, 'delete', $promotion.promotion_id])}"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    {/foreach}
                    <!-- Add more rows with data and actions as needed -->
                    </tbody>

            <!-- Add more rows with data and actions as needed -->
                </tbody>
            </table>
        </div>
    </div>
    

                    <!-- modal delete -->

                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Popup Example</title>
                        <!-- Include FontAwesome CSS (you may need to adjust the version) -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                    </head>
                    <body>

                    <div class="container">
                        <!-- ... Your existing HTML code ... -->
                    </div>

                    <!-- JavaScript to handle delete confirmation -->
                  

                    </body>
                    </html>

                            


</div>
