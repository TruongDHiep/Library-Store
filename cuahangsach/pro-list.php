<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sách</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
    </script>

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
        #product-box {
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
            width: 200px;
            height: 200px;
            max-height: 200px;
            object-fit: cover;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-title {
            min-height: 40px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .book-price {
            height: 10px;
            color: #C92127;
            font-size: 1.2em;
            margin-top: 5px;
        }

        .book-rating {
            height: 10px;
            color: gold;
            margin-top: 5px;
        }

        .old-price {
            color: grey;
            text-decoration: line-through;
        }

        .discount-percent {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #C92127;
            padding: 5px;
            font-weight: bold;
            font-size: 15px;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            align-content: center;
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
            background-color: #C92127;
            color: white;
            cursor: default;
        }

        #pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .sort-select-box {
            /* display: flex; */
            /* justify-content: space-between; */
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 40px;
        }

        #sort-select {
            width: 200px;
            height: 35px;
            padding: 5px;
        }

        #sort-select-box label {
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

<script>
    function loadProduct(page) {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const theloai = params.get('theloai');
        var timkiem = '<?php echo isset($_GET['timkiem']) ? $_GET['timkiem'] : '' ?>';
        var price = $('.checkprice:checked').map(function() {
            return this.id;
        }).get().join(',');
        $.ajax({
            url: 'loadProduct.php',
            type: 'GET',
            data: {
                sort: $('#sort-select').val(),
                theloai: theloai,
                price: price,
                page: page,
                timkiem: timkiem
            },
            success: function(response) {
                var data = JSON.parse(response);
                var total_pages = data.total_pages;
                var result_products = data.products;

                if (result_products.length === 0) {
                    $('.grid-products').html(
                        '<p style="margin:10px;">Không tìm thấy sản phẩm nào</p>');
                    return;
                } else {
                    var grid_products = $('.grid-products');
                    grid_products.empty();

                    result_products.forEach(function(sach) {
                        var discount_percent = '';
                        var book_price = '<p class="book-price">' + sach.giaXuat +
                            ' VNĐ</p>';
                        var old_price = '';

                        if (sach.khuyenMai > 0) {
                            var giaMoi = sach.giaXuat * (1 - sach.khuyenMai / 100);
                            discount_percent = '<div class="discount-percent">' + sach
                                .khuyenMai + '%</div>';
                            book_price = '<p class="book-price">' + giaMoi + ' VNĐ</p>';
                            old_price = '<p class="old-price">' + sach.giaXuat + ' VNĐ</p>';
                        }

                        if (sach.hinhAnh == null) {
                            sach.hinhAnh = 'https://via.placeholder.com/150';
                        }
                        var product_item =
                            '<div class="grid-item"><a href="../cuahangsach/product.php?id=' + sach.maSach + '" style="text-decoration: none; color: black;">' +
                            discount_percent + '<img src="../adminweb/img/' +
                            sach.maHinh + '" class="book-image"  alt="' + sach.tenSach + '">' +
                            '<p class="book-title" style="margin: 0px;">' + sach.tenSach + '</p>' +
                            book_price +
                            old_price +
                            '</a></div>';
                        grid_products.append(product_item);
                    });

                    var pagination = $('#pagination');
                    pagination.empty();

                    for (var i = 1; i <= total_pages; i++) {
                        var button = $('<a onclick="loadProduct(' + i + ')">' + i + '</a>');

                        if (i === page) {
                            button.addClass('active');
                        }

                        pagination.append(button);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    $('.a-danhmuc').click(function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a

        const filterValue = $(this).data('theloai'); // Lấy giá trị của bộ lọc từ thuộc tính data-value của thẻ a

        updateTheloaiFilter(filterValue); // Gọi hàm để cập nhật bộ lọc 'theloai' với giá trị mới
        loadProduct(1);
    });

    // Hàm để cập nhật bộ lọc 'theloai' trong URL
    function updateTheloaiFilter(filterValue) {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);

        // Thay đổi giá trị của bộ lọc 'theloai'
        params.set('theloai', filterValue);

        const newUrl = `${url.origin}${url.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newUrl);

    }
    $('.checkprice').change(function() {
        loadProduct(1);
    });
    $('#sort-select').change(function() {
        loadProduct(1);
    });

    $(document).ready(function() {
        loadProduct(1);
    });
</script>

</html>