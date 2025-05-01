<?php

namespace App\Models;

use CodeIgniter\Model;

class SuborderItem_model extends Model
{
    protected $table = 'suborder_items';
    protected $primaryKey = 'suborder_item_id';
    protected $allowedFields = ['suborder_id', 'product_id', 'quantity', 'price'];

    // Specify the return type as an array
    protected $returnType = 'array';

    // Timestamps are not used in this table
    protected $useTimestamps = false;

    // Validation rules (optional)
    protected $validationRules = [
        'suborder_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|greater_than[0]',
        'price' => 'required|decimal'
    ];

    protected $validationMessages = [
        'suborder_id' => [
            'required' => 'The suborder ID is required.',
            'integer' => 'The suborder ID must be an integer.'
        ],
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer.'
        ],
        'quantity' => [
            'required' => 'The quantity is required.',
            'integer' => 'The quantity must be an integer.',
            'greater_than' => 'The quantity must be greater than 0.'
        ],
        'price' => [
            'required' => 'The price is required.',
            'decimal' => 'The price must be a valid decimal number.'
        ]
    ];

    // Method to get all items for a suborder
    public function getItemsBySuborder($suborder_id)
    {
        return $this->where('suborder_id', $suborder_id)->findAll();
    }
}