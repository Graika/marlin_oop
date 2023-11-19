<?php

namespace CustClasses\models;

use Rakit\Validation\Validator;

class Validate
{
    private $validator;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function validate_creation_user($post) {
        $validation = $this->validator->make($post, [
           'username' => 'required|min:3',
           'job' => 'required|min:3',
           'phone_number' => 'required:|numeric',
           'adress' => 'required',
           'email' => 'required|email',
           'password' => 'required|min:6',
           'avatar' => 'required|uploaded_file:0,5,png,jpg,jpeg',
        ], [
            'username:required' => "Имя - это обязательное поле",
            'username:min' => "Имя не должно быть короче 3 символов",
            'job:required' => "Место работы не должно быть короче 3 символов",
            'phone_number:required' => "Номер телефона - обязательное поле",
            'phone_number:numeric' => "Номер телефона может содержать только цифры",
            'adress:required' => "Адрес - это обязательное поле",
            'email:required' => "Email - обязательное поле",
            'email:email' => "Некорректный Email",
            'password:required' => "Номер телефона - обязательное поле",
            'password:numeric' => "Номер телефона может содержать только цифры",
        ]);
        $validation->validate();
        return $this->print_result($validation);
    }

    public function validate_registration($post) {
        $validation = $this->validator->make($post, [
            'username' => 'required|min:3',
            'password' => 'required|min:6',
        ], [
            'username:required' => "Имя - это обязательное поле",
            'username:min' => "Имя не должно быть короче 3 символов",
            'password:required' => "Номер телефона - обязательное поле",
            'password:numeric' => "Номер телефона может содержать только цифры",
        ]);
        $validation->validate();
        return $this->print_result($validation);
    }

    public function validate_profile_edit($post) {
        $validation = $this->validator->make($post, [
            'username' => 'required|min:3',
            'job' => 'required|min:6',
            'phone_number' => 'required|min:6',
            'adress' => 'required|min:6',
        ], [
            'username:required' => "Имя - это обязательное поле",
            'job:required' => "Место работы - это обязательное поле",
            'phone_number:required' => "Номер телефона - это обязательное поле",
            'adress:required' => "Адрес - это обязательное поле",
            'username:min' => "Имя не должно быть короче 3 символов",
            'job:min' => "Место работы не должно быть короче 6 символов",
            'phone_number:min' => "Номер телефона не должен быть короче 6 символов",
            'adress:min' => "Адрес не должен быть короче 6 символов",
        ]);
        $validation->validate();
        return $this->print_result($validation);
    }

    public function validate_image($post) {
        $validation = $this->validator->make($post, [
            'image' => 'required|uploaded_file:0,5,png,jpg,jpeg',
        ]);
        $validation->validate();
        return $this->print_result($validation);
    }

    private function print_result($validation) {
        if($validation->errors->count() == 0) return false;
        else {
            $mess = array();
            foreach ($validation->errors->all() as $err) {
                $mess[] = ['status' => 'alert-danger', 'message' => $err];
            }
            return $mess;
        }
    }
}