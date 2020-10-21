<?php
$this->title = Yii::t('app', 'New Tag');
$this->page_title = Yii::t('app', 'New Tag: ');
$this->breadcrumbs[] = ['label' => 'Tags', 'url' => $main_url]; ?>

<div class="Tags-create">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
    ]); ?>
</div>