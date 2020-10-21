<?php
$this->title = Yii::t('app', 'Edit City: {name}', [
    'name' => $model->name,
]);

$this->breadcrumb_title = 'Edit City';
$this->breadcrumbs[] = ['label' => 'Cities', 'url' => $main_url . '/cities']; ?>

<div class="City-update">
    <?= $this->render('_form_city', [
        'model' => $model,
    ]) ?>
</div>
