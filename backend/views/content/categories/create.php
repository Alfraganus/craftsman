<?php
$this->title = Yii::t('app', 'New Category');
$this->page_title = Yii::t('app', 'New Category: ');
$this->breadcrumbs[] = ['label' => 'Categories', 'url' => $main_url]; ?>

<div class="Category-create">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
    ]); ?>
</div>