<?php
$this->title = Yii::t('app', 'Edit Customer: {email}', [
    'email' => $model->email,
]);

$this->breadcrumb_title = 'Edit Customer';
$this->breadcrumbs[] = ['label' => 'Customers', 'url' => $main_url]; ?>

<div class="User-update">
    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]); ?>
</div>