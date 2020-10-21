<?php

use backend\models\Locations;
use common\models\Logs;
use common\models\Profile;
use common\models\UsersSession;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Vendor: {email}', [
    'email' => $user->username,
]);

$this->breadcrumb_title = 'Info';
$this->breadcrumbs[] = ['label' => 'Customers', 'url' => $main_url];

$active_tab = input_get('tab', 'profile');

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
    <?php elseif ($active_tab == 'activity') : ?>
        <?php
        $usersActivitiesArgs = array(
            'where' => array('user_id' => $user->id),
            'order_by' => array('created_on' => 'DESC'),
        );
        $usersActivities = Logs::getAdminLogs($usersActivitiesArgs); ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Activity list</h3>
                    <p class="card-title-desc">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nam quos ut autem quidem iste molestiae, eaque quo quod laudantium repudiandae recusandae a omnis id. Ab at quas vero inventore.
                    </p>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Session</th>
                                    <th width="200px">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($usersActivities) : ?>
                                    <?php foreach ($usersActivities as $usersActivity) : ?>
                                        <?php
                                        $activityItem = Logs::logItemView($usersActivity);
                                        $browser_session = json_decode($usersActivity->browser); ?>
                                        <tr>
                                            <td><?= $activityItem->type_name ?></td>
                                            <td><?= $activityItem->action_name ?></td>
                                            <td>
                                                <?php
                                                if ($browser_session) {
                                                    echo '<span>IP: ' . $browser_session->ip_address . '</span>';
                                                    echo '<br>';
                                                    echo '<span>' . $browser_session->session . '</span>';
                                                } else {
                                                    echo '-';
                                                } ?>
                                            </td>
                                            <td><?= $activityItem->created_on ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center table-not-found">
                                            <i class="ri-error-warning-line"></i>
                                            <div class="h5">
                                                Data not found!
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
    <?php elseif ($active_tab == 'sessions') : ?>
        <?php $usersSession = UsersSession::getLog($user->id); ?>
        <!-- Tab item -->
        <div class="tab-pane active">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">User sessions</h3>
                    <p class="card-title-desc">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nam quos ut autem quidem iste molestiae, eaque quo quod laudantium repudiandae recusandae a omnis id. Ab at quas vero inventore.
                    </p>
                    <div class="table-responsive">
                        <?php if ($usersSession && $usersSession['history']) : ?>
                            <table class="table table-bordered dt-responsive nowrap" data-table>
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Browser</th>
                                        <th width="200">OS</th>
                                        <th width="200">IP address</th>
                                        <th width="200">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usersSession['history'] as $key => $session) : ?>
                                        <?php $i = $key + 1; ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $session->browser_name . ' ' . $session->browser_version ?></td>
                                            <td><?= $session->platform ?></td>
                                            <td><?= $session->ip_address ?></td>
                                            <td><?= $session->date; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Browser</th>
                                        <th width="200">OS</th>
                                        <th width="200">IP address</th>
                                        <th width="200">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center table-not-found">
                                            <i class="ri-error-warning-line"></i>
                                            <div class="h5">
                                                Sessions not found!
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
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
                        <img class="card-img-top img-fluid profile-info-box-img" src="<?= Profile::getAvatar($profile); ?>" alt="Profile image">
                        <div class="card-body text-center">
                            <h3 class="card-title mt-0 mb-2"><?= $profile->name . ' ' . $profile->surname . ' ' . $profile->lastname ?></h3>
                            <p class="mb-3"><?= $user->email ?></p>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="<?= $main_url; ?>/edit?id=<?= $user->id; ?>">Edit user</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="profile-info-right">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Profile informations</h3>
                            <p class="card-title-desc">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nam quos ut autem quidem iste molestiae, eaque quo quod laudantium repudiandae recusandae a omnis id. Ab at quas vero inventore.
                            </p>

                            <div class="table-responsive">
                                <table class="table table-user-infos table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td><b>Username</b>: <?= $user->username ?></td>
                                            <td><b>Email</b>: <?= $user->email ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone</b>: <?= $profile->phone ? $profile->phone : '-' ?></td>
                                            <td><b>Mobile</b>: <?= $profile->mobile ? $profile->mobile : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Gender</b>: <?= gender((is_numeric($profile->gender) ? $profile->gender : '0')) ?></td>
                                            <td><b>Birthday</b>: <?= $profile->birthdate ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Country</b>: <?= $profile->country ? Locations::getCountry(['ISO' => $profile->country], 'name') : '-' ?></td>
                                            <td><b>City</b>: <?= $profile->city ? $profile->city : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Region</b>: <?= $profile->country ? $profile->region : '-' ?></td>
                                            <td><b>Postal code</b>: <?= $profile->postal_code ? $profile->postal_code : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Address</b>: <?= $profile->address ? $profile->address : '-' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Biography</b>: <?= $profile->bio ? $profile->bio : '-' ?>
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