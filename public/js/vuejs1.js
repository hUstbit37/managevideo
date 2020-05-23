var varInstance = new Vue({
    el: '#app',
    data: {
        title: "Áo thun thời trang nam thời thượng nhiều màu",
        url: "https://lamishop.vn/sp/ao-thun-nam-adidas-thao-2-mau",
        target: '_blank',
        price: '200000',
        sale: 0.1,
        cartNumber: 0,
        selectedProduct: 0,
        listProductDetail: [
            { image: "../img/1.jpg", quantity: 8, textColor: 'Xanh đậm' },
            { image: "../img/2.jpg", quantity: 5, textColor: 'Đen trắng' },
            { image: "../img/3.jpg", quantity: 0, textColor: 'Xanh dương' },
        ],
        listDescription: [
            'Thoát mồ hôi tốt',
            'Áo thun cổ tròn thể thao Hiye chuyên được may từ chất liệu nilon thoáng mát',
            'Kết hợp thêm sợi thun tạo độ co giãn giúp người tiêu dùng thoải mái khi mặc',
            'Chất liệu: polyester và thun',
        ],
        testDescription: "<p>testDescription with v-html</p>",
    },
    methods: {
        handleClickColor(e, index) {
            this.selectedProduct = index;
        },
        classColorActive(index) {
            return {
                active: this.selectedProduct === index
            }
        },
        handleAddCart() {
            if (this.getSelectedProduct.quantity <= 0) {
                alert('Sản phẩm đã hết hàng');
            } else if (this.cartNumber + 1 > this.getSelectedProduct.quantity) {
                alert('Số lượng vượt quá hàng còn lại');
            } else {
                this.cartNumber += 1;
            }
        }
    },
    computed: {
        formatOriginalPrice() {
            var number = this.price;
            return (new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' }).format(number));
        },
        formatFinalPrice() {
            var number = this.price - this.sale * this.price;
            return (new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' }).format(number));
        },
        getSelectedProduct() {
            let index = this.selectedProduct;
            return this.listProductDetail[index];
        },
    }
});