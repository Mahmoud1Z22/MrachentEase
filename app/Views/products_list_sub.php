<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
<meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store, bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

<!-- SITE TITLE -->
<title>MarchentEase - <?php echo esc($selected_subcategory['subcategory_name'] ?? 'Subcategory'); ?></title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.png'); ?>">
<!-- Animation CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/animate.css'); ?>">    
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet"> 
<!-- Icon Font CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/all.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/ionicons.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/themify-icons.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/linearicons.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/flaticon.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/simple-line-icons.css'); ?>">
<!-- Owl carousel CSS -->
<link rel="stylesheet" href="<?= base_url('assets/owlcarousel/css/owl.carousel.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/owlcarousel/css/owl.theme.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/owlcarousel/css/owl.theme.default.min.css'); ?>">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/magnific-popup.css'); ?>">
<!-- jQuery UI CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.css'); ?>">
<!-- Slick CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/slick.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/slick-theme.css'); ?>">
<!-- Style CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/responsive.css'); ?>">
</head>

<body>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END LOADER -->

<?php
// Initialize cart data
$cart_count = 0;
$cart_items = [];

// Check if the user is logged in to fetch their cart items
$logged_in = session()->get('logged_in');
$user_id = session()->get('user_id');

if ($logged_in && $user_id) {
    $cartModel = new \App\Models\Cart_model();
    $productModel = new \App\Models\Products_model();
    $imageModel = new \App\Models\Product_images_model();

    try {
        // Fetch cart items for the user
        $cart_items = $cartModel->where('customer_id', $user_id)->findAll();
        log_message('debug', 'Cart items for dropdown: ' . json_encode($cart_items));

        // Clear cart duplicates by cart_id or product_id
        $cart_items = array_unique($cart_items, SORT_REGULAR); // Ensures no duplicates in the cart

        // Fetch product details and images for each cart item
        foreach ($cart_items as &$item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $item['product_name'] = $product['product_name'];
                $item['price'] = $product['price'];
            } else {
                $item['product_name'] = 'Unknown Product';
                $item['price'] = 0.00;
                log_message('error', 'Product not found for product_id: ' . $item['product_id']);
            }

            $image = $imageModel->where('product_id', $item['product_id'])->first();
            $item['image'] = $image && !empty($image['image']) ? $image['image'] : 'images/default_product.jpg';
        }

        // Calculate cart count
        $cart_count = count($cart_items);
        log_message('debug', 'Cart count for user_id ' . $user_id . ': ' . $cart_count);
    } catch (\Exception $e) {
        log_message('error', 'Error fetching cart items for dropdown: ' . $e->getMessage());
        $cart_count = 0;
        $cart_items = [];
    }
}
?>

<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-left">
                            <li>
                                <i class="ti-mobile"></i>
                                <span>123-456-7890</span>
                                <i></i>
                                <?php if (session()->get('logged_in')): ?>
                                    <b>Hi</b>
                                    <a href="<?php echo site_url('account_details'); ?>">
                                        <b><?php echo session()->get('logged_in') ? esc(session()->get('userName')) : 'Guest'; ?></b>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-right">
                        <ul class="header_list">
                            <li><a href="contact.html">Contact Us</a></li>  
                            <li><a href="#">About us</a></li> 
                            <li><a href="<?php echo site_url('wishlist/view'); ?>"><i class="ti-heart"></i><span>Wishlist</span></a></li>
                            <li>
                                <?php if (session()->get('logged_in')): ?>
                                    <a href="<?php echo site_url('logout'); ?>"><i class="ti-user"></i><span>Logout</span></a>
                                <?php else: ?>
                                    <a href="<?php echo site_url('login'); ?>"><i class="ti-user"></i><span>Login</span></a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg"> 
                <a class="navbar-brand" href="<?php echo site_url(''); ?>">
                    <h2>
                        <img src="<?= base_url('assets/images/favicon.png'); ?>" alt="">
                        <b>MarchentEase</b>
                    </h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false"> 
                    <span class="ion-android-menu"></span>
                </button>
                <div class="product_search_form collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="custom_select">
                                    <select class="first_null">
                                        <option value="">All Category</option>
                                        <?php foreach ($categories as $categoryId => $category): ?>
                                            <option value="<?php echo esc($category['name']); ?>"><?php echo esc($category['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <input class="form-control" placeholder="Search Product..." required="" type="text">
                            <button type="submit" class="search_btn"><i class="linearicons-magnifier"></i></button>
                        </div>
                    </form>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li>
                            <a class="nav-link active" href="<?php echo site_url(''); ?>">Home</a>
                        </li>
                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Products</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <?php foreach ($categories as $categoryId => $category): ?>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header"><?php echo esc($category['name']); ?></li>
                                                <?php if (empty($category['subcategories'])): ?>
                                                    <li><a class="dropdown-item nav-link nav_item" href="<?php echo site_url('shop/category/' . $categoryId); ?>">All <?php echo esc($category['name']); ?></a></li>
                                                <?php else: ?>
                                                    <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                        <?php
                                                            $subcategoryName = $subcategory['name'];
                                                            if (strlen($subcategoryName) > 25) {
                                                                $subcategoryName = substr($subcategoryName, 0, 30) . '...';
                                                            }
                                                        ?>
                                                        <li><a class="dropdown-item nav-link nav_item" href="<?php echo esc($subcategory['url']); ?>"><?php echo esc($subcategoryName); ?></a></li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <style>
                        .dropdown-menu {
                            padding: 0 !important;
                            margin: 0 !important;
                            width: 100%;
                            max-width: 100vw;
                            overflow-x: auto;
                            box-sizing: border-box !important;
                        }
                        .mega-menu.d-lg-flex {
                            display: flex !important;
                            flex-wrap: wrap;
                            margin: 0 !important;
                            padding: 0 !important;
                            list-style: none !important;
                            width: 100%;
                            gap: 0 !important;
                        }
                        .mega-menu-col {
                            flex: 0 0 auto;
                            min-width: 200px;
                            margin: 0 !important;
                            padding: 0 !important;
                            box-sizing: border-box;
                        }
                        .mega-menu-col.col-lg-3 {
                            padding-left: 0 !important;
                            padding-right: 0 !important;
                        }
                        .mega-menu-col ul {
                            margin: 0 !important;
                            padding: 0 !important;
                            list-style: none !important;
                        }
                        .nav_item {
                            display: block;
                            max-width: 200px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            padding: 5px !important;
                        }
                        </style>
                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Shops</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <li class="mega-menu-col col-lg-9">
                                        <ul class="d-lg-flex">
                                            <li class="mega-menu-col col-lg-4">
                                                <ul> 
                                                    <li class="dropdown-header">Shop Page Layout</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">shop List view</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">shop List Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-right-sidebar.html">shop List Right Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Shop Load More</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Other Pages</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Cart</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Checkout</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="my-account.html">My Account</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Wishlist</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="compare.html">compare</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Order Completed</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Product Pages</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Default</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Right Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Thumbnails Left</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mega-menu-col col-lg-3">
                                        <div class="header_banner">
                                            <div class="header_banner_content">
                                                <div class="shop_banner">
                                                    <div class="banner_img overlay_bg_40">
                                                        <img src="assets/images/shop_banner.jpg" alt="shop_banner"/>
                                                    </div> 
                                                    <div class="shop_bn_content">
                                                        <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                        <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                        <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <?php if (session()->get('logged_in')): ?>
                        <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count"><?php echo $cart_count; ?></span></a>
                            <div class="cart_box dropdown-menu dropdown-menu-right">
                                <ul class="cart_list">
                                    <?php if (empty($cart_items)): ?>
                                        <li>
                                            <span class="cart_quantity">Your cart is empty.</span>
                                        </li>
                                    <?php else: ?>
                                        <?php foreach ($cart_items as $item): ?>
                                            <li>
                                                <a href="<?php echo site_url('cart/remove/' . $item['cart_id']); ?>" class="item_remove">
                                                    <i class="ion-close"></i>
                                                </a>
                                                <a href="<?php echo site_url('product_details/' . $item['product_id']); ?>">
                                                    <img src="<?php echo base_url('assets/' . esc($item['image'])); ?>" alt="<?php echo esc($item['product_name']); ?>">
                                                    <?php echo esc($item['product_name']); ?>
                                                </a>
                                                <span class="cart_quantity">
                                                    <?php echo $item['quantity']; ?> x
                                                    <span class="cart_amount">
                                                        <span class="price_symbole">$</span>
                                                        <?php echo number_format($item['price'], 2); ?>
                                                    </span>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total">
                                        <strong>Subtotal:</strong>
                                        <span class="cart_price">
                                            <span class="price_symbole">$</span>
                                            <?php
                                            $subtotal = 0;
                                            foreach ($cart_items as $item) {
                                                $subtotal += $item['price'] * $item['quantity'];
                                            }
                                            echo number_format($subtotal, 2);
                                            ?>
                                        </span>
                                    </p>
                                    <p class="cart_buttons">
                                        <a href="<?php echo site_url('cart'); ?>" class="btn btn-fill-line rounded-0 view-cart">View Cart</a>
                                        <a href="<?php echo site_url('checkout'); ?>" class="btn btn-fill-out rounded-0 checkout">Checkout</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown"><i class="linearicons-cart"></i></a>
                            <div class="cart_box dropdown-menu dropdown-menu-centered">
                                <div class="cart_footer">
                                    <p class="cart_total"><strong>Please login to view your cart</strong></p>
                                    <p class="cart_buttons"><a href="<?php echo site_url('login'); ?>" class="btn btn-fill-out rounded-0 checkout">Login</a></p>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- END HEADER -->

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row align-items-center mb-4 pb-1">
                    <div class="col-12">
                        <div class="product_header">
                            <div class="product_header_left">
                                <h5 class="section_title"><?php echo esc($selected_subcategory['subcategory_name'] ?? 'Subcategory Products'); ?></h5>
                            </div>
                            <div class="product_header_right">
                            	<div class="products_view">
                                    <a href="javascript:Void(0);" class="shorting_icon grid"><i class="ti-view-grid"></i></a>
                                    <a href="javascript:Void(0);" class="shorting_icon list active"><i class="ti-layout-list-thumb"></i></a>
                                </div>
                                <div class="custom_select">
                                    <select class="form-control form-control-sm">
                                        <option value="order">Default sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="date">Sort by newness</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row shop_container list">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="<?php echo site_url('product_details/' . $product['product_id']); ?>">
                                            <img src="<?php echo base_url(esc($product['image'])); ?>" alt="<?php echo esc($product['product_name']); ?>">        
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="<?php echo site_url('cart/add/' . $product['product_id']); ?>"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="<?php echo site_url('wishlist/add/' . $product['product_id']); ?>"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="<?php echo site_url('product_details/' . $product['product_id']); ?>"><?php echo esc($product['product_name']); ?></a></h6>
                                        <div class="product_price">
                                            <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                            <!-- <?php if ($product['price'] < 100): ?>
                                                <del>$<?php echo number_format($product['price'] + 10, 2); ?></del>
                                                <div class="on_sale">
                                                    <span>10% Off</span>
                                                </div>
                                            <?php endif; ?> -->
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:<?php echo ($product['rating'] ?? 4) * 20; ?>%"></div>
                                            </div>
                                            <span class="rating_num">(<?php echo rand(10, 50); ?>)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p><?php echo esc($product['product_description'] ?? 'No description available.'); ?></p>
                                        </div>
                                        <div class="list_product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="<?php echo site_url('cart/add/' . $product['product_id']); ?>"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="<?php echo site_url('wishlist/add/' . $product['product_id']); ?>"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>No products found in this subcategory.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination mt-3 justify-content-center pagination_style1">
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="linearicons-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                <div class="sidebar">
                    <div class="widget">
                        <h5 class="widget_title">Categories</h5>
                        <ul class="widget_categories">
                            <?php foreach ($categories as $categoryId => $category): ?>
                                <li class="category-item">
                                    <div class="category-header">
                                        <span class="categories_name"><?php echo esc($category['name']); ?></span>
                                        <span class="categories_num">(<?php echo esc($category['product_count']); ?>)</span>
                                        <?php if (!empty($category['subcategories'])): ?>
                                            <span class="toggle-icon">+</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($category['subcategories'])): ?>
                                        <ul class="subcategory_list" style="display: none;">
                                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                <li>
                                                    <a href="<?php echo esc($subcategory['url']); ?>" class="categories_name <?php echo ($selected_subcategory && $selected_subcategory['subcategory_name'] === $subcategory['name']) ? 'active-subcategory' : ''; ?>">
                                                        <span class="subcategory_name"><?php echo esc($subcategory['name']); ?></span>
                                                        <span class="subcategory_num">(<?php echo esc($subcategory['product_count']); ?>)</span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <style>
                    .widget_categories {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }
                    .category-item {
                        margin-bottom: 10px;
                    }
                    .category-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 8px 12px;
                        background-color: #f5f5f5;
                        border-radius: 4px;
                        cursor: pointer;
                        transition: background-color 0.3s;
                    }
                    .category-header:hover {
                        background-color: #e0e0e0;
                    }
                    .categories_name {
                        font-size: 16px;
                    }
                    .categories_num {
                        font-size: 14px;
                        color: #777;
                    }
                    .toggle-icon {
                        font-size: 16px;
                        font-weight: bold;
                        color: #FF324D;
                    }
                    .subcategory_list {
                        list-style: none;
                        padding: 0;
                        margin-left: 15px;
                        margin-top: 5px;
                    }
                    .subcategory_list li a.categories_name {
                        font-size: 14px;
                        color: #555;
                        text-decoration: none;
                        display: block;
                        padding: 5px 0;
                    }
                    .subcategory_list li a.categories_name:hover {
                        color: #FF324D;
                        text-decoration: underline;
                    }
                    .subcategory_list li a.active-subcategory {
                        color: #FF324D;
                        font-weight: bold;
                        background-color: #f9ebeb;
                        border-radius: 4px;
                        padding: 5px 10px;
                    }
                    </style>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const categoryHeaders = document.querySelectorAll('.category-header');
                        
                        categoryHeaders.forEach(header => {
                            header.addEventListener('click', function () {
                                const subcategoryList = this.nextElementSibling;
                                const toggleIcon = this.querySelector('.toggle-icon');
                                
                                if (subcategoryList && subcategoryList.classList.contains('subcategory_list')) {
                                    const isVisible = subcategoryList.style.display === 'block';
                                    subcategoryList.style.display = isVisible ? 'none' : 'block';
                                    toggleIcon.textContent = isVisible ? '+' : '−';
                                }
                            });

                            // Automatically expand the category containing the active subcategory
                            const subcategoryList = header.nextElementSibling;
                            if (subcategoryList && subcategoryList.querySelector('.active-subcategory')) {
                                subcategoryList.style.display = 'block';
                                header.querySelector('.toggle-icon').textContent = '−';
                            }
                        });
                    });
                    </script>

                    <div class="widget">
                        <h5 class="widget_title">Filter</h5>
                        <div class="filter_price">
                            <div id="price_filter" data-min="0" data-max="500" data-min-value="50" data-max-value="300" data-price-sign="$"></div>
                            <div class="price_range">
                                <span>Price: <span id="flt_price"></span></span>
                                <input type="hidden" id="price_first">
                                <input type="hidden" id="price_second">
                            </div>
                        </div>
                    </div>
                    <div class="widget">
                        <h5 class="widget_title">Brand</h5>    
                        <ul class="list_brand">
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="Arrivals" value="">
                                    <label class="form-check-label" for="Arrivals"><span>New Arrivals</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="Lighting" value="">
                                    <label class="form-check-label" for="Lighting"><span>Lighting</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="Tables" value="">
                                    <label class="form-check-label" for="Tables"><span>Tables</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="Chairs" value="">
                                    <label class="form-check-label" for="Chairs"><span>Chairs</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="Accessories" value="">
                                    <label class="form-check-label" for="Accessories"><span>Accessories</span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h5 class="widget_title">Size</h5>
                        <div class="product_size_switch">
                            <span>xs</span>
                            <span>s</span>
                            <span>m</span>
                            <span>l</span>
                            <span>xl</span>
                            <span>2xl</span>
                            <span>3xl</span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
<footer class="footer_dark">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="footer_logo">
                            <h3>
                                <img src="assets/images/favicon.png" alt="">
                                <b style="color: white;">MarchentEase</b>
                            </h3>
                        </div>
                        <p>If you are going to use of Lorem Ipsum need to be sure there isn't hidden of text</p>
                    </div>
                    <div class="widget">
                        <ul class="social_icons social_white">
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                            <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                            <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Useful Links</h6>
                        <ul class="widget_links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Location</a></li>
                            <li><a href="#">Affiliates</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Category</h6>
                        <ul class="widget_links">
                            <li><a href="#">Men</a></li>
                            <li><a href="#">Woman</a></li>
                            <li><a href="#">Kids</a></li>
                            <li><a href="#">Best Saller</a></li>
                            <li><a href="#">New Arrivals</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">My Account</h6>
                        <ul class="widget_links">
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Discount</a></li>
                            <li><a href="#">Returns</a></li>
                            <li><a href="#">Orders History</a></li>
                            <li><a href="#">Order Tracking</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Contact Info</h6>
                        <ul class="contact_info contact_info_light">
                            <li>
                                <i class="ti-location-pin"></i>
                                <p>123 Street, Old Trafford, New South London , UK</p>
                            </li>
                            <li>
                                <i class="ti-email"></i>
                                <a href="mailto:info@sitename.com">info@sitename.com</a>
                            </li>
                            <li>
                                <i class="ti-mobile"></i>
                                <p>+ 457 789 789 65</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-left">© 2025 All Rights Reserved</p>
                </div>
                <div class="col-md-6">
                    <ul class="footer_payment text-center text-lg-right">
                        <li><a href="#"><img src="assets/images/visa.png" alt="visa"></a></li>
                        <li><a href="#"><img src="assets/images/discover.png" alt="discover"></a></li>
                        <li><a href="#"><img src="assets/images/master_card.png" alt="master_card"></a></li>
                        <li><a href="#"><img src="assets/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="assets/images/amarican_express.png" alt="amarican_express"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 

<!-- Latest jQuery --> 
<script src="<?= base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script> 
<!-- jQuery UI --> 
<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>
<!-- Popper min JS -->
<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
<!-- Latest compiled and minified Bootstrap --> 
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script> 
<!-- Owl Carousel min JS  --> 
<script src="<?= base_url('assets/owlcarousel/js/owl.carousel.min.js'); ?>"></script> 
<!-- Magnific Popup min JS  --> 
<script src="<?= base_url('assets/js/magnific-popup.min.js'); ?>"></script> 
<!-- Waypoints min JS  --> 
<script src="<?= base_url('assets/js/waypoints.min.js'); ?>"></script> 
<!-- Parallax JS  --> 
<script src="<?= base_url('assets/js/parallax.js'); ?>"></script> 
<!-- Countdown JS  --> 
<script src="<?= base_url('assets/js/jquery.countdown.min.js'); ?>"></script> 
<!-- ImagesLoaded JS --> 
<script src="<?= base_url('assets/js/imagesloaded.pkgd.min.js'); ?>"></script>
<!-- Isotope min JS --> 
<script src="<?= base_url('assets/js/isotope.min.js'); ?>"></script>
<!-- jQuery.dd.min JS -->
<script src="<?= base_url('assets/js/jquery.dd.min.js'); ?>"></script>
<!-- Slick JS -->
<script src="<?= base_url('assets/js/slick.min.js'); ?>"></script>
<!-- ElevateZoom JS -->
<script src="<?= base_url('assets/js/jquery.elevatezoom.js'); ?>"></script>
<!-- Custom Scripts JS --> 
<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>

</body>
</html>