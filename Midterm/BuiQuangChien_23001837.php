<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Bài làm Tự luận PHP Cơ bản</title>
</head>
<body>
<?php
// ==================== CÂU 1 ====================
$name = "Bui Quang Chien";
$score = 8.5;

echo "<h2>Câu 1: Kiến thức PHP cơ bản</h2>";

// Kiểm tra tính hợp lệ của dữ liệu đầu vào
if (!is_numeric($score) || $score < 0 || $score > 10) {
    $xepLoai = "Điểm không hợp lệ (Phải là số từ 0 đến 10)";
} else {
    // Ép kiểu về float để so sánh chính xác
    $score = (float)$score;
    if ($score >= 8.0) {
        $xepLoai = "Giỏi";
    } elseif ($score >= 6.5) {
        $xepLoai = "Khá";
    } elseif ($score >= 5.0) {
        $xepLoai = "Trung bình";
    } else {
        $xepLoai = "Yếu";
    }
}

// Chống XSS bằng htmlspecialchars
echo "Tên học sinh: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";
echo "Điểm: " . (is_numeric($score) ? $score : "N/A") . "<br>";
echo "Xếp loại: " . $xepLoai . "<br>";
echo "<hr>";

// ==================== CÂU 2 ====================
$prices = [15000, 45000, 120000, 8000, 62000];

/**
 * Tính tổng giá trị mảng sản phẩm
 */
function calculateTotal(array $arrPrices): float|int {
    $total = 0;
    foreach ($arrPrices as $price) {
        if (is_numeric($price) && $price >= 0) {
            $total += $price;
        }
    }
    return $total;
}

/**
 * Tìm giá sản phẩm lớn nhất
 * Trả về null nếu mảng rỗng hoặc không có phần tử hợp lệ
 */
function findMaxPrice(array $arrPrices): float|int|null {
    if (empty($arrPrices)) {
        return null;
    }

    $maxPrice = null;
    foreach ($arrPrices as $price) {
        if (!is_numeric($price)) {
            continue;
        }
        if ($maxPrice === null || $price > $maxPrice) {
            $maxPrice = $price;
        }
    }
    return $maxPrice;
}

$totalValue = calculateTotal($prices);
$maxValue   = findMaxPrice($prices);

echo "<h2>Câu 2: Xử lý mảng và hàm trong PHP</h2>";

if (empty($prices)) {
    echo "Danh sách sản phẩm trống.<br>";
} else {
    echo "Danh sách giá sản phẩm: " . implode(" đ, ", $prices) . " đ<br>";
    echo "Tổng giá trị của tất cả sản phẩm: " . number_format($totalValue, 0, ",", ".") . " đ<br>";
    echo "Giá sản phẩm cao nhất: " . ($maxValue !== null ? number_format($maxValue, 0, ",", ".") . " đ" : "Không xác định") . "<br>";
}
?>
</body>
</html>
