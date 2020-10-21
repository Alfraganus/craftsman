<?php

use common\models\AuthItem;
use common\models\Countries;
use common\models\UsersSession;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->role = 'seller';
    $lastSession = array();
} else {
    $lastSession = UsersSession::getLog($model->id, 'last_session');
}


// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form'
    ]
]) ?>

<div class="row">
    <!-- Left column -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($model, 'email')->textInput(['type' => 'email', 'required' => 'required']) ?>
                    </div>

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
    </div>
    <!-- /Left column -->

    <!-- Right column -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group required-field">
                    <?= $form->field($model, 'status')->dropDownList([
                        0 => 'Pending',
                        10 => 'Active',
                        5 => 'Banned',
                    ], [
                        'class' => 'form-control custom-select',
                        'required' => 'required',
                    ]) ?>
                </div>

                <div class="form-group required-field">
                    <?php
                    $listdata = ArrayHelper::map(AuthItem::find()
                        ->where(['type' => 1])
                        ->all(), 'name', 'description');

                    echo $form->field($model, 'role')->dropDownList(
                        $listdata,
                        [
                            'class' => 'form-control custom-select',
                            'required' => 'required',
                        ]
                    )->label('Group') ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if ($model->isNewRecord) : ?>
                    <div class="form-group required-field">
                        <?= $form->field($model, 'password')->passwordInput(['required' => 'required']) ?>
                    </div>
                    <div class="form-group required-field">
                        <?= $form->field($model, 'password_repeat')->passwordInput(['required' => 'required']) ?>
                    </div>
                <?php else : ?>
                    <div class="form-group">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Register date</label>
                    <?php $created_at = $model->created_at > 0 ? date('d/m/Y H:i', $model->created_at) : '-'; ?>
                    <input type="text" class="form-control" value="<?= $created_at; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Updated date</label>
                    <?php $updated_at = $model->updated_at > 0 ? date('d/m/Y H:i', $model->updated_at) : '-'; ?>
                    <input type="text" class="form-control" value="<?= $updated_at; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="last_login">Last login</label>
                    <input type="text" class="form-control" id="last_login" value="<?= $lastSession ? $lastSession->date : ''; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="last_ip">Last IP</label>
                    <input type="text" class="form-control" id="last_ip" value="<?= $lastSession ? $lastSession->ip_address : ''; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="last_session">Last session</label>
                    <input type="text" class="form-control" id="last_session" value="<?= $lastSession ? $lastSession->session : ''; ?>" disabled>
                </div>
            </div>
        </div>
    </div>
    <!-- /Right column -->
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