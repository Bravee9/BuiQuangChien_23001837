/**
 * Component <dong-gio-hang>
 * Bai 3: Gio hang voi props va $emit
 * Sinh vien thuc hien: Bui Quang Chien - MSV: 23001837 - Lop: K68A3
 */

const DongGioHang = {
  name: 'DongGioHang',

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

  emits: ['doi-so-luong', 'yeu-cau-xoa'],

  computed: {
    thanhTien() {
      return this.donGia * this.soLuong;
    }
  },

  methods: {
    formatMoney(val) {
      if (typeof val !== 'number' || isNaN(val)) return '0 đ';
      return val.toLocaleString('vi-VN') + ' đ';
    },

    giamSoLuong() {
      if (this.soLuong > 1) {
        this.$emit('doi-so-luong', this.id, this.soLuong - 1);
      }
    },

    tangSoLuong() {
      if (this.soLuong < 99) {
        this.$emit('doi-so-luong', this.id, this.soLuong + 1);
      }
    },

    nhapSoLuong(event) {
      const rawVal = event.target.value.trim();
      const parsed = parseInt(rawVal, 10);

      if (isNaN(parsed) || parsed < 1) {
        event.target.value = this.soLuong;
        this.$emit('doi-so-luong', this.id, 1);
      } else if (parsed > 99) {
        event.target.value = 99;
        this.$emit('doi-so-luong', this.id, 99);
      } else {
        this.$emit('doi-so-luong', this.id, parsed);
      }
    },

    yeuCauXoa() {
      this.$emit('yeu-cau-xoa', this.id);
    }
  },

  template: `
    <tr>
      <td>
        <div class="cart-item-name">{{ ten }}</div>
        <div class="cart-item-id">Mã SP: #{{ id }}</div>
      </td>

      <td class="cart-item-price">
        {{ formatMoney(donGia) }}
      </td>

      <td>
        <div class="quantity-control">
          <button 
            type="button" 
            class="qty-btn" 
            @click="giamSoLuong"
            :disabled="soLuong <= 1"
            title="Giảm"
          >
            -
          </button>

          <input 
            type="number" 
            class="qty-input" 
            :value="soLuong" 
            @change="nhapSoLuong($event)"
            min="1" 
            max="99" 
            step="1"
          />

          <button 
            type="button" 
            class="qty-btn" 
            @click="tangSoLuong"
            :disabled="soLuong >= 99"
            title="Tăng"
          >
            +
          </button>
        </div>
      </td>

      <td class="cart-item-subtotal">
        {{ formatMoney(thanhTien) }}
      </td>

      <td class="text-center">
        <button 
          type="button" 
          class="btn btn-outline-danger btn-sm" 
          @click="yeuCauXoa"
          title="Xóa sản phẩm"
        >
          Xóa
        </button>
      </td>
    </tr>
  `
};

window.DongGioHang = DongGioHang;
