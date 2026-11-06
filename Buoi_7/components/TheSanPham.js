/**
 * Component <the-san-pham>
 * Bài 2: Danh mục sản phẩm bằng component
 * Sinh viên thực hiện: Bùi Quang Chiến - MSV: 23001837 - Lớp: K68A3
 * 
 * Yêu cầu tuân thủ:
 * 1. Nhận các prop: tên, giá, ảnh, mô tả và số lượng tồn.
 * 2. Khai báo kiểu dữ liệu cho từng prop, có ít nhất một prop bắt buộc (ten, gia)
 *    và có prop có giá trị mặc định (anh, moTa, soLuongTon).
 * 3. Trạng thái bật/tắt mô tả lưu trong data() riêng biệt của từng component.
 * 4. Sản phẩm hết hàng có nhãn riêng và khóa nút "Mua".
 */

const TheSanPham = {
  name: 'TheSanPham',
  props: {
    // 3. Khai báo kiểu dữ liệu cho từng prop
    // Prop bắt buộc: 'ten'
    ten: {
      type: String,
      required: true
    },
    // Prop bắt buộc: 'gia'
    gia: {
      type: Number,
      required: true,
      validator(value) {
        return value >= 0;
      }
    },
    // Prop có giá trị mặc định: 'anh'
    anh: {
      type: String,
      default: 'assets/images/default-product.svg'
    },
    // Prop có giá trị mặc định: 'moTa'
    moTa: {
      type: String,
      default: 'Thông tin mô tả chi tiết của sản phẩm đang được cập nhật.'
    },
    // Prop có giá trị mặc định: 'soLuongTon'
    soLuongTon: {
      type: Number,
      default: 0,
      validator(value) {
        return Number.isInteger(value) && value >= 0;
      }
    }
  },

  // 5. Mỗi thẻ có nút “Xem mô tả” để bật/tắt phần mô tả. Trạng thái này lưu trong data() riêng của từng component.
  data() {
    return {
      hienThiMoTa: false
    };
  },

  computed: {
    // 7. Sản phẩm hết hàng
    isOutOfStock() {
      return this.soLuongTon <= 0;
    }
  },

  methods: {
    toggleMoTa() {
      // 6. Khi mở mô tả của một sản phẩm, các sản phẩm khác không bị ảnh hưởng vì state nằm trong data() riêng
      this.hienThiMoTa = !this.hienThiMoTa;
    },

    formatCurrency(value) {
      if (typeof value !== 'number' || isNaN(value)) return '0 đ';
      return value.toLocaleString('vi-VN') + ' đ';
    },

    handleBuy() {
      if (this.isOutOfStock) return;
      alert(`Đã thêm "${this.ten}" vào giỏ hàng với giá ${this.formatCurrency(this.gia)}!`);
    }
  },

  template: `
    <div class="product-card-item" :class="{ 'is-out-of-stock': isOutOfStock }">
      <!-- Vùng ảnh đại diện sản phẩm -->
      <div class="product-thumb-container">
        <img 
          :src="anh" 
          :alt="ten" 
          class="product-thumb-img"
          loading="lazy"
        />

        <!-- 7. Sản phẩm hết hàng có nhãn riêng -->
        <div class="product-stock-tag">
          <span v-if="isOutOfStock" class="badge-stock badge-out-of-stock">
            ✕ Hết hàng
          </span>
          <span v-else class="badge-stock badge-in-stock">
            ✓ Còn {{ soLuongTon }} sản phẩm
          </span>
        </div>
      </div>

      <!-- Vùng thông tin chi tiết -->
      <div class="product-details">
        <h3 class="product-name-title">{{ ten }}</h3>
        <div class="product-price-display">{{ formatCurrency(gia) }}</div>

        <!-- 5 & 6. Bật/tắt phần mô tả, trạng thái lưu riêng trong data() từng thẻ -->
        <div v-show="hienThiMoTa" class="product-desc-box">
          <strong style="color: var(--info); display: block; margin-bottom: 4px;">📝 Chi tiết mô tả:</strong>
          <p style="margin: 0;">{{ moTa }}</p>
        </div>

        <!-- Cụm nút thao tác -->
        <div class="product-card-actions">
          <!-- Nút bật/tắt mô tả -->
          <button 
            type="button" 
            class="btn btn-outline btn-sm" 
            @click="toggleMoTa"
            :title="hienThiMoTa ? 'Thu gọn phần mô tả' : 'Mở rộng xem chi tiết mô tả'"
          >
            <span v-if="hienThiMoTa">🔼 Ẩn mô tả</span>
            <span v-else>🔽 Xem mô tả</span>
          </button>

          <!-- 7. Khóa nút "Mua" khi sản phẩm hết hàng -->
          <button 
            type="button" 
            class="btn btn-primary btn-sm"
            :disabled="isOutOfStock"
            @click="handleBuy"
            :title="isOutOfStock ? 'Sản phẩm này hiện đang tạm hết hàng' : 'Chọn mua ngay sản phẩm này'"
          >
            <span v-if="isOutOfStock">🚫 Hết hàng</span>
            <span v-else>🛒 Mua ngay</span>
          </button>
        </div>
      </div>
    </div>
  `
};

// Đăng ký toàn cục để sử dụng trong script tag
window.TheSanPham = TheSanPham;
