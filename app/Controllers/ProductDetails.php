<?php

namespace App\Controllers;

use App\Models\Products_model;
use App\Models\Shops_model;
use App\Models\Product_images_model;
use App\Models\Category_model;
use App\Models\Brands_model;

class ProductDetails extends BaseController
{
    public function index($product_id = null)
    {
        // Load models
        $productModel = new Products_model();
        $shopModel = new Shops_model();
        $imageModel = new Product_images_model();
        $categoryModel = new Category_model();
        $brandModel = new Brands_model();

        // If no product_id is provided, throw a 404 error
        if (!$product_id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No product selected.');
        }

        // Fetch the product with its shop name
        $product = $productModel
            ->select('products.*, shops.shop_name')
            ->join('shops', 'shops.shop_id = products.shop_id') // Fix join condition
            ->where('products.product_id', $product_id)
            ->first();

        // If product not found, redirect or show an error
        if (!$product) {
            return redirect()->to('/')->with('error', 'Product not found.');
        }

        // Fetch images for the product
        $images = $imageModel->where('product_id', $product_id)->first();
        $product['images'] = $images ? [
            'image' => $images['image'],
            'image2' => $images['image2'],
            'image3' => $images['image3'],
            'image4' => $images['image4']
        ] : [
            'image' => 'images/default_product.jpg',
            'image2' => 'images/default_product.jpg',
            'image3' => 'images/default_product.jpg',
            'image4' => 'images/default_product.jpg'
        ];

        // Fetch category and brand names
        $category = $categoryModel->find($product['category_id']);
        $brand = $brandModel->find($product['brand_id']);
        $product['category_name'] = $category ? $category['category_name'] : 'Unknown';
        $product['brand_name'] = $brand ? $brand['brand_name'] : 'Unknown';

        // Prepare data for the view
        $data = [
            'product' => $product
        ];
      
        return view('product_details', $data);
    }
    
}