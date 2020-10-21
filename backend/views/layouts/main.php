<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
$this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= $this->imagesUrl('images/favicon.ico'); ?>">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?> &bull; AVLO UZ</title>
    <?php $this->head(); ?>

    <script type="text/javascript">
        var site_url = '<?= admin_url(); ?>';
        var this_url = window.location.href;
        var images_url = '<?= images_url(); ?>';
        var ajax_error_msg = 'An error occurred while processing your request. Please try agian.';
    </script>
</head>

<body data-sidebar="dark">
    <?php $this->beginBody(); ?>

    <div id="preloader">
        <div id="preloader-in">
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= \backend\widgets\HeaderWidget::widget(); ?>

        <!-- Left Sidebar Start -->
        <?= \backend\widgets\SidebarWidget::widget(); ?>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
                <div class="content-header">
                    <?= $this->render('breadcrumb.php'); ?>
                </div>

                <div class="container-fluid">
                    <?= $content ?>
                </div>
            </div>

            <?= \backend\widgets\FooterWidget::widget(); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php $this->endBody(); ?>

</body>

</html>
<?php $this->endPage(); ?>