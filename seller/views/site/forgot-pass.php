<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password'; ?>

<!-- Header -->
<header id="header" class="ex-header" style="padding: 12rem 0 8rem;min-height: 520px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">
                    Parolni qaytarish
                </h1>
                <h5>Parolingizni unutgan bo'lsangiz yangi parol oling!</h5>
            </div>

            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'account-form']]); ?>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Reset password!', ['class' => 'btn btn-primary']) ?>
                </div>

                <div class="forgot-pass">
                    <a href="<?= seller_url('account/login'); ?>">
                        <i class="fas fa-sign-in-alt"></i> Sign in
                    </a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->