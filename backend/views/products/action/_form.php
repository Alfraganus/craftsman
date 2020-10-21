<?php

use backend\models\Brand;
use backend\models\Product;
use backend\models\Segment;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$languages = get_active_langs();
$langs_array = ArrayHelper::map($languages, 'lang_code', 'name');

if ($model->isNewRecord) {
    $model->sort = 0;
    $model->status = 2;
    $model->quantity = 1000;
    $model->quantity_min = 1;
    $model->searchable = true;
    $model->cacheable = true;
    $model->upc = Product::generateUPCode();
    $model->created_by = Yii::$app->user->id;
    $model->updated_by = Yii::$app->user->id;
} else {
    $model->category_id = Product::getProductCategoriesArray($model);
    $info = init_content_meta($info);
}

// Language
$lang = input_get('lang');

if (is_string($lang) && $lang) {
    $info->language = $lang;
}

// Begin form
$form = ActiveForm::begin([
    'options' => [
        'class' => 'full-form',
    ],
]); ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-custom nav-justified mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">General</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#content" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">Content</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#attrbutes" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">Attributes</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Settings</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <!-- Tab item -->
    <div class="tab-pane active" id="general" role="tabpanel">
        <div class="row">
            <!-- Left column -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" style="min-height:536px;">
                        <div class="form-group required-field">
                            <?= $form->field($info, 'name')->textInput(['required' => 'required', 'ep-bind-action' => 'title']) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($info, 'short_title')->textInput() ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?= $form->field($model, 'upc', ['template' => field_with_tooltip_label('Universal Product Code')])
                                    ->textInput() ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <?= $form->field($model, 'mpn', ['template' => field_with_tooltip_label('Manufacturer Part Number')])
                                    ->textInput() ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <?= $form->field($model, 'quantity')->textInput(['type' => 'number']) ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <?php
                                $min_qt_template = field_with_tooltip_label('Force a minimum ordered amount');
                                echo $form->field($model, 'quantity_min', ['template' => $min_qt_template])->textInput(['type' => 'number']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group required-field">
                                <?= $form->field($model, 'price')->textInput(['type' => 'text', 'required' => 'required', 'product-form-price-input' => 'price']) ?>
                            </div>

                            <div class="col-md-6 form-group required-field">
                                <?= $form->field($model, 'currency')->dropDownList(
                                    Product::getCurrencies(),
                                    [
                                        'class' => 'form-control custom-select',
                                        'required' => 'required',
                                        'product-form-price-input' => 'currency'
                                    ]
                                ) ?>
                            </div>

                            <?php
                            $discount_input_types = ['discount_price' => 'price', 'discount_percentage' => 'percentage'];
                            $discount_select_types = ['percentage' => 'Percentage', 'price' => 'Fixed price']; ?>

                            <div class="col-md-6 form-group">
                                <label>Discount</label>

                                <div class="input-group">
                                    <?php foreach ($discount_input_types as $discount_input_key => $discount_input_value) {
                                        $discount_input_values = '';

                                        if ($model && $model->discount_type == $discount_input_key) {
                                            $discount_input_class_name = 'form-control product-discount-input active';
                                        } else {
                                            $discount_input_class_name = 'form-control product-discount-input';
                                        }

                                        if ($model && $model->discount_type) {
                                            if ($discount_input_value == 'price') {
                                                $discount_input_values = 'value="' . $model->discount_price . '"';
                                            }

                                            if ($discount_input_value == 'percentage') {
                                                $discount_input_values = 'value="' . $model->discount . '"';
                                            }
                                        }

                                        echo '<input type="text" class="' . $discount_input_class_name . '" name="' . $discount_input_key . '" product-form-discount-input="' . $discount_input_value . '" ' . $discount_input_values . '>';
                                    } ?>

                                    <div class="input-group-append">
                                        <select class="form-control custom-select" name="discount_type" product-form-discount-input="type">
                                            <?php foreach ($discount_select_types as $discount_select_key => $discount_select_value) {
                                                if ($model && $model->discount_type == $discount_select_key) {
                                                    echo '<option value="' . $discount_select_key . '" selected>' . $discount_select_value . '</option>';
                                                } else {
                                                    echo '<option value="' . $discount_select_key . '">' . $discount_select_value . '</option>';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="product_sale_price">Sale price</label>
                                <span id="product_sale_price_span"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <?= $form->field($info, 'meta_title')->textInput() ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($info, 'meta_description')->textInput() ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($info, 'focus_keywords')->textInput() ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Google preview</label>

                            <div class="seopro-panel-body">
                                <div class="seopro-preview-title">Home - AVLO UZ</div>
                                <div class="seopro-preview-url">https://www.avlo.loc/</div>
                                <div class="seopro-preview-description">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime nostrum repudiandae temporibus esse animi voluptatem accusamus corrupti ab, porro doloremque quia mollitia ipsam nihil sunt quis qui? Quia, ipsam culpa.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>SEO Analysis</label>

                            <div class="seopro-analysis">
                                <div class="seopro-analysis-in seopro-success active">
                                    <h5>Good:</h5>
                                    <ul class="nav">
                                        <li>The SEO title was set for this page.</li>
                                        <li>The SEO title has a nice length. (Max length: 75 characters)</li>
                                        <li>The meta description was set for this page.</li>
                                    </ul>
                                </div>

                                <div class="seopro-analysis-in seopro-errors active">
                                    <h5>Errors:</h5>
                                    <ul class="nav">
                                        <li>No focus keyword was set for this page. If you do not set a focus keyword, no score can be calculated.</li>
                                    </ul>
                                </div>

                                <div class="seopro-analysis-in seopro-improvements active">
                                    <h5>Improvements:</h5>
                                    <ul class="nav">
                                        <li>The meta description is wider than the viewable limit. Max length: 160 characters</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Left column -->

            <!-- Right column -->
            <div class="col-md-3">
                <?php if ($languages && count($languages) > 1) : ?>
                    <div class="card">
                        <div class="card-body full-form-translations">
                            <div class="form-group required-field">
                                <?= $form->field($info, 'language')->dropDownList($langs_array, ['class' => 'form-control custom-select c-translation-select', 'required' => 'required']) ?>
                            </div>

                            <?php if (isset($translations) && $translations) : ?>
                                <div class="form-group">
                                    <label for="brand_language">Translations</label>
                                    <?php foreach ($languages as $language) : ?>
                                        <?php
                                        $translations_array = array();
                                        $language_code = $language['lang_code'];

                                        foreach ($translations as $translation_item) {
                                            $translations_array[$translation_item->language] = $translation_item->name;
                                        } ?>
                                        <div class="input-group mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="<?= $language['name']; ?>">
                                                    <img src="<?= $language['flag']; ?>" alt="<?= $language_code; ?>" height="10" width="17">
                                                </span>
                                            </div>
                                            <?php if (isset($translations_array[$language_code])) : ?>
                                                <input type="text" class="form-control" placeholder="<?= $translations_array[$language_code]; ?>" disabled>
                                                <div class="input-group-append">
                                                    <a href="<?= Url::current(['lang' => $language_code]); ?>" class="input-group-text">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </a>
                                                </div>
                                            <?php else : ?>
                                                <input type="text" class="form-control" placeholder="No translation" disabled>
                                                <div class="input-group-append">
                                                    <a href="<?= Url::current(['lang' => $language_code]); ?>" class="input-group-text">
                                                        <i class="ri-add-fill"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="form-group">
                                    <label for="brand_language">Translations</label>
                                    <?php foreach ($languages as $language) : ?>
                                        <?php $language_code = $language['lang_code']; ?>
                                        <div class="input-group mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="<?= $language['name']; ?>">
                                                    <img src="<?= $language['flag']; ?>" alt="<?= $language_code; ?>" height="10" width="17">
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="translations_title[<?= $language_code; ?>]" data-translation-code="<?= $language_code; ?>" placeholder="Title" required>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group required-field">
                            <?= html_entity_decode($form->field($model, 'category_id')->dropDownList(
                                Segment::getListParent('product', $info, 0, 'product_category'),
                                [
                                    'class' => 'form-control select2',
                                    'required' => 'required',
                                    'multiple' => 'multiple',
                                ]
                            )) ?>
                        </div>

                        <div class="form-group">
                            <?= html_entity_decode($form->field($model, 'brand_id')->dropDownList(
                                Brand::getDropdownList(),
                                [
                                    'class' => 'form-control select2',
                                ]
                            )) ?>
                        </div>

                        <div class="form-group required-field position-relative">
                            <?= $form->field($info, 'image', ['template' => media_browser_input('image')])
                                ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image', 'required' => 'required']) ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group required-field">
                            <?= $form->field($model, 'status')->dropDownList($model->statusArray(), ['class' => 'form-control custom-select', 'required' => 'required']) ?>
                        </div>

                        <div class="form-group">
                            <?php
                            $slug_template = field_slug_input();
                            echo $form->field($info, 'slug', ['template' => $slug_template])->textInput(['readonly' => 'readonly']); ?>
                        </div>

                        <div class="form-group required-field">
                            <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'required' => 'required']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Right column -->
        </div>
    </div> <!-- /Tab item -->

    <!-- Tab item -->
    <div class="tab-pane" id="content" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Gallery</h5>

                <div class="abk-gallery-block">
                    <div class="abk-gallery-upload">
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            <i class="ri-image-add-line align-middle mr-2"></i> Add Image
                        </button>
                    </div>
                    <div class="abk-gallery-in">
                        <div class="abk-gallery-item">
                            <input type="hidden" name="product_gallery[]" value="/source/path/image-name.jpg">
                            <div class="abk-gallery-item-in">
                                <button class="abk-gallery-item-remove">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <a class="image-popup-vertical-fit abk-gallery-item-zoom" href="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg">
                                    <i class="ri-zoom-in-line"></i>
                                </a>
                                <img class="abk-gallery-item-img" src="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg" alt="Image">
                            </div>
                        </div>
                        <div class="abk-gallery-item">
                            <input type="hidden" name="product_gallery[]" value="/source/path/image-name.jpg">
                            <div class="abk-gallery-item-in">
                                <button class="abk-gallery-item-remove">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <a class="image-popup-vertical-fit abk-gallery-item-zoom" href="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg">
                                    <i class="ri-zoom-in-line"></i>
                                </a>
                                <img class="abk-gallery-item-img" src="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg" alt="Image">
                            </div>
                        </div>
                        <div class="abk-gallery-item">
                            <input type="hidden" name="product_gallery[]" value="/source/path/image-name.jpg">
                            <div class="abk-gallery-item-in">
                                <button class="abk-gallery-item-remove">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <a class="image-popup-vertical-fit abk-gallery-item-zoom" href="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg">
                                    <i class="ri-zoom-in-line"></i>
                                </a>
                                <img class="abk-gallery-item-img" src="https://n11scdn4.akamaized.net/a1/1024/elektronik/akilli-saat-aksesuarlari/xiaomi-mi-band-4-akilli-bileklik-tme-kordon-kayis__0176844118334709.jpg" alt="Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <?= $form->field($info, 'description')->textarea(['id' => 'tiny-editor-description', 'data-tinymce' => "compact", 'data-height' => "600"]) ?>
            </div>
        </div>
    </div> <!-- /Tab item -->

    <!-- Tab item -->
    <div class="tab-pane" id="attrbutes" role="tabpanel">
        <div class="card">
            <div class="card-body">
                ...
            </div>
        </div>
    </div> <!-- /Tab item -->

    <!-- Tab item -->
    <div class="tab-pane" id="settings" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Created on</label>
                        <input type="text" value="<?= $model->created_on ? $model->created_on : '-' ?>" class="form-control" disabled>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Updated on</label>
                        <input type="text" value="<?= $model->updated_on ? $model->updated_on : '-' ?>" class="form-control" disabled>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'created_by')->dropDownList(
                            Product::getVendors(),
                            [
                                'class' => 'form-control select2',
                                'required' => 'required',
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'shop_id')->dropDownList(
                            Product::getShops(),
                            [
                                'class' => 'form-control select2',
                                'required' => 'required',
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'template')->textInput() ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'layout')->textInput() ?>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Properties</label>
                        <br>

                        <div class="d-inline-block custom-control custom-checkbox mr-2">
                            <?php
                            $checkbox_template = '{input}';
                            $checkbox_template .= '<label class="custom-control-label" for="product-searchable">Searchable</label>';
                            $checkbox_attrs = ['class' => 'custom-control-input', 'type' => 'checkbox', 'value' => 1];

                            if ($model->searchable) {
                                $checkbox_attrs['checked'] = true;
                            }

                            echo $form->field(
                                $model,
                                'searchable',
                                ['template' => $checkbox_template]
                            )->textInput($checkbox_attrs); ?>
                        </div>

                        <div class="d-inline-block custom-control custom-checkbox mr-2">
                            <?php
                            $checkbox_template = '{input}';
                            $checkbox_template .= '<label class="custom-control-label" for="product-cacheable">Cacheable</label>';
                            $checkbox_attrs = ['class' => 'custom-control-input', 'type' => 'checkbox', 'value' => 1];

                            if ($model->cacheable) {
                                $checkbox_attrs['checked'] = true;
                            }

                            echo $form->field(
                                $model,
                                'cacheable',
                                ['template' => $checkbox_template]
                            )->textInput($checkbox_attrs); ?>
                        </div>

                        <div class="d-inline-block custom-control custom-checkbox mr-2">
                            <?php
                            $checkbox_template = '{input}';
                            $checkbox_template .= '<label class="custom-control-label" for="product-deleted">Deleted</label>';
                            $checkbox_attrs = ['class' => 'custom-control-input', 'type' => 'checkbox', 'value' => 1];

                            if ($model->deleted) {
                                $checkbox_attrs['checked'] = true;
                            }

                            echo $form->field(
                                $model,
                                'deleted',
                                ['template' => $checkbox_template]
                            )->textInput($checkbox_attrs); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Tab item -->
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