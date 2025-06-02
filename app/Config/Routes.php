<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\MarchentAccount;
$routes->get('/', 'Home::index');
$routes->get('products-list', 'ProductsList::index');
$routes->get('/', 'Home::index'); // Assuming a Home controller exists

$routes->get('wishlist/view', 'Wishlist::view');
$routes->get('wishlist/add/(:num)', 'Wishlist::add/$1');
$routes->get('wishlist/remove/(:num)', 'Wishlist::remove/$1');

$routes->get('/my_account', 'MyAccount::index');

$routes->get('/products_list', 'ProductsList::index');

$routes->get('shop-list/(:num)', 'ShopList::index');
$routes->get('shop-list', 'ShopList::index'); // Fallback for no ID

$routes->get('product_details/(:num)', 'ProductDetails::index/$1');

$routes->get('/shop/category/(:num)/(:any)', 'ProductsList::index/$1/$2');

$routes->get('products-list/subcategory-products/(:num)/(:any)', 'ProductsList::subcategoryProducts/$1/$2');
$routes->get('products-list/(:num)/(:segment)', 'ProductsList::subcategoryProducts');
$routes->get('home/search', 'Home::search');





$routes->get('/marchent_account', [MarchentAccount::class, 'index'], ['as' => 'merchant_account']);
$routes->get('/marchent_account/suborderDetails/(:num)', [MarchentAccount::class, 'suborderDetails'], ['as' => 'merchant_suborder_details']);
$routes->post('/marchent_account/updateSuborderStatus/(:num)', [MarchentAccount::class, 'updateSuborderStatus'], ['as' => 'merchant_update_suborder_status']);

$routes->get('signup', 'SignUp::index');
$routes->post('signup/store_user', 'SignUp::store_user');

$routes->get('account_details', 'MyAccount::account_details');

$routes->get('/order_view', 'Order::view');
$routes->get('order/details/(:num)', 'Order::details/$1');
// $routes->get('suborder/details/(:num)', 'Suborder::details/$1');

$routes->get('order-completed', 'OrderCompleted::index');

$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/placeOrder', 'Checkout::placeOrder');

$routes->post('marchent/add_product', 'MarchentAccount::add_product');
$routes->post('merchant/update_shop', 'MarchentAccount::update_account');
$routes->get('/marchent_account', 'MarchentAccount::index');

$routes->get('cart', 'Cart::index');
$routes->get('cart/add/(:num)', 'Cart::add/$1');
$routes->post('cart/add_del/(:num)', 'Cart::add_del/$1');
$routes->get('cart/remove/(:num)', 'Cart::remove/$1');
$routes->post('cart/update', 'Cart::update');

$routes->get('/login', 'Login::index');
$routes->post('login/auth', 'Login::auth');  // Handle login submission
$routes->get('logout', 'Login::logout');