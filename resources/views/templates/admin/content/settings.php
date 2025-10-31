<?php
$site_settings = json_decode(site_settings('site_settings'));
$copyright = '';
if ($site_settings) {
    if (isset($site_settings->copyright)) {
        $copyright = $site_settings->copyright;
    }
}
?>
<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard/generale">Консоль</a></li>
                                <li class="breadcrumb-item active">Настройки</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Настройки</h4>
                    </div>
                </div>
            </div>

            <form id="site_settings" class="mb-4">
                <div class="mb-3">
                    <label for="site_title" class="form-label">Название сайта</label>
                    <input type="text" id="site_title" name="site_title" class="form-control" value="<?php echo ($site_settings)? $site_settings->site_title : '';?>">
                    <span class="help-block"><small>Название сайта</small></span>
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">Описание сайта</label>
                    <textarea class="form-control" id="site_description"  name="site_description" rows="5"><?php echo ($site_settings)? $site_settings->site_description : '';?></textarea>
                    <span class="help-block"><small>Описание сайта</small></span>
                </div>

                <div class="mb-3">
                    <label for="copyright" class="form-label">Copyright</label>
                    <input type="text" id="copyright" name="copyright" class="form-control" value="<?php echo $copyright;?>">
                    <span class="help-block"><small>Copyright</small></span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="post_limit_admin" class="form-label">Количество записей в админке</label>
                            <input type="number"
                                id="post_limit_admin"
                                name="post_limit_admin"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->post_limit_admin : '';?>">
                            <span class="help-block"><small>Количество записей на страницах в админке</small></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="post_limit_site" class="form-label">Количество записей на сайте</label>
                            <input type="number"
                                id="post_limit_site"
                                name="post_limit_site"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->post_limit_site : '';?>">
                            <span class="help-block"><small>Количество записей на страницах на сайте</small></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pay_pass" class="form-label">Proxyapi secret key</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="secret_key" name="secret_key" class="form-control" autocomplete="new-password" value="<?php echo ($site_settings)? $site_settings->secret_key : '';?>">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        <span class="help-block"><small>Proxyapi secret key</small></span>
                    </div>
                </div>

                <?php echo csrf_field();?>

                <div class="mb-0">
                    <button type="button" name="submit" class="btn btn-info" onclick="formSiteSettings(this)">Сохранить</button>
                </div>

            </form>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
// var_dump(json_decode(site_settings('site_settings')));
