<?php
$this->title = Yii::t('app', 'New Brand');
$this->page_title = Yii::t('app', 'New Brand: ');
$this->breadcrumbs[] = ['label' => 'Brands', 'url' => $main_url]; ?>

<div class="Brand-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>