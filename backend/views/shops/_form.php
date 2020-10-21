<?php

use backend\models\Shop;
use common\models\Profile;
use common\models\Countries;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->sort = 0;
    $model->status = 0;
}

// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form',
    ],
]) ?>

<div class="row">
    <!-- Left column -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group required-field">
                        <?= $form->field($model, 'title')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?php
                        $company_types = Shop::company_types();

                        echo $form->field($shop_info, 'company_type')->dropDownList(
                            select_array_with_empty_label($company_types),
                            ['class' => 'custom-select', 'required' => 'required']
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?php
                        $company_status_types = Shop::status_types();

                        echo $form->field($model, 'type')->dropDownList(
                            select_array_with_empty_label($company_status_types),
                            ['class' => 'custom-select'],
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?php
                        $company_person_status = Shop::person_status();

                        echo $form->field($shop_info, 'person_status')->dropDownList(
                            select_array_with_empty_label($company_person_status),
                            ['class' => 'custom-select', 'required' => 'required']
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($shop_info, 'company_no')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?php
                        $countries = ArrayHelper::map(Countries::find()->all(), 'ISO', 'name');

                        echo $form->field($shop_info, 'country')->dropDownList(
                            select_array_with_empty_label($countries),
                            ['class' => 'custom-select', 'required' => 'required'],
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($shop_info, 'city')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($shop_info, 'region')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($shop_info, 'postal_code')->textInput() ?>
                    </div>

                    <div class="col-md-12 form-group required-field">
                        <?= $form->field($shop_info, 'address')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($shop_info, 'email')->textInput(['type' => 'email', 'required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group required-field">
                        <?= $form->field($shop_info, 'phone')->textInput(['required' => 'required']) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($shop_info, 'mobile')->textInput() ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($shop_info, 'fax')->textInput() ?>
                    </div>

                    <div class="col-md-12 form-group required-field">
                        <?= $form->field($shop_info, 'description')->textarea(['cols' => 5, 'required' => 'required']) ?>
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
                    <?= $form->field($model, 'status')->dropDownList(
                        Shop::status(),
                        ['class' => 'custom-select', 'required' => 'required']
                    ) ?>
                </div>

                <div class="form-group required-field">
                    <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'required' => 'required']) ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body vendors-find-list">
                <div class="form-group">
                    <label for="shop_vendors_find">Vendors</label>
                    <div class="find-group">
                        <i class="ri-search-line"></i>
                        <input type="text" id="shop_vendors_find" class="form-control" placeholder="Find vendor...">
                        <div class="vendors-find-list-block">
                            <div class="vendors-find-list-in"></div>
                            <div class="vendors-find-list-preloader">
                                <i class="ri-refresh-line fas fa-spin"></i>
                            </div>
                            <div class="vendors-find-list-notfound">
                                <i class="ri-error-warning-line"></i>
                                <div class="h4">Vendors not found!</div>
                            </div>
                            <div class="vendors-find-list-close">
                                Close
                            </div>
                        </div>
                    </div>
                </div>
                <?php $vendors = Shop::getVendors($model->id); ?>
                <div class="vendors-find-list-res">
                    <?php if ($vendors) : ?>
                        <?php foreach ($vendors as $vendor) : ?>
                            <div class="form-group vendors-find-list-res-in" data-id="<?= $vendor->id; ?>">
                                <input type="hidden" name="vendors_id[]" value="<?= $vendor->id; ?>">
                                <button type="button"><i class="ri-close-circle-line"></i></button>
                                <span><?= Profile::getFullname($vendor->profile); ?> (<?= $vendor->email; ?>)</span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="user_register_date">Register date</label>
                    <?php $created_on = $model->created_on > 0 ? date('d/m/Y H:i', $model->created_on) : '-'; ?>
                    <input type="text" class="form-control" value="<?= $created_on; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="user_last_login">Update date</label>
                    <?php $updated_on = $model->updated_on > 0 ? date('d/m/Y H:i', $model->updated_on) : '-'; ?>
                    <input type="text" class="form-control" value="<?= $updated_on; ?>" disabled>
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

<script type="text/javascript">
    var main_url = '<?= admin_url(trim($main_url, '/')); ?>';
    var vendors_url = '<?= admin_url(trim($vendors_url, '/')); ?>';
</script>

<?php
$this->registerJs(<<<JS

$(document).ready(function() {
    $('#shop_vendors_find').on('keypress', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);

        if (keycode == '13') {
            event.preventDefault();
            var element = $(this);
            var value = element.val();

            if (value != undefined && value != '') {
                vendorsSearchBox(element, value);
            }
        }
    });

    $(document).on('click', '.vendors-find-list-close', function () {
        $('.vendors-find-list-block').hide();
    });

    $(document).on('click', '.vendors-find-list-res-in > button', function () {
        if (confirm('Are you sure to remove vendor?')) {
            $(this).parent().remove();
        }
    });

    $(document).on('click', '.vendors-find-list-item', function () {
        var id = $(this).attr('data-id');
        var fullname = $(this).attr('data-fullname');
        var email = $(this).attr('data-email');

        if (id != undefined && fullname != undefined && email != undefined) {
            var parent = $(this).closest('.vendors-find-list');
            var popup = $(this).closest('.vendors-find-list-block');
            var block = parent.find('.vendors-find-list-res');
            var item = block.children('[data-id="'+ id +'"]');

            if (item != undefined && item.length > 0) {
                popup.hide();
            } else {
                var div = '<div class="form-group vendors-find-list-res-in" data-id="'+ id +'">';
                div += '<input type="hidden" name="vendors_id[]" value="'+ id +'">';
                div += '<button type="button"><i class="ri-close-circle-line"></i></button>';
                div += '<span>'+ fullname +' ('+ email +')</span>';
                div += '</div>';
                block.append(div);
                popup.hide();
            }
        } else {
            alert(ajax_error_msg);
        }
    });
});

function vendorsSearchBox(element, value) {
    var div = '';
    var parent = element.parent();
    var block = parent.children('.vendors-find-list-block');
    var area = block.children('.vendors-find-list-in');
    var preloader = block.children('.vendors-find-list-preloader');
    var notfound = block.children('.vendors-find-list-notfound');

    if (value.length < 3) {
        alert('Please enter at least 3 characters!');
        return false;
    }

    block.show();
    area.empty();
    preloader.show();
    notfound.hide();

    $.ajax({
        type: "GET",
        url: main_url + "/json/",
        data: {
            type: 'search',
            keyword: value
        },
        dataType: "json",
        success: function(data) {
            if (data.success) {
                $.each(data.vendors, function (i, value) {
                    div += '<div class="vendors-find-list-item" data-id="'+ value.user_id +'" data-fullname="'+ value.fullname +'" data-email="'+ value.email +'">';
                    div += '<p>';
                    div += value.fullname + ' (' + value.email + ')';
                    div += '</p>';
                    div += '</div>';
                });

                area.html(div);
                preloader.hide();
            } else {
                notfound.show();
                preloader.hide();
            }
        },
        error: function () {
            alert(ajax_error_msg);
        },
    });
}

JS);
