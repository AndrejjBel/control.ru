<?php
insertTemplate('/templates/header', ['data' => $data]);
$userId = userId();
$site_settings = json_decode(site_settings('site_settings'));
?>

<main class="main-container page-main">
    <h1 class="page-title text-center"><?php echo $site_settings->site_title;?></h1>

    <div class="page-content"></div>

</main>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);
