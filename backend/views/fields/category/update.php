<?php
$this->title = Yii::t('app', 'Edit Category: {title}', [
    'title' => $info->title,
]);

$this->page_title = Yii::t('app', 'Edit Category: <span>{title}</span>', [
    'title' => $info->title,
]);

$this->breadcrumb_title = 'Edit Category';
$this->breadcrumbs[] = ['label' => 'Categories', 'url' => $main_url]; ?>

<div class="Category-update">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
        'translations' => $translations,
    ]); ?>
</div>