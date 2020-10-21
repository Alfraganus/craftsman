<?php
$this->title = Yii::t('app', 'Edit Brand: {title}', [
    'title' => $model->title,
]);

$this->page_title = Yii::t('app', 'Edit Brand: <span>{title}</span>', [
    'title' => $model->title,
]);

$this->breadcrumb_title = 'Edit Brand';
$this->breadcrumbs[] = ['label' => 'Brands', 'url' => $main_url]; ?>

<div class="Brand-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>