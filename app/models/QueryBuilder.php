<?php

namespace CustClasses\models;

use Illuminate\Database\Capsule\Manager as Capsule;
use Delight\Auth\Auth;
use PDO;
use function DI\get;

class QueryBuilder {
    private $capsule;
    private $pdo;
    private $auth;

    public function __construct(Capsule $capsule, PDO $pdo) {
        $this->capsule = $capsule;
        $this->pdo = $pdo;
        $this->auth = new Auth($this->pdo);
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function getCapsule() {
        return $this->capsule;
    }

    public function getAllUsers() {
        $users = $this->capsule::table("users")->join("users_info", "users.id", "=", "users_info.user_id")->orderByDesc('users.id')->get()->toArray();
        $result = array_map(function ($value) {
            return (array)$value;
        }, $users);
        return $result;
    }

    public function getOneUser($id) {
        $users = $this->capsule::table("users")->where("users.id", $id)->join("users_info", "users.id", "=", "users_info.user_id")->get()->toArray();
        $result = array_map(function ($value) {
            return (array)$value;
        }, $users);
        return $result[0];
    }

    public function userEdit($id, $arr) {
        return $this->capsule::table("users")->where("users.id", $id)->join("users_info", "users.id", "=", "users_info.user_id")->update($arr);
    }

    public function create_user($post, $image) {
        try {
            $userId = $this->auth->admin()->createUser($post['email'], $post['password'], $post['username']);
            $this->capsule::table("users_info")->insert(array([
                'user_id' => $userId,
                'phone_number' => $post['phone_number'],
                'adress' => $post['adress'],
                'job' => $post['job'],
                'image' => $image // Найти компонент для загрузки картинки
            ]));
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            echo 'Invalid email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo 'Invalid email address';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            echo 'Invalid email address';
        }
    }

    public function register_user($post) {
        $mess = false;
        try {
            $userId = $this->auth->register($post['email'], $post['password'], $post['username'], function ($selector, $token) {
                // Отправка ссылки с селектором и токеном на указанный мейл
                $this->auth->confirmEmail($selector, $token);
            });
            $this->capsule::table("users_info")->insert(array([
                'user_id' => $userId,
            ]));
            header("Location: /");
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Wrong email address'];
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Wrong password'];
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Too many requests'];
        }
        return $mess;
    }

    public function update_user_password($post) {
        $mess = false;
        try {
            $this->auth->changePassword($_POST['oldpassword'], $_POST['password']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Invalid password(s)'];
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Too many requests'];
        }
        return $mess;
    }

    public function update_user_email($post) {
        $mess = false;
        try {
            if ($this->auth->reconfirmPassword($_POST['password'])) {
                $this->auth->changeEmail($_POST['email'], function ($selector, $token) {
                    // Отправка ссылки с селектором и токеном на указанный мейл
                    $this->auth->confirmEmail($selector, $token);
                });
            }
            else {
                $mess[] = ['status' => 'alert-danger', 'message' => 'Введен неправльный пароль'];
            }
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Некорректный адрес электронной почты'];
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Такой адрес электронной почты уже используеися'];
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Account not verified'];
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $mess[] = ['status' => 'alert-danger', 'message' => 'Too many requests'];
        }
        return $mess;
    }

    public function update_user_image($user_id, $img_src) {
        $user_info = $this->getOneUser($user_id);
        unlink($user_info['image']);
        return $this->capsule::table("users_info")->where("user_id", $user_id)->update(["image" => $img_src]);
    }
}