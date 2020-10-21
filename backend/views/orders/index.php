<?php

use \backend\widgets\BulkActions;

$this->title = 'Orders'; ?>

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
</div>

<div class="card">
    <div class="card-body">
        <div class="card-body-top">
            <?= BulkActions::widget(array('actions' => $bulk_actions, 'show_clang' => false)); ?>
        </div>

        <div class="table-responsive table-with-actions">
            <input type="hidden" id="table-selected-items" ta-selected-items>

            <table class="table mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="30px" class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select-all></i>
                        </th>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Vendor</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th width="130px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-success">
                                #AV-11848
                            </a>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-success">
                                New order
                            </a>
                        </td>
                        <td>
                            <a href="<?= $vendors_url; ?>/info?id=10" class="text-secondary">
                                Samsung UZB
                            </a>
                        </td>
                        <td>
                            <span class="text-secondary">3</span>
                        </td>
                        <td>
                            <span class="text-secondary">240.50 $</span>
                        </td>
                        <td>
                            <span class="text-secondary">21/06/2020</span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="complete-order" ta-single-id="10">
                                    <i class="ri-checkbox-circle-line" data-toggle="tooltip" data-placement="top" title="Set as completed"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="cancel-order" ta-single-id="10">
                                    <i class="ri-close-circle-line" data-toggle="tooltip" data-placement="top" title="Cancel order"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash-order" ta-single-id="10">
                                    <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete order"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-danger">
                                #AV-11847
                            </a>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-danger">
                                Processing
                            </a>
                        </td>
                        <td>
                            <a href="<?= $vendors_url; ?>/info?id=10" class="text-secondary">
                                Artel
                            </a>
                        </td>
                        <td>
                            <span class="text-secondary">8</span>
                        </td>
                        <td>
                            <span class="text-secondary">956.53 $</span>
                        </td>
                        <td>
                            <span class="text-secondary">21/06/2020</span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="complete-order" ta-single-id="10">
                                    <i class="ri-checkbox-circle-line" data-toggle="tooltip" data-placement="top" title="Set as completed"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="cancel-order" ta-single-id="10">
                                    <i class="ri-close-circle-line" data-toggle="tooltip" data-placement="top" title="Cancel order"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash-order" ta-single-id="10">
                                    <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete order"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-primary">
                                #AV-11846
                            </a>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-primary">
                                Completed
                            </a>
                        </td>
                        <td>
                            <a href="<?= $vendors_url; ?>/info?id=10" class="text-secondary">
                                Samsung UZB
                            </a>
                        </td>
                        <td>
                            <span class="text-secondary">4</span>
                        </td>
                        <td>
                            <span class="text-secondary">1 500 $</span>
                        </td>
                        <td>
                            <span class="text-secondary">26/06/2020</span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="new-order" ta-single-id="10">
                                    <i class="ri-flashlight-line" data-toggle="tooltip" data-placement="top" title="Set as new"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="cancel-order" ta-single-id="10">
                                    <i class="ri-close-circle-line" data-toggle="tooltip" data-placement="top" title="Cancel order"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash-order" ta-single-id="10">
                                    <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete order"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ta-select-icon">
                            <i class="ri-checkbox-blank-line" data-ta-select="1"></i>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-secondary">
                                #AV-11845
                            </a>
                        </td>
                        <td>
                            <a href="<?= $main_url; ?>/edit?id=10" class="text-secondary">
                                Cancelled
                            </a>
                        </td>
                        <td>
                            <a href="<?= $vendors_url; ?>/info?id=10" class="text-secondary">
                                Hayot Suv
                            </a>
                        </td>
                        <td>
                            <span class="text-secondary">1</span>
                        </td>
                        <td>
                            <span class="text-secondary">16 $</span>
                        </td>
                        <td>
                            <span class="text-secondary">30/06/2020</span>
                        </td>
                        <td class="ta-icons-block">
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="new-order" ta-single-id="10">
                                    <i class="ri-flashlight-line" data-toggle="tooltip" data-placement="top" title="Set as new"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="complete-order" ta-single-id="10">
                                    <i class="ri-checkbox-circle-line" data-toggle="tooltip" data-placement="top" title="Set as completed"></i>
                                </a>
                            </div>
                            <div class="ta-icons-in">
                                <a href="javascript:void(0);" ta-single-action="trash-order" ta-single-id="10">
                                    <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete order"></i>
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