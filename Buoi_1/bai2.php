<?php
// Bài 2: Tách hàm xử lý sinh viên

$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];

/**
 * 1. Tính và trả về điểm trung bình của danh sách sinh viên.
 * Kiểm tra danh sách rỗng để tránh lỗi chia cho 0.
 */
function calculateAverageScore($students) {
    if (empty($students) || count($students) === 0) {
        return 0;
    }

    $totalScore = 0;
    foreach ($students as $student) {
        $totalScore += $student['score'];
    }

    return round($totalScore / count($students), 2);
}

/**
 * 2. Trả về xếp loại của sinh viên theo quy tắc:
 * - Điểm >= 8: Giỏi
 * - Điểm >= 6.5: Khá
 * - Điểm >= 5: Trung bình
 * - Điểm < 5: Yếu
 */
function getRank($score) {
    if ($score >= 8) {
        return "Giỏi";
    } elseif ($score >= 6.5) {
        return "Khá";
    } elseif ($score >= 5) {
        return "Trung bình";
    } else {
        return "Yếu";
    }
}

/**
 * 3. Hiển thị thông tin một sinh viên, bao gồm cả xếp loại.
 */
function displayStudent($student) {
    if (empty($student)) {
        echo "Dữ liệu sinh viên không hợp lệ!\n";
        return;
    }
    $rank = getRank($student['score']);
    echo "Họ tên: {$student['name']}, Tuổi: {$student['age']}, Điểm: {$student['score']}, Xếp loại: {$rank}\n";
}

// === PHẦN CODE CHÍNH ===
echo "=== BÀI 2: HIỂN THỊ THÔNG TIN SINH VIÊN BẰNG HÀM ===\n";

if (empty($students)) {
    echo "Danh sách sinh viên rỗng!\n";
} else {
    foreach ($students as $student) {
        displayStudent($student);
    }
    echo "=> Điểm trung bình (dùng hàm): " . calculateAverageScore($students) . "\n\n";
}

// Thử nghiệm trường hợp danh sách rỗng để đảm bảo không lỗi chia cho 0
echo "--- TEST VỚI DANH SÁCH RỖNG ---\n";
$emptyStudents = [];
echo "Điểm trung bình danh sách rỗng: " . calculateAverageScore($emptyStudents) . "\n\n";
?>
