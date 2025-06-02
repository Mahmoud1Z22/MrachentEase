<?php

namespace App\Models;

use CodeIgniter\Model;

class Products_model extends Model
{
    public $table = 'products';
    public $primaryKey = 'product_id';
    protected $allowedFields = [
        'shop_id',
        'product_name',
        'product_description',
        'size',
        'target',
        'price',
        'rating',
        'dimensions',
        'quantity',
        'category_id',
        'brand_id',
        'stock_status',
        'weight',
        'slug',
        'subcategory_id'
    ];
}