<?php

use backend\models\Menu;

$json_data = array();
$item_type = 'link';
$menu_id = isset($id) ? $id : 0;

if (isset($data) && !is_null($data) && $data) {
    $json_data = json_decode($data, true);

    $name = array_value($json_data, 'name', '-');
    $attrs = array_value($json_data, 'attrs');
    $menu_type = array_value($json_data, 'menu_type');
    $class_name = array_value($json_data, 'class_name');
    $link = array_value($json_data, 'link', '#');
    $link_target = array_value($json_data, 'link_target');
}

if (isset($action_type)) {
    $item_type = $action_type;
} else if (isset($type)) {
    $item_type = $type;
} ?>

<div class="menu-page-item-box" data-id="<?= $menu_id; ?>">
    <input type="hidden" data-name="id">
    <input type="hidden" data-name="item_id" value="<?= $item_id; ?>">
    <input type="hidden" data-name="type" value="<?= $item_type; ?>">

    <div class="menu-page-item-box-in">
        <div class="menu-page-item-box-top">
            <div class="menu-page-item-box-title">
                <i class="ri-drag-move-fill"></i>
                <span><?= htmlspecialchars($name, ENT_QUOTES); ?></span>
                <em>[<?= $item_type; ?>]</em>
            </div>
            <div class="menu-page-item-box-btns">
                <button type="button" class="btn menu-page-item-edit">Edit</button>
                <button type="button" class="btn menu-page-item-delete">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </div>

        <div class="menu-page-item-box-info">
            <div class="row">
                <div class="col-md-12 col-12 form-group">
                    <label>Title</label>
                    <input type="text" data-name="name" class="form-control menu-title-input" value="<?= htmlspecialchars($name, ENT_QUOTES); ?>">
                </div>
                <?php if ($item_type == 'link') : ?>
                    <div class="col-md-12 col-12 form-group">
                        <label>Link</label>
                        <input type="text" data-name="link" class="form-control" value="<?= htmlspecialchars($link, ENT_QUOTES); ?>">
                    </div>
                <?php endif; ?>
                <div class="col-md-6 col-12 form-group">
                    <?php
                    $link_targets = array(
                        '_blank' => 'Blank',
                        '_parent' => 'Parent',
                        '_self' => 'Self',
                        '_top' => 'Top',
                    ); ?>
                    <label>Link target</label>
                    <select data-name="link_target" class="form-control custom-select">
                        <option value="">-</option>
                        <?php
                        foreach ($link_targets as $link_tkey => $link_tvalue) {
                            if ($link_tkey == $link_target) {
                                echo '<option value="' . $link_tkey . '" selected>' . $link_tvalue . '</option>';
                            } else {
                                echo '<option value="' . $link_tkey . '">' . $link_tvalue . '</option>';
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-6 col-12 form-group">
                    <?php
                    $menu_types = array(
                        'simple-menu' => 'Simple menu',
                        'mega-menu' => 'Mega menu',
                    ); ?>
                    <label>Menu type</label>
                    <select data-name="menu_type" class="form-control custom-select">
                        <?php
                        foreach ($menu_types as $menu_tkey => $menu_tvalue) {
                            if ($menu_tkey == $menu_type) {
                                echo '<option value="' . $menu_tkey . '" selected>' . $menu_tvalue . '</option>';
                            } else {
                                echo '<option value="' . $menu_tkey . '">' . $menu_tvalue . '</option>';
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-6 col-12 form-group">
                    <label>Attributes</label>
                    <input type="text" data-name="attrs" class="form-control" value="<?= htmlspecialchars($attrs, ENT_QUOTES); ?>">
                </div>
                <div class="col-md-6 col-12 form-group">
                    <label>Class name</label>
                    <input type="text" data-name="class_name" class="form-control" value="<?= htmlspecialchars($class_name, ENT_QUOTES); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="menu-page-item-box-list menu-sortable">
        <?php
        if (isset($childs) && $childs) {
            Menu::menuItemsForRender($childs, $model, $this);
        } ?>
    </div>
</div>