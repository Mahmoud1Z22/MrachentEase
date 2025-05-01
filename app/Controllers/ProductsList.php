<?php

namespace App\Controllers;

class ProductsList extends BaseController
{
    public function index(): string
    {
        return view('products_list');
    }
}
