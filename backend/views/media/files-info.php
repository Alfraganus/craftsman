<?php if ($folders) : ?>
    <?php foreach ($folders as $folder) : ?>
        <div class="media-browser-popup-item media-browser-info-block" media-browser-info-block="<?= $folder['relative_path_name']; ?>">
            <form class="media-browser-action-form media-browser-info-block-in">
                <input type="hidden" name="action_type" value="update_folder">
                <input type="hidden" name="folder_name" value="<?= $folder['name']; ?>">
                <input type="hidden" name="folder_permissons" value="<?= $folder['permissions']; ?>">

                <div class="form-group">
                    <label>Folder name</label>
                    <input type="text" class="form-control" name="name" value="<?= $folder['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Folder URL</label>
                    <div class="media-browser-info-ro-input">
                        <?= $folder['file_url']; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label>Permissons</label>
                    <input type="number" class="form-control" name="permissions" value="<?= $folder['permissions']; ?>" required>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Modified at</label>
                        <div class="media-browser-info-ro-input">
                            <?= date('d/m/Y H:i', $folder['modified_time']); ?>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Access time</label>
                        <div class="media-browser-info-ro-input">
                            <?= date('d/m/Y H:i', $folder['access_time']); ?>
                        </div>
                    </div>
                </div>

                <div class="media-browser-info-block-buttons">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" media-browser-popup-close>
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light media-browser-action-btn">
                        <i class="ri-refresh-line media-browser-icon-spin"></i>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($files) : ?>
    <?php foreach ($files as $file) : ?>
        <div class="media-browser-popup-item media-browser-info-block" media-browser-info-block="<?= $file['name']; ?>">
            <form class="media-browser-action-form media-browser-info-block-in">
                <input type="hidden" name="action_type" value="update_file">
                <input type="hidden" name="file_name" value="<?= $file['name']; ?>">
                <input type="hidden" name="file_permissons" value="<?= $file['permissions']; ?>">

                <div class="form-group">
                    <label>File name</label>
                    <input type="text" class="form-control" name="name" value="<?= $file['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>File URL</label>
                    <div class="media-browser-info-ro-input">
                        <?= $file['file_url']; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>File size</label>
                        <div class="media-browser-info-ro-input">
                            <?= $file['size']; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Permissons</label>
                        <input type="number" class="form-control" name="permissions" value="<?= $file['permissions']; ?>" required>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Modified at</label>
                        <div class="media-browser-info-ro-input">
                            <?= date('d/m/Y H:i', $file['modified_time']); ?>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Access time</label>
                        <div class="media-browser-info-ro-input">
                            <?= date('d/m/Y H:i', $file['access_time']); ?>
                        </div>
                    </div>
                </div>

                <div class="media-browser-info-block-buttons">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" media-browser-popup-close>
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light media-browser-action-btn">
                        <i class="ri-refresh-line media-browser-icon-spin"></i>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>