<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Do'kon ochish"; ?>

<!-- Header -->
<header id="header" class="ex-header" style="padding: 12rem 0 8rem;min-height: 520px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">
                    Do'kon ochish
                </h1>
                <h5>Yangi Do'kon Ochish</h5>
            </div>

            <div class="col-md-12">
                <div class="form-register form-container">
                    <?php $form = ActiveForm::begin(['id' => 'register-form', 'options' => ['class' => 'account-form']]); ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'name')->textInput(['required' => 'required']) ?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'surname')->textInput(['required' => 'required']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'username')->textInput(['required' => 'required']) ?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'required' => 'required']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'password')->textInput(['type' => 'password', 'required' => 'required']) ?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'password_confirm')->textInput(['type' => 'password', 'required' => 'required']) ?>
                        </div>
                    </div>

                    <div class="mt-3">
                        <?= Html::submitButton('Register now!', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->