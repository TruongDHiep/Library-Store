<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sách</title>
    <link rel="stylesheet" href="style.css">

    <style>
    html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .main {
        /* width: 100%; */
        margin: 10px auto;
    }

    .main_product {
        margin: 0 auto;
        width: 1230px;
        display: flex;
        padding-top: 10px;

    }

    .categorytab {
        padding: 30px 0;

    }

    @media (min-width: 1310px) {
        .container {
            max-width: 1290px;
        }
    }

    .container {

        width: 100%;
        padding: 0 10px;

    }

    .title-border {
        border-top: solid 2px green;
        margin-bottom: 35px;
        display: flex;
        justify-content: space-between;
    }


    .sort-select {
        margin-bottom: 20px;
    }

    /* #product-box {
        width: 1230px;
    } */
    #product-box{
        padding-top: 10px;
        width: 70%;
        background-color: #fff;

    }
    .grid-products {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        /* Hiển thị 4 cột */
        gap: 5px;
        /* width: 1230px; */
    }

    .grid-item {
        position: relative;
        border: 1px solid #C2C2C2;
        padding: 10px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 330px;
        background-color: white;
    }

    .grid-item:hover {
        transform: scale(1.05);
        /* Phóng to khi di chuột vào */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Đổ bóng */
    }

    .book-image {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
    }

    .book-title {
        font-weight: bold;
        margin-top: 10px;
    }

    .book-price {
        color: green;
        font-size: 1.2em;
        margin-top: 5px;
    }

    .book-rating {
        color: gold;
        margin-top: 5px;
    }

    .old-price {
        color: grey;
        text-decoration: line-through;
    }

    .discount-percent {
        position: absolute;
        top: 0;
        right: 0;
        background-color: red;
        padding: 5px;
        font-weight: bold;
        color: white;
    }

    #pagination {
        margin: 20px auto;
        text-align: center;
    }

    #pagination a {
        display: inline-block;
        padding: 6px 12px;
        text-decoration: none;
        color: #000;
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 5px;
        cursor: pointer;

    }

    #pagination a.active {
        background-color: #4CAF50;
        color: white;
        cursor: default;
    }

    #pagination a:hover:not(.active) {
        background-color: #ddd;
    }
    .sort-select-box{
        /* display: flex; */
        /* justify-content: space-between; */
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: 40px;
    }
    #sort-select{
        width: 200px;
        height: 35px;
        padding: 5px;
    }
    #sort-select-box label{
        font-size: 1.3em;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="main">
        <div class="main_product">
            <?php
                require_once '../cuahangsach/sidebar.php';
            ?>
            <div id="product-box">
                <div class="sort-select-box">
                    <label for="sort-select">Sắp xếp theo:</label>
                    <select id="sort-select">
                        <option value="">Mặc định</option>
                        <option value="low-to-high">Giá từ thấp đến cao</option>
                        <option value="high-to-low">Giá từ cao đến thấp</option>
                    </select>
                </div>
                <div class="grid-products">
                </div>

                <div id="pagination">
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
</script>
<script>
$('#sort-select').change(function() {
    loadProduct(1);
});

function loadProduct(page) {
    $.ajax({
        url: 'loadProduct.php',
        type: 'GET',
        data: {
            sort: $('#sort-select').val(),
            theloai: '<?= $_GET['theloai'] ?>',
            // price: $('input[name="price"]:checked').val(),
            page: page
        },
        success: function(response) {
            $data = JSON.parse(response);
            $total_pages = $data.total_pages;
            $result_products = $data.products;
            console.log($result_products);

            var grid_products = $('.grid-products');
            grid_products.empty();
            $result_products.forEach(function(sach) {
                if (sach.khuyenMai > 0) {
                    $giaMoi = sach.giaXuat * (1 - sach.khuyenMai / 100);
                    $discount_percent = '<div class="discount-percent">' + sach.khuyenMai +
                        '%</div>';
                    $book_price = '<p class="book-price">' + $giaMoi + ' VNĐ</p>';
                    $old_price = '<p class="old-price">' + sach.giaXuat + ' VNĐ</p>';
                } else {
                    $discount_percent = '';
                    $book_price = '<p class="book-price">' + sach.giaXuat + ' VNĐ</p>';
                    $old_price = '';
                }
                if (sach.hinhAnh == null) {
                    sach.hinhAnh = 'https://via.placeholder.com/150';
                }
                $product_item = '<div class="grid-item">' + $discount_percent + '<img src="' + sach
                    .hinhAnh + '" class="book-image" alt="' + sach.tenSach + '">' +
                    '<p class="book-title">' + sach.tenSach + '</p>' + $book_price + $old_price +
                    '</div>';

                grid_products.append($product_item);
            });

            var pagination = $('#pagination');
            pagination.empty();
            for (var i = 1; i <= $total_pages; i++) {
                var button = $('<a onclick="loadProduct(' + i + ')">' + i + '</a>');
                if (i === page) {
                    button.addClass('active');
                }
                pagination.append(button);
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}
$(document).ready(function() {
    loadProduct(1);
});
</script>

</html>