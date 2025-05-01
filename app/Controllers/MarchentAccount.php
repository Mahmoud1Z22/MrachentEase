<?php

namespace App\Controllers;
use App\Models\Users_model;
use App\Models\Shops_model;
use App\Models\Category_model;
use App\Models\Products_model;
use App\Models\product_images_model;
use App\Models\Brands_model;


class MarchentAccount extends BaseController
{
    public function index(): \CodeIgniter\HTTP\ResponseInterface
    {
        // Check if user is logged in and is a merchant
        if (!session()->get('logged_in') || session()->get('user_type') !== 'merchant') {
            return redirect()->to('/login')->with('error', 'Please log in as a merchant.');
        }

        // Get user ID
        $userId = session()->get('user_id');

        // Load models
        $userModel = new Users_model();
        $shopModel = new Shops_model();
        $categoryModel = new Category_model();
        $brandModel = new Brands_model();
        $productModel = new Products_model();

        // Fetch user data
        $user = $userModel->find($userId);
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        // Fetch merchant's shop
        $shop = $shopModel->where('marchent_id', $userId)->first();
        if (!$shop) {
            return redirect()->to('/marchent_account')->with('error', 'No shop found. Please set up your shop.');
        }

        // Fetch data
        $categories = $categoryModel->findAll();
        $brands = $brandModel->findAll();
        $products = $productModel->where('shop_id', $shop['shop_id'])->findAll();

        // Prepare data for view
        $data = [
            'user' => $user,
            'shop' => $shop,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ];

        return $this->response->setBody(view('marchent_account', $data));
    }

    public function add_product()
{
    if (!session()->get('logged_in') || session()->get('user_type') !== 'merchant') {
        return redirect()->to('/login')->with('error', 'Please log in as a merchant.');
    }

    $userId = session()->get('user_id');
    $shopModel = new Shops_model();
    $productModel = new Products_model();
    $productImagesModel = new Product_images_model();

    $shop = $shopModel->where('marchent_id', $userId)->first();
    if (!$shop) {
        return redirect()->to('/marchent_account')->with('error', 'No shop found.');
    }

    // Prepare product data
    $data = [
        'shop_id' => $shop['shop_id'],
        'product_name' => $this->request->getPost('product_name'),
        'product_description' => $this->request->getPost('product_description'),
        'price' => $this->request->getPost('price'),
        'quantity' => $this->request->getPost('quantity'),
        'category_id' => $this->request->getPost('category_id'),
        'brand_id' => $this->request->getPost('brand_id'),
        'dimensions' => $this->request->getPost('dimensions'),
        'weight' => $this->request->getPost('weight'),
        'stock_status' => $this->request->getPost('stock_status'),
        'slug' => url_title($this->request->getPost('product_name'), '-', true)
    ];

    // Insert product and get product ID
    $productModel->insert($data);
    $product_id = $productModel->insertID();

    if (!$product_id) {
        return redirect()->to('/marchent_account')->with('error', 'Failed to add product.');
    }

    // Handle file uploads
    $fileFields = ['photo_1', 'photo_2', 'photo_3', 'photo_4'];
    $images = [];

    foreach ($fileFields as $field) {
        $file = $this->request->getFile($field);
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . '../public/assets/uploads/products', $newName);
            $images[] = '/uploads/products/' . $newName;
        } else {
            $images[] = null;
        }
    }

    $imageData = [
        'product_id' => $product_id,
        'image' => $images[0] ?? null,
        'image2' => $images[1] ?? null,
        'image3' => $images[2] ?? null,
        'image4' => $images[3] ?? null,
    ];
    $productImagesModel->insert($imageData);

    return redirect()->to('/marchent_account')->with('success', 'Product added successfully.');
}


    public function update_account()
{
    // Check if user is a logged-in merchant
    if (!session()->get('logged_in') || session()->get('user_type') !== 'merchant') {
        return redirect()->to('/login')->with('error', 'Please log in as a merchant.');
    }

    $userId = session()->get('user_id');
    $shopModel = new Shops_model();
    $shop = $shopModel->where('marchent_id', $userId)->first();

    if (!$shop) {
        return redirect()->to('/marchent_account')->with('error', 'No shop found.');
    }

    $validationRules = [
        'shop_name' => 'required|max_length[100]',
        'shop_address' => 'required|max_length[255]',
        'shop_description' => 'required|max_length[500]',
        'shop_icon' => 'if_exist|uploaded[shop_icon]|max_size[shop_icon,1024]|is_image[shop_icon]'
    ];

    if (!$this->validate($validationRules)) {
        $errors = $this->validator->getErrors();
        return redirect()->to('/marchent-account')->with('error', implode('<br>', $errors));
    }

    $updateData = [
        'shop_name' => $this->request->getPost('shop_name'),
        'shop_address' => $this->request->getPost('shop_address'),
        'shop_description' => $this->request->getPost('shop_description')
    ];

    // Handle shop icon upload if a new file is provided
    if ($this->request->getFile('shop_icon')->isValid()) {
        $image = $this->request->getFile('shop_icon');
        $imageName = $image->getRandomName();
        $image->move('assets/uploads/shops', $imageName);
        $updateData['shop_icon'] = $imageName;

        // Optionally delete the old image
        if ($shop['shop_icon'] && file_exists('assets/uploads/shops/' . $shop['shop_icon'])) {
            unlink('assets/uploads/shops/' . $shop['shop_icon']);
        }
    }

    $shopModel->update($shop['shop_id'], $updateData);

    return redirect()->to('/marchent_account')->with('success', 'Shop details updated successfully.');
}



}
