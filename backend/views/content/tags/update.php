<?php
$this->title = Yii::t('app', 'Edit Tag: {title}', [
    'title' => $info->title,
]);

$this->page_title = Yii::t('app', 'Edit Tag: <span>{title}</span>', [
    'title' => $info->title,
]);

$this->breadcrumb_title = 'Edit Tag';
$this->breadcrumbs[] = ['label' => 'Tags', 'url' => $main_url]; ?>

<div class="Post-update">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
        'translations' => $translations,
    ]); ?>
</div>