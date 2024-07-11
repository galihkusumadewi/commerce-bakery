<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">
                <i class="{$current_page.nav_icon}"></i>
                <span>{$current_page.nav_title}</span>
            </h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table data-tables table-striped">
                <thead>
                    <tr class="light">
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Pekerjaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {$no = 1}
                    {foreach from=$pelamar key=key item=data_pelamar}
                    <tr>
                        <td>{$no++}</td>
                        <td>{$data_pelamar.nama_lengkap}</td>
                        <td>{$data_pelamar.job_name}</td>
                        <td align="center">
                            <a class="btn btn-sm btn-outline-info rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{site_url([$current_page.nav_url, 'detail', {$data_pelamar.id_pelamar}])}"><i class="fa-regular fa-file"></i></a>
                            <a class="btn btn-sm btn-outline-danger rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download" href="{site_url([$current_page.nav_url, 'download', {$data_pelamar.id_pelamar}])}"><i class="fa-solid fa-download"></i></a>
                            {if $data_pelamar.phone}
                            <!-- Tautan WhatsApp -->
                            <a target="_blank" href="{site_url([$current_page.nav_url,'whatsapp' , {$data_pelamar.id_pelamar}])}" class="btn btn-sm btn-outline-success rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Whatsapp"><i class="fa-brands fa-whatsapp"></i>
                            </a>

                            {/if}

                            {if $allowed.delete}
                            <a class="btn btn-sm btn-outline-danger rounded" data-toggle="modal" data-placement="top" title="" data-original-title="Delete" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>
                            {/if}

                        </td>
                    </tr>

                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="{site_url([$current_page.nav_url, 'delete', {$data_pelamar.id_pelamar}])}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure want to delete this?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>




</div>