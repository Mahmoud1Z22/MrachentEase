<?php namespace App\Models;

use CodeIgniter\Model;

class Shops_model extends Model{
    public $table = 'shops';
    public $primaryKey = 'shop_id';
    public $allowedFields = [
        'marchent_id',
        'shop_name',
        'shop_description',
        'shop_address',
        'shop_icon',
    ];
}
?>