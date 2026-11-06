/**
 * Component <dong-gio-hang>
 * Bài 3: Giỏ hàng với props và $emit
 * Sinh viên thực hiện: Bùi Quang Chiến - MSV: 23001837 - Lớp: K68A3
 * 
 * Yêu cầu tuân thủ:
 * 1. Nhận dữ liệu qua props: id, tên, đơn giá và số lượng.
 * 2. Hiển thị thành tiền và các nút tăng, giảm, xóa.
 * 3. Khai báo và phát sự kiện:
 *    - 'doi-so-luong': gửi (id, newQuantity)
 *    - 'yeu-cau-xoa': gửi (id)
 * 4. Luồng dữ liệu một chiều (One-Way Data Flow):
 *    Tuyệt đối KHÔNG gán lại props hoặc sửa thuộc tính của props.
 * 5. Giới hạn số lượng trong khoảng [1, 99].
 */

const DongGioHang = {
  name: 'DongGioHang',

  // 1 & 2. Khai báo props nhận từ component cha
  props: {
    id: {
      type: [Number, String],
      required: true
    },
    ten: {
      type: String,
      required: true
    },
    donGia: {
      type: Number,
      required: true,
      validator(val) {
        return val >= 0;
      }
    },
    soLuong: {
      type: Number,
      required: true,
      validator(val) {
        return Number.isInteger(val) && val >= 1 && val <= 99;
      }
    }
  },

  // 3. Khai báo các sự kiện tùy chỉnh (Custom Events)
  emits: ['doi-so-luong', 'yeu-cau-xoa'],

  computed: {
    // 2. Hiển thị thành tiền = đơn giá * số lượng
    thanhTien() {
      return this.donGia * this.soLuong;
    }
  },

  methods: {
    formatMoney(val) {
      if (typeof val !== 'number' || isNaN(val)) return '0 đ';
      return val.toLocaleString('vi-VN') + ' đ';
    },

    // Giảm số lượng: kiểm tra không dưới 1, phát sự kiện lên cha
    giamSoLuong() {
      if (this.soLuong > 1) {
        // 6. KHÔNG sửa trực tiếp prop, chỉ phát sự kiện
        this.$emit('doi-so-luong', this.id, this.soLuong - 1);
      }
    },

    // Tăng số lượng: kiểm tra không quá 99, phát sự kiện lên cha
    tangSoLuong() {
      if (this.soLuong < 99) {
        // 6. KHÔNG sửa trực tiếp prop, chỉ phát sự kiện
        this.$emit('doi-so-luong', this.id, this.soLuong + 1);
      }
    },

    // Nhập trực tiếp số lượng: ép kiểu nguyên và clamp trong [1, 99]
    nhapSoLuong(event) {
      const rawVal = event.target.value.trim();
      const parsed = parseInt(rawVal, 10);

      if (isNaN(parsed) || parsed < 1) {
        // Nếu nhập không hợp lệ, đặt lại giá trị hiển thị về prop hiện tại
        event.target.value = this.soLuong;
        this.$emit('doi-so-luong', this.id, 1);
      } else if (parsed > 99) {
        event.target.value = 99;
        this.$emit('doi-so-luong', this.id, 99);
      } else {
        this.$emit('doi-so-luong', this.id, parsed);
      }
    },

    // Yêu cầu xóa: phát sự kiện 'yeu-cau-xoa' kèm mã id sản phẩm
    yeuCauXoa() {
      this.$emit('yeu-cau-xoa', this.id);
    }
  },

  template: `
    <tr>
      <!-- Cột Mã & Tên sản phẩm -->
      <td>
        <div style="font-weight: 700; color: var(--gray-900); font-size: 0.95rem;">
          {{ ten }}
        </div>
        <div style="font-size: 0.75rem; color: var(--gray-500); margin-top: 2px;">
          Mã SP: #{{ id }}
        </div>
      </td>

      <!-- Cột Đơn giá -->
      <td style="color: var(--gray-700); font-weight: 600;">
        {{ formatMoney(donGia) }}
      </td>

      <!-- Cột Số lượng & Bộ điều khiển (+ / -) -->
      <td>
        <div class="quantity-control">
          <!-- Nút giảm: khóa khi số lượng <= 1 -->
          <button 
            type="button" 
            class="qty-btn" 
            @click="giamSoLuong"
            :disabled="soLuong <= 1"
            title="Giảm số lượng"
          >
            −
          </button>

          <!-- Input số lượng: [1, 99] -->
          <input 
            type="number" 
            class="qty-input" 
            :value="soLuong" 
            @change="nhapSoLuong($event)"
            min="1" 
            max="99" 
            step="1"
          />

          <!-- Nút tăng: khóa khi số lượng >= 99 -->
          <button 
            type="button" 
            class="qty-btn" 
            @click="tangSoLuong"
            :disabled="soLuong >= 99"
            title="Tăng số lượng"
          >
            +
          </button>
        </div>
      </td>

      <!-- Cột Thành tiền (Computed) -->
      <td style="font-weight: 800; color: var(--primary); font-size: 1.05rem;">
        {{ formatMoney(thanhTien) }}
      </td>

      <!-- Cột Thao tác Xóa -->
      <td style="text-align: center;">
        <button 
          type="button" 
          class="btn btn-outline-danger btn-sm" 
          @click="yeuCauXoa"
          title="Xóa mục này khỏi giỏ hàng"
        >
          🗑️ Xóa
        </button>
      </td>
    </tr>
  `
};

// Đăng ký toàn cục
window.DongGioHang = DongGioHang;
