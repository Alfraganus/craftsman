<?php
$this->title = Yii::t('app', 'New Vendor');
$this->breadcrumbs[] = ['label' => 'Vendor', 'url' => $main_url]; ?>

<div class="Vendor-create">
    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]); ?>
</div>