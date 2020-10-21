<?php
$this->title = Yii::t('app', 'Edit Post: {title}', [
    'title' => $info->title,
]);

$this->page_title = Yii::t('app', 'Edit Post: <span>{title}</span>', [
    'title' => $info->title,
]);

$this->breadcrumb_title = 'Edit Post';
$this->breadcrumbs[] = ['label' => 'Posts', 'url' => $main_url]; ?>

<div class="Post-update">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
        'translations' => $translations,
    ]); ?>
</div>