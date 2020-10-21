<?php
$this->title = Yii::t('app', 'New Product');
$this->page_title = Yii::t('app', 'New Product: ');
$this->breadcrumbs[] = ['label' => 'Products', 'url' => $main_url]; ?>

<div class="Product-create">
    <?= $this->render('_form', [
        'main_url' => $main_url,
        'actions_url' => $actions_url,
        'vendors_url' => $vendors_url,
        'model' => $model,
        'info' => $info,
    ]); ?>
</div>