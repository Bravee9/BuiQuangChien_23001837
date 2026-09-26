<?php
// Bài 3: Xử lý danh sách sinh viên

$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];

/**
 * Tìm và trả về sinh viên có điểm cao nhất.
 * Kiểm tra danh sách rỗng trước khi truy cập $students[0].
 */
function findBestStudent($students) {
    if (empty($students)) {
        return null;
    }

    $bestStudent = $students[0];
    foreach ($students as $student) {
        if ($student['score'] > $bestStudent['score']) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;
}

/**
 * Tìm và trả về sinh viên có điểm thấp nhất.
 * Kiểm tra danh sách rỗng trước khi truy cập $students[0].
 */
function findWorstStudent($students) {
    if (empty($students)) {
        return null;
    }

    $worstStudent = $students[0];
    foreach ($students as $student) {
        if ($student['score'] < $worstStudent['score']) {
            $worstStudent = $student;
        }
    }
    return $worstStudent;
}

/**
 * Đếm số sinh viên đạt (Điểm >= 5).
 */
function countPassedStudents($students) {
    if (empty($students)) {
        return 0;
    }

    $count = 0;
    foreach ($students as $student) {
        if ($student['score'] >= 5) {
            $count++;
        }
    }
    return $count;
}

/**
 * Tìm sinh viên theo tên và trả về sinh viên tìm được.
 */
function findStudentByName($students, $name) {
    if (empty($students)) {
        return null;
    }

    foreach ($students as $student) {
        if ($student['name'] === $name) {
            return $student;
        }
    }
    return null;
}

// === PHẦN CODE CHÍNH ===
echo "=== BÀI 3: XỬ LÝ DANH SÁCH SINH VIÊN ===\n";

$best = findBestStudent($students);
if ($best !== null) {
    echo "Sinh viên điểm cao nhất: {$best['name']} ({$best['score']})\n";
} else {
    echo "Danh sách rỗng, không tìm thấy sinh viên có điểm cao nhất.\n";
}

$worst = findWorstStudent($students);
if ($worst !== null) {
    echo "Sinh viên điểm thấp nhất: {$worst['name']} ({$worst['score']})\n";
} else {
    echo "Danh sách rỗng, không tìm thấy sinh viên có điểm thấp nhất.\n";
}

echo "Số sinh viên đạt: " . countPassedStudents($students) . "\n";

$searchName = "Le Van Cuong";
$found = findStudentByName($students, $searchName);
if ($found !== null) {
    echo "Tìm thấy sinh viên: Họ tên: {$found['name']}, Tuổi: {$found['age']}, Điểm: {$found['score']}\n";
} else {
    echo "Không tìm thấy sinh viên tên '{$searchName}'\n";
}
echo "\n";

// --- KIỂM THỬ VỚI TRƯỜNG HỢP DANH SÁCH RỖNG ---
echo "--- TEST VỚI DANH SÁCH RỖNG ---\n";
$emptyList = [];
$bestEmpty = findBestStudent($emptyList);
echo "Tìm SV cao nhất (danh sách rỗng): " . ($bestEmpty === null ? "null (Đã xử lý an toàn)" : $bestEmpty['name']) . "\n";

$worstEmpty = findWorstStudent($emptyList);
echo "Tìm SV thấp nhất (danh sách rỗng): " . ($worstEmpty === null ? "null (Đã xử lý an toàn)" : $worstEmpty['name']) . "\n";

echo "Số SV đạt (danh sách rỗng): " . countPassedStudents($emptyList) . "\n";

$foundEmpty = findStudentByName($emptyList, "Nguyen Van An");
echo "Tìm SV theo tên (danh sách rỗng): " . ($foundEmpty === null ? "null (Đã xử lý an toàn)" : "Tìm thấy") . "\n\n";
?>
