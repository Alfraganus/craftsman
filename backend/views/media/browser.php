<div class="media-browser-block">
    <div class="media-browser-block-in">
        <div class="media-browser-top">
            <div class="media-browser-top-in media-browser-top-left">
                <div class="h3 media-browser-top-border" media-browser-text="title">0 files</div>

                <div class="media-browser-top-icon">
                    <i class="ri-function-line media-browser-view-btn" media-browser-view="grid" data-toggle="tooltip" data-placement="top" title="Grid view"></i>
                </div>

                <div class="media-browser-top-icon media-browser-top-border">
                    <i class="ri-list-unordered media-browser-view-btn" media-browser-view="list" data-toggle="tooltip" data-placement="top" title="List view"></i>
                </div>

                <div class="media-browser-top-icon">
                    <i class="ri-delete-bin-line" media-browser-quick-action="delete" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                </div>
            </div>

            <div class="media-browser-top-in media-browser-top-right">
                <div class="media-browser-top-btn">
                    <button type="button" class="btn btn-outline-secondary waves-effect" media-browser-toggle="folder">
                        <i class="ri-folder-add-line mr-2"></i>
                        Add folder
                    </button>
                </div>
                <div class="media-browser-top-btn media-browser-top-right" media-browser-toggle="upload">
                    <button type="button" class="btn btn-info waves-effect waves-light">
                        <i class="ri-upload-2-line mr-2"></i>
                        Upload
                    </button>
                </div>
            </div>
        </div>

        <div class="media-browser-actions">
            <div class="media-browser-add-folder">
                <form class="media-browser-action-form input-group">
                    <input type="hidden" name="action_type" value="create_folder">
                    <input type="text" class="form-control" name="folder_name" placeholder="Enter name of folder" required>

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary media-browser-action-btn">
                            <i class="ri-refresh-line media-browser-icon-spin"></i>
                            <span>Create folder</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="media-browser-upload">
                <form class="media-browser-upload-form input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="media-broser-upload-area" name="files[]" multiple required>
                        <label class="custom-file-label" id="media-broser-upload-label" for="media-broser-upload-area" data-label="Choose file">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success media-browser-action-btn">
                            <i class="ri-refresh-line media-browser-icon-spin"></i>
                            <span>Upload</span>
                        </button>
                    </div>

                    <div class="media-browser-upload-form-msg"></div>
                </form>
            </div>
        </div>

        <div class="media-browser-link">
            <ul class="nav">
                <li media-browser-open-dir="/">
                    <i class="ri-home-3-line"></i>
                    <?= $path_name ? $path_name : 'Home'; ?>
                </li>
            </ul>
        </div>

        <div class="media-browser-list" media-browser-block>
            <div class="media-browser-list-preloader">
                <span>
                    <i class="ri-refresh-line media-browser-icon-spin"></i>
                </span>
            </div>

            <div class="media-browser-list-view" media-browser-view="list">
                <table class="media-browser-table">
                    <thead>
                        <tr>
                            <td>
                                <i class="ri-checkbox-blank-line media-browser-select-icon" media-browser-select-all></i>
                            </td>
                            <th>Name</th>
                            <th width="150px">Size</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="media-browser-table-notfound">
                                <i class="ri-error-warning-line"></i>
                                <div class="h4">Files not found!</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="media-browser-grid-view" media-browser-view="grid">
                <div class="media-browser-grid-in"></div>
                <div class="media-browser-table-notfound">
                    <i class="ri-error-warning-line"></i>
                    <div class="h4">Files not found!</div>
                </div>
            </div>
        </div>

        <div class="media-browser-info-popup"></div>
    </div>
</div>