<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/wishlist', 'Wishlist::index');
$routes->get('/my_account', 'MyAccount::index');
$routes->get('/marchent_account', 'MarchentAccount::index');
$routes->get('/products_list', 'ProductsList::index');
$routes->get('/shop_list', 'ShopList::index');
// $routes->get('/product_details', 'ProductDetails::index');
$routes->get('product_details/(:num)', 'ProductDetails::index/$1');
$routes->get('signup', 'SignUp::index');
$routes->post('signup/store_user', 'SignUp::store_user');

$routes->get('account_details', 'MyAccount::account_details');


$routes->get('checkout', 'Checkout::index');


$routes->get('order-completed', 'OrderCompleted::index');

$routes->post('checkout/placeOrder', 'Checkout::placeOrder');

$routes->post('marchent/add_product', 'MarchentAccount::add_product');
$routes->post('merchant/update_shop', 'MarchentAccount::update_account');

$routes->get('cart', 'Cart::index');
$routes->get('cart/add/(:num)', 'Cart::add/$1');
$routes->post('cart/add_del/(:num)', 'Cart::add_del/$1');
$routes->get('cart/remove/(:num)', 'Cart::remove/$1');
$routes->post('cart/update', 'Cart::update');

$routes->get('/login', 'Login::index');
$routes->post('login/auth', 'Login::auth');  // Handle login submission
$routes->get('logout', 'Login::logout');