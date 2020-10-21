<?php
$this->title = Yii::t('app', 'Edit Product: {title}', [
    'title' => $info->name,
]);

$this->page_title = Yii::t('app', 'Edit Product: <span>{title}</span>', [
    'title' => $info->name,
]);

$this->breadcrumb_title = 'Edit Product';
$this->breadcrumbs[] = ['label' => 'Products', 'url' => $main_url]; ?>

<div class="Brand-update">
    <?= $this->render('_form', [
        'main_url' => $main_url,
        'actions_url' => $actions_url,
        'vendors_url' => $vendors_url,
        'model' => $model,
        'info' => $info,
        'translations' => $translations,
    ]); ?>
</div>