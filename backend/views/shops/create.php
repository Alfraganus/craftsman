<?php
$this->title = 'New Shop';
$this->breadcrumbs[] = ['label' => 'Shops', 'url' => $main_url]; ?>

<div class="Shop-create">
    <?= $this->render('_form', [
        'main_url' => $main_url,
        'vendors_url' => $vendors_url,
        'model' => $model,
        'shop_info' => $shop_info,
    ]); ?>
</div>