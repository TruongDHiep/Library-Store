<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    if ($productId === false || $quantity === false || $productId <= 0 || $quantity <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['maSach'] == $productId) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        require_once('Helper.php');
        $conn = new Helper();
        $stmt = "SELECT * FROM sach JOIN hinhanh ON sach.maSach = hinhanh.maSach WHERE sach.maSach = ?";
        $product = $conn->fetchOne($stmt, [$productId]);

        if ($product) {
            $newItem = [
                'maSach' => $product['maSach'],
                'tenSach' => $product['tenSach'],
                'giaXuat' => $product['giaXuat'],
                'khuyenMai' => $product['khuyenMai'],
                'hinhanh' => $product['maHinh'],
                'quantity' => $quantity
            ];
            $_SESSION['cart'][] = $newItem;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            exit();
        }
    }

    echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}
