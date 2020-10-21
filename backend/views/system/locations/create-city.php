<?php
$this->title = Yii::t('app', 'New City');
$this->breadcrumbs[] = ['label' => 'Cities', 'url' => $main_url . '/cities']; ?>

<div class="City-create">
    <?= $this->render('_form_city', [
        'model' => $model,
    ]) ?>
</div>