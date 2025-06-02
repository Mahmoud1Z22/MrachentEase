<?php

namespace App\Controllers;

use App\Models\Wishlist_model;
use App\Models\Products_model;
use App\Models\Product_images_model;

class Wishlist extends BaseController
{
    public function view()
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Please log in as a customer to view your wishlist.');
        }

        $customerId = session()->get('user_id');
        $wishlistModel = new Wishlist_model();
        $imageModel = new Product_images_model();

        // Fetch wishlist items with product and shop details
        $wishlistItems = $wishlistModel->select('wishlist.*, products.product_name, products.price, products.stock_status, products.shop_id, shops.shop_name')
            ->join('products', 'products.product_id = wishlist.product_id', 'left')
            ->join('shops', 'shops.shop_id = products.shop_id', 'left')
            ->where('wishlist.customer_id', $customerId)
            ->findAll();

        // Attach the main image to each wishlist item
        foreach ($wishlistItems as &$item) {
            $imageData = $imageModel->where('product_id', $item['product_id'])->first();
            $imagePath = null;
            if (!empty($imageData)) {
                $possibleImages = [$imageData['image'], $imageData['image2'] ?? null, $imageData['image3'] ?? null, $imageData['image4'] ?? null];
                foreach ($possibleImages as $img) {
                    if (!empty($img)) {
                        // Adjust the path to match the file system (e.g., assets/uploads/products/...)
                        $dbImagePath = ltrim($img, '/'); // Remove leading '/'
                        $imagePath = 'assets/uploads/products/' . basename($dbImagePath);
                        break;
                    }
                }
            }
            $item['image'] = $imagePath ?: 'assets/images/default_product.jpg';
        }

        $data = [
            'wishlist' => $wishlistItems
        ];

        return view('wishlist', $data);
    }

    public function add($product_id)
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Please log in as a customer to add to wishlist.');
        }

        $customerId = session()->get('user_id');
        $wishlistModel = new Wishlist_model();
        $productModel = new Products_model();

        // Verify the product exists
        $product = $productModel->find($product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Check if the product is already in the wishlist
        if ($wishlistModel->isProductInWishlist($customerId, $product_id)) {
            return redirect()->back()->with('info', 'Product is already in your wishlist.');
        }

        // Add to wishlist
        $wishlistData = [
            'customer_id' => $customerId,
            'product_id' => $product_id
        ];

        if ($wishlistModel->insert($wishlistData)) {
            return redirect()->to('/wishlist/view')->with('success', 'Product added to wishlist successfully!');
        } else {
            return redirect()->to('/wishlist/view')->with('error', 'Failed to add product to wishlist.');
        }
    }

    public function remove($product_id)
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Please log in as a customer to remove from wishlist.');
        }

        $customerId = session()->get('user_id');
        $wishlistModel = new Wishlist_model();

        if ($wishlistModel->removeFromWishlist($customerId, $product_id)) {
            return redirect()->to('/wishlist/view')->with('success', 'Product removed from wishlist successfully!');
        } else {
            return redirect()->to('/wishlist/view')->with('error', 'Failed to remove product from wishlist.');
        }
    }
}