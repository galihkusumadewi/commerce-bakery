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
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table data-tables table-striped">
                <thead>
                    <tr class="light">
                        <th>No</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product St</th>
                        <!-- <th>Product Pict</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var="no" value=1}
                    {foreach from=$products key=key item=product}
                    <tr>
                        <td align="center">{$no++}</td>
                        <td>{$product->product_code}</td>
                        <td>{$product->product_name}</td>
                        <td>{if $product->product_st == 0}Active{else}Tidak Aktif{/if}</td>
                        <td align="center">
                            <a class="btn btn-sm btn-outline-info rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detail" href="{site_url([$current_page.nav_url, 'detail'])}?id={$product->product_id}"><i class="fa-regular fa-file"></i></a>
                            {if $allowed.edit}
                            <a class="btn btn-sm btn-outline-secondary rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{site_url([$current_page.nav_url, 'edit'])}?id={$product->product_id}"><i class="fa-regular fa-pen-to-square"></i></a>
                            {/if}
                            {if $allowed.delete}
                            <a class="btn btn-sm btn-outline-danger rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{site_url([$current_page.nav_url, 'delete'])}?id={$product->product_id}"><i class="fa-solid fa-trash"></i></a>
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>