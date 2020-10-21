<?php
$this->title = Yii::t('app', 'Edit Menu: {title}', [
    'title' => $info->title,
]);

$this->page_title = Yii::t('app', 'Edit Menu: <span>{title}</span>', [
    'title' => $info->title,
]);

$this->breadcrumb_title = 'Edit Menu';
$this->breadcrumbs[] = ['label' => 'Menus', 'url' => $main_url]; ?>

<div class="Page-update">
    <?= $this->render('_form', [
        'menu' => $menu,
        'model' => $model,
    ]); ?>
</div>