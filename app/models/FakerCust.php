<?php

namespace CustClasses\models;

use CustClasses\models\QueryBuilder;
use Delight\Auth\Auth;
use Faker\Factory;

class FakerCust
{
    private $pdo;
    private $capsule;
    private $auth;
    private $faker;

    public function __construct(QueryBuilder $qb) {
        $this->pdo = $qb->getPdo();
        $this->capsule = $qb->getCapsule();
        $this->auth = new Auth($this->pdo);
        $this->faker = Factory::create();
    }

    public function generateUsers($n) {
        for($i = 0; $i < $n; $i++) {
            $userId = $this->auth->admin()->createUser($this->faker->email(), 12345, $this->faker->name());
            $this->capsule::table("users_info")->insert(array([
                'user_id' => $userId,
                'phone_number' => $this->faker->phoneNumber(),
                'adress' => $this->faker->address(),
                'image' => $this->faker->imageUrl(),
                'job' => $this->faker->jobTitle()
            ]));
        }
    }
}