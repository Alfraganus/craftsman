<?php
$this->title = Yii::t('app', 'New Post');
$this->page_title = Yii::t('app', 'New Post: ');
$this->breadcrumbs[] = ['label' => 'Posts', 'url' => $main_url]; ?>

<div class="Post-create">
    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
    ]); ?>
</div>