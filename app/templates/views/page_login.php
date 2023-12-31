<?php $this->layout('layouts/layout_login', ['title' => "Авторизация"]); ?>

<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="/" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="/app/templates/img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Учебный проект</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <?php if($mess) { ?>
            <div class="alert <?=$mess['status']?>">
                <?=$mess['message']?>
            </div>
        <?php } ?>
        <form action="/login" method="post">
            <div class="form-group">
                <label class="form-label" for="username">Email</label>
                <input type="email" id="username" name="email" class="form-control" placeholder="Эл. адрес" value="">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="" >
            </div>
            <button type="submit" class="btn btn-default float-right">Войти</button>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        Нет аккаунта? <a href="page_register.html"><strong>Зарегистрироваться</strong>
    </div>
</div>
