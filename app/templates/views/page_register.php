<?php $this->layout('layouts/layout_reg', ['title' => "Регистрация"]); ?>

<div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
        <div class="row">
            <div class="col-xl-12">
                <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                    Регистрация
                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                        Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                        <br>
                        По своей сути рыбатекст является альтернативой традиционному lorem ipsum
                    </small>
                </h2>
            </div>
            <div class="col-xl-6 ml-auto mr-auto">
                <div class="card p-4 rounded-plus bg-faded">
                    <?php if($mess) {
                        foreach ($mess as $message) { ?>
                        <div class="alert <?=$message['status']?> text-dark" role="alert">
                            <strong>Уведомление!</strong> <?=$message['message']?>
                        </div>
                    <?php }
                    } ?>
                    <form id="js-login" novalidate="" action="" method="post">
                        <div class="form-group">
                            <label class="form-label" for="username">Имя Пользователя</label>
                            <input type="text" id="username" class="form-control" name="username" placeholder="Пример: 'Jonatan Joske'" required>
                            <div class="invalid-feedback">Заполните поле.</div>
                            <div class="help-block">Это Имя будет отображаться на общей странице</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="emailverify">Email</label>
                            <input type="email" id="emailverify" class="form-control" name="email" placeholder="Эл. адрес" required>
                            <div class="invalid-feedback">Заполните поле.</div>
                            <div class="help-block">Эл. адрес будет вашим логином при авторизации</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="userpassword">Пароль <br></label>
                            <input type="password" id="userpassword" class="form-control" name="password" placeholder="" required>
                            <div class="invalid-feedback">Заполните поле.</div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-md-4 ml-auto text-right">
                                <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">Регистрация</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>