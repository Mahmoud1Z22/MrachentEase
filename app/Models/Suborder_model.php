<?php

namespace App\Models;

use CodeIgniter\Model;

class Suborder_model extends Model
{
    protected $table = 'suborders';
    protected $primaryKey = 'suborder_id';
    protected $allowedFields = ['order_id', 'shop_id', 'subtotal', 'status'];

    // Specify the return type as an array
    protected $returnType = 'array';

    // Timestamps are not used in this table
    protected $useTimestamps = false;

    // Validation rules (optional)
    protected $validationRules = [
        'order_id' => 'required|integer',
        'shop_id' => 'required|integer',
        'subtotal' => 'required|decimal',
        'status' => 'in_list[pending,processing,shipped,delivered,cancelled]'
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order ID is required.',
            'integer' => 'The order ID must be an integer.'
        ],
        'shop_id' => [
            'required' => 'The shop ID is required.',
            'integer' => 'The shop ID must be an integer.'
        ],
        'subtotal' => [
            'required' => 'The subtotal is required.',
            'decimal' => 'The subtotal must be a valid decimal number.'
        ],
        'status' => [
            'in_list' => 'The status must be one of: pending, processing, shipped, delivered, cancelled.'
        ]
    ];

    // Method to get a suborder with its items
    public function getSuborderWithItems($suborder_id)
    {
        return $this->select('suborders.*, suborder_items.suborder_item_id, suborder_items.product_id, suborder_items.quantity, suborder_items.price')
            ->join('suborder_items', 'suborder_items.suborder_id = suborders.suborder_id', 'left')
            ->where('suborders.suborder_id', $suborder_id)
            ->findAll();
    }

    // Method to get all suborders for an order
    public function getSubordersByOrder($order_id)
    {
        return $this->select('suborders.*, suborder_items.suborder_item_id, suborder_items.product_id, suborder_items.quantity, suborder_items.price')
            ->join('suborder_items', 'suborder_items.suborder_id = suborders.suborder_id', 'left')
            ->where('suborders.order_id', $order_id)
            ->findAll();
    }
}