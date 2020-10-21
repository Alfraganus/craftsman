<?php

use backend\models\Locations;
use backend\models\Shop;
use backend\models\User;
use backend\models\Vendors;
use common\models\Logs;
use common\models\Profile;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Shop: {title}', [
    'title' => $shop->title,
]);

$this->breadcrumb_title = 'Info';
$this->breadcrumbs[] = ['label' => 'Shops', 'url' => $main_url];

$active_tab = input_get('tab', 'informations');

$this->registerCss(<<< CSS
    .table-user-infos td {
        width: 50%;
    }
CSS); ?>

<!-- Nav tabs -->
<?php if ($tabs) : ?>
    <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-3">
        <?php foreach ($tabs as $tab) : ?>
            <?php
            $tab_class = 'nav-link';

            if ($active_tab == $tab['link']) {
                $tab_class = 'nav-link active';
            } ?>
            <li class="nav-item">
                <a class="<?= $tab_class; ?>" href="<?= Url::current(['tab' => $tab['link']]); ?>">
                    <span class="d-block d-sm-none"><i class="<?= $tab['icon']; ?>"></i></span>
                    <span class="d-none d-sm-block"><?= $tab['name']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="tab-content">
    <?php if ($active_tab == 'orders') : ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50px">#</th>
                                    <th>Order ID</th>
                                    <th width="200px">Price</th>
                                    <th width="150px">Status</th>
                                    <th width="150px">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center table-not-found">
                                        <i class="ri-error-warning-line"></i>
                                        <div class="h5">
                                            Orders not found!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- /Tab item -->
    <?php elseif ($active_tab == 'products') : ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table products-table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30px">#</th>
                                    <th width="80px">Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th class="text-center" width="100px">Status</th>
                                    <th width="160px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center table-not-found">
                                        <i class="ri-error-warning-line"></i>
                                        <div class="h5">
                                            Products not found!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- /Tab item -->
    <?php elseif ($active_tab == 'vendors') : ?>
        <?php $vendors = Shop::getVendors($shop->id); ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table products-table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center" width="150px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($vendors) : ?>
                                    <?php foreach ($vendors as $vendor) : ?>
                                        <?php
                                        $status_class = 'dot-status-success';

                                        if ($vendor->deleted) {
                                            $status_text = 'Deleted';
                                            $status_class = 'dot-status-danger';
                                        } elseif ($vendor->status == User::PENDING) {
                                            $status_text = 'Unpublished';
                                            $status_class = 'dot-status-warning';
                                        } elseif ($vendor->status == User::BANNED) {
                                            $status_text = 'Blocked';
                                            $status_class = 'dot-status-danger';
                                        } ?>
                                        <tr>
                                            <td>
                                                <a href="<?= $vendors_url ?>/edit/<?= $vendor->id ?>"><?= Profile::getFullname($vendor->profile); ?></a>
                                            </td>
                                            <td><?= $vendor->email; ?></td>
                                            <td><?= $vendor->profile->phone; ?></td>
                                            <td class="text-center">
                                                <span class="<?= $status_class; ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $status_text; ?>"></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center table-not-found">
                                            <i class="ri-error-warning-line"></i>
                                            <div class="h5">
                                                Products not found!
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- /Tab item -->
    <?php else : ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="profile-info-box">
                <div class="profile-info-left">
                    <div class="card">
                        <img class="card-img-top img-fluid profile-info-box-img" src="<?= Shop::shopImage($profile); ?>" alt="Profile image">
                        <div class="card-body text-center">
                            <h3 class="card-title mt-0 mb-2"><?= Shop::shopName($shop) ?></h3>
                            <p class="mb-1"><?= $shop->info->email ?></p>
                            <p class="mb-3"><?= $shop->info->phone ?></p>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="<?= $main_url; ?>/edit?id=<?= $shop->id; ?>">Edit shop</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="profile-info-right">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Shop informations</h3>
                            <p class="card-title-desc">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nam quos ut autem quidem iste molestiae, eaque quo quod laudantium repudiandae recusandae a omnis id. Ab at quas vero inventore.
                            </p>

                            <div class="table-responsive">
                                <table class="table table-user-infos table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td><b>Name</b>: <?= (!empty($shop->title) ? $shop->title : 'Unknown') ?></td>
                                            <td><b>Status</b>: <?= Shop::status($shop->status) ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Company type</b>: <?= (!empty($shop->info->company_type) ? Shop::company_types($shop->info->company_type) : '-') ?></td>
                                            <td><b>Status type</b>: <?= (!empty($shop->type) ? Shop::status_types($shop->type) : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Company No</b>: <?= (!empty($shop->info->company_no) ? $shop->info->company_no : '-') ?></td>
                                            <td><b>Person status</b>: <?= (!empty($shop->info->person_status) ? Shop::person_status($shop->info->person_status) : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b>: <?= (!empty($shop->info->email) ? $shop->info->email : '-') ?></td>
                                            <td><b>Phone</b>: <?= (!empty($shop->info->phone) ? $shop->info->phone : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile</b>: <?= (!empty($shop->info->mobile) ? $shop->info->mobile : '-') ?></td>
                                            <td><b>Fax</b>: <?= (!empty($shop->info->fax) ? $shop->info->fax : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Country</b>: <?= (!empty($shop->info->country) ? Locations::getCountry(['ISO' => $shop->info->country], 'name') : '-') ?></td>
                                            <td><b>City</b>: <?= (!empty($shop->info->city) ? $shop->info->city : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Region</b>: <?= (!empty($shop->info->region) ? $shop->info->region : '-') ?></td>
                                            <td><b>Postal code</b>: <?= (!empty($shop->info->postal_code) ? $shop->info->postal_code : '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Address</b>: <?= (!empty($shop->info->address) ? $shop->info->address : '-') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Description</b>: <?= (!empty($shop->info->description) ? '<br>' . $shop->info->description : '-') ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /Tab item -->
    <?php endif; ?>
</div>