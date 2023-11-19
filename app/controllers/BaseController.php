<?php

namespace CustClasses\controllers;

use CustClasses\models\QueryBuilder;
use CustClasses\models\FakerCust;
use CustClasses\models\Validate;
use CustClasses\models\ImageSaver;
use League\Plates\Engine;
use Delight\Auth;


class BaseController {
    protected $templates;
    protected $auth;
    protected $pdo;
    protected $qb;
    protected $faker;
    protected $validator;
    protected $imageSaver;
    protected $state = false;

    public function __construct(QueryBuilder $qb, FakerCust $fc, Engine $engine, Validate $validate, ImageSaver $imageSaver) {
        $this->pdo = $qb->getPDO();
        $this->qb = $qb;
        $this->templates = $engine;
        $this->auth = new Auth\Auth($this->pdo);
        $this->faker = $fc;
        $this->validator = $validate;
        $this->imageSaver = $imageSaver;
        $role = 0;
        if($this->auth->hasRole(Auth\Role::ADMIN)) $role = 1;
        if ($this->auth->isLoggedIn()) {
            $this->state = [
                'id' => $this->auth->getUserId(),
                'role' => $role,
            ];
        }
    }
}