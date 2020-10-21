<?php
$this->title = Yii::t('app', 'Edit Page: {title}', [
    'title' => $info->title,
]);

$this->page_title = Yii::t('app', 'Edit Page: <span>{title}</span>', [
    'title' => $info->title,
]);

$this->breadcrumb_title = 'Edit Page';
$this->breadcrumbs[] = ['label' => 'Pages', 'url' => $main_url]; ?>

<div class="Page-update">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
        'translations' => $translations,
    ]); ?>
</div>