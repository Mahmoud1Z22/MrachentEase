<?php

namespace App\Controllers;
use App\Models\Users_model;

class Login extends BaseController
{
    public function index(): string
    {
        return view('login'); // Assumes your form is in a view file named 'login.php'
    }

        public function auth()
        {
        $userModel = new Users_model();

        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Find user by email
        $user = $userModel->where('email', $email)->first();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) { // Changed 'password' to 'password_hash'
            // Set session data for logged-in user
            $sessionData = [
                'user_id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'userName' => $user['userName'],
                'email' => $user['email'],
                'user_type' => $user['user_type'],
                'logged_in' => true // Added this key
            ];
            session()->set($sessionData);

            if ($sessionData['user_type'] === 'merchant') {
                return redirect()->to('/marchent_account')->with('success', 'Login successful!');   
            }else {
                return redirect()->to('/')->with('success', 'Login successful!');
            }
            
        } else {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
