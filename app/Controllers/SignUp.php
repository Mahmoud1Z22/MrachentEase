<?php

namespace App\Controllers;

class SignUp extends BaseController
{
    public function index(): string
    {
        return view('sign_up');
    }
}
