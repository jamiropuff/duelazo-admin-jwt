<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index() {
        return view('index');
    }

    public function dashboard() {
        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside');
        echo view('templates/breadcrumb');
        echo view('home/default');
        echo view('templates/footer');
    }
}
