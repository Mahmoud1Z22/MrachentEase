<?php

namespace App\Controllers;

use App\Models\Products_model;
use App\Models\Shops_model;
use App\Models\Product_images_model;
use App\Models\Categories_model;
use App\Models\Brands_model;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel = new Products_model();
        $shopModel = new Shops_model();
        $imageModel = new Product_images_model();

        // Fetch all products with their shop names
        $products = $productModel
            ->select('products.*, shops.shop_name')
            ->join('shops', 'shops.shop_id = products.shop_id')
            ->findAll();

        // Attach the correct image or fallback
        foreach ($products as &$product) {
            $imageData = $imageModel->where('product_id', $product['product_id'])->first();

            // Debug: Log the image data
            if ($imageData) {
                log_message('debug', 'Image data for product_id ' . $product['product_id'] . ': ' . json_encode($imageData));
            } else {
                log_message('debug', 'No image data found for product_id ' . $product['product_id']);
            }

            // The image field contains the full path (e.g., /uploads/products/1744557484_ad29466926438cd7fb3d)
            // Remove the leading '/' and adjust the path for file_exists
            if (!empty($imageData['image'])) {
                // Remove leading '/' and prepend the correct base path
                $imagePath = ltrim($imageData['image'], '/'); // e.g., uploads/products/1744557484_ad29466926438cd7fb3d
                $fullPath = FCPATH . $imagePath; // e.g., public/uploads/products/1744557484_ad29466926438cd7fb3d

                if (file_exists($fullPath)) {
                    $product['image'] = $imagePath; // Store the relative path for the view
                } else {
                    $product['image'] = 'images/default_product.jpg'; // Fallback image
                    log_message('debug', 'Image file does not exist: ' . $fullPath);
                }
            } else {
                $product['image'] = 'uploads/products/no-image-icon-6.png'; // Fallback image
            }
        }

        $data = [
            'products' => $products
        ];

        return view('home', $data);
    }
}
