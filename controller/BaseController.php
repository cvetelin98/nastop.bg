<?php

namespace controller;

class BaseController {

    public function index(){
   header("Location: view/pageNotFound.html");
    }
}