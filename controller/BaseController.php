<?php

namespace controller;

use model\dao\TravelDao;

class BaseController {

    public function index() {
        $travels = TravelDao::getAll();
        require "view/main.php";
    }
}