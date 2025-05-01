<?php namespace App\Models;

use CodeIgniter\Model;

class brands_model extends Model{
    public $table = 'brands';
    public $primaryKey = 'brand_id';
    public $allowedFields = [
        'category_id',  
        'brand_name'
    ];
}
?>