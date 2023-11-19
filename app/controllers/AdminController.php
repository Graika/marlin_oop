<?php

namespace CustClasses\controllers;

use CustClasses\controllers\BaseController;
use CustClasses\models\ImageSaver;

/**
 * Контроллер адмнских страниц, основанный на базовом
 */

class AdminController extends BaseController {
    public function create_user() {
        $errors = false;
        if(isset($_POST['username'])) {
            $errors = $this->validator->validate_creation_user($_POST);
            if(!$errors) {
                $image_name = $this->imageSaver->saveImage($_FILES['avatar'], 'app/templates/userimages');
                $this->qb->create_user($_POST, $image_name);
                header('Location: /');
            }
        }
        echo $this->templates->render('create_user', ['state' => $this->state, 'mess' => $errors]);
    }

}