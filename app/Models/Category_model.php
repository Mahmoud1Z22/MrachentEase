<?php namespace App\Models;

use CodeIgniter\Model;

class Category_model extends Model{
    public $table = 'catigories';
    public $primaryKey = 'category_id';
    public $allowedFields = [
        'category_name',  
    ];
}
?>