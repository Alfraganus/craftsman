<?php
$this->title = Yii::t('app', 'New Region');
$this->breadcrumbs[] = ['label' => 'Regions', 'url' => $main_url . '/regions']; ?>

<div class="Region-create">
    <?= $this->render('_form_region', [
        'model' => $model,
    ]) ?>
</div>
