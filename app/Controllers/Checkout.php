<?php

namespace App\Controllers;

class Checkout extends BaseController
{
    public function index()
    {
        $cartModel = new \App\Models\Cart_model();
        $productModel = new \App\Models\Products_model();
        $imageModel = new \App\Models\Product_images_model();
        $shopModel = new \App\Models\Shops_model();

        $user_id = session()->get('user_id');
        $logged_in = session()->get('logged_in');

        if (!$logged_in || !$user_id) {
            return redirect()->to('login')->with('error', 'Please log in to proceed to checkout.');
        }

        $cart_items = [];
        try {
            $cart_items = $cartModel->where('customer_id', $user_id)->findAll();
            log_message('debug', 'Cart items fetched for checkout: ' . json_encode($cart_items));
        } catch (\Exception $e) {
            log_message('error', 'Error fetching cart items: ' . $e->getMessage());
            return redirect()->to('cart')->with('error', 'Unable to fetch cart data. Please try again later.');
        }

        $grouped_cart_items = [];
        $grand_total = 0;
        $seen_product_ids = [];

        foreach ($cart_items as $item) {
            if (in_array($item['product_id'], $seen_product_ids)) {
                log_message('warning', 'Duplicate product_id found in cart: ' . $item['product_id']);
                continue;
            }
            $seen_product_ids[] = $item['product_id'];

            try {
                $product = $productModel->find($item['product_id']);
                if (!$product) {
                    log_message('error', 'Product not found for product_id: ' . $item['product_id']);
                    continue;
                }

                $shop = $shopModel->find($product['shop_id']);
                if (!$shop) {
                    log_message('error', 'Shop not found for shop_id: ' . $product['shop_id']);
                    continue;
                }

                $image = $imageModel->where('product_id', $item['product_id'])->first();
                $item['product_name'] = $product['product_name'];
                $item['price'] = $product['price'];
                $item['subtotal'] = $product['price'] * $item['quantity'];
                $item['image'] = $image && !empty($image['image']) ? $image['image'] : 'images/default_product.jpg';
                $item['shop_id'] = $product['shop_id'];
                $item['shop_name'] = $shop['shop_name'];

                if (!isset($grouped_cart_items[$product['shop_id']])) {
                    $grouped_cart_items[$product['shop_id']] = [
                        'shop_name' => $shop['shop_name'],
                        'items' => [],
                        'subtotal' => 0
                    ];
                }

                $grouped_cart_items[$product['shop_id']]['items'][] = $item;
                $grouped_cart_items[$product['shop_id']]['subtotal'] += $item['subtotal'];
                $grand_total += $item['subtotal'];
            } catch (\Exception $e) {
                log_message('error', 'Error processing cart item for product_id: ' . $item['product_id'] . ' - ' . $e->getMessage());
                continue;
            }
        }

        $data = [
            'grouped_cart_items' => $grouped_cart_items,
            'grand_total' => $grand_total
        ];

        return View('checkout', $data);
    }

   public function placeOrder()
{
    log_message('debug', 'placeOrder method called. App timezone: ' . date_default_timezone_get() . ', Current time: ' . (new \DateTime('now'))->format('Y-m-d H:i:s'));

    $cartModel = new \App\Models\Cart_model();
    $productModel = new \App\Models\Products_model();
    $shopModel = new \App\Models\Shops_model();
    $orderModel = new \App\Models\Order_model();
    $suborderModel = new \App\Models\Suborder_model();
    $suborderItemModel = new \App\Models\SuborderItem_model();

    $user_id = session()->get('user_id');
    $logged_in = session()->get('logged_in');

    log_message('debug', 'User ID: ' . ($user_id ?? 'Not set') . ', Logged In: ' . ($logged_in ? 'Yes' : 'No'));
    log_message('debug', 'Session data: ' . json_encode(session()->get()));

    if (!$logged_in || !$user_id) {
        log_message('error', 'User not logged in or user_id not set');
        return redirect()->to('login')->with('error', 'Please log in to place an order.');
    }

    if (strtolower($this->request->getMethod()) !== 'post') {
        log_message('error', 'Invalid request method for placeOrder: ' . $this->request->getMethod());
        return redirect()->to('checkout')->with('error', 'Invalid request. Please use the checkout form.');
    }

    // Fetch cart items
    $cart_items = [];
    try {
        $cart_items = $cartModel->where('customer_id', $user_id)->findAll();
        log_message('debug', 'Cart items fetched for placeOrder: ' . json_encode($cart_items));
    } catch (\Exception $e) {
        log_message('error', 'Error fetching cart items: ' . $e->getMessage());
        return redirect()->to('checkout')->with('error', 'Unable to fetch cart data. Please try again later.');
    }

    if (empty($cart_items)) {
        log_message('error', 'Cart is empty during placeOrder for user_id: ' . $user_id);
        return redirect()->to('cart')->with('error', 'Your cart is empty. Add items to place an order.');
    }

    // Group cart items by shop and calculate totals
    $grouped_cart_items = [];
    $grand_total = 0;
    $seen_product_ids = [];

    foreach ($cart_items as $item) {
        log_message('debug', 'Processing cart item: ' . json_encode($item));

        if (in_array($item['product_id'], $seen_product_ids)) {
            log_message('warning', 'Duplicate product_id found in cart: ' . $item['product_id']);
            continue;
        }
        $seen_product_ids[] = $item['product_id'];

        try {
            $product = $productModel->find($item['product_id']);
            if (!$product) {
                log_message('error', 'Product not found for product_id: ' . $item['product_id']);
                continue;
            }
            log_message('debug', 'Product found: ' . json_encode($product));

            $shop = $shopModel->find($product['shop_id']);
            if (!$shop) {
                log_message('error', 'Shop not found for shop_id: ' . $product['shop_id']);
                continue;
            }
            log_message('debug', 'Shop found: ' . json_encode($shop));

            $item['price'] = $product['price'];
            $item['subtotal'] = $product['price'] * $item['quantity'];
            $item['shop_id'] = $product['shop_id'];

            if (!isset($grouped_cart_items[$product['shop_id']])) {
                $grouped_cart_items[$product['shop_id']] = [
                    'items' => [],
                    'subtotal' => 0
                ];
            }

            $grouped_cart_items[$product['shop_id']]['items'][] = $item;
            $grouped_cart_items[$product['shop_id']]['subtotal'] += $item['subtotal'];
            $grand_total += $item['subtotal'];
        } catch (\Exception $e) {
            log_message('error', 'Error processing cart item for product_id: ' . $item['product_id'] . ' - ' . $e->getMessage());
            continue;
        }
    }

    log_message('debug', 'Grouped cart items: ' . json_encode($grouped_cart_items));
    log_message('debug', 'Grand total: ' . $grand_total);

    if (empty($grouped_cart_items)) {
        log_message('error', 'No valid cart items to process for order for user_id: ' . $user_id);
        return redirect()->to('cart')->with('error', 'No valid items in your cart to place an order.');
    }

    // Start a database transaction
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        // Create the main order
        $order_data = [
            'customer_id' => $user_id,
            'total_amount' => $grand_total,
            'status' => 'pending',
            'condition' => 'unseen'
            // order_date omitted to rely on beforeInsert callback
        ];
        log_message('debug', 'Order data before insert: ' . json_encode($order_data));
        $orderModel->insert($order_data);
        $order_id = $orderModel->insertID();
        $inserted_order = $orderModel->find($order_id);
        log_message('debug', 'Main order created with order_id: ' . $order_id . ', order_date: ' . ($inserted_order['order_date'] ?? 'Not set') . ', Raw DB value: ' . var_export($inserted_order, true));

        if (!$order_id) {
            throw new \Exception('Failed to create order');
        }

        // Create suborders for each shop
        foreach ($grouped_cart_items as $shop_id => $shop_data) {
            $suborder_data = [
                'order_id' => $order_id,
                'shop_id' => $shop_id,
                'subtotal' => $shop_data['subtotal'],
                'status' => 'pending',
                'condition' => 'unseen'
            ];
            $suborderModel->insert($suborder_data);
            $suborder_id = $suborderModel->insertID();
            log_message('debug', 'Suborder created with suborder_id: ' . $suborder_id . ' for shop_id: ' . $shop_id);

            if (!$suborder_id) {
                throw new \Exception('Failed to create suborder for shop_id: ' . $shop_id);
            }

            // Add items to suborder_items
            foreach ($shop_data['items'] as $item) {
                $suborder_item_data = [
                    'suborder_id' => $suborder_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
                $result = $suborderItemModel->insert($suborder_item_data);
                if (!$result) {
                    log_message('error', 'Failed to insert suborder item for suborder_id: ' . $suborder_id . ' and product_id: ' . $item['product_id']);
                    throw new \Exception('Failed to add item to suborder');
                }
                log_message('debug', 'Suborder item added for product_id: ' . $item['product_id'] . ' under suborder_id: ' . $suborder_id);
            }
        }

        // Clear the cart
        $cartModel->where('customer_id', $user_id)->delete();
        log_message('debug', 'Cart cleared for customer_id: ' . $user_id);

        // Complete the transaction
        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Transaction failed during order placement');
            throw new \Exception('Transaction failed. Please try again.');
        }
    } catch (\Exception $e) {
        $db->transRollback();
        log_message('error', 'Error placing order: ' . $e->getMessage());
        return redirect()->to('checkout')->with('error', 'Unable to place your order. Please try again later. Error: ' . $e->getMessage());
    }

    // Redirect to order-completed page with the order_id
    log_message('debug', 'Redirecting to order-completed with order_id: ' . $order_id);
    return redirect()->to('order-completed?order_id=' . $order_id)->with('success', 'Your order has been placed successfully!');
}
}