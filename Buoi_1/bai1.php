<?php
// Bài 1: Làm quen với biến, mảng và vòng lặp
$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

echo "=== BÀI 1: THÔNG TIN TẤT CẢ SINH VIÊN ===\n";

// Kiểm tra danh sách rỗng trước khi xử lý
if (empty($students)) {
    echo "Danh sách sinh viên rỗng!\n";
} else {
    $totalScore = 0;
    foreach ($students as $student) {
        echo "Họ tên: " . $student['name'] . ", Tuổi: " . $student['age'] . ", Điểm: " . $student['score'] . "\n";
        $totalScore += $student['score'];
    }

    $count = count($students);
    // Kiểm tra điều kiện count > 0 để tránh lỗi chia cho 0 (Division by zero)
    if ($count > 0) {
        $averageScore = $totalScore / $count;
        echo "=> Điểm trung bình của tất cả sinh viên: " . round($averageScore, 2) . "\n\n";
    } else {
        echo "=> Danh sách không có sinh viên để tính điểm trung bình.\n\n";
    }
}
?>
