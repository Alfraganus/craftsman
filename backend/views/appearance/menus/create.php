<?php
$this->title = Yii::t('app', 'New Menu');
$this->page_title = Yii::t('app', 'New Menu: ');
$this->breadcrumbs[] = ['label' => 'Menus', 'url' => $main_url]; ?>

<div class="Page-create">
    <?= $this->render('_form', [
        'menu' => $menu,
        'model' => $model,
        'items' => $items,
    ]); ?>
</div>