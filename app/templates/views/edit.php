<?php $this->layout('layouts/layout', ['title' => "Редактирование профиля", 'state' => json_encode($state)]);?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
        </h1>

    </div>
    <form action="" method="post">
        <div class="row">
            <div class="col-xl-6">
                <?php if($mess) {
                    foreach ($mess as $message) { ?>
                        <div class="alert <?=$message['status']?> text-dark" role="alert">
                            <strong>Уведомление!</strong> <?=$message['message']?>
                        </div>
                    <?php }
                } ?>
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <!-- username -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Имя</label>
                                <input type="text" id="simpleinput" name="username" class="form-control" value="<?=$user_info['username']?>">
                            </div>

                            <!-- title -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Место работы</label>
                                <input type="text" id="simpleinput" name="job"  class="form-control" value="<?=$user_info['job']?>">
                            </div>

                            <!-- tel -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Номер телефона</label>
                                <input type="text" id="simpleinput" name="phone_number" class="form-control" value="<?=$user_info['phone_number']?>">
                            </div>

                            <!-- address -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Адрес</label>
                                <input type="text" id="simpleinput" name="adress" class="form-control" value="<?=$user_info['adress']?>">
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Редактировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
