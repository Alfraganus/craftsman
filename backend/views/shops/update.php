<?php
$this->title = Yii::t('app', 'Edit Shop: {title}', [
    'title' => $model->title,
]);

$this->breadcrumb_title = 'Edit Shop';
$this->breadcrumbs[] = ['label' => 'Shops', 'url' => $main_url]; ?>

<div class="Shop-update">
    <?= $this->render('_form', [
        'main_url' => $main_url,
        'vendors_url' => $vendors_url,
        'model' => $model,
        'shop_info' => $shop_info,
    ]); ?>
</div>