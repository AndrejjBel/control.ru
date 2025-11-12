<?php
$currUser = userAllDataNew();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$link_lk = '/dashboard';
if (is_admin_allowed()) {
    $link_lk = '/admin';
}
$site_settings = json_decode(site_settings('site_settings'));
?>
<header id="topnav" class="header-pages">
    <div class="main-container container-header">
        <a href="/" class="site-brand">
            <!-- <img src="../public/images/logo-txtgen1.png" class="logo-img me-2" alt=""> -->
            <div class="site-brand-title"><?php echo $site_settings->site_title;?></div>
        </a>
        <div class="header-nav">
            <div class="primary-nav">
                <a href="#" class="btn primary">Продукты</a>
                <a href="#" class="btn primary">Бдюдо из продуктов</a>
                <a href="#" class="btn primary">Рецепт</a>
                <a href="#" class="btn primary">Меню на неделю</a>
            </div>
            <div class="user-wrap dropdown-wrap">
                <button class="user-icon btn primary round" type="button" name="button" data-dropdown="user-info">
                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path d="M240 192C240 147.8 275.8 112 320 112C364.2 112 400 147.8 400 192C400 236.2 364.2 272 320 272C275.8 272 240 236.2 240 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM144 544C144 473.3 201.3 416 272 416L368 416C438.7 416 496 473.3 496 544L496 552C496 565.3 506.7 576 520 576C533.3 576 544 565.3 544 552L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 552C96 565.3 106.7 576 120 576C133.3 576 144 565.3 144 552L144 544z"/>
                    </svg>
                </button>
                <div class="user-info dropdown-elem" data-dropdown-elem="user-info">
                    <?php if (is_login()) { ?>
                        <div class="user-name">
                            <a href="<?php echo $link_lk;?>">
                                <span><?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?></span>
                            </a>
                        </div>
                        <div class="user-balance">Баланс: <?php echo round($currUser['balance'], 2);?></div>
                        <form action="/logout" method="post" accept-charset="utf-8" class="user-logout">
                            <input type="hidden" name="actions" value="logOut">
                            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                            <button type="submit" class="dashboard-logout-btn btn btn-link btn-sm">Выйти</button>
                        </form>
                    <?php } else { ?>
                        <a href="/login">Авторизация</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>
