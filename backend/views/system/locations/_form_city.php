<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Countries;

$data = Countries::find()->asArray()->all();
$countries = ArrayHelper::map($data, 'id', 'name');

$languages = get_active_langs(); ?>

<?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group required-field">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'city_name', 'required' => 'required']) ?>
                </div>
                <div class="form-group required-field">
                    <?= $form->field($model, 'country_id')->dropDownList(
                        $countries,
                        [
                            'prompt' => '-',
                            'class' => 'form-control select2',
                            'required' => 'required'
                        ]
                    ) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group required-field">
                    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Disabled'], ['class' => 'form-control custom-select', 'required' => 'required']) ?>
                </div>

                <div class="form-group required-field">
                    <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'value' => 0, 'required' => 'required']) ?>
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