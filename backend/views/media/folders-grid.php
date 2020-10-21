<?php

use common\models\MediaBrowser;

if ($folders) : ?>
    <?php foreach ($folders as $folder) : ?>
        <div class="media-browser-grid-item media-browser-grid-folder">
            <div class="media-browser-grid-item-in">
                <div class="media-browser-grid-item-top">
                    <i class="ri-checkbox-blank-line media-browser-select-icon" media-browser-select="<?= $folder['relative_path_name']; ?>" media-browser-select-item="folder"></i>
                    <div class="media-browser-grid-icon" media-browser-open-dir="<?= trim($path_name, '/') . '/' . $folder['relative_path_name']; ?>">
                        <i class="ri-folder-3-fill"></i>
                    </div>
                </div>
                <div class="media-browser-grid-item-bottom" media-browser-path-info="<?= $folder['relative_path_name']; ?>">
                    <i class="ri-information-fill mr-2" data-toggle="tooltip" data-placement="top" title="Informations"></i>
                    <span title="<?= $folder['name']; ?>"><?= $folder['name']; ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>