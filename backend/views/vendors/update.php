<?php
$this->title = Yii::t('app', 'Edit Vendor: {email}', [
    'email' => $model->email,
]);

$this->breadcrumb_title = 'Edit Vendor';
$this->breadcrumbs[] = ['label' => 'Vendors', 'url' => $main_url]; ?>

<div class="Vendor-update">
    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]); ?>
</div>