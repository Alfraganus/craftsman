<?php
$this->title = 'Media Browser';

echo $this->render('browser', [
    'path_name' => $path_name
]);

if (isset($path) && $path) {
    $script = "media_browser_path = '{$path}';";
    $this->registerJs($script);
}

$this->registerJs(<<<JS
    $(document).ready(function () {
        mediaBrowserInit();
    });
JS);
