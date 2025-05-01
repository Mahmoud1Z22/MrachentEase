<?php

namespace App\Controllers;

use App\Models\Cart_model;
use App\Models\Products_model;
use App\Models\Shops_model;
use App\Models\Product_images_model;

class Cart extends BaseController
{
    public function index()
    {
        $cartModel = new Cart_model();
        $productModel = new Products_model();
        $imageModel = new Product_images_model();
    
        // Get user_id from session
        $user_id = session()->get('user_id');
        $logged_in = session()->get('logged_in');
    
        // Check if user is logged in
        if (!$logged_in || !$user_id) {
            return redirect()->to('login')->with('error', 'Please log in to view your cart.');
        }
    
        // Fetch cart items for the customer
        $cart_items = [];
        try {
            $cart_items = $cartModel->where('customer_id', $user_id)->findAll();
            log_message('debug', 'Cart items fetched: ' . json_encode($cart_items));
        } catch (\Exception $e) {
            log_message('error', 'Error fetching cart items: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'Unable to fetch cart data. Please try again later.');
        }
    
       // Fetch product data and images for each cart item
        $cart_with_products = [];
        $grand_total = 0;
        foreach ($cart_items as $item) {
            try {
                $product = $productModel->find($item['product_id']);
                if (!$product) {
                    log_message('error', 'Product not found for product_id: ' . $item['product_id']);
                    continue; // Skip if product not found
                }

                $images = $imageModel->where('product_id', $item['product_id'])->first();

                // Combine cart item with product and image data
                $item['product_name'] = $product['product_name'];
                $item['price'] = $product['price'];
                $item['subtotal'] = $product['price'] * $item['quantity'];
                $item['image'] = $images && !empty($images['image']) ? $images['image'] : 'images/default_product.jpg';

                $cart_with_products[] = $item;
                $grand_total += $item['subtotal'];
            } catch (\Exception $e) {
                log_message('error', 'Error fetching product for product_id: ' . $item['product_id'] . ' - ' . $e->getMessage());
                continue;
            }
        }
    
        $data = [
            'cart_items' => $cart_with_products,
            'grand_total' => $grand_total
        ];
    
      return view('cart', $data);
    }

    public function add($product_id){
        $cartModel = new Cart_model();
        $productModel = new Products_model();

        // Get user_id and role from session
        $user_id = session()->get('user_id');
        $role = session()->get('user_type');
        $logged_in = session()->get('logged_in');

        // Check if user is logged in
        if (!$logged_in || !$user_id) {
            return redirect()->to('login')->with('error', 'Please log in to add items to your cart.');
        }

        // Check if user is a customer (not a merchant)
        if ($role !== 'customer') {
            if ($role === 'merchant') {
                return redirect()->to('marchent_account')->with('error', 'Merchants cannot add items to the customer cart.');
            }
            return redirect()->to('login')->with('error', 'Invalid user type.');
        }

        // Validate product exists
        try {
            $product = $productModel->find($product_id);
            if (!$product) {
                log_message('error', 'Product not found for product_id: ' . $product_id);
                return redirect()->back()->with('error', 'Product not found.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error fetching product for product_id: ' . $product_id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to add product to cart. Please try again later.');
        }

        // Check if the product is already in the cart
        try {
            $cart_item = $cartModel
                ->where('customer_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($cart_item) {
                // If item exists, increment the quantity
                $new_quantity = $cart_item['quantity'] + 1;
                $cartModel->update($cart_item['id'], ['quantity' => $new_quantity]);
                log_message('debug', 'Updated cart item quantity for product_id: ' . $product_id . ' to ' . $new_quantity);
            } else {
                // If item doesn't exist, add it to the cart
                $cart_data = [
                    'customer_id' => $user_id,
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'added_at' => date('Y-m-d H:i:s')
                ];
                $cartModel->insert($cart_data);
                log_message('debug', 'Added new cart item for product_id: ' . $product_id);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding/updating cart item for product_id: ' . $product_id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to add product to cart. Please try again later.');
        }

        return redirect()->to('cart')->with('success', 'Product added to cart successfully!');    
    }

    public function add_del($product_id)
{
    $cartModel = new Cart_model();
    $productModel = new Products_model();

    // Get user_id and role from session
    $user_id = session()->get('user_id');
    $role = session()->get('user_type');
    $logged_in = session()->get('logged_in');

    // Check if user is logged in
    if (!$logged_in || !$user_id) {
        return redirect()->to('login')->with('error', 'Please log in to add items to your cart.');
    }

    // Check if user is a customer (not a merchant)
    if ($role !== 'customer') {
        if ($role === 'merchant') {
            return redirect()->to('marchent_account')->with('error', 'Merchants cannot add items to the customer cart.');
        }
        return redirect()->to('login')->with('error', 'Invalid user type.');
    }

    // Validate product exists
    try {
        $product = $productModel->find($product_id);
        if (!$product) {
            log_message('error', 'Product not found for product_id: ' . $product_id);
            return redirect()->back()->with('error', 'Product not found.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error fetching product for product_id: ' . $product_id . ' - ' . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to add product to cart. Please try again later.');
    }

    // Get quantity from form
    $quantity = (int)$this->request->getPost('quantity');
    if ($quantity <= 0) {
        log_message('error', 'Invalid quantity provided: ' . $quantity);
        return redirect()->back()->with('error', 'Please enter a valid quantity.');
    }

    // Check if the product is already in the cart
    try {
        $cart_item = $cartModel
            ->where('customer_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($cart_item) {
            // If item exists, add the new quantity to the existing quantity
            $new_quantity = $cart_item['quantity'] + $quantity;
            $cartModel->update($cart_item['id'], ['quantity' => $new_quantity]);
            log_message('debug', 'Updated cart item quantity for product_id: ' . $product_id . ' to ' . $new_quantity);
        } else {
            // If item doesn't exist, add it to the cart with the specified quantity
            $cart_data = [
                'customer_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'added_at' => date('Y-m-d H:i:s')
            ];
            $cartModel->insert($cart_data);
            log_message('debug', 'Added new cart item for product_id: ' . $product_id . ' with quantity: ' . $quantity);
        }
    } catch (\Exception $e) {
        log_message('error', 'Error adding/updating cart item for product_id: ' . $product_id . ' - ' . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to add product to cart. Please try again later.');
    }

    // Redirect to the cart view on success
    return redirect()->to('cart')->with('success', 'Product added to cart successfully!');
}

public function remove($cart_id)
{
    $cartModel = new Cart_model();

    // Get user_id and role from session
    $user_id = session()->get('user_id');
    $role = session()->get('user_type');
    $logged_in = session()->get('logged_in');

    // Log the cart_id and user_id for debugging
    log_message('debug', 'Attempting to remove cart item with cart_id: ' . $cart_id . ' for user_id: ' . $user_id);

    // Check if user is logged in
    if (!$logged_in || !$user_id) {
        return redirect()->to('login')->with('error', 'Please log in to remove items from your cart.');
    }

    // Check if user is a customer (not a merchant)
    if ($role !== 'customer') {
        if ($role === 'merchant') {
            return redirect()->to('marchent_account')->with('error', 'Merchants cannot access the customer cart.');
        }
        return redirect()->to('login')->with('error', 'Invalid user type.');
    }

    // Ensure the cart item belongs to the customer
    try {
        $cart_item = $cartModel
            ->where('cart_id', $cart_id) // Changed 'id' to 'cart_id' to match the model's primary key
            ->where('customer_id', $user_id)
            ->first();

        if ($cart_item) {
            $cartModel->delete($cart_id); // This uses the primary key (cart_id) automatically
            log_message('debug', 'Removed cart item with cart_id: ' . $cart_id . ' for customer_id: ' . $user_id);
            return redirect()->to('cart')->with('success', 'Item removed from cart successfully.');
        } else {
            log_message('error', 'Cart item not found or does not belong to customer. Cart ID: ' . $cart_id . ', Customer ID: ' . $user_id);
            return redirect()->to('cart')->with('error', 'Item not found in your cart.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error removing cart item with cart_id: ' . $cart_id . ' - ' . $e->getMessage());
        return redirect()->to('cart')->with('error', 'Unable to remove item from cart. Please try again later.');
    }
}

public function update()
{
    // Step 1: Initialize Cart Model and Get User Info from Session
    $cartModel = new Cart_model();
    $user_id = session()->get('user_id');
    $role = session()->get('user_type');
    $logged_in = session()->get('logged_in');

    log_message('error', 'User ID: ' . $user_id . ' | Role: ' . $role . ' | Logged in: ' . ($logged_in ? 'Yes' : 'No'));

    // Step 2: Check if user is logged in
    if (!$logged_in || !$user_id) {
        return redirect()->to('login')->with('error', 'Please log in to update your cart.');
    }

    // Step 3: Ensure only customers can access this page
    if ($role !== 'customer') {
        return redirect()->to($role === 'merchant' ? 'marchent_account' : 'login')
            ->with('error', 'Access denied.');
    }

    // Step 4: Get posted quantities from the form
    $quantities = $this->request->getPost('quantity');
    $update_items = $this->request->getPost('update'); // This should contain cart_id's to update

    log_message('error', 'Quantities from form: ' . print_r($quantities, true));

    if (empty($quantities) || !is_array($quantities)) {
        return redirect()->to('cart')->with('error', 'No items to update.');
    }

    $updated_items = 0;

    // Step 5: Iterate over the quantities and update the cart items
    foreach ($quantities as $cart_id => $quantity) {
        $quantity = (int)$quantity;

        // Debug: Check if we are getting the correct cart item
        log_message('error', 'Processing cart ID: ' . $cart_id . ' with quantity: ' . $quantity);

        // Find the cart item for the current cart_id and user_id
        $cart_item = $cartModel
            ->where('cart_id', $cart_id)
            ->where('customer_id', $user_id)
            ->first();

        // Debug: Check if cart item was found
        if (!$cart_item) {
            log_message('error', 'Cart item not found for cart ID: ' . $cart_id . ' | User ID: ' . $user_id);
            continue; // Skip this iteration if cart item is not found
        }

        // Step 6: Update or remove the cart item based on the quantity
        if ($quantity <= 0) {
            // If quantity is 0 or less, remove the item
            $cartModel->delete($cart_id);
            log_message('error', 'Removed cart item with cart_id: ' . $cart_id);
        } else {
            // Update the quantity
            $cartModel->update($cart_id, [
                'quantity' => $quantity
            ]);
            log_message('error', 'Updated cart item with cart_id: ' . $cart_id . ' to quantity: ' . $quantity);
        }

        $updated_items++;
    }

    if ($updated_items === 0) {
        return redirect()->to('cart')->with('error', 'No changes were made to the cart.');
    }

    return redirect()->to('cart')->with('success', 'Cart updated successfully!');
}

    
}


    