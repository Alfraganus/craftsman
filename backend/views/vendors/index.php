<?php

use backend\models\User;
use common\models\Profile;
use backend\widgets\BulkActions;
use yii\widgets\LinkPager;

$this->title = 'Vendors'; ?>

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
            <a href="<?= $main_url; ?>/create" class="btn btn-info waves-effect">
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
                        <th>Fullname</th>
                        <th>Shop name</th>
                        <th>Email</th>
                        <th width="200px">Phone</th>
                        <th class="text-center" width="80px">Status</th>
                        <th width="150px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users) : ?>
                        <?php foreach ($users as $user) : ?>
                            <?php
                            $status_text = 'Published';
                            $status_class = 'dot-status-success';
                            $fullname = Profile::getFullname($user->profile);
                            $shop = User::getShop($user->id);

                            if ($user->deleted) {
                                $status_text = 'Deleted';
                                $status_class = 'dot-status-danger';
                            } elseif ($user->status == User::PENDING) {
                                $status_text = 'Unpublished';
                                $status_class = 'dot-status-warning';
                            } elseif ($user->status == User::BANNED) {
                                $status_text = 'Blocked';
                                $status_class = 'dot-status-danger';
                            } ?>
                            <tr>
                                <td class="ta-select-icon">
                                    <i class="ri-checkbox-blank-line" data-ta-select="<?= $user->id ?>"></i>
                                </td>
                                <td>
                                    <a href="<?= $main_url; ?>/edit/<?= $user->id ?>" class="products-table-title" title="<?= $fullname ?>">
                                        <?= $fullname; ?>
                                    </a>
                                    <nav class="nav products-table-nav">
                                        <li class="text-secondary">
                                            Orders: <?= User::countOrders($user->id); ?>
                                        </li>
                                        <li class="text-secondary">
                                            Products: <?= User::countProducts($user->id); ?>
                                        </li>
                                    </nav>
                                </td>
                                <td>
                                    <?php if ($shop) : ?>
                                        <a href="<?= $shops_url; ?>/info?id=<?= $shop->id ?>"><?= $shop->title ?></a>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span><?= $user->email; ?></span>
                                </td>
                                <td><?= $user->profile->phone ? $user->profile->phone : '-'; ?></td>
                                <td class="text-center">
                                    <span class="<?= $status_class; ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $status_text; ?>"></span>
                                </td>
                                <td class="ta-icons-block">
                                    <div class="ta-icons-in">
                                        <a href="#">
                                            <i class="ri-share-box-line" data-toggle="tooltip" data-placement="top" title="Open on the site"></i>
                                        </a>
                                    </div>
                                    <div class="ta-icons-in">
                                        <a href="<?= $main_url; ?>/info/<?= $user->id ?>">
                                            <i class="ri-information-line" data-toggle="tooltip" data-placement="top" title="Informations"></i>
                                        </a>
                                    </div>
                                    <?php if ($user->status == User::ACTIVE) : ?>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="block" ta-single-id="<?= $user->id ?>">
                                                <i class="ri-indeterminate-circle-line" data-toggle="tooltip" data-placement="top" title="Block"></i>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="activate" ta-single-id="<?= $user->id ?>">
                                                <i class="ri-checkbox-circle-line" data-toggle="tooltip" data-placement="top" title="Activate"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($user->deleted) : ?>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="restore" ta-single-id="<?= $user->id ?>">
                                                <i class="ri-refresh-line" data-toggle="tooltip" data-placement="top" title="Restore"></i>
                                            </a>
                                        </div>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="delete" ta-single-id="<?= $user->id ?>">
                                                <i class="ri-delete-bin-2-line" data-toggle="tooltip" data-placement="top" title="Delete permanenty"></i>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="trash" ta-single-id="<?= $user->id ?>">
                                                <i class="ri-delete-bin-6-line" data-toggle="tooltip" data-placement="top" title="Move to trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center table-not-found">
                                <i class="ri-error-warning-line"></i>
                                <div class="h5">
                                    Vendors not found!
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<nav>
    <?php echo LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination pagination-rounded'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'prevPageLabel' => '<i class="ri-arrow-left-s-line"></i>',
        'nextPageLabel' => '<i class="ri-arrow-right-s-line"></i>',
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
    ]); ?>
</nav>