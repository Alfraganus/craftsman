<?php
$this->title = Yii::t('app', 'Edit Region: {name}', [
    'name' => $model->name,
]);

$this->breadcrumb_title = 'Edit Region';
$this->breadcrumbs[] = ['label' => 'Regions', 'url' => $main_url . '/regions']; ?>

<div class="Region-create">
    <?= $this->render('_form_region', [
        'model' => $model,
    ]) ?>
</div>
