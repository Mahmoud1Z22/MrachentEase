<?php

namespace App\Controllers;

class OrderCompleted extends BaseController
{
    public function index()
    {
        $orderModel = new \App\Models\Order_model();
        $suborderModel = new \App\Models\Suborder_model();
        $suborderItemModel = new \App\Models\SuborderItem_model();
        $productModel = new \App\Models\Products_model();
        $shopModel = new \App\Models\Shops_model();

        $user_id = session()->get('user_id');
        $logged_in = session()->get('logged_in');

        if (!$logged_in || !$user_id) {
            return redirect()->to('login')->with('error', 'Please log in to view your order.');
        }

        // Get the order_id from the query parameter
        $order_id = $this->request->getGet('order_id');
        if (!$order_id) {
            log_message('error', 'No order_id provided for order-completed page');
            return redirect()->to('cart')->with('error', 'Invalid order. Please try again.');
        }

        // Fetch the order and verify it belongs to the customer
        $order = $orderModel->where('order_id', $order_id)
                            ->where('customer_id', $user_id)
                            ->first();

        if (!$order) {
            log_message('error', 'Order not found or does not belong to customer. Order ID: ' . $order_id . ', Customer ID: ' . $user_id);
            return redirect()->to('cart')->with('error', 'Order not found.');
        }

        // Fetch suborders for the order
        $suborders = $suborderModel->where('order_id', $order_id)->findAll();
        $grouped_suborders = [];

        foreach ($suborders as $suborder) {
            $shop = $shopModel->find($suborder['shop_id']);
            if (!$shop) {
                log_message('error', 'Shop not found for shop_id: ' . $suborder['shop_id']);
                continue;
            }

            $items = $suborderItemModel->where('suborder_id', $suborder['suborder_id'])->findAll();
            foreach ($items as &$item) {
                $product = $productModel->find($item['product_id']);
                if ($product) {
                    $item['product_name'] = $product['product_name'];
                } else {
                    $item['product_name'] = 'Unknown Product';
                    log_message('error', 'Product not found for product_id: ' . $item['product_id']);
                }
            }

            $grouped_suborders[$suborder['suborder_id']] = [
                'shop_name' => $shop['shop_name'],
                'subtotal' => $suborder['subtotal'],
                'status' => $suborder['status'],
                'items' => $items
            ];
        }

        $data = [
            'order' => $order,
            'grouped_suborders' => $grouped_suborders
        ];

        return View('order-completed', $data);
    }
}