<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta content="<?php echo $data['description'];?>" name="description" />
    <title><?php echo $data['title'];?></title>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" href="../public/images/favicons/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="../public/images/favicons/favicon-32x32.png" sizes="32x32" />


    <!-- Css -->
    <link href="../public/assetsnew/dist/front.min.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/assetsnew/dist/front.min.css' );?>" rel="stylesheet" type="text/css" />
    <link href="../public/css/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/main.css' );?>" rel="stylesheet" type="text/css">

    <!-- JAVASCRIPT -->
    <script src="../public/assetsnew/dist/front.min.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/assetsnew/dist/front.min.js' );?>" defer></script>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>">
    <div class="page">
        <?php if (array_key_exists('temp_header', $data)) {
            insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
        } ?>
