<?php

namespace CustClasses\controllers;

use CustClasses\controllers\BaseController;
use CustClasses\models\QueryBuilder;
use CustClasses\models\FakerCust;
use CustClasses\models\Validate;
use League\Plates\Engine;
use Delight\Auth;


/**
 * Контроллер пользовательских страниц,
 */

class UserController extends BaseController {

    public function users() {
        //$this->faker->generateUsers(50);
        $users = $this->qb->getAllUsers();
        echo $this->templates->render('users', ['users' => $users, 'state' => $this->state]);
    }

    public function login() {
        $mess = false;
        if($_SESSION['postreg']) {
            $mess = ['status' => 'alert-success', 'message' => 'Успешная регистрация, теперь вы можете войти!'];
            $_SESSION['postreg'] = false;
        }
        if (!$this->auth->isLoggedIn()) {
            if(isset($_POST['email'])) {
                try {
                    $this->auth->login($_POST['email'], $_POST['password']);
                    header("Location: /");
                }
                catch (Auth\InvalidEmailException $e) {
                    $mess = ['status' => 'alert-danger', 'message' => 'Wrong email address'];
                }
                catch (Auth\InvalidPasswordException $e) {
                    $mess = ['status' => 'alert-danger', 'message' => 'Wrong password'];
                }
                catch (Auth\EmailNotVerifiedException $e) {
                    $mess = ['status' => 'alert-danger', 'message' => 'Email not verified'];
                }
                catch (Auth\TooManyRequestsException $e) {
                    $mess = ['status' => 'alert-danger', 'message' => 'Too many requests'];
                }
            }
            echo $this->templates->render('page_login', ['mess' => $mess]);
        }
        else {
            header("Location: /");
        }
    }

    public function registration() {
        if (!$this->auth->isLoggedIn()) {
            $mess = false;
            if(isset($_POST['email'])) {
                $mess = $this->validator->validate_registration($_POST);
                if(!$mess) {
                    $mess = $this->qb->register_user($_POST);
                    if(!$mess) {
                        $_SESSION['postreg'] = true;
                        header('Location: /login');
                    }
                }
            }
            echo $this->templates->render('page_register', ['mess' => $mess]);
        }
    }

    public function logout() {
        $this->auth->logOut();
        header("Location: /");
    }


    public function edit($vars) {
        $mess = false;
        if(isset($vars['id'])) {
            if($this->state['role'] == 1) $user_id = $vars['id'];
            else {
                header('Location: /');
            }
        } else {
            $user_id = $this->state['id'];
        }
        if(isset($_POST['username'])) {
            $mess = $this->validator->validate_profile_edit($_POST);
            if(!$mess) {
                $this->qb->userEdit($user_id, $_POST);
                $mess[] = ['status' => 'alert-success', 'message' => 'Данные успешно обновлены'];
            }
        }

        $user_info = $this->qb->getOneUser($user_id);
        echo $this->templates->render('edit', ['mess' => $mess, 'state' => $this->state, 'user_info' => $user_info]);
    }

    public function security($vars) {
        $mess = false;
        if(isset($vars['id'])) {
            if($this->state['role'] == 1) $user_id = $vars['id'];
            else {
                header('Location: /');
            }
        } else {
            $user_id = $this->state['id'];
        }


        if(isset($_POST['email'])) {
            $mess = $this->qb->update_user_email($_POST);
            if ($mess == false) {
                $mess[] = ['status' => 'alert-success', 'message' => 'Данные успешно обновлены'];
            }
        }

        if(isset($_POST['oldpassword'])) {
            $mess = $this->qb->update_user_password($_POST);
            if ($mess == false) {
                $mess[] = ['status' => 'alert-success', 'message' => 'Данные успешно обновлены'];
            }
        }

        $user_info = $this->qb->getOneUser($user_id);
        echo $this->templates->render('security', ['mess' => $mess, 'state' => $this->state, 'user_info' => $user_info]);
    }

    public function media($vars) {
        $mess = false;
        if(isset($vars['id'])) {
            if($this->state['role'] == 1) $user_id = $vars['id'];
            else {
                header('Location: /');
            }
        } else {
            $user_id = $this->state['id'];
        }
        if(isset($_FILES['image'])) {
            $image_name = $this->imageSaver->saveImage($_FILES['image'], 'app/templates/userimages');
            d($image_name);
            $this->qb->update_user_image($user_id, $image_name);
        }
        $user_info = $this->qb->getOneUser($user_id);
        echo $this->templates->render('media', ['mess' => $mess, 'state' => $this->state, 'user_info' => $user_info]);
    }

    public function confirmation($vars) {
        try {
            $this->auth->confirmEmail($vars['selector'], $vars['token']);
            echo 'Email address has been verified';
        }
        catch (Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }



}