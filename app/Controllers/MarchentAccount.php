<?php

namespace App\Controllers;
use App\Models\Users_model;
use App\Models\Shops_model;
use App\Models\Category_model;
use App\Models\Products_model;
use App\Models\product_images_model;
use App\Models\Brands_model;
use App\Models\Suborder_model;
use App\Models\SuborderItem_model;
use App\Models\Subcategory;



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
    $suborderModel = new Suborder_model();
    $suborderItemModel = new SuborderItem_model();
    $subcategoryModel = new Subcategory(); // Added Subcategory model

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
    $categories = $categoryModel->findAll(); // Keep for other potential uses
    $brands = $brandModel->findAll();
    $products = $productModel->where('shop_id', $shop['shop_id'])->findAll();
    $subcategories = $subcategoryModel->findAll(); // Fetch all subcategories

    // Fetch suborders for the shop
    $suborders = [];
    $total_orders = 0;
    $total_revenue = 0;
    $unseen_count = 0;
    try {
        // Fetch suborders
        $suborders = $suborderModel
            ->select('suborders.*, orders.order_date, orders.total_amount')
            ->join('orders', 'orders.order_id = suborders.order_id')
            ->where('suborders.shop_id', $shop['shop_id'])
            ->orderBy('orders.order_date', 'DESC')
            ->findAll();

        // Calculate metrics
        $total_orders = $suborderModel->where('shop_id', $shop['shop_id'])->countAllResults();
        $total_revenue = $suborderModel->selectSum('subtotal')->where('shop_id', $shop['shop_id'])->first()['subtotal'] ?? 0;
        $unseen_count = $suborderModel->where('shop_id', $shop['shop_id'])->where('condition', 'unseen')->countAllResults();

        // Calculate the number of items in each suborder
        foreach ($suborders as &$suborder) {
            $items = $suborderItemModel->where('suborder_id', $suborder['suborder_id'])->findAll();
            $suborder['item_count'] = count($items);
            // Debug the order_date value
            log_message('debug', 'Suborder ID: ' . $suborder['suborder_id'] . ', Order Date: ' . $suborder['order_date']);
        }
    } catch (\Exception $e) {
        log_message('error', 'Error fetching suborders for shop_id: ' . $shop['shop_id'] . ' - ' . $e->getMessage());
        $suborders = [];
    }

    // Prepare data for view
    $data = [
        'user' => $user,
        'shop' => $shop,
        'categories' => $categories,
        'brands' => $brands,
        'products' => $products,
        'suborders' => $suborders,
        'total_orders' => $total_orders,
        'total_revenue' => $total_revenue,
        'unseen_count' => $unseen_count,
        'subcategories' => $subcategories // Added subcategories to data
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

    // Get size and target as arrays and convert to comma-separated strings
    $sizes = $this->request->getPost('size');
    $targets = $this->request->getPost('target');

    $sizeString = !empty($sizes) ? implode(',', $sizes) : null;
    $targetString = !empty($targets) ? implode(',', $targets) : null;

    // Prepare product data
    $data = [
        'shop_id' => $shop['shop_id'],
        'product_name' => $this->request->getPost('product_name'),
        'product_description' => $this->request->getPost('product_description'),
        'size' => $sizeString,
        'target' => $targetString,
        'price' => $this->request->getPost('price'),
        'quantity' => $this->request->getPost('quantity'),
        'category_id' => $this->request->getPost('category_id'),
        'brand_id' => $this->request->getPost('brand_id'),
        'dimensions' => $this->request->getPost('dimensions'),
        'weight' => $this->request->getPost('weight'),
        'stock_status' => $this->request->getPost('stock_status'),
        'slug' => url_title($this->request->getPost('product_name'), '-', true),
        'subcategory_id' => $this->request->getPost('subcategory_id') // Added subcategory_id
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

public function suborderDetails($suborder_id)
{
    if (!session()->get('logged_in') || session()->get('user_type') !== 'merchant') {
        return redirect()->to('/login')->with('error', 'Please log in as a merchant to view suborder details.');
    }

    $user_id = session()->get('user_id');
    $shopsModel = new Shops_model();
    $suborderModel = new Suborder_model();
    $suborderItemModel = new SuborderItem_model();
    $productsModel = new Products_model();

    // Verify the shop belongs to the merchant
    try {
        $shop = $shopsModel->where('marchent_id', $user_id)->first();
        if (!$shop) {
            log_message('error', 'No shop found for merchant_id: ' . $user_id);
            return redirect()->to('/marchent_account')->with('error', 'Please set up your shop to view orders.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error fetching shop for merchant_id: ' . $user_id . ' - ' . $e->getMessage());
        return redirect()->to('/marchent_account')->with('error', 'Unable to fetch shop details. Please try again later.');
    }

    // Fetch the suborder
    try {
        $suborder = $suborderModel->select('suborders.*, orders.order_date, orders.total_amount, orders.customer_id')
            ->join('orders', 'orders.order_id = suborders.order_id')
            ->where('suborders.suborder_id', $suborder_id)
            ->where('suborders.shop_id', $shop['shop_id'])
            ->first();

        if (!$suborder) {
            log_message('error', 'Suborder not found or access denied for suborder_id: ' . $suborder_id . ' and shop_id: ' . $shop['shop_id']);
            return redirect()->to('/marchent_account')->with('error', 'Suborder not found or access denied.');
        }

        // Update the suborder condition to 'seen' if it's currently 'unseen'
        if ($suborder['condition'] === 'unseen') {
            $suborderModel->update($suborder_id, ['condition' => 'seen']);
            // Optionally refresh the suborder data to reflect the update
            $suborder['condition'] = 'seen';
        }
    } catch (\Exception $e) {
        log_message('error', 'Error fetching suborder for suborder_id: ' . $suborder_id . ' - ' . $e->getMessage());
        return redirect()->to('/marchent_account')->with('error', 'Unable to fetch suborder details. Please try again later.');
    }

    // Fetch suborder items with product details (excluding image)
    $items = [];
    try {
        $items = $suborderItemModel->select('suborder_items.*, products.product_name, products.product_description')
            ->join('products', 'products.product_id = suborder_items.product_id')
            ->where('suborder_id', $suborder_id)
            ->findAll();

        if (empty($items)) {
            log_message('warning', 'No items found for suborder_id: ' . $suborder_id);
        }
    } catch (\Exception $e) {
        log_message('error', 'Error fetching items for suborder_id: ' . $suborder_id . ' - ' . $e->getMessage());
        $items = []; // Proceed with empty items to avoid breaking the view
    }

    $data = [
        'suborder' => $suborder,
        'items' => $items
    ];

    return view('merchant_suborder_details', $data);
}

public function updateSuborderStatus($suborder_id)
{
    if (!session()->get('logged_in') || session()->get('user_type') !== 'merchant') {
        return redirect()->to('/login')->with('error', 'Please log in as a merchant to update suborder status.');
    }

    $userId = session()->get('user_id');
    $shopModel = new Shops_model();
    $suborderModel = new Suborder_model();

    // Verify the shop belongs to the merchant
    $shop = $shopModel->where('marchent_id', $userId)->first();
    if (!$shop) {
        return redirect()->to('/marchent_account')->with('error', 'Please set up your shop to update orders.');
    }

    $suborder = $suborderModel->where('suborder_id', $suborder_id)
        ->where('shop_id', $shop['shop_id'])
        ->first();

    if (!$suborder) {
        return redirect()->to('/marchent_account/suborderDetails/' . $suborder_id)->with('error', 'Suborder not found or access denied.');
    }

    $newStatus = $this->request->getPost('status');
    if (!in_array($newStatus, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
        return redirect()->to('/marchent_account/suborderDetails/' . $suborder_id)->with('error', 'Invalid status selected.');
    }

    try {
        $suborderModel->update($suborder_id, ['status' => $newStatus]);
        log_message('info', 'Suborder status updated to ' . $newStatus . ' for suborder_id: ' . $suborder_id);
    } catch (\Exception $e) {
        log_message('error', 'Error updating suborder status: ' . $e->getMessage());
        return redirect()->to('/marchent_account/suborderDetails/' . $suborder_id)->with('error', 'Failed to update suborder status. Please try again.');
    }

    return redirect()->to('/marchent_account/suborderDetails/' . $suborder_id)->with('success', 'Suborder status updated successfully.');
}



}
