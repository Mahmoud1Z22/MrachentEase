<?php

namespace App\Models;

use CodeIgniter\Model;

class Order_model extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = ['customer_id', 'order_date', 'total_amount', 'status'];

    // Specify the return type as an array
    protected $returnType = 'array';

    // Automatically manage timestamps
    protected $useTimestamps = false; // Set to true if you want to manage created_at/updated_at automatically
    protected $createdField = 'order_date';
    protected $updatedField = '';

    // Validation rules (optional)
    protected $validationRules = [
        'customer_id' => 'required|integer',
        'total_amount' => 'required|decimal',
        'status' => 'in_list[pending,processing,shipped,delivered,cancelled]'
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'The customer ID is required.',
            'integer' => 'The customer ID must be an integer.'
        ],
        'total_amount' => [
            'required' => 'The total amount is required.',
            'decimal' => 'The total amount must be a valid decimal number.'
        ],
        'status' => [
            'in_list' => 'The status must be one of: pending, processing, shipped, delivered, cancelled.'
        ]
    ];

    // Callback to set order_date to current date if not provided
    protected $beforeInsert = ['setOrderDate'];

   protected function setOrderDate(array $data)
    {
        log_message('debug', 'Entering setOrderDate callback. App timezone: ' . date_default_timezone_get() . ', Raw now: ' . date('Y-m-d H:i:s') . ', Intended time: ' . (new \DateTime('now'))->format('Y-m-d H:i:s'));
        if (empty($data['data']['order_date'])) {
            $dateTime = new \DateTime('now');
            $data['data']['order_date'] = $dateTime->format('Y-m-d H:i:s');
            log_message('debug', 'Order date set to: ' . $data['data']['order_date'] . ', DateTime object: ' . json_encode($dateTime));
        } else {
            log_message('debug', 'Order date already provided (overriding): ' . $data['data']['order_date']);
        }
        return $data;
    }

    // Method to get an order with its suborders
    public function getOrderWithSuborders($order_id)
    {
        return $this->select('orders.*, suborders.suborder_id, suborders.shop_id, suborders.subtotal, suborders.status as suborder_status')
            ->join('suborders', 'suborders.order_id = orders.order_id', 'left')
            ->where('orders.order_id', $order_id)
            ->findAll();
    }

    // Method to get all orders for a customer
    public function getCustomerOrders($customer_id)
    {
        return $this->select('orders.*, suborders.suborder_id, suborders.shop_id, suborders.subtotal, suborders.status as suborder_status')
            ->join('suborders', 'suborders.order_id = orders.order_id', 'left')
            ->where('orders.customer_id', $customer_id)
            ->findAll();
    }
}