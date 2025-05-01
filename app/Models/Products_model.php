<?php namespace App\Models;

use CodeIgniter\Model;

class Products_model extends Model{
    public $table = 'products';
    public $primaryKey = 'product_id';
    protected $allowedFields = [
        'shop_id',
        'product_name',
        'product_description',
        'price',
        'quantity',
        'category_id',
        'brand_id',    // correct field
        'dimensions',
        'weight',
        'stock_status',
        'slug'         // add this
    ];
    
}
?>