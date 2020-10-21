<?php
// Get active languages
function get_active_langs($hide_active = false)
{
    $output = array();
    $array = \base\Backend::language('list');

    if ($array) {
        $hide_id = 0;

        if ($hide_active) {
            $current_lang = get_current_lang();
            $current_lexicon = get_content_lexicon();

            if ($current_lexicon && $hide_active == 'content_lexicon') {
                $hide_id = $current_lexicon['id'];
            } elseif ($current_lang) {
                $hide_id = $current_lang['id'];
            }

            foreach ($array as $key => $value) {
                if ($value['id'] != $hide_id) {
                    $output[$key] = $value;
                }
            }
        } else {
            $output = $array;
        }
    }

    return $output ? $output : array();
}

// Get current language
function get_current_lang()
{
    $array = \base\Backend::language('current');
    return $array ? $array : array();
}

// Get current content language
function get_content_lexicon()
{
    $array = \base\Backend::language('content');
    return $array ? $array : array();
}

// Media browser input
function media_browser_input($type = 'single')
{
    $template = '<div class="media-browser-frame-group">';
    $template .= '{label}';
    $template .= '<div class="input-group">';
    $template .= '{input}';
    $template .= '<div class="input-group-append">';
    $template .= '<button type="button" class="btn-image-clear">';
    $template .= '<i class="ri-close-fill"></i>';
    $template .= '</button>';
    $template .= '<button type="button" class="btn btn-secondary" media-browser-show="single">Select</button>';
    $template .= '</div>';
    $template .= '</div>';

    if ($type == 'image') {
        $template .= '<div class="media-browser-input-img"></div>';
    }

    $template .= '</div>';

    return $template;
}

// Field slug input
function field_slug_input($tooltip = 'Clear')
{
    $template = '{label}';
    $template .= '<div class="input-group">';
    $template .= '{input}';
    $template .= '<div class="input-group-append input-on-slug-eraser c-pointer">';
    $template .= '<span class="input-group-text" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '">';
    $template .= '<i class="ri-eraser-fill"></i>';
    $template .= '</span>';
    $template .= '</div>';
    $template .= '</div>';

    return $template;
}

// Field with tooltip label
function field_with_tooltip_label($tooltip, $place = 'right')
{
    $template = '<div class="label">
        <span data-toggle="tooltip" data-placement="' . $place . '" title="' . $tooltip . '">
            {label} <i class="ri-question-line" style="font-size: 12px;"></i>
        </span>
    </div>
    {input}';

    return $template;
}

// Field with append group
function field_with_append_group($text)
{
    $template = '{label}';
    $template .= '<div class="input-group">';
    $template .= '{input}';
    $template .= '<div class="input-group-append">';
    $template .= '<div class="input-group-text">' . $text . '</div>';
    $template .= '</div>';
    $template .= '</div>';

    return $template;
}

// Settings item form input field
function settings_item_form_input_field($item, $args = array())
{
    $active_lang = array_value($args, 'active_lang');
    $active_lang_key = array_value($active_lang, 'lang_code');

    if ($item->required == 1) {
        $required = 'required="required"';
    } else {
        $required = '';
    }

    if ($active_lang_key) {
        $label = $item->title . ' [' . $active_lang_key . ']';
        $input_name = 'name="settings_translation[' . $active_lang_key . '][' . $item->settings_key . ']"';
        $input_value = $item->translation ? $item->translation : $item->settings_value;
    } else {
        $label = $item->title;
        $input_name = 'settings[' . $item->settings_key . ']';
        $input_value = $item->settings_value;
    }

    $output = '<label for="' . $item->settings_key . '">' . $label . '</label>';
    $output .= '<input type="' . $item->settings_type . '" class="form-control" ' . $input_name . ' id="' . $item->settings_key . '" value="' . $input_value . '" ' . $required . '>';

    return $output;
}

// Settings item form textarea field
function settings_item_form_textarea_field($item, $args = array())
{
    $active_lang = array_value($args, 'active_lang');
    $active_lang_key = array_value($active_lang, 'lang_code');
    $rows = array_value($args, 'rows', '3');

    if ($item->required == 1) {
        $required = 'required="required"';
    } else {
        $required = '';
    }

    if ($active_lang_key) {
        $label = $item->title . ' [' . $active_lang_key . ']';
        $input_name = 'name="settings_translation[' . $active_lang_key . '][' . $item->settings_key . ']"';
        $input_value = $item->translation ? $item->translation : $item->settings_value;
    } else {
        $label = $item->title;
        $input_name = 'settings[' . $item->settings_key . ']';
        $input_value = $item->settings_value;
    }

    $output = '<label for="' . $item->settings_key . '">' . $label . '</label>';
    $output .= '<textarea class="form-control" ' . $input_name . ' id="' . $item->settings_key . '" rows="' . $rows . '" ' . $required . '>' . $input_value . '</textarea>';


    return $output;
}

// Settings item form select field
function settings_item_form_select_field($item, $array, $args = array())
{
    $active_lang = array_value($args, 'active_lang');
    $active_lang_key = array_value($active_lang, 'lang_code');

    $value_as_key = array_value($args, 'value_as_key');
    $class = array_value($args, 'class', 'form-control custom-select');


    if ($item->required == 1) {
        $required = 'required="required"';
    } else {
        $required = '';
    }

    if ($active_lang_key) {
        $label = $item->title . ' [' . $active_lang_key . ']';
        $sname = 'name="settings_translation[' . $active_lang_key . '][' . $item->settings_key . ']"';
    } else {
        $label = $item->title;
        $sname = 'name="settings[' . $item->settings_key . ']"';
    }

    $output = '<label for="' . $item->settings_key . '">' . $label . '</label>';

    if ($array) {
        $output .= '<select class="' . $class . '" ' . $sname . '] id="' . $item->settings_key . '" ' . $required . '>';

        foreach ($array as $key => $value) {
            if ($value_as_key) {
                $item_key = $value;
                $item_value = $key;
            } else {
                $item_key = $key;
                $item_value = $value;
            }

            if ($item_key == $item->settings_value) {
                $output .= '<option value="' . $item_key . '" selected>' . $item_value . '</option>';
            } else {
                $output .= '<option value="' . $item_key . '">' . $item_value . '</option>';
            }
        }

        $output .= '</select>';
    }

    return $output;
}

// Settings item form select field
function settings_item_form_file_field($item, $args = array())
{
    $active_lang = array_value($args, 'active_lang');
    $active_lang_key = array_value($active_lang, 'lang_code');

    if ($item->required == 1) {
        $required = 'required="required"';
    } else {
        $required = '';
    }

    if ($active_lang_key) {
        $label = $item->title . ' [' . $active_lang_key . ']';
        $sname = 'name="settings_translation[' . $active_lang_key . '][' . $item->settings_key . ']"';
    } else {
        $label = $item->title;
        $sname = 'name="settings[' . $item->settings_key . ']"';
    }

    $output = '<div class="media-browser-frame-group">';
    $output .= '<label for="' . $item->settings_key . '">' . $label . '</label>';
    $output .= '<div class="input-group">';
    $output .= '<input type="text" class="form-control media-browser-input" ' . $sname . ' id="' . $item->settings_key . '" value="' . $item->settings_value . '" ' . $required . '>';
    $output .= '<div class="input-group-append">';
    $output .= '<button type="button" class="btn-image-clear"><i class="ri-close-fill"></i></button>';
    $output .= '<button type="button" class="btn btn-secondary" media-browser-show="single">Select</button>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
