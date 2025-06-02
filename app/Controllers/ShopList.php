<?php

namespace App\Controllers;

use App\Models\Shops_model;
use App\Models\Products_model;
use App\Models\Product_images_model;

class ShopList extends BaseController
{
    public function index(): string
    {
        $shopModel = new Shops_model();
        $productModel = new Products_model();
        $imageModel = new Product_images_model();

        // Get shop_id from the URL
        $uri = $this->request->getUri();
        $shop_id = $this->request->getGet('id') ?? $uri->getSegment(2);

        $shop = null;
        $products = [];

        if ($shop_id && is_numeric($shop_id)) {
            $shop_id = (int)$shop_id;
            // Fetch the shop details
            $shop = $shopModel->find($shop_id);

            if ($shop) {
                // Fetch products for the specific shop
                $products = $productModel
                    ->where('shop_id', $shop_id)
                    ->findAll();

                // Fetch images for each product using Product_images_model
                foreach ($products as &$product) {
                    $imageData = $imageModel->where('product_id', $product['product_id'])->first();

                    $imagePath = null;
                    if (!empty($imageData)) {
                        // Prioritize image, image2, image3, image4
                        $possibleImages = [
                            $imageData['image'] ?? null,
                            $imageData['image2'] ?? null,
                            $imageData['image3'] ?? null,
                            $imageData['image4'] ?? null
                        ];
                        foreach ($possibleImages as $img) {
                            if (!empty($img)) {
                                $imagePath = $img;
                                break;
                            }
                        }
                    }

                    // Set the product_image with a fallback
                    $product['product_image'] = $imagePath ?? 'assets/images/default_product.jpg';
                }
            } else {
                log_message('error', 'Shop not found for shop_id: ' . $shop_id);
            }
        } else {
            log_message('error', 'Invalid or missing shop_id: ' . ($shop_id ?? 'null'));
        }

        $data = [
            'shop' => $shop,
            'products' => $products
        ];

        return view('shop_list', $data);
    }
}