<?php namespace App\Models;

use CodeIgniter\Model;

class Product_images_model extends Model {
    protected $table = 'product_images';
    protected $primaryKey = 'id'; // Adjust to match your table's actual PK
    protected $allowedFields = [
        'product_id',
        'image',
        'image2',
        'image3',
        'image4'
    ];
}
