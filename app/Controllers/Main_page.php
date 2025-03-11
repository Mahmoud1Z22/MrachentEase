<?php

namespace App\Controllers;

class Main_page extends BaseController
{
    public function index(): string
    {
        return view('main_page');
    }
}
