<?php

namespace CustClasses\models;

use Imagine\Gd\Imagine;

class ImageSaver
{
    private $file;
    private $save_dir;
    private $name;
    private $imagine; // Компонент
    private $image; // Картинка

    public function __construct(Imagine $imagine) {
        $this->imagine = $imagine;
    }

    private function load($image, $save_dir) {
        $this->file = $image;
        $this->save_dir = $save_dir;
        $this->image = $this->imagine->open($this->file['tmp_name']);
    }

    private function resize() {
        //
    }

    private function explode_filename($fname) {
        $ext = explode(".", $fname);
        return $ext[count($ext)-1];
    }

    private function save() {
        $name = $this->save_dir."/".md5(time()).".".$this->explode_filename($this->file['name']);
        $this->image->save($name);
        $this->name = $name;
    }

    private function get_name() {
        return $this->name;
    }

    public function saveImage($image, $save_dir) {
        $this->load($image, $save_dir);
        $this->save();
        return $this->get_name();
    }
}