<?php

use backend\models\Content;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->sort = 0;
    $model->searchable = true;
    $model->cacheable = true;
    $model->products_per_page = 0;
    $model->created_by = Yii::$app->user->id;
    $model->updated_by = Yii::$app->user->id;
} else {
    $model = init_content_meta($model);
    $model = init_content_settings($model);
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
                    <div class="card-body">
                        <div class="form-group required-field">
                            <?= $form->field($model, 'title')->textInput(['required' => 'required', 'ep-bind-action' => 'title']) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'meta_title')->textInput() ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'meta_description')->textInput() ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'focus_keywords')->textInput() ?>
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
                <div class="card">
                    <div class="card-body">
                        <div class="form-group required-field">
                            <?= $form->field($model, 'status')->dropDownList($model->statusArray(), ['class' => 'form-control custom-select', 'required' => 'required']) ?>
                        </div>

                        <div class="form-group">
                            <?php
                            $slug_template = field_slug_input();
                            echo $form->field($model, 'slug', ['template' => $slug_template])->textInput(['readonly' => 'readonly']); ?>
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
                <div class="form-group position-relative">
                    <?= $form->field($model, 'icon', ['template' => media_browser_input('image')])
                        ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image']) ?>
                </div>

                <div class="form-group position-relative">
                    <?= $form->field($model, 'image', ['template' => media_browser_input('image')])
                        ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image']) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'cover_image', ['template' => media_browser_input('image')])
                        ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image']) ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'description')->textarea(['id' => 'tiny-editor-description', 'data-tinymce' => "compact", 'data-height' => "300"]) ?>
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
                            Content::getVendors(),
                            [
                                'class' => 'form-control select2',
                                'required' => 'required',
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'products_view_type')->dropDownList(
                            category_products_view_types(),
                            ['class' => 'form-control custom-select']
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'products_sorting')->dropDownList(
                            category_sorting(),
                            ['class' => 'form-control custom-select']
                        ) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'products_per_page')->textInput(['type' => 'number']) ?>
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
                            $checkbox_template .= '<label class="custom-control-label" for="brand-searchable">Searchable</label>';
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
                            $checkbox_template .= '<label class="custom-control-label" for="brand-cacheable">Cacheable</label>';
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
                            $checkbox_template .= '<label class="custom-control-label" for="brand-deleted">Deleted</label>';
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