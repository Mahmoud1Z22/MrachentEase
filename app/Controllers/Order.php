<?php

namespace App\Controllers;

use App\Models\Order_model;
use App\Models\Shops_model;
use App\Models\Products_model;
use App\Models\SuborderItem_model;

class Order extends BaseController
{
    public function view()
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Please log in as a customer to view your orders.');
        }

        $customerId = session()->get('user_id');
        $orderModel = new Order_model();
        $shopModel = new Shops_model();

        // Fetch all shops to map shop_id to shop_name
        $shops = $shopModel->findAll();
        $shopNames = array_column($shops, 'shop_name', 'shop_id');

        // Fetch all orders for the customer with suborder details
        $orders = $orderModel->getCustomerOrders($customerId);

        // Group suborders by order_id for easier display
        $ordersWithSuborders = [];
        foreach ($orders as $order) {
            $orderId = $order['order_id'];
            if (!isset($ordersWithSuborders[$orderId])) {
                $ordersWithSuborders[$orderId] = [
                    'order_id' => $order['order_id'],
                    'order_date' => $order['order_date'],
                    'total_amount' => $order['total_amount'],
                    'status' => $order['status'],
                    'suborders' => []
                ];
            }
            if ($order['suborder_id']) {
                $ordersWithSuborders[$orderId]['suborders'][] = [
                    'suborder_id' => $order['suborder_id'],
                    'shop_id' => $order['shop_id'],
                    'subtotal' => $order['subtotal'],
                    'suborder_status' => $order['suborder_status']
                ];
            }
        }

        $data = [
            'orders' => $ordersWithSuborders,
            'shopNames' => $shopNames
        ];

        return view('order_view', $data);
    }

   public function details($order_id)
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Please log in as a customer to view order details.');
        }

        $customerId = session()->get('user_id');
        $orderModel = new Order_model();
        $shopModel = new Shops_model();
        $suborderItemModel = new SuborderItem_model();

        // Fetch the specific order with suborders
        try {
            $orders = $orderModel->getOrderWithSuborders($order_id);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching orders: ' . $e->getMessage());
            return redirect()->to('/order/view')->with('error', 'Unable to fetch order details. Please try again later.');
        }

        if (empty($orders) || !isset($orders[0]['customer_id']) || $orders[0]['customer_id'] !== $customerId) {
            return redirect()->to('/order/view')->with('error', 'Order not found or access denied.');
        }

        // Group suborders by order_id
        $order = [
            'order_id' => $orders[0]['order_id'],
            'order_date' => $orders[0]['order_date'],
            'total_amount' => $orders[0]['total_amount'],
            'status' => $orders[0]['status'],
            'suborders' => []
        ];

        // Fetch shop names
        try {
            $shops = $shopModel->findAll();
            $shopNames = array_column($shops, 'shop_name', 'shop_id');
        } catch (\Exception $e) {
            log_message('error', 'Error fetching shops: ' . $e->getMessage());
            $shopNames = [];
        }

        // Fetch all suborder IDs
        $suborderIds = array_column($orders, 'suborder_id');
        $suborderIds = array_filter($suborderIds); // Remove null values

        // Fetch items for all suborders
        $groupedItems = [];
        if (!empty($suborderIds)) {
            try {
                // Use SuborderItem_model to fetch items for all suborders
                $suborderItems = $suborderItemModel->select('suborder_items.*, products.product_name')
                    ->join('products', 'products.product_id = suborder_items.product_id', 'left')
                    ->whereIn('suborder_items.suborder_id', $suborderIds)
                    ->findAll();

                // Group items by suborder_id
                foreach ($suborderItems as $item) {
                    $groupedItems[$item['suborder_id']][] = $item;
                }
            } catch (\Exception $e) {
                log_message('error', 'Error fetching suborder items: ' . $e->getMessage());
                // Continue without items if query fails
            }
        }

        // Attach suborders and their items
        foreach ($orders as $item) {
            if (isset($item['suborder_id']) && $item['suborder_id']) {
                $order['suborders'][] = [
                    'suborder_id' => $item['suborder_id'],
                    'shop_id' => $item['shop_id'] ?? null,
                    'subtotal' => $item['subtotal'] ?? 0,
                    'suborder_status' => $item['suborder_status'] ?? 'unknown',
                    'products' => $groupedItems[$item['suborder_id']] ?? [] // Use 'products' key for consistency with the view
                ];
            }
        }

        $data = [
            'order' => $order,
            'shopNames' => $shopNames
        ];

        return view('order_details', $data);
    }
}