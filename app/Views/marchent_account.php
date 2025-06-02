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
                        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="ti-receipt"></i>Orders      <?php if (isset($unseen_count) && $unseen_count > 0): ?>
                                            <span class="badge badge-danger"><?php echo $unseen_count; ?> Unseen</span>
                                        <?php endif; ?></a>
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
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="card-text"><?php echo isset($total_orders) ? $total_orders : 0; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Revenue</h5>
                                <p class="card-text">$<?php echo isset($total_revenue) ? number_format($total_revenue, 2) : '0.00'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Unseen Orders</h5>
                                <p class="card-text"><?php echo isset($unseen_count) ? $unseen_count : 0; ?></p>
                                <?php if (isset($unseen_count) && $unseen_count > 0): ?>
                                    <a href="javascript:void(0);" onclick="$('#orders-tab').trigger('click')" class="btn btn-light btn-sm">View</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <p>From your merchant dashboard, you can easily check & view your <a href="javascript:void(0);" onclick="$('#orders-tab').trigger('click')">recent orders</a>, manage your <a href="javascript:void(0);" onclick="$('#products-tab').trigger('click')">products</a>, and <a href="javascript:void(0);" onclick="$('#account-detail-tab').trigger('click')">edit your account details</a>.</p>
            </div>
        </div>
    </div>


<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-body {
        padding: 20px;
    }
    .card-title {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }
    .card-text {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .text-white { color: white !important; }
    @media (max-width: 768px) {
        .col-sm-6 { width: 100%; margin-bottom: 15px; }
    }
</style>
                  	<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Orders </h3>
                                        
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
                                                <?php if (!empty($suborders)): ?>
                                                    <?php foreach ($suborders as $suborder): ?>
                                                        <tr class="<?php echo $suborder['condition'] === 'unseen' ? 'unseen-row' : ''; ?>">
                                                            <td>#<?php echo esc($suborder['suborder_id']); ?></td>
                                                            <td><?php echo date('F j, Y', strtotime($suborder['order_date'])); ?></td>
                                                            <td>
                                                                <span class="badge badge-<?php echo $suborder['status'] === 'pending' ? 'warning' : ($suborder['status'] === 'processing' ? 'info' : ($suborder['status'] === 'shipped' ? 'primary' : ($suborder['status'] === 'delivered' ? 'success' : 'danger'))); ?>">
                                                                    <?php echo ucfirst($suborder['status']); ?>
                                                                </span>
                                                            </td>
                                                            <td>$<?php echo number_format($suborder['subtotal'], 2); ?> for <?php echo $suborder['item_count']; ?> item<?php echo $suborder['item_count'] != 1 ? 's' : ''; ?></td>
                                                            <td>
                                                                <a href="<?php echo base_url('/marchent_account/suborderDetails/' . $suborder['suborder_id']); ?>" class="btn btn-fill-out btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No suborders found for your shop.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <style>
                            .unseen-row {
                                font-weight: bold;
                            }

                            /* Optional: Enhance table styling */
                            .table {
                                width: 100%;
                                border-collapse: collapse;
                            }

                            .table th,
                            .table td {
                                padding: 12px;
                                text-align: left;
                                border-bottom: 1px solid #dee2e6;
                            }

                            .table th {
                                background-color: #f8f9fa;
                                font-weight: 600;
                            }

                            .badge {
                                padding: 5px 10px;
                                border-radius: 10px;
                                font-size: 12px;
                            }

                            .badge-warning { background-color: #ffc107; color: #212529; }
                            .badge-info { background-color: #17a2b8; color: #fff; }
                            .badge-primary { background-color: #007bff; color: #fff; }
                            .badge-success { background-color: #28a745; color: #fff; }
                            .badge-danger { background-color: #dc3545; color: #fff; }
                        </style>
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
                                    <div class="form-group col-md-4">
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
                                    <div class="form-group col-md-4">
                                        <label>SubCategory <span class="required">*</span></label>
                                        <select required class="form-control" name="subcategory_id" id="subcategory_id">
                                            <option value="">Select SubCategory</option>
                                            <?php foreach ($subcategories as $subcategory): ?>
                                                <option value="<?= esc($subcategory['subcategory_id']) ?>">
                                                    <?= esc($subcategory['subcategory_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
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
                                        <label>Dimensions</label>
                                        <input required class="form-control" name="dimensions" type="text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Weight</label>
                                        <input required class="form-control" name="weight" type="text">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="sizeSelect">Size <span class="text-danger"></span></label>
                                        <select required class="form-control" name="size[]" id="sizeSelect" multiple>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                            <option value="xlarge">XLarge</option>
                                            <option value="xxlarge">XXLarge</option>
                                            <option value="xxxlarge">XXXLarge</option>
                                        </select>
                                        <div class="selected-options" id="selectedSizes"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="targetSelect">Target <span class="text-danger"></span></label>
                                        <select required class="form-control" name="target[]" id="targetSelect" multiple>
                                            <option value="women">Women</option>
                                            <option value="men">Men</option>
                                            <option value="kids">Kids</option>
                                        </select>
                                        <div class="selected-options" id="selectedTargets"></div>
                                    </div>
                                    <style>
            .form-group {
                margin-bottom: 20px;
            }

            label {
                font-weight: 600;
                margin-bottom: 5px;
                display: block;
            }

            .form-control {
                border: 1px solid #f56a6a; /* MarchentEase theme color */
                border-radius: 4px;
                padding: 8px;
                transition: border-color 0.3s ease;
            }

            .form-control:focus {
                border-color: #d33f3f;
                box-shadow: 0 0 5px rgba(245, 106, 106, 0.5);
                outline: none;
            }

            select[multiple] {
                height: 120px; /* Show multiple options at once */
            }

            select[multiple] option {
                padding: 5px;
            }

            .selected-options {
                margin-top: 10px;
                font-size: 14px;
                color: #333;
                min-height: 20px;
            }

            .btn-fill-out {
                background-color: #f56a6a;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-fill-out:hover {
                background-color: #d33f3f;
            }

            .text-danger {
                color: #d33f3f;
            }

            .error-message {
                color: #d33f3f;
                font-size: 14px;
                margin-top: 5px;
                display: none;
            }
        </style>

        <!-- Internal JavaScript -->
        <script>
            // Function to update selected options display
            function updateSelectedOptions(selectElement, displayElementId) {
                const select = document.getElementById(selectElement);
                const display = document.getElementById(displayElementId);
                const selectedOptions = Array.from(select.selectedOptions).map(option => option.text);
                display.textContent = selectedOptions.length > 0 
                    ? 'Selected: ' + selectedOptions.join(', ') 
                    : 'No options selected';
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Update selected sizes and targets on change
                const sizeSelect = document.getElementById('sizeSelect');
                const targetSelect = document.getElementById('targetSelect');

                updateSelectedOptions('sizeSelect', 'selectedSizes');
                updateSelectedOptions('targetSelect', 'selectedTargets');

                sizeSelect.addEventListener('change', function() {
                    updateSelectedOptions('sizeSelect', 'selectedSizes');
                });

                targetSelect.addEventListener('change', function() {
                    updateSelectedOptions('targetSelect', 'selectedTargets');
                });

                // Form submission validation
                const form = document.getElementById('checkoutForm');
                form.addEventListener('submit', function(event) {
                    const sizes = Array.from(sizeSelect.selectedOptions);
                    const targets = Array.from(targetSelect.selectedOptions);

                    let hasError = false;

                    if (sizes.length === 0) {
                        alert('Please select at least one size.');
                        hasError = true;
                    }

                    if (targets.length === 0) {
                        alert('Please select at least one target.');
                        hasError = true;
                    }

                    if (hasError) {
                        event.preventDefault(); // Prevent form submission
                    }
                });
            });
        </script>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Initial subcategories and brands data from PHP
    var subcategories = <?php echo json_encode($subcategories); ?>;
    var brands = <?php echo json_encode($brands); ?>;

    // Function to populate subcategory dropdown
    function updateSubcategories(categoryId) {
        var $subcategorySelect = $('#subcategory_id');
        $subcategorySelect.empty(); // Clear existing options
        $subcategorySelect.append('<option value="">Select SubCategory</option>');

        // Filter subcategories based on selected category
        var filteredSubcategories = subcategories.filter(function(subcategory) {
            return subcategory.category_id == categoryId;
        });

        // Populate dropdown with filtered subcategories
        $.each(filteredSubcategories, function(index, subcategory) {
            $subcategorySelect.append(
                $('<option>', {
                    value: subcategory.subcategory_id,
                    text: subcategory.subcategory_name
                })
            );
        });
    }

    // Function to populate brand dropdown
    function updateBrands(categoryId) {
        var $brandSelect = $('#brand');
        $brandSelect.empty(); // Clear existing options
        $brandSelect.append('<option value="">Select Brand</option>');

        // Filter brands based on selected category
        var filteredBrands = brands.filter(function(brand) {
            return brand.category_id == categoryId;
        });

        // Populate dropdown with filtered brands
        $.each(filteredBrands, function(index, brand) {
            $brandSelect.append(
                $('<option>', {
                    value: brand.brand_id,
                    text: brand.brand_name
                })
            );
        });
    }

    // Event listener for category change
    $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        updateSubcategories(categoryId);
        updateBrands(categoryId); // Added to update brands
    });

    // Initial load (if a category is pre-selected)
    var initialCategoryId = $('#category_id').val();
    if (initialCategoryId) {
        updateSubcategories(initialCategoryId);
        updateBrands(initialCategoryId);
    }
});
</script>

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