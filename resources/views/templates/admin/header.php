<!DOCTYPE html>
<html lang="ru-RU">

<head>
    <meta charset="utf-8" />
    <title><?php echo $data['title'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $data['description'];?>">
    <meta name="csrf_tocken" content="<?= csrf_token() ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" href="../public/images/favicons/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="../public/images/favicons/favicon-32x32.png" sizes="32x32" />

    <script src="../public/js/admin/config.min.js"></script>

    <?php if (in_array($data['temp'], ['product-add', 'product-edit'])) { ?>
        <link href="../public/css/admin/quill.snow.css" rel="stylesheet" type="text/css" />
        <script src="../public/js/admin/quill-new.min.js"></script>
    <?php } ?>

    <link href="../public/css/admin/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../public/css/admin/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../public/css/admin/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/admin/main.css' );?>" rel="stylesheet" type="text/css" />

    <script src="../public/js/admin/vendor.min.js"></script>
    <script src="../public/js/admin/app.min.js" defer></script>

    <script src="../public/js/sortable/sortable.js" defer></script>
    <script src="../public/js/admin/admin.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/admin/admin.js' );?>" defer></script>
</head>

<body>
    <div class="wrapper">
