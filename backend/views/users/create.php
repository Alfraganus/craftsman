<?php
$this->title = Yii::t('app', 'New User');
$this->breadcrumbs[] = ['label' => 'Customers', 'url' => $main_url]; ?>

<div class="User-create">
    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]); ?>
</div>