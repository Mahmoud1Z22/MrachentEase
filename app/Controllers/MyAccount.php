<?php

namespace App\Controllers;
use App\Models\Users_model;
use App\Models\Shops_model;
use App\Models\Order_model;
use App\Models\Suborder_model;
use App\Models\SuborderItem_model;

class MyAccount extends BaseController
{
    public function index(): string
    {
        return view('my_account');
    }

    public function account_details(): \CodeIgniter\HTTP\RedirectResponse|string
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to view your account.');
        }

        // Load models
        $userModel = new Users_model();
        $shopModel = new Shops_model();
        $orderModel = new Order_model();
        $suborderModel = new Suborder_model();
        $suborderItemModel = new SuborderItem_model();

        // Get user ID from session
        $userId = session()->get('user_id');

        // Fetch user data
        $user = $userModel->find($userId);

        if (!$user) {
            // Handle case where user doesn't exist
            session()->destroy();
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        // Prepare data to pass to view
        $data = [
            'user' => $user
        ];

        // Fetch additional data based on user_type
        if ($user['user_type'] === 'merchant') {
            // Fetch shop details for merchants
            $shop = $shopModel->where('marchent_id', $userId)->first();
            if (!$shop) {
                log_message('error', 'Shop not found for merchant ID: ' . $userId);
                $data['shop'] = null;
            } else {
                $data['shop'] = $shop;

                // Fetch suborders for the merchant's shop
                $suborders = $suborderModel->where('shop_id', $shop['shop_id'])->findAll();
                foreach ($suborders as &$suborder) {
                    // Fetch the number of items in each suborder
                    $items = $suborderItemModel->where('suborder_id', $suborder['suborder_id'])->findAll();
                    $suborder['item_count'] = count($items);
                }
                $data['orders'] = $suborders;
            }
        } elseif ($user['user_type'] === 'customer') {
            // Fetch orders for the customer
            $orders = $orderModel->where('customer_id', $userId)->findAll();
            foreach ($orders as &$order) {
                // Fetch suborders to calculate the total number of items
                $suborders = $suborderModel->where('order_id', $order['order_id'])->findAll();
                $item_count = 0;
                foreach ($suborders as $suborder) {
                    $items = $suborderItemModel->where('suborder_id', $suborder['suborder_id'])->findAll();
                    $item_count += count($items);
                }
                $order['item_count'] = $item_count;
            }
            $data['orders'] = $orders;
            $data['customer_details'] = $user;
        }

        return view('my_account', $data);
    }
}