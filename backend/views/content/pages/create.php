<?php
$this->title = Yii::t('app', 'New Page');
$this->page_title = Yii::t('app', 'New Page: ');
$this->breadcrumbs[] = ['label' => 'Pages', 'url' => $main_url]; ?>

<div class="Page-create">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
    ]); ?>
</div>