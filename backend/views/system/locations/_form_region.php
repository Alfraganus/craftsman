<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Countries;
use common\models\Cities;

$data = Countries::find()->asArray()->all();
$data1 = Cities::find()->asArray()->all();
$countries = ArrayHelper::map($data, 'id', 'name');
$cities = ArrayHelper::map($data1, 'id', 'name');

$languages = get_active_langs();

// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form'
    ]
]); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group required-field">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'required' => 'required']) ?>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($model, 'country_id')->dropDownList(
                            $countries,
                            [
                                'prompt' => '-',
                                'class' => 'form-control select2',
                                'required' => 'required'
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($model, 'city_id')->dropDownList(
                            $cities,
                            [
                                'prompt' => '-',
                                'class' => 'form-control select2',
                                'required' => 'required'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group required-field">
                    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Disabled'], ['required' => 'required']) ?>
                </div>

                <div class="form-group required-field">
                    <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'required' => 'required', 'value' => 0]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3 full-form-btns">
    <?php
    if ($model->isNewRecord) {
        echo Html::submitButton('<i class="ri-check-line mr-1"></i> Create & Open', ['class' => 'btn btn-success waves-effect btn-with-icon']);
        echo Html::submitButton('<i class="ri-add-circle-line mr-1"></i> Create & add another', ['class' => 'btn btn-primary waves-effect btn-with-icon', 'name' => 'submit_button', 'value' => 'create_and_add_new']);
    } else {
        echo Html::submitButton('<i class="ri-check-line mr-1"></i> Save', ['class' => 'btn btn-success waves-effect btn-with-icon']);
        echo Html::submitButton('<i class="ri-add-fill mr-1"></i> Save & add another', ['class' => 'btn btn-primary waves-effect btn-with-icon', 'name' => 'submit_button', 'value' => 'create_and_add_new']);
    } ?>
</div>
<?php ActiveForm::end(); ?>