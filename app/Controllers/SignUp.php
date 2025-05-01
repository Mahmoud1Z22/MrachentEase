<?php

namespace App\Controllers;
use App\Models\Users_model;
use App\Models\Shops_model;

class SignUp extends BaseController
{
    public function index(): string
    {
        return view('signup');
    }

        public function store_user()
        {
            // Load models
            $userModel = new Users_model();
            $shopModel = new Shops_model();
    
            // Get POST data
            $password = $this->request->getPost('password');
            $confirm_password = $this->request->getPost('confirm_password');
            $agree = $this->request->getPost('agree');
    
            // Validation rules
            if ($password !== $confirm_password) {
                return redirect()->back()->with('error', 'Passwords do not match.');
            }
            if (empty($agree)) {
                return redirect()->back()->with('error', 'You must agree to the terms and policy.');
            }
    
            // Prepare user data for insertion
            $userData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'userName' => $this->request->getPost('userName'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'address' => $this->request->getPost('address'),
                'user_type' => $this->request->getPost('user_type')
            ];
    
            // Insert user and get the inserted ID
            $userId = $userModel->insert($userData, true); // Returns the inserted ID
    
            // Check if user_type is 'merchant' and create a shop
            if ($userData['user_type'] === 'merchant') {
                $shopData = [
                    'marchent_id' => $userId,
                    'shop_name' => '', // Empty
                    'shop_description' => '', // Empty
                    'shop_address' => '', // Empty
                    'shop_icon' => '' // Empty
                ];
                $shopModel->insert($shopData);
    
            }
    
            return redirect()->to('/login')->with('success', 'Registration successful! Please log in.');
        } 
    

}