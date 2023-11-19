<?php $this->layout('layouts/layout', ['title' => "Безопасность", 'state' => json_encode($state)]); ?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-lock'></i> Безопасность
        </h1>

    </div>
    <div class="row">
        <div class="col-xl-6">
            <?php d($mess); if($mess) {
                foreach ($mess as $message) { ?>
                    <div class="alert <?=$message['status']?> text-dark" role="alert">
                        <strong>Уведомление!</strong> <?=$message['message']?>
                    </div>
                <?php }
            } ?>
            <div id="panel-1" class="panel">
                <form action="" method="post">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Обновление эл. адреса</h2>
                        </div>
                        <div class="panel-content">
                            <!-- email -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Email</label>
                                <input type="text" id="simpleinput" class="form-control" name="email" value="<?=$user_info['email']?>">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Пароль</label>
                                <input type="password" id="simpleinput" name="password" class="form-control">
                            </div>

                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Изменить Email</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="" method="post">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Старый пароль</label>
                                    <input type="password" id="simpleinput" name="oldpassword" class="form-control">
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Пароль</label>
                                    <input type="password" id="simpleinput" name="password" class="form-control">
                                </div>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                                    <input type="password" id="simpleinput" name="password_confirm" class="form-control">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить</button>
                                </div>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>
