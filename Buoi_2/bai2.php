<?php
class Movie {
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    public function __construct($id, $title, $price, $totalSeats) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTicket($quantity) {
        if ($quantity <= 0) {
            echo "Lỗi: Số lượng vé đặt cho phim '{$this->title}' phải lớn hơn 0.\n";
            return false;
        }
        if ($quantity > $this->availableSeats) {
            echo "Lỗi: Không thể đặt {$quantity} vé cho phim '{$this->title}'. Chỉ còn {$this->availableSeats} ghế trống.\n";
            return false;
        }
        $this->availableSeats -= $quantity;
        echo "Thành công: Đã đặt {$quantity} vé cho phim '{$this->title}'.\n";
        return true;
    }

    public function cancelTicket($quantity) {
        if ($quantity <= 0) {
            echo "Lỗi: Số lượng vé hủy cho phim '{$this->title}' phải lớn hơn 0.\n";
            return false;
        }
        $soldSeats = $this->getSoldSeats();
        if ($quantity > $soldSeats) {
            echo "Lỗi: Không thể hủy {$quantity} vé cho phim '{$this->title}'. Số vé đã bán chỉ là {$soldSeats}.\n";
            return false;
        }
        $this->availableSeats += $quantity;
        echo "Thành công: Đã hủy {$quantity} vé cho phim '{$this->title}'.\n";
        return true;
    }

    public function getSoldSeats() {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue() {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo() {
        echo "Mã: {$this->id} | Tên phim: {$this->title} | Giá vé: {$this->price} | Tổng ghế: {$this->totalSeats} | Ghế còn trống: {$this->availableSeats} | Đã bán: {$this->getSoldSeats()} | Doanh thu: " . $this->getRevenue() . "\n";
    }
}

// 3. Các function xử lý danh sách phim
function findMovieById($movies, $id) {
    if (empty($movies)) return null;
    foreach ($movies as $movie) {
        if ($movie->id === $id) {
            return $movie;
        }
    }
    return null;
}

function getTotalRevenue($movies) {
    if (empty($movies)) return 0;
    $total = 0;
    foreach ($movies as $movie) {
        $total += $movie->getRevenue();
    }
    return $total;
}

function getBestSellingMovie($movies) {
    if (empty($movies)) return null;
    $bestMovie = $movies[0];
    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestMovie->getSoldSeats()) {
            $bestMovie = $movie;
        }
    }
    return $bestMovie;
}

// 5. Yêu cầu thực hiện
// 1. Tạo danh sách các object Movie.
$movie1 = new Movie(1, "Avengers", 100000, 100);
$movie2 = new Movie(2, "Avatar", 120000, 80);
$movie3 = new Movie(3, "Batman", 90000, 120);

$movies = [$movie1, $movie2, $movie3];

// 2. Đặt vé cho phim Avengers.
echo "--- THỰC HIỆN ĐẶT/HỦY VÉ ---\n";
$movie1->bookTicket(10);
// Test trường hợp lỗi
$movie1->bookTicket(-5);
$movie1->bookTicket(150);

// 3. Đặt vé cho phim Avatar.
$movie2->bookTicket(20);

// 4. Hủy một số vé đã đặt của phim Avengers.
$movie1->cancelTicket(2);
// Test trường hợp lỗi
$movie1->cancelTicket(0);
$movie1->cancelTicket(20);

echo "\n--- DANH SÁCH PHIM ---\n";
// 5. Hiển thị thông tin của tất cả các phim.
foreach ($movies as $movie) {
    $movie->displayInfo();
}

// 6. Tính tổng doanh thu của tất cả các phim.
echo "\nTổng doanh thu của tất cả các phim: " . getTotalRevenue($movies) . "\n";

// 7. Tìm và hiển thị phim có số vé bán ra nhiều nhất.
$bestSelling = getBestSellingMovie($movies);
if ($bestSelling) {
    echo "Phim bán chạy nhất là: {$bestSelling->title} với {$bestSelling->getSoldSeats()} vé đã bán.\n";
}

// Test trường hợp danh sách rỗng
echo "\n--- TEST DANH SÁCH RỖNG ---\n";
$emptyList = [];
echo "Doanh thu danh sách rỗng: " . getTotalRevenue($emptyList) . "\n";
$bestEmpty = getBestSellingMovie($emptyList);
if ($bestEmpty === null) echo "Không có phim bán chạy nhất vì danh sách rỗng.\n";

// Test tìm phim
echo "\n--- TEST TÌM PHIM ---\n";
$found = findMovieById($movies, 2);
if ($found) {
    echo "Tìm thấy phim ID 2: {$found->title}\n";
}
$notFound = findMovieById($movies, 99);
if (!$notFound) {
    echo "Không tìm thấy phim ID 99.\n";
}
?>
