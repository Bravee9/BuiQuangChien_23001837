<?php
// Bài 4
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
        echo "Họ tên: " . $this->name . ", Tuổi: " . $this->age . ", Điểm: " . $this->score . ", Xếp loại: " . $this->getRank() . "\n";
    }
}

echo "Bài 4. Lập trình hướng đối tượng (OOP):\n";
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$studentObjects = [$student1, $student2, $student3, $student4];

echo "Danh sách sinh viên:\n";
foreach ($studentObjects as $student) {
    $student->display();
}
echo "\n";

function findBestStudentOOP($students) {
    $best = $students[0];
    foreach ($students as $student) {
        if ($student->score > $best->score) {
            $best = $student;
        }
    }
    return $best;
}

$bestOOP = findBestStudentOOP($studentObjects);
echo "Sinh viên điểm cao nhất: " . $bestOOP->name . " (" . $bestOOP->score . ")\n";

function countPassedStudentsOOP($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }
    return $count;
}

echo "Số sinh viên đạt: " . countPassedStudentsOOP($studentObjects) . "\n";

function calculateAverageScoreOOP($students) {
    $total = 0;
    foreach ($students as $student) {
        $total += $student->score;
    }
    return $total / count($students);
}

echo "Điểm trung bình của lớp: " . calculateAverageScoreOOP($studentObjects) . "\n";
?>
