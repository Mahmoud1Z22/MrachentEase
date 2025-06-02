<?php

namespace App\Controllers;

use App\Models\Products_model;
use App\Models\Shops_model;
use App\Models\Product_images_model;
use App\Models\Category_model;
use App\Models\Subcategory;
use App\Models\Brands_model;

class ProductsList extends BaseController
{
    public function index(): string
    {
        $productModel = new Products_model();
        $shopModel = new Shops_model();
        $imageModel = new Product_images_model();
        $categoryModel = new Category_model();
        $subcategoryModel = new Subcategory();

        // Get search term from query parameter
        $term = $this->request->getGet('term') ?? '';

        // Fetch products with search filter
        $products = $productModel
            ->select('products.*, shops.shop_name')
            ->join('shops', 'shops.shop_id = products.shop_id', 'left');

        if ($term) {
            $products = $productModel
                ->groupStart()
                ->like('product_name', $term)
                ->orLike('product_description', $term)
                ->groupEnd();
        }

        $products = $productModel
            ->orderBy('product_id', 'DESC')
            ->findAll();

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

        // Fetch the latest 8 shops
        $shops = $shopModel
            ->orderBy('shop_id', 'DESC')
            ->findAll(8);

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

        // Fetch all categories and subcategories
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
            'products' => array_slice($products, 0, 8), // Limit to latest 8 products for display
            'shops' => $shops,
            'categories' => $categories,
            'selected_subcategory' => null,
            'searchTerm' => $term // Pass search term to the view
        ];

        return view('products_list', $data);
    }

    public function subcategoryProducts($category_id = null, $subcategory_name = null): string
{
    $productModel = new Products_model();
    $shopModel = new Shops_model();
    $imageModel = new Product_images_model();
    $categoryModel = new Category_model();
    $subcategoryModel = new Subcategory();

    // Debug incoming parameters
    log_message('debug', 'subcategoryProducts called with category_id: ' . ($category_id ?? 'null') . ', subcategory_name: ' . ($subcategory_name ?? 'null'));

    // Validate parameters
    if ($category_id === null || $subcategory_name === null) {
        log_message('error', 'Missing parameters in subcategoryProducts: category_id = ' . ($category_id ?? 'null') . ', subcategory_name = ' . ($subcategory_name ?? 'null'));
        return view('errors/html/error_404', ['message' => 'Invalid category or subcategory']);
    }

    // Fetch all subcategories for the given category_id to find a match
    $subcategories = $subcategoryModel
        ->where('category_id', $category_id)
        ->findAll();

    $selectedSubcategory = null;
    foreach ($subcategories as $subcat) {
        $sanitizedSubcatName = strtolower(preg_replace('/[^a-z0-9\-]/', '-', $subcat['subcategory_name']));
        $sanitizedSubcatName = preg_replace('/-+/', '-', $sanitizedSubcatName);
        $sanitizedSubcatName = trim($sanitizedSubcatName, '-');

        if ($sanitizedSubcatName === $subcategory_name) {
            $selectedSubcategory = $subcat;
            break;
        }
    }

    if (!$selectedSubcategory) {
        log_message('error', 'Subcategory not found for category_id: ' . $category_id . ', sanitized subcategory_name: ' . $subcategory_name);
        return view('errors/html/error_404', ['message' => 'Subcategory not found']);
    }

    // Fetch products under the specific subcategory_id
    $products = $productModel
        ->select('products.*, shops.shop_name')
        ->join('shops', 'shops.shop_id = products.shop_id', 'left')
        ->where('products.category_id', $category_id)
        ->where('products.subcategory_id', $selectedSubcategory['subcategory_id'])
        ->orderBy('product_id', 'DESC')
        ->findAll();

    log_message('debug', 'Fetched ' . count($products) . ' products for category_id: ' . $category_id . ', subcategory_id: ' . $selectedSubcategory['subcategory_id']);

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

    // Fetch the latest 8 shops
    $shops = $shopModel
        ->orderBy('shop_id', 'DESC')
        ->findAll(8);

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
        'selected_subcategory' => $selectedSubcategory
    ];

    return view('products_list_sub', $data);
}

    public function search($category_id = null, $subcategory_name = null): string
{
    $productModel = new Products_model();
    $shopModel = new Shops_model();
    $imageModel = new Product_images_model();
    $categoryModel = new Category_model();
    $subcategoryModel = new Subcategory();

    // Debug incoming parameters
    log_message('debug', 'subcategoryProducts called with category_id: ' . ($category_id ?? 'null') . ', subcategory_name: ' . ($subcategory_name ?? 'null'));

    // Validate parameters
    if ($category_id === null || $subcategory_name === null) {
        log_message('error', 'Missing parameters in subcategoryProducts: category_id = ' . ($category_id ?? 'null') . ', subcategory_name = ' . ($subcategory_name ?? 'null'));
        return view('errors/html/error_404', ['message' => 'Invalid category or subcategory']);
    }

    // Fetch all subcategories for the given category_id to find a match
    $subcategories = $subcategoryModel
        ->where('category_id', $category_id)
        ->findAll();

    $selectedSubcategory = null;
    foreach ($subcategories as $subcat) {
        $sanitizedSubcatName = strtolower(preg_replace('/[^a-z0-9\-]/', '-', $subcat['subcategory_name']));
        $sanitizedSubcatName = preg_replace('/-+/', '-', $sanitizedSubcatName);
        $sanitizedSubcatName = trim($sanitizedSubcatName, '-');

        if ($sanitizedSubcatName === $subcategory_name) {
            $selectedSubcategory = $subcat;
            break;
        }
    }

    if (!$selectedSubcategory) {
        log_message('error', 'Subcategory not found for category_id: ' . $category_id . ', sanitized subcategory_name: ' . $subcategory_name);
        return view('errors/html/error_404', ['message' => 'Subcategory not found']);
    }

    // Fetch products under the specific subcategory_id
    $products = $productModel
        ->select('products.*, shops.shop_name')
        ->join('shops', 'shops.shop_id = products.shop_id', 'left')
        ->where('products.category_id', $category_id)
        ->where('products.subcategory_id', $selectedSubcategory['subcategory_id'])
        ->orderBy('product_id', 'DESC')
        ->findAll();

    log_message('debug', 'Fetched ' . count($products) . ' products for category_id: ' . $category_id . ', subcategory_id: ' . $selectedSubcategory['subcategory_id']);

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

    // Fetch the latest 8 shops
    $shops = $shopModel
        ->orderBy('shop_id', 'DESC')
        ->findAll(8);

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
        'selected_subcategory' => $selectedSubcategory
    ];

    return view('products_list_sub', $data);
}


}