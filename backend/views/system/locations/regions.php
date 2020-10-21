<?php

use backend\widgets\BulkActions;
use common\models\Countries;
use common\models\Cities;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

$country_id = input_get('country');
$this->title = 'Locations'; ?>

<div class="card-top-links row">
    <div class="col-md-7">
        <div class="card-listed-links">
            <a href="<?= $main_url; ?>">
                Countries
            </a>
            <a href="<?= $main_url . '/cities'; ?>">
                Cities
            </a>
            <a href="<?= $main_url . '/regions'; ?>" class="active">
                Regions
            </a>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-listed-links-right">
            <a href="<?= $main_url; ?>/create?type=region" class="btn btn-info waves-effect">
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
            <?php
            $countries = ArrayHelper::map(Countries::find()->asArray()->all(), 'id', 'name');
            $cities = array();
            
            if (is_numeric($country_id) && $country_id > 0) {
                $cities_where = array('country_id' => $country_id);
                $cities_orderby = array('name' => 'ASC');
                $cities_query = Cities::find()->asArray()->where($cities_where)->orderBy($cities_orderby)->all();
                $cities = ArrayHelper::map($cities_query, 'id', 'name');
            }

            $bulk_actions_args = ['actions' => false, 'show_clang' => false, 'countries' => $countries, 'cities' => $cities];
            echo BulkActions::widget($bulk_actions_args); ?>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th width="150px">Status</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($region) : ?>
                        <?php foreach ($region as $key => $one) : ?>
                            <tr>
                                <td>
                                    <strong><?= $one->name ?></strong>
                                </td>
                                <td>
                                    <strong><?= $one->city->name ?></strong>
                                </td>
                                <td>
                                    <strong><?= $one->country->name ?></strong>
                                </td>
                                <td>
                                    <?php if ($one->status == 1) : ?>
                                        <span class="text-secondary">Active</span>
                                    <?php else : ?>
                                        <span class="text-danger">Disabled</span>
                                    <?php endif ?>
                                </td>
                                <td class="ta-icons-block">
                                    <div class="ta-icons-in">
                                        <a href="<?= $main_url; ?>/edit?type=region&id=<?= $one->id ?>">
                                            <i class="ri-edit-2-fill" data-toggle="tooltip" data-placement="top" title="Edit region"></i>
                                        </a>
                                    </div>
                                    <div class="ta-icons-in">
                                        <a href="javascript:void(0);" ta-single-action="delete" ta-single-id="<?= $one->id ?>">
                                            <i class="ri-delete-bin-2-line" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center table-not-found">
                                <i class="ri-error-warning-line"></i>
                                <div class="h5">
                                    Regions not found!
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
        'prevPageLabel' => 'previous',
        'nextPageLabel' => 'next',
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link']
    ]); ?>
</nav>