<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change password';
$this->breadcrumb_title = 'Change password';
$this->breadcrumbs[] = ['label' => 'Profile', 'url' => $main_url];

// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form'
    ]
]) ?>

<div class="card">
    <div class="card-body">
        <div class="form-group required-field">
            <?= $form->field($model, 'old_password')->textInput(['required' => 'required', 'type' => 'password']) ?>
        </div>
        <div class="form-group required-field">
            <?= $form->field($model, 'new_password')->textInput(['required' => 'required', 'type' => 'password']) ?>
        </div>
        <div class="required-field">
            <?= $form->field($model, 'confirm_password')->textInput(['required' => 'required', 'type' => 'password']) ?>
        </div>
    </div>
</div>


<div class="mb-3 full-form-btns">
    <?php
    echo Html::submitButton('<i class="ri-check-line mr-1"></i> Change password!', ['class' => 'btn btn-primary waves-effect btn-with-icon']); ?>

    <a href="<?= $main_url; ?>" class="btn btn-secondary waves-effect btn-with-icon">
        <i class="ri-arrow-left-line mr-1"></i> Back to Profile
    </a>
</div>
<?php ActiveForm::end(); ?>