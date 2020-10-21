<?php if ($folders) : ?>
    <?php foreach ($folders as $folder) : ?>
        <tr>
            <td>
                <i class="ri-checkbox-blank-line media-browser-select-icon" media-browser-select="<?= $folder['relative_path_name']; ?>" media-browser-select-item="folder"></i>
            </td>
            <td>
                <div class="media-browser-table-folder" media-browser-open-dir="<?= trim($path_name, '/') . '/' . $folder['relative_path_name']; ?>">
                    <div class="media-browser-table-folder-icon">
                        <i class="ri-folder-3-fill"></i>
                        <i class="ri-information-fill media-browser-table-item-info" media-browser-path-info="<?= $folder['relative_path_name']; ?>" data-toggle="tooltip" data-placement="top" title="Informations"></i>
                    </div>

                    <span>
                        <?= $folder['name']; ?>
                    </span>
                </div>
            </td>
            <td>-</td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>