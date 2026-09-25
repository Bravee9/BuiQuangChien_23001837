<?php
class CartItem {
    public $name;
    public $price;
    public $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal() {
        return $this->price * $this->quantity;
    }
}

class ShoppingCart {
    public $items = [];

    public function addItem($item) {
        if ($item->price <= 0) {
            echo "Lỗi: Không thể thêm sản phẩm '{$item->name}' vì giá ({$item->price}) <= 0.\n";
            return;
        }
        if ($item->quantity <= 0) {
            echo "Lỗi: Không thể thêm sản phẩm '{$item->name}' vì số lượng ({$item->quantity}) <= 0.\n";
            return;
        }
        $this->items[] = $item;
        echo "Đã thêm sản phẩm '{$item->name}' vào giỏ hàng.\n";
    }

    public function removeItem($name) {
        $found = false;
        foreach ($this->items as $index => $item) {
            if ($item->name === $name) {
                unset($this->items[$index]);
                $this->items = array_values($this->items); // Reindex array
                $found = true;
                echo "Đã xóa sản phẩm '{$name}' khỏi giỏ hàng.\n";
                break;
            }
        }
        if (!$found) {
            echo "Lỗi: Không tìm thấy sản phẩm '{$name}' để xóa.\n";
        }
    }

    public function calculateTotal() {
        $total = 0;
        if (empty($this->items)) {
            return $total;
        }
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart() {
        echo "\n--- THÔNG TIN GIỎ HÀNG ---\n";
        if (empty($this->items)) {
            echo "Giỏ hàng đang trống.\n";
            return;
        }
        foreach ($this->items as $item) {
            echo "- {$item->name} | Đơn giá: {$item->price} | Số lượng: {$item->quantity} | Thành tiền: " . $item->getTotal() . "\n";
        }
        echo "=> TỔNG TIỀN: " . $this->calculateTotal() . "\n";
        echo "--------------------------\n\n";
    }
}

// 3. Dữ liệu và yêu cầu thực hiện
// 1. Tạo một object ShoppingCart.
$cart = new ShoppingCart();

// 2. Tạo ít nhất 04 object CartItem.
$item1 = new CartItem("Laptop Dell", 15000000, 1);
$item2 = new CartItem("Chuột không dây", 250000, 2);
$item3 = new CartItem("Bàn phím cơ", 800000, 1);
$item4 = new CartItem("Tai nghe Bluetooth", 500000, 3);
// Sản phẩm test lỗi
$itemInvalidPrice = new CartItem("Sản phẩm lỗi giá", -100, 1);
$itemInvalidQty = new CartItem("Sản phẩm lỗi số lượng", 1000, 0);

// 3. Thêm các sản phẩm vào giỏ hàng bằng method addItem().
echo "--- THÊM SẢN PHẨM ---\n";
$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);
$cart->addItem($itemInvalidPrice);
$cart->addItem($itemInvalidQty);

// 4. Hiển thị toàn bộ giỏ hàng.
$cart->displayCart();

// 5. Tính và hiển thị tổng tiền của giỏ hàng. (Đã hiển thị trong displayCart nhưng in riêng theo yêu cầu)
echo "Tổng tiền của giỏ hàng tính riêng là: " . $cart->calculateTotal() . "\n\n";

// 6. Xóa một sản phẩm theo tên bằng method removeItem().
echo "--- XÓA SẢN PHẨM ---\n";
$cart->removeItem("Bàn phím cơ");
$cart->removeItem("Sản phẩm không tồn tại"); // Test trường hợp không tồn tại

// 7. Hiển thị lại giỏ hàng sau khi xóa.
$cart->displayCart();

?>
