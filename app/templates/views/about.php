<?php
use function \Tamtamchik\SimpleFlash\flash;
$this->layout('layout', ['title' => $title]) ?>

<h1><?= flash()->display();?></h1>
<p>This is about page </p>