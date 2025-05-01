<?php namespace App\Models;

use CodeIgniter\Model;

class Cart_model extends Model{
    public $table = 'cart';
    public $primaryKey = 'cart_id';
    public $allowedFields = [
        'customer_id',
        'product_id',
        'quantity' ,
        'added_at'
    ];

    protected $beforeInsert = ['setAddedAt'];

    protected function setAddedAt(array $data)
    {
        if (!isset($data['data']['added_at'])) {
            $data['data']['added_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
}
?>