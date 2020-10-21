<?php

use \backend\widgets\BulkActions;

$this->title = 'Sponsored Products'; ?>

<div class="card-top-links row">
    <div class="col-md-7">
        <div class="card-listed-links">
            <?php foreach ($page_types as $page_type_key => $page_type) : ?>
                <a href="<?= $main_url . '/' . $page_type_key; ?>" <?= $page_type['active'] ? 'class="active"' : ''; ?>>
                    <?= $page_type['name']; ?>
                    <span>(<?= $page_type['count']; ?>)</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-listed-links-right">
            <a href="<?= $actions_url; ?>/create" class="btn btn-info waves-effect">
                Add new
            </a>
            <a href="<?= admin_url(); ?>" class="btn btn-secondary waves-effect">
                Close
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-body-top">
            <?= BulkActions::widget(array('actions' => $bulk_actions)); ?>
        </div>
        
        <div class="table-responsive table-with-actions">
            <input type="hidden" id="table-selected-items" ta-selected-items>

            <table class="table products-table mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="30px" class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select-all></i>
                        </th>
                        <th width="80px">Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th class="text-center" width="80px">Status</th>
                        <th width="160px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a class="product-table-image-preview image-popup-vertical-fit" href="https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg">
                                <span style="background-image: url(https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg);"></span>
                            </a>
                        </td>
                        <td>
                            <a href="<?= $actions_url; ?>/edit?id=10" class="products-table-title " title="{product_name}">
                                Apple Iphone 11 (6.1) Içi Kadife Lansman Silikon Kılıf Mavi    
                            </a>
                            <strong class="products-table-upc text-secondary" title="{upc_code}">
                                UPC: GRA-L8KS5LS
                            </strong>
                            <strong class="products-table-upc text-secondary">
                                Stock: 300
                            </strong>
                        </td>
                        <td>
                            <s class="text-secondary">150 $</s><br>
                            <b class="text-dark">120 $</br>
                        </td>
                        <td class="text-center">
                            <span class="dot-status-success" data-toggle="tooltip" data-placement="bottom" title="Published"></span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="#">
                                    <i class="ri-share-box-line" data-toggle="tooltip" data-placement="top" title="Open on the site"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="quick-edit" ta-single-id="10">
                                    <i class="ri-edit-2-fill" data-toggle="tooltip" data-placement="top" title="Quick edit"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="copy" ta-single-id="10">
                                    <i class="ri-file-copy-line" data-toggle="tooltip" data-placement="top" title="Copy"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="unpublish" ta-single-id="10">
                                    <i class="ri-eye-off-line" data-toggle="tooltip" data-placement="top" title="Unpublish"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash" ta-single-id="10">
                                    <i class="ri-delete-bin-6-line" data-toggle="tooltip" data-placement="top" title="Move to trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a class="product-table-image-preview image-popup-vertical-fit" href="https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg">
                                <span style="background-image: url(https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg);"></span>
                            </a>
                        </td>
                        <td>
                            <a href="<?= $actions_url; ?>/edit?id=10" class="products-table-title " title="{product_name}">
                                Apple Iphone 11 (6.1) Içi Kadife Lansman Silikon Kılıf Mavi    
                            </a>
                            <strong class="products-table-upc text-secondary" title="{upc_code}">
                                UPC: GRA-L8KS5LS
                            </strong>
                            <strong class="products-table-upc text-secondary">
                                Stock: 300
                            </strong>
                        </td>
                        <td>
                            <b class="text-dark">520 $</b>
                        </td>
                        <td class="text-center">
                            <span class="dot-status-secondary" data-toggle="tooltip" data-placement="bottom" title="Pending"></span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="#">
                                    <i class="ri-share-box-line" data-toggle="tooltip" data-placement="top" title="Open on the site"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="quick-edit" ta-single-id="10">
                                    <i class="ri-edit-2-fill" data-toggle="tooltip" data-placement="top" title="Quick edit"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="copy" ta-single-id="10">
                                    <i class="ri-file-copy-line" data-toggle="tooltip" data-placement="top" title="Copy"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="unpublish" ta-single-id="10">
                                    <i class="ri-eye-off-line" data-toggle="tooltip" data-placement="top" title="Unpublish"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash" ta-single-id="10">
                                    <i class="ri-delete-bin-6-line" data-toggle="tooltip" data-placement="top" title="Move to trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a class="product-table-image-preview image-popup-vertical-fit" href="https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg">
                                <span style="background-image: url(https://cdn.dsmcdn.com//assets/product/media/images/20200302/11/3961570/64756971/1/1_org.jpg);"></span>
                            </a>
                        </td>
                        <td>
                            <a href="<?= $actions_url; ?>/edit?id=10" class="products-table-title " title="{product_name}">
                                Apple Iphone 11 (6.1) Içi Kadife Lansman Silikon Kılıf Mavi    
                            </a>
                            <strong class="products-table-upc text-secondary" title="{upc_code}">
                                UPC: GRA-L8KS5LS
                            </strong>
                            <strong class="products-table-upc text-secondary">
                                Stock: 300
                            </strong>
                        </td>
                        <td>
                            <b class="text-dark">215.40 $</b>
                        </td>
                        <td class="text-center">
                            <span class="dot-status-danger" data-toggle="tooltip" data-placement="bottom" title="Unpublished"></span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="#">
                                    <i class="ri-share-box-line" data-toggle="tooltip" data-placement="top" title="Open on the site"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="quick-edit" ta-single-id="10">
                                    <i class="ri-edit-2-fill" data-toggle="tooltip" data-placement="top" title="Quick edit"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="copy" ta-single-id="10">
                                    <i class="ri-file-copy-line" data-toggle="tooltip" data-placement="top" title="Copy"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="publish" ta-single-id="10">
                                    <i class="ri-checkbox-circle-line" data-toggle="tooltip" data-placement="top" title="Publish"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash" ta-single-id="10">
                                    <i class="ri-delete-bin-6-line" data-toggle="tooltip" data-placement="top" title="Move to trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<nav>
    <ul class="pagination pagination-rounded">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item active">
            <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>