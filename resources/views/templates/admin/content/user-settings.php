<?php
$user = $data['user'];
$br_gen = 'Консоль';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
}
?>
<div class="content-page user-settings">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $br_gen;?></a></li>
                                <li class="breadcrumb-item active">Профиль <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Профиль <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card overflow-hidden">
                        <div class="card-body">

                            <div id="basicwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4 border-top-0" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#basictab1" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1 active" aria-selected="true" role="tab">
                                            <i class="ri-account-circle-line fw-normal fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Профиль</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#basictab2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1" aria-selected="true" role="tab">
                                            <i class="ri-account-circle-line fw-normal fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Биометрические данные</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#basictab3" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1" aria-selected="false" role="tab" tabindex="-1">
                                            <i class="ri-lock-2-line fw-normal fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Пароль</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">
                                    <form class="tab-pane user-settings active show" id="basictab1" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="first_name">Имя</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="first_name"
                                                            name="first_name"
                                                            class="form-control"
                                                            placeholder="Имя"
                                                            value="<?php echo ($user['first_name'])? $user['first_name'] : '';?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="last_name"> Фамилия</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="last_name"
                                                            name="last_name"
                                                            class="form-control"
                                                            placeholder="Фамилия"
                                                            value="<?php echo ($user['last_name'])? $user['last_name'] : '';?>">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="email">Email</label>
                                                    <div class="col-md-9">
                                                        <input type="email"
                                                            id="email"
                                                            name="email"
                                                            class="form-control"
                                                            placeholder="Email"
                                                            value="<?php echo $user['email'];?>"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="phone">Телефон</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="phone"
                                                            name="phone"
                                                            class="form-control phone_mask"
                                                            placeholder="Телефон"
                                                            value="<?php echo get_user_meta($user, 'generale', 'phone');?>">
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="description">О себе</label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control"
                                                            id="description"
                                                            name="description"
                                                            rows="5"><?php echo get_user_meta($user, 'generale', 'description');?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo csrf_field();?>
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="next list-inline-item float-end">
                                                <button type="button" name="submit" class="btn btn-info">Сохранить</button>
                                            </li>
                                        </ul>
                                    </form>

                                    <form class="tab-pane user-bio" id="basictab2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label">Пол</label>
                                                    <div class="col-md-9">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" id="female" name="gender" class="form-check-input" value="female"<?php echo checked('female', get_user_meta($user, 'bio', 'gender'));?>>
                                                                <label class="form-check-label" for="female">Женский</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" id="male" name="gender" class="form-check-input" value="male"<?php echo checked('male', get_user_meta($user, 'bio', 'gender'));?>>
                                                                <label class="form-check-label" for="male">Мужской</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="last_name">День рождения</label>
                                                    <div id="birthday" class="col-md-9">
                                                        <input type="text"
                                                            id="birthday"
                                                            name="birthday"
                                                            class="form-control air-datepicker-input"
                                                            placeholder="День рождения"
                                                            data-val="<?php echo get_user_meta($user, 'bio', 'birthday');?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="last_name">Рост</label>
                                                    <div class="col-md-9">
                                                        <input type="number"
                                                            id="user_height"
                                                            name="user_height"
                                                            class="form-control"
                                                            placeholder="Рост"
                                                            value="<?php echo get_user_meta($user, 'bio', 'user_height');?>">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="email">Вес</label>
                                                    <div class="col-md-9">
                                                        <input type="number"
                                                            id="user_weight"
                                                            name="user_weight"
                                                            class="form-control"
                                                            placeholder="Вес"
                                                            value="<?php echo get_user_meta($user, 'bio', 'user_weight');?>">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="phone">Уровень активности</label>
                                                    <div class="col-md-9 d-flex align-items-center">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="short" name="activity_level" class="form-check-input" value="short"<?php echo checked('short', get_user_meta($user, 'bio', 'activity_level'));?>>
                                                            <label class="form-check-label" for="short">Низкий</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="average" name="activity_level" class="form-check-input" value="average"<?php echo checked('average', get_user_meta($user, 'bio', 'activity_level'));?>>
                                                            <label class="form-check-label" for="average">Средний</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="high" name="activity_level" class="form-check-input" value="high"<?php echo checked('high', get_user_meta($user, 'bio', 'activity_level'));?>>
                                                            <label class="form-check-label" for="high">Высокий</label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="description">Исключить продукты</label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control"
                                                            id="exclude_products"
                                                            name="exclude_products"
                                                            rows="5"><?php echo get_user_meta($user, 'bio', 'exclude_products');?></textarea>
                                                            <span class="help-block"><small>Перечислите продукты, которые хотите исключить при составлении меню питанияю Например: свинина, молоко</small></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo csrf_field();?>
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="next list-inline-item float-end">
                                                <button type="button" name="submit" class="btn btn-info">Сохранить</button>
                                            </li>
                                        </ul>
                                    </form>

                                    <form class="tab-pane user-password" id="basictab3" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_old">Старый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_old" name="password_old" class="form-control" placeholder="Старый пароль" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_new">Новый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_new" name="password_new" class="form-control" placeholder="Новый пароль" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                            <div class="invalid-feedback">Пароли не совпадают</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_re">Новый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_re" name="password_re" class="form-control" placeholder="Новый пароль еще раз" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                            <div class="invalid-feedback">Пароли не совпадают</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo csrf_field();?>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="next list-inline-item float-end">
                                                <button type="button" name="submit" class="btn btn-info">Сохранить</button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php

    // echo '<pre>';
    // var_dump($user);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>
