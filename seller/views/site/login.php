<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Kirish'; ?>

<!-- Header -->
<header id="header" class="ex-header" style="padding: 12rem 0 8rem;min-height: 520px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">
                    Kirish
                </h1>
                <h5>Sotuvchi Paneliga Kirish</h5>
            </div>

            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'account-form']]); ?>

                <?= $form->field($model, 'username')->textInput(['required' => 'required']) ?>

                <?= $form->field($model, 'password')->passwordInput(['required' => 'required']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <div class="forgot-pass">
                    <a href="<?= seller_url('account/forgot-pass'); ?>">
                        <i class="far fa-question-circle"></i> Forgot password?
                    </a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->