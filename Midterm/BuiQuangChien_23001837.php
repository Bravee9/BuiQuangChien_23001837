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

if ($score >= 8) {
    $xepLoai = "Giỏi";
} elseif ($score >= 6.5) {
    $xepLoai = "Khá";
} elseif ($score >= 5) {
    $xepLoai = "Trung bình";
} else {
    $xepLoai = "Yếu";
}

echo "<h2>Câu 1: Kiến thức PHP cơ bản</h2>";
echo "Tên học sinh: " . $name . "<br>";
echo "Điểm: " . $score . "<br>";
echo "Xếp loại: " . $xepLoai . "<br>";
echo "<hr>";

// ==================== CÂU 2 ====================
$prices = [15000, 45000, 120000, 8000, 62000];

function calculateTotal($arrPrices) {
    $total = 0;
    foreach ($arrPrices as $price) {
        $total += $price;
    }
    return $total;
}

function findMaxPrice($arrPrices) {
    if (empty($arrPrices)) {
        return 0;
    }
    $maxPrice = $arrPrices[0];
    foreach ($arrPrices as $price) {
        if ($price > $maxPrice) {
            $maxPrice = $price;
        }
    }
    return $maxPrice;
}

$totalValue = calculateTotal($prices);
$maxValue   = findMaxPrice($prices);

echo "<h2>Câu 2: Xử lý mảng và hàm trong PHP</h2>";
echo "Danh sách giá sản phẩm: " . implode(" đ, ", $prices) . " đ<br>";
echo "Tổng giá trị của tất cả sản phẩm: " . number_format($totalValue, 0, ",", ".") . " đ<br>";
echo "Giá sản phẩm cao nhất: " . number_format($maxValue, 0, ",", ".") . " đ<br>";
?>
</body>
</html>