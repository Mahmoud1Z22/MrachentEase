<?php

namespace App\Controllers;

class ShopList extends BaseController
{
    public function index(): string
    {
        return view('shop_list');
    }
}
