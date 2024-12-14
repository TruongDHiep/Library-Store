
<?php
// Trong file admin.php

session_start();
if (empty($_SESSION['current_admin'])) {
    // Nếu không có người dùng đăng nhập, bạn có thể chuyển hướng hoặc hiển thị thông báo lỗi
    header("Location: index.php");
    exit;
}

// Lấy thông tin người dùng từ session
$currentUser = $_SESSION['current_admin'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminweb</title>
    <link rel="stylesheet" href="css/styleadmin.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="script/lelf_content.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="sb-nav-fixed">
    <?php include_once "./config/config.php"; ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" >Admin web</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><svg class="svg-inline--fa fa-bars" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"></path></svg><!-- <i class="fas fa-bars"></i> Font Awesome fontawesome.com --></button>
            
            <!-- Navbar-->
            
        </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
               <div class="nav">
                     <?php include("./pages/leftcontent.php"); ?>
                </div>
            </div>
        </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
            <?php
              
            if (isset($_GET['action']) && $_GET['query']) {
                $action = $_GET['action'];
                $query = $_GET['query'];
            } else {
                $action = '';
                $query = '';
                include './pages/Dashboard.php';
            }
            if ($action == 'dashboard' && $query == 'dashboard')
                include './pages/Dashboard.php';

            elseif ($action == 'order' && $query == 'order')
                include './pages/Orders.php';
            elseif ($action == 'details' && $query== 'details')
                include './pages/DetailsOrder.php';

            elseif ($action == 'user' && $query == 'user')
                include './pages/User.php';
            elseif ($action == 'user' && $query== 'user_edit')
                include './pages/form/user/edit_User.php';
            elseif ($action == 'user' && $query== 'user_add')
                include './pages/form/user/add_user_form.php';

            elseif ($action == 'suppliers' && $query == 'suppliers')
                include './pages/Suppliers.php';

            elseif ($action == 'suppliers' && $query == 'suppliers_add')
            include './pages/form/suppliers/add_suppliers_form.php';

            elseif ($action == 'customer' && $query == 'customer')
                include './pages/Customers.php';
            elseif ($action == 'customer' && $query == 'customer_edit')
                include './pages/form/customer/edit_customer.php';

            elseif ($action == 'product' && $query == 'product')
                include './pages/Product.php';

            elseif ($action == 'product' && $query == 'product_add')
                include './pages/form/product/add_product_form.php';
            elseif ($action == 'product' && $query == 'product_edit')
                include './pages/form/product/edit_product.php';

            elseif ($action == 'category' && $query == 'category')
                include './pages/category.php';

            elseif ($action == 'category' && $query == 'category_add')
                include './pages/form/category/add_category_form.php';

            elseif ($action == 'category' && $query == 'category_edit')
                include './pages/form/category/edit_cate.php';


            elseif ($action == 'order' && $query== 'order_edit' )
                include './pages/form/order/edit_oder.php';

            elseif ($action == 'supplier' && $query== 'supplier_edit')
                include './pages/form/suppliers/edit_supplier.php';



            elseif ($action == 'roles' && $query== 'roles')
                include './pages/Role.php';
            elseif ($action == 'roles' && $query== 'roles_add')
                include './pages/form/role/add_role_form.php';
            elseif ($action == 'roles' && $query== 'edit_role')
                include './pages/form/role/edit_role.php';

            elseif ($action == 'import' && $query == 'import')
                include './pages/Import.php';

            elseif ($action == 'import' && $query == 'import_add')
                include './pages/form/import/add_import_form.php';

            elseif ($action == 'Import' && $query == 'Import_edit')
                include './pages/form/import/edit_import.php';

            elseif ($action == 'details_import' && $query == 'details_import')
                include './pages/Details_import.php';

                elseif ($action == 'emloyee' && $query== 'emloyee')
                include './pages/Emloyee.php';

            elseif ($action == 'emloyee' && $query== 'emloyee_edit')
                include './pages/form/emloyee/edit_emloyee.php';

            elseif ($action == 'emloyee' && $query == 'emloyee_add')
                include './pages/form/emloyee/add_emloyee_form.php';

                /*-------thống kê------*/

            elseif ($action == 'static' && $query == 'static')
                include './pages/static.php';
            ?>
            <footer class="py-4 bg-light mt-auto" >
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"> Web admin nhom 17</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                ·
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    <script src="script/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>



</html>