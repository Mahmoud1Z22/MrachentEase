<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
<meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

<!-- SITE TITLE -->
<title>MarchentEase</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="assets/css/animate.css">	
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet"> 
<!-- Icon Font CSS -->
<link rel="stylesheet" href="assets/css/all.min.css">
<link rel="stylesheet" href="assets/css/ionicons.min.css">
<link rel="stylesheet" href="assets/css/themify-icons.css">
<link rel="stylesheet" href="assets/css/linearicons.css">
<link rel="stylesheet" href="assets/css/flaticon.css">
<link rel="stylesheet" href="assets/css/simple-line-icons.css">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="assets/css/magnific-popup.css">
<!-- jquery-ui CSS -->
<link rel="stylesheet" href="assets/css/jquery-ui.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="assets/css/slick.css">
<link rel="stylesheet" href="assets/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/responsive.css">

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


<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
	<div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                	<div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <!-- <div class="lng_dropdown mr-2">
                            <select name="countries" class="custome_select">
                                <option value='en' data-image="assets/images/eng.png" data-title="English">English</option>
                                <option value='fn' data-image="assets/images/fn.png" data-title="France">France</option>
                                <option value='us' data-image="assets/images/us.png" data-title="United States">United States</option>
                            </select>
                        </div>
                        <div class="mr-3">
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="USD">USD</option>
                                <option value='EUR' data-title="EUR">EUR</option>
                                <option value='GBR' data-title="GBR">GBR</option>
                            </select>
                        </div> -->
                        <ul class="contact_detail text-center text-lg-left">
                            <li>
                                <i class="ti-mobile"></i>
                                <span>123-456-7890</span>
                                <i></i>
                                <?php if (session()->get('logged_in')): ?>
                                    <b>
                                        Hi
                                    </b>
                                    <a href="<?php echo site_url('marchent_account'); ?>">
                                        <b>
                                            <?php echo session()->get('logged_in') ? esc(session()->get('userName')) : 'Guest'; ?>
                                        </b>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                	<div class="text-center text-md-right">
                       	<ul class="header_list">
                        	<!-- <li><a href="compare.html"><i class="ti-control-shuffle"></i><span>Compare</span></a></li> -->
                            <!-- <li><a href="<?php echo site_url('wishlist'); ?>"><i class="ti-heart"></i><span>Wishlist</span></a></li> -->
                            <li><a href="<?php echo site_url('login'); ?>"><i class="ti-user"></i><span>Logout</span></a></li>
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
                        <img src="assets/images/favicon.png" alt="">
                        <b>MarchentEase</b>
                    </h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false"> 
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li >
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li >
                            <a class="nav-link active" href="#">Store information</a>
                        </li>
                        <li>
                            <a class="nav-link nav_item" href="contact.html">Contact Us</a>
                        </li> 
                        <li>
                            <a class="nav-link" href="#">About us</a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form>
                                <input type="text" placeholder="Search" class="form-control" id="search_input">
                                <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div><div class="search_overlay"></div>
                    </li>
                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count">2</span></a>
                        <div class="cart_box dropdown-menu dropdown-menu-right">
                            <ul class="cart_list">
                                <li>
                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                    <a href="#"><img src="assets/images/cart_thamb1.jpg" alt="cart_thumb1">Variable product 001</a>
                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>78.00</span>
                                </li>
                                <li>
                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                    <a href="#"><img src="assets/images/cart_thamb2.jpg" alt="cart_thumb2">Ornare sed consequat</a>
                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>81.00</span>
                                </li>
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>159.00</p>
                                <p class="cart_buttons"><a href="#" class="btn btn-fill-line rounded-0 view-cart">View Cart</a><a href="#" class="btn btn-fill-out rounded-0 checkout">Checkout</a></p>
                            </div>
                        </div>
                    </li>
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
            <div class="col-lg-3 col-md-4">
            <div class="dashboard_menu">
                <ul class="nav nav-tabs flex-column" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="ti-layout-grid2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="ti-receipt"></i>Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="false"><i class="ti-package"></i>Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="add-product-tab" data-toggle="tab" href="#add-product" role="tab" aria-controls="add-product" aria-selected="false"><i class="ti-plus"></i>Add new product</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="shop-detail-tab" data-toggle="tab" href="#shop-detail" role="tab" aria-controls="shop-detail" aria-selected="false"><i class="ti-home"></i>shop details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-detail-tab" data-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="false"><i class="ti-user"></i>Account details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout'); ?>"><i class="ti-power-off"></i>Logout</a>
                    </li>
                </ul>
            </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="tab-content dashboard_content">
                  	<div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    	<div class="card">
                        	<div class="card-header">
                                <h3>Dashboard</h3>
                            </div>
                            <div class="card-body">
                    			<p>From your account dashboard. you can easily check &amp; view your <a href="javascript:void(0);" onclick="$('#orders-tab').trigger('click')">recent orders</a>, manage your <a href="javascript:void(0);" onclick="$('#address-tab').trigger('click')">shipping and billing addresses</a> and <a href="javascript:void(0);" onclick="$('#account-detail-tab').trigger('click')">edit your password and account details.</a></p>
                            </div>
                        </div>
                  	</div>
                  	<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    	<div class="card">
                        	<div class="card-header">
                                <h3>Orders</h3>
                            </div>
                            <div class="card-body">
                    			<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1234</td>
                                                <td>March 15, 2020</td>
                                                <td>Processing</td>
                                                <td>$78.00 for 1 item</td>
                                                <td><a href="#" class="btn btn-fill-out btn-sm">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>#2366</td>
                                                <td>June 20, 2020</td>
                                                <td>Completed</td>
                                                <td>$81.00 for 1 item</td>
                                                <td><a href="#" class="btn btn-fill-out btn-sm">View</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  	</div>

                      <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                    	<div class="card">
                        	<div class="card-header">
                                <h3>Products</h3>
                            </div>
                            <div class="card-body">
                    			<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Stock State</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($products)): ?>
                                                <tr>
                                                    <td colspan="5">No products added yet.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($products as $product): ?>
                                                    <tr>
                                                        <td>#<?= esc($product['product_id']) ?></td>
                                                        <td><?= esc($product['product_name']) ?></td>
                                                        <td><?= esc(ucfirst(str_replace('_', ' ', $product['stock_status']))) ?></td>
                                                        <td>$<?= esc(number_format($product['price'], 2)) ?></td>
                                                        <td><?= esc($product['quantity']) ?></td>
                                                        <td><a href="<?php echo site_url('marchent/product/' . $product['product_id']); ?>" class="btn btn-fill-out btn-sm">View</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  	</div>

                    <div class="tab-pane fade" id="add-product" role="tabpanel" aria-labelledby="add-product-tab">
						<div class="card">
                        	<div class="card-header">
                                <h3>Add new product</h3>
                            </div>
                            <div class="card-body">
                            <form method="post" name="enq" action="<?php echo site_url('marchent/add_product'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Product Name <span class="required">*</span></label>
                                        <input required class="form-control" name="product_name" type="text">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Product Description <span class="required">*</span></label>
                                        <input required class="form-control" name="product_description" type="text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price <span class="required">*</span></label>
                                        <input required class="form-control" name="price" type="number" step="0.01">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Quantity <span class="required">*</span></label>
                                        <input required class="form-control" name="quantity" type="number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Category <span class="required">*</span></label>
                                        <select required class="form-control" name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= esc($category['category_id']) ?>">
                                                    <?= esc($category['category_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Brand <span class="required">*</span></label>
                                        <select required class="form-control" name="brand_id" id="brand">
                                            <option value="">Select Brand</option>
                                            <?php foreach ($brands as $brand): ?>
                                                <option value="<?= esc($brand['brand_id']) ?>">
                                                    <?= esc($brand['brand_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Dimensions <span class="required">*</span></label>
                                        <input required class="form-control" name="dimensions" type="text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Weight <span class="required">*</span></label>
                                        <input required class="form-control" name="weight" type="text">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Stock Status <span class="required">*</span></label>
                                        <select required class="form-control" name="stock_status">
                                            <option value="">Select stock status</option>
                                            <option value="in_stock">In stock</option>
                                            <option value="out_of_stock">Out of stock</option>
                                            <option value="pre_order">Pre order</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Main Photo <span class="required">*</span></label>
                                        <input required class="form-control" name="photo_1" type="file" accept="image/*">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Photo 2</label>
                                        <input class="form-control" name="photo_2" type="file" accept="image/*">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Photo 3</label>
                                        <input class="form-control" name="photo_3" type="file" accept="image/*">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Photo 4</label>
                                        <input class="form-control" name="photo_4" type="file" accept="image/*">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Add Product</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
					</div>

                    <div class="tab-pane fade" id="shop-detail" role="tabpanel" aria-labelledby="shop-detail-tab">
                        <div class="card">
                            <div class="card-header">
                                <h3>Shop Details</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" name="enq" action="<?php echo site_url('merchant/update_shop'); ?>" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Shop name <span class="required">*</span></label>
                                            <input required class="form-control" name="shop_name" type="text" value="<?php echo isset($shop['shop_name']) ? esc($shop['shop_name']) : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Shop address <span class="required">*</span></label>
                                            <input required class="form-control" name="shop_address" type="text" value="<?php echo isset($shop['shop_address']) ? esc($shop['shop_address']) : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Shop description <span class="required">*</span></label>
                                            <input required class="form-control" name="shop_description" type="text" value="<?php echo isset($shop['shop_description']) ? esc($shop['shop_description']) : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Shop Photo <span class="required">*</span></label>
                                            <input class="form-control" name="shop_icon" type="file" accept="image/*">
                                            <?php if (isset($shop['shop_icon']) && $shop['shop_icon']): ?>
                                                <p>Current Photo: <img src="<?php echo base_url('assets/uploads/shops/' . esc($shop['shop_icon'])); ?>" alt="Shop Icon" width="100"></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    

					
                    <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
						<div class="card">
                        	<div class="card-header">
                                <h3>Account Details</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" name="enq" action="<?php echo site_url('signup/update_account'); ?>">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>First Name <span class="required">*</span></label>
                                            <input required class="form-control" name="first_name" type="text" value="<?= esc($user['first_name'] ?? '') ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input required class="form-control" name="last_name" type="text" value="<?= esc($user['last_name'] ?? '') ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Display Name <span class="required">*</span></label>
                                            <input required class="form-control" name="userName" type="text" value="<?= esc($user['userName'] ?? '') ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input required class="form-control" name="email" type="email" value="<?= esc($user['email'] ?? '') ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Current Password <span class="required">*</span></label>
                                            <input class="form-control" name="password" type="password" placeholder="Enter new password (optional)">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                    <p class="mb-md-0 text-center text-md-left">© 2025 All Rights Reserved </p>
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
<script src="assets/js/jquery-1.12.4.min.js"></script> 
<!-- jquery-ui --> 
<script src="assets/js/jquery-ui.js"></script>
<!-- popper min js -->
<script src="assets/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap --> 
<script src="assets/bootstrap/js/bootstrap.min.js"></script> 
<!-- owl-carousel min js  --> 
<script src="assets/owlcarousel/js/owl.carousel.min.js"></script> 
<!-- magnific-popup min js  --> 
<script src="assets/js/magnific-popup.min.js"></script> 
<!-- waypoints min js  --> 
<script src="assets/js/waypoints.min.js"></script> 
<!-- parallax js  --> 
<script src="assets/js/parallax.js"></script> 
<!-- countdown js  --> 
<script src="assets/js/jquery.countdown.min.js"></script> 
<!-- imagesloaded js --> 
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<!-- isotope min js --> 
<script src="assets/js/isotope.min.js"></script>
<!-- jquery.dd.min js -->
<script src="assets/js/jquery.dd.min.js"></script>
<!-- slick js -->
<script src="assets/js/slick.min.js"></script>
<!-- elevatezoom js -->
<script src="assets/js/jquery.elevatezoom.js"></script>
<!-- scripts js --> 
<script src="assets/js/scripts.js"></script>

</body>
</html>