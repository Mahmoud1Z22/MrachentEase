<?php

namespace App\Controllers;

class Wishlist extends BaseController
{
    public function index(): string
    {
        return view('wishlist');
    }
}
