<?php

use common\models\Countries;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Profile settings';
$this->breadcrumb_title = 'Profile settings';
$this->breadcrumbs[] = ['label' => 'Profile', 'url' => $main_url];

// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form'
    ]
]) ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 form-group required-field">
                <?= $form->field($profile, 'name')->textInput(['required' => 'required']) ?>
            </div>

            <div class="col-md-6 form-group required-field">
                <?= $form->field($profile, 'surname')->textInput(['required' => 'required']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'lastname')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'gender')->dropDownList([
                    0 => '-',
                    1 => 'Male',
                    2 => 'Female'
                ]) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'phone')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'mobile')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?php
                $countries = ArrayHelper::map(Countries::find()->all(), 'ISO', 'name');

                echo $form->field($profile, 'country')->dropDownList(
                    select_array_with_empty_label($countries),
                    ['class' => 'custom-select'],
                ) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'city')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'region')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $form->field($profile, 'postal_code')->textInput(['type' => 'number']) ?>
            </div>

            <div class="col-md-12 form-group">
                <?= $form->field($profile, 'address')->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="col-md-12 form-group position-relative">
                <label for="image">Image</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="image">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-secondary">Select</button>
                    </div>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <?= $form->field($profile, 'bio')->textarea(['class' => 'form-control', 'rows' => 5]) ?>
            </div>
        </div>
    </div>
</div>


<div class="mb-3 full-form-btns">
    <?php
    echo Html::submitButton('<i class="ri-check-line mr-1"></i> Save changes', ['class' => 'btn btn-primary waves-effect btn-with-icon']); ?>

    <a href="<?= $main_url; ?>" class="btn btn-secondary waves-effect btn-with-icon">
        <i class="ri-arrow-left-line mr-1"></i> Back to Profile
    </a>
</div>
<?php ActiveForm::end(); ?>