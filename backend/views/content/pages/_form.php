<?php

use backend\models\Content;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$languages = get_active_langs();
$langs_array = ArrayHelper::map($languages, 'lang_code', 'name');

if ($model->isNewRecord) {
    $model->sort = 0;
    $model->searchable = true;
    $model->cacheable = true;
    $model->products_per_page = 0;
    $model->created_by = Yii::$app->user->id;
    $model->updated_by = Yii::$app->user->id;
} else {
    $info = init_content_meta($info);
    $model = init_content_settings($model);
}

// Language
$lang = input_get('lang');

if (is_string($lang) && $lang) {
    $info->language = $lang;
}

// Parent id
$parent_id = input_get('parent');

if (is_numeric($parent_id) && $parent_id > 0) {
    $model->parent_id = $parent_id;
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
                            <?= $form->field($info, 'title')->textInput(['required' => 'required', 'ep-bind-action' => 'title']) ?>
                        </div>

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
                                            $translations_array[$translation_item->language] = $translation_item->title;
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
                            <?= html_entity_decode($form->field($model, 'parent_id')->dropDownList(
                                Content::getListParent($model, $info),
                                [
                                    'class' => 'form-control select2',
                                    'required' => 'required',
                                ]
                            )) ?>
                        </div>

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
                <div class="form-group position-relative">
                    <?= $form->field($info, 'image', ['template' => media_browser_input('image')])
                        ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image']) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($info, 'cover_image', ['template' => media_browser_input('image')])
                        ->textInput(['class' => 'form-control media-browser-input', 'media-browser-input' => 'image']) ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <?= $form->field($info, 'description')->textarea(['id' => 'tiny-editor-description', 'data-tinymce' => "compact", 'data-height' => "300"]) ?>
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
                            $checkbox_template .= '<label class="custom-control-label" for="content-searchable">Searchable</label>';
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
                            $checkbox_template .= '<label class="custom-control-label" for="content-cacheable">Cacheable</label>';
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
                            $checkbox_template .= '<label class="custom-control-label" for="content-deleted">Deleted</label>';
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