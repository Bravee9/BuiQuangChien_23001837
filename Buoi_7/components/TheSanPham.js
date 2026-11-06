/**
 * Component <the-san-pham>
 * Bai 2: Danh muc san pham bang component
 * Sinh vien thuc hien: Bui Quang Chien - MSV: 23001837 - Lop: K68A3
 */

const TheSanPham = {
  name: 'TheSanPham',
  props: {
    // Prop bat buoc: ten
    ten: {
      type: String,
      required: true
    },
    // Prop bat buoc: gia
    gia: {
      type: Number,
      required: true,
      validator(value) {
        return value >= 0;
      }
    },
    // Prop co gia tri mac dinh: anh (anh that mac dinh)
    anh: {
      type: String,
      default: 'assets/images/default-product.jpg'
    },
    // Prop co gia tri mac dinh: moTa
    moTa: {
      type: String,
      default: 'Thong tin mo ta chi tiet cua san pham dang duoc cap nhat.'
    },
    // Prop co gia tri mac dinh: soLuongTon
    soLuongTon: {
      type: Number,
      default: 0,
      validator(value) {
        return Number.isInteger(value) && value >= 0;
      }
    }
  },

  data() {
    return {
      // Trang thai mo/dong mo ta luu trong data() rieng cua tung component
      hienThiMoTa: false
    };
  },

  computed: {
    isOutOfStock() {
      return this.soLuongTon <= 0;
    }
  },

  methods: {
    toggleMoTa() {
      this.hienThiMoTa = !this.hienThiMoTa;
    },

    formatCurrency(value) {
      if (typeof value !== 'number' || isNaN(value)) return '0 đ';
      return value.toLocaleString('vi-VN') + ' đ';
    },

    handleBuy() {
      if (this.isOutOfStock) return;
      alert(`Đã thêm "${this.ten}" vào giỏ hàng (${this.formatCurrency(this.gia)})`);
    }
  },

  template: `
    <div class="product-card-item" :class="{ 'is-out-of-stock': isOutOfStock }">
      <div class="product-thumb-container">
        <img 
          :src="anh" 
          :alt="ten" 
          class="product-thumb-img"
          loading="lazy"
        />

        <div class="product-stock-tag">
          <span v-if="isOutOfStock" class="badge-stock badge-out-of-stock">
            Hết hàng
          </span>
          <span v-else class="badge-stock badge-in-stock">
            Còn {{ soLuongTon }}
          </span>
        </div>
      </div>

      <div class="product-details">
        <h3 class="product-name-title">{{ ten }}</h3>
        <div class="product-price-display">{{ formatCurrency(gia) }}</div>

        <div v-show="hienThiMoTa" class="product-desc-box">
          <div class="desc-title">Mô tả sản phẩm:</div>
          <p class="desc-content">{{ moTa }}</p>
        </div>

        <div class="product-card-actions">
          <button 
            type="button" 
            class="btn btn-outline btn-sm" 
            @click="toggleMoTa"
          >
            {{ hienThiMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
          </button>

          <button 
            type="button" 
            class="btn btn-primary btn-sm"
            :disabled="isOutOfStock"
            @click="handleBuy"
          >
            {{ isOutOfStock ? 'Tạm hết hàng' : 'Mua ngay' }}
          </button>
        </div>
      </div>
    </div>
  `
};

window.TheSanPham = TheSanPham;
