<?php
// Bài 4: Chuyển sang lập trình hướng đối tượng (OOP)

class Student {
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score) {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank() {
        if ($this->score >= 8) {
            return "Giỏi";
        } elseif ($this->score >= 6.5) {
            return "Khá";
        } elseif ($this->score >= 5) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    public function isPassed() {
        return $this->score >= 5;
    }

    public function display() {
        echo "Họ tên: {$this->name}, Tuổi: {$this->age}, Điểm: {$this->score}, Xếp loại: " . $this->getRank() . "\n";
    }
}

/**
 * Tìm sinh viên có điểm cao nhất.
 * Kiểm tra danh sách rỗng trước khi truy cập $students[0].
 */
function findBestStudentOOP($students) {
    if (empty($students)) {
        return null;
    }

    $best = $students[0];
    foreach ($students as $student) {
        if ($student->score > $best->score) {
            $best = $student;
        }
    }
    return $best;
}

/**
 * Đếm số sinh viên đạt (isPassed = true).
 */
function countPassedStudentsOOP($students) {
    if (empty($students)) {
        return 0;
    }

    $count = 0;
    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }
    return $count;
}

/**
 * Tính điểm trung bình của cả lớp.
 * Kiểm tra count > 0 để tránh lỗi chia cho 0 (Division by zero).
 */
function calculateAverageScoreOOP($students) {
    if (empty($students) || count($students) === 0) {
        return 0;
    }

    $total = 0;
    foreach ($students as $student) {
        $total += $student->score;
    }
    return round($total / count($students), 2);
}

// === PHẦN CODE CHÍNH ===
echo "=== BÀI 4: LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG (OOP) ===\n";

$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$studentObjects = [$student1, $student2, $student3, $student4];

echo "Danh sách sinh viên:\n";
if (empty($studentObjects)) {
    echo "Danh sách rỗng!\n";
} else {
    foreach ($studentObjects as $student) {
        $student->display();
    }
}
echo "\n";

$bestOOP = findBestStudentOOP($studentObjects);
if ($bestOOP !== null) {
    echo "Sinh viên điểm cao nhất: {$bestOOP->name} ({$bestOOP->score})\n";
} else {
    echo "Không có sinh viên điểm cao nhất (danh sách rỗng).\n";
}

echo "Số sinh viên đạt: " . countPassedStudentsOOP($studentObjects) . "\n";
echo "Điểm trung bình của lớp: " . calculateAverageScoreOOP($studentObjects) . "\n\n";

// --- KIỂM THỬ VỚI TRƯỜNG HỢP DANH SÁCH RỖNG ---
echo "--- TEST VỚI DANH SÁCH RỖNG ---\n";
$emptyObjects = [];
$bestEmpty = findBestStudentOOP($emptyObjects);
echo "SV điểm cao nhất (danh sách rỗng): " . ($bestEmpty === null ? "null (Đã xử lý an toàn)" : $bestEmpty->name) . "\n";
echo "Số SV đạt (danh sách rỗng): " . countPassedStudentsOOP($emptyObjects) . "\n";
echo "Điểm TB (danh sách rỗng - tránh chia cho 0): " . calculateAverageScoreOOP($emptyObjects) . "\n";
?>
