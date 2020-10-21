<?php

use common\models\MediaBrowser;

if ($files) : ?>
    <?php foreach ($files as $file) : ?>
        <?php $image_preview = MediaBrowser::checkImagePreview($file); ?>
        <tr>
            <td>
                <i class="ri-checkbox-blank-line media-browser-select-icon" media-browser-select="<?= $file['name']; ?>" media-browser-file-url="<?= $file['file_url']; ?>" media-browser-select-item="file"></i>
            </td>
            <td>
                <div class="media-browser-table-file" media-browser-info="<?= $file['name']; ?>">
                    <div class="media-browser-table-file-icon">
                        <i class="<?= MediaBrowser::iconConvert($file); ?>"></i>
                        <i class="ri-information-fill media-browser-table-item-info" data-toggle="tooltip" data-placement="top" title="Informations"></i>
                    </div>

                    <?php if($image_preview): ?>
                        <div class="media-browser-list-image-preview" media-browser-list-image-preview="<?= $image_preview; ?>">
                            <?= $file['name']; ?>
                        </div>
                    <?php else: ?>
                        <span><?= $file['name']; ?></span>
                    <?php endif; ?>
                </div>
            </td>
            <td><?= $file['size']; ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>