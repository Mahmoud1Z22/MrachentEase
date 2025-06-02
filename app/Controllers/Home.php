<?php

namespace App\Controllers;

use App\Models\Products_model;
use App\Models\Shops_model;
use App\Models\Product_images_model;
use App\Models\Category_model;
use App\Models\Subcategory;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel = new Products_model();
        $shopModel = new Shops_model();
        $imageModel = new Product_images_model();
        $categoryModel = new Category_model();
        $subcategoryModel = new Subcategory();

        // Fetch all products with their shop names (no limit, as per previous request)
        $products = $productModel
            ->select('products.*, shops.shop_name')
            ->join('shops', 'shops.shop_id = products.shop_id')
            ->orderBy('product_id', 'DESC')
            ->findAll(); // No limit, fetch all products

        // Attach the correct image or fallback for products
        foreach ($products as &$product) {
            $imageData = $imageModel->where('product_id', $product['product_id'])->first();

            if ($imageData) {
                log_message('debug', 'Image data for product_id ' . $product['product_id'] . ' (' . $product['product_name'] . '): ' . json_encode($imageData));
            } else {
                log_message('debug', 'No image data found for product_id ' . $product['product_id'] . ' (' . $product['product_name'] . ')');
            }

            $imagePath = null;
            if (!empty($imageData)) {
                $possibleImages = [$imageData['image'], $imageData['image2'] ?? null, $imageData['image3'] ?? null, $imageData['image4'] ?? null];
                foreach ($possibleImages as $img) {
                    if (!empty($img)) {
                        $imagePath = $img;
                        break;
                    }
                }
            }

            if ($imagePath) {
                $dbImagePath = ltrim($imagePath, '/');
                $adjustedImagePath = 'assets/uploads/products/' . basename($dbImagePath);
                $fullPath = FCPATH . $adjustedImagePath;

                if (file_exists($fullPath)) {
                    $product['image'] = $adjustedImagePath;
                    log_message('debug', 'Image found for product_id ' . $product['product_id'] . ' (' . $product['product_name'] . '): ' . $fullPath);
                } else {
                    $product['image'] = 'assets/images/default_product.jpg';
                    log_message('debug', 'Image file does not exist for product_id ' . $product['product_id'] . ' (' . $product['product_name'] . '): ' . $fullPath);
                }
            } else {
                $product['image'] = 'assets/images/default_product.jpg';
                log_message('debug', 'No images available for product_id ' . $product['product_id'] . ' (' . $product['product_name'] . '), using fallback');
            }
        }

        // Fetch all shops (no limit)
        $shops = $shopModel
            ->orderBy('shop_id', 'DESC')
            ->findAll(); // No limit, fetch all shops

        // Attach the correct image or fallback for shops
        foreach ($shops as &$shop) {
            log_message('debug', 'Shop ID ' . $shop['shop_id'] . ' (' . $shop['shop_name'] . ') fetched.');

            $imagePath = $shop['shop_icon'] ?? null;

            if ($imagePath) {
                $adjustedImagePath = 'assets/uploads/shops/' . $imagePath;
                $fullPath = FCPATH . $adjustedImagePath;

                log_message('debug', 'Checking image path for shop_id ' . $shop['shop_id'] . ': Raw path = ' . $imagePath . ', Adjusted path = ' . $adjustedImagePath . ', Full path = ' . $fullPath);

                if (file_exists($fullPath)) {
                    $shop['image'] = $adjustedImagePath;
                    log_message('debug', 'Image found for shop_id ' . $shop['shop_id'] . ' (' . $shop['shop_name'] . '): ' . $fullPath);
                } else {
                    $shop['image'] = 'assets/images/default_shop.jpg';
                    log_message('debug', 'Image file does not exist for shop_id ' . $shop['shop_id'] . ' (' . $shop['shop_name'] . '): ' . $fullPath);
                }
            } else {
                $shop['image'] = 'assets/images/default_shop.jpg';
                log_message('debug', 'No image available for shop_id ' . $shop['shop_id'] . ' (' . $shop['shop_name'] . '), using fallback');
            }
        }

        // Fetch all categories and subcategories for the sidebar
        $categoriesData = $categoryModel->findAll();
        if (empty($categoriesData)) {
            log_message('error', 'No categories found in the database');
        }

        $subcategoriesData = $subcategoryModel->findAll();
        if (empty($subcategoriesData)) {
            log_message('error', 'No subcategories found in the database');
        }

        $categories = [];
        foreach ($categoriesData as $category) {
            $categoryProductCount = $productModel->where('category_id', $category['category_id'])->countAllResults();
            $categories[$category['category_id']] = [
                'name' => $category['category_name'],
                'subcategories' => [],
                'product_count' => $categoryProductCount
            ];
        }

        foreach ($subcategoriesData as $subcategory) {
            if (isset($categories[$subcategory['category_id']])) {
                $subcategoryProductCount = $productModel->where('subcategory_id', $subcategory['subcategory_id'])->countAllResults();

                $sanitizedSubcategoryName = strtolower(preg_replace('/[^a-z0-9\-]/', '-', $subcategory['subcategory_name']));
                $sanitizedSubcategoryName = preg_replace('/-+/', '-', $sanitizedSubcategoryName);
                $sanitizedSubcategoryName = trim($sanitizedSubcategoryName, '-');

                $categories[$subcategory['category_id']]['subcategories'][] = [
                    'name' => $subcategory['subcategory_name'],
                    'url' => site_url('products-list/subcategory-products/' . $subcategory['category_id'] . '/' . $sanitizedSubcategoryName),
                    'product_count' => $subcategoryProductCount
                ];
            }
        }

        $data = [
            'products' => $products,
            'shops' => $shops,
            'categories' => $categories,
            'selected_subcategory' => null
        ];

        return view('home', $data);
    }

    public function search()
    {
        $term = $this->request->getGet('term');
        $productModel = new Products_model();

        $results = [];

        if ($term) {
            $results = $productModel
                ->select('product_id as id, product_name as name')
                ->like('product_name', $term)
                ->findAll(5); // Limit to 5 suggestions
        }

        return $this->response->setJSON($results);
    }
}
                