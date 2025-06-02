<?php

namespace App\Models;

use CodeIgniter\Model;

class Wishlist_model extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'wishlist_id';
    protected $allowedFields = ['customer_id', 'product_id', 'added_at'];

    // Specify the return type as an array
    protected $returnType = 'array';

    // Automatically manage timestamps
    protected $useTimestamps = true;
    protected $createdField = 'added_at';
    protected $updatedField = ''; // No updates expected for wishlist entries

    // Validation rules
    protected $validationRules = [
        'customer_id' => 'required|integer',
        'product_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'The customer ID is required.',
            'integer' => 'The customer ID must be an integer.'
        ],
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer.'
        ]
    ];

    // Method to get a customer's wishlist with product details
    public function getCustomerWishlist($customer_id)
    {
        return $this->select('wishlist.*, products.product_name, products.price, products.shop_id, shops.shop_name')
            ->join('products', 'products.product_id = wishlist.product_id', 'left')
            ->join('shops', 'shops.shop_id = products.shop_id', 'left')
            ->where('wishlist.customer_id', $customer_id)
            ->findAll();
    }

    // Method to check if a product is already in a customer's wishlist
    public function isProductInWishlist($customer_id, $product_id)
    {
        return $this->where('customer_id', $customer_id)
                    ->where('product_id', $product_id)
                    ->first() !== null;
    }

    // Method to remove a product from a customer's wishlist
    public function removeFromWishlist($customer_id, $product_id)
    {
        return $this->where('customer_id', $customer_id)
                    ->where('product_id', $product_id)
                    ->delete();
    }
}