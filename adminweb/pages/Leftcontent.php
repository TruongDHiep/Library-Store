<?php

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['current_admin'])) {
    // Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
    header("Location: index.php");
    exit;
}

// Include controller
include 'C:\xampp\htdocs\fahasa\adminweb\controller\ctq_cnController.php';

// Lấy mã quyền của người dùng từ session
$maQuyen = $_SESSION['current_admin']['maQuyen'];

$ctq_cnController = new CTQ_CN_Controller($mysqli);
$ctq_cnData = $ctq_cnController->getCTQ_CNByMaQuyen($maQuyen);

if (empty($ctq_cnData)) {
    echo 'ádasda';
}
?>
            <a class="nav-link" href="admin.php?action=dashboard&query=dashboard" class="logo">
                
                <span class="nav-item-dashboard">Dashboard</span>
            </a> 
        
        <?php
        // Khai báo một mảng để lưu các số đã được kiểm tra
        $checkedNumbers = [];

        // Kiểm tra và thực hiện chỉ một lần cho mỗi số
        foreach ($ctq_cnData as $chucNangItem) {
            $maCN = $chucNangItem['maCN'];

            // Nếu số này đã được kiểm tra, bỏ qua
            if (in_array($maCN, $checkedNumbers)) {
                continue;
            }

            // Thực hiện kiểm tra và xử lý cho số này
            switch ($maCN) {
                case 3:
                    ?>
                    
                    <a class="nav-link" href="admin.php?action=emloyee&query=emloyee">
                    <div class="sb-nav-link-icon">
                    <i class="fas fa-address-book"></i>
                    </div>
                        Nhân viên
                    </a>
                   
                
                <?php
                 break;
                case 2:
                    ?>
                    
                        <a class="nav-link" href="admin.php?action=order&query=order">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-cart-shopping"></i>
                        </div>
                            Đơn hàng
                        </a>
                    
                    <?php
                    break;
                case 6:
                    ?>
                    
                        <a class="nav-link" href="admin.php?action=import&query=import">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-users"></i>
                        </div>
                            Nhập hàng
                        </a>
                    
                    <?php
                    break;
                case 1:
                    ?>
                    
                        <a class="nav-link" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts" >
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-book"></i>
                        </div>
                            Sản phẩm
                        <div class="sb-sidenav-collapse-arrow">
                        <svg class="svg-inline--fa fa-angle-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M169.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 274.7 54.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z">
                        </path>                     
                        </svg>
                         </div>
                        </a>

                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion" style="">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="admin.php?action=product&query=product" >
                                    <span class="submenu-item">Danh sách sản phẩm</span>
                                </a>
                            
                           
                                <a class="nav-link" href="admin.php?action=category&query=category" >
                                    <span class="submenu-item">Loại sản phẩm</span>
                                </a>
                            
                        </div>
                    
                    <?php
                    break;
                case 14:
                    ?>
                    
                        <a class="nav-link" href="admin.php?action=user&query=user">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-face-smile"></i>
                        </div>
                            Tài khoản
                        </a>
                    
                    <?php
                    break;
                case 4:
                    ?>
                    
                        <a class="nav-link" href="admin.php?action=customer&query=customer">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-person"></i>
                        </div>
                            Khách hàng
                        </a>
                    
                    <?php
                    break;
                case 5:
                    ?>
                    
                        <a class="nav-link" href="admin.php?action=suppliers&query=suppliers">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-boxes-packing"></i>
                        </div>
                            Nhà cung cấp
                        </a>
                    
                    <?php
                    break;
                case 7:
                        ?>
                    <a class="nav-link" href="admin.php?action=roles&query=roles">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    Phân quyền
                    </a>
                    <?php
                    break;
            }

            // Thêm số này vào mảng đã kiểm tra
            $checkedNumbers[] = $maCN;
        }
        ?>
        <!-- Chức năng logout -->
        
           
              
        <a id="logout" class="nav-link" href="#" class="logout" name="logout">
    <div class="sb-nav-link-icon">
        <i class="fas fa-sign-out-alt"></i>
    </div>
    Logout
</a>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var logoutButton = document.getElementById('logout');
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ 'a'

            var confirmation = confirm('Bạn có muốn đăng xuất?');
            if (confirmation) {
                window.location.href = '../adminweb/logout.php';
            } else {
                // Không làm gì nếu người dùng không xác nhận
            }
        });
    });
</script>
 
   

