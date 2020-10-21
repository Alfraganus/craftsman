<?php

use common\models\MediaBrowser;

if ($files) : ?>
    <?php foreach ($files as $file) : ?>
        <?php $image_preview = MediaBrowser::checkImagePreview($file); ?>
        <div class="media-browser-grid-item media-browser-grid-file">
            <div class="media-browser-grid-item-in">
                <div class="media-browser-grid-item-top">
                    <i class="ri-checkbox-blank-line media-browser-select-icon" media-browser-select="<?= $file['name']; ?>" media-browser-file-url="<?= $file['file_url']; ?>" media-browser-select-item="file"></i>

                    <?php if ($image_preview) : ?>
                        <div class="media-browser-grid-image">
                            <img src="<?= $image_preview; ?>" alt="<?= $file['name']; ?>">
                        </div>
                    <?php else : ?>
                        <div class="media-browser-grid-icon">
                            <i class="<?= MediaBrowser::iconConvert($file); ?>"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="media-browser-grid-item-bottom" media-browser-info="<?= $file['name']; ?>">
                    <i class="ri-information-fill mr-2" data-toggle="tooltip" data-placement="top" title="Informations"></i>
                    <span title="<?= $file['name']; ?>"><?= $file['name']; ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>